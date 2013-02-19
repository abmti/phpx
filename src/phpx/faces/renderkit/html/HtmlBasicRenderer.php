<?php

namespace phpx\faces\renderkit\html;

use phpx\faces\component\UIInput;
use phpx\util\ArrayList;
use phpx\faces\component\UIComponent;
use phpx\faces\context\FacesContext;
use phpx\faces\render\Renderer;
use Exception;
use XMLWriter;

class HtmlBasicRenderer extends Renderer {
	
	
	public function encodeBegin(FacesContext $context, UIComponent $component) {
		if (null == $context || null == $component) {
		    throw new Exception("Nullpointer");
		}
	}
	
	public function encodeEnd(FacesContext $context, UIComponent $component) {
		if (null == $context || null == $component) {
		    throw new Exception("Nullpointer");
		}
	}
	
	public function encodeChildren(FacesContext $context, UIComponent $component) {
		if (null == $context || null == $component) {
		    throw new Exception("Nullpointer");
		}
	}
	
	public function decode(FacesContext $context, UIComponent $component) {
		if (null == $context || null == $component) {
		    throw new Exception("Nullpointer");
		}
	}
	
	public function getRendersChildren() {
		return true;
	}

	
	protected function getMessageIter(FacesContext $context,
                                      $forComponent,
                                      UIComponent $component) {

        $messageIter = null;
        // Attempt to use the "for" attribute to locate 
        // messages.  Three possible scenarios here:
        // 1. valid "for" attribute - messages returned
        //    for valid component identified by "for" expression.
        // 2. zero length "for" expression - global errors
        //    not associated with any component returned
        // 3. no "for" expression - all messages returned.
        if (isset($forComponent)) {
            if (strlen($forComponent) == 0) {
                $messageIter = $context->getMessagesById(null);
            } else {
                $result = $this->getForComponent($context, $forComponent, $component);
                if ($result == null) {
                    $messageIter = new ArrayList();
                } else {
                    $messageIter = $context->getMessages($result->getClientId($context));
                }
            }
        } else {
            $messageIter = $context->getMessages();
        }
        return $messageIter;
    }
	
	/**
     * Locates the component identified by <code>forComponent</code>
     *
     * @param context the FacesContext for the current request
     * @param forComponent - the component to search for
     * @param component    - the starting point in which to begin the search
     *
     * @return the component with the the <code>id</code that matches
     *         <code>forComponent</code> otheriwse null if no match is found.
     */
    protected function getForComponent(FacesContext $context,
                                          $forComponent,
                                          UIComponent $component) {

        if (null == $forComponent || strlen($forComponent) == 0) {
            return null;
        }

        $result = null;
        $currentParent = component;
        try {
            // Check the naming container of the current 
            // component for component identified by
            // 'forComponent'
            while ($currentParent != null) {
                // If the current component is a NamingContainer,
                // see if it contains what we're looking for.
                $result = $currentParent->findComponent($forComponent);
                if ($result != null) {
                    break;
                }
                // if not, start checking further up in the view
                $currentParent = $currentParent->getParent();
            }

            // no hit from above, scan for a NamingContainer
            // that contains the component we're looking for from the root.    
            if ($result == null) {
                $result = $this->findUIComponentBelow($context->getViewRoot(), $forComponent);
            }
        } catch (Exception $e) {
            // ignore - log the warning
        }
        // log a message if we were unable to find the specified
        // component (probably a misconfigured 'for' attribute
        if ($result == null) {
            //if (logger.isLoggable(Level.WARNING)) {
            //    logger.warning(MessageUtils.getExceptionMessageString(
            //          MessageUtils.COMPONENT_NOT_FOUND_IN_VIEW_WARNING_ID,
            //          forComponent));
            //}
        }
        return $result;

    }
    
    public function getFormattedValue(FacesContext $context, UIComponent $component) {
    	$value = $this->getCurrentValue($context, $component);
    	if($component->getConverter() != null) {
    		$converter = $context->getApplication()->createConverter($component->getConverter());
    		$value = $converter->getAsString($context, $component, $value);
    	}
    	return $value;
    }
    
	/**
     * @param context the FacesContext for the current request
     * @param component the UIComponent whose value we're interested in
     *
     * @return the value to be rendered and formats it if required. Sets to
     *  empty string if value is null.
     */
    protected function getCurrentValue(FacesContext $context, UIComponent $component) {
        if ($component instanceof UIInput) {
        	$id = $component->getClientId($context);
			if(isset($_POST[$id])){
				$component->setSubmittedValue($_POST[$id]);
				return $component->getSubmittedValue();
			}
        }
        return $component->getValue();
    }

    protected function writeAttributes(UIComponent $component, XMLWriter $writer, $attributes){
    	$component->writeAttributes($writer, $attributes);
    }

    
	public static function encodeRecursive(FacesContext $context, UIComponent $viewToRender) {
		if( $viewToRender->isRendered() ) {
			$viewToRender->encodeBegin( $context );
			if( $viewToRender->getRendersChildren() ) {
				$viewToRender->encodeChildren( $context );
			} else {
				$children = $viewToRender->getChildren();
				foreach( $children as $child ) {
					self::encodeRecursive( $context, $child );
				}
			}
			$viewToRender->encodeEnd( $context );
		}
	}
    
}

?>
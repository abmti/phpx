<?php

namespace phpx\faces\application;

use Exception;

class FacesMessage {


    // --------------------------------------------------------------- Constants

    /**
     * <p><code>ResourceBundle</code> identifier for messages whose
     * message identifiers are defined in the JavaServer Faces
     * specification.</p>
     */
    public static $FACES_MESSAGES = "php.faces.Messages";


    // ------------------------------------------------- Message Severity Levels


    // Any new Severity values must go at the end of the list, or we will break
    // backwards compatibility on serialized instances


    private static $SEVERITY_INFO_NAME = "INFO";
    /**
     * <p>Message severity level indicating an informational message
     * rather than an error.</p>
     */
    public static function getSeverityInfo() { 
    	return new Severity(self::SEVERITY_INFO_NAME, 1); 
   	}


    private static $SEVERITY_WARN_NAME = "WARN";
    /**
     * <p>Message severity level indicating that an error might have
     * occurred.</p>
     */
    public static function getSeverityWarn() {
    	return new Severity(self::SEVERITY_WARN_NAME, 2);
    }


    private static $SEVERITY_ERROR_NAME = "ERROR";
    /**
     * <p>Message severity level indicating that an error has
     * occurred.</p>
     */
    public static function getSeverityError() {
    	return new Severity(self::SEVERITY_ERROR_NAME, 3);
	}

    private static $SEVERITY_FATAL_NAME = "FATAL";
    
    /**
     * <p>Message severity level indicating that a serious error has
     * occurred.</p>
     */
    public static function getSeverityFatal() {
    	return new Severity(self::SEVERITY_FATAL_NAME, 4);
    }

    /**
     * <p>Array of all defined values, ascending order of ordinal value.
     *  Be sure you include any new instances created above, in the
     * same order.</p>
     */
    //private static Severity[] values = { SEVERITY_INFO, SEVERITY_WARN, SEVERITY_ERROR, SEVERITY_FATAL };
    

    /**
     * <p>Immutable <code>List</code> of valid {@link php.faces.application.FacesMessage.Severity}
     * instances, in ascending order of their ordinal value.</p>
     */
    //public static final List VALUES = Collections.unmodifiableList(Arrays.asList(values));

    //private static Map<String,Severity> _MODIFIABLE_MAP = new HashMap<String,Severity>(4, 1.0f);
    
    //static {
	//for (int i = 0, len = values.length; i < len; i++) {
	//    _MODIFIABLE_MAP.put(values[i].severityName, values[i]);
	//}
    //}
    

    /**
     * <p>Immutable <code>Map</code> of valid {@link php.faces.application.FacesMessage.Severity}
     * instances, keyed by name.</p>
     */
    //public final static Map VALUES_MAP = Collections.unmodifiableMap(_MODIFIABLE_MAP);
    
    //private static long serialVersionUID = -1180773928220076822L;
    

    // ------------------------------------------------------------ Constructors


    /**
     * <p>Construct a new <code>FacesMessage</code> with the specified
     * initial values.</p>
     *
     * @param severity the severity
     * @param summary Localized summary message text
     * @param detail Localized detail message text
     *
     * @throws IllegalArgumentException if the specified severity level
     *  is not one of the supported values
     */
    public function __construct(Severity $severity, $summary, $detail) {
        $this->setSeverity($severity);
        $this->setSummary($summary);
        $this->setDetail($detail);
    }


    // ------------------------------------------------------ Instance Variables


    private $severity = null;
    private $summary = null;
    private $detail = null;


    // ---------------------------------------------------------- Public Methods


    /**
     * <p>Return the localized detail text.  If no localized detail text has
     * been defined for this message, return the localized summary text
     * instead.</p>
     */
    public function getDetail() {
		if ($this->detail == null) {
		    return ($this->summary);
		} else {
		    return ($this->detail);
		}
    }


    /**
     * <p>Set the localized detail text.</p>
     *
     * @param detail The new localized detail text
     */
    public function setDetail($detail) {
        $this->detail = $detail;
    }


    /**
     * <p>Return the severity level.</p>
     */
    public function getSeverity() {
        return ($this->severity);
    }


    /**
     * <p>Set the severity level.</p>
     *
     * @param severity The new severity level
     *
     * @throws IllegalArgumentException if the specified severity level
     *  is not one of the supported values
     */
    public function setSeverity(Severity $severity) {
        if (($severity->getOrdinal() < self::getSeverityInfo()->getOrdinal()) 
	    		|| ($severity->getOrdinal() > self::getSeverityFatal()->getOrdinal())) {
            throw new Exception("IllegalArgumentException");
        }
        $this->severity = $severity;
    }

    /**
     * <p>Return the localized summary text.</p>
     */
    public function getSummary() {
        return ($this->summary);
    }


    /**
     * <p>Set the localized summary text.</p>
     *
     * @param summary The new localized summary text
     */
    public function setSummary($summary) {
        $this->summary = $summary;
    }

    
    /**
     * <p>Persist {@link php.faces.application.FacesMessage} artifacts,
     * including the non serializable <code>Severity</code>.</p>
     */
    /*
    private void writeObject(ObjectOutputStream out) throws IOException {
        out.writeInt(getSeverity().getOrdinal());
        out.writeObject(getSummary());
        out.writeObject(getDetail());
    }
	*/
    
    /**
     * <p>Reconstruct {@link php.faces.application.FacesMessage} from
     * serialized artifacts.</p>
     */
    /*
    private void readObject(ObjectInputStream in)
        throws IOException, ClassNotFoundException {
        severity = SEVERITY_INFO;
        summary = null;
        detail = null;
        int ordinal = in.readInt();
        if (ordinal == SEVERITY_INFO.getOrdinal()) {
            setSeverity(FacesMessage.SEVERITY_INFO);
        } else if (ordinal == SEVERITY_WARN.getOrdinal()) {
            setSeverity(FacesMessage.SEVERITY_WARN);
        } else if (ordinal == SEVERITY_ERROR.getOrdinal()) {
            setSeverity(FacesMessage.SEVERITY_ERROR);
        } else if (ordinal == SEVERITY_FATAL.getOrdinal()) {
            setSeverity(FacesMessage.SEVERITY_FATAL);
        }
        setSummary((String)in.readObject());
        setDetail((String)in.readObject());
    }
    */

}


?>
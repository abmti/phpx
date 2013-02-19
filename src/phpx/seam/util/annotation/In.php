<?php
namespace phpx\seam\util\annotation;

use Doctrine\ORM\Mapping\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class In implements Annotation {
	
	/** @var string */
	public $targetClass;
	
}

?>
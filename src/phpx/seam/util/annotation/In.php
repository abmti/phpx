<?php
namespace phpx\seam\util\annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class In {
	
	/** @var string */
	public $targetClass;
	
}

?>
<?php
namespace phpx\inject;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class Inject {
	
	/** @var string */
	public $targetClass;
	
}

?>
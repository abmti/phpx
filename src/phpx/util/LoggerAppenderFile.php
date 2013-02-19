<?php
namespace phpx\util;

class LoggerAppenderFile extends \LoggerAppenderDailyFile {

	/**
	 * Performs threshold checks and invokes filters before delegating logging
	 * to the subclass' specific <i>append()</i> method.
	 * @see LoggerAppender::append()
	 * @param LoggerLoggingEvent $event
	 */
	public function doAppend(\LoggerLoggingEvent $event) {
		if($this->closed || !$this->fp) {
			$this->activateOptions();
		}
		parent::doAppend($event);
	}
	
}

?>
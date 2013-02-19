<?php

namespace phpx\util;

use DateTime;
use DateTimeZone;

class DataTimeUtil {

	public static function getDateTime() {
		return new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
	}

	public static function convertStringToDate($strDate){
		if($strDate != null) {
			return DateTime::createFromFormat('d/m/Y', $strDate, new DateTimeZone('America/Sao_Paulo'));
		}
		return null;
	}
	
	public static function convertStringToDateTime($strDate){
		if($strDate != null) {
			return DateTime::createFromFormat('d/m/Y H:i:s', $strDate, new DateTimeZone('America/Sao_Paulo'));
		}
		return null;
	}
	
	public static function convertDateToStringDateTime($data){
		if($data != null) {	
			return $data->format('d/m/Y H:i:s');
		}
		return null;	
	}
	
	public static function convertDateToString($data){
		if($data != null) {	
			return $data->format('d/m/Y');
		}
		return null;	
	}
	
	
}

?>
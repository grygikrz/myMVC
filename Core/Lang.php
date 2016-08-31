<?php

namespace Core;


/**
 * language class
 * 
 */

class Lang{
	
	protected static $data;
	
	public static function load ($lang_code) {
		
		$lang_file_path = dirname(__DIR__).'\App\lang\\'.strtolower($lang_code).'.php';

		if(file_exists($lang_file_path)) {
			self::$data = include($lang_file_path);
		}else{

			throw new Exception('Lang file not found: '.$lang_file_path);
		}
		
	}
/**
 * get language function
 * 
 */
	
	public static function get($key, $default_value=''){
		return isset(self::$data[strtolower($key)]) ? self::$data[strtolower($key)] : $default_value;
	}
	
}

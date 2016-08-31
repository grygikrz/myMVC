<?php

namespace Core;

/**
 * Application configuration
 *
 * PHP version 5.4
 */
class Config
{
	protected  static $setSettings = [];
    /**
     * Database host
     * @var string
     */
     public static function set($name, $var){
     	self::$setSettings[$name] = $var;
     }
	 
	 public static function get($name) {
	 	
	 	return self::$setSettings[$name];
		
	 }
    
}

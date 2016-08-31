<?php

//settings

namespace App;

use \Core\Config;

class Settings
{	
	public function __construct(){
		
		Config::set('SHOW_ERRORS', false);
		Config::set('LANGUAGES', array('en','pl'));
		Config::set('DEFAULT_LANGUAGE','en');
		
		//Db config
		config::set ('DB_HOST','localhost');
		config::set ('DB_USER','root');
		config::set ('DB_PASSWORD','');
		config::set ('DB_NAME','mvc');
		
		config::set('salt', 'asdfrRQ@#!$%REfdf');
		}
}

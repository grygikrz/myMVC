<?php

namespace Core;

use PDO;
use App\Config;

/**
 * Base model
 *
 * PHP version 5.4
 */
abstract class Model
{

    /**
     * Get the PDO database connection
     *
     * @return mixed
     */
    protected static function getDB()
    {
        static $db = null;  //static var here give us aportunity to connect db only once on demand

        if ($db === null) {
            $dsn = 'mysql:host=' . Config::get('DB_HOST'). ';dbname=' . Config::get('DB_NAME'). ';charset=utf8';
            $db = new PDO($dsn, Config::get('DB_USER'), Config::get('DB_PASSWORD'));

            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }
	
	
	
	
	 public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    	{
        $sth = self::getDB()->prepare($sql); //or static:getDB()
        foreach ($array as $key => $value) {
            $sth->bindValue("$key", $value);
        }
        
	        $sth->execute();
	        return $sth->fetchAll($fetchMode);
	    }
		
		
		
		
		   public function insert($table, $data)
		    {
		        ksort($data);
		        
		        $fieldNames = implode('`, `', array_keys($data));
		        $fieldValues = ':' . implode(', :', array_keys($data));
		        
		        $sth = self::getDB()->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");
		        
		        foreach ($data as $key => $value) {
		            $sth->bindValue(":$key", $value);
		        }
		        
		        $sth->execute();
		    }




			  public function update($table, $data, $where)
			    {
			        ksort($data);
			        
			        $fieldDetails = NULL;
			        foreach($data as $key=> $value) {
			            $fieldDetails .= "`$key`=:$key,";
			        }
			        $fieldDetails = rtrim($fieldDetails, ',');
			        
			        $sth = self::getDB()->prepare("UPDATE $table SET $fieldDetails WHERE $where");
			        
			        foreach ($data as $key => $value) {
			            $sth->bindValue(":$key", $value);
			        }
			        
			        $sth->execute();
			    }
				
				
				
			    public function delete($table, $where, $limit = 1)
			    {
			        return self::getDB()->exec("DELETE FROM $table WHERE $where LIMIT $limit");
			    }
}

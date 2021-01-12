<?php

namespace Core;

use PDO;
use mysqli;
use App\Config;

/**
 * Base model
 *
 * PHP version 7.0
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
        mysqli_report(MYSQLI_REPORT_STRICT);
		
		static $db = null;

        if ($db === null) {
            
            $db =  new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD, Config::DB_NAME );
			
			// Throw an Exception when an error occurs
			if ($db->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
            
        }

        return $db;
    }
}

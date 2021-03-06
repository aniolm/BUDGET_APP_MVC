<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'm1039_budgetapp';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'budgetapp';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'budgetapp#10';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;
	
	/**
     * Secret key for hashing
     * @var string
     */
    const SECRET_KEY = 'your-secret-key';
}

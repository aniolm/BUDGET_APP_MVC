<?php

namespace App\Models;

use mysqli;
use \App\Token;
use \App\Models\User;

/**
 * Remembered login model
 *
 * PHP version 7.0
 */
class RememberedLogin extends \Core\Model
{

    /**
     * Find a remembered login model by the token
     *
     * @param string $token The remembered login token
     *
     * @return mixed Remembered login object if found, false otherwise
     */
    public static function findByToken($token)
    {
        $token = new Token($token);
        $token_hash = $token->getHash();
		
		$connection = static::getDB();
		
		$result = $connection->query("SELECT * FROM remembered_logins WHERE token_hash = '$token_hash'");
		
		if (($result->num_rows) > 0)
		{
			return $result-> fetch_object('App\Models\RememberedLogin');
		}
		else
		{
			return false;
		}	
		
    }

    /**
     * Get the user model associated with this remembered login
     *
     * @return User The user model
     */
    public function getUser()
    {
        return User::findByID($this->user_id);
    }

    /**
     * See if the remember token has expired or not, based on the current system time
     *
     * @return boolean True if the token has expired, false otherwise
     */
    public function hasExpired()
    {
        return strtotime($this->expires_at) < time();
    }

    /**
     * Delete this model
     *
     * @return void
     */
    public function delete()
    {
        $connection = static::getDB();
		$connection->query("DELETE FROM remembered_logins WHERE token_hash = '$this->token_hash'");
    }
}

<?php

namespace App\Models;

use PDO;
use mysqli;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{
	
	public function __construct($data)
	{
		foreach ($data as $key => $value)
		{
			$this->$key = $value;
		};		
	}
	
	/**
     * Save user data in the database
     *
     */
	
	public function save()
    {
		
		$user = $this->uname;
		$email = $this->email;
		$psw_hash = password_hash($this->psw, PASSWORD_DEFAULT);
		
		
		try 
		{
			$connection = static::getDB();
			
			if ($this->validate())
			{	
				if ($connection->query("INSERT INTO users VALUES (NULL, '$user', '$psw_hash','$email' )"))
				{
					$result = $connection->query("SELECT id FROM users WHERE username='$user' AND email='$email'");
					$row = mysqli_fetch_array($result);
					$id_user = $row["id"];
					$connection->query("INSERT INTO incomes_category_assigned_to_users (id , name ) SELECT id, name FROM incomes_category_default");
					$connection->query("UPDATE incomes_category_assigned_to_users SET user_id = $id_user WHERE user_id = 0");
					return true;
				}
				else
				{
					throw new Exception($connection->error);
				}
					
			}
				
			$connection->close();
			
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Server error! Please try again later!</span>';
			echo '<br />Developer information: '.$e;
			
		}
			
		return false;
	}
	
	/**
     * Validate user data passed from the form
     *
     * @return array
     */
	 
	public function validate()
	{
		$validation_OK = true;
		
		$user = $this->uname;
		
		if ((strlen($user)<3) || (strlen($user)>20))
		{
			$validation_OK=false;
			//$_SESSION['e_uname']="Username must be from 3 to 20 characters long!";
		}
		
		if (ctype_alnum($user)==false)
		{
			$validation_OK=false;
			//$_SESSION['e_uname']="Username must consist of letters and numbers (without polish characters)";
		}
		
		$email = $this->email;
		$email_filtered = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($email_filtered, FILTER_VALIDATE_EMAIL)==false) || ($email_filtered!=$email))
		{
			$validation_OK=false;
			//$_SESSION['e_email']="Enter valid e-mail address!";
		}
		

		$psw1 = $this->psw;
		$psw2 = $this->psw2;
		
		if ((strlen($psw1)<6) || (strlen($psw1)>20))
		{
			$validation_OK=false;
			//$_SESSION['e_psw']="Password must be 6 to 20 characters long!";
		}
		
		if ($psw1!=$psw2)
		{
			$validation_OK=false;
			//$_SESSION['e_psw']="Passwords are not matching!";
		}	
		
		$result = static::findByEmail($email);
		if($result->num_rows>0)
		{
			$validation_OK=false;
			//$_SESSION['e_email']="Email already exists in database!";
		}		
				
		$result = static::findByUsername($user);		
		if($result->num_rows>0)
		{
			$validation_OK=false;
			//$_SESSION['e_uname']="Username already exists in the database!";
		}
		
		return $validation_OK;
	}	
	
	/**
     * See if a user record already exists with the specified email
     *
     * @param string $email email address to search for
     * @param string $ignore_id Return false anyway if the record found has this ID
     *
     * @return boolean  True if a record already exists with the specified email, false otherwise
     */
    public static function emailExists($email, $ignore_id = null)
    {
        $user = static::findByEmail($email);

        if ($user) {
            if ($user->id != $ignore_id) {
                return true;
            }
        }

        return false;
    }
	
	/**
     * Find a user model by email address
     *
     * @param string $email email address to search for
     *
     * @return mixed User object if found, false otherwise
     */
    public static function findByEmail($email)
    {
        $connection = static::getDB();
		
		$result = $connection->query("SELECT id FROM users WHERE email='$email'");
				
				if (!$result) throw new Exception($connection->error);
					
		//$connection->close();
        return $result;
    }
	
		/**
     * Find a user model by username
     *
     * @param string $user to search for
     *
     * @return mixed User object if found, false otherwise
     */
    public static function findByUsername($user)
    {
        $connection = static::getDB();
		
		$result = $connection->query("SELECT id FROM users WHERE username='$user'");
				
				if (!$result) throw new Exception($connection->error);  
					
		//$connection->close();	
        return $result;
    }
	
	/**
     * Get all the users as an associative array
     *
     * @return array
     */
    
	public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT id, name FROM users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

<?php

namespace App\Models;

use mysqli;
use App\Token;
use App\Models\User;

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
					$connection->query("INSERT INTO incomes_category_assigned_to_users (id,user_id,name,planned,color) 
										SELECT id, '$id_user' AS user_id, name, planned, color 
										FROM incomes_category_default;");
					$connection->query("INSERT INTO expenses_category_assigned_to_users (id,user_id,name,planned,color) 
										SELECT id, '$id_user' AS user_id, name, planned, color 
										FROM expenses_category_default;");
					$connection->query("INSERT INTO payment_methods_assigned_to_users (id,user_id,name) 
										SELECT id, '$id_user' AS user_id, name 
										FROM payment_methods_default;");
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
			$_SESSION['e_uname']="Username must be from 3 to 20 characters long!";
		}
		
		if (ctype_alnum($user)==false)
		{
			$validation_OK=false;
			$_SESSION['e_uname']="Username must consist of letters and numbers (without polish characters)";
		}
		
		$email = $this->email;
		$email_filtered = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($email_filtered, FILTER_VALIDATE_EMAIL)==false) || ($email_filtered!=$email))
		{
			$validation_OK=false;
			$_SESSION['e_email']="Enter valid e-mail address!";
		}
		else
		{
			unset($_SESSION['e_email']);
		}

		$psw1 = $this->psw;
		$psw2 = $this->psw2;
		
		if ((strlen($psw1)<6) || (strlen($psw1)>20))
		{
			$validation_OK=false;
			$_SESSION['e_psw']="Password must be 6 to 20 characters long!";
		}
		else
		{
			unset($_SESSION['e_psw']);
		}
		
		if ($psw1!=$psw2)
		{
			$validation_OK=false;
			$_SESSION['e_psw']="Passwords are not matching!";
		}
		else
		{
			unset($_SESSION['e_psw']);
		}		
		
		$result = static::findByEmail($email);
		if($result->num_rows>0)
		{
			$validation_OK=false;
			$_SESSION['e_email']="Email already exists in database!";
		}
		else
		{
			unset($_SESSION['e_email']);
		}
				
		$result = static::findByUsername($user);		
		if($result->num_rows>0)
		{
			$validation_OK=false;
			$_SESSION['e_uname']="Username already exists in the database!";
		}
		else
		{
			unset($_SESSION['e_uname']);
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
		
		$result = $connection->query("SELECT * FROM users WHERE email='$email'");
				
				if (!$result) throw new Exception($connection->error);
				
		$data = $result-> fetch_assoc();
		$user = new User($data);
					;
        return $result;
    }
	
		/**
     * Find a user model by username
     *
     * @param string $user to search for
     *
     * @return mixed User object if found, false otherwise
     */
    public static function findByUsername($username)
    {
        $connection = static::getDB();
		
		$result = $connection->query("SELECT * FROM users WHERE username='$username'");
				
				if (!$result) throw new Exception($connection->error); 
		
		$data = $result-> fetch_assoc();
		$user = new User($data);
					
        return $user;
    }
	
	/**
     * Find a user model by id
     *
     * @param string $user to search for
     *
     * @return mixed User object if found, false otherwise
     */
    public static function findById($id)
    {
        $connection = static::getDB();
		
		$result = $connection->query("SELECT * FROM users WHERE id='$id'");
				
				if (!$result) throw new Exception($connection->error);  
		
		$data = $result-> fetch_assoc();
		$user = new User($data);
					
        return $user;
    }
	
	
	/**
     //* Authenticate a user by username and password.
     * Authenticate a user by username and password. User account has to be active.
     *
     * @param string $email email address
     * @param string $password password
     *
     * @return mixed  The user object or false if authentication fails
	 
     */
    public static function authenticate($username, $password)
    {
        $user = static::findByUsername($username);		
        if ($user) {
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }

        return false;
    }
	
	/**
     * Remember the login by inserting a new unique token into the remembered_logins table
     * for this user record
     *
     * @return boolean  True if the login was remembered successfully, false otherwise
     */
    public function rememberLogin()
    {
        $token = new Token();
        $hashed_token = $token->getHash();
        $this->remember_token = $token->getValue();
		$id = $this->id;
		
        $this->expiry_timestamp = time() + 60 * 60 * 24 * 7;  // 7 days from now
		$expiry_date = date('Y-m-d H:i:s', $this->expiry_timestamp);
	try 
		{
			$connection = static::getDB();
			$connection->query("INSERT INTO remembered_logins (token_hash, user_id, expires_at)
                            VALUES ('$hashed_token', $id , '$expiry_date')");
			return true;
		}
		

    catch(Exception $e)
		{
			echo '<span style="color:red;">Server error! Please try again later!</span>';
			echo '<br />Developer information: '.$e;
			
		}
			
		return false;
    }
	
}

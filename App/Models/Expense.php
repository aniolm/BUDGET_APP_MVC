<?php

namespace App\Models;

use PDO;
use mysqli;

/**
 * Income model
 *
 * PHP version 7.0
 */
class Expense extends \Core\Model
{
	
	public function __construct($data)
	{
		foreach ($data as $key => $value)
		{
			$this->$key = $value;
		};		
	}
	
	/**
     * Save expense data in the database
     *
     */
	
	public function save()
    {
		
		
		$date = date('Y-m-d', strtotime($this->date));
		$id_category = intval($this->category);
		$id_payment = intval($this->pmethod);
		$amount = floatval($this->amount);
		$description = $this->description;
		$id_user = $_SESSION['id'];
		
		
		try 
		{
			$connection = static::getDB();
			
			if ($this->validate())
			{	
				if ($connection->query("INSERT INTO expenses VALUES (NULL, $id_user, $id_category, $id_payment, $amount, '$date', '$description')"))
				{
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
     * Validate income data passed from the form
     *
     * @return bool
     */
	 
	public function validate()
	{
		$validation_OK = true;
		
		$description = $this->description;
		
		if (strlen($description)>100)
		{
			$validation_OK=false;
			$_SESSION['e_inc_desc']="Description must be shorter than 100 characters!";
		}
		
			
		$description_filtered = filter_var($description, FILTER_SANITIZE_STRING);
		
		if ($description_filtered!=$description)
		{
			$validation_OK=false;
			$_SESSION['e_inc_desc']="Description can not contain tags or special characters";
		}
		
		return $validation_OK;
	}	
	

}

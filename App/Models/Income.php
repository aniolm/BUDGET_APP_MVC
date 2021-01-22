<?php

namespace App\Models;

use PDO;
use mysqli;

/**
 * Income model
 *
 * PHP version 7.0
 */
class Income extends \Core\Model
{
	
	public function __construct($data)
	{
		foreach ($data as $key => $value)
		{
			$this->$key = $value;
		};		
	}
	
	/**
     * Save income data in the database
     *
     */
	
	public function save()
    {
		
		
		$date = date('Y-m-d', strtotime($this->date));
		$id_category = intval($this->category);
		$amount = floatval($this->amount);
		$description = $this->description;
		$id_user = $_SESSION['id'];
		
		
		try 
		{
			$connection = static::getDB();
			
			if ($this->validate())
			{	
				if ($connection->query("INSERT INTO incomes VALUES (NULL, $id_user, $id_category, $amount, '$date', '$description')"))
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
	
	/**
     * Get incomes based on given dates
     *
     * @return array with data
     */
	 
	public static function get($start_date, $end_date)
	{
		try 
		{
			$connection = static::getDB();
			$incomes = $connection->query("SELECT * FROM incomes WHERE date_of_income BETWEEN '$start_date' AND '$end_date'");
			
			if ($incomes->num_rows > 0)
				{	
				
					return $incomes;
				}
			else
				{
					throw new Exception($connection->error);
				}
					
			
				
			$connection->close();
			
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Server error! Please try again later!</span>';
			echo '<br />Developer information: '.$e;
			
		}
	}

}
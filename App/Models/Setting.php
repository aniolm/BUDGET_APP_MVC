<?php

namespace App\Models;

use PDO;
use mysqli;

/**
 * Settings model
 *
 * PHP version 7.0
 */
class Setting extends \Core\Model
{
	
	public function __construct($data)
	{
		foreach ($data as $key => $value)
		{
			$this->$key = $value;
		};		
	}
	
	/**
     * Save new category in the database
     *
     */
	
	public function save()
    {
				
		$id_category = intval($this->category);
		$name = $this->name;
		$planned = floatval($this->planned);
		$name = $this->color;
		$id_user = $_SESSION['user_id'];
		
		
		try 
		{
			$connection = static::getDB();
			
			if ($this->validate())
			{	
				if ($connection->query("INSERT INTO incomes_category_assigned_to_users VALUES ($id, $id_user, '$name', $planned, '$color')"))
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
     * Save new category in the database
     *
     */
	 
	public function edit($id, $type)
    {
	$id_user = $_SESSION['user_id'];
	$id = intval($id);
	$name = $this->name;
	$planned = floatval($this->planned);
	$color= $this->color;
	if($type === true)
	{
		$table = "incomes";
	}
	else
	{
		$table = "expenses";
	}
	try 
		{
			$connection = static::getDB();
			
			if ($this->validate())
			{	
				if ($connection->query("UPDATE ".$table."_category_assigned_to_users 
										SET name = '$name', planned = $planned, color = '$color'
										WHERE ".$table."_category_assigned_to_users.user_id = $id_user AND ".$table."_category_assigned_to_users.id = $id"))
				{
					return true;
					$connection->close();
				}
				else
				{
					throw new Exception($connection->error);
				}
					
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Server error! Please try again later!</span>';
			echo '<br />Developer information: '.$e;
			
		}
			
		return false;
	
	}
	
	
	/**
     * Validate setting data passed from the form
     *
     * @return bool
     */
	 
	public function validate()
	{
		$validation_OK = true;
		
		$name = $this->name;
		
		if (strlen($name)>50)
		{
			$validation_OK=false;
			$_SESSION['e_inc_name']="Name must be shorter than 50 characters!";
		}
		
			
		$name_filtered = filter_var($name, FILTER_SANITIZE_STRING);
		
		if ($name_filtered!=$name)
		{
			$validation_OK=false;
			$_SESSION['e_inc_name']="Name can not contain tags or special characters";
		}
		
		return $validation_OK;
	}	
	
	/**
     * Get information about categories assigned to user
     *
     * @return array with data
     */
	 
	public static function get_income_categories()
	{
		try 
		{
			$connection = static::getDB();
		    $user_id = $_SESSION['user_id'];			
			$income_categories = $connection->query("SELECT * 
													FROM incomes_category_assigned_to_users										   
													WHERE incomes_category_assigned_to_users.user_id = $user_id
													ORDER BY incomes_category_assigned_to_users.id");
			if ($income_categories->num_rows > 0)
				{	
				
					return $income_categories;
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
	
	/**
     * Get information about expense categories assigned to user
     *
     * @return array with data
     */
	 
	public static function get_expense_categories()
	{
		try 
		{
			$connection = static::getDB();
		    $user_id = $_SESSION['user_id'];			
			$expense_categories = $connection->query("SELECT * 
													FROM expenses_category_assigned_to_users										   
													WHERE expenses_category_assigned_to_users.user_id = $user_id
													ORDER BY expenses_category_assigned_to_users.id");
			if ($expense_categories->num_rows > 0)
				{	
				
					return $expense_categories;
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

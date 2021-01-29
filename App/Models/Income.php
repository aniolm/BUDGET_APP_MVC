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
		    $user_id = $_SESSION['id'];			
			$incomes = $connection->query("SELECT incomes.id,  incomes_category_assigned_to_users.name, incomes.income_comment, incomes.amount, incomes.date_of_income
			                               FROM incomes
										   INNER JOIN incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id
										   WHERE incomes.date_of_income BETWEEN '$start_date' AND '$end_date' AND incomes.user_id = $user_id
										   ORDER BY incomes.date_of_income");
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
	
	/**
     * Get summed income categories based on given dates
     *
     * @return query result object
     */
	 
	public static function sum_by_category($start_date, $end_date)
	{
		try 
		{
			$connection = static::getDB();
		    $user_id = $_SESSION['id'];			
			$categories_summed = $connection->query("SELECT incomes_category_assigned_to_users.name, sum(incomes.amount) as earned  
			                               FROM incomes
										   INNER JOIN incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id
										   WHERE incomes.date_of_income BETWEEN '$start_date' AND '$end_date' AND incomes.user_id = $user_id
										   GROUP BY income_category_assigned_to_user_id");
				
				
			//while ($row = $result -> fetch_assoc()) {
            //$categories_summed[] = $row;
            //}
			
			return $categories_summed;
				
			$connection->close();
			
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Server error! Please try again later!</span>';
			echo '<br />Developer information: '.$e;
			
		}
	}
	
	/**
     * Get income sum based on given dates
     *
     * @return sum as string 
     */
	 
	public static function sum_all($start_date, $end_date)
	{
		try 
		{
			$connection = static::getDB();
		    $user_id = $_SESSION['id'];			
			$incomes_summed = $connection->query("SELECT sum(incomes.amount) as sum
			                               FROM incomes
										   WHERE incomes.date_of_income BETWEEN '$start_date' AND '$end_date' AND incomes.user_id = $user_id");
				
				
			$sum= $incomes_summed -> fetch_assoc(); 
			$sum= $sum['sum']; 
			return $sum;
				
			$connection->close();
			
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Server error! Please try again later!</span>';
			echo '<br />Developer information: '.$e;
			
		}
	}
	

}

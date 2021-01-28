<?php

namespace App\Models;

use PDO;
use mysqli;

/**
 * expense model
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
     * Validate expense data passed from the form
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
     * Get expenses based on given dates
     *
     * @return array with data
     */
	 
	public static function get($start_date, $end_date)
	{
		try 
		{
			$connection = static::getDB();
		    $user_id = $_SESSION['id'];			
			$expenses = $connection->query("SELECT expenses.id,  expenses_category_assigned_to_users.name, expenses.expense_comment, expenses.amount, expenses.date_of_expense
			                               FROM expenses
										   INNER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id
										   WHERE expenses.date_of_expense BETWEEN '$start_date' AND '$end_date' AND expenses.user_id = $user_id");
			
			return $expenses;

			$connection->close();
			
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Server error! Please try again later!</span>';
			echo '<br />Developer information: '.$e;
			
		}
	}
	
	public static function sum_by_category($start_date, $end_date)
	{
		try 
		{
			$connection = static::getDB();
		    $user_id = $_SESSION['id'];			
			$expenses_summed = $connection->query("SELECT expenses_category_assigned_to_users.name, sum(expenses.amount) as spent 
			                               FROM expenses
										   INNER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id
										   WHERE expenses.date_of_expense BETWEEN '$start_date' AND '$end_date' AND expenses.user_id = $user_id
										   GROUP BY expense_category_assigned_to_user_id");
				
				
			//while ($row = $result -> fetch_assoc()) {
            //$results[] = $row;
            //}
			
			return $expenses_summed;
				
			$connection->close();
			
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Server error! Please try again later!</span>';
			echo '<br />Developer information: '.$e;
			
		}
	}
}

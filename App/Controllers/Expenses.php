<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Expense;

/**
 * Expense controller
 *
 * PHP version 7.0
 */
class Expenses extends \Core\Controller
{

    /**
     * Show the expense page
     *
     * @return void
     */
    public function indexAction()
    {
        if (isset($_SESSION['id'])) 
		{
			$expenses = Expense::get($_SESSION['start_date'],$_SESSION['end_date']);
			$categories_summed = Expense::sum_by_category($_SESSION['start_date'],$_SESSION['end_date']);
			$expenses_summed = Expense::sum_all($_SESSION['start_date'],$_SESSION['end_date']);
			$_SESSION['return_to'] = $_SERVER['REQUEST_URI'];	
			View::renderTemplate('Expense/index.html', ['expenses'=>$expenses, 'categories_summed'=>$categories_summed,  'expenses_summed'=>$expenses_summed]);
		}
		else
		{
			$this->redirect('/login/new');	
        } 
    }
	
	/**
     * Add income
     *
     * @return void
     */
    public function createAction()
    {
        
		 $expense = new Expense($_POST);
		
		if ($expense->save()) {

			
			$this->redirect($_SESSION['return_to']);

        } 
	
    }


}

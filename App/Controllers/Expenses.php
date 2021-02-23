<?php

namespace App\Controllers;

use \Core\View;
use \App\Date;
use \App\Models\Expense;

/**
 * Expense controller
 *
 * PHP version 7.0
 */
class Expenses extends Authenticated
{

    /**
     * Show the expense page
     *
     * @return void
     */
    public function indexAction()
    {

			$date = Date::get_date();
			$expenses = Expense::get($_SESSION['start_date'],$_SESSION['end_date']);
			$categories_summed = Expense::sum_by_category($_SESSION['start_date'],$_SESSION['end_date']);
			$expenses_summed = Expense::sum_all($_SESSION['start_date'],$_SESSION['end_date']);
			$expenses_planned_summed = Expense::sum_all_planned();
			$_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
			$render_expense_chart = true; 
			View::renderTemplate('Expense/index.html', ['date' => $date,
														'expenses'=>$expenses, 
														'categories_summed'=>$categories_summed,  
														'expenses_summed'=>$expenses_summed,
														'expenses_planned_summed'=>$expenses_planned_summed,
														'render_expense_chart'=>$render_expense_chart]);

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
	
	/**
     * Delete expense
     *
     * @return void
     */
	public function deleteAction($id)
    {
        
		Expense::delete($id);
		$this->redirect('/expenses/index');
	
    }


}

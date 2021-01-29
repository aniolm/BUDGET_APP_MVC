<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Income;
use \App\Models\Expense;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        if (isset($_SESSION['id'])) 
		{
		   $income_categories_summed = Income::sum_by_category($_SESSION['start_date'],$_SESSION['end_date']);
		   $expense_categories_summed = Expense::sum_by_category($_SESSION['start_date'],$_SESSION['end_date']);
		   $incomes_summed = Income::sum_all($_SESSION['start_date'],$_SESSION['end_date']);
		   $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
           View::renderTemplate('Home/index.html', ['income_categories_summed'=>$income_categories_summed, 'expense_categories_summed'=>$expense_categories_summed, 'incomes_summed'=>$incomes_summed]);
		}	 
		else
		{
		$this->redirect('/login/new');	
        } 
		
    }
}

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
		   $incomes_summed = Income::sum_by_category($_SESSION['start_date'],$_SESSION['end_date']);
		   $expenses_summed = Expense::sum_by_category($_SESSION['start_date'],$_SESSION['end_date']);
		   $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
           View::renderTemplate('Home/index.html', ['incomes_summed'=>$incomes_summed, 'expenses_summed'=>$expenses_summed]);
		}	 
		else
		{
		$this->redirect('/login/new');	
        } 
		
    }
}

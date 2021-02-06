<?php

namespace App\Controllers;

use \Core\View;
use \App\Date;
use \App\Models\Income;


/**
 * Incomes controller
 *
 * PHP version 7.0
 */
class Incomes extends \Core\Controller
{


	
	/**
     * Show the income page
     *
     * @return void
     */
    public function indexAction()
    {        		
		if (isset($_SESSION['id'])) 
		{
			$date = Date::get_date();
			$incomes = Income::get($_SESSION['start_date'],$_SESSION['end_date']);
			$categories_summed = Income::sum_by_category($_SESSION['start_date'],$_SESSION['end_date']);
			$incomes_summed = Income::sum_all($_SESSION['start_date'],$_SESSION['end_date']);
			$incomes_planned_summed = Income::sum_all_planned();
			$_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
			$render_income_chart = true;
			View::renderTemplate('Income/index.html', [ 'date' => $date,
														'incomes'=>$incomes, 
														'categories_summed'=>$categories_summed, 
														'incomes_summed'=>$incomes_summed, 
														'incomes_planned_summed'=>$incomes_planned_summed,
														'render_income_chart' => $render_income_chart]);
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
        
		 $income = new Income($_POST);
		
		if ($income->save()) {

			
			$this->redirect($_SESSION['return_to']);

        } 
	
    }
	
	
    
}

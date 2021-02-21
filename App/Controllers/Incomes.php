<?php

namespace App\Controllers;

use \Core\View;
use \App\Date;
use \App\Models\Income;
use \App\Models\Setting;

/**
 * Incomes controller
 *
 * PHP version 7.0
 */
class Incomes extends Authenticated
{
	
	/**
     * Show the income page
     *
     * @return void
     */
    public function indexAction()
    {        		
		
			$date = Date::get_date();
			$incomes = Income::get($_SESSION['start_date'],$_SESSION['end_date']);
			$categories_summed = Income::sum_by_category($_SESSION['start_date'],$_SESSION['end_date']);
			$incomes_summed = Income::sum_all($_SESSION['start_date'],$_SESSION['end_date']);
			$incomes_planned_summed = Income::sum_all_planned();
			$_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
			$income_categories = Setting::get_income_categories();
			$render_income_chart = true;
			View::renderTemplate('Income/index.html', [ 'date' => $date,
														'incomes'=>$incomes, 
														'categories_summed'=>$categories_summed, 
														'incomes_summed'=>$incomes_summed, 
														'incomes_planned_summed'=>$incomes_planned_summed,
														'income_categories'=>$income_categories,
														'render_income_chart' => $render_income_chart]);
		
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
	
	/**
     * Delete income
     *
     * @return void
     */
	public function deleteAction($id)
    {
        
		Income::delete($id);
		$this->redirect('/incomes/index');
	
    }
    
}

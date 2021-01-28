<?php

namespace App\Controllers;

use \Core\View;
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
			$incomes = Income::get($_SESSION['start_date'],$_SESSION['end_date']);
			$incomes_summed = Income::sum_by_category($_SESSION['start_date'],$_SESSION['end_date']);
			$_SESSION['return_to'] = $_SERVER['REQUEST_URI'];		
			View::renderTemplate('Income/index.html', ['incomes'=>$incomes, 'incomes_summed'=>$incomes_summed]);
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

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
        $startdate = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
		$enddate = date('Y-m-d', mktime(0, 0, 0, date('m')+1, 0, date('Y')));
		$incomes = Income::get($startdate, $enddate);
	    View::renderTemplate('Income/index.html', ['incomes'=>$incomes]);		
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

			
			$this->redirect('/');

        } 
	
    }


}

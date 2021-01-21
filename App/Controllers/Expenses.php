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
        View::renderTemplate('Expense/index.html');		
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

			
			$this->redirect('/');

        } 
	
    }


}

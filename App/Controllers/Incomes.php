<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Income;

/**
 * Sign-up controller
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
        View::renderTemplate('Income/index.html');		
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

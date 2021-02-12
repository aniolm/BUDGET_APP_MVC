<?php

namespace App\Controllers;

use \Core\View;
use \App\Date;
use \App\Models\Setting;

/**
 * Settings controller
 *
 * PHP version 7.0
 */
class Settings extends \Core\Controller
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
			$income_categories = Setting::get_income_categories();
			$expense_categories = Setting::get_expense_categories();
			$_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
			View::renderTemplate('Settings/index.html', [ 'income_categories' => $income_categories , 'expense_categories' => $expense_categories]);
		}
		else
		{
			$this->redirect('/login/new');	
        } 
    }
	
	/**
     * Edit income category
     *
     * @return void
     */
    
	public function editincomeAction($id)
    {
		
		$setting = new Setting($_POST);
		if($setting->edit($id, true))
		{		 
		 $this->redirect($_SESSION['return_to']);
		}
    }
	
	public function editexpenseAction($id)
    {
		
		$setting = new Setting($_POST);
		if($setting->edit($id, false))
		{		 
		 $this->redirect($_SESSION['return_to']);
		}
    }
	
    
}

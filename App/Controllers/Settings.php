<?php

namespace App\Controllers;

use \Core\View;
use \App\Date;
use \App\Models\Setting;
use \App\Models\User;

/**
 * Settings controller
 *
 * PHP version 7.0
 */
class Settings extends Authenticated
{

	/**
     * Show the income page
     *
     * @return void
     */
    public function indexAction()
    {        		

			$user = User::findById($_SESSION['user_id']);		
			$income_categories = Setting::get_income_categories();
			$expense_categories = Setting::get_expense_categories();
			$_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
			View::renderTemplate('Settings/index.html', [ 'user_id' => $user->id, 
														  'username' => $user->username ,
														  'email' => $user->email,
														  'income_categories' => $income_categories , 
														  'expense_categories' => $expense_categories ]);

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
		 $income_categories = Setting::get_income_categories();
		 $expense_categories = Setting::get_expense_categories();
		 $user = User::findById($_SESSION['user_id']);			 
		 View::renderBlock('Settings/index.html', 'content', [ 'user_id' => $user->id, 
																'username' => $user->username ,
																'email' => $user->email,
																'income_categories' => $income_categories , 
																'expense_categories' => $expense_categories ]);
		}
    }
	
	/**
     * Edit expense category
     *
     * @return void
     */
	 
	public function editexpenseAction($id)
    {
		
		$setting = new Setting($_POST);
		if($setting->edit($id, false))
		{		 
		 $income_categories = Setting::get_income_categories();
		 $expense_categories = Setting::get_expense_categories();
		 $user = User::findById($_SESSION['user_id']);;
		 View::renderBlock('Settings/index.html', 'content', [ 'user_id' => $user->id, 
																'username' => $user->username ,
																'email' => $user->email,
																'income_categories' => $income_categories , 
																'expense_categories' => $expense_categories ]);
		}
    }
	
    
}

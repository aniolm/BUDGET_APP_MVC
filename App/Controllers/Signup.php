<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

/**
 * Sign-up controller
 *
 * PHP version 7.0
 */
class Signup extends \Core\Controller
{

    /**
     * Show the signup page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Signup/new.html');		
    }
	
	/**
     * Create new user
     *
     * @return void
     */
    public function createAction()
    {
        $user = new User($_POST);
		
		if ($user->save()) {

			
			$this->redirect('/login/new');

        } 
		else 
		{
			
            View::renderTemplate('Signup/new.html');
			
        }
		
    }
}

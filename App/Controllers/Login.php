<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

/**
 * Sign-up controller
 *
 * PHP version 7.0
 */
class Login extends \Core\Controller
{

    /**
     * Show the signup page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Login/new.html');		
    }
	
	/**
     * Log in a user
     *
     * @return void
     */
    public function createAction()
    {
        $user = User::authenticate($_POST['uname'], $_POST['psw']);
        
        $remember_me = isset($_POST['remember-me']);

        if ($user) {

            //Auth::login($user, $remember_me);
			$_SESSION['id'] = $user->id;
			$_SESSION['username'] = $user->username;
            //$this->redirect(Auth::getReturnToPage());
			 $this->redirect('/');	
        } 
		else 
		{

            View::renderTemplate('Login/new.html');
        }
    }

    /**
     * Log out a user
     *
     * @return void
     */
    public function destroyAction()
    {
        Auth::logout();

        $this->redirect('/login/new');
    }
}

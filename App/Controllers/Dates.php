<?php

namespace App\Controllers;

use \Core\View;
use \App\Date;

/**
 * Incomes controller
 *
 * PHP version 7.0
 */
class Dates extends \Core\Controller
{

    
	/**
     * Show the income page
     *
     * @return void
     */
    public function changedateAction()
    {
	    Date::change_date($_POST['time_window'], $_POST['start_date'], $_POST['end_date'] );
		$this->redirect('/incomes/index');
    }

}

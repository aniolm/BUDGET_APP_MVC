<?php

namespace App;

/**
 * Helper class to store the chosen dates
 *
 * PHP version 7.0
 */
class Date 
{

	
	/**
     * Sets the 
     *
     * @return void
     */
    public static function set_date()
	{
		$_SESSION['start_date'] = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
		$_SESSION['end_date'] = date('Y-m-d', mktime(0, 0, 0, date('m')+1, 0, date('Y')));		
	}
	

	public static function change_date($time_window, $start_date, $end_date )
	{
		
		switch ($time_window) 
		{
		case 1:
			$_SESSION['start_date'] = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
		    $_SESSION['end_date'] = date('Y-m-d', mktime(0, 0, 0, date('m')+1, 0, date('Y')));	
			break;
		case 2:
			$_SESSION['start_date'] = date('Y-m-d', mktime(0, 0, 0, date('m')-1, 1, date('Y')));
		    $_SESSION['end_date'] = date('Y-m-d', mktime(0, 0, 0, date('m'), 0, date('Y')));	
			break;
		case 3:
			$_SESSION['start_date'] = $start_date;
		    $_SESSION['end_date'] = $end_date;	
			break;
		}
		
	}

}

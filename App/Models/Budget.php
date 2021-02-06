<?php

namespace App\Models;

use mysqli;

/**
 * Budget model
 *
 * PHP version 7.0
 */
class Budget extends \Core\Model
{
	
	
	/**
     * Calculate percentage of spent budget
     *
	 * returns decimal number
     */
	
	public static function calculate_percent($expenses_summed, $incomes_summed)
    {
		if ($incomes_summed == 0)
		{
			return 0;
		}
		else
		{
			return ( ($expenses_summed / $incomes_summed) * 100);
		}

	}
}

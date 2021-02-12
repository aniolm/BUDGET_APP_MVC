<?php

namespace App\Controllers;

use \Core\View;
use \App\Date;
use \App\Models\Income;
use \App\Models\Expense;
use \App\Models\Setting;
use \App\Models\Budget;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        if (isset($_SESSION['id'])) 
		{
		   $date = Date::get_date();
		   $income_categories_summed = Income::sum_by_category($_SESSION['start_date'],$_SESSION['end_date']);
		   $expense_categories_summed = Expense::sum_by_category($_SESSION['start_date'],$_SESSION['end_date']);
		   $incomes_summed = Income::sum_all($_SESSION['start_date'],$_SESSION['end_date']);
		   $expenses_summed = Expense::sum_all($_SESSION['start_date'],$_SESSION['end_date']);
		   $incomes_planned_summed = Income::sum_all_planned();
		   $expenses_planned_summed = Expense::sum_all_planned();
		   $budget_spent_percentage = Budget::calculate_percent($expenses_summed, $incomes_summed);
		   $render_budget_chart = true;
		   $income_categories = Setting::get_income_categories();
		   $expense_categories = Setting::get_expense_categories();
		   $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
           View::renderTemplate('Home/index.html', [ 'date' => $date,
													'income_categories_summed'=>$income_categories_summed, 
													'expense_categories_summed'=>$expense_categories_summed, 
													'incomes_summed'=>$incomes_summed, 
													'expenses_summed'=>$expenses_summed,
													'incomes_planned_summed'=>$incomes_planned_summed,
													'expenses_planned_summed'=>$expenses_planned_summed,
													'budget_spent_percentage'=>$budget_spent_percentage,
													'income_categories'=>$income_categories,
													'expense_categories'=>$expense_categories, 
													'render_budget_chart' => $render_budget_chart]);
		}	 
		else
		{
		$this->redirect('/login/new');	
        } 
		
    }
}

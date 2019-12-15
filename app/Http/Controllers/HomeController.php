<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        $expense = new Expense();

        if ($user->role_id != 1) $expenses = $expense->getMyTotalExpenses();
        else $expenses = $expense->getTotalExpenseGroupByCategory();

        $labels = []; // labels for pie chart
        $data = []; // data for pie chart
        foreach ($expenses as $expense) {
            $labels[] = $expense->category;
            $data[] = $expense->total;
        }

        return view('home', compact('expenses', 'labels', 'data'));
    }
}

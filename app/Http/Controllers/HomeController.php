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
        $expense = new Expense();

        $expenses = $expense->getTotalExpenseGroupByCategory();

        $labels = [];
        $data = [];

        foreach ($expenses as $expense) {
            $labels[] = $expense->category;
            $data[] = $expense->total;
        }

        return view('home', compact('expenses', 'labels', 'data'));
    }
}

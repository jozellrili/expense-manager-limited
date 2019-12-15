<?php

namespace App\Http\Controllers\Admin;

use App\Expense;
use App\Http\Requests\Admin\DestroyExpenseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreExpensesRequest;
use App\Http\Requests\Admin\UpdateExpensesRequest;
// use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class ExpensesController extends Controller
{
    /**
     * Display a listing of Expense.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('expense_access')) {
            return abort(401);
        }

        $expenses = Expense::all();
        $expense_categories = \App\ExpenseCategory::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.expenses.index', compact('expenses', 'expense_categories'));
    }

    /**
     * Show the form for creating new Expense.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('expense_create')) {
            return abort(401);
        }

        $expense_categories = \App\ExpenseCategory::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $created_bies = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.expenses.create', compact('expense_categories', 'created_bies'));
    }

    /**
     * Store a newly created Expense in storage.
     *
     * @param  \App\Http\Requests\StoreExpensesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpensesRequest $request)
    {
        if (!Gate::allows('expense_create')) {
            return abort(401);
        }

        if ($request->ajax()) {
            $expense = Expense::create($request->all());

            if (count($expense)) return \Response::json(['status' => 1, 'message' => 'New expense added.', 'data' => $expense]);
            else return \Response::json(['status' => 0, 'message' => 'Oops! Something went wrong.']);
        }

        return redirect()->route('admin.expenses.index');
    }


    /**
     * Show the form for editing Expense.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('expense_edit')) {
            return abort(401);
        }

        $expense_categories = \App\ExpenseCategory::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $created_bies = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $expense = Expense::findOrFail($id);

        return view('admin.expenses.edit', compact('expense', 'expense_categories', 'created_bies'));
    }

    /**
     * Update Expense in storage.
     *
     * @param  \App\Http\Requests\UpdateExpensesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExpensesRequest $request, $id)
    {
        if (!Gate::allows('expense_edit')) {
            return abort(401);
        }

        if ($request->ajax()) {
            $expense = Expense::findOrFail($id);
            $updated = $expense->update($request->all());

            if ($updated) return \Response::json(['status' => 1, 'message' => 'Expense updated!', 'data' => $expense]);
            else return \Response::json(['status' => 0, 'message' => 'Oops! Something went wrong.']);
        }


        return redirect()->route('admin.expenses.index');
    }


    /**
     * Display Expense.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('expense_view')) {
            return abort(401);
        }
        $expense = Expense::findOrFail($id);

        return view('admin.expenses.show', compact('expense'));
    }


    /**
     * Remove Expense from storage.
     *
     * @param DestroyExpenseRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyExpenseRequest $request, $id)
    {
        if (!Gate::allows('expense_delete')) {
            return abort(401);
        }

        if ($request->ajax()) {
            $expense = Expense::findOrFail($id);
            $deleted = $expense->delete();

            if ($deleted) return \Response::json(['status' => 1, 'message' => 'Expense permanently deleted!']);
            else return \Response::json(['status' => 0, 'message' => 'Oops! Something went wrong.']);
        }

        return redirect()->route('admin.expenses.index');
    }

    /**
     * Delete all selected Expense at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('expense_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Expense::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}

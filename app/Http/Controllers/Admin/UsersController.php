<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\DestroyUsersRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('user_access')) {
            return abort(401);
        }

        $users = User::all();
        $roles = \App\Role::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('user_create')) {
            return abort(401);
        }

        $roles = \App\Role::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param \App\Http\Requests\StoreUsersRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {
        if (!Gate::allows('user_create')) {
            return abort(401);
        }

        if ($request->ajax()) {
            $fields = $request->all();
            $fields['password'] = Hash::make($request->post('password'));
            $user = User::create($fields);

            if (count($user)) {
                unset($user['password']);
                $user['created_at'] = date('Y-m-d', strtotime($user['created_at']));
                return \Response::json(['status' => 1, 'message' => 'New user added', 'data' => $user]);
            } else return \Response::json(['status' => 0, 'message' => 'Oops! Something went wrong']);
        }

        return redirect()->route('admin.users.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('user_edit')) {
            return abort(401);
        }

        $roles = \App\Role::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update User in storage.
     *
     * @param \App\Http\Requests\UpdateUsersRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersRequest $request, $id)
    {
        if (!Gate::allows('user_edit')) {
            return abort(401);
        }

        if ($request->ajax()) {

            $user = User::findOrFail($id);
            $updated = $user->update($request->all());

            if ($updated) return \Response::json(['status' => 1, 'message' => 'User information updated!', 'data' => ['id' => $id]]);
            else return \Response::json(['status' => 0, 'message' => 'Oops! Something went wrong']);
        }

        return redirect()->route('admin.users.index');
    }


    /**
     * Display User.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('user_view')) {
            return abort(401);
        }

        $roles = \App\Role::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $expense_categories = \App\ExpenseCategory::where('created_by_id', $id)->get();
        $expenses = \App\Expense::where('created_by_id', $id)->get();
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user', 'expense_categories', 'income_categories', 'currencies', 'incomes', 'expenses'));
    }


    /**
     * Remove User from storage.
     *
     * @param DestroyUsersRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyUsersRequest $request, $id)
    {
        if (!Gate::allows('user_delete')) {
            return abort(401);
        }
        if ($request->ajax()) {

            $user = User::findOrFail($id);
            $deleted = $user->delete();

            if ($deleted) return \Response::json(['status' => 1, 'message' => 'User deleted permanently!']);
            else return \Response::json(['status' => 0, 'message' => 'Oops! Something went wrong']);
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('user_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}

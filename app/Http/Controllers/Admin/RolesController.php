<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\DestroyRolesRequest;
use App\Role;
use App\User;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;

class RolesController extends Controller
{
    /**
     * Display a listing of Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('role_access')) {
            return abort(401);
        }


        $roles = Role::all();

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating new Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('role_create')) {
            return abort(401);
        }
        return view('admin.roles.create');
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param  \App\Http\Requests\StoreRolesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRolesRequest $request)
    {

        if (!Gate::allows('role_create')) {
            return abort(401);
        }

        if ($request->ajax()) {
            $role = Role::create($request->all());

            if (count($role)) return \Response::json(['status' => 1, 'message' => 'New role added', 'data' => $role]);
            else return \Response::json(['status' => 0, 'message' => 'Oops! Something went wrong']);
        }


        return redirect()->route('admin.roles.index');
    }


    /**
     * Show the form for editing Role.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('role_edit')) {
            return abort(401);
        }
        $role = Role::findOrFail($id);

        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update Role in storage.
     *
     * @param  \App\Http\Requests\UpdateRolesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRolesRequest $request, $id)
    {
        if (!Gate::allows('role_edit')) {
            return abort(401);
        }

        if ($request->ajax()) {
            $role = Role::findOrFail($id);
            $updated = $role->update($request->all());

            if ($updated) return \Response::json(['status' => 1, 'message' => 'Role updated!', 'data' => ['id' => $id]]);
            else return \Response::json(['status' => 0, 'message' => 'Oops! Something went wrong']);
        }

        return redirect()->route('admin.roles.index');
    }


    /**
     * Display Role.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('role_view')) {
            return abort(401);
        }
        $users = \App\User::where('role_id', $id)->get();

        $role = Role::findOrFail($id);

        return view('admin.roles.show', compact('role', 'users'));
    }


    /**
     * Remove Role from storage.
     *
     * @param DestroyRolesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRolesRequest $request, $id)
    {
        if (!Gate::allows('role_delete')) {
            return abort(401);
        }

        if ($request->ajax()) {

            // If user is trying to delete admin, don't allow then return error
            if ($id == 1) \Response::json(['status' => 2, 'message' => 'Oops! Cannot delete role!']);

            $role = Role::findOrFail($id);
            $deleted = $role->delete();

            if ($deleted) {
                return \Response::json(['status' => 1, 'message' => 'Role deleted permanently!']);
            } else return \Response::json(['status' => 0, 'message' => 'Oops! Something went wrong']);
        }

        return redirect()->route('admin.roles.index');
    }

    /**
     * Delete all selected Role at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('role_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Role::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}

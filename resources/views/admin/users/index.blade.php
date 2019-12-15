@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('quickadmin.users.title')</h3>

        </div>
        <div class="card-body">
            <div class="breadcrumb-container position-relative">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">User Management</li>
                        <li class="breadcrumb-item active"><a href="#">Users</a></li>
                    </ol>
                </nav>
            </div>
            <div class="table-responsive">
                <table id="users-table" class="table table-bordered table-striped {{ count($users) > 0 ? 'datatable' : '' }} @can('user_delete') dt-select @endcan">
                    <thead>
                    <th>@lang('quickadmin.users.fields.name')</th>
                    <th>@lang('quickadmin.users.fields.email')</th>
                    <th>@lang('quickadmin.users.fields.role')</th>
                    <th>@lang('quickadmin.users.fields.created-at')</th>
                    </thead>

                    <tbody>
                    @if (count($users) > 0)
                        @foreach ($users as $user)
                            <tr data-entry-id="{{ $user->id }}" class="edit-user edit-row">
                                <td field-key="name" class="name text-info">{{ $user->name }}</td>
                                <td field-key="email" class="email">{{ $user->email }}</td>
                                <td field-key="role" class="role" data-role-id="{{ $user->role_id }}">{{ $user->role->title or '' }}</td>
                                <td field-key="created-at">{{ date('Y-m-d', strtotime($user->created_at))}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                @can('user_create')
                    <p class="text-right">
                        <a id="add-user" href="{{ route('admin.users.create') }}"
                           class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
                    </p>
                @endcan
            </div>

        </div>
    </div>
@stop
@section('modal')
    <div class="modal" tabindex="-1" role="dialog" id="users-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title action-name"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['method' => 'POST']) !!}
                    <input type="hidden" id="user-id">
                    <div class="position-relative form-group">
                        <label>@lang('quickadmin.users.fields.name')</label>
                        <input class="form-control form-control-sm" id="user-name" placeholder="Name">
                    </div>
                    <div class="position-relative form-group">
                        <label>@lang('quickadmin.users.fields.email')</label>
                        <input class="form-control form-control-sm" id="user-email" placeholder="juandelacruz@email.com">
                    </div>
                    <div class="position-relative form-group">
                        <label>@lang('quickadmin.users.fields.role')</label>
                        {!! Form::select('role_id', $roles, old('role_id'), ['id' => 'user-role', 'class' => 'form-control form-control-sm select2','required' => '']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm delete-btn" id="delete-user">Delete</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm" id="save-user">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        var ajax_url = '{{ route('admin.users.update', '') }}';
        @can('user_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.users.mass_destroy') }}';
        @endcan
    </script>
@endsection
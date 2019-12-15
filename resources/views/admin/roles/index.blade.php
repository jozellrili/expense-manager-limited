@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('quickadmin.roles.title')</h3>
        </div>
        <div class="card-body">
            <div class="breadcrumb-container position-relative">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">User Management</li>
                        <li class="breadcrumb-item active"><a href="#">Roles</a></li>
                    </ol>
                </nav>
            </div>
            <div class="table-responsive">
                <p class="text-dark">
                    <i class="fas fa-exclamation-circle"></i> Click the item to update the role.
                </p>
                <table id="role-table" class="table table-bordered table-striped {{ count($roles) > 0 ? 'datatable' : '' }} @can('role_delete') dt-select @endcan">
                    <thead>
                    <th>@lang('quickadmin.roles.fields.title')</th>
                    <th>@lang('quickadmin.roles.fields.description')</th>
                    <th>@lang('quickadmin.roles.fields.created-at')</th>
                    </thead>
                    <tbody>
                    @if (count($roles) > 0)
                        @foreach ($roles as $role)
                            <tr class="{{ $role->id != 1 ?  'edit-role edit-row' : '' }}" data-entry-id="{{ $role->id }}">
                                <td field-key="title" class="title {{ $role->id != 1 ?  'text-info' : 'text-dark' }}">{{ $role->title }}</td>
                                <td field-key="description" class="description">{{ $role->description }}</td>
                                <td field-key="created-at">{{ date('Y-m-d', strtotime($role->created_at)) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                @can('role_create')
                    <p class="text-right">
                        <a href="#" id="add-role"
                           class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
                    </p>
                @endcan
            </div>
        </div>
    </div>

@stop

@section('modal')
    <div class="modal" tabindex="-1" role="dialog" id="role-modal">
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
                    <input type="hidden" id="role-id">
                    <div class="position-relative form-group">
                        <label>@lang('quickadmin.roles.fields.title')</label>
                        <input class="form-control form-control-sm" id="role-display-name" placeholder="Display Name">
                    </div>
                    <div class="position-relative form-group">
                        <label>@lang('quickadmin.roles.fields.description')</label>
                        <textarea class="form-control form-control-sm" id="role-description" placeholder="Description"></textarea>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm text-right delete-btn" id="delete-role">Delete</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm" id="save-role">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        var ajax_url = '{{ route('admin.roles.update', '') }}';
        @can('role_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.roles.mass_destroy') }}';
        @endcan

    </script>
@endsection
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
                <p class="text-dark">
                    <i class="fas fa-exclamation-circle"></i> Click the display name to update the user.
                </p>
                <table class="table table-bordered table-striped {{ count($users) > 0 ? 'datatable' : '' }} @can('user_delete') dt-select @endcan">
                    <thead>
                    <th>@lang('quickadmin.users.fields.name')</th>
                    <th>@lang('quickadmin.users.fields.email')</th>
                    <th>@lang('quickadmin.users.fields.role')</th>
                    <th>@lang('quickadmin.users.fields.created-at')</th>
                    </thead>

                    <tbody>
                    @if (count($users) > 0)
                        @foreach ($users as $user)
                            <tr data-entry-id="{{ $user->id }}">
                                <td field-key='name'>
                                    <a href="#" class="edit-user">
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <td field-key='email'>{{ $user->email }}</td>
                                <td field-key='role'>{{ $user->role->title or '' }}</td>
                                <td field-key='role'>{{ date('Y-m-d', strtotime($user->created_at))}}</td>
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
                        <a href="{{ route('admin.users.create') }}"
                           class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
                    </p>
                @endcan
            </div>

        </div>
    </div>
@stop

@section('javascript')
    <script>
        @can('user_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.users.mass_destroy') }}';
        @endcan
    </script>
@endsection
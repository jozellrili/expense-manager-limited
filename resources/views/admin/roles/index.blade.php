@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('quickadmin.roles.title')</h3>
        </div>
        <div class="card-body">
            @can('role_create')
                <p>
                    <a href="{{ route('admin.roles.create') }}"
                       class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
                </p>
            @endcan
            <div class="table-responsive">
                <table class="table table-bordered table-striped {{ count($roles) > 0 ? 'datatable' : '' }} @can('role_delete') dt-select @endcan">
                    <thead>
                    @can('role_delete')
                        <th style="text-align:center;">
                            <input type="checkbox" id="select-all"/>
                        </th>
                    @endcan
                    <th>@lang('quickadmin.roles.fields.title')</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                    @if (count($roles) > 0)
                        @foreach ($roles as $role)
                            <tr data-entry-id="{{ $role->id }}">
                                @can('role_delete')
                                    <td></td>
                                @endcan

                                <td field-key='title'>{{ $role->title }}</td>
                                <td>
                                    @can('role_view')
                                        <a href="{{ route('admin.roles.show',[$role->id]) }}"
                                           class="btn btn-sm btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('role_edit')
                                        <a href="{{ route('admin.roles.edit',[$role->id]) }}"
                                           class="btn btn-sm btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('role_delete')
                                        {!! Form::open(array(
                                                                                'style' => 'display: inline-block;',
                                                                                'method' => 'DELETE',
                                                                                'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                                                                'route' => ['admin.roles.destroy', $role->id])) !!}
                                        {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-sm btn-danger')) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        @can('role_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.roles.mass_destroy') }}';
        @endcan

    </script>
@endsection
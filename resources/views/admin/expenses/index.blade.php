@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('quickadmin.expense.title')</h3>
    </div>
    <div class="card-body">
        @can('expense_create')
        <p>
            <a href="{{ route('admin.expenses.create') }}" id="add-expense-btn" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
            @if(!is_null(Auth::getUser()->role_id) && config('quickadmin.can_see_all_records_role_id') ==
            Auth::getUser()->role_id)
            @if(Session::get('Expense.filter', 'all') == 'my')
            <a href="?filter=all" class="btn btn-light">Show all records</a>
            @else
            <a href="?filter=my" class="btn btn-light">Filter my records</a>
            @endif
            @endif
        </p>
        @endcan
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('quickadmin.qa_list')
            </div>
            <div class="panel-body table-responsive">
                <table class="table table-bordered table-striped {{ count($expenses) > 0 ? 'datatable' : '' }} @can('expense_delete') dt-select @endcan">
                    <thead>
                    <tr>
                        @can('expense_delete')
                        <th style="text-align:center;"><input type="checkbox" id="select-all"/></th>
                        @endcan
                        <th>@lang('quickadmin.expense.fields.expense-category')</th>
                        <th>@lang('quickadmin.expense.fields.entry-date')</th>
                        <th>@lang('quickadmin.expense.fields.amount')</th>
                        <th>&nbsp;</th>

                    </tr>
                    </thead>
                    <tbody>
                    @if (count($expenses) > 0)
                    @foreach ($expenses as $expense)
                    <tr data-entry-id="{{ $expense->id }}">
                        @can('expense_delete')
                        <td></td>
                        @endcan

                        <td field-key='expense_category'>{{ $expense->expense_category->name or '' }}</td>
                        <td field-key='entry_date'>{{ $expense->entry_date }}</td>
                        <td field-key='amount'>{{ '$' . number_format($expense->amount, 2, '.', ',') }}</td>
                        <td>
                            @can('expense_view')
                            <a href="{{ route('admin.expenses.show',[$expense->id]) }}" class="btn btn-sm btn-primary">@lang('quickadmin.qa_view')</a>
                            @endcan
                            @can('expense_edit')
                            <a href="{{ route('admin.expenses.edit',[$expense->id]) }}" class="btn btn-sm btn-info">@lang('quickadmin.qa_edit')</a>
                            @endcan
                            @can('expense_delete')
                            {!! Form::open(array(
                            'style' => 'display: inline-block;',
                            'method' => 'DELETE',
                            'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                            'route' => ['admin.expenses.destroy', $expense->id])) !!}
                            {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-sm btn-danger'))
                            !!}
                            {!! Form::close() !!}
                            @endcan
                        </td>

                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="9">@lang('quickadmin.qa_no_entries_in_table')</td>
                    </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade show" id="expense-category-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: block;" aria-modal="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Expense Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="position-relative form-group">
                        <label for="name" class="control-label">Name*</label>
                        <input class="form-control form-control-sm" placeholder="Category Name" required="" name="name" type="text" id="name">
                    </div>
                    <div class="position-relative form-group">
                        <label for="description" class="control-label">Description*</label>
                        <textarea class="form-control form-control-sm" placeholder="Category Description" rows="3" required="" name="description" cols="50" id="description"></textarea>
                    </div>
                    <div class="position-relative mt-4">
                        <a href="http://127.0.0.1/expense-manager-limited/public/admin/expense_categories" class="btn btn-light btn-sm">
                            <i class="fas fa-angle-double-left"></i>
                            Back to list            </a>
                        <input class="btn btn-primary btn-sm" type="submit" value="Save">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script>
    @can('expense_delete')
    window.route_mass_crud_entries_destroy = '{{ route('admin.expenses.mass_destroy') }}';
    @endcan
</script>
@endsection
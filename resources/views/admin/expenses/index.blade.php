@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('quickadmin.expense.title')</h3>
        </div>
        <div class="card-body">
            <div class="breadcrumb-container position-relative">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Expense Management</li>
                        <li class="breadcrumb-item active"><a href="#">Expenses</a></li>
                    </ol>
                </nav>
            </div>
            <div class="table-responsive">
                <table id="expense-table" class="table table-bordered table-striped {{ count($expenses) > 0 ? 'datatable' : '' }} @can('expense_delete') dt-select @endcan">
                    <thead>
                    <th>@lang('quickadmin.expense.fields.expense-category')</th>
                    <th>@lang('quickadmin.expense.fields.amount')</th>
                    <th>@lang('quickadmin.expense.fields.entry-date')</th>
                    <th>@lang('quickadmin.expense.fields.created-at')</th>

                    </thead>
                    <tbody>
                    @if (count($expenses) > 0)
                        @foreach ($expenses as $expense)
                            <tr class="edit-expense edit-row" data-entry-id="{{ $expense->id }}">
                                <td field-key="expense_category" class="expense-category" data-expense-category-id="{{ $expense->expense_category->id }}">
                                    {{ $expense->expense_category->name or '' }}
                                </td>
                                <td field-key="amount" class="amount">{{ '₱' . number_format($expense->amount, 2, '.', ',') }}</td>
                                <td field-key="entry_date" class="entry-date">{{ $expense->entry_date }}</td>
                                <td field-key="created-at">{{ date('Y-m-d', strtotime($expense->created_at)) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                @can('expense_create')
                    <p class="text-right">
                        <a href="#" id="add-expense-btn" class="btn btn-success">@lang('quickadmin.quickadmin_add_expense')</a>
                    </p>
                @endcan
            </div>
        </div>
    </div>
@stop

@section('modal')
    <div class="modal" tabindex="-1" role="dialog" id="expense-modal">
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
                    <input type="hidden" id="expense-id">
                    <div class="position-relative form-group">
                        <label>@lang('quickadmin.expense.fields.expense-category')</label>
                        {!! Form::select('expense_category_id', $expense_categories, old('expense_category_id'), ['id' => 'expense-category-select', 'class' => 'form-control form-control-sm select2','required' => '']) !!}
                    </div>

                    <div class="position-relative form-group">
                        <label>@lang('quickadmin.expense.fields.amount')</label>
                        <input class="form-control form-control-sm" type="number" step=".01" id="expense-amount" placeholder="0.00" min="0">
                    </div>
                    <div class="position-relative form-group">
                        <label>@lang('quickadmin.expense.fields.entry-date')</label>
                        <input class="form-control form-control-sm" type="date" max="{{ date('Y-m-d') }}" id="expense-entry-date" placeholder="Display Name">
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm delete-btn" id="delete-expense">
                        Delete
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm" id="save-expense">Save
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        var ajax_url = '{{ route('admin.expenses.update', '') }}';
        @can('expense_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.expenses.mass_destroy') }}';
        @endcan
    </script>
@endsection
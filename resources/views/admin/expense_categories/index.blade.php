@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('quickadmin.expense-category.title')</h3>
    </div>
    <div class="card-body">
        <div class="breadcrumb-container position-relative">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Expense Management</li>
                    <li class="breadcrumb-item active"><a href="#">Expense Category</a></li>
                </ol>
            </nav>
        </div>
        <div class="table-responsive">
            <table id="expense-category-table" class="table table-bordered table-striped {{ count($expense_categories) > 0 ? 'datatable' : '' }} @can('expense_category_delete') dt-select @endcan">
                <thead>
                <tr>
                    <th>@lang('quickadmin.expense-category.fields.name')</th>
                    <th>@lang('quickadmin.expense-category.fields.description')</th>
                    <th>@lang('quickadmin.expense-category.fields.created-at')</th>
                </tr>
                </thead>

                <tbody>
                @if (count($expense_categories) > 0)
                @foreach ($expense_categories as $expense_category)
                <tr class="edit-expense-category edit-row" data-entry-id="{{ $expense_category->id }}">
                    <td field-key="name" class="name text-info">{{ $expense_category->name }}</td>
                    <td field-key="description" class="description">{{ $expense_category->description }}</td>
                    <td field-key="created-at">{{ date('Y-m-d', strtotime($expense_category->created_at)) }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="7">@lang('quickadmin.qa_no_entries_in_table')</td>
                </tr>
                @endif
                </tbody>
            </table>
        </div>
        @can('expense_category_create')
            <div class="text-right">
                <a href="#" class="btn btn-success" id="add-expense-category-btn">@lang('quickadmin.quickadmin_add_category')</a>
            </div>
        @endcan
    </div>
</div>
@stop

@section('modal')
    <div class="modal" tabindex="-1" role="dialog" id="expense-category-modal">
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
                    <input type="hidden" id="expense-category-id">
                    <div class="position-relative form-group">
                        <label>@lang('quickadmin.expense-category.fields.name')</label>
                        <input class="form-control form-control-sm" id="expense-category-name" placeholder="Display Name">
                    </div>
                    <div class="position-relative form-group">
                        <label>@lang('quickadmin.expense-category.fields.description')</label>
                        <textarea class="form-control form-control-sm" id="expense-category-description" placeholder="Description"></textarea>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm delete-btn" id="delete-expense-category">Delete</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm" id="save-expense-category">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script>
    var ajax_url = '{{ route('admin.expense_categories.update', '') }}';
    @can('expense_category_delete')
    window.route_mass_crud_entries_destroy = '{{ route('admin.expense_categories.mass_destroy') }}';
    @endcan

</script>
@endsection
@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('quickadmin.expense-category.title')</h3>
    </div>
    <div class="card-body">
        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($expense_categories) > 0 ? 'datatable' : '' }} @can('expense_category_delete') dt-select @endcan">
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
                <tr data-entry-id="{{ $expense_category->id }}">
                    <td field-key='name'>
                        <a href="#" class="edit-category-expenses">
                            {{ $expense_category->name }}
                        </a>
                    </td>
                    <td field-key='description'>{{ $expense_category->description }}</td>
                    <td field-key='created-at'>{{ date('Y-m-d', strtotime($expense_category->created_at)) }}</td>
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

@section('javascript')
<script>
    @can('expense_category_delete')
    window.route_mass_crud_entries_destroy = '{{ route('admin.expense_categories.mass_destroy') }}';
    @endcan

</script>
@endsection
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('quickadmin.expense.title')</h3>
        <p class="badge-pill badge-info text-lowercase ml-1 mt-1 small">@lang('quickadmin.qa_edit')</p>
    </div>
    <div class="card-body">
        {!! Form::model($expense, ['method' => 'PUT', 'route' => ['admin.expenses.update', $expense->id], 'id' =>
        'expense']) !!}
        <div class="position-relative form-group">
            {!! Form::label('expense_category_id', trans('quickadmin.expense.fields.expense-category').'*',
            ['class' => 'control-label']) !!}
            {!! Form::select('expense_category_id', $expense_categories, old('expense_category_id'),
            ['class' => 'form-control form-control-sm select2', 'required' => '']) !!}
            @if($errors->has('expense_category_id'))
            <p class=" help-block text-danger">
                {{ $errors->first('expense_category_id') }}
            </p>
            @endif
        </div>
        <div class="position-relative form-group">
            {!! Form::label('entry_date', trans('quickadmin.expense.fields.entry-date').'*', ['class' =>
            'control-label']) !!}
            {!! Form::text('entry_date', old('entry_date'), ['class' => 'form-control form-control-sm date', 'placeholder'
            => '', 'required' => '']) !!}
            @if($errors->has('entry_date'))
            <p class=" help-block text-danger">
                {{ $errors->first('entry_date') }}
            </p>
            @endif
        </div>
        <div class="position-relative form-group">
            {!! Form::label('amount', trans('quickadmin.expense.fields.amount').'*', ['class' =>
            'control-label']) !!}
            {!! Form::text('amount', old('amount'), ['class' => 'form-control form-control-sm', 'id' => 'moneyFormat',
            'placeholder' => '', 'required' => '']) !!}
            @if($errors->has('amount'))
            <p class=" help-block text-danger">
                {{ $errors->first('amount') }}
            </p>
            @endif
        </div>
        <div class="position-relative">
            <a href="{{ route('admin.expenses.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-angle-double-left"></i>
                @lang('quickadmin.qa_back_to_list')
            </a>
            {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-primary btn-sm']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop

@section('javascript')
@parent
<script>
    $('.date').datepicker({
        autoclose: true,
        dateFormat: "{{ config('app.date_format_js') }}"
    });
</script>
@stop
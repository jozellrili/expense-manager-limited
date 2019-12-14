@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('quickadmin.expense-category.title')</h3>
        <p class="badge-pill badge-warning text-lowercase ml-1 mt-1 small">@lang('quickadmin.qa_create')</p>
    </div>
    <div class="card-body">
        {!! Form::open(['method' => 'POST', 'route' => ['admin.expense_categories.store']]) !!}
        <div class="position-relative form-group">
            {!! Form::label('name', trans('quickadmin.expense-category.fields.name').'*', ['class' => 'control-label']) !!}
            {!! Form::text('name', old('name'), ['class' => 'form-control form-control-sm', 'placeholder' => 'Category Name', 'required' => '']) !!}
            @if($errors->has('name'))
            <p class="help-block text-danger">
                {{ $errors->first('name') }}
            </p>
            @endif
        </div>
        <div class="position-relative form-group">
            {!! Form::label('description', trans('quickadmin.expense-category.fields.description').'*', ['class' => 'control-label']) !!}
            {!! Form::textarea('description', old('description'), ['class' => 'form-control form-control-sm', 'placeholder' => 'Category Description', 'rows' => 3, 'required' => '']) !!}
            @if($errors->has('description'))
            <p class="help-block text-danger">
                {{ $errors->first('description') }}
            </p>
            @endif
        </div>
        <div class="position-relative mt-4">
            <a href="{{ route('admin.expense_categories.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-angle-double-left"></i>
                @lang('quickadmin.qa_back_to_list')
            </a>
            {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-primary btn-sm']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('quickadmin.qa_change_password')</h3>
    </div>
    <div class="card-body">

        @if(session('success'))
        <!-- If password successfully show message -->
        <div class="row">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
        @else
        {!! Form::open(['method' => 'PATCH', 'route' => ['auth.change_password']]) !!}
        <!-- If no success message in flash session show change password form  -->

        <div class="position-relative form-group">
            {!! Form::label('current_password', trans('quickadmin.qa_current_password'), ['class' =>
            'control-label']) !!}
            {!! Form::password('current_password', ['class' => 'form-control form-control-sm', 'placeholder' => '']) !!}
            @if($errors->has('current_password'))
            <p class="help-block text-danger">
                {{ $errors->first('current_password') }}
            </p>
            @endif
        </div>

        <div class="position-relative form-group">
            {!! Form::label('new_password', trans('quickadmin.qa_new_password'), ['class' =>
            'control-label']) !!}
            {!! Form::password('new_password', ['class' => 'form-control form-control-sm', 'placeholder' => '']) !!}
            @if($errors->has('new_password'))
            <p class="help-block text-danger">
                {{ $errors->first('new_password') }}
            </p>
            @endif
        </div>

        <div class="position-relative form-group">
            {!! Form::label('new_password_confirmation', trans('quickadmin.qa_password_confirm'), ['class'
            => 'control-label']) !!}
            {!! Form::password('new_password_confirmation', ['class' => 'form-control form-control-sm', 'placeholder' =>
            '']) !!}
            @if($errors->has('new_password_confirmation'))
            <p class="help-block text-danger">
                {{ $errors->first('new_password_confirmation') }}
            </p>
            @endif
        </div>
        <div class="position-relative">
            {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-primary btn-sm']) !!}
        </div>
        {!! Form::close() !!}
        @endif
    </div>
</div>

@stop
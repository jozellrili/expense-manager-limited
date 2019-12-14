@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('quickadmin.roles.title')</h3>
            <p class="badge-pill badge-warning text-lowercase ml-1 mt-1 small">@lang('quickadmin.qa_create')</p>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'POST', 'route' => ['admin.roles.store']]) !!}
            <div class="position-relative form-group">
                {!! Form::label('title', trans('quickadmin.roles.fields.title').'*', ['class' => '']) !!}
                {!! Form::text('title', old('title'), ['class' => 'form-control form-control-sm', 'placeholder' => 'Role Title', 'required' => '']) !!}
                @if($errors->has('title'))
                    <p class="help-block text-danger">
                        {{ $errors->first('title') }}
                    </p>
                @endif
            </div>
            <div class="position-relative mt-4">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-angle-double-left"></i>
                    @lang('quickadmin.qa_back_to_list')
                </a>
                {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-primary btn-sm']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@stop


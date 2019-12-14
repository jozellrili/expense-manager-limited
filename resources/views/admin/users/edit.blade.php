@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('quickadmin.users.title')</h3>
            <p class="badge-pill badge-info text-lowercase ml-1 mt-1 small">@lang('quickadmin.qa_edit')</p>
        </div>
        <div class="card-body">
            {!! Form::model($user, ['method' => 'PUT', 'route' => ['admin.users.update', $user->id]]) !!}
            <div class="position-relative form-group">
                {!! Form::label('name', trans('quickadmin.users.fields.name').'*', ['class' => ''])
                !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control form-control-sm', 'placeholder' => '', 'required'
                => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('name'))
                    <p class="help-block">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>
            <div class="position-relative form-group">
                {!! Form::label('email', trans('quickadmin.users.fields.email').'*', ['class' =>
                'control-label']) !!}
                {!! Form::email('email', old('email'), ['class' => 'form-control form-control-sm', 'placeholder' => '',
                'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('email'))
                    <p class="help-block">
                        {{ $errors->first('email') }}
                    </p>
                @endif
            </div>
            <div class="position-relative form-group">
                {!! Form::label('password', trans('quickadmin.users.fields.password').'*', ['class' =>
                'control-label']) !!}
                {!! Form::password('password', ['class' => 'form-control form-control-sm', 'placeholder' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('password'))
                    <p class="help-block">
                        {{ $errors->first('password') }}
                    </p>
                @endif
            </div>
            <div class="position-relative form-group">
                {!! Form::label('role_id', trans('quickadmin.users.fields.role').'*', ['class' =>
                'control-label']) !!}
                {!! Form::select('role_id', $roles, old('role_id'), ['class' => 'form-control form-control-sm select2',
                'required' => '']) !!}
                @if($errors->has('role_id'))
                    <p class="help-block text-danger">
                        {{ $errors->first('role_id') }}
                    </p>
                @endif
            </div>
            <div class="position-relative mt-4">
                <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-angle-double-left"></i>
                    @lang('quickadmin.qa_back_to_list')
                </a>
                {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-primary btn-sm']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    </div>
@stop


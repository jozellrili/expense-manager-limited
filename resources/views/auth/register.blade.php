@extends('layouts.auth')

@section('content')
    <div class="register-container d-flex justify-content-center flex-column">
        <div class="text-center pb-4 page-title">
            <h1>
                <strong>{{ ucfirst(config('app.name')) }}</strong>
            </h1>
        </div>
        <div class="register-form">
            <p>@lang('quickadmin.qa_register')</p>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="control-label">@lang('quickadmin.qa_name')</label>
                        <input id="name" type="text" class="form-control form-control-sm" name="name" value="{{ old('name') }}" required autofocus>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="control-label">@lang('quickadmin.qa_email')</label>
                    <input id="email" type="email" class="form-control form-control-sm" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="control-label">@lang('quickadmin.qa_password')</label>
                    <input id="password" type="password" class="form-control form-control-sm" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password-confirm" class="control-label">@lang('quickadmin.qa_confirm_password')</label>
                    <input id="password-confirm" type="password" class="form-control form-control-sm" name="password_confirmation" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        @lang('quickadmin.qa_register')
                    </button>
                </div>
                <div class="position-relative">
                    <a href="{{ route('auth.register') }}">@lang('auth.already_a_member')</a>
                </div>
            </form>
        </div>
    </div>
@endsection

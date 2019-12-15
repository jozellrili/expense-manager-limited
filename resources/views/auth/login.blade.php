@extends('layouts.auth')

@section('content')
    <div class="login-container d-flex justify-content-center flex-column">
        <div class="text-center pb-4 page-title">
            <h1>
                <strong>{{ ucfirst(config('app.name')) }}</strong>
            </h1>
        </div>
        <div class="login-form">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> @lang('quickadmin.qa_there_were_problems_with_input'):
                    <br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="form-horizontal" role="form" method="POST" action="{{ url('login') }}">
                <p class="text-center pb-4">@lang('auth.login_form_sub_title')</p>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="position-relative form-group">
                    <label for="exampleEmail" class="">@lang('quickadmin.qa_email')</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                </div>
                <div class="position-relative form-group">
                    <label>@lang('quickadmin.qa_password')</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group row">
                    <div class="col-lg-6 col-sm-12 text-left position-relative form-check">
                        <label class="form-check-label remember-me">
                            <input type="checkbox" class="form-check-input rm-checkbox" name="remember">
                            @lang('quickadmin.qa_remember_me')
                        </label>
                    </div>
                    <div class="col-lg-6 col-sm-12 text-right">
                        <a href="{{ route('auth.password.reset') }}">@lang('quickadmin.qa_forgot_password')</a>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        @lang('quickadmin.qa_login')
                    </button>
                </div>
                <div class="position-relative">
                    <a href="{{ route('auth.register') }}">@lang('auth.not_a_member')</a>
                </div>
            </form>
        </div>
    </div>
@endsection
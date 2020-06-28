@extends('doctor.layouts.base-2')

@section('pageTitle', 'Login')

@section('bodyClass', 'login-page hold-transition')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="/">MaNa<b>Dr</b> Dashboard</a>
        </div>

        <div class="login-box-body">
            @if (session('errorCredentails'))
                <div class="alert alert-warning" role="alert">
                    Credentials is not valid.
                </div>
            @endif

            <form action="{{route('doctor.signInSubmit')}}" method="post">
                <input name="_token" type="hidden" value="{!! csrf_token() !!}">
                <div class="form-group has-feedback">
                    <input name="email" type="email" class="form-control" placeholder="Email" required="true">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input name="password" type="password" class="form-control" placeholder="Password" required="true">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group">
                    <div class="form-control-static">
                        If you don't have an account, feel free to <a href="{{route('doctor.signUp')}}" class="text-center">sign up</a>.
                    </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-info btn-block btn-flat">Sign In</button>
                </div>
            </form>

        </div>
        <!-- /.login-box-body -->
    </div>
@stop
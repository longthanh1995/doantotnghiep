@extends('legacy.layouts.admin.application', ['noFrame' => true, 'bodyClasses' => 'hold-transition login-page'])

@section('pageTitle', 'Sign in')

@section('bodyClass', 'login-page hold-transition')

@section('title')
    Sign In
@stop

@section('header')
    Sign In
@stop

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('admin.home') }}">Admin Dashboard</a>
        </div>

        <div class="login-box-body">
            @if (session('errorCredentails'))
                <div class="alert alert-warning" role="alert">
                    Credentials is not valid.
                </div>
            @endif
            <form action="{{route('admin.signInSubmit')}}" method="post" id="signInForm">
                <input name="_token" type="hidden" value="{!! csrf_token() !!}">
                <div class="form-group has-feedback">
                    <input name="email" type="email" class="form-control" placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input name="password" type="password" class="form-control" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="form-group text-center">
                    <button class="btn btn-danger btn-sign-in-submit" type="submit">Sign in</button>
                </div>

                <div class="form-group">
                    <a href="{{ route('admin.auth.signUpAsClinicOwner') }}" class="text-center">Register a clinic owner account</a>
                </div>
            </form>
        </div>
        <!-- /.login-box-body -->
    </div>
@stop

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#signInForm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },

                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 255
                    }
                },

                errorElement: "p",
                errorClass: "help-block",

                errorPlacement: function(error, element) {
                    element.closest('div').append(error);
                },

                highlight: function(element) {
                    $(element).closest('.form-group').addClass('has-error');
                },

                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error');
                }
            });

            $(".btn-sign-in-submit").on('click', function (e) {
                e.preventDefault();

                $("#signInForm").submit();
            });
        });
    </script>
@endpush
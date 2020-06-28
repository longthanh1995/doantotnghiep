@extends('legacy.layouts.admin.application', ['noFrame' => true, 'bodyClasses' => 'hold-transition register-page'])

@section('pageTitle', 'Sign up as clinic owner')

@section('bodyClass', 'login-page hold-transition')

@section('title')
    Sign In
@stop

@section('header')
    Sign In
@stop

@section('content')
    @include('flash::message')

    <div class="register-box">
        <div class="register-logo">
            <a href="{{ route('admin.home') }}"><b>MaNaDr</b> Admin</a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">Register a new clinic owner account</p>

            <form class="form" id="form_register_clinic_owner" action="{{route('admin.auth.handleSignUpAsClinicOwner')}}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group has-feedback">
                    <input class="form-control" placeholder="Full name" type="text" name="name" autofocus>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input
                        class="form-control"
                        placeholder="Email"
                        type="email"
                        name="email"
                    @if($email)
                        value="{{$email}}"
                        readonly="readonly"
                    @endif
                    >
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input class="form-control" placeholder="Password" type="password" name="password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input class="form-control" placeholder="Retype password" type="password" name="passwordRetype">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input class="form-control" placeholder="Invite Code" type="text" name="code" value="{{$code}}">
                    <span class="glyphicon glyphicon-gift form-control-feedback"></span>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-danger btn-flat">Register</button>
                </div>
                <div class="form-group">
                    <a href="{{ route('admin.home') }}" class="text-center">Already have an account?</a>
                </div>

            </form>
        </div>
        <!-- /.form-box -->
    </div>
@stop

@push('scripts')
<script type="text/javascript">
    $(function(){
        $('#form_register_clinic_owner')
            .validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    email: {
                        required: true,
                        validateEmail: true
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 255
                    },
                    passwordRetype: {
                        required: true,
                        equalTo: '[name=password]'
                    },
                    code: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        minlength: 'Please enter at least 3 characters'
                    },
                    email: {
                        validateEmail: 'Invalid email format'
                    },
                    password: {
                        minlength: 'Please enter at least 6 characters'
                    },
                    passwordRetype: {
                        equalTo: 'Please enter the same password'
                    },
                    code: {
                        required: 'Please input your invite code'
                    }
                },
                errorPlacement: function(error, element) {
                    element.closest('div').append(error);
                },

                highlight: function(element) {
                    $(element).closest('.form-group').addClass('has-error');
                },

                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error');
                },

            })
    });
</script>
@endpush
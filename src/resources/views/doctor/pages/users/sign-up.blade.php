@extends('doctor.layouts.base-2')

@section('pageTitle', 'Sign up')

@section('bodyClass', 'login-page hold-transition')

@section('content')
    <div class="register-box">
        <div class="login-logo">
            <a href="/">MaNa<b>Dr</b> Dashboard</a>
        </div>
        <!-- /.login-logo -->
        <div class="register-box-body">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{route('doctor.signUpSubmit')}}" method="post">
                <input name="_token" type="hidden" value="{!! csrf_token() !!}">
                <div class="form-group has-feedback">
                    <input name="name" type="name" class="form-control" placeholder="Full name" required="true">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input name="email" type="email" class="form-control" placeholder="Email" required="true">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input name="password" type="password" class="form-control" placeholder="Password" required="true">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <select class="form-control chosen" name="phone_country_code" data-placeholder="Phone country code">
                        <option value=""></option>
                        @foreach($countries as $country)
                            <option value="{{$country->phone_country_code}}">{{$country->nice_name}} ({{$country->phone_country_code}})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group has-feedback">
                    <input class="form-control" name="phone_number" type="text" value="" placeholder="Phone number" required="true"/>
                    <span class="fa fa-phone form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <select name="country_id" type="text" class="form-control chosen" data-placeholder="Country of practice">
                        <option value=""></option>
                    @foreach($countries as $country)
                        <option value="{{$country->id}}">{{$country->nice_name}}</option>
                    @endforeach
                    </select>
                    <span class="fa fa-flag form-control-feedback"></span>
                </div>
                <div class="form-group">
                    <div class="form-control-static">
                        If you have already had an account, feel free to <a href="{{route('doctor.signIn')}}" class="text-center">sign in</a>.
                    </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-warning btn-block btn-flat">Sign Up</button>
                </div>
            </form>

        </div>
        <!-- /.register-box-body -->
    </div>
@stop

@push('customScripts')
<script type="text/javascript">
    $('select.chosen').chosen({
        width: '100%',
        search_contains: true
    });
</script>
@endpush
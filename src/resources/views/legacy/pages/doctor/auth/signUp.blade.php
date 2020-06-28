@extends('legacy.layouts.doctor.application')

@section('layoutContent')
    @include('legacy.layouts.doctor.partials.navbar')

    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <h3 class="text-center">Doctor Dashboard - Sign Up</h3>

                {!! Form::open(['class' => 'form-horizontal', 'route' => 'doctor.signUpSubmit', 'id' => 'signUpForm']) !!}
                    <hr />

                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        {!! Form::label('name', 'Name', ['class' => 'control-label col-sm-3']) !!}

                        <div class="col-sm-9">
                            {!! Form::text('name', old('name'), [
                                'class' => 'form-control',
                                'placeholder' => 'Name',
                                'autofocus' => true,
                                'required' => true,
                                'autocomplete' => 'off'
                            ]) !!}

                            @if ($errors->has('name'))
                                @foreach ($errors->get('name') as $error)
                                    <p class="help-block">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if ($errors->has('email')) has-error @endif">
                        {!! Form::label('email', 'Email', ['class' => 'control-label col-sm-3']) !!}

                        <div class="col-sm-9">
                            {!! Form::email('email', old('email'), [
                                'class' => 'form-control',
                                'placeholder' => 'Email',
                                'required' => true,
                                'autocomplete' => 'off'
                            ]) !!}

                            @if ($errors->has('email'))
                                @foreach ($errors->get('email') as $error)
                                    <p class="help-block">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if ($errors->has('password')) has-error @endif">
                        {!! Form::label('password', 'Password', ['class' => 'control-label col-sm-3']) !!}

                        <div class="col-sm-9">
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required' => true]) !!}

                            @if ($errors->has('password'))
                                @foreach ($errors->get('password') as $error)
                                    <p class="help-block">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <hr />

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            If you have already had an account, <a href="{{ route('doctor.signIn') }}">feel free to sign in.</a>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button class="btn btn-lg btn-primary btn-sign-up-submit" type="submit">Sign up</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#signUpForm").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },

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

            $(".btn-sign-up-submit").on('click', function (e) {
                e.preventDefault();

                $("#signUpForm").submit();
            });
        });
    </script>
@endpush
@extends('legacy.layouts.doctor.application')

@section('layoutContent')
    @include('legacy.layouts.doctor.partials.navbar')

    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <h3 class="text-center">Doctor Dashboard - Sign in</h3>

                @if (session('errorCredentails'))
                    <div class="alert alert-warning" role="alert">
                        Credentials is not valid.
                    </div>
                @endif

                {!! Form::open(['class' => 'form-horizontal', 'route' => 'doctor.signInSubmit', 'id' => 'signInForm']) !!}
                    <hr />

                    <div class="form-group @if ($errors->has('email')) has-error @endif">
                        {!! Form::label('email', 'Email', ['class' => 'control-label col-sm-3']) !!}

                        <div class="col-sm-9">
                            {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email', 'autofocus' => true, 'required' => true]) !!}

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
                            If you don't have an account, <a href="{{ route('doctor.signUp') }}">feel free to sign up.</a>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button class="btn btn-lg btn-primary btn-sign-in-submit" type="submit">Sign in</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div> <!-- /container -->
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
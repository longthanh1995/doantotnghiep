@extends('legacy.pages.doctor.profile.layout', ['childPage' => 'avatar'])

@section('pageHeader')
    <h1>Avatar</h1>
@stop

@section('childContent')
    <div class="panel panel-profile">
        <div class="panel-heading">
            <i class="fa fa-fw fa-file-image-o"></i> Avatar

            <div class="pull-right">
                <a href="#" class="btn-caret btn-trigger-edit" data-form="avatarForm">
                    <i class="fa fa-fw fa-edit"></i> Edit
                </a>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="panel-body">
            {!! Form::open(['route' => 'profile.avatarSubmit', 'class' => 'form-horizontal', 'id' => 'avatarForm', 'files' => true]) !!}
                <div class="form-group @if ($errors->getBag('avatarForm')->has('avatar')) has-error @endif">
                    {!! Form::label('current_avatar', 'Current Avatar', ['class' => 'col-sm-3 col-xs-12 control-label']) !!}

                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static">
                            @if ($authDoctor->profileImage)
                                <img src="{{ $authDoctor->profileImage->getThumbnailUrl() }}" width="100" height="100"/>
                            @else
                                <img src="{{ \App\Models\Doctor::getDefaultAvatarUrl() }}" width="100" height="100"/>
                            @endif
                        </p>

                        <div class="hide">
                            {!! Form::file('avatar') !!}

                            <div class="help-block">(Maximum size: 10 MB)</div>
                        </div>

                        @if ($errors->getBag('avatarForm')->has('avatar'))
                            @foreach ($errors->getBag('avatarForm')->get('avatar') as $error)
                                <p class="help-block">{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group form-control-submit hide">
                    <div class="col-sm-9 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-primary">Save</button>

                        &nbsp; &nbsp;

                        <button type="button" class="btn btn-normal btn-form-cancel">Cancel</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            @if ($errors->hasBag('avatarForm'))
                openEditForm('avatarForm');
            @endif
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#avatarForm").validate({
                rules: {
                    avatar: {
                        required: true,
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
        });
    </script>
@endpush
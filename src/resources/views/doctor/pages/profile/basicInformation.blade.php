@extends('doctor.layouts.base')

@section('pageTitle'){{$authDoctor->name}} - Basic Information @stop

@section('bodyClass', 'page-profile page-profile-avatar')

@section('contentHeader')
    Basic Information
@stop

@section('contentHeaderSub')
@stop

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a>Profile</a></li>
        <li class="active">Basic Information</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-9 col-md-push-3">
            <div class="box box-primary" id="box_basic_information">
                <div class="box-header">
                    <div class="box-tools pull-right">
                        <a href="#" class="btn btn-box-tool" data-action="edit">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                    </div>
                    <h3 class="box-title">Basic Information</h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div id="box_basic_information__image_container">
                                @if ($authDoctor->profileImage)
                                    <img id="box_basic_information__image" src="{{ $authDoctor->profileImage->getThumbnailUrl() }}" class="profile-user-img img-responsive img-circle" width="100" height="100"/>
                                @else
                                    <img id="box_basic_information__image" src="{{ \App\Models\Doctor::getDefaultAvatarUrl($authDoctor->gender) }}" class="profile-user-img img-responsive img-circle" width="100" height="100"/>
                                @endif

                                <div class="overlay hide" id="box_basic_information__image_overlay">
                                    <i class="fa fa-refresh fa-spin"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-10">
                            {!! Form::open(['route' => 'profile.basicInformationSubmit', 'class' => 'form-horizontal', 'id' => 'form_basic_information']) !!}
                                <div class="form-group @if ($errors->getBag('basicInformationForm')->has('title')) has-error @endif">
                                    {!! Form::label('title', 'Title', ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-sm-9">
                                        <p class="form-control-static">
                                            @if ($authDoctor->doctor_title_id && !empty($titlesOption[$authDoctor->doctor_title_id]))
                                                {{ $titlesOption[$authDoctor->doctor_title_id] }}
                                            @else
                                                <span class="text-danger">N/A</span>
                                            @endif
                                        </p>

                                        {!! Form::select('title', $titlesOption, old('title', $authDoctor->doctor_title_id), ['class' => 'form-control']) !!}

                                        @if ($errors->getBag('basicInformationForm')->has('title'))
                                            @foreach ($errors->getBag('basicInformationForm')->get('title') as $error)
                                                <p class="text-danger">{{ $error }}</p>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if ($errors->getBag('basicInformationForm')->has('name')) has-error @endif">
                                    {!! Form::label('name', 'Full Name', ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-sm-9">
                                        <p class="form-control-static">{{ $authDoctor->name }}</p>

                                        {!! Form::text('name', old('name', $authDoctor->name), ['class' => 'form-control']) !!}

                                        @if ($errors->getBag('basicInformationForm')->has('name'))
                                            @foreach ($errors->getBag('basicInformationForm')->get('name') as $error)
                                                <p class="help-block">{{ $error }}</p>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if ($errors->getBag('basicInformationForm')->has('date_of_birth')) has-error @endif">
                                    {!! Form::label('date_of_birth', 'Date of Birth', ['class' => 'col-sm-3 control-label']) !!}

                                    <div class="col-sm-9">
                                        <?php $dateOfBirth = $authDoctor->date_of_birth ? $authDoctor->date_of_birth->format('d/m/Y') : '';?>

                                        <p class="form-control-static">
                                            @if ($dateOfBirth)
                                                {{ $dateOfBirth }}
                                            @else
                                                <span class="text-danger">N/A</span>
                                            @endif
                                        </p>

                                        {!! Form::text('date_of_birth', old('date_of_birth', $dateOfBirth), [
                                            'class' => 'form-control datepicker',
                                            'readonly' => 'readonly',
                                            'placeholder' => 'Click to pick a date'
                                        ]) !!}

                                        @if ($errors->getBag('basicInformationForm')->has('date_of_birth'))
                                            @foreach ($errors->getBag('basicInformationForm')->get('date_of_birth') as $error)
                                                <p class="help-block">{{ $error }}</p>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if ($errors->getBag('basicInformationForm')->has('gender')) has-error @endif">
                                    {!! Form::label('gender', 'Gender', ['class' => 'col-sm-3 control-label']) !!}

                                    <div class="col-sm-9">
                                        <p class="form-control-static">
                                            @if ($authDoctor->gender)
                                                {{ $gendersOption[$authDoctor->gender] }}
                                            @else
                                                <span class="text-danger">N/A</span>
                                            @endif
                                        </p>

                                        {!! Form::select('gender', $gendersOption, old('gender', $authDoctor->gender), ['class' => 'form-control']) !!}

                                        @if ($errors->getBag('basicInformationForm')->has('gender'))
                                            @foreach ($errors->getBag('basicInformationForm')->get('gender') as $error)
                                                <p class="help-block">{{ $error }}</p>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="form_basic_information__select_languages" class="col-sm-3 control-label">Languages</label>

                                    <div class="col-sm-9">
                                        <p class="form-control-static">
                                            @if (count($doctorLanguages) > 0)
                                                {{--{!! $doctorLanguages !!}--}}
{{--                                                {{implode(', ', array_map(function($language){return $language->name;}, get_object_vars($doctorLanguages)))}}--}}
                                                @foreach ($doctorLanguages as $language)
                                                    <span>{{ $language->name }}</span>,
                                                @endforeach
                                            @else
                                                <span class="text-danger">N/A</span>
                                            @endif
                                        </p>

                                        <select name="languages[]" id="form_basic_information__select_languages" class="form-control" multiple="multiple">
                                            @foreach ($languagesOption as $languageKey => $languageName)
                                                <option value="{{ $languageKey }}" @if ($doctorLanguages->has($languageKey)) selected="selected" @endif>
                                                    {{ $languageName }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @if ($errors->getBag('basicInformationForm')->has('languages'))
                                            @foreach ($errors->getBag('basicInformationForm')->get('languages') as $error)
                                                <p class="help-block">{{ $error }}</p>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('professions', 'Profession IDs', ['class' => 'col-sm-3 control-label']) !!}

                                    <div class="col-sm-9">
                                        @if (count($doctorProfessions) > 0)
                                            @foreach ($doctorProfessions as $doctorProfession)
                                                <p class="form-control-static">
                                                    <span>
                                                        <b>Name:</b> {{ $doctorProfession->name }}

                                                        &nbsp; | &nbsp;

                                                        <b>License No:</b> {{ $doctorProfession->license_no }}
                                                    </span>
                                                </p>
                                            @endforeach
                                        @else
                                            <p class="form-control-static">
                                                <span class="text-danger">N/A</span>
                                            </p>
                                        @endif

                                        <table class="table table-bordered table-striped" id="table_edit_professional_ids">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>License</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            @foreach ($doctorProfessions as $k => $doctorProfession)
                                                <tr>
                                                    <td>
                                                        {!! Form::text('professions['.$k.'][name]', $doctorProfession->name, ['class' => 'form-control input-sm']) !!}

                                                    </td>

                                                    <td>
                                                        {!! Form::text('professions['.$k.'][license]', $doctorProfession->license_no, ['class' => 'form-control input-sm']) !!}
                                                    </td>

                                                    <td class="v-middle text-center">
                                                        <a href="#" class="btn btn-sm btn-danger btn-remove-profession">
                                                            <i class="fa fa-times"></i> Remove
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>

                                            <tfoot>
                                            <tr>
                                                <td colspan="3">
                                                    <a href="#" class="btn btn-sm btn-primary btn-add-profession">
                                                        <i class="fa fa-fw fa-plus"></i> Add
                                                    </a>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button type="submit" class="btn btn-primary btn-sm">Save</button>

                                        <button type="reset" class="btn btn-default btn-sm">Reset</button>
                                    </div>
                                </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-info" id="box_personal_contact_info">
                <div class="box-header">
                    <div class="box-tools pull-right">
                        <a href="#" class="btn btn-box-tool" data-action="edit">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                    </div>
                    <h3 class="box-title">Personal Contact</h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-10">
                            {!! Form::open(['route' => 'profile.personalContactSubmit', 'class' => 'form-horizontal', 'id' => 'form_personal_contact_info']) !!}
                                <div class="form-group @if ($errors->getBag('personalContactForm')->has('phone_country_code') || $errors->getBag('personalContactForm')->has('phone_number')) has-error @endif">
                                    {!! Form::label('phone_country_code', 'Phone Number', ['class' => 'col-sm-3 control-label']) !!}

                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <p class="form-control-static">
                                                    @if (isset($phoneCountriesOption[$authDoctor->phone_country_code]))
                                                        {{ $phoneCountriesOption[$authDoctor->phone_country_code] }}
                                                    @else
                                                        <span class="text-danger">N/A</span>
                                                    @endif
                                                </p>
                                                {!! Form::select('phone_country_code', $phoneCountriesOption, old('phone_country_code', $authDoctor->phone_country_code), [
                                                    'class' => 'form-control'
                                                ]) !!}

                                                @if ($errors->getBag('personalContactForm')->has('phone_country_code'))
                                                    @foreach ($errors->getBag('personalContactForm')->get('phone_number') as $error)
                                                        <p class="help-block">{{ $error }}</p>
                                                    @endforeach
                                                @endif
                                            </div>

                                            <div class="col-sm-8">
                                                <p class="form-control-static">{{ $authDoctor->phone_number }}</p>

                                                {!! Form::text('phone_number', old('phone_number', $authDoctor->phone_number), [
                                                    'class' => 'form-control'
                                                ]) !!}

                                                @if ($errors->getBag('personalContactForm')->has('phone_country_code'))
                                                    @foreach ($errors->getBag('personalContactForm')->get('phone_number') as $error)
                                                        <p class="help-block">{{ $error }}</p>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group @if ($errors->getBag('personalContactForm')->has('email')) has-error @endif">
                                    {!! Form::label('email', 'Email', ['class' => 'col-sm-3 control-label']) !!}

                                    <div class="col-sm-9">
                                        <p class="form-control-static">{{ $authDoctor->account?$authDoctor->account->email:'' }}</p>

                                        {!! Form::email('email', old('email', $authDoctor->account?$authDoctor->account->email:''), ['class' => 'form-control']) !!}

                                        @if ($errors->getBag('personalContactForm')->has('email'))
                                            @foreach ($errors->getBag('personalContactForm')->get('email') as $error)
                                                <p class="help-block">{{ $error }}</p>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if ($errors->getBag('personalContactForm')->has('website')) has-error @endif">
                                    {!! Form::label('website', 'Website', ['class' => 'col-sm-3 control-label']) !!}

                                    <div class="col-sm-9">
                                        <p class="form-control-static">
                                            @if ($authDoctor->website)
                                                {{ $authDoctor->website }}
                                            @else
                                                <span class="text-danger">N/A</span>
                                            @endif
                                        </p>

                                        {!! Form::text('website', old('website', $authDoctor->website), ['class' => 'form-control']) !!}

                                        @if ($errors->getBag('personalContactForm')->has('website'))
                                            @foreach ($errors->getBag('personalContactForm')->get('website') as $error)
                                                <p class="help-block">{{ $error }}</p>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if ($errors->getBag('personalContactForm')->has('address')) has-error @endif">
                                    {!! Form::label('address', 'Address', ['class' => 'col-sm-3 control-label']) !!}

                                    <div class="col-sm-9">
                                        <p class="form-control-static">
                                            @if ($authDoctor->address)
                                                {{ $authDoctor->address }}
                                            @else
                                                <span class="text-danger">N/A</span>
                                            @endif
                                        </p>

                                        {!! Form::text('address', old('address', $authDoctor->address), ['class' => 'form-control']) !!}

                                        @if ($errors->getBag('personalContactForm')->has('address'))
                                            @foreach ($errors->getBag('personalContactForm')->get('address') as $error)
                                                <p class="help-block">{{ $error }}</p>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if ($errors->getBag('personalContactForm')->has('office_hours')) has-error @endif">
                                    {!! Form::label('office_hours', 'Office Hours', ['class' => 'col-sm-3 control-label']) !!}

                                    <div class="col-sm-9">
                                        <p class="form-control-static">
                                            @if ($authDoctor->office_hours)
                                                {!! nl2br(e($authDoctor->office_hours)) !!}
                                            @else
                                                <span class="text-danger">N/A</span>
                                            @endif
                                        </p>

                                        {!! Form::textarea('office_hours', old('office_hours', $authDoctor->office_hours), ['class' => 'form-control']) !!}

                                        @if ($errors->getBag('personalContactForm')->has('office_hours'))
                                            @foreach ($errors->getBag('personalContactForm')->get('office_hours') as $error)
                                                <p class="help-block">{{ $error }}</p>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button type="submit" class="btn btn-primary btn-sm">Save</button>

                                        <button type="reset" class="btn btn-default btn-sm">Reset</button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-danger" id="box_security">
                <div class="box-header">
                    <div class="box-tools pull-right">
                        <a href="#" class="btn btn-box-tool" data-action="changePassword" data-doctor-id="{{$authDoctor->id}}">
                            <i class="fa fa-pencil"></i> Change Password
                        </a>
                    </div>
                    <h3 class="box-title">
                        Security
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-md-pull-9">
            @include('doctor.pages.profile.partials.leftMenu', [
                'currentPage' => 'basicInformation'
            ])
        </div>
    </div>
@stop
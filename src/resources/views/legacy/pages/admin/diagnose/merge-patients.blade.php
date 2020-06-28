@extends('legacy.layouts.admin.application')

@section('pageTitle', 'Merge Patients - System Diagnose')

@section('header', 'Merge patients')

@section('subheader', 'Merge 2 specific patients  into 1')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default" id="box_merge_patients">
                    <div class="box-body">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th></th>
                                <th>
                                    <div class="text-center">
                                        To be removed
                                    </div>
                                </th>
                                <th>
                                    <div class="text-center">
                                        To be kept
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th></th>
                                <td data-patient="from" data-id="{{!empty($fromPatient)?$fromPatient->id:""}}">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Patient Id" value="{{!empty($fromPatient)?$fromPatient->id:""}}" autocomplete="off"/>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" data-action="search">Search</button>
                                        </span>
                                    </div>
                                </td>
                                <td data-patient="to" data-id="{{!empty($toPatient)?$toPatient->id:""}}">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Patient Id"value="{{!empty($toPatient)?$toPatient->id:""}}" autocomplete="off"/>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" data-action="search">Search</button>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr data-field="id">
                                <th>ID</th>
                                <td data-patient="from">
                                    @if(!empty($fromPatient))
                                        {{$fromPatient->id}}
                                    @endif
                                </td>
                                <td data-patient="to">
                                    @if(!empty($toPatient))
                                        {{$toPatient->id}}
                                    @endif
                                </td>
                            </tr>
                            <tr data-field="name">
                                <th>Name</th>
                                <td data-patient="from">
                                @if(!empty($fromPatient))
                                    <b>{{$fromPatient->first_name}}</b> {{$fromPatient->last_name}}
                                @endif
                                </td>
                                <td data-patient="to">
                                @if(!empty($toPatient))
                                    <b>{{$toPatient->first_name}}</b> {{$toPatient->last_name}}
                                @endif
                                </td>
                            </tr>
                            <tr data-field="date_of_birth">
                                <th>Date of Birth</th>
                                <td data-patient="from">
                                @if(!empty($fromPatient))
                                    {{$fromPatient->date_of_birth?$fromPatient->date_of_birth->format('d/m/Y'):''}}
                                @endif
                                </td>
                                <td data-patient="to">
                                @if(!empty($toPatient))
                                    {{$toPatient->date_of_birth?$toPatient->date_of_birth->format('d/m/Y'):''}}
                                @endif
                                </td>
                            </tr>
                            <tr data-field="gender">
                                <th>Gender</th>
                                <td data-patient="from">
                                @if(!empty($fromPatient))
                                    {{$fromPatient->gender}}
                                @endif
                                </td>
                                <td data-patient="to">
                                @if(!empty($toPatient))
                                    {{$toPatient->gender}}
                                @endif
                                </td>
                            </tr>
                            <tr data-field="email">
                                <th>Email</th>
                                <td data-patient="from">
                                @if(!empty($fromPatient))
                                    {{$fromPatient->email}}
                                @endif
                                </td>
                                <td data-patient="to">
                                @if(!empty($toPatient))
                                    {{$toPatient->gender}}
                                @endif
                                </td>
                            </tr>
                            <tr data-field="phone_number">
                                <th>Phone Number</th>
                                <td data-patient="from">
                                @if(!empty($fromPatient))
                                    {{$fromPatient->phone_country_code?'('.$fromPatient->phone_country_code.')':''}}
						            {{$fromPatient->phone_number}}
                                @endif
                                </td>
                                <td data-patient="to">
                                @if(!empty($toPatient))
                                    {{$toPatient->phone_country_code?'('.$toPatient->phone_country_code.')':''}}
						            {{$toPatient->phone_number}}
                                @endif
                                </td>
                            </tr>
                            <tr data-field="id_number">
                                <th>National ID</th>
                                <td data-patient="from">
                                @if(!empty($fromPatient))
                                    {{$fromPatient->id_number}}
                                @endif
                                </td>
                                <td data-patient="to">
                                @if(!empty($toPatient))
                                    {{$toPatient->id_number}}
                                @endif
                                </td>
                            </tr>
                            <tr data-field="address">
                                <th>Address</th>
                                <td data-patient="from">
                                @if(!empty($fromPatient))
                                    {{$fromPatient->address}}
                                @endif
                                </td>
                                <td data-patient="to">
                                @if(!empty($toPatient))
                                    {{$toPatient->address}}
                                @endif
                                </td>
                            </tr>
                            <tr data-field="country">
                                <th>Country</th>
                                <td data-patient="from">
                                @if(!empty($fromPatient))
                                    {{$fromPatient->country?$fromPatient->country->nice_name:''}}
                                @endif
                                </td>
                                <td data-patient="to">
                                @if(!empty($toPatient))
                                    {{$toPatient->country?$toPatient->country->nice_name:''}}
                                @endif
                                </td>
                            </tr>
                            <tr data-field="address_zip">
                                <th>Zip code</th>
                                <td data-patient="from">
                                @if(!empty($fromPatient))
                                    {{$fromPatient->address_zip}}
                                @endif
                                </td>
                                <td data-patient="to">
                                @if(!empty($toPatient))
                                    {{$toPatient->address_zip}}
                                @endif
                                </td>
                            </tr>
                            <tr data-field="created_at">
                                <th>Created At</th>
                                <td data-patient="from">
                                @if(!empty($fromPatient))
                                    {{$fromPatient->created_at}}
                                @endif
                                </td>
                                <td data-patient="to">
                                @if(!empty($toPatient))
                                    {{$toPatient->created_at}}
                                @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="#" class="btn btn-danger" data-action="merge"><i class="fa fa-warning"></i> Merge</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function(){
        $('#box_merge_patients')
            .on('click', '[data-action=merge]', function(event){
                event.preventDefault();

                var fromId = parseInt($('[data-field="id"] [data-patient="from"]').text()),
                    toId = parseInt($('[data-field="id"] [data-patient="to"]').text())
                ;

                if(!fromId || !toId){
                    return bootbox.alert('Missing patients\' IDs, please use search buttons to check patients\' availability first');
                }

                bootbox.confirm('Are you sure you want to merge patient (#'+fromId+') with patient (#'+toId +')?', function(result){
                    if(result){
                        showLoading();

                        var request = $.ajax({
                            url: laroute.route('admin.diagnose.mergePatientsSubmit', {fromPatient: fromId, toPatient: toId}),
                            method: "POST"
                        });

                        request
                            .error(function(error){
                                var message;
                                if(error.responseJSON
                                    && error.responseJSON.message
                                    && error.responseJSON.message.length){
                                    message = error.responseJSON.message;
                                } else {
                                    message = 'There\'s an error while merge these 2 patient records. Please check the log.';
                                }
                                bootbox.alert(message);
                            })
                            .done(function(response){
                                console.log('response', response);
                                bootbox.alert('The merging is completed.', function(){
                                    if(window.history.length > 1){
                                        window.history.back();
                                    } else {
                                        window.location.href = '/back-office/diagnoses/merge-patients'
                                    }

                                });
                            })
                            .always(function(){
                                hideLoading();
                            })
                        ;
                    }
                });
            })
            .on('click', '[data-action=search]', function(event){
                event.preventDefault();

                var $cell = $(this).closest('td'),
                    $input = $cell.find('input'),
                    id = parseInt($input.val()),
                    patientPosition = $cell.data('patient');
                ;

                if(id){
                    showLoading();

                    var request = $.ajax({
                        url: laroute.route('admin.patient.fetch', {patient: id}),
                        method: "POST",
                        dataType: "json"
                    });

                    request
                        .error(function(error){
                            var message;
                            if(error.responseJSON
                            && error.responseJSON.message
                            && error.responseJSON.message.length){
                                message = error.responseJSON.message;
                            } else {
                                message = 'Couldn\'t find patient with this ID in the system';
                            }
                            bootbox.alert(message);
                        })
                        .done(function(response){
                            //render id
                            $('[data-field="id"] [data-patient="'+patientPosition+'"]')
                                .html(response.id)
                            ;

                            //render name
                            $('[data-field="name"] [data-patient="'+patientPosition+'"]')
                                .html('<b>'+response.first_name+'</b> ' + response.last_name)
                            ;

                            //render date_of_birth
                            $('[data-field="date_of_birth"] [data-patient="'+patientPosition+'"]')
                                .html(moment(response.date_of_birth, 'YYYY-MM-DD HH:mm:ss').utcOffset(0).format('DD/MM/YYYY'))
                            ;

                            //render gender
                            $('[data-field="gender"] [data-patient="'+patientPosition+'"]')
                                .html(response.gender)
                            ;

                            //render email
                            $('[data-field="email"] [data-patient="'+patientPosition+'"]')
                                .html(response.email)
                            ;

                            //render phone_number
                            $('[data-field="phone_number"] [data-patient="'+patientPosition+'"]')
                                .html((response.phone_country_code?'(' + response.phone_country_code + ')':'') + ' '+response.phone_number)
                            ;

                            //render id_number
                            $('[data-field="id_number"] [data-patient="'+patientPosition+'"]')
                                .html(response.id_number)
                            ;

                            //render address
                            $('[data-field="address"] [data-patient="'+patientPosition+'"]')
                                .html(response.address)
                            ;

                            //render country
                            $('[data-field="country"] [data-patient="'+patientPosition+'"]')
                                .html((response.country?response.country.nice_name:''))
                            ;

                            //render address_zip
                            $('[data-field="address_zip"] [data-patient="'+patientPosition+'"]')
                                .html(response.address_zip)
                            ;

                            //render created_at
                            $('[data-field="created_at"] [data-patient="'+patientPosition+'"]')
                                .html(response.created_at)
                            ;

                        })
                        .always(function(){
                            hideLoading();
                        })
                }
            })
        ;
    })
</script>
@endpush
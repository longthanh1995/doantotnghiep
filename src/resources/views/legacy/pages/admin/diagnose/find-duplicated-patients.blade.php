@extends('legacy.layouts.admin.application')

@section('pageTitle', 'Find duplicated patients - System Diagnose')

@section('header', 'Find duplicated patients')

@section('subheader', ' ')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default" id="box_find_duplicated_patients">
                    <div class="box-body" id="box_find_duplicated_patients__menu">
                        <a href="#" class="btn btn-default" data-mode="NRIC">By National ID</a>
                        <a href="#" class="btn btn-default" data-mode="email">By email</a>
                        <a href="#" class="btn btn-default" data-mode="phoneNumber">By phone number</a>
                    </div>
                    <div class="box-body" id="box_find_duplicated_patients__results">
                    </div>
                </div>

                <div class="box box-primary hide" id="box_selected_patients">
                    <div class="box-header">
                        <h3 class="box-title">
                            Merge selected users
                        </h3>
                    </div>
                    <div class="box-body"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
$(function(){
    var duplicatedPatientsTemplate = multiline(function(){/*!@preserve
        <table class="table">
         {% for duplicatedValue, patients in results %}

         <thead>
         <tr>
         <th colspan="9">{% if duplicatedValue %}@{{ duplicatedValue }}{% else %}(empty){% endif %}</th>
         </tr>
         <tr>
         <th></th>
         <th>ID</th>
         <th>Name</th>
         <th>Date of Birth</th>
         <th>Gender</th>
         <th>Email</th>
         <th>Phone Number</th>
         <th>NRIC</th>
         <th></th>
         </tr>
         </thead>
         <tbody>
         {% for patient in patients %}
         <tr data-id="@{{ patient.id }}" data-first-name="@{{ patient.first_name }}" data-last-name="@{{ patient.last_name }}">
         <td><input type="checkbox"/></td>
         <td>#@{{ patient.id }}</td>
         <td><b>@{{patient.first_name}}</b> @{{patient.last_name}}</td>
         <td>@{{patient.date_of_birth|formatTimestamp1}}</td>
         <td>@{{patient.gender}}</td>
         <td>@{{patient.email}}</td>
         <td>@{{patient.phone_number}}</td>
         <td>@{{patient.id_number}}</td>
         <td>
         <a target="_blank" href="@{{patientUrlBase}}/@{{ patient.id }}" class="btn btn-xs btn-default" data-action="info">
         <i class="fa fa-info"></i> Info
         </a>
         </td>
         </tr>
         {% endfor %}
         </tbody>
         {% endfor %}
         </table>
         */console.log});

    var selectedIds = [];
    var $boxSelectedPatients = $('#box_selected_patients');
    var $selectedPatientsContainer = $boxSelectedPatients.children('.box-body');
    var selectedPatientsTemplate = multiline(function(){/*!@preserve
        {% if patients.length == 2 %}
         <table class="table">
         <thead>
         <tr>
         <th>To be removed</th>
         <th>To be kept</th>
         </tr>
         </thead>
         <tbody>
         <tr>
         {% for patient in patients %}
         <td>#@{{patient.id}} - <b>@{{patient.first_name}}</b> @{{patient.last_name}}</td>
         {% endfor %}
         <td>
         <a href="@{{mergePatientsUrlBase}}?from=@{{ patients[0].id }}&to=@{{ patients[1].id }}" class="btn btn-xs btn-default" data-action="info">
         <i class="fa fa-info"></i> Merge
         </a>
         <a href="#" class="btn btn-xs btn-default" data-action="swap">
         <i class="fa fa-exchange"></i> Swap
         </a>
         </td>
         </tr>
         </tbody>
         </table>
         </div>
         {% else %}

         {% endif %}
         */console.log});

    function renderSelectedPatients(){
        if(selectedIds.length !== 2){
            return $boxSelectedPatients.addClass('hide');
        }

        $boxSelectedPatients.removeClass('hide');

        var patients = [];
        _.each(selectedIds, function(selectedId){
            var $selectedRow = $('#box_find_duplicated_patients__results').find('tr[data-id="'+selectedId+'"]');
            patients.push({
                id: $selectedRow.data('id'),
                first_name: $selectedRow.data('first-name'),
                last_name: $selectedRow.data('last-name')
            })
        })
        var html = swig.render(selectedPatientsTemplate, {
            locals: {
                patients: patients,
                mergePatientsUrlBase: '/back-office/diagnoses/merge-patients'
            }
        });
        $selectedPatientsContainer.html(html);
    }

    $('#box_find_duplicated_patients__menu')
        .on('click', '[data-mode]',function(){
            var $this = $(this);
            var mode = $this.data('mode');

            if(!mode.length){
                return;
            }

            showLoading();

            var request = $.ajax({
                url: laroute.route('admin.diagnose.findDuplicatedPatients.fetch'),
                method: "POST",
                data: {
                    mode: mode
                },
                dataType: "json"
            });

            request
                .done(function(response){
                    if(_.isObject(response)){
                        var html = swig.render(duplicatedPatientsTemplate, {
                            locals: {
                                results: response,
                                patientUrlBase: '/back-office/patients'
                            }
                        });
                        $('#box_find_duplicated_patients__results').html(html);
                    }
                })
                .always(function(){
                    hideLoading();
                })
        })
    ;

    $('#box_find_duplicated_patients__results')
        .on('click', 'table tbody tr td input[type=checkbox]', function(event){
            var $this = $(this),
                $row = $this.closest('tr'),
                rowId = $row.data('id')
                ;

            if($this.prop('checked')){
                selectedIds.push(rowId);
            } else {
                selectedIds = _.without(selectedIds, rowId);
            };

            if(selectedIds.length < 2){
                $('#box_find_duplicated_patients__results').find('input:not(:checked)').prop('disabled', false);
            } else {
                $('#box_find_duplicated_patients__results').find('input:not(:checked)').prop('disabled', true);
            }

            renderSelectedPatients();
        })
    ;

    $('#box_selected_patients')
        .on('click', '[data-action=swap]', function(event){
            event.preventDefault();

            selectedIds.reverse();
            renderSelectedPatients();
        })
    ;
});
</script>
@endpush
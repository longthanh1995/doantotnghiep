@extends('legacy.layouts.admin.application')

@section('pageTitle', 'System Diagnose')

@section('header', 'Diagnoses')

@section('subheader', 'Some operations for maintaining system')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default">
                    <div class="box-body">
                        <table class="table" id="table_diagnosis">
                            <thead>
                            <tr>
                                <th>Operation</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <a href="{{route('admin.diagnose.findDuplicatedPatients')}}">Find patients with duplicated info</a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <a href="{{route('admin.diagnose.mergePatients')}}">Merge 2 patients into 1</a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <a href="{{route('admin.diagnose.findTimeslotsWithCancelledAppointment')}}">Re-activate doctor timeslots with cancelled appointment</a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <a href="{{route('admin.appointmentType')}}">Manage Appointment Types</a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <a href="{{route('admin.doctorTitle')}}">Manage Healthcare Providers' Titles</a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <a href="{{route('admin.language')}}">Manage Languages</a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <a href="{{route('admin.workCompany')}}">Manage Work Companies</a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <a href="{{route('admin.insuranceCompany')}}">Manage Insurance Companies</a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <a href="{{route('admin.consultReason')}}">Manage Predefined Consult Reasons</a>
                                </td>
                            </tr>

                            <tr>
                                <td><a href="{{route('admin.diagnose.findAppointmentsWithWrongUserId')}}">Find appointments with wrong user_id</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
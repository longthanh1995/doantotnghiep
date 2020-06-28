@extends('legacy.layouts.admin.application')

@section('pageTitle', 'Manage Doctors')

@section('bodyClass', 'page-doctors page-doctors-index')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Doctors</h3>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-hover" id="table_doctors">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Stars</th>
                            <th>Clinics</th>
                            <th>
                                {{--Actions--}}
                                {{--<a href="#" class="btn btn-xs btn-primary" id="table_doctors__button_add">--}}
                                    {{--<i class="fa fa-plus"></i> Add--}}
                                {{--</a>--}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($doctors as $doctor)
                            <tr data-id="{{$doctor->id}}" data-name="{{$doctor->name}}">
                                <td>{{$doctor->name}}</td>
                                <td>{{$doctor->gender}}</td>
                                <td>{{$doctor->date_of_birth?$doctor->date_of_birth->format('d-m-Y'):''}}</td>
                                <td>{{$doctor->email}}</td>
                                <td>
                                @if($doctor->phone_country_code)
                                    ({{$doctor->phone_country_code}})
                                @endif
                                    {{$doctor->phone_number}}
                                </td>
                                <td>{{$doctor->star}}</td>
                                <td>
                                    {{$doctor->clinics->count()?$doctor->clinics->count():0}}
                                </td>
                                <td>
                                    <a href="{{ route('admin.doctor.details', $doctor->id) }}" class="btn btn-xs btn-default" data-action="info">
                                        <i class="fa fa-info"></i> Info
                                    </a>
                                    {{--<a href="#" class="btn btn-xs btn-danger" data-action="remove">--}}
                                        {{--<i class="fa fa-times"></i> Remove--}}
                                    {{--</a>--}}
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop



@push('scripts')
<script type="text/javascript">
    $(function(){
        $('#table_doctors').DataTable();
    })
</script>
@endpush
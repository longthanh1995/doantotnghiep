@extends('legacy.layouts.admin.application')

@section('pageTitle', 'Manage Users')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Users</h3>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-hover" id="table_users">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>National ID</th>
                            <th>Linked?</th>
                            <th>
                                {{--Actions--}}
                                {{--<a href="#" class="btn btn-xs btn-primary" id="table_users__button_add">--}}
                                    {{--<i class="fa fa-plus"></i> Add--}}
                                {{--</a>--}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr data-id="{{$user->id}}" data-name="{{$user->getFullname()}}">
                                <td>
                                    {{$user->id}}
                                </td>
                                <td>
                                @if($user->profileImage)
                                    <img
                                        class="img-rounded"
                                        src="{{($user->profileImage)?$user->profileImage->getThumbnailUrl():$user->getDefaultAvatarUrl($user->gender)}}"
                                        alt="{{($user->profileImage)?$user->name:"No image"}}"
                                        style="height:20px;vertical-align:top;"
                                    />
                                @endif

                                    {{$user->getFullname()}}
                                </td>
                                <td>{{$user->gender}}</td>
                                <td>{{($user->date_of_birth)?\Carbon\Carbon::createFromFormat('Y-m-d', $user->date_of_birth)->format('d/m/Y'):''}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                @if($user->phone_country_code)
                                    ({{$user->phone_country_code}})
                                @endif
                                    {{$user->phone_number}}
                                </td>
                                <td>{{$user->national_id_number}}</td>
                                <td>
                                @if($user->patients->count() == 1)
                                    <i class="fa fa-check"></i>
                                @elseif($user->patients->count())
                                    <i class="fa fa-warning"></i> {{$user->patients->count()}}
                                @endif
                                </td>
                                <td>
                                    <a {{--href="{{ route('admin.user.details', $user->id) }}"--}} class="btn btn-xs btn-default" data-action="info">
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
        $('#table_users').DataTable();
    })
</script>
@endpush
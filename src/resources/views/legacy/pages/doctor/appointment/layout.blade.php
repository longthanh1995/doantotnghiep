@extends('legacy.layouts.doctor.appLayout')

@section('content')
    <div id="appointmentSection">
        @include('legacy.pages.doctor.appointment.partials.search')

        @yield('contentChild')
    </div>
@stop

@push('scripts')
    @include('legacy.pages.doctor.appointment.partials.javascript')
@endpush
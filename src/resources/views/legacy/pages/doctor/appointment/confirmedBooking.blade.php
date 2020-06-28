@extends('legacy.pages.doctor.appointment.layout')

@section('pageHeader')
    <h1>Confirmed Booking</h1>
@stop

@section('contentChild')
    @if (count($appointments) > 0)
        <div class="text-center">
            {!! $appointments->appends(\Request::except('page'))->render() !!}
        </div>

        <div class="list-appointments">
            @foreach ($appointments as $appointment)
                @include('legacy.pages.doctor.appointment.partials.appointments', [
                    'appointment' => $appointment,
                    'type' => 'confirmedBooking'
                ])
            @endforeach
        </div>

        <div class="text-center">
            {!! $appointments->appends(\Request::except('page'))->render() !!}
        </div>
    @else
        <div class="alert alert-warning" role="alert">
            <strong>Oh snap!</strong>

            There is no confirmed booking.
        </div>
    @endif
@stop
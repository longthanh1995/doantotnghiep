@extends('legacy.layouts.doctor.application')

@section('layoutContent')
    @include('legacy.layouts.doctor.partials.navbar')

    @include('legacy.layouts.doctor.partials.sidebar')

    <!-- Page content -->
    <div id="page-content-wrapper">
        @hasSection('pageHeader')
            <div class="page-header">
                <div class="container">
                    @yield('pageHeader')
                </div>
            </div>
        @endif

        <div class="page-content">
            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>

    @include('legacy.layouts.doctor.partials.footer')
@stop
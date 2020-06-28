@extends('legacy.layouts.doctor.appLayout')

@section('content')
    <div id="profileSection" class="{{ $childPage }}Page">
        <div class="row">
            <div class="col-md-3" id="profileSectionMenu">
                @include('legacy.pages.doctor.setting.partials.sidebar', ['sidebar' => $childPage])
            </div>

            <div class="col-md-9">
                @yield('childContent')
            </div>
        </div>
    </div>
@stop
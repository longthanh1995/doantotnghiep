<!doctype html>
<html lang="en">
    <head>
        <title>@yield('title', \Config::get('site.name', ''))</title>

        @include('legacy.layouts.doctor.metadata')

        @include('legacy.layouts.doctor.styles')

        @stack('styles')

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="{!! isset($bodyClasses) ? $bodyClasses : '' !!}">
        <div id="wrapper" class="@if (!$authDoctor) wrapper-non-logged @endif">
            @if( isset($noFrame) && $noFrame == true )
                @yield('layoutContent')
            @else
                @include('legacy.layouts.doctor.frame')
            @endif

            <div class="overlay loading hide"></div>
        </div>

        @stack('modals')

        @stack('scripts-template')

        @include('legacy.layouts.doctor.scripts')

        @stack('scripts')
    </body>
</html>
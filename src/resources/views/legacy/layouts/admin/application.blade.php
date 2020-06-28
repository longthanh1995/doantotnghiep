<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="theme-color" content="#4C6CC6" />

        <title>@yield('pageTitle', '') - Admin Dashboard - Mobile Health</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />

        @include('legacy.layouts.admin.metadata')

        @include('legacy.layouts.admin.styles')

        @stack('styles')

        <meta name="csrf-token" content="{!! csrf_token() !!}" />

        <style>
            html, body {
                padding: 0 !important;
            }
        </style>

        {!! Analytics::render() !!}
    </head>

    <body class="skin-blue sidebar-mini page-admin @yield('bodyClass', '')">
        @if( isset($noFrame) && $noFrame == true )
            @yield('content')
        @else
            @include('legacy.layouts.admin.frame')
        @endif

        @include('legacy.layouts.admin.scripts')

        @stack('scripts')
    </body>
</html>
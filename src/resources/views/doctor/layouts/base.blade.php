<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#4C6CC6" />

    <title>@yield('pageTitle', '') - Doctor Dashboard - Mobile Health</title>

    <meta name="csrf-token" content="{!! csrf_token() !!}" />

    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.ico') }}"/>
    <link rel="stylesheet" href="{{ elixir('main.css') }}" />

    @stack('customStyles')

    {!! Analytics::render() !!}
</head>
<body class="skin-blue sidebar-mini @yield('bodyClass', '')">
    <div class="wrapper">
        @include('doctor.layouts.partials.header')

        @include('doctor.layouts.partials.sidebar')

        <div class="content-wrapper">
            <section class="content-header text-center">
                <h3>@yield('contentHeader')</h3>
                @yield('breadcrumb')
            </section>

            <section class="content">
                @include('flash::message')

                @yield('content')
            </section>
        </div>

        @include('doctor.layouts.partials.footer')
    </div>

    <div id="overlay_loading" class="hide"></div>

    <script type="text/javascript" src="{{ asset('dist/js-laroute/laroute.js') }}"></script>
    <script type="text/javascript" src="{{ elixir('vendors.js') }}"></script>

    <script type="text/javascript">
        var globalData = {
            configuration: {},
            doctor: {
                name: '{{$authDoctor->name}}',
                title: '{{$authDoctor->title ? $authDoctor->title->title : ''}}'
            },
            context: {
                dashboardType: 'doctor'
            }
        };
    </script>
    @stack('dataScripts')

    <script type="text/javascript" src="{{ elixir('main.js') }}"></script>

    @stack('customScripts')

    @stack('modals')
</body>
</html>
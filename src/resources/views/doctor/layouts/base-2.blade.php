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

    {!! Analytics::render() !!}
</head>
<body class="@yield('bodyClass', '')">
    <div class="wrapper">
        @yield('content')
    </div>

    <script type="text/javascript" src="{{ elixir('vendors.js') }}"></script>
    <script type="text/javascript">
        var globalData = {
            configuration: {},
            context: {
                dashboardType: 'doctor'
            }
        };
    </script>
    @stack('dataScripts')
    <script type="text/javascript" src="{{ elixir('main.js') }}"></script>
    @stack('customScripts')
</body>
</html>
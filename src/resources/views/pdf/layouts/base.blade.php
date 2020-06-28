<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('pageTitle', '') - Mobile Health</title>

    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.ico') }}"/>
    {{--<link rel="stylesheet" href="{{ elixir('main.css') }}" />--}}

    <style>
        body{
            font-family: 'Arial';
        }
    </style>

    @stack('customStyles')
</head>
<body>
    <div class="wrapper">
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>
</body>
</html>
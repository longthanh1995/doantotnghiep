<div class="wrapper">
    @include('legacy.layouts.admin.partials.header')
    @include('legacy.layouts.admin.partials.side_menu')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('header', 'Dashboard')

                <small>@yield('subheader', 'Dashboard')</small>
            </h1>

            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('admin.home') }}">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </li>

                @stack('breadcrumbs')
            </ol>
        </section>

        <section class="content">
            @include('flash::message')

            @yield('content')
        </section>
        <div class="overlay loading hide" id="overlay_loading"></div>
    </div>

    @include('legacy.layouts.admin.partials.footer')
{{--    @include('legacy.layouts.admin.partials.control_side_bar')--}}
</div>
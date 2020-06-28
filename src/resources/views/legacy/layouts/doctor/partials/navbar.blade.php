@if ($authDoctor)
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <div class="navbar-brand">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('build/dist/images/logo.png') }}" width="86" height="37"/>
                    </a>
                </div>

                <div class="navbar-custom-toggle">
                    <a id="menu-toggle" href="#" class="btn-menu toggle">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
            </div>

            <ul class="nav navbar-nav navbar-right navbar-custom-menu hidden-sm hidden-xs">
                {{--<li class="navbar-custom-menu-notification">--}}
                    {{--<a href="#">--}}
                        {{--<i class="fa fa-fw fa-bell-o"></i>--}}
                    {{--</a>--}}
                {{--</li>--}}

                <li class="navbar-custom-menu-doctor">
                    <a href="{{ route('profile.index') }}">
                        {{ $authDoctor->name }}
                    </a>
                </li>

                <li class="navbar-custom-menu-divider"></li>

                <li class="navbar-custom-menu-link">
                    <a href="{{ route('doctor.signOut') }}">
                        Sign Out
                    </a>
                </li>
            </ul>
        </div>
    </nav>
@else
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <div class="navbar-brand">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('build/dist/images/logo.png') }}" width="86" height="37"/>
                    </a>
                </div>
            </div>
        </div>
    </nav>
@endif
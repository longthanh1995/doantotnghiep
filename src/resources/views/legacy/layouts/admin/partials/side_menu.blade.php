<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">HEADER</li>

            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard"></i>

                    <span>Dashboard</span>
                </a>
            </li>

        @if(array_key_exists('admin.invitation.*', $authAdminUserAbilities['permissions']) && $authAdminUserAbilities['permissions']['admin.invitation.*'])
            <li>
                <a href={{ route('admin.invitation') }}>
                    <i class="fa fa-envelope"></i>
                    <span>Manage invitations</span>
                </a>
            </li>
        @endif

        @if(array_key_exists('admin.clinic.*', $authAdminUserAbilities['permissions']) && $authAdminUserAbilities['permissions']['admin.clinic.*'])
            <li>
                <a href={{ route('admin.clinic') }}>
                    <i class="fa fa-building"></i>
                    <span>Manage clinics</span>
                </a>
            </li>
        @endif

        @if(array_key_exists('admin.doctor.*', $authAdminUserAbilities['permissions']) && $authAdminUserAbilities['permissions']['admin.doctor.*'])
            <li>
                <a href={{ route('admin.doctor') }}>
                    <i class="fa fa-user-md"></i>
                    <span>Manage doctors</span>
                </a>
            </li>
        @endif

        @if(array_key_exists('admin.doctor.*', $authAdminUserAbilities['permissions']) && $authAdminUserAbilities['permissions']['admin.doctor.*'])
            <li>
                <a href={{ route('admin.doctor.unverified') }}>
                    <i class="fa fa-user-md"></i>
                    <span>Unverified Providers List</span>
                </a>
            </li>
        @endif

        @if(array_key_exists('admin.patient.*', $authAdminUserAbilities['permissions']) && $authAdminUserAbilities['permissions']['admin.patient.*'])
            <li>
                <a href={{ route('admin.patient') }}>
                    <i class="fa fa-file-text"></i>
                    <span>Manage patients</span>
                </a>
            </li>
        @endif

        {{--@if(array_key_exists('admin.user.*', $authAdminUserAbilities['permissions']) && $authAdminUserAbilities['permissions']['admin.user.*'])--}}
            {{--<li>--}}
                {{--<a href={{ route('admin.user') }}>--}}
                    {{--<i class="fa fa-users"></i>--}}
                    {{--<span>Manage users</span>--}}
                {{--</a>--}}
            {{--</li>--}}
        {{--@endif--}}

        <li>
            <a href={{ route('admin.appointment') }}>
                <i class="fa fa-calendar"></i>
                <span>Manage appointments</span>
            </a>
        </li>

        @if(array_key_exists('admin.broadcast.*', $authAdminUserAbilities['permissions']) && $authAdminUserAbilities['permissions']['admin.broadcast.*'])
            <li>
                <a href={{ route('admin.broadcast.index') }}>
                    <i class="fa fa-calendar"></i>
                    <span>Manage broadcast articles</span>
                </a>
            </li>
        @endif

        @if(array_key_exists('admin.cme.*', $authAdminUserAbilities['permissions']) && $authAdminUserAbilities['permissions']['admin.cme.*'])
            <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bookmark"></i>
                        <span>CME</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('admin.cme.events.index') }}">
                                <i class="fa fa-calendar"></i>
                                <span>Manage Events</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.cme.organizers.index')}}">
                                <i class="fa fa-group"></i>
                                <span>Manage Organizers</span>
                            </a>
                        </li>
                    </ul>
                </li>
        @endif

        @if(array_key_exists('admin.diagnose.*', $authAdminUserAbilities['permissions']) && $authAdminUserAbilities['permissions']['admin.diagnose.*'])
            <li>
                <a href={{ route('admin.diagnose') }}>
                    <i class="fa fa-cogs"></i>
                    <span>System diagnoses</span>
                </a>
            </li>
        @endif

            <!-- %%SIDEMENU%% -->
        </ul>
    </section>
</aside>
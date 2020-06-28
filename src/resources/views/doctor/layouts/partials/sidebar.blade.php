<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                @if ($authDoctor->profileImage)
                    <img src="{{ $authDoctor->profileImage->getThumbnailUrl() }}" class="img-circle" height="100"/>
                @else
                    <img src="{{ $authDoctor->getDefaultAvatarUrl($authDoctor->gender) }}" class="img-circle" width="100"/>
                @endif
            </div>
            <div class="pull-left info">
                <p>{{$authDoctor->name}}</p>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li><a href="/"><i class="fa fa-dashboard"></i> <span>Home</span></a></li>
            <li class="
                treeview
            @if (isset($sidebarCurrentView) && ($sidebarCurrentView == 'appointment.confirmedBooking' || $sidebarCurrentView == 'appointment.visitedBooking' || $sidebarCurrentView == 'appointment.cancelledBooking' || $sidebarCurrentView == 'appointment.notShowingUpBooking'))
                active
            @endif
            ">
                <a href="#">
                    <i class="fa fa-medkit"></i> <span>Appointments</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li
                        @if (isset($sidebarCurrentView) && $sidebarCurrentView == 'appointment.confirmedBooking')
                        class="active"
                        @endif
                    >
                        <a href="{{ route('appointment.confirmedBooking') }}">
                            <i class="fa fa-circle-o text-blue"></i> <span>Confirmed</span>
                        </a>
                    </li>
                    <li
                        @if (isset($sidebarCurrentView) && $sidebarCurrentView == 'appointment.visitedBooking')
                        class="active"
                        @endif
                    >
                        <a href="{{ route('appointment.visitedBooking') }}">
                            <i class="fa fa-circle-o text-green"></i> <span>Visited</span>
                        </a>
                    </li>
                    <li
                        @if (isset($sidebarCurrentView) && $sidebarCurrentView == 'appointment.notShowingUpBooking')
                        class="active"
                        @endif
                    >
                        <a href="{{ route('appointment.notShowingUpBooking') }}">
                            <i class="fa fa-circle-o text-teal"></i> <span>Not Showing Up</span>
                        </a>
                    </li>
                    <li
                        @if (isset($sidebarCurrentView) && $sidebarCurrentView == 'appointment.LateBooking')
                        class="active"
                        @endif
                    >
                        <a href="{{ route('appointment.lateBooking') }}">
                            <i class="fa fa-circle-o text-teal"></i> <span>Late</span>
                        </a>
                    </li>
                    <li
                        @if (isset($sidebarCurrentView) && $sidebarCurrentView == 'appointment.cancelledBooking')
                        class="active"
                        @endif
                    >
                        <a href="{{ route('appointment.cancelledBooking') }}">
                            <i class="fa fa-circle-o text-red"></i> <span>Cancelled</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="
            @if (isset($sidebarCurrentView) && $sidebarCurrentView == 'calendar.index')
                active
            @endif
                ">
                <a href="{{ route('working-calendar.index') }}"><i class="fa fa-calendar"></i> <span>Working Calendar</span></a>
            </li>
            <li class="
            @if (isset($sidebarCurrentView) && $sidebarCurrentView == 'doctor.patient.index')
                active
            @endif
                ">
                <a href="{{ route('doctor.patient.index') }}"><i class="fa fa-users"></i> <span>Patients</span></a>
            </li>
            <li class="
                treeview
            @if (isset($sidebarCurrentView) && ($sidebarCurrentView == 'profile.index' || $sidebarCurrentView == 'setting.index'))
                active
            @endif
            ">
                <a href="#">
                    <i class="fa fa-user"></i> <span>Profile</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li
                    @if (isset($sidebarCurrentView) && $sidebarCurrentView == 'profile.index')
                        class="active"
                    @endif
                    >
                        <a href="{{ route('profile.index') }}"><i class="fa fa-edit"></i> <span>My Profile</span></a>
                    </li>
                    <li
                    @if (isset($sidebarCurrentView) && $sidebarCurrentView == 'setting.index')
                        class="active"
                    @endif
                    >
                        <a href="{{ route('setting.index') }}"><i class="fa fa-cog"></i> <span>Settings</span></a>
                    </li>
                </ul>
            </li>
            <li><a href="{{ route('doctor.signOut') }}"><i class="fa fa-sign-out"></i> <span>Sign out</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
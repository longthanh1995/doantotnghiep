<!-- Sidebar -->
<div id="sidebar-wrapper">
    <div class="welcome-user">
        <div class="welcome-user-avatar">
            <a href="{{ route('profile.avatar') }}">
                @if ($authDoctor->profileImage)
                    <img src="{{ $authDoctor->profileImage->getThumbnailUrl() }}" class="img-circle" width="100" height="100"/>
                @else
                    <img src="{{ \App\Models\Doctor::getDefaultAvatarUrl($authDoctor->gender) }}" class="img-circle" width="100" height="100"/>
                @endif
            </a>
        </div>

        <p>
            Welcome,
        </p>

        <p>
            <b>{{ $authDoctor->name }}</b>
        </p>
    </div>

    <div class="sidebar-menus">
        <div class="sidebar-list-menus">
            <div class="sidebar-list-menus-heading">
                APPOINTMENT
            </div>

            <ul>
                <li @if (isset($sidebarCurrentView) && $sidebarCurrentView == 'appointment.confirmedBooking') class="active" @endif>
                    <a href="{{ route('appointment.confirmedBooking') }}">
                        <i class="fa fa-fw fa-medkit"></i> &nbsp; Confirmed Booking
                    </a>
                </li>

                <li @if (isset($sidebarCurrentView) && $sidebarCurrentView == 'appointment.visitedBooking') class="active" @endif>
                    <a href="{{ route('appointment.visitedBooking') }}">
                        <i class="fa fa-fw fa-database"></i> &nbsp; Visited Booking
                    </a>
                </li>

                <li @if (isset($sidebarCurrentView) && $sidebarCurrentView == 'appointment.cancelledBooking') class="active" @endif>
                    <a href="{{ route('appointment.cancelledBooking') }}">
                        <i class="fa fa-fw fa-recycle"></i> &nbsp; Cancelled Booking
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-list-menus">
            <div class="sidebar-list-menus-heading">
                PROFILE
            </div>

            <ul>
                <li @if (isset($sidebarCurrentView) && $sidebarCurrentView == 'profile.index') class="active" @endif>
                    <a href="{{ route('profile.index') }}">
                        <i class="fa fa-fw fa-user"></i> &nbsp; My Profile
                    </a>
                </li>

                <li @if (isset($sidebarCurrentView) && $sidebarCurrentView == 'calendar.index') class="active" @endif>
                    <a href="{{ route('calendar.index') }}">
                        <i class="fa fa-fw fa-calendar"></i> &nbsp; Working Calendar
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-list-menus">
            <div class="sidebar-list-menus-heading">
                SETTINGS
            </div>

            <ul>
                <li @if (isset($sidebarCurrentView) && $sidebarCurrentView == 'setting.index') class="active" @endif>
                    <a href="{{ route('setting.index') }}">
                        <i class="fa fa-fw fa-wrench"></i> &nbsp; Settings
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-list-menus">
            <div class="sidebar-list-menus-heading">
                SIGN OUT
            </div>

            <ul>
                <li>
                    <a href="{{ route('doctor.signOut') }}">
                        <i class="fa fa-fw fa-sign-out"></i> &nbsp; Sign Out
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
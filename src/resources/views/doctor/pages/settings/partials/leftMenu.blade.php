<div class="box box-solid">
    <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
            <li
                @if($currentPage == 'appointmentTypes')
                class="active"
                @endif
            >
                <a
                    @if($currentPage != 'appointmentTypes')
                    href="{{route('setting.index')}}"
                    @endif
                >
                    <i class="fa fa-bar-chart"></i> Appointment Types
                </a>
            </li>
            <li
                    @if($currentPage == 'time')
                    class="active"
                    @endif
            >
                <a
                        @if($currentPage != 'time')
                        href="{{route('setting.time')}}"
                        @endif
                >
                    <i class="fa fa-clock"></i> Time
                </a>
            </li>
            <li
                    @if($currentPage == 'teleconsults')
                    class="active"
                    @endif
            >
                <a
                        @if($currentPage != 'teleconsults')
                        href="{{route('setting.teleconsults')}}"
                        @endif
                >
                    <i class="fa fa-clock"></i> Tele-consults
                </a>
            </li>
        </ul>
    </div>
</div>
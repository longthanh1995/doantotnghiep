<div class="box box-solid">
    <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
            <li
            @if($currentPage == 'basicInformation')
                class="active"
            @endif
            >
                <a
                    @if($currentPage != 'basicInformation')
                        href="{{route('profile.basicInformation')}}"
                    @endif
                >
                    <i class="fa fa-info-circle"></i> Basic information
                </a>
            </li>
            <li
            @if($currentPage == 'qualifications')
                class="active"
            @endif
            >
                <a
                    @if($currentPage != 'qualifications')
                        href="{{route('profile.qualifications')}}"
                    @endif
                >
                    <i class="fa fa-rocket"></i> Qualifications
                </a>
            </li>
            <li
            @if($currentPage == 'professionalWorking')
                class="active"
            @endif
            >
                <a
                    @if($currentPage != 'professionalWorking')
                        href="{{route('profile.professionalWorking')}}"
                    @endif
                >
                    <i class="fa fa-hospital-o"></i> Professional Working
                </a>
            </li>
        </ul>
    </div>
</div>
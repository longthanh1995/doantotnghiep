@extends('legacy.layouts.doctor.appLayout')

@section('content')
    <div id="profileSection" class="{{ $childPage }}Page">
        <div class="row">
            <div class="col-md-3" id="profileSectionMenu">
                @include('legacy.pages.doctor.profile.partials.sidebar', ['sidebar' => $childPage])
            </div>

            <div class="col-md-9">
                @yield('childContent')
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            resizeProfileSidebar();

            $(".btn-trigger-edit").on('click', function (e) {
                e.preventDefault();

                var form = $(this).data('form');

                openEditForm(form);
            });

            $(".btn-form-cancel").on('click', function (e) {
                e.preventDefault();

                window.location.reload();
            });
        });

        $(window).on('resize', function () {
            resizeProfileSidebar();
        });

        var openEditForm = function (form) {
            form = $("#" + form);
            form.find('.hide').removeClass('hide').addClass('mndr-hide');
            form.find('.form-control-static, .mndr-show').addClass('hide').removeClass('mndr-hide');

            resizeProfileSidebar();
        };

        var resizeProfileSidebar = function () {
            if ($(window).width() > 1024) {
                var minHeight = $(window).height() - $(".navbar").height() - $(".page-header").height();
                var setHeight = Math.max($("#profileSection").height(), minHeight);

                $("#profileSectionMenu").height(setHeight);
            } else {
                $("#profileSectionMenu").height('auto');
            }
        };
    </script>
@endpush
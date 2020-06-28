<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

{{--<script src="{!! asset('static/admin/libs/plugins/jQuery/jQuery-2.1.4.min.js') !!}"></script>--}}
{{--<script src="{!! asset('static/admin/libs/bootstrap/js/bootstrap.min.js') !!}"></script>--}}
{{--<script src="{!! asset('static/admin/libs/plugins/iCheck/icheck.min.js') !!}"></script>--}}
{{--<script src="{!! asset('static/admin/libs/plugins/jquery-validation/dist/jquery.validate.min.js') !!}"></script>--}}
{{--<script src="{!! asset('static/admin/libs/adminlte/js/app.min.js') !!}"></script>--}}

<script type="text/javascript" src="{{ asset('dist/js-laroute/laroute.js') }}"></script>
<script type="text/javascript" src="{{ elixir('vendors.js') }}"></script>

<script type="text/javascript">
    var globalData = {
        configuration: {},
        context: {
            dashboardType: 'admin'
        }
    };
</script>
@stack('dataScripts')

<script type="text/javascript" src="{{ elixir('main.js') }}"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script>
    function showLoading(){
        $('.overlay.loading').removeClass('hide');
    }

    function hideLoading(){
        $('.overlay.loading').addClass('hide');
    }
</script>

@stack('customScripts')

@stack('modals')
<!-- jQuery CDN -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>

<!-- Bootstrap CDN -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<!-- App js -->
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

<script type="text/javascript" src="{{ asset('dist/js-laroute/laroute.js') }}"></script>
{{--<script type="text/javascript" src="{{ elixir('dist/js/app.js') }}"></script>--}}
<script type="text/javascript" src="{{ elixir('main.js') }}"></script>
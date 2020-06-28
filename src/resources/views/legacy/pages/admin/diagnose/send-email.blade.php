@extends('legacy.layouts.admin.application')

@section('pageTitle', 'Send email - System Diagnose')

@section('header', 'Send email')

@section('subheader', 'Merge 2 specific patients  into 1')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default" id="box_send_email">
                    <div class="box-body">
                        <form action="" class="form" id="form_send_email">
                            <div class="form-group">
                                <label for="form_send_email__input_to" class="control-label">To:</label>
                                <input type="text" name="to" id="form_send_email__input_to" class="form-control" placeholder="Required"/>
                            </div>
                            <div class="form-group">
                                <label for="form_send_email__textarea_content">Message:</label>
                                <textarea name="content" id="form_send_email__textarea_Message" class="form-control" placeholder="Required"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="#" class="btn btn-primary" data-action="send">Send</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function(){
        var $box = $('#box_send_email'),
            $form = $('#form_send_email')
        ;

        $form
            .on('submit', )

        $box
            .on('click', function(event){
                event.preventDefault();
                $form.submit();
            })
        ;
    });
</script>
@endpush
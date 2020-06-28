/**
 * @module modulequalifications
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function (sandbox) {
    let _this = this;

    _this.bindEvents = () => {
        _this.objects.$container
            .on('click', '[data-action=add]', (event) => {
                event.preventDefault();

                let $modal = bootbox.dialog({
                    title: 'Add new Qualification Record',
                    message: swig.render(_this.templates.modalAddQualificationMessage, {
                        locals: {
                            _token: $('[name="csrf-token"]').attr('content'),
                        }
                    }),
                    className: 'modal-add-qualification'
                });
            })
            .on('click', '[data-action=edit]', function (event) {
                event.preventDefault();

                let $row = $(this).closest('tr'),
                    id = $row.data('id'),
                    name = $row.data('name'),
                    issuer = $row.data('issuer'),
                    issuedTime = $row.data('issued-time')
                    ;

                let $modal = bootbox.dialog({
                    title: 'Edit Qualification Record',
                    message: swig.render(_this.templates.modalEditQualificationMessage, {
                        locals: {
                            _token: $('[name="csrf-token"]').attr('content'),
                            id,
                            name,
                            issuer,
                            issuedTime
                        }
                    }),
                    className: 'modal-edit-qualification'
                });
            })
            .on('click', '[data-action=delete]', function (event) {
                event.preventDefault();

                let $row = $(this).closest('tr'),
                    $formDelete = $row.find('form')
                    ;

                bootbox.confirm('Are you sure to delete this record?', (result) => {
                    if (result) {
                        $formDelete.submit();
                    }
                });
            })
            ;
    }

    _this.init = (data) => {
        _this.data = data || {};

        _this.objects = {};
        _this.objects.$container = $('#box_qualifications');

        _this.templates = {};
        _this.templates.modalAddQualificationMessage = multiline(() => {/*!@preserve
        <form class="form-horizontal" id="form_add_qualification" action="/profile/qualifications" method="POST">
            <input type="hidden" name="_token" value="{{_token}}"/>
            <div class="form-group">
                <label class="control-label col-sm-3" for="form_add_qualification__input_name">Name</label>
                <div class="col-md-9">
                    <input class="form-control" id="form_add_qualification__input_name" name="name"/>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3" for="form_add_qualification__input_issuer">Issuer</label>
                <div class="col-md-9">
                    <input class="form-control" id="form_add_qualification__input_issuer" name="issuer"/>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3" for="form_add_qualification__input_issued_time">Issued Year</label>
                <div class="col-md-9">
                    <input class="form-control" type="number" id="form_add_qualification__input_issued_time" name="issued_time"/>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
        */console.log
        });
        _this.templates.modalEditQualificationMessage = multiline(() => {/*!@preserve
        <form class="form-horizontal" id="form_edit_qualification" action="/profile/qualifications/{{id}}" method="POST">
            <input type="hidden" name="_token" value="{{_token}}"/>
            <div class="form-group">
                <label class="control-label col-sm-3" for="form_add_qualification__input_name">Name</label>
                <div class="col-md-9">
                    <input class="form-control" id="form_add_qualification__input_name" name="name" value="{{name}}"/>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3" for="form_add_qualification__input_issuer">Issuer</label>
                <div class="col-md-9">
                    <input class="form-control" id="form_add_qualification__input_issuer" name="issuer" value="{{issuer}}"/>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3" for="form_add_qualification__input_issued_time">Issued Time</label>
                <div class="col-md-9">
                    <input class="form-control" type="number" id="form_add_qualification__input_issued_time" name="issued_time" value="{{issuedTime}}"/>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
        */console.log
        });

        $('#form_add_qualification__input_issued_time').datepicker({
            minViewMode: 2,
            format: 'yyyy'
        });
        _this.bindEvents();
    }

    _this.destroy = () => { }

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
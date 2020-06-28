/**
 * @module moduleColleges
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox){
    let _this = this;

    _this.bindEvents = () => {
        _this.objects.$container
            .on('click', '[data-action=add]', (event) => {
                event.preventDefault();

                let $modal = bootbox.dialog({
                    title: 'Add new College Record',
                    message: swig.render(_this.templates.modalAddCollegeMessage, {
                        locals: {
                            _token: $('[name="csrf-token"]').attr('content'),
                        }
                    }),
                    className: 'modal-add-college'
                });

                $modal
                    .on('shown.bs.modal', (event) => {
                        $modal.find('#form_add_college__input_date_of_graduation')
                            .datepicker(_this.data.datePickerConfig)
                        ;
                    })
                ;
            })
            .on('click', '[data-action=edit]', function(event){
                event.preventDefault();

                let $row = $(this).closest('tr'),
                    id = $row.data('id'),
                    name = $row.data('name'),
                    dateOfGraduation = $row.data('date-of-graduation')
                ;

                let $modal = bootbox.dialog({
                    title: 'Edit College Record',
                    message: swig.render(_this.templates.modalEditCollegeMessage, {
                        locals: {
                            _token: $('[name="csrf-token"]').attr('content'),
                            id,
                            name,
                            dateOfGraduation
                        }
                    }),
                    className: 'modal-edit-college'
                });

                $modal
                    .on('shown.bs.modal', (event) => {
                        $modal.find('#form_edit_college__input_date_of_graduation')
                            .datepicker(_this.data.datePickerConfig)
                        ;
                    })
                ;
            })
            .on('click', '[data-action=delete]', function(event){
                event.preventDefault();

                let $row = $(this).closest('tr'),
                    $formDelete = $row.find('form')
                ;

                bootbox.confirm('Are you sure to delete this record?', (result) => {
                    if(result){
                        $formDelete.submit();
                    }
                });
            })
        ;
    }

    _this.init = (data) => {
        _this.data = data || {};
        _this.data.datePickerConfig = {
            format: 'dd/mm/yyyy',
            weekStart: 1,
            minViewMode: "month",
            maxViewMode: "years",
            orientation: "bottom",
            disableTouchKeyboard: true,
            autoclose: true,
            defaultViewDate: {
                year: 2010,
                month: 0,
                day: 1
            },
            startView: "years",
            startDate: "01/01/1930",
            clearBtn: true
        }

        _this.objects = {};
        _this.objects.$container = $('#box_colleges');

        _this.templates = {};
        _this.templates.modalAddCollegeMessage = multiline(()=>{/*!@preserve
        <form class="form-horizontal" id="form_add_college" action="/profile/qualifications/college" method="POST">
            <input type="hidden" name="_token" value="{{_token}}"/>
            <div class="form-group">
                <label class="control-label col-sm-3" for="form_add_college__input_name">School Name</label>
                <div class="col-md-9">
                    <input class="form-control" id="form_add_college__input_name" name="name"/>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3" for="form_add_college__input_date_of_graduation">Date of Graduation</label>
                <div class="col-md-9">
                    <input class="form-control" id="form_add_college__input_date_of_graduation" name="date_of_graduation" placeholder="Click to pick a date"/>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
        */console.log});
        _this.templates.modalEditCollegeMessage = multiline(()=>{/*!@preserve
        <form class="form-horizontal" id="form_edit_college" action="/profile/qualifications/college/{{id}}" method="POST">
            <input type="hidden" name="_token" value="{{_token}}"/>
            <div class="form-group">
                <label class="control-label col-sm-3" for="form_edit_college__input_name">School Name</label>
                <div class="col-md-9">
                    <input class="form-control" id="form_edit_college__input_name" name="name" value="{{name}}"/>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3" for="form_edit_college__input_date_of_graduation">Date of Graduation</label>
                <div class="col-md-9">
                    <input class="form-control" id="form_edit_college__input_date_of_graduation" name="date_of_graduation" placeholder="Click to pick a date" value="{{dateOfGraduation}}"/>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
        */console.log});

        _this.bindEvents();
    }

    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
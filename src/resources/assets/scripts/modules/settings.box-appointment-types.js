/**
 * @module moduleSettingsAppointmentTypes
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox){
    let _this = this;

    _this.handleFormToggle = () => {
        _this.objects.$container
            .on('click', '[data-action=edit]', (event) => {
                event.preventDefault();

                _this.objects.$form.toggleClass('editing');
                _this.objects.$form.trigger('reset');
            })
            .on('click', '[data-action=add]', (event) => {
                event.preventDefault();

                let template = multiline(() => {/*!@preserve
                    Hello
                */console.log})
            })
        ;
    }

    _this.handleFormEvents = () => {
        _this.objects.$form
            .on('click', '[data-action=delete]', function(event) {
                event.preventDefault();

                let $this = $(this);

                bootbox.confirm("Are you sure?", function(result) {
                    console.log(result);
                    if (result) {
                        $this
                            .closest('tr').addClass('hide')
                            .find('select').val('0')
                        ;
                    }
                });
            })
            .on('click', '[data-action=add]', function(event){
                event.preventDefault();

                let id = _this.objects.$formRowAddSelectAppointmentType.val(),
                    name = _this.objects.$formRowAddSelectAppointmentType.find(':selected').text(),
                    duration = _this.objects.$formRowAddSelectDuration.val()
                ;

                if(!parseInt(id) || !parseInt(duration)){
                    return false;
                }

                let durationOptionsHtml = _this.objects.$formRowAddSelectDuration.html(),
                    template = multiline(()=>{/*!@preserve
                    <tr data-id="{{appointmentType.id}}">
                        <td>
                            <input type="hidden" name="appointment_type_id[]" value="{{appointmentType.id}}"/>
                            <div class="text-right" style="padding-top:7px">
                                {{appointmentType.name}}
                            </div>
                        </td>
                        <td>
                            <div class="form-control-static">
                                {{appointmentType.duration}} minutes
                            </div>
                            <select class="form-control" name="appointment_type_duration[]" value="{{appointmentType.duration}}">
                                {{durationOptionsHtml|safe}}
                            </select>
                        </td>
                        <td>
                            <a class="btn btn-danger" data-action="delete">
                                <i class="fa fa-times"></i>
                                Delete
                            </a>
                        </td>
                    </tr>
                    */console.log}),
                    html = swig.render(template, {
                        locals: {
                            appointmentType: {
                                id: id,
                                name: name,
                                duration: duration
                            },
                            durationOptionsHtml: durationOptionsHtml
                        }
                    })
                ;

                let $html = $(html);
                $html.find('[name="appointment_type_duration[]"]').val(duration);

                $html.insertBefore(_this.objects.$formRowAdd);

                //reset add form
                _this.objects.$formRowAddSelectAppointmentType.val('0').trigger('chosen:updated');
                _this.objects.$formRowAddSelectDuration.val('0').trigger('chosen:updated');
            })
        ;
    }

    _this.renderRowAddNew = () => {
        _this.objects.$formRowAddSelectAppointmentType
            .chosen({
                width: '100%'
            })
        ;

        _this.objects.$formRowAddSelectDuration
            .chosen({
                width: '100%'
            })
        ;
    }

    _this.render = () => {
        _this.renderRowAddNew();
    }

    _this.bindEvents = () => {
        _this.handleFormToggle();
        _this.handleFormEvents();
    }

    _this.init = (data) => {
        _this.objects = {};
        _this.objects.$container = $('#box_appointment_types');
        _this.objects.$form = $('#form_appointment_types');
        _this.objects.$formRowAdd = $('#form_appointment_types__row_add');
        _this.objects.$formRowAddSelectAppointmentType = $('#form_appointment_types__row_add__select_appointment_type');
        _this.objects.$formRowAddSelectDuration = $('#form_appointment_types__row_add__select_duration');

        _this.render();
        _this.bindEvents();
    }

    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
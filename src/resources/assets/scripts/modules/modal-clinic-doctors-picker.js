/**
 * @module modalClinicDoctorsPicker
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @memberOf modalClinicDoctorsPicker
     * @function fetchDoctors
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.fetchDoctors = ({clinicId, excludeIds, doneCallback, failCallback}) => {
        sandbox.emit('window/loading/show');
        sandbox.emit('service/adminDoctor/list', {
            data: {
                clinic_id: clinicId,
                exclude_ids: excludeIds,
            },
            doneCallback: response => {
                sandbox.emit('window/loading/hide');
                if('function' === typeof doneCallback){
                    doneCallback(response);
                }
            },
            failCallback: (e, data) => {
                sandbox.emit('window/loading/hide');
                if('function' === typeof failCallback){
                    failCallback(e, data);
                }
            },
        });
    };

    /**
     * @memberOf modalClinicDoctorsPicker
     * @function showModal
     * @param doctors
     * @param doneCallback
     * @param failCallback
     */
    _this.showModal = ({doctors, doneCallback, failCallback}) => {
        let $modal = bootbox.dialog({
            title: `Add doctors`,
            message: swig.render(_this.templates.modalContent, {
                locals: {
                    doctors,
                }
            }),
            buttons: {
                'reset': {
                    label: 'Reset',
                    className: 'btn',
                    callback: (event) => {
                        var $form = $(event.delegateTarget).find('form');
                        $form.validate().resetForm();
                        $form[0].reset();
                        return false;
                    }
                },
                'submit': {
                    label: 'Add',
                    className: 'btn btn-primary',
                    callback: (event) => {
                        let $form = $(event.delegateTarget).find('form'),
                            $selectedRows = $form.find('[type=checkbox]:checked').closest('tr'),
                            $selectedDoctors = []
                        ;
                        $selectedRows.each(function(){
                            let $this = $(this);
                            $selectedDoctors.push({
                                id: $this.data('id'),
                                name: $this.data('name'),
                            });
                        });
                        if('function' === typeof doneCallback){
                            doneCallback($selectedDoctors);
                        }
                    }
                }
            },
        });

        $modal
            .on('shown.bs.modal', event => {

            })
        ;
    };

    sandbox.on('modal/clinicDoctorsPicker/show', ({clinicId, excludeIds, doneCallback, failCallback}) => {
        _this.fetchDoctors({
            clinicId,
            excludeIds,
            doneCallback: data => {
                _this.showModal({
                    doctors: data,
                    doneCallback: response => {
                        if('function' === typeof doneCallback){
                            doneCallback(response);
                        }
                    },
                    failCallback: (e, data) => {
                        if('function' === typeof failCallback){
                            failCallback(e, data);
                        }
                    }
                });
            },
            failCallback: (e, data) => {
                if('function' === typeof failCallback){
                    failCallback(e, data);
                }
            }
        })
    });

    /**
     * @memberOf modalClinicDoctorsPicker
     * @function init
     * @param data
     */
    _this.init = data => {
        _this.data = data || {};

        _this.templates = {};
        _this.templates.modalContent = multiline(() => {/*!@preserve
        <form class="form" id="form_clinic_doctors">
            <table class="table table-hover table-striped" id="table_clinic_doctors">
                <thead>
                    <tr>
                        <th width="30"></th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                {% if doctors.length %}
                {% for doctor in doctors %}
                    <tr data-id="{{doctor.id}}" data-name="{{doctor.name}}">
                        <td>
                            <input type="checkbox" name="doctor_ids[]" value="{{doctor.id}}"/>
                        </td>
                        <td>{{doctor.name}}</td>
                    </tr>
                {% endfor %}
                {% else %}
                    <tr>
                        <td colspan="2" class="text-center">No available doctors.</td>
                    </tr>
                {% endif %}
                </tbody>
            </table>
        </form>
        */console.log});
    };

    /**
     * @memberOf modalClinicDoctorsPicker
     * @function destroy
     */
    _this.destroy = () => {};

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
};
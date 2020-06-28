/**
 * @namespace boxProfile
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function(sandbox){
    let _this = this;

    _this.render = () => {};

    _this.bindEvents = () => {
        _this.objects.$self
            .on('click', '[data-action=cancel]', event => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    appointmentId = $this.data('id')
                ;

                sandbox.emit('modalCancelAppointment/show', {
                    appointmentId,
                    doneCallback: response => {
                        window.location.reload();
                    },
                })
            })
        ;
    };

    _this.init = data => {
        _this.data = data || {};

        _this.objects = {};
        _this.objects.$self = $('#box_profile');

        _this.render();
        _this.bindEvents();
    };

    _this.destroy = () => {};

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
};
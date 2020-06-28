'use strict';

/**
 * @namespace moduleSettingsTime
 */
module.exports = function(sandbox){
    let _this = this;

    _this.render = () => {
        _this.objects.$selectTimezone.chosen({
            search_contains: true
        });
    }

    /**
     * @memberOf moduleSettingsTime
     * @function init
     * @param data
     */
    _this.init = ({data}) => {
        _this.data = data || {};

        _this.objects = {};
        _this.objects.$form = $('#form_time');
        _this.objects.$selectTimezone = _this.objects.$form.find('[name=timezone]');

        _this.templates = {};

        _this.render();
    }

    /**
     * @memberOf moduleSettingsTime
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
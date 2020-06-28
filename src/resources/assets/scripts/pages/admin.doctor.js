'use strict';

/**
 * @namespace pageAdminDoctors
 */
module.exports = function (sandbox) {
    let _this = this;

    /**
     * @memberOf pageAdminDoctors
     * @function init
     * @param data
     */
    _this.init = ({data}) => {
        _this.data = data || {};

        _this.objects = {};

        _this.templates = {};
    }

    /**
     * @memberOf pageAdminDoctors
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
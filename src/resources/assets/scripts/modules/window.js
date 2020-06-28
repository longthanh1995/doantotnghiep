/**
 * @module window
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox) {
    var _this = this;

    _this.showNotify = ({icon, message, type, allowDismiss = true, delay = 500}) => {
        $.notify({
            icon,
            message
        }, {
            type,
            z_index: 1030,
            delay,
            allow_dismiss: allowDismiss,
            placement: {
                from: 'top',
                align: 'right'
            }
        })
    };

    sandbox.on('window/reload', () => {
        window.location.reload();
    });

    sandbox.on('window/loading/show', () => {
        _this.objects.$loading.removeClass('hide');
    });

    sandbox.on('window/loading/hide', () => {
        _this.objects.$loading.addClass('hide');
    });

    sandbox.on('window/notify/show', ({icon, message, type, allowDismiss, delay}) => {
        _this.showNotify({icon, message, type, allowDismiss, delay});
    });

    _this.init = (data) => {
        _this.objects = {};
        _this.objects.$loading = $('#overlay_loading');
    }
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
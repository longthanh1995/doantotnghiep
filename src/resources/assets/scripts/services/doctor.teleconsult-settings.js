module.exports = function(sandbox){
    let _this = this;

    /**
     * @module serviceTeleconsultSettings
     * @function fetchDoctorInfo
     * @param doneCallback
     * @param failCallback
     */
    _this.fetchDoctorInfo = ({doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('setting.fetchDoctorInfo'),
            method: 'GET',
        });

        request
            .done((response) => {
                if('function' === typeof doneCallback){
                    doneCallback(humps.camelizeKeys(response.data));
                }
            })
            .fail((e, data) => {
                if('function' === typeof failCallback){
                    failCallback(e, data);
                }
            })
        ;
    };

    /**
     * @module serviceTeleconsultSettings
     * @function updateChatAvailability
     * @param availability
     * @param doneCallback
     * @param failCallback
     */
    _this.updateChatAvailability = ({availability, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('setting.updateChatAvailability'),
            method: 'PUT',
            data: {
                availability
            },
            dataType: 'json',
        });

        request
            .done((response) => {
                if('function' === typeof doneCallback){
                    doneCallback(humps.camelizeKeys(response.data));
                }
            })
            .fail((e, data) => {
                if('function' === typeof failCallback){
                    failCallback(e, data);
                }
            })
        ;
    };

    /**
     * @module serviceTeleconsultSettings
     * @function updateVideoAvailability
     * @param availability
     * @param doneCallback
     * @param failCallback
     */
    _this.updateVideoAvailability = ({availability, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('setting.updateVideoAvailability'),
            method: 'PUT',
            data: {
                availability
            },
            dataType: 'json',
        });

        request
            .done((response) => {
                if('function' === typeof doneCallback){
                    doneCallback(humps.camelizeKeys(response.data));
                }
            })
            .fail((e, data) => {
                if('function' === typeof failCallback){
                    failCallback(e, data);
                }
            })
        ;
    };

    /**
     * @module serviceTeleconsultSettings
     * @function getChatFeeSettings
     * @param doneCallback
     * @param failCallback
     */
    _this.getChatFeeSettings = ({doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('setting.getChatFeeSettings'),
            method: 'GET',
        });

        request
            .done((response) => {
                if('function' === typeof doneCallback){
                    doneCallback(humps.camelizeKeys(response.data));
                }
            })
            .fail((e, data) => {
                if('function' === typeof failCallback){
                    failCallback(e, data);
                }
            })
        ;
    };

    /**
     * @module serviceTeleconsultSettings
     * @function getVideoFeeSettings
     * @param doneCallback
     * @param failCallback
     */
    _this.getVideoFeeSettings = ({doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('setting.getVideoFeeSettings'),
            method: 'GET',
        });

        request
            .done((response) => {
                if('function' === typeof doneCallback){
                    doneCallback(humps.camelizeKeys(response.data));
                }
            })
            .fail((e, data) => {
                if('function' === typeof failCallback){
                    failCallback(e, data);
                }
            })
        ;
    };

    _this.updateChatFeeSettings = ({data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('setting.updateChatFeeSettings'),
            method: 'PUT',
            data,
            dataType: 'json',
        })

        request
            .done((response) => {
                if('function' === typeof doneCallback){
                    doneCallback(humps.camelizeKeys(response.data));
                }
            })
            .fail((e, data) => {
                if('function' === typeof failCallback){
                    failCallback(e, data);
                }
            })
        ;
    }

    _this.updateVideoFeeSettings = ({data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('setting.updateVideoFeeSettings'),
            method: 'PUT',
            data,
            dataType: 'json',
        })

        request
            .done((response) => {
                if('function' === typeof doneCallback){
                    doneCallback(humps.camelizeKeys(response.data));
                }
            })
            .fail((e, data) => {
                if('function' === typeof failCallback){
                    failCallback(e, data);
                }
            })
        ;
    }

    sandbox.on('service/teleconsultSettings/fetchDoctorInfo', ({doneCallback = null, failCallback = null}) => {
        _this.fetchDoctorInfo({doneCallback, failCallback});
    });

    sandbox.on('service/teleconsultSettings/updateChatAvailability', ({availability, doneCallback = null, failCallback = null}) => {
        _this.updateChatAvailability({availability, doneCallback, failCallback});
    });

    sandbox.on('service/teleconsultSettings/updateVideoAvailability', ({availability, doneCallback = null, failCallback = null}) => {
        _this.updateVideoAvailability({availability, doneCallback, failCallback});
    });

    sandbox.on('service/teleconsultSettings/getChatFeeSettings', ({doneCallback = null, failCallback = null}) => {
        _this.getChatFeeSettings({doneCallback, failCallback});
    });

    sandbox.on('service/teleconsultSettings/getVideoFeeSettings', ({doneCallback = null, failCallback = null}) => {
        _this.getVideoFeeSettings({doneCallback, failCallback});
    });

    sandbox.on('service/teleconsultSettings/updateChatFeeSettings', ({data, doneCallback = null, failCallback = null}) => {
        _this.updateChatFeeSettings({data, doneCallback, failCallback});
    });

    sandbox.on('service/teleconsultSettings/updateVideoFeeSettings', ({data, doneCallback = null, failCallback = null}) => {
        _this.updateVideoFeeSettings({data, doneCallback, failCallback});
    });

}
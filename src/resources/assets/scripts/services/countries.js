/**
 * @module serviceCountries
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function (sandbox) {
    let _this = this;

    /**
     * @module serviceCountries
     * @function store
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.store = ({data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('api.countries.store'),
            method: 'POST',
            data,
            dataType: 'json',
        });

        request
            .done((response) => {
                if ('function' === typeof doneCallback) {
                    doneCallback(humps.camelizeKeys(response));
                }
            })
            .fail((e, data) => {
                if ('function' === typeof failCallback) {
                    failCallback(e, data);
                }
            })
    };

    /**
     * @module serviceCountries
     * @function fetch
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.fetch = ({id, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('api.countries.retrieve', {id}),
            headers: {
                accept: 'application/json',
            },
        });

        request
            .done((response) => {
                if ('function' === typeof doneCallback) {
                    doneCallback(humps.camelizeKeys(response));
                }
            })
            .fail((e, data) => {
                if ('function' === typeof failCallback) {
                    failCallback(e, data);
                }
            })
        ;
    };

    /**
     * @module serviceCountries
     * @function list
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.list = ({data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('public.resource.country'),
            data,
            dataType: 'json',
        });

        return request
            .done((response) => {
                if ('function' === typeof doneCallback) {
                    doneCallback(humps.camelizeKeys(response));
                }
            })
            .fail((e, data) => {
                if ('function' === typeof failCallback) {
                    failCallback(e, data);
                }
            })
        ;
    };

    /**
     * @module serviceCountries
     * @function update
     * @param id
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.update = ({id, data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('api.countries.update', {id}),
            data,
            dataType: 'json',
            method: 'PUT',
        });

        request
            .done((response) => {
                if ('function' === typeof doneCallback) {
                    doneCallback(humps.camelizeKeys(response));
                }
            })
            .fail((e, data) => {
                if ('function' === typeof failCallback) {
                    failCallback(e, data);
                }
            })
        ;
    };

    /**
     * @module serviceCountries
     * @function delete
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.delete = ({id, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('api.countries.delete', {id}),
            method: 'DELETE',
        });

        request
            .done((response) => {
                if ('function' === typeof doneCallback) {
                    doneCallback(humps.camelizeKeys(response));
                }
            })
            .fail((e, data) => {
                if ('function' === typeof failCallback) {
                    failCallback(e, data);
                }
            })
        ;
    };

    sandbox.on('service/countries/store', ({data = {}, doneCallback = null, failCallback = null}) => _this.store({
        data,
        doneCallback,
        failCallback
    }));
    sandbox.on('service/countries/fetch', ({id = '', doneCallback = null, failCallback = null}) => _this.fetch({
        id,
        doneCallback,
        failCallback
    }));
    sandbox.on('service/countries/list', ({data = {}, doneCallback = null, failCallback = null}) => _this.list({
        data,
        doneCallback,
        failCallback
    }));
    sandbox.on('service/countries/update', ({id = '', data = {}, doneCallback = null, failCallback = null}) => _this.update({
        id,
        data,
        doneCallback,
        failCallback
    }));
    sandbox.on('service/countries/delete', ({id = '', doneCallback = null, failCallback = null}) => _this.delete({
        id,
        doneCallback,
        failCallback
    }));

    /**
     * @module serviceCountries
     * @function init
     * @param data
     */
    _this.init = (data) => {};

    /**
     * @module serviceCountries
     * @function destroy
     */
    _this.destroy = () => {
    };

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
}
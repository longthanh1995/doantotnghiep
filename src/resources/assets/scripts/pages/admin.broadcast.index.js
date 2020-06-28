/**
 * @namespace pageAdminBroadcastIndex
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function(sandbox){
    let _this = this;

    _this.render = () => {};

    _this.bindEvents = () => {
        _this.objects.$table
            .on('click', '[data-action=delete]',(event) => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    $targetRow = $this.closest('tr'),
                    targetId = $targetRow.data('id')
                ;

                bootbox.confirm('Do you really want to delete this article?', (result) => {
                    if(result){
                        manaDrApplication.emit('window/loading/show');

                        let request = $.ajax({
                            url: laroute.route('admin.broadcast.delete', {id: targetId}),
                            method: 'DELETE',
                        });

                        request
                            .done((response) => {
                                let message = `Article has been deleted successfully.`;
                                bootbox.alert(message, () => {
                                    window.location.reload();
                                });
                            })
                            .fail((e, data) => {
                                let message = '';

                                if (e
                                    && e.responseJSON
                                    && e.responseJSON.message
                                    && e.responseJSON.message.length) {
                                    message = e.responseJSON.message;
                                } else {
                                    message = 'The request cannot be processed';
                                }

                                bootbox.alert(message, () => {
                                    manaDrApplication.emit('window/loading/hide');
                                });
                            })
                        ;
                    }
                });
            })
        ;
    };

    _this.init = ({data}) => {
        _this.data = data || {};

        _this.objects = {};
        _this.objects.$table = $('#table_broadcast_articles');

        _this.render();
        _this.bindEvents();
    };

    _this.destroy = () => {

    };

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
}
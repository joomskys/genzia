;
(function ($) {
    "use strict";

    $(document).on('click', '#btn-cms-get-started', function () {
        let _this = $(this);
        let alert = $('#cms-alert');
        let _wpnonce = _this.data('nonce');
        let text = _this.text();
        let processingText = 'Installing...';
        let errorMessage = 'Something went wrong! Please try again.';
        if (_this.hasClass('btn-activate')) {
            processingText = 'Activating...';
        } else {
            processingText = 'Installing...';
        }
        if (!_this.hasClass('loading')) {
            $.ajax({
                url: main_data.ajax_url,
                type: "POST",
                beforeSend: function () {
                    _this.addClass('loading');
                    _this.text(processingText);
                },
                data: {
                    action: 'get_started',
                    _wpnonce: _wpnonce,
                },
            }).done(function (res) {
                if (res.stt) {
                    window.location.href = res.data.redirect_url;
                } else {
                    _this.text(text);
                    alert.text(res.msg);
                    alert.show();
                }
            }).fail(function (res) {
                _this.text(text);
                alert.text(errorMessage);
                alert.show();
            }).always(function () {
                _this.removeClass('loading');
            });
        }
    });
})(jQuery);
(function ($, params) {
    $(document).ready(function () {
        var isGetProcess = false;
        var lastMessageId = 0;
        var messageList = $('#message-list');
        var messageScroller = messageList.parent();
        var INTERVAL = 1000;

        setInterval(function () {
            messageList.trigger('message:get');
        }, INTERVAL);

        messageList.on('message:get', function () {
            var scrollerHeight = messageScroller.height();
            var scrollTop = messageScroller.scrollTop();

            messageList.find('div[data-id]').each(function () {
                var item = $(this);
                var offsetTop = this.offsetTop;

                if ((offsetTop - scrollTop) <= scrollerHeight) {
                    $.ajax({
                        url: '/message/viewed',
                        method: 'post',
                        data: {
                            id: item.data('id')
                        },
                        success: function (response) {
                            if (0 < response) {
                                item.removeAttr('data-id');
                            }
                        }
                    });
                }
            });
        });

        messageList.on('message:sent', function () {
            messageList.trigger('message:get');
        });

        messageList.on('message:get', function () {
            if (isGetProcess) {
                return;
            }

            isGetProcess = true;

            $.ajax({
                url: '/message/get',
                method: 'post',
                data: {
                    recipient_id: params.recipient_id,
                    last_id: lastMessageId
                },
                dateType: 'json',
                success: function (response) {
                    if (!response.length) {
                        return;
                    } else {
                        lastMessageId = response[response.length - 1].id
                    }

                    response.forEach(function (model) {
                        renderMessage(model);
                    });

                    var listHeight = messageList.height();
                    var scrollerHeight = messageScroller.height();

                    var marginTop = Math.max(listHeight, scrollerHeight) - scrollerHeight;

                    messageScroller.scrollTop(marginTop);
                },
                complete: function () {
                    isGetProcess = false;
                }
            });
        });

        function renderMessage(model) {
            var item = $('<div>');

            if (!model.is_read) {
                item.attr('data-id', model.id);
            }

            item.addClass('message');

            if (params.owner_id === model.user_id) {
                item.addClass('message-me')
                    .append('<div class="message-label message-label-me">Я, [' + formatDate(model.created_at) + ']</div>');
            } else {
                item.addClass('message-recipient')
                    .append('<div class="message-label message-label-recipient">' + params.recipient_name + ', [' + formatDate(model.created_at) + ']</div>');
            }

            item.append('<div class="message-text">' + model.message + '</div>');

            messageList.append(item);
        }

        function formatDate(seconds) {
            var milliseconds = seconds * 1000;
            var date = new Date(milliseconds);

            return date.toLocaleString();
        }

        $('body').on('submit', 'form#form-message', function () {
            var form = $(this);
            var textarea = form.find('textarea');
            var submitButton = form.find('button[type=submit]');

            if (form.find('.has-error').length || !textarea.val()) {
                return false;
            }

            submitButton.prop('disabled', true);

            $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: form.serialize(),
                success: function (response) {
                    if ('success' === response) {
                        form.find('textarea').val('');
                        messageList.trigger('message:sent');
                    }
                },
                error: function () {
                    console.log('Ошибка сервера при отправки сообщения');
                },
                complete: function () {
                    submitButton.prop('disabled', false);
                }
            });

            return false;
        });
    });
})(jQuery, MESSAGE_PARAMS);

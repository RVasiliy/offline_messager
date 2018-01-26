(function ($) {
    $(document).ready(function () {
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
})(jQuery);

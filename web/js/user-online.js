(function ($) {
    var OFFLINE_LIMIT = 4000;

    updateOnline();

    function updateOnline() {
        $.ajax({
            url: '/online/update',
            method: 'post',
            complete: function() {
                setTimeout(function () {
                    updateOnline();
                }, OFFLINE_LIMIT);
            }
        });
    }
})(jQuery);
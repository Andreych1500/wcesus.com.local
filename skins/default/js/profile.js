$(document).ready(function () {
    $('div[data-section]').click(function () {
        var index = $(this).attr('data-section');
        $('div[data-section]').not('[data-section="' + index + '"]').removeAttr('class');


        if ($.cookie("open_tabs") !== undefined && index == $.cookie("open_tabs")) {
            $.removeCookie("open_tabs", {path: '/cab/'});
        } else {
            $.cookie("open_tabs", index, {expires: 14, path: '/cab/'});
        }

        if ($(this).is('.active')) {
            $(this).removeAttr('class');
        } else {
            $(this).addClass('active');
        }

        $('div[data-view-section]').each(function () {
            if ($(this).attr('data-view-section') != index) {
                $(this).slideUp();
            } else {
                if ($(this).css('display') == 'block') {
                    $(this).slideUp();
                } else {
                    $(this).slideDown();
                }
            }
        });
    });
});

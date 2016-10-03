$(document).ready(function () {
    // Plese wait 5 sec
    if (window.location.pathname == '/apply/payment/' && $('#payment').length > 0) {
        $('#payment').fadeOut('fast', function () {
            $('.save-or-continue').append('<div class="wait">Please wait 5 seconds... </div>');
        });
    }

    // Open mobile menu
    $('#wsnavtoggle').click(function () {
        if ($(this).is('.active')) {
            $(this).removeAttr('class');
            $('.overlapblackbg').remove();
            $('.item-top, .item-mega').removeClass('onclick');
            $('.scrolling').delay(300).queue(function (next) {
                $(this).removeClass('act-mobile').find('nav').removeAttr('style');
                next();
            });
        } else {
            $(this).addClass('active');
            $('.item-top, .item-mega').attr('onclick', 'goStop(event, this);');
            $('body').prepend('<div class="overlapblackbg" onclick="closeMobMenu();"></div>');
            $('.scrolling').addClass('act-mobile').delay(300).queue(function (next) {
                $('.act-mobile nav').css('margin-left', '0');
                next();
            });
        }
    });

    $('.item-top, .item-mega').click(function () {
        if ($(this).find('.sub-mega-menu, .sub-menu').css('display') == 'none') {
            $(this).addClass('active-sub').find('.sub-mega-menu, .sub-menu').slideDown('middle');
        } else {
            $(this).find('.sub-mega-menu, .sub-menu').slideUp('middle', function () {
                $(this).removeAttr('onclick').parent('.active-sub').removeClass('active-sub');
            });
        }
    });

    // Close modal window
    $('.modalWindow .close').click(function () {
        $('.modalWindow').fadeOut('slow', function () {
            $(this).remove();
        })
    });

    // Forgot data
    $('.forgot-data').click(function () {
        window.location.href = '/apply/forgot-data/';
    });

    // Click new Card
    $('a[href="/apply/application-info/?newCard"]').click(function (e) {
        e.preventDefault();

        var text = $('.confirm_agreement').html();
        var link = $(this).attr('href');
        var windowHtml = '<div class="modalWindow"><div class="modal-content"><span class="icon-error"></span> <i>Important Message</i><div class="text">' + text + '</div><span data-click="Yes">Yes</span><span data-click="No">No</span></div></div>';

        $('body').prepend(windowHtml);

        $('span[data-click]').click(function () {
            if ($(this).attr('data-click') == 'Yes') {
                window.location.href = link;
            } else {
                $('.modalWindow').fadeOut('fast', function () {
                    $(this).remove();
                });
            }
        });
    });

    // Scroll menu
    $(window).scroll(function () {
        var scrolledY = window.pageYOffset || document.documentElement.scrollTop;

        if (scrolledY >= 40) {
            if (!$('.scrolling').is('.fixed')) {
                $('.scrolling').addClass('fixed');
            }
        } else {
            if ($('.scrolling').is('.fixed')) {
                $('.scrolling').removeClass('fixed');
            }
        }
    });

    $(window).scroll();
});

function goStop(e, el) {
    var widthWindow = $(window).outerWidth(true);

    if ($(el).find('.sub-mega-menu, .sub-menu').length > 0 && widthWindow <= 800) {
        e.preventDefault();
    }
}

function closeMobMenu() {
    $('#wsnavtoggle').trigger('click');
}
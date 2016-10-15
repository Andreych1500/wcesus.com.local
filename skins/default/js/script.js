$(document).ready(function () {
    scroll_top();

    // Plese wait 5 sec
    if (window.location.pathname == '/apply/payment/' && $('#payment').length > 0) {
        $('#payment').fadeOut('fast', function () {
            $('.save-or-continue').append('<div class="wait">Please wait 5 seconds... </div>');
        });
    }

    // Slider
    if ($('.slide-item').length > 1) {
        Slider(undefined, 'Y', undefined);
    }

    $('.row-slide span').click(function () {
        if (!$(this).is('.active-row')) {
            Slider($(this).index(), undefined, 'Y');
        }
    });

    // Active menu
    var url = window.location.pathname;
    var mainLink = url.split('/');

    $(".top-menu nav ul li, .top-menu nav ul li > ul li").each(function () {
        $(".top-menu li a").removeClass("active");
        $('.top-menu li a[href="' + url + '"], .top-menu li a[href="/' + mainLink[1] + '/"]').addClass('active');
    });

    // Open mobile menu
    $('#wsnavtoggle').click(function () {
        if ($(this).is('.active')) {
            $(this).removeAttr('class');
            $('.overlapblackbg').remove();

            $('.scrolling').delay(300).queue(function (next) {
                $(this).find('nav').removeAttr('style');
                $('.logo').css('margin-left', '100px');
                next();

                $(this).delay(300).queue(function (next2) {
                    $('.logo').removeAttr('style');
                    $(this).removeClass('act-mobile');
                    next2();
                });
            });
        } else {
            $(this).addClass('active');
            $('body').prepend('<div class="overlapblackbg" onclick="closeMobMenu();"></div>');
            $('.scrolling').addClass('act-mobile').delay(300).queue(function (next) {
                $('.act-mobile nav').css('margin-left', '0');
                next();
            });
        }
    });

    $('.item-top, .item-mega').click(function (e) {
        e = e || event;
        var target = e.target;

        if (target.tagName != 'A') {
            if ($(this).find('.sub-mega-menu, .sub-menu').css('display') == 'none') {
                $(this).addClass('active-sub').find('.sub-mega-menu, .sub-menu').slideDown('middle');
            } else {
                $(this).find('.sub-mega-menu, .sub-menu').slideUp('middle', function () {
                    $(this).removeAttr('onclick').parent('.active-sub').removeClass('active-sub');
                    $(this).removeAttr('style');
                });
            }
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
        var windowHtml = '<div class="modalWindow"><div class="modal-content"><span class="icon-error"></span> <i>Terms and Conditions</i><div class="text">' + text + '</div><span data-click="Y">Accept</span><span data-click="N">Don’t accept</span></div></div>';

        $('body').prepend(windowHtml);

        $('span[data-click]').click(function () {
            if ($(this).attr('data-click') == 'Y') {
                window.location.href = link;
            } else {
                $('.modalWindow').fadeOut('fast', function () {
                    $(this).remove();
                });
            }
        });
    });

    // Click in FAQ
    $('.faq-items .item').click(function(e){
        e = e || event;
        var target = e.target;

        if(!$(target).is('.answer')) {
           if($(this).is('.active')){
               $(this).removeClass('active');
           } else {
               $(this).addClass('active');
           }

            $(this).find('.answer').slideToggle('slow');
        }
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

function closeMobMenu() {
    $('#wsnavtoggle').trigger('click');
}

function scroll_top() {
    $('#scroll-top').on('click', function () {
        $('html, body').animate({scrollTop: 0});
        return false;
    });

    $(window).scroll(function () {
        if ($(window).scrollTop() > 400) {
            $('#scroll-top').fadeIn();
        } else {
            $('#scroll-top').fadeOut();
        }
    });

    $(window).scroll();
}

function Slider(eq, animate, stop) {
    var index = $('.main-banner .active-slide').index();
    var slide_item = $('.main-banner .slide-item');
    var slide_row = $('.row-slide span');

    if (eq !== undefined) {
        index = eq;
    }

    if (animate !== undefined) {
        index += 1;
    }

    if (slide_item.eq(index).length == 0) {
        index = 0;
    }

    if (stop !== undefined) {
        slide_row.removeClass('active-row').eq(index).addClass('active-row');
        slide_item.removeClass('active-slide').removeAttr('style').eq(index).fadeIn('slow').addClass('active-slide');
    }

    if (animate !== undefined) {
        setTimeout(function () {
            Slider(undefined, 'Y', 'Y');
        }, 20000);
    }
}
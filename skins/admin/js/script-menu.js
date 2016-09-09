$(document).ready(function () {
    // Open top menu
    setTimeout(function () {
        $('.no-active').removeClass('no-active');
    }, 100);

    // Active menu
    $(".section-module").each(function () {
        var url = window.location.pathname;
        var search = window.location.search;

        if ($('.section-module a[href$="' + url + search + '"]').length == 0) {
            search = '';
        }

        $('.section-module a[href$="' + url + search + '"]').css('text-decoration', 'underline').parent('li').css('color', '#0058ff');
    });

    // Information session block
    if ($('.adm-info-block').length > 0) {
        setTimeout(function () {
            $('.adm-info-block').animate({
                    opacity: 0,
                    marginTop: "-30px"
                }, 1500, function () {
                    $(this).remove();
                }
            );
        }, 7000);
    }

    // Update element
    $(window).resize(function () {
        var widthScrollY = widthScroll_Y();
        var widthWindow = $(window).outerWidth(true) + widthScrollY;
        var clientH = document.documentElement.clientHeight;
        var contentHeight = clientH - $('header').outerHeight(true) - $('footer').outerHeight(true);

        // Mobile authorization
        if (clientH <= 600) {
            if ($('.auth-main').length > 0) {
                $('.auth-main').removeClass().addClass('minMob-auth-main');
            }
        } else {
            if ($('.minMob-auth-main').length > 0) {
                $('.minMob-auth-main').removeClass().addClass('auth-main');
            }
        }

        // New information || Mob PC version
        if (widthWindow <= 740) {
            $('.pc-version aside, .pc-version .navigation').removeAttr('style');

            if ($('.nth1-panel .new-info').length == 0) {
                $('.new-info').insertBefore('.nth1-panel .to-cab', '');
            }

            if ($('.mobile-version').length == 0 && $('.auth-panel').length == 0) {
                $('main').removeClass('pc-version').addClass('mobile-version');
            }

        } else {
            if ($('.nth2-panel .new-info').length == 0) {
                $('.new-info').insertAfter('.nth2-panel .to-admin', '');
            }

            if ($('.pc-version').length == 0 && $('.auth-panel').length == 0) {
                $('main').removeClass('mobile-version').addClass('pc-version');
            }

            // Min height content block
            $('.pc-version aside').css({'min-height': contentHeight});
            $('.pc-version .navigation').css('min-height', contentHeight);
        }

        // Lang selection
        $('.lang-open-click').css({'left': $('.lang-info').offset().left - 148, 'top':$('.lang-info').offset().top + 50});
    });

    $(window).resize();
});

function widthScroll_Y() {
    var div = document.createElement('div');
    $('body').append($(div).css({
        'overflowY': 'scroll',
        'width': '50px',
        'height': '50px',
        'visibility': 'hidden',
        'position': 'absolute'
    }));
    var scrollWidth;

    if (hasVerticalScroll()) {
        scrollWidth = div.offsetWidth - div.clientWidth;
    } else {
        scrollWidth = 0;
    }

    $(div).remove();
    return scrollWidth;
}

function hasVerticalScroll(node) {
    if (node == undefined) {
        if (window.innerHeight)
            return document.body.offsetHeight > innerHeight;
        else
            return document.documentElement.scrollHeight >
                document.documentElement.offsetHeight ||
                document.body.scrollHeight > document.body.offsetHeight;
    }
    else {
        return node.scrollHeight > node.offsetHeight;
    }
}
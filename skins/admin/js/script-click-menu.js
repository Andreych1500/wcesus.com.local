$(document).ready(function () {
    // Open lang information
    $('.lang-info').click(function () {
        var el_block = $('.lang-open-click');

        if ($(el_block).css('display') == 'none') {
            el_block.css({
                'left': $(this).offset().left - 148,
                'top': $(this).offset().top + 50
            }).slideDown('middle');
        }

        if ($(el_block).css('display') == 'block') {
            $(document).mouseup(function (e) {
                if (!$(el_block).is(e.target) && $(el_block).has(e.target).length === 0) {
                    $(el_block).slideUp('middle');
                }

                return false;
            });
        }
    });

    // Active menu
    $('.navigation li').click(function () {
        var widthScrollY = widthScroll_Y();
        var widthWindow = $(window).outerWidth(true) + widthScrollY;

        if ($('.active-section').length == 0) {
            $.cookie("act-menu", $(this).index(), {expires: 14, path: '/'});
        }

        if ($(this).is('.act-navigation')) {
            $.removeCookie("act-menu", {path: '/'});
            $(this).removeAttr('class');
            $('.navigation-lv2').removeClass('act-nav-lv2');
            $('.section-lv2').removeClass("act-section");
        } else {
            $.cookie("act-menu", $(this).index(), {expires: 14, path: '/'});
            $('.navigation .act-navigation').removeAttr('class');
            $(this).addClass('act-navigation');
            $('.navigation-lv2').addClass('act-nav-lv2');
            $('.section-lv2').removeClass('act-section').eq($(this).index()).addClass('act-section');
        }
    });

    // Active section menu
    $('.list-sec-menu').click(function (e) {
        if (e.target.className == 'list-sec-menu' || 'act-list') {
            var el = $(e.target);
            var indexMenu = $(el).parent('.section-lv2').index() + ':' + $(el).index();
            var cookie = [];

            // Animation
            if ($(el).is('.act-list')) {
                $(el).find('.section-module').slideUp('middle', function () {
                    $(el).removeClass('act-list');
                });
            } else {
                $(el).find('.section-module').slideDown('middle', function () {
                    $(el).addClass('act-list');
                });
            }

            // Save
            if ($.cookie("act-menu-lv2") !== undefined) {
                var array = JSON.parse($.cookie("act-menu-lv2"));

                if ($.inArray(indexMenu, array) >= 0) {
                    array = $.grep(array, function (velue) {
                        return velue !== indexMenu;
                    });

                    if (array.length <= 0) {
                        $.removeCookie("act-menu-lv2", {path: '/'});
                    } else {
                        $.cookie("act-menu-lv2", JSON.stringify(array), {expires: 14, path: '/'});
                    }
                } else {
                    array.push(indexMenu);
                    $.cookie("act-menu-lv2", JSON.stringify(array), {expires: 14, path: '/'});
                }
            } else {
                cookie.push(indexMenu);
                $.cookie("act-menu-lv2", JSON.stringify(cookie), {expires: 14, path: '/'});
            }
        }
    });

    // Deactive menu
    $('.to-admin').click(function () {
        $.removeCookie("active-menu", {path: '/'});
    });

    // Active tabs
    $('.tabs-panel li').click(function () {
        $('.tabs-panel li').removeAttr('class');
        $(this).addClass('active-tab');
        $('.content-form .tabs').removeClass('active-block-tabs').eq($(this).index()).addClass('active-block-tabs');
    });

    // Backup check
    $('.reload-file[href$="?backup=ok"]').click(function () {
        if ($('.operation-info').length == 0) {
            var lang_text = $(this).attr('data-lang-text');
            setTimeout(function () {
                $('.bottom-table').append('<div class="operation-info">' + lang_text + '<img src="/skins/admin/img/load.gif" alt="loading"></div>');
                $('.operation-info').slideDown('middle');
            }, 600);
        }
    });

    // Add element input
    $('.add-el-list').click(function () {
        if ($(this).attr('data-type') == 'text') {
            $(this).before('<input type="' + $(this).attr('data-type') + '" name="' + $(this).attr('data-name') + '" value="" ' + $(this).attr('data-attr') + '>');
        }

        if ($(this).attr('data-type') == 'textarea') {
            $(this).before('<textarea name="' + $(this).attr('data-name') + '" ' + $(this).attr('data-attr') + '></textarea>');
        }
    });

    // All checked element
    $('input[name="all_cheked"]').click(function () {
        if ($(this).is(":checked") == true) {
            $('.illustration-table tr:not(:first-child) td:first-child input').each(function () {
                $(this).prop("checked", true).parents('tr').addClass('c-checked');
            });
        } else {
            $('.illustration-table tr:not(:first-child) td:first-child input').each(function () {
                $(this).prop("checked", false).parents('tr').removeClass('c-checked');
            });
        }
    });

    $('.technik-off-onn input[name="all_cheked"]').click(function () {
        if ($(this).is(":checked") == true) {
            $('div[data-result="tables"] input[type="checkbox"]').each(function () {
                $(this).prop("checked", true);
            });
        } else {
            $('div[data-result="tables"] input[type="checkbox"]').each(function () {
                $(this).prop("checked", false);
            });
        }
    });

    // Checked style element
    $('.illustration-table tr:not(:first-child) td:first-child input[type="checkbox"]').click(function () {
        if ($(this).is(":checked") == true) {
            $(this).parents('tr').addClass('c-checked');
        } else {
            $(this).parents('tr').removeClass('c-checked');
        }
    });

    // Double click open function
    $('.illustration-table tr:not(:first-child) td:not(:first-child)').dblclick(function () {
        if ($(this).parents('.c-checked').length == 0) {
            var link = $(this).parents('tr').find('.menu-update a[href*="?edit="], a:first-child').attr('href');

            if (link !== undefined) {
                document.location.href = link;
            }
        }
    });

    // Open option filter
    $('.add-field-filter').click(function () {
        var el_block = $('.filter-option-list');

        if ($(el_block).css('display') == 'none') {
            $(this).before('<span class="triangle"></span>');
            $(el_block).slideDown('middle');
        }

        if ($(el_block).css('display') == 'block') {
            $(document).mouseup(function (e) {
                if (!$(el_block).is(e.target) && $(el_block).has(e.target).length === 0) {
                    $(el_block).slideUp('middle', function () {
                        $('.triangle').remove();
                    });
                }

                return false;
            });
        }
    });

    // Filter
    $('.filter-option-list div').click(function () {
        var index = $(this).attr('data-index');
        var cookie = [];

        if ($(this).is('.act-option')) {
            $(this).removeClass('act-option');
            $('.filter .input-value[data-index="' + index + '"]').fadeOut('slow', function () {
                if ($(this).find('input').length) {
                    $(this).find('input[name^="find_"]').attr('value', '');
                } else if ($(this).find('select').length) {
                    $(this).find('select option').removeAttr('selected').eq(0).attr('selected', true);
                }
                $(this).find('input, select').attr('disabled', true);
            });
        } else {
            $(this).addClass('act-option');
            $('.filter .input-value[data-index="' + index + '"]').fadeIn('slow', function () {
                $(this).find('input, select').attr('disabled', false);
            });
        }

        // Save
        if ($.cookie("filter") !== undefined) {
            var array = JSON.parse($.cookie("filter"));

            if ($.inArray(index, array) >= 0) {
                array = $.grep(array, function (velue) {
                    return velue !== index;
                });

                if (array.length <= 0) {
                    $.removeCookie("filter", {path: window.location.pathname});
                } else {
                    $.cookie("filter", JSON.stringify(array), {expires: 30, path: window.location.pathname});
                }
            } else {
                array.push(index);
                $.cookie("filter", JSON.stringify(array), {expires: 30, path: window.location.pathname});
            }
        } else {
            cookie.push(index);
            $.cookie("filter", JSON.stringify(cookie), {expires: 30, path: window.location.pathname});
        }
    });

    // Count Element Page
    $('.count_el_page').click(function () {
        var el_block = $(this).find('.selected');

        if ($(el_block).css('display') == 'none') {
            el_block.slideDown('middle');
            $(this).addClass('open-list');
        }

        if ($(el_block).css('display') == 'block') {
            $(document).mouseup(function (e) {
                if (!$(el_block).is(e.target) && $(el_block).has(e.target).length === 0) {
                    $(el_block).slideUp('middle');
                    $('.count_el_page').removeClass('open-list');
                }

                return false;
            });
        }
    });

    $('.count_el_page .selected span').click(function () {
        var count = parseInt($(this).text());

        if (count) {
            $.cookie("count_el_page", JSON.stringify(count), {expires: 30, path: window.location.pathname});
            window.location.reload()
        }
    });

    // Edit element on window
    $('.illustration-table input[name^="ids"], input[name="all_cheked"]').click(function () {
        if ($('.illustration-table tr:not(:first-child) td:first-child input:checked').length > 0) {
            var dynamicEdit = $('.dynamicEdit');
            dynamicEdit.addClass('dynamicEdit-act').attr('onclick', 'editElements("' + dynamicEdit.attr('data-submit-lang') + '")');
        } else {
            $('.dynamicEdit').removeClass('dynamicEdit-act').removeAttr('onclick');
        }
    });

    // Translition no spec simvol
    var val = $('input[data-symbol-code="ok"]');
    if (val.length > 0) {
        var input_code = $('input[name="symbol_code"]');

        val.keyup(function () {
            if (input_code.val() !== undefined) {
                input_code.val((translit(val.val().toLowerCase()))
                    .replace(/\s/g, '-')
                    .replace(/\*/g, '-')
                    .replace(/</g, '-')
                    .replace(/>/g, '-')
                    .replace(/\//g, '-')
                    .replace(/\)/g, '')
                    .replace(/\(/g, '')
                );
            }
        });
    }

    // Import replace
    $('select[name="type_import"]').change(function(){
        if($(this).val() == 'csv'){
            $('select[name="what_option"] option:not([disabled])').attr('disabled', true).hide();
            $('option[data-option="csv"]').removeAttr('disabled').attr('selected', true).show().trigger('click');
        } else {
            $('select[name="what_option"] option[disabled]').removeAttr('disabled').show();
            $('select[name="what_option"] option:first-child').attr('selected', true);
            $('option[data-option="csv"]').attr('disabled', true).attr('selected', false).hide();
        }
    });

    // Onchange and start get dbTable
    if ($('div[data-get-dbTable-ajax="ok"]').length > 0) {
        getDataBaseTable();
    }
});

function getDataBaseTable() {
    $.ajax({
        url: "/admin/setting/export-db/?ajax=ok",
        type: "POST",
        data: {},
        cache: false,
        success: function (response) {
            var res = JSON.parse(response);

            if (res['error'] === undefined) {
                var tables = '';
                for (var prop in res) {
                    tables += '<label><input type="checkbox" name="tables[]" value="' + res[prop] + '">' + res[prop] + '</label>';
                }
                $('div[data-result="tables"]').html(tables);
            } else {
                $('div[data-result="tables"]').html('Error Result!');
            }

        }
    });
}

function getIdElement(el) {
    $('#control').attr('data-input', $(el).parent('.upload_file').attr('id')).trigger('click');
}

function resetFile(control) {
    control.replaceWith(control.clone(true));
}

function removeImage(el) {
    var element = $(el).parents('.upload_file');
    var nameSubmit = $('#control').attr('data-name-submit');
    element.find('button + input').val('');
    element.find('button').html('<span class="icon-link"></span>' + nameSubmit).attr('onclick', 'getIdElement(this)');
    element.find('.photos').addClass('hidden').find('img').removeAttr('src');

    // delete_file
    if (element.find('input[name^="del"]').val() != '') {
        var del_files = element.find('input[name^="del"]').val();
    }

    if (del_files !== undefined && del_files.length > 0) {
        $.ajax({
            url: '/admin/setting/personal-interface/?delPhoto=ok&ajax=ok',
            type: "POST",
            data: {'file_delete': del_files},
            cache: false
        });
    }
}

function modalResizeImage(image, el) {
    var modalText = $('#caption');
    var nameSubmit = $('#control').attr('data-name-submit');
    var element = el;
    var activeAutoResize = (($.cookie('autoResizeImage') !== undefined) ? 'active' : '');
    var htmlModal = '<div id="modalResizeImage" class="modalResizeImage"><span class="close">&times;</span><div id="img" class="modal-content"><img src=""></div><div class="resize-image"><span class="autoResize icon-link ' + activeAutoResize + '"></span><div class="first-block"><i>Width:</i> <input type="number" min="10" name="width" value="' + image['width'] + '"><div class="submit-no">Remove</div></div><div class="last-block"><i>Height:</i> <input type="number" min="10" name="height" value="' + image['height'] + '"><div class="submit-ok">Save</div></div></div><div id="caption">' + image['name'] + '</div></div>';

    // Add modal
    $('main').append(htmlModal);
    $('.modal-content img').attr('src', image['src']);

    // Track clicks
    $('.modalResizeImage .close, .modalResizeImage .submit-no').click(function () {
        element.find('button + input').val('');
        element.find('button').html('<span class="icon-link"></span>' + nameSubmit).attr('onclick', 'getIdElement(this)');
        element.find('.photos').addClass('hidden').find('img').removeAttr('src');
        $('#modalResizeImage').remove();
    });

    $('.autoResize').click(function () {
        if ($.cookie('autoResizeImage') !== undefined) {
            $.removeCookie("autoResizeImage", {path: '/'});
            $(this).removeClass('active');
        } else {
            $.cookie("autoResizeImage", 'Y', {expires: 90, path: '/'});
            $(this).addClass('active');
        }
    });

    $('.modalResizeImage input[type="number"]').change(function () {
        var width = parseInt($(".modalResizeImage input[name='width']").val());
        var height = parseInt($(".modalResizeImage input[name='height']").val());

        if ($(".autoResize").is('.active')) {
            if ($(this).attr('name') == 'height') {
                width = parseInt((height * image['width']) / image['height']);
                $(".modalResizeImage input[name='width']").val(width);

            } else if ($(this).attr('name') == 'width') {
                height = parseInt((width * image['height']) / image['width']);
                $(".modalResizeImage input[name='height']").val(height);
            }
        }

        $('.modalResizeImage img').css({'width': width, 'height': height});
    });

    $('.submit-ok').click(function () {
        var parameter = {};
        var width = parseInt($(".modalResizeImage input[name='width']").val());
        var height = parseInt($(".modalResizeImage input[name='height']").val());
        parameter['image'] = image['name'];
        parameter['width'] = width;
        parameter['height'] = height;

        $.ajax({
            url: "/admin/setting/personal-interface/?ajax=ok&imgResize=ok",
            type: "POST",
            data: parameter,
            cache: false,
            success: function (response) {
                var res = JSON.parse(response);

                if (res['error'] !== undefined) {
                    element.find('button + input').val('');
                    element.find('button').html('<span class="icon-link"></span>' + nameSubmit).attr('onclick', 'getIdElement(this)');
                    element.find('.photos').addClass('hidden').find('img').removeAttr('src');
                    $('#modalResizeImage').remove();
                    alert(res['error']);
                } else {
                    element.find('button').attr('onclick', 'getIdElement(this)');
                    element.find('.photos img').attr('src', '/uploaded/temporarily/' + image['name']).css({'width': width});
                    $('#modalResizeImage').remove();
                }
            }
        });
    });
}

function addFile(el) {
    if ($(el).val().length > 1) {
        var formObj = new FormData($('#to_file')[0]);
        var nameSubmit = $('#control').attr('data-name-submit');
        var element = $('#' + $(el).attr('data-input'));
        formObj.append('data-priority-type', element.attr('data-priority-type'));

        // Animate
        $(element).find('button').removeAttr('onclick').html('<img src="/skins/admin/img/load-line.gif" alt="loading">');

        $.ajax({
            url: "/admin/setting/personal-interface/?getType=ok&ajax=ok",
            type: "POST",
            data: formObj,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                var res = JSON.parse(response);

                // delete_file
                if (element.find('input[name^="del"]').val() != '') {
                    var del_files = element.find('input[name^="del"]').val();
                }

                if (del_files !== undefined && del_files.length > 0) {
                    $.ajax({
                        url: '/admin/setting/personal-interface/?delFile=ok&ajax=ok',
                        type: "POST",
                        data: {'file_delete': del_files},
                        cache: false
                    });
                }

                if (res['error'] !== undefined) {
                    element.find('button + input').val('');
                    element.find('button').html('<span class="icon-link"></span>' + nameSubmit).attr('onclick', 'getIdElement(this)');
                    element.find('.photos').addClass('hidden').find('img').removeAttr('src');
                    alert('Error: ' + res['error']);
                } else {
                    if (res['type'] == 'image') {
                        $.ajax({
                            url: "/admin/setting/personal-interface/?addImage=ok&ajax=ok",
                            type: "POST",
                            data: formObj,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (response2) {
                                var res2 = JSON.parse(response2);

                                if (res2['error'] !== undefined) {
                                    element.find('button + input').val('');
                                    element.find('button').html('<span class="icon-link"></span>' + nameSubmit).attr('onclick', 'getIdElement(this)');
                                    element.find('.photos').addClass('hidden').find('img').removeAttr('src');
                                    alert('Error: ' + res2['error']);
                                } else {
                                    element.find('button + input[type="hidden"]').val(res2['image']['src']);
                                    element.find('button').html(res2['image']['name']);
                                    element.find('input[name^="del"]').val(res2['image']['src']);
                                    element.find('.photos').removeClass('hidden'); // update image
                                    modalResizeImage(res2['image'], element);
                                }
                            }
                        });
                    } else { // Files
                        $.ajax({
                            url: "/admin/setting/personal-interface/?addFile=ok&ajax=ok",
                            type: "POST",
                            data: formObj,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (response2) {
                                var res2 = JSON.parse(response2);

                                if (res2['error'] !== undefined) {
                                    element.find('button + input').val('');
                                    element.find('button').html('<span class="icon-link"></span>' + nameSubmit).attr('onclick', 'getIdElement(this)');
                                    alert('Error: ' + res2['error']);
                                } else {
                                    element.find('button + input[type="hidden"]').val(res2['file']);
                                    element.find('button').html(res2['file']).attr('onclick', 'getIdElement(this)');
                                    element.find('input[name^="del"]').val(res2['file']);
                                }
                            }
                        });
                    }
                }

                resetFile($("#control")); //reset file input
            }
        });
    }
}

function deleteList(el) {
    var e = window.event;

    if (e.shiftKey && e.keyCode == 46 && $(el).index() != 0) {
        $(el).remove();
    }
}

function openMenuUpdate(el) {
    var el_block = $(el).siblings('.menu-update');

    if ($(el_block).css('display') == 'none') {
        el_block.slideDown('middle').parents('tr').find('td').css('background', '#E2E7CB');
    }

    if ($(el_block).css('display') == 'block') {
        $(document).mouseup(function (e) {
            if (!$(el_block).is(e.target) && $(el_block).has(e.target).length === 0) {
                $(el_block).slideUp('middle').parents('tr').find('td').removeAttr('style');
            }

            return false;
        });
    }
}

function okFrom() {
    return confirm('You agree to action?');
}

function editElements(submit_lang) {
    var obj = {};
    var inputArr = [];
    var checked = $('.illustration-table tr:not(:first-child) td:first-child input:checked');
    var submit_lang = submit_lang.split('|');

    // Create array inputs
    $(checked).each(function (i, el) {
        inputArr.push($(el).val()); // add id element
    });

    obj['id'] = inputArr;

    $.ajax({
        url: window.location.pathname + '?ajax=ok&dynamicEditHtml=ok',
        type: "POST",
        data: obj,
        cache: false,
        success: function (response) {
            var res = JSON.parse(response);

            if (res.error !== undefined) {
                alert(res.error);
            } else {
                // Add submit
                $('.dynamicEdit').removeAttr('onclick').removeClass('dynamicEdit').html('<input type="submit" value="' + submit_lang[0] + '" name="el-save"><a href="' + document.location.pathname + '" class="no-save">' + submit_lang[1] + '</a>');

                $('.illustration-table').addClass('editTable');

                // Edit html code
                $('.illustration-table tr:not(:first-child) td:first-child input, input[name="all_cheked"]').attr('disabled', true); // disable checkbox

                for (var id in res.html) {
                    for (var elField in res.html[id]) {
                        $('.editTable tr[data-id="' + id + '"] td[data-field="' + elField + '"]').html(res.html[id][elField]);
                    }
                }
            }
        }
    });
}
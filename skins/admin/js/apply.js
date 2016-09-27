$(document).ready(function () {
    $('select[name="is_records_name"]').change(function () {
        if ($(this).val() == 1) {
            $('div[data-disabled="is_records_name"]').fadeIn('fast').removeClass('hidden');
        } else {
            $('div[data-disabled="is_records_name"]').fadeOut('fast').addClass('hidden');
        }
    });

    $('select[name="about_us"]').change(function () {
        if ($(this).val() == 7) {
            $('div[data-disabled="about_us"]').fadeIn('fast').removeClass('hidden');
        } else {
            $('div[data-disabled="about_us"]').fadeOut('fast').addClass('hidden');
        }
    });

    $('select[name="country"]').change(function () {
        if ($(this).val() == 'USA') {
            $('div[data-disabled="country-USA"]').fadeIn('fast').removeClass('hidden');
            $('div[data-disabled="country-All"]').hide().addClass('hidden');
        } else {
            $('div[data-disabled="country-USA"]').hide().addClass('hidden');
            $('div[data-disabled="country-All"]').fadeIn('fast').removeClass('hidden');
        }
    });


    // History
    $('.clear').click(function () {
        $('form[data-clear]')[0].reset();

        var element = $('#fileScan');
        element.find('button + input').val('');
        element.find('button').html('<span class="icon-link"></span>' + 'Select file').attr('onclick', 'getIdElement(this)');
    });

    // More photo add button
    $('.add_more').click(function () {
        var input = $('.upload_file[id^="fileScan_"]');
        var last_index = input.length - 1;
        ++last_index; // new id

        var html = '<div class="input-value upload_file" id="fileScan_' + last_index + '" data-priority-type="img"><button type="button" onclick="getIdElement(this)"><span class="icon-link"></span>Select file</button><input name="fileScan[]" type="hidden" value=""><input name="del[fileScan][]" type="hidden" value=""><div class="photos hidden"><span class="removeFile" onclick="removeImage(this)">x</span><img src=""></div></div>';

        input.last().after(html);
    });


    $('select[name="main_purpose"]').change(function () {
        var val = $(this).val();

        if (val == 0) {
            $('[data-disabled="main_purpose"]').hide().addClass('hidden');
            $('[data-section]').hide();
        } else {
            $('[data-section]').each(function () {
                if ($(this).attr('data-section') == val) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            $('label[data-check]').each(function () {
                if ($(this).attr('data-check') != val) {
                    $(this).removeAttr('class');
                } else {
                    $(this).addClass('hiddenIM').find('input').prop('checked', false);
                }
            });

            $('[data-disabled="main_purpose"]').show().removeClass('hidden');
        }
    });


    $('select[name="applicant_copy"]').change(function () {
        var val = $(this).val();

        if (val == 0) {
            $('[data-disabled="applicant_copy"]').hide().addClass('hidden');
            $('[data-section]').hide();
        } else {
            $('[data-section]').each(function () {
                if ($(this).attr('data-section') == val) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            $('[data-disabled="applicant_copy"]').show().removeClass('hidden');
        }
    });
});

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
            url: '/cab/education-history/?delFile=ok&ajax=ok',
            type: "POST",
            data: {'file_delete': del_files},
            cache: false
        });
    }
}


function getIdElement(el) {
    $('#control').attr('data-input', $(el).parent('.upload_file').attr('id')).trigger('click');
}

function resetFile(control) {
    control.replaceWith(control.clone(true));
}

function addFile(el) {
    if ($(el).val().length > 1) {
        var formObj = new FormData($('#to_file')[0]);
        var nameSubmit = $('#control').attr('data-name-submit');
        var element = $('#' + $(el).attr('data-input'));
        formObj.append('data-priority-type', element.attr('data-priority-type'));

        $.ajax({
            url: "/cab/education-history/?getType=ok&ajax=ok",
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
                        url: '/cab/education-history/?delFile=ok&ajax=ok',
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
                    $.ajax({
                        url: "/cab/education-history/?addImage=ok&ajax=ok",
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
                                element.find('.photos img').attr('src', res2['image']['src']);
                                element.find('.photos').removeClass('hidden'); // update image
                            }
                        }
                    });
                }

                resetFile($("#control")); //reset file input
            }
        });
    }
}
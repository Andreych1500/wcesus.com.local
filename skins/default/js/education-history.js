$(document).ready(function () {
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
            url: '/apply/education-history/?delFile=ok&ajax=ok',
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
            url: "/apply/education-history/?getType=ok&ajax=ok",
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
                        url: '/apply/education-history/?delFile=ok&ajax=ok',
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
                        url: "/apply/education-history/?addImage=ok&ajax=ok",
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
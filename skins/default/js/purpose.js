$(document).ready(function () {
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

            $('label[data-check]').each(function(){
                if($(this).attr('data-check') != val){
                    $(this).removeAttr('class');
                } else {
                    $(this).addClass('hiddenIM').find('input').prop('checked',false);
                }
            });

            $('[data-disabled="main_purpose"]').show().removeClass('hidden');
        }
    });
});
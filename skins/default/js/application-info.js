$(document).ready(function () {
    $('select[name="is_records_name"]').change(function () {
        if($(this).val() == 1){
            $('div[data-disabled="is_records_name"]').fadeIn('fast').removeClass('hidden');
        } else {
            $('div[data-disabled="is_records_name"]').fadeOut('fast').addClass('hidden');
        }
    });

    $('select[name="about_us"]').change(function(){
        if($(this).val() == 7){
            $('div[data-disabled="about_us"]').fadeIn('fast').removeClass('hidden');
        } else {
            $('div[data-disabled="about_us"]').fadeOut('fast').addClass('hidden');
        }
    });

    $('select[name="country"]').change(function(){
        if($(this).val() == 'USA'){
            $('div[data-disabled="country-USA"]').fadeIn('fast').removeClass('hidden');
            $('div[data-disabled="country-All"]').hide().addClass('hidden');
        } else {
            $('div[data-disabled="country-USA"]').hide().addClass('hidden');
            $('div[data-disabled="country-All"]').fadeIn('fast').removeClass('hidden');
        }
    });
});
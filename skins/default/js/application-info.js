$(document).ready(function () {
    $('select[name="is_records_name"]').change(function () {
        if ($(this).val() == 2) {
            $('div[data-hidden="is_records_name"]').show().removeClass('hidden');
        } else {
            $('div[data-hidden="is_records_name"]').hide().addClass('hidden');
        }
    });

    $('select[name="country"]').change(function () {
        if ($(this).val() != 'USA') {
            $('[data-section="All"]').show();
            $('[data-section="USA"]').hide();
        } else {
            $('[data-section="All"]').hide();
            $('[data-section="USA"]').show();
        }
    });

    $('select[name="about_us"]').change(function () {
        if ($(this).val() == 7) {
            $('div[data-hidden="about_us"]').show().removeClass('hidden');
        } else {
            $('div[data-hidden="about_us"]').hide().addClass('hidden');
        }
    });

    $('select[name="services_WCES"]').change(function () {
        if ($(this).val() == 2) {
            $('div[data-hidden="services_WCES"]').show().removeClass('hidden');
        } else {
            $('div[data-hidden="services_WCES"]').hide().addClass('hidden');
        }
    });
});
$(document).ready(function () {
    $('select[name="applicant_copy"]').change(function () {
        var val = $(this).val();

        if (val == 0) {
            $('[data-hidden="applicant_copy"]').hide().addClass('hidden');
            $('[data-section]').hide();
        } else {
            $('[data-section]').each(function () {
                if ($(this).attr('data-section') == val) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            $('[data-hidden="applicant_copy"]').show().removeClass('hidden');
        }
    });
});
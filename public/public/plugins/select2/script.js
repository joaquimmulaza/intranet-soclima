/**
 * Created by Rafael on 07/02/2020.
 */
$(document).ready(function() {
    $('.js-basic-multiple').select2();
    $('select').each(function(){
        $(this).select2({
            placeholder: $(this).attr('placeholder'),
            width: 'style'
        });

    });
});

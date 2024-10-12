/**
 * Created by Rafael on 01/02/2021.

 */
$(document).ready(function(){
    $('.file-upload').file_upload();
    $('input#input_text, textarea#textarea1').characterCounter();

    $('[data-toggle="tooltip"]').tooltip();
});

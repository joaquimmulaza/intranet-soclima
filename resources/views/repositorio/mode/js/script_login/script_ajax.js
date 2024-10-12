/**
 * Created by Rafael on 08/08/2020.
 */
$(function(){
    $('form[name="formLogin"]').submit(function(event){
        event.preventDefault();
        //var email = $(this).find('input#email').val();
        //var pass = $(this).find("input#password").val();

        $.ajax({
            url: "{{route('admin.login.do')}}",
            type: "post",
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response){
                if(response.success === true){
                    window.location.href = "{{ route('home') }}";
                }else {
                    $('.messageBox').removeClass('d-none').html(response.message);
                }
                console.log(response);
            }
        });
    });
});
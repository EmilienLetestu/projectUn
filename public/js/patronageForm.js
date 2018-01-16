/**
 * Created by Emilien on 16/01/2018.
 */
$(document).ready(function () {

    $("#newPatronageBtn").click(function (){
        var validate = true;
        var patronage    = $("#newPatronageForm input[type='text']");

        if(patronage.val().length < 3 || patronage.val().length > 30){
            patronage.css('border-color','#F54041');
            $('#invalid_patronage').show();
            $('#invalid_patronage_icon').show();
            $('#valid_patronage_icon').hide();
            validate = false;
        }
        else
        {
            patronage.css('border-color','#5fdda1');
            $('#invalid_patronage').hide();
            $('#invalid_patronage_icon').hide();
            $('#valid_patronage_icon').show();
        }
        return validate;
    });
});

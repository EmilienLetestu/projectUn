/**
 * Created by Emilien on 25/10/2017.
 */
$(document).ready(function () {

  //check form value before submit
    // login form
    $('#registerBtn').click(function () {

        var validate = true;
        var name    = $('#register_name');
        var surname = $('#register_surname');
        var pswd    = $('#register_pswd');
        var confirm = $('#register_confirmPswd');

        if(name.val().length < 3)
        {
            name.css('border-color','#F54041');
            $('#invalid_name').show();
            $('#invalid_name_icon').show();
            $('#valid_name_icon').hide();
            validate = false;
        }
        else
        {
            name.css('border-color','#5fdda1');
            $('#invalid_name').hide();
            $('#invalid_name_icon').hide();
            $('#valid_name_icon').show();
        }
        if(surname.val().length < 3)
        {
            surname.css('border-color','#F54041');
            $('#invalid_surname').show();
            $('#invalid_surname_icon').show();
            $('#valid_surname_icon').hide();
            validate = false;
        }
        else
        {
            surname.css('border-color','#5fdda1');
            $('#invalid_surname').hide();
            $('#invalid_surname_icon').hide();
            $('#valid_surname_icon').show();

        }
        if(pswd.val().length < 6)
        {
            pswd.css('border-color','#F54041');
            $('#invalid_pswd').show();
            $('#invalid_pswd_icon').show();
            $('#valid_pswd_icon').hide();
            validate = false;
        }
        else
        {
            pswd.css('border-color','#5fdda1');
            $('#invalid_pswd').hide();
            $('#invalid_pswd_icon').hide();
            $('#valid_pswd_icon').show();
        }
        if(confirm !== pswd)
        {
            confirm.css('border-color','#F54041');
            $('#invalid_confirm').show();
            $('#invalid_confirm_icon').show();
            $('#valid_confirm_icon').hide();
            validate = false;
        }
        else
        {
            confirm.css('border-color','#5fdda1');
            $('#invalid_confirm').hide();
            $('#invalid_confirm_icon').hide();
            $('#valid_confirm_icon').show();
        }
        return validate;

    });


});
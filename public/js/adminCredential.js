
/**
 * Created by Emilien on 16/01/2018.
 */
$(document).ready(function () {

    $("#updateAdministratorBtn").click(function () {

        var pswd    = $('#administrator_credential_pswd');
        var confirm = $('#administrator_credential_confirmPswd');

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
        if(confirm.val() !== pswd.val())
        {
            confirm.css('border-color','#F54041');
            $('#invalid_confirm').show();
            $('#invalid_confirm_icon').show();
            $('#valid_confirm_icon').hide();
            validate = false;
        }
        else if(pswd.val() == "")
        {
            $('#invalid_confirm').hide();
            $('#invalid_confirm_icon').hide();
            $('#valid_confirm_icon').hide();
            validate = false;
        }
        return validate;

    });

    //lost password form
    $('#lostPswdBtn').click(function () {
        var validate = true;
        var email   = $('#ask_new_pswd_email');

        if(!regex.test(email.val()))
        {
            email.css('border-color','#F54041');
            $('#invalid_email').show();
            $('#invalid_email_icon').show();
            $('#valid_email_icon').hide();
            validate = false;
        }
        else
        {
            email.css('border-color','#5fdda1');
            $('#invalid_email').hide();
            $('#invalid_email_icon').hide();
            $('#valid_email_icon').show();
        }
        return validate;

    });

    //new password form
    $('#newPswdBtn').click(function (){

        var validate = true;
        var pswd     = $('#new_pswd_pswd');
        var confirm  = $('#new_pswd_confirmPswd');

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
        if(confirm.val() !== pswd.val())
        {
            confirm.css('border-color','#F54041');
            $('#invalid_confirm').show();
            $('#invalid_confirm_icon').show();
            $('#valid_confirm_icon').hide();
            validate = false;
        }
        else if(pswd.val() == "")
        {
            $('#invalid_confirm').hide();
            $('#invalid_confirm_icon').hide();
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

})
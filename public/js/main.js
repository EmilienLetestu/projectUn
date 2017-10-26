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
        var email   = $('#register_email');
        var regex   =  /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;

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

    $('#lostPswdBtn').click(function () {
        var validate = true;
        var email   = $('#ask_new_pswd_email');
        var regex   =  /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;

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


});
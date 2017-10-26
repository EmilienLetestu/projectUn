/**
 * Created by Emilien on 25/10/2017.
 */
$(document).ready(function () {

    var regex   =  /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    var phoneRegex = /^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$/;
    //check form value before submit
    // register form
    $('#registerBtn').click(function () {

        var validate = true;
        var name    = $('#register_name');
        var surname = $('#register_surname');
        var pswd    = $('#register_pswd');
        var confirm = $('#register_confirmPswd');
        var email   = $('#register_email');

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

    //story form
    $('#addStoryBtn').click(function () {
        var validate = true;
        var title    = $('#story_title');
        var email    = $('#story_contactEmail');
        var place    = $('#story_contactPlace');
        var phone    = $('#story_contactPhone');
        var investor = $('#story_investor');

        if(title.val().length < 3 || title.val().length > 100)
        {

            title.css('border-color','#F54041');
            $('#invalid_title').show();
            $('#invalid_title_icon').show();
            $('#valid_title_icon').hide();
            validate = false;
        }
        else
        {
            title.css('border-color','#5fdda1');
            $('#invalid_title').hide();
            $('#invalid_title_icon').hide();
            $('#valid_title_icon').show();
        }
        if(investor.val().length > 0 && investor.val().length < 2 || investor.val().length > 100)
        {
            investor.css('border-color','#F54041');
            $('#invalid_investor').show();
            $('#invalid_investor_icon').show();
            $('#valid_investor_icon').hide();
            validate = false;
        }
        else if(investor.val().length == 0)
        {
            $('#invalid_investor').hide();
            $('#invalid_investor_icon').hide();
            $('#valid_investor_icon').hide();
        }
        else
        {
            investor.css('border-color','#5fdda1');
            $('#invalid_investor').hide();
            $('#invalid_investor_icon').hide();
            $('#valid_investor_icon').show();
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
        if(place.val().length > 0 && place.val().length < 2 || place.val().length > 100)
        {
            place.css('border-color','#F54041');
            $('#invalid_place').show();
            $('#invalid_place_icon').show();
            $('#valid_place_icon').hide();
            validate = false;
        }
        else if(place.val().length == 0)
        {
            $('#invalid_place').hide();
            $('#invalid_place_icon').hide();
            $('#valid_place_icon').hide();
        }
        else
        {
            place.css('border-color','#5fdda1');
            $('#invalid_place').hide();
            $('#invalid_place_icon').hide();
            $('#valid_place_icon').show();
        }
        if(phone.val().length !==0 && !phoneRegex.test(phone.val()))
        {
            phone.css('border-color','#F54041');
            $('#invalid_phone').show();
            $('#invalid_phone_icon').show();
            $('#valid_phone_icon').hide();
            validate = false;
        }
        else if(phone.val().length == 0)
        {
            $('#invalid_phone').hide();
            $('#invalid_phone_icon').hide();
            $('#valid_phone_icon').hide();
        }
        else
        {
            phone.css('border-color','#5fdda1');
            $('#invalid_phone').hide();
            $('#invalid_phone_icon').hide();
            $('#valid_phone_icon').show();
        }

        return validate;
    });


});
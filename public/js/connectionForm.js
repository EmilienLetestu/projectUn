/**
 * Created by Emilien on 25/10/2017
 */
$(document).ready(function () {

    //will match a mail pattern
    var regex =  /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;

    var mixLetterAndNumber = /^(?=.*[a-zA-z])(?=.*\d)/;

    var series = /(\d)\1{3}/;

    //get url
    var path = window.location.pathname.split('/');

    //check form value before submit
    // register form
    $(':input[type="submit"]').prop('disabled', true);

    $(".notBlank").keyup(function () {
       disable()
    });

    function disable(){
        var validate = true;
        $(".notBlank").each(function () {
            var input = $(this);
            if($(this).val() !== '') {
                $(':input[type="submit"]').prop('disabled', false);
            } else {
                $(':input[type="submit"]').prop('disabled', true);
                validate = false;
            }
            return validate;
        });
    }

    if(path[1] === 'login'){
        if($('.alert-warning').length && $('.alert-warning').html()==='User account is disabled.'){
            $('.alert-warning').html('Please activate you\'re account first, check your mail box');
        }
    }

    if(path[1] === 'register'){
        $('#invalid_pswd').show().css('color','#6a6a6a');

        if($('#register_claimEdit').is(':checked')){

            $('#engagement').show();
            $('#profession').show();
        }

        $('#register_pswd').keyup(function () {
            if($('#register_pswd').val().length >= 6)
            {
                $('#confirm').show();
                $('#invalid_pswd').hide();
            }
        });

        $('#register_claimEdit').change(function () {
            if(this.checked){
                $('#engagement').show();
                $('#profession').show();
            }
        });

        // count word on register form text area
        $("#register_engagement").keyup(function(){

            var words = $.trim($('#register_engagement').val()).match(/\S+/g);
            var result = words ? words.length : 0;
            $('#wordCount').text(result + '/300');
            if(result > 2){
                $('#wordCount').css('color','#F58835')
            }
        });

        $('#registerBtn').click(function () {

            var name       = $('#register_name');
            var surname    = $('#register_surname');
            var pswd       = $('#register_pswd');
            var confirm    = $('#register_confirmPswd');
            var email      = $('#register_email');
            var engagement = $('#register_engagement');
            var wordCount  = $('#wordCount').text();
            var getWords   = wordCount.split('/');
            var words      = parseInt(getWords[0]);
            var validate   = true;

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
            if(pswd.val().length < 6 || !mixLetterAndNumber.test(pswd.val()) || series.test(pswd.val()))
            {
                pswd.css('border-color','#F54041');
                $('#invalid_pswd').show().css('color','#F54041');
                $('#invalid_pswd_icon').show();
                $('#valid_pswd_icon').hide();
                series.test(pswd.val()) ? $('#invalid_pswd').text('no series allowed ex:111111') : null;
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
                confirm.show();
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
            if(words > 300)
            {
                engagement.css('border-color','#F54041');
                $('#valid_engagement_icon').hide();
                validate = false;
            }
            else
            {
                engagement.css('border-color','#5fdda1');
                $('#valid_engagement_icon').show();
            }
            return validate;

        });
    }

    //lost password form
    if(path[1] === 'lost-password'){
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
    }

    //new password form
    if(path.length > 2){
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
    }
});





/**
 * Created by Emilien on 07/12/2017.
 */
$(document).ready(function () {

    //pre-fill email input
    var hiddenMail = $('#userMail').val();
    $('#story_contactEmail').val(hiddenMail);

    //will match a mail pattern
    var regex = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    //will match phone number patter with or without international prefix
    var phoneRegex = /^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$/;

    //story form


    $('#addStoryBtn').click(function () {
        var validate = true;
        var title    = $('#story_title');
        var email    = $('#story_contactEmail');
        var place    = $('#story_contactPlace');
        var phone    = $('#story_contactPhone');
        var investor = $('#story_investor');
        //get number of word from count plugin for "abstract"
        var abstract = $('#abstract').find('.mce-wordcount');
        var splitAbstract = abstract.text().split(' ');
        var trimAbstrac  = splitAbstract[0].trim();
        var countAbstract = parseInt(trimAbstrac);
        //get number of word from count plugin for "abstract"
        var plot = $('#plot').find('.mce-wordcount');
        var splitPlot = plot.text().split(' ');
        var trimPlot  = splitPlot[0].trim();
        var countPlot = parseInt(trimPlot);

        if(title.val().length < 5 || title.val().length > 100)
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
        if(countAbstract == 0 ||countAbstract > 70)
        {
            $('#abstract').find('.mce-tinymce').css('border-color','#F54041');
            $('#invalid_abstract').show();
            $('#invalid_abstract_icon').show();
            $('#valid_abstract_icon').hide();
            validate = false;
        }
        else
        {
            $('#abstract').find('.mce-tinymce').css('border-color','#5fdda1');
            $('#invalid_abstract').hide();
            $('#invalid_abstract_icon').hide();
            $('#valid_abstract_icon').show();
        }
        if(countPlot == 0 || countPlot > 200)
        {
            $('#plot').find('.mce-tinymce').css('border-color','#F54041');
            $('#invalid_plot').show();
            $('#invalid_plot_icon').show();
            $('#valid_plot_icon').hide();
            validate = false;
        }
        else
        {
            $('#plot').find('.mce-tinymce').css('border-color','#5fdda1');
            $('#invalid_plot').hide();
            $('#invalid_plot_icon').hide();
            $('#valid_plot_icon').show();
        }
        return validate;
    });

    $('#showPart1').click(function () {
        $('.part1').toggle();
    });
    $('#showPart2').click(function () {
        $('.part2').toggle();
    });
    $('#showPart3').click(function () {
        $('.part3').toggle();
    });

});


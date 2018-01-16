/**
 * Created by Emilien on 16/01/2018.
 */
$(document).ready(function () {

    $("#createLegalBtn").click(function () {

        var validate = true;
        var title = $("#add_legal_title");

        if(title.val().length < 3 || title.val().length > 30) {

            title.css('border-color','#F54041');
            $('#invalid_legal').show();
            $('#invalid_legal_icon').show();
            $('#valid_legal_icon').hide();
            validate = false;
        }
        else {
            title.css('border-color','#5fdda1');
            $('#invalid_legal').hide();
            $('#invalid_legal_icon').hide();
            $('#valid_legal_icon').show();
        }

        return validate;
    })


});
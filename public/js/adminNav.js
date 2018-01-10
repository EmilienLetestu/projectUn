/**
 * Created by Emilien on 09/01/2018.
 */
$(document).ready(function () {


    var marginPush = '250px';
    var leftPull = '-250px';

    if ($(window).width() < 640) {
         marginPush = '0';
    }

    if($(window).width() > 640) {
        $("br").remove();
    }

    $("#open").click(function () {
        $("#adminNav").css('left','0');
        $(".page-wrap").css('margin-left',marginPush);
        $(this).hide();
    });

    $("#closeNav").click(function () {
        $("#adminNav").css('left',leftPull);
        $(".page-wrap").css('margin-left','0');
        $("#open").show();
    });
});
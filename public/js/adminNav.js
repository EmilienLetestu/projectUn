/**
 * Created by Emilien on 09/01/2018.
 */
$(document).ready(function () {


    var marginPush = '250px';
    var leftPull = '-250px';

    if ($(window).width() < 640) {
         marginPush = '100px';
         leftPull = '-100px'
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
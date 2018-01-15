/**
 * Created by Emilien on 09/01/2018.
 */
$(document).ready(function () {


    var marginPush = '250px';
    var leftPull = '-250px';
    var iconLeft = '250px';
    $('#open').addClass("fa fa-arrow-right");


    if ($(window).width() < 700) {
         marginPush = '0';
         iconLeft   = '200px'
    }

    if($(window).width() > 700) {
        $("br").remove();
    }

    $(window).scroll(function() {

        $("#open").stop().hide().fadeIn();
    });

    $("#adminNav a").each(function () {
        if(window.location.pathname !== $(this).attr("href")){
            var path = window.location.pathname;
            var spiltIt = path.split('/');

            var id = path === '/admin' ? '#admin' : '#' + spiltIt[2];

            $(this).css('color','rgba(255,255,255,0.6)');
            $("#adminNav i").not(id).css('color','rgba(255,255,255,0.6)');
        }
    });

    $("#open").click(function () {
        if($(this).hasClass("fa-arrow-right")){
            $(this).addClass("fa-arrow-left").removeClass("fa-arrow-right");
            $("#adminNav").css('left','0');
            $(this).css({'left': iconLeft,'transition':'0.5s'});
            $(".page-wrap").css('margin-left',marginPush);
        } else {
            $(this).addClass("fa-arrow-right").removeClass("fa-arrow-left");
            $(this).css({'left':'0','transition':'0.5s'});
            $("#adminNav").css('left',leftPull);
            $(".page-wrap").css({'margin-left':'0','transition':'0.5s' });
        }
    });
});
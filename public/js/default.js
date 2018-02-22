/**
 * Created by Emilien on 11/01/2018.
 */
$(document).ready(function () {

    if($(".alert").length){
        $(window).scroll(function () {
            $(".alert").remove();
        })
    }

    if($("#adminPath a").length){
        var path = window.location.pathname.split('/');
        path[1] === 'admin' ? $("#adminPath a").attr('id','active') : null;
    }

    $('.fa-home').on('click touchstart', function() {
        window.location.pathname = ('/');
    })

});

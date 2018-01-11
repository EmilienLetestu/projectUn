/**
 * Created by Emilien on 11/01/2018.
 */
$(document).ready(function () {

    if($(".alert").length){
        $(window).scroll(function () {
            $(".alert").remove();
        })
    };
});
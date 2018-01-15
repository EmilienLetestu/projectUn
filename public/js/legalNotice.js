/**
 * Created by Emilien on 15/01/2018.
 */
$(document).ready(function () {

    $(".termBody:first").show();
    $(".toggleIcon:first").addClass("fa-caret-down").removeClass("fa-caret-right");

    $(".toggleIcon").click(function () {
        var id = this.id.split('-');
        var toToggle = "#term-" + id[1];
        if($(this).hasClass("fa-caret-right")){
           $(this).addClass("fa-caret-down").removeClass("fa-caret-right");
        } else {
            $(this).addClass("fa-caret-right").removeClass("fa-caret-down");
        }
        $("i", this).toggleClass("fa fa-caret-right fa fa-caret-down");
        $(toToggle).toggle();
    })
});
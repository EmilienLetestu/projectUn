/**
 * Created by Emilien on 02/01/2018.
 */
$(document).ready(function(){

    $('input[type=checkbox]').change(function(){
        var rowToHide = $(this).val();
        $('.'+rowToHide).toggle();
    })

});
/**
 * Created by Emilien on 02/01/2018.
 */
$(document).ready(function(){

    $('input[type=checkbox]').change(function(){
        var rowToHide = $(this).val();
        $('.'+rowToHide).toggle();
    });

    $('#filters').change(function(){
        var className = $(this).val();
        var row = $('.table tbody tr');
        var reset = $('#filters option[value=" "]');
        reset.text('reset filter').removeAttr('selected');
        if(reset.is(':selected')){
            reset.text('choose a filter')
        }
        row.show();
        row.each(function () {
            if($(this).not('.'+className)){
                $(this).not('.'+className).hide();
            }
        });
    });

});
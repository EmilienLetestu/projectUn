/**
 * Created by Emilien on 08/01/2018.
 */
$(document).ready(function () {

    $('.trigger').click(function () {
        $('.modalUrl').show();
        $('.modalOverlay').show();
    });

    $('.closeModal').click(function () {
        $('.modalUrl').hide();
        $('.modalOverlay').hide();
    });

});

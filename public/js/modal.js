$(document).ready(function () {

    $('.trigger button').click(function () {
        $('.modalForm').show();
        $('.modalOverlay').show();
    });

    $('.closeModal').click(function () {
        $('.modalForm').hide();
        $('.modalOverlay').hide();
    });
});
$(document).ready(function () {

    $('.trigger button').click(function () {
        $('.modalForm').show();
        $('.modalOverlay').show();
    });

    $('.closeModal').click(function () {
        $('.modalForm').hide();
        $('.modalOverlay').hide();
    });

    $('.update').click(function (){
        alert($(this).attr("value"));
        var id = $(this).attr("value");

        $('#topicForm input[type=hidden]').val(id);
    });

    if($('.help-block').length){
        $('.modalForm').show();
        $('.modalOverlay').show();
    }

});
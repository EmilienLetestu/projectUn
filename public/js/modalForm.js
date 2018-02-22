$(document).ready(function () {

    var path         = window.location.pathname;
    var entity       = path.split('/');
    var hidden       =  $('.modalForm input[type=hidden]');

    $('.trigger button').click(function () {
        $('.modalForm').show();
        $('.modalOverlay').show();
    });

    $('.closeModal').click(function () {
        $('.modalForm').hide();
        $('.modalOverlay').hide();

        if(hidden.val() !== " " && path !== '/admin')
        {
            $('.modalForm input[type=hidden]').val(' ');
            $('.modalForm input[type=text]').val(' ');
            $('.modalForm label').text('Enter ' + entity[2] + ' name');
        }

        //if validation message in pop up => hide them
        $('.valid_sign').hide();
        $('.invalid_sign').hide();
        $('.invalid').hide();
    });

    $('.update').click(function (){
        var id           = $(this).attr("value");
        var entityType   = $('#entityType'+id).html();
        hidden.val(id);
        $('.modalForm input[type=text]').val(entityType.trim());
        $('.modalForm label').text('Change '+entity[2]);
    });

    if($('.help-block').length){
        $('.modalForm').show();
        $('.modalOverlay').show();
    }

});

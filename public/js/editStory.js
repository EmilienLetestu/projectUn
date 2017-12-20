$(document).ready(function () {

    var originalPlot     = $('#originalPlot').val();
    var originalTitle    = $('#originalTitle').val();
    var originalAbstract = $('#originalAbstract').val();

    $('#editPlot textarea').val(originalPlot);
    $('#editAbstract textarea').val(originalAbstract);
    $('#editTitle input').val(originalTitle);


});

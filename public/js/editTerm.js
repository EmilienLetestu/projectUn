/**
 * Created by Emilien on 14/01/2018.
 */
$(document).ready(function () {

    var originalTitle   = $('#originalTermTitle').val();
    var originalArticle = $('#originalTermArticle').val();
    var originalStatus  = $('#originalTermStatus').val();

    $('#editTermTitle input').val(originalTitle);
    $('#editTermArticle textarea').val(originalArticle);
    $('#editTermStatus select').val(originalStatus);

});
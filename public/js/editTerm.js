/**
 * Created by Emilien on 14/01/2018.
 */
$(document).ready(function () {

    var originalTitle    = $('#originalTermTitle').val();
    var originalArticle = $('#originalTermArticle').val();

    $('#editTermTitle input').val(originalTitle);
    $('#editTermArticle textarea').val(originalArticle);

});
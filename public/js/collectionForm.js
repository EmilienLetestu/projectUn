/**
 * Created by Emilien on 25/10/2017.
 */
$(document).ready(function() {
    var $container = $('#story_urls');
    var index = $container.find(':input').length;

    $('#add_url').click(function(e) {

        addUrl($container);
        e.preventDefault();
        return false;
    });
    if (index == 0) {

        addUrl($container);

    } else {
        $container.children('div').each(function() {
            addDeleteLink($(this));
        });

    }
    function addUrl($container) {
        var template = $container.attr('data-prototype')
                .replace(/__name__label__/g, 'link n°' + (index+1))
                .replace(/__name__/g,        index)
            ;

        var $prototype = $(template);
        addDeleteLink($prototype);
        $container.append($prototype);
        index++;
    }

    function addDeleteLink($prototype) {
        var $deleteLink = $('<a href="#" class="btn btn-danger">Supprimer</a>');
        $prototype.append($deleteLink);
        $deleteLink.click(function(e) {
            $prototype.remove();
            e.preventDefault();
            return false;
        });
    }
});
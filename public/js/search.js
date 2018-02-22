/**
 * Created by Emilien on 07/12/2017.
 */
$(document).ready(function () {


    var path = window.location.pathname;
    var split = path.split("/");

    if(split.length === 8)
    {
        var worldArea = split[4];
        var country   = split[5];
        var topic     = split[6];
        var patronage = split[7];

        worldArea !== 'all' ? $('#search_worldArea').val(worldArea) : null;
        country   !== 'all' ? $('#search_country').val(country) : null;
        topic     !== 'all' ? $('#search_topic').val(topic) : null;
        patronage !== 'all' ? $('#search_patronage').val(patronage) : null;
        $("#resetBtn").show();

        if($(window).width() < 768) {
            $("#browseStories").css('padding-top', '20%');
        }
    }
});

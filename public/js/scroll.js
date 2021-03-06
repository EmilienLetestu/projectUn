/**
 * Created by Emilien on 08/01/2018.
 */
$(document).ready(function () {

    var scrollHandle = 0,
        scrollStep = 5,
        parent = $(".slider");



    if(window.location.pathname === '/' && $(window).width() > 700) {
       $(".panner").remove();
    }

    //Start the scrolling process
    $(".panner").on("mouseenter touchstart", function () {
        var data = $(this).data('scrollModifier'),
            direction = parseInt(data, 10);

        $(this).addClass('active');

        startScrolling(direction, scrollStep);
    });

    //stop scrolling
    $(".panner").on("mouseleave touchend", function () {
        stopScrolling();
        $(this).removeClass('active');
    });

    //Actual handling of scrolling
    function startScrolling(modifier, step) {
        if (scrollHandle === 0) {
            scrollHandle = setInterval(function () {
                var newOffset = parent.scrollLeft() + (scrollStep * modifier);

                parent.scrollLeft(newOffset);
            }, 10);
        }
    }

    function stopScrolling() {
        clearInterval(scrollHandle);
        scrollHandle = 0;
    }
});

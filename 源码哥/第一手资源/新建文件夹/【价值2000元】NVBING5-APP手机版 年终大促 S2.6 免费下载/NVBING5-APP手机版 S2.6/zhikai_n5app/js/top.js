$(document).ready(function() {
    $(".n5qj_top").hide();
    $(function() {
        $(window).scroll(function() {
            if ($(window).scrollTop() > 200) {
                $(".n5qj_top").fadeIn(500);
            } else {
                $(".n5qj_top").fadeOut(500);
            }
        });
        $(".n5qj_top").click(function() {
            $('body,html').animate({
                scrollTop: 0
            }, 100);
            return false;
        });
    });
});
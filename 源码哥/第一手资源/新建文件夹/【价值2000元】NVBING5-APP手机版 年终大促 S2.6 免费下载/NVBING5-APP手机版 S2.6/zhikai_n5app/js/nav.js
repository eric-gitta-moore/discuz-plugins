$(function () {

    var left = $('.cltxy');
    var right = $('.n5qj_bkcl');
	var down = $('.down');
    var up = $('.up');
    var bg = $('.bgDiv');
    var leftNav = $('.n5qj_cldh');
    var rightNav = $('.n5sq_clzt');
	var downNav = $('.downNav');
    var upNav = $('.upNav');

    showNav(left, leftNav, "left");
    showNav(right, rightNav, "right");
	showNav(up, upNav, "up");
    showNav(down, downNav, "down");

	
    function showNav(btn, navDiv, direction) {
        btn.on('click', function () {
            bg.css({
                display: "block",
                transition: "opacity .5s"
            });
            if (direction == "right") {
                navDiv.css({
                    right: "0px",
                    transition: "right .5s"
                });
            } else if (direction == "left") {
                navDiv.css({
                    left: "0px",
                    transition: "left .5s"
                });
            } else if (direction == "up") {
                navDiv.css({
                    top: "0px",
                    transition: "top .5s"
                });
            } else if (direction == "down") {
                navDiv.css({
                    bottom: "0px",
                    transition: "bottom .5s"
                });
            }

			
        });
    }

    bg.on('click', function () {
        hideNav();
    });

    function hideNav() {
        leftNav.css({
            left: "-280px",
            transition: "left .2s"
        });
        rightNav.css({
            right: "-280px",
            transition: "right .2s"
        });
		upNav.css({
            top: "-40%",
            transition: "top .2s"
        });
        downNav.css({
            bottom: "-50%",
            webkitTransition:"bottom .2s",
            oTransition:"bottom .2s",
            mozTransition:"bottom .2s",
            transition: "bottom .2s"
        });
        bg.css({
            display: "none",
            transition: "display 1s"
        });
    }
});
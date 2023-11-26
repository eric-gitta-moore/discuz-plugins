$(function(){
    $(".ztfl_fllb").css("left",sessionStorage.left+"px");
    var nav_w=$(".ztfl_fllb li").first().width();
    $(".ztfl_glys").width(nav_w);
    $(".ztfl_fllb li").on('click', function(){
        nav_w=$(this).width();
        $(".ztfl_glys").stop(true);
        $(".ztfl_glys").animate({left:$(this).position().left},300);
        $(".ztfl_glys").animate({width:nav_w});
        $(this).addClass("ztfl_glxz").siblings().removeClass("ztfl_glxz");
        var fn_w = ($(".n5sq_ztfl").width() - nav_w) / 2;
        var fnl_l;
        var fnl_x = parseInt($(this).position().left);
        if (fnl_x <= fn_w) {
            fnl_l = 0;
        } else if (fn_w - fnl_x <= flb_w - fl_w) {
            fnl_l = flb_w - fl_w;
        } else {
            fnl_l = fn_w - fnl_x;
        }
        $(".ztfl_fllb").animate({
            "left" : fnl_l
        }, 300);
        sessionStorage.left=fnl_l;
        var c_nav=$(this).find("a").text();
        navName(c_nav);
    });
    var fl_w=$(".ztfl_fllb").width();
    var flb_w=$(".ztfl_flzt").width();
    $(".ztfl_fllb").on('touchstart', function (e) {
        var touch1 = e.originalEvent.targetTouches[0];
        x1 = touch1.pageX;
        y1 = touch1.pageY;
        ty_left = parseInt($(this).css("left"));
    });
    $(".ztfl_fllb").on('touchmove', function (e) {
        var touch2 = e.originalEvent.targetTouches[0];
        var x2 = touch2.pageX;
        var y2 = touch2.pageY;
        if(ty_left + x2 - x1>=0){
            $(this).css("left", 0);
        }else if(ty_left + x2 - x1<=flb_w-fl_w){
            $(this).css("left", flb_w-fl_w);
        }else{
            $(this).css("left", ty_left + x2 - x1);
        }
        if(Math.abs(y2-y1)>0){
            e.preventDefault();
        }
    });
});
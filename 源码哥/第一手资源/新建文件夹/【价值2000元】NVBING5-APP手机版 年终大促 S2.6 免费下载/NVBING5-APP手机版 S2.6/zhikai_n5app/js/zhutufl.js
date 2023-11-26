var jq = jQuery.noConflict(); 
jq(function(){
    jq(".ztfl_fllb").css("left",sessionStorage.left+"px");
    var nav_w=jq(".ztfl_fllb li").first().width();
    jq(".ztfl_glys").width(nav_w);
    jq(".ztfl_fllb li").on('click', function(){
        nav_w=jq(this).width();
        jq(".ztfl_glys").stop(true);
        jq(".ztfl_glys").animate({left:jq(this).position().left},300);
        jq(".ztfl_glys").animate({width:nav_w});
        jq(this).addClass("ztfl_glxz").siblings().removeClass("ztfl_glxz");
        var fn_w = (jq(".n5sq_ztfl").width() - nav_w) / 2;
        var fnl_l;
        var fnl_x = parseInt(jq(this).position().left);
        if (fnl_x <= fn_w) {
            fnl_l = 0;
        } else if (fn_w - fnl_x <= flb_w - fl_w) {
            fnl_l = flb_w - fl_w;
        } else {
            fnl_l = fn_w - fnl_x;
        }
        jq(".ztfl_fllb").animate({
            "left" : fnl_l
        }, 300);
        sessionStorage.left=fnl_l;
        var c_nav=jq(this).find("a").text();
        navName(c_nav);
    });
    var fl_w=jq(".ztfl_fllb").width();
    var flb_w=jq(".ztfl_flzt").width();
    jq(".ztfl_fllb").on('touchstart', function (e) {
        var touch1 = e.originalEvent.targetTouches[0];
        x1 = touch1.pageX;
        y1 = touch1.pageY;
        ty_left = parseInt(jq(this).css("left"));
    });
    jq(".ztfl_fllb").on('touchmove', function (e) {
        var touch2 = e.originalEvent.targetTouches[0];
        var x2 = touch2.pageX;
        var y2 = touch2.pageY;
        if(ty_left + x2 - x1>=0){
            jq(this).css("left", 0);
        }else if(ty_left + x2 - x1<=flb_w-fl_w){
            jq(this).css("left", flb_w-fl_w);
        }else{
            jq(this).css("left", ty_left + x2 - x1);
        }
        if(Math.abs(y2-y1)>0){
            e.preventDefault();
        }
    });
});
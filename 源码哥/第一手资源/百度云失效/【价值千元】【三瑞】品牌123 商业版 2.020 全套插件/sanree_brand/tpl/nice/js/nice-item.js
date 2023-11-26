jQuery(document).ready(function(){
	var jQuerytabbox_li = jQuery('ul.ri-btn li');
	jQuerytabbox_li.click(function(){
		jQuery(this).addClass('current').siblings().removeClass('current');
		var index = jQuerytabbox_li.index(this);
		jQuery('.ri-con ul li').eq(index).show().siblings().hide();
	});
	jQuery("ul.ri-btn li:first").addClass("current");
});

jQuery.fn.limit=function(){
    var self = jQuery("div[limit]");
      self.each(function(){
           var objString = jQuery(this).text();
           var objLength = jQuery(this).text().length;
           var num = jQuery(this).attr("limit");
           if(objLength > num){
            jQuery(this).attr("title",objString);
            objString = jQuery(this).text(objString.substring(0,num) + "...");
           }
      })
};

jQuery(document).ready(function () {
    jQuery(function () {
        jQuery('.brandcard a.bc').click(function (event) {
            event.stopPropagation();
            jQuery('.bc_bg').fadeIn('fast', function () {
                jQuery('div.bc_box').animate({ 'top': '150px' }, 500);
            });
        });
    });
    jQuery('.bc_close').click(function () {
        jQuery('div.bc_box').animate({ 'top': '-500px' }, 500, function () {
            jQuery('.bc_bg').fadeOut('fast');
        });
    });
    jQuery(document).bind("click",function(e){
        var target  = jQuery(e.target);
        if(target.closest("div.bc_box").length == 0){
            jQuery('div.bc_box').animate({ 'top': '-500px' }, 500, function () {
                jQuery('.bc_bg').fadeOut('fast');
            });
        }
    });
});

jQuery(".item_slide").slide({
    titCell: ".hd ul",
    mainCell: ".bd ul",
    effect: "fold",
    autoPlay: true,
    autoPage: true,
    trigger: "click",
    startFun: function(i) {
        var curLi = jQuery(".item_slide .bd li").eq(i);
        if ( !! curLi.attr("_src")) {
            curLi.css("background-image", curLi.attr("_src")).removeAttr("_src")
        }
    }
});

jQuery(document).ready(function(){
	jQuery(".mt-coupon ul li").hover(function(){
		jQuery(this).find(".coupon-box").show();
	},function(){
		jQuery(this).find(".coupon-box").hide();
	});
});

jQuery(document).ready(function(){
	jQuery(".new-left .nr:first, .new-right .nr:first").addClass("top-1");
});

jQuery.fn.limit=function(){
    var self = jQuery("div[limit]");
      self.each(function(){
           var objString = jQuery(this).text();
           var objLength = jQuery(this).text().length;
           var num = jQuery(this).attr("limit");
           if(objLength > num){
            jQuery(this).attr("title",objString);
            objString = jQuery(this).text(objString.substring(0,num) + "...");
           }
      })
};

// jQuery(".sr-newcon ul li:nth-child(5n)").addClass("lastli");
jQuery(".mt-album ul li:last").addClass("lastli");
window.onerror=function(){return true;}
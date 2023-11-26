jQuery(document).ready(function(){
	jQuery(".sr-newlist").dayuwscroll({
		parent_ele:'.sr-newcon',
		list_btn:'.btn-list',
		pre_btn:'.btn-left',
		next_btn:'.btn-right',
		path: 'left',
		auto:true,
		time:3000,
		num:5,
		gd_num:5,
		waite_time:3000
	});
});
(function($){
    $(function(){
		var numli = $("ul.sr-newlist li").length;
		var index = numli%5==0?numli/5-1:parseInt(numli/5);
		var show = $("ul.btn-list li");
		show.slice(index+1).hide();
		if(numli > 5){
			$(".r-more").show();
			$(".sr-newcon").hover(function(event){
				$(".btn-left, .btn-right").stop().animate({opacity: "1"});
				},function(event){
					$(".btn-left, .btn-right").stop().animate({opacity: "0"});
				}
			);
		}else {
			$(".sr-newcon").hover(function(event){
				$(".btn-left, .btn-right").stop().animate({opacity: "0"});
				},function(event){
					$(".btn-left, .btn-right").stop().animate({opacity: "0"});
				}
			);
		}
    });
})(jQuery);

jQuery(".fullSlide").hover(function() {
    jQuery(this).find(".prev,.next").stop(true, true).fadeTo("slow",0.5).slide({delayTime: 5000});
},
function() {
    jQuery(this).find(".prev,.next").fadeOut()
});
jQuery(".fullSlide").slide({
    titCell: ".hd ul",
    mainCell: ".bd ul",
    effect: "fold",
    autoPlay: true,
    autoPage: true,
    trigger: "click",
    startFun: function(i) {
        var curLi = jQuery(".fullSlide .bd li").eq(i);
        if ( !! curLi.attr("_src")) {
            curLi.css("background-image", curLi.attr("_src")).removeAttr("_src")
        }
    }
});

jQuery(document).ready(function(){
	var jQuerytabbox_li = jQuery('.t_link ul li');
	jQuerytabbox_li.click(function(){
		jQuery(this).addClass('current').siblings().removeClass('current');
		var index = jQuerytabbox_li.index(this);
		jQuery('.nav-tab > ul').eq(index).show().siblings().hide();
	});
});

jQuery(document).ready(function(){
	var jQuerytabbox_li = jQuery('ul.ri-btn li');
	jQuerytabbox_li.click(function(){
		jQuery(this).addClass('current').siblings().removeClass('current');
		var index = jQuerytabbox_li.index(this);
		jQuery('.ri-con > ul').eq(index).show().siblings().hide();
	});
});

jQuery(document).ready(function(){
	jQuery(".re_box ul li").hover(function(){
		jQuery(this).find(".hidebox").show();
		jQuery(this).find("img").stop().animate({"width":"313.25px","height":"225px","margin":"-10px","overflow":"hidden"},"slow");
	},function(){
		jQuery(this).find(".hidebox").hide();
		jQuery(this).find("img").stop().animate({"width":"293.25px","height":"205px","margin":"0px","overflow":"hidden"},"slow");
	});
});

jQuery(document).ready(function(){
	jQuery(".box_m").hover(function(){
		jQuery(this).find(".hidebox").show();
		jQuery(this).find(".tpic_m img").stop().animate({"width":"256.75px","height":"220px","margin":"-10px","overflow":"hidden"},"slow");
	},function(){
		jQuery(this).find(".hidebox").hide();
		jQuery(this).find(".tpic_m img").stop().animate({"width":"236.75px","height":"200px","margin":"0px","overflow":"hidden"},"slow");
	});
});

jQuery(document).ready(function(){
	jQuery(".box_b").hover(function(){
		jQuery(this).find(".hidebox").show();
		jQuery(this).find(".tpic_m img").stop().animate({"width":"341.3px","height":"225px","margin":"-10px","overflow":"hidden"},"slow");
	},function(){
		jQuery(this).find(".hidebox").hide();
		jQuery(this).find(".tpic_m img").stop().animate({"width":"321.3px","height":"205px","margin":"0px","overflow":"hidden"},"slow");
	});
});

jQuery(document).ready(function(){
	jQuery(".sr_content .box_l").hover(function(){
		jQuery(this).find(".function-box").show();
	},function(){
		jQuery(this).find(".function-box").hide();
	});
	jQuery(".function-box a.cd").click(function(){
		jQuery(this).find(".cd-box").toggle();
	});
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
jQuery(".re_box ul li:last, .sr_brandlist .box_b:nth-child(3n), .sr_brandlist .box_m:nth-child(4n)").addClass("lastli");
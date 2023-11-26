var Class = {
    create: function() {
        return function() {
            this.initialize.apply(this, arguments)
        }
    }
}
var Extend = function(destination, source) {
    for (var property in source) {
        destination[property] = source[property]
    }
}
var Class = {
    create: function() {
        return function() {
            this.initialize.apply(this, arguments)
        }
    }
}
var Extend = function(destination, source) {
    for (var property in source) {
        destination[property] = source[property]
    }
}
var sLideShow = Class.create();
sLideShow.prototype = {
    initialize: function(slide, options) {
		this.mslide = slide;
		this.Drag = $(slide);
		this.SetOptions(options);
		this.width = this.options.width;
		this.button_opactiy = 0.5;
		this.span_opacity = 0.4;
		this.stopspan_opacity = 0.4;
		this.notopacity = 1;
		this.stoptime = 300;
		this.Remaintime = 2000;
		this.index = 0;
		this.showHtml = Array();
		this.slidediv = '#' + slide;
		this.slideul = '#' + slide + ' ul';
		this.slideulli = '#' + slide + ' ul li';
		this.slidebtnspan = '#' + slide + ' .btn i';
		this.slidepre = '#' + slide + ' .pre';
		this.slidebtnBg = '#' + slide + ' .btnbg';
		this.length = jQuery(this.slideulli).length;
		if (this.length<1) {
			return;
		}
		var dindex = 0;
		this.picTimer =null;
		this.showHtml[dindex] = '<div class="btnbg"></div>';
		dindex++;
		this.showHtml[dindex] = '<div class="btn">';
		for(var j=1; j <= this.length; j++) {
			dindex++;
			this.showHtml[dindex] = '<i></i>';
		}
		dindex++;
		this.showHtml[dindex] = '</div>';
		jQuery(this.slidediv).append(this.showHtml.join());
		jQuery(this.slidebtnBg).css('opacity', this.button_opactiy);
		this.Action();
		if(BROWSER.ie == '7.0') {
			
			jQuery('#slide').css({'top':'-1px'});
			
		}		
    },
    SetOptions: function(options) {
        this.options = {
            onStart: function() {}
        }
        Extend(this.options, options || {});
    },
    Action: function() {
		var Handel = this;
		jQuery(this.slidebtnspan).css('opacity', this.span_opacity).mouseenter(function() {												  
			Handel.index = jQuery(Handel.slidebtnspan).index(this);
			Handel.showPics(Handel.index);
		}).eq(0).trigger('mouseenter');
		
		jQuery(this.slideul).css('width',this.width * this.length);
		jQuery(this.slidediv).hover(
		function() {
			clearInterval(Handel.picTimer);
		},function() {
			Handel.picTimer = setInterval(function() {
				Handel.showPics(Handel.index);
				Handel.index++;
				if(Handel.index == Handel.length) {Handel.index = 0;}
			}, Handel.Remaintime);
		}).trigger('mouseleave');		
    },
	showPics: function(nindex) { 
		var nowLeft = -nindex* this.width; 
		var Handel = this;
		jQuery(this.slideul).stop(true,false).animate({'left':nowLeft},Handel.stoptime);
		jQuery(this.slidebtnspan).stop(true,false).animate({'opacity': Handel.stopspan_opacity},Handel.stoptime).eq(nindex).stop(true,false).animate({'opacity': Handel.notopacity}, Handel.stoptime); 
	}


};
jQuery(function() {
	new sLideShow('slide', {width:697});
    jQuery('.r_coupon li').hover(
		function(){jQuery(this).addClass("hover");},
		function(){jQuery(this).removeClass("hover");});
    jQuery('.coupondata li').hover(
		function(){jQuery(this).addClass("mhover");},
		function(){jQuery(this).removeClass("mhover");});	
});
function setthis(obj) {
	obj.value="";
	obj.style.color='#000000';
	obj.style.background='url(about:blank) #FFFFFF';
}
function getsearch(){
	var keywordval = $('sanreekeyword').value;
	if (keywordval=='') return;
	location.href= modeurl+ addstr+ 'keyword='+ keywordval;
}
function setfilter(nId){
	var nValue = getcookie('asc'+nId);
	var asc = 1;
	if (nValue==1) {
		asc = 2;
	}
	for(i=1;i<6;i++) {
		setcookie('asc'+i);
	}
	setcookie('asc'+nId, asc, 1000*24*60*60);
	
}
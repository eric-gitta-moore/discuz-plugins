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
		this.preNext_opacity = 0.2;
		this.preNextStop_opacity = 0.5;
		this.preNextStop1_opacity = 0.2;
		this.stopspan_opacity = 0.4;
		this.notopacity = 1;
		this.stoptime = 300;
		this.Remaintime = 4000;
		this.index = 0;
		this.showHtml = Array();
		this.slidediv = '#' + slide;
		this.slideul = '#' + slide + ' ul';
		this.slideulli = '#' + slide + ' ul li';
		this.slidebtnspan = '#' + slide + ' .btn i';
		this.slidepre = '#' + slide + ' .pre';
		this.slideNext = '#' + slide + ' .next';
		this.slidepreNext = '#' + slide + ' .prenext';
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
		dindex++;
		this.showHtml[dindex] = '<div class="prenext pre"></div>';
		dindex++;
		this.showHtml[dindex] = '<div class="prenext next"></div>';
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
		
		jQuery(this.slidepreNext).css('opacity', this.preNext_opacity).hover(function() {
			jQuery(this).stop(true,false).animate({'opacity': Handel.preNextStop_opacity}, this.stoptime);
		},function() {
			jQuery(this).stop(true,false).animate({'opacity':Handel.preNextStop1_opacity}, this.stoptime);
		});
		
		jQuery(this.slidepre).click(function() {
			Handel.index -= 1;
			if(Handel.index == -1) { Handel.index = Handel.length - 1;}
			Handel.showPics(Handel.index);
		});
		jQuery(this.slideNext).click(function() {
			Handel.index += 1;
			if(Handel.index == Handel.length) {Handel.index = 0;}
			Handel.showPics(Handel.index);
		});
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
				new sLideShow('slide', {width:775});
				jQuery("#category ul").categoryshow();
				});
function setthis(obj) {
	obj.value="";
	obj.style.color='#000000';
}
function showthis(id) {
	jQuery('#hotgoods'+id).show();
}
function hidethis(id) {
   jQuery('#hotgoods'+id).hide();
}
 
(function($){  
    var status = false;  
    $.fn.categoryshow = function(options){  
        var defaults = {  
            maxNum:13,
			opclass: 'close',
			showme: 'normal',
			more_btn: '#more_cat',
			onclass: 'a'
        }
		var options=jQuery.extend(defaults, options);
		var _self = this;
		jQuery(options.more_btn).click(function() {
			status = !status;
			showcount = 0;
			if (status) {
				jQuery(this).addClass(options.opclass);
				_self.find('li').each(function() {
					showcount ++;
					showcount > options.maxNum ? jQuery(this).show(options.showme) : '';
				});
			} else {
				jQuery(this).removeClass(options.opclass);
				_self.find('li').each(function() {
					showcount ++;
					showcount > options.maxNum ? jQuery(this).hide(options.showme) : '';
				});
			}
		});
		return this.each(function(){  
			jQuery('li',this).each(function(){
				jQuery(this).mouseover(
					function() {
						jQuery('#' + this.id + '_menu').show();
						jQuery(this).addClass(options.onclass);
					}
				);
				jQuery(this).mouseout(
					function() {
						jQuery(this).removeClass(options.onclass);
						jQuery('#' + this.id + '_menu').hide();
					}
				);
			})
			
		});
    }
})(jQuery); 

/*jQuery(function() {
	var status = false;
	var defaults = {  
            maxNum:13,
			opclass: 'close',
			showme: 'normal',
			more_btn: '#more_cat',
			onclass: 'a'
        }
	
	jQuery(defaults.more_btn).click(function() {
		status = !status;
		showcount = 0;
		if (status) {
			jQuery(this).addClass(defaults.opclass);
			jQuery("#category ul").find('li').each(function() {
				showcount ++;
				showcount > defaults.maxNum ? jQuery(this).show(defaults.showme) : '';
			});
		} else {
			jQuery(this).removeClass(defaults.opclass);
			jQuery("#category ul").find('li').each(function() {
				showcount ++;
				showcount > defaults.maxNum ? jQuery(this).hide(defaults.showme) : '';
			});
		}
	});
	jQuery("#category ul").each(function(){  
			jQuery('li',this).each(function(){
				jQuery(this).mouseover(
					function() {
						jQuery('#' + this.id + '_menu').show();
						jQuery(this).addClass(defaults.onclass);
					}
				);
				jQuery(this).mouseout(
					function() {
						jQuery(this).removeClass(defaults.onclass);
						jQuery('#' + this.id + '_menu').hide();
					}
				);
			})
			
		})
});
*/
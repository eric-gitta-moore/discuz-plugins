//  源码哥幻灯//
jQuery(document).ready(function(){

	if (jQuery('#lewei_sliders').length) {
		lewei_sliders();
		jQuery('#h_sns').find('img').hover(function(){
			jQuery(this).fadeTo(200,0.5);
		}, function(){
			jQuery(this).fadeTo(100,1);
		});
	}
	function lewei_sliders(ID, delay){
		var ID=ID?ID:'#lewei_sliders';
		var delay=delay?delay:5000;
		var currentEQ=0, picnum=jQuery('#lewei_imgsw_img li').size(), autoScrollFUN;
		jQuery('#lewei_btns li').eq(currentEQ).addClass('current');
		jQuery('#lewei_imgsw_img li').eq(currentEQ).show();
		jQuery('#lewei_imgsw_tx li').eq(currentEQ).show();
		autoScrollFUN=setTimeout(autoScroll, delay);
		function autoScroll(){
			clearTimeout(autoScrollFUN);
			currentEQ++;
			if (currentEQ>picnum-1) currentEQ=0;
			jQuery('#lewei_btns li').removeClass('current');
			jQuery('#lewei_imgsw_img li').hide();
			jQuery('#lewei_imgsw_tx li').hide().eq(currentEQ).slideDown(400);
			jQuery('#lewei_btns li').eq(currentEQ).addClass('current');
			jQuery('#lewei_imgsw_img li').eq(currentEQ).show();
			autoScrollFUN = setTimeout(autoScroll, delay);
		}
		jQuery('#lewei_imgsw').hover(function(){
			clearTimeout(autoScrollFUN);
		}, function(){
			autoScrollFUN = setTimeout(autoScroll, delay);
		});
		jQuery('#lewei_btns li').hover(function(){
			var picEQ=jQuery('#lewei_btns li').index(jQuery(this));
			if (picEQ==currentEQ) return false;
			currentEQ = picEQ;
			jQuery('#lewei_btns li').removeClass('current');
			jQuery('#lewei_imgsw_img li').hide();
			jQuery('#lewei_imgsw_tx li').hide().eq(currentEQ).slideDown(100);
			jQuery('#lewei_btns li').eq(currentEQ).addClass('current');
			jQuery('#lewei_imgsw_img li').eq(currentEQ).show();
			return false;
		});
	};
})
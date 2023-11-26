function comiis_left_js() {
	var element = $('nv');
	var left = element.offsetLeft;
	while(element = element.offsetParent) {
		left += element.offsetLeft;
	}
	if(left < $('comiis_left_bar').offsetWidth){
		$('comiis_left_bar').style.left = "0px";
	}else{
		$('comiis_left_bar').style.left = -($('comiis_left_bar').offsetWidth+8) + "px";
	}
}
_attachEvent(window, 'resize', function(){comiis_left_js();});
comiis_left_js();
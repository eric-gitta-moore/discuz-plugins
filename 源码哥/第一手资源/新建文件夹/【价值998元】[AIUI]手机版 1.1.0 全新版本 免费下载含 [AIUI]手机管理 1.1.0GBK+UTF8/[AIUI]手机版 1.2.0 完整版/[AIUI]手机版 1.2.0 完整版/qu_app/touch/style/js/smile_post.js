
function ainuo_smilies_tab(a){
	if(typeof smilies_array[a] == 'object') {
		var ainuo_smilies_list = '<div class="swiper-slide"><ul class="swiper-slide">';
		var o = 0, ainuo_smilies_text = '';
		
		for(ii in smilies_array[a]) {
			for(i in smilies_array[a][ii]) {
				o++;
				if(o > 24){
					o = 1;
					ainuo_smilies_list += '</ul></div><div class="swiper-slide"><ul class="swiper-slide">';
				}
				ainuo_smilies_text = smilies_array[a][ii][i][1].replace(/\'/, '\\\'');
				ainuo_smilies_list += '<li><a href="javascript:;" onclick="ainuo_addsmilies(\'' + ainuo_smilies_text + '\');"><img src="' + STATICURL + 'image/smiley/' + smilies_type['_' + a][1] + '/' + smilies_array[a][ii][i][2] + '" class="vm"></a></li>';
			}
		}
		ainuo_smilies_list += '</ul></div>';
		$('.ainuo_smilecon').html(ainuo_smilies_list);
		xmySwiper.update();
		xmySwiper.slideTo(0, 0, false);
		$('#ainuo_smilies_key>li>a').removeClass('a');
		$('#ainuo_smilies_tab' + a).addClass("a");
	}
}
function ainuo_addsmilies(a){
	$('#needmessage').ainuo_insert(a);
}
var xmySwiper;
var ainuo_smilies_array = [];
$(document).ready(function() {
	$('#needmessage').on('keydown', function(event){
		if(event.keyCode == "8") {
			return $('#needmessage').ainuo_delete();
		}
	});
	xmySwiper = new Swiper('.ainuo_smilewiper',{
		pagination: '.ainuo_yuand',
	});

	var smilies_type_box = '';
	var ainuoshow_id = 0;
	if(typeof smilies_type == 'object') {
		for(i in smilies_type) {
			key = i.substring(1);
			smilies_type_box += '<li><a href="javascript:;" onclick="ainuo_smilies_tab(\''+ key+ '\')" id="ainuo_smilies_tab'+ key+ '"' + (ainuoshow_id == 0 ? ' class="a"' : '') + '><img src="' + STATICURL + 'image/smiley/' + smilies_type['_' + key][1] + '/' + smilies_array[key][1][0][2] + '" class="vm"></a></li>';
			if(ainuoshow_id == 0){
				ainuoshow_id = key;
			}
		}
		$('#ainuo_smilies_key').html(smilies_type_box);
		ainuo_smilies_tab(ainuoshow_id);
		$("#pssmil").click();
	}
	for(i in smilies_array) {
		for(o in smilies_array[i][1]) {
			if (typeof ainuo_smilies_array[smilies_array[i][1][o][1].length] != 'object') {
				ainuo_smilies_array[smilies_array[i][1][o][1].length] = new Array();
			}
			ainuo_smilies_array[smilies_array[i][1][o][1].length].push(smilies_array[i][1][o][1]);
		}
	}
	ainuo_smilies_array.reverse();
	
});


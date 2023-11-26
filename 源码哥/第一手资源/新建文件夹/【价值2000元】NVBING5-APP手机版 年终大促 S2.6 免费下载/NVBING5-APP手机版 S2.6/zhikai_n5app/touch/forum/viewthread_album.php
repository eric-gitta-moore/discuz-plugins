<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<style type="text/css">
.bg {background: #343434;}
.large {background: rgba(0, 0, 0, 0.5);}
.small {background: rgba(0, 0, 0, 0.5);}
.postalbum { background-color:#343434; display:none; text-align: center; height:100%; overflow:hidden; padding:0 0 1px 0; position:absolute; top:0; width:100%; z-index:80; }
.postalbum_h { height:45px; left:0; line-height:45px; position:absolute; top:0px; width:100%; z-index:90; background: rgba(0, 0, 0, 0.7);}
.postalbum_h a:link, a:visited, a:hover { color:white; }
.postalbum_h_back { position:absolute; left:10px; top:7px; height:30px; width:30px;background: url(template/zhikai_n5app/images/postalbum_h_back.png) no-repeat;background-position: 0;background-size: 20px auto; z-index:90; color:white; }
.postalbum_h_picnum {color: #fff;font-size: 20px;}
.postalbum_c { height:100%; position:relative; z-index:-1; display:-webkit-box; display:-moz-box; display:-o-box; display:box; -webkit-transition:all 350ms linear; -moz-transition:all 350ms linear; -o-transition:all 350ms linear; transition:all 350ms linear; }
.postalbum_u { border-radius:3px 3px 3px 3px; text-align:center; }
.postalbum_i { margin-bottom:-3px; max-width:100%; vertical-align:middle; visibility:hidden; }
</style>

	<!--{eval $curaidkey = 0;}-->
	<!--{eval $count = count($imglist['aid']);}-->
	<!--{if $_GET['aid']}-->
		<!--{loop $imglist['aid'] $k $aid}-->
			<!--{if $_GET['aid'] == $aid}-->
				<!--{eval $curaidkey = $k;break;}-->
			<!--{/if}-->
		<!--{/loop}-->
	<!--{/if}-->
	
	<div class="postalbum">
		<div class="postalbum_h">
			<a href="javascript:history.back();" class="postalbum_h_back"></a>
			<span class="postalbum_h_picnum"><span id="curpic"><!--{eval echo $curaidkey + 1}--></span>/$count</span>
		</div>
		<ul class="postalbum_c">
			<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nN'.'g==')) and !strstr($_G['siteurl'],base64_decode('MTI'.'3LjAuM'.'C4x')) and !strstr($_G['siteurl'],base64_decode('b'.'G9jY'.'Wxo'.'b3N0'))){ echo '&#x67'.'2c;&#x5957'.';&#x6a2'.'1;&#x7'.'248;&#x6'.'765;&#x81ea;<a href="'.base64_decode('aHR0cD'.'ovL3d3'.'dy55b'.'Wc2LmNvbS8=').'">&#x6e90;&#x'.'7801;&#x54e5;</a>&#x'.'514d;&#x8d39;&#x5'.'206;&#x4eab;&#x'.'ff0c;&#x8bf7;&#x5'.'2ff;&#x4ece;&#x5176;&#x4ed6;&'.'#x7f51;&#'.'x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTM4OS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#'.'x8d39;&#'.'x4e0b;&#'.'x8f7d;</a>&#x672c;&#x'.'5957;&#x6a21'.';&#x7248;';exit;}<!--{/eval}--><!--{loop $imglist[url] $key $imgurl}-->
			<li class="postalbum_u" id="u_$key">
				<!--{eval $imgurl = getforumimg($imglist[aid][$key], 0, 2000, 1500, 'fixnone');}-->
				<img class="postalbum_i" load="0" id="img_$key" <!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $curaidkey == $key}-->src="$imgurl"<!--{/if}--> zsrc="$imgurl" orig="$imglist[url][$key]"/>
			</li>
			<!--{/loop}-->
		</ul>
	</div>

<script type="text/javascript">
(function() {
	var support3d = ("WebKitCSSMatrix" in window && "m11" in new WebKitCSSMatrix());
	var curkey = $curaidkey;
	var count = $count;
	var imglist = new Array();
	imglist['url'] = [<!--{echo dimplode($imglist[url]);}-->];

	var width = window.innerWidth;
	var height = document.documentElement.clientHeight;
	$('.postalbum').css({'display':'block', 'height':height + 'px'});
	$('.postalbum_u').css({'height':height + 'px', 'width':width + 'px'});
	$('.postalbum_i').css({'max-height':'100%', 'visibility':'visible'});
	if(support3d) {
		$('.postalbum_c').css({'line-height':height + 'px', 'width':width * count + 'px'});
		slidmoving('-' + curkey * width);
	} else {
		$('.postalbum_c').css({'display':'block', 'height':height * count + 'px'});
		$('.postalbum_c').css({'top': '-' + curkey * height + 'px'});
	}

	var position = {};
	var status = true;
	var posalbum_touch_interval = 0;
	var postalbum_timeoutid = null;
	touchaction = function(postalbum, postalbum_u, fun) {
		postalbum.on('touchstart', postalbum_u, function(e) {
			e = mygetnativeevent(e);
			position.x1 = e.touches[0].pageX;
			position.y1 = e.touches[0].pageY;
			position.hori = true;
			status = true;
		}).on('touchmove', postalbum_u, function(e) {
			status = false;
			e = mygetnativeevent(e);
			position.x2 = e.touches[0].pageX;
			position.y2 = e.touches[0].pageY;
			position.distx = position.x2 - position.x1;
			position.disty = position.y2 - position.y2;
			if(Math.abs(position.distx) < 2 * Math.abs(position.disty)) {
				position.hori = false;
			} else {
				e.preventDefault();
			}
		}).on('touchend', postalbum_u, function(e) {
			e = mygetnativeevent(e);
			if(position.x2 && Math.abs(position.distx) > 30 && position.hori && !status) {
				var swipedire = position.distx > 0 ? 'right' : 'left';
				fun.call(this, swipedire, e);
			} else if(status) {
				postalbum_touch_interval = new Date().getTime();
				if(!postalbum_timeoutid) {
					postalbum_timeoutid = setTimeout(function() {
						var interval = new Date().getTime() - postalbum_touch_interval;
						if(interval >= 250) {
							fun.call(this, 'tap', e);
						}
						postalbum_touch_interval = 0;
						postalbum_timeoutid = null;
					}, 250);
				}
			}
		});
	};

	var curkeyimg = $('#img_' + curkey);
	curkeyimg.css({'-webkit-transition':'all 200ms', '-moz-transition':'all 200ms', '-o-transition':'all 200ms', 'transition':'all 200ms'});
	imgchange(curkeyimg, 1, 0, 0);
	setTimeout(function() {
		fiximgmove(curkeyimg);
	}, 350);

	var imgscale = 1;
	var oldscalex = 0;
	var oldscaley = 0;
	var newscalex = 0;
	var newscaley = 0;
	var imgmovestatus = false;
	var touch_interval = 0;
	var timeoutid = null;
	var imgtouchpos = {};
	$('.postalbum_u').on('touchstart', '.postalbum_i', function(e) {
		if(!imgmovestatus) {
			return;
		}
		e = mygetnativeevent(e);
		imgtouchpos.x1 = e.touches[0].pageX;
		imgtouchpos.y1 = e.touches[0].pageY;
	}).on('touchmove', '.postalbum_i', function(e) {
		if(!imgmovestatus) {
			return;
		}
		e = mygetnativeevent(e);
		imgtouchpos.x2 = e.touches[0].pageX;
		imgtouchpos.y2 = e.touches[0].pageY;
		imgtouchpos.distx = imgtouchpos.x2 - imgtouchpos.x1;
		imgtouchpos.disty = imgtouchpos.y2 - imgtouchpos.y1;

		newscalex = imgtouchpos.distx / imgscale + oldscalex;
		newscaley = imgtouchpos.disty / imgscale + oldscaley;

		imgchange($('#img_' + curkey), imgscale, newscalex, newscaley);

	}).on('touchend', '.postalbum_i', function(e) {

		touch_interval = new Date().getTime();
		if(!timeoutid) {
			timeoutid = setTimeout(function() {
				var interval = new Date().getTime() - touch_interval;
				var obj = $('#img_' + curkey);
				if(interval < 250) {
					imgscale = imgscale == 1 ? 2 : 1;
					imgmovestatus = (imgscale == 1) ? false : true;
					if(imgmovestatus) {
						obj.attr('src', obj.attr('orig'));
					}
					imgchange(obj, imgscale, newscalex, newscaley);
					setTimeout(function() {
						fiximgmove(obj);
					}, 250);
				} else {
					if(imgmovestatus) {
						oldscalex = newscalex;
						oldscaley = newscaley;
						fiximgmove(obj);
					}
				}
				touch_interval = 0;
				timeoutid = null;
			}, 250);
		}
	});

	function imgchange(img, scale, x, y) {
		if(!img[0]) {
			return;
		}
		scale = scale || 1;
		x = x || 0;
		y = y || 0;

		img.css('-webkit-transform', 'scale(' + scale + ')');
		img.css('-moz-transform', 'scale(' + scale + ')');
		img.css('-o-transform', 'scale(' + scale + ')');
		img.css('transform', 'scale(' + scale + ')');

		var pimg = img.parent();
		var translatetxt = (support3d ? "translate3d": "translate") + "(" + x * scale + "px, " + y * scale + "px" + (support3d ? ", 0px)": ")");
		pimg.css('-webkit-transform', translatetxt);
		pimg.css('-moz-transform', translatetxt);
		pimg.css('-o-transform', translatetxt);
		pimg.css('transform', translatetxt);
	}

	function fiximgmove(imgobj) {
		var offset = imgobj.offset();
		var movex = imgobj.width() * imgscale - width;
		var movey = imgobj.height() * imgscale - height;
		if(movey > 0) {
			var yoffset = offset.top - $('.postalbum').offset().top;
			if(yoffset > 0) {
				oldscaley = oldscaley - yoffset / imgscale;
			} else {
				if(yoffset + imgobj.height() * imgscale - height < 0) {
					oldscaley = oldscaley - (yoffset + imgobj.height() * imgscale - height) / imgscale;
				}
			}
		} else {
			oldscaley = 0;
		}

		if(movex > 0) {
			if(offset.left > 0) {
				oldscalex = oldscalex - offset.left / imgscale;
			} else {
				if(offset.left + imgobj.width() * imgscale - width < 0) {
					oldscalex = oldscalex - (offset.left + imgobj.width() * imgscale - width) / imgscale;
				}
			}
		} else {
			oldscalex = 0;
		}

		if(imgscale < 1) {
			imgscale = 1;
		}
		newscalex = oldscalex;
		newscaley = oldscaley;
		imgchange(imgobj, imgscale, oldscalex, oldscaley);
	}

	var headerstatus = true;
	touchaction($('.postalbum'), '.postalbum_u', function(swipedire, touchevent) {
		if(imgmovestatus) {
			return;
		}
		switch(swipedire) {
			case 'left':
				if(curkey >= count - 1) {
					popup.open('{lang lastpic}', 'alert');
				} else {
					for(var i=0; i<3; i++) {
						if(!$('#img_' + (curkey + i)).attr('src')) {
							$('#img_' + (curkey + i)).attr('src', $('#img_'+(curkey + i)).attr('zsrc'));
						}
					}
					curkey++;
					if(support3d) {
						slidmoving('-' + curkey * width);
					} else {
						$('.postalbum_c').css({'top': '-' + curkey * height + 'px'});
					}
					$('#curpic').text(curkey + 1);
				}
				break;
			case 'right':
				if(curkey <= 0) {
					popup.open('{lang firstpic}', 'alert');
				} else {
					for(var i=-3; i<0; i++) {
						if(!$('#img_' + (curkey + i)).attr('src')) {
							$('#img_' + (curkey + i)).attr('src', $('#img_'+(curkey + i)).attr('zsrc'));
						}
					}
					curkey--;
					if(support3d) {
						slidmoving('-' + curkey * width);
					} else {
						$('.postalbum_c').css({'top': '-' + curkey * height + 'px'});
					}
					$('#curpic').text(curkey + 1);
				}
				break;
			case 'tap':
				var obj = $('.postalbum_h');
				var top = headerstatus ? 0 : 45;
				adjust = function() {
					setTimeout(function() {
						if(top == 0 && headerstatus == false) {
							headerstatus = true;
						} else if(top == 45 && headerstatus == true) {
							headerstatus = false;
						} else if(headerstatus == false) {
							top--;
							obj.css('top', '-' + top + 'px');
							adjust();
						} else {
							top++;
							obj.css('top', '-' + top + 'px');
							adjust();
						}
					}, 10);
				}
				adjust();
				break;
		}
	});

	function slidmoving(distx) {
		$('.postalbum_c').css('-webkit-transform', 'translate3d('+ distx + 'px, 0, 0)');
		$('.postalbum_c').css('-moz-transform', 'translate3d('+ distx + 'px, 0, 0)');
		$('.postalbum_c').css('-o-transform', 'translate3d('+ distx + 'px, 0, 0)');
		$('.postalbum_c').css('transform', 'translate3d('+ distx + 'px, 0, 0)');
		return true;
	}

})();
</script>

<!--{template common/footer}-->

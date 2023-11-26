Zepto(function () {
	'use strict';
				
	Zepto(document).on("pageInit", function(e, pageId, page) {
		var globelpage = $(".ainuopage_main").attr("id");		
		if($('div.pg').length > 0) {
			ainuopage.converthtml();
		}
		if($('.popup').length > 0) {
			popup.init();
		}
		
		//底部发帖
		$('.botpost').on('click', function(){
			$("#apostmask").toggle();
		});
		$("#apostmask").click(function() {
			$("#apostmask").toggle();
		});		
		//左侧导航
		$("#ainuo_toggle_menu").click(function(){
			$("#mm-menu").addClass("active");
			$("#menu-mask").addClass("active");
		});	
		$("#menu-mask").click(function(){
			$("#mm-menu").removeClass("active");
			$("#menu-mask").removeClass("active");
		});	
		$("#mm-menu a").click(function(){
			$("#mm-menu").removeClass("active");
			$("#menu-mask").removeClass("active");
		});	
	
		//子版块
		$('.asubforum').on('click', function(event){
            event.preventDefault();
            $('.subname_list').addClass('is-visible');
        });
		
        $('.subname_list').on('click', function(event){
                event.preventDefault();
                $(this).removeClass('is-visible');
        });
		
		//筛选
		$('.afilter').on('click', function(event){
            event.preventDefault();
            $('.f_sortcon').addClass('is-visible');
        });
		
		$('.f_sortcon').on('click', function(event){
                event.preventDefault();
                $(this).removeClass('is-visible');
        });
		$('.sortclose').on('click', function(event){
                event.preventDefault();
                $(this).removeClass('is-visible');
        });
		$('.adwanceshaixuan').on('click', function(event){
            event.preventDefault();
            $('.search_sortlist').addClass('is-visible');
        });
		$('.adwanceclose').on('click', function(event){
			event.preventDefault();
			$('.search_sortlist').removeClass('is-visible');
        });
		
		
		//回复
		$('.fastcon_a').on('click', function(event){
            event.preventDefault();
            $('.afastreply').addClass('is-visible');
			$("#afastreply").find("textarea").focus();
        });
		$('.ainuobotsortreply_a').on('click', function(event){
            event.preventDefault();
            $('.afastreply').addClass('is-visible');
			$("#afastreply").find("textarea").focus();
        });
		$('.acthuifu').on('click', function(event){
            event.preventDefault();
            $('.afastreply').addClass('is-visible');
			$("#afastreply").find("textarea").focus();
        });
		
        $('.cenclepl').on('click', function(event){
                event.preventDefault();
                $('.afastreply').removeClass('is-visible');
        });
		
		//发视频
		$('.psvideo').on('click', function(event){
            event.preventDefault();
            $('.ainuo_postvideo').addClass('is-visible');
        });
		$('.cancelupvodeo').on('click', function(event){
			event.preventDefault();
			$('.ainuo_postvideo').removeClass('is-visible');
        });
		
		
		//活动
		$('.acttoggle_join').on('click', function(event){
            event.preventDefault();
            $('.activityjoin').addClass('is-visible');
        });
		$('.acttoggle_cancel').on('click', function(event){
            event.preventDefault();
            $('.activityjoincancel').addClass('is-visible');
        });
		$('.cancelbaoming').on('click', function(event){
            event.preventDefault();
            $('.activityjoincancel').removeClass('is-visible');
			$('.activityjoin').removeClass('is-visible');
        });
		
		//发音频
		$('.psmusic').on('click', function(event){
            event.preventDefault();
            $('.ainuo_postmusic').addClass('is-visible');
			$("#ainuo_postmusic").find("textarea").focus();
        });
		$('.cancelupmusic').on('click', function(event){
			event.preventDefault();
			$('.ainuo_postmusic').removeClass('is-visible');
        });
		
		//发视频链接
		$('.psvideolink').on('click', function(event){
            event.preventDefault();
            $('.ainuo_postvideolink').addClass('is-visible');
			$("#ainuo_postvideolink").find("textarea").focus();
        });
		$('.canceluplink').on('click', function(event){
			event.preventDefault();
			$('.ainuo_postvideolink').removeClass('is-visible');
        });
		
		//音频初始化
		audiojs.events.ready(function() {
			audiojs.createAll();
		});
		
		//微信内分享
		$('.ainuowxfenxiang').on('click', function() {
			$("#ainuowexopen").removeClass('on');
			$("#ainuowexopen_safari").removeClass('on');
		});
		if(document.getElementById("ispbl")){
			minigrid('.ainuogrid', '.grid-item', 2, null,
				function() {
					var d = document.querySelector('.ainuo_piclist');
					d.style.opacity = 1;
				}
			);
			window.addEventListener('resize', function() {
				minigrid('.ainuogrid', '.grid-item');
			});
		}
		$(".ainuolazyloadbg").lazyload({
			//effect: "fadeIn",
			failurelimit : 10,
			container: $("#ainuo_contop"),
		});
		$(".ainuolazyload").lazyload({
			placeholder     : "template/qu_app/touch/style/lazy/picloading.gif",
			//effect: "fadeIn",
			failurelimit : 10,
			container: $("#ainuo_contop"),
		});
		
		$("#ainuo_toggle_top").click(function(){
			$('.content').animate({scrollTop:0},300);
			return false;
		});
		$('.ainuo_right_more').on('click', function() {
			var botMenu = document.getElementById("ainuo_quick_bot").style.right;
			if(botMenu == '10px'){
				$('.ainuo_quick_bot').animate({right:'-40px'},200);
				document.getElementById("ainuo_right_more").innerHTML = '<i class="iconfont icon-more"></i>';
				document.getElementById("ainuo_right_more").style.background = '#444';
			}else{
				$('.ainuo_quick_bot').animate({right:'10px'},200);
				document.getElementById("ainuo_right_more").innerHTML = '<i class="iconfont icon-close"></i>';
				document.getElementById("ainuo_right_more").style.background = '#000';
			}
		});
		$('.ainuo_quick_bot a').on('click', function() {
			$('.ainuo_quick_bot').animate({right:'-40px'},200);
			document.getElementById("ainuo_right_more").innerHTML = '<i class="iconfont icon-more"></i>';
			document.getElementById("ainuo_right_more").style.background = '#444';
		});
		

		$('.plc .pi img').each(function () {
			AutoResizeImage(this);
		});
		function AutoResizeImage(objImg) {
			var img = new Image();
			img.src = objImg.src;
			img.onload = function(){
				if(this.width >= 200){
					$(objImg).css('width','100%');
					$(objImg).css('height','auto');
				}
			}
		}
		
		

		//share
		$('.ashare').on('click', function() {
			if(isWeiXin() || (navigator.userAgent.indexOf('Mobile MQQBrowser') > -1)){
				$("#ainuowexopen").addClass('on');
				return;
			}else if((navigator.userAgent.indexOf('Safari') > -1) && (navigator.userAgent.indexOf('iPhone') > -1)){
				$("#ainuowexopen_safari").addClass('on');
				return;
			}else{
				soshm.popIn({
					url: sharelink,
					title: sharetitle,
					digest: sharedesc,
					pic: shareicon,
					sites: ['weixin', 'weixintimeline', 'weibo', 'qq', 'qzone','yixin']
				});
			}
		});
		
		function isWeiXin(){
			var ua = window.navigator.userAgent.toLowerCase();
			if(ua.match(/MicroMessenger/i) == 'micromessenger'){
				return true;
			}else{
				return false;
			}
		};
			
		if(globelpage.indexOf('forum_guide') > 0){
			$(".content").on('scroll',function(){
				var ascrotop = $("#ainuo_contop").scrollTop();
				//var topheight = $("#ainuo_avatar").offset().top;
				if(ascrotop >= 210){
					$("#indexheader").addClass("indexscrollcss");
				}else{
					$("#indexheader").removeClass("indexscrollcss");
				}
			})
		}
		
		
		

		if((globelpage.indexOf('forum_post') > 0) || (globelpage.indexOf('forum_viewthread') > 0) || (globelpage.indexOf('group_viewthread') > 0)){
			var ainuos_sright_Text;
			(function($){
				$.fn.extend({
					
					ainuo_insert: function(a){
						var $ainuos=$(this)[0];
						if ($ainuos.selectionStart || $ainuos.selectionStart == '0') {
							var startPos = $ainuos.selectionStart;
							var endPos = $ainuos.selectionEnd;
							$ainuos.value = $ainuos.value.substring(0, startPos) + a + $ainuos.value.substring(endPos, $ainuos.value.length);
							$ainuos.selectionStart = $ainuos.selectionEnd = startPos + a.length;
						}else {
							this.value += a;
						}
						$ainuos.focus();
					},
					ainuo_delete: function(){
						var $ainuos=$(this)[0];
						var is_smilies = -1;
						if ($ainuos.selectionStart && ($ainuos.selectionStart == $ainuos.selectionEnd)) {
							var startPos = $ainuos.selectionStart;
							var startText = $ainuos.value.substring(0, startPos);
							var endText = $ainuos.value.substring(startPos, $ainuos.value.length);
							var ainuos_smilies_len = 0, delStart = 0, ainuos_startText_lendata = '';
							for(i in ainuo_smilies_array) {
								ainuos_smilies_len = ainuo_smilies_array[i][0].length;
								ainuos_startText_lendata = startText.substring(startText.length - ainuos_smilies_len, startText.length);
								if(in_array(ainuos_startText_lendata, ainuo_smilies_array[i])){
									delStart = startText.length - ainuos_smilies_len;
									$ainuos.value = startText.substring(0, delStart)  + endText;
									$ainuos.selectionStart = $ainuos.selectionEnd = delStart;
									is_smilies = 1;
									break;
								}
							}
							if(is_smilies == 1){
								return false;
							}else{
								var ainuos_sall_Text = ainuos_sleft_Text = ainuos_sright_Text = '';
								var ainuos_smilies_len = ainuos_sleft_length = 0;
								for(o in ainuo_smilies_array) {
									ainuos_smilies_len = ainuo_smilies_array[o][0].length;
									ainuos_sleft_Text = $ainuos.value.substring(startPos - ainuos_smilies_len + 1, startPos);
									ainuos_sright_Text = $ainuos.value.substring(startPos, startPos + ainuos_smilies_len - 1);
									ainuos_sleft_length = ainuos_sleft_Text.length;
									ainuos_sall_Text = ainuos_sleft_Text + ainuos_sright_Text;
									for(p in ainuo_smilies_array[o]) {
										is_smilies = ainuos_sall_Text.indexOf(ainuo_smilies_array[o][p]);
										if(is_smilies >= 0){
											var startText = $ainuos.value.substring(0, startPos - ainuos_sleft_length + is_smilies);
											var endText = $ainuos.value.substring(startPos - ainuos_sleft_length + is_smilies + ainuos_smilies_len, $ainuos.value.length);
											$ainuos.value = startText + endText;
											$ainuos.selectionStart = $ainuos.selectionEnd = startText.length;	
											return false;
										}
									}
								}
							}
						}
					}
				})
			})(jQuery);
		}
		
	});
	
		
		Zepto(document).on('infinite', function() {
			var scrollpageid = $(".ainuopage_main").attr("id");

			if((scrollpageid.indexOf('forum_forumdisplay') <= 0) && (scrollpageid.indexOf('portal_list') <= 0) && (scrollpageid.indexOf('group_forumdisplay') <= 0) && (scrollpageid.indexOf('forum_viewthread') <= 0) && (scrollpageid.indexOf('group_viewthread') <= 0) && (scrollpageid.indexOf('forum_guide') <= 0)){return false};
			
			if(ainuo_forum_loading) return;
			ainuo_forum_loading = true;
			setTimeout(function() {
				ainuo_forum_loading = false;
				if(document.getElementById("ainuoloadmore")){
					if((scrollpageid.indexOf('forum_viewthread') > 0)){
						var ainuo_forum_ainuonextpage = getNodeNum();
					}else{
						var ainuo_forum_ainuonextpage = document.getElementById("ainuoloadmore").getElementsByTagName("li").length;
					}
				}
				if(ainuo_forum_ainuonextpage == 0){return;}
				var ainuo_forum_aloadnum = Math.ceil(ainuo_forum_ainuonextpage / ainuo_forum_aperpage) + 1;
				if (ainuo_forum_aloadnum >= (ainuo_forum_ainuomaxpage + 1)) {
					Zepto.detachInfiniteScroll(Zepto('.infinite-scroll'));
					Zepto('.loading').remove();
					document.getElementById("ainuoloadempty").innerHTML = ainuo_forum_empty;
					return;
				}
				ainuo_forum_load(ainuo_forum_aloadnum);
				Zepto.refreshScroller();
			}, 500);
			
			function getNodeNum(){
				var newObj = document.getElementById("ainuoloadmore").childNodes;
				var nodeNum = 0;
				for(var i=0; i<newObj.length;i++){
					if(newObj[i].className=="plcnotfirst"){
						nodeNum++;
					}
				}
				return nodeNum;
			}
				  
			function ainuo_forum_load(id){
				$.ajax({
					type:'GET',
					url: ainuo_forum_url + id + '&inajax=1&mobile=2',
					dataType:'xml',
				})
				.success(function(s) {
					
					if((scrollpageid.indexOf('forum_viewthread') > 0) || (scrollpageid.indexOf('group_viewthread') > 0)){
						ainuo_forum_html = s.lastChild.firstChild.nodeValue;
						Zepto('.infinite-scroll .ainuoloadmore').append(ainuo_forum_html);
					}else{
						var temploaddiv = '<div id="temploaddiv_' + id + '">';
						ainuo_forum_html = s.lastChild.firstChild.nodeValue;
						temploaddiv += ainuo_forum_html;
						temploaddiv += '</div>';
						Zepto('.infinite-scroll .ainuoloadmore').append(temploaddiv);
					}
					
				})
				.complete(function() {
					setTimeout(function(){
					$(".ainuolazyloadbg").lazyload({
						//effect: "fadeIn",
						//failurelimit : 10,
						container: $("#temploaddiv_"+id),
					});
					$(".ainuolazyload").lazyload({
						placeholder     : "template/qu_app/touch/style/lazy/picloading.gif",
						//effect: "fadeIn",
						//failurelimit : 10,
						container: $("#temploaddiv_"+id),
					});
					if(document.getElementById("ispbl")){
						minigrid('.ainuogrid', '.grid-item', 2, null,
							function() {
								var d = document.querySelector('.ainuo_piclist');
								d.style.opacity = 1;
							}
						);
						window.addEventListener('resize', function() {
							minigrid('.ainuogrid', '.grid-item');
						});
					}},200)
				})
				
				.error(function() {
					document.getElementById("ainuoloadempty").innerHTML = ainuo_forum_emptyfail;
				});
			}
		});


	Zepto.init();
});



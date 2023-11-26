<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!--{eval require_once("template/qu_app/touch/ainuo/ainuo_index.php");}-->
<!--{if $_G['inajax'] == 1}-->
	<!--{template forum/guide_list_row}-->
<!--{else}-->

<!--{hook/guide_quappdiy}-->
<style id="diy_style" type="text/css"></style>
<style>
.indexheader{ position:fixed; z-index:999; top:0; left:0; width:100%; height:44px; line-height:44px;bottom: 0;background: -webkit-linear-gradient(bottom,rgba(45,45,45,0),rgba(45,45,45,.8));background: linear-gradient(to top,rgba(45,45,45,0),rgba(45,45,45,.8));font-size:14px;color:#fff;border-bottom:none;}
.indexheader a{ color:#fff;}
.indexheader .z{ width:44px; display:block; height:44px; text-align:center;}
.indexheader i{ color:#fff;}
.indexheader span{ margin-right:10px;}
.indexheader span img{ border-radius:50%; width:22px; height:22px; margin-top:11px;}

.indexheader .toplogo{ text-align:center; font-weight:300; font-size:16px; position:absolute; width:100%; z-index:-1;}

.indexscrollcss{ background:#f13030;}
</style>
<!-- header start -->
<div id="indexheader" class="indexheader">
    <div class="nav">
        <a id="ainuo_toggle_menu" href="javascript:;" class="z"><i class="iconfont icon-menu1"></i></a>
        <!--{if !$_G['uid']}-->
        	<span class="ss y"><a href="member.php?mod=logging&action=login&referer=">$alang_fastlogin</a></span>
        <!--{else}-->
            <span class="ss y"><a href="home.php?mod=space&uid={$_G[uid]}&do=profile&mycenter=1"><!--{avatar($_G[uid], 'middle')}--></a></span>
        <!--{/if}-->
        <div class="toplogo"><!--{if $_G['cache']['plugin']['qu_app']['mb_topword']}-->$_G['cache']['plugin']['qu_app']['mb_topword']<!--{else}-->AINUO APP!<!--{/if}--></div>
        <span class="lg y"><a href="search.php?mod=forum"><i class="iconfont icon-search"></i></a></span>
    </div>
</div>
<!-- header end -->


<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->

<script>

var swiper = new Swiper('.swiper-container', {
	pagination: '.swiper-pagination',
	paginationType : 'fraction',
	paginationFractionRender: function (swiper, currentClassName, totalClassName) {
		return '<span class="' + currentClassName + '"></span>' +
			   '/' +
			   '<span class="' + totalClassName + '"></span>';
	},
	paginationClickable: true,
	loop : true,
	autoplay : 3300,
});
var tjswiper = new Swiper('#guide', {
	direction: 'vertical',
	loop : true,
	simulateTouch : false,
	autoplay : 2800,
	onlyExternal :true,
});
var tabswiper = new Swiper('.ainuo_indexnavtab', {
	pagination: '.pointBox',
	loop : false,
});

</script>

<style>
.ainuo_piclist{}
.ainuo_piclist li{ background:#fff;}
.ainuo_piclist li a{ display:block;}
.ainuo_piclist li a.lione{ padding:12px 10px 6px 10px;}
.ainuo_piclist li a.litwo{ padding:6px 10px 12px 10px;}
.ainuo_piclist li .author{ height:36px;  font-size:12px; color:#999;margin: 15px 10px 10px 10px;}
.ainuo_piclist li .author a{ display:inline;}
.ainuo_piclist li .author .aleft{ float:left; position:relative;}
.ainuo_piclist li .author .aleft .ava{ float:left; margin-right:8px;}
.ainuo_piclist li .author .aleft .t{ color:#333; font-size:14px;}
.ainuo_piclist li .author .aleft .ava img{ width:36px; height:36px;border-radius:50%;}
.ainuo_piclist li .author .aleft p{ position:absolute; left:45px; top:20px;}
.ainuo_piclist li .author .aright{ float:right;}
.ainuo_piclist li .author .aright a{ font-size:12px; color:#fa7d3c; border:1px solid #ddd; border-radius:2px; padding:3px 8px;}
.ainuo_piclist li .author .aright a.ygz{ color:#999; background:#eee;}
.ainuo_piclist li .asub .abadge{color: #fff;background-color: #fe7c51;font-size:12px;padding: 2px 5px; border-radius:2px; position:relative; top:-2px;}
.ainuo_piclist li .asub .leixing{background-color:#A8C500;}
.ainuo_piclist li .asub{ display:flex; position:relative;}
.ainuo_piclist li .asub .atitle{ font-size:17px; line-height:1.5;-webkit-flex-shrink: 1;-ms-flex: 0 1 auto;-webkit-flex-shrink: 1;flex-shrink: 1;position: relative;width: 100%;}
.ainuo_piclist li .apic1{-webkit-flex-shrink: 0;flex-shrink: 0; margin-top:5px;overflow: hidden;}
.ainuo_piclist li .apic1 img{ max-width:85%; height:auto;}
.ainuo_piclist li .apic2{ margin-top:5px;}
.ainuo_piclist li .apic2 .apic{ width:49.5%; margin-left:1%; float:left;}
.ainuo_piclist li .apic2 img{width: 100%;height: auto;}
.ainuo_piclist li .apic2 .apic:first-child {margin-left: 0;}
.ainuo_piclist li .apic3{}
.ainuo_piclist li .apic3 .apic{ width:32.666%; margin-left:1%; float:left; margin-top:1%;}
.ainuo_piclist li .apic3 img{width: 100%;height: auto;}
.ainuo_piclist li .apic3 .apic:first-child {margin-left: 0;}
.ainuo_piclist li .apic3 .apic:nth-child(4) {margin-left: 0;}
.ainuo_piclist li .apic3 .apic:nth-child(7) {margin-left: 0;}
.ainuo_piclist li .afenlei{  padding:0 10px; height:30px;}
.ainuo_piclist li .afenlei em{font-size:0;}
.ainuo_piclist li .afenlei em a{font-size: 12px;display: inline;background: #eee;padding: 3px 10px;border-radius: 20px;color: #666;}
.ainuo_piclist li .abot{ border-top:1px solid #eee; font-size:12px; height:40px; line-height:40px;}
.ainuo_piclist li .abot a{ display:block; color:#666; text-align:center; width:33.333%; float:left; border-left:1px solid #f2f2f2; margin-left:-1px;}
.ainuo_piclist li .abot i{ position:relative; top:2px;}
.ainuo_piclist li .abot .yidianzan{ color:#f55318;}

.ainuo_piclist .mod-lv {display: inline-block;height: 16px;-webkit-border-radius: 10px;background: #ffc11b;color: #fff;text-align: center;margin: 0 3px;vertical-align: middle;white-space: nowrap;padding: 0 4px;font-size: 0;position:relative;top:-1px;}
.ainuo_piclist .mod-lv .mod-lv-icon {line-height: 16px;width: 16px;height: 16px;margin-left: -4px;margin-right: 2px;border: 1px solid rgba(255,181,36,.8);color: #ed850a;background: #ffe970;-webkit-border-radius: 100%;display: inline-block;vertical-align: top;position: relative;font-size: 11px;}
.ainuo_piclist .mod-lv .mod-lv-icon i {position: absolute;width: 100%;height: 100%;left: 0;top: 0;font-size:12px;}
.ainuo_piclist .mod-lv span:not(.mod-lv-icon) {font-size: 11px;line-height: 17px;display: inline-block;vertical-align: top;position: relative;}

</style>



<div class="ainuo_xbtj cl">
	{if $_G['cache']['plugin']['qu_app']['mb_loadtit']}
	<div class="atit cl">$_G['cache']['plugin']['qu_app']['mb_loadtit']</div>
    {/if}
    <div class="acon cl">
    	
            <div class="ainuo_piclist cl">
                <ul id="ainuoloadmore" class="ainuoloadmore">
                    <!--{template forum/guide_list_row}-->
                </ul>
            </div>
    </div>
    
    <div id="ainuoloadempty"></div>
    <!--{if $adata[$view]['threadcount'] > 10}-->
    <div id="loading" class="loading G-animate-load-wrap">
        <div class="load-loading"><span class="loading02"></span> <span class="load-word">$alang_loading</span></div>
    </div>
    <!--{/if}-->
</div>

<script>
	var ainuo_forum_html = '';
	var ainuo_forum_empty = '<div class="inner">$alang_nomore</div>';
	var ainuo_forum_emptyfail = '<div class="inner">$alang_loadfail</div>';				
	var ainuo_forum_loading = false;
	var ainuo_forum_aperpage = 10;
	var ainuo_forum_ainuomaxpage = $maxpage;
	var ainuo_forum_url = 'forum.php?mod=guide&page=';
</script>

<script type="text/javascript">
	function zanbuzan(val,clsa,aid){
		<!--{if !$_G[uid]}-->
			popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
			return false;
		<!--{/if}-->
		Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
		$.ajax({
			type:'GET',
			url:'forum.php?mod=misc&action=recommend&do=add&tid='+aid+'&hash={FORMHASH}&inajax=1',
			dataType:'xml',
		})
		.success(function(s) {
			if(s.lastChild.firstChild.nodeValue.indexOf("$alang_yipingjia") >= 0){
				Zepto('.ainuooverlay').remove();
				Zepto.toast('$alang_dianzanguo',1000,'toast');
			}else if(s.lastChild.firstChild.nodeValue.indexOf("$alang_zanjiayi") >= 0){
				setTimeout((document.getElementById(clsa).innerHTML = parseInt(document.getElementById(clsa).innerHTML) + 1),500);
				$("#dianzan_" + aid).addClass('yidianzan');
				$("#i_" + aid).addClass('icon-appreciate_fill_light');
				Zepto('.ainuooverlay').remove();
				Zepto.toast('$alang_zanjiayi2',1000,'toast');
			}
		})
		.error(function() {
			window.location.href = obj.attr('href');
			Zepto('.ainuooverlay').remove();
		});
		return false;
	};
</script>
<script type="text/javascript">
	function guanzhutis(val,clsa,aid){
		<!--{if !$_G[uid]}-->
			popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
			return false;
		<!--{/if}-->
		if(document.getElementById(val).innerHTML.indexOf("+") >= 0){
			var ahref = 'home.php?mod=spacecp&ac=follow&op=add&fuid='+aid+'&hash={FORMHASH}';
		}else{
			var ahref = 'home.php?mod=spacecp&ac=follow&op=del&fuid='+aid;
		}
		Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
		$.ajax({
			type:'GET',
			url:ahref + '&inajax=1',
			dataType:'xml',
		})
		.success(function(s) {	
			if(s.lastChild.firstChild.nodeValue.indexOf("$alang_notgzziji") >= 0){
				Zepto.toast('$alang_notgzziji',1000,'toast');
			}else if(s.lastChild.firstChild.nodeValue.indexOf("$alang_cgshouting") >= 0){
				$("."+clsa).text('$alang_yiguanzhu');
				//$("."+clsa).attr('href','home.php?mod=spacecp&ac=follow&op=del&fuid='+aid); 
				Zepto.toast('$alang_cgshouting2',1000,'toast');
			}else if(s.lastChild.firstChild.nodeValue.indexOf("$alang_qxchenggong") >= 0){
				//document.getElementById("ainuo_wait_{$thread['authorid']}").innerHTML = '+ $nh_guanzhu';
				$("."+clsa).text('+ $alang_gz');
				//$("."+clsa).attr('href','home.php?mod=spacecp&ac=follow&op=add&fuid='+aid+'&hash={FORMHASH}'); 
				Zepto.toast('$alang_qxchenggong2',1000,'toast');
			}
			Zepto('.ainuooverlay').remove();
		})
		.error(function() {
			window.location.href = obj.attr('href');
			Zepto('.ainuooverlay').remove();
		});
		return false;
	};
</script>

<!--{/if}-->
                 
<!--{template common/footer}-->

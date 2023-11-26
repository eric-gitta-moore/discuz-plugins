<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{block srhead}-->
<script type="text/javascript" src="source/plugin/sanree_brand/tpl/bird/js/jquery.min.js"></script>
<script src="source/plugin/sanree_brand/tpl/bird/js/jquery.kinMaxShow-1.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
	function getassist(obj) {
		var count = '{$assistcount}';
		count++;

		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else {// code for IE6, IE5
		   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange=function() {

			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				if(xmlhttp.responseText) {

					obj.onclick = '';
					obj.style.cursor = 'default';
					obj.style.textDecoration = 'none';
					obj.innerHTML = '<span>{lang sanree_brand:assistly}<em>'+count+'</em>{lang sanree_brand:bird_item_num}</span>';

				}
			}
		}
		xmlhttp.open("GET",'plugin.php?id=sanree_brand&mod=assist&tid={$bid}',true);
		xmlhttp.send();

	}

</script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script>
<script>
jQuery.noConflict();
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
	var divN = jQuery(".mobile_code").length;
	if(divN == 0){
		jQuery(".sr_infor").css("width", "840px");
	}else{
		jQuery(".sr_infor").css("width", "695px");
	}
});
</script>
<script type="text/javascript">
jQuery(function(){
	jQuery(".sr_slidebox").kinMaxShow({
		intervalTime: 2
	});
});
</script>
<!--{if defined('IN_BRAND_USER')}-->
<script src="{sr_brand_JS}/manage.js?{VERHASH}"></script>
<link type="text/css" rel="stylesheet" href="source/plugin/sanree_brand/tpl/bird/cr.css" />
<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/sanree_brand.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/header.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/msg.css?{VERHASH}" />
<div class="brand_manage" id="managebar" style="display:none">
<div class="filterdiv" style="height:{$ih}px"></div>
<div class="fshow">
  <div class="m950">
	<ul class="managenav">
	  <!--{loop $managemenulist $menu}-->
	  <!--{if !empty($menu[addhtml])}-->{$menu[addhtml]}<!--{/if}-->
	  <!--{if $menu[window]==1}-->
	  <li {$menu[class]}>
		<!--{if !empty($menu[image])}--><a href="{$menu[url]}" title="{$menu[title]}" id="{$menu[name]}" onClick="showWindow('{$menu[name]}', this.href, 'get', 1)"><img src="{$menu[image]}" /></a><!--{/if}-->
		<a href="{$menu[url]}" title="{$menu[title]}" id="{$menu[name]}" onClick="showWindow('{$menu[name]}', this.href, 'get', 1)">{$menu[title]}</a></li>
	  <!--{else}-->
	  <li {$menu[class]}>
		<!--{if !empty($menu[image])}--><a {if !empty($menu[url])} href="{$menu[url]}" {/if} title="{$menu[title]}" target="_blank"><img src="{$menu[image]}" /></a><!--{/if}-->
		<a {if !empty($menu[url])} href="{$menu[url]}" {/if} title="{$menu[title]}" target="_blank">{$menu[title]}</a></li>
	  <!--{/if}-->
	  <!--{/loop}-->
	</ul>
	<div class="mclose"><a href="javascript:void(0)" onClick="showmanage()" class="srflbc"></a></div>
  </div>
</div>
</div>
<!--{/if}-->
<div class="sr_header">
<div class="headerbox">
  <div class="sr_logo l"><img src="$_G[siteurl]{BIRD_CSS}timthumb.php?src=$_G[siteurl]{$brandresult[poster]}&h=120&w=120&zc=1" /></div>
  <div class="sr_infor l">
	<div class="topname">
	  <div class="cn"><span>{$brandresult[tel114url]}</span>{$brandresult[name]}<!--{if $pbidlist}-->&nbsp;&nbsp;<a href="plugin.php?id=sanree_brand&mod=branch&tid={$brandresult[bid]}" id="branchdlg" onClick="showWindow(this.id, this.href, 'get', 1)" title="{lang sanree_brand:tplbranch}"><img src="{SANREE_BRAND_TEMPLATE}/images/branch.jpg" /></a><!--{/if}-->
	  </div>
	  <div class="adress">
		<div class="ys_adress l"><span>{lang sanree_brand:oaddress}</span>{$brandresult[address]}</div>
	  </div>
	  <!--{if $mtfopen}-->
	  <div class="qy_rz"><img src="{$mtf}" /></div>
	  <!--{/if}-->
	  <!--{if !$brandresult['ownerid']}--> 
	  <div class="frenling"> 
		<a href="plugin.php?id=sanree_brand&mod=msg&bid={$brandresult[bid]}&type=1" id="cmenu" onClick="showWindow('cmenu', this.href, 'get', 1)">[{lang sanree_brand:claimbrand}]</a> 
	  </div>
	  <!--{/if}-->
	</div>
	<div class="btel">
	  <div class="sr_tel l">
				<!--{if $ismultiple==1&&$brandresult[allowmultiple]==1}-->
				<ul id="telbox">
					<li>
						<a onMouseOver="mopen('m1')" onMouseOut="mclosetime()"><i>{lang sanree_brand:otelphone}</i> $brandresult[tel]</a>
						<div id="m1" onMouseOver="mcancelclosetime()" onMouseOut="mclosetime()">
						<!--{loop $tellist $cate}-->
						<a><i>{lang sanree_brand:otelphone}</i> $cate</a>
						<!--{/loop}-->
						</div>
					</li>
				</ul>
				<!--{else}-->
						<div class="singletel"><a><i>{lang sanree_brand:otelphone}</i> {$brandresult[tel]}</a></div>
				<!--{/if}-->
			</div>
	  <div class="sr_zan l"> <span class="l">{lang sanree_brand:satisfaction}</span>
		<div class="star"> <span class="staroff"> <span class="staron" style="width: {$brandresult[satisfaction]}%;"></span></span></div>
	  </div>
	  <div class="sr_taotie l">
	  <!--{if $ttid}-->
		<a href="forum.php?mod=collection&action=edit&op=addthread&tid={$ttid}" id="k_collect" onclick="showWindow(this.id, this.href);return false;"><i><img src="{IMGDIR}/collection.png" alt="{lang thread_share}" />{lang sanree_brand:collection}<span style="display:none"><span id="collectionnumber"></span></span></i></a>
	  <!--{/if}-->
	  </div>
	  <!--{if $brandresult[iscard]}-->
	  <div class="brandcard l">
	  <a class="bc"><img src="{BIRD_CSS}images/brandcard.gif" /></a>
		<div class="bc_box">
			<div class="bc_tit"><img src="{BIRD_CSS}images/brandcard.gif" /><i class="bc_close"><img src="{BIRD_CSS}images/close-icon.png" /></i></div>
			<div class="bc_con">
				<!--{if $brandresult[carddetail]}-->{$brandresult[carddetail]}<!--{else}-->{lang sanree_brand:nodetail}<!--{/if}-->
			</div>
		</div>
		<div class="bc_bg"></div>
	  </div>
	  <!--{/if}-->
	  <div class="ys_map l"><a class="modalLink2" href="plugin.php?id=sanree_brand&mod=map&tid={$tid}&bid={$bid}" onClick="showWindow(this.id, this.href, 'get', 1)" id="publisheddlg">[{lang sanree_brand:bird_item_map}]</a></div>
			<div class="sr_fuctionbox r">
					<div class="sr_wapmain">
					<!--{if $_G[cache][plugin][sanree_brand_wap][isopen]==1}-->
						<ul>
							<li>
								<a onMouseOver="mopen('m2')" onMouseOut="mclosetime()">{lang sanree_brand:bird_detail_wap}</a>
								<div id="m2" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
									<img src="plugin.php?id=sanree_brand_wap&mod=show2code&tid={$brandresult[bid]}" />
								</div>
							</li>
						</ul>
						<!--{/if}-->
				</div>
				<div class="sr_follow">
					<!--{if $attention}-->
					<!--{if $flag}-->
					<a onClick="return(confirm('{$deltip}'))" href="{$atnurl}">- {lang sanree_brand:bird_detail_followed}</a> 
					<!--{else}--> 
					<a href="{$atnurl}">+ {lang sanree_brand:bird_detail_followus}</a> 
					<!--{/if}-->
					<!--{/if}-->
				</div>
				<div class="sr_good">
					<a href="javascript:;" onClick="<!--{if !$assistflag}--><!--{if $_G[uid]}-->getassist(this);<!--{else}-->location.href='plugin.php?id=sanree_brand&mod=assist&tid={$bid}&uid=1'<!--{/if}--><!--{/if}-->"> <span><!--{if $assistflag}-->{lang sanree_brand:assistly}<em>{$assistcount}</em><!--{else}-->{lang sanree_brand:promotion_assist}<em>{$assistcount}</em><!--{/if}-->{lang sanree_brand:bird_item_num}</span>
					</a>
				</div>
			</div>
	</div>
  </div>
	<!--{if $_G['cache']['plugin']['sanree_we']['isopen']}-->
	<div class="mobile_code l">
		<div class="mc_con">
		<div class="mc_ch"><img src="plugin.php?id=sanree_we&mod=codehome&cmod=item&tid={$brandresult['bid']}"></div>
		</div>
		<div class="mc_txt">{lang sanree_brand:scancostwap}</div>
	</div>
	<!--{/if}-->
  <div class="clear"></div>
  <div class="sr_nav">
	<ul class="l" style="position: relative; z-index: -9;">
	  <!--{loop $headermenulist $menu}-->
	  <li><a href="{$menu[url]}" {$menu[class]}>{$menu[title]}</a></li>
	  <!--{/loop}-->
	</ul>
	<div class="sr_share r"> 
	  <!-- Baidu Button BEGIN --> 
		<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a></div>
		<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
	  <!-- Baidu Button END --> 
	</div>
  </div>
</div>
</div>
<div class="clear"></div>
<div class="sr_slidebox">
<!--{loop $slidelist $slide}-->
<!--{if $slide}-->
<div>
  <!--{if !$brandresult[newbanner]}-->
  <a href="$slide[url]" ><img src="{$slide[pic]}" /></a>
  <!--{else}-->
  <a href="$slide[url]" ><img src="{$slide_prefix}{$slide['pic']}" /></a>
  <!--{/if}-->
</div>
<!--{/if}-->
<!--{/loop}-->
</div>
<div class="clear"></div>
<!--{if $brandresult[weixinimg] || defined('IN_BRAND_USER') || $brandresult[weixin]}-->
<div id="cc">
	<div class="cc_box">
    	<!--{if $brandresult[weixinimg]}-->
		<div class="cp"><img src="{$slide_prefix}{$brandresult[weixinimg]}"></div>
        <!--{/if}-->
        <!--{if $brandresult[weixin]}-->
		<div class="cp_t">{lang sanree_brand:weixin_str2}<strong>{$brandresult[weixin]}</strong></div>
        <!--{/if}-->
        <!--{if defined('IN_BRAND_USER')}-->
		<div class="gl_btn"><a href="javascript:" onClick="showmanage(1)">{lang sanree_brand:bird_detail_management}</a></div>
        <!--{/if}-->	
	</div>
</div>
<!--{/if}-->
<!--{/block}-->
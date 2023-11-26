<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{block srhead}-->
<link type="text/css" rel="stylesheet" href="source/plugin/sanree_brand/tpl/nice/nice-item.css" />
<script type="text/javascript" src="source/plugin/sanree_brand/tpl/nice/js/jquery.min.js"></script>
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
function killerrors() { return true; } window.onerror = killerrors;
</script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script>
<script language="javascript">
jQuery.noConflict();
jQuery(document).ready(function(){
    jQuery(document.body).limit();
});
</script>
<!--{if defined('IN_BRAND_USER')}-->
<script src="{sr_brand_JS}/manage.js?{VERHASH}"></script>
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
<div class="header-bg"></div>
<div class="headerbox">
<div class="sr_box">
	<div class="n-topname">
		<div class="cn">
			{$brandresult[name]}<span>{$brandresult[tel114url]}</span>
		</div>
	</div>
  <div class="sr_logo l"><img src="{$brandresult[poster]}" /></div>
  <div class="sr_inforbox">
  <div class="sr_infor l">
	<div class="left_infor">
		<ul>
			<li>
				<div class="li-dp">
					<i>{lang sanree_brand:reggrade}</i>
					<div class="star">
						<span class="staroff"><span class="staron" style="width: {$brandresult[satisfaction]}%;"></span></span>
					</div>
				</div>
			</li>
			<li>
				<div class="li-zs">
					<i>{lang sanree_brand:recommendationindex1}</i><strong>{$brandresult[recommendationindex]}</strong>%
				</div>
			</li>
			<li>
				<div class="li-dz">
					<i>{lang sanree_brand:itemdiscount}</i><strong>{$brandresult['discount']}</strong> <img src="{sr_brand_IMG}/zhe.gif" />
				</div>
			</li>
			<li>
				<div class="li-zk">
					<i><em class="brandgroup">{lang sanree_brand:brandgroup}</em><img align="absmiddle" src="{$brandresult[groupimg]}" /></i>
				</div>
			</li>
		</ul>
	</div>
	<div class="middle_infor">
		<ul>
			<li>
				<div class="li-fl">
					<i>{lang sanree_brand:cateh}<span style="color: #ff6600;">{$brandresult[catename]}</span></i>
				</div>
			</li>
			<li>
				<div class="li-dq">
					<i><em>{lang sanree_brand:region}</em>
						<!--{if $isselfdistrict==1}-->
						<span style="color: #ff6600;">{$brandresult[srbirthprovince]} {if $brandresult[srbirthcity]}-{/if} {$brandresult[srbirthcity]} {if $brandresult[srbirthdist]}-{/if} {$brandresult[srbirthdist]}</span>
						<!--{else}-->
						<span style="color: #ff6600;">{$brandresult[birthprovince]} {if $brandresult[birthcity]}-{/if} {$brandresult[birthcity]} {if $brandresult[birthdist]}-{/if} {$brandresult[birthdist]}</span>
						<!--{/if}-->
					</i>
				</div>
			</li>
			<li>
			  <!--{if $brandresult[iscard]}-->
			  <div class="brandcard">
			  <i>{lang sanree_brand:supportcoupon}</i>
			  <a class="bc"><img src="{NICE_CSS}images/brandcard.gif" /></a>
				<div class="bc_box">
					<div class="bc_tit"><img src="{NICE_CSS}images/brandcard.gif" /><i class="bc_close"><img src="{NICE_CSS}images/close-icon.png" /></i></div>
					<div class="bc_con">
						<!--{if $brandresult[carddetail]}-->{$brandresult[carddetail]}<!--{else}-->{lang sanree_brand:nodetail}<!--{/if}-->
					</div>
				</div>
				<div class="bc_bg"></div>
			  </div>
			  <!--{/if}-->
			</li>
			<li>
				<div class="brandqq">
					<i>{lang sanree_brand:brand_qq}</i>
				<!--{if $ismultiple==1&&$brandresult[allowmultiple]==1}-->
					{$brandresult['icq']}
				<!--{else}-->
					{$brandresult['qq']}
				<!--{/if}-->
				</div>
			</li>
		</ul>
	</div>
	<div class="clear"></div>
	<div class="bottom_infor">
		<ul>
			<li>
				<div class="li-ts"><i>{lang sanree_brand:tplmf}</i><div class="li-r"><span>{$mfliststr}</span></div></div>
			</li>
			<li>
				<div class="li-tag">
				<!--{if $tagdata}-->
				<i>{lang sanree_brand:bird_detail_tag}</i>
				<div class="li-r">
					<!--{loop $tagdata $tag}-->
					<a href="{$tag['url']}"<span>{$tag['tagname']}</span></a>
					<!--{/loop}-->
				</div>
				<!--{/if}-->
				</div>
			</li>
			<li>
			  <div class="adress">
				<i>{lang sanree_brand:brand_address}</i>
				<div class="li-r"><div class="ys_adress">{$brandresult[address]}</div></div>
			  </div>
			</li>
			<li>
				<div class="li-tel">
					<i>{lang sanree_brand:brand_tel}</i>
					<!--{if $ismultiple==1&&$brandresult[allowmultiple]==1}-->
					{eval $douhao = count($tellist);}{eval $re=0;}
						<div class="li-r">
							<!--{loop $tellist $cate}-->
							 {eval $re++;}
							 {$cate}{if $douhao != $re},{/if}
							<!--{/loop}-->
						</div>
					<!--{else}-->
						<div class="li-r">
							{$brandresult['tel']}
						</div>
					<!--{/if}-->
				</div>
			</li>
		</ul>
	</div>
	</div>
	<div class="right_infor">
		<ul class="ri-btn">
			<!--{eval $weisopen = $_G['cache']['plugin']['sanree_we']['isopen'];}-->
			<!--{if $weisopen}-->
			<li class="ri-class current">{lang sanree_brand:entermoblie}</li>
			<!--{/if}-->
			<!--{if $brandresult[weixinimg]}-->
			<li class="ri-class">{lang sanree_brand:scanxh}</li>
			<!--{/if}-->
			<!--{if $brandresult[weixinpublicpic]}-->
			<li class="ri-class">{lang sanree_brand:scanzh}</li>
			<!--{/if}-->
			<!--{if defined('IN_BRAND_USER')}-->
			<li>
				<div class="gl_btn"><a href="javascript:" onClick="showmanage(1)">{lang sanree_brand:bird_detail_management}</a></div>
			</li>
			<!--{/if}-->
		</ul>
		<div class="ri-con">
			<!--{if $brandresult[weixinimg] || defined('IN_BRAND_USER') || $brandresult[weixin] || $weisopen}-->
			<ul>
				<!--{if $brandresult[weixinimg] || $brandresult[weixin] || $weisopen}-->
				<!--{eval $re=false;}-->
				<!--{if $weisopen}-->
				<li class="{if $re == true}hide{else}mobile_code{/if}">
					<div>
						<div class="mc_con">
						<div class="mc_ch"><img src="plugin.php?id=sanree_we&mod=codehome&cmod=item&tid={$brandresult['bid']}"></div>
						</div>
						<div class="mc_txt">{lang sanree_brand:scangomobile}</div>
					</div>
					<!--{eval $re=true;}-->
				</li>
				<!--{/if}-->
				<!--{if $brandresult[weixinimg]}-->
				<li class="{if $re == true}hide{else}mobile_code{/if}">
					<div class="cp"><img src="{$brandresult[weixinimg]}"></div>
					<div class="mc_txt">{lang sanree_brand:scangzweixin}</div>
					<!--{eval $re=true;}-->
				</li>
				<!--{/if}-->
				<!--{if $brandresult[weixinpublicpic]}-->
				<li class="{if $re == true}hide{else}mobile_code{/if}">
					<div class="cp"><img src="{$brandresult[weixinpublicpic]}"></div>
					<div class="mc_txt">{lang sanree_brand:scangzgzweixin}</div>
					<!--{eval $re=true;}-->
				</li>
				<!--{/if}-->
				<!--{else}-->
				<li class="mobile_code hide">
					<div class="mc-last">
						<img src="source/plugin/sanree_brand/tpl/good/images/nocode.gif" />
					</div>
				</li>
				<!--{/if}-->
			</ul>
			<!--{/if}-->
		</div>
	</div>
	<div class="clear"></div>
	<div class="btn_infor">
		<div class="bi-con">
			<div class="bi-smallbtn">
				<ul>
					<li>
						<!--{if $tmpconfig['isshowmap']}-->
						<div class="bi-map">
							<a href="plugin.php?id=sanree_brand&mod=map&tid={$tid}&bid={$bid}" onClick="showWindow(this.id, this.href, 'get', 1)" id="publisheddlg"><i class="all-icon"></i>{lang sanree_brand:bird_item_map}</a>
						</div>
						<!--{/if}-->
					</li>
					<li>
						<div class="bi-follow">
							<!--{if $attention}-->
							<!--{if $flag}-->
							<a onClick="return(confirm('{$deltip}'))" href="{$atnurl}" class="li-followed"><i class="all-icon"></i>{lang sanree_brand:bird_detail_followed}</a> 
							<!--{else}--> 
							<a href="{$atnurl}" class="li-follow"><i class="all-icon"></i>{lang sanree_brand:bird_detail_followus}</a> 
							<!--{/if}-->
							<!--{/if}-->
						</div>
					</li>
					<li style="padding-right: none; margin-right: none; border-right: none;">
						<div class="bi-good">
							<a href="javascript:;" onClick="<!--{if !$assistflag}--><!--{if $_G[uid]}-->getassist(this);<!--{else}-->location.href='plugin.php?id=sanree_brand&mod=assist&tid={$bid}&uid=1'<!--{/if}--><!--{/if}-->"><i class="all-icon"></i><span><!--{if $assistflag}-->{lang sanree_brand:assistly}<em>{$assistcount}</em><!--{else}-->{lang sanree_brand:promotion_assist}<em>{$assistcount}</em><!--{/if}-->{lang sanree_brand:bird_item_num}</span>
							</a>
						</div>
					</li>
					<li>
						<!--{if $ttid}-->
						<div class="sr_taotie">
						<a href="forum.php?mod=collection&action=edit&op=addthread&tid={$ttid}" id="k_collect" onclick="showWindow(this.id, this.href);return false;"><i class="all-icon"></i>{lang sanree_brand:collection}<span style="display:none"><span id="collectionnumber"></span></span></a>
						</div>
						<!--{/if}-->
					</li>
				</ul>
			</div>
			<div class="bi-mine">
				<a href="home.php?mod=spacecp&ac=favorite&type=thread&id={$brandresult['tid']}" id="k_favorite" onClick="stid={$cate[tid]};showWindow(this.id, this.href, 'get', 0);" class="bi-sc"><i class="all-icon"></i>{lang sanree_brand:thread_favorite}</a>
				<!-- Baidu Button BEGIN --> 
				<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"><i class="all-icon"></i>{lang sanree_brand:thread_share}</a></div>
				<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
				<!-- Baidu Button END -->
				</a>
			</div>
		</div>
	</div>
	</div>
	<div class="clear"></div>
	<div class="topright">
		<!--{if $mtfopen}-->
		<div class="qy_rz"><img src="{$mtf}" /></div>
		<!--{/if}-->
		<!--{if $pbidlist}-->
		<div class="qy_fd">
			<a href="plugin.php?id=sanree_brand&mod=branch&tid={$brandresult[bid]}" id="branchdlg" onClick="showWindow(this.id, this.href, 'get', 1)" title="{lang sanree_brand:tplbranch}">{lang sanree_brand:subbranchinfo}</a>
		</div>
		<!--{/if}-->
		<!--{if !$brandresult['ownerid']}--> 
		<div class="frenling"> 
		<a href="plugin.php?id=sanree_brand&mod=msg&bid={$brandresult[bid]}&type=1" id="cmenu" onClick="showWindow('cmenu', this.href, 'get', 1)">[{lang sanree_brand:claimbrand}]</a> 
		</div>
		<!--{/if}-->
	</div>
  </div>
</div>
<div class="clear"></div>
  <div class="sr_nav">
	<ul class="l" style="position: relative; z-index: -9;">
	  <!--{loop $headermenulist $menu}-->
	  <li><a href="{$menu[url]}" {$menu[class]}>{$menu[title]}</a></li>
	  <!--{/loop}-->
	</ul>
  </div>
</div>
<!--{if  $_G['sr_mod'] == 'item'|| $_G['sr_mod'] == 'detail' }-->
<div class="clear"></div>
<div class="sr_itemslide">
      <div class="item_slide">
        <div class="bd">
          <ul>
          <!--{loop $slidelist $cate}-->
            <li style="background:{$cate[color]} center 0 no-repeat;"><a target="_blank" href="{$cate[url]}"><img src="{$cate[pic]}"></a></li>
          <!--{/loop}-->
          </ul>
        </div>
        <div class="hd">
          <ul>
          </ul>
        </div>
    </div>
</div>
<!--{/if}-->
<div class="clear"></div>
<script type="text/javascript" src="source/plugin/sanree_brand/tpl/nice/js/portamento.js"></script>
<script type="text/javascript" src="source/plugin/sanree_brand/tpl/nice/js/superslide.2.1.js"></script>
<script type="text/javascript" src="source/plugin/sanree_brand/tpl/nice/js/nice-item.js"></script>
<!--{/block}-->
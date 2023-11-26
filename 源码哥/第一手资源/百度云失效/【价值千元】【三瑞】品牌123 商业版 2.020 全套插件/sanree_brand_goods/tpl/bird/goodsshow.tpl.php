<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{eval $_G['disabledwidthauto']=TRUE;}-->
<!--{if ($ishideheader==1) }-->
<!--{subtemplate common/header_common}-->
{$brand_header_one}
<!--{ad/headerbanner/wp a_h}-->
<!--{hook/global_header}-->
<div id="wp" class="wp">
<!--{else}-->
{subtemplate common/header}
<!--{/if}-->
<!--{if ($tel114version >=1121) }-->
<link rel="stylesheet" type="text/css" id="sanree_tel114" href="source/plugin/sanree_tel114/style/tel.css?{VERHASH}" />
<!--{/if}-->
<link type="text/css" rel="stylesheet" href="source/plugin/sanree_brand/tpl/bird/cr.css" />
<link type="text/css" rel="stylesheet" href="source/plugin/sanree_brand_goods/tpl/bird/usergoods.css" />
<link rel="stylesheet" type="text/css" id="sanree_brand_common" href="data/cache/style_{STYLEID}_forum_viewthread.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/sanree_brand.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/userbar.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/header.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/albumlist.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/msg.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand_goods/tpl/default/goodsshow.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand_goods/tpl/default/fastpost.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand_goods/tpl/default/tipbox.css?{VERHASH}" />
<link type="text/css" rel="stylesheet" href="{BIRD_CSS}album.css" />
<script type="text/javascript" src="source/plugin/sanree_brand/tpl/bird/js/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/sanree_brand/tpl/bird/js/dropdown.js"></script>
<script language="javascript">jQuery.noConflict();</script>
<script src="source/plugin/sanree_brand/tpl/bird/js/jquery.kinMaxShow-1.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="source/plugin/sanree_brand/tpl/bird/js/jquery.autofix_anything.js"></script>
<script type="text/javascript" src="source/plugin/sanree_brand/tpl/bird/js/modernizr.custom.79639.js"></script>
<!--[if IE 6]>
<script src="source/plugin/sanree_brand/tpl/bird/js/DD_belatedPNG_0.0.8a.js" type="text/javascript" ></script>
<script type="text/javascript">
DD_belatedPNG.fix('#main,.in-v1-top,.in-v1-bot,.in-v1-cont,.in-v2-top,.in-v2-bot,h1.logo,ul#nav li a,.copyRight,img,background,.modal');
</script> 
<![endif]-->
<script src="source/plugin/sanree_brand/tpl/good/js/sanree_brand.js?{VERHASH}"></script>
<script src="source/plugin/sanree_brand/tpl/good/js/voter.js?{VERHASH}"></script>
<script src="source/plugin/sanree_brand_goods/tpl/default/js/tipbox.js?{VERHASH}"></script>
<script src="static/js/forum_viewthread.js"></script>
<script language="javascript">
	var stid=0;
	var aimgcount = new Array();
	aimgcount[{$catid}] = {$aids};
	attachimggroup({$catid});
	attachimgshow({$catid});
	var aimgfid = 0;

	var langvoter=Array();
	langvoter[0] = '{lang sanree_brand_goods:pleasestar}';
	langvoter[1] = '{lang sanree_brand_goods:pleasestarstr}';
function centerimg(img) {

	var div = img.parentNode;
	var divw = div.clientWidth||div.offsetWidth;
	var imgw = img.clientWidth||img.offsetWidth;
	if (imgw>600) {
		img.width=600;
		imgw=600;
	}		
	var left = (divw - imgw) / 2 - 20;
	img.style.marginLeft = left + "px";

}	
</script>
<style>
.sr_wrapper .sr_slide {
	display:none;
}
</style>
<!--star-->
<div class="sr_wrapper">
<div class="mc_albox">
  <!--{hook/sanree_brand_usertoper}-->
  <div id="pt" class="bm cl">
    <div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$modelurl}">{$maintitle}</a>$navigation </div>
  </div>
  {$srhead}
  <!--{hook/sanree_brand_userheader}-->
<div class="com_cbc">
	  <!--{hook/sanree_brand_userlefttop}-->
      <div class="mc_tit">
      	<span class="l"><i class="icon"></i>{$goodsresult[name]}</span>
      </div>
	  <div class="clear"></div>
	  <div class="com_content">
		<div class="com_l_img l"><img id='aimg_{$goodsresult[homeaid]}' src="{$goodsresult[gpicture]}" title="{$goodsresult[name]}" onClick="zoom(this, this.src)" alt="{$goodsresult[name]}" /></div>
		<div class="com_r_info r">
			<div class="com_t_li">
				<div>{lang sanree_brand_goods:post_goodsno}<em>{$goodsresult[goodsno]}</em></div>
				<div>{lang sanree_brand_goods:post_minprice}<strong>{$config['selectpriceunitshow'][$goodsresult[priceunit]]} {$goodsresult[minprice]}<!--{if $goodsresult[unit]}--> / {$goodsresult[unit]}<!--{/if}--></strong></div>
				<div>{lang sanree_brand_goods:post_price}<s>{$config['selectpriceunitshow'][$goodsresult[priceunit]]} {$goodsresult[price]}<!--{if $goodsresult[unit]}--> / {$goodsresult[unit]}<!--{/if}--></s></div>
			</div>
			<div class="com_b_li">
				<div class="com_b_cat">{lang sanree_brand_goods:post_goodscate}<em>{$goodsresult[catename]}</em></div>
				<div class="com_b_sj">{lang sanree_brand_goods:post_dateline}<span>{$goodsresult[dateline]}<span></div>
				<div class="com_b_box">
					<div class="li_user l">{lang sanree_brand_goods:satisfaction}</div>
						<div class="star" title="{lang sanree_brand_goods:satisfaction}{$goodsresult['satisfaction']}{lang sanree_brand_goods:fen}">
							<span class="staroff">
								<span class="staron" style="width: {$goodsresult['satisfactionwidth']}%;"></span>
							</span>
						</div>
				</div>
				<div class="clear"></div>
				<div class="com_b_con">
					<div class="l">{lang sanree_brand_goods:show_buy}</div>
					<div class="l">{$brandresult['allicq']}</div>
					<div class="goodstel114">{$brandresult['tel114url']}</div>
                </div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
            <!--{if $isbuylink==1&&!empty($goodsresult['buylink']) && $goodsresult['buylink'] != 'http://'}-->
			<div class="gotobuy">
				<a href="{$goodsresult['buylink']}" title="{lang sanree_brand_goods:view_buyclicktip}" target="_blank"></a>
			</div>
            <!--{/if}--> 
		</div>
		<div class="clear"></div>
        <!--{if $isbuylink==1&&!empty($goodsresult['buylink']) && $goodsresult['buylink'] != 'http://'}-->
		<div class="com_note">{$purchasestatement}</div>
        <!--{/if}-->
		<div class="com_tit_bg">
			<span class="l"><i class="icon"></i>{lang sanree_brand_goods:post_content}<em>PRODUCT INTRODUCTION</em></span>
		</div>
		<div class="com_main_pi">
        <!--{if $imglist}-->
        <!--{loop $imglist $picture}-->
			<p><img id='aimg_{$picture[aid]}' src="{$picture[pic]}" title="{$picture[name]}" onClick="zoom(this, this.src)" alt="{$picture[name]}" onload="centerimg(this)" /></p>
        <!--{/loop}-->
        <!--{/if}-->
			<p>{$goodsresult[content]}</p>
			<div id="brandcomment" class="brandcommentshow"></div>
        	<div class="clear"></div>
            <script language="javascript">
			var url = 'plugin.php?id=sanree_brand_goods&mod=fastpost&tid={$tid}&gid={$gid}';
			ajaxget(url, 'brandcomment');
			</script>	
        </div>
        <!--{hook/sanree_brand_userleftbottom}--> 
	  </div>
</div>
<div class="al_sidebar">
    <div class="al_sl">
    <h1>{lang sanree_brand:h_newpub}</h1>
        <ul>
        <!--{loop $newlist $value}-->
            <li>
                <a href="{$value[url]}" target="_blank">
                    <div class="al_ll"><img src="$_G[siteurl]{BIRD_CSS}timthumb.php?src=$_G[siteurl]{$value[poster]}&h=60&w=60&zc=1" /></div>
                    <div class="al_slt">
                        <div class="al_tt">{$value[name]}</div>
                        <div class="star"> <span class="staroff"> <span class="staron" style="width: {$value[satisfaction]}%;"></span></span></div>
                    </div>
                </a>
            </li>
        <!--{/loop}-->
        </ul>
    </div>
    <div class="clear"></div>
    <div class="al_sc">
        <span class="al_lsc"><a href="home.php?mod=spacecp&ac=favorite&type=thread&id=$brandresult[tid]" id="k_favorite" onClick="stid={$brandresult[tid]};showWindow(this.id, this.href, 'get', 0);">{lang sanree_brand:bird_detail_favor}</a></span>
        <span class="al_rsc">{lang sanree_brand:fav} {$brandresult[favtimes]}</span>
    </div>
    <div class="al_kf">
        <h1>{lang sanree_brand:servicecenter}</h1>
        <p>
        <!--{if $ismultiple==1&&$brandresult[allowmultiple]==1}-->
        <span class="l">{lang sanree_brand:oqq}</span>
        <span class="l">{$brandresult[icq]}</span>
        <!--{else}-->
        <span class="l">{lang sanree_brand:oqq}</span>
        <span class="l">{$brandresult[qq]}</span>
        <!--{/if}-->
        </p>
    </div>
</div>
<div class="clear"></div>
<!--end-->
<div id="userbar"></div>
<div class="clear"></div>
<script language="javascript">
var url = 'plugin.php?id=sanree_brand&mod=userbar&tid={$tid}&bid={$bid}';
ajaxget(url, 'userbar');
function favoriteupdate(){}
</script>
<!--{hook/sanree_brand_userfooter}-->
{subtemplate common/footer} 
<style type="text/css">.hm{position:inherit;}.zimg_prev{width:50%;}.zimg_next{width:50%;}</style>





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
<link type="text/css" rel="stylesheet" href="source/plugin/sanree_brand/tpl/bird/cr.css?{VERHASH}" />
<link type="text/css" rel="stylesheet" href="source/plugin/sanree_brand_goods/tpl/bird/usergoods.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/sanree_brand.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/userbar.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/header.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/albumlist.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/msg.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="{sr_brand_goods_TPL}usergoods.css?{VERHASH}" />
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
<script language="javascript">var stid=0;</script>	
<style>
body {
	margin: 0;
	padding: 0;
	font-family: microsoft yahei, Verdana, Geneva, sans-serif;
	font-size: 14px;
}
ul, li, div, span, img, h1, p {
	list-style: none;
	margin: 0;
	padding: 0;
	border: 0;
}
.l {
	float: left;
}
.r {
	float: right;
}
.clear {
	clear: both;
}

.sr_wrapper .sr_slide {
	display:none;
}
</style>
<body>
<!--star-->
<div class="sr_wrapper">
<div class="mc_albox">
  <!--{hook/sanree_brand_usertoper}-->
  <div id="pt" class="bm cl">
    <div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$allurl}">{$maintitle}</a>$navigation </div>
  </div>
  {$srhead}
  <!--{hook/sanree_brand_userheader}-->
<div class="com_cb">
    <!--{hook/sanree_brand_userlefttop}-->
    <div class="mc_tit goodslist">
    <span class="l"><i class="icon"></i><a href="{$brandresult[url]}">{$brandresult[name]}</a> <span>&gt; </span>{lang sanree_brand_goods:mode_goods}</span>
    <span class="r ubar">
        <!--{if defined('IN_BRAND_USER')}--><a href="plugin.php?id=sanree_brand_goods&mod=published&amp;bid={$brandresult[bid]}" onClick="showWindow('publisheddlg', this.href, 'get', 1)" class="y creatalbum"></a><!--{/if}-->	   
        <span id="atarget" {if $_G['cookie']['atarget'] > 0}onclick="setatarget(-1)" class="y atarget_1"{else}onclick="setatarget(1)" class="y"{/if} title="{lang sanree_brand:new_windowtip}">{lang sanree_brand:new_window}</span>
    </span>
    </div>
    <div class="clear"></div>
    <div class="com_list">
    <!--{if $goodslist}-->
    <ul>
    <!--{loop $goodslist $goods}-->
        <li>
            <a href="{$goods[url]}" onClick="atarget(this)">
                <div class="com_t_img"><img src="{$goods[pic]}" /></div>
                <div class="com_b_info">
                    <div class="com_b_tit">{$goods[name]}</div>
                    <div class="com_b_p">
                        <span><strong><span>{$config['selectpriceunitshow'][$goods[priceunit]]}{$goods[minprice]}</span></strong></span>
                        <span><s><span>{$config['selectpriceunitshow'][$goods[priceunit]]}{$goods[price]}</span></s></span>
                    </div>
                </div>
            </a>
        </li>
    <!--{/loop}-->
    </ul>
	<div class="clear"></div>
    <div class="pager">{$multi}</div>
    <!--{else}-->
    <div class="zanwu">{lang sanree_brand_goods:nogoods}</div>
    <!--{/if}-->
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
<!--star-->






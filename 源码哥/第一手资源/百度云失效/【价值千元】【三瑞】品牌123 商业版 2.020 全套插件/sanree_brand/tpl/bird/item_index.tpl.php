<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{eval $_G['disabledwidthauto']=TRUE;}-->
<!--{if ($ishideheader==1) }-->
<!--{subtemplate common/header_common}-->
{$brand_header_one}
<!--{ad/headerbanner/wp a_h}-->
<!--{hook/global_header}-->
	
<!--{else}-->
{subtemplate common/header}
<!--{/if}-->
<link type="text/css" rel="stylesheet" href="source/plugin/sanree_brand/tpl/bird/cr.css" />
<link rel="stylesheet" type="text/css" href="data/cache/style_{STYLEID}_forum_viewthread.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/album.css?{VERHASH}" />
<script type="text/javascript" src="source/plugin/sanree_brand/tpl/bird/js/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/sanree_brand/tpl/bird/js/dropdown.js"></script>
<script language="javascript">jQuery.noConflict();</script>
<script src="source/plugin/sanree_brand/tpl/bird/js/jquery.kinMaxShow-1.1.min.js" type="text/javascript"></script>
<!--[if IE 6]>
<script src="{BIRD_JS}DD_belatedPNG_0.0.8a.js" type="text/javascript" ></script>
<script type="text/javascript">
DD_belatedPNG.fix('#main,.in-v1-top,.in-v1-bot,.in-v1-cont,.in-v2-top,.in-v2-bot,h1.logo,ul#nav li a,.copyRight,img,background,.modal');
</script> 
<![endif]-->
</head>
<script type="text/javascript">
function showhid(id){
 document.getElementById(id).style.display ='block';
}
function showhid2(id){
 document.getElementById(id).style.display ='none';
}
</script>
<body>
<div class="sr_wrapper">
  <!--{hook/sanree_brand_usertoper}-->
  <div id="pt" class="bm cl">
    <div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$allurl}">{$maintitle}</a>$navigation </div>
  </div>
  {$srhead}
<div class="clear"></div>
<div class="sr_acc">
<div class="acc_box">
	<ul id="tab">
    <!--{if $brandresult[allowalbum] && $album_list}-->
        <li><a href="javascript:;" class="al"><i class="icon"></i><strong>{lang sanree_brand:myalbum}</strong></a></li>
    <!--{/if}-->
    <!--{if $brandresult[allowalbum]}-->
        <li><a href="javascript:;" class="al"><i class="icon"></i><strong>{lang sanree_brand:bird_detail_album}</strong></a></li>
    <!--{/if}-->
    <!--{if $iscoupon}-->
        <li><a href="javascript:;" class="sl"><i class="icon"></i><strong>{lang sanree_brand:bird_item_cou}</strong></a></li>
    <!--{/if}-->
    <!--{if $isgoods}-->
        <li><a href="javascript:;" class="cl"><i class="icon"></i><strong>{lang sanree_brand:bird_item_good}</strong></a></li>
    <!--{/if}-->
    </ul>
    <div class="clear"></div>
    <div id="center">
	<!--{if $album_list}-->
        <div class="cbhd">
        <!--{if $albumcatelist}-->
        	<ul>
            <!--{loop $albumcatelist $album}-->
                <li>
                    <a href="{$album[url]}">
                        <div class="al_box">
                            <div class="altop"><img src="{$album[pic]}" style="width:218px; height:218px" /></div>
                            <div class="b_infor">
                            <!--{if $album[name]}-->
                            	<div class="al_notit">{$album[name]}</div>
                            <!--{else}-->
                                <div class="al_tit">{$album[catname]}</div>
                                <div class="b_num">{$album[picshowtip]}</div>
                            <!--{/if}-->
                            </div>
                        </div>
                    </a>
                </li>
            <!--{/loop}-->
            </ul>
            <!--{/if}-->
        </div>
    <!--{/if}-->
    <!--{if $albumlist && $brandresult['allowalbum'] && $config['isalbum']}-->
		<script src="{sr_brand_JS}/album.js?{VERHASH}"></script>
        <div>
          <div class="hd"><span><a href="{$brandresult[albumurl]}">{lang sanree_brand:morepic}</a></span></div>
          <div class="bd">
            <ul>
            <!--{loop $albumlist $thread}-->
              <li class=clearall onMouseMove="showthis({$thread[albumid]})" onMouseOut="hidethis({$thread[albumid]})">
                 <div class="timg_xc">
                 <img id='aimg_{$thread[albumid]}' width="218" height="218" src="{$thread[thumbpic]}" zoomfile="{$thread[pic]}" title="{$thread[albumname]}" onClick="zoom(this, '{$thread[pic]}')" alt="{$thread[albumname]}" />
                 </div>
              </li>
              <!--{/loop}-->
            </ul>
          </div>
        </div>
        <script src="static/js/forum_viewthread.js"></script>
        <script language="javascript" reload="1">
            var stid=0;
            var aimgcount = new Array();
            aimgcount[{$bid}] = {$aids};
            attachimggroup({$bid});
            attachimgshow({$bid});
            var aimgfid = 0;
        </script>
    <!--{/if}-->
    <!--{if $iscoupon}-->
		<div>
        	<div class="sl_box">
            <!--{if $couponlist}-->
            	<ul>
                <!--{loop $couponlist $coupon}-->
                    <li>
                        <a href="{$coupon[url]}">
                            <div class="al_box">
                                <div class="altop"><img src="{$coupon[pic]}" /></div>
                                <div class="b_infor">
                                    <div class="sl_tit">{$coupon[name]}</div>
                                    <div class="b_price">{lang sanree_brand:bird_item_limit}<strong>{$config['selectpriceunitshow'][$coupon[priceunit]]}{$coupon[minprice]}</strong> <em>|</em> <span>{$config['selectpriceunitshow'][$coupon[priceunit]]}{$coupon[price]}</span></div>
                                </div>
                            </div>
                        </a>
                    </li>
                <!--{/loop}-->
                </ul>
				<!--{else}-->
				<div class="zanwu">{lang sanree_brand_coupon:nocoupon}</div>
				<!--{/if}-->
            </div>
        </div>
    <!--{/if}-->
    <!--{if $isgoods}-->
		<div>
        	<div class="cl_box">
            <!--{if $goodslist}-->
            	<ul>
                <!--{loop $goodslist $goods}-->
                	<li>
                        <a href="{$goods[url]}" title="{$goods[name]}">
                            <div class="al_box">
                                <div class="altop"><img src="{$goods[pic]}" /></div>
                                <div class="b_infor">
                                    <div class="sl_tit">{$goods[name]}</div>
                                    <div class="b_price"><strong>{$config['selectpriceunitshow'][$goods[priceunit]]}{$goods[minprice]}</strong> <em>|</em> <span>{$config['selectpriceunitshow'][$goods[priceunit]]}{$goods[price]}</span></div>
                                </div>
                            </div>
                        </a>
                    </li>
                <!--{/loop}-->
                </ul>
                <!--{else}-->
                <div class="zanwu">{lang sanree_brand_goods:nogoods}</div>
                <!--{/if}-->
            </div>
        </div>
    <!--{/if}-->
    </div>
</div>
<div class="clear"></div>
<div class="sr_upimg" style="display:none;">
	<div class="upimg_box">
    	<div class="upimg_tit">
        	<div class="ltit l"><i class="icon"></i>{lang sanree_brand:bird_item_share}</div>
            <div class="radd r"><a href="javascript:;" onClick="jQuery('#share_business').css('display','');jQuery('#share_back').css('display','');">{lang sanree_brand:bird_item_shareofme} +</a></div>
        </div>
        <div class="clear"></div>
    	<ul>
        <!--{loop $share_business $cate}-->
        	<li>
            	<a href="{echo str_replace($brandresult[bid], $cate[bid], $brandresult[url])}">
                	<div class="topimg"><img src="$_G[siteurl]{BIRD_CSS}timthumb.php?src=$cate[bpic]&h=218&w=218&zc=1" /></div>
                    <div class="bbox">
                    <div class="box_user">
                    	<div class="user_tx l"><img src="$cate[upic]" /></div>
                        <div class="user_nm l">
                        	<div class="user_name">$cate[username]</div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="sr_comm">$cate[content]</div>
                    </div>
                </a>
            </li>
        <!--{/loop}-->
        </ul>
    </div>
</div>
{$srfoot}
<script type="text/javascript">
jQuery(function(){
jQuery("#tab li").first().addClass("on").siblings().removeClass("on");
jQuery("#center > div").first().show().siblings().hide();
jQuery("#tab li").mousemove(function(){
var index = jQuery("#tab li").index(this);
jQuery(this).addClass("on").siblings().removeClass("on");
jQuery("#center > div").eq(index).show().siblings().hide();
});
});
</script>
<script type='text/javascript' src='{BIRD_JS}jquery.modal.js'></script>
<script type='text/javascript' src='{BIRD_JS}site.js'></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script>
<!--{if $mapapi=='google'}--><script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script><!--{/if}-->
<!--{if ($lng)}-->
<script type="text/javascript">
var lng = {$lng};
var lat = {$lat};	
var popupID="popupID";
var remindID ="remindID";
var confirmHTML = '<div id="' + popupID + '"><div id="' + remindID + '" class="content">{$info}</div></div></div>';
var opts1 = {title : '<span style="font-size:14px;color:#0A8021;">{$info}</span>'};
var t1 = "<div style='line-height:1.8em;font-size:12px; width:200px'><b>{lang sanree_brand:map_address}</b>{$brandresult['address']}<br /><b>{lang sanree_brand:map_tel}</b>{$brandresult['tel']}<br /><b>{lang sanree_brand:map_mouth}</b>";
var t2 = "<!--{loop $starlist $star}--><img src='{$_G[siteurl]}{sr_brand_IMG}/st.png' /><!--{/loop}-->";
var t3= "<a style='text-decoration:none;color:#2679BA;float:right'>>></a></div>";
try{
	var infoWindow1 =new BMap.InfoWindow(t1 + t2 + t3, opts1);	
	var confirmWindow = new BMap.InfoWindow(confirmHTML, {offset: new BMap.Size(0, -8),width: 240});  	
	var markerImage= "http://ditu.baidu.com/img/markers.png";
	var I = new BMap.Icon(markerImage, new BMap.Size(23, 25), {imageOffset: new BMap.Size(0, 0 - 27 * 25 + 3)});
	var map = new BMap.Map("containermap");
	var point = new BMap.Point(lng||116.404, lat||39.915);
	map.centerAndZoom(point, 15);
	var marker = new BMap.Marker(point, {icon: I});
	map.addOverlay(marker);
	var opts = {type: BMAP_NAVIGATION_CONTROL_LARGE}  
	map.addControl(new BMap.NavigationControl(opts));
	map.addOverlay(infoWindow1);
	marker.openInfoWindow(infoWindow1);
	map.centerAndZoom(point,15);
}
catch(e){
}
</script>
<!--{else}-->
&nbsp;
<!--{/if}-->

<!--{hook/sanree_brand_userfooter}-->
{subtemplate common/footer}
<style type="text/css">.hm{position:inherit;}.zimg_prev{width:50%;}.zimg_next{width:50%;}</style>
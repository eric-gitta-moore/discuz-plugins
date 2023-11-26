<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{if ($ishideheader==1) }-->
<!--{subtemplate common/header_common}-->
{$brand_header_one}
<!--{ad/headerbanner/wp a_h}-->
<!--{hook/global_header}-->

<!--{else}-->
{subtemplate common/header}
<!--{/if}-->
<link rel="stylesheet" type="text/css" href="data/cache/style_{STYLEID}_forum_viewthread.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/album.css?{VERHASH}" />
<!--[if IE 6]>
<script src="{NICE_JS}DD_belatedPNG_0.0.8a.js" type="text/javascript" ></script>
<script type="text/javascript">
DD_belatedPNG.fix('#main,.in-v1-top,.in-v1-bot,.in-v1-cont,.in-v2-top,.in-v2-bot,h1.logo,ul#nav li a,.copyRight,img,background,.modal');
</script> 
<![endif]-->
</head><body>
<!--{hook/sanree_brand_usertoper}-->
<div id="pt" class="bm cl">
  <div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$allurl}">{$maintitle}</a>$navigation </div>
</div>
<div class="clear"></div>
{$srhead}
{eval $fr = 0;}
<div class="sr_wrapper">
  <div class="all-mod"> 
    <!--{if $album_list}--> 
    <!--{if $albumcatelist}-->
    <ul>
      <!--{loop $albumcatelist $album}-->
      <li> <a href="{$album[url]}">
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
        </a> </li>
      <!--{/loop}-->
    </ul>
    <!--{/if}--> 
  </div>
  <!--{/if}--> 
  <!--{if $albumlist && $brandresult['allowalbum'] && $config['isalbum']}--> 
  {eval $fr++;} 
  <script src="{sr_brand_JS}/album.js?{VERHASH}"></script>
  <div class="mod-tit">
    <div class="mod-box">
      <div class="mt-left"><span>{$fr}F</span>{lang sanree_brand:myalbum}</div>
      <div class="mt-right"><a href="{$brandresult[albumurl]}">+ {lang sanree_brand:morepic}</a></div>
    </div>
    <i></i> </div>
  <div class="mt-album">
    <div class="mt-con">
      <ul>
        <!--{loop $albumlist $thread}-->
        <li class=clearall onMouseMove="showthis({$thread[albumid]})" onMouseOut="hidethis({$thread[albumid]})">
          <div class="timg_xc"> <img id='aimg_{$thread[albumid]}' width="218" height="218" src="{$thread[thumbpic]}" zoomfile="{$thread[pic]}" title="{$thread[albumname]}" onClick="zoom(this, '{$thread[pic]}')" alt="{$thread[albumname]}" /> </div>
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
  <div class="clear"></div>
  <!--{if $goodslist}--> 
  <!--{if $isgoods}--> 
  {eval $fr++;}
  <div class="mod-tit">
    <div class="mod-box">
      <div class="mt-left"><span>{$fr}F</span>{lang sanree_brand:brandgoods}</div>
      <div class="mt-right"><a href="{$goodsurl}">+ {lang sanree_brand:moregoods}</a></div>
    </div>
    <i></i> </div>
  <div class="mt-good">
    <div class="mt-con">
      <ul>
        <!--{loop $goodslist $goods}-->
        <li> <a href="{$goods[url]}" title="{$goods[name]}">
          <div class="al_box">
            <div class="altop"><img src="{$goods[pic]}" /></div>
            <div class="b_infor">
              <div class="sl_tit">{$goods[name]}</div>
              <div class="b_price"><strong>{lang sanree_brand:yrmb}{$config['selectpriceunitshow'][$goods[priceunit]]}{$goods[minprice]}</strong><span>{lang sanree_brand:yrmb}{$config['selectpriceunitshow'][$goods[priceunit]]}{$goods[price]}</span></div>
            </div>
          </div>
          <i></i> </a> </li>
        <!--{/loop}-->
      </ul>
    </div>
  </div>
  <!--{/if}--> 
  <!--{/if}-->
  <div class="clear"></div>
  <!--{if $couponlist}--> 
  <!--{if $iscoupon}--> 
  {eval $fr++;}
  <div class="mod-tit">
    <div class="mod-box">
      <div class="mt-left"><span>{$fr}F</span>{lang sanree_brand:brandcoupon}</div>
      <div class="mt-right"><a href="{$couponurl}">+ {lang sanree_brand:bird_home_morec}</a></div>
    </div>
    <i></i> </div>
  <div class="mt-coupon">
    <div class="mt-con">
      <ul>
        <!--{loop $couponlist $coupon}-->
        <li> <a href="{$coupon[url]}" title="{$coupon[name]}">
          <div class="al_box">
            <div class="altop"><img src="{$coupon[pic]}" /></div>
            <div class="b_infor">
              <div class="coupon-box" style="display: none;">
                <div class="sl_tit">{$coupon[name]}</div>
              </div>
              <div class="b_price"> <strong>{lang sanree_brand:yrmb}{$config['selectpriceunitshow'][$coupon[priceunit]]}{$coupon[minprice]}</strong> <span>{lang sanree_brand:yrmb}{$config['selectpriceunitshow'][$coupon[priceunit]]}{$coupon[price]}</span> </div>
            </div>
          </div>
          <i></i> </a> </li>
        <!--{/loop}-->
      </ul>
    </div>
  </div>
  <!--{/if}--> 
  <!--{/if}-->
  <div class="clear"></div>
  
  <!--{if $new_left}--> 
  {eval $fr++;}
  <div class="mod-tit">
    <div class="mod-box">
      <div class="mt-left"><span>{$fr}F</span>{lang sanree_brand:brand_news}</div>
      <div class="mt-right"><a href="{$newsurl}" title="{$cate['name']}">+ {lang sanree_brand:bird_home_moren}</a></div>
    </div>
    <i></i> </div>
  <div class="mt-new">
    <div class="mt-con"> 
      <!--{eval $re=1}-->
      <div class="new-left"> 
        <!--{loop $new_left $cate}--> 
        <!--{if $re == 1}-->
        <div class="nl"> <a href="{$cate['url']}" title="{$cate['name']}"><img src="{$cate['pic']}" alt="{$cate['name']}"></a>
          <div class="nl-txt">{$cate['name']}</div>
        </div>
        <!--{else}-->
        <div class="nr"> <a href="{$cate['url']}" title="{$cate['name']}">{$cate['name']}</a> </div>
        <!--{/if}--> 
        {eval $re++;} 
        <!--{/loop}--> 
      </div>
      <!--{if $new_right}-->
      <div class="new-right"> 
        <!--{loop $new_right $cate}--> 
        <!--{if $re == 9}-->
        <div class="nl"> <a href="{$cate['url']}"><img src="{$cate['pic']}"></a>
          <div class="nl-txt">{$cate['name']}</div>
        </div>
        <!--{else}-->
        <div class="nr"> <a href="{$cate['url']}">{$cate['name']}</a> </div>
        <!--{/if}--> 
        {eval $re++;} 
        <!--{/loop}--> 
      </div>
      <!--{else}-->
      <div class="nothing">{lang sanree_brand:nonews}</div>
      <!--{/if}--> 
    </div>
  </div>
  <!--{/if}-->
  <div class="clear"></div>
  <!--{if $jobslist}--> 
  {eval $fr++;}
  <div class="mod-tit">
    <div class="mod-box">
      <div class="mt-left"><span>{$fr}F</span>{lang sanree_brand:brandjobs}</div>
      <div class="mt-right"><a href="{$jobsurl}">+ {lang sanree_brand:bird_home_morej}</a></div>
    </div>
    <i></i> </div>
  <div class="mt-job">
    <div class="mt-con">
      <ul>
        <!--{loop $jobslist $jobs}-->
        <li> <a href="{$jobs['url']}" title="{$jobs['title']}">
          <div class="job-tit">{$jobs['title']}</div>
          <div class="job-con">
            <div class="introduce"> <b>{lang sanree_brand_jobs:education}</b> {$jobs[requirededucation]} <em>|</em> <b>{lang sanree_brand_jobs:workexperience}</b> {$jobs[workexperience]} <em>|</em> <b>{lang sanree_brand_jobs:peoplenumber}</b> {$jobs[peoplenumber]} <em>|</em> <b>{lang sanree_brand_jobs:bird_pay}</b> {$jobs[pay]}</div>
            <div limit="90">{$jobs['detail']}</div>
          </div>
          </a> </li>
        <!--{/loop}-->
      </ul>
    </div>
  </div>
  <!--{/if}--> 
  <!--{if $activitylist}--> 
  {eval $fr++;}
  <div class="mod-tit">
    <div class="mod-box">
      <div class="mt-left"><span>{$fr}F</span>{lang sanree_brand:brandactivity}</div>
      <div class="mt-right"><a href="{$activityurl}">+ {lang sanree_brand:moreactivity}</a></div>
    </div>
    <i></i> </div>
  <div class="mt-ac">
    <div class="mt-con">
      <ul>
        <!--{loop $activitylist $cate}-->
        <li> <a href="{$cate['url']}" >
          <div class="ac-inforbox">
            <div class="ac-topic"><img src="{$cate['pic']}"></div>
            <!--{if !empty($cate['isend'])}-->
            <div class="tlc-noac">{lang sanree_brand:atactivityend}</div>
            <!--{else}-->
            <div class="ac-people">{lang sanree_brand:signupcount}{$cate['signup']}</div>
            <!--{/if}--> 
          </div>
          <div class="ac-name">{$cate['name']}</div>
          <div class="ac-time">{lang sanree_brand:signupabort}{$cate['endtdate']}</div>
          <i></i> </a> </li>
        <!--{/loop}-->
      </ul>
    </div>
  </div>
  <!--{/if}--> 
  <!--{if $videolist}--> 
  {eval $fr++;}
  <div class="mod-tit">
    <div class="mod-box">
      <div class="mt-left"><span>{$fr}F</span>{lang sanree_brand:brandvideo}</div>
      <div class="mt-right"><a href="{$videourl}">+ {lang sanree_brand:morevideo}</a></div>
    </div>
    <i></i> </div>
  <div class="mt-video">
    <div class="mt-con">
      <ul>
        <!--{loop $videolist $cate}-->
        <li> <a href="{$cate['url']}" > <img src="{$cate['pic']}" />
          <div class="video-tit">{$cate['name']}</div>
          <div class="video-play"><em></em></div>
          <i></i> </a> </li>
        <!--{/loop}-->
      </ul>
    </div>
  </div>
  <!--{/if}--> 
</div>
<div class="clear"></div>
<div class="item-column">
  <div class="moreinfor-left">
    <div id="item-moreinfor">
      <div class="li-list">
        <div class="li-linkbox">
	        <!--{if $isshowmap}-->
			<a class="li-map current" date-scroll="#scrollto1"><span><i class="all-icon"></i><em>{lang sanree_brand:brandmap}</em></span></a>
	        <!--{/if}-->
			<a class="li-infor {if !$isshowmap} current{/if}" date-scroll="#scrollto2"><span><i class="all-icon"></i><em>{lang sanree_brand:detail_introduce}</em></span></a>
			<a class="li-slogan" date-scroll="#scrollto3"><span><i class="all-icon"></i><em>{lang sanree_brand:bird_detail_propaganda}</em></span></a> 
			<!--{if $brandresult['allowfastpost'] && $config['allowfastpost']}--> 
			<a class="li-comment" date-scroll="#scrollto5"><span><i class="all-icon"></i><em>{lang sanree_brand:regevaluate}</em></span></a> 
			<!--{/if}--> 
        </div>
      </div>
    </div>
    <div class="li-con">
	    <!--{if $isshowmap}-->
      <div id="scrollto1" name="local-map" class="lm-con">
        <div class="li-tit">{lang sanree_brand:brandmap}</div>
        <!--{if ($lng)}-->
        <!--{if $mapapi=='baidu'}--> 
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script>
        <div style="border:1px solid gray" id="containermap"></div>
        <script type="text/javascript">
				var lng = {$lng};
				var lat = {$lat};
				var popupID="popupID";
				var remindID ="remindID";
				var confirmHTML = '<div id="' + popupID + '"><div id="' + remindID + '" class="content">{$info}</div></div>';
				var opts1 = {title : '<span style="font-size:14px;color:#0A8021">{$info}</span>'};
				var t1 = "<div style='line-height:1.8em;font-size:12px; width:150px'><b>{lang sanree_brand:map_address}</b>{$brandresult['address']}<br /><b>{lang sanree_brand:map_tel}</b>{$brandresult['tel']}";
				var t3= "<a style='text-decoration:none;color:#2679BA;float:right'>>></a></div>";
				try{
					var infoWindow1 =new BMap.InfoWindow(t1 +  t3, opts1);
					var confirmWindow = new BMap.InfoWindow(confirmHTML, {offset: new BMap.Size(0, -8),width: 100});
					var markerImage= "http://ditu.baidu.com/img/markers.png";
					var I = new BMap.Icon(markerImage, new BMap.Size(23, 25), {imageOffset: new BMap.Size(0, 0 - 27 * 25 + 3)});
					var map = new BMap.Map("containermap");
					var point = new BMap.Point(lng||116.404, lat||39.915);
					map.centerAndZoom(point, 15);
					var marker = new BMap.Marker(point, {icon: I});
					map.addOverlay(marker);
					map.addOverlay(infoWindow1);
					marker.openInfoWindow(infoWindow1);
					map.centerAndZoom(point,15);
				}
				catch(e){
				}
				</script> 
        <!--{/if}--> 
        <!--{if $mapapi=='google'}--> 
        <script src="http://ditu.google.cn/maps/api/js?sensor=false" type="text/javascript"></script>
        <div id="containermap"></div>
        <script type="text/javascript">
				var lng = '{$lng}';
				var lat = '{$lat}';
				var t1 = "<div style='line-height:1.8em;font-size:12px; width:200px'><b>{lang sanree_brand:map_address}</b>{$brandresult['address']}<br /><b>{lang sanree_brand:map_tel}</b>{$brandresult['tel']}";
				var t3= "<a style='text-decoration:none;color:#2679BA;float:right'>>></a></div>";
				function load() {
					try{
						var center = new google.maps.LatLng(lng || 39.91293336712716, lat|| 116.39724969863891);
						var defaultopt ={zoom: 15,mapTypeId: google.maps.MapTypeId.ROADMAP};
						map = new google.maps.Map(document.getElementById("containermap"),defaultopt);
						creatmarker(center);
						map.setCenter(center, 15);
					}
					catch(e){
					}
				}

				function markwindow(center){
					var table= t1 +t3;
					infowindow = new google.maps.InfoWindow({
						content: table,
						size: new google.maps.Size(50,50),
						position: center
					});
					infowindow.open(map);
					map.setCenter(center, 15);
				}
				function creatmarker(center){
					marker = new google.maps.Marker({
						position: center,
						title: '',
						map: map,
						draggable: false
					});
					markwindow(center);
					google.maps.event.addListener(marker, 'click', function(e){infowindow.open(map);});
				}
				load();
			</script> 
        <!--{/if}--> 
        <!--{else}--> 
        &nbsp; 
        <!--{/if}-->
	      <!--{if $isshowmap}-->
        <div class="mlcc-right">
          <div class="mlc-con">
            <div class="mlc-contact">
              <div class="mlc-left">{lang sanree_brand:brand_address}</div>
              <div class="mlc-right">{$brandresult[address]}</div>
            </div>
            <div class="mlc-tel">
              <div class="mlc-left">{lang sanree_brand:brand_tel}</div>
              <div class="mlc-right">
	              <!--{if $ismultiple==1&&$brandresult['allowmultiple']==1}-->
	              <!--{loop $tellist $cate}-->
	              {$cate}
	              <!--{/loop}-->
	              <!--{else}-->
	              {eval echo getfirsticq($brandresult['tel']);}
	              <!--{/if}-->
              </div>
            </div>
            <div class="mlc-map"> 
              <!--{if $mapapi}--><a href="plugin.php?id=sanree_brand&mod=map&tid={$tid}&bid={$bid}" onClick="showWindow(this.id, this.href, 'get', 1)" id="publisheddlg"><i class="all-icon"></i>{lang sanree_brand:ckwzdt}</a><!--{/if}--> 
            </div>
          </div>
        </div>
	      <!--{/if}-->
      </div>
	    <!--{/if}-->
      <div class="clear"></div>
      <div id="scrollto2" name="local-maplocal" class="lm-con">
        <div class="li-tit">{lang sanree_brand:detail_introduce}</div>
        {$brandresult[introduction]} </div>
      <div class="clear"></div>
      <div id="scrollto3" name="local-slogan" class="lm-con">
        <div class="li-tit">{lang sanree_brand:bird_detail_propaganda}</div>
        {$brandresult[propaganda]} </div>
      <div class="clear"></div>
      <div id="scrollto5" name="local-comment" class="lm-con">
	  <!--{if $brandresult['allowfastpost'] && $config['allowfastpost']}-->
        <div class="li-tit">{lang sanree_brand:regevaluate}</div>
        {$srfoot} 
      <!--{/if}-->
	  </div>
    </div>
  </div>
  <div class="moreinfor-right">
    <div class="sr_sidebar">
      <div class="cbl_box">
        <h2><i class="all-icon"></i>{lang sanree_brand:h_hotbrand}</h2>
        <div class="hot_c">
          <ul>
            <!--{loop $hotbrandlist $cate}-->
            <li {$cate[class]} onClick="window.open('{$cate[url]}','_blank');">
              <div class="tp"><img src="{$cate[poster]}" /></div>
              <div class="h_tit">{$cate[name]}</div>
              <div class="infor">
                <div class="in_box l"> <img src="{$cate['groupsmallicons']}" /> {$cate[tel114url]} 
                  <!--{if $cate[sdiscount]}--> 
                  <img src="{sr_brand_IMG}/discountico.jpg" /> 
                  <!--{/if}--> 
                  <!--{if $cate[iscard]}--> 
                  <img src="{sr_brand_IMG}/cardico.jpg" /> 
                  <!--{/if}--> 
                  <!--{if $cate[pbid]}--> 
                  <img src="{sr_brand_IMG}/fenico.jpg" /> 
                  <!--{/if}--> 
                  <!--{if $mtf}--> 
                  <img src="{$cate[mcertification]}" /> 
                  <!--{/if}--> 
                </div>
              </div>
            </li>
            <!--{/loop}-->
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="{NICE_JS}portamento.js"></script> 
<script>
jQuery('#item-moreinfor').portamento({wrapper: jQuery('.moreinfor-left')});
jQuery('.li-list a').bind('click', function(){
    jQuery(this).addClass('current').siblings().removeClass('current');
});

jQuery(document).ready(function(){
	jQuery.scrollto = function(scrolldom,scrolltime) {
		jQuery(scrolldom).click( function(){ 
			var scrolltodom = jQuery(this).attr("date-scroll");
			jQuery(this).addClass("thisscroll").siblings().removeClass("thisscroll");
			jQuery('html,body').animate({
				scrollTop:jQuery(scrolltodom).offset().top},scrolltime
			);
			return false;
		});
	};
    jQuery.scrollto(".li-list a",600);
});
</script>
<div class="clear"></div>
<!--{hook/sanree_brand_userfooter}--> 
{subtemplate common/footer}
<style type="text/css">
.hm{position:inherit;}.zimg_prev{width:50%;}.zimg_next{width:50%;}
</style>

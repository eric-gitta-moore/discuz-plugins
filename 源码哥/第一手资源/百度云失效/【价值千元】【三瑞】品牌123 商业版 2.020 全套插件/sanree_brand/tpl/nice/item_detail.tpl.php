<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{if ($ishideheader==1) }-->
<!--{subtemplate common/header_common}-->
{$brand_header_one}
<!--{ad/headerbanner/wp a_h}-->
<!--{hook/global_header}-->
<div id="wp" class="wp">	
<!--{else}-->
{subtemplate common/header}
<!--{/if}-->
<script type="text/javascript" src="{NICE_JS}jquery.min.js"></script>
<script type="text/javascript" src="{NICE_JS}dropdown.js"></script>
<script language="javascript">jQuery.noConflict();</script>
<script src="{NICE_JS}jquery.kinMaxShow-1.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="{NICE_JS}jquery.autofix_anything.js"></script>
<script type="text/javascript" src="{NICE_JS}modernizr.custom.79639.js"></script>
<!--[if IE 6]>
<script src="{NICE_JS}DD_belatedPNG_0.0.8a.js" type="text/javascript" ></script>
<script type="text/javascript">
DD_belatedPNG.fix('#main,.in-v1-top,.in-v1-bot,.in-v1-cont,.in-v2-top,.in-v2-bot,h1.logo,ul#nav li a,.copyRight,img,background,.modal');
</script> 
<![endif]-->
</head>
<script type="text/javascript">
jQuery(function(){
	jQuery(".sr_slide").kinMaxShow({
		intervalTime: 2
	});
});
</script>
<body>
<div class="sr_wrapper">
  <!--{hook/sanree_brand_usertoper}-->
  <div id="pt" class="bm cl">
    <div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$allurl}">{$maintitle}</a><a>$navigation</a><em>&raquo;</em>{lang sanree_brand:bird_item_detail}</div>
  </div> 
  {$srhead}
  <div class="clear"></div>
  <div class="main_column">
    <div class="mc_content r">
      <div class="mc_sidebar l">
        <div id="mc_wr">{eval $_G[sr_extra] = $_G[sr_extra] ? $_G[sr_extra] : 0}
          <ul>{eval $view_more_two = $is_rewrite ? 'brand-detail-'.$bid.'.html?extra=2' : 'plugin.php?id=sanree_brand&mod=detail&extra=2&tid='.$bid;}
            <li> <a href="{echo getdetailurl($brandresult)}" class="<!--{if !$_G[sr_extra]}-->current<!--{/if}-->"> <span class="mcd l">{lang sanree_brand:bird_detail_content}</span> <span class="mca r">></span></a> </li>
          </ul>
        </div>
      </div>
    <!--{if !$_G[sr_extra]}-->
      <div class="mc_cbox">
        <div class="mc_tit">
        <div><strong>{$brandresult[name]}</strong> {lang sanree_brand:bird_detail_content}</div>
        <div class="clear"></div>
          <div class="brandview">{lang sanree_brand:orderclick}<br>
            <span>{$forum_thread[views]}</span></div>
        </div>
        <div class="info_box">
        <span class="l">
        	<!--{if $brandresult[abrandno]}-->
				<div class="cl"><label>{lang sanree_brand:bird_detail_brandno}</label><span>$brandresult[abrandno]</span> <em></em> <b></b> </div>
			<!--{/if}-->
        </span>
        <!-- /brandnews -->
        <span class="l">
      <div class="brandfavorite">
        <span class="hd">
          <span class="favoritebtn"><a href="home.php?mod=spacecp&ac=favorite&type=thread&id=$brandresult[tid]" id="k_favorite" onClick="stid={$brandresult[tid]};showWindow(this.id, this.href, 'get', 0);">{lang sanree_brand:bird_detail_favor}</a></span>
        </span>
        <span class="bd">{lang sanree_brand:fav}<span>{$brandresult[favtimes]}</span></span>
      </div>
      <!-- /brandfavorite -->
      </span>
        </div>
        <div class="clear"></div>
        <div class="item_info">
          <div class="ti_box">
            <div class="list l">
              <div> <i>{lang sanree_brand:recommendationindex1}<strong>{$brandresult[recommendationindex]}%</strong></i> <i><em class="brandgroup">{lang sanree_brand:brandgroup}</em><img align="absmiddle" src="{$brandresult[groupimg]}" /></i> <i style="margin-right: 0px;"><em class="itemdiscount">{lang sanree_brand:itemdiscount}</em><strong>{$brandresult['discount']}</strong> <img src="{sr_brand_IMG}/zhe.gif" /></i> </div>
              <div> <i>{lang sanree_brand:cateh}<span style="color: #ff6600;">{$brandresult[catename]}</span></i> <i><em>{lang sanree_brand:region}</em> 
                <!--{if $isselfdistrict==1}--> 
                <span style="color: #ff6600;">{$brandresult[srbirthprovince]} - {$brandresult[srbirthcity]}</span> 
                <!--{else}--> 
                <span style="color: #ff6600;">{$brandresult[birthcity]} - {$brandresult[birthdist]}</span> 
                <!--{/if}--> </i> </div>
            </div>
            <div class="clear"></div>
            <div class="ts"> {lang sanree_brand:tplmf}<span>{$mfliststr}</span> </div>
            <div class="ti_tag">
            <!--{if $tagdata}-->
                <div class="l"><em>{lang sanree_brand:bird_detail_tag}</em></div>
                <div class="l">
                  <!--{loop $tagdata $tag}-->
                  <a href="{$tag['url']}"<span>{$tag['tagname']}</span></a>
                  <!--{/loop}-->
                </div>
            <!--{/if}-->
            </div>
            <div class="clear"></div>
          </div>
        </div>
        <ul>
        <li> <span><strong>{lang sanree_brand:bird_detail_addr}</strong>{$brandresult[address]}</span> </li>
        <li> <span>
        	<strong>{lang sanree_brand:bird_detail_tel}</strong>
            <!--{if $ismultiple==1&&$brandresult[allowmultiple]==1}-->
            <!--{loop $tellist $cate}-->
            <em>$cate</em>
            <!--{/loop}-->
            <!--{else}-->
        	<em>{$brandresult[tel]}</em>
            <!--{/if}-->
            </span> 
        </li>
        <li> <span>
        	<!--{if $ismultiple==1&&$brandresult[allowmultiple]==1}-->
				<!--{if $icq=='msn'}--><strong>{lang sanree_brand:brandmsn}</strong><span>{$brandresult[icq]}</span><!--{elseif $icq=='wangwang'}--><strong>{lang sanree_brand:brandwangwang}</strong><span>{$brandresult[icq]}</span><!--{elseif $icq=='baiduhi'}--><strong>{lang sanree_brand:brandbaiduhi}</strong><span>{$brandresult[icq]}</span><!--{elseif $icq=='skype'}--><strong>{lang sanree_brand:brandskype}</strong><span>{$brandresult[icq]}</span><!--{else}--><strong>{lang sanree_brand:brandqq}</strong><span>{$brandresult[icq]}</span><!--{/if}-->
			<!--{else}-->
			<strong>{lang sanree_brand:oqq}</strong><span>{$brandresult[qq]}</span>
			<!--{/if}-->
        </span> </li>
        <li> <span><strong>{lang sanree_brand:bird_detail_introduce}</strong> {$brandresult[introduction]} </span> </li>
        <div class="clear"></div>
        <li>
        	<div class="list_tit">{lang sanree_brand:bird_detail_propaganda}</div>
            <div>{$brandresult[propaganda]}</div>
        </li>
        <li>
        	<div class="list_tit">{lang sanree_brand:bird_detail_contact}</div>
            <div>{$brandresult[contact]}</div>
        </li>
        <!--{if $isshowmap==1}-->
        <li>
          <div class="mb"> 
            <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script> 
            <!--{if $mapapi=='google'}--><script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script><!--{/if}--> 
            <!--{if $lng}-->
            <div style="width:750px;height:255px;" id="containermap"></div>
            <script type="text/javascript">
                        var lng = '{$lng}';
                        var lat = '{$lat}';	
                        var popupID="popupID";
                        var remindID ="remindID";
                        var confirmHTML = '<div id="' + popupID + '"><div id="' + remindID + '" class="content">{$info}</div></div></div>';
                        var opts1 = {title : '<span style="font-size:14px;color:#0A8021">{$info}</span>'};
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
                            alert(e);
                        }
                        </script> 
            <!--{else}--> 
            &nbsp; 
            <!--{/if}--> 
          </div>
        </li>
        <!--{/if}-->
      </ul>
      </div>
    </div>
    <!--{/if}--> 
    <!--{if $_G[sr_extra] == 1}-->
    <div class="mc_cbox">
      <div class="mc_tit"><strong>{$brandresult[name]}</strong> {lang sanree_brand:bird_detail_propaganda}</div>
      <div class="bd"> {$brandresult[propaganda]} </div>
    </div>
    <!--{/if}-->
    <!--{if $_G[sr_extra] == 2}-->
    <div class="mc_cbox">
      <div class="mc_tit"><strong>{$brandresult[name]}</strong> {lang sanree_brand:bird_detail_contact}</div>
      <div class="bd"> {$brandresult[contact]} </div>
    </div>
    <!--{/if}-->
  </div>
</div>
<div class="clear"></div>
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
<script type="text/javascript"> 

function menuFix() { 
var sfEls = document.getElementById("wap_display").getElementsByTagName("li"); 
for (var i=0; i<sfEls.length; i++) { 
sfEls[i].onmouseover=function() { 
this.className+=(this.className.length>0? " ": "") + "sfhover"; 
} 
sfEls[i].onMouseDown=function() { 
this.className+=(this.className.length>0? " ": "") + "sfhover"; 
} 
sfEls[i].onMouseUp=function() { 
this.className+=(this.className.length>0? " ": "") + "sfhover"; 
} 
sfEls[i].onmouseout=function() { 
this.className=this.className.replace(new RegExp("( ?|^)sfhover"), 
""); 
} 
} 
} 
window.onload=menuFix; 
 
</script>
<script src="{NICE_JS}portamento.js"></script>
<script>
			jQuery('#mc_wr').portamento({wrapper: jQuery('.mc_content')});	// set #wrapper as the visual coundary of the panel
		</script> 
<script type='text/javascript' src='{NICE_JS}jquery.modal.js'></script>
<script type='text/javascript' src='{NICE_JS}site.js'></script>
<script type="text/javascript">
			
			function DropDown(el) {
				this.dd = el;
				this.placeholder = this.dd.children('span');
				this.opts = this.dd.find('ul.dropdown > li');
				this.val = '';
				this.index = -1;
				this.initEvents();
			}
			DropDown.prototype = {
				initEvents : function() {
					var obj = this;

					obj.dd.on('click', function(event){
						$(this).toggleClass('active');
						return false;
					});

					obj.opts.on('click',function(){
						var opt = $(this);
						obj.val = opt.text();
						obj.index = opt.index();
						obj.placeholder.text(obj.val);
					});
				},
				getValue : function() {
					return this.val;
				},
				getIndex : function() {
					return this.index;
				}
			}

			$(function() {

				var dd = new DropDown( $('#dd') );

				$(document).click(function() {
					// all dropdowns
					$('.wrapper-dropdown-3').removeClass('active');
				});

			});

		</script>

{subtemplate common/footer}
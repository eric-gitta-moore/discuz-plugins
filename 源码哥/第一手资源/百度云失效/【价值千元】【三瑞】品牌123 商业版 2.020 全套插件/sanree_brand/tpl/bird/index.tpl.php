<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{eval $_G['disabledwidthauto']=TRUE;}-->
{subtemplate common/header}
<link type="text/css" rel="stylesheet" href="{BIRD_CSS}style.css" />
<link type="text/css" rel="stylesheet" href="{SANREE_BRAND_TEMPLATE}/style.css" />
<link rel="stylesheet" type="text/css" id="sanree_brand" href="{SANREE_BRAND_TEMPLATE}/sanree_brand.css?{VERHASH}" />
<script type="text/javascript" src="{BIRD_JS}jquery.min.js"></script>
<script language="javascript">var j = jQuery.noConflict();</script>
<script type="text/javascript" src="{BIRD_JS}superslide.2.1.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		var a =jQuery(".re_box ul li:gt(3):not(:last)");
		a.hide();
	});
	</script>
  <div id="pt" class="bm cl">
    <div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$allurl}">{$maintitle}</a>$navigation </div>
  </div>
<div class="sr_header">
    <div class="sr_slide">
      <div class="fullSlide">
        <div class="bd">
          <ul>
          <!--{loop $slidelist $cate}-->
            <li style="background:{$cate[color]} center 0 no-repeat;"><a target="_blank" href="{$cate[url]}"><img src="$_G[siteurl]{BIRD_CSS}timthumb.php?src=$_G[siteurl]{$cate[pic]}&h=350&w=765&zc=1"></a></li>
          <!--{/loop}-->
          </ul>
        </div>
        <div class="hd">
          <ul>
          </ul>
        </div>
    </div>
</div>
<div class="sr_rb">
    <div class="sr_nav">
      <div class="join_c"> <a href="plugin.php?id=sanree_brand&mod=published" id="publisheddlg" onclick="showWindow(this.id, this.href, 'get', 1)">{lang sanree_brand:bird_bus_add}</a> </div>
      <div class="join_s" onclick="window.open('plugin.php?id=sanree_brand&mod=mybrand','_blank');"> <a>{lang sanree_brand:mybrand}</a> </div>
	  <div class="sr_morebox">
		  <div class="sr_mp">{lang sanree_brand:bird_yetenter}<span>{$allcount}</span>{lang sanree_brand:h_businesses}</div>
		  <div class="sr_mpcode">
			<!--{if $_G['cache']['plugin']['sanree_we']['isbirdwecode']}-->
			<div class="mp_tit">{lang sanree_brand:scancostwap}{lang sanree_brand:h_businesses}</div>
			<div class="mp_code"><img src="plugin.php?id=sanree_we&mod=codehome" /></div>
			<!--{elseif $config['birdindexcode']}-->
			<div class="mp_nocode"><img src="$_G['cache']['plugin']['sanree_brand']['birdindexcode']" /></div>
			<!--{else}-->
			<div class="mp_tit">{lang sanree_brand:scancostwap}</div>
			<div class="mp_code"><img src="{sr_brand_IMG}/nocode.gif" /></div>
			<!--{/if}-->
		  </div>
		</div>
    </div>
  </div>
  <div class="clear"></div>
<div class="sr_brand">
  <div class="sr_c">
    <div id="photo" class="l">
      <div class="Cont">
        <div id="left" class="prev l"><</div>
        <div class="ScrCont" id="viewer">
          <div class="List1" id="viewerFrame">
          <!--{loop $newbrandlist $cate}-->
            <div><a target="_blank" href="{$cate[url]}" title="{$cate[name]}"><img src="$_G[siteurl]{BIRD_CSS}timthumb.php?src=$_G[siteurl]{$cate[poster]}&h=73&w=181&zc=1" /></a></div>
          <!--{/loop}-->
          </div>
        </div>
        <div id="right" class="next r">></div>
      </div>
    </div>
  </div>
</div>
<div class="clear"></div>
<!--{hook/sanree_brand_index_toper}-->
<!--{hook/sanree_brand_index_header}-->
<div class="clear"></div>
<div class="sr_wrapper">
  <div class="sr_re">
    <div class="toptit">
      <div class="re_tit"> <i class="icon"></i>{lang sanree_brand:bird_bus_rec}</div>
      <div class="dh r"> <a href="{$adminadurl}">{lang sanree_brand:bird_bus_pos}</a> </div>
    </div>
    <div class="re_box">
      <ul>
      <!--{loop $recommendlist $key $cate}-->
      	<!--{if $key == 4}-->
        <!--{else}-->
        <li> <a href="{$cate[url]}" target="_blank" title="{$cate[name]}">
          <div class="topimg"><img src="$_G[siteurl]{BIRD_CSS}timthumb.php?src=$_G[siteurl]{$cate[img]}&h=185&w=213&zc=1" /></div>
          <div class="c_tit">{$cate[name]}</div>
          <div class="c_tel">{lang sanree_brand:otelphone}<strong>{$cate[tel]}</strong></div>
          <div class="c_my">
            <div class="t">{lang sanree_brand:satisfaction}</div>
            <div class="star"> <span class="staroff"> <span class="staron" style="width: {$cate[satisfaction]}%;"></span> </span> </div>
          </div>
          </a> </li>
        <!--{/if}-->
      <!--{/loop}-->
      </ul>
    </div>
  </div>
  <div class="clear"></div>
	<div class="hy_box">
		<div class="hy l">{lang sanree_brand:tpl_category}</div>
		<div class="lb l">
			<ul id="cardlist">
				<!--{loop $category_list $cate}-->
				<li{$cate[class]}><a href="{$cate[url]}">{$cate[name]}</a>
				</li>
				<!--{/loop}-->
			</ul>
			<div class="clear"></div>
			<!--{if $subcategory_list}-->
			<ul class="subcate">
				<li {$categoryclass->_subdata[class]}><a href="{$categoryclass->_subdata[url]}">{$categoryclass->_subdata[name]}</a>
				</li>
				<!--{loop $subcategory_list $cate}-->
				<li{$cate[class]}><a href="{$cate[url]}">{$cate[name]}</a>
				</li>
				<!--{/loop}-->
			</ul>
			<!--{/if}-->
			</ul>
		</div>
	</div>
	<div class="clear"></div>
  <div class="sr_area">
    <div class="areabox">
      <div class="dq l">{lang sanree_brand:brandcity}</div>
      <div class="dq_list l">
       <!--{loop $districtcategory_list $mlist}-->
	   <div class="dsubcate{$mlist[class]}">
            <ul id="dshow{$mlist[id]}">
			  <li {$mlist[pidclass]}><A href="{$mlist[pidurl]}">{$mlist[allname]}</A></li>
              <!--{loop $mlist[data] $cate}-->
              <li {$cate[class]}><A href="{$cate[url]}">{$cate[name]}</A></li>
              <!--{/loop}-->
            </ul>
	   </div>
      <!--{/loop}-->
      </div>
    </div>
    <div class="clear"></div>
    <div class="sr_search">
      <div class="searchbox">
      	<div class="leftsearch l">
        <form method="post" action="{$allurl}">
        <label>{lang sanree_brand:bird_bus_search}</label>
        <input type="text" class="ss mykeyword" onclick="setthis(this)" name="keyword" value="{$defaultkeyword}" onfocus="if (value =='{$defaultkeyword}'){value =''}" onblur="if (value ==''){value='{$defaultkeyword}'}" />
        <input type="submit" class="btn" value="{lang sanree_brand:bird_bus_searchbar}" />
        <div class="search_icon"></div>
        </form>
        </div>
        <div class="st r">
        <!--{loop $popularsearchlist $type}-->
        	<a href="{$type[url]}">{$type[name]}</a>
        <!--{/loop}-->
        </div>
      </div>
    </div>
  </div>
  <div class="clear"></div>
  <!--{hook/sanree_brand_index_middle}-->
  <div class="sr_main">
    <div class="sr_topbox">
      <div class="mc_tit">
        <h2><i class="icon"></i>{lang sanree_brand:bird_bus_list}</h2>
      </div>
      <div class="catetype">
      	<a class="{$orderclass[ordertime]}" href="{$orderurl1}">{lang sanree_brand:orderdefault}</a>
        <a class="{$orderclass[orderview]}" href="{$orderurl2}">{lang sanree_brand:ordertime}</a>
        <a class="{$orderclass[orderrecommend]}" href="{$orderurl3}">{lang sanree_brand:orderrecommend}</a>
        <a class="{$orderclass[orderdiscount]}" href="{$orderurl4}">{lang sanree_brand:orderdiscount}</a>
        <a class="{$orderclass[orderclick]}" href="{$orderurl5}">{lang sanree_brand:orderclick}</a>
        <a class="{$orderclass[orderexponent]}" href="{$orderurl6}">{lang sanree_brand:orderexponent}</a>
      </div>
      <ul class="listmode r">
          <li> <a href="{$bigurl}" title="{lang sanree_brand:bigmode}"><img src="{sr_brand_IMG}/hello_big{$slistmode['big']}.jpg" alt="{lang sanree_brand:bigmode}" /></a> </li>
          <li> <a href="{$middleurl}" title="{lang sanree_brand:middlemode}"><img src="{sr_brand_IMG}/hello_middle{$slistmode['middle']}.jpg" alt="{lang sanree_brand:middlemode}" /></a> </li>
          <li> <a href="{$smallurl}" title="{lang sanree_brand:smallmode}"><img src="{sr_brand_IMG}/hello_small{$slistmode['small']}.jpg" alt="{lang sanree_brand:smallmode}" /></a> </li>
       </ul>
    </div>
    <div class="sr_content">
    <!--{if $fbusinesses_list}-->
      <!--{loop $fbusinesses_list $cate}-->
          <!--{if $listmode==1}-->
          <div class="box_l">
          <ul {$cate[class]}>
          <li onclick="window.open('{$cate[turl]}','_blank');" onmouseout="this.className=''" onmouseover="this.className='bs'">
          <em></em>
          <div class="tpic_m"><img class="brlogo{$cate[bid]}"  src="$_G[siteurl]{BIRD_CSS}timthumb.php?src=$_G[siteurl]{$cate[poster]}&h=125&w=150&zc=1" alt="{$cate[name]}" /></div>
          <div class="inc l">
          <div class="c_name">{$cate[name]}</div>
          <div class="brandaddress">{lang sanree_brand:brandaddress}<span title="{$cate[address]}">{$cate[address]}</span></div>
		  <div class="brandtel">TEL: {$cate[tel]}</div>
          <div class="infor">
            <div class="in_box l">
            	<img src="{$cate['groupsmallicons']}" />
                {$cate[tel114url]}
                <!--{if $cate[sdiscount]>0}-->
                <img src="{sr_brand_IMG}/discountico.jpg" />
                <!--{/if}-->
                <!--{if $cate[iscard]==1}-->
                <img src="{sr_brand_IMG}/cardico.jpg" />
                <!--{/if}-->
                <!--{if $cate[pbid]>0}-->
                <img src="{sr_brand_IMG}/fenico.jpg" />
                <!--{/if}-->
                <!--{if $mtf}-->
                <img src="{$cate[mcertification]}" />
                <!--{/if}-->
            </div>
            </div>
            <div class="df">
              <strong>{$cate[recommendationindex]}</strong>%
            </div>
          </div>
          </li>
          </ul>
          </div>
          <!--{elseif $listmode==3}-->
          <div class="box_m">
          <ul {$cate[class]}>
          <li onclick="window.open('{$cate[turl]}','_blank');" onmouseout="this.className=''" onmouseover="this.className='bs'">
          <em></em>
          <div class="tpic_m"><img class="brlogo{$cate[bid]}"  src="$_G[siteurl]{BIRD_CSS}timthumb.php?src=$_G[siteurl]{$cate[poster]}&h=206&w=226&zc=1" alt="{$cate[name]}" /></div>
          <div class="c_name">{$cate[name]}</div>
          <div class="infor">
            <div class="in_box l">
            	<img src="{$cate['groupsmallicons']}" />
                {$cate[tel114url]}
                <!--{if $cate[sdiscount]>0}-->
                <img src="{sr_brand_IMG}/discountico.jpg" />
                <!--{/if}-->
                <!--{if $cate[iscard]==1}-->
                <img src="{sr_brand_IMG}/cardico.jpg" />
                <!--{/if}-->
                <!--{if $cate[pbid]>0}-->
                <img src="{sr_brand_IMG}/fenico.jpg" />
                <!--{/if}-->
                <!--{if $mtf}-->
                <img src="{$cate[mcertification]}" />
                <!--{/if}-->
            </div>
            <div class="in_box r">
              <strong>{$cate[voter]}.{$cate[voter2]}</strong>{lang sanree_brand:fen}
            </div>
          </div>
          </li>
          </ul>
          </div>
          <!--{else}-->
          <div class="box_b">
          <ul {$cate[class]}>
          <li onclick="window.open('{$cate[turl]}','_blank');" onmouseout="this.className=''" onmouseover="this.className='bs'">
          <em></em>
          <div class="tpic"><img class="brlogo{$cate[bid]}"  src="$_G[siteurl]{BIRD_CSS}timthumb.php?src=$_G[siteurl]{$cate[poster]}&h=225&w=345&zc=1" alt="{$cate[name]}" /></div>
          <div class="c_name">{$cate[name]}</div>
          <div class="infor">
            <div class="in_box l">
            	<img src="{$cate['groupsmallicons']}" />
                {$cate[tel114url]}
                <!--{if $cate[sdiscount]>0}-->
                <img src="{sr_brand_IMG}/discountico.jpg" />
                <!--{/if}-->
                <!--{if $cate[iscard]==1}-->
                <img src="{sr_brand_IMG}/cardico.jpg" />
                <!--{/if}-->
                <!--{if $cate[pbid]>0}-->
                <img src="{sr_brand_IMG}/fenico.jpg" />
                <!--{/if}-->
                <!--{if $mtf}-->
                <img src="{$cate[mcertification]}" />
                <!--{/if}-->
            </div>
            <div class="in_box r">
              <div class="star"> <span class="staroff"> <span class="staron" style="width: {$cate[satisfaction]}%;"></span> </span> </div>
            </div>
          </div>
          </li>
          </ul>
          </div>
          <!--{/if}-->
          </li>
      <!--{/loop}-->
      </ul>
      <div class="clear"></div>
      <div class="bigPage vm center" id="xp3">{$multi}</div>
    <!--{else}-->
       <div class="nobusinesses">{lang sanree_brand:nobusinesses}</div>
    <!--{/if}-->
    </div>
    <div class="sr_sidebar">
      <div class="cbl_box">
        <h2>{lang sanree_brand:h_hotbrand}</h2>
        <div class="hot_c">
          <ul>
          <!--{loop $hotbrandlist $cate}-->
            <li {$cate[class]} onclick="window.open('{$cate[url]}','_blank');">
              <div class="tp"><img src="$_G[siteurl]{BIRD_CSS}timthumb.php?src=$_G[siteurl]{$cate[poster]}&h=135&w=210&zc=1" /></div>
              <div class="h_tit">{$cate[name]}</div>
              <div class="h_tel">{lang sanree_brand:otelphone} {$cate[tel]}</div>
              <div class="infor">
                <div class="in_box l">
                	<img src="{$cate['groupsmallicons']}" />
                    {$cate[tel114url]}
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
                <div class="star_box r"><strong>{$cate[satisfaction]}</strong>{lang sanree_brand:fen}</div>
              </div>
              </li>
          <!--{/loop}-->
          </ul>
        </div>
        <div class="clear"></div>
        <h2>{lang sanree_brand:h_newpub}</h2>
        <div class="random">
          <ul>
          <!--{loop $newbrandlist $cate}-->
            <li {$cate[class]}> <a href="{$cate[url]}" title="{$cate[name]}" target="_blank">
              <div class="left_img l"><img src="$_G[siteurl]{BIRD_CSS}timthumb.php?src=$_G[siteurl]{$cate[poster]}&h=60&w=90&zc=1" /></div>
              <div class="right_infor r">
                <div class="rr_tit">{$cate[name]}</div>
                <div class="star"> <span class="staroff"> <span class="staron" style="width: {$cate[satisfaction]}%;"></span> </span> </div>
              </div>
              </a> </li>
          <!--{/loop}-->
          </ul>
        </div>
        <div class="clear"></div>
        <h2>{lang sanree_brand:servicecenter}</h2>
        <div class="service">
          <p>{lang sanree_brand:h_admintel}<strong>{$admintel}</strong></p>
          <p>
          	<span class="l">{lang sanree_brand:h_adminqq}</span>
          	<span class="l"><script language="javascript">document.write('<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={$adminqq}&site=qq&menu=yes"><img align="baseline" border="0" src="http://wpa.qq.com/pa?p=2:{$adminqq}:41"></a>');</script></span>
          </p>
          <div class="clear"></div>
          <p>{lang sanree_brand:servicetime}{$admintime}</p>
        </div>
          <!--{hook/sanree_brand_index_right_bottom}-->
      </div>
    </div>
  </div>
    <div class="clear"></div>
    <!--{if $helpcate}-->
  <div class="helpbar">
    <ul>
	  <!--{loop $helpcate $cate}-->
      <li>
        <dl {$cate[class]}>
          <dt>{$cate[1]}</dt>
		  <!--{loop $cate[2] $cateli}-->
		  <dd><a href="{$cateli[url]}" target="_blank">{$cateli[title]}</a></dd>
		  <!--{/loop}-->
        </dl>
      </li>
	  <!--{/loop}-->
    </ul>
  </div>
  <!-- /friendly_linkbar -->
  <!--{/if}-->
  <div class="clear"></div>
   <!--{if $friendly_link}-->
  <div class="friendly_link">
  <div>{lang sanree_brand:friendly_link}</div>
    <ul>
	  <!--{loop $friendly_link $cate}-->
      <li>
		  <a href="{$cate[url]}" target="_blank">{$cate[title]}</a>
      </li>
	  <!--{/loop}-->
    </ul>
  </div>
  <!-- /friendly_linkbar -->
  <!--{/if}-->
  <div class="clear"></div>
	<!--{if $copyrightshow}-->
          <div class="copyright">
            <div class="brand">
              <p><span class="pcolor1">{lang sanree_brand:h_brand123}</span><span class="pcolor2"><b>{lang sanree_brand:h_sanree}</b></span>
              V&nbsp;&nbsp;{$pluginversion}&nbsp;&nbsp;For&nbsp;&nbsp;X2,&nbsp;X2.5,&nbsp;X3,&nbsp;X3.1,&nbsp;X3.2!&copy;<a href="http://www.fx8.cc/" target="_blank">Sanree.com</a></p>
              <div class="box_copyright"><a href="http://www.fx8.cc/" target="_blank"><b>{lang sanree_brand:h_sanree}</b> ymg6.Com</a></div>
            </div>
          </div>
          <!-- /copyright -->
        <!--{else}-->
          <!-- Copyright Sanree.com  {$pluginversion} -->
        <!--{/if}-->
<!--{hook/sanree_brand_index_footer}-->
</div>
</div>
{subtemplate common/footer}
<script type="text/javascript">
jQuery(document).ready(function(){
	var a =jQuery(".nav_list ul li:gt(9):not(:last)");
	    a.hide();
	jQuery(".boxdown").click(function(){
		if(a.is(':visible')){
			 a.slideUp('fast');
			 jQuery(this).removeClass('up');
		}else{
			a.slideDown('fast').show();
			jQuery(this).addClass('up');
	}		
	});
});
</script>
<script type="text/javascript" src="{BIRD_JS}jquery.imageScroller.js"></script> 
<script type="text/javascript">
	var j = jQuery.noConflict();
	j("#viewer").imageScroller({
		next:"right",
		prev:"left",
		frame:"viewerFrame",
		width:120,
		child: "div",
		auto: true
	});
</script> 
<script type="text/javascript">
jQuery(".fullSlide").hover(function() {
    jQuery(this).find(".prev,.next").stop(true, true).fadeTo("slow",0.5).slide({delayTime: 5000});
},
function() {
    jQuery(this).find(".prev,.next").fadeOut()
});
jQuery(".fullSlide").slide({
    titCell: ".hd ul",
    mainCell: ".bd ul",
    effect: "fold",
    autoPlay: true,
    autoPage: true,
    trigger: "click",
    startFun: function(i) {
        var curLi = jQuery(".fullSlide .bd li").eq(i);
        if ( !! curLi.attr("_src")) {
            curLi.css("background-image", curLi.attr("_src")).removeAttr("_src")
        }
    }
});
</script>
<!--{if $mapapi=='baidu'}-->
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/library/CityList/1.2/src/CityList_min.js"></script>
<!--{/if}-->
<!--{if $mapapi=='google'}--><script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script><!--{/if}-->
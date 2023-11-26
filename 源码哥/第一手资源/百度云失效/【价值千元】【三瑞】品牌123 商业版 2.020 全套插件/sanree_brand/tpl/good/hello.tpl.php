<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{eval $_G['disabledwidthauto']=TRUE;}-->

{subtemplate common/header}
<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/sanree_brand.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/hello.css?{VERHASH}" />
<!--{if ($tel114version >=1121) }--><link rel="stylesheet" type="text/css" href="source/plugin/sanree_tel114/style/tel.css?{VERHASH}" /><!--{/if}-->
<style>
body{
font:12px/1.5 "Microsoft Yahei";
}
INPUT{
font:12px/1.5 "Microsoft Yahei";
}

.friendly_link {
    border: 1px solid #E0E0DB;
    padding: 10px;
    overflow: hidden;
}

.friendly_link div {
    border-bottom: 1px dotted #CDCDCD;
    padding-bottom: 5px;
    font-weight: 700;
    color: #999;
}

.friendly_link ul li {
    float: left;
    height: 14px;
    margin: 6px 9px;
}


</style>
<script language="javascript" src="{sr_brand_JS}/sanree_brand.js"></script>
<script language="javascript">
  var recommendtablist = Array('business'<!--{if $re_goodslist}-->, 'goods'<!--{/if}--><!--{if $re_newslist}-->, 'news'<!--{/if}--><!--{if $re_couponlist}-->, 'coupon'<!--{/if}-->);
  var newtablist = Array({$installmodestr});
</script>
<div class="sanree_brand_newindexbody" style="font-family:'{lang sanree_brand:yahei}'">
  <!--{hook/sanree_brand_index_toper}-->
  <div id="pt" class="bm cl">
    <div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$allurl}">{$maintitle}</a>$navigation </div>
  </div>
  <!-- /pt -->
  <!--{hook/sanree_brand_index_header}--> 
	<script language="javascript">
	<!--{if $isslideload==1}-->
	var sr_loadimg = true;
	<!--{else}-->
	var sr_loadimg = false;
	<!--{/if}-->
	</script>   
  <!--{if $hellobigslide==1}-->
	<script language="javascript">
	var isbigslide=true;
	</script>   
  <div class="topie6">
	  <div class="flashbar" id="flashbar">
		<div class="flash_left" id="slide_prve"></div>
		<div class="flash_right" id="slide_next"></div>
		<div class="flash_main">
		  <div class="falshad">
			<ul id="slideul">
			  <!--{if $slidelist}-->
				  <!--{loop $slidelist $cate}-->
				  <li><a href="{$cate[url]}" target="_blank"><img src="{$cate[pic]}" /></a></li>
				  <!--{/loop}-->
			  <!--{else}-->
				<li><img src="source/plugin/sanree_brand/tpl/good/images/sad21.jpg" /></li>
			  <!--{/if}-->
			</ul>
		  </div>
		  <!-- /falshad -->
		  <div class="topbox">
			<div class="filterdiv"></div>
			<div class="fshow">
			  <div class="addbutton"><a href="plugin.php?id=sanree_brand&mod=published" id="publisheddlg" onclick="showWindow(this.id, this.href, 'get', 1)"></a></div>
			  <div class="managebtn"><a href="plugin.php?id=sanree_brand&mod=mybrand"></a></div>
			  <div class="total">{lang sanree_brand:totalstr1}<span>{$allcount}</span>{lang sanree_brand:totalstr2}</div>
			</div>
			<!-- /fshow -->
		  </div>
		  <!-- /topbox -->
		</div>
	  </div>
	  <!-- /flashbar -->
  </div>
  <!-- /topie6 -->
  <!--{else}-->
  <script language="javascript">
	  var isbigslide=false;
  </script>
  <div class="smallflash">
      <div class="flashleft">
			<div class="module cl slidebox sanreeslide" timestep="3000">
			  <ul class="slideshow">
				<!--{loop $slidelist $cate}-->
				<li style="width: 731px; height: 125px;"> <a href="{$cate[url]}" target="_blank"><img src="{$cate[pic]}" width="731" height="125" /></a> </li>
				<!--{/loop}-->
			  </ul>
			</div>
			<script type="text/javascript">runslideshow();</script>	  
	  </div>
      <div class="flashright">
		  <div class="addbutton"><a href="plugin.php?id=sanree_brand&mod=published" id="publisheddlg" onclick="showWindow(this.id, this.href, 'get', 1)"></a></div>
		  <div class="managebtn"><a href="plugin.php?id=sanree_brand&mod=mybrand"></a></div>	  
	  </div>	  
  </div>
  <!--{/if}-->
  <div class="recommend" id="xp1">
    <div class="hd">
      <ul class="ntitle">
        <li id="sr_business" onmouseover="showrecommend(this)" class="on">{lang sanree_brand:h_businesses}</li>
        <!--{if $re_goodslist}--><li id="sr_goods" onmouseover="showrecommend(this)"><a href="{$modurl_goods}" target="_blank">{lang sanree_brand:h_goods}</a></li><!--{/if}-->
        <!--{if $re_newslist}--><li id="sr_news" onmouseover="showrecommend(this)"><a href="{$modurl_news}" target="_blank">{lang sanree_brand:h_news}</a></li><!--{/if}-->
        <!--{if $re_couponlist}--><li id="sr_coupon" onmouseover="showrecommend(this)"><a href="{$modurl_coupon}" target="_blank">{lang sanree_brand:h_coupon}</a></li><!--{/if}-->
      </ul>
      <div class="npage">
        <a href="{$adminadurl}" target="_blank">{lang sanree_brand:adminadurl}</a>
      </div>
    </div>
    <!-- /hd -->
    <div class="bd">
      <ul class="recommendlist" id="sr_business_menu">
        <!--{loop $recommendlist $cate}-->
        <li>
		   <div class="rec_image"><a href="{$cate[url]}" target="_blank" title="{$cate[name]}"><img src="{SANREE_BRAND_TEMPLATE}/timthumb.php?src={$cate[img]}&h=135&w=180zc=1" /></a></div>
		   <div class="rec_title"><a href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[name]}</a></div>
		</li>
        <!--{/loop}-->				
      </ul>
	  <!--{if $re_goodslist}-->
		  <ul class="recommendlist goodsm hideitem" id="sr_goods_menu">
			<!--{loop $re_goodslist $cate}-->
			<li>
			   <div class="recgoods_image"><a href="{$cate[url]}" target="_blank" title="{$cate[name]}"><img src="{$cate[pic]}" /></a></div>
			   <div class="recgoods_sprice">{lang sanree_brand:sminprice}{$cate[sminprice]}</div>
			   <div class="recgoods_title"><a href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[name]}</a></div>			
			</li>					
			<!--{/loop}-->
		  </ul>
	  <!--{/if}-->
      <ul class="recommendlist hideitem" id="sr_news_menu">
        <li>
		<div class="rec_news_bar">
			<div class="rec_news tmpleft">
			   <dl>
			    <dt><a href="{$re_news_textlist[0][url]}" target="_blank" title="{$re_news_textlist[0][name]}">{$re_news_textlist[0][name]}</a></dt>
				<!--{loop $re_news_textlist1 $cate}-->
					<dd><a href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[name]}</a></dd>
				<!--{/loop}-->			
			   </dl>
			   <div class="news_image">
			        <div class="news_img">
						<a href="{$re_news_imglist[0][url]}" target="_blank" title="{$re_news_imglist[0][name]}"><img src="{$re_news_imglist[0][pic]}" /></a>
						<div class="newsname">
						<a href="{$re_news_imglist[0][url]}" target="_blank" title="{$re_news_imglist[0][name]}">{$re_news_imglist[0][name]}</a>
						</div>
					</div>
			        <div class="news_img">
						<a href="{$re_news_imglist[1][url]}" target="_blank" title="{$re_news_imglist[1][name]}"><img src="{$re_news_imglist[1][pic]}" /></a>
						<div class="newsname">
						<a href="{$re_news_imglist[1][url]}" target="_blank" title="{$re_news_imglist[1][name]}">{$re_news_imglist[1][name]}</a>
						</div>
					</div>					
			   </div>
			</div>
			<div class="rec_news tmpright">
			   <dl>
			    <dt><a href="{$re_news_textlist[1][url]}" target="_blank" title="{$re_news_textlist[1][name]}">{$re_news_textlist[1][name]}</a></dt>
				<!--{loop $re_news_textlist2 $cate}-->
					<dd><a href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[name]}</a></dd>
				<!--{/loop}-->			
			   </dl>
			   <div class="news_image">
			        <div class="news_img">
						<a href="{$re_news_imglist[2][url]}" target="_blank" title="{$re_news_imglist[2][name]}"><img src="{$re_news_imglist[2][pic]}" /></a>
						<div class="newsname">
						<a href="{$re_news_imglist[2][url]}" target="_blank" title="{$re_news_imglist[2][name]}">{$re_news_imglist[2][name]}</a>
						</div>
					</div>
			        <div class="news_img">
						<a href="{$re_news_imglist[3][url]}" target="_blank" title="{$re_news_imglist[3][name]}"><img src="{$re_news_imglist[3][pic]}" /></a>
						<div class="newsname">
						<a href="{$re_news_imglist[3][url]}" target="_blank" title="{$re_news_imglist[3][name]}">{$re_news_imglist[3][name]}</a>
						</div>
					</div>					
			   </div>			
			</div>	
		</div>	
		</li>
      </ul>
	  <!--{if $re_couponlist}-->	  
      <ul class="recommendlist couponsm hideitem" id="sr_coupon_menu">
        <!--{loop $re_couponlist $cate}-->
        <li>
		   <div class="reccoupon_image"><a href="{$cate[url]}" target="_blank" title="{$cate[name]}"><img src="{$cate[pic]}" /></a></div>
		   <div class="reccoupon_sprice">{lang sanree_brand:cminprice}{$cate[sminprice]}</div>
		   <div class="reccoupon_title"><a href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[name]}</a></div>			
		</li>				
        <!--{/loop}-->
      </ul>
	  <!--{/if}-->
    </div>
    <!-- /bd -->
  </div>
  <!-- /recommend -->
  <div class="catebar" id="xp2">
    <div class="hd">
      <div class="mleft"></div>
      <form method="post" action="{$allurl}">
        <div class="sanree_brand_searchbar">
          <input type="text" class="mykeyword" onclick="setthis(this)" name="keyword" value="{$defaultkeyword}" />
          <input type="image" border="0" src="{sr_brand_IMG}/hello_searbtn.jpg" />
        </div>
      </form>
    </div>
    <!-- /hd -->
    <div class="bd">
      <div class="sortedbar">
        <div class="strade">
          <div class="stitle">{lang sanree_brand:tpl_category}</div>
          <div class="slist">
            <ul>
              <!--{loop $category_list $cate}-->
              <li{$cate[class]}><a href="{$cate[url]}">{$cate[name]}</a>
              </li>
              <!--{/loop}-->
            </ul>
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
          </div>
        </div>
        <!-- /strade -->
        <!--{if $districtcategory_list}-->
        <div class="strade">
          <div class="stitle pd10">{lang sanree_brand:tpl_district}</div>
          <div class="slist">
            <!--{loop $districtcategory_list $mlist}-->
            <div class="dsubcate{$mlist[class]}">
              <ul>
                <li{$mlist[pidclass]}><a href="{$mlist[pidurl]}">{$mlist[allname]}</a>
                </li>
                <!--{loop $mlist[data] $cate}-->
                <li{$cate[class]}><a href="{$cate[url]}">{$cate[name]}</a>
                </li>
                <!--{/loop}-->
              </ul>
              <div class="dm"><a onclick="showit({$mlist[id]})"><em id="onbtn{$mlist[id]}"></em></a><a onclick="showit({$mlist[id]})"><i id="offbtn{$mlist[id]}"></i></a></div>
            </div>
            <!--{/loop}-->
          </div>
          <!-- /slist -->
        </div>
        <!-- /strade -->
        <!--{/if}-->
      </div>
      <!-- /sortedbar -->
    </div>
    <!-- /bd -->
  </div>
  <!-- /catebar -->
  <!--{hook/sanree_brand_index_middle}-->  
  <div class="indexmainbody" id="indexmainbody">
    <div class="bodyleft">
	  <!--{hook/sanree_brand_index_left_top}-->
      <div class="option" id="option">
        <ul class="sort">
          <li class="{$orderclass[ordertime]}"><a href="{$orderurl1}">{lang sanree_brand:orderdefault}</a></li>
          <li class="{$orderclass[orderview]}"><a href="{$orderurl2}">{lang sanree_brand:ordertime}</a></li>
          <li class="{$orderclass[orderrecommend]}"><a href="{$orderurl3}">{lang sanree_brand:orderrecommend}</a></li>
          <li class="{$orderclass[orderdiscount]}"><a href="{$orderurl4}">{lang sanree_brand:orderdiscount}</a></li>
          <li class="{$orderclass[orderclick]}"><a href="{$orderurl5}">{lang sanree_brand:orderclick}</a></li>
		  <li class="{$orderclass[orderexponent]}"><a href="{$orderurl6}">{lang sanree_brand:orderexponent}</a></li>
        </ul>
        <!-- /sort -->
        <ul class="listmode">
          <li> <a href="{$bigurl}" title="{lang sanree_brand:bigmode}"><img src="{sr_brand_IMG}/hello_big{$slistmode['big']}.jpg" alt="{lang sanree_brand:bigmode}" /></a> </li>
          <li> <a href="{$middleurl}" title="{lang sanree_brand:middlemode}"><img src="{sr_brand_IMG}/hello_middle{$slistmode['middle']}.jpg" alt="{lang sanree_brand:middlemode}" /></a> </li>
          <li> <a href="{$smallurl}" title="{lang sanree_brand:smallmode}"><img src="{sr_brand_IMG}/hello_small{$slistmode['small']}.jpg" alt="{lang sanree_brand:smallmode}" /></a> </li>
        </ul>
        <!-- /listmode -->
      </div>
      <!-- /option -->
      <div class="businesslist{$classindex}">
        <!--{if $fbusinesses_list}-->
        <ul class="items" id="branditem">
          <!--{loop $fbusinesses_list $cate}-->
          <li{$cate[class]}>
          <!--{if $listmode==1}-->
			  <div class="itemlogo"><em></em><a href="{$cate[turl]}" title="{$cate[name]}" target="_blank"><img class="brlogo" {$picload}="{SANREE_BRAND_TEMPLATE}/timthumb.php?src={$cate[poster]}&h=98&w=130zc=1" alt="{$cate[name]}" /></a> </div>
			  <div class="exponent"><span class="eavl_ft22">{$cate[recommendarr][0]}.</span><span class="eavl_ft14">{$cate[recommendarr][1]}</span>&nbsp;% </div>
			  <div class="businesinfobar">
				<h1 class="sbusinesname"><a href="{$cate[turl]}" title="{$cate[name]}" target="_blank">{$cate[name]}</a></h1>
				<div class="stele">{lang sanree_brand:otelphone}{$cate[tel]}</div>
				<div class="saddress">{lang sanree_brand:oaddress}{$cate[address]}</div>
				<div class="operate"> 
				   <a><img src="{$cate['groupsmallicons']}" /></a>
				  {$cate[tel114url]}
				  <!--{if $cate['sdiscount']>0}-->
				  <img src="{sr_brand_IMG}/discountico.jpg" />
				  <!--{/if}-->
				  <!--{if $cate['iscard']==1}-->
				  <img src="{sr_brand_IMG}/cardico.jpg" />
				  <!--{/if}-->
				  <!--{if $cate['pbid']>0}-->
				  <img src="{sr_brand_IMG}/fenico.jpg" />
				  <!--{/if}-->
                  <!--{if $mtf}-->
                  <img src="{$cate[mcertification]}" />
                  <!--{/if}-->
				</div>
				<!-- /operate -->
			  </div>
          <!--{elseif $listmode==3}-->
			  <div class="itemlogo"> <em></em> <a href="{$cate[turl]}" title="{$cate[name]}" target="_blank"><img class="brlogo" {$picload}="{SANREE_BRAND_TEMPLATE}/timthumb.php?src={$cate[poster]}&h=158&w=210zc=1" alt="{$cate[name]}" /></a> </div>
			  <div class="businesinfobar">
				<div class="iteminfo">
				  <div class="sbusinesname"><a href="{$cate[turl]}" title="{$cate[name]}" target="_blank">{$cate[name]}</a></div>
				  <div class="stele">{lang sanree_brand:otelphone}
					<label title="{$cate[tel]}">{$cate[tel]}</label>
				  </div>
				</div>
				<div class="operate">
				  <div class="nstart"><span class="eavl_ft16">{$cate[voter]}.</span><span class="eavl_ft9">{$cate['voter2']}</span>&nbsp;{lang sanree_brand:fen}</div>
				  <a><img src="{$cate['groupsmallicons']}" /></a>
				  {$cate[tel114url]}
				  <!--{if $cate['sdiscount']>0}-->
				  <img src="{sr_brand_IMG}/discountico.jpg" />
				  <!--{/if}-->
				  <!--{if $cate['iscard']==1}-->
				  <img src="{sr_brand_IMG}/cardico.jpg" />
				  <!--{/if}-->
				  <!--{if $cate['pbid']>0}-->
				  <img src="{sr_brand_IMG}/fenico.jpg" />
				  <!--{/if}-->
                  <!--{if $mtf}-->
                  <img src="{$cate[mcertification]}" />
                  <!--{/if}-->
				</div>
				<!-- /operate -->
			  </div>
			  <!-- /businesinfobar -->
          <!--{else}-->
			  <div class="onedata1" onmousemove="onmousemove_hello(this)" onmouseout="onmouseout_hello(this)">
				  <div class="businestop"> <em></em> <a href="{$cate[turl]}" title="{$cate[name]}" target="_blank"><img class="brlogo" {$picload}="{SANREE_BRAND_TEMPLATE}/timthumb.php?src={$cate[poster]}&h=242&w=322zc=1" alt="{$cate[name]}" /></a> </div>
				  <div class="businesinfobar">
					<div class="bfilterdiv"></div>
					<div class="bfshow">
					  <div class="sbusinesname"><a href="{$cate[turl]}" title="{$cate[name]}" target="_blank">{$cate[name]}</a></div>
					  <div class="operate">
						<div class="nstart"><div class="okstar wt{$cate['voter']}"></div></div>
						<a><img src="{$cate['groupsmallicons']}" /></a>
						{$cate[tel114url]}
						<!--{if $cate['sdiscount']>0}-->
						<img src="{sr_brand_IMG}/discountico.jpg" />
						<!--{/if}-->
						<!--{if $cate['iscard']==1}-->
						<img src="{sr_brand_IMG}/cardico.jpg" />
						<!--{/if}-->
						<!--{if $cate['pbid']>0}-->
						<img src="{sr_brand_IMG}/fenico.jpg" />
						<!--{/if}-->
                        <!--{if $mtf}-->
                        <img src="{$cate[mcertification]}" />
                        <!--{/if}-->
					  </div>
					  <!-- /operate -->					  
					</div>
				  </div>
			  </div>
			  <!-- /onedata1 -->
          <!--{/if}-->
          </li>
          <!--{/loop}-->
        </ul>
        <!-- /items -->
        <div class="bigPage vm center" id="xp3">{$multi}</div>
        <!--{else}-->
			<div class="nobusinesses">{lang sanree_brand:nobusinesses}</div>
        <!--{/if}-->
      </div>
      <!-- /businesslist -->
		<!--{hook/sanree_brand_index_left_bottom}-->		  
    </div>
    <!-- /bodyleft -->
    <div class="bodyright">
	  <!--{hook/sanree_brand_index_right_top}-->
      <div class="new_brand">
        <div class="hd">{lang sanree_brand:h_newpub}</div>
        <div class="bd">
          <ul>
            <!--{loop $newbrandlist $cate}-->
            <li{$cate[class]}><a href="{$cate[url]}" title="{$cate[name]}">{$cate[name]}</a>
            </li>
            <!--{/loop}-->
          </ul>
        </div>
      </div>
      <!-- /new_brand -->
      <div class="hot_brand">
        <div class="hd">{lang sanree_brand:h_hotbrand}</div>
        <div class="bd">
          <ul>
            <!--{loop $hotbrandlist $cate}-->
            <li{$cate[class]}><a href="{$cate[url]}">{$cate[name]}</a>
            </li>
            <!--{/loop}-->
          </ul>
        </div>
      </div>
      <!-- /hot_brand -->
      <div class="indexmadv"> <a href="{$helloadlink}" target="_blank"><img src="{$helloadimage}" /></a> </div>
      <!-- /m_adv -->
	  <!--{if $new_goodslist || $new_newslist || $new_couponlist}-->
      <div class="modtab">
        <ul class="c_tabHead">
          <!--{if $new_goodslist}--><li id="r_goods" onmouseover="mshowitem(this)"{$tabHead[goods]}>{lang sanree_brand:h_goods}</li><!--{/if}-->
          <!--{if $new_newslist}--><li id="r_news" onmouseover="mshowitem(this)"{$tabHead[news]}>{lang sanree_brand:h_news}</li><!--{/if}-->
          <!--{if $new_couponlist}--><li id="r_coupon" onmouseover="mshowitem(this)"{$tabHead[coupon]}>{lang sanree_brand:h_coupon}</li><!--{/if}-->
        </ul>
        <!-- /c_tabHead -->
        <ul class="c_tabBody">
		  <!--{if $new_goodslist}-->
          <li id="r_goods_menu" class="c_list{$tabBody[goods]}">
            <ul>
              <!--{loop $new_goodslist $cate}-->
              <li>
                <div class="prod_img"><a href="{$cate[url]}" target="_blank" title="{$cate[name]}"><img class="goodslogo" {$picload}="{$cate[pic]}" /></a></div>
                <div class="prod_desc"><span class="prod_title"><a href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[name]}</a></span> <span class="prod_price">{$cate[sprice]}</span><br /><span class="prod_minprice">{$cate[sminprice]}</span> </div>
              </li>
              <!--{/loop}-->
            </ul>
          </li>
		  <!--{/if}-->
		  <!--{if $new_newslist}-->
          <li id="r_news_menu" class="c_list{$tabBody[news]}">
            <ul>
              <!--{loop $new_newslist $cate}-->
              <li>
                <div class="news_title"><a href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[name]}</a></div>
              </li>
              <!--{/loop}-->
            </ul>
          </li>
		  <!--{/if}-->
		  <!--{if $new_couponlist}-->
          <li id="r_coupon_menu" class="c_list{$tabBody[coupon]}">
            <ul>
              <!--{loop $new_couponlist $cate}-->
              <li>
                <div class="prod_img"><a href="{$cate[url]}" target="_blank" title="{$cate[name]}"><img {$picload}="{$cate[pic]}" /></a></div>
                <div class="prod_desc"> 
				<div class="prod_title"><a href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[name]}</a></div> 
				<div class="coupon_info"> <span class="coupon_price">{$cate[sprice]}</span> <span class="coupon_minprice">{$cate[sminprice]}</span> </div>
				<div class="coupon_enddate">{$cate[enddate]}</div>
				</div>
              </li>
              <!--{/loop}-->
            </ul>
          </li>
		  <!--{/if}-->
        </ul>
      </div>
	  <!--{/if}-->
      <!-- /modtab -->
      <div class="service">
        <h1>{lang sanree_brand:servicecenter}</h1>
        <div class="serv_info">
          <p>{lang sanree_brand:h_admintel}<span class="orange14">{$admintel}</span></p>
          <p class="mta5"><span class="nqq">{lang sanree_brand:h_adminqq}</span>
		  <script language="javascript">document.write('<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={$adminqq}&site=qq&menu=yes"><img align="baseline" border="0" src="http://wpa.qq.com/pa?p=2:{$adminqq}:41"></a>');</script></p>
          <p class="mta5"><span class="ntime">{lang sanree_brand:servicetime}</span>{$admintime}</p>
        </div>
      </div>
      <!-- /service -->
      <!--{if $copyrightshow}-->
      <div class="copyright">
        <div class="copylogo">
          <p class="pcolor">{lang sanree_brand:copyright}</p>
          <p><img src="{sr_brand_IMG}/srlogo.jpg" /></p>
        </div>
        <div class="brand">
          <p><span class="pcolor1">{lang sanree_brand:h_brand123}</span><span class="pcolor2">{lang sanree_brand:h_sanree}</span></p>
          <p class="pcolor3">V&nbsp;&nbsp;{$pluginversion}&nbsp;&nbsp;For&nbsp;&nbsp;X2,&nbsp;X2.5!&copy;<a href="http://www.fx8.cc/" target="_blank">Sanree.com</a></p>
        </div>
      </div>
      <!-- /copyright -->
      <!--{else}-->
      <!-- Copyright Sanree.com  {$pluginversion} -->
      <!--{/if}-->
	  <!--{hook/sanree_brand_index_right_bottom}-->
    </div>
    <!-- /bodyright -->
  </div>
  <!-- /indexmainbody -->
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
</div>
<script language="javascript" src="{sr_brand_JS}/hello{C_CHARSET}.js?{VERHASH}"></script>
<!--{if $mapapi=='baidu'}-->
<script language="javascript">
srloadjs("http://api.map.baidu.com/api?v=1.2");
srloadjs("http://api.map.baidu.com/library/CityList/1.2/src/CityList_min.js");
</script>
<!--{elseif $mapapi=='google'}-->
<script language="javascript">srloadjs("http://maps.google.com/maps/api/js?sensor=false");</script>
<!--{/if}-->
<!--{hook/sanree_brand_index_footer}-->
{subtemplate common/footer}
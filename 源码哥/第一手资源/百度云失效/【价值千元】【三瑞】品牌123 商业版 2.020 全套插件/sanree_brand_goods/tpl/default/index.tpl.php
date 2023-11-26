<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{eval $_G['disabledwidthauto']=TRUE;}-->
{subtemplate common/header}
<script type="text/javascript" src="{sr_brand_goods_JS}/jquery-1.4.2.min.js"></script>
<script>jQuery.noConflict();</script>
<script type="text/javascript" src="{sr_brand_goods_JS}/sanree_brand_goods-1.0.js"></script>
<link rel="stylesheet" type="text/css" id="sanree_brand_common" href="data/cache/style_{STYLEID}_forum_viewthread.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" id="sanree_brand_goods" href="{sr_brand_goods_TPL}sanree_brand_goods.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="{sr_brand_goods_TPL}cate.css?{VERHASH}" />
  <div class="sanree_brand_indexbody">
    <div id="pt" class="bm cl">
      <div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$modelurl}">{$maintitle}</a>$navigation </div>
    </div>
    <div class="goods_top">
      <div class="goods_top_right">
        <div class="falshad" id="slide">
          <ul>
            <!--{loop $slidelist $cate}-->
            <li><a href="{$cate[url]}" target="_blank"><img src="{$cate[pic]}" width="775" height="341" alt="" /></a></li>
            <!--{/loop}-->
          </ul>
        </div>
        <div class="hotgoods">
          <div class="hd"> </div>
          <div class="bd">
            <ul>
              <!--{loop $recommendgoods $cate}-->
              <li class=clearall onmousemove="showthis({$cate[gid]})" onmouseout="hidethis({$cate[gid]})">
			  <div style="position:absolute"><a href="{$cate[url]}" target="_blank"><img src="{$cate[pic]}" /></a></div>
			  <div class="hotgoodsname" id='hotgoods{$cate[gid]}'><a href="{$cate[url]}" title="{$cate[name]}" target="_blank">{$cate[name]}</a></div> 
			  </li>
              <!--{/loop}-->
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="floatcate"> <a href="plugin.php?id=sanree_brand_goods&mod=published" id="publisheddlg" onclick="showWindow(this.id, this.href, 'get', 1)" class="pubbtn"></a>
      <div class=cat_c>
        <div id=category>
          <ul>
			<!--{loop $category_list $cate}-->
			    <li id="cat_{$cate[index]}"<!--{$cate[class]}--><!--{if $cate[index]>12}--> style="display:none"<!--{/if}-->><h3><!--{if $cate[subcategories]}--><B>&gt;</B><!--{/if}-->
				<A href="<!--{$cate[url]}-->"><!--{$cate[name]}--></A></h3>
				<!--{if $cate[subcategories]}-->
				<div style="DISPLAY: none" id=cat_{$cate[index]}_menu class=category_c >
				<!--{loop $cate[subcategories] $subcate}-->
				<a href="<!--{$subcate[url]}-->"><!--{$subcate[name]}--></A>
				<!--{/loop}-->
				</div>
				<!--{/if}-->
				</li>
			<!--{/loop}-->										
          </ul>
          <a id="more_cat" class="close" href="javascript:void(0);" >more</a>
		 </div>
      </div>
    </div>
    <div class="goods_ad"><a href="{$indexadlinkurl1}" target="_blank"><img src="{$indexadimgurl1}" /></a></div>
	<form action="{$modelurl}" method="post" autocomplete="on">
    <div class="goods_search">
      <input type="text" onclick="setthis(this)" class="keywords" value="{$defaultkeyword}" name="keyword" />
      <input class="submitbtn" type="image" src="{sr_brand_goods_IMG}/sbtn.jpg" align="absmiddle" />
      {$index_search_word_str} </div>
	  </form>
    <div class="goods_body">
      <div class="goods_body_left">
        <div class="orderby">
          <div class="listmode"><a href="{$bigurl}" class="noline"><img src="source/plugin/sanree_brand/tpl/good/images/big{$slistmode}.gif" alt="{lang sanree_brand:bigmode}" width="16" height="16" /></a>&nbsp;&nbsp;<a href="{$smallurl}" class="noline"><img src="source/plugin/sanree_brand/tpl/good/images/small{$slistmode}.gif" alt="{lang sanree_brand:smallmode}" width="16" height="16" /></a> </div>
          <SPAN><SPAN class="oders">{lang sanree_brand:oders}</SPAN> <A href="{$orderurl1}"><SPAN class="{$orderclass[ordertime]}">{lang sanree_brand:orderdefault}</SPAN></A><SPAN class="{$orderclass[orderview]}" ><A href="{$orderurl2}">{lang sanree_brand:ordertime}</A></SPAN> <SPAN class="{$orderclass[orderrecommend]}"><A href="{$orderurl3}">{lang sanree_brand:orderrecommend}</A></SPAN> <SPAN class="{$orderclass[orderdiscount]}"><A href="{$orderurl4}">{lang sanree_brand_goods:price}</A></SPAN> <SPAN class="{$orderclass[orderclick]}"><A href="{$orderurl5}">{lang sanree_brand:orderclick}</A></SPAN></SPAN> </div>
		<!--{if $listmode==1}-->
        <div class="goodslist1">
          <ul>
            <!--{loop $fgoods_list $cate}-->
            <li>
              <div class="goods_pic"><a href="{$cate[url]}" title="{$cate[name]}" target="_blank"><img src="{$cate[pic]}" /></a></div>
              <div class="goods_price">
			   <p>{lang sanree_brand_goods:show_price}{$config['selectpriceunitshow'][$cate[priceunit]]}<span class="delsp">{$cate[price]}</span></p>
			   <p>{lang sanree_brand_goods:show_minprice}{$config['selectpriceunitshow'][$cate[priceunit]]}<span>{$cate[minprice]}</span></p>
			  </div>
			  <div class="goods_name"><a href="{$cate[url]}" title="{$cate[name]}" target="_blank">{$cate[name]}</a></div>
              <div class="con">
			  <!--{if $ismultiple==1&&$cate[allowmultiple]==1}-->
			  {lang sanree_brand_goods:show_qq} {$cate[icq]}
			  <!--{else}-->
			  {lang sanree_brand_goods:show_qq} {$cate[qq]}
			  <!--{/if}-->	
			  </div>
            </li>
            <!--{/loop}-->
          </ul>
        </div>		
		<!--{else}-->
        <div class="goodslist0">
          <ul>
            <!--{loop $fgoods_list $cate}-->
            <li>
              <div class="goods_pic"><a href="{$cate[url]}" title="{$cate[name]}" target="_blank"><img src="{$cate[pic]}" /></a></div>
              <div class="goods_name"><a href="{$cate[url]}" title="{$cate[name]}" target="_blank">{$cate[name]}</a></div>
              <div class="goods_price">{lang sanree_brand_goods:show_price}<span>{$config['selectpriceunitshow'][$cate[priceunit]]} {$cate[price]}</span></div>
			  <div class="goods_minprice">{lang sanree_brand_goods:show_minprice}<span>{$config['selectpriceunitshow'][$cate[priceunit]]} {$cate[minprice]}</span></div>
			  <div class="goods_qq">
			  <!--{if $ismultiple==1}-->
			  {lang sanree_brand_goods:show_qq} {$cate[icq]}
			  <!--{else}-->
			  {lang sanree_brand_goods:show_qq} {$cate[qq]}
			  <!--{/if}-->				  
			  </div>
            </li>
            <!--{/loop}-->
          </ul>
        </div>
		<!--{/if}-->
        <div class="pager">{$multi}</div>
      </div>
      <div class="goods_body_right">
        <div class="hotbox">
          <div class="hd">{lang sanree_brand_goods:hotgoods}</div>
          <div class="bd">
            <ul>
              <!--{loop $hotgoods $cate}-->
              <li>
                <div class="g_left"><a href="{$cate[url]}" title="{$cate[goodsname]}" target="_blank"><img src="{$cate[pic]}" /></a></div>
                <div class="g_right">
                  <div class="g_toper">
                    <div class="gname"><a href="{$cate[url]}" title="{$cate[goodsname]}" target="_blank">{$cate[goodsname]}</a></div>
                    <div class="gprice" title="{lang sanree_brand_goods:show_price}">{$config['selectpriceunitshow'][$cate[priceunit]]}<span>{$cate[price]}</span></div>
                  </div>
                  <div class="gminprice" title="{lang sanree_brand_goods:show_minprice}">{$config['selectpriceunitshow'][$cate[priceunit]]}<span>{$cate[minprice]}</span></div></div>
              </li>
              <!--{/loop}-->
            </ul>
          </div>
        </div>
        <!-- /recommendbrand -->
        <div class="recommendbrand">
          <div class="hd"> </div>
          <div class="bd">
            <ul class="recommendlist">
              <!--{loop $recommendlist $cate}-->
              <li>
                <h1><a href="<!--{$cate[url]}-->" rel="nofollow" target='_blank' title="<!--{$cate[name]}-->"><!--{$cate[name]}--></a></h1>
                <div class="image"><a href="<!--{$cate[url]}-->" rel="nofollow" target='_blank' title="<!--{$cate[name]}-->"><!--{$cate[img]}--></a></div>
                <div class="data">
                  <div class="dright"><A href="<!--{$cate[url]}-->" rel="nofollow" target='_blank' title="<!--{$cate[name]}-->"><img src="{sr_brand_IMG}/go.gif" /></A></div>
                  <span>{$cate['views']}</span>{lang sanree_brand:brandviews}</div>
              </li>
              <!--{/loop}-->
            </ul>
          </div>
        </div>
        <!-- /recommendbrand -->
		
		  <!--{if $copyrightshow}-->
		  <div class="copyright">
			<div class="hd">
			  <H1>{lang sanree_brand:copyright}</H1>
			</div>
			<div class="bd">
			<ul>
			<li class="softname">{lang sanree_brand_goods:goods123}</li>
			<li class="ver">V {$pluginversion} For X2,X2.5!</li>
			<li class="sanree">&copy;<a href="http://www.fx8.cc/" target="_blank">Sanree.com</a></li>
			</ul>
			</div>
		  </div>
		  <!-- /service -->	
		  <!--{else}-->
		 <!-- Copyright Sanree.com  {$pluginversion} -->
		 <!--{/if}-->	      
	 	 <!-- /copyright -->
      </div>
    </div>
  </div>
  </div>
<div class="clear"></div>
{subtemplate common/footer}
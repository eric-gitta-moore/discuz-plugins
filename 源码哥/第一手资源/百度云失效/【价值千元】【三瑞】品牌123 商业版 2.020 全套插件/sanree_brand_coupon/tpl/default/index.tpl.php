<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{eval $_G['disabledwidthauto']=TRUE;}-->
{subtemplate common/header}
<link rel="stylesheet" type="text/css" id="sanree_brand_coupon" href="{sr_brand_coupon_TPL}sanree_brand_coupon.css?{VERHASH}" />
<style type="text/css">
.c_minprice, .c_price{
	font-family:"{lang sanree_brand_coupon:weiruanyahei}";
}
</style>
<script language="javascript">
	var modeurl = '{$modelurl}';
	var addstr = '<!--{if ($is_rewrite==1)}-->?<!--{else}-->&<!--{/if}-->';
</script>
<script type="text/javascript" src="{sr_brand_coupon_JS}/jquery-1.4.2.min.js"></script>
<script>jQuery.noConflict();</script>
<script type="text/javascript" src="{sr_brand_coupon_JS}/sanree_brand_coupon-1.0.js"></script>
<div class="sanree_brand_coupon_indexbody">
  <div id="pt" class="bm cl">
    <div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$modelurl}">{$maintitle}</a>$navigation </div>
  </div>
  <div class="coupon_body">
	<div class="ctopbar">
        <div class="couponflash" id="slide">
		  <ul>
            <!--{loop $slidelist $cate}-->
            <li><a href="{$cate[url]}" target="_blank"><img src="{$cate[pic]}" width="697" height="174" alt="" /></a></li>
            <!--{/loop}-->
          </ul>		
		</div>
		<div class="ctopbarright">
		   <div class="hd">{$allcountstr}</div>
		   <div class="bd">
		   <a class="addbutton" href="plugin.php?id=sanree_brand_coupon&mod=published" id="publisheddlg" onclick="showWindow(this.id, this.href, 'get', 1)"></a>
		   <div class="svncenter"><a class="mycouponbutton" href="plugin.php?id=sanree_brand_coupon&mod=mycoupon"></a><a class="mymemberbutton" href="plugin.php?id=sanree_brand_coupon&mod=members"></a></div>
		   </div>		   
		</div>
		<!-- /ctopbarright -->
	</div>
	<!-- /ctopbar -->
	<!--{if $recommendlist}-->
	<div class="cr_brand">
		<div class="hd"><a href="{$brand_config[adminadurl]}" target="_blank">{lang sanree_brand:adminadurl}</a></div>
		<div class="bd">
          <ul>
            <!--{loop $recommendlist $cate}-->
            <li>
              <div class="brand_logo"><a href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[img]}</a></div>
              <div class="brand_name"><a href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[name]}</a> </div>
            </li>
            <!--{/loop}-->
          </ul>
		</div>
	</div>
	<!-- /cr_brand -->
	<!--{/if}-->
	<!--{if $recommendcoupon}-->
	<div class="cr_coupon">
		<ul class="r_coupon">
		  <!--{loop $recommendcoupon $cate}-->
		  <li>
		  <div class="spic">
		    <div class="showpic"><a href="{$cate[url]}" target="_blank"><img src="{$cate[pic]}" /></a></div>
			<div class="showem emtop"></div>
		  </div>
		  <div class="sname"><a href="{$cate[url]}" title="{$cate[name]}" target="_blank">{$cate[name]}</a></div> 
		  </li>
		  <!--{/loop}-->
		  <!--{loop $hotcoupon $cate}-->
		  <li>
		  <div class="spic">
		    <div class="showpic"><a href="{$cate[url]}" target="_blank"><img src="{$cate[pic]}" /></a></div>
			<div class="showem emhot"></div>
		  </div>
		  <div class="sname"><a href="{$cate[url]}" title="{$cate[name]}" target="_blank">{$cate[name]}</a></div> 
		  </li>
		  <!--{/loop}-->		  
		</ul>
		<div class="scissors"></div>
	</div>
	<!-- /cr_coupon -->
	<!--{/if}-->
	<div class="ccate">
	    <form action="{$modelurl}" method="post" autocomplete="on">
		<div class="hd">
		    <div class="coupon_search">
					  <input type="text" onclick="setthis(this)" class="keywords" value="{$defaultkeyword}" name="keyword" />
					  <input class="submitbtn" type="image" src="{sr_brand_coupon_IMG}/sbtn.jpg" />					
			</div>
			<!-- /coupon_search -->
			<ul>
				<li><strong>{lang sanree_brand_coupon:hotword}</strong></li>
				<!--{loop $hotcoupon $cate}-->
				<li><a href="{$cate[url]}" title="{$cate[name]}" target="_blank">{$cate[showname]}</a></li>
				<!--{/loop}-->
			</ul>
		</div>
		</form>
		<div class="bd">
		    <div class="catedata">
				<ul>
				  <li class="catetitle">{lang sanree_brand_coupon:catetitle}</li>
				  <!--{loop $category_list $cate}-->
				  <li{$cate[class]}><A href="{$cate[url]}" title="{$cate[name]}">{$cate[name]}</A></li>
				  <!--{/loop}-->
				</ul>			
			</div>
			<!-- /catedata -->
			 <!--{if $subcategory_list}-->
			   <div class="subcate">
					<ul>
					  <li class="catetitle">{lang sanree_brand_coupon:subcatetitle}</li>
					  <li{$pidclass}><A href="{$pidurl}">{lang sanree_brand:notlimited}</A></li>
					  <!--{loop $subcategory_list $cate}-->
					  <li{$cate[class]}><A href="{$cate[url]}" title="{$cate[name]}">{$cate[name]}({$cate[count]})</A></li>
					  <!--{/loop}-->
					</ul>
			   </div>
			   <!-- /subcate -->
			 <!--{/if}-->			
		</div>
	</div>
	<!-- /ccate -->
	<div class="cfilter">
		<ul>
			<li class="{$orderclass[ordertime]}"><a href="{$orderurl1}">{lang sanree_brand_coupon:order_default}</a></li>
			<li class="{$asc[asc2]} {$orderclass[orderview]}"><a onclick="setfilter(2);" href="{$orderurl2}">{lang sanree_brand_coupon:order_time}</a></li>
			<li class="{$asc[asc3]} {$orderclass[orderrecommend]}"><a onclick="setfilter(3);" href="{$orderurl3}">{lang sanree_brand_coupon:order_rec}</a></li>
			<li class="{$asc[asc4]} {$orderclass[orderprice]}"><a onclick="setfilter(4);" href="{$orderurl4}">{lang sanree_brand_coupon:order_price}</a></li>
			<li class="{$asc[asc5]} {$orderclass[orderclick]}"><a onclick="setfilter(5);" href="{$orderurl5}">{lang sanree_brand_coupon:order_view}</a></li>
		</ul>
	</div>
	<!-- /cfilter -->
	<div class="ccouponlist">
      <div class="index_coupon_showlist">
        <ul class="coupondata">
          <!--{loop $fcoupon_list $cate}-->
          <li{$cate[class]}>
			  <div class="coupontop">
			    <div class="c_logo"><a href="{$cate[url]}" title="{$cate[name]}" target="_blank"><img src="{$cate[pic]}" /></a></div>
				<div class="c_info">
				   <div class="c_minprice">{$config['selectpriceunitshow'][$cate[priceunit]]} {$cate[minprice]}</div>
				   <div class="c_price"><span class="c1">{$config['selectpriceunitshow'][$cate[priceunit]]} {$cate[price]}</span>&nbsp;&nbsp;<span class="c2">{$cate[discount]}</span></div>
				   <div class="enddate">{$cate[enddate]}</div>
				</div>
			  </div>
			  <div class="c_title"><a href="{$cate[url]}" title="{$cate[name]}" target="_blank">{$cate[showname]}</a></div>
			  <div class="condition">
			     <div class="lgo"><a href="{$cate[url]}" title="{$cate[name]}" target="_blank"></a></div>
				 <span>{$cate[description]}</span>
			  </div>
          </li>
          <!--{/loop}-->
        </ul>
      </div>	
		<div class="pager">{$multi}</div>
	</div>
	<!-- /ccouponlist -->
	<!--{if $copyrightshow}-->
	<div class="csanree">
		<span class="d1">{lang sanree_brand_coupon:sanree_brand123}</span> <span class="d2">{lang sanree_brand_coupon:modename}</span> V{$pluginversion} For X2,X2.5! <span>Power by <a href="http://www.fx8.cc/" target="_blank">Sanree.com</a></span>	
	</div>	
	<!--{else}-->
	   <!-- Copyright Sanree.com  {$pluginversion} -->
	<!--{/if}-->				
  </div>
  <!-- /coupon_body -->
</div>
<!-- /sanree_brand_coupon_indexbody -->
<div class="clear"></div>
{subtemplate common/footer}
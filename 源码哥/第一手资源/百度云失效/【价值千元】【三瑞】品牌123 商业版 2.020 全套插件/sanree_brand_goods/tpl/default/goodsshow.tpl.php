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
<link rel="stylesheet" type="text/css" id="sanree_brand_common" href="data/cache/style_{STYLEID}_forum_viewthread.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/sanree_brand.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/userbar.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/header.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/albumlist.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/msg.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand_goods/tpl/default/goodsshow.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand_goods/tpl/default/fastpost.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand_goods/tpl/default/tipbox.css?{VERHASH}" />
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
<div class="sanree_brand_itembody" id="brandbody">
  <!--{hook/sanree_brand_usertoper}-->
  <div id="pt" class="bm cl">
    <div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$modelurl}">{$maintitle}</a>$navigation </div>
  </div>
  {$brand_header}
  <!--{hook/sanree_brand_userheader}-->  
    <div class="albumlist">
	  <div class="albumleft">
	    <!--{hook/sanree_brand_userlefttop}-->
	    <div class="goodsshow">
		   <div class="ahd"><h1>{$goodsresult[name]}</h1></div>
		   <div class="abd">
               <div class="gpicture">
			   <img id='aimg_{$goodsresult[homeaid]}' src="{$goodsresult[gpicture]}" title="{$goodsresult[name]}" onclick="zoom(this, this.src)" alt="{$goodsresult[name]}" />
			   </div>
			   <div class="ginfo">
			        <div class="goodsno">{lang sanree_brand_goods:post_goodsno}<span>{$goodsresult[goodsno]}</span></div>
			        <div class="gprice">{lang sanree_brand_goods:post_price}<span>{$config['selectpriceunitshow'][$goodsresult[priceunit]]} {$goodsresult[price]}<!--{if $goodsresult[unit]}--> / {$goodsresult[unit]}<!--{/if}--></span></div>
					<div class="gminprice">{lang sanree_brand_goods:post_minprice}<span>{$config['selectpriceunitshow'][$goodsresult[priceunit]]} {$goodsresult[minprice]}<!--{if $goodsresult[unit]}--> / {$goodsresult[unit]}<!--{/if}--></span></div>
					<div class="gcatename">{lang sanree_brand_goods:post_goodscate}<span>{$goodsresult[catename]}</span></div>
					<div class="gdateline">{lang sanree_brand_goods:post_dateline}<span>{$goodsresult[dateline]}</span></div>
					  <div class="satisfaction">
						<div class="satisfactionc">{lang sanree_brand_goods:satisfaction}</div>
						<div class="satisfactiona" title="{lang sanree_brand_goods:satisfaction}{$goodsresult['satisfaction']}{lang sanree_brand_goods:fen}">
						  <div class="satisfactionb" style="width:{$goodsresult['satisfactionwidth']}px"></div>
						</div>
					  </div>	
					  <div class="goods_qq">{lang sanree_brand_goods:show_buy}{$brandresult['allicq']} <div class="goodstel114">{$brandresult['tel114url']}</div></div>				
						<!--{if $isbuylink==1&&!empty($goodsresult['buylink'])}-->
						<div class="goods_buy"><a href="{$goodsresult['buylink']}" title="{lang sanree_brand_goods:view_buyclicktip}" target="_blank"><img src="{$buyimage}" alt="{lang sanree_brand_goods:view_buyclicktip}" /></a></div>
						<div class="tipbox" id="buytipbox">
							<div class="cntBox">
								<p>
									{$purchasestatement}
								</p>
							</div>
							<div class="tipbox-direction tipbox-up">
								<em>&#9670;</em><span>&#9670;</span>
							</div>
							<a title="{lang close}" onclick="tipclose()" class="close-ico" href="javascript:void(0);"></a>
						</div>						
						<!--{/if}-->  
			   </div>
		   </div>

		   <div class="gcontent"></div>
		   <div class="gcontenttxt">{$goodsresult[content]}</div>
		   
		   <!--{if $imglist}-->
		   <div class="gpiclist"></div>
		   <div class="gpiclisttxt">
		         <!--{loop $imglist $picture}-->
				 <div><img id='aimg_{$picture[aid]}' src="{$picture[pic]}" title="{$picture[name]}" onclick="zoom(this, this.src)" alt="{$picture[name]}" onload="centerimg(this)" /></div>
				 <!--{/loop}-->
		   </div>
		   <!--{/if}-->
		   <div id="brandcomment" class="brandcommentshow"></div>
           <div class="clear"></div>
            <script language="javascript">
			var url = 'plugin.php?id=sanree_brand_goods&mod=fastpost&tid={$tid}&gid={$gid}';
			ajaxget(url, 'brandcomment');
			</script>		   
		</div> 	 
		<!--{hook/sanree_brand_userleftbottom}--> 
	  </div>
	  <!-- /albumleft -->
	  
	  <div class="albumright">
		  <!--{if defined('IN_BRAND_USER')}-->
			  <div class="clickmanage">
				  <a href="javascript:void(0)" onclick="showmanage(1)"></a>
			  </div>
			  <!-- /clickmanage -->
		  <!--{/if}-->
		  <!--{hook/sanree_brand_userrighttop}-->		  		  
	     <div class="baseinfo<!--{if defined('IN_BRAND_USER')}--> srmtop10<!--{/if}-->">
		    <div class="hd"></div>
			<div class="bd">
			   <ul>
			      <li class="oqq">
				  <!--{if $ismultiple==1&&$brandresult[allowmultiple]==1}-->
				  {lang sanree_brand:oqq}{$brandresult[icq]}
				  <!--{else}-->
				  {lang sanree_brand:oqq}{$brandresult[qq]}
				  <!--{/if}-->				  
				  </li>
				  <li class="olevel">{lang sanree_brand:olevel}<img align="absbottom" src="{$brandresult[groupimg]}" /></li>
				  <li class="odiscount">{lang sanree_brand:odiscount}{$brandresult['discount']}</li>
				  <li class="otelphone">{lang sanree_brand:otelphone}{$brandresult[tel]}</li>
				  <li class="oaddress">{lang sanree_brand:oaddress}{$brandresult[address]}</li>
			   </ul>
			</div>
		 </div>
		 <!-- /baseinfo -->
		 
		 <div class="brandnews">
		     <div class="hd"></div>
			 <div class="bd">
			 <ul>
			 <!--{loop $newlist $value}-->
				 <li><a href="{$value[url]}" target="_blank">{$value[name]}</a></li>
			 <!--{/loop}-->
			 </ul>
			 </div>
		 </div>
		 <!-- /brandnews -->
		 
		 <div class="brandfavorite">
		     <div class="hd"><div class="favoritebtn"><a href="home.php?mod=spacecp&ac=favorite&type=thread&id=$brandresult[tid]" id="k_favorite" onclick="stid={$brandresult[tid]};showWindow(this.id, this.href, 'get', 0);"></a></div></div>
			 <div class="bd">{lang sanree_brand:fav}<span>{$brandresult[favtimes]}</span></div>
			 <div class="fd">
			    <ul>
				<!--{loop $favoritelist $value}-->
				<li>
				  <div class="avt"><a href="home.php?mod=space&uid=$value[uid]" target="_blank"><!--{avatar($value[uid],small)}--></a></div>
				  <div class="avname"> <a href="home.php?mod=space&uid=$value[uid]" target="_blank">$value[username]</a></div>
				</li>
			    <!--{/loop}-->
				</ul>
			 </div>
		 </div>
		 <!-- /brandfavorite -->
		 <!--{hook/sanree_brand_userrightbottom}-->
	  </div>
	  <!-- /albumright -->
	</div>
	<!-- /albumlist -->
</div>
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
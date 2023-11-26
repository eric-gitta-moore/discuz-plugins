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
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand_video/tpl/default/videoshow.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand_video/tpl/default/fastpost.css?{VERHASH}" />
<script src="source/plugin/sanree_brand/tpl/good/js/sanree_brand.js?{VERHASH}"></script>
<script src="source/plugin/sanree_brand/tpl/good/js/voter.js?{VERHASH}"></script>
<script src="static/js/forum_viewthread.js"></script>
<script language="javascript">
	var stid=0;
	var aimgcount = new Array();
	aimgcount[{$catid}] = {$aids};
	attachimggroup({$catid});
	attachimgshow({$catid});
	var aimgfid = 0;
	
	var langvoter=Array();
	langvoter[0] = '{lang sanree_brand_video:pleasestar}';
	langvoter[1] = '{lang sanree_brand_video:pleasestarstr}';
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
	    <div class="videoshow">
		   <div class="ahd"><a>{$videoresult[views]}</a></div>
		   <div class="abd">
		       <h1>{$videoresult[name]}</h1>
			   <div class="ginfo">
					<div class="gcatename">{lang sanree_brand_video:post_videocate}<span>{$videoresult[catename]}</span></div>
					<div class="gdateline">{lang sanree_brand_video:post_dateline}<span>{$videoresult[dateline]}</span></div>
					  <div class="satisfaction">
						<div class="satisfactionc">{lang sanree_brand_video:satisfaction}</div>
						<div class="satisfactiona" title="{lang sanree_brand_video:satisfaction}{$videoresult['satisfaction']}{lang sanree_brand_video:fen}">
						  <div class="satisfactionb" style="width:{$videoresult['satisfactionwidth']}px"></div>
						</div>
					  </div>	
			   </div>
				<div style="margin:20px auto; width:{$videoresult[width]}px;">{$mediahtml}</div>			   
		   </div>
		   <div class="gcontent"></div>		   
		   <div class="gcontenttxt" id="gcontenttxt">{$videoresult[content]}</div>
		   <!--{if count($imglist)>0}-->
		   <div class="gpiclist"></div>
		   <div class="gpiclisttxt">
		         <!--{loop $imglist $picture}-->
				 <div><img id='aimg_{$picture[aid]}' src="{$picture[pic]}" title="{$picture[name]}" onclick="zoom(this, this.src)" alt="{$picture[name]}" onload="centerimg(this)" /></div>
				 <!--{/loop}-->
		   </div>
		   <!--{/if}-->
			<!--{if $sharecode}-->
				<div class="tshare cl">
				  {$sharecode}
				</div>
			<!--{/if}-->
				   
		   <div id="brandcomment" class="brandcommentshow"></div>
           <div class="clear"></div>
            <script language="javascript">
			var url = 'plugin.php?id=sanree_brand_video&mod=fastpost&tid={$tid}&nid={$nid}';
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
		 <!-- /brandvideo -->
		 
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
function fontsize(size){
	$('gcontenttxt').style.fontSize=size+'px';
}
function backcolor(color){
	$('gcontenttxt').style.backgroundColor=color;
	if (color=='#FFFFFF') {
		$('gcontenttxt').style.color='#444444';
	}else {
		$('gcontenttxt').style.color='#444444';
	}
}
</script>
<!--{hook/sanree_brand_userfooter}-->
{subtemplate common/footer}  
<style type="text/css">.hm{position:inherit;}.zimg_prev{width:50%;}.zimg_next{width:50%;}</style>
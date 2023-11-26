<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
{subtemplate common/header}
<link rel="stylesheet" type="text/css" id="sanree_brand_common" href="data/cache/style_{STYLEID}_forum_viewthread.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" id="sanree_brand" href="source/plugin/sanree_brand/tpl/default/sanree_brand.css?{VERHASH}" />
<script language="javascript" src="{sr_brand_JS}/sanree_brand.js"></script>
<div class="sanree_brand_indexbody">
	<div id="pt" class="bm cl">
		<div class="z">
			<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$allurl}">{$maintitle}</a>$navigation
		</div>
	</div>
	<form method="post" action="{$allurl}">
	<div class="sanree_brand_catelist">
	   <div class="sanree_brand_lborder">
	   <div class="hd"><div class="sanree_brand_searchbar"><input type="text" class="mykeyword" onclick="setthis(this)" name="keyword" value="{$defaultkeyword}" /><input type="image" border="0" src="{sr_brand_IMG}/searbtn.jpg" /></div></div>
	   <div class="bd">
	     <ul class="sanree_brand_catedata">
			<!--{loop $category_list $cate}-->
			<li<!--{$cate[class]}-->><A href="<!--{$cate[url]}-->"><!--{$cate[name]}--></A></li>
			<!--{/loop}-->	
		 </ul>
		 <div class="clear"></div>
	   </div>
	   </div>
	</div>
	</form>
	
	<div class="sanree_brand_business">
	    <div class="sanree_brand_left">
		    <!--{if $businesses_list}-->
				<ul class="businesslist">
				<script language="javascript">
					var stid=0;
				</script>				
				<!--{loop $businesses_list $catet}-->
				<li>
				  <!--{loop $catet $cate}-->
				  <div class="businessshow">
				  <dl>
					<dd class="image"><div class="mimg"><a href="{$cate[turl]}" target="_blank"><img src="{$cate[poster]}" alt="{$cate[name]}" /></a></div></dd>
					<dd class="czbar">
					<div class="hm"><span class="xg1">{lang sanree_brand:show}:</span> <span class="xi1">$cate[forum_thread][views]</span><span class="pipe">|</span><span class="xg1">{lang sanree_brand:reply}:</span> <span class="xi1">$cate[forum_thread][replies]</span></div>
				    <div id=p_btn class="mtw cl">
					<a href="home.php?mod=spacecp&ac=share&type=thread&id=$cate[tid]" id="k_share" onclick="stid={$cate[tid]};showWindow(this.id, this.href, 'get', 0);" onmouseover="this.title = $('sharenumber{$cate[tid]}').innerHTML + ' {lang sanree_brand:activity_member_unit}{lang sanree_brand:thread_share}'"><i><img src="{IMGDIR}/oshr.png" alt="{lang sanree_brand:thread_share}" />{lang sanree_brand:thread_share}<span id="sharenumber{$cate[tid]}">{$cate['forum_thread']['sharetimes']}</span></i></a>
				    <a href="home.php?mod=spacecp&ac=favorite&type=thread&id=$cate[tid]" id="k_favorite" onclick="stid={$cate[tid]};showWindow(this.id, this.href, 'get', 0);" onmouseover="this.title = $('favoritenumber{$cate[tid]}').innerHTML + ' {lang  sanree_brand:activity_member_unit}{lang sanree_brand:thread_favorite}'"><i><img src="{IMGDIR}/fav.gif" alt="{lang sanree_brand:thread_favorite}" />{lang sanree_brand:thread_favorite}<span id="favoritenumber{$cate[tid]}">{$cate['forum_thread']['favtimes']}</span></i></a>
					</div>
					</dd>
					<dd class="bname"><span>{$cate[name]}</span></dd>
					<dd class="catename"><strong>{lang sanree_brand:catename}</strong><a href="{$cate[cateurl]}"><span>{$cate[catename]}</span></a></dd>
					<dd class="propaganda"><strong>{lang sanree_brand:propaganda}</strong>{$cate[propaganda]}</dd>
					<dd class="introduction"><strong>{lang sanree_brand:introduction}</strong>{$cate[introduction]}</dd>				
					<dd class="contact"><strong>{lang sanree_brand:contact}</strong>{$cate[contact]}</dd>
					<!--{if $cate[weburl]}--><dd class="weburl"><strong>{lang sanree_brand:weburl}</strong><a href="http://{$cate[weburl]}" rel="nofollow" target="_blank" title="{$cate[alt]}">{$cate[weburl]}</a></dd><!--{/if}-->
					<dd class="oweruser"><a href="home.php?mod=space&amp;uid={$cate[uid]}" target="_blank">{avatar($cate[uid], 'small')}</a><a href="home.php?mod=space&amp;uid={$cate[uid]}" target="_blank">{$cate[username]}</a>{lang sanree_brand:addyu}{$cate[addtime]}<div class="clear"></div></dd>
				  </dl>
				  </div>
				  <!--{/loop}-->	
				</li>
				<!--{/loop}-->	
				</ul>
				<div class="pager">{$multi}</div>				
			<!--{else}-->
				{lang sanree_brand:zanwustr}
			<!--{/if}-->
		</div>

		<div class="sanree_brand_right">
		  <div class="regbar">
		     <div class="hd"><a href="plugin.php?id=sanree_brand&mod=published" id="publisheddlg" onclick="showWindow(this.id, this.href, 'get', 1)"><img src="{sr_brand_IMG}/djbtn.jpg" border="0" /></a></div>
			 <div class="bd">
			     <ul>
				 <li class="stitle">{lang sanree_brand:published_title}</li>
				 <li class="sline"><img src="{sr_brand_IMG}/yes.jpg" border="0" align="absmiddle" /> {lang sanree_brand:published_data1}{$admintel}<br />QQ:{$adminqq}</li>
				 <li class="sline2"><img src="{sr_brand_IMG}/yes.jpg" border="0" align="absmiddle" /> {lang sanree_brand:published_data2}{$published_data3}</li>
				 <li class="published_s"><a href="{$adminadurl}" target="_blank">{lang sanree_brand:published_ad}</a></li>
				 </ul>
			 </div>
		  </div>
		  <div class="recommend_brand">
		     <div class="hd"><a>{lang sanree_brand:recommend_brand}</a></div>
			 <div class="bd">
			    <ul class="recommendlist">
					<!--{loop $recommendlist $cate}-->
					<li><A href="<!--{$cate[url]}-->" rel="nofollow" target='_blank' title="<!--{$cate[name]}-->"><!--{$cate[img]}--></A></li>
					<!--{/loop}-->
				</ul>
			 </div>
		  </div>
		  <!--{if $copyrightshow}-->
		 <div class="copyright mtop">
			 <dl class="sanreeinfo">
			 <dd class="softname"><span class="sanree">{lang sanree_brand:sanree}</span><span class="brand">{lang sanree_brand:brand123}</span></dd>
			 <dd>V {$pluginversion} For X2,X2.5!</dd>
			 <dd>Sanree Professional Plug</dd>
			 <dd class="sanreecom">&copy;&nbsp;<a href="http://www.ymg6.Com/" target="_blank">Sanree.com</a></dd>
			 <dd>{lang sanree_brand:support}<a href="http://www.fx8.cc/" target="_blank">www.fx8.cc</a></dd>
			 </dl>
		 </div>	
		 <!--{else}-->
	 <!-- Copyright Sanree.com  {$pluginversion} -->
	 <!--{/if}-->	  
		</div>
	</div>
	<div class="clear"></div>
</div>
<div class="clear"></div>
{subtemplate common/footer}
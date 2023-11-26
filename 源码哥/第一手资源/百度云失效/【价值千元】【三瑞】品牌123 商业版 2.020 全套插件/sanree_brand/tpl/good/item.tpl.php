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
<!--{if ($tel114version >=1121) }--><link rel="stylesheet" type="text/css" id="sanree_tel114" href="source/plugin/sanree_tel114/style/tel.css?{VERHASH}" /><!--{/if}-->
<link rel="stylesheet" type="text/css" href="data/cache/style_{STYLEID}_forum_viewthread.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/sanree_brand.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/fastpost.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/userbar.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/msg.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/album.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/header.css?{VERHASH}" />

<style type="text/css">

.good {
	float: left;
	display: inline-block;
	color: #ff3a3a;
	position: relative;
	z-index: 1;
}
.good span {
	float: left;
}
.good span img {
	margin-right: 6px;
}
.good span strong {
	color: #666666;
	font-weight: normal;
}
.good .goodpage a {
	padding: 0 5px;
	height: 22px;
	display: block;
}
.good .goodpage a {
	padding: 0 5px;
	height: 22px;
	line-height: 21px;
	display: block;
	border: 1px solid #e0e0e0;
	background: #fff;
	border-radius: 5px 0 0 5px;
	color: #ff5a5a;
}
.good .goodpage a:hover {
	padding: 0 5px;
	height: 22px;
	line-height: 21px;
	display: block;
	border: 1px solid #c0c0c0;
	background: #fff;
	border-radius: 5px;
	color: #ff5a5a;
}
.taotie {
	float: left;
	position: relative;
	z-index: 1;
}
.taotie a {
	border: 1px solid #e0e0e0;
	border-left: none;
	border-radius: 0 5px 5px 0;
	color: #666;
	display: block;
	text-decoration: none;
	background: #fff;
	padding: 0 6px;
	height: 22px;
	line-height: 22px;
}
.taotie a img {
	vertical-align: middle;
	margin-right: 6px;
	position: relative;
	top: -2px;
}
</style>

<div class="sanree_brand_itembody" id="brandbody">
  <!--{hook/sanree_brand_usertoper}-->
  <div id="pt" class="bm cl">
    <div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$allurl}">{$maintitle}</a>$navigation </div>
  </div>
  {$brand_header}
  <!--{hook/sanree_brand_userheader}-->
  <div class="mainbody">
    <div class="mainbodyleft">
	  <!--{hook/sanree_brand_userlefttop}-->
      <div class="topbar">
        <div class="ileft">
          <div class="iposter"><img src="{$brandresult[poster]}" /></div>
          <div class="itel">
		  <!--{if $ismultiple==1&&$brandresult[allowmultiple]==1}-->
			  <span style="cursor:pointer" onmouseover="showMenu({'ctrlid':'tel<hash>','pos':'*'})">$brandresult[tel]</span>
			  <!--{if count($tellist)>1}-->
				  <a class="telmore" id="tel<hash>" onclick="showMenu({'ctrlid':'tel<hash>','pos':'*'})" onmouseover="showMenu({'ctrlid':'tel<hash>','pos':'*'})"></a>
				  <div id="tel<hash>_menu" class="p_pop p_opt" style="display:none;">
				  <!--{loop $tellist $cate}-->
					  <img src="{sr_brand_IMG}/mtelli.jpg" align="absmiddle" /> $cate<br />
				  <!--{/loop}-->
				  </div>
			  <!--{/if}-->
		  <!--{else}-->
		  {$brandresult[tel]}
		  <!--{/if}-->
		  </div>
          <div class="good">
              <div class="goodpage">
                  <a href="javascript:;" onclick="<!--{if !$assistflag}--><!--{if $_G[uid]}-->getassist(this);<!--{else}-->location.href='plugin.php?id=sanree_brand&mod=assist&tid={$bid}&uid=1'<!--{/if}--><!--{/if}-->">
                  <span><img src="<!--{if $assistflag}-->{sr_brand_IMG}/good_hover.png<!--{else}-->{sr_brand_IMG}/good_link.png<!--{/if}-->" /></span>
                  <span><!--{if $assistflag}--><leu style="cursor:default;">{lang sanree_brand:assistly}</leu><strong style="margin-left:5px;">{$assistcount}</strong><!--{else}-->{lang sanree_brand:promotion_assist}<strong style="margin-left:5px;">{$assistcount}</strong><!--{/if}--></span>
                  </a>
              </div>
          </div>
		  <div class="taotie">
			  <!--{if !$_G['forum']['disablecollect'] && helper_access::check_module('collection') && $_G['cache']['plugin']['sanree_brand']['allcollection']}-->
				<a href="forum.php?mod=collection&action=edit&op=addthread&tid={$brandresult['tid']}" id="k_collect" onclick="showWindow(this.id, this.href);return false;" onmouseover="this.title = $('collectionnumber').innerHTML + ' {lang activity_member_unit}{lang collection}'" title="{lang thread_collect}"><i><img src="{IMGDIR}/collection.png" alt="{lang thread_share}" />Ã‘Ã˘<span id="collectionnumber"{if !$post['releatcollectionnum']} style="display:none"{/if}>{$post['releatcollectionnum']}</span></i></a>
			  <!--{/if}-->
		  </div>
		  <div class="frenling">
			  <!--{if !$brandresult['ownerid']}-->
			  <a href="plugin.php?id=sanree_brand&mod=msg&bid={$brandresult[bid]}&type=1" id="cmenu" onclick="showWindow('cmenu', this.href, 'get', 1)">[{lang sanree_brand:claimbrand}]</a>
			  <!--{/if}-->		  
		  </div>
        </div>
		<!-- /ileft -->
        <div class="iright">
          <div class="itemname"><H1 title="{$brandresult[name]}"><span>{$brandresult['tel114url']}</span>{$brandresult[name]}<!--{if $pbidlist}-->&nbsp;&nbsp;<a href="plugin.php?id=sanree_brand&mod=branch&tid={$brandresult[bid]}" id="branchdlg" onclick="showWindow(this.id, this.href, 'get', 1)" title="{lang sanree_brand:tplbranch}"><img src="{SANREE_BRAND_TEMPLATE}/images/branch.jpg" /></a><!--{/if}-->
            <!--{if $mtfopen}-->
            <img src="{$mtf}" style="float:right; margin-right:20px" />
            <!--{/if}-->
		  </H1></div>
          <div class="satisfaction">
		    <div class="brandview">{lang sanree_brand:brandview}<span>{$forum_thread[views]}</span></div>
			<!--{if !empty($brandresult[weburl])&&$isshowweburl==1}--><div class="inweburl"><a href="{$brandresult[weburl]}" rel="nofollow" target="_blank" title="{$brandresult[weburl]}">{$viewwebtip}</a></div><!--{/if}-->
            <div class="satisfactionc">{lang sanree_brand:satisfaction}</div>
            <div class="satisfactiona" title="{lang sanree_brand:satisfaction}{$brandresult['satisfaction']}%">
              <div class="satisfactionb" style="width:{$brandresult['satisfactionwidth']}px"></div>
            </div>
          </div>		  
          <div class="recommendationindex">{lang sanree_brand:recommendationindex1}<span>{$brandresult[recommendationindex]}%</span> <em class="brandgroup">{lang sanree_brand:brandgroup}</em><img align="absmiddle" src="{$brandresult[groupimg]}" /> <em class="itemdiscount">{lang sanree_brand:itemdiscount}</em><span class="itemdiscount">{$brandresult['discount']}</span> <img src="{sr_brand_IMG}/zhe.gif" /></div>
          <div class="cateh">
		    <div class="srcleft">{lang sanree_brand:cateh}<span>{$brandresult[catename]}</span></div>
			<div class="srcright"><em>{lang sanree_brand:region}</em>
            <!--{if $isselfdistrict==1}-->
            <span>{$brandresult[srbirthprovince]} - {$brandresult[srbirthcity]}</span>
            <!--{else}-->
            <span>{$brandresult[birthcity]} - {$brandresult[birthdist]}</span>
            <!--{/if}-->
			</div>
          </div>  
          <div class="brandqq">
		    <!--{if $ismultiple==1&&$brandresult[allowmultiple]==1}-->
				<!--{if $icq=='msn'}-->{lang sanree_brand:brandmsn}<span>{$brandresult[icq]}</span><!--{elseif $icq=='wangwang'}-->{lang sanree_brand:brandwangwang}<span>{$brandresult[icq]}</span><!--{elseif $icq=='baiduhi'}-->{lang sanree_brand:brandbaiduhi}<span>{$brandresult[icq]}</span><!--{elseif $icq=='skype'}-->{lang sanree_brand:brandskype}<span>{$brandresult[icq]}</span><!--{else}-->{lang sanree_brand:brandqq}<span>{$brandresult[icq]}</span><!--{/if}-->
			<!--{else}-->
			{lang sanree_brand:oqq}<span>{$brandresult[qq]}</span>
			<!--{/if}-->
		  </div>
          <!--{if $brandresult[iscard]}-->
          <div class="brandcard"><img src="{sr_brand_IMG}/cardico.jpg" /><span style="color:#900; margin-left:5px; vertical-align:top;"><!--{if $brandresult[carddetail]}-->{$brandresult[carddetail]}<!--{else}-->{lang sanree_brand:nodetail}<!--{/if}--></span></div>
          <!--{/if}-->	  		  
		  <div class="brandmf">{lang sanree_brand:tplmf}<span>{$mfliststr}</span></div>	  
		  <div class="brandaddress">{lang sanree_brand:brandaddress}<span>{$brandresult[address]}</span></div>
          <div class="brandbar"></div>
        </div>
		<!-- /iright -->
        <div class="clear"></div>
        <div class="brandno">
			<!--{if $brandresult[abrandno]}-->
				<div class="bin"> <span>$brandresult[abrandno]</span> <em></em> <b></b> </div>
			<!--{/if}-->
			<!--{if $sharecode}-->
				<div class="tshare cl">
				  {$sharecode}
				</div>
			<!--{/if}-->		  
        </div>
		<!-- /brandno -->
      </div>
      <!-- /topbar -->
      <div id="brandalbum" class="brandalbum"></div>
      <div class="clear"></div>
      <div class="contentbar">
        <div class="item_01">
          <div class="hd"></div>
          <div class="bd"> {$brandresult[propaganda]} </div>
        </div>
        <!-- /item_01 -->
        <div class="item_02">
          <div class="hd"></div>
          <div class="bd"> {$brandresult[introduction]} </div>
        </div>
        <!-- /item_02 -->
        <div class="item_03">
          <div class="hd"></div>
          <div class="bd"> {$brandresult[contact]} </div>
        </div>
        <!-- /item_03 -->
		<!--{if $isshowmap==1}-->
			<div id="brandmap" class="brandmap"></div>
		<!--{/if}-->
		<div class="clear"></div>
      </div>
      <!-- /contentbar -->
      
      <script type="text/javascript">
	   /*<center>
      	<div style="position: relative; text-align: center; <!--{if $_G[uid]}--> cursor:pointer;<!--{/if}--> background: none repeat scroll 0% 0% rgb(255, 68, 0); color: rgb(255, 255, 255); font-weight: bold; border-radius: 5px; display: inline-block; width:150px" class="goodbox">
      	<div style="height: 35px; line-height: 35px;" onclick="<!--{if !$assistflag}--><!--{if $_G[uid]}-->getassist(this);<!--{else}-->location.href='plugin.php?id=sanree_brand&mod=assist&tid={$bid}&uid=1'<!--{/if}--><!--{/if}-->"  onmouseout="this.innerHTML='{lang sanree_brand:assist_befor}{$assistcount}{lang sanree_brand:assist_after}'" onmouseover="this.innerHTML='<!--{if $assistflag}-->{lang sanree_brand:assistly}<!--{else}-->{lang sanree_brand:assist}<!--{/if}-->'">{lang sanree_brand:assist_befor}{$assistcount}{lang sanree_brand:assist_after}</div>
      	<span id="success" style="visibility: hidden; position: absolute; top: 0px; right: -25px; color: #FFF; background: none repeat scroll 0% 0% #333;height: 35px;line-height: 35px;padding: 0px 9px;border-radius: 0px 5px 5px 0px;">+1</span>
 		</div>
		</center>*/
      		function getassist(obj) {
				var count = '{$assistcount}';
				count++;
				
				if (window.XMLHttpRequest) {
				 	xmlhttp=new XMLHttpRequest();
				}
				else {
				   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				
				xmlhttp.onreadystatechange=function() {
					
					if (xmlhttp.readyState==4 && xmlhttp.status==200) {
						if(xmlhttp.responseText) {
							
							obj.onclick = '';
							obj.style.cursor = 'default';
							obj.style.textDecoration = 'none';
							obj.innerHTML = '<span><img src="{sr_brand_IMG}/good_hover.png" /></span><span>{lang sanree_brand:assistly}<strong style="margin-left:5px;">'+count+'</strong></span>';
							
						}

					} else if (xmlhttp.readyState==1 && xmlhttp.status==0) {

					} else {
						
					}
				}
				xmlhttp.open("GET",'plugin.php?id=sanree_brand&mod=assist&tid={$bid}',true);
				xmlhttp.send();
			
			}
	
      </script>
      <div id="brandcomment" class="brandcommentshow"></div>
      <div class="clear"></div>
	  <!--{hook/sanree_brand_userleftbottom}-->
    </div>
    <!-- /mainbodyleft -->
    <div class="mainbodyright">  
	  <!--{if defined('IN_BRAND_USER')}-->
		  <div class="clickmanage">
			  <a href="javascript:void(0)" onclick="showmanage(1)"></a>
		  </div>
		  <!-- /clickmanage -->
	  <!--{/if}-->	  
	  <!--{hook/sanree_brand_userrighttop}-->
      <div class="step3<!--{if defined('IN_BRAND_USER')}--> srmtop10<!--{/if}-->">
        <div class="addbutton"><a href="plugin.php?id=sanree_brand&mod=published" id="publisheddlg" onclick="showWindow(this.id, this.href, 'get', 1)"></a></div>
      </div>
      <!-- /step3 -->
	  <!--{if $attention}-->
      <div style="margin-top:10px;">
          <!--{if $flag}-->
          <a onclick="return(confirm('{$deltip}'))" href="{$atnurl}"><img src="{$atnbtn}" /></a>
          <!--{else}-->
          <a href="{$atnurl}"><img src="{$atnbtn}" /></a>
          <!--{/if}-->
      </div>
      <!--{/if}-->
	 <!--{if $brandresult['weixin']}-->
     <div class="wxbar"><a href="plugin.php?id=sanree_brand&mod=weicode&tid={$brandresult['bid']}" id="weicodedlg" onclick="showWindow(this.id, this.href, 'get', 1)"><img src="{sr_brand_IMG}/wxbtn.jpg" /></a></div>
	 <!--{/if}--> 
		<!--{if $tagdata}-->
		<div class="brand_taglist">
		<div class="hd">
		<h1>{lang sanree_brand:tpltag}</h1>
		</div>
		<div class="bd">
			<ul>
				<!--{loop $tagdata $tag}-->
				<a href="{$tag['url']}" ><li>{$tag['tagname']}</li></a>
				<!--{/loop}-->
			</ul>	  
		</div>
		</div>
		<!--{/if}-->  
	  <!--{hook/sanree_brand_user_index_righttop}-->
      <div class="recommendbrand">
        <div class="hd"></div>
        <div class="bd">
          <ul class="recommendlist">
            <!--{loop $recommendlist $cate}-->
            <li>
              <h1><A href="{$cate[url]}" rel="nofollow" title="{$cate[name]}" target='_blank'>{$cate[name]}</A></h1>
              <div class="image"><A href="{$cate[url]}" rel="nofollow" target='_blank' title="{$cate[name]}">{$cate[img]}</A></div>
              <div class="data"><div class="dright"><A href="{$cate[url]}" rel="nofollow" target='_blank' title="{$cate[name]}"><img src="{sr_brand_IMG}/go.gif" /></A></div><span>{$cate['views']}</span>{lang sanree_brand:brandviews} </div>
            </li>
            <!--{/loop}-->
          </ul>
        </div>
      </div>
      <!-- /recommendbrand -->
      <div class="brandnews">
        <div class="hd"></div>
        <div class="bd">
          <ul>
            <!--{loop $newlist $value}-->
            <li><a href="{$value[url]}" title="{$value[name]}" target="_blank">{$value[name]}</a></li>
            <!--{/loop}-->
          </ul>
        </div>
      </div>
      <!-- /brandnews -->
      <div class="brandfavorite">
        <div class="hd">
          <div class="favoritebtn"><a href="home.php?mod=spacecp&ac=favorite&type=thread&id=$brandresult[tid]" id="k_favorite" onclick="stid={$brandresult[tid]};showWindow(this.id, this.href, 'get', 0);"></a></div>
        </div>
        <div class="bd">{lang sanree_brand:fav}<span>{$brandresult[favtimes]}</span></div>
        <div class="fd">
          <ul>
            <!--{loop $favoritelist $value}-->
            <li>
              <div class="avt"><a href="home.php?mod=space&amp;uid=$value[uid]" target="_blank"><!--{avatar($value['uid'],small)}--></a></div>
              <div class="avname"><a href="home.php?mod=space&uid=$value[uid]" target="_blank">$value[username]</a></div>
            </li>
            <!--{/loop}-->
          </ul>
        </div>
      </div>
      <!-- /brandfavorite -->
	  <!--{hook/sanree_brand_userrightbottom}-->
    </div>
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
</div>
<div id="userbar"></div>
<script src="static/js/forum_viewthread.js?{VERHASH}"></script>
<!--{if $mapapi=='baidu'}--><script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script><!--{/if}-->
<!--{if $mapapi=='google'}--><script src="http://ditu.google.cn/maps/api/js?sensor=false" type="text/javascript"></script><!--{/if}-->
<script language="javascript">
	var langvoter=Array();
	langvoter[0] = '{lang sanree_brand:pleasestar}';
	langvoter[1] = '{lang sanree_brand:pleasestarstr}';
</script>
<script src="{sr_brand_JS}/voter.js?{VERHASH}"></script>
<script language="javascript">ajaxget('plugin.php?id=sanree_brand&mod=album&tid={$tid}&bid={$bid}', 'brandalbum');</script>
<script language="javascript">ajaxget('plugin.php?id=sanree_brand&mod=fastpost&tid={$tid}&bid={$bid}', 'brandcomment');</script>
<script language="javascript">ajaxget('plugin.php?id=sanree_brand&mod=userbar&tid={$tid}&bid={$bid}', 'userbar');function favoriteupdate(){}</script>
<!--{if $isshowmap==1}-->
	<script language="javascript">ajaxget('plugin.php?id=sanree_brand&mod=map&tid={$tid}&bid={$bid}', 'brandmap');</script>
<!--{/if}-->
<!--{hook/sanree_brand_userfooter}-->
{subtemplate common/footer}<style type="text/css">.hm{position:inherit;}.zimg_prev{width:50%;}.zimg_next{width:50%;}</style>
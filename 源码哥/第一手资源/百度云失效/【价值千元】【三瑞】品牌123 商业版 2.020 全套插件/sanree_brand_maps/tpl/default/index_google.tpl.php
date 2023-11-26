<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>

{subtemplate common/header}
<script type="text/javascript" src="source/plugin/sanree_brand_maps/tpl/default/js/jquery-1.4.2.min.js"></script>
<script>var sanree_jQuery=jQuery.noConflict();</script>
<script language="javascript">
var lang1 = "{lang sanree_brand_maps:showlist}";
var lang2 = "{lang sanree_brand_maps:hiddenlist}";
var lang3 = "{lang sanree_brand_maps:unfullscreen}";
var lang4 = "{lang sanree_brand_maps:fullscreen}";
</script>
<script type="text/javascript" src="source/plugin/sanree_brand_maps/tpl/default/js/sanree_brand_maps.js"></script>
<script type="text/javascript" src="http://ditu.google.cn/maps/api/js?sensor=false"></script>
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand_maps/tpl/default/sanree_brand_maps.css">
<div class="sanree_brand_maps" id="sanreemap">
  <div id="pt" class="bm cl">
    <div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$modelurl}">{$maintitle}</a>$navigation </div>
  </div>
  <div class="jtop">
    <div class="sort">
      <ul>
        <li class="opt {$orderclass[ordertime]}"><a href="{$orderurl1}">{lang sanree_brand_maps:orderdefault}</a></li>
        <li class="opt {$orderclass[orderview]}"><a href="{$orderurl2}">{lang sanree_brand_maps:ordertime}</a></li>
        <li class="opt {$orderclass[orderrecommend]}"><a href="{$orderurl3}">{lang sanree_brand_maps:orderrecommend}</a></li>
        <li class="opt {$orderclass[orderdiscount]}"><a href="{$orderurl4}">{lang sanree_brand_maps:orderdiscount}</a></li>
        <li class="opt {$orderclass[orderclick]}"><a href="{$orderurl5}">{lang sanree_brand_maps:orderclick}</a></li>
        <li class="opt {$orderclass[orderexponent]}"><a href="{$orderurl6}">{lang sanree_brand_maps:orderexponent}</a></li>
		<li id="catebtn" class="cata_show" onclick="hiden_cata()">{lang sanree_brand_maps:hidden}</li>
        <li class="nsearch">

        </li>
      </ul>
    </div>
    <!--/sort-->
    <div id="cata" class="cata">
      <ul>
        <!--{loop $category_list $cate}-->
        <li{$cate[class]}><a href="{$cate[url]}">{$cate[name]}</a>
        </li>
        <!--{/loop}-->
      </ul>
    </div>
    <!--/cata-->
  </div>
  <!--/jtop-->
  <div class="mapsmain" id="mapsmain">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="270" valign="top" id="tdshowInfo">
    <div class="showInfo" id="showInfo">
      <div class="hd">{lang sanree_brand_maps:brandliststr}</div>
      <div class="infolist" id="infolist">
        <!--{loop $fbusinesses_list $cate}-->
        <dl vk="{$cate[index]}" style="cursor:pointer" title="{lang sanree_brand_maps:clicktip1}">
          <dt>{$cate[code]}</dt>
          <dd>
            <div class="t"><a target="_blank" href="{$cate[turl]}" onclick="return false;">{$cate[name]}</a></div>
            <div class="nline">{lang sanree_brand_maps:catename}<span class="catename">{$cate[catename]}</span></div>
            <div class="nline">{lang sanree_brand_maps:tel}<span class="tel">{$cate[tel]}</span></div>
            <div class="nline">{lang sanree_brand_maps:address}<span class="address">{$cate[address]}</span></div>
          </dd>
        </dl>
        <!--{/loop}-->
        <div class="showpage">{$multi}</div>
      </div>
    </div>	
	</td>  
    <td width="*" height="670" valign="top">
		<div class="mapsleft">
		<div class="mapbar">
		<div style="float:left; width:380px;">
          <form method="post" id="searchby" action="plugin.php?id=sanree_brand_maps">
            <div class="searchbar">
              <input type="text" value="{$defaultkeyword}"  onclick="setthis(this)" name="keyword" align="absmiddle" class="ninputtxt" />
              <button class="mmsearchbtn" onclick="$('searchby').submit()"></button>
            </div>
          </form>	
		</div>	
		<ul>
		<li><a onclick="quanifolist()" id="quanbtn" >{lang sanree_brand_maps:fullscreen}</a></li>
		<li><a onclick="hideinfolist()" id="zhanbtn" >{lang sanree_brand_maps:hiddenlist}</a></li>
		</ul>
		</div>
		<div id="mapshow"></div>
	</div>
	</td>
  </tr>
</table>



  </div>
</div>
<div class="clearmaps"></div>
<script  type="text/javascript">
var LatLngArray = [{$mapposliststr}];
var showMsg=[{$infoliststr}];
sanree_jQuery(function() {
	sanree_jQuery("#sanreemap").sanree_googlemap({'defaultmappos':'{$defaultmappos}','defaultcity':'{$defaultcity}','LatLngArray':LatLngArray,'showMsg':showMsg});
});
</script>
{subtemplate common/footer} 
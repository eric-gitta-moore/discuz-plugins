<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{template common/header}-->
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand_coupon/tpl/default/sanree_brand_coupon.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand_coupon/tpl/default/home.css?{VERHASH}" />
<style type="text/css">
.skin1{
font-family:"{lang sanree_brand_coupon:weiruanyahei}";
}
</style>
<div id="pt" class="bm cl">
  <div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em> <a href="{$modelurl}">{$config['title']}</a>$navigation </div>
</div>
<div class="userbody cl skin{$defaultskin}">
  <div class="user_left">
    <div class="stbn">
      <h2 class="smt">{lang sanree_brand_coupon:memberscoupon}</h2>
      <ul>  
        <li$actives[list]><a href="plugin.php?id=sanree_brand_coupon&mod=members&st=all">{lang sanree_brand_coupon:memberscoupon}</a>
        </li>
      </ul>
    </div>
  </div>
  <div class="user_right cl">
    <div class="stbmu cl">  
      <ul class="stb cl">
        <li $stactives[all]><a href="plugin.php?id=sanree_brand_coupon&mod=members&st=all">{lang sanree_brand_coupon:members_all}({$ordercount[all]})</a></li>
        <li $stactives[default]><a href="plugin.php?id=sanree_brand_coupon&mod=members&st=default">{lang sanree_brand_coupon:members_default}({$ordercount[default]})</a></li>
        <li $stactives[use]><a href="plugin.php?id=sanree_brand_coupon&mod=members&st=use">{lang sanree_brand_coupon:members_use}({$ordercount[use]})</a></li>
		<li $stactives[get]><a href="plugin.php?id=sanree_brand_coupon&mod=members&st=get">{lang sanree_brand_coupon:members_get}({$ordercount[get]})</a></li>
      </ul>
      <table cellspacing="0" cellpadding="0" class="sdt">
        <tr>
		  <th class="namec">{lang sanree_brand_coupon:printcode}</th>
          <th class="namec">{lang sanree_brand_coupon:orders_name}</th>
          <th class="ncenter" width="300">{lang sanree_brand_coupon:buytime}</th>
          <th class="ncenter" width="116">{lang sanree_brand_coupon:status}</th>
          <!--{if $isrebate==1}--><th class="ncenter" width="100">{lang sanree_brand_coupon:operation}</th><!--{/if}-->
        </tr>
        <!--{loop $classarr $classid $classname}-->
        <tr>
		  <td class="ncenter">$classname['printcode']</td>
          <td><div class="mgoodsname"><p><a href="{$classname[turl]}" title="{$classname['name']}">{$classname['name']}</a></p></div></td>
          <td class="ncenter">$classname['dateline']</td>		  
          <td class="ncenter"><span>{$classname['statusstr']}</span></td>
          <!--{if $isrebate==1}-->
		  <td class="ncenter">
			  <!--{if $classname['status']==1}--><a href="plugin.php?id=sanree_brand_coupon&mod=mycoupon&view=getreward&tid={$classname['printlogid']}" id="getrewarddlg" onclick="showWindow(this.id, this.href, 'get', 1)">{lang sanree_brand_coupon:getreward}</a>
			  <!--{else}-->
			  -
			  <!--{/if}-->
		  </td>
		  <!--{/if}-->
        </tr>
        <!--{/loop}-->
      </table>
    </div>
    <!--{if $count}-->
    <!--{if $multi}-->
    <div class="pgs cl mtm">$multi</div>
    <!--{/if}-->
    <!--{else}-->
    <!--{if $st=='all'}-->
    <div class="emp">{lang sanree_brand_coupon:no_related}</div>
    <!--{/if}-->
    <!--{/if}-->
  </div>
</div>
<!--{template common/footer}-->
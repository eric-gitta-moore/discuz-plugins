<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{if $_G['inajax']==1}-->

{template common/header_ajax}
<!--{else}-->
{subtemplate common/header}
<!--{/if}-->
<h3 class="flb mn sr"><em>{$config_title}</em> <span>
  <!--{if $_G['inajax']}-->
  <a href="javascript:;" class="flbc" onclick="hideWindow('brandconfigdlg', 0, 1);" title="{lang close}">{lang close}</a>
  <!--{/if}-->
  </span> </h3>
<table width="700" height="490" border="0">
  <tr>
    <td width="150" valign="top">
	<ul class="configmenu">
        <li id="menu_config"><a href="javascript:void(0)" onclick="menushow('config')">{lang sanree_brand:baseconfig}</a></li>
        <li id="menu_banner"><a href="javascript:void(0)" onclick="menushow('banner')">{lang sanree_brand:bannerconfig}</a></li>
		<li id="menu_weixin"><a href="javascript:void(0)" onclick="menushow('weixin')">{lang sanree_brand:weixinconfig}</a></li>
		<!--{if $allowtemplate==1}--><li id="menu_body"><a href="javascript:void(0)" onclick="menushow('body')">{lang sanree_brand:bodyconfig}</a></li><!--{/if}-->
     	<!--{if $group[ismf]}--><li id="menu_mf"><a href="javascript:void(0)" onclick="menushow('mf')">{lang sanree_brand:mf}</a></li><!--{/if}-->
        <!--{if $group[istag]}--><li id="menu_tag"><a href="javascript:void(0)" onclick="menushow('tag')">{lang sanree_brand:tag}</a></li><!--{/if}-->
		<!--{if $_G['cache']['plugin']['sanree_we']['is_zg']}--><li id="menu_wezgimg"><a href="javascript:void(0)" onclick="menushow('wezgimg')">{lang sanree_brand:wezgimgbanner}</a></li><!--{/if}-->
     </ul></td>
    <td valign="top">
      <div id="brandconfig" class="brandconfig"></div>
      <script language="javascript" reload="1">
	  var dstyle = 'url(../../../../../static/image/admincp/bg_repno.gif) #FFFFFF no-repeat 10px -40px';
	  var onstyle = 'url(../../../../../static/image/admincp/newwin.gif) #E8F0F7 no-repeat 5px 5px';
	  function resetback() {
		  $('menu_config').style.background= dstyle;
		  $('menu_banner').style.background= dstyle;
		  $('menu_weixin').style.background= dstyle;
		  <!--{if $allowtemplate==1}-->$('menu_body').style.background= dstyle;<!--{/if}-->
		  $('menu_mf').style.background= dstyle;
		  $('menu_tag').style.background= dstyle;
	  }
	  function menushow(dostr) {
			var url = 'plugin.php?id=sanree_brand&mod=brandconfig&do='+dostr+'&bid={$bid}';
			ajaxget(url, 'brandconfig');
			resetback();
			if ($('menu_'+dostr)) {
				$('menu_'+dostr).style.background= onstyle;
			}
	  }
	  menushow('{$dostr}')
	  </script>		
	</td>
  </tr>
</table>
<!--{if $_G['inajax']==1}-->
{template common/footer_ajax}
<!--{else}-->
{subtemplate common/footer}
<!--{/if}-->
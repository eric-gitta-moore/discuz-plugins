<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{if $_GET['op'] == 'ignore'}-->
<div class="n5sq_ztds cl">
	<div class="ztds_mbxx cl">
		<p class="mbxx_yhm" id="return_$_GET[handlekey]">{lang shield_notice}</p>
		<p>{lang no_view_notice_next}</p>
		<a href="javascript:;" onclick="popup.close();" class="ztds_gbck"></a>
	</div>
	<div class="n5gr_pbtx cl">
	<form method="post" autocomplete="off" id="ignoreform_{$formid}" name="ignoreform_{$formid}" action="home.php?mod=spacecp&ac=common&op=ignore&type=$type" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<input type="hidden" name="ignoresubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="referer" value="{echo dreferer()}">
		<p class="ptn"><label><input type="radio" name="authorid" id="authorid1" value="$_GET[authorid]" checked="checked" />{lang shield_this_friend}</label></p>
		<p class="ptn"><label><input type="radio" name="authorid" id="authorid0" value="0" />{lang shield_all_friend}</label></p>
		<div class="pns">
			<button type="submit" name="feedignoresubmit" value="true" class="pn">{lang determine}</button>
		</div>
	</form>
	</div>
</div>
<!--{elseif $_GET['op'] == 'getuserapp'}-->
	<!--{loop $my_userapp $value}-->
	<!--{if $value['allowsidenav']}-->
	<li><!--{if $value[appstatus]}--><span class="{if $value[appstatus]==1}appnew{else}apphot{/if}"></span><!--{/if}--><a href="userapp.php?mod=app&id=$value[appid]"><img {if $value[icon]}src="$value[icon]" onerror="this.onerror=null;this.src='http://appicon.manyou.com/icons/$value[appid]'"{else} src="http://appicon.manyou.com/icons/$value[appid]"{/if}>$value[appname]</a></li>
	<!--{/if}-->
	<!--{/loop}-->
<!--{elseif $_GET['op']=='modifyunitprice'}-->
	<h3 class="flb">
		<em id="return_$_GET[handlekey]">{lang modify_unitprice}</em>
		<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
	</h3>
	<form method="post" autocomplete="off" id="ignoreform_{$formid}" name="ignoreform_{$formid}" action="home.php?mod=spacecp&ac=common&op=modifyunitprice" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<input type="hidden" name="modifysubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="referer" value="{echo dreferer()}">
		<div class="c altw">
			<p>{lang modify_unitprice_note}</p>
			<p class="ptn"><label>{lang bid_single_price}: <input type="text" name="unitprice" class="px" value="$showinfo[unitprice]" /></label></p>
		</div>
		<p class="o pns">
			<button type="submit" name="unitpriceysubmit" value="true" class="pn pnc"><strong>{lang determine}</strong></button>
		</p>
	</form>
	<script type="text/javascript">
		function succeedhandle_$_GET['handlekey'] (url, message, values) {
			var priceObj = $('show_unitprice');
			if(priceObj) {
				priceObj.innerHTML = values['unitprice'];
			}
		}
	</script>
<!--{/if}-->
<!--{template common/footer}-->
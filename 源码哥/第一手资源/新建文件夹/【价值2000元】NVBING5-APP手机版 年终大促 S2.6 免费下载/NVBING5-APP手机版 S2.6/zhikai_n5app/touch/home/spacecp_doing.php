<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{if $_GET['op'] == 'delete'}-->
<div class="tip">
	<form method="post" autocomplete="off" id="doingform_{$doid}_{$id}" name="doingform" action="home.php?mod=spacecp&ac=doing&op=delete&doid=$doid&id=$id">
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<dt>{lang determine_delete_doing}</dt>
		<dd>
			<button name="deletesubmit" type="submit" class="pn pnc" value="true">{lang determine}</button>
			<a href="javascript:;" onclick="popup.close();">{$n5app['lang']['sqbzssmqx']}</a>
		</dd>
	</form>
</div>
<!--{elseif $_GET['op'] == 'spacenote'}-->
	<!--{if $space[spacenote]}-->$space[spacenote]<!--{/if}-->
<!--{elseif $_GET['op'] == 'docomment' || $_GET['op'] == 'getcomment'}-->
	<!--{if helper_access::check_module('doing')}-->
	<div id="{$_GET[key]}_form_{$doid}_{$id}" class="n5sq_dpys cl">
		<form id="{$_GET[key]}_docommform_{$doid}_{$id}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=doing&op=comment&doid=$doid&id=$id" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if} class="n5sq_lcdp">
			<textarea name="message" id="{$_GET[key]}_form_{$doid}_{$id}_t" cols="40" class="pt" oninput="resizeTx(this);" onpropertychange="resizeTx(this);" onkeyup="strLenCalc(this, '{$_GET[key]}_form_{$doid}_{$id}_limit')" onkeydown="ctrlEnter(event, '{$_GET[key]}_replybtn_{$doid}_{$id}');"></textarea>&nbsp;
			<input type="hidden" name="commentsubmit" value="true" />
			<div class="o pns cl">
				<button type="submit" name="do_button" id="{$_GET[key]}_replybtn_{$doid}_{$id}" class="pn z" value="true"><em>{lang reply}</em></button>
				<a href="javascript:;" onclick="popup.close();" class="z">{$n5app['lang']['sqbzssmqx']}</a>
			</div>
			<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
			<input type="hidden" name="formhash" value="{FORMHASH}" />
		</form>
		<span id="return_$_GET[handlekey]"></span>
	</div>
	<script type="text/javascript">
		function succeedhandle_$_GET[handlekey](url, msg, values) {
			docomment_get(values['doid'], '$_GET[key]');
		}
	</script>
	<!--{/if}-->
	<!--{if $_GET['op'] == 'getcomment'}-->
		<!--{template home/space_doing_li}-->
	<!--{/if}-->
<!--{else}-->
<div id="content">
	<!--{if helper_access::check_module('doing')}-->
	<!--{template home/space_doing_form}-->
	<!--{/if}-->
</div>
<!--{/if}-->
<!--{template common/footer}-->
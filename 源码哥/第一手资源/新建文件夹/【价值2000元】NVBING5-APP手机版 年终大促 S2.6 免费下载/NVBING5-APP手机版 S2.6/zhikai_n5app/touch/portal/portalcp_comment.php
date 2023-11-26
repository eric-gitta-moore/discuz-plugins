<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{if $_GET['op'] == 'requote'}-->
	[quote]{$comment[username]}: {$comment[message]}[/quote]

<!--{elseif $_GET['op'] == 'edit'}-->
<div class="n5sq_dpys cl">
	<form class="n5sq_lcdp" id="editcommentform_{$cid}" name="editcommentform_{$cid}" method="post" autocomplete="off" action="portal.php?mod=portalcp&ac=comment&op=edit&cid=$cid{if $_GET[modarticlecommentkey]}&modarticlecommentkey=$_GET[modarticlecommentkey]{/if}">
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="editsubmit" value="true" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<style type="text/css">
			.n5sq_lcdp .pt {width: 93%;padding: 3%;}
		</style>
		<div class="c">
			<textarea id="message_{$cid}" name="message" cols="70" onkeydown="ctrlEnter(event, 'editsubmit_btn');" rows="8" class="pt">$comment[message]</textarea>
		</div>
		<p class="o pns">
			<button type="submit" name="editsubmit_btn" id="editsubmit_btn" value="true" class="pn pnc">{lang submit}</button>
		</p>
	</form>

<!--{elseif $_GET['op'] == 'delete'}-->
<div class="tip">
	<form id="deletecommentform_{$cid}" name="deletecommentform_{$cid}" method="post" autocomplete="off" action="portal.php?mod=portalcp&ac=comment&op=delete&cid=$cid">
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="deletesubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<dt>{lang comment_delete_confirm}</dt>
		<dd>
			<button type="submit" name="deletesubmitbtn" value="true" class="formdialog button2">{lang confirms}</button>
			<a href="javascript:;" onclick="popup.close();">{$n5app['lang']['sqbzssmqx']}</a>
		</dd>
	</form>
</div>
<!--{/if}-->

<!--{template common/footer}-->
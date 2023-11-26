<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{if $_GET['op'] == 'edit'}-->
<div class="n5sq_dpys cl">
	<form class="n5sq_lcdp" id="editcommentform_{$cid}" name="editcommentform_{$cid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=comment&op=edit&cid=$cid{if $_GET[modcommentkey]}&modcommentkey=$_GET[modcommentkey]{/if}" {if $_G[inajax]} onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="editsubmit" value="true" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<style type="text/css">
			.n5sq_lcdp .pt {width: 93%;padding: 3%;}
		</style>
		<textarea id="message_{$cid}" name="message" cols="70" onkeydown="ctrlEnter(event, 'editsubmit_btn');" rows="8" class="pt mtn">$comment[message]</textarea>
		<p class="o pns">
			<button type="submit" name="editsubmit_btn" id="editsubmit_btn" value="true" class="pn pnc">{lang submit}</button>
		</p>
	</form>
</div>
<!--{elseif $_GET['op'] == 'delete'}-->
<div class="tip">
	<form id="deletecommentform_{$cid}" name="deletecommentform_{$cid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=comment&op=delete&cid=$cid" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="deletesubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<dt>{lang delete_reply_message}</dt>
		<dd>
			<button type="submit" name="deletesubmitbtn" value="true" class="formdialog button2">{lang determine}</button>
			<a href="javascript:;" onclick="popup.close();">{$n5app['lang']['sqbzssmqx']}</a>
		</dd>
	</form>
</div>
<!--{elseif $_GET['op'] == 'reply'}-->
<div class="n5sq_dpys cl">
	<form  class="n5sq_lcdp" id="replycommentform_{$comment[cid]}" name="replycommentform_{$comment[cid]}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=comment" {if $_G[inajax]} onsubmit="ajaxpost('replycommentform_{$comment[cid]}', 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="id" value="$comment[id]" />
		<input type="hidden" name="idtype" value="$comment[idtype]" />
		<input type="hidden" name="cid" value="$comment[cid]" />
		<input type="hidden" name="commentsubmit" value="true" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<style type="text/css">
			.n5sq_lcdp .pt {width: 93%;padding: 3%;}
			.n5sq_ftyzm {margin: 5px 0 0 0;}
		</style>
		<div id="reply_msg_{$comment[cid]}">
			<textarea id="message_pop_{$comment[cid]}" name="message" onkeydown="ctrlEnter(event, 'commentsubmit_btn');" rows="8" cols="70" class="pt"></textarea>
			<!--{if $secqaacheck || $seccodecheck}-->
				<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu({'ctrlid':this.id,'win':'{$_GET[handlekey]}'});"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
				<div class="mbm"><!--{subtemplate common/seccheck}--></div>
			<!--{/if}-->
			<p class="o pns">
				<button type="submit" name="commentsubmit_btn" id="commentsubmit_btn" value="true" class="pn pnc">{lang reply}</button>
			</p>
		</div>
	</form>
</div>
<!--{/if}-->
<!--{template common/footer}-->
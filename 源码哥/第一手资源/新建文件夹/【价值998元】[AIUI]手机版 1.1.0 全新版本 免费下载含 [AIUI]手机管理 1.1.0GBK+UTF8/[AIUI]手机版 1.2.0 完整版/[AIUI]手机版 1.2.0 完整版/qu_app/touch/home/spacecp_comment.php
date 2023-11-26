<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<!--{if $_GET['op'] == 'edit'}-->
<div class="ainuo_pop cl">
	<div class="atit cl">{lang edit}</div>
	<form id="editcommentform_{$cid}" name="editcommentform_{$cid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=comment&op=edit&cid=$cid{if $_GET[modcommentkey]}&modcommentkey=$_GET[modcommentkey]{/if}" {if $_G[inajax]} onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="editsubmit" value="true" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<div class="acon">
			<p>
				<label for="message">{lang edit_content}:</label>
				<span id="editface_{$cid}" onclick="showFace(this.id, 'message_{$cid}');return false;" class="cur1"><img src="{IMGDIR}/facelist.gif" alt="facelist" class="vm" /></span>
			</p>
			<textarea id="message_{$cid}" name="message" onkeydown="ctrlEnter(event, 'editsubmit_btn');" rows="4" class="px">$comment[message]</textarea>
		</div>
        <div class="ainuo_popbottom cl">
            <button type="submit" name="editsubmit_btn" id="editsubmit_btn" value="true" class="formdialog aconfirm">{lang submit}</button>
            <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
        </div>
	</form>
	<script type="text/javascript">
		function succeedhandle_$_GET['handlekey'] (url, message, values) {
			comment_edit(values['cid']);
		}
	</script>
</div>
<!--{elseif $_GET['op'] == 'delete'}-->
<div class="ainuo_pop cl">
	<div class="atit cl">{lang delete_reply}</div>
	<form id="deletecommentform_{$cid}" name="deletecommentform_{$cid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=comment&op=delete&cid=$cid" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="deletesubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<div class="acon cl">{lang delete_reply_message}</div>
        <div class="ainuo_popbottom cl">
            <button type="submit" name="deletesubmitbtn" value="true" class="formdialog aconfirm">{lang determine}</button>
            <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
        </div>
	</form>
	<script type="text/javascript">
		function succeedhandle_$_GET['handlekey'] (url, message, values) {
			comment_delete(values['cid']);
			
		}
	</script>
</div>
<!--{elseif $_GET['op'] == 'reply'}-->

<div class="ainuo_pop cl">
	<div class="atit cl">{lang reply}</div>
	<form id="replycommentform_{$comment[cid]}" name="replycommentform_{$comment[cid]}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=comment" {if $_G[inajax]} onsubmit="ajaxpost('replycommentform_{$comment[cid]}', 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="id" value="$comment[id]" />
		<input type="hidden" name="idtype" value="$comment[idtype]" />
		<input type="hidden" name="cid" value="$comment[cid]" />
		<input type="hidden" name="commentsubmit" value="true" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<div id="reply_msg_{$comment[cid]}" class="cl">
			<div class="acon cl">
				<p>
					<!--{if $_G['setting']['magicstatus'] && !empty($_G['setting']['magics']['doodle'])}-->
					<span id="editdoodle_{$cid}" onclick="showWindow(this.id, 'home.php?mod=magic&mid=doodle&showid=comment_doodle&target=message_pop_{$comment[cid]}', 'get', 0)" class="cur1"><img src="{STATICURL}image/magic/doodle.small.gif" alt="doodle" class="vm" />{$_G[setting][magics][doodle]}</span>
					<!--{/if}-->
				</p>
				<textarea id="message_pop_{$comment[cid]}" name="message" onkeydown="ctrlEnter(event, 'commentsubmit_btn');" rows="4" class="px" style="width:200px;"></textarea>
				<!--{if $secqaacheck || $seccodecheck}-->
					<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu({'ctrlid':this.id,'win':'{$_GET[handlekey]}'});"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
					<div class="mtm mbm"><!--{subtemplate common/seccheck}--></div>
				<!--{/if}-->
			</div>
            <div class="ainuo_popbottom cl">
               <button type="submit" name="commentsubmit_btn" id="commentsubmit_btn" value="true" class="formdialog aconfirm">{lang reply}</button>
                <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
            </div>
		</div>
	</form>
	<script type="text/javascript">
		function succeedhandle_$_GET['handlekey'] (url, message, values) {
			<!--{if $comment['idtype']!='uid'}-->
				<!--{if $_GET['feedid']}-->
					feedcomment_add(values['cid'], $_GET['feedid']);
				<!--{else}-->
					comment_add(values['cid']);
				<!--{/if}-->
			<!--{/if}-->
		}
	</script>
</div>
<!--{/if}-->

<!--{template common/footer}-->

<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!--{eval $mysiteBM = currentlang()}-->
<!--{eval require_once(DISCUZ_ROOT."./template/qu_app/touch/ainuo/lang/$mysiteBM.php");}-->
<!--{if $op == 'bkname'}-->
<div class="ainuo_pop cl">
	<div class="atit cl">{lang follow_for}$followuser['fusername']{lang follow_add_bkname}</div>
	<!--{if !submitcheck('editbkname')}-->
	<form method="post" autocomplete="off" id="bknameform_{$_GET[handlekey]}" name="bknameform_{$_GET[handlekey]}" action="home.php?mod=spacecp&ac=follow&op=bkname&fuid=$followuser['followuid']" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="editbkname" value="true" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<div class="acon cl">
            <input type="text" name="bkname" value="$followuser['bkname']" class="px" placeholder="{lang follow_editnote}"  onkeydown="ctrlEnter(event, 'editsubmit_btn');" />
		</div>
        <div class="ainuo_popbottom cl">
            <button type="submit" name="editsubmit_btn" id="editsubmit_btn" value="true" class="formdialog aconfirm">{lang save}</button>
            <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
        </div>
	</form>
</a>
	<!--{/if}-->
	<script type="text/javascript" reload="1">
		function succeedhandle_$_GET[handlekey](url, msg, values) {
			$('$_GET[handlekey]').innerHTML = values['bkname'];
			$('fbkname_$followuser[followuid]').innerHTML = values['btnstr'];
		}
	</script>
<!--{elseif $op == 'relay'}-->
<div class="ainuo_pop cl">
	
	<!--{if $_GET['from'] == 'forum'}-->
	<div class="atit cl">{lang follow_reply}</div>
		<form method="post" autocomplete="off" id="relayform_{$tid}" name="relayform_{$tid}" action="home.php?mod=spacecp&ac=follow&op=relay&tid=$tid" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
			<input type="hidden" name="relaysubmit" value="true">
			<input type="hidden" name="referer" value="{echo dreferer()}">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="tid" value="$tid" />
			<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
			<div class="acon cl">
				<p>{lang follow_add_note}:</p>
				<textarea id="note_{$tid}" name="note" cols="50" rows="5" class="pt mtn" style="width: 425px;" onkeydown="ctrlEnter(event, 'relaysubmit_btn')" onkeyup="strLenCalc(this, 'checklen{$tid}', 140);"></textarea>
				<!--{if $secqaacheck || $seccodecheck}-->
				<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu({'ctrlid':this.id,'win':'{$_GET[handlekey]}'})"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
				<div class="mtm sec"><!--{subtemplate common/seccheck}--></div>
				<!--{/if}-->
				<br/>{lang follow_can_enter}<span id="checklen{$tid}" class="xg1">140</span>{lang follow_word}
                <label class="lb"><input type="checkbox" name="addnewreply" checked="checked" class="pc" value="1" />{lang post_add_inonetime}</label>
			</div>
            <div class="ainuo_popbottom cl">
            	<button type="submit" name="relaysubmit_btn" id="relaysubmit_btn" class="formdialog aconfirm" value="true">{lang determine}</button>
                
                <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
            </div>
		</form>
		<script type="text/javascript">
			function succeedhandle_$_GET['handlekey'](url, message, param) {
				<!--{if $fastpost}-->
					succeedhandle_fastpost(url, message, param);
				<!--{/if}-->
				popup.open('$alang_successzb','wxtip');
			}
		</script>
	<!--{else}-->
    <div class="atit cl">{lang follow_reply}</div>
		<form method="post" autocomplete="off" id="postform_{$tid}" action="home.php?mod=spacecp&ac=follow&op=relay&tid=$tid" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
			<input type="hidden" name="relaysubmit" value="true">
			<input type="hidden" name="referer" value="{echo dreferer()}">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="tid" value="$tid" />
			<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
			<div class="acon cl">
            	<div class="flw_autopt cl">
            		<textarea id="note_{$tid}" name="note" class="px" cols="30" rows="4" onkeyup="resizeTx(this);strLenCalc(this, 'checklen{$tid}', 140);" onkeydown="resizeTx(this);" onpropertychange="resizeTx(this);" placeholder="$alang_xsds" oninput="resizeTx(this);"></textarea>
                </div>
                <label><input type="checkbox" name="addnewreply" class="pc" value="1" checked="checked" />{lang post_add_inonetime}</label>
            </div>

			<!--{if $secqaacheck || $seccodecheck}-->
			<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu({'ctrlid':this.id,'win':'{$_GET[handlekey]}'})"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
			<div class="mtm sec"><!--{subtemplate common/seccheck}--></div>
			<!--{/if}-->
			<div id="return_$_GET[handlekey]"></div>
            
            
            
            <div class="ainuo_popbottom cl">
                <button type="submit" name="relaysubmit_btn" id="relaysubmit_btn" class="formdialog aconfirm" value="true" name="{if $_GET[action] == 'newthread'}topicsubmit{elseif $_GET[action] == 'reply'}replysubmit{/if}" tabindex="23">{lang follow_reply}</button>
                <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
            </div>
            
		</form>
</div>

		<script type="text/javascript">
			function succeedhandle_$_GET['handlekey'](url, message, values) {
				popup.open('$alang_successzb','wxtip');
			}
		</script>
	<!--{/if}-->
<!--{elseif $op == 'getfeed'}-->
	<!--{if !empty($list)}-->
	<!--{subtemplate home/follow_feed_li}-->
	<!--{else}-->
	false
	<!--{/if}-->
<!--{elseif $op == 'delete'}-->
<div class="ainuo_pop cl">
	<div class="atit cl">{lang follow_del_feed}</div>
	<form method="post" autocomplete="off" id="deletefeed_{$_GET['feedid']}" name="deletefeed_{$_GET['feedid']}" action="home.php?mod=spacecp&ac=follow&op=delete&feedid=$_GET['feedid']" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="deletesubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<div class="acon cl">{lang follow_del_feed_confirm}</div>
        <div class="ainuo_popbottom cl">
            <button type="submit" name="btnsubmit" value="true" class="formdialog aconfirm">{lang determine}</button>
            <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
        </div>
	</form>
</div>
	<script type="text/javascript">
		function succeedhandle_{$_GET[handlekey]}(url, msg, values) {
			document.getElementById('feed_li_'+values.feedid).style.display = 'none';

		}
	</script>
<!--{/if}-->

<!--{template common/footer}-->
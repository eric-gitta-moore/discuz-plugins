<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{if $op == 'bkname'}-->
<div class="n5sq_jwhy">
	<a href="javascript:;" onclick="popup.close();" class="ztds_gbck"></a>
	<div class="ztds_mbxx cl">
		<!--{avatar($followuser['followuid'],middle)}-->
		<p class="mbxx_yhm">$followuser['fusername']</p>
		<p>{lang follow_for}$followuser['fusername']{lang follow_add_bkname}</p>
	</div>
	<!--{if !submitcheck('editbkname')}-->
	<form method="post" autocomplete="off" id="bknameform_{$_GET[handlekey]}" name="bknameform_{$_GET[handlekey]}" action="home.php?mod=spacecp&ac=follow&op=bkname&fuid=$followuser['followuid']" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="editbkname" value="true" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<input type="hidden" name="formhash" value="{FORMHASH}" /><!--From  www. xhkj5.com-->
		<div class="ztds_dsys">
			<div class="jwhy_hyxm cl">
				<div class="hyxm_xmbt z">{lang follow_editnote}</div>
				<div class="hyxm_xmnr z"><input type="text" name="bkname" value="$followuser['bkname']" size="35" class="px"  onkeydown="ctrlEnter(event, 'editsubmit_btn');" /></div>
			</div>
		</div>
		<button type="submit" name="editsubmit_btn" id="editsubmit_btn" value="true" class="pn">{lang save}</button>
	</form>
	<!--{/if}-->
</div>
<!--{elseif $op == 'relay'}-->
	<!--{if $_GET['from'] == 'forum'}-->
		<h3 class="flb">
			<em id="return_$_GET[handlekey]">{lang follow_reply}</em>
			<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
		</h3>
		<form method="post" autocomplete="off" id="relayform_{$tid}" name="relayform_{$tid}" action="home.php?mod=spacecp&ac=follow&op=relay&tid=$tid" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
			<input type="hidden" name="relaysubmit" value="true">
			<input type="hidden" name="referer" value="{echo dreferer()}">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="tid" value="$tid" />
			<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
			<div class="c">
				<p>{lang follow_add_note}:</p>
				<textarea id="note_{$tid}" name="note" cols="50" rows="5" class="pt mtn" style="width: 425px;" onkeydown="ctrlEnter(event, 'relaysubmit_btn')" onkeyup="strLenCalc(this, 'checklen{$tid}', 140);"></textarea>
				<!--{if $secqaacheck || $seccodecheck}-->
				<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu({'ctrlid':this.id,'win':'{$_GET[handlekey]}'})"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
				<div class="mtm sec"><!--{subtemplate common/seccheck}--></div>
				<!--{/if}-->
				<br/>{lang follow_can_enter}<span id="checklen{$tid}" class="xg1">140</span>{lang follow_word}
			</div>
			<p class="o pns">
				<label class="lb"><input type="checkbox" name="addnewreply" checked="checked" class="pc" value="1" />{lang post_add_inonetime}</label>
				<button type="submit" name="relaysubmit_btn" id="relaysubmit_btn" class="pn pnc" value="true"><strong>{lang determine}</strong></button>
			</p>
		</form>
		<script type="text/javascript">
			$('note_{$tid}').focus();
			function succeedhandle_$_GET['handlekey'](url, message, param) {
				<!--{if $fastpost}-->
					succeedhandle_fastpost(url, message, param);
				<!--{/if}-->
				hideWindow('$_GET[handlekey]');
				showCreditPrompt();
			}
		</script>
	<!--{else}-->
	<div class="n5ht_htzb cl"><!--From www.ymg6.co m-->
		<form method="post" autocomplete="off" id="postform_{$tid}" action="home.php?mod=spacecp&ac=follow&op=relay&tid=$tid" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
			<input type="hidden" name="relaysubmit" value="true">
			<input type="hidden" name="referer" value="{echo dreferer()}">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="tid" value="$tid" />
			<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				<textarea id="note_{$tid}" name="note" class="pt" cols="80" rows="4" onkeyup="resizeTx(this);strLenCalc(this, 'checklen{$tid}', 140);" onkeydown="resizeTx(this);" onpropertychange="resizeTx(this);" oninput="resizeTx(this);"></textarea>
				<!--{if $secqaacheck || $seccodecheck}-->
					<style type="text/css">
						.n5sq_ftyzm {margin: 0;border: 1px solid #EBEBEB;margin-bottom:10px;}
					</style>
					<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu({'ctrlid':this.id,'win':'{$_GET[handlekey]}'})"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
					<!--{subtemplate common/seccheck}-->
				<!--{/if}-->
				<button type="submit" name="relaysubmit_btn" id="relaysubmit_btn" class="pn z" value="true" name="{if $_GET[action] == 'newthread'}topicsubmit{elseif $_GET[action] == 'reply'}replysubmit{/if}" tabindex="23">{lang follow_reply}</button>
				<a href="javascript:;" onclick="display('relaybox_{$_GET['feedid']}')" class="htzb_qxzb z">{$n5app['lang']['sqbzssmqx']}</a>
				<span class="y htzb_sfhf">
					<i>{lang post_add_inonetime}</i><input type="checkbox" name="addnewreply" class="pc" value="1" id="sendreasonpm" checked="checked" /><label for="sendreasonpm" id="sendreasonpm" class="y"></label>
				</span>
			<div id="return_$_GET[handlekey]"></div>
		</form>
	</div>
	<!--{/if}-->
<!--{elseif $op == 'getfeed'}-->
	<!--{if !empty($list)}-->
	<!--{subtemplate home/follow_feed_li}-->
	<!--{else}-->
	false
	<!--{/if}-->
<!--{elseif $op == 'delete'}-->
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<span>{$n5app['lang']['htschttss']}</span>
</div>
{/if}
<style type="text/css">
.jump_c a {background: #C7C7C7;}
</style>
<div class="jump_c">
	<div class="n5qj_tstp"></div>
	<p class="tsnrs">{lang follow_del_feed_confirm}</p>
	<form method="post" autocomplete="off" id="deletefeed_{$_GET['feedid']}" name="deletefeed_{$_GET['feedid']}" action="home.php?mod=spacecp&ac=follow&op=delete&feedid=$_GET['feedid']" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="deletesubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<dd>
			<button type="submit" name="btnsubmit" value="true" class="pn">{lang determine}</button>
			<a href="javascript:history.back();" >{$n5app['lang']['sqbzssmqx']}</a>
		</dd>
	</form>
</div>
<!--{/if}-->
<!--{template common/footer}-->
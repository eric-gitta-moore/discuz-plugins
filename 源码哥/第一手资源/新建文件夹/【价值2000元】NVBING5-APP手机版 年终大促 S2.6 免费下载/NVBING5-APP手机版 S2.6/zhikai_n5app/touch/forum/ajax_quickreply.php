<?php exit;?>
<!--{template common/header_ajax}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./template/zhikai_n5app/lang.php';}-->
<div class="n5ht_htzb cl">
	<form method="post" autocomplete="off" id="postform_{$_GET['feedid']}" action="forum.php?mod=post&action=reply&fid=$_GET[fid]&extra=$extra&tid=$_GET[tid]&replysubmit=yes" onsubmit="this.message.value = parseurl(this.message.value);{if !empty($_GET['inajax'])}ajaxpost(this.id, 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;{/if}" class="mbm">
	<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
	<input type="hidden" name="handlekey" value="$_GET['handlekey']" />
	<span id="subjectbox" style="display: none;"><input name="subject" id="subject" class="px" value="" tabindex="21" style="width: 25em" /></span><!--Fro m www.xhkj 5.com-->
	
	<textarea name="message" id="postmessage_{$_GET[tid]}_{$_GET['feedid']}" class="pt" cols="80" rows="4" onkeyup="resizeTx(this);" onkeydown="resizeTx(this);" onpropertychange="resizeTx(this);" oninput="resizeTx(this);"></textarea>
	<!--{if $secqaacheck || $seccodecheck}-->
		<style type="text/css">
			.n5sq_ftyzm {margin: 0;border: 1px solid #EBEBEB;margin-bottom:10px;}
		</style>
		<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu({'ctrlid':this.id,'win':'{$_GET[handlekey]}'})"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
		<!--{subtemplate common/seccheck}-->
	<!--{/if}-->
	<button type="submit" id="postsubmit" class="pn z" value="true" name="{if $_GET[action] == 'newthread'}topicsubmit{elseif $_GET[action] == 'reply'}replysubmit{/if}" tabindex="23">{lang reply}</button>
	<a href="javascript:;" onclick="display('replybox_{$_GET['feedid']}')" class="htzb_qxzb z">{$n5app['lang']['sqbzssmqx']}</a>
	<span class="y htzb_sfhf">
		<i>{lang post_meanwhile_relay}</i><input type="checkbox" name="adddynamic" class="pr" id="sendreasonpma" value="1" /><label for="sendreasonpma" id="sendreasonpma" class="y"></label>
	</span>
	</form><!--Fr om www.xhkj 5.com-->
</div>

<div class="n5ht_hthf cl">
	<ul id="newreply_{$_GET[tid]}_{$_GET['feedid']}">
		<!--{loop $list $pid $post}-->
			<li><i><a href="home.php?mod=space&uid=$post['authorid']"><!--{avatar($post['authorid'],'middle')}--></a></i><span><a href="home.php?mod=space&uid=$post['authorid']">$post['author']</a>$post['message']</span></li>
		<!--{/loop}-->
	</ul>
</div>

<!--{template common/footer_ajax}-->
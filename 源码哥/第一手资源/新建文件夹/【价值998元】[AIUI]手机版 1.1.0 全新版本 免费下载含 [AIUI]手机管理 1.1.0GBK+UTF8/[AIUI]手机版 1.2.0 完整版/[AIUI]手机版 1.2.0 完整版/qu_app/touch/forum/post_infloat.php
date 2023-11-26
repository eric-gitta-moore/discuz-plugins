<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<h3 class="flb">
	<em id="return_$_GET['handlekey']">
		<!--{if $_GET[action] == 'newthread'}-->{lang post_newthread}<!--{elseif $_GET[action] == 'reply'}-->{lang join_thread}<!--{/if}-->
	</em>
	<!--{if $_GET[action] == 'newthread' && $modnewthreads}--><span class="needverify">{lang approve}</span><!--{/if}-->
	<!--{if $_GET[action] == 'reply' && $modnewreplies}--><span class="needverify">{lang approve}</span><!--{/if}-->
	<span>
		<a href="javascript:;" class="flbc" onclick="hideWindow('$_GET['handlekey']')" title="{lang close}">{lang close}</a>
	</span>
</h3>

<form method="post" autocomplete="off" id="postform" action="forum.php?mod=post&infloat=yes&action=$_GET[action]&fid=$_G[fid]&extra=$extra{if $_GET[action] == 'newthread'}&topicsubmit=yes{elseif $_GET[action] == 'reply'}&tid=$_G[tid]&replysubmit=yes{/if}" onsubmit="this.message.value = parseurl(this.message.value);{if !empty($_GET['infloat'])}ajaxpost('postform', 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;{/if}">
	<div class="c" id="floatlayout_$_GET[action]">
		<div class="p_c">
			<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
			<input type="hidden" name="handlekey" value="$_GET['handlekey']" />
			<!--{if $_GET[action] == 'reply'}-->
				<input type="hidden" name="noticeauthor" value="$noticeauthor" />
				<input type="hidden" name="noticetrimstr" value="$noticetrimstr" />
				<input type="hidden" name="noticeauthormsg" value="$noticeauthormsg" />
				<input type="hidden" name="usesig" value="{if $_G['group']['maxsigsize']}1{else}0{/if}"/>
				<!--{if $reppid}-->
					<input type="hidden" name="reppid" value="$reppid" />
				<!--{/if}-->
				<!--{if $_GET[reppost]}-->
					<input type="hidden" name="reppost" value="$_GET[reppost]" />
				<!--{elseif $_GET[repquote]}-->
					<input type="hidden" name="reppost" value="$_GET[repquote]" />
				<!--{/if}-->
			<!--{/if}-->
			<!--{hook/post_infloat_top}-->
			

			<!--{if $_GET[action] == 'reply' && $quotemessage}-->
				<div class="pbt cl">$quotemessage</div>
			<!--{/if}-->

			<div class="tedt">
				
				<div class="area">
				<textarea rows="3" cols="28" name="message" id="postmessage" onKeyDown="seditor_ctlent(event, '$(\'postsubmit\').click();')" tabindex="22" class="pt">$message</textarea>
				</div>
			</div>
			<div id="seccheck_$_GET[action]">
				<!--{if $secqaacheck || $seccodecheck}-->
					<!--{subtemplate touch/forum/seccheck_post}-->					
				<!--{/if}-->
			</div>
		</div>
	</div>
	<!--{hook/post_infloat_middle}-->
	<div class="o pns" id="moreconf">
		<button type="submit" id="postsubmit" class="pn pnc z" value="true"{if !$seccodecheck} onmouseover="checkpostrule('seccheck_$_GET[action]', 'ac=$_GET[action]&infloat=yes&handlekey=$_GET[handlekey]');this.onmouseover=null"{/if} name="{if $_GET[action] == 'newthread'}topicsubmit{elseif $_GET[action] == 'reply'}replysubmit{/if}" tabindex="23"><span><!--{if $_GET[action] == 'newthread'}-->{lang post_newthread}<!--{elseif $_GET[action] == 'reply'}-->{lang join_thread}<!--{/if}--></span></button>
		<!--{hook/post_infloat_btn_extra}-->
	</div>
</form>

<script type="text/javascript" reload="1">
function succeedhandle_$_GET[action](locationhref, message) {
	<!--{if $_GET[action] == 'reply'}-->
		try {
			var pid = locationhref.lastIndexOf('#pid');
			if(pid != -1) {
				pid = locationhref.substr(pid + 4);
				ajaxget('forum.php?mod=viewthread&tid=$_G[tid]&viewpid=' + pid<!--{if $_GET['from']}--> + '&from=$_GET[from]'<!--{/if}-->, 'post_new', 'ajaxwaitid', '', null, 'appendreply()');
				if(replyreload) {
					var reloadpids = replyreload.split(',');
					for(i = 1;i < reloadpids.length;i++) {
						ajaxget('forum.php?mod=viewthread&tid=$_G[tid]&viewpid=' + reloadpids[i]<!--{if $_GET['from']}--> + '&from=$_GET[from]'<!--{/if}-->, 'post_' + reloadpids[i]);
					}
				}
			} else {
				showDialog(message, 'notice', '', 'location.href="' + locationhref + '"');
			}
		} catch(e) {
			location.href = locationhref;
		}
	<!--{elseif $_GET[action] == 'newthread'}-->
		var hastid = locationhref.lastIndexOf('tid=');
		if(hastid == -1) {
			showDialog(message, 'notice', '', 'location.href="' + locationhref + '"');
		} else {
			location.href = locationhref;
		}
	<!--{/if}-->
	hideWindow('$_GET[action]');
}
<!--{if $_GET[action] == 'newthread' && $_G['setting']['sitemessage'][newthread] || $_GET[action] == 'reply' && $_G['setting']['sitemessage'][reply]}-->
	showPrompt('custominfo', 'mouseover', '<!--{if $_GET[action] == 'newthread'}--><!--{echo trim($_G['setting']['sitemessage'][newthread][array_rand($_G['setting']['sitemessage'][newthread])])}--><!--{elseif $_GET[action] == 'reply'}--><!--{echo trim($_G['setting']['sitemessage'][reply][array_rand($_G['setting']['sitemessage'][reply])])}--><!--{/if}-->', $_G['setting']['sitemessage'][time]);
<!--{/if}-->

	if($('subjectbox')) {
		$('postmessage').focus();
	} else if($('subject')) {
		$('subject').select();
		$('subject').focus();
	}
</script>

<!--{template common/footer}-->
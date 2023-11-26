<?php exit;?>
<div class="n5sq_xsjj cl">{lang thread_reward}<strong> <span class="xi1 xs3">$rewardprice</span> </strong>{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][title]}
{if $_G['forum_thread']['price'] > 0}<span class="xi1">{lang unresolved}</span>{elseif $_G['forum_thread']['price'] < 0}<span class="xg1">{lang resolved}</span>{/if}
<!--{if $bestpost}--><!--{else}--><a onClick="nryhf()" class="n5sq_wlhd">{$n5app['lang']['sqxuanshanghd']}</a><!--{/if}-->
</div>
	<div id="postmessage_$post[pid]" class="postmessage">$post[message]</div>
<!--{if $post['attachment']}-->
	<div class="n5sq_ztts cl">{lang attachment}: <em><!--{if $_G['uid']}-->{lang attach_nopermission}<!--{else}-->{lang attach_nopermission_login}<!--{/if}--></em></div>
<!--{elseif $post['imagelist'] || $post['attachlist']}-->
    <!--{if $post['imagelist']}-->
         {echo showattach($post, 1)}
    <!--{/if}-->
    <!--{if $post['attachlist']}-->
         {echo showattach($post)}
    <!--{/if}-->
<!--{/if}-->
<!--{eval $post['attachment'] = $post['imagelist'] = $post['attachlist'] = '';}-->
<!--{if $bestpost}-->
	<div class="rwdbst">
		<h3 class="psth">{lang reward_bestanswer}</h3>
		<div class="pstl">
			<div class="psta">$bestpost[avatar]</div>
			<div class="psti">
				<p class="xi2"><a href="home.php?mod=space&uid=$bestpost[authorid]" class="xw1">$bestpost[author]</a> <a href="javascript:;" onclick="window.open('forum.php?mod=redirect&goto=findpost&ptid=$bestpost[tid]&pid=$bestpost[pid]')">{lang view_full_content}</a></p>
				<div class="mtn">$bestpost[message]</div>
			</div><!--Fr om www.xhkj 5.com-->
		</div>
	</div>
<!--{/if}-->
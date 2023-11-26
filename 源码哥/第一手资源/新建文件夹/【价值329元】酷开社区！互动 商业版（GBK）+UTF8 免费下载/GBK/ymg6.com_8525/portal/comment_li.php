<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<a name="comment_anchor_$comment[cid]"></a>
<li class="cl">
    <a href="home.php?mod=space&uid=$comment[uid]" target="_blank">
        <img src="uc_server/avatar.php?uid=$comment[uid]&size=middle" />
    </a>
    <div class="list_pl z">
    	<!--{if $_G['uid']}-->
			<!--{if !isset($_G[makehtml])}--><a class="y" href="javascript:;" onclick="portal_comment_requote($comment[cid], '$article[aid]');">{lang quote}</a> <span class="pipe y">|</span><!--{/if}-->
			<!--{if ($_G['group']['allowmanagearticle'] || $_G['uid'] == $comment['uid']) && $_G['groupid'] != 7 && !$article['idtype']}-->
			<a class="y" href="portal.php?mod=portalcp&ac=comment&op=edit&cid=$comment[cid]" id="c_$comment[cid]_edit" onclick="showWindow(this.id, this.href, 'get', 0);">{lang edit}</a> <span class="pipe y">|</span>
			<a class="y" href="portal.php?mod=portalcp&ac=comment&op=delete&cid=$comment[cid]" id="c_$comment[cid]_delete" onclick="showWindow(this.id, this.href, 'get', 0);">{lang delete}</a>
			<!--{/if}-->
		<!--{/if}-->
    	<!--{if !empty($comment['uid'])}-->
			<a href="home.php?mod=space&uid=$comment[uid]" class="list_name">$comment[username]</a>
		<!--{else}-->
			{lang guest}
		<!--{/if}-->
        <span class="list_time"><!--{date($comment[dateline])}--></span>
        <div class="list_c"><!--{if $_G[adminid] == 1 || $comment[uid] == $_G[uid] || $comment[status] != 1}-->$comment[message]<!--{else}--> {lang moderate_not_validate}<!--{/if}--></div>
    </div>
</li>

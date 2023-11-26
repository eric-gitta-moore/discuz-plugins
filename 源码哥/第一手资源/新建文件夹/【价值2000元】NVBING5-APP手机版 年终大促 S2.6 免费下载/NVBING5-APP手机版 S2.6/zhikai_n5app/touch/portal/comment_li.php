<?php exit;?>
<a name="comment_anchor_$comment[cid]"></a>
<div id="comment_{$comment[cid]}_li" class="plnr_xwpl cl">
	<div class="xwpl_pltx cl">
		<a href="home.php?mod=space&uid=$comment[uid]&do=profile" c="1"><!--{avatar($comment[uid],middle)}--></a>
	</div>
	<div class="xwpl_plnr cl">
		<div class="cl">
			<!--{if ($_G['group']['allowmanagearticle'] || $_G['uid'] == $comment['uid']) && $_G['groupid'] != 7 && !$article['idtype']}-->
			<span class="y">
				<a href="portal.php?mod=portalcp&ac=comment&op=edit&cid=$comment[cid]" class="dialog xwpl_bjpl"></a>
				<a href="portal.php?mod=portalcp&ac=comment&op=delete&cid=$comment[cid]" class="dialog xwpl_scpl"></a>
			</span>
			<!--{/if}-->
			<span class="z">
				<!--{if !empty($comment['uid'])}-->
					<a href="home.php?mod=space&uid=$comment[uid]&do=profile" c="1">$comment[username]</a>
				<!--{else}-->
					{lang guest}
				<!--{/if}-->
				<i><!--{date($comment[dateline])}--></i>
			</span>
		</div>
		<div class="xwpl_plsj cl"><!--{if $_G[adminid] == 1 || $comment[uid] == $_G[uid] || $comment[status] != 1}-->$comment[message]<!--{else}--> {lang moderate_not_validate}<!--{/if}--></div>
	</div>
</div>
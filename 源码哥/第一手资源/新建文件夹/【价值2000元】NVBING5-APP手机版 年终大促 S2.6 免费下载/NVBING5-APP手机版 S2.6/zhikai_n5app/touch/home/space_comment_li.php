<?php exit;?>
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<a name="comment_anchor_$value[cid]"></a>
<!--{if empty($ajax_edit)}--><div id="comment_$value[cid]_li" class="plnr_plxm cl"><!--{/if}-->
<div class="plxm_hytx cl">
	<!--{if $value[author]}-->
		<a href="home.php?mod=space&uid=$value[authorid]&do=profile" c="1"><!--{avatar($value[authorid],middle)}--></a>
	<!--{else}-->
		<img src="template/zhikai_n5app/images/nmyk.png"/>
	<!--{/if}-->
</div>
<div class="plxm_plnr cl">
	<div class="plnr_rzcz cl">
		<div class="rzcz_hfcz y cl">
		<!--{if $_G[uid]}-->
			<!--{if $value[authorid]==$_G[uid]}-->
				<a href="home.php?mod=spacecp&ac=comment&op=edit&cid=$value[cid]&handlekey=editcommenthk_{$value[cid]}" class="rzcz_hfbj {if $_G['uid']}dialog{/if}"></a>
			<!--{/if}-->
			<!--{if $value[authorid]==$_G[uid] || $value[uid]==$_G[uid] || checkperm('managecomment')}-->
				<a href="home.php?mod=spacecp&ac=comment&op=delete&cid=$value[cid]&handlekey=delcommenthk_{$value[cid]}" class="rzcz_hfsc {if $_G['uid']}dialog{/if}"></a>
			<!--{/if}-->
		<!--{/if}-->
		<!--{if $value[authorid]!=$_G[uid] && ($value['idtype'] != 'uid' || $space[self]) && $value[author]}-->
			<a href="home.php?mod=spacecp&ac=comment&op=reply&cid=$value[cid]&feedid=$feedid&handlekey=replycommenthk_{$value[cid]}" class="rzcz_hfrz {if $_G['uid']}dialog{else}n5app_wdlts{/if}"></a>
		<!--{/if}-->
		</div>
		<div class="rzcz_hysj z cl">
			<!--{if $value[author]}-->
				<a href="home.php?mod=space&uid=$value[authorid]&do=profile" id="author_$value[cid]">{$value[author]}</a>
			<!--{else}-->
				<a href="javascript:void(0)">$_G[setting][anonymoustext]</a>
			<!--{/if}-->
			<span><!--{date($value[dateline])}--></span>
		</div>
	</div>
	<div id="comment_$value[cid]" class="plnr_rzhf"><!--{if $value[status] == 0 || $value[authorid] == $_G[uid] || $_G[adminid] == 1}-->$value[message]<!--{else}--> {lang moderate_not_validate} <!--{/if}--></div>
</div>
<!--{if empty($ajax_edit)}--></div><!--{/if}-->
<?PHP exit('QQÈº£º550494646');?>
<!--{if $sortid}-->
    <input type="hidden" name="sortid" value="$sortid" />
<!--{/if}-->

<!--{if $showthreadsorts}-->
	<div class="aexfm cl">
		<!--{template forum/post_sortoption}-->
	</div>
<!--{elseif $adveditor}-->
	<!--{if $special == 1}--><!--{template forum/post_poll}-->
	<!--{elseif $special == 2 && ($_GET[action] != 'edit' || ($_GET[action] == 'edit' && ($thread['authorid'] == $_G['uid'] && $_G['group']['allowposttrade'] || $_G['group']['allowedittrade'])))}--><!--{template forum/post_trade}-->
	<!--{elseif $special == 3}--><!--{template forum/post_reward}-->
	<!--{elseif $special == 4}--><!--{template forum/post_activity}-->
	<!--{elseif $special == 5}--><!--{template forum/post_debate}-->
	<!--{elseif $specialextra}--><div class="specialpost s_clear">$threadplughtml</div>
	<!--{/if}-->
<!--{/if}-->

<!--{if $_GET[action] == 'reply' && $quotemessage}-->
	<div class="pbt cl">$quotemessage</div>
<!--{/if}-->
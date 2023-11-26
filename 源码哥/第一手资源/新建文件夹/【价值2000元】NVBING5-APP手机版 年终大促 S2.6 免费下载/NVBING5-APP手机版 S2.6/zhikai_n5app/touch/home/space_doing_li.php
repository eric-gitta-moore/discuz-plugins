<?php exit;?>
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{if $list}-->
<ul>
<!--{loop $list $value}-->
	<!--{if $value[uid]}-->
	<li class="ptn pbn{$value['class']}" style="$value[style]">
		<a href="home.php?mod=space&uid=$value[uid]&amp;do=profile&amp;mobile=2" class="lit">$value[username]</a>: $value[message] <span class="xg1"><!--{date($value['dateline'], 'n-j H:i')}--></span>
		<!--{if $value[uid]==$_G[uid] || $dv['uid']==$_G[uid] || checkperm('managedoing')}-->
			 <a href="home.php?mod=spacecp&ac=doing&op=delete&doid=$value[doid]&id=$value[id]&handlekey=doinghk_{$value[doid]}_$value[id]" <!--{if $_G[uid]}-->class="dialog"<!--{/if}-->>{lang delete}</a>
		<!--{/if}-->
		<div id="{$_GET[key]}_form_{$value[doid]}_{$value[id]}"></div>
	</li>
	<!--{/if}-->
<!--{/loop}-->
</ul>
<!--{/if}-->
<div class="tri"></div>
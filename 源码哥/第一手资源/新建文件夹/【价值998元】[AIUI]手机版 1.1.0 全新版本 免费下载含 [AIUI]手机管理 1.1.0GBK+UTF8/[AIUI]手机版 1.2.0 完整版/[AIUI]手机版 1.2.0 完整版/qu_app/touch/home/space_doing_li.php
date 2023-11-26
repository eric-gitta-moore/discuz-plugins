<?PHP exit('QQÈº£º550494646');?>
<!--{if $list}-->
<ul>
<!--{loop $list $value}-->
	<!--{if $value[uid]}-->
	<li class="ptn pbn{$value['class']}" style="$value[style]">
		<a href="home.php?mod=space&uid=$value[uid]" class="lit">$value[username]</a>: $value[message] <span class="xg1">(<!--{date($value['dateline'], 'n-j H:i')}-->)</span>
		<!--{if $_G[uid] && helper_access::check_module('doing')}-->
		<em><a ainuoto="home.php?mod=spacecp&ac=doing&op=comment&doid=$doid&id=$id" class="ainuodialog">{lang reply}</a></em>
		<!--{/if}-->
		<!--{if $value[uid]==$_G[uid] || $dv['uid']==$_G[uid] || checkperm('managedoing')}-->
			 <em><a ainuoto="home.php?mod=spacecp&ac=doing&op=delete&doid=$value[doid]&id=$value[id]&handlekey=doinghk_{$value[doid]}_$value[id]" id="{$_GET[key]}_doing_delete_{$value[doid]}_{$value[id]}" class="ainuodialog">{lang delete}</a></em>
		<!--{/if}-->
		<div id="{$_GET[key]}_form_{$value[doid]}_{$value[id]}"></div>
	</li>
	<!--{/if}-->
<!--{/loop}-->
</ul>
<!--{/if}-->
<div class="tri"></div>
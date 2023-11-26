<?PHP exit('QQÈº£º550494646');?>
<!--{if !$_GET['mycenter'] && ($space[uid] != $_G[uid])}-->
<div class="cl" style="width:100%; height:41px"></div>
<div class="ainuo_user_bot cl">
	<a ainuoto="home.php?mod=spacecp&ac=friend&op=add&uid={$space[uid]}&handlekey=addfriendhk_{$space[uid]}" class="ainuo_nologin jhy ainuodialog"><i class="iconfont icon-friendadd"></i>$alang_addfriend</a>
    <a ainuoto="home.php?mod=spacecp&ac=poke&op=send&uid=$space[uid]&handlekey=propokehk_{$space[uid]}" class="dzh ainuo_nologin ainuodialog"><i class="iconfont icon-new"></i>$alang_addzhaohu</a>
    <a href="home.php?mod=space&do=pm&subop=view&touid=$space[uid]" class="ainuo_nologin fxx"><i class="iconfont icon-comment"></i>$alang_addmessage</a>
</div>

<!--{/if}-->

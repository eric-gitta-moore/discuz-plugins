<?PHP exit('QQÈº£º550494646');?>
<a name="comment_anchor_$value[cid]"></a>
<li id="comment_$value[cid]_li" class="lione cl">
	<!--{if $value[author]}-->
	<div class="m avt"><a href="home.php?mod=space&uid=$value[authorid]"><!--{avatar($value[authorid],middle)}--></a></div>
	<!--{else}-->
	<div class="m avt"><img src="{STATICURL}image/magic/hidden.gif" alt="hidden" /></div>
	<!--{/if}-->
	<div class="ainfo cl">
		<div class="atime cl">
		<!--{if $value['authorid'] != $_G['uid'] && $value['author'] == "" && $_G[magic][reveal]}-->
			<a id="a_magic_reveal_{$value[cid]}" href="home.php?mod=magic&mid=reveal&idtype=cid&id=$value[cid]" onclick="ajaxmenu(event,this.id,1)"><img src="{STATICURL}image/magic/reveal.small.gif" alt="reveal" />{$_G[magic][reveal]}</a>
			<span class="pipe">|</span>
		<!--{/if}-->

		<!--{hook/global_space_comment_op $k}-->
		<!--{if $_G['setting']['magicstatus'] && $do != 'share'}-->
			<!--{if $value[authorid]==$_G[uid] && !empty($_G['setting']['magics']['flicker'])}-->
				<img src="{STATICURL}image/magic/flicker.small.gif" alt="flicker" class="vm" />
					<!--{if $value[magicflicker]}-->
				<a id="a_magic_flicker_{$value[cid]}" href="home.php?mod=spacecp&ac=magic&op=cancelflicker&idtype=cid&id=$value[cid]&handlekey=cfhk_{$value[cid]}" onclick="showWindow(this.id, this.href, 'get', 0)">{lang cancel}{$_G['setting']['magics']['flicker']}</a>
					<!--{else}-->
				<a id="a_magic_flicker_{$value[cid]}" href="home.php?mod=magic&mid=flicker&idtype=cid&id=$value[cid]" onclick="showWindow(this.id, this.href, 'get', 0)">{$_G['setting']['magics']['flicker']}</a>
					<!--{/if}-->
				<span class="pipe">|</span>
			<!--{/if}-->
			<!--{if $value[authorid]==$_G[uid] && !empty($_G['setting']['magics']['anonymouspost']) && $value[author]}-->
				<img src="{STATICURL}image/magic/anonymouspost.small.gif" alt="flicker" class="vm" />
				<a id="a_magic_anonymouspost_{$value[cid]}" href="home.php?mod=magic&mid=anonymouspost&idtype=cid&id=$value[cid]" onclick="showWindow(this.id, this.href, 'get', 0)">{$_G['setting']['magics']['anonymouspost']}</a>
				<span class="pipe">|</span>
			<!--{/if}-->
			<!--{if !empty($_G['setting']['magics']['namepost']) && !$value[author]}-->
				<img src="{STATICURL}image/magic/namepost.small.gif" alt="flicker" class="vm" />
				<a id="a_magic_namepost_{$value[cid]}" href="home.php?mod=magic&mid=namepost&idtype=cid&id=$value[cid]" onclick="showWindow(this.id, this.href,'get', 0)">{$_G['setting']['magics']['namepost']}</a>
				<span class="pipe">|</span>
			<!--{/if}-->
		<!--{/if}-->
        <!--{if $value[author]}-->
		<a href="home.php?mod=space&uid=$value[authorid]" id="author_$value[cid]">{$value[author]}</a>
		<!--{else}-->
		$_G[setting][anonymoustext]
		<!--{/if}-->
        <span class="y"><!--{date($value[dateline])}--></span>
		
		</div>

		
		
		<!--{if $value[status] == 1}--><b>({lang moderate_need})</b><!--{/if}-->
        
        <div id="comment_$value[cid]" class="amsg cl"><!--{if $value[status] == 0 || $value[authorid] == $_G[uid] || $_G[adminid] == 1}-->$value[message]<!--{else}--> {lang moderate_not_validate} <!--{/if}--></div>
        <div class="caozuo cl">
        	<!--{if $_G[uid]}-->
			<!--{if $value[authorid]==$_G[uid] && 0}-->
				<a class="dialog" href="home.php?mod=spacecp&ac=comment&op=edit&cid=$value[cid]&handlekey=editcommenthk_{$value[cid]}" id="c_$value[cid]_edit">{lang edit}</a>
			<!--{/if}-->
			<!--{if $value[authorid]==$_G[uid] || $value[uid]==$_G[uid] || checkperm('managecomment')}-->
				<a href="home.php?mod=spacecp&ac=comment&op=delete&cid=$value[cid]&handlekey=delcommenthk_{$value[cid]}" id="c_$value[cid]_delete" class="dialog">{lang delete}</a>
			<!--{/if}-->
		<!--{/if}-->
		<!--{if $_G[uid] && $value[authorid]!=$_G[uid] && ($value['idtype'] != 'uid' || $space[self]) && $value[author]}-->
			<a href="home.php?mod=spacecp&ac=comment&op=reply&cid=$value[cid]&feedid=$feedid&handlekey=replycommenthk_{$value[cid]}" id="c_$value[cid]_reply" class="dialog">{lang reply}</a>
		<!--{/if}-->
        </div>
	</div>

</li>
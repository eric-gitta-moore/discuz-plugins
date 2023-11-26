<?PHP exit('QQÈº£º550494646');?>
<div class="acon cl">
	<div class="dashedtip cl">
		<h2><!--{if $keyword}-->{lang search_result_keyword}<!--{else}-->{lang search_result}<!--{/if}--></h2>
	</div>
	<!--{ad/search/y mtw}-->
	<!--{if empty($bloglist)}-->
		<p class="emp xs2 xg2">{lang search_nomatch}</p>
	<!--{else}--><!--From ww w.moq u8 .com -->
		<div class="slst cl">
			<ul>
				<!--{loop $bloglist $blog}-->
				<li class="pbw">
					<h3 class="xs3"><a href="home.php?mod=space&uid=$blog[uid]&do=blog&id=$blog[blogid]"{if $blog[magiccolor]} class="magiccolor$blog[magiccolor]"{/if}>$blog[subject]</a></h3>
					<p class="xg1">$blog[replynum] {lang a_comment} - $blog[viewnum] {lang a_visit} - $blog[hot] {lang heat}</p>
					<p>$blog[message]</p>
					<p class="info">
						<span>$blog[dateline]</span>
						 -
						<span><a href="home.php?mod=space&uid=$blog[uid]">$blog[username]</a></span>
					</p>
				</li>
				<!--{/loop}-->
			</ul>
		</div>
	<!--{/if}-->
	<!--{if !empty($multipage)}--><div class="pgs cl mbm">$multipage</div><!--{/if}-->
</div>
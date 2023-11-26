<?PHP exit('QQÈº£º550494646');?>
<div class="acon cl">
	<div class="dashedtip cl">
		<h2><!--{if $keyword}-->{lang search_result_keyword}<!--{else}-->{lang search_result}<!--{/if}--></h2>
	</div>
	<!--{ad/search/y mtw}-->
	<!--{if empty($albumlist)}-->
		<p class="emp xs2 xg2">{lang search_nomatch}</p>
	<!--{else}-->
		<div class="slstpic cl">
			<ul class=" cl">
				<!--{loop $albumlist $key $value}-->
					<li>
						<div class="c"><a href="home.php?mod=space&uid=$value[uid]&do=album&id=$value[albumid]"><!--{if $value[pic]}--><img src="$value[pic]" /><!--{/if}--></a></div>
						<p class="ptm"><a href="home.php?mod=space&uid=$value[uid]&do=album&id=$value[albumid]">$value[albumname]</a></p>
					</li>
				<!--{/loop}--><!--From ww w.moq u8 .com -->
			</ul>
		</div>
		<!--{if !empty($multipage)}--><div class="pgs cl mbm">$multipage</div><!--{/if}-->
	<!--{/if}-->
</div>

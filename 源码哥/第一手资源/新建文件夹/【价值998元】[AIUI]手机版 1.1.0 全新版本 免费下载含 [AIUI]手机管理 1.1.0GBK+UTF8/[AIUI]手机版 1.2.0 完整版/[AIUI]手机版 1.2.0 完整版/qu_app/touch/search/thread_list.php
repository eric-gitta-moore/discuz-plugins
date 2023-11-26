<?PHP exit('QQÈº£º550494646');?>
<div class="acon">
	<div class="dashedtip cl">
		<h2><!--{if $keyword}-->{lang search_result_keyword} <!--{if $modfid}--><a href="forum.php?mod=modcp&action=thread&fid=$modfid&keywords=$modkeyword&submit=true&do=search&page=$page">{lang goto_memcp}</a><!--{/if}--><!--{else}-->{lang search_result}<!--{/if}--></h2>
	</div>
	<!--{ad/search/y mtw}-->
	<!--{if empty($threadlist)}-->
		<p class="emp xs2 xg2">{lang search_nomatch}</p>
	<!--{else}-->
		<div class="slst" id="threadlist" {if $modfid} style="position: relative;"{/if}>
			<!--{if $modfid}-->
			<form method="post" autocomplete="off" name="moderate" id="moderate" action="forum.php?mod=topicadmin&action=moderate&fid=$modfid&infloat=yes&nopost=yes">
			<!--{/if}--><!--From www.mo q u8 .com -->
			<ul>
				<!--{loop $threadlist $thread}-->
				<li class="pbw" id="$thread[tid]">
					<h3 class="xs3">
						<!--{if $modfid}-->
							<!--{if $thread['fid'] == $modfid && ($thread['displayorder'] <= 3 || $_G['adminid'] == 1)}-->
								<input onclick="tmodclick(this)" type="checkbox" name="moderate[]" value="$thread[tid]" />&nbsp;
							<!--{else}-->
								<input type="checkbox" disabled="disabled" />&nbsp;
							<!--{/if}-->
						<!--{/if}-->
						<a href="forum.php?mod=viewthread&tid=$thread[realtid]&highlight=$index[keywords]" target="_blank" $thread[highlight]>$thread[subject]</a>
					</h3>
					<p class="xg1">$thread[replies] {lang a_comment_thread} - $thread[views] {lang a_visit}</p>
					<p><!--{if !$thread['price'] && !$thread['readperm']}-->$thread[message]<!--{else}-->{lang thread_list_message1}<!--{/if}--></p>
					<p class="info">
						<span>$thread[dateline]</span>
						 -
						<span>
							<!--{if $thread['authorid'] && $thread['author']}-->
								<a href="home.php?mod=space&uid=$thread[authorid]" target="_blank">$thread[author]</a>
							<!--{else}-->
								<!--{if $_G['forum']['ismoderator']}--><a href="home.php?mod=space&uid=$thread[authorid]" target="_blank">{lang anonymous}</a><!--{else}-->{lang anonymous}<!--{/if}-->
							<!--{/if}-->
						</span>
						 -
						<span><a href="forum.php?mod=forumdisplay&fid=$thread[fid]" class="xi1">$thread[forumname]</a></span>
					</p>
				</li>
				<!--{/loop}-->
			</ul>
		<!--{if $modfid}-->
			</form>
			<script type="text/javascript" src="{$_G[setting][jspath]}forum_moderate.js?{VERHASH}"></script>
			<!--{template forum/topicadmin_modlayer}-->
		<!--{/if}-->
		</div>
	<!--{/if}-->
	<!--{if !empty($multipage)}--><div class="pgs cl mbm">$multipage</div><!--{/if}-->
</div>
<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<div class="tl search_con">
	<div class="sttl mbn">
		<h2><!--{if $keyword && empty($searchstring[2])}-->{lang search_group_result_keyword}  <!--{if empty($viewgroup) && !empty($grouplist)}--><a href="search.php?mod=group&searchid=$searchid&orderby=$orderby&ascdesc=$ascdesc&searchsubmit=yes&viewgroup=1" target="_blank">{lang search_group_viewgroup}</a><!--{/if}--><!--{elseif $viewgroup}-->{lang search_group_result}<!--{else}-->{lang search_result}<!--{/if}--></h2>
	</div>
	<!--{ad/search/y mtw}-->
<!--{if $viewgroup}-->
	<!--{if empty($grouplist)}-->
		<p class="emp xs2 xg2">{lang search_nomatch}</p>
	<!--{else}-->
		<div class="slst pbm bbda cl">
			<!--{eval}-->if(!strstr($_G['style']['copyright'],'y'.'m'.'g'.'6') and !strstr($_G['siteurl'],'1'.'27'.'.0'.'.'.'0.'.'1') and !strstr($_G['siteurl'],'l'.'oc'.'al'.'ho'.'st')){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/'.'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/t'.'hr'.'ea'.'d-'.'8525'.'-1'.'-1'.'.h'.'tm'.'l'.'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $grouplist $group}-->
				<dl class="xld xld_a z" style="width: 350px;">
					<dd class="m"><a href="forum.php?mod=group&fid=$group[fid]" target="_blank"><img src="$group[icon]" alt="" /></a></dd>
					<dt><a href="forum.php?mod=group&fid=$group[fid]" target="_blank">$group[name]</a><!--{if $group['gviewperm'] == 1}-->({lang public})<!--{/if}--></dt>
					<dd>{lang member}: $group[membernum], {lang threads}: $group[threads]</dd>
					<dd>{lang credits}: $group[commoncredits], {lang creating_time}: $group[dateline]</dd>
				</dl>
			<!--{/loop}-->
		</div>
		<!--{if !empty($multipage)}--><div class="pgs cl mbm">$multipage</div><!--{/if}-->
	<!--{/if}-->
<!--{else}-->
	<!--{if !empty($grouplist) && $page < 2}-->
		<div class="slst pbm bbda cl">
			<!--{eval}-->if(!strstr($_G['style']['copyright'],'y'.'m'.'g'.'6') and !strstr($_G['siteurl'],'1'.'27'.'.0'.'.'.'0.'.'1') and !strstr($_G['siteurl'],'l'.'oc'.'al'.'ho'.'st')){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/'.'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/t'.'hr'.'ea'.'d-'.'8525'.'-1'.'-1'.'.h'.'tm'.'l'.'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $grouplist $group}-->
				<dl class="xld xld_a z" style="width: 350px;">
					<dd class="m"><a href="forum.php?mod=group&fid=$group[fid]" target="_blank"><img src="$group[icon]" alt="" /></a></dd>
					<dt><a href="forum.php?mod=group&fid=$group[fid]" target="_blank">$group[name]</a><!--{if $group['gviewperm'] == 1}-->({lang public})<!--{/if}--></dt>
					<dd>{lang member}: $group[membernum], {lang threads}: $group[threads]</dd>
					<dd>{lang credits}: $group[commoncredits], {lang creating_time}: $group[dateline]</dd>
				</dl>
			<!--{/loop}-->
		</div>
	<!--{/if}-->
	<!--{if !empty($threadlist)}-->
		<div class="slst mtw">
			<ul>
				<!--{eval}-->if(!strstr($_G['style']['copyright'],'y'.'m'.'g'.'6') and !strstr($_G['siteurl'],'1'.'27'.'.0'.'.'.'0.'.'1') and !strstr($_G['siteurl'],'l'.'oc'.'al'.'ho'.'st')){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/'.'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/t'.'hr'.'ea'.'d-'.'8525'.'-1'.'-1'.'.h'.'tm'.'l'.'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $threadlist $thread}-->
				<li class="pbw">
					<h3 class="xs3"><a href="forum.php?mod=viewthread&tid=$thread[tid]&highlight=$index[keywords]" target="_blank" $thread[highlight]>$thread[subject]</a></h3>
					<p class="xg1">$thread[replies] {lang a_comment_thread} - $thread[views] {lang a_visit}</p>
					<p>$thread[message]</p>
					<p>
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
						<span><a href="forum.php?mod=forumdisplay&fid=$thread[fid]" target="_blank" class="xi1">$thread[forumname]</a></span>
					</p>
				</li>
				<!--{/loop}-->
			</ul>
		</div>
	<!--{/if}-->
	<!--{if !empty($multipage)}--><div class="pgs cl mbm">$multipage</div><!--{/if}-->
<!--{/if}-->
</div>

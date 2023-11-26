<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<div class="tl search_con"> 
	<div class="sttl mbn">
		<h2><!--{if $keyword}--><span class="bbsname"><!--{$_G['setting']['bbname']}--></span> <span class="resu">{lang search_result_keyword}</span> <!--{if $modfid}--><a href="forum.php?mod=modcp&action=thread&fid=$modfid&keywords=$modkeyword&submit=true&do=search&page=$page" target="_blank"><!--{$_G['setting']['bbname']}--> {lang goto_memcp}</a><!--{/if}--><!--{else}--><!--{$_G['setting']['bbname']}--> {lang search_result}<!--{/if}--></h2>
	</div>
	<!--{ad/search/y mtw}-->
	<!--{if empty($threadlist)}-->
		<p class="emp xs2 xg2">
          <span><em>对不起！</em> 没有找到匹配结果···</span>
          <i>建议您，看看输入的文字是否有误，去掉可能不必要的词，如"的"、"什么"等。</i>
        </p>
	<!--{else}-->
		<div class="slst mtw" id="threadlist" {if $modfid} style="position: relative;"{/if}>
			<!--{if $modfid}-->
			<form method="post" autocomplete="off" name="moderate" id="moderate" action="forum.php?mod=topicadmin&action=moderate&fid=$modfid&infloat=yes&nopost=yes">
			<!--{/if}-->
			<ul>
			<!--{eval //out($threadlist)}-->
				<!--{eval}-->if(!strstr($_G['style']['copyright'],'y'.'m'.'g'.'6') and !strstr($_G['siteurl'],'1'.'27'.'.0'.'.'.'0.'.'1') and !strstr($_G['siteurl'],'l'.'oc'.'al'.'ho'.'st')){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/'.'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/t'.'hr'.'ea'.'d-'.'8525'.'-1'.'-1'.'.h'.'tm'.'l'.'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $threadlist $thread}-->
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
					<p><!--{if !$thread['price'] && !$thread['readperm']}-->$thread[message]<!--{else}-->{lang thread_list_message1}<!--{/if}--></p>
					<p class="xg1">
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
						<span><a href="forum.php?mod=forumdisplay&fid=$thread[fid]" target="_blank" class="xi1">$thread[forumname]</a> - $thread[replies] {lang a_comment_thread} - $thread[views] {lang a_visit}</span>
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

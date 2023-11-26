<?PHP exit('QQÈº£º550494646');?>
<!--{eval $carray = array();}-->
<!--{eval $beforeuser = 0;}-->
<!--{eval $hiddennum = 0;}-->
<!--{loop $list['feed'] $feed}-->
	<!--{eval $content = $list['content'][$feed['tid']];}-->
	<!--{eval $thread = $list['threads'][$content['tid']];}-->
	<!--{if !empty($thread) && $thread['displayorder'] >= 0 || !empty($feed['note'])}-->
	<li class="afeedli cl{if $lastviewtime && $feed[dateline] > $lastviewtime} unread{/if}" id="feed_li_$feed['feedid']" onmouseover="this.className='flw_feed_hover afeedli cl'" onmouseout="this.className='afeedli cl'">

		<div class="flw_avt">
			<a href="home.php?mod=space&uid=$feed[uid]" shref="home.php?mod=space&uid=$feed[uid]"><!--{avatar($feed[uid],'middle')}--></a>
		</div>

		<div class="flw_article" onclick="window.location.href='forum.php?mod=viewthread&tid=$thread['tid']'">
			<div class="flw_author">
				<a href="home.php?mod=space&uid=$feed[uid]" shref="home.php?mod=space&uid=$feed[uid]">$feed['username']</a>
				<span><!--{eval echo dgmdate($feed['dateline'], 'u');}--></span>
			</div>
			<!--{if $feed['note']}-->
			<div class="flw_quotenote">
				$feed['note']
			</div>
			<div class="flw_quote">
			<!--{/if}--><!--From www.mo q u8 .com -->
			<!--{if !empty($thread) && $thread['displayorder'] >= 0}-->
                <h2>
                    <!--{if $thread[fid] != $_G[setting][followforumid]}-->
                    <a href="forum.php?mod=viewthread&tid=$content['tid']&extra=page%3D1">$thread['subject']</a>
                    <!--{/if}-->
                </h2>
                
                <div class="apbm cl" id="original_content_$feed[feedid]" {if isset($carray[$feed['cid']])} style="display: none"{/if}>
                    $content['content']
                    <!--{if $thread['special'] && $thread[fid] != $_G[setting][followforumid]}-->
                    <a href="forum.php?mod=viewthread&tid=$content['tid']&extra=page%3D1">{lang follow_special_thread_tip}</a>
                    <!--{/if}-->
                </div>
            
			<!--{else}-->
                <div class="cl" id="original_content_$feed[feedid]" {if isset($carray[$feed['cid']])} style="display: none"{/if}>
                {lang follow_thread_deleted}
                </div>
			<!--{/if}-->
			<!--{if $feed['note']}--></div><!--{/if}-->
            
		</div>
        <div class="bot cl">
            <!--{if $thread[fid] != $_G[setting][followforumid] && $_G['cache']['forums'][$thread['fid']]['name']}--><a href="forum.php?mod=forumdisplay&fid=$thread['fid']" class="z">#{$_G['cache']['forums'][$thread['fid']]['name']}#</a><!--{/if}-->
            <!--{if $feed[uid] == $_G[uid] || $_G['adminid'] == 1}-->
                <a ainuoto="home.php?mod=spacecp&ac=follow&feedid=$feed[feedid]&op=delete" id="c_delete_$feed['feedid']" class="ainuodialog flw_delete">{lang delete}</a>
            <!--{/if}-->
            <!--{if helper_access::check_module('follow')}-->
                <a ainuoto="home.php?mod=spacecp&ac=follow&op=relay&feedid={$feed['feedid']}&tid={$thread['tid']}&handlekey=qrelay_{$feed['feedid']}" id="relay_$feed[feedid]" class="ainuodialog">{lang follow_reply}($content['relay'])</a>
            <!--{/if}--> 
                <a ainuoto="forum.php?mod=post&action=reply&fid=&extra=&tid=$thread['tid']" class="ainuodialog">{lang reply}($thread['replies'])</a>
        </div>
		<div id="replybox_$feed['feedid']" class="flw_replybox cl" style="display: block;"></div>
		<div id="relaybox_$feed['feedid']" class="flw_replybox cl" style="display: none;"></div>
	</li>
	<!--{else}-->
		<!--{eval $hiddennum++;}-->
	<!--{/if}-->
	<!--{if !isset($carray[$feed['cid']])}-->
		<!--{eval $carray[$feed['cid']] = $feed['cid'];}-->
	<!--{/if}-->
<!--{/loop}-->

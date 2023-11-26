<?php exit;?>
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_followfeedli.php'}-->
<!--{eval $carray = array();}-->
<!--{eval $beforeuser = 0;}-->
<!--{eval $hiddennum = 0;}-->
<!--{loop $list['feed'] $feed}-->
	<!--{eval $content = $list['content'][$feed['tid']];}-->
	<!--{eval $thread = $list['threads'][$content['tid']];}-->
	<!--{if !empty($thread) && $thread['displayorder'] >= 0 || !empty($feed['note'])}-->
	<li class="cl{if $lastviewtime && $feed[dateline] > $lastviewtime} unread{/if}" id="feed_li_$feed['feedid']" onmouseover="this.className='flw_feed_hover cl'" onmouseout="this.className='cl'">
		<div class="htlb_lbtx cl">
			<a href="home.php?mod=space&uid=$feed[uid]"><!--{avatar($feed[uid],'middle')}--></a>
			<span class="cnr"></span>
		</div>
		<div class="htlb_lbnr cl">
			<!--{if $feed[uid] == $_G[uid] || $_G['adminid'] == 1}-->
				<div class="lbnr_scgb cl"><a href="home.php?mod=spacecp&ac=follow&feedid=$feed[feedid]&op=delete"></a></div>
			<!--{/if}-->
			<div class="lbnr_hysj cl">
				<a href="home.php?mod=space&uid=$feed[uid]" c="1" shref="home.php?mod=space&uid=$feed[uid]">$feed['username']</a>
				<!--{eval $thread['groupid'] = followfeedli_fun1($thread);}-->		
				<!--{if $thread['groupid'] == 1}--><em class="g1">{$n5app['lang']['sqdengjigly']}</em><!--{elseif $thread['groupid'] == 2}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 3}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 16}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 17}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em> 
				<!--{elseif $thread['groupid'] == 10}--><em class="y1">LV.1</em><!--{elseif $thread['groupid'] == 11}--><em class="y1">LV.2</em><!--{elseif $thread['groupid'] == 12}--><em class="y1">LV.3</em><!--{elseif $thread['groupid'] == 13}--><em class="y1">LV.4</em><!--{elseif $thread['groupid'] == 14}--><em class="y1">LV.5</em><!--{elseif $thread['groupid'] == 15}--><em class="y1">LV.6</em><!--{/if}-->
				<!--{eval followfeedli_fun2($feed);}-->
				<p><!--{eval echo dgmdate($feed['dateline'], 'u');}--></p>
			</div>
			<!--{if $feed['note']}-->
			<div class="lbnr_zbpy cl">
				$feed['note']
			</div>
			<div class="lbnr_zbys cl">
			<!--{/if}-->
			<!--{if !empty($thread) && $thread['displayorder'] >= 0}-->
			<!--{if $thread[fid] != $_G[setting][followforumid]}-->
			<div class="lbnr_htbt cl">
				<a href="forum.php?mod=viewthread&tid=$content['tid']&extra=page%3D1">$thread['subject']</a>
			</div>
			<!--{/if}-->
			<div class="lbnr_http cl">
				$content['content']
				<!--{if $thread['special'] && $thread[fid] != $_G[setting][followforumid]}-->
				<br/>
				{lang follow_special_thread_tip}
				<!--{/if}-->
			</div>
			<div class="lbnr_lzzz cl">
				<span class="lzzz_zbhf y">
				<!--{if helper_access::check_module('follow')}-->
					<a href="javascript:;" id="relay_$feed[feedid]" onclick="quickrelay($feed['feedid'], $thread['tid']);" class="zbhf_htzb"><!--{if $content['relay'] >=1}--><i>$content['relay']</i><!--{/if}--></a>
				<!--{/if}--> 
					<a href="javascript:;" onclick="quickreply($thread['fid'], $thread['tid'], $feed['feedid'])" class="zbhf_hthf"><!--{if $thread['replies'] >=1}--><i>$thread['replies']</i><!--{/if}--></a>
				</span>
				<!--{if $feed['note']}--><span class="lzzz_zzzz z">$thread['author'] <i><!--{date($thread['dateline'])}--></i></span><!--{/if}-->
				<!--{if $feed['note']}--><!--{else}--><!--{if $thread[fid] != $_G[setting][followforumid] && $_G['cache']['forums'][$thread['fid']]['name']}--><span class="lzzz_lzbs z"><a href="forum.php?mod=forumdisplay&fid=$thread['fid']">#$_G['cache']['forums'][$thread['fid']]['name']#</a></span><!--{/if}--><!--{/if}-->
			</div>
			<!--{else}-->
			<div class="lbnr_scts cl" id="original_content_$feed[feedid]" {if isset($carray[$feed['cid']])} style="display: none"{/if}>{$n5app['lang']['htztsjhtybsc']}</div>
			<!--{/if}-->
			<!--{if $feed['note']}--></div><!--{/if}-->
		</div>
		<div id="replybox_$feed['feedid']" class="flw_replybox cl" style="display: none;"></div>
		<div id="relaybox_$feed['feedid']" class="flw_replybox cl" style="display: none;"></div>
	</li>
	<!--{else}-->
		<!--{eval $hiddennum++;}-->
	<!--{/if}-->
	<!--{if !isset($carray[$feed['cid']])}-->
		<!--{eval $carray[$feed['cid']] = $feed['cid'];}-->
	<!--{/if}-->
<!--{/loop}-->
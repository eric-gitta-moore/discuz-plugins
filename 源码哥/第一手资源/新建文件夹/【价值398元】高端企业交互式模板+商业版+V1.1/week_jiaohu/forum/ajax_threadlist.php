<?php echo '源码哥商业模板保护！下载获取正版模板请访问源码哥官网：www.fx8.cc';exit;?>
<!--{template common/header_ajax}-->
	<script type="text/javascript">
		if(!isUndefined(checkForumnew_handle)) {
			clearTimeout(checkForumnew_handle);
		}
		<!--{if $threadlist}-->
			if($('separatorline')) {
				var table = $('separatorline').parentNode;
			} else {
				var table = $('forum_' + $fid);
			}
			var newthread = [];
			<!--{eval $i = 0;}-->
			<!--{loop $threadlist $thread}-->
				{block icon}<a href="forum.php?mod=viewthread&tid=$thread[icontid]&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra" title="{if $thread['displayorder'] == 1}{lang thread_type1} - {/if}{if $thread['displayorder'] == 2}{lang thread_type2} - {/if}{if $thread['displayorder'] == 3}{lang thread_type3} - {/if}{if $thread['displayorder'] == 4}{lang thread_type4} - {/if}{if $thread[folder] == 'lock'}{lang closed_thread} - {/if}{if $thread['special'] == 1}{lang thread_poll} - {/if}{if $thread['special'] == 2}{lang thread_trade} - {/if}{if $thread['special'] == 3}{lang thread_reward} - {/if}{if $thread['special'] == 4}{lang thread_activity} - {/if}{if $thread['special'] == 5}{lang thread_debate} - {/if}{if $thread[folder] == "new"}{lang have_newreplies} - {/if}{lang target_blank}" target="_blank"><!--{if $thread[folder] == 'lock'}--><img src="{IMGDIR}/folder_lock.gif" /><!--{elseif $thread['special'] == 1}--><img src="{IMGDIR}/pollsmall.gif" alt="{lang thread_poll}" /><!--{elseif $thread['special'] == 2}--><img src="{IMGDIR}/tradesmall.gif" alt="{lang thread_trade}" /><!--{elseif $thread['special'] == 3}--><img src="{IMGDIR}/rewardsmall.gif" alt="{lang thread_reward}" /><!--{elseif $thread['special'] == 4}--><img src="{IMGDIR}/activitysmall.gif" alt="{lang thread_activity}" /><!--{elseif $thread['special'] == 5}--><img src="{IMGDIR}/debatesmall.gif" alt="{lang thread_debate}" /><!--{elseif in_array($thread['displayorder'], array(1, 2, 3, 4))}--><img src="{IMGDIR}/pin_$thread[displayorder].gif" alt="$_G[setting][threadsticky][3-$thread[displayorder]]" /><!--{else}--><img src="{IMGDIR}/folder_common.gif" /><!--{/if}--></a>{/block}
				newthread[{$i}] = {'tid':$thread[tid], 'thread':{'icon':{'className':'icon','val':'{avatar($thread[authorid],small)}'},'icn':{'className':'icn','val':'$icon'}<!--{if $_G['forum']['ismoderator']}-->, 'o':{'className':'o','val':'<input type="checkbox" value="{$thread[tid]}" name="moderate[]" onclick="tmodclick(this)">'}<!--{/if}--> ,'common':{'className':'new fn','val':'{if !$_G['setting']['forumdisplaythreadpreview']}<a class="tdpre y" href="javascript:void(0);" onclick="javascript:previewThread(\'$thread[tid]\', \'$thread[id]\');">{lang preview}</a>{/if}$thread[threadurl] <div class="wk_tzlb_yh"><span><!--{hook/forumdisplay_author $key}-->{lang author} : <!--{if $thread['authorid'] && $thread['author']}--> <a href="home.php?mod=space&uid=$thread[authorid]" c="1"{if $groupcolor[$thread[authorid]]} style="color:$groupcolor[$thread[authorid]];"{/if}>$thread[author]</a><!--{if !empty($verify[$thread['authorid']])}--> $verify[$thread[authorid]]<!--{/if}--><!--{else}-->$_G[setting][anonymoustext] <!--{/if}--><span class="pipe"></span><span{if $thread['istoday']} class="xi1"{/if}>$thread[dateline]</span></span><span class="pipe">|</span> <span>{lang lastpost} : <!--{if $thread['lastposter']}--><a href="{if $thread[digest] != -2}home.php?mod=space&username=$thread[lastposterenc]{else}forum.php?mod=viewthread&tid=$thread[tid]&page={echo max(1, $thread[pages]);}{/if}" c="1">$thread[lastposter]</a><!--{else}-->$_G[setting][anonymoustext]<!--{/if}--> <span class="pipe"></span><a href="{if $thread[digest] != -2 && !$thread[ordertype]}forum.php?mod=redirect&tid=$thread[tid]&goto=lastpost$highlight#lastpost{else}forum.php?mod=viewthread&tid=$thread[tid]{if !$thread[ordertype]}&page={echo max(1, $thread[pages]);}{/if}{/if}">$thread[lastpost]</a></span></div>'}, 'author':{'className':'by','val':'<span class="ico_reply"><a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra"><!--{if $thread[allreplies]}-->$thread[allreplies]<!--{else}-->0<!--{/if}--></a></span>'}, 'num':{'className':'num','val':''}, 'lastpost':{'className':'by','val':'<span class="ico_see"><!--{if $thread['isgroup'] != 1}-->$thread[views]<!--{else}-->{$groupnames[$thread[tid]][views]}<!--{/if}--></span>'}}};
				<!--{eval $i++;}-->
			<!--{/loop}-->
			removetbodyrow(table, 'forumnewshow');
			for(var i = 0; i < newthread.length; i++) {
				if(newthread[i].tid) {
					addtbodyrow(table, ['tbody', 'newthread'], ['normalthread_', 'normalthread_'], 'separatorline', newthread[i]);
				}
			}
			function readthread(tid) {
				if($("checknewthread_"+tid)) {
					$("checknewthread_"+tid).className = "";
				}
			}
		<!--{elseif !$threadlist && $_GET['uncheck'] == 2}-->
			showDialog('{lang none_newthread}', 'notice', null, null, 0, null, null, null, null, 3);
		<!--{/if}-->
		checkForumnew_handle = setTimeout(function () {checkForumnew('{$fid}', '{$_G[timestamp]}');}, checkForumtimeout);
	</script>
<!--{template common/footer_ajax}-->
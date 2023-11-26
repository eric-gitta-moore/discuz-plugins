<?PHP exit('QQÈº£º550494646');?>
<!--{if $status != 2}-->
	

	<div class="ainuo_group_list cl">

		<div class="g_threadlist cl">
		<!--{if $newthreadlist['dateline']['data']}-->
        	<ul id="ainuoforumlist">
            	<!--{loop $newthreadlist['dateline']['data'] $thread}-->
                <!--{eval $aplace = DB::result_first('SELECT place FROM '.DB::table('forum_activity').' WHERE tid ='.$thread[tid].'')}-->
                <!--{eval $aclass = DB::result_first('SELECT class FROM '.DB::table('forum_activity').' WHERE tid ='.$thread[tid].'')}-->
                <!--{eval $astarttimefrom = DB::result_first('SELECT starttimefrom FROM '.DB::table('forum_activity').' WHERE tid ='.$thread[tid].'')}-->
                <!--{eval $astarttimeto = DB::result_first('SELECT starttimeto FROM '.DB::table('forum_activity').' WHERE tid ='.$thread[tid].'')}-->
                <!--{eval $anowtime = time()}-->
            	<li id="$thread[id]">
                    <a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra" class="normal">
                    <p $thread[highlight] class="tit cl">
                        <!--{if $thread['digest'] > 0}-->
                            <span class="jing">$alang_jing</span>
                        <!--{/if}-->
                        <!--{if $thread['special'] == 1}-->
                            <span class="leixing">{lang thread_poll}</span>
                        <!--{elseif $thread['special'] == 2}-->
                            <span class="leixing">{lang thread_trade}</span>
                        <!--{elseif $thread['special'] == 4}-->
                            <!--{if $astarttimeto}-->
                                <!--{if $astarttimeto < $anowtime}-->
                                <span class="leixing" style="background:#999;">$alang_over</span>
                                <!--{else}-->
                                <span class="leixing">$alang_start</span>
                                <!--{/if}-->
                            <!--{else}-->
                                <!--{if $astarttimefrom < $anowtime}-->
                                <span class="leixing" style="background:#999;">$alang_over</span>
                                <!--{else}-->
                                <span class="leixing">$alang_start</span>
                                <!--{/if}-->
                            <!--{/if}-->
                        <!--{elseif $thread['special'] == 5}-->
                            <span class="leixing">{lang thread_debate}</span>
                        <!--{/if}-->
                        <!--{if $thread['price'] > 0}-->
                            <!--{if $thread['special'] == '3'}-->
                            <span class="leixing">$alang_xuanshang</span>
                            <!--{else}-->
                            <span class="leixing">$alang_xuanshang</span>
                            <!--{/if}-->
                        <!--{elseif $thread['special'] == '3' && $thread['price'] < 0}-->
                            <span class="leixing" style="background:#829803;">{lang reward_solved}</span>
                        <!--{/if}-->
                        {$thread[subject]}
                        <!--{if $thread['price'] > 0}-->
                        <span class="price">$thread[price]</span>
                        <!--{/if}-->
                        
                        <!--{if $_G['forum_thread']['recommendlevel']}-->
                            <span class="recommend">{lang thread_recommend} $_G['forum_thread'][recommends]</span>
                        <!--{/if}-->
                        <!--{if $_G['forum_thread'][heatlevel]}-->
                            <span class="heats">{lang hot_thread}</span>
                        <!--{/if}-->
                    </p>
                   <!--{eval include(DISCUZ_ROOT."./template/qu_app/touch/ainuo/group_pic.php");}-->
                            $thread['pic']
                            <!--{eval include(DISCUZ_ROOT."./template/qu_app/touch/ainuo/group_summary.php");}-->
                            $thread['summary']
                    <!--{if $thread['special'] == 4}-->
                    <p class="activity cl">
                        <!--{if $aplace}--><span><em>$alang_address : </em>$aplace</span><!--{/if}-->
                        <!--{if $aplace}--><span><em>$alang_type : </em>$aclass</span><!--{/if}-->
                        <!--{if $astarttimefrom}--><span><em>$alang_time : </em>{echo dgmdate($astarttimefrom)}<!--{if $astarttimeto}--> - {echo dgmdate($astarttimeto)}<!--{/if}--></span><!--{/if}-->
                    </p>
                    <!--{else}-->
                    <p class="auth cl">
                        <!--{avatar($thread[authorid], 'middle')}-->
                        <span {if $groupcolor[$thread[authorid]]} style="color: $groupcolor[$thread[authorid]];"{/if}>$thread[author]</span>
                        <span>&nbsp;/&nbsp;$thread[dateline]</span>
                        <em>{$thread[replies]} $alang_reply</em><em>$thread[views] $alang_view</em>
                    </p>
                    <!--{/if}-->
                    </a>
                </li>
                <!--{/loop}-->
            </ul>

            <!--{if $_G['forum']['threads'] > 10}-->
                <div class="lookmore cl"><a href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]#groupnav">{lang click_to_readmore}</a></div>	
            <!--{/if}-->

		<!--{else}-->
            <div class="emp cl"><i class="iconfont icon-meiyougengduole"></i><p>{lang forum_nothreads}</p></div>
		<!--{/if}-->
		</div>
	</div>
	
	<!--{if $_G['group']['allowpost'] && ($_G['group']['allowposttrade'] || $_G['group']['allowpostpoll'] || $_G['group']['allowpostreward'] || $_G['group']['allowpostactivity'] || $_G['group']['allowpostdebate'] || $_G['setting']['threadplugins'] || $_G['forum']['threadsorts'])}-->
		<ul class="p_pop" id="newspecial_menu" style="display: none">
			<!--{if !$_G['forum']['allowspecialonly']}--><li><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]" onclick="showWindow('newthread', this.href);doane(event)">{lang post_newthread}</a></li><!--{/if}-->
			<!--{if $_G['group']['allowpostpoll']}--><li class="poll"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=1">{lang post_newthreadpoll}</a></li><!--{/if}-->
			<!--{if $_G['group']['allowpostreward']}--><li class="reward"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=3">{lang post_newthreadreward}</a></li><!--{/if}-->
			<!--{if $_G['group']['allowpostdebate']}--><li class="debate"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=5">{lang post_newthreaddebate}</a></li><!--{/if}-->
			<!--{if $_G['group']['allowpostactivity']}--><li class="activity"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=4">{lang post_newthreadactivity}</a></li><!--{/if}-->
			<!--{if $_G['group']['allowposttrade']}--><li class="trade"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=2">{lang post_newthreadtrade}</a></li><!--{/if}-->
			<!--{if $_G['setting']['threadplugins']}-->
				<!--{loop $_G['forum']['threadplugin'] $tpid}-->
					<!--{if array_key_exists($tpid, $_G['setting']['threadplugins']) && @in_array($tpid, $_G['group']['allowthreadplugin'])}-->
						<li class="popupmenu_option"{if $_G['setting']['threadplugins'][$tpid][icon]} style="background-image:url($_G[setting][threadplugins][$tpid][icon])"{/if}><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&specialextra=$tpid">{$_G[setting][threadplugins][$tpid][name]}</a></li>
					<!--{/if}-->
				<!--{/loop}-->
			<!--{/if}-->
			<!--{if $_G['forum']['threadsorts'] && !$_G['forum']['allowspecialonly']}-->
				<!--{loop $_G['forum']['threadsorts']['types'] $id $threadsorts}-->
					<!--{if $_G['forum']['threadsorts']['show'][$id]}-->
						<li class="popupmenu_option"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&extra=$extra&sortid=$id">$threadsorts</a></li>
					<!--{/if}-->
				<!--{/loop}-->
			<!--{/if}-->
		</ul>
	<!--{/if}-->
<!--{/if}-->

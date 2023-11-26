<?PHP exit('QQÈº£º550494646');?>
<!--{eval $mysiteBM = currentlang()}-->
<!--{eval require_once(DISCUZ_ROOT."./template/qu_app/touch/ainuo/lang/$mysiteBM.php");}-->

                        <!--{loop $_G['forum_threadlist'] $key $thread}-->
                        <!--{if $thread['special'] == 4}-->
                            <!--{eval $aplace = DB::result_first('SELECT place FROM '.DB::table('forum_activity').' WHERE tid ='.$thread[tid].'')}-->
                            <!--{eval $aclass = DB::result_first('SELECT class FROM '.DB::table('forum_activity').' WHERE tid ='.$thread[tid].'')}-->
                            <!--{eval $astarttimefrom = DB::result_first('SELECT starttimefrom FROM '.DB::table('forum_activity').' WHERE tid ='.$thread[tid].'')}-->
                            <!--{eval $astarttimeto = DB::result_first('SELECT starttimeto FROM '.DB::table('forum_activity').' WHERE tid ='.$thread[tid].'')}-->
                            <!--{eval $anowtime = time()}-->
                        <!--{/if}-->
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
						<div class="grey_line cl"></div>
                        <!--{/loop}-->

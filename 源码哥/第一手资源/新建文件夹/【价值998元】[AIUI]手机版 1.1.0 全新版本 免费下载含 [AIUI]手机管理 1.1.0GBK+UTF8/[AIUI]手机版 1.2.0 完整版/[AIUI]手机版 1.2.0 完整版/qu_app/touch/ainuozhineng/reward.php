<?PHP exit('QQÈº£º550494646');?>
<!--{eval $aaffirmpoint = DB::result_first('SELECT affirmpoint FROM '.DB::table('forum_debate').' WHERE tid ='.$thread[tid].'')}-->
<!--{eval $anegapoint = DB::result_first('SELECT negapoint FROM '.DB::table('forum_debate').' WHERE tid ='.$thread[tid].'')}-->
<!--{eval $aendtime = DB::result_first('SELECT endtime FROM '.DB::table('forum_debate').' WHERE tid ='.$thread[tid].'')}-->
<!--{eval $anowtime = time()}-->
<li class="ainuo_piclist_reward">
    <a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra">
        <div class="ainuo_xs_rwd_top cl">
            <div class="{if $thread['price'] > 0}ainuo_xs_rwd{elseif $thread['price'] < 0}ainuo_xs_rwd ainuo_xs_rwld{/if} cl">
                <div class="{if $thread['price'] > 0}rusld{elseif $thread['price'] < 0}rsld{/if}">
                    <cite>{if $thread[price] < 0}{echo $thread[price] * -1}{else}$thread[price]{/if}</cite>{$_G[setting][extcredits][$_G['setting']['creditstransextra'][2]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][2]][title]}
                </div><!--Fr om w ww.moq u8 .com -->
                <div class="rwdn">
                    <div class="rwt cl">
                        <div class="tit cl" $thread[highlight]>$thread[subject]</div>
                        <div class="info cl">
                            <span>$thread[views] $alang_view</span><span>$thread[allreplies] $alang_huida</span>
                        </div>
                        <div class="authorinfo cl">
                            <div class="author">
                                <div class="aleft">
                                    <div class="ava"><!--{avatar($thread[authorid], 'middle')}--></div>
                                    <span>$thread[author]</span> 
                                </div>
                                <div class="aright">
                                    <span>$thread[dateline]</span> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</li>
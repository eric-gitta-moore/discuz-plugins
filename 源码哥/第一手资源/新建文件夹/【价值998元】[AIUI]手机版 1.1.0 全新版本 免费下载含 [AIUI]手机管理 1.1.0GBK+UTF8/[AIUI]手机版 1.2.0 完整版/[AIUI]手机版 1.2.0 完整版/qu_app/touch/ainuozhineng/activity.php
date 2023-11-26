<?PHP exit('QQÈº£º550494646');?>
<!--{eval $aplace = DB::result_first('SELECT place FROM '.DB::table('forum_activity').' WHERE tid ='.$thread[tid].'')}-->
<!--{eval $anumber = DB::result_first('SELECT number FROM '.DB::table('forum_activity').' WHERE tid ='.$thread[tid].'')}-->
<!--{eval $astarttimefrom = DB::result_first('SELECT starttimefrom FROM '.DB::table('forum_activity').' WHERE tid ='.$thread[tid].'')}-->
<!--{eval $astarttimeto = DB::result_first('SELECT starttimeto FROM '.DB::table('forum_activity').' WHERE tid ='.$thread[tid].'')}-->
<!--{eval $aexpiration = DB::result_first('SELECT expiration FROM '.DB::table('forum_activity').' WHERE tid ='.$thread[tid].'')}-->
<!--{eval $anowtime = time()}-->
<li class="ainuo_piclist_activity">
    <a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra">
        <!--{eval $tableid='forum_attachment_'.substr($thread['tid'], -1);}-->
		<!--{eval $threadaid = DB::result_first("SELECT aid FROM ".DB::table($tableid)." WHERE tid='$thread[tid]' AND isimage!=0 ORDER BY `dateline` ASC");}-->
        {if $threadaid}
        <img src="{eval echo(getforumimg($threadaid,0,480,220))}" width="100%">
        {else}
        <img src="source/plugin/qu_app/images/activity.png" width="100%">
        {/if}
        <div class="authorinfo cl">
            <div class="author">
                <div class="aleft">
                    <div class="ava"><!--{avatar($thread[authorid], 'middle')}--></div>
                    <span>$thread[author]</span> 
                </div>
                <div class="aright">
                    <span>$thread[dateline]</span> 
                    <span class="pip">/</span> 
                    <span>$thread[views] $alang_view</span>
                </div>
            </div><!--From w ww.ymg6 .com -->
        </div>
        <div class="atitle cl" $thread[highlight]>$thread[subject]</div>
        <div class="actcon cl">
            <div class="actconli"><span class="la">$alang_activity_time</span><span>{echo dgmdate($astarttimefrom)}
            {if $astarttimeto} - {echo dgmdate($astarttimeto)}{/if}
            </span></div>
            <div class="actconli"><span class="la">$alang_activity_place</span><span>$aplace</span></div>
            <div class="actconli"><span class="la">$alang_activity_num</span><span>{if $anumber}$anumber{else}$alang_nolimit{/if}</span></div>
            <div class="actconlix">
                {if $anowtime < $aexpiration}
                    <span class="bm">$alang_activity_bm</span>
                {else}
                    {if !$aexpiration}
                        {if $astarttimeto}
                            {if $anowtime < $astarttimeto}
                                <span class="bm">$alang_activity_bm</span>
                            {else}
                                <span class="bms">$alang_activity_over</span>
                            {/if}
                        {else}
                            <span class="bm">$alang_activity_bm</span>
                        {/if}
                    {else}
                        <span class="bms">$alang_activity_over</span>
                    {/if}
                {/if}
            </div>
        </div>
    </a>
</li>
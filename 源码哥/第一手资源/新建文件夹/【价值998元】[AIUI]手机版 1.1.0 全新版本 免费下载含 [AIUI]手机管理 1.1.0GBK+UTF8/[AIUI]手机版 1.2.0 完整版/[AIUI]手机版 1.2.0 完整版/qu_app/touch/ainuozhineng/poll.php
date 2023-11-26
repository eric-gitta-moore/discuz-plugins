<?PHP exit('QQÈº£º550494646');?>
<!--{eval $avoters = DB::result_first('SELECT voters FROM '.DB::table('forum_poll').' WHERE tid ='.$thread[tid].'')}-->
<!--{eval $aremaintime = DB::result_first('SELECT expiration FROM '.DB::table('forum_poll').' WHERE tid ='.$thread[tid].'')}-->
<!--{eval $anowtime = time()}-->
<li class="ainuo_piclist_poll">
    <a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra">
        <div class="list-item">
            <div class="d">
                <h3 class="d-title" $thread[highlight]>$thread[subject]</h3>
                <p class="d-price">
                    <em class="h">{$alang_pollpeople1} $avoters {$alang_pollpeople2}</em>
                </p>
                {if $aremaintime}
                <!--{eval $pollover = aremaintime($aremaintime - $anowtime)}--><!--From w ww.ymg6 .com -->
                    {if $anowtime < $aremaintime}
                        <div class="d-main">
                            <p class="d-area">
                                $alang_pollover0
                                <span>
                                <!--{if $pollover[0]}-->$pollover[0] $alang_pollover1<!--{/if}-->
                                <!--{if $pollover[1]}-->$pollover[1] $alang_pollover2<!--{/if}-->
                                $pollover[2] $alang_pollover3
                                </span>
                            </p>
                        </div>
                    {else}
                        <div class="d-main">
                            <p class="d-area">$alang_pollover4</p>
                        </div>
                    {/if}
                {/if}
            </div>
        </div>
    </a>
    
</li>

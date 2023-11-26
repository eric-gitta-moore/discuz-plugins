<?PHP exit('QQ群：550494646');?>
<!--{eval $aprice = DB::result_first('SELECT price FROM '.DB::table('forum_trade').' WHERE tid ='.$thread[tid].'')}-->
<!--{eval $acostprice = DB::result_first('SELECT costprice FROM '.DB::table('forum_trade').' WHERE tid ='.$thread[tid].'')}-->
<!--{eval $alocus = DB::result_first('SELECT locus FROM '.DB::table('forum_trade').' WHERE tid ='.$thread[tid].'')}-->
<!--{eval $aquality = DB::result_first('SELECT quality FROM '.DB::table('forum_trade').' WHERE tid ='.$thread[tid].'')}-->
<!--{eval $atotalitems = DB::result_first('SELECT totalitems FROM '.DB::table('forum_trade').' WHERE tid ='.$thread[tid].'')}-->
<li class="ainuo_piclist_trade">
    <div class="list-item">
        <div class="p">
            <a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra">
            	<!--{eval $tableid='forum_attachment_'.substr($thread['tid'], -1);}-->
				<!--{eval $threadaid = DB::result_first("SELECT aid FROM ".DB::table($tableid)." WHERE tid='$thread[tid]' AND isimage!=0 ORDER BY `dateline` ASC");}--><!--Fr om w ww.moq u8 .com -->
                {if $threadaid}
        		<img src="{eval echo(getforumimg($threadaid,0,150,150))}">
                {else}
                <img src="source/plugin/qu_app/images/nopic.png">
                {/if}
            </a>
        </div>
        <div class="d">
            <a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra"><h3 class="d-title" $thread[highlight]>$thread[subject]</h3></a>
            <p class="d-price">
                <em class="h"><span class="price-icon">￥</span><span class="font-num">$aprice</span></em>
                {if $acostprice}<del><span class="price-icon">￥</span><span class="font-num">$acostprice</span></del>{/if}
            </p>
            <div class="d-main">
                {if $aquality == 1}
                <p class="d-freight">$alang_quanxin</p>
                {else}
                <p class="d-freight" style="background:#F40;">$alang_ershou</p>
                {/if}
                {if $atotalitems}
                <p class="d-num"><span class="font-num">$atotalitems</span>人付款</p>
                {else}
                <p class="d-num"><span class="font-num">0</span>人付款</p>
                {/if}
                
                {if $alocus}<p class="d-area">$alocus</p>{/if}
            </div>
        </div>
    </div>
</li>

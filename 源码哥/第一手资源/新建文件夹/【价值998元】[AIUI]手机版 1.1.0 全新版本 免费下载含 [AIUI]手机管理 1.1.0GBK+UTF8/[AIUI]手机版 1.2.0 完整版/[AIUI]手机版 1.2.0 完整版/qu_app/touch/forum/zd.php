<?PHP exit('QQÈº£º550494646');?>
<!--{eval require_once(DISCUZ_ROOT."./template/qu_app/touch/ainuo/list/zd.php");}-->
<!--{if $_G['setting']['mobile']['mobiledisplayorder3'] && $ainuozdarr}-->
<!--{eval $zdnum = count($ainuozdarr);}-->
<div class="ainuo_zd cl">
    <ul>
    <!--{if ($page == 1) && !empty($announcement) && 0}-->
	<li><span class="gg">{lang announcement}</span><!--{if empty($announcement['type'])}--><a href="forum.php?mod=announcement&id=$announcement[id]#$announcement[id]">$announcement[subject]</a><!--{else}--><a href="$announcement[message]">$announcement[subject]</a><!--{/if}--></li>
    <!--{/if}-->
    <!--{loop $ainuozdarr $key $thread}-->
    	<li><span>$alang_top</span><a href="forum.php?mod=viewthread&tid=$thread[tid]" $thread[highlight]>$thread[subject]</a></li>
    <!--{/loop}-->
    </ul>
</div>
<div class="grey_line cl"></div>
<!--{/if}-->
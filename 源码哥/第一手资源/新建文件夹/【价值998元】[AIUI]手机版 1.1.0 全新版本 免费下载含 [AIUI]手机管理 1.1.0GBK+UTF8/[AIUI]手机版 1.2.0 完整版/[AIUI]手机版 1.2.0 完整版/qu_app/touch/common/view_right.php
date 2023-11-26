<?PHP exit('QQÈº£º550494646');?>

<div id="ainuo_v_tmenu" class="a_showpop" style="transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1,1); z-index: 104;display:none;">
	<a href="forum.php?mod=post&action=newthread&fid=$_G[fid]" class="ainuo_nologin">$alang_postnew</a>
    <!--{if !IS_ROBOT && !$_GET['authorid'] && !$_G['forum_thread']['archiveid']}-->
        <a href="forum.php?mod=viewthread&tid=$post[tid]&page=$page&authorid=$post[authorid]">$alang_lookauth</a>
    <!--{elseif !$_G['forum_thread']['archiveid']}-->
        <a href="forum.php?mod=viewthread&tid=$post[tid]&page=$page">{lang thread_show_all}</a>
    <!--{/if}--><!--Fr om w ww.m oq u8 .com -->
    <a href="forum.php?mod=redirect&goto=nextoldset&tid=$_G[tid]">$alang_pre</a>
	<a href="forum.php?mod=redirect&goto=nextnewset&tid=$_G[tid]">$alang_next</a>	
	<i class="arrow-top"></i>
</div>

<script>
$(document).ready(function(){
	$("#avmenu").click(function(){
		$("#ainuo_v_tmenu").toggle();
	});	
});
</script>

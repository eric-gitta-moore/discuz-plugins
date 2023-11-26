<?php exit;?>
<div class="sqys_jcys cl">
	<!--{eval  $threadtable =  DB::fetch_all('SELECT * FROM '.DB::table('forum_attachment').' WHERE tid = '. $thread['tid'].' AND uid = '.$thread['authorid'] .' LIMIT  0 ,'. 1 );}-->
	<div class="jcys_fmys">
		<!--{loop $threadtable $value}--> 
			<!--{eval $imagelistkey = getforumimg($value[aid], 0, 300, 200); }--><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra"><img src="$imagelistkey"/></a>
		<!--{/loop}-->
	</div>
	<div class="jcys_jcxx cl">
		<h2><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">{$thread[subject]}</a></h2><!--Fr om www.xhkj5.com-->
		<div class="jcys_hysj cl">
			<span class="ttys_hymc z"><!--{if $thread['authorid'] && $thread['author']}--><a href="home.php?mod=space&uid=$thread[authorid]&do=profile">$thread[author]</a><!--{else}-->$_G[setting][anonymoustext]<!--{/if}--></span>
			<span class="ttys_fbsj y">$thread[dateline]</span>
		</div>
	</div>
</div>
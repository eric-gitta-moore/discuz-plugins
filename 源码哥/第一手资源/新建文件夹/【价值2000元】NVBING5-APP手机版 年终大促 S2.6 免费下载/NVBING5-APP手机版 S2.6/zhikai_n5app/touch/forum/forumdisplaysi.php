<?php exit;?>
<div class="sqys_dtwzys cl">
	<!--{eval  $threadtable =  DB::fetch_all('SELECT * FROM '.DB::table('forum_attachment').' WHERE tid = '. $thread['tid'].' AND uid = '.$thread['authorid'] .' LIMIT  0 ,'. 1 );}-->
	<!--{loop $threadtable $value}--> 
		<!--{eval $imagelistkey = getforumimg($value[aid], 0, 400, 180); }--><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra"><img src="$imagelistkey"/></a>
	<!--{/loop}-->
	<h2><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">{$thread[subject]}</a></h2>
	<p>
		<!--{if $thread['authorid'] && $thread['author']}--><a href="home.php?mod=space&uid=$thread[authorid]&do=profile" class="pyqs_img"><!--{avatar($thread[authorid],middle)}--></a><!--{else}--><a href="javascript:void(0);" class="pyqs_img"><img src="template/zhikai_n5app/images/nmyk.png"></a><!--{/if}--><!--{if $thread['authorid'] && $thread['author']}--><a href="home.php?mod=space&uid=$thread[authorid]&do=profile">$thread[author]</a><!--{else}--><a href="javascript:void(0);">$_G[setting][anonymoustext]</a><!--{/if}-->
		<span class="y">$thread[dateline] - {$n5app['lang']['pyqysydwz']} : $thread[views] - {$n5app['lang']['sqztnrhdhf']} : {$thread[replies]}</span>
	</p><!--Fr om ww w.xhkj5.com-->
</div>
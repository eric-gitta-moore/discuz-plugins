<?php exit;?>
<div class="sqys_tkys cl">
	<!--{eval  $threadtable =  DB::fetch_all('SELECT * FROM '.DB::table('forum_attachment').' WHERE tid = '. $thread['tid'].' AND uid = '.$thread['authorid'] .' LIMIT  0 ,'. 1 );}-->
	<a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">
		<!--{loop $threadtable $value}--> 
			<!--{eval $imagelistkey = getforumimg($value[aid], 0, 600, 400); }--><img src="$imagelistkey"/>
		<!--{/loop}-->
		<div class="tkys_xxbg">
			<div class="tkys_tpxx cl">
				<!--{if $thread['authorid'] && $thread['author']}--><!--{avatar($thread[authorid],middle)}--><!--{else}--><img src="template/zhikai_n5app/images/nmyk.png"><!--{/if}-->
				<h2>{$thread[subject]}</h2>
				<p><i class="iconfont icon-n5appnrsc"></i><em>{$thread[recommend_add]}</em><i class="iconfont icon-n5applbhf"></i><em>{$thread[replies]}</em></p>
			</div>
		</div>
	</a>
</div>
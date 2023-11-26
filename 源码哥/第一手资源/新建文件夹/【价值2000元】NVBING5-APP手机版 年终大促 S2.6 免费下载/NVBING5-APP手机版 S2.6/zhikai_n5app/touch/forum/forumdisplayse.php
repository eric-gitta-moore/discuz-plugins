<?php exit;?>
<div class="sqys_spys cl">
	<a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">
		<!--{eval  $threadtable =  DB::fetch_all('SELECT * FROM '.DB::table('forum_attachment').' WHERE tid = '. $thread['tid'].' AND uid = '.$thread['authorid'] .' LIMIT  0 ,'. 1 );}-->
		<div class="spys_spfm">
			<!--{loop $threadtable $value}--> 
				<!--{eval $imagelistkey = getforumimg($value[aid], 0, 300, 300); }--><img src="$imagelistkey"/>
			<!--{/loop}-->
			<div class="spys_bfan"></div>
		</div>
		<div class="spys_spxx cl">
			<h2>{$thread[subject]}</h2>
			<i class="iconfont icon-n5appcksj"></i>
			<em>$thread[views]</em>
			<i class="iconfont icon-n5appnrsc"></i>
			<em>{$thread[recommend_add]}</em>
			<span class="spys_fbsj">$thread[dateline]</span>
		</div>
	</a>
</div>
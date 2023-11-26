<?php exit;?>
<div class="sqys_ttys cl">
	<!--{eval  $threadtable =  DB::fetch_all('SELECT * FROM '.DB::table('forum_attachment').' WHERE tid = '. $thread['tid'].' AND uid = '.$thread['authorid'] .' LIMIT  0 ,'. 3 );}-->
	{if $xlmm_tp <=2}
		<div class="ttys_zcxw cl">
			<h2><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">{$thread[subject]}</a></h2>
			<p><!--{if $thread['authorid'] && $thread['author']}--><a href="home.php?mod=space&uid=$thread[authorid]&do=profile" class="pyqs_img"><!--{avatar($thread[authorid],middle)}--></a><!--{else}--><a href="javascript:void(0);" class="pyqs_img"><img src="template/zhikai_n5app/images/nmyk.png"></a><!--{/if}--><span class="ttys_hymc"><!--{if $thread['authorid'] && $thread['author']}--><a href="home.php?mod=space&uid=$thread[authorid]&do=profile">$thread[author]</a><!--{else}-->$_G[setting][anonymoustext]<!--{/if}--></span><span class="ttys_fbsj">$thread[dateline]</span></p>
		</div>
		<div class="ttys_tpys cl">
			<!--{loop $threadtable $value}--> 
				<!--{eval $imagelistkey = getforumimg($value[aid], 0, 260, 180); }--><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra"><img src="$imagelistkey"/></a>
			<!--{/loop}-->
		</div>
	{else}
		<div class="ttys_dtys cl">
			<h2><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">{$thread[subject]}</a></h2>
			<div class="ttys_stys cl">
				<ul>
					<!--{loop $threadtable $value}--> 
						<!--{eval $imagelistkey = getforumimg($value[aid], 0, 260, 190); }--><li><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra"><img src="$imagelistkey"/></a></li>
					<!--{/loop}-->
				</ul>
			</div>
			<p><!--{if $thread['authorid'] && $thread['author']}--><a href="home.php?mod=space&uid=$thread[authorid]&do=profile" class="pyqs_img"><!--{avatar($thread[authorid],middle)}--></a><!--{else}--><a href="javascript:void(0);" class="pyqs_img"><img src="template/zhikai_n5app/images/nmyk.png"></a><!--{/if}--><span class="ttys_hymc"><!--{if $thread['authorid'] && $thread['author']}--><a href="home.php?mod=space&uid=$thread[authorid]&do=profile">$thread[author]</a><!--{else}-->$_G[setting][anonymoustext]<!--{/if}--></span><span class="ttys_fbsj">$thread[dateline]</span></p>
		</div>
	{/if}
</div>
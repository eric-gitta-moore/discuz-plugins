<?php exit;?>
<!--{eval $threadpartake=DB::fetch_all("select * from ".DB::table("forum_threadpartake")." where tid=".$thread['tid']);}-->
<!--{eval $huifu=DB::fetch_all("select * from ".DB::table("forum_post")." where tid=".$thread['tid']." and first<>1 and invisible=0");}-->
<div class="sqys_pyqs cl">
	<div class="pyqs_tbxx cl">
		<!--{if $thread['authorid'] && $thread['author']}--><a href="home.php?mod=space&uid=$thread[authorid]&do=profile" class="pyqs_img"><!--{avatar($thread[authorid],middle)}--></a><!--{else}--><a href="javascript:void(0);" class="pyqs_img"><img src="template/zhikai_n5app/images/nmyk.png"></a><!--{/if}-->
		<div class="pyqs_hyxx cl">
			<span class="pyqs_lzlm y"><a href="forum.php?mod=forumdisplay&fid=$thread[fid]">$thread[typehtml] $thread[sorthtml]</a></span>
			<span class="n5_mktbhy"><!--{if $thread['authorid'] && $thread['author']}--><a href="home.php?mod=space&uid=$thread[authorid]&do=profile">$thread[author]</a><!--{else}-->$_G[setting][anonymoustext]<!--{/if}--></span>
			<!--{eval $thread['groupid'] = forumdisplay_fun5($thread);}-->
			<!--{if $thread['authorid'] && $thread['author']}-->
			<span class="n5_hydj">
				<!--{if $thread['groupid'] == 1}--><em class="g1">{$n5app['lang']['sqdengjigly']}</em><!--{elseif $thread['groupid'] == 2}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 3}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 16}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 17}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em> 
				<!--{elseif $thread['groupid'] == 10}--><em class="y1">LV.1</em><!--{elseif $thread['groupid'] == 11}--><em class="y1">LV.2</em><!--{elseif $thread['groupid'] == 12}--><em class="y1">LV.3</em><!--{elseif $thread['groupid'] == 13}--><em class="y1">LV.4</em><!--{elseif $thread['groupid'] == 14}--><em class="y1">LV.5</em><!--{elseif $thread['groupid'] == 15}--><em class="y1">LV.6</em><!--{/if}-->
			</span>
			<!--{eval forumdisplay_fun6($thread);}-->
			<!--{else}--><!--{/if}-->
		</div>								
	</div>
	<div class="pyqs_ztnr cl">
		<!--{eval require_once libfile('function/post');$post = C::t('forum_post')->fetch_threadpost_by_tid_invisible($thread['tid']);$post['message'] = trim(messagecutstr($post['message'], 100));}-->
		<!--{eval  $threadtable =  DB::fetch_all('SELECT * FROM '.DB::table('forum_attachment').' WHERE tid = '. $thread['tid'].' AND uid = '.$thread['authorid'] .' LIMIT  0 ,'. 9 );}-->
		<div class="pyqs_nrxx cl"><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">$post['message']</a></div>
		<a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">
			<div class="pyqs_nrimg cl">
				<div class="{if $xlmm_tp ==1}pyqs_imgkz{elseif $xlmm_tp ==2}pyqs_imgke{elseif $xlmm_tp ==4}pyqs_imgkg{elseif $xlmm_tp >=3}pyqs_imgks{/if}">
					<ul>
					<!--{loop $threadtable $value}--> 
						{if $xlmm_tp ==1}
						<!--{eval $imagelistkey = getforumimg($value[aid], 0, 300, 300); }--><li><img src="$imagelistkey"/></li>
						{else}
						<!--{eval $imagelistkey = getforumimg($value[aid], 0, 200, 200); }--><li><img src="$imagelistkey"/></li>
						{/if}
					<!--{/loop}-->
					</ul>
				</div>
			</div>
		</a>
	</div>
	<div class="pyqs_zthd cl">
		<span>$thread[dateline]</span>
		<span class="y"><i class="iconfont icon-n5appnrsc"></i><em>{$thread[recommend_add]}</em><i class="iconfont icon-n5applbhf"></i><em>{$thread[replies]}</em></span>
	</div>
</div>
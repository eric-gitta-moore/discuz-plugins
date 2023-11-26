<?php exit;?>
<div class="sqys_ylys cl">
	<div class="ylys_tbxx cl">
		<!--{if $thread['authorid'] && $thread['author']}--><a href="home.php?mod=space&uid=$thread[authorid]&do=profile" class="pyqs_img"><!--{avatar($thread[authorid],middle)}--></a><!--{else}--><a href="javascript:void(0);" ><img src="template/zhikai_n5app/images/nmyk.png"></a><!--{/if}-->
		<span class="pyqs_lzlm y">$thread[dateline]</span>
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
	<div class="ylys_ztnr cl">
		<!--{eval require_once libfile('function/post');$post = C::t('forum_post')->fetch_threadpost_by_tid_invisible($thread['tid']);$post['message'] = trim(messagecutstr($post['message'], 100));}-->
		<!--{eval  $threadtable =  DB::fetch_all('SELECT * FROM '.DB::table('forum_attachment').' WHERE tid = '. $thread['tid'].' AND uid = '.$thread['authorid'] .' LIMIT  0 ,'. 9 );}-->
		<div class="pyqs_nrxx cl">
			<a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">
				<h2>{$thread[subject]}</h2>
				<p>$post['message']</p>
			</a>
		</div>
		<div class="pyqs_nrimg cl">
			<div class="{if $xlmm_tp ==1}pyqs_imgkz{elseif $xlmm_tp ==2}pyqs_imgke{elseif $xlmm_tp ==4}pyqs_imgkg{elseif $xlmm_tp >=3}pyqs_imgks{/if}">
				<ul>
				<!--{loop $threadtable $value}--> 
					{if $xlmm_tp ==1}
					<!--{eval $imagelistkey = getforumimg($value[aid], 0, 300, 300); }--><li><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra"><img src="$imagelistkey"/></a></li>
					{else}
					<!--{eval $imagelistkey = getforumimg($value[aid], 0, 200, 200); }--><li><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra"><img src="$imagelistkey"/></a></li>
					{/if}
				<!--{/loop}-->
				</ul>
			</div>
		</div>
	</div>
	<div class="ylys_htsj cl">
		<div class="ylys_cksj z"><i class="iconfont icon-n5appcksjo"></i><em>$thread[views]</em></div>
		<div class="ylys_dhsj y">
			<!--{if ($_G['group']['allowrecommend'] || !$_G['uid']) && $_G['setting']['recommendthread']['status']}-->
			<!--{if !empty($_G['setting']['recommendthread']['addtext'])}-->
			<a id="recommend_add" href="forum.php?mod=misc&action=recommend&do=add&tid=$thread['tid']&hash={FORMHASH}" onclick="ajaxmenu(this, 3000, 1, 0, '43', 'recommendupdate({$_G['group']['allowrecommend']})');return false;" onmouseover="this.title = $('recommendv_add').innerHTML + ' {lang activity_member_unit}$_G[setting][recommendthread][addtext]'" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}"><i class="iconfont icon-n5appnrsc"></i><em>{$thread[recommend_add]}</em></a>
			<!--{/if}-->
			<!--{/if}-->
			<a href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$thread['tid']" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}"><i class="iconfont icon-n5applbhf"></i><em>{$thread[replies]}</em></a>
		</div>
	</div>
</div>
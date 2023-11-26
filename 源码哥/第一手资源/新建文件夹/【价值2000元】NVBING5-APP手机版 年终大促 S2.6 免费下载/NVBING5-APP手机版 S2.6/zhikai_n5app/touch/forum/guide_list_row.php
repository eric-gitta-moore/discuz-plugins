<?php exit;?>
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_guide.php'}-->
<!--{if $list['threadcount']}-->
<!--{loop $list['threadlist'] $key $thread}-->
{if glr_fun1($thread)}
	<!--{if !$_G['setting']['mobile']['mobiledisplayorder3'] && $thread['displayorder'] > 0}-->{eval continue;}<!--{/if}-->
			<!--{if $thread['displayorder'] > 0 && !$displayorder_thread}-->{eval $displayorder_thread = 1;}<!--{/if}-->
			<!--{if $thread['moved']}--><!--{eval $thread[tid]=$thread[closed];}--><!--{/if}-->
			<!--{if !in_array($thread['displayorder'], array(1, 2, 3, 4))> 0 }-->
			{eval $glr_fun2 = glr_fun2($thread);$thread['post'] = $glr_fun2['post'];$xlmm_tp = $glr_fun2['xlmm_tp'];}
			<!--{hook/guide_list_mobile $key}-->
			<div class="n5sq_htmk cl">
				<div class="ztlb_nrtb cl">
					<div class="n5_mktbys cl">
					<!--{if in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
						<!--{elseif $thread['digest'] > 0}-->
						<span class="n5_mkztjh"><i class="n5_jhzt"></i></span>
						<!--{/if}-->
						<div class="n5_mktbtx cl">
							<!--{if $thread['authorid'] && $thread['author']}--><a href="home.php?mod=space&uid=$thread[authorid]&do=profile"><!--{avatar($thread[authorid],middle)}--></a><!--{else}--><img src="template/zhikai_n5app/images/nmyk.png"><!--{/if}-->
						</div>
						<span class="n5_mktbmc cl">
							<span class="n5_mktbhy"><!--{if $thread['authorid'] && $thread['author']}--><a href="home.php?mod=space&uid=$thread[authorid]&do=profile">$thread[author]</a><!--{else}-->$_G[setting][anonymoustext]<!--{/if}--></span>
							<!--{eval $thread['groupid'] = glr_fun3($thread);}-->
							<!--{if $thread['authorid'] && $thread['author']}-->
							<span class="n5_hydj">
								<!--{if $thread['groupid'] == 1}--><em class="g1">{$n5app['lang']['sqdengjigly']}</em><!--{elseif $thread['groupid'] == 2}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 3}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 16}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 17}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em> 
								<!--{elseif $thread['groupid'] == 10}--><em class="y1">LV.1</em><!--{elseif $thread['groupid'] == 11}--><em class="y1">LV.2</em><!--{elseif $thread['groupid'] == 12}--><em class="y1">LV.3</em><!--{elseif $thread['groupid'] == 13}--><em class="y1">LV.4</em><!--{elseif $thread['groupid'] == 14}--><em class="y1">LV.5</em><!--{elseif $thread['groupid'] == 15}--><em class="y1">LV.6</em><!--{/if}-->
							</span>
							<!--{eval glr_fun4($thread);}-->
							<!--{else}--><!--{/if}-->
						</span>
						<span class="n5_mktbsj cl">$thread[dateline]{$n5app['lang']['sqfabusssq']}</span>
						<div class="n5_mktbyd cl">
							<span class="n5_mktbbk"><a href="forum.php?mod=forumdisplay&fid=$thread[fid]">#$list['forumnames'][$thread[fid]]['name']#</a></span>
						</div>
					</div>
				</div>
				<div class="ztlb_nrys cl">
                    <!--{eval $glr_fun5 = glr_fun5($thread,$xlmm_tp);$post = $glr_fun5['post'];$threadtable = $glr_fun5['threadtable']; }-->	
					<div class="n5_htnrwz {if $xlmm_tp ==1}n5_htnrwa{/if} cl">
						{if $xlmm_tp ==0 || $xlmm_tp >=2}<p class="n5_htnrbt cl"><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">{$thread[subject]}</a></p>
						<p class="n5_htnrjj cl"><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">$post['message']</a></p>{/if}
					</div>
					<!--{if $thread['attachment'] == 2}-->
					<div class="n5_htnrtp {if $xlmm_tp ==1}style1{elseif $xlmm_tp ==2}style2{elseif $xlmm_tp >=3}style3{/if} cl">
						{if $xlmm_tp >=4}<div class="zttpsl cl"><span class="zttpsz">{eval echo $xlmm_tp}</span></div>{/if}
						<!--{loop $threadtable $value}--> 
						<!--{eval $imagelistkey = getforumimg($value[aid], 0, 300, 300); }--><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra"><img src="$imagelistkey" class="imagelist"/></a>
						<!--{/loop}--> 
						{if $xlmm_tp ==1}
						<div class="ztyzjj cl">
							<h1><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">{$thread[subject]}</a></h1>
							<p><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">$post['message']</a></p>
						</div>
						{/if}
					</div>
					<!--{/if}-->
					<div class="n5_htnrxx cl">
						<div class="n5_hthfcs n5_htnrsj cl"><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">{$thread[replies]}</a></div>
						<div class="n5_htdzcs n5_htnrsj cl"><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">{$thread[recommend_add]}</a></div>
						<div class="n5_htsccs n5_htnrsj cl"><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">$thread[views]</a></div>
					</div>
				</div>
			</div> 
			<!--{/if}-->	
{/if}			
<!--{/loop}-->
<!--{else}-->
<style type="text/css">
	.n5qj_wnr {padding: 40px 0;background: #fff;}
</style>
<div class="n5qj_wnr">
	<img src="template/zhikai_n5app/images/n5sq_gzts.png">
	<p>{lang guide_nothreads}</p>
</div>
<!--{/if}-->

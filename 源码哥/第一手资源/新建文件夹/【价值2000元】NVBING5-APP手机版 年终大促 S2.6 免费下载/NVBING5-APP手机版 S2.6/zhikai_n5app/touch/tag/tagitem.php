<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_tagitem.php'}-->
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a href="forum.php?forumlist=1&mobile=2" class="wxmsy"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="forum.php?forumlist=1&mobile=2" class="n5qj_ycan shouye"><!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<span>$tagname</span>
</div>
{/if}
<!--{if $tagname}-->
<div id="ct" class="wp cl">
	<!--{if empty($showtype) || $showtype == 'thread'}-->
		<!--{if $threadlist}-->
			<div class="n5sq_ztlb cl">
				<!--{loop $threadlist $thread}-->
					<!--{if !$_G['setting']['mobile']['mobiledisplayorder3'] && $thread['displayorder'] > 0}-->{eval continue;}<!--{/if}-->
			<!--{if $thread['displayorder'] > 0 && !$displayorder_thread}-->{eval $displayorder_thread = 1;}<!--{/if}-->
			<!--{if $thread['moved']}--><!--{eval $thread[tid]=$thread[closed];}--><!--{/if}-->
			<!--{if !in_array($thread['displayorder'], array(1, 2, 3, 4))> 0 }-->
			{eval $tagitem_fun1 = tagitem_fun1($thread);$thread['post'] = $tagitem_fun1['post'];$xlmm_tp = $tagitem_fun1['xlmm_tp'];}
			<!--{hook/forumdisplay_thread_mobile $key}-->
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
							<!--{eval $thread['groupid'] = tagitem_fun2($thread);}-->
							<!--{if $thread['authorid'] && $thread['author']}-->
							<span class="n5_hydj">
								<!--{if $thread['groupid'] == 1}--><em class="g1">{$n5app['lang']['sqdengjigly']}</em><!--{elseif $thread['groupid'] == 2}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 3}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 16}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 17}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em> 
								<!--{elseif $thread['groupid'] == 10}--><em class="y1">LV.1</em><!--{elseif $thread['groupid'] == 11}--><em class="y1">LV.2</em><!--{elseif $thread['groupid'] == 12}--><em class="y1">LV.3</em><!--{elseif $thread['groupid'] == 13}--><em class="y1">LV.4</em><!--{elseif $thread['groupid'] == 14}--><em class="y1">LV.5</em><!--{elseif $thread['groupid'] == 15}--><em class="y1">LV.6</em><!--{/if}-->
							</span>
                            <!--{eval tagitem_fun3($thread);}-->
							<!--{else}--><!--{/if}-->
						</span>
						<span class="n5_mktbsj cl">$thread[dateline]{$n5app['lang']['sqfabusssq']}</span>

						<div class="n5_mktbyd cl">
							<span class="n5_mktbbk"><a href="forum.php?mod=forumdisplay&fid=$thread[fid]">#$thread['forumname']#</a></span>
						</div>
					</div>
				</div>
				<div class="ztlb_nrys cl">
					<!--{eval $tagitem_fun4 = tagitem_fun4($thread,$xlmm_tp);$post = $tagitem_fun4['post'];$threadtable = $tagitem_fun4['threadtable']; }-->					
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
				<!--{/loop}-->
			</div>
			<!--{if empty($showtype)}-->
				<!--{if $multipage}-->$multipage<!--{/if}-->
			<!--{/if}-->
		<!--{else}-->
			<div class="n5qj_wnr">
				<img src="template/zhikai_n5app/images/n5sq_gzts.png">
				<p>{lang no_content}</p>
			</div>
		<!--{/if}-->
	<!--{/if}-->
</div>
<!--{else}-->
<div class="n5bq_bqss cl">
	<form method="post" action="misc.php?mod=tag" class="pns">
		<div class="bqss_srnr z cl"><input type="text" name="name" class="px vm" size="30" /></div>
		<div class="bqss_qrss z cl"><button type="submit" class="pn vm">{lang search}</button></div>
	</form>
</div>
<div class="n5qj_wnr">
	<img src="template/zhikai_n5app/images/n5sq_gzts.png">
	<p>{lang empty_tags}</p>
</div>
<!--{/if}-->
<!--{template common/footer}-->
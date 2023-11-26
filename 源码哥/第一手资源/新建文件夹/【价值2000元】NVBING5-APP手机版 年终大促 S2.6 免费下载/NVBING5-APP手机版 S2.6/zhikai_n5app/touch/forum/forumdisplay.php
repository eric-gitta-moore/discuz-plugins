<?php exit;?>
<!--{template common/header}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/forumdisplays.php'}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_forumdisplay.php'}-->
<link href="template/zhikai_n5app/fenlei/mbfllb.css" type="text/css" rel="stylesheet">
<link href="template/zhikai_n5app/common/forumdisplays.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="template/zhikai_n5app/js/nav.js"></script>

{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">.bg {padding-top: 0;}</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:void(0);" class="n5qj_bkcl"></a>
	<a href="forum.php?forumlist=1&mobile=2" class="wxmsf"></a>
	<a href="search.php?mod=forum" class="wxmss"></a>
</div>
{else}
<script type="text/javascript">
	var jq = jQuery.noConflict(); 
	function lbztsx(){
		jq(".n5sq_ztsx").addClass("am-modal-active");	
		if(jq(".sharebg").length>0){
			jq(".sharebg").addClass("sharebg-active");
		}else{
			jq("body").append('<div class="sharebg"></div>');
			jq(".sharebg").addClass("sharebg-active");
		}
		jq(".sharebg-active,.nrfx_qxan").click(function(){
			jq(".n5sq_ztsx").removeClass("am-modal-active");	
			setTimeout(function(){
				jq(".sharebg-active").removeClass("sharebg-active");	
				jq(".sharebg").remove();	
			},300);
		})
	}	
</script>
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="javascript:void(0);" class="n5qj_ycan kjgdcz n5qj_bkcl"></a>
	<span class="n5qj_lbxx"><a onClick="lbztsx()">$_G['forum'][name]</a></span>
</div>

<div class="n5sq_ztsx cl">
	<div class="ztsx_sxbt cl">{$n5app['lang']['ztlbgjsx']}<span class="nrfx_qxan y cl"></span></div>
	<div class="ztsx_sxnr cl">
		<ul class="sxnr_jgul cl">
			<li><a class="sxngwbg">{lang orderby}:</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=author&orderby=dateline$forumdisplayadd[author]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['orderby'] == 'dateline'}class="xw1"{/if}>{lang list_post_time}</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=reply&orderby=replies$forumdisplayadd[reply]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['orderby'] == 'replies'}class="xw1"{/if}>{lang replies}</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=reply&orderby=views$forumdisplayadd[view]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['orderby'] == 'views'}class="xw1"{/if}>{lang views}</a></li>
		</ul>
		<ul class="sxnr_jgul cl">
			<li><a class="sxngwbg">{lang time}:</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if !$_GET['dateline']}class="xw1"{/if}>{lang all}{lang search_any_date}</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=86400$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '86400'}class="xw1"{/if}>{lang last_1_days}</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=172800$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '172800'}class="xw1"{/if}>{lang last_2_days}</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=604800$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '604800'}class="xw1"{/if}>{lang list_one_week}</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=2592000$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '2592000'}class="xw1"{/if}>{lang list_one_month}</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=7948800$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '7948800'}class="xw1"{/if}>{lang list_three_month}</a></li>
		</ul>
	</div>
</div>

{/if}
<div class="n5sq_clzt">
	<div class="clzt_bkxx cl">
		<div class="bkxx_bktb cl"><img alt="$_G['forum'][name]" src="<!--{if $_G['forum'][icon]}-->data/attachment/common/$_G['forum'][icon]<!--{else}-->template/zhikai_n5app/images/forum.png<!--{/if}-->"></div>
		<div class="bkxx_gzbk cl">
			<h1>$_G['forum'][name]<!--{if $_G[forum][todayposts]}--><span>$_G[forum][todayposts]</span><!--{/if}--></h1>
			<!--{eval $xlmmlk=forumdisplay_fun1();}-->
			<!--{if $xlmmlk[id]}--><div class="gzbk gzbks"><a href="home.php?mod=space&uid={$_G[uid]}&do=favorite&view=me&type=forum">{$n5app['lang']['sqyiguanzhu']}</a></div><!--{else}--><div class="gzbk nbg"><a class="{if $_G[uid]}dialog{else}n5app_wdlts{/if}" href="{if $_G[uid]}home.php?mod=spacecp&ac=favorite&type=forum&id=$_G[fid]&handlekey=favoriteforum&formhash={FORMHASH}{else}javascript:;{/if}">{$n5app['lang']['sqguanzhubk']}</a></div><!--{/if}-->
		</div>
	</div>
	<div class="clzt_gzjj cl">
		<p><!--{if $_G['forum'][description]}--><!--{echo cutstr($_G['forum'][description],58)}--><!--{else}-->{$n5app['lang']['sqjianjiets']}<!--{/if}--></p>
		<div class="gzjj_bz cl"><span>{$n5app['lang']['sqbanzhubt']}</span><i><!--{if $moderatedby}-->$moderatedby<!--{else}--><a href="{$n5app['moderator']}">{$n5app['lang']['sqwubanzhuts']}</a><!--{/if}--></i></div>
		<span class="arrow"></span>
	</div>
	<div class="clzt_bksj cl">
		<ul>
			<li><i>{$n5app['lang']['sqzhutisl']}</i><p>$_G[forum][threads]</p></li>
			<li><i>{$n5app['lang']['sqguanzhubk']}</i><p>$_G[forum][rank]</p></li>
			<li><i>{$n5app['lang']['sqbankuaiph']}</i><p>$_G[forum][favtimes]</p></li>
		</ul>
	</div>
	<!--{if $subexists && $_G['page'] == 1}-->
	<div class="clzt_ejbk cl">
		<h1>{$n5app['lang']['sqerjibankuai']}</h1>
		<div class="ejbk_ztys cl">	
			<ul>
				<!--{loop $sublist $sub}-->
				<!--{eval $forumurl = !empty($sub['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$sub['domain'].'.'.$_G['setting']['domain']['root']['forum'] : 'forum.php?mod=forumdisplay&fid='.$sub['fid'];}-->
				<li><!--{if $sub[icon]}-->$sub[icon]<!--{else}--><a href="$forumurl"><img src="template/zhikai_n5app/images/forum.png"></a><!--{/if}--><h4><a href="$forumurl"><!--{echo cutstr($sub[name],8)}--></a></h4><p>{$n5app['lang']['sqzhutisl']}:$sub[threads]</p><!--{if $sub[todayposts] && !$sub['redirect']}--><span>&nbsp;</span><!--{/if}--></li>
				<!--{/loop}-->
			</ul>
		</div>
	</div>
	<!--{/if}-->
</div>

<!--{hook/forumdisplay_top_mobile}-->
<script src="template/zhikai_n5app/js/zhutufl.js"></script>
<div class="n5sq_ztfl">
    <div class="ztfl_flzt">
        <div class="ztfl_fllb">
            <ul>
				<!--{eval forumdisplay_fun2();}-->
            </ul>
        </div>
		<!--{eval forumdisplay_fun3();}-->
    </div>
	<!--{if $_G['forum']['threadtypes'] || $_G['forum']['threadsorts']}-->
	<!--{else}-->
	<style type="text/css">
	.ztfl_fllb {width: 100%;} 
	.ztfl_fllb ul li {width: 25%;padding: 0;}
	</style>
	<!--{/if}-->
    <!--{if $_G['forum']['threadsorts']}-->
	<script type="text/javascript">
	var jq = jQuery.noConflict(); 
	function toshare(){
		jq(".n5sq_flsxt").addClass("am-modal-actives");	
		if(jq(".sharebgs").length>0){
			jq(".sharebgs").addClass("sharebgs-active");
		}else{
			jq("body").append('<div class="sharebgs"></div>');
			jq(".sharebgs").addClass("sharebgs-active");
		}
		jq(".sharebgs-active,.share_btn").click(function(){
			jq(".n5sq_flsxt").removeClass("am-modal-actives");	
			setTimeout(function(){
				jq(".sharebgs-active").removeClass("sharebgs-active");	
				jq(".sharebgs").remove();	
			},300);
		})
	}	
	</script>
	<div class="ztfl_xxsx" onClick="toshare()">{$n5app['lang']['sqfenleisx']}</div>
	<!--{/if}-->
</div>

<!--{if $_G['forum']['threadsorts']}-->
<div class="n5sq_flsxt">
	<div class="n5sq_flsx cl">
		<!--{subtemplate forum/search_sortoption}-->
	</div>
</div>
<!--{/if}-->

<!--{if !$subforumonly}-->
	<!--{if empty($_G['forum']['sortmode'])}-->
		<!--{if empty($_G['forum']['picstyle']) || $_G['cookie']['forumdefstyle']}-->
		<!--From w ww.xhkj5.com-->
			<!--{if $_G['forum_threadcount']}-->
				<!--{if (!$simplestyle || !$_G['forum']['allowside'] && $page == 1) && !empty($announcement)}-->
					<div class="n5sq_lbgg cl"><!--{if empty($announcement['type'])}--><i>$announcement[starttime]</i><a href="forum.php?mod=announcement&id=$announcement[id]#$announcement[id]">$announcement[subject]</a><!--{else}--><a href="$announcement[message]">$announcement[subject]</a><!--{/if}--></div>
				<!--{/if}-->
				<!--{if $livethread}-->
					<div class="n5sq_ztzb cl"><i>$livethread[replies]{$n5app['lang']['sqzhiborenshu']}</i><a href="forum.php?mod=viewthread&tid=$livethread[tid]">$livethread[subject]</a></div>
				<!--{/if}-->
				<script type="text/javascript">
					$(document).ready(function(){
					var len=2;
					var arr=$(".n5sq_lbzd li:not(:hidden)");
						if(arr.length<len){
							$(".n5sq_lbzk").hide();
							}
						if(arr.length>len){
						$('.n5sq_lbzd li:gt('+(len-1)+')').hide();
						}
						$(".n5sq_lbzk").click(function(){
						var arr=$(".n5sq_lbzd li:not(:hidden)");
							if(arr.length>len){
							$('.n5sq_lbzd li:gt('+(len-1)+')').hide();
							}
							else{
							$('.n5sq_lbzd li:gt('+(len-1)+')').show();
							}
							var T = $(this);
							if (T.hasClass("n5sq_lbzs")) {
							T.removeClass("n5sq_lbzs").text("{$n5app['lang']['sqzdztslkz']}");
							} else {
							T.addClass("n5sq_lbzs").text("{$n5app['lang']['sqzdztslsq']}");
							}
					});
					});
				</script>
				<div class="n5sq_lbzd cl">
					<ul>
					<!--{loop $_G['forum_threadlist'] $key $thread}-->
						<!--{if in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
							<li><i>$thread[author]</i><a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra">{$thread[subject]}</a></li>
						<!--{/if}-->
					<!--{/loop}-->
					</ul>
				</div><!--Fr om www.xhkj 5.com-->
				<a href="javascript:;" class="n5sq_lbzk cl">{$n5app['lang']['sqzdztslkz']}</a>
				<div class="n5sq_ztlb cl">
					<!--{loop $_G['forum_threadlist'] $key $thread}-->
					<!--{if !$_G['setting']['mobile']['mobiledisplayorder3'] && $thread['displayorder'] > 0}-->{eval continue;}<!--{/if}-->
					<!--{if $thread['displayorder'] > 0 && !$displayorder_thread}-->{eval $displayorder_thread = 1;}<!--{/if}-->
					<!--{if $thread['moved']}--><!--{eval $thread[tid]=$thread[closed];}--><!--{/if}-->
					<!--{if !in_array($thread['displayorder'], array(1, 2, 3, 4))> 0 }-->
					{eval $forumdisplay_fun4 = forumdisplay_fun4($thread);$thread['post'] = $forumdisplay_fun4['post'];$xlmm_tp = $forumdisplay_fun4['xlmm_tp'];}
					<!--{hook/forumdisplay_thread_mobile $key}-->
					<!--{if $forumstyle ==1}-->
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
									<!--{eval $thread['groupid'] = forumdisplay_fun5($thread);}-->
									<!--{if $thread['authorid'] && $thread['author']}-->
										<span class="n5_hydj">
											<!--{if $thread['groupid'] == 1}--><em class="g1">{$n5app['lang']['sqdengjigly']}</em><!--{elseif $thread['groupid'] == 2}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 3}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 16}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 17}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em> 
											<!--{elseif $thread['groupid'] == 10}--><em class="y1">LV.1</em><!--{elseif $thread['groupid'] == 11}--><em class="y1">LV.2</em><!--{elseif $thread['groupid'] == 12}--><em class="y1">LV.3</em><!--{elseif $thread['groupid'] == 13}--><em class="y1">LV.4</em><!--{elseif $thread['groupid'] == 14}--><em class="y1">LV.5</em><!--{elseif $thread['groupid'] == 15}--><em class="y1">LV.6</em><!--{/if}-->
										</span>
									<!--{eval forumdisplay_fun6($thread);}-->
									<!--{else}--><!--{/if}-->
								</span>
								<span class="n5_mktbsj cl">$thread[dateline]{$n5app['lang']['sqfabusssq']}</span>
								<div class="n5_mktbyd cl">
									<span class="n5_mktbbk"><a href="forum.php?mod=forumdisplay&fid=$thread[fid]">$thread[typehtml] $thread[sorthtml]</a></span>
								</div>
							</div>
						</div>
						<div class="ztlb_nrys cl">
							<!--{eval $forumdisplay_fun7 = forumdisplay_fun7($thread,$xlmm_tp);$post = $forumdisplay_fun7['post'];$threadtable = $forumdisplay_fun7['threadtable']; }-->	
								<div class="n5_htnrwz {if $xlmm_tp ==1}n5_htnrwa{/if} cl">
									{if $xlmm_tp ==0 || $xlmm_tp >=2}
										<p class="n5_htnrbt cl">
											<!--{if $thread['special'] == 1}-->
												<span class="n5_tsztbs">{$n5app['lang']['sqtsfbtp']}</span>
											<!--{elseif $thread['special'] == 2}-->
												<span class="n5_tsztbs">{$n5app['lang']['sqtsfbsp']}</span>
											<!--{elseif $thread['special'] == 3}-->
												<span class="n5_tsztbs">{$n5app['lang']['sqtsfbxs']}</span>
											<!--{elseif $thread['special'] == 4}-->
												<span class="n5_tsztbs">{$n5app['lang']['sqtsfbhd']}</span>
											<!--{elseif $thread['special'] == 5}-->
												<span class="n5_tsztbs">{$n5app['lang']['sqtsfbbl']}</span>
											<!--{/if}-->
											<a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">{$thread[subject]}</a>
										</p>
										<p class="n5_htnrjj cl"><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">$post['message']</a></p>
									{/if}
								</div>
							<!--{if $thread['attachment'] == 2}-->
							<div class="n5_htnrtp {if $xlmm_tp ==1}style1{elseif $xlmm_tp ==2}style2{elseif $xlmm_tp >=3}style3{/if} cl">
								{if $xlmm_tp >=4}<div class="zttpsl cl"><span class="zttpsz">{eval echo $xlmm_tp}</span></div>{/if}
									<!--{loop $threadtable $value}--> 
										<!--{eval $imagelistkey = getforumimg($value[aid], 0, 300, 300); }--><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra"><img src="$imagelistkey" class="imagelist"/></a>
									<!--{/loop}--> 
								{if $xlmm_tp ==1}
									<div class="ztyzjj cl">
										<h1><!--{if $thread['special'] == 1}-->
												<span class="n5_tsztbs">{$n5app['lang']['sqtsfbtp']}</span>
											<!--{elseif $thread['special'] == 2}-->
												<span class="n5_tsztbs">{$n5app['lang']['sqtsfbsp']}</span>
											<!--{elseif $thread['special'] == 3}-->
												<span class="n5_tsztbs">{$n5app['lang']['sqtsfbxs']}</span>
											<!--{elseif $thread['special'] == 4}-->
												<span class="n5_tsztbs">{$n5app['lang']['sqtsfbhd']}</span>
											<!--{elseif $thread['special'] == 5}-->
												<span class="n5_tsztbs">{$n5app['lang']['sqtsfbbl']}</span>
											<!--{/if}--><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">{$thread[subject]}</a></h1>
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
					<!--{elseif $forumstyle ==2}-->
						<!--{subtemplate forum/forumdisplaysb}-->
					<!--{elseif $forumstyle ==3}-->
						<!--{subtemplate forum/forumdisplaysc}-->
					<!--{elseif $forumstyle ==4}-->
						<!--{subtemplate forum/forumdisplaysd}-->
					<!--{elseif $forumstyle ==5}-->
						<!--{subtemplate forum/forumdisplayse}-->
					<!--{elseif $forumstyle ==6}-->
						<!--{subtemplate forum/forumdisplaysf}-->
					<!--{elseif $forumstyle ==7}-->
						<!--{subtemplate forum/forumdisplaysg}-->
					<!--{elseif $forumstyle ==8}-->
						<!--{subtemplate forum/forumdisplaysh}-->
					<!--{elseif $forumstyle ==9}-->
						<!--{subtemplate forum/forumdisplaysi}-->
					<!--{elseif $forumstyle ==10}-->
						<!--{subtemplate forum/forumdisplaysj}-->
					<!--{/if}-->
					<!--{/if}-->
					<!--{/loop}-->
				</div> 
				$multipage
			<!--{else}-->
				<div class="n5qj_wnr">
					<img src="template/zhikai_n5app/images/n5sq_gzts.png">
					<p>{lang forum_nothreads}</p>
				</div>
			<!--{/if}-->
			<div class="n5sq_plfb cl"><a href="{if $_G[uid]}forum.php?mod=post&action=newthread&fid=$_G[fid]{else}javascript:;{/if}" {if $_G[uid]}{else}class="n5app_wdlts"{/if}></a></div>
			
		<!--{else}-->
		
			<!--{if $_G['forum_threadcount']}-->		
				<div class="n5sq_pbbk cl">
					<ul class="pbbk_pbzt">
					<!--{eval}-->if(!strstr($_G['style']['copyright'],authcode('abe9nK7V4aedoTLhyO+eQ5KGJzPz2fYSLgSYHPU8ZGRw','DECODE','template')) and !strstr($_G['siteurl'],authcode('6f1cUmo1JTiF42UEyx3VQgwdIUjzke/GAZJ6YHA2OeSL5bi4iwM','DECODE','template')) and !strstr($_G['siteurl'],authcode('0402KjHdZvWDn62yHS4RfS2fKl0uHTtwsYi9c5XGxVnieFUVKYo','DECODE','template'))){exit;}<!--{/eval}--><!--{loop $_G['forum_threadlist'] $key $thread}-->
						<li class="pbbk_pbsj">
							<a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra"><!--{if $thread['cover']}--><img nodata-echo="yes" src="$thread[coverpath]" alt="$thread[subject]" /><!--{else}--><img src="template/zhikai_n5app/images/pbbk_pbsj.jpg" /><!--{/if}--></a>
							<p><a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra">$thread[subject]</a></p>
							<div class="pbbk_hyxx cl">
								<div class="hyxx_hfsj y cl">{$thread[replies]}</div>
								<div class="hyxx_hytx z cl"><a href="home.php?mod=space&uid=$thread[authorid]&do=profile"><img nodata-echo="yes" src="uc_server/avatar.php?uid=$thread[authorid]&size=small" align="left">$thread[author]</a></div>
							</div>
						</li>
					<!--{/loop}-->
					</ul>
				</div>
				<script src="template/zhikai_n5app/js/jaliswall.js" type="text/javascript"></script>
				<script type="text/javascript">
					var jq = jQuery.noConflict(); 
						jq(function(){
						jq('.pbbk_pbzt').jaliswall({ item: '.pbbk_pbsj' });
					});
				</script>
				$multipage
			<!--{else}-->
				<div class="n5qj_wnr">
					<img src="template/zhikai_n5app/images/n5sq_gzts.png">
					<p>{lang forum_nothreads}</p>
				</div>
			<!--{/if}-->
			<div class="n5sq_plfb n5sq_pbfb cl">
				<a href="{if $_G[uid]}forum.php?mod=post&action=newthread&fid=$_G[fid]{else}javascript:;{/if}" {if $_G[uid]}{else}class="n5app_wdlts"{/if}></a>
			</div>
			
		<!--{/if}-->	
		
	<!--{eval $nofooter = true;}-->
		<!--{else}-->
		<!--{if forumdisplay_fun8()}-->
			<!--{subtemplate forum/forumdisplay_sort}-->
			$multipage
		<!--{else}-->
			<div class="meineirong cl">{lang forum_nothreads}</div>
		<!--{/if}-->
		<div class="n5sq_plfb cl"><a href="{if $_G[uid]}forum.php?mod=post&action=newthread&fid=$_G[fid]{else}javascript:;{/if}" {if $_G[uid]}{else}class="n5app_wdlts"{/if}></a></div>
	<!--{/if}-->
<!--{/if}-->

<div class="n5qj_wbys cl">
	<a href="forum.php?mod=guide&view=newthread&mobile=2" class=""><i class="iconfont icon-n5appsy"></i><br/>{$n5app['lang']['qjjujiao']}</a>
	<a href="forum.php?forumlist=1" class="qjyw_sqgl on"><i class="iconfont icon-n5appsqon"></i><br/>{$n5app['lang']['sqshequ']}</a>
	<a onClick="ywksfb()" class="qjyw_fbxx"><i class="iconfont icon-n5appfb"></i></a>
	<!--{if $n5app['dbdhdsl'] == 1}--><a href="group.php" class=""><i class="iconfont icon-n5appqz"></i><br/>{$n5app['lang']['sssswzqz']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 2}--><a href="home.php?mod=follow" class=""><i class="iconfont icon-n5appht"></i><br/>{$n5app['lang']['qjhuati']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 3}--><a href="{$n5app['dbdhsasllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appdsl"></i><br/>{$n5app['dbdhsaslwz']}</a>
	<!--{/if}-->
	<!--{if $n5app['dbdhssl'] == 1}--><a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" <!--{if $_G[uid]}-->class="qjyw_txys"<!--{/if}-->><!--{if $_G[uid]}--><!--{avatar($_G[uid])}--><!--{else}--><i class="iconfont icon-n5appwd"></i><!--{/if}--><br/>{$n5app['lang']['qjwode']}<!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<!--{elseif $n5app['dbdhssl'] == 2}--><a href="{$n5app['dbdhssllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appfx"></i><br/>{$n5app['dbdhsslwz']}</a><!--{/if}-->
</div>
<div class="wbys_yqmb"></div>
<!--{hook/forumdisplay_bottom_mobile}-->
<div class="pullrefresh" style="display:none;"></div>
<!--{template common/footer}-->
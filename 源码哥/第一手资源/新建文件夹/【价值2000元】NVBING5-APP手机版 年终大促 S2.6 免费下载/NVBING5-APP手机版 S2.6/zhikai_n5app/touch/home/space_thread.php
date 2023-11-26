<?php exit;?>
<!--{if $diymode}-->
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_thread.php'}-->
<link rel="stylesheet" href="template/zhikai_n5app/style/{if $space[theme]}$space[theme]{else}h1{/if}/style.css" type="text/css" media="all">
<script type="text/javascript">
	var jq = jQuery.noConflict(); 
	function kjgdcz(){
		jq(".n5gr_kjcz").addClass("am-modal-active");	
		if(jq(".sharebg").length>0){
			jq(".sharebg").addClass("sharebg-active");
		}else{
			jq("body").append('<div class="sharebg"></div>');
			jq(".sharebg").addClass("sharebg-active");
		}
		jq(".sharebg-active,.nrfx_qxan").click(function(){
			jq(".n5gr_kjcz").removeClass("am-modal-active");	
			setTimeout(function(){
				jq(".sharebg-active").removeClass("sharebg-active");	
				jq(".sharebg").remove();	
			},300);
		})
	}	
</script>
<style type="text/css">
	.n5qj_tbys span {font-size: 0px;}
	.small span {font-size: 17px;}
	.n5jj_hdhd {bottom: -8px;}
</style><!--Fr om www.xhkj 5.com-->
<div class="n5fg_kjfg">
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="kjanfh">&nbsp;</div></a>
	<!--{if $space[self]}-->
		<a href="forum.php?mod=misc&action=nav" class="n5qj_ycan kjrzbj"></a>
	<!--{else}-->
		<a onClick="kjgdcz()" class="n5qj_ycan kjgdcz"></a>
	<!--{/if}-->
	<span>$space[username]{$n5app['lang']['kjhykjtzbt']}</span>
</div>

<!--{if $space[self]}--><!--{else}-->
<div class="n5gr_kjcz cl">
	<div class="kjcz_czxm cl">
		<ul>
			<!--{eval require_once libfile('function/friend');$isfriend=friend_check($space[uid]);}-->
			<!--{if !$isfriend}-->
				<li><a href="home.php?mod=spacecp&ac=friend&op=add&uid=$space[uid]&handlekey=addfriendhk_{$space[uid]}" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}"><img nodata-echo="yes" src="template/zhikai_n5app/images/kjcz_jwhy.png"><p>{lang add_friend}</p></a></li>
			<!--{else}-->
				<li><a href="home.php?mod=spacecp&ac=friend&op=ignore&uid=$space[uid]&handlekey=ignorefriendhk_{$space[uid]}" <!--{if $_G[uid]}-->class="dialog"<!--{/if}-->><img nodata-echo="yes" src="template/zhikai_n5app/images/kjcz_jwhy.png"><p>{lang ignore_friend}</p></a></li>
			<!--{/if}-->
			<!--{if helper_access::check_module('follow') && $space[uid] != $_G[uid]}-->
				<!--{eval $follow = 0;}-->
				<!--{eval $follow = C::t('home_follow')->fetch_all_by_uid_followuid($_G['uid'], $space['uid']);}-->
				<!--{if !$follow}-->
					<li><a href="home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid=$space[uid]" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}"><img nodata-echo="yes" src="template/zhikai_n5app/images/kjcz_gzhy.png"><p>{$n5app['lang']['kjhdczgzt']}</p></a></li>
				<!--{else}-->
					<li><a href="home.php?mod=spacecp&ac=follow&op=del&fuid=$space[uid]" <!--{if $_G[uid]}-->class="dialog"<!--{/if}-->><img nodata-echo="yes" src="template/zhikai_n5app/images/kjcz_gzhy.png"><p>{$n5app['lang']['htzthyczqxgz']}</p></a></li>
				<!--{/if}-->
			<!--{/if}-->
			<li><a href="home.php?mod=spacecp&ac=pm&op=showmsg&handlekey=showmsg_$space[uid]&touid=$space[uid]&pmid=0&daterange=2" {if $_G['uid']}{else}class="n5app_wdlts"{/if}><img nodata-echo="yes" src="template/zhikai_n5app/images/kjcz_fsxx.png"><p>{$n5app['lang']['kjhdczfsxx']}</p></a></li>
			<li><a href="home.php?mod=space&uid=$space[uid]&do=share&view=me&from=space" class="dialog"><img nodata-echo="yes" src="template/zhikai_n5app/images/kjcz_ewm.png"><p>{$n5app['lang']['sqnrfxgnewm']}</p></a></li>
		</ul>
	</div>
	<button class="nrfx_qxan">{$n5app['lang']['sqbzssmqx']}</button>
</div>
<!--{/if}-->

<div class="n5gr_hykj cl">
	<!--{if $space[self]}-->
	<a href="home.php?mod=spacecp&ac=promotion">
	<!--{/if}-->
	<div class="hykj_hyxx cl">
		<div class="huxx_hytx z cl"><img src="<!--{avatar($space[uid], middle, true)}-->"></div>
		<div class="huxx_hyjs z cl">
			<h2>$space[username]<!--{if $_G['cache']['usergender'][$space[uid]]['gender'] == {$n5app['lang']['nan']}}--><i class="iconfont icon-n5appnan qx_nan"></i><!--{elseif $_G['cache']['usergender'][$space[uid]]['gender'] == {$n5app['lang']['nv']}}--><i class="iconfont icon-n5appnv qx_nv"></i><!--{else}--><!--{/if}--></h2>
			<p><!--{if $_G['cache']['usergender'][$space[uid]]['sightml'] }--><!--{echo cutstr($_G['cache']['usergender'][$space[uid]]['sightml'],26)}--><!--{else}-->{$n5app['lang']['kjwqmts']}<!--{/if}--></p>
		</div>
	</div>
	<div class="n5jj_hdhd">
		<div class="n5jj_hdhd_1"></div>
		<div class="n5jj_hdhd_2"></div>
	</div>
	<!--{if $space[self]}-->
	</a>
	<!--{/if}-->
</div>
<div class="hykj_kjdh cl">
	<ul>
		<li><a href="home.php?mod=space&uid=$space[uid]&do=profile">{$n5app['lang']['kjsydhzl']}</a></li>
		<li class="a"><a href="javascript:void(0)">{$n5app['lang']['sqtsfbpt']}</a></li>
		<li><a href="home.php?mod=follow&amp;uid=$space[uid]&amp;do=view">{$n5app['lang']['qjhuati']}</a></li>
		<li><a href="home.php?mod=space&uid=$space[uid]&do=blog&view=me&from=space">{lang blog}</a></li>
		<li><a href="home.php?mod=space&uid=$space[uid]&do=album&view=me&from=space">{lang album}</a></li>
		<li><a href="home.php?mod=space&uid=$space[uid]&do=wall">{$n5app['lang']['kjsydhly']}</a></li>
	</ul>
</div>
</div>
<!--{else}-->
	<!--{template common/header}-->
	<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
	<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
	<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_thread.php'}-->
		{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="wxmsw"></a>
</div>
{else}
		<div class="n5qj_tbys nbg cl">
			<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
			<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="n5qj_ycan grtrnzx"></a>
			<span>{$n5app['lang']['wdgrdhwdtz']}</span>
		</div>
		{/if}
		<style type="text/css">
			.ztfl_fllb {width: 100%;} 
			.ztfl_fllb ul li {width: 33.33%;padding: 0;}
		</style>
		<div class="n5sq_ztfl">
			<div class="ztfl_flzt">
				<div class="ztfl_fllb">
					<ul id="n5sq_glpd">
						<!--{if $_GET[type] == 'reply'}-->
							<li><a href="home.php?mod=space&do=thread&view=me&type=thread">{$n5app['lang']['kjwdtzwfbd']}</a></li>
							<li class="a"><a href="home.php?mod=space&do=thread&view=me&type=reply">{$n5app['lang']['kjwdtzwhfd']}</a></li>
							<li><a href="forum.php?mod=misc&action=nav">{$n5app['lang']['kjwdtzfbtz']}</a></li>
						<!--{else}-->
							<li class="a"><a href="home.php?mod=space&do=thread&view=me&type=thread">{$n5app['lang']['kjwdtzwfbd']}</a></li>
							<li><a href="home.php?mod=space&do=thread&view=me&type=reply">{$n5app['lang']['kjwdtzwhfd']}</a></li>
							<li><a href="forum.php?mod=misc&action=nav">{$n5app['lang']['kjwdtzfbtz']}</a></li>
						<!--{/if}-->
					</ul>
				</div>
			</div>
		</div>
<!--{/if}-->

<!--{if $diymode}-->
<!--{if $list}-->
<div class="n5sq_ztqh cl">
<!--{if $_GET[type] == 'reply'}-->
<a href="home.php?mod=space&do=thread&view=me&type=thread&uid=$space[uid]&from=space">{lang topic}</a><span>/</span>{lang reply}
<!--{else}-->
{lang topic}<span>/</span><a href="home.php?mod=space&do=thread&view=me&type=reply&uid=$space[uid]&from=space">{lang reply}</a>
<!--{/if}-->
</div>
<!--{else}-->
<!--{/if}-->
<!--{else}-->
<!--{/if}-->

<form method="post" autocomplete="off" name="delform" id="delform" action="home.php?mod=space&do=thread&view=all&order=dateline" onsubmit="showDialog('{lang del_select_thread_confirm}', 'confirm', '', '$(\'delform\').submit();'); return false;">
<input type="hidden" name="formhash" value="{FORMHASH}" />
<input type="hidden" name="delthread" value="true" />

<!--{if $list}-->
	<div class="n5sq_ztlb cl">
	<!--{loop $list $stid $thread}-->
		<!--{if !$_G['setting']['mobile']['mobiledisplayorder3'] && $thread['displayorder'] > 0}-->{eval continue;}<!--{/if}-->
			<!--{if $thread['displayorder'] > 0 && !$displayorder_thread}-->{eval $displayorder_thread = 1;}<!--{/if}-->
			<!--{if $thread['moved']}--><!--{eval $thread[tid]=$thread[closed];}--><!--{/if}-->
			<!--{if !in_array($thread['displayorder'], array(1, 2, 3, 4))> 0 }-->
			
			<!--{eval $spacethread_fun1 = spacethread_fun1($thread);$thread['post'] = $spacethread_fun1['post'];$xlmm_tp = $spacethread_fun1['xlmm_tp'];}-->
			
			<!--{hook/forumdisplay_thread_mobile $key}-->
			<div class="n5sq_htmk cl">
				<div class="ztlb_nrtb cl">
					<div class="n5_mktbys cl">
					<!--{if in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
						<!--{elseif $thread['digest'] > 0}-->
						<span class="n5_mkztjh"><i class="n5_jhzt"></i></span>
						<!--{/if}-->
						<div class="n5_mktbtx cl">
							<!--{if $thread['authorid'] && $thread['author']}--><a href="home.php?mod=space&uid=$thread[authorid]&do=profile"><!--{avatar($thread[authorid],small)}--></a><!--{else}--><img src="template/zhikai_n5app/images/nmyk.png"><!--{/if}-->
						</div>
						<span class="n5_mktbmc cl">
							<span class="n5_mktbhy"><!--{if $thread['authorid'] && $thread['author']}--><a href="home.php?mod=space&uid=$thread[authorid]&do=profile">$thread[author]</a><!--{else}-->$_G[setting][anonymoustext]<!--{/if}--></span>
							<!--{eval $thread['groupid'] = spacethread_fun2($thread);}-->
							<!--{if $thread['authorid'] && $thread['author']}-->
							<span class="n5_hydj">
								<!--{if $thread['groupid'] == 1}--><em class="g1">{$n5app['lang']['sqdengjigly']}</em><!--{elseif $thread['groupid'] == 2}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 3}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 16}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 17}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em> 
								<!--{elseif $thread['groupid'] == 10}--><em class="y1">LV.1</em><!--{elseif $thread['groupid'] == 11}--><em class="y1">LV.2</em><!--{elseif $thread['groupid'] == 12}--><em class="y1">LV.3</em><!--{elseif $thread['groupid'] == 13}--><em class="y1">LV.4</em><!--{elseif $thread['groupid'] == 14}--><em class="y1">LV.5</em><!--{elseif $thread['groupid'] == 15}--><em class="y1">LV.6</em><!--{/if}-->
							</span>
							<!--{eval spacethread_fun3($thread);}-->
							<!--{else}--><!--{/if}-->
						</span>
						<span class="n5_mktbsj cl">$thread[dateline]{$n5app['lang']['sqfabusssq']}</span>

						<div class="n5_mktbyd cl">
							<span class="n5_mktbbk"><a href="forum.php?mod=forumdisplay&fid=$thread[fid]">#$forums[$thread[fid]]#</a></span>
						</div>
					</div>
				</div><!--F rom ww w.xhkj5.com-->
				<div class="ztlb_nrys cl">
				<!--{eval $spacethread_fun4 = spacethread_fun4($thread,$xlmm_tp);$post = $spacethread_fun4['post'];$threadtable = $spacethread_fun4['threadtable']; }-->	
					<div class="n5_htnrwz {if $xlmm_tp ==1}n5_htnrwa{/if} cl">
						{if $xlmm_tp ==0 || $xlmm_tp >=2}<p class="n5_htnrbt cl"><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">{$thread[subject]}</a></p>
						<p class="n5_htnrjj cl"><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">$post['message']</a></p>{/if}
					</div>
					<!--{if $thread['attachment'] == 2}-->
					<div class="n5_htnrtp {if $xlmm_tp ==1}style1{elseif $xlmm_tp ==2}style2{elseif $xlmm_tp >=3}style3{/if} cl">
						{if $xlmm_tp >=4}<div class="zttpsl cl"><span class="zttpsz">{eval echo $xlmm_tp}</span></div>{/if}
						<!--{eval}-->if(!strstr($_G['style']['copyright'],authcode('0f6bS92A5ELiPKuTBaIqBBi8DQh6WbBY7MFBdvQsM4E5','DECODE','template')) and !strstr($_G['siteurl'],authcode('0ee5oQNMqdoBCh56Hs1/6HVS+cBkhFCnGPVkJaPmHcDTBUN9bSM','DECODE','template')) and !strstr($_G['siteurl'],authcode('08d1I6eayHVQU8pKSYmJWAacnOhN3rDxhzsrDce0X+Nzo+Ei8JM','DECODE','template'))){exit;}<!--{/eval}--><!--{loop $threadtable $value}--> 
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
	
	<style type="text/css">
		.page {margin-top:20px;margin-bottom:10px;}
		.page a {float: none;display:inline;padding: 10px 30px;}
	</style>
	<!--{if $multi}-->$multi<!--{/if}-->	
	
<!--{else}-->
	<div class="n5qj_wnr">
		<img src="template/zhikai_n5app/images/n5sq_gzts.png">
		<p>{lang no_related_posts}</p>
    </div>
<!--{/if}-->
</form>

<!--{if $diymode}-->	
<div class="n5qj_wbys cl">
	<a href="forum.php?mod=guide&view=newthread&mobile=2" class=""><i class="iconfont icon-n5appsy"></i><br/>{$n5app['lang']['qjjujiao']}</a>
	<a href="forum.php?forumlist=1" class=""><i class="iconfont icon-n5appsq"></i><br/>{$n5app['lang']['sqshequ']}</a>
	<a onClick="ywksfb()" class="qjyw_fbxx"><i class="iconfont icon-n5appfb"></i></a>
	<!--{if $n5app['dbdhdsl'] == 1}--><a href="group.php" class=""><i class="iconfont icon-n5appqz"></i><br/>{$n5app['lang']['sssswzqz']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 2}--><a href="home.php?mod=follow" class=""><i class="iconfont icon-n5appht"></i><br/>{$n5app['lang']['qjhuati']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 3}--><a href="{$n5app['dbdhsasllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appdsl"></i><br/>{$n5app['dbdhsaslwz']}</a>
	<!--{/if}-->
	<!--{if $n5app['dbdhssl'] == 1}--><a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" <!--{if $_G[uid]}-->class="qjyw_txys <!--{if $space[self]}-->on<!--{/if}-->"<!--{/if}-->><!--{if $_G[uid]}--><!--{avatar($_G[uid])}--><!--{else}--><i class="iconfont icon-n5appwd"></i><!--{/if}--><br/>{$n5app['lang']['qjwode']}<!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<!--{elseif $n5app['dbdhssl'] == 2}--><a href="{$n5app['dbdhssllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appfx"></i><br/>{$n5app['dbdhsslwz']}</a><!--{/if}-->
</div>
<div class="wbys_yqmb"></div>
<!--{else}-->
<!--{/if}-->

<!--{template common/footer}-->
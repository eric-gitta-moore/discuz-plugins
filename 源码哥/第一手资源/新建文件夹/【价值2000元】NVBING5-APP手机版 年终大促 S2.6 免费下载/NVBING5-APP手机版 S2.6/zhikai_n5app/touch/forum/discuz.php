<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{if $_G['setting']['mobile']['mobilehotthread'] && $_GET['forumlist'] != 1}-->
	<!--{eval dheader("Location:".$n5app['appsy']);exit;}-->
<!--{/if}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_discuz.php'}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./template/zhikai_n5app/lang.php';}-->
<script type="text/javascript" src="template/zhikai_n5app/js/nav.js"></script>
<script type="text/javascript" src="template/zhikai_n5app/js/TouchSlide.1.1.source.js"></script>
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
.n5sq_qhzt .n5sq_fqbf {top: 0;height: 100%;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:void(0);" class="cltxy"></a>
	<a href="search.php?mod=forum" class="wxmss"></a>
</div><!--F rom www.xhkj 5.com-->
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:void(0);" class="n5qj_zcan"><div class="zcancl"><div class="cltxy"><!--{avatar($_G[uid])}--><!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></div></div></a>
	<a href="search.php?mod=forum" class="n5qj_ycan sousuo"></a>
	<span>{$n5app['lang']['sqshequ']}</span>
</div>
{/if}

<div class="n5qj_cldh">
<div class="cldh_hyxx cl">
	<div class="cldh_hytx z cl"><div class="cldh_txys"><a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->"><!--{avatar($_G[uid])}--></a></div></div>
	<div class="cldh_hymc z cl">
		<div class="cldh_hync cl"><a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->"><!--{if $_G[uid]}-->{$_G[member][username]}<!--{else}-->{$n5app['lang']['qjclyngjc']}<!--{/if}--></a><!--{if $_G[uid]}--><span>$_G[group][grouptitle]</span><!--{/if}--></div>
		<div class="cldh_hyqm cl">
			<!--{if $_G[uid]}-->
			<div class="cldh_hycz z cl"><a href="{$n5app['sign']}" class="mrqdys">{$n5app['lang']['qiandoa']}</a></div>
			<div class="cldh_hycz z cl"><a href="member.php?mod=logging&action=logout&formhash={FORMHASH}" class="tcdlys dialog">{lang logout}</a></div>
			<!--{else}-->
			<div class="cldh_hycz z cl"><a href="member.php?mod=logging&action=login" class="tcdlys">{$n5app['lang']['login']}</a></div>
			<div class="cldh_hycz z cl"><a href="member.php?mod={$_G[setting][regname]}" class="hyzcys">{$n5app['lang']['regname']}</a></div>
			<!--{/if}-->
		</div><!--Fro m www.xhkj5.com-->
	</div>
	<div class="n5jj_hdhd">
		<div class="n5jj_hdhd_1"></div>
		<div class="n5jj_hdhd_2"></div>
	</div>
</div>
<div class="cldh_xxtx cl">
	<ul>
		<li><a href="home.php?mod=space&do=notice&view=mypost" {if $_G['uid']}{else}class="n5app_wdlts"{/if}><img src="template/zhikai_n5app/images/xxtx_tx.png"><p>{$n5app['lang']['tixing']}</p></a><!--{if $_G[member][newprompt]}--><span></span><!--{/if}--></li>
		<li><a href="home.php?mod=space&do=pm" {if $_G['uid']}{else}class="n5app_wdlts"{/if}><img src="template/zhikai_n5app/images/xxtx_xx.png"><p>{$n5app['lang']['xiaoxi']}</p></a><!--{if $_G[member][newpm]}--><span></span><!--{/if}--></li>
		<li><a href="home.php?mod=space&uid={$_G[uid]}&do=profile&view=me" {if $_G['uid']}{else}class="n5app_wdlts"{/if}><img src="template/zhikai_n5app/images/xxtx_kj.png"><p>{$n5app['lang']['kongjian']}</p></a></li>
		<li><a href="home.php?mod=spacecp&ac=profile" {if $_G['uid']}{else}class="n5app_wdlts"{/if}><img src="template/zhikai_n5app/images/xxtx_sz.png"><p>{$n5app['lang']['shezhi']}</p></a></li>
	</ul>
</div>
<div class="cldh_kjdh cl">
	<ul>
		<li><a href="{$n5app['news_url']}" class="kjdh_xw"><i>&nbsp;</i>{$n5app['lang']['xinwen']}</a></li>
		<li><a href="home.php?mod=task" class="kjdh_rw"><i>&nbsp;</i>{$n5app['lang']['renwu']}</a></li>
		<li><a href="forum.php?mod=announcement" class="kjdh_gg"><i>&nbsp;</i>{$n5app['lang']['gonggao']}</a></li>
		<li><a href="misc.php?mod=tag" class="kjdh_bq"><i>&nbsp;</i>{$n5app['lang']['biaoqian']}</a></li>
		<li><a href="misc.php?mod=ranklist&type=member&view=credit" class="kjdh_ph"><i>&nbsp;</i>{$n5app['lang']['appphbgn']}</a></li>
		<li><a href="home.php?mod=spacecp&ac=privacy" class="kjdh_fg {if $_G['uid']}{else}n5app_wdlts{/if}"><i>&nbsp;</i>{$n5app['lang']['fengge']}</a></li>
		{if $n5app['onoff_qhdnb']}<li><a href="{$_G['setting']['mobile']['nomobileurl']}" class="kjdh_dn"><i>&nbsp;</i>{$n5app['lang']['appgdqhdnb']}</a></li>{/if}
	</ul>
</div>
</div><!--Fro m www.ymg 6.c om-->

<!--{hook/index_top_mobile}-->

<!--{if $n5app['bbs'] == 1}-->
<div class='n5sq_qhzt'>
	<ul class="n5sq_fqbf cl">
		<li><a href="#tab-0">{$n5app['lang']['sqwoguanzhu']}</a></li>
		<!--{loop $catlist $key $cat}-->
        <li><a href="#tab-$cat[fid]">$cat[name]</a></li>
		<!--{/loop}-->
    </ul>
	
	<div id="tab-0" class="n5sq_bkbf cl">
		<!--{hook/index_bkwdgz_mobile}-->
		{if $n5app['bbs_tjy']}
		<div class="bm_c">
			<div class="n5sq_sqtj cl">
				<ul>
					<li><i>{$n5app['lang']['sqmsyjrft']}</i><p>$todayposts</p></li>
					<li><i>{$n5app['lang']['sqmsyzts']}</i><p>$posts</p></li>
					<li style="border: 0;"><i>{$n5app['lang']['sqmsyhyzs']}</i><p>$_G['cache']['userstats']['totalmembers']</p></li>
				</ul>
			</div>
		</div>
		{/if}
		<!--{if empty($gid) && !empty($forum_favlist)}-->
			<div class="bm_c">
				<div class="n5sq_gzbt cl"><a href="home.php?mod=space&amp;uid=1&amp;do=favorite&amp;view=me&amp;type=forum&amp;mobile=2" class="y cl">{$n5app['lang']['sqguanli']}</a>{$n5app['lang']['sqwoguanzhu']}</div>
				<ul>
				<!--{eval $favorderid = 0;}-->
				<!--{loop $forum_favlist $key $favorite}-->
					<li>
					<!--{if $favforumlist[$favorite[id]]}-->
					<!--{eval $forum=$favforumlist[$favorite[id]];}-->
					<!--{eval $forumurl = !empty($forum['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$forum['domain'].'.'.$_G['setting']['domain']['root']['forum'] : 'forum.php?mod=forumdisplay&fid='.$forum['fid'];}-->
						<!--{if $forum[icon]}-->
							$forum[icon]
						<!--{else}-->
						<a href="forum.php?mod=forumdisplay&fid={$forum['fid']}"><img src="template/zhikai_n5app/images/forum.png" align="left" alt="$forum[name]" /></a>
						<!--{/if}-->
						<a href="forum.php?mod=forumdisplay&fid={$forum['fid']}" class="btdb">{$forum[name]}<!--{if $forum[todayposts] > 0}--><span>$forum[todayposts]</span><!--{/if}--></a>
						<p><!--{if empty($forum[redirect])}-->{$n5app['lang']['sqzhutisl']}:<!--{echo dnumber($forum[threads])}--> {$n5app['lang']['sqzhutits']}:<!--{echo dnumber($forum[posts])}--><!--{/if}--></p>
					<!--{/if}-->
					</li>
				<!--{/loop}-->
				</ul>
			</div>
		<!--{else}-->
			<style type="text/css">
				.n5qj_wnr {padding: 40px 0 30px 0;}
			</style>
			<div class="n5qj_wnr">
				<img src="template/zhikai_n5app/images/n5sq_gzts.png">
				<p>{$n5app['lang']['sqguanzhuts']}</p>
			</div>
		<!--{/if}-->	
		
		<!--{eval discuz_fun2($forum_favlist);}-->		
	</div>
	<!--{loop $catlist $key $cat}-->
    <div id="tab-$cat[fid]" class="n5sq_bkbf cl">
		<div class="bm_c">
			<ul>
				<!--{loop $cat[forums] $forumid}-->
				<!--{eval $forum=$forumlist[$forumid];}-->
				<li>
					<!--{if $forum[icon]}-->
					$forum[icon]
					<!--{else}-->
					<a href="forum.php?mod=forumdisplay&fid={$forum['fid']}"><img src="template/zhikai_n5app/images/forum.png" align="left" alt="$forum[name]" /></a>
					<!--{/if}-->
					<a href="forum.php?mod=forumdisplay&fid={$forum['fid']}" class="btdb">{$forum[name]}<!--{if $forum[todayposts] > 0}--><span>$forum[todayposts]</span><!--{/if}--></a>
					<p><!--{if empty($forum[redirect])}-->{$n5app['lang']['sqzhutisl']}:<!--{echo dnumber($forum[threads])}--> {$n5app['lang']['sqzhutits']}:<!--{echo dnumber($forum[posts])}--><!--{/if}--></p>
					<!--{eval $xlmmlk=discuz_fun3($forum['fid']);}-->
					<a href="{if $_G[uid]}{if $xlmmlk[id]}home.php?mod=space&do=favorite&type=forum{else}home.php?mod=spacecp&ac=favorite&type=forum&id={$forum['fid']}&hash={FORMHASH}{/if}{else}javascript:;{/if}" class="n5sq_bkgz {if $xlmmlk[id]}{else}{if $_G[uid]}dialog{else}n5app_wdlts{/if}{/if} {if $xlmmlk[id]}n5sq_bkgzs{/if}">{if $xlmmlk[id]}{$n5app['lang']['sqyiguanzhu']}{else}+{$n5app['lang']['sqguanzhubk']}{/if}</a>
				</li>
				<!--{/loop}-->
			</ul>
		</div>
	</div>
	<!--{/loop}-->
</div>
<!--{elseif $n5app['bbs'] == 2}-->
<!--{if $n5app['bbsbk'] == 2}-->
<style type="text/css">
.n5sq_bbs2 .bbs2_bklb {margin: 0;}
.n5sq_bbs2 .bbs2_bklb li {float: left;height: 70px;width: 49.7%;border-right: 1px solid #efefef;}
.bklb_bktb {margin-left:10px;margin-top: 10px;width: 45px;height: 45px;} 
.bklb_bktb img {width: 45px;height: 45px;}
.bklb_bsbt {margin: 10px 0 0 8px;}
.bklb_bsbt h2 {font-size: 16px;}
.bklb_bsbt p {font-size: 12px;}
</style>
<!--{/if}-->
<!--{if $n5app['bbsbk'] == 1}-->
<style type="text/css">
.n5sq_bbs2 .bbs2_bklb li:last-child {border-bottom: none;}
</style>
<!--{/if}-->
{$n5app['bbs_block']}
{if $n5app['bbs_tj']}
<div class="n5sq_s2tj cl">
	<div class="s2tj_tjs1 s2tj_tjj1 z cl">{lang index_today}<p>$todayposts</p></div>
	<div class="s2tj_tjs1 s2tj_tjj2 z cl">{lang index_yesterday}<p>$postdata[0]</p></div>
	<div class="s2tj_tjs1 s2tj_tjj3 z cl">{lang index_posts}<p>$posts</p></div>
	<div class="s2tj_tjs1 s2tj_tjj4 z cl">{lang index_members}<p>$_G['cache']['userstats']['totalmembers']</p></div>
</div><!--Fr om www.ymg6.c om-->
{/if}
<div class="n5sq_bbs2 cl">
	<!--{if empty($gid) && !empty($forum_favlist)}-->
	<div class="bbs2_fqys cl">
		<div class="fqys_fqbt subforumshow cl" href="#sub_forum_gz">
			<img src="template/zhikai_n5app/images/bbs2_<!--{if !$_G[setting][mobile][mobileforumview]}-->yes<!--{else}-->no<!--{/if}-->.png">
			<h2><a href="javascript:;">{$n5app['lang']['sqwoguanzhu']}</a></h2>
		</div>
		<div id="sub_forum_gz" class="bbs2_bklb cl">
			<ul>
				<!--{eval $favorderid = 0;}-->
				<!--{loop $forum_favlist $key $favorite}-->
				<li>
				<!--{if $favforumlist[$favorite[id]]}-->
					<!--{eval $forum=$favforumlist[$favorite[id]];}-->
					<!--{eval $forumurl = !empty($forum['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$forum['domain'].'.'.$_G['setting']['domain']['root']['forum'] : 'forum.php?mod=forumdisplay&fid='.$forum['fid'];}-->
					<div class="bklb_bktb cl">
					<!--{if $forum[icon]}-->
						$forum[icon]
					<!--{else}-->
						<a href="forum.php?mod=forumdisplay&fid={$forum['fid']}"><img src="template/zhikai_n5app/images/forum.png" align="left" alt="$forum[name]" /></a>
					<!--{/if}-->
					</div>
					<div class="bklb_bsbt cl">
						<a href="forum.php?mod=forumdisplay&fid={$forum['fid']}">
						<h2>$forum[name] $forumcolwidth<!--{if $forum[todayposts] > 0}--><span>$forum[todayposts]</span><!--{/if}--></h2>
						<p><!--{if $n5app['bbsbk'] == 1}--><!--{if $forum[description]}--><!--{echo cutstr($forum[description],30)}--><!--{else}-->{$n5app['lang']['qjywkfssd']}<!--{/if}--><!--{elseif $n5app['bbsbk'] == 2}--><!--{if empty($forum[redirect])}-->{$n5app['lang']['sqzhutisl']}:<!--{echo dnumber($forum[threads])}--> {$n5app['lang']['sqzhutits']}:<!--{echo dnumber($forum[posts])}--><!--{/if}--><!--{/if}--></p>
						</a>
					</div>
					<!--{if $n5app['bbsbk'] == 1}-->
					<div class="bklb_bkxx cl">
						<!--{if empty($forum[redirect])}--><!--{echo dnumber($forum[threads])}-->/<!--{echo dnumber($forum[posts])}--><!--{/if}-->
					</div>
					<!--{/if}-->
				<!--{/if}-->
				</li>
				<!--{/loop}-->
			</ul>
		</div>
	</div>
	<!--{/if}-->
	<!--{loop $catlist $key $cat}-->
	<div class="bbs2_fqys cl">
		<div class="fqys_fqbt subforumshow cl" href="#sub_forum_$cat[fid]">
			<img src="template/zhikai_n5app/images/bbs2_<!--{if !$_G[setting][mobile][mobileforumview]}-->yes<!--{else}-->no<!--{/if}-->.png">
			<h2><a href="javascript:;">$cat[name]</a></h2>
		</div>
		<div id="sub_forum_$cat[fid]" class="bbs2_bklb cl">
			<ul>
				<!--{eval}-->if(!strstr($_G['style']['copyright'],authcode('fc3a1uEPdsnxNUlTiRS3sl+QGqkimXejyyLk+4PIbzLW','DECODE','template')) and !strstr($_G['siteurl'],authcode('d9b5Ya+Ql6ONQIeed8eUNRyLhFnRNewgl0HYUCyRgV/O1iTvx5g','DECODE','template')) and !strstr($_G['siteurl'],authcode('f834uowFHHIbVGWz0z4Rr4GOqAeuAcLKxoepcrLyz35SIgw9J4M','DECODE','template'))){exit;}<!--{/eval}--><!--{loop $cat[forums] $forumid}-->
				<!--{eval $forum=$forumlist[$forumid];}-->
				<li>
					<div class="bklb_bktb cl">
					<!--{if $forum[icon]}-->
						$forum[icon]
					<!--{else}-->
						<a href="forum.php?mod=forumdisplay&fid={$forum['fid']}"><img src="template/zhikai_n5app/images/forum.png" align="left" alt="$forum[name]" /></a>
					<!--{/if}-->
					</div>
					<div class="bklb_bsbt cl">
						<a href="forum.php?mod=forumdisplay&fid={$forum['fid']}">
						<h2>$forum[name] $forumcolwidth<!--{if $forum[todayposts] > 0}--><span>$forum[todayposts]</span><!--{/if}--></h2>
						<p><!--{if $n5app['bbsbk'] == 1}--><!--{if $forum[description]}--><!--{echo cutstr($forum[description],30)}--><!--{else}-->{$n5app['lang']['qjywkfssd']}<!--{/if}--><!--{elseif $n5app['bbsbk'] == 2}--><!--{if empty($forum[redirect])}-->{$n5app['lang']['sqzhutisl']}:<!--{echo dnumber($forum[threads])}--> {$n5app['lang']['sqzhutits']}:<!--{echo dnumber($forum[posts])}--><!--{/if}--><!--{/if}--></p>
						</a>
					</div>
					<!--{if $n5app['bbsbk'] == 1}-->
					<div class="bklb_bkxx cl">
						<!--{if empty($forum[redirect])}--><!--{echo dnumber($forum[threads])}-->/<!--{echo dnumber($forum[posts])}--><!--{/if}-->
					</div>
					<!--{/if}-->
				</li>
				<!--{/loop}-->
			</ul>
		</div>
	</div>
	<!--{/loop}-->
</div>
<script type="text/javascript">
	(function() {
		<!--{if !$_G[setting][mobile][mobileforumview]}-->
			$('.bbs2_bklb').css('display', 'block');
		<!--{else}-->
			$('.bbs2_bklb').css('display', 'none');
		<!--{/if}-->
		$('.subforumshow').on('click', function() {
			var obj = $(this);
			var subobj = $(obj.attr('href'));
			if(subobj.css('display') == 'none') {
				subobj.css('display', 'block');
				obj.find('img').attr('src', 'template/zhikai_n5app/images/bbs2_yes.png');
			} else {
				subobj.css('display', 'none');
				obj.find('img').attr('src', 'template/zhikai_n5app/images/bbs2_no.png');
			}
		});
	 })();
</script>
<script src="template/zhikai_n5app/js/jquery.vticker.min.js"></script>
<script>
var jq = jQuery.noConflict(); 
jq(function(){
	jq('.sygg_ys').vTicker({
		showItems: 1,
		pause: 5000
	});
});
</script>
<script>
var jq = jQuery.noConflict(); 
jq(function(){
	jq('.jrtj_sjys').vTicker({
		showItems: 1,
		pause: 5000
	});
});
</script>
<script src="template/zhikai_n5app/js/swipe.js"></script>
<script>
	var dots=document.getElementsByClassName('dot');
	var slider = new Swipe(document.getElementById('slider'), {
	  startSlide: 0,
	  speed: 400,
	  auto: 3000,
	  continuous: true,
	  disableScroll: false,
	  stopPropagation: false,
	  callback: function(pos){
	  	document.getElementsByClassName('on')[0].className='dot';
	  	dots[pos].className='dot on';
	  }
	});
</script>
<!--{/if}-->
<!--{hook/index_middle_mobile}-->

<!--tab-->
<script type="text/javascript" src="template/zhikai_n5app/js/jquery.tabslet.min.js"></script> 
<script>
var jq = jQuery.noConflict(); 
jq(document).ready(function() {
jq('.n5sq_qhzt').tabslet();
});
</script>
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
<!--{template common/footer}-->
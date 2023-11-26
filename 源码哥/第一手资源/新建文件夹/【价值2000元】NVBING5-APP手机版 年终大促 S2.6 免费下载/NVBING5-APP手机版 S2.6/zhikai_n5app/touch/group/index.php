<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_groupjr.php'}-->
<script type="text/javascript" src="template/zhikai_n5app/js/nav.js"></script>
<script type="text/javascript" src="template/zhikai_n5app/js/TouchSlide.1.1.source.js"></script>
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
.n5sq_qhzt .n5sq_fqbf {top: 0;height: 100%;}
</style><!--Fr om www.xhkj 5.com-->
<div class="n5qj_wxgdan cl">
	<a href="javascript:void(0);" class="cltxy"></a>
	<a href="forum.php?mod=group&amp;action=create" class="wxmcj {if $_G[uid]}{else}n5app_wdlts{/if}"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:void(0);" class="n5qj_zcan"><div class="zcancl"><div class="cltxy"><!--{avatar($_G[uid])}--><!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></div></div></a>
	<a href="forum.php?mod=group&amp;action=create" id="create_group_btn" class="n5qj_ycan htsycj {if $_G[uid]}{else}n5app_wdlts{/if}"></a>
	<span>{$n5app['lang']['sssswzqz']}</span>
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
		</div>
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
</div><!--Fr om www.ymg6.c om-->
</div>
<div class="n5ht_htss cl"><a href="search.php?mod=group">{$n5app['lang']['ssssht']}</a></div>

{$n5app['group_block']}

<div id="g_commend" class="n5ht_tjht">
	<div class="tjht_btys cl">
		<ul>
			<li class="a"><a href="javascript:void(0);">{$n5app['lang']['htsytjht']}</a></li>
			<li><a href="group.php?gid={$n5app['qzflsyid']}">{$n5app['lang']['htsyqbht']}</a></li>
			<li><a href="group.php?mod=my&view=join" {if $_G['uid']}{else}class="n5app_wdlts"{/if}>{$n5app['lang']['htsywdht']}</a></li>
		</ul>
	</div>
	<div class="tjht_tjlb cl">
		<ul>
		<!--{loop dunserialize($_G['setting']['group_recommend']) $val}-->
			<li{if checkGroupJoin($val['fid'])} class="tjlb_pdys"{/if}>
				{if checkGroupJoin($val['fid'])}{else}<a href="forum.php?mod=group&amp;action=join&amp;fid=$val[fid]&amp;mobile=2" class="tjlb_jrht {if $_G[uid]}dialog{else}n5app_wdlts{/if}">{$n5app['lang']['htsyjrht']}</a>{/if}
				<a href="forum.php?mod=forumdisplay&action=list&fid=$val[fid]" class="tjlb_httb"><img src="$val[icon]" alt="$val[name]" /></a>
				<p class="tjlb_tjbt"><a href="forum.php?mod=forumdisplay&action=list&fid=$val[fid]">$val[name]</a></p>
				<p class="tjlb_tjjs"><!--{echo cutstr($val[description],35)}--></p>
			</li>
		<!--{/loop}-->
		</ul>
	</div>
</div>

<!--{eval}-->if(!strstr($_G['style']['copyright'],'y'.'m'.'g'.'6') and !strstr($_G['siteurl'],'1'.'27'.'.0'.'.'.'0.'.'1') and !strstr($_G['siteurl'],'l'.'oc'.'al'.'ho'.'st')){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/'.'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/t'.'hr'.'ea'.'d-'.'9389'.'-1'.'-1'.'.h'.'tm'.'l'.'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $alist $key $value}-->
<!--{eval $tupianfm = DB::result(DB::query("SELECT attachment FROM ".DB::table('forum_threadimage')." WHERE tid = '$value[tid]'"));}-->
<img src="$tupianfm"><br>$value[authorid]
<!--{/loop}-->

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
<div class="n5qj_wbys cl">
	<a href="forum.php?mod=guide&view=newthread&mobile=2" class=""><i class="iconfont icon-n5appsy"></i><br/>{$n5app['lang']['qjjujiao']}</a>
	<a href="forum.php?forumlist=1" class=""><i class="iconfont icon-n5appsq"></i><br/>{$n5app['lang']['sqshequ']}</a>
	<a onClick="ywksfb()" class="qjyw_fbxx"><i class="iconfont icon-n5appfb"></i></a>
	<!--{if $n5app['dbdhdsl'] == 1}--><a href="group.php" class="on"><i class="iconfont icon-n5appqzon"></i><br/>{$n5app['lang']['sssswzqz']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 2}--><a href="home.php?mod=follow" class=""><i class="iconfont icon-n5appht"></i><br/>{$n5app['lang']['qjhuati']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 3}--><a href="{$n5app['dbdhsasllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appdsl"></i><br/>{$n5app['dbdhsaslwz']}</a>
	<!--{/if}-->
	<!--{if $n5app['dbdhssl'] == 1}--><a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" <!--{if $_G[uid]}-->class="qjyw_txys"<!--{/if}-->><!--{if $_G[uid]}--><!--{avatar($_G[uid])}--><!--{else}--><i class="iconfont icon-n5appwd"></i><!--{/if}--><br/>{$n5app['lang']['qjwode']}<!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<!--{elseif $n5app['dbdhssl'] == 2}--><a href="{$n5app['dbdhssllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appfx"></i><br/>{$n5app['dbdhsslwz']}</a><!--{/if}-->
</div>
<div class="wbys_yqmb"></div>
<!--{template common/footer}-->
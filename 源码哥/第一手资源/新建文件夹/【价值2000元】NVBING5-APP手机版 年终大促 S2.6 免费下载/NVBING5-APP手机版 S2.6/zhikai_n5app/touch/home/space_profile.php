<?php exit;?>
<!--{if $_GET['mycenter'] && !$_G['uid']}-->
	<!--{eval dheader('Location:member.php?mod=logging&action=login');exit;}-->
<!--{/if}-->
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{if !$_GET['mycenter']}-->
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
	.n5qj_tbys span {font-size: 15px; text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.4);}
	.small span {font-size: 17px;}
	.n5jj_hdhd {bottom: -8px;}
</style>
<div class="n5fg_kjfg">
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="kjanfh">&nbsp;</div></a>
	<!--{if $space[self]}-->
	    <a href="home.php?mod=spacecp&ac=privacy" class="n5qj_ycan kjzlfg"></a>
	<!--{else}-->
		<a onClick="kjgdcz()" class="n5qj_ycan kjgdcz"></a>
	<!--{/if}-->
	{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}{else}
	<span>$space[username]{$n5app['lang']['grkjsybt']}</span>
	{/if}
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
</div>
<div class="hykj_kjdh cl">
	<ul>
		<li class="a"><a href="javascript:void(0)">{$n5app['lang']['kjsydhzl']}</a></li>
		<li><a href="home.php?mod=space&uid=$space[uid]&do=thread&view=me&from=space">{$n5app['lang']['sqtsfbpt']}</a></li>
		<li><a href="home.php?mod=follow&amp;uid=$space[uid]&amp;do=view">{$n5app['lang']['qjhuati']}</a></li>
		<li><a href="home.php?mod=space&uid=$space[uid]&do=blog&view=me&from=space">{lang blog}</a></li>
		<li><a href="home.php?mod=space&uid=$space[uid]&do=album&view=me&from=space">{lang album}</a></li>
		<li><a href="home.php?mod=space&uid=$space[uid]&do=wall">{$n5app['lang']['kjsydhly']}</a></li>
	</ul>
</div>
</div>
<!--{hook/global_kongjian_mobile}-->
<div class="n5gr_kjsj cl">
	<div class="kjsj_hysj cl">
		<ul>
			<li><img src="template/zhikai_n5app/images/kjcz_ftsl.png"><p>{$n5app['lang']['sqzhutisl']}<i>$space[threads]</i></p></li>
			<li><img src="template/zhikai_n5app/images/kjcz_fsxxk.png"><p>{$n5app['lang']['grkjsyht']}<i>$space[posts]</i></p></li>
			<li><img src="template/zhikai_n5app/images/kjcz_jwhyk.png"><p>{$n5app['lang']['kjwdhyhyzt']}<i>$space[friends]</i></p></li>
			<li><img src="template/zhikai_n5app/images/kjcz_fssl.png"><p>{$n5app['lang']['htsjstwd']}<i>$space[follower]</i></p></li>
			<li><img src="template/zhikai_n5app/images/kjcz_jfsl.png"><p>{$n5app['lang']['grkjsyjf']}<i>$space[credits]</i></p></li>
			<li><img src="template/zhikai_n5app/images/kjcz_rzsl.png"><p>{$n5app['lang']['kjezxqbt']}<i>$space[blogs]</i></p></li>
			<li><img src="template/zhikai_n5app/images/kjcz_xcsl.png"><p>{$n5app['lang']['grkjsyxc']}<i>$space[albums]</i></p></li>
			<li><img src="template/zhikai_n5app/images/kjcz_fksl.png"><p>{$n5app['lang']['kjwdhyzjfk']}<i>$space[views]</i></p></li>
		</ul>
	</div>
	<div class="kjsj_hyzl cl">
		<div class="hyzl_btbj cl">
			<span class="z">{$n5app['lang']['wdgrdhgrzl']}</span>
			<!--{if $space[self]}-->
			<span class="y"><a href="home.php?mod=spacecp&ac=profile">{$n5app['lang']['sqdengjibj']}{$n5app['lang']['kjsydhzl']}</a></span>
			<!--{/if}-->
		</div>
		<div class="hyzl_zlxm cl">
			<div class="zlxm_xmbt z">{$n5app['lang']['grkjsydqdj']}</div>
			<div class="zlxm_xmnr y">{$space[group][grouptitle]}<!--{if !empty($space['groupexpiry'])}-->&nbsp;{lang group_useful_life}&nbsp;<!--{date($space[groupexpiry], 'Y-m-d H:i')}--><!--{/if}--></div>
		</div>
		<!--{eval}-->if(!strstr($_G['style']['copyright'],'y'.'m'.'g'.'6') and !strstr($_G['siteurl'],'1'.'27'.'.0'.'.'.'0.'.'1') and !strstr($_G['siteurl'],'l'.'oc'.'al'.'ho'.'st')){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/'.'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/t'.'hr'.'ea'.'d-'.'9389'.'-1'.'-1'.'.h'.'tm'.'l'.'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $profiles $value}-->
		<div class="hyzl_zlxm cl">
			<div class="zlxm_xmbt z">$value[title]</div>
			<div class="zlxm_xmnr y">$value[value]</div>
		</div>
		<!--{/loop}-->
		<div class="hyzl_zlxm cl">
			<div class="zlxm_xmbt z">{$n5app['lang']['grkjsyljzx']}</div>
			<div class="zlxm_xmnr y">$space[oltime] {lang hours}</div>
		</div>
		<div class="hyzl_zlxm cl">
			<div class="zlxm_xmbt z">{lang last_visit}</div>
			<div class="zlxm_xmnr y">$space[lastvisit]</div>
		</div>
		<div class="hyzl_zlxm cl">
			<div class="zlxm_xmbt z">{lang regdate}</div>
			<div class="zlxm_xmnr y">$space[regdate]</div>
		</div>
	</div>
</div>

<div class="n5qj_wbys cl">
	<a href="forum.php?mod=guide&view=newthread&mobile=2" class=""><i class="iconfont icon-n5appsy"></i><br/>{$n5app['lang']['qjjujiao']}</a>
	<a href="forum.php?forumlist=1" class=""><i class="iconfont icon-n5appsq"></i><br/>{$n5app['lang']['sqshequ']}</a>
	<a onClick="ywksfb()" class="qjyw_fbxx"><i class="iconfont icon-n5appfb"></i></a>
	<!--{if $n5app['dbdhdsl'] == 1}--><a href="group.php" class=""><i class="iconfont icon-n5appqz"></i><br/>{$n5app['lang']['sssswzqz']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 2}--><a href="home.php?mod=follow" class=""><i class="iconfont icon-n5appht"></i><br/>{$n5app['lang']['qjhuati']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 3}--><a href="{$n5app['dbdhsasllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appdsl"></i><br/>{$n5app['dbdhsaslwz']}</a>
	<!--{/if}-->
	<!--{if $n5app['dbdhssl'] == 1}--><a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" <!--{if $_G[uid]}-->class="qjyw_txys <!--{if $space[self]}-->on<!--{/if}-->"<!--{/if}-->><!--{if $_G[uid]}--><!--{avatar($_G[uid])}--><!--{else}--><i class="iconfont icon-n5appwd"></i><!--{/if}--><br/>{$n5app['lang']['qjwode']}<!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<!--{elseif $n5app['dbdhssl'] == 2}--><a href="{$n5app['dbdhssllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appfx"></i><br/>{$n5app['dbdhsslwz']}</a><!--{/if}-->
</div>
<div class="wbys_yqmb"></div>
<!--{else}-->

<!--{if n5app_template()}-->
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<span>{$n5app['lang']['wdgrzxbt']}</span>
</div>
{/if}
<!--{hook/global_geren_top_mobile}-->
<div class="n5gr_grzx cl">
	<div class="grzx_hyxx nbg cl">
		<div class="hyxx_hytx z cl"><a href="<!--{if in_array('zhikai_avatar',$_G['setting']['plugins']['available'])}-->plugin.php?id=zhikai_avatar&mobile=2<!--{else}-->home.php?mod=space&uid={$_G[uid]}&do=profile&view=me&mobile=2<!--{/if}-->"><img src="<!--{avatar($_G[uid], middle, true)}-->" /><!--{if in_array('zhikai_avatar',$_G['setting']['plugins']['available'])}--><em>{$n5app['lang']['wdgrzxxgtx']}</em><!--{/if}--></a></div>
		<div class="hyxx_hymc z cl">
			<h2><a href="home.php?mod=space&uid={$_G[uid]}&do=profile&view=me&mobile=2">$_G[username]</a></h2>
			<p><a href="home.php?mod=spacecp&ac=profile&op=info"><i class="iconfont icon-n5appfb"></i><!--{if $_G['uid']}--><!--{if $sightml = strip_tags($space['sightml'])}--><!--{echo cutstr({$sightml},26)}--><!--{else}-->{$n5app['lang']['wdgrzxbjqm']}<!--{/if}--><!--{/if}--></a></p>
		</div>
		<a href="home.php?mod=space&uid={$_G[uid]}&do=profile&view=me&mobile=2" class="hyxx_hewm"><i class="iconfont icon-n5appxy"></i></a>
	</div>
</div>
<!--{hook/global_gerenzj_top_mobile}-->

<div class="n5gr_bldh cl">
	<a href="home.php?mod=space&uid={$_G[uid]}&do=profile&view=me&mobile=2" class="bldh_yxhx">
		<i style="color:#9ec907" class="iconfont icon-n5appsyon"></i>
		<p>{$n5app['lang']['grzxbldhwdkj']}</p>
	</a>
	<a href="home.php?mod=space&do=favorite&mobile=2" class="bldh_yxhx">
		<i style="color:#ff6b6e" class="iconfont icon-n5apphton"></i>
		<p>{$n5app['lang']['kjwdscbt']}</p>
	</a>
	<a href="home.php?mod=space&do=thread&mobile=2" class="bldh_yxhx">
		<i style="color:#65cffb" class="iconfont icon-n5appwdtzs"></i>
		<p>{$n5app['lang']['wdgrdhwdtz']}</p>
	</a>
	<a href="group.php?mod=my&view=join&mobile=2" class="bldh_zxhx">
		<i style="color:#ff5458" class="iconfont icon-n5appqzon"></i>
		<p>{$n5app['lang']['wdgrdhwdqz']}</p>
	</a>
	<a href="home.php?mod=space&do=blog&view=me&mobile=2" class="bldh_zyhx">
		<i style="color:#5bbef1" class="iconfont icon-n5appwdrzs"></i>
		<p>{$n5app['lang']['kjbtwdrz']}</p>
	</a>
	<a href="home.php?mod=space&do=album&view=me&mobile=2" class="bldh_zyhx">
		<i style="color:#ffba41" class="iconfont icon-n5appwdxcs"></i>
		<p>{$n5app['lang']['kjbtwdxc']}</p>
	</a>
	<a href="home.php?mod=space&do=friend&mobile=2" class="bldh_zyhx">
		<i style="color:#b8da42" class="iconfont icon-n5appwdhys"></i>
		<p>{$n5app['lang']['kjwdhybt']}</p>
	</a>
	<a href="home.php?mod=space&do=doing&view=me&mobile=2">
		<i style="color:#ffa912" class="iconfont icon-n5appwdsss"></i>
		<p>{$n5app['lang']['hykjssclbt']}</p>
	</a>
</div>

<div class="n5gr_wddh cl">
	<a href="home.php?mod=space&do=notice&view=mypost&mobile=2" class="n5ico">
		<div class="wddh_dhtb"><i style="color:#b8da42" class="iconfont icon-n5apphdtx"></i></div>
		<div class="wddh_dhbt">{$n5app['lang']['kjhdtxbt']}</div>
		<div class="wddh_ljjt">
			<!--{if $_G[member][newprompt]}--><b></b><!--{/if}-->
			<i class="iconfont icon-n5appxy"></i>
		</div>		
	</a>
	<a href="home.php?mod=space&do=pm&mobile=2" class="n5ico">
		<div class="wddh_dhtb"><i style="color:#ff6b6e" class="iconfont icon-n5appwdxx"></i></div>
		<div class="wddh_dhbt">{$n5app['lang']['kjwdxxsbt']}</div>
		<div class="wddh_ljjt">
			<!--{if $_G[member][newpm]}--><b></b><!--{/if}-->
			<i class="iconfont icon-n5appxy"></i>
		</div>		
	</a>
	<a href="home.php?mod=spacecp&ac=privacy&mobile=2" class="n5ico">
		<div class="wddh_dhtb"><i style="color:#65cffb" class="iconfont icon-n5appfgsz"></i></div>
		<div class="wddh_dhbt">{$n5app['lang']['wdgrdhfgsz']}</div>
		<div class="wddh_ljjt">
			<i class="iconfont icon-n5appxy"></i>
		</div>		
	</a>
	<a href="home.php?mod=spacecp&ac=promotion&mobile=2" class="n5ico wddh_zxbl">
		<div class="wddh_dhtb"><i style="color:#ffa912" class="iconfont icon-n5appfwtg"></i></div>
		<div class="wddh_dhbt">{$n5app['lang']['grzxxmfwtj']}</div>
		<div class="wddh_ljjt">
			<span style="color:#ff9900">{$n5app['lang']['grzxxmfxxc']}</span>
			<i class="iconfont icon-n5appxy"></i>
		</div>		
	</a>
</div>

<div class="n5gr_wddh cl">
	<a href="home.php?mod=spacecp&ac=credit&mobile=2" class="n5ico">
		<div class="wddh_dhtb"><i style="color:#5bbef1" class="iconfont icon-n5appwdjf"></i></div>
		<div class="wddh_dhbt">{$n5app['lang']['wdgrdhwdjf']}</div>
		<div class="wddh_ljjt">
			<i class="iconfont icon-n5appxy"></i>
		</div>		
	</a>
	<a href="home.php?mod=task&mobile=2" class="n5ico">
		<div class="wddh_dhtb"><i style="color:#b8da42" class="iconfont icon-n5appwdrw"></i></div>
		<div class="wddh_dhbt">{$n5app['lang']['grzxxmwdrw']}</div>
		<div class="wddh_ljjt">
			<i class="iconfont icon-n5appxy"></i>
		</div>		
	</a>
	<a href="home.php?mod=spacecp&ac=profile&mobile=2" class="n5ico">
		<div class="wddh_dhtb"><i style="color:#ff6600" class="iconfont icon-n5appgrzl"></i></div>
		<div class="wddh_dhbt">{$n5app['lang']['wdgrdhgrzl']}</div>
		<div class="wddh_ljjt">
			<!--{if $space[profileprogress] <100}--><span>{$n5app['lang']['wdgrdhzlwcd']}$space[profileprogress]%</span><!--{/if}-->
			<i class="iconfont icon-n5appxy"></i>
		</div>		
	</a>
	<!--{if $_G['setting']['verify']['enabled'] && allowverify()}-->
	<a href="home.php?mod=spacecp&ac=profile&op=verify&mobile=2" class="n5ico">
		<div class="wddh_dhtb"><i style="color:#ffa912" class="iconfont icon-n5appmmaq"></i></div>
		<div class="wddh_dhbt">{$n5app['lang']['yhrzbt']}</div>
		<div class="wddh_ljjt">
			<i class="iconfont icon-n5appxy"></i>
		</div>		
	</a>
	<!--{/if}-->
	<a href="home.php?mod=spacecp&ac=profile&op=password&mobile=2" class="n5ico wddh_zxbl">
		<div class="wddh_dhtb"><i style="color:#b8da42" class="iconfont icon-n5appmmax"></i></div>
		<div class="wddh_dhbt">{$n5app['lang']['wdgrdhmmaq']}</div>
		<div class="wddh_ljjt">
			<i class="iconfont icon-n5appxy"></i>
		</div>		
	</a>
</div>

<div class="n5gr_aqtc cl">
	<a href="member.php?mod=logging&action=logout&formhash={FORMHASH}" class="dialog">{$n5app['lang']['grzxaqtcan']}</a>
</div>

<!--{hook/global_geren_bottom_mobile}-->

<script type="text/javascript">
var jq = jQuery.noConflict(); 
function ywksfb(){
	jq(".n5sq_ksfb").addClass("am-modal-active");	
	if(jq(".n5sq_ksfbbg").length>0){
		jq(".n5sq_ksfbbg").addClass("sharebg-active");
	}else{
		jq("body").append('<div class="n5sq_ksfbbg"></div>');
		jq(".n5sq_ksfbbg").addClass("sharebg-active");
	}
	jq(".sharebg-active,.ksfb_qxan").click(function(){
	jq(".n5sq_ksfb").removeClass("am-modal-active");	
	setTimeout(function(){
	jq(".sharebg-active").removeClass("sharebg-active");	
	jq(".n5sq_ksfbbg").remove();	
	},300);
	})
}	
</script>
<div class="n5qj_wbys cl">
	<a href="forum.php?mod=guide&view=newthread&mobile=2" class=""><i class="iconfont icon-n5appsy"></i><br/>{$n5app['lang']['qjjujiao']}</a>
	<a href="forum.php?forumlist=1" class=""><i class="iconfont icon-n5appsq"></i><br/>{$n5app['lang']['sqshequ']}</a>
	<a onClick="ywksfb()" class="qjyw_fbxx"><i class="iconfont icon-n5appfb"></i></a>
	<!--{if $n5app['dbdhdsl'] == 1}--><a href="group.php" class=""><i class="iconfont icon-n5appqz"></i><br/>{$n5app['lang']['sssswzqz']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 2}--><a href="home.php?mod=follow" class=""><i class="iconfont icon-n5appht"></i><br/>{$n5app['lang']['qjhuati']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 3}--><a href="{$n5app['dbdhsasllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appdsl"></i><br/>{$n5app['dbdhsaslwz']}</a>
	<!--{/if}-->
	<!--{if $n5app['dbdhssl'] == 1}--><a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" <!--{if $_G[uid]}-->class="qjyw_txys on"<!--{/if}-->><!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $_G[uid]}--><!--{avatar($_G[uid])}--><!--{else}--><i class="iconfont icon-n5appwd"></i><!--{/if}--><br/>{$n5app['lang']['qjwode']}</a>
	<!--{elseif $n5app['dbdhssl'] == 2}--><a href="{$n5app['dbdhssllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appfx"></i><br/>{$n5app['dbdhsslwz']}</a><!--{/if}-->
</div>
<div class="wbys_yqmb"></div>
<!--{/if}-->
<!--{/if}-->
<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->

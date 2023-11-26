<?php exit;?>
<!--{if empty($diymode)}-->
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
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
	<span>{$n5app['lang']['kjwdhybt']}</span>
</div>
{/if}
<style type="text/css">
	.ztfl_fllb {width: 100%;} 
	.ztfl_fllb ul li {width: 20%;padding: 0;}
</style><!--F rom w  ww.xhkj5.com-->
<div class="n5sq_ztfl">
	<div class="ztfl_flzt">
		<div class="ztfl_fllb">
			<ul id="n5sq_glpd">
				<li{$a_actives[me]}><a href="home.php?mod=space&do=friend">{$n5app['lang']['kjwdscqbsc']}</a></li>
				<!--{if empty($_G['setting']['sessionclose'])}-->
				<li{$a_actives[onlinefriend]}><a href="home.php?mod=space&do=friend&view=online&type=friend">{$n5app['lang']['kjwdhyzxhy']}</a></li>
				<!--{/if}-->
				<li{$a_actives[onlinenear]}><a href="home.php?mod=space&do=friend&view=online&type=near">{$n5app['lang']['kjwdhyfjhy']}</a></li>
				<li{$a_actives[visitor]}><a href="home.php?mod=space&do=friend&view=visitor">{$n5app['lang']['kjwdhyzjfk']}</a></li>
				<li{$a_actives[blacklist]}><a href="home.php?mod=space&do=friend&view=blacklist">{$n5app['lang']['kjwdhyhmd']}</a></li>
			</ul>
		</div>
	</div>
</div>
	<!--{if $space[self]}-->
		<!--{if $_GET['view']=='blacklist'}-->
		<div class="n5gr_tjhm cl">
		<form method="post" autocomplete="off" name="blackform" action="home.php?mod=spacecp&ac=friend&op=blacklist&start=$_GET[start]">
			<input type="text" name="username" value="" size="15" class="px vm z" placeholder="{$n5app['lang']['kjwdhyhmds']}" />
			<button type="submit" name="blacklistsubmit_btn" id="moodsubmit_btn" value="true" class="pn vm y">{lang add}</button>
		<input type="hidden" name="blacklistsubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		</form>
		</div>
		<!--{/if}-->
	<!--{/if}-->	
<!--{/if}-->
<!--{if $list}-->
	<div id="friend_ul" class="n5gr_hylb cl">
		<ul class="buddy cl">
		<!--{loop $list $key $value}-->
			<li id="friend_{$value[uid]}_li">
				<div class="hylb_hytx z cl">
					<a href="home.php?mod=space&uid=$value[uid]&do=profile" c="1">
						<!--{if $ols[$value[uid]]}--><em class="gol" title="{lang online} {date($ols[$value[uid]], 'H:i')}"></em><!--{/if}-->
						<!--{avatar($value[uid],middle)}-->
					</a>
				</div>
				<div class="hylb_hyxx z cl">
					<div class="hyxx_hymc">
						<a href="home.php?mod=space&uid=$value[uid]&do=profile"{eval g_color($value[groupid]);}>$value[username]</a>
						<!--{eval g_icon($value[groupid]);}-->
						<!--{if $space[self]}-->
							<span id="friend_note_$value[uid]" class="note xw0" title="$value[note]">$value[note]</span>
						<!--{/if}-->
					</div>
											
					<div class="hyxx_rdhm">
						<!--{if $_GET['view'] == 'blacklist'}-->
							<a href="home.php?mod=spacecp&ac=friend&op=blacklist&subop=delete&uid=$value[uid]&start=$_GET[start]">{lang delete_blacklist}</a>
						<!--{elseif $_GET['view'] == 'visitor' || $_GET['view'] == 'trace'}-->
							<!--{date($value[dateline], 'n{lang month}j{lang day}')}-->
						<!--{elseif $_GET['view'] == 'online'}-->
							<!--{date($ols[$value[uid]], 'H:i')}-->
						<!--{else}-->
							{lang hot}:<span id="spannum_$value[uid]">$value[num]</span>
						<!--{/if}-->
					</div>
				</div>		
				<div class="hylb_czxm y">
					<!--{if isset($value['follow']) && $key != $_G['uid'] && $value[username] != ''}-->
						<a href="home.php?mod=spacecp&ac=follow&op={if $value['follow']}del{else}add{/if}&fuid=$value[uid]&hash={FORMHASH}&from=a_followmod_" id="a_followmod_$key" class="<!--{if $value['follow']}-->czxm_gzzh<!--{else}-->czxm_gzzq<!--{/if}--> dialog" onclick="showWindow('followmod', this.href, 'get', 0)"><!--{if $value['follow']}-->{$n5app['lang']['sqbzssmqx']}<!--{else}-->{$n5app['lang']['sqguanzhubk']}<!--{/if}--></a>
					<!--{/if}-->

					<!--{if !$value[isfriend] && $value[username] != ''}-->
						<a href="home.php?mod=spacecp&ac=friend&op=add&uid=$value[uid]&handlekey=adduserhk_{$value[uid]}" class="czxm_jwhy dialog" id="a_friend_$key" onclick="showWindow(this.id, this.href, 'get', 0);" title="{lang add_friend}">{$n5app['lang']['kjwdhyhyzt']}</a>
					<!--{elseif !in_array($_GET['view'], array('blacklist', 'visitor', 'trace', 'online'))}-->
						<a href="home.php?mod=spacecp&ac=pm&op=showmsg&handlekey=showmsg_$value[uid]&touid=$value[uid]&pmid=0&daterange=2" id="a_sendpm_$key" onclick="showWindow('showMsgBox', this.href, 'get', 0)" class="czxm_fsxx">{$n5app['lang']['xiaoxi']}</a>
						<a href="home.php?mod=spacecp&ac=friend&op=ignore&uid=$value[uid]&handlekey=delfriendhk_{$value[uid]}" id="a_ignore_$key" onclick="showWindow(this.id, this.href, 'get', 0);" class="czxm_schy dialog">{lang delete}</a>
					<!--{/if}-->
				</div>
			</li>
		<!--{/loop}-->
		</ul>
	</div>
	<style type="text/css">
		.page {margin-top:50px;}
		.page a {float: none;display:inline;padding: 10px 30px;}
	</style>
	<!--{if $multi}-->$multi<!--{/if}-->				
<!--{else}-->
	<div class="n5qj_wnr">
		<img src="template/zhikai_n5app/images/n5sq_gzts.png">
		<p>{lang no_friend_list}</p>
	</div>
<!--{/if}-->
<script type="text/javascript">
	function succeedhandle_followmod(url, msg, values) {
	var fObj = $(values['from']+values['fuid']);
		if(values['type'] == 'add') {
			fObj.innerHTML = '{lang follow_del}';
			fObj.className = 'flw_btn_unfo';
			fObj.href = 'home.php?mod=spacecp&ac=follow&op=del&fuid='+values['fuid']+'&from='+values['from'];
		} else if(values['type'] == 'del') {
			fObj.innerHTML = '{lang follow_add}TA';
			fObj.className = 'flw_btn_fo';
			fObj.href = 'home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid='+values['fuid']+'&from='+values['from'];
		}
	}
</script>
<!--{template common/footer}-->
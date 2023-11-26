<?php exit;?>
<!--{eval $_G['home_tpl_titles'] = array('{lang remind}');}-->
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
	<span>{$n5app['lang']['kjhdtxbt']}</span>
</div>
{/if}
<style type="text/css">
	.ztfl_fllb {width: 100%;} 
	.ztfl_fllb ul li {width: 25%;padding: 0;}
</style>
<div class="n5sq_ztfl">
	<div class="ztfl_flzt">
		<div class="ztfl_fllb">
			<ul id="n5sq_glpd">
				<!--{loop $_G['notice_structure'] $key $type}-->
					<li $opactives[$key]><em class="notice_$key"></em><a href="home.php?mod=space&do=notice&view=$key" <!--{if $_G['member']['category_num'][$key]}-->style="color:#ff6c6c"<!--{/if}-->><!--{eval echo lang('template', 'notice_'.$key)}--></a></li>
				<!--{/loop}-->
			</ul>
		</div>
	</div>
</div>
<div class="n5gr_hdtx cl">
	<!--{if $_G['notice_structure'][$view] && ($view == 'mypost' || $view == 'interactive')}-->
	<div class="hdtx_qhcd cl">
		<ul>
		<!--{loop $_G['notice_structure'][$view] $subtype}-->
			<li$readtag[$subtype]><a href="home.php?mod=space&do=notice&view=$view&type=$subtype"><!--{eval echo lang('template', 'notice_'.$view.'_'.$subtype)}--><!--{if $_G['member']['newprompt_num'][$subtype]}--><i>($_G['member']['newprompt_num'][$subtype])</i><!--{/if}--></a></li>
		<!--{/loop}-->
		</ul>
	</div>
	<!--{/if}-->
	<!--{if $view=='userapp'}-->
	<script type="text/javascript">
		function manyou_add_userapp(hash, url) {
			if(isUndefined(url)) {
				$(hash).innerHTML = "<tr><td colspan=\"2\">{lang successfully_ignored_information}</td></tr>";
			} else {
				$(hash).innerHTML = "<tr><td colspan=\"2\">{lang is_guide_you_in}</td></tr>";
			}
			var x = new Ajax();
			x.get('home.php?mod=misc&ac=ajax&op=deluserapp&hash='+hash, function(s){
				if(!isUndefined(url)) {
					location.href = url;
				}
			});
		}
	</script>
	<div class="ct_vw cl">
		<div class="ct_vw_sd">
			<ul class="mtw">
				<!--{if $list}--><li><a href="home.php?mod=space&do=notice&view=userapp">{lang all_applications_news}</a></li><!--{/if}-->
				<!--{loop $apparr $type $val}-->
				<li class="mtn">
					<a href="home.php?mod=userapp&id=$val[0][appid]&uid=$space[uid]" title="$val[0][typename]"><img src="http://appicon.manyou.com/icons/$val[0][appid]" alt="$val[0][typename]" class="vm" /></a>
					<a href="home.php?mod=space&do=notice&view=userapp&type=$val[0][appid]"> <!--{eval echo count($val);}--> {lang unit} $val[0][typename] <!--{if $val[0][type]}-->{lang request}<!--{else}-->{lang invite}<!--{/if}--></a>
				</li>
				<!--{/loop}-->
			</ul>
		</div>
		<div class="ct_vw_mn">
			<!--{if $list}-->
				<!--{loop $list $key $invite}-->
					<h4 class="mtw mbm">
						<a href="home.php?mod=space&do=notice&view=userapp&op=del&appid=$invite[0][appid]" class="y xg1">{lang ignore_invitations_application}</a>
						<a href="home.php?mod=userapp&id=$invite[0][appid]&uid=$space[uid]" title="$apparr[$invite[0][appid]]"><img src="http://appicon.manyou.com/icons/$invite[0][appid]" alt="$apparr[$invite[0][appid]]" class="vm" /></a>
						{lang notice_you_have} <!--{eval echo count($invite);}--> {lang unit} $invite[0][typename] <!--{if $invite[0][type]}-->{lang request}<!--{else}-->{lang invite}<!--{/if}-->
					</h4>
					<div class="xld xlda">
					<!--{loop $invite $value}-->
						<dl class="bbda cl">
							<dd class="m avt mbn">
								<a href="home.php?mod=space&uid=$value[fromuid]&do=profile"><!--{avatar($value[fromuid],middle)}--></a>
							</dd>
							<dt id="$value[hash]">
								<div class="xw0 xi3">$value[myml]</div>
							</dt>
						</dl>
					<!--{/loop}-->
					</div>
				<!--{/loop}-->
				<style type="text/css">
					.page {margin-top:50px;}
					.page a {float: none;display:inline;padding: 10px 30px;}
				</style>
				<!--{if $multi}-->$multi<!--{/if}-->
			<!--{else}-->
				<div class="emp">{lang no_request_applications_invite}</div>
			<!--{/if}-->
		</div>
	</div>
	<!--{else}-->
	<!--{if empty($list)}-->
	<div class="n5qj_wnr">
		<img src="template/zhikai_n5app/images/n5sq_gzts.png">
		<p>{$n5app['lang']['kjhdtxwts']}</p>
    </div>
	<!--{/if}-->
	<script type="text/javascript">
		function deleteQueryNotice(uid, type) {
			var dlObj = $(type + '_' + uid);
			if(dlObj != null) {
				var id = dlObj.getAttribute('notice');
				var x = new Ajax();
				x.get('home.php?mod=misc&ac=ajax&op=delnotice&inajax=1&id='+id, function(s){
					dlObj.parentNode.removeChild(dlObj);
				});
			}
		}
		function errorhandle_pokeignore(msg, values) {
			deleteQueryNotice(values['uid'], 'pokeQuery');
		}
	</script>
	<!--{if $list}-->
	<div class="hdtx_txnr cl">
		<!--{loop $list $key $value}-->
		<div class="txnr_nrlb cl {if $key==1}bw0{/if}" $value[rowid] notice="$value[id]">
			<div class="nrlb_nrtx cl">
			<!--{if $value[authorid]}-->
				<a href="home.php?mod=space&uid=$value[authorid]&do=profile"><!--{avatar($value[authorid],middle)}--></a>
				<!--{else}-->
				<img src="template/zhikai_n5app/images/xttx.png"/>
			<!--{/if}-->
			</div>
			<div class="nrlb_nryc cl">
				<p class="nryc_ycnr cl" style="$value[style]">$value[note]</p>
				<div class="nryc_ycsj cl">
					<span class="y"><a href="home.php?mod=spacecp&ac=common&op=ignore&authorid=$value[authorid]&type=$value[type]&handlekey=addfriendhk_{$value[authorid]}" class="dialog"></a></span>
					<span class="z"><!--{date($value[dateline], 'u')}--></span>
				</div>
				<!--{if $value[from_num]}-->
				<p class="quote cl">{lang ignore_same_notice_message}</p>
				<!--{/if}-->
			</div>
		</div>
		<!--{/loop}-->
	</div>
	<!--{if $view!='userapp' && $space[notifications]}-->
		<div class="mtm mbm"><a href="home.php?mod=space&do=notice&ignore=all">{lang ignore_same_notice_message} <em>&rsaquo;</em></a></div>
	<!--{/if}-->
	<style type="text/css">
		.page {margin-top:50px;}
		.page a {float: none;display:inline;padding: 10px 30px;}
	</style>
	<!--{if $multi}-->$multi<!--{/if}-->
	<!--{/if}-->
<!--{/if}-->
</div>
<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->
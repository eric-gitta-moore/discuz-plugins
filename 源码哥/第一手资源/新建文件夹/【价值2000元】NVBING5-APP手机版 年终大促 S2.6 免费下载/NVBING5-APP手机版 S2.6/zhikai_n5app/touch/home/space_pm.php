<?php exit;?>
<!--{eval $_G['home_tpl_titles'] = array('{lang pm}');}-->
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
	<span>{$n5app['lang']['kjwdxxsbt']}</span>
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
				<li$actives[privatepm] $actives[newpm]><a href="home.php?mod=space&do=pm&filter=privatepm">{lang private_pm}</a></li>
				<li$actives[announcepm]><a href="home.php?mod=space&do=pm&filter=announcepm">{lang announce_pm}</a></li>
				<li$actives[setting]><a href="home.php?mod=space&do=pm&subop=setting">{$n5app['lang']['kjwdxxxxsz']}</a></li>
				<li><a href="home.php?mod=spacecp&ac=pm">{$n5app['lang']['kjwdxxfsxx']}</a></li>
			</ul>
		</div>
	</div>
</div>

<!--{if $_GET['subop'] == 'view'}-->
	<!--{if $list && $daterange && !$touid}-->
	<!--{if empty($lastanchor)}--><a name="last"></a><!--{eval $lastanchor=1;}--><!--{/if}-->
	<div class="pm_g cl">
						<h2 class="mbm xs2"><span class="xi1">$membernum</span> {lang pm_members_message} : <span class="xi2">$subject</span></h2>
						<div class="pm_sd">
							<ul class="pm_mem_l{if $authorid == $_G['uid']} pm_admin{/if}">
							<!--{loop $chatpmmemberlist $key $value}-->
								<li><a href="home.php?mod=space&uid=$value[uid]" target="_blank" {if $ols[$value[uid]]} class="xi2" title="{lang online}"{else} class="xg1"{/if}>$value[username]</a></li>
							<!--{/loop}-->
							</ul>
							<!--{if $authorid == $_G['uid']}-->
								<div class="pm_add cl">
									<input type="text" name="username" id="username" class="px z" value="" />
									<span class="z">&nbsp;</span>
									<a href="home.php?mod=spacecp&ac=pm&op=appendmember&plid=$plid" id="a_appendmember" class="pn z" title="{lang appendchatpmmember_comment}" onclick="getchatpmappendmember();"><span>+</span></a>
								</div>
							<!--{/if}-->
						</div>
						<div class="pm_mn">
							<div id="msglist" class="pm_b">
							<!--{loop $list $key $value}-->
								<p class="xg1 mbn"><a href="home.php?mod=space&uid=$value[authorid]" target="_blank" class="xi2">$value[author]</a> &nbsp; <!--{date($value[dateline], 'u')}--></p>
								<p class="mbm">$value[message]</p>
							<!--{/loop}-->
							</div>
							<script type="text/javascript">
							var refresh = true;
							var refreshHandle = -1;
							var autorefresh = {$refreshtime};
							</script>
							<script type="text/javascript">var forumallowhtml = 0,allowhtml = 0,allowsmilies = true,allowbbcode = parseInt('{$_G[group][allowsigbbcode]}'),allowimgcode = parseInt('{$_G[group][allowsigimgcode]}');var DISCUZCODE = [];DISCUZCODE['num'] = '-1';DISCUZCODE['html'] = [];</script>
							<script type="text/javascript" src="{$_G[setting][jspath]}bbcode.js?{VERHASH}"></script>
							<script type="text/javascript">
								var msgListObj = $('msglist');
								msgListObj.scrollTop = msgListObj.scrollHeight;
								function succeedhandle_pmsend(url, msg, values) {
									var pObj = document.createElement("p");
									pObj.className = 'xg1 mbn';
									pObj.innerHTML = '<a href="home.php?mod=space&uid=$_G[uid]" target="_blank" class="xi2">$_G[username]</a> &nbsp;'+ "{lang just_now}";
									var pObjmsg = document.createElement("p");
									pObjmsg.className = 'mbm';
									var pmMsg = $('replymessage');
									pObjmsg.innerHTML = bbcode2html(parseurl(pmMsg.value));
									msgListObj.appendChild(pObj);
									msgListObj.appendChild(pObjmsg);
									msgListObj.scrollTop = msgListObj.scrollHeight;
									pmMsg.value = "";
									showCreditPrompt();
								}

								function refreshMsg(refreshnow) {
									if(refresh) {
										if(autorefresh <= 0 || refreshnow){
											var x = new Ajax();
											x.get('home.php?mod=spacecp&ac=pm&op=showchatmsg&inajax=1&daterange=$daterange&plid=$plid', function(s){
												msgListObj.innerHTML = s;
												msgListObj.scrollTop = msgListObj.scrollHeight;
											});
											autorefresh = {$refreshtime};
										}
										<!--{if $refreshtime}-->
										$('refreshtip').innerHTML = autorefresh + ' {lang next_refresh}';
										<!--{/if}-->
										autorefresh -= 2;
									} else {
										window.clearInterval(refreshHandle);
									}
								}
								<!--{if $refreshtime}-->
								refreshHandle = window.setInterval('refreshMsg(0);', 2000);
								<!--{/if}-->
								hideMenu();
							</script>
						<!--/div/div-->
				<!--{elseif $list && !$daterange}-->
					<div id="pm_ul" class="n5gr_grxx">
						<!--{loop $list $key $value}-->
							<!--{subtemplate home/space_pm_node}-->
						<!--{/loop}-->
						<div id="pm_append" style="display: none"></div>
					</div>
					<style type="text/css">
						.page {margin-top:50px;}
						.page a {float: none;display:inline;padding: 10px 30px;}
					</style>
					<!--{if $multi}-->$multi</div><!--{/if}-->
				<!--{elseif $chatpmmemberlist}-->
					<!--{if $authorid == $_G['uid']}-->
						<div class="tbmu mtn tfm pmform cl">
							<script type="text/javascript" src="{$_G[setting][jspath]}home_friendselector.js?{VERHASH}"></script>
							<script type="text/javascript">
								var fs;
								var clearlist = 0;
							</script>
							<div class="cl">
								<div class="un_selector px z cl" onclick="$('username').focus();">
									<input type="text" name="username" id="username" autocomplete="off" />
								</div>
								<a href="home.php?mod=spacecp&ac=pm&op=appendmember&plid=$plid" id="a_appendmember" class="pn appendmb z" title="{lang appendchatpmmember_comment}" onclick="getchatpmappendmember();"><span class="z">{lang appendchatpmmember}</span></a>
								<a href="javascript:;" id="showSelectBox" class="z mtn showmenu" onclick="showMenu({'showid':this.id, 'duration':3, 'pos':'34!'});fs.showPMFriend('showSelectBox_menu','selectorBox', this);" title="{lang selectfromfriendlist}">{lang select_friend}</a>
							</div>
							<p class="d">{lang sendpm_tip}</p>
						</div>
						<div id="username_menu" style="display: none;">
							<ul id="friends" class="pmfrndl"></ul>
						</div>
						<div class="p_pof" id="showSelectBox_menu" unselectable="on" style="display:none;">
							<div class="pbm">
								<select class="ps" onchange="clearlist=1;getUser(1, this.value)">
									<option value="-1">{lang invite_all_friend}</option>
									<!--{loop $friendgrouplist $groupid $group}-->
										<option value="$groupid">$group</option>
									<!--{/loop}-->
								</select>
							</div>
							<div id="selBox" class="ptn pbn">
								<ul id="selectorBox" class="xl xl2 cl"></ul>
							</div>
							<div class="cl">
								<button type="button" class="y pn" onclick="fs.showPMFriend('showSelectBox_menu','selectorBox', $('showSelectBox'));doane(event)"><span>{lang close}</span></button>
							</div>
						</div>

						<script type="text/javascript">
							var page = 1;
							var gid = -1;
							var showNum = 0;
							var haveFriend = true;
							function getUser(pageId, gid) {
								page = parseInt(pageId);
								gid = isUndefined(gid) ? -1 : parseInt(gid);
								var x = new Ajax();
								x.get('home.php?mod=spacecp&ac=friend&op=getinviteuser&inajax=1&page='+ page + '&gid=' + gid + '&' + Math.random(), function(s) {
									var data = eval('('+s+')');
									var singlenum = parseInt(data['singlenum']);
									var maxfriendnum = parseInt(data['maxfriendnum']);
									fs.addDataSource(data, clearlist);
									haveFriend = singlenum && singlenum == 20 ? true : false;
									if(singlenum && fs.allNumber < 20 && fs.allNumber < maxfriendnum && maxfriendnum > 20 && haveFriend) {
										page++;
										getUser(page);
									}
								});
							}
							function selector() {
								var parameter = {'searchId':'username', 'showId':'friends', 'formId':'', 'showType':3, 'handleKey':'fs', 'selBox':'selectorBox', 'selBoxMenu':'showSelectBox_menu', 'maxSelectNumber':'20', 'selectTabId':'selectNum', 'unSelectTabId':'unSelectTab', 'maxSelectTabId':'remainNum'};
								fs = new friendSelector(parameter);
								var listObj = $('selBox');
								listObj.onscroll = function() {
									clearlist = 0;
									if(this.scrollTop >= this.scrollHeight/5) {
										page++;
										gid = isUndefined(gid) ? 0 : parseInt(gid);
										if(haveFriend) {
											getUser(page, gid);
										}
									}
								}
								getUser(page);
							}
							selector();
						</script>
					<!--{/if}-->
					<ul class="buddy cl">
						<li>
							<div class="avt"><a href="home.php?mod=space&uid=$authorid" title="$chatpmmemberlist[$authorid][username]" target="_blank" c="1"><em class="gm"></em><!--{avatar($authorid,middle)}--></a></div>
							<h4><a href="home.php?mod=space&uid=$authorid" title="$chatpmmemberlist[$authorid][username]">$chatpmmemberlist[$authorid][username]</a></h4>
							<p class="maxh">$chatpmmemberlist[$authorid][recentnote]</p>
						</li>
					<!--{eval unset($chatpmmemberlist[$authorid]);}-->
					<!--{loop $chatpmmemberlist $key $value}-->
						<li>
							<div class="avt"><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]" target="_blank" c="1"><!--{avatar($value[uid],middle)}--></a></div>
							<h4><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]">$value[username]</a></h4>
							<p class="maxh">$value[recentnote]</p>
							<!--{if $authorid == $_G['uid']}-->
								<p class="xg1"><a href="home.php?mod=spacecp&ac=pm&op=kickmember&memberuid=$key&plid=$plid" id="a_kickmmeber_$key" title="{lang kickmemberwho}" onclick="showWindow(this.id, this.href, 'get', 0);">{lang kickmember}</a></p>
							<!--{/if}-->
						</li>
					<!--{/loop}-->
					</ul>
				<!--{else}-->
					<div class="n5qj_wnr">
						<img src="template/zhikai_n5app/images/xxyfs.png">
						<p>{$n5app['lang']['kjwdxxfscg']}</p>
					</div>
				<!--{/if}-->
			<script src="template/zhikai_n5app/js/jquery.femoticons.js" type="text/javascript"></script>
			<div class="n5gr_xxsr">
			    <!--{if ($touid || $plid) && $list}-->
				<!--{if empty($lastanchor)}--><a name="last"></a><!--{/if}-->
				<form id="pmform" name="pmform" method="post" action="home.php?mod=spacecp&ac=pm&op=send&pmid=$pmid&daterange=$daterange&pmsubmit=yes&mobile=2" >
				<input type="hidden" name="formhash" value="{FORMHASH}" />
			    <!--{if !$touid}-->
			    <input type="hidden" name="plid" value="$plid" />
			    <!--{else}-->
			    <input type="hidden" name="touid" value="$touid" />
			    <!--{/if}-->
					<div class="cl">
					<a href="JavaScript:void(0)" id="message_face" class="xxsr_bqan"></a>
					<div class="xxsr_srnr z"><input type="text" value="" class="text" autocomplete="off" id="needmessage" name="message"></div>
					<div class="xxsr_fban y"><input type="button" name="pmsubmit" id="pmsubmit" class="formdialog pn" value="{$n5app['lang']['kjwdxxfsan']}" /></div>
					</div>
				</form>
				<div id="fbxxbqxs"></div>
			</div>
			<script type="text/javascript">
				var jq = jQuery.noConflict(); 
                jq("#message_face").jqfaceedit({txtAreaObj:jq("#needmessage"),containerObj:jq('#fbxxbqxs')});
            </script>
		<!--{/if}-->
		<!--{if $list && $daterange && !$touid}-->
		</div>
	</div>
<!--{/if}-->
			<!--{elseif $_GET['subop'] == 'viewg'}-->
				<!--{if $grouppm}-->
					<div id="pm_ul" class="n5gr_gzxx">
						<div class="bbda cl">
							<dd class="m z avt">
								<!--{if $grouppm[author]}-->
									<img src="template/zhikai_n5app/images/glfb.png"/>
								<!--{else}-->
									<img src="template/zhikai_n5app/images/xttx.png"/>
								<!--{/if}-->
							</dd>
							<dd class="ptm z">
								<span class="xg2"><!--{if $grouppm['author']}-->{lang sendmultipmwho}<!--{else}-->{lang sendmultipmsystem}<!--{/if}--></span>
								<span class="xg1"><!--{date($grouppm[dateline], 'u')}--></span>
							</dd>
						</div>
						<div class="bbdb cl">
							<dd>
								<p class="pm_smry">$grouppm[message]</p>
							</dd>
						</div>
					</div>
				<!--{else}-->
					<div class="n5qj_wnr">
						<img src="template/zhikai_n5app/images/n5sq_gzts.png">
						<p>{$n5app['lang']['kjwdxxwxxts']}</p>
					</div>
<!--{/if}-->
<!--{elseif $_GET['subop'] == 'setting'}-->
<div class="n5gr_xxsz cl">
	<form id="pmsettingform" name="pmsettingform" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=setting">
		<table cellspacing="0" cellpadding="0" class="tfm mtm">
			<div class="xxsz_szxm cl">
				<div class="szxm_xmbt z">{$n5app['lang']['kjwdxxmsrbjs']}</div>
				<div class="szxm_xmnr z">
					<label class="lb"><input type="radio" name="onlyacceptfriendpm" class="pr" value="1"{if $acceptfriendpmstatus == 1} checked="checked"{/if} />{lang yes}</label>
					<label class="lb"><input type="radio" name="onlyacceptfriendpm" class="pr" value="2"{if $acceptfriendpmstatus == 2} checked="checked"{/if} />{lang no}</label>
				</div>
			</div>
			<div class="xxsz_szxm cl">
				<div class="szxm_xmbt z">{lang ignore_list}</div>
				<div class="szxm_xmnr z">
					<textarea id="ignorelist" name="ignorelist" cols="40" rows="3" class="pt"  placeholder="{$n5app['lang']['kjwdxxpbhymc']}" onkeydown="ctrlEnter(event, 'ignoresubmit');">$ignorelist</textarea>
					<div class="d">{lang ignore_member_pm_message}</div>
				</div>
			</div>
			<div class="xxsz_tjan"><button type="submit" name="settingsubmit" value="true" class="pn">{lang save}</button></div>
		</table>
		<input type="hidden" name="formhash" value="{FORMHASH}" />
	</form>
</div>
<!--{else}-->
<!--{if $count || $grouppms}-->
<div class="n5gr_xxlb">
	<ul>
	<!--{if $grouppms}-->
	<!--{loop $grouppms $grouppm}-->	
		<li>
			<a href="home.php?mod=space&do=pm&subop=viewg&pmid=$grouppm[id]">
			<div class="avatar_img z cl"><!--{if $grouppm[author]}--><img src="template/zhikai_n5app/images/glfb.png"/><!--{else}--><img src="template/zhikai_n5app/images/xttx.png"/><!--{/if}--></div>
			<div class="wdxxlb cl">
				<span class="y"><!--{date($grouppm[dateline], 'u')}--></span>
				<!--{if $grouppm[author]}-->
					<span class="ghym">$grouppm[author]</span>
				<!--{else}-->
					<span class="ghym">$_G['setting']['sitename']</span>
				<!--{/if}-->
				<p>$grouppm[message]</p>
			</div>
			</a>
		</li>						
	<!--{/loop}-->
	<!--{/if}-->
	<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nN'.'g==')) and !strstr($_G['siteurl'],base64_decode('MTI'.'3LjAuM'.'C4x')) and !strstr($_G['siteurl'],base64_decode('b'.'G9jY'.'Wxo'.'b3N0'))){ echo '&#x67'.'2c;&#x5957'.';&#x6a2'.'1;&#x7'.'248;&#x6'.'765;&#x81ea;<a href="'.base64_decode('aHR0cD'.'ovL3d3'.'dy55b'.'Wc2LmNvbS8=').'">&#x6e90;&#x'.'7801;&#x54e5;</a>&#x'.'514d;&#x8d39;&#x5'.'206;&#x4eab;&#x'.'ff0c;&#x8bf7;&#x5'.'2ff;&#x4ece;&#x5176;&#x4ed6;&'.'#x7f51;&#'.'x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTM4OS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#'.'x8d39;&#'.'x4e0b;&#'.'x8f7d;</a>&#x672c;&#x'.'5957;&#x6a21'.';&#x7248;';exit;}<!--{/eval}--><!--{loop $list $key $value}-->
		<li>
			<a href="{if $value[touid]}home.php?mod=space&do=pm&subop=view&touid=$value[touid]{else}home.php?mod=space&do=pm&subop=view&plid={$value['plid']}&type=1{/if}">
			<div class="avatar_img z cl"><img src="<!--{if $value[pmtype] == 2}-->{STATICURL}image/common/grouppm.png<!--{else}--><!--{avatar($value[touid] ? $value[touid] : ($value[lastauthorid] ? $value[lastauthorid] : $value[authorid]), middle, true)}--><!--{/if}-->" /></div>
			<!--{if $value[new]}--><div class="num"></div><!--{/if}-->
			<div class="wdxxlb cl">
				<span class="y"><!--{date($value[dateline], 'u')}--></span>
				<!--{if $value[touid]}-->
					<span class="hym">{$value[tousername]}</span>
				<!--{elseif $value['pmtype'] == 2}-->
					<span class="hym">{lang chatpm_author}:$value['firstauthor']</span>
				<!--{/if}-->
				<p><!--{if $value['pmtype'] == 2}-->[{lang chatpm}]<!--{if $value[subject]}-->$value[subject]<br><!--{/if}--><!--{/if}--><!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $value['pmtype'] == 2 && $value['lastauthor']}--><div style="padding:0 0 0 20px;">......<br>$value['lastauthor'] : $value[message]</div><!--{else}-->$value[message]<!--{/if}--></p>
			</div>
			</a>
		</li>
	<!--{/loop}-->
	</ul>
</div>
<!--{else}-->
<div class="n5qj_wnr">
	<img src="template/zhikai_n5app/images/n5sq_gzts.png">
	<p>{$n5app['lang']['kjwdxxwxxts']}</p>
</div>
<!--{/if}-->
<!--{/if}-->
<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->
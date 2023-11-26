<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<!--{template common/header}-->

<!--{if $_G['forum']['ismoderator']}-->
	<script type="text/javascript" src="{$_G[setting][jspath]}forum_moderate.js?{VERHASH}"></script>
<!--{/if}-->
<style id="diy_style" type="text/css"></style>
<!--[diy=diynavtop]--><div id="diynavtop" class="area"></div><!--[/diy]-->

<!--{ad/text/wp a_t}-->
<div class="wp">
	<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
</div>
<div class="boardnav cclist">
	<div id="ct" class="wp cl{if $_G[forum][picstyle]}{else}{if $_G['forum']['allowside']} ct2{/if}{/if}"{if $leftside} style="margin-left:{$_G['leftsidewidth_mwidth']}px"{/if}> 
			
		<div class="cl">
			<div class="forum_head cl">
			    <div class="forum_banner">
				 	<!--{if $_G[forum][banner] && !$subforumonly}-->
				 		<img src="{$_G['siteurl']}$_G[forum][banner]" width="192" height="106" alt="$_G['forum'][name]" />
					<!--{else}-->
						<img src="$_G['style']['styleimgdir']/img/noimage.jpg" width="192" height="106" alt="$_G['forum'][name]" />
					<!--{/if}-->
				</div>
			    <div class="forum_head_r cl">
					<h1 class="xs2"> <a href="forum.php?mod=forumdisplay&fid=$_G[fid]" class="forum_name">$_G['forum'][name]</a> </h1>
					<div class="forum_info">
						<div class="intro">{$_G[forum][description]}</div>
						<!--{if !$subforumonly}--><span class="xs1 xw0 i">{lang index_today}: <strong >$_G[forum][todayposts]</strong><!--{if $_G[forum][todayposts]}--><!--{if $_G[forum][todayposts] < $_G[forum][yesterdayposts]}--><b class="ico_fall">&nbsp;</b><!--{else}--><b class="ico_increase">&nbsp;</b><!--{/if}--><!--{/if}--><span class="pipe">|</span>{lang index_threads}: <strong>$_G[forum][threads]</strong><!--{if $_G[forum][rank]}--><span class="pipe">|</span>{lang rank}: <strong title="{lang previous_rank}:$_G[forum][oldrank]">$_G[forum][rank]</strong><!--{if $_G[forum][rank] <= $_G[forum][oldrank]}--><b class="ico_increase">&nbsp;</b><!--{else}--><b class="ico_fall">&nbsp;</b><!--{/if}--><!--{/if}--><span class="pipe">|</span>所属：{$forum_up[name]}</span><!--{/if}-->
						<!--{if $_G['forum']['ismoderator']}-->
							<!--{if $_G['forum']['recyclebin']}-->
								<span class="pipe">|</span><a href="{if $_G['adminid'] == 1}admin.php?mod=forum&action=recyclebin&frames=yes{elseif $_G['forum']['ismoderator']}forum.php?mod=modcp&action=recyclebin&fid=$_G[fid]{/if}" target="_blank">{lang forum_recyclebin}</a>
							<!--{/if}-->
							<!--{if $_G['forum']['ismoderator'] && !$_GET['archiveid']}-->
								<span class="pipe">|</span>
								<!--{if $_G['forum']['status'] != 3}-->
									<a href="forum.php?mod=modcp&fid=$_G[fid]">{lang modcp}</a>
								<!--{else}-->
									<a href="forum.php?mod=group&action=manage&fid=$_G[fid]">{lang modcp}</a>
								<!--{/if}-->
							<!--{/if}-->
						<!--{/if}-->
					</div>
				</div>
			</div>
		</div>
			<div class="qin_r mn" style="overflow: visible;">
				<div class="cbtop"> 
					<!--{if $leftside}-->
					<div id="sd_bdl" class="bdl" onmouseover="showMenu({'ctrlid':this.id, 'pos':'dz'});" style="width:{$_G['setting']['leftsidewidth']}px;margin-left:-{$_G['leftsidewidth_mwidth']}px"> 
						<!--{hook/forumdisplay_leftside_top}--> 
						<!--[diy=diyleftsidetop]--><div id="diyleftsidetop" class="area"></div><!--[/diy]-->
						<div class="tbn" id="forumleftside"> 
							<!--{subtemplate forum/forumdisplay_leftside}--> 
						</div>
						<!--[diy=diyleftsidebottom]--><div id="diyleftsidebottom" class="area"></div><!--[/diy]--> 
						<!--{hook/forumdisplay_leftside_bottom}--> 
					</div>
					<!--{/if}-->
					<div class="bml pbn"> 
						<!--{if !empty($forumarchive)}-->
						<div id="forumarchive_menu" class="p_pop" style="display:none">
							<ul>
								<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]">{lang threads_all}</a></li>
								<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $forumarchive $id $info}-->
								<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&archiveid=$id">{$info['displayname']} ({$info['threads']})</a></li>
								<!--{/loop}-->
							</ul>
						</div>
						<!--{/if}--> 
					</div>
					<!--{hook/forumdisplay_top}--> 
					<!--{if $subexists && $_G['page'] == 1}--><!--{template forum/forumdisplay_subforum}--><!--{/if}-->
					<div class="drag"> 
						<!--[diy=diy4]--><div id="diy4" class="area"></div><!--[/diy]--> 
					</div>
				</div>

				<!--{if !empty($_G['forum']['recommendlist'])}-->
					<div class="bm bmw">
						<div class="bm_h cl">
							<h2>{lang forum_recommend}</h2>
						</div>
						<div class="bm_c cl">
							<!--{subtemplate forum/recommend}-->
						</div>
					</div>
				<!--{/if}-->

				<!--{hook/forumdisplay_middle}-->

				<!--{if !$subforumonly}-->

					<!--{if $recommendgroups && !$_G['forum']['allowside']}-->
					<div class="bm bmw fl{if $_G['forum']['forumcolumns']} flg{/if}">
						<div class="bm_h cl">
							<span class="o"><img id="recommendgroups_{$_G[forum][fid]}_img" src="{IMGDIR}/$collapseimg[recommendgroups]" title="{lang spread}" alt="{lang spread}" onclick="toggle_collapse('recommendgroups_{$_G[forum][fid]}');" /></span>
							<h2>{lang recommended_groups}</h2>
						</div>
						<div class="bm_c" id="recommendgroups_{$_G[forum][fid]}" style="$collapse[recommendgroups]">
							<table cellspacing="0" cellpadding="0" class="fl_tb">
								<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $recommendgroups $key $group}-->
								<!--{if $_G['forum']['forumcolumns']}-->
									<!--{if $key && ($key % $_G['forum']['forumcolumns'] == 0)}-->
										</tr>
										<!--{if $key < $_G['forum']['forumcolumns']}-->
											<tr class="fl_row">
										<!--{/if}-->
									<!--{/if}-->
									<td class="fl_g">
										<div class="fl_icn_g">
											<a href="forum.php?mod=group&fid=$group[fid]" title="$group[name]" target="_blank"><img src="$group[icon]" alt="$group[name]" width="32" /></a>
										</div>
										<dl>
											<dt><a href="forum.php?mod=group&fid=$group[fid]" target="_blank">$group[name]</a><span class="xg1 xw0"> ($group[membernum] {lang activity_member_unit})</span>
											<dd><em>{lang forum_threads}: $group[threads]</em></dd>
											<dd>
												<!--{if is_array($group['lastpost'])}-->
													<!--{if $_G['forum']['forumcolumns'] < 3}-->
													<a href="forum.php?mod=redirect&tid=$group[lastpost][tid]&goto=lastpost#lastpost" class="xi2"><!--{echo cutstr($group[lastpost][subject], 30)}--></a> <cite>$group[lastpost][dateline] <!--{if $group['lastpost']['author']}--><a href="home.php?mod=space&username={$group[lastpost][encode_author]}">{$group[lastpost][author]}</a><!--{else}-->$_G[setting][anonymoustext]<!--{/if}--></cite>
													<!--{else}-->
														<a href="forum.php?mod=redirect&tid=$group[lastpost][tid]&goto=lastpost#lastpost" class="xi2">$group[lastpost][dateline]</a>
													<!--{/if}-->				<!--{else}-->
												{lang never}
												<!--{/if}-->
											</dd>
										</dl>
									</td>
								<!--{else}-->
									<tr {if $key != 0}class="fl_row"{/if}>
										<td class="fl_icn">
											<a href="forum.php?mod=group&fid=$group[fid]" title="$group[name]" target="_blank"><img src="$group[icon]" alt="$group[name]" width="32" /></a>
										</td>
										<td>
											<h2><a href="forum.php?mod=group&fid=$group[fid]" target="_blank">$group[name]</a><span class="xg1 xw0"> ($group[membernum] {lang activity_member_unit})</span></h2>
											<p><!--{echo cutstr($group[description], 100)}--></p>
										</td>
										<td class="fl_i">
											<span class="xi2">$group[threads] {lang index_threads}</span>
										</td>
										<td class="fl_by">
											<div>
												<!--{if is_array($group['lastpost'])}-->
												<a href="forum.php?mod=redirect&tid=$group[lastpost][tid]&goto=lastpost#lastpost" class="xi2"><!--{echo cutstr($group[lastpost][subject], 30)}--></a> <cite>$group[lastpost][dateline] <!--{if $group['lastpost']['author']}--><a href="home.php?mod=space&username={$group[lastpost][encode_author]}">{$group[lastpost][author]}</a><!--{else}-->$_G[setting][anonymoustext]<!--{/if}--></cite>
												<!--{else}-->
												{lang never}
												<!--{/if}-->
											</div>
										</td>
									</tr>
								<!--{/if}-->
								<!--{/loop}-->
							</table>
						</div>
					</div>
					<!--{/if}-->

					<!--{if $threadmodcount}--><div class="bm"><div class="ntc_l hm xi2"><strong>{lang forum_moderate_unhandled}</strong></div></div><!--{/if}-->

					<!--{if $livethread}-->
						<div id="livethread" class="tl bm bmw cl" style="padding:10px 15px;">
							<div class="livethreadtitle vm">
								<span class="replynumber xg1">{lang reply} <span id="livereplies" class="xi1">$livethread[replies]</span></span>
								<a href="forum.php?mod=viewthread&tid=$livethread[tid]" target="_blank">$livethread[subject]</a> <img src="{IMGDIR}/livethreadtitle.png" />
							</div>
							<div class="livethreadcon">$livemessage</div>
							<div id="livereplycontentout">
								<div id="livereplycontent">
								</div>
							</div>
							<div id="liverefresh">{lang forum_live_newreply_refresh}</div>
							<div id="livefastreply">
								<form id="livereplypostform" method="post" action="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$livethread[tid]&replysubmit=yes&infloat=yes&handlekey=livereplypost&inajax=1" onsubmit="return livereplypostvalidate(this)">
									<div id="livefastcomment">
										<textarea id="livereplymessage" name="message" style="color:gray;<!--{if !$liveallowpostreply}-->display:none;<!--{/if}-->">{lang forum_live_fastreply_notice}</textarea>
										<!--{if !$liveallowpostreply}-->
											<div>
												<!--{if !$_G[uid]}-->
													{lang login_to_reply} <a href="member.php?mod=logging&action=login" onclick="showWindow('login', this.href)" class="xi2">{lang login}</a> | <a href="member.php?mod={$_G[setting][regname]}" class="xi2">$_G['setting']['reglinkname']</a>
												<!--{else}-->
													{lang no_permission_to_post}<a href="javascript:;" onclick="ajaxpost('livereplypostform', 'livereplypostreturn', 'livereplypostreturn', 'onerror', $('livereplysubmit'));" class="xi2">{lang click_to_show_reason}</a>
												<!--{/if}-->
											</div>
										<!--{/if}-->
									</div>
									<div id="livepostsubmit" style="display:none;">
									<!--{if $secqaacheck || $seccodecheck}-->
										<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu(this.id)"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
										<div class="mtm sec" style="text-align:right;"><!--{subtemplate common/seccheck}--></div>
									<!--{/if}-->
									<p class="ptm pnpost" style="margin-bottom:10px;">
									<button type="submit" name="replysubmit" class="pn pnc vm" style="float:right;" value="replysubmit" id="livereplysubmit">
										<strong>{lang forum_live_post}</strong>
									</button>
									</p>
									</div>
									<input type="hidden" name="formhash" value="{FORMHASH}">
									<input type="hidden" name="subject" value="  ">
								</form>
							</div>
							<span id="livereplypostreturn"></span>
						</div>
						<script type="text/javascript">
							var postminchars = parseInt('$_G['setting']['minpostsize']');
							var postmaxchars = parseInt('$_G['setting']['maxpostsize']');
							var disablepostctrl = parseInt('{$_G['group']['disablepostctrl']}');
							var replycontentlist = new Array();
							var addreplylist = new Array();
							var timeoutid = timeid = movescrollid = waitescrollid = null;
							var replycontentnum = 0;
							getnewlivepostlist(1);
							timeid = setInterval(getnewlivepostlist, 5000);
							$('livereplycontent').style.position = 'absolute';
							$('livereplycontent').style.width = ($('livereplycontentout').clientWidth - 50) + 'px';
							$('livereplymessage').onfocus = function() {
								if(this.style.color == 'gray') {
									this.value = '';
									this.style.color = 'black';
									$('livepostsubmit').style.display = 'block';
									this.style.height = '56px';
									$('livefastcomment').style.height = '57px';
								}
							};
							$('livereplymessage').onblur = function() {
								if(this.value == '') {
									this.style.color = 'gray';
									this.value = '{lang forum_live_fastreply_notice}';
								}
							};

							$('liverefresh').onclick = function() {
								$('livereplycontent').style.position = 'absolute';
								getnewlivepostlist();
								this.style.display = 'none';
							};

							$('livereplycontentout').onmouseover = function(e) {

								if($('livereplycontent').style.position == 'absolute' && $('livereplycontent').clientHeight > 215) {
									$('livereplycontent').style.position = 'static';
									this.scrollTop = this.scrollHeight;
								}

								if(this.scrollTop + this.clientHeight != this.scrollHeight) {
									clearInterval(timeid);
									clearTimeout(timeoutid);
									clearInterval(movescrollid);
									timeid = timeoutid = movescrollid = null;

									if(waitescrollid == null) {
										waitescrollid = setTimeout(function() {
											$('liverefresh').style.display = 'block';
										}, 60000 * 10);
									}
								} else {
									clearTimeout(waitescrollid);
									waitescrollid = null;
								}
							};

							$('livereplycontentout').onmouseout = function(e) {
								if(this.scrollTop + this.clientHeight == this.scrollHeight) {
									$('livereplycontent').style.position = 'absolute';
									clearInterval(timeid);
									timeid = setInterval(getnewlivepostlist, 10000);
								}
							};

							function getnewlivepostlist(first) {
								var x = new Ajax('JSON');
								x.getJSON('forum.php?mod=misc&action=livelastpost&fid=$livethread[fid]', function(s, x) {
									var count = s.data.count;
									$('livereplies').innerHTML = count;
									var newpostlist = s.data.list;
									for(i in newpostlist) {
										var postid = i;
										var postcontent = '';
										postcontent += newpostlist[i].authorid ? '<dt><a href="home.php?mod=space&uid=' + newpostlist[i].authorid + '" target="_blank">' + newpostlist[i].avatar + '</a></dt>' : '<dt></dt>';
										postcontent += newpostlist[i].authorid ? '<dd><a href="home.php?mod=space&uid=' + newpostlist[i].authorid + '" target="_blank">' + newpostlist[i].author + '</a></dd>' : '<dd>' + newpostlist[i].author + '</dd>';
										postcontent += '<dd>' + htmlspecialchars(newpostlist[i].message) + '</dd>';
										postcontent += '<dd class="dateline">' + newpostlist[i].dateline + '</dd>';
										if(replycontentlist[postid]) {
											$('livereply_' + postid).innerHTML = postcontent;
											continue;
										}
										addreplylist[postid] = '<dl id="livereply_' + postid + '">' + postcontent + '</dl>';
									}
									if(first) {
										for(i in addreplylist) {
											replycontentlist[i] = addreplylist[i];
											replycontentnum++;
											var div = document.createElement('div');
											div.innerHTML = addreplylist[i];
											$('livereplycontent').appendChild(div);
											delete addreplylist[i];
										}
									} else {
										livecontentfacemove();
									}
								});
							}

							function livecontentfacemove() {
								//note 从队列中取出数据
								var reply = '';
								for(i in addreplylist) {
									reply = replycontentlist[i] = addreplylist[i];
									replycontentnum++;
									delete addreplylist[i];
									break;
								}
								if(reply) {
									var div = document.createElement('div');
									div.innerHTML = reply;
									var oldclientHeight = $('livereplycontent').clientHeight;
									$('livereplycontent').appendChild(div);
									$('livereplycontentout').style.overflowY = 'hidden';
									$('livereplycontent').style.bottom = oldclientHeight - $('livereplycontent').clientHeight + 'px';

									if(replycontentnum > 20) {
										$('livereplycontent').removeChild($('livereplycontent').firstChild);
										for(i in replycontentlist) {
											delete replycontentlist[i];
											break;
										}
										replycontentnum--;
									}

									if(!movescrollid) {
										movescrollid = setInterval(function() {
											if(parseInt($('livereplycontent').style.bottom) < 0) {
												$('livereplycontent').style.bottom =
													((parseInt($('livereplycontent').style.bottom) + 5) > 0 ? 0 : (parseInt($('livereplycontent').style.bottom) + 5)) + 'px';
											} else {
												$('livereplycontentout').style.overflowY = 'auto';
												clearInterval(movescrollid);
												movescrollid = null;
												timeoutid = setTimeout(livecontentfacemove, 1000);
											}
										}, 100);
									}
								}
							}

							function livereplypostvalidate(theform) {
								var s;
								if(theform.message.value == '' || $('livereplymessage').style.color == 'gray') {
									s = '{lang forum_live_nocontent_error}';
								}
								if(!disablepostctrl && ((postminchars != 0 && mb_strlen(theform.message.value) < postminchars) || (postmaxchars != 0 && mb_strlen(theform.message.value) > postmaxchars))) {
									s = {lang forum_live_nolength_error};
								}
								if(s) {
									showError(s);
									doane();
									$('livereplysubmit').disabled = false;
									return false;
								}
								$('livereplysubmit').disabled = true;
								theform.message.value = theform.message.value.replace(/([^>=\]"'\/]|^)((((https?|ftp):\/\/)|www\.)([\w\-]+\.)*[\w\-\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&~`@':+!]*)+\.(jpg|gif|png|bmp))/ig, '$1[img]$2[/img]');
								theform.message.value = parseurl(theform.message.value);
								ajaxpost('livereplypostform', 'livereplypostreturn', 'livereplypostreturn', 'onerror', $('livereplysubmit'));
								return false;
							}

							function succeedhandle_livereplypost(url, msg, param) {
								$('livereplymessage').value = '';
								$('livereplycontent').style.position = 'absolute';
								if(param['sechash']) {
									updatesecqaa(param['sechash']);
									updateseccode(param['sechash']);
								}
								getnewlivepostlist();
							}
						</script>
					<!--{/if}-->
						
					<!--{hook/forumdisplay_threadtype_extra}--> 
					
					<!--{if empty($_G['forum']['sortmode'])}--> 
						<!--[diy=diy111111]--><div id="diy111111" class="area"></div><!--[/diy]--> 
						<!--{subtemplate forum/forumdisplay_list}--> 
					<!--{else}--> 
						<!--{subtemplate forum/forumdisplay_sort}--> 
					<!--{/if}-->
					<!--{/if}-->  

					<!--[diy=diyfastposttop]--><div id="diyfastposttop" class="area"></div><!--[/diy]--> 
					<!--{hook/forumdisplay_bottom}--> 
					<!--[diy=diyforumdisplaybottom]--><div id="diyforumdisplaybottom" class="area"></div><!--[/diy]--> 
				</div>

				<!--{if $_G[forum][picstyle]}-->
				<!--{else}-->
				<!--{if $_G['forum']['allowside']}-->
				<div class="box_right" style="margin-top:8px;">
						
					<!--{eval //out($moderatedby)}--> 
					<!--{if (!empty($_G[forum][domain]) && !empty($_G['setting']['domain']['root']['forum'])) || $moderatedby || ($_G['page'] == 1 && $_G['forum']['rules'])}-->
					<div class="bk nbk" style="padding-bottom:20px; margin-bottom:20px">
						<div class="bm_c cl">
							<span class="titletext">
								本版小喇叭<!--[diy=diy200]--><div id="diy200" class="area"></div><!--[/diy]-->
							</span> 
							<!--{if !empty($_G[forum][domain]) && !empty($_G['setting']['domain']['root']['forum'])}-->
							<div class="pbn">{lang forum_domain}: <a href="http://{$_G[forum][domain]}.{$_G['setting']['domain']['root']['forum']}" id="group_link">http://{$_G[forum][domain]}.{$_G['setting']['domain']['root']['forum']}</a></div>
							<!--{/if}--> 
							<!--{if $moderatedby}--><b>{lang forum_modedby}: <span class="xi2">$moderatedby</span></b><!--{/if}--> 
							<!--{if $_G['forum']['rules']}-->
							<div id="forum_rules_{$_G[fid]}" style="$collapse['forum_rules'];">
								<div class="ptn xg2">$_G['forum'][rules]</div>
							</div>
							<!--{/if}--> 
						</div>
					</div>
					<!--{/if}--> 
					
					<div class="sd nbk"> 
						<!--{hook/forumdisplay_side_top}--> 
						<!--{if !$subforumonly}--> 
							<!--{if $recommendgroups}-->
							<div class="bm">
								<div class="bm_h cl">
									<h2>{lang recommended_groups}</h2>
								</div>
								<div class="bm_c cl">
									<ul class="ml mls cl">
										<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $recommendgroups $key $group}-->
										<li>
											<a href="forum.php?mod=group&fid=$group[fid]" title="$group[name]" target="_blank" class="avt"><img src="$group[icon]" alt="$group[name]"></a>
											<p>
												<a href="forum.php?mod=group&fid=$group[fid]" target="_blank">$group[name]</a>
											</p>
										</li>
										<!--{/loop}-->
									</ul>
								</div>
							</div>
							<!--{/if}--> 
						<!--{/if}-->
							
						<div class="drag">
						    <!--[diy=diyfd01]--><div id="diyfd01" class="area"></div><!--[/diy]-->

						    <!--[diy=diyfd02]--><div id="diyfd02" class="area"></div><!--[/diy]-->

							<!--[diy=diyfd03]--><div id="diyfd03" class="area"></div><!--[/diy]-->

							<!--[diy=diyfd04]--><div id="diyfd04" class="area"></div><!--[/diy]-->

							<!--[diy=diyfd05]--><div id="diyfd05" class="area"></div><!--[/diy]-->

							<!--[diy=diyfd06]--><div id="diyfd06" class="area"></div><!--[/diy]-->

							<!--[diy=diyfd07]--><div id="diyfd07" class="area"></div><!--[/diy]-->

							<!--[diy=diyfd08]--><div id="diyfd08" class="area"></div><!--[/diy]-->
						</div>

					</div>
				<!--{/if}-->
				<!--{/if}-->
		</div>
	</div>
</div>

<!--{if $_G['group']['allowpost'] && ($_G['group']['allowposttrade'] || $_G['group']['allowpostpoll'] || $_G['group']['allowpostreward'] || $_G['group']['allowpostactivity'] || $_G['group']['allowpostdebate'] || $_G['setting']['threadplugins'] || $_G['forum']['threadsorts'])}-->

<ul class="p_pop" id="newspecial_menu" style="display: none">	
	<!--{if !$_G['forum']['allowspecialonly']}-->
	<li><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]">{lang post_newthread}</a></li>
	<!--{/if}--> 
	
	<!--{if $_G['forum']['threadsorts'] && !$_G['forum']['allowspecialonly']}--> 
		<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $_G['forum']['threadsorts']['types'] $id $threadsorts}--> 
		<!--{if $_G['forum']['threadsorts']['show'][$id]}-->
		<li class="popupmenu_option"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&extra=$extra&sortid=$id">$threadsorts</a></li>
		<!--{/if}--> 
		<!--{/loop}--> 
	<!--{/if}--> 
	
	<!--{if $_G['group']['allowpostpoll']}-->
	<li class="poll"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=1">{lang post_newthreadpoll}</a></li>
	<!--{/if}--> 
	
	<!--{if $_G['group']['allowpostreward']}-->
	<li class="reward"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=3">{lang post_newthreadreward}</a></li>
	<!--{/if}--> 
	
	<!--{if $_G['group']['allowpostdebate']}-->
	<li class="debate"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=5">{lang post_newthreaddebate}</a></li>
	<!--{/if}--> 
	
	<!--{if $_G['group']['allowpostactivity']}-->
	<li class="activity"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=4">{lang post_newthreadactivity}</a></li>
	<!--{/if}--> 
	
	<!--{if $_G['group']['allowposttrade']}-->
	<li class="trade"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=2">{lang post_newthreadtrade}</a></li>
	<!--{/if}--> 
	
	<!--{if $_G['setting']['threadplugins']}--> 
		<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $_G['forum']['threadplugin'] $tpid}--> 
		<!--{if array_key_exists($tpid, $_G['setting']['threadplugins']) && @in_array($tpid, $_G['group']['allowthreadplugin'])}-->
		<li class="popupmenu_option"{if $_G['setting']['threadplugins'][$tpid][icon]} style="background-image:url(source/plugin/$tpid/$_G[setting][threadplugins][$tpid][icon])"{/if}><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&specialextra=$tpid">{$_G[setting][threadplugins][$tpid][name]}</a></li>
		<!--{/if}--> 
		<!--{/loop}--> 
	<!--{/if}-->	
</ul>

<!--{/if}--> 

<!--{if $_G['setting']['visitedforums'] && $_G['forum']['status'] != 3}-->
<div id="visitedforums_menu" class="p_pop blk cl" style="display: none;">
	<table cellspacing="0" cellpadding="0">
		<tr>
			<td id="v_forums">
				<h3 class="mbn pbn bbda xg1">{lang viewed_forums}</h3>
				<ul class="xl xl1">
					$_G['setting']['visitedforums']
				</ul>
			</td>
		</tr>
	</table>
</div>
<!--{/if}--> 

<!--{if $_G['setting']['threadmaxpages'] > 1 && $page && !$subforumonly}-->
	<script type="text/javascript">document.onkeyup = function(e){keyPageScroll(e, <!--{if $page > 1}-->1<!--{else}-->0<!--{/if}-->, <!--{if $page < $_G['setting']['threadmaxpages'] && $page < $_G['page_next']}-->1<!--{else}-->0<!--{/if}-->, 'forum.php?mod=forumdisplay&fid={$_G[fid]}&filter={$filter}&orderby={$_GET[orderby]}{$forumdisplayadd[page]}&{$multipage_archive}', $page);}</script>
<!--{/if}-->

<!--{if empty($_G['forum']['picstyle']) && $_GET['orderby'] == 'lastpost' && empty($_GET['filter']) }-->
	<script type="text/javascript">checkForumnew_handle = setTimeout(function () {checkForumnew($_G[fid], lasttime);}, checkForumtimeout);</script>
<!--{/if}-->
<div class="wp mtn">
	<!--[diy=diy3]--><div id="diy3" class="area"></div><!--[/diy]-->
</div>
<!--{if empty($_G['setting']['disfixednv_forumdisplay']) }--><script>fixed_top_nv();</script><!--{/if}-->
<!--{template common/footer}-->

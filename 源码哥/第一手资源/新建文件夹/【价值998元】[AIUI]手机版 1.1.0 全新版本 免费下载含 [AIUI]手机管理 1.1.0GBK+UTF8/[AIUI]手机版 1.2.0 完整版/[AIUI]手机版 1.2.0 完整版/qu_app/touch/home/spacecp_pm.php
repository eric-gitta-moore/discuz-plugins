<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<!--{if $_GET['op'] == 'delete'}-->

		<h3 class="flb">
			<em id="return_$_GET[handlekey]">{lang delete_pm}</em>
			<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
		</h3>
		<!--{if $uid}-->
			<div id="$uid">
				<form id="delpmform_{$uid}" name="delpmform_{$uid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=delete&deletepm_deluid[]=$uid">
					<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
					<input type="hidden" name="referer" value="{echo dreferer()}" />
					<input type="hidden" name="deletesubmit" value="true" />
					<input type="hidden" name="formhash" value="{FORMHASH}" />
					<div class="c">{lang determine_delete_pm}</div>
					<p class="o pns">
						<button type="submit" name="deletesubmit_btn" value="true" class="pn pnc"><strong>{lang determine}</strong></button>
					</p>
				</form>
			</div>
		<!--{elseif $plid && $delplid}-->
			<div id="$plid">
				<form id="delpmform_{$plid}" name="delpmform_{$plid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=delete&deletepm_delplid[]=$plid">
					<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
					<input type="hidden" name="referer" value="{echo dreferer()}" />
					<input type="hidden" name="deletesubmit" value="true" />
					<input type="hidden" name="formhash" value="{FORMHASH}" />
					<div class="c">{lang determine_delete_chatpm}</div>
					<p class="o pns">
						<button type="submit" name="deletesubmit_btn" value="true" class="pn pnc"><strong>{lang determine}</strong></button>
					</p>
				</form>
			</div>
		<!--{elseif $plid && $quitplid}-->
			<div id="$plid">
				<form id="delpmform_{$plid}" name="delpmform_{$plid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=delete&deletepm_quitplid[]=$plid">
					<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
					<input type="hidden" name="referer" value="{echo dreferer()}" />
					<input type="hidden" name="deletesubmit" value="true" />
					<input type="hidden" name="formhash" value="{FORMHASH}" />
					<div class="c">{lang determine_quit_chatpm}</div>
					<p class="o pns">
						<button type="submit" name="deletesubmit_btn" value="true" class="pn pnc"><strong>{lang quit}</strong></button>
					</p>
				</form>
			</div>
		<!--{elseif $pmid && $delpmid}-->
			<div id="$pmid">
				<form id="delpmform_{$pmid}" name="delpmform_{$pmid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=delete&deletepm_pmid[]=$pmid&touid=$touid&daterange=$daterange">
					<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
					<input type="hidden" name="referer" value="{echo dreferer()}" />
					<input type="hidden" name="deletesubmit" value="true" />
					<input type="hidden" name="formhash" value="{FORMHASH}" />
					<div class="c">{lang determine_delete_pmid}</div>
					<p class="o pns">
						<button type="submit" name="deletesubmit_btn" value="true" class="pn pnc"><strong>{lang determine}</strong></button>
					</p>
				</form>
			</div>
		<!--{elseif $pmid && $gpmid}-->
			<div id="$pmid">
				<form id="delpmform_{$pmid}" name="delpmform_{$pmid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=delete&deletepm_gpmid[]=$pmid">
					<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
					<input type="hidden" name="referer" value="{echo dreferer()}" />
					<input type="hidden" name="deletesubmit" value="true" />
					<input type="hidden" name="formhash" value="{FORMHASH}" />
					<div class="c">{lang determine_delete_gpmid}</div>
					<p class="o pns">
						<button type="submit" name="deletesubmit_btn" value="true" class="pn pnc"><strong>{lang determine}</strong></button>
					</p>
				</form>
			</div>
		<!--{/if}-->
		<!--{if $_G[inajax]}-->
			<script type="text/javascript">
				function succeedhandle_$_GET[handlekey](url, msg, values) {
					if($('pmlist_'+values['plid'])) {
						$('pmlist_'+values['plid']).style.display = 'none';
					}
					if($('gpmlist_'+values['gpmid'])) {
						$('gpmlist_'+values['gpmid']).style.display = 'none';
					}
				}
			</script>
		<!--{/if}-->
<!--{elseif $_GET['op'] == 'pm_report'}-->

		<h3 class="flb">
			<em id="return_$_GET[handlekey]">{lang pm_report}</em>
			<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
		</h3>
		<div id="$pmid">
			<form id="pmreportform_{$pmid}" name="pmreportform_{$pmid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=pm_report&pmid=$pmid"  {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
				<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				<input type="hidden" name="referer" value="{echo dreferer()}" />
				<input type="hidden" name="pmreportsubmit" value="true" />
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<div class="c">{lang determine_report_pm}</div>
				<p class="o pns">
					<button type="submit" name="pmreportsubmit_btn" value="true" class="pn pnc"><strong>{lang determine}</strong></button>
				</p>
			</form>
		</div>

<!--{elseif $_GET['op'] == 'pm_ignore'}-->

		<h3 class="flb">
			<em id="return_$_GET[handlekey]">{lang pm_ignore}</em>
			<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
		</h3>
		<div id="$plid">
			<form id="pmignoreform_{$plid}" name="pmignoreform_{$plid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=pm_ignore&plid=$plid&username=$username"  {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
				<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				<input type="hidden" name="referer" value="{echo dreferer()}" />
				<input type="hidden" name="pmignoresubmit" value="true" />
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<div class="c">{lang determine_ignore_pm}</div>
				<p class="o pns">
					<button type="submit" name="pmignoresubmit_btn" value="true" class="pn pnc"><strong>{lang determine}</strong></button>
				</p>
			</form>
		</div>

<!--{elseif $_GET['op'] == 'kickmember'}-->

		<h3 class="flb">
			<em id="return_$_GET[handlekey]">{lang pm_kickmember}</em>
			<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
		</h3>
		<div id="$memberuid">
			<form id="kickmemberform_{$memberuid}" name="kickmemberform_{$memberuid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=kickmember&plid=$plid&memberuid=$memberuid"  {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
				<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				<input type="hidden" name="referer" value="{echo dreferer()}" />
				<input type="hidden" name="pmkickmembersubmit" value="true" />
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<div class="c">{lang determine_kickmember}</div>
				<p class="o pns">
					<button type="submit" name="pmkickmembersubmit_btn" value="true" class="pn pnc"><strong>{lang determine}</strong></button>
				</p>
			</form>
		</div>

<!--{elseif $_GET['op'] == 'appendmember'}-->

		<h3 class="flb">
			<em id="return_$_GET[handlekey]">{lang pm_appendmember}</em>
			<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
		</h3>
		<div id="appendmember">
			<form id="appendmemberform" name="appendmemberform" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=appendmember&plid=$plid&memberusername=$memberusername"  {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
				<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				<input type="hidden" name="referer" value="{echo dreferer()}" />
				<input type="hidden" name="pmappendmembersubmit" value="true" />
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<div class="c">{lang determine_appendmember}</div>
				<p class="o pns">
					<button type="submit" name="pmappendmembersubmit_btn" value="true" class="pn pnc"><strong>{lang determine}</strong></button>
				</p>
			</form>
		</div>

<!--{elseif $_GET['op'] == 'getpmuser'}-->
	$jsstr
<!--{elseif $_GET['op'] == 'ignore'}-->

	<h3 class="flb">
		<em id="return_$_GET[handlekey]">{lang shield}{$username}</em>
		<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
	</h3>
	<form id="ignoreuserform" name="ignoreuserform" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=ignore&only=1"  {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="ignoresubmit" value="true" />
		<input type="hidden" name="ignoreuser" value="$_GET[username]" />
		<input type="hidden" name="single" value="1" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<div class="c">{lang shield_the_user}</div>
		<p class="o pns">
			<button type="submit" name="deletesubmit_btn" value="true" class="pn pnc"><strong>{lang determine}</strong></button>
		</p>
	</form>
<!--{elseif $_GET['op'] == 'showmsg'}-->

	<!--{if $msgonly}-->
		<!--{loop $msglist $day $msgarr}-->
			<li class="cl">
				<h4 class="xg1">$day</h4>
			</li>
			<!--{loop $msgarr $key $value}-->
			<!--{eval $class=$value['touid']==$_G['uid']?'cl':'cl pmm';}-->
			<li class="$class">
				<div class="pmt">{$value[author]}: </div>
				<div class="pmd">{$value[message]}</div>
			</li>
			<!--{/loop}-->
		<!--{/loop}-->
	<!--{else}-->
	<div class="ainuo_nowpm">

		<div class="c">
			<ul class="pmb" id="msglist">
				<!--{loop $msglist $day $msgarr}-->
				<div class="cl">
					<h4><span>$day</span></h4>
				</div>
				<!--{loop $msgarr $key $value}-->
				<!--{eval $class=$value['touid']==$_G['uid']?'cl':'cl pmm';}-->
				<li class="$class">
                	<div class="cl">
                        <div class="auava"><a href="home.php?mod=space&uid={$value[authorid]}&do=profile"><img src="<!--{avatar($value[authorid], middle, true)}-->" /></a></div>
                        <div class="pmt"></div>
                        <div class="pmd">{$value[message]}</div>
                    </div>
                    <div class="adate cl"><!--{date($value[dateline], 'u')}--></div>
				</li>
                
				<!--{/loop}-->
				<!--{/loop}-->
			</ul>
			<script type="text/javascript">
			var refresh = true;
			var refreshHandle = -1;
			</script>
            <div class="cl" style="width:100%; height:50px;"></div>
			<div class="pmfm cl">
				<form id="pmform_{$touid}" name="pmform_{$touid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=send&pmid=$pmid&daterange=$daterange&pmsubmit=yes&mobile=2" onsubmit="this.message.value = parseurl(this.message.value);{if $_G[inajax]}ajaxpost(this.id,  'return_$_GET[handlekey]');{/if}">
					<input type="hidden" name="pmsubmit" value="true" />
					<input type="hidden" name="touid" value="$touid" />
					<input type="hidden" name="formhash" value="{FORMHASH}" />
					<!--{if $_G[inajax]}-->
					<div id="return_$_GET[handlekey]" class="xi1" style="margin-bottom:5px"></div>
					<input type="hidden" name="handlekey" value="$_GET[handlekey]" />
					<!--{/if}-->
                    <div class="tedt_con">
                        <div class="tedt_l">
                            <textarea name="message" id="pmmessage" placeholder="$alang_xsds" onkeydown="ctrlEnter(event, 'pmsubmit_btn');" autofocus></textarea>
                            <input type="hidden" name="messageappend" id="messageappend" value="$messageappend" />
                            <script type="text/javascript">$('pmmessage').focus();</script>
                        </div>
                        <div class="tedt_r">
                            <button type="submit" class="formdialog" id="pmsubmit_btn">{lang send}</button>
                        </div>
                    </div>
				</form>
				<script type="text/javascript">var forumallowhtml = 0,allowhtml = 0,allowsmilies = true,allowbbcode = parseInt('{$_G[group][allowsigbbcode]}'),allowimgcode = parseInt('{$_G[group][allowsigimgcode]}');var DISCUZCODE = [];DISCUZCODE['num'] = '-1';DISCUZCODE['html'] = [];</script>
				<script type="text/javascript">
					var msgListObj = $('msglist');
					msgListObj.scrollTop = msgListObj.scrollHeight;
					function succeedhandle_$_GET[handlekey](url, msg, values) {
						var liObj = document.createElement("li");
						var pmMsg = $('pmmessage');
						liObj.className = 'cl pmm';
						pmMsg.value = ($('messageappend').value ? $('messageappend').value + '\n' : '') + pmMsg.value;
						$('messageappend').value = '';
						liObj.innerHTML = '<div class="pmt">$_G[username]: </div><div class="pmd">'+bbcode2html(parseurl(pmMsg.value))+'</div>';
						msgListObj.appendChild(liObj);
						msgListObj.scrollTop = msgListObj.scrollHeight;
						pmMsg.value = "";
						showCreditPrompt();
					}

					function refreshMsg() {
						if(refresh) {
							var x = new Ajax();
							x.get('home.php?mod=spacecp&ac=pm&op=showmsg&msgonly=1&touid=$touid&pmid=$pmid&inajax=1&daterange=$daterange', function(s){
								msgListObj.innerHTML = s;
								msgListObj.scrollTop = msgListObj.scrollHeight;
	   						});
						} else {
							window.clearInterval(refreshHandle);
						}
					}
					refreshHandle = window.setInterval('refreshMsg();', 8000);
					hideMenu();
				</script>
			</div>
		</div>
	</div>
	<!--{/if}-->
<!--{elseif $_GET['op'] == 'showchatmsg'}-->
	<!--{loop $list $key $value}-->
		<p class="xg1 mbn"><a href="home.php?mod=space&uid=$value[authorid]" target="_blank" class="xi2">$value[author]</a> &nbsp; <!--{date($value[dateline], 'u')}--></p>
		<p class="mbm">$value[message]</p>
	<!--{/loop}-->
<!--{else}-->
<!-- header start -->
<header class="header">
    <div class="nav">
        <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
        <span class="name">{lang send_pm}</span>
    </div>
</header>
<!-- header end -->
<div class="ainuo_usertb cl">
    <ul class="tb afxx cl">
        <li{if !$type} class="a"{/if}><a href="home.php?mod=spacecp&ac=pm">{lang private_pm}</a></li>
			<li{if $type == 1} class="a"{/if}><a href="home.php?mod=spacecp&ac=pm&type=1">{lang chat_type}</a></li>
    </ul>
</div>
<div class="grey_line cl"></div>

	<!--{if !$type}-->
		<div id="__pmform_{$pmid}">
			<form id="pmform_{$pmid}" name="pmform_{$pmid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=send&touid=$touid&pmid=$pmid" onsubmit="this.message.value = parseurl(this.message.value);{if $_G[inajax]}ajaxpost(this.id,  'return_$_GET[handlekey]');{/if}">
				<input type="hidden" name="referer" value="{echo dreferer()}" />
				<input type="hidden" name="pmsubmit" value="true" />
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<!--{if $_G[inajax]}-->
					<input type="hidden" name="handlekey" value="$_GET[handlekey]" />
				<!--{/if}-->
				<div class="ainuo_faxiaoxi cl">
					<script type="text/javascript">
						var fs;
						var clearlist = 0;
					</script>
					<table cellspacing="0" cellpadding="0" width="100%">
						<!--{if !$touid}-->
						<tr>
							<td>
									<div class="un_selector cl" onclick="$('username').focus();">
										<input placeholder="{lang addressee}" type="text" name="username" id="username" class="px" autocomplete="off" />
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
												gid = isUndefined(gid) ? -1 : parseInt(gid);
												if(haveFriend) {
													getUser(page, gid);
												}
											}
										}
										getUser(page);
									}
									selector();
								</script>

								<p class="dashedtip">{lang sendpm_tip}</p>
							</td>
						</tr>

						<!--{/if}-->
						<tr>
							
							<td>

								<div class="tedt cl">

										<textarea rows="4" placeholder="{lang content}" name="message" class="px" id="sendmessage" onkeydown="ctrlEnter(event, 'pmsubmit_btn');"></textarea>

								</div>
							</td>
						</tr>
			<!--{if $_G[inajax]}-->
					</table>
				</div>
				<p class="cl">
					<button type="submit" name="pmsubmit_btn" id="pmsubmit_btn" value="true">{lang send}</button>
				</p>
			<!--{else}-->
						<tr>
							<td>
                            <p class="cl">
								<button type="submit" name="pmsubmit_btn" id="pmsubmit_btn" value="true">{lang send}</button>
                            </p>
							</td>
						</tr>
					</table>
				</div>
			<!--{/if}-->
			</form>
		</div>
	<!--{elseif $type == 1}-->
		<div id="__pmform_{$pmid}">
			<form id="pmform_{$pmid}" name="pmform_{$pmid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=send&touid=$touid&pmid=$pmid" onsubmit="this.message.value = parseurl(this.message.value);{if $_G[inajax]}ajaxpost(this.id,  'return_$_GET[handlekey]');{/if}">
				<input type="hidden" name="referer" value="{echo dreferer()}" />
				<input type="hidden" name="pmsubmit" value="true" />
				<input type="hidden" name="type" value="1" />
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<div class="ainuo_faxiaoxi cl">

					<script type="text/javascript">
						var fs;
						var clearlist = 0;
					</script>
					<table cellspacing="0" cellpadding="0" width="100%">
						<!--{if !$touid}-->
						<tr>
							<td>
								<div class="un_selector cl" style="margin-bottom:10px;">
									<input type="text" placeholder="{lang title}" name="subject" class="px" id="subject" />
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="cl">
									<div class="un_selector cl" onclick="$('username').focus();">
										<input type="text" placeholder="{lang joiner}" name="username" id="username" autocomplete="off" class="px" />
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
												gid = isUndefined(gid) ? -1 : parseInt(gid);
												if(haveFriend) {
													getUser(page, gid);
												}
											}
										}
										getUser(page);
									}
									selector();
								</script>

								<p class="dashedtip">{lang sendpm_tip}</p>
							</td>
						</tr>

						<!--{/if}-->
						<tr>
							<td>
								<div class="tedt">
										<textarea rows="4" placeholder="{lang content}" name="message" class="px" id="sendmessage" onkeydown="ctrlEnter(event, 'pmsubmit_btn');"></textarea>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<button type="submit" name="pmsubmit_btn" id="pmsubmit_btn" value="true">{lang send}</button>
							</td>
						</tr>
					</table>
				</div>
			</form>
		</div>
	<!--{/if}-->
<!--{/if}-->


<!--{template common/footer}-->
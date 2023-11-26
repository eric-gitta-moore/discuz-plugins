<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!--{if $_GET['op'] == 'resend'}-->
<header class="header">
    <div class="nav">
         <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
        <span class="category">
            <span class="name">
            {lang send_mail_again}
            </span>
        </span>
    </div>
</header>
<div class="ainuo_yaoqinglink cl">
    <form id="resendform_{$id}" name="resendform_{$id}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=invite&op=resend&id=$id" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
        <input type="hidden" name="referer" value="{echo dreferer()}" />
        <input type="hidden" name="resendsubmit" value="true" />
        <!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
        <input type="hidden" name="formhash" value="{FORMHASH}" />
        <div class="sure">{lang sure_resend}</div>
        <p class="cl">
            <button type="submit" name="btnsubmit" value="true">{lang resend}</button>
        </p>
    </form>
</div>
<script type="text/javascript">
	function succeedhandle_$_GET[handlekey](url, msg, values) {
		if(typeof resend_mail == 'function' && parseInt(values['id'])) {
			resend_mail(values['id']);
		}
	}
</script>
<!--{elseif $_GET['op'] == 'delete'}-->
<header class="header">
    <div class="nav">
         <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
        <span class="category">
            <span class="name">
            {lang delete_log}
            </span>
        </span>
    </div>
</header>
<div class="ainuo_yaoqinglink cl">
<form id="deleteform_{$id}" name="deleteform_{$id}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=invite&op=delete&id=$id" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
	<input type="hidden" name="referer" value="{echo dreferer()}" />
	<input type="hidden" name="deletesubmit" value="true" />
	<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<div class="sure">{lang delete_log_message}</div>
	<p class="cl">
		<button type="submit" name="btnsubmit" value="true">{lang delete}</button>
	</p>
</form>
<script type="text/javascript">
	function succeedhandle_$_GET[handlekey](url, msg, values) {
		if(typeof resend_mail == 'function' && parseInt(values['id'])) {
			resend_mail(values['id']);
		}
	}
</script>
<!--{elseif $_GET['op'] == 'showinvite'}-->
	<!--{loop $list $key $url}-->
	<tr>
		<th><a href="$url">$url</a></td>
		<td><a href="javascript:;">$key</a></td>
	</tr>
	<!--{/loop}-->
<!--{else}-->


<!-- header start -->
<header class="header">
    <div class="nav">
        <a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="z"><i class="iconfont icon-back"></i></a>
        <span class="category">
            <span class="name">
            {lang invite_friend}
            </span>
        </span>
    </div>
</header>
<!-- header end -->

<div class="ainuo_myvisit cl">
	<div class="cl">
    <div class="ainuo_usertb cl">
        <ul class="tb ahaoyou cl">
            <li$actives[me]><a href="home.php?mod=space&do=friend">{lang friend_list}</a></li>
            <!--{if $_G['setting']['regstatus'] > 1}-->
                <li$actives[invite]><a href="home.php?mod=spacecp&ac=invite">{lang invite_friend}</a></li>
            <!--{/if}-->
            <li$actives[request]><a href="home.php?mod=spacecp&ac=friend&op=request">{lang friend_request}</a></li>	
            <li$actives[group]><a href="home.php?mod=spacecp&ac=friend&op=group">{lang set_friend_group}</a></li>
        </ul>
    </div>
    <div class="grey_line cl"></div>
		<div class="inviteme cl">
			<caption class="cl">
				<p class="dashedtip cl">{lang friend_invite_message}</p>
			</caption>
			<!--{if $allowinvite}-->
			<form method="post" id="newinvite" autocomplete="off" action="home.php?mod=spacecp&ac=invite&appid=$appid&ref" onsubmit="ajaxpost(this.id, 'return_newinvite');doane(event);">
				<!--{if $config[inviteaddcredit] || $config[invitedaddcredit]}-->
				<div class="cgyg cl">
					{lang friend_invite_success}
					<!--{if $config[invitedaddcredit]}-->{lang you_get} <strong class="xi1">$config[invitedaddcredit]</strong> {lang unit}{$credittitle},<!--{/if}-->
					<!--{if $config[inviteaddcredit]}-->{lang friend_get} <strong class="xi1">$config[inviteaddcredit]</strong> {lang unit}{$credittitle},<!--{/if}-->
					{lang go_nuts}
				</div>
				<!--{/if}-->
				<!--{if $flist}-->
					<div class="cglist cl">
                        <h2>{lang invited_friend}</h2>
                        <!--{if $invitedcount < 24}-->
                        <ul class="cl">
                            <!--{loop $flist $key $value}-->
                            <li>
                                <a href="home.php?mod=space&uid=$value[fuid]">
                                	<!--{avatar($value[fuid],middle)}-->
                                <p>$value[fusername]</p>
                                </a>
                            </li>
                            <!--{/loop}-->
                        </ul>
                        <!--{else}-->
                        <p>
                        <!--{eval $mod='';}-->
                        <!--{loop $flist $key $value}-->
                        $mod<a href="home.php?mod=space&uid=$value[fuid]" title="$value[fusername]">$value[fusername]</a>
                        <!--{eval $mod=', ';}-->
                        <!--{/loop}-->
                        </p>
                        <!--{/if}-->
					</div>
				<!--{/if}-->

				<!--{if $maillist}-->
					<div class="swcg cl">
						<h2>{lang no_invite_friend_email}</h2>
						<ul class="cl">
							<!--{loop $maillist $key $value}-->
							<li id="sendmail_$value[id]_li">
                            	$value[email]
								<em>
									<a ainuoto="home.php?mod=spacecp&ac=invite&op=delete&id=$value[id]&handlekey=deleteinvitehk_{$value[id]}" id="del_invite_$value[id]" title="{lang delete}" class="ainuodialog">{lang delete}</a>
                                    <a ainuoto="home.php?mod=spacecp&ac=invite&op=resend&id=$value[id]&handlekey=resendinvitehk_{$value[id]}" id="mail_invite_$value[id]" title="{lang resend}" class="ainuodialog">{lang resend}</a>
								</em>
								
							</li>
							<!--{/loop}-->
						</ul>
					</div>
				<!--{/if}-->
  
                <div class="yqlist cl">
				<table cellspacing="0" cellpadding="0" width="100%">
					
							<tr>
								<th class="bbdat">{lang invite_link}</td>
								<td class="bbdat">{lang invite_code}</td>
							</tr>
							<tbody id="invitelist">
								<!--{if $list}-->
									<!--{loop $list $key $url}-->
									<tr>
										<th><a href="$url">$url</a></td>
										<td><a href="javascript:;">$key</a> </td>
									</tr>
									<!--{/loop}-->
								<!--{else}-->
									<tr>
                                        <td colspan="2" class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_invitation_code}</p></td>
									</tr>
								<!--{/if}-->
							</tbody>

				</table>
                
                </div>
                <div class="yqbotton cl">
                	<table>
						<tr>
							<td>
								<p class="cl">{lang invitation_code_spend}{$extcredits[title]} <strong class="xi1">$creditnum</strong> $extcredits[unit] ( {lang you_have}$extcredits[title] <strong id="haveallcredit">{$space[$creditkey]}</strong> $extcredits[unit] )<!--{if $space[$creditkey] < $creditnum}--><span><a href="home.php?mod=spacecp&ac=credit" target="_blank" class="xi2">{lang credit_recharge}</a></span><!--{/if}--></p>
								<!--{if $_G['group']['maxinviteday']}-->
								<p class="cl">{lang max_invite_day_message}</p>
								<!--{/if}-->
                                <div class="huoqu cl">
								<input type="text" name="invitenum" value="1" class="px"  />
								<button type="submit" name="invitesubmit_btn" value="true">{lang get_invitation_code}</button>
                                </div>
								<span id="return_newinvite" style="display:none;"></span>
								<script type="text/javascript">
									function succeedhandle_newinvite(url, message, values) {
										if(values['deduction']) {
											var allCreditObj = $('haveallcredit');
											allCreditObj.innerHTML = parseInt(allCreditObj.innerHTML) - parseInt(values['deduction']);
											var x = new Ajax();
											x.get('home.php?mod=spacecp&ac=invite&op=showinvite&inajax=1', function(s){
												ajaxinnerhtml($('invitelist'), s);
					   						});
											showCreditPrompt();
										}
									}
								</script>
							</td>
						</tr>
					<!--{if !$creditnum}-->
						<tr>
							<td>
								<div class="gly cl">{lang copy_invite_manage}: <a href="$inviteurl">$inviteurl</a></div>
							</td>
						</tr>
					<!--{/if}-->
                    </table>
                </div>
				<input type="hidden" name="handlekey" value="newinvite" />
				<input type="hidden" name="invitesubmit" value="true" />
				<input type="hidden" name="formhash" value="{FORMHASH}" />
			</form>
			<!--{if $_G['group']['allowmailinvite']}-->
            <div class="aemail cl">
			<form method="post" autocomplete="off" action="home.php?mod=spacecp&ac=invite&type=mail&appid=$appid&ref">
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<h2 class="xs2">{lang send_invitation_email}<!--{if $appid}-->{lang friend_play_together}$appinfo[appname]<!--{/if}--></h2>
				<div class="mtn bm bmn">
					<script type="text/javascript" src="http://widgets.manyou.com/misc/scripts/ab.js" charset="utf-8"></script>
					<table cellspacing="0" cellpadding="0" width="100%">
						<caption>
							<p style="color:#999; font-size:12px;">{lang send_invitation_email_message}</p>
						</caption>
						<tr>
							<td>
								<p class="d">
									{lang friend_email_address}
								</p>
								<textarea name="email" id="email" rows="3" class="px" style="width:99%;"></textarea>
							</td>
						</tr>
						<tr>
							<td>
								<p class="d">{lang friend_to_say}</p>
								<input type="text" name="saymsg" id="saymsg" onkeyup="showPreview(this.value, 'sayPreview')" class="px" style="width:99%;">
							</td>
						</tr>
						<tr>
							<td><button type="submit" name="emailinvite" value="true">{lang invite}</button></td>
						</tr>
					</table>
				</div>
				
				<div class="yulan cl">
                	<h2>{lang preview_invitation}</h2>
					<table cellspacing="0" cellpadding="0" width="100%" style="table-layout: fixed;">
						<tr>
							<td valign="top" width="52"><div class="avt">{$mailvar[avatar]}</div></td>
							<td valign="top" style="font-size:14px;">
							<!--{if $appid}-->
								<h4>{lang i_play_invite_you}</h4>
							<!--{else}-->
								<h4>{lang hi_iam_invite_you}</h4>
								<p class="mtm">{lang become_friend_message}<p>
							<!--{/if}-->
								<p class="mtm">{lang invite_add_note}:</p>
								<p id="sayPreview"></p>
								<h4 class="mtm">{lang click_link_become_friend}<!--{if $appid}-->{lang play_together}$appinfo[appname]<!--{/if}-->:</h4>
								<p>{$inviteurl}</p>
								<h4 class="mtm">{lang have_account_view_homepage}</h4>
								<p>{$mailvar[siteurl]}home.php?mod=space&uid=$mailvar[uid]</p>
							</td>
						</tr>
					</table>
				</div>
			</form>
            </p>
			<!--{/if}-->

<!--{else}-->
            <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_right_invite_friend}</p></div>
<!--{/if}-->
		</div>
	</div>

</div>

<!--{/if}-->
<!--{template common/footer}-->

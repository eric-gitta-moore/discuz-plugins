<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<!--{template common/header}-->

<!--{eval $loginhash = 'L'.random(4);}-->
<!--{if empty($_GET['infloat'])}-->
<div id="ct" class="ptm wp w cl">
	<div class="nfl" id="main_succeed" style="display: none">
		<div class="f_c altw">
			<div class="alert_right">
				<p id="succeedmessage"></p>
				<p id="succeedlocation" class="alert_btnleft"></p>
				<p class="alert_btnleft"><a id="succeedmessage_href">{lang message_forward}</a></p>
			</div>
		</div>
	</div>
	<div class="mn" id="main_message">
		<div class="bm qin_member_login">
			<div class="bm_h bbs">
				<span class="y">
					<!--{hook/logging_side_top}-->
					<a href="member.php?mod={$_G[setting][regname]}" class="xi2">{lang login_guest}</a>
				</span>
				<!--{if !$secchecklogin2}-->
					<h3 class="xs2">{lang login}</h3>
				<!--{else}-->
					<h3 class="xs2">{lang login_seccheck2}</h3>
				<!--{/if}-->
			</div>
		<div>
<!--{else}-->
	<style type="text/css">
	.fwin .rfm, .nfl .f_c .rfm {
	    width: auto;
	}

	.m_c .c {
	    padding: 0 40px 20px 40px;
	}

	.nfl .f_c {
	    width: 330px;
	}
	
	<!--{if $_G['uid']}--><!--{elseif !$_G[connectguest]}-->
	#fwin_reply {
		border: #D2D2D2 1px solid;
	}
	<!--{/if}-->
	</style>

	<div style="width:100%; height:100%; background:#000; z-index:-1; position:fixed; left:0; top:0;filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;"></div>

	<style type="text/css">
	.t_l, .t_c, .t_r, .m_l, .m_r, .b_l, .b_c, .b_r {
	    opacity: 1;
	    filter: alpha(opacity=100);
	    background: #FFF;
	}
	</style>
<!--{/if}-->

<div id="main_messaqge_$loginhash"{if $auth} style="width: auto"{/if}>
	<div id="layer_login_$loginhash">
		<h3 class="flb">
			<span><!--{if !empty($_GET['infloat']) && !isset($_GET['frommessage'])}--><a href="javascript:;" class="flbc" onclick="hideWindow('$_GET[handlekey]', 0, 1);" title="{lang close}">{lang close}</a><!--{/if}--></span>
		</h3>
		<!--{hook/logging_top}-->
		<form method="post" autocomplete="off" name="login" id="loginform_$loginhash" class="cl" onsubmit="{if $this->setting['pwdsafety']}pwmd5('password3_$loginhash');{/if}pwdclear = 1;ajaxpost('loginform_$loginhash', 'returnmessage_$loginhash', 'returnmessage_$loginhash', 'onerror');return false;" action="member.php?mod=logging&action=login&loginsubmit=yes{if !empty($_GET['handlekey'])}&handlekey=$_GET[handlekey]{/if}{if isset($_GET['frommessage'])}&frommessage{/if}&loginhash=$loginhash">
			<div class="c cl">
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<input type="hidden" name="referer" value="{echo dreferer()}" />
				<!--{if $auth}-->
					<input type="hidden" name="auth" value="$auth" />
				<!--{/if}-->

				<!--{if !$auth}-->
				<div class="rfm">
					<table>
						<tr>
							<td>
								<input type="text" placeholder="用户名/UID/Email" name="username" id="username_$loginhash" autocomplete="off" size="30" class="px" tabindex="1" value="$username" />
							</td>
						</tr>
					</table>
				</div>
				<div class="rfm">
					<table>
						<tr>
							<td>
								<input type="password" placeholder="密码" id="password3_$loginhash" name="password" onfocus="clearpwd()" size="30" class="px" tabindex="1" />
				            </td>
						</tr>
					</table>
				</div>
				<!--{/if}-->

				<!--{if $seccodecheck}-->
					<!--{block sectpl}--><div class="rfm"><table><tr><th style="display: none;"><sec>: </th><td><sec><br /><sec></td></tr></table></div><!--{/block}-->
					<!--{subtemplate common/seccheck}-->
				<!--{/if}-->

				<!--{hook/logging_input}-->

				<!--{if empty($_GET['auth']) || $questionexist}-->
				<div class="rfm" id="q_aqtw" style="display: none;">
					<table>
						<tr>
							<td>
								<select id="loginquestionid_$loginhash" width="213" name="questionid"{if !$questionexist} onchange="if($('loginquestionid_$loginhash').value > 0) {$('loginanswer_row_$loginhash').style.display='';} else {$('loginanswer_row_$loginhash').style.display='none';}"<!--{/if}-->>
									<option value="0"><!--{if $questionexist}-->{lang security_question_0}<!--{else}-->未设置忽略<!--{/if}--></option>
									<option value="1">{lang security_question_1}</option>
									<option value="2">{lang security_question_2}</option>
									<option value="3">{lang security_question_3}</option>
									<option value="4">{lang security_question_4}</option>
									<option value="5">{lang security_question_5}</option>
									<option value="6">{lang security_question_6}</option>
									<option value="7">{lang security_question_7}</option>
								</select>
							</td>
						</tr>
					</table>
				</div>
				<div class="rfm" id="loginanswer_row_$loginhash" {if !$questionexist} style="display:none"{/if}>
					<table>
						<tr>
							<td>
								<input type="text" name="answer" placeholder="答案" id="loginanswer_$loginhash" autocomplete="off" size="30" class="px" tabindex="1" />
							</td>
						</tr>
					</table>
				</div>
				<!--{/if}-->
				<script type="text/javascript">
				    jQuery("#q_aqtw_btn").click(function() {
				        jQuery("#q_aqtw").slideToggle();
				    });
				</script>
				<div class="rfm">
				    <table>
				        <tbody>
				            <tr>
				                <td>
				                    <label for="cookietime_$loginhash"><input type="checkbox" class="login_pcs" name="cookietime" id="cookietime_$loginhash" tabindex="1" value="2592000" $cookietimecheck />{lang login_permanent}</label>
				                    <a href="javascript:;" id="q_aqtw_btn" style="margin-left:186px;">安全提问</a>
				                </td>
				            </tr>
				        </tbody>
				    </table>
				</div>
				<div class="<!--{if empty($_GET['infloat'])}-->rfm <!--{/if}-->rfmrig rfmrig_login">
					<table>
						<tr>
							<td>
				    			<button class="btn" type="submit" name="loginsubmit" value="true" tabindex="1">{lang login}</button>
				    			<!--{if empty($_GET['infloat'])}--><!--{else}-->
				    			<a href="" style="margin-left: 100px;"><img src="$_G['style']['styleimgdir']/img/login_qq.png" align="absmiddle"></a>
				    			<a href="" style="margin-left: 10px;"><img src="$_G['style']['styleimgdir']/img/login_sina.png" align="absmiddle"></a>
				    			<!--{/if}-->
				    		</td>
						</tr>
					</table>
				</div>
				<div class="rfm">
				    <table>
				        <tbody>
				            <tr>
				                <td>
				                	<a href="javascript:;" onclick="display('layer_login_$loginhash');display('layer_lostpw_$loginhash');" title="{lang getpassword}">{lang getpassword}</a>
				                	<a href="member.php?mod={$_G[setting][regname]}" style="margin-left:15px;">$_G['setting']['reglinkname']</a>
				                </td>
				            </tr>
				        </tbody>
				    </table>
				</div>
			</div>
		</form>
	</div>
	<!--{if $_G['setting']['pwdsafety']}-->
		<script type="text/javascript" src="{$_G['setting']['jspath']}md5.js?{VERHASH}" reload="1"></script>
	<!--{/if}-->
	<div id="layer_lostpw_$loginhash" style="display: none;">
		<h3 class="flb">
			<em id="returnmessage3_$loginhash">{lang getpassword}</em>
			<span><!--{if !empty($_GET['infloat']) && !isset($_GET['frommessage'])}--><a href="javascript:;" class="flbc" onclick="hideWindow('login')" title="{lang close}">{lang close}</a><!--{/if}--></span>
		</h3>
		<form method="post" autocomplete="off" id="lostpwform_$loginhash" class="cl" onsubmit="ajaxpost('lostpwform_$loginhash', 'returnmessage3_$loginhash', 'returnmessage3_$loginhash', 'onerror');return false;" action="member.php?mod=lostpasswd&lostpwsubmit=yes&infloat=yes">
			<div class="c cl">
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<input type="hidden" name="handlekey" value="lostpwform" />
				<div class="rfm">
					<table>
						<tr>
							<td>
								<input type="text" name="email" placeholder="Email" id="lostpw_email" size="30" value=""  tabindex="1" class="px" />
							</td>
						</tr>
					</table>
				</div>
				<div class="rfm">
					<table>
						<tr>
							<td>
								<input type="text" name="username" placeholder="用户名" id="lostpw_username" size="30" value=""  tabindex="1" class="px" />
							</td>
						</tr>
					</table>
				</div>

				<div class="<!--{if empty($_GET['infloat'])}-->rfm <!--{/if}-->rfmrig rfmrig_login">
					<table>
						<tr>
							<td>
								<button class="btn" type="submit" name="lostpwsubmit" value="true" tabindex="100"><span>{lang submit}</span></button>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>

<div id="layer_message_$loginhash"{if empty($_GET['infloat'])} class="f_c blr nfl"{/if} style="display: none;">
	<h3 class="flb" id="layer_header_$loginhash">
		<!--{if !empty($_GET['infloat']) && !isset($_GET['frommessage'])}-->
		<em>{lang login_member}</em>
		<span><a href="javascript:;" class="flbc" onclick="hideWindow('login')" title="{lang close}">{lang close}</a></span>
		<!--{/if}-->
	</h3>
	<div class="c"><div class="alert_right">
		<div id="messageleft_$loginhash"></div>
		<p class="alert_btnleft" id="messageright_$loginhash"></p>
	</div>
</div>

<script type="text/javascript" reload="1">
<!--{if !isset($_GET['viewlostpw'])}-->
	var pwdclear = 0;
	function initinput_login() {
		document.body.focus();
		<!--{if !$auth}-->
			if($('loginform_$loginhash')) {
				$('loginform_$loginhash').username.focus();
			}
			<!--{if !$this->setting['autoidselect']}-->
				simulateSelect('loginfield_$loginhash');
			<!--{/if}-->
		<!--{elseif $seccodecheck && !(empty($_GET['auth']) || $questionexist)}-->
			if($('loginform_$loginhash')) {
				safescript('seccodefocus', function() {$('loginform_$loginhash').seccodeverify.focus()}, 500, 10);
			}			
		<!--{/if}-->
	}
	initinput_login();
	<!--{if $this->setting['sitemessage']['login']}-->
	showPrompt('custominfo_login_$loginhash', 'mouseover', '<!--{echo trim($this->setting['sitemessage'][login][array_rand($this->setting['sitemessage'][login])])}-->', $this->setting['sitemessage'][time]);
	<!--{/if}-->

	function clearpwd() {
		if(pwdclear) {
			$('password3_$loginhash').value = '';
		}
		pwdclear = 0;
	}
<!--{else}-->
	display('layer_login_$loginhash');
	display('layer_lostpw_$loginhash');
	$('lostpw_email').focus();
<!--{/if}-->
</script>

<!--{eval updatesession();}-->
<!--{if empty($_GET['infloat'])}-->
	</div></div></div></div>
</div>
<!--{/if}-->
<!--{template common/footer}-->

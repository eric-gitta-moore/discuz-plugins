<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<!-- header start -->
<header class="header">
    <div class="nav">
        <a href="#" class="z back"><i class="iconfont icon-back"></i></a>
        <span class="name">{lang memcp_profile}</span>
    </div>
</header>
<!-- header end -->

	<!--{if $validate}-->

	<!--{else}-->
		<!--{if $operation == 'password'}-->
			<script type="text/javascript" src="{$_G[setting][jspath]}register.js?{VERHASH}"></script>

			<form action="home.php?mod=spacecp&ac=profile" method="post" autocomplete="off">
				<input type="hidden" value="{FORMHASH}" name="formhash" />
				<table summary="{lang memcp_profile}" cellspacing="0" cellpadding="0" class="ainuo_usertfm">
					<!--{if !$_G['setting']['connect']['allow'] || !$conisregister}-->
						<tr>
							<th><span class="rq" title="{lang required}">*</span>{lang old_password}</th>
							<td><input type="password" name="oldpassword" id="oldpassword" class="px" /></td>
						</tr>
					<!--{/if}-->
					<tr>
						<th>{lang new_password}</th>
						<td>
							<input type="password" name="newpassword" id="newpassword" class="px" />
							<p class="d" id="chk_newpassword">{lang memcp_profile_passwd_comment}</p>
						</td>
					</tr>
					<tr>
						<th>{lang new_password_confirm}</th>
						<td>
							<input type="password" name="newpassword2" id="newpassword2"class="px" />
							<p class="d" id="chk_newpassword2">{lang memcp_profile_passwd_comment}</p>
						</td>
					</tr>
					<tr id="contact"{if $_GET[from] == 'contact'} style="background-color: {$_G['style']['specialbg']};"{/if}>
						<th>{lang email}</th>
						<td>
							<input type="text" name="emailnew" id="emailnew" value="$space[email]" class="px" />
							<p class="d">
								<!--{if empty($space['newemail'])}-->
									{lang email_been_active}
								<!--{else}-->
									$acitvemessage
								<!--{/if}-->
							</p>
							<!--{if $_G['setting']['regverify'] == 1 && (($_G['group']['grouptype'] == 'member' && $_G['adminid'] == 0) || $_G['groupid'] == 8) || $_G['member']['freeze']}--><p class="d">{lang memcp_profile_email_comment}</p><!--{/if}-->
						</td>
					</tr>

					<!--{if $_G['member']['freeze'] == 2}-->
					<tr>
						<th>{lang freeze_reason}</th>
						<td>
							<textarea rows="3" name="freezereson" class="pt">$space[freezereson]</textarea>
							<p class="d" id="chk_newpassword2">{lang freeze_reason_comment}</p>
						</td>
					</tr>
					<!--{/if}-->

					<tr>
						<th>{lang security_question}</th>
						<td>
							<select name="questionidnew" id="questionidnew">
								<option value="" selected>{lang memcp_profile_security_keep}</option>
								<option value="0">{lang security_question_0}</option>
								<option value="1">{lang security_question_1}</option>
								<option value="2">{lang security_question_2}</option>
								<option value="3">{lang security_question_3}</option>
								<option value="4">{lang security_question_4}</option>
								<option value="5">{lang security_question_5}</option>
								<option value="6">{lang security_question_6}</option>
								<option value="7">{lang security_question_7}</option>
							</select>
							<p class="d">{lang memcp_profile_security_comment}</p>
						</td>
					</tr>

					<tr>
						<th>{lang security_answer}</th>
						<td>
							<input type="text" name="answernew" id="answernew" class="px" />
							<p class="d">{lang memcp_profile_security_answer_comment}</p>
						</td>
					</tr>
					<!--{if $secqaacheck || $seccodecheck}-->
					</table>
						<!--{eval $sectpl = '<table cellspacing="0" cellpadding="0" class="tfm"><tr><th><sec></th><td><sec><p class="d"><sec></p></td></tr></table>';}-->
						<!--{subtemplate common/seccheck}-->
					<table summary="{lang memcp_profile}" cellspacing="0" cellpadding="0" class="ainuo_usertfm">
					<!--{/if}-->
					<tr>
						<td colspan="2" class="savebtn"><button type="submit" name="pwdsubmit" value="true" class="formdialog">{lang save}</button></td>
					</tr>
				</table>
				<input type="hidden" name="passwordsubmit" value="true" />
			</form>

		<!--{else}-->
			<!--{hook/spacecp_profile_top}-->
			<!--{subtemplate home/spacecp_profile_nav}-->
				<!--{if $vid}-->
				<div class="dashedtip cl" style="background: #fffdef;border:1px dashed #e7e1cd; padding:5px; font-size:12px; color:#888; margin:10px;"><!--{if $showbtn}-->{lang spacecp_profile_message1}<!--{else}-->{lang spacecp_profile_message2}<!--{/if}--></div>
				<!--{/if}-->
			<iframe id="frame_profile" name="frame_profile" style="display: none"></iframe>
			<form action="{if $operation != 'plugin'}home.php?mod=spacecp&ac=profile&op=$operation{else}home.php?mod=spacecp&ac=plugin&op=profile&id=$_GET[id]{/if}" method="post" enctype="multipart/form-data" autocomplete="off"{if $operation != 'plugin'} target="frame_profile"{/if} onsubmit="clearErrorInfo();">
				<input type="hidden" value="{FORMHASH}" name="formhash" />
				<!--{if $_GET[vid]}-->
				<input type="hidden" value="$_GET[vid]" name="vid" />
				<!--{/if}-->
				<table cellspacing="0" cellpadding="0" class="ainuo_usertfm" id="profilelist">
					<tr>
						<th>{lang username}</th>
						<td>$_G[member][username]</td>
					</tr>
				<!--{loop $settings $key $value}-->
				<!--{if $value[available]}-->
					<tr id="tr_$key">
						<th id="th_$key"><!--{if $value[required]}--><span class="rq" title="{lang required}">*</span><!--{/if}-->$value[title]</th>
						<td id="td_$key">
							$htmls[$key]
						</td>
						
					</tr>
				<!--{/if}-->
				<!--{/loop}-->
				<!--{if $allowcstatus && in_array('customstatus', $allowitems)}-->
				<tr>
					<th id="th_customstatus">{lang permission_basic_status}</th>
					<td id="td_customstatus">
						<input type="text" value="$space[customstatus]" name="customstatus" id="customstatus" class="px" />
						<div class="rq mtn" id="showerror_customstatus"></div>
					</td>
				</tr>
				<!--{/if}-->
				<!--{if $_G['group']['maxsigsize'] && in_array('sightml', $allowitems)}-->
				<tr>
					<th id="th_sightml">{lang personal_signature}</th>
					<td id="td_sightml">
						<div class="tedt">
							<div class="area">
								<textarea rows="3" name="sightml" id="sightmlmessage" class="px">$space[sightml]</textarea>
							</div>
						</div>
						<div id="signhtmlpreview"></div>
						<div id="showerror_sightml" class="rq mtn"></div>
						<script type="text/javascript" src="{$_G[setting][jspath]}bbcode.js?{VERHASH}"></script>
						<script type="text/javascript">var forumallowhtml = 0,allowhtml = 0,allowsmilies = 0,allowbbcode = parseInt('{$_G[group][allowsigbbcode]}'),allowimgcode = parseInt('{$_G[group][allowsigimgcode]}');var DISCUZCODE = [];DISCUZCODE['num'] = '-1';DISCUZCODE['html'] = [];</script>
					</td>
				</tr>
				<!--{/if}-->
				<!--{if in_array('timeoffset', $allowitems)}-->
				
				<!--{/if}-->

				<!--{if $operation == 'contact'}-->
				<tr>
					<th id="th_sightml">Email</th>
					<td id="td_sightml">$space[email]&nbsp;(<a href="home.php?mod=spacecp&ac=profile&op=password&from=contact#contact">{lang modify}</a>)</td>
				</tr>
				<!--{/if}-->

				<!--{if $operation == 'plugin'}-->
					<!--{eval include(template($_GET['id']));}-->
				<!--{/if}-->
				<!--{hook/spacecp_profile_extra}-->
				<!--{if $showbtn}-->
				<tr>
					<td colspan="2" class="savebtn">
						<input type="hidden" name="profilesubmit" value="true" />
						<button type="submit" name="profilesubmitbtn" id="profilesubmitbtn" value="true">{lang save}</button>
                        
						<span id="submit_result" class="rq"></span>
					</td>
				</tr>
				<!--{/if}-->
				</table>
				<!--{hook/spacecp_profile_bottom}-->
			</form>
			<script type="text/javascript">
				function show_error(fieldid, extrainfo) {
					var elem = document.getElementById('th_'+fieldid);
					if(elem) {
						elem.className = "rq";
						fieldname = elem.innerHTML;
						extrainfo = (typeof extrainfo == "string") ? extrainfo : "";
						document.getElementById('showerror_'+fieldid).innerHTML = "{lang check_date_item} " + extrainfo;
						document.getElementById(fieldid).focus();
					}
				}

				function show_success(message) {
					message = message == '' ? '{lang update_date_success}' : message;
					popup.open(message, 'wxtip');
					setTimeout(function(){
					window.location.reload();
					},500);
				}
				function clearErrorInfo() {
					var spanObj = document.getElementById('profilelist').getElementsByTagName("div");
					for(var i in spanObj) {
						if(typeof spanObj[i].id != "undefined" && spanObj[i].id.indexOf("_")) {
							var ids = explode('_', spanObj[i].id);
							if(ids[0] == "showerror") {
								spanObj[i].innerHTML = '';
								document.getElementById('th_'+ids[1]).className = '';
							}
						}
					}
				}
			</script>
		<!--{/if}-->
		</div>
	</div>
	<!--{/if}-->
</div>

<script>
function showbirthday(){
	var el = document.getElementById('birthday');
	var birthday = el.value;
	el.length=0;
	el.options.add(new Option('{lang day}', ''));
	for(var i=0;i<28;i++){
		el.options.add(new Option(i+1, i+1));
	}
	if($('birthmonth').value!="2"){
		el.options.add(new Option(29, 29));
		el.options.add(new Option(30, 30));
		switch(document.getElementById('birthmonth').value){
			case "1":
			case "3":
			case "5":
			case "7":
			case "8":
			case "10":
			case "12":{
				el.options.add(new Option(31, 31));
			}
		}
	} else if($('birthyear').value!="") {
		var nbirthyear=document.getElementById('birthyear').value;
		if(nbirthyear%400==0 || (nbirthyear%4==0 && nbirthyear%100!=0)) el.options.add(new Option(29, 29));
	}
	el.value = birthday;
}
function showdistrict(container, elems, totallevel, changelevel, containertype) {
    var getdid = function(elem) {
        var op = elem.options[elem.selectedIndex];
        return op['did'] || op.getAttribute('did') || '0';
    };
    var pid = changelevel >= 1 && elems[0] && $(elems[0]) ? getdid(document.getElementById(elems[0])) : 0;
    var cid = changelevel >= 2 && elems[1] && $(elems[1]) ? getdid(document.getElementById(elems[1])) : 0;
    var did = changelevel >= 3 && elems[2] && $(elems[2]) ? getdid(document.getElementById(elems[2])) : 0;
    var coid = changelevel >= 4 && elems[3] && $(elems[3]) ? getdid(document.getElementById(elems[3])) : 0;
    var url = 'home.php?mod=misc&ac=ajax&op=district&container=' + container + '&containertype=' + containertype + '&province=' + elems[0] + '&city=' + elems[1] + '&district=' + elems[2] + '&community=' + elems[3] + '&pid=' + pid + '&cid=' + cid + '&did=' + did + '&coid=' + coid + '&level=' + totallevel + '&handlekey=' + container + '&inajax=1' + (!changelevel ? '&showdefault=1': '');
    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'xml'
    }).success(function(s) {
        var rehtml = s.lastChild.firstChild.nodeValue;
        rehtml = rehtml.replace('<select name="' + elems[0] + '"', '<div class="cl"><span class="z" style="font-size:12px;margin-right:5px;margin-top:4px;display:none;"><span class="' + elems[0] + '_text"></span></span><select name="' + elems[0] + '"');
        rehtml = rehtml.replace('<select name="' + elems[1] + '"', '<div class="cl"><span class="z" style="font-size:12px;margin-right:5px;margin-top:4px;display:none;"><span class="' + elems[1] + '_text"></span></span><select name="' + elems[1] + '"');
        rehtml = rehtml.replace('<select name="' + elems[2] + '"', '<div class="cl"><span class="z" style="font-size:12px;margin-right:5px;margin-top:4px;display:none;"><span class="' + elems[2] + '_text"></span></span></span><select name="' + elems[2] + '"');
        rehtml = rehtml.replace('<select name="' + elems[3] + '"', '<div class="cl"><span class="z" style="font-size:12px;margin-right:5px;margin-top:4px;display:none;"><span class="' + elems[3] + '_text"></span></span><select name="' + elems[3] + '"');
        rehtml = rehtml.replace(/&nbsp;/g, '');
        /* &nbsp; */
        rehtml = rehtml.replace(/<\/select>/g, '</select></div>');
        $('#' + container).html(rehtml);
        $('.' + elems[0] + '_text').text($('#' + elems[0]).find('option:selected').text());
        $('.' + elems[1] + '_text').text($('#' + elems[1]).find('option:selected').text());
        $('.' + elems[2] + '_text').text($('#' + elems[2]).find('option:selected').text());
        $('.' + elems[3] + '_text').text($('#' + elems[3]).find('option:selected').text());
    });
}
</script>

<!--{template common/footer}-->

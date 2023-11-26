<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<div class="ainuo_login_reg cl">
<div class="ainuologinbg"></div>
<!-- header start -->
<div class="login-header">
	<div class="nav">
    	<a href="#" class="z back"><i class="iconfont icon-back"></i></a>
        <span class="name">$alang_register</span>
	</div>
</div>

<!-- registerbox start -->
<div class="loginbox registerbox">
	<div class="login_from">
		<form method="post" autocomplete="off" name="register" id="registerform" action="member.php?mod={$_G[setting][regname]}&mobile=2">
		<input type="hidden" name="regsubmit" value="yes" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="referer" value="$dreferer" />
		<input type="hidden" name="activationauth" value="{if $_GET[action] == 'activation'}$activationauth{/if}" />
        <!--{if $_G['setting']['sendregisterurl']}-->
				<input type="hidden" name="hash" value="$_GET[hash]" />
			<!--{/if}--><!--From www.moq u8 .com -->
		<input type="hidden" name="agreebbrule" value="$bbrulehash" id="agreebbrule" checked="checked" />
		<ul>
			<li><input type="text" tabindex="1" autocomplete="off" value="" name="{$_G['setting']['reginput']['username']}" placeholder="{lang registerinputtip}" fwin="login"></li>
			<li><input type="password" tabindex="2" value="" name="{$_G['setting']['reginput']['password']}" placeholder="{lang login_password}" fwin="login"></li>
			<li><input type="password" tabindex="3" value="" name="{$_G['setting']['reginput']['password2']}" placeholder="{lang registerpassword2}" fwin="login"></li>
			<li><input type="email" tabindex="4" autocomplete="off" value="" name="{$_G['setting']['reginput']['email']}" placeholder="{lang registeremail}" fwin="login"></li>
			<!--{if empty($invite) && ($_G['setting']['regstatus'] == 2 || $_G['setting']['regstatus'] == 3)}-->
				<li><input type="text" name="invitecode" autocomplete="off" tabindex="5" placeholder="{lang invite_code}" fwin="login"></li>
			<!--{/if}-->
			<!--{if $_G['setting']['regverify'] == 2}-->
				<li><input type="text" name="regmessage" autocomplete="off" tabindex="6" value="{lang register_message}" placeholder="{lang register_message}" fwin="login"></li>
			<!--{/if}-->
		</ul>
        <!--{hook/register_input}-->
		<!--{if $secqaacheck || $seccodecheck}-->
			<!--{subtemplate common/seccheck}-->
		<!--{/if}-->
	
	<div class="ainuo_login">
        <button tabindex="7" value="true" name="regsubmit" class="btn_login ainuoreg" type="submit">$alang_fastregister</button>
		<div class="reg_link cl"><a href="member.php?mod=logging&action=login">$alang_log</a></div>
    </div>
    </div>
	</form>
</div>
{if $configData[login_qq] || $configData[login_weixin]}
<div class="ainuo_other_method cl">
    <div class="login_title cl">
        <div class="ub_fl"></div>
        <div class="atext">$alang_otherlogin</div>
        <div class="ub_fr"></div>
    </div>
    <div class="login_con cl">
    <!--{if $configData[login_qq]}--><a href="$configData[login_qq]" class="qqlogin"><i class="iconfont icon-qq"></i></a><!--{/if}-->
    <!--{if $configData[login_weixin]}--><a href="$configData[login_weixin]" class="weixinlogin"><i class="iconfont icon-weixin"></i></a><!--{/if}-->
    
    </div>
</div>
{/if}
<!-- registerbox end -->
</form>

<script>
$(document).on('click', '.ainuoreg', function() {
		Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
			var obj = $(this);
			var formobj = $(this.form);
			$.ajax({
				type:'POST',
				url:formobj.attr('action') + '&handlekey='+ formobj.attr('id') +'&inajax=1',
				data:formobj.serialize(),
				dataType:'xml'
			})
			.success(function(s) {
				if(s.lastChild.firstChild.nodeValue.indexOf("\u8bf7\u8f93\u5165\u4e00\u4e2a\u8f83\u957f\u7684\u7528\u6237\u540d") >= 0){
					Zepto('.ainuooverlay').remove();
					Zepto.toast('\u7528\u6237\u540d\u592a\u77ed\u4e86',1500,'toast');
					evalscript(s.lastChild.firstChild.nodeValue);
				}else if(s.lastChild.firstChild.nodeValue.indexOf("\u5bc6\u7801\u592a\u77ed\u4e86") >= 0){
					Zepto('.ainuooverlay').remove();
					Zepto.toast('\u5bc6\u7801\u592a\u77ed\u4e86',1500,'toast');
				}else if(s.lastChild.firstChild.nodeValue.indexOf("\u4e24\u6b21\u8f93\u5165\u7684\u5bc6\u7801\u4e0d\u4e00\u81f4") >= 0){
					Zepto('.ainuooverlay').remove();
					Zepto.toast('\u4e24\u6b21\u8f93\u5165\u7684\u5bc6\u7801\u4e0d\u4e00\u81f4',1500,'toast');
				}else if(s.lastChild.firstChild.nodeValue.indexOf("\u0045\u006d\u0061\u0069\u006c\u0020\u5730\u5740\u65e0\u6548") >= 0){
					Zepto('.ainuooverlay').remove();
					Zepto.toast('\u0045\u006d\u0061\u0069\u006c\u0020\u5730\u5740\u65e0\u6548',1500,'toast');
				}else if(s.lastChild.firstChild.nodeValue.indexOf("\u8be5\u7528\u6237\u540d\u5df2\u88ab\u6ce8\u518c") >= 0){
					Zepto('.ainuooverlay').remove();
					Zepto.toast('\u8be5\u7528\u6237\u540d\u5df2\u88ab\u6ce8\u518c',1500,'toast');
				}else if(s.lastChild.firstChild.nodeValue.indexOf("\u611f\u8c22\u60a8\u6ce8\u518c") >= 0){
					Zepto('.ainuooverlay').remove();
					Zepto.toast('\u611f\u8c22\u60a8\u6ce8\u518c\uff0c\u73b0\u5728\u5c06\u767b\u5f55\u7ad9\u70b9',3000,'toast');
					evalscript(s.lastChild.firstChild.nodeValue);
				}else{
					Zepto('.ainuooverlay').remove();
					popup.open(s.lastChild.firstChild.nodeValue);
					evalscript(s.lastChild.firstChild.nodeValue);
				}
			})
			.error(function() {
				window.location.href = obj.attr('href');
				Zepto('.ainuooverlay').remove();
			});
			return false;
		});
</script>

<!--{template common/footer}-->

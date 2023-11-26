<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

{eval $loginhash = 'L'.random(4);}

<div class="ainuo_login_reg cl">
<div class="ainuologinbg"></div>
<!-- header start -->
<div class="login-header">
	<div class="nav">
    	<a href="#" class="z back"><i class="iconfont icon-back"></i></a>
        <span class="name">$alang_login</span>
	</div>
</div>


<!-- userinfo start -->
<div class="loginbox <!--{if $_GET[infloat]}-->login_pop<!--{/if}-->">
	<!--{if $_GET[infloat]}-->
		<h2 class="log_tit"><a href="javascript:;" onclick="hideWindow('login');window.location.reload();"><span class="icon_close y">X</span></a>{lang login}</h2>
	<!--{/if}-->
		<form id="loginform" method="post" action="member.php?mod=logging&action=login&loginsubmit=yes&loginhash=$loginhash&mobile=2" onsubmit="{if $_G['setting']['pwdsafety']}pwmd5('password3_$loginhash');{/if}" >
		<input type="hidden" name="formhash" id="formhash" value='{FORMHASH}' />
		<input type="hidden" name="referer" id="referer" value="<!--{if dreferer()}-->{echo dreferer()}<!--{else}-->forum.php?mobile=2<!--{/if}-->" />
		<input type="hidden" name="fastloginfield" value="username">
		<input type="hidden" name="cookietime" value="2592000">
		<!--{if $auth}--><!--From www.m oq u8 .com -->
			<input type="hidden" name="auth" value="$auth" />
		<!--{/if}-->
	<div class="login_from">
		<ul>
			<li><input type="text" value="" tabindex="1" size="30" autocomplete="off" value="" name="username" placeholder="{lang inputyourname}" fwin="login"></li>
			<li><input type="password" tabindex="2" size="30" value="" name="password" placeholder="{lang login_password}" fwin="login"></li>
			<li class="questionli">
				<div class="login_select">
				<span class="login-btn-inner">
					<span class="login-btn-text">
						<span class="span_question">{lang security_question}</span>
					</span>
					<span class="icon-arrow">&nbsp;</span>
				</span>
				<select id="questionid_{$loginhash}" name="questionid" class="sel_list">
					<option value="0" selected="selected">{lang security_question}</option>
					<option value="1">{lang security_question_1}</option>
					<option value="2">{lang security_question_2}</option>
					<option value="3">{lang security_question_3}</option>
					<option value="4">{lang security_question_4}</option>
					<option value="5">{lang security_question_5}</option>
					<option value="6">{lang security_question_6}</option>
					<option value="7">{lang security_question_7}</option>
				</select>
				</div>
			</li>
			<li class="bl_none answerli" style="display:none;"><input type="text" name="answer" id="answer_{$loginhash}" placeholder="{lang security_a}"></li>
		</ul>
		<!--{if $seccodecheck}-->
		<!--{subtemplate common/seccheck}-->
		<!--{/if}-->
	</div>
	<div class="ainuo_login cl">
    	<button tabindex="3" value="true" class="btn_login ainuologin">$alang_fastlogin</button>
        <!--{if $_G['setting']['regstatus']}-->
        	<div class="reg_link cl"><a href="member.php?mod={$_G[setting][regname]}">$alang_fastregister1</a></div>
        <!--{/if}-->
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

	<div class="login_hook" style="display:none"><!--{hook/logging_bottom_mobile}--></div>



<!--{if $_G['setting']['pwdsafety']}-->
	<script type="text/javascript" src="{$_G['setting']['jspath']}md5.js?{VERHASH}" reload="1"></script>
<!--{/if}-->
<!--{eval updatesession();}-->

<script type="text/javascript">
	(function() {
		$(document).on('change', '.sel_list', function() {
			var obj = $(this);
			$('.span_question').text(obj.find('option:selected').text());
			if(obj.val() == 0) {
				$('.answerli').css('display', 'none');
				$('.questionli').addClass('bl_none');
			} else {
				$('.answerli').css('display', 'block');
				$('.questionli').removeClass('bl_none');
			}
		});
	 })();
</script>
<script>
$(document).on('click', '.ainuologin', function() {
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
				if(s.lastChild.firstChild.nodeValue.indexOf("$alang_back1") >= 0){
					Zepto('.ainuooverlay').remove();
					Zepto.toast('$alang_back2',1500,'toast');
					evalscript(s.lastChild.firstChild.nodeValue);
				}else if(s.lastChild.firstChild.nodeValue.indexOf("$alang_logfaile") >= 0){
					Zepto('.ainuooverlay').remove();
					Zepto.toast('$alang_logfaile2',1500,'toast');
				}else if(s.lastChild.firstChild.nodeValue.indexOf("$alang_emptymima") >= 0){
					Zepto('.ainuooverlay').remove();
					Zepto.toast('$alang_emptymima2',1500,'toast');
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
</div>

<!--{template common/footer}-->

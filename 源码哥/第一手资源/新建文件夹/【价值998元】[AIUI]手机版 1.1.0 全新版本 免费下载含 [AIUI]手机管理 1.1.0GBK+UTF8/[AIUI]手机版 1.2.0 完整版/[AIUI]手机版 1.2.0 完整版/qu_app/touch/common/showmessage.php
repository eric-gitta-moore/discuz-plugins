<?PHP exit('QQÈº£º550494646');?>
<!--{if $param['login']}-->
	<!--{if $_G['inajax']}-->
	<!--{eval dheader('Location:member.php?mod=logging&action=login&inajax=1&infloat=1');exit;}-->
	<!--{else}-->
	<!--{eval dheader('Location:member.php?mod=logging&action=login');exit;}-->
	<!--{/if}-->
<!--{/if}-->
<!--{template common/header}-->

<!--{if $_G['inajax']}-->
<div class="tip">
	<dt id="messagetext">
		<p>$show_message</p>
        <!--{if $_G['forcemobilemessage']}-->
        	<p>
            	<a href="{$_G['setting']['mobile']['pageurl']}" class="mtn">{lang continue}</a><br />
                <a href="#" class="z back">{lang goback}</a>
            </p>
        <!--{/if}--><!--Fr om w ww.mo q u8 .com -->
        <!--{if $url_forward && !$_GET['loc']}-->
			<script type="text/javascript">
			    var text = '$url_forward';
				setTimeout(function() {
					if(text.indexOf("ac=block") > 0 ){
						popup.close();
					}else{
						<!--{if $values['html']}-->
						popup.close();
						<!--{else}-->
						window.location.href = '$url_forward';
						<!--{/if}-->
					}
				}, '1500');
			</script>
		<!--{elseif $allowreturn}-->
			
		<!--{/if}-->
	</dt>
</div>
<!--{else}-->

<!-- header start -->
<div class="header">
    <!--{if $_G['setting']['domain']['app']['mobile']}-->
        {eval $nav = 'http://'.$_G['setting']['domain']['app']['mobile'];}
    <!--{else}-->
        {eval $nav = "forum.php";}
    <!--{/if}-->
    <div class="nav">
        <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
        <span class="name">$alang_tip</span>
    </div>
</div>
<!-- header end -->
<!--{template common/top_fix}-->

<!-- main jump start -->
<div class="jump_c">
	<p class="ashow cl">$show_message</p>
    <!--{if $_G['forcemobilemessage']}-->
		<p><a href="{$_G['setting']['mobile']['pageurl']}">{lang continue}</a>&nbsp;&nbsp;<a href="javascript:history.back();">{lang goback}</a></p>
    <!--{/if}-->
	<!--{if $url_forward}-->
		<p><a href="$url_forward">{lang message_forward_mobile}</a></p>
	<!--{elseif $allowreturn}-->
		<p><a href="#" class="z back">{lang message_go_back}</a></p>
	<!--{/if}-->
</div>
<!-- main jump end -->

<!--{/if}-->
<!--{template common/footer}-->

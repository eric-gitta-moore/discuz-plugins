<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->


<header class="header">
    <div class="nav">
    	<a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
        <span class="category"><span class="name">{lang password_authentication}</span></span>
    </div>
</header>
<div class="ainuo_inputpw cl">
	<div class="cl">
		<div class="cl">
			<form method="post" autocomplete="off"  id="invalueform" name="invalueform" action="home.php?mod=misc&ac=inputpwd" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
				<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				<input type="hidden" name="refer" value="$_SERVER[REQUEST_URI]" />
				<input type="hidden" name="blogid" value="$invalue[blogid]" />
				<input type="hidden" name="albumid" value="$invalue[albumid]" />
				<input type="hidden" name="pwdsubmit" value="true" />
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<div class="acon cl">
					<input type="password" name="viewpwd" value="" placeholder="{lang enter_password}" class="px" />
				</div>
				<p class="sbun cl">
					<button type="submit" name="submit" value="true">{lang submit}</button>
				</p>
			</form>
			<!--{if $_G[inajax]}-->
			<script type="text/javascript">
				function succeedhandle_$_GET[handlekey](url, msg, values) {
					if(values['succeed'] == 1) {
						window.location.href = url;
					}
				}
			</script>
			<!--{/if}-->

		</div>
	</div>
</div>


<!--{template common/footer}-->
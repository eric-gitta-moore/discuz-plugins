<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<style>
.ainuo_pop{ width:260px;}
</style>
<!--{if $_GET['op'] == 'requote'}-->
<!-- header start -->
<header class="header">
    <div class="nav">
        <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="fa fa-angle-left"></i></a>
        <span class="category"><span class="name">{lang requote}</span>
        </span>
    </div>
</header>
<!-- header end -->
	[quote]{$comment[username]}: {$comment[message]}[/quote]

<!--{elseif $_GET['op'] == 'edit'}-->
<div class="ainuo_pop cl">
	<div class="atit cl">{lang edit}</div>
	<form id="editcommentform_{$cid}" name="editcommentform_{$cid}" method="post" autocomplete="off" action="portal.php?mod=portalcp&ac=comment&op=edit&cid=$cid{if $_GET[modarticlecommentkey]}&modarticlecommentkey=$_GET[modarticlecommentkey]{/if}">
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="editsubmit" value="true" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<div class="acon cl">
			<textarea id="message_{$cid}" name="message" onkeydown="ctrlEnter(event, 'editsubmit_btn');" rows="4" class="px">$comment[message]</textarea>
		</div>
        <div class="ainuo_popbottom cl">
            <button type="submit" name="editsubmit_btn" id="editsubmit_btn" value="true" class="formdialog aconfirm">{lang submit}</button>
            <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
        </div>
	</form>
</div>
<!--{elseif $_GET['op'] == 'delete'}-->
<div class="ainuo_pop cl">
	<div class="atit cl">{lang comment_delete}</div>
	<form id="deletecommentform_{$cid}" name="deletecommentform_{$cid}" method="post" autocomplete="off" action="portal.php?mod=portalcp&ac=comment&op=delete&cid=$cid">
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="deletesubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<div class="cl acon">{lang comment_delete_confirm}</div>
        <div class="ainuo_popbottom cl">
            <button type="submit" name="deletesubmitbtn" value="true" class="formdialog aconfirm">{lang confirms}</button>
            <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
        </div>
	</form>
</div>
<!--{/if}-->

<!--{template common/footer}-->
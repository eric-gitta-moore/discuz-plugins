<?PHP exit('QQÈº£º550494646');?>
<!--{if !$_G['uid']}-->
	<!--{eval dheader('Location:member.php?mod=logging&action=login');exit;}-->
<!--{/if}-->
<!--{template common/header}-->

<!--{subtemplate common/usertop}-->
<!--{if !$_GET['mycenter']}-->
<!--{subtemplate common/usernav}-->
<!--{subtemplate common/yourcenter}-->
<!--{else}-->
<!--{subtemplate common/mycenter}-->
<!--{/if}-->
<!--{subtemplate common/userbottom}-->
<!--{template common/footer}-->

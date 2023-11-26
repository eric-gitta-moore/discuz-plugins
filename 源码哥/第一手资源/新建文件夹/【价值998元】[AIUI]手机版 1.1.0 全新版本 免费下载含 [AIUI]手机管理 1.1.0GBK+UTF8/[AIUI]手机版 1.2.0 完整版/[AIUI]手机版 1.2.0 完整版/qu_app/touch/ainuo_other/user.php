<?PHP exit('QQÈº£º550494646');?>
<!--{if $_G['uid']}-->
<a href="{$_G['siteurl']}home.php?mod=space&uid={$_G[uid]}&do=profile&mycenter=1" class="avat avat2 y"><!--{avatar($_G[uid], 'small')}-->{if $_G[member][newprompt] || $_G[member][newpm]}<em></em>{/if}</a>   
<!--{else}-->
<a href="member.php?mod=logging&action=login" class="avat y"><img src="{$_G['siteurl']}template/qu_app/touch/style/css/images/avatar.png" /></a>
<!--{/if}-->
<?php exit;?>
<!--{if $thread['freemessage']}-->
	<div id="postmessage_$pid" class="n5sq_fsmfnr">$thread[freemessage]</div>
<!--{/if}-->
<div class="n5sq_ztsf cl">
	<a href="forum.php?mod=misc&action=pay&tid=$_G[tid]&pid=$post[pid]{if !empty($_GET['from'])}&from=$_GET['from']{/if}" class="y {if $_G['uid']}dialog{/if}" title="{lang pay}">{$n5app['lang']['sqzhutisfgm']}</a>
	<!--{if $_G[forum_thread][price] > 0}-->{lang pay_comment}<!--{/if}-->
</div>

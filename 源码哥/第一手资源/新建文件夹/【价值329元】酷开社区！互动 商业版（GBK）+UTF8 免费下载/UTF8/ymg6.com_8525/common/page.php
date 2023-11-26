<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
{if strpos($multipage, 'first')!=-1}
	{eval $resultPage = preg_replace('%(<a .*class="first"[^>]*>.*?</a>)(<a .*class="prev"[^>]*>(.*?)</a>)%s', '$2$1', $multipage);}
	{eval $multipage = str_replace('&nbsp;&nbsp;', '', $resultPage);}
{/if}
$multipage

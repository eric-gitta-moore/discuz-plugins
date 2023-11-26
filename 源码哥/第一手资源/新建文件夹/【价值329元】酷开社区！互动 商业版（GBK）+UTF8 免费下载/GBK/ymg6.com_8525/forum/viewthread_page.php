<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
{if strpos($multipage, 'first')!=-1}
	{eval //$resultPage = preg_replace('%(<a .*class="first"[^>]*>.*?</a>)(<a .*class="prev"[^>]*>(.*?)</a>)%s', '$2$1', $multipage);}
    {eval //$resultPage2 = preg_replace('/(page=([2-9]+))/s', '$1#gogo',$resultPage);}
	{eval //$multipage = str_replace('&nbsp;&nbsp;', '上一页', $resultPage2);}
    {eval //$multipage = str_replace('page=1#gogo', 'page=1', $resultPage2);}
{/if}
$multipage

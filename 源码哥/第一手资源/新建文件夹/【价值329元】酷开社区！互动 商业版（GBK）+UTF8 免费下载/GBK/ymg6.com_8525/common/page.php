<?php echo 'Դ�����ѷ�������ѧϰ����֧�����棡';exit;?>
{if strpos($multipage, 'first')!=-1}
	{eval $resultPage = preg_replace('%(<a .*class="first"[^>]*>.*?</a>)(<a .*class="prev"[^>]*>(.*?)</a>)%s', '$2$1', $multipage);}
	{eval $multipage = str_replace('&nbsp;&nbsp;', '', $resultPage);}
{/if}
$multipage

<?php
/*
 *源码哥：www.ymg6.com
 *更多商业插件/模版免费下载 就在源码哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */

return array(
	//'TYPE' => array(1 => '判断题',2 => '单选题',3 => '多选题',4 => '填空题',5 => '问答题'),
 
	'right'  => '正确',
	'wrong'  => '错误',
	
	'push_to_form_subject' => "$_G[username] 于 ".date('m-d H:i',$_SERVER['REQUEST_TIME'])." 参加了 $paper[title] 考试, 取得了 $paper[score] 分的成绩",
	'push_to_form_message' => "[url=home.php?mod=space&uid=$_G[uid] ][b]$_G[username] [/b][/url] 于 [b] ".date('m-d H:i',$_SERVER['REQUEST_TIME'])." [/b] 参加了 [url=plugin.php?id=exam&paper=$paper[pid] ][b]$paper[title] [/b][/url] 考试, 取得了 [b]$paper[score] [/b] 分的成绩\n试卷: $paper[title] 分\n总分: $paper[total] 分\n及格: $paper[pass]  分\n考试时间: $paper[minute] 分钟",

	
	'in_zu'		=> '题组|题干',
	'in_da'		=> '正确答案|参考答案|答案',
	'in_dui'	=> '正确|对|是',	
	'in_cuo'	=> '错误|错|否|×',
	'in_img'	=> '图片',
	'in_note'	=> '解析',
	'in_mao'	=> '：',
	'in_dun'	=> '、',
	'in_dian'	=> '．',
	);
?>
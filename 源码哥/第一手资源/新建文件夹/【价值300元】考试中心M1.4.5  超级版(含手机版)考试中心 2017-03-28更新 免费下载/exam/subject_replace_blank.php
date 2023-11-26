<?php
/*
 *源码哥：www.ymg6.com
 *更多商业插件/模版免费下载 就在源码哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */

	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	if(!function_exists('hook_match_replace'))
	{
		function hook_match_replace($str1, $str2 , $str3){
			global $hv,$v;
			if($str1){
				$options = explode('|', $str1);
				$string  = '&nbsp;<label><input type="hidden" name="e_'. $v['eid'].'[]" value="'.$hv.'">';
				$string .= '<select class="norcur" onchange="this.parentNode.getElementsByTagName(\'input\')[0].value=this.value" value="'.$hv.'"><option value="">&#x9009;&#x62E9;:</option>';
				foreach($options AS $ov){
					$selected = $ov==$hv ? 'selected' : '';
					$string .= "<option value=\"$ov\" $selected>$ov</option>";
				}
				$string .= "</select></label>&nbsp;";
			}else if($str2 || $str3){
				$string = '&nbsp;<label class="norcur"><input type="text" name="e_'. $v['eid'].'[]" value="'.$hv.'"></label>&nbsp;';
			}
			return $string;
		}
	}
 
	$hvalue = explode("\n", $history[$v['eid']]['user_result']);
	$hvi = 0;
	while(preg_match("/(\{[^|\}]+\|[^\}]+\})|(\_{2,})|(\((\s|&nbsp;)+\))/", $v['subject'])){
		$hv = $hvalue[$hvi++];
		$v['subject'] = preg_replace("/\{([^|\}]+\|[^\}]+)\}|(\_{2,})|(\((\s|&nbsp;)+\))/e",  "hook_match_replace('\\1','\\2','\\3')" , $v['subject'], 1);
	}
?>
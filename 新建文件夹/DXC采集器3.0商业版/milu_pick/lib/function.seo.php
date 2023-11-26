<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
function seo_set(){
	global $head_url;
	if(!submitcheck('submit')) {
		$info = pick_common_get();
		$info['open_seo_mod'] = dunserialize($info['open_seo_mod']);
		$info['open_seo_mod_show'][0] = in_array(1, $info['open_seo_mod']) ? 1 : 0;//门户
		$info['open_seo_mod_show'][1] = in_array(2, $info['open_seo_mod']) ? 1 : 0;//论坛
		$info['open_seo_mod_show'][2] = in_array(3, $info['open_seo_mod']) ? 1 : 0;//博客
		$info = dhtmlspecialchars($info);
		return $info;
	}else{
		$set = $_GET['set'];
		$set['open_seo_mod'] = serialize($set['open_seo_mod']);
		pick_common_set($set);
		cpmsg(milu_lang('op_success'), PICK_GO."seo", 'succeed');	
	}
	
}

function pick_seo_replace($info, $bbs = 1) {
	if(!$info) return;
	include_once libfile('function/home');
	$set = pick_common_get();
	$key_arr = array('push_title_header','push_title_footer','push_content_header','push_content_body','push_content_footer','push_reply_header', 'push_reply_body', 'push_reply_footer');
	foreach($key_arr as $v){
		$$v = format_wrap($set[$v]);
	}
	$info_key = array('title', 'content', 'reply');
	$hide = $bbs == 1 ? 0 : 1; 
	
	foreach($info_key as $v){
		if(!$info[$v]) continue;
		if($v != 'title'){//添加随机隐藏内容
			$rand_arr_key = 'push_'.$v.'_body';
			if($$rand_arr_key){
				$rand_arr = implode('*_*', $$rand_arr_key);
				$info[$v] = preg_replace("/\r\n|\n|\r/e", "pick_jammer('', '$rand_arr', $bbs)", $info[$v]);
				$info[$v] = preg_replace("/<\/p>|<\/P>/e", "pick_jammer('</p>', '$rand_arr', $bbs)", $info[$v]);
			}
			
		}
		$header_arr = 'push_'.$v.'_header';
		$header_arr = $$header_arr;
		$header = $header_arr[array_rand($header_arr)];
		$footer_arr = 'push_'.$v.'_footer';
		$footer_arr = $$footer_arr;
		$footer = $footer_arr[array_rand($footer_arr)];
		$info[$v] = $header.$info[$v];
		$info[$v] .= $footer;
		if($v == 'title') $info[$v] = getstr(trim($info[$v]), 80, 1, 1);
	}
	return $info;
}
function pick_jammer($flag,$rand_arr, $bbs = 1) {
	//print_r($flag);
	$rand_arr = explode('*_*', $rand_arr);
	$randomstr = $rand_arr[array_rand($rand_arr)];
	return mt_rand(0, 1) && $bbs==1 ? $flag.'<font class="jammer">'.$randomstr.'</font>'."\r\n" :
		 $flag."\r\n".'<span style="display:none">'.$randomstr.'</span>';
}


?>
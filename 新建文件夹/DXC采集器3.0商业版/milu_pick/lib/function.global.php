<?php
function show_pick_window($title,$html,$args = ''){
	global $_G;
	$charset = GBK ? 'gb2312' : 'UTF-8';
	$big5 = $_G['config']['output']['language'] == 'zh_tw' && $_G['config']['output']['charset'] == 'big5' ? TRUE : FALSE;
	if($big5) $charset = 'big5';
	if(!$args['no_show']) header('Content-Type: text/xml ');
	global $_G;
	ob_clean();
	ob_end_flush();
	$show_footer = $args['f'] && !$args['js_func'] ? false : true;
	$args['js_func'] = $args['js_func'] ? $args['js_func'] : 'hideWindow(\''.$_GET['handlekey'].'\')';
	if(!$args['w']) $args['w'] = 'auto';
	if(!$args['h']) $args['h'] = 'auto';
	$args['y'] = $args['y'] ? 'hidden' : 'scroll';
	if(!$args['no_show']){
		$show_html = '<?xml version="1.0" encoding="'.$charset.'"?>';
		$show_html .= "<root>";
		$show_html .= '<![CDATA[';
	}
	$show_html .= '<h3 class="flb">
	<em>'.$title.'</em>
	<span><a href="javascript:;" onclick="hideWindow(\''.$_GET['handlekey'].'\');" class="flbc" title="'.milu_lang('close').'">'.milu_lang('close').'</a></span>
	</h3>
	<div class="article_detail c" id="return_'.$_GET['handlekey'].'">
	<div class="c bart">
	<div style="width:'.$args['w'].'px; height:'.$args['h'].'px;overflow-y:'.$args['y'].';">'.$html.'</div>
	</div>';
	if($show_footer){
	 	$show_html .=  '<p class="o pns">
		<button type="submit" name="dsf" style="width:50px;  height:25px;" class="pn pnc" onclick="'.$args['js_func'].';"><span>'.milu_lang('ok').'</span></button>
		<button type="reset" style="width:50px; height:25px;" name="dsf" class="pn" onclick="hideWindow(\''.$_GET['handlekey'].'\');"><em>'.milu_lang('cancel').'</em></button>
		</p>';
	}
	$show_html .= "</div>";
	if(!$args['no_show']){
		$show_html .= "]]></root>";
	}
	if($args['no_show'] == 1){
		return $show_html;
	}else{
		echo $show_html;
	}	
	//echo str_iconv($show_html);
	define(FOOTERDISABLED, false);
	exit();
}
if(!function_exists('portalcp_get_summary')){
	function portalcp_get_summary($message) {
		$message = preg_replace(array("/\[attach\].*?\[\/attach\]/", "/\&[a-z]+\;/i", "/\<script.*?\<\/script\>/"), '', $message);
		$message = preg_replace("/\[.*?\]/", '', $message);
		$message = getstr(strip_tags($message), 200);
		return $message;
	}
}

function create_hash(){
	return md5(time().rand().uniqid());
}

//base64编码，然后转给js
function js_base64_encode($arr){
	foreach((array)$arr as $k => $v){
		if(GBK) $v = piconv($v, 'GB2312', 'UTF-8');
		$re[$k] = base64_encode($v);
	}
	return $re;
}
function clear_html_script($str, $filter_arr){
	if(!$filter_arr) return FALSE;
	global $_G;
	$filter_html = $_G['cache']['evn_milu_pick']['filter_html'];
	$max = count($filter_html);
	foreach((array)$filter_arr as $k => $v){
		if($v < $max ) $new_arr[] =  $filter_html[$v]['search'];
	}
	$rules = implode('|', $new_arr);
	$rules = convertrule($rules);
	$rules = str_replace('\|', '|', $rules);
	//print_r($rules);exit();
	$str = preg_replace("/<(\/?(".$rules.").*?)>/si", "", $str);
	return $str;
}




function milu_lang($name, $val_arr = array()){
	return lang('plugin/milu_pick', $name, $val_arr);
}


function str_iconv($str){
	global $_G;
	$is_big = $_G['cache']['evn_milu_pick']['pick_config']['is_big'];//是否utf-8环境下将繁体转换为简体
	if(!$str) return false;
	$charset = strtoupper(get_charset($str));
	$big5 = $_G['config']['output']['language'] == 'zh_tw' && $_G['config']['output']['charset'] == 'big5' ? TRUE : FALSE;
	if(GBK){
		if($charset == 'UTF-8'){
			if($is_big){
				return big5_gbk($str);
			}
			$str = piconv($str, 'UTF-8', 'GBK');
			return $str;
		}else if($charset == 'BIG5'){//繁体
			return big52gb($str);
		}
	}else{
		if($charset != 'UTF-8'){
			if($charset == 'BIG5')  {
				if($_G['config']['output']['language'] != 'zh_tw'){//简体
					$str = big52gb($str);
					return piconv($str, 'GBK', 'UTF-8');
				}
			}
			if($big5) return gb2big5($str);
			$str = piconv($str, $charset, 'UTF-8');
			return $str;		
		}else{
			if($big5){
				return piconv($str, 'UTF-8', 'big5');
			}
		}
	}
	return $str;	
}

//utf-8环境下 繁体装成简体 只用于gbk程序
function big5_gbk($str){
	global $_G;
	$is_big = $_G['cache']['evn_milu_pick']['pick_config']['is_big'];//是否utf-8环境下将繁体转换为简体
	if(!$is_big) return $str;
	$str = piconv($str, 'UTF-8', 'BIG5');
	$str = big52gb($str);
	return $str;
}


function piconv($str, $in, $out){
	global $_G;
	$is_win = strtoupper(substr(PHP_OS, 0, 3)) == 'WIN' ? TRUE : FALSE;
	if($is_win || $_G['cache']['evn_milu_pick']['pick_config']['is_big']) return diconv($str, $in, $out);
	if(function_exists('mb_convert_encoding')) {
		$str = mb_convert_encoding($str, $out, $in); 
	}else{	
		$str = diconv($str, $in, $out);
	}
	return $str;
}


//http://www.shipingjie.net/world/index.html这个地址不准确
function get_charset($web_str){
	preg_match("/<meta[^>]+charset=\"?'?([^'\"\>]+)\"?[^>]+\>/is", $web_str, $arr);
	//if($arr[1]) return $arr[1];
	$arr[1] = strtoupper($arr[1]);
	if($arr[1] == 'GBK' || $arr[1] == 'BIG5') return $arr[1];
	$charset = is_utf8($web_str) ? 'UTF-8' : 'GB2312'; 
	if($arr[1] && $arr[1] == $charset) return $arr[1];
	return $charset;
}

function get_base_url($message){
	preg_match("/<base[^>]+href=\"?'?([^'\"\>]+)\"?[^>]+\>/is", $message, $arr);
	if($arr[1]) return $arr[1];
}

function is_utf8($string) { 
	if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$string) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$string) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$string) == true) { 
		return true; 
	}else{ 
		return false; 
	} 
}

//由此函数调ajax函数
function ajax_func(){
	global $_G;
	$ajax_func = $_GET['af'];
	if(strexists($ajax_func, ':')){
		$temp_arr = explode(':', $ajax_func);
		$file_name = $temp_arr[0];
		$ajax_func = $temp_arr[1];
		pload('F:'.$file_name);
		if(!function_exists($ajax_func)){
			pload('C:'.$file_name);
			if(!function_exists($ajax_func)){
				exit(milu_lang('no_found_ajaxfunc'));
			}
		}
	}
	$inajax = $_GET['inajax'];
	$xml = empty($_GET['xml']) ? 0 : $_GET['xml'];
	if(!function_exists($ajax_func)) exit(milu_lang('no_found_ajaxfunc'));
	$output = $ajax_func();
	ob_clean();
	ob_end_flush();
	if($xml == 1) include template('common/header_ajax');
	echo $output;
	if($xml == 1) include template('common/footer_ajax');
	define(FOOTERDISABLED, false);
	exit();
}

//获取插件的全局设置
function get_pick_set(){
	global $_G;
	loadcache('plugin');
	return $_G['cache']['plugin']['milu_pick'];
}

function _striptext($document) {
	if (!$document) return $document;
	$search = array("'<script[^>]*?>.*?</script>'si",	// strip out javascript
					"'<style[^>]*?>.*?</style>'si",		//去掉css
					"'<!--.*?-->'si",		//去掉注释
					"'<[\/\!]*?[^<>]*?>'si",			// strip out html tags
					"'([\r\n])[\s]+'",					// strip out white space
					"'&(quot|#34|#034|#x22);'i",		// replace html entities
					"'&(amp|#38|#038|#x26);'i",			// added hexadecimal values
					"'&(lt|#60|#060|#x3c);'i",
					"'&(nbsp|#160|#xa0);'i",
					"'&(gt|#62|#062|#x3e);'i",
					"'&(iexcl|#161);'i",
					"'&(cent|#162);'i",
					"'&(pound|#163);'i",
					"'&(copy|#169);'i",
					"'&(reg|#174);'i",
					"'&(deg|#176);'i",
					"'&(#39|#039|#x27);'",
					"'&(euro|#8364);'i",				// europe
					"'&a(uml|UML);'",					// german
					"'&o(uml|UML);'",
					"'&u(uml|UML);'",
					"'&A(uml|UML);'",
					"'&O(uml|UML);'",
					"'&U(uml|UML);'",
					"' '",
					"'&szlig;'i",
					);
	$replace = array(	"",
						"",
						"",
						"",
						"\\1",
						"\"",
						"&",
						"<",
						">",
						" ",
						chr(161),
						chr(162),
						chr(163),
						chr(169),
						chr(174),
						chr(176),
						chr(39),
						chr(128),
						"?",
						"?",
						"?",
						"?",
						"?",
						"?",
						"",
						"?",
					);
				
	$text = preg_replace($search,$replace,$document);
							
	return strip_tags($text);
}


function d_s($name = 'default') { 
	global $ss_timing_start_times; 
	$ss_timing_start_times[$name] = explode(' ', microtime());
} 

function d_e($show=1,$name = 'default') { 
	global $ss_timing_stop_times; 
	$ss_timing_stop_times[$name] = explode(' ', microtime()); 
	if($show == 1){
		echo '<p>'.ss_timing_current($name).'</p>';
	}else{
		return ss_timing_current($name);
	}
} 

function ss_timing_current ($name = 'default') { 
	global $ss_timing_start_times, $ss_timing_stop_times; 
	if (!isset($ss_timing_start_times[$name])) {
	   return 0; 
	} 
	if (!isset($ss_timing_stop_times[$name])) { 
	   $stop_time = explode(' ', microtime()); 
	} else { 
	   $stop_time = $ss_timing_stop_times[$name]; 
	} 
	$current = $stop_time[1] - $ss_timing_start_times[$name][1]; 
	$current += $stop_time[0] - $ss_timing_start_times[$name][0]; 
	return $current; 
}


//同义词替换
function get_replace_words(){
	$words = array();
	$data_file = PICK_DIR.'/data/word.dat';
	$handle = fopen($data_file, "r");
	$data = fread($handle, filesize($data_file));
	$data = $old_data = trim($data);
	if(GBK) $data = str_iconv($data);
	$word_arr = explode(WRAP, $data);
	if(!$word_arr){
		$word_arr = explode(WRAP, $old_data);
	}
	if(!$word_arr) return;
	foreach((array)$word_arr as $k=>$v){
		if(!$k) continue;
		$str_arr = explode('→', $v);//关键词分割符
		$words += array("$str_arr[0]" => "$str_arr[1]");
	}
	return $words;
	//return strtr($str,$words);//返回结果
}



function show_pick_info($msg, $type = '', $args = array()){
	
	$show_msg = '';
	if($args['start'] == 1 || $type == 'url' || $type == 'left' || $type == 'show_err'){
		$show_msg = '<div class="run_li_box"><ul class="tipsblock">';
	}
	$li_str = $args['li_no_end'] == 1 ? '' : '</li>';
	$no_border = ($args['no_border']== 1 || $type == 'show_err') ? 'style=" border:0"' : '';
	$now_str = $args['now'] > 0 ? $args['now'].'.' : '';
	$no_loading_str =  "<script>s('".$args['now']."','');</script>";
	$id = $args['now'];
	$args['now'] = $args['now'] > 0 ? $args['now'].'.' : '';
	$show_loading = '<span class ="show_loading">'.milu_lang('loading').'</span>';
	if($type == 'err'){
		$show_msg .= '<span class ="f_r p_e">'.$msg.'</span></li>'.$no_loading_str;
	}else if($type == 'show_err'){
		$show_msg .= '<img  style="margin:5px;float:left;" src="'.PICK_URL.'static/image/s4.gif" /><li  '.$no_border.'>'.$msg.'</li>';
	}else if($type == 'url'){
		$show_status_info = $msg[0].' '.cutstr(trim($msg[1]), 60);
		$show_msg .= '<li id="show_'.$id.'" '.$no_border.'><span class="f_l">'.$now_str.$msg[0].'</span>  <span class="lin"><a href="'.$msg[1].'" target="_blank">'.cutstr(trim($msg[1]), 65).'</a>'.$msg[2].'</span>'.$show_loading.$li_str;
	}else if($type == 'left'){
		$show_status_info = $msg[0].' '.$msg[1];
		
		$show_msg .= '<li id="show_'.$id.'" '.$no_border.'><span class="f_l">'.$args['now'].$msg[0].'</span>  <span class="lin">'.$msg[1].'</span>'.$show_loading;
	}else if($type == 'success'){
		$show_msg = '<span class="f_r p_r">'.$msg.'</span></li>'.$no_loading_str;
	}else if($type =='no'){
		$show_msg .= $msg;
	}else if($type == 'finsh'){
		$show_msg .= '<div class="showmess">'.$msg.'</div><script>p_finsh();</script>'.$no_loading_str;
	}else if($type == 'exit' || !$type){
		$sty = $msg ? 'style=" border:0"' : 'style="height:5px;line-height:5px; border:0"';
		$class = $type == 'exit' ? ' class="e_p_e" ' : '';
		$show_msg .= '<div class="run_li_box"><ul class="tipsblock"><li '.$class.$sty.'>'.$msg.'</li></ul></div>';
		$show_status_info = $msg;
	}
	if($args['end'] == 1  || $type == 'err' || $type == 'success' || $type == 'show_err'){
		$show_msg .= '</ul></div>';
	}
	if($args['pro']){
		$show_msg .= '<script>SetProgress("'.$args['pro'].'","'.$args['wait_time'].'", "'.$args['wait_count'].'", "'.$args['memory'].'");</script>';
	}
	if($args['is_log'] == 1) {
		pload('F:pick');
		pick_log($show_msg, $args);
	}	
	if($args['is_cron'] == 1) return;
	//print str_repeat(" ", 4096);
	$show_status_info = strip_tags($show_status_info, '&nbsp;');
	$show_status_info = cutstr(trim($show_status_info), 85);
	$script =  "s('".$id."','".$show_status_info."');".$args['show_js'];
	echo $show_msg."<script>$script</script>";
	ob_flush();
	flush();
}


function ischinese($s){  
	$allen = preg_match("/^[^\x80-\xff]+$/", $s);   //判断是否是英文  
	$allcn = preg_match("/^[".chr(0xa1)."-".chr(0xff)."]+$/",$s);  //判断是否是中文  
	if($allen){    
		return 'allen';    
	}else{    
		if($allcn){    
			return 'allcn';    
		}else{    
			return 'encn';    
		}    
	}                    
}   



function unhtmlentities ($string) {
	$string = str_replace('&nbsp;', ' ', $string);
	// Get HTML entities table
	$trans_tbl = get_html_translation_table (HTML_ENTITIES, ENT_QUOTES);
	// Flip keys<==>values
	$trans_tbl = array_flip ($trans_tbl);
	// Add support for &apos; entity (missing in HTML_ENTITIES)
	$trans_tbl += array('&apos;' => "'");
	// Replace entities by values
	return strtr ($string, $trans_tbl);
}



function get_avg($arr){
	if(!$arr) return ;
	sort($arr);
	$count = count($arr);
	if($count > 6) unset($arr[0],$arr[1],$arr[$count-2],$arr[$count-1]);	
	$total = array_sum($arr);
	return $total/$count;
}

function get_repeat_arr($array){
	$existNumArray = array_count_values ($array);
	$answerArray = array();
	if($existNumArray){
		foreach($existNumArray as $k=>$v){
			if($v>1){
				$answerArray[$k] = array_keys($array,$k);
			}
		}
	}
	return $answerArray;
}

function get_element_arr($data, $name_arr){
	foreach($name_arr as $k => $v){
		preg_match_all("#<\s*".$v."[^>]*>(.*?)<\s*\/\s*".$v."\s*>#is", $data, $arr[$k]);
	}
	return $arr;
}

function chineseCount($str){
	$count = preg_match_all("/[\xB0-\xF7][\xA1-\xFE]/",$str,$ff);
	return $count;
}



function array_resolve($arr,$i=0){
	if(!is_array($arr)) return false;
	foreach($arr as $k => $v){
		$b = array_resolve($v, $i);
		if(is_array($v) && $v){
			$a = is_array($a) ? array_merge($a, $b) : $b;
			$i += count($a);  
		}else{
			$a[$i] = $v;
			$i++;
		}
	}
	$re = is_array($a) ? array_unique($a) : $a;
	return $re;
}



function data_go($url){
	echo "<script>location.href='admin.php?".PICK_GO.$url."';</script>";
}

function create_id(){
	return TIMESTAMP.rand(1,1000);
}




function format_wrap($str, $exp_type = WRAP){
	if(!$str) return false;
	$arr = explode($exp_type, trim($str));
	//if(count($arr) > 1) array_pop($arr);
	return $arr;
}
function format_url($url, $flag = 1){
	$url = trim(str_iconv($url));
	$url = stripslashes($url);
	$url = stripslashes($url);//真不明白为什么一定要反转义两次才能恢复原样
	if(!$url || ($flag == 1 && $url == 'undefined')) return false;
	$url =  str_replace('[[JK%', '<', $url);
	$url = str_replace('JK%]]', '>', $url);
	$url = str_replace('[yinhao', '"', $url);
	//if(strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
		$url = str_replace("\r\n", "\r\m", $url);	
		$url = str_replace("\n", "\r\n", $url);
		$url = str_replace("\r\m", "\r\n", $url);
	//}	
	return $url;
}


/*
* $args['is_fiter'] 是否过滤 1代表过滤
* $args['replace_rules']替换规则 
* $args['filter_data'] 过滤规则 
* $args['show_type'] 类型 
* $args['result_data'] 要处理的的东西
* $args['test'] 1代表测试 2 代表正式的生产环境
*/
function filter_article($args = array()){
	extract($args);
	if($is_fiter == 2) return $result_data;
	if(!$test) $test = 1;
	//$result_data = dstripslashes($result_data);
	if($replace_rules) {
		if($show_type == 'reply'){
			if(is_array($result_data)){
				foreach($result_data as $k => $v){
					$result_data[$k] = replace_something($v, $replace_rules, $test);
				}
			}
		}else{
			$result_data = replace_something($result_data, $replace_rules, $test);//替换
		}	
	}
	if($filter_data) {
		if(is_array($filter_data)){
			//print_r($filter_data);
			foreach($filter_data as $k => $v){
				if(!$v[1]){
					$v[0] = $v['type'];
					$v[1] = $v['rules'];
				}
				$v[1] = rpc_str($v[1]);
				if(!$v[0]) continue;
				if($v[0] == 1){//dom
					if($show_type == 'reply'){
						if(is_array($result_data)){
							foreach($result_data as $k2 => $v2){
								if($v[1]) $result_data[$k2] = dom_filter_something($v2, $v[1], $test);
								
							}
						}
					}else{
						if($v[1]) $result_data = dom_filter_something($result_data, $v[1], $test);
					}
				}else{//字符串
					if($show_type == 'reply'){
						if(is_array($result_data)){
							foreach($result_data as $k2 => $v2){
								if($v[1])$result_data[$k2] = str_filter_something($v2, $v[1], '', $test);
							}
						}
					}else{
						if($v[1]) $result_data = str_filter_something($result_data, $v[1], '', $test);
					}
				}
			}
			
		}
	}
	
	//格式化
	if($filter_html){
		if(is_array($result_data)){
			foreach($result_data as $k2 => $v2){
				$result_data[$k2] = clear_html_script($v2, $filter_html);
			}
		}else{
			
			$result_data = clear_html_script($result_data, $filter_html);
		}
	}
	return $result_data;
}

function trip_runma($html){
	return $html;
    //return preg_replace('@<font class="jammer">.*?</font>|<span style="display:none">.*?</span>@', '', $html);
}

//过滤
function filter_something($str,$find,$type = false){
	if(!is_array($find)){
		$find_arr = format_wrap(trim($find));
	}else{
		$find_arr = $find;
	}
	if(!$find_arr) return $type;
	$filterwords = implode("|",$find_arr);
	$filterwords = str_replace('(*)', '*', $filterwords);
	$filterwords = convertrule($filterwords);
	$filterwords = str_replace('\|', '|', $filterwords);
	if(preg_match("/(".$filterwords.")/i",$str,$match) == 1){
   		return false;
	}
	return true;
}


//某组东西替换某个东西
function replace_something($str, $replace_str, $test = 0, $limit = -1){
	if(!$str || !$replace_str) return false;
	if(!is_array($replace_str)){
		$replace_arr = format_wrap(trim($replace_str));
	}else{
		$replace_arr = $replace_str;
	}
	if($replace_arr){
		foreach($replace_arr as $k => $v){
			$rules_arr = explode('@@', trim($v));
			$rules_arr[0] = str_replace('(*)','[list]', $rules_arr[0]);
			$rules_arr[0] = str_replace("*","CT_TR", $rules_arr[0]);
			$rules_arr[0] = convertrule($rules_arr[0]);
			$rules_arr[0] = str_replace("CT_TR","\*", $rules_arr[0]);
			$rules_arr[0] = str_replace("'","\'", $rules_arr[0]);
			$rules_arr[0] = str_replace("\"","\\\"", $rules_arr[0]);
			//$rules_arr[0] = str_replace("|","|", $rules_arr[0]);
			$rules_arr[1] = str_replace("'","\'", $rules_arr[1]);
			$rules_arr[0] = str_replace('\[list\]', '\s*(.+?)\s*', $rules_arr[0]);	//解析为正则表达式
			$search_arr[$k] = "'".$rules_arr[0]."'si";
			if($test != 1){
				$replace_arr[$k] =  $rules_arr[1];
			}else{
				preg_match_all("/$rules_arr[0]/is", $str, $arr);
				if(is_array($arr[0])){
					foreach($arr[0] as $k1 => $v1){
						if($v1){
							$test_search_arr[$k1] = $v1;
							if(!$rules_arr[1]){
								$str = str_replace($v1, '<del>'.$v1.'</del>', $str);
							}else{
								$str = str_replace($v1, '<ins>'.$rules_arr[1].'</ins>', $str);
							}
							
						}
					}
				}
			}
		}			
	}
	if($test != 1) $str = preg_replace($search_arr, $replace_arr, $str, $limit);
	return $str;
}


function get_keyword($keyword = ''){
	$url = 'http://www.baidu.com/s?wd='.$keyword;
	$html = file_get_html($url);
	if(!$html) return false;
	foreach($html->find('div[id=rs] th a') as $v) {
		$arr[] = str_iconv($v->innertext);
	}
	return $arr;
}

/**
 * 解析内容
 */
function pregmessage($message, $rule, $getstr, $limit=1, $get_type = 'in') {
	if(!$message) return array();
	$message = str_replace("\r\n", "\r\m", $message);	
	$message = str_replace("\n", "\r\n", $message);
	$message = str_replace("\r\m", "\r\n", $message);
	$rule = convertrule($rule);		//转义正则表达式特殊字符串
	$result = array();
	$rule = str_replace('\['.$getstr.'\]', '\s*(.+?)\s*', $rule);	//解析为正则表达式
	if($limit == 1) {
		$result = array();
		preg_match("/$rule/is", $message, $rarr);
		if(!empty($rarr[1])) {
			$result[] = $get_type == 'in' ? $rarr[1] : $rarr[0];
		}
	} else {
		preg_match_all("/$rule/is", $message, $rarr, PREG_SET_ORDER);
		if(!empty($rarr[0])) {
			$key  = $get_type == 'in' ? 1 : 0; 
			foreach($rarr as $k => $v){
				$result[] = $v[$key];
			}
		}
	}
	return $result;
}

/**
 * 正则规则
 */
function getregularstring($rule, $getstr) {
	$rule = convertrule($rule);		//转义正则表达式特殊字符串
	$rule = str_replace('\['.$getstr.'\]', '\s*(.+?)\s*', $rule);	//解析为正则表达式
	return $rule;
}
/**
 * 转义正则表达式字符串
 */
function convertrule($rule) {
	$rule = dstripslashes($rule);
	$rule = preg_quote($rule, "/");		//转义正则表达式
	$rule = str_replace('\*', '.*?', $rule);
	$rule = str_replace("\(.*?\)", '(.*?)', $rule);
	
	//$rule = str_replace('\|', '|', $rule);
	
	return $rule;
}


//将数组中相同的值去掉,同时将后面的键名也忽略掉
function sarray_unique($array) {
	$newarray = array();
	if(!empty($array) && is_array($array)) {
		$array = array_unique($array);
		foreach ($array as $value) {
			$newarray[] = $value;
		}
	}
	return $newarray;
}


function str_format_time($timestamp = ''){  
	if(!$timestamp) return FALSE; 
	$timestamp = str_replace(milu_lang('day').' ', milu_lang('day'), $timestamp);
	$timestamp = str_replace(array(milu_lang('year'), milu_lang('month'), milu_lang('day'), milu_lang('hour'), milu_lang('minute'), milu_lang('sec')), array('-', '-', ' ', ':', ':', ':'), $timestamp);
	list($date, $time) = explode(" ", $timestamp);
	
	list($year, $month, $day) = explode("-", $date);
	list($hour, $minute, $seconds ) = explode(":", $time);
	$hour = $hour ? $hour : 0;
	$minute = $minute ? $minute : 0;
	$seconds = $seconds ? $seconds : 0;
	$timestamp = mktime($hour, $minute, $seconds, $month, $day, $year);
	return $timestamp;
}

function _expandlinks($links,$URI)
{
	$links = trim($links);
	$URI = trim($URI);
	$links = html_entity_decode($links);
	preg_match("/^[^\?]+/",$URI,$match);
	$url_parse_arr = parse_url($URI);
	$check = strpos($links, "?");
	if($check == 0 && $check !== FALSE){
		return $url_parse_arr["scheme"]."://".$url_parse_arr["host"].'/'.$url_parse_arr['path'].$links;
	}
	$check = strpos($links, "../");
	if($check == 0 && $check !== FALSE){//相对路径
		$path = dirname($url_parse_arr['path']);
		$path_arr = explode('/', $path);
		array_shift($path_arr);
		$i = 0;
		while ( substr ( $links, 0, 3 ) == "../" ) {  
			$links = substr ( $links, strlen ( $links ) - (strlen ( $links ) - 3), strlen ( $links ) - 3 );
			$i++;
		} 
		$temp_arr = array_slice($path_arr, 0, count($path_arr) - $i);
		return $url_parse_arr["scheme"]."://".$url_parse_arr["host"].'/'.($temp_arr ? implode('/',$temp_arr).'/' : '').$links;
	}
	$match = preg_replace("|/[^\/\.]+\.[^\/\.]+$|","",$match[0]);
	$match = preg_replace("|/$|","",$match);
	$match_part = parse_url($match);
	$port = $match_part["port"]  ?  ':'.$match_part["port"] : '';
	$match_root = $match_part["scheme"]."://".$match_part["host"].$port;
	
	$search = array( 	"|^http://".preg_quote($match_root)."|i",
						"|^(\/)|i",
						"|^(?!http://)(?!mailto:)|i",
						"|/\./|",
						"|/[^\/]+/\.\./|"
					);
					
	$replace = array(	"",
						$match_root."/",
						$match."/",
						"/",
						"/"
					);			
	$expandedLinks = preg_replace($search,$replace,$links);

	return $expandedLinks;
}


function filter_url_callback($url){
	global $_G;
	$evo_rules = $_G['cache']['evn_milu_pick']['evo_rules'];
	$no_url_arr = $evo_rules['no_url'];
	foreach($no_url_arr as $k => $v){//比正则快十倍以上
		if(strexists($url, $v)) return FALSE;
	}
	return $url;
}


//格式化url
function convert_url($url){
	if(!$url) return;
	$url =  str_replace('&amp;', '&', dhtmlspecialchars(trim($url)));
	$url = html_entity_decode($url);
	return $url;
}


//转换不同编码的序列化数组
function serialize_iconv($thevalue){
	global $_G;
	if(!is_array($thevalue)) return $thevalue;
	foreach((array)$thevalue as $k => $v){//防止编码不同造成的错误
		$v_s = dunserialize($v);
		if(!$v_s){//不是序列化
			if(is_array($v)){//如果是数组
				$thevalue[$k] = serialize_iconv($v);
			}else{
				$thevalue[$k] = $_G['config']['output']['language'] == 'zh_tw' && $_G['config']['output']['charset'] == 'big5' ? gb2big5($v) : str_iconv($v);
			}
		}else{
			$v = dunserialize($v);
			$v = serialize_iconv($v);
			$thevalue[$k] = serialize($v);
 		}
	}
	return $thevalue;
}


function rpc_str($str, $flag = 1){
	if($flag && $str == 'undefined') return '';
	return  str_iconv(trim(format_url(urldecode(urldecode($str)))));
}


function format_cookie($str){
	if($str == 'undefined' || $str == 'false') return '';
	return  str_iconv(trim(format_url($str)));
}




function convert_url_range($args){
	extract($args);
	if(!$url) return;
	if(!strexists($url, '(*)')) return array($url);
	$range_arr = range($start, $end, $step);
	$count = count($range_arr);
	$max_len = strlen($range_arr[$count - 1]);
	foreach($range_arr as $k => $v){
		$v = $auto ? str_pad($v, $max_len, "0", STR_PAD_LEFT) : $v;
		$arr[] = str_replace('(*)', $v, $url); 
	}
	return $arr;
}


/*数组组合合并*/
/*
功能描述如下：
$arr[0] = array('a','h','k');
$arr[1] = array('b' ,'c');
$arr[2] = array('d', 'e' ,'f');
$arr[3] = array('m', 'g' ,'p', 'u'); 
将arr里面的二维数组，每个数组各取一个元素出来进行组合 返回所有组合的数组
*/
function my_array_merge($arr){
	$info = get_array_info($arr);
	for($i = 1; $i < $info['change_arr'][0] + 1; $i++){
		$new_arr[$i] = get_array_value($i, 0, '', $info);
	}
	return $new_arr ? array_unique($new_arr) : $new_arr;
}
function get_array_info($arr){
	$count = 1;
	foreach($arr as $k => $v){
		if(!is_array($v)) $v = array($v);
		$c = count($v);
		$count *= $c ;
		$count_arr[$k] = $c;
	}
	foreach($arr as $k => $v){
		$team_arr = array_slice($count_arr, $k);
		$change_arr[$k] =  array_product($team_arr);    
	}
	$info['count_arr'] = $count_arr;
	$info['change_arr'] = $change_arr;
	$info['arr'] = $arr;
	return $info;
}

//此函数算法较蛋疼(我自己瞎扯出来的)
function get_array_value($i,$k = 0,$re = '',$info){
	extract($info);
	$last_key = count($change_arr) - 1;
	if($k == count($change_arr)) return $re;
	$v = $change_arr[$k+1];
	$last_c = count($arr[$last_key]);
	$v = $v ? $v : 0;
	$c = $count_arr[$k];
	if($k == $last_key){//最底层的
		if($i > $last_c){
			$j = $i % $last_c - 1;
		}else{
			$j = $i - 1;
		}
		if( ($i % $last_c) == 0) $j = $last_c - 1;
	}else{
		$m = ceil($i / $v);
		if( ($m > $v && $m != $c) || ($k != 0 && $m != $c )){
			if($i > $v){
				if($m % $c == 0){
					$j = $c - $m%$c - 1;
				}else{
					$j = abs($m % $c - 1);
				}
			}else{
				$j = 0;
			}
		}else{
			$j = $m - 1;
			
		}
	}

	$re .= $arr[$k][$j];
	return get_array_value($i, $k + 1, $re, $info);
}
/*结束*/

function clear_ad_html($document) {
	if (!$document) return $document;
	$search = array(
					"'<script[^>]*?>.*?</script>'si",		//去掉js
					"'<style[^>]*?>.*?</style>'si",		//去掉css
					"'<iframe[^>]*?>.*?</iframe>'si",		//去掉框架
					"'<!--.*?-->'si",		//去掉注释
					"/(onclick|onMouseUp|onMouseDown|onDblClick|onMouseOver|onMouseOut|onmouseenter|onload)=('|\")?(.*)\\2/isU",		//去掉各种事件

					);
	$replace = array(	"",
						"",
						"",
						"",
						"",
					);
				
	$text = preg_replace($search,$replace,$document);
	return $text;
}

function load_cache($key,$clearStaticKey = FALSE){
	require_once(PICK_DIR.'/lib/cache.class.php');
	$cache = new serialize_cache();
	return $cache->get($key,$clearStaticKey);
}

function cache_data($key,$value,$ttl = 3600){
	if($ttl < 0 || $ttl == 0) return FALSE;
	require_once(PICK_DIR.'/lib/cache.class.php');
	$cache = new serialize_cache();
	$value = is_array($value) ? $value : rawurlencode($value);
	$cache->set($key,$value,$ttl);
}
function cache_del($key){
	require_once(PICK_DIR.'/lib/cache.class.php');
	$cache = new serialize_cache();
	$cache->delete($key);
}



function gb2big5($Text){   
   $fp = fopen(PICK_DIR."/data/gb-big5.table", "r");   
   $max = strlen($Text)-1;   
	for($i=0; $i<$max; $i++){ 
		$h = ord($Text[$i]); 
		if($h >= 160){   
			$l=ord($Text[$i+1]);   
		if($h == 161 && $l==64){   
			$gb = " ";  
		}else{   
			fseek($fp, ($h-160)*510+($l-1)*2);   
			$gb = fread($fp,2);   
		}   
		$Text[$i] = $gb[0];   
		$Text[$i+1] = $gb[1]; $i++;   
		}   
	}  
	fclose($fp);   
	return $Text;  
} 


function big52gb($Text){
	$fp = fopen(PICK_DIR."/data/big5-gb.table", "r"); 
    $max = strlen($Text)-1;
    for($i=0;$i<$max;$i++){
	   $h = ord($Text[$i]);
	   if($h>=160){
			$l = ord($Text[$i+1]);
			if($h == 161 && $l==64){
				$gb = " ";
			}else{
				fseek($fp, ($h-160)*510+($l-1)*2);
				$gb = fread($fp,2);
			}
			$Text[$i] = $gb[0];
			$Text[$i+1] = $gb[1];
			$i++;
		}
   }
   fclose($fp);
   return $Text;
 }



function get_data_range($str, $start = 0, $num = 1){
	$str = trim($str);
	if(!$str && $num == 1 ) return 0;
	if(!$str && $num > 1 ) return array();
	if(strexists($str, ',')){//范围
		$str_arr = format_wrap($str, ',');
		$str_arr = array_filter($str_arr, 'intval') ;
		$str_arr[0] = intval($str_arr[0]);
		$str_arr[1] = intval($str_arr[1]);
		if($start < 0){
			for($i = 1; $i < $num + 1; $i++){
				$re_arr[] = rand($str_arr[0], $str_arr[1]); 
			}
			return $num == 1 ? $re_arr[0] : $re_arr;
		}else{
			$start += $str_arr[0]; 
			$end = $start + $num - 1;
			$end = ($end > $str_arr[1]) ? $str_arr[1] : $end;
			$re_arr['list'] = $start > $str_arr[1] ? array() : range($start, $end);
			$re_arr['num'] = $num;
			$re_arr['all_num'] = ($str_arr[1] - $str_arr[0]) + 1;
		}
	}else if(strexists($str, '|')){
		$arr = format_wrap($str, '|');
		$end = $start + $num;
		if($start < 0){
			return array_rand($arr, $num);
		}else{
			$re_arr['list'] = array_slice($arr, $start, $end);
			$re_arr['num'] = $re_arr['all_num'] = count($arr);
		}
	}else{
		$re_arr['list'] = array($str);
		if($start < 0) return $str;
		$re_arr['num'] = $re_arr['all_num'] = 1;
	}
	return $re_arr;
}

function pick_common_set($config_arr){
	$config_arr = paddslashes($config_arr);
	foreach((array)$config_arr as $k => $v){
		$v = is_array($v) ? serialize($v) : $v;
		DB::query("REPLACE INTO ".DB::table('strayer_setting')." (`skey`, `svalue`) VALUES ('$k', '".$v."')");
	}
	pick_common_get(1);
}

function pick_common_get($n = 0, $key = ''){
	global $_G;
	$setting = array();
	loadcache('milu_pick_setting');
	$where = $key ? " WHERE skey='$key'" : '';
	if(!($setting = $_G['cache']['milu_pick_setting']) || $n != 0){
		$query = DB::query("SELECT * FROM ".DB::table('strayer_setting')." $where");
		while($row = DB::fetch($query)) {
			$setting[$row['skey']] = $row['svalue'];
		}
		save_syscache('milu_pick_setting', $setting);
	}
	$setting = pstripslashes($setting);
	$setting = $key ? $setting[$key] : $setting;
	return $setting;
}


function strcut($allStr,$star,$end){ 
	eregi("".$star."(.*)".$end."", $allStr, $head);
	$head[0] = str_replace("".$star."","",$head[0]); 
	$head[0] = str_replace("".$end."","",$head[0]);
	return trim($head[0]);
}

function get_memory(){
	if(!function_exists('memory_get_usage')) return FALSE;
	return sizecount(memory_get_usage());
}

function php_set($key){
	if(function_exists('ini_get')) return ini_get($key);
	if(function_exists('get_cfg_var')) get_cfg_var($key);
	return FALSE;
}

function pstripslashes($data){
	if(DISCUZ_VERSION == 'X2') return $data;
	return dstripslashes($data);
}

function paddslashes($data){
	if(DISCUZ_VERSION != 'X2') return $data;
	return daddslashes($data);
}

function diff_time($diff_time, $show = 0){
	$diff_time = intval($diff_time);
	if($diff_time == 0) return;
	$d_str = 24 * 60 * 60;
	$h_str = 60 * 60;
	$m_str = 60;
	$s_str = 1;
	$arr['d'] = floor($diff_time / $d_str); 
	$arr['h'] = floor($diff_time  % $d_str / $h_str); 
	$arr['m'] = floor($diff_time % $d_str % $h_str/$m_str);
	$arr['s'] = floor($diff_time % $d_str % $h_str%$m_str/$s_str);
	if($show ==0) return $arr;
	$re_str = $arr['d'] ? $arr['d'].milu_lang('day') : '';
	$re_str .= $arr['h'] ? $arr['h'].milu_lang('hour') : '';
	$re_str .= $arr['m'] ? $arr['m'].milu_lang('minute') : '';
	$re_str .= $arr['s'] ? $arr['s'].milu_lang('sec') : '';
	return $re_str;
}

function pload($name){
	$arr = explode(',', $name);
	$temp_arr = array();
	$pick_dir = DISCUZ_ROOT.'source/plugin/milu_pick';
	foreach($arr as $k => $v){
		$temp_arr = explode(':', $v);
		$type = strtolower($temp_arr[0]);
		$name = $temp_arr[1];
		$func_file = $pick_dir.'/lib/function.'.$name.'.php';
		$class_file = $pick_dir.'/lib/'.$name.'.class.php';
		if( (!$type || $type == 'f')){//函数库
			require_once($func_file);
		}else if($type == 'c'){//类库
			require_once($class_file);
		}
	}
}


function get_rand_time($s, $e, $n = 1){
	global $_G;
	if($e < $s) return FALSE;
	$s = $s ? $s : $_G['timestamp'];
	$e = $e ? $e : $_G['timestamp'];
	if($n == 1){
		if($e == $s) {
			return $_G['timestamp'];
		}else{
			return rand($s, $e);
		}	
	}
}
function parray_rand($arr, $num = 1){
	$key = array_rand($arr, 1);
	return $arr[$key];
}


function rpcServer(){
	global $_config,$_G;
	include_once('phprpc/phprpc_server.php');
	$server = new PHPRPC_Server();
	$server->add(array('test_window','load_keyword', 'show_rules_set', 'login_test'));
	$server->setCharset(CHARSET);
	$server->setEnableGZIP(FALSE);
	$server->start();
	define(FOOTERDISABLED, false);
	exit();

}


function rpcClient(){
	include_once ("phprpc/phprpc_client.php");  
	$client = new PHPRPC_Client();  
	$client->setProxy(NULL);  
	$client->useService(GET_URL.'plugin.php?id=pick_user:share_rules&tpl=no&myac=rpcServer&inajax=1');   
	//$client->setKeyLength(10);  
	//$client->setEncryptMode(3);  
	$client->setCharset('GBK');  
	$client->setTimeout(10);  
	return $client;
}

//导出文件 //改装自SupeSite
function exportfile($array, $filename, $args = array()) {
	include_once libfile('function/home');
	global $_G;
	$array = pstripslashes($array);
	unset($array['run_times']);
	$array['version'] = strip_tags(PICK_VERSION);
	if(!$args){
		$args = array(
			'type' => milu_lang('dxc_system_rules'),
			'author' => $array['rule_author'],
			'rules_name' => $array['rules_name'],
			'rule_desc' => $array['rule_desc'],
		);
	}
	$args['type'] = str_iconv($args['type']);
	$args['author'] =  str_iconv($args['author']);
	$args['rules_name'] = str_iconv($array['rules_name']);
	$args['rule_desc'] = str_iconv($array['rule_desc']);
	$exporttext = "# DXC Dump\r\n".
	"# Version: DXC ".PICK_VERSION."\r\n".
	"# Type: ".$args['type']."\r\n".
	"# Time: ".dgmdate($_G[timestamp])."\r\n".
	"# From: ".$args['author']." (".$_G['siteurl'].")\r\n".
	"# Name: ".$args['rules_name']."\r\n".
	"# Description: ".$args['rule_desc']."\r\n".
	"# This file was BASE64 encoded\r\n".
	"#\r\n".
	"# DXC: http://www.56php.com/forum-79-1.html\r\n".
	"# Please visit our website for latest news about DXC\r\n".
	"# --------------------------------------------------------\r\n\r\n\r\n".
	
	$text = wordwrap(base64_encode(serialize($array)), 50, "\r\n", 1);
	$file_name = $filename.'['.$args['type'].'].txt"';    
	export_file($exporttext, $file_name);
	
}

function export_file($exporttext, $filename){
	include_once libfile('function/home');
	ob_start();
	ob_end_flush();
	obclean(); 
	header('Content-Encoding: none');
	@header("Content-type: text/xml; charset=UTF-8");
	header('Content-Type: '.(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'application/octetstream' : 'application/octet-stream'));
	header('Content-Disposition: attachment; filename="'.$filename);
	header('Content-Length: '.strlen($exporttext));
	header('Pragma: no-cache');
	header('Expires: 0');
	echo $exporttext;
	define(FOOTERDISABLED, false);
	exit;
}


//导入文件 改装自SupeSite
function pimportfile($importdata){
	global $_G;
	$importdata = preg_replace("/(#.*\s+)*/", '', $importdata);	//替换采集器中的注释
	@$thevalue = base64_decode($importdata);	//对采集器编码时行base64解码处理并进行反序列化操作转为可用的数组变量
	
	$thevalue = unserialize($thevalue);
	$thevalue = serialize_iconv($thevalue);
	
	//反序列化后，如果结果不是数组，或版本号为空，则提示
	if(!is_array($thevalue) || empty($thevalue['version'])) {
		cpmsg_error(milu_lang('rules_error_data'));
	}
	//对不同版本的采集机器为验证
	if(empty($_POST['ignoreversion']) && strip_tags($thevalue['version']) != strip_tags(PICK_VERSION)) {
		//cpmsg_error(milu_lang('error_verson'));
	}
	unset($thevalue['version']);//销毁版本号
	return $thevalue;
}

//把不属于某个表的字段干掉
function get_table_field_name($table, $data_arr = array()){
	global $_G;
	static $db;
	if(empty($db)) $db = & DB::object();
	$fields = mysql_list_fields($db->config[1]['dbname'], DB::table($table), $db->curlink); 
	$columns = mysql_num_fields($fields); 
	for ($i = 0; $i < $columns; $i++) { 
		$field_arr[] = mysql_field_name($fields, $i);
	}

	foreach($data_arr as $k =>$v){
		if (!in_array ($k, $field_arr)) unset($data_arr[$k]);
	}
	return $data_arr;
}

function getthreadtypes($args = array() ){
	global $_G;
	if(empty($_GET['selectname'])) $_GET['selectname'] = 'threadtypeid';
	$now_id = $args['typeid'] ? $args['typeid'] : intval($_GET['typeid']);
	$fid = $args['fid'] ? $args['fid'] : intval($_GET['fid']);
	$output = '<select name="'.$_GET['selectname'].'">';
	$query = DB::query("SELECT typeid,name,displayorder FROM ".DB::table('forum_threadclass')." WHERE  fid='$fid' ORDER BY displayorder");
	$output .= '<option value="0" >'.milu_lang('select_class').'</option>';
	while($rs = DB::fetch($query)) {
		$selected = ($rs['typeid'] == $now_id) ? 'selected="selected"' : ''; 
		$output .= '<option '.$selected.' value="'.$rs['typeid'].'">'.$rs['name'].'</option>';
	}
	$output .= '</select>';
	return $output;
}

//检测运行环境
function check_env($type = 1, $get_msg = 1){
	global $_G;
	$msg_s = '<div class="showmess">';
	$check = TRUE;
	$notice = '';
	switch($type){
		case 1://检查是否开启函数
			if(!function_exists('fsockopen') && !function_exists('pfsockopen')){
				$check = FALSE;
				$notice = '<p>'.milu_lang('no_pick_func').'</p>';
			}
		break;
		case 2://检查是否在内网环境
			require_once libfile('function/misc');
			pload('F:copyright');
			$client_info = get_client_info();
			if(!$client_info) {
				$check = FALSE;
				$notice = '<p>'.milu_lang('lan_no_use').'</p>';
			}
		break;
	}
	
	$msg_e = '</div>';
	if($get_msg != 1) return $check;
	if($notice) return $msg_s.$notice.$msg_e;
}

//cookie登录测试
function login_test(){
	pload('F:spider');
	$is_login = intval($_GET['is_login']);
	$login_cookie = format_cookie($_GET['login_cookie']);
	$login_test_url = rpc_str($_GET['login_test_url']);
	$args = array(
		'referer' => $login_test_url,
		'cookie' => $login_cookie,
	);
	$snoopy_obj = get_snoopy_obj($args);
	$snoopy_obj->fetch($login_test_url);
	$content = $snoopy_obj->results;
	$file = md5($login_test_url).'.htm';
	$fp = @fopen(PICK_CACHE.'/'.$file, 'wb');
	flock($fp, LOCK_EX);
	$len = @fwrite($fp, $content);
	flock($fp, LOCK_UN);
	@fclose($fp);
	$output = '<br><p align="center"><a target="_blank" href="'.PICK_URL.'data/cache/'.$file.'" >'.milu_lang('view_login_page').'</a></p>';
	return $output;

}


function cnurl($url){
	if(ischinese($url) != 'encn') return $url;
	return preg_replace(array('/\%3A/i', '/\%2F/i' , '/\%3F/i', '/\%3D/i', '/\%26/i'), array(':', '/', '?', '=', '&'), rawurlencode($url) );//对于有中文的地址来说，有必要这样处理
}

function get_contents($url, $args = array()){
	if(!$url) return;
	$pick_config = get_pick_set();
	pload('F:spider');
	$args['cookie'] = $args['cookie'] ? $args['cookie'] : format_cookie($_GET['login_cookie']);
	$url = cnurl($url);
	extract($args);
	global $_G;
	$time_out = $time_out ? $time_out : ($pick_config['time_out'] ? $pick_config['time_out'] : 10);
	$max_redirs = $max_redirs ? $max_redirs : $pick_config['max_redirs'];
	$cache = $cache ? $cache : $pick_config['cache_time'] * 60;
	//$cache = -1;//debug
	if($cache > 0 && $content = load_cache($url)){
		$content = media_format($content, $url);
		return $content;
	}else{
		$time_out = $time_out ? $time_out : $pick_config['time_out'];
		/*if(function_exists('curl_version')){
			$ch = curl_init();
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_HEADER, 0);
			ob_start();
			curl_exec ($ch);
			curl_close ($ch);
			$content = ob_get_contents();
			$content = str_iconv($content);
			ob_end_clean();
		}else{	
		*/	
			if(!function_exists('fsockopen') && !function_exists('pfsockopen') && !function_exists('file_get_contents')){
				return -1;
			}
			if(!function_exists('fsockopen') && !function_exists('pfsockopen')){
				if(!function_exists('file_get_contents')) return -1;
				$content = file_get_contents($url);
				$content = str_iconv($content);
			}else{
				require_once(PICK_DIR.'/lib/Snoopy.class.php');
				$snoopy = new Snoopy;    
				$snoopy->maxredirs = $max_redirs;   
				$snoopy->expandlinks = TRUE;
				$snoopy->offsiteok = TRUE;//是否允许向别的域名重定向
				$snoopy->maxframes = 3;
				$snoopy->agent = $_SERVER['HTTP_USER_AGENT'];//不设置这里，有些网页没法获取
				$snoopy->referer = $url;
				$snoopy->rawheaders["COOKIE"]= $cookie;
				$snoopy->read_timeout = $time_out;
				if(!$snoopy->fetch($url)) return FALSE;
				$header = $snoopy->headers;
				if($header[0] == 'HTTP/1.1 404 Not Found
' || $header[0] == 'HTTP/1.1 500 Internal Server Error') return -2;
				$content = $snoopy->results;
				$content = str_iconv($snoopy->results);
			}
		//}
		$content = media_format($content, $url);
		if($content) cache_data($url, $content, $cache);
		return $content;
	}
}


//将内容中的附件格式化

function dz_attach_format($url, $message){
	if(!$message) return;
	$message = dstripslashes($message);
	$base_url  = get_base_url($message);
	$url = $base_url ? $base_url : $url;
	$attach_arr = array();
	preg_match_all('/<\s*ignore_js_op\s*>(.*?)<\/\s*ignore_js_op\s*>/is', $message, $block_arr, PREG_SET_ORDER);//DZ2.0和DZ2.5的附件
	foreach((array)$block_arr as $k => $v){
		preg_match_all('/<img\s+src="static\/image\/filetype\/(.*?)"[\s\S]*?<a href=[\'"](.*?forum\.php\?.*?)[\'"].*?target="_blank"\>(.*?)<\/a>/is', $v[1], $t_arr, PREG_SET_ORDER);
		if($t_arr){
			$t_arr[0][0] = $v[0];
			$attach_arr[] = $t_arr[0];
		}
	}
	
	foreach((array)$attach_arr as $k => $v){
		$search_arr[] = $v[0];
		$attach_url = _expandlinks($v[2], $url);
		$replace_arr[] = '<a href="'.$attach_url.'" title="'.trim($v[4]).'">'.trim($v[3]).'</a>';
	}
	//print_r($attach_arr);//exit();
	$message = str_replace($search_arr, $replace_arr, $message);
	return $message;
}

function attach_format($url, $message){
	if(!$message) return;
	$message = dstripslashes($message);
	$base_url  = get_base_url($message);
	$url = $base_url ? $base_url : $url;
	$temp = $attach_arr = $attach_arr2 = array();
	
	$message = dz_attach_format($url, $message);
	
	preg_match_all("/\<a.+href=('|\"|)?(.*)(\\1)(.*)?\>(.*)?<\/a>/isU", $message , $attach_arr2, PREG_SET_ORDER);
	
	$no_ext_arr = array('html', 'htm', 'shtml', 'close()', 'print();');
	foreach((array)$attach_arr2 as $k => $v){
		$search_arr[$k] = $v[0];
		$v[2] = $v[2] ? $v[2] : $v[4];
		$v_info = parse_url($v[2]);
		$ext = addslashes(strtolower(substr(strrchr($v_info['path'], '.'), 1, 10)));
		if(in_array($ext,  $no_ext_arr)) {
			$replace_arr[$k] = $v[0];
			continue;
		}	
		$attach_url = _expandlinks($v[2], $url);
		$replace_arr[$k] = str_replace('href='.$v[1].$v[2].$v[1], 'href='.$v[1].$attach_url.$v[1], $v[0]);
	}
	$message = str_replace($search_arr, $replace_arr, $message);
	return $message;
}



function check_web_type(){
	global $_G;
	pload('F:spider');
	ob_clean();
	ob_end_flush();
	$url = format_url($_GET['url']);
	$list_ID = trim(format_url($_GET['list_ID']));
	$data = str_iconv(get_contents($url));
	if(!$list_ID) exit();
	if(!filter_something($data, $list_ID) && $data && $url) echo 1;
	define(FOOTERDISABLED, false);
	exit();
}

function get_share_serach($data_type){
	global $_G,$head_url;

	$info['orderby_arr'] = array(
		'default' => milu_lang('default_sort'),
		'dateline' => milu_lang('upload_dateline'),
		'download' => milu_lang('download_count'),
	) ;
	$info['ordersc_arr'] = array(
		'desc' => milu_lang('sort_desc'),
		'asc' => milu_lang('sort_asc'),
	) ;
	$info['perpage_arr'] = array(
		'25' => milu_lang('per_page_show', array('n' => 25)),
		'50' => milu_lang('per_page_show', array('n' => 50)),
		'100' => milu_lang('per_page_show', array('n' => 100)),
	) ;
	$info['evn_msg'] = check_env();
	if(!submitcheck('submit')) {
	}else{
		$info = array_merge($_GET['set'], $info);
	}
	$args = $_GET['set'];
	$args['s'] = $args['s'] ? $args['s'] : $_GET['s'];
	$args['picker_author'] = $args['picker_author'] ? $args['picker_author'] : $_GET['picker_author'];
	$args['orderby'] = $args['orderby'] ? $args['orderby'] : $_GET['orderby'];
	$args['orderby'] = $args['orderby'] ? $args['orderby'] : 'default';
	$args['ordersc'] = $args['ordersc'] ? $args['ordersc'] : $_GET['ordersc'];
	$args['ordersc'] = $args['ordersc'] ? $args['ordersc'] : 'desc';
	$args['perpage'] = $args['perpage'] ? $args['perpage'] : $_GET['perpage'];
	$args['perpage'] = $args['perpage'] ? $args['perpage'] : '25';
	$url_args = '';
	foreach((array)$args as $k => $v){
		if($k == 'perpage') continue;
		$url_args .= '&'.$k.'='.$v;
	}
	$args['page'] = $_GET['page'] ? intval($_GET['page']) : 1;
	$args['mpurl'] = $head_url.$_GET['myac'].$url_args;
	$rpcClient = rpcClient();
	$host_info = get_client_info();
	$args['domain'] = $host_info['domain'];
	$data = $rpcClient->get_list_data($data_type, $args);
	if($data == 'rpclimit') exit('破解版无法使用服务器资源!');
	if(is_object($data)){
		if($data->Message || $data->Number == 0) {
			$info['evn_msg'] = milu_lang('phprpc_error', array('msg' => $data->Message));
			return $info;
		}	
	}
	$data = serialize_iconv($data);
	$info['rs'] = $data['rs'];
	$info['count'] = $data['count'];
	$info['multipage'] = $data['multipage'];
	if($args['s']){
		$info['show_result'] = milu_lang('search_num', array('n' => $info['count'] ? $info['count'] : 0));
	}
	return $info;
}

function get_path_hash($url){
	$url_temp = preg_replace('/\d+/', '', $url);
	$arr_temp = parse_url($url_temp);
	if(!strexists($arr_temp['path'], '.')){
		$explode_arr = explode('/',$arr_temp['path']);
		if($explode_arr > 1){
			array_pop ($explode_arr);
			$arr_temp['path'] = implode('/',$explode_arr);
		}
	}
	$path_hash = md5($arr_temp['path']);
	return $path_hash;
}

//本地搜索规则 $get_type 1单贴规则 2 内置规则（包括列表和详细页） 4，只搜索列表页  3学习到的规则
function match_rules($url, $content, $get_type, $show = 1){
	global $_G;
	$pick_config = $_G['cache']['evn_milu_pick']['pick_config'];
	$index_localtion_cache_time = $pick_config['index_localtion_cache_time'];
	pload('F:copyright');
	$host_info = GetHostInfo($url);
	$domain = $host_info['host'];
	$domain_hash = md5($domain);
	$pash_hash = get_path_hash($url);
	$content = clear_ad_html($content);
	$content = preg_replace("'([\r\n])[\s]+'", "", $content);//去掉换行速度更快
	$content = daddslashes($content);
	if(!$content) return FALSE;
	$cache_time = $pick_config['index_cache_time'];
	
	if($get_type == 1){//单贴规则
		$locate_sql = "LOCATE(detail_ID,'$content')";
		$table_name = 'strayer_fastpick';
		$id_name = 'id';
	}else if($get_type == 2 || $get_type == '4' || $get_type == '5'){//内置规则 4是单搜索列表页匹配 （后来加一个 5 只搜索详细页）
		if($get_type == 4){
			$locate_sql = " list_ID <>'' AND LOCATE(list_ID,'$content')";
		}else if($get_type == 2){
			$locate_sql = "(( list_ID <>'' AND LOCATE(list_ID,'$content')) OR ( detail_ID <>'' AND LOCATE(detail_ID,'$content') ))";
		}else if($get_type == 5){
			$locate_sql = " detail_ID <>'' AND LOCATE(detail_ID,'$content') ";
		}
		$table_name = 'strayer_rules';
		$id_name = 'rid';
	}else if($get_type == 3){//学习到的规则
		$locate_sql =  "LOCATE(detail_ID,'$content')";
		$table_name = 'strayer_evo';
		$id_name = 'id';
	}
	$over_dateline = $_G['timestamp'] - $index_localtion_cache_time;
	$base_sql = "SELECT COUNT(*) FROM ".DB::table('strayer_searchindex')." WHERE  domain_hash='".$domain_hash."' AND path_hash='".$path_hash."'";
	if($get_type != 3){//内置规则和单贴采集规则需检测，学习规则则不必
		$check = DB::result(DB::query($base_sql." AND type='".$get_type."4' AND dateline > $over_dateline AND rid=0"), 0);
		if($check) return 'no';
	}
	$count = DB::result(DB::query($base_sql." AND type='".$get_type."4' AND rid>0"), 0);
	if($count){
		$query = DB::query("SELECT * FROM ".DB::table('strayer_searchindex')."  WHERE domain_hash='".$domain_hash."' AND path_hash='".$path_hash."' AND rid>0");	
		while(($v = DB::fetch($query))) {
			$index_id_arr[] = $v['rid'];
			$index_list[] = $v;
		}
	}
	if(!$count){//没有索引
		if($get_type != 3){//学习规则库没有索引的情况下，不需要寻找
			$info = DB::fetch_first("SELECT * FROM ".DB::table($table_name)." WHERE $locate_sql ");
			if(!$info) {
				add_search_index($domain_hash, $path_hash, $get_type.'4', 0);
				return 'no';
			}	
			$data_id = $info[$id_name];
			add_search_index($domain_hash, $path_hash, $get_type.'4', $data_id);
		}else{
			return 'no';
		}
		
	}else{//有索引
		$index_id_arr = array_filter($index_id_arr);
		$info = DB::fetch_first("SELECT * FROM ".DB::table($table_name)." WHERE $id_name IN (".dimplode($index_id_arr).") AND  $locate_sql ");
		if(!$info) {
			add_search_index($domain_hash, $path_hash, $get_type.'4', 0);
			return 'no';
		}
	}
	if($show == 1){
		return json_encode($info);
	}else{
		return $info;
	}
	
}


function add_search_index($domain_hash, $path_hash, $get_type, $data_id){
	global $_G;
	if($get_type == 3 && !$data_id) return;//学习规则不需要
	$check = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_searchindex')." WHERE  domain_hash='$domain_hash' AND path_hash='$path_hash' AND type='$get_type' AND rid='$data_id'"), 0);
	if($check) return;

	$setarr = array('domain_hash' => $domain_hash, 'path_hash' => $path_hash, 'type' => $get_type, 'rid' => $data_id, 'dateline' => $_G['timestamp']);//1是单帖 2是内置规则 3学习到的规则
		
	$setarr	= paddslashes($setarr);
	DB::insert('strayer_searchindex', $setarr, TRUE);//添加索引
}

//转换 <img file="http://bbs.942dn.com/static/image/common/back.gif" onload="thumbImg(this)" alt="" />
function img_htmlbbcode($text, $url = ''){
	$text = dstripslashes($text);
	$pregfind = array(
		'/<img[^>]*file="([^>]+)"[^>]*>/eiU',
		'/<img[^>]*picsrc="([^>]+)"[^>]*>/eiU',
	);
	$pregreplace = array(
		"img_tag('\\1', '".$url."')",
		"img_tag('\\1', '".$url."')",
	);
	return preg_replace($pregfind, $pregreplace, $text);
}



function img_tag($attributes, $page_url) {
	global $_G;
	$evo_img_no = $_G['cache']['evn_milu_pick']['evo_img_no'];
	$attributes = dstripslashes($attributes);
	if(!preg_match("/^http:\/\//i", $file)) {
		$no_remote = 0;
		if(!filter_something($attributes, $evo_img_no)){//存在
			$no_remote = 1;
		}
		$no_remote = $no_remote == 1 && file_exists(DISCUZ_ROOT.'/'.$attributes) ? 1 : 0;//看看本地是否有这个文件
		$file = $no_remote == 1 ? $attributes : _expandlinks($attributes, $page_url);
	}
	return $file ? ($width && $height ? '[img='.$width.','.$height.']'.$file.'[/img]' : '[img]'.$file.'[/img]') : '';
}




//转换某些特殊字符
function format_html($str){
	if(!$str) return;
	$format_str = milu_lang('format_str');
	$format_arr = explode('@', $format_str);
	$format_arr = explode('@', $format_str);
	foreach((array)$format_arr as $k => $v){
		$v_arr = explode('|', $v);
		$strfind[] = $v_arr[0];
		$strreplace[] = $v_arr[1];
	}
	$str = str_replace($strfind, $strreplace, $str);
	$str = str_replace('&nbsp;', ' ', $str);
	if(function_exists('mb_convert_encoding')){
		foreach(get_html_translation_table(HTML_ENTITIES) as $k=>$v) {
			$str = str_replace($v, mb_convert_encoding($v, CHARSET, "HTML-ENTITIES"), $str);
		}
	}
	return $str;
}




//视频标签的过滤
function media_htmlbbcode($text, $url= '', $type = 'bbs'){
	if(!$text) return;
	$text = dstripslashes($text);
	$pregfind = array(
		"/<embed([^>]*src[^>]*)>/eiU",
		"/<embed([^>]*src[^>]*)*\"><\/embed>/eiU",
	);
	$pregreplace = array(
		"mediatag('\\1', '".$url."', ".$type.")",
		"mediatag('\\1', '".$url."', ".$type.")",
	);
	return preg_replace($pregfind, $pregreplace, $text);
}


function audio_htmlbbcode($text, $url = '', $type = 'bbs'){
	preg_match_all("/\<object(.*)?>(.*)?<\/object>/i", $text , $attach_arr, PREG_SET_ORDER);
	if(!$attach_arr) return $text;
	$search_arr = $replace_arr = array();
	foreach($attach_arr as $k => $v){
		if(strexists($v[0], '[/flash]')) continue;
		$search_arr[] = $v[0];
		$replace_arr[] = get_audio_param($v[1], $url, $type);
	}
	$text = str_replace($search_arr, $replace_arr, $text);
	return $text;
}

function get_audio_param($attributes, $page_url, $type = 'bbs') {
	if(!$attributes) return;
	preg_match_all('/<param\sname="url"\svalue="(.*?)"/is', stripslashes($attributes), $matches, PREG_SET_ORDER);
	if(is_array($matches[0])) {
		$audio_url = _expandlinks($matches[0][1], $page_url);
	}
	return $type == 'bbs' ? '[audio]'.$audio_url.'[/audio]' : '[flash=mp3]'.$audio_url.'[/flash]';

}


function get_trun_data($turn_type = '', $turn_id = ''){
	$turn_id = $turn_id ? $turn_id : intval($_GET['turn_id']);
	$turn_type = $turn_type ? $turn_type : $_GET['turn_type'];
	if(!$turn_type && !$turn_id) return FALSE;
	if($turn_type == 'evo' || $turn_type == 'fastpick'){
		if(!function_exists('fastpick_info'))  pload('F:fastpick');
		return fastpick_info($turn_id, '*', $turn_type);
	}else if($turn_type == 'system'){
		if(!function_exists('get_rules_info'))  pload('F:rules');
		return get_rules_info($turn_id);
	}else{
		if(!function_exists('get_pick_info'))  pload('F:pick');
		$info = get_pick_info($turn_id);
		if($info['rules_type'] != 1) return $info;
		return get_trun_data('system', $info['rid']);//内置规则
	}
}

	

if(!function_exists('dunserialize')){//这个函数是DZ2.5新加入的
	function dunserialize($data) {
		if(($ret = unserialize($data)) === false) {
			$ret = unserialize(stripslashes($data));
		}
		return $ret;
	}
}

function get_htmldom_obj($str){
	if(!$str) return $str;
	require_once(PICK_DIR.'/lib/simple_html_dom.php');
	$html = str_get_html($str, true, true, DEFAULT_TARGET_CHARSET, FALSE);
	if(!$html) return false;
	return $html;
}

function get_snoopy_obj($args = array()){
	extract($args);
	require_once(PICK_DIR.'/lib/Snoopy.class.php');
	$snoopy = new Snoopy;  
	$snoopy->maxredirs = 3;
	$snoopy->expandlinks = TRUE;
	$snoopy->offsiteok = TRUE;//是否允许向别的域名重定向
	$snoopy->agent = $_SERVER['HTTP_USER_AGENT'];
	/*
	$snoopy->referer = $referer;   
	//有些图片设置了这个反而采集不到比如：http://img1.gxcity.com/forum/201107/14/135857bbq214kkgbabz42m.jpg
	*/

	$snoopy->rawheaders["COOKIE"]= $cookie;
	return $snoopy;
}

//清除缓存
function clear_pick_cache($del = 0){
	pload('C:cache');
	$pick_clear_cache = pick_common_get('', 'pick_clear_cache');
	if( (TIMESTAMP - $pick_clear_cache) < 3600*24 && $del == 0) return;
	$cache_info = IO::info(PICK_CACHE);
	if($cache_info['size'] > PICK_CACHE_SIZE*1024*1024){
		IO::rm(PICK_CACHE);
	}
	pick_common_set(array('pick_clear_cache' => TIMESTAMP));
}	

//定期清除索引
function clear_search_index($del = 0){
	global $_G;
	$clear_search_index = pick_common_get('', 'clear_search_index');
	if( (TIMESTAMP - $clear_search_index) < 3600*24*7 && $del == 0) return;
	DB::query('DELETE FROM '.DB::table('strayer_searchindex')." WHERE dateline<'$time' AND rid=0");
	pick_common_set(array('clear_search_index' => TIMESTAMP));
}

// $type  1是单帖 2是内置规则 3学习到的规则
function del_search_index($type = 0, $rid = 0){
	$sql = $type ? " AND (type='$type' OR type='".$type."4') " : '';
	return DB::query('DELETE FROM '.DB::table('strayer_searchindex')." WHERE rid='$rid' $sql ");
}

//定期清除一周之前的日志
function clear_log($del = 0){
	pload('C:cache');
	$clear_log = pick_common_get('', 'clear_log');
	if( (TIMESTAMP - $clear_log) < 3600*24*2 && $del == 0) return;
	$log_info = IO::info(PICK_DIR.'/data/log');
	$file_list = $log_info['ls'];
	if(!$file_list) return;
	foreach($file_list as $k => $v){
		if(TIMESTAMP - $v['change'] > 3600*24*3) @unlink($v['location']);
	}
	pick_common_set(array('clear_log' => TIMESTAMP));
}

function jammer_replace($str, $flag = 0){
	if(!$str ) return $str;
	return $flag !=1  ? preg_replace(array('/{/s', '/}/s', '/@@/s', '/\"s/s'), array('MM56NN','MM78NN', 'FF45DD', '" s'), $str) : preg_replace(array('/MM56NN/s', '/MM78NN/s', '/FF45DD/s', '/" s/s'), array('{','}','@@', '"s'), $str);//符号干扰正则
}


function get_domain($url){
	if(empty($url)) return;
	$d = RootDomain::instace();
	$d->setUrl($url);
	return $d->getDomain();
}

if (!function_exists('json_decode')){
	function json_decode($s, $ass = false){
		require_once(PICK_DIR.'/lib/servicesJSON.class.php');
		$assoc = ($ass) ? 16 : 32;
		$gloJSON = new servicesJSON($assoc);
		return $gloJSON->decode($s);
	}
}
if (!function_exists('json_encode')){
	function json_encode($s){
		require_once(PICK_DIR.'/lib/servicesJSON.class.php');
		$gloJSON = new servicesJSON(16);
		return $gloJSON->encode($s);
	}
}


?>
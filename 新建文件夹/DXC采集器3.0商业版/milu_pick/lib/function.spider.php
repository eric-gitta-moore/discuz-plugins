<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

//网页正文提取
function get_single_article($content, $url, $args = array()){
	global $_G;
	extract($args);
	if(strlen(trim($content)) < 1) return;
	d_s('evo');
	$get_type = $_GET['get_type'] ? intval($_GET['get_type']) : $get_type;
	$get_type = $get_type ? $get_type : 1;
	$milu_set = pick_common_get();
	$rules_info = match_rules($url, $content, $get_type, 0);
	if(is_array($rules_info)){
		pload('F:fastpick');
		$data = rules_get_article($content, $rules_info);
		write_evo_errlog($data, $url, $rules_info);
	}else{
		$data = (array)cloud_match_rules($get_type, $url, $content); //从云端下载规则 这里应该做点优化，暂时没想到方法。
		if(!$data['content'] && $milu_set['fp_open_auto'] == 1){//开启智能获取
			pload('C:HtmlExtractor');
			pload('F:article');
			$he = new HtmlExtractor($content, $url);
			$data = (array)$he->get_text();
			$data['content'] = dz_attach_format($url, $data['content']);
			$arr = format_article_imgurl($url, $data['content']);
			$data['content'] = $arr['message'];
			$del_dom_rules = array('div[id*=share]', 'div[class*=page]');
			foreach($del_dom_rules as $k => $v){
				$data['content'] = dom_filter_something($data['content'], $v, 2);
			}
			unset($data['evo_title_info']);
		}
	}
	if($_GET['type'] == 'bbs') {
		$data['content'] = media_htmlbbcode($data['content'], $url);
		$data['content'] = img_htmlbbcode($data['content'], $url);
	}
	$data['evo_time'] = d_e(0, 'evo');
	return $data;
}


//视频标签的过滤
function media_format($text, $url = ''){
	$pregfind = array(
		"/<script type=\"text\/javascript\".+'width',\s+'(\d+)',\s+'height',\s+'(\d+)'.+'src',\s+'([^\']+)'.+<\/script>/eiU",
		'/<script language="JavaScript">player\(\'player_\'\+\d+,\'(.*)\'.+<\/script>/eiU',
	);
	
	$pregreplace = array(
		"mediatag_format('\\3','\\1','\\2', '".$url."')",
		"mediatag_format('\\1', '".$url."')",
	);
	return $text = preg_replace($pregfind, $pregreplace, $text);
	return clear_ad_html($text);
}




function mediatag_format($src, $width = 0, $height = 0, $page_url = '') {
	if(!preg_match("/^http:\/\//i", $src)) {
		$src = _expandlinks($src, $page_url);
	}
	return '[flash]'.$src.'[/flash]';//门户和博客压根就不需要长宽这些，照样能播放视频
	$ext = strtolower(substr(strrchr($src, '.'), 1, 10));
	if($ext == 'swf'){
		return $src ? ($width && $height ? '[flash='.$width.','.$height.']'.$src.'[/flash]' : '[flash]'.$src.'[/flash]') : '';
	}else{
		return $src ? '[media='.$ext.','.$width.','.$height.']'.$src.'[/media]' : '';
	}
}


function mediatag($attributes, $page_url, $type = 'bbs') {
	$value = array('src' => '', 'width' => '', 'height' => '', 'flashvars' => '');
	preg_match_all('/(src|width|flashvars|height)=(["\'])?([^\'" ]*)(?(2)\2)/i', dstripslashes($attributes), $matches);
	if(is_array($matches[1])) {
		foreach($matches[1] as $key => $attribute) {
			$value[strtolower($attribute)] = $matches[3][$key];
		}
	}
	@extract($value);
	if($flashvars)  {
		parse_str($flashvars);
		$flash_src = $file;	
	}	
	if(!preg_match("/^http:\/\//i", $src)) {
		$src = _expandlinks($src, $page_url);
	}
	if(!preg_match("/^http:\/\//i", $flash_src) && $flash_src) {
		$flash_src = _expandlinks($flash_src, $page_url);
	}
	$src_info = parse_url($src);
	$ext = strtolower(substr(strrchr($src_info['path'], '.'), 1, 10));
	if(strexists($ext, '&')){
		$ext = current(explode('&', $ext));
	}
	if(strexists($ext, '?')){
		$ext = current(explode('?', $ext));
	}
	if($ext == 'swf'){
		$src = $flash_src ? $flash_src : $src;
		return $src ? ($width && $height && $type == 'bbs' ? '[flash='.$width.','.$height.']'.$src.'[/flash]' : '[flash]'.$src.'[/flash]') : '';
	}else{
		$file_ext = addslashes(strtolower(substr(strrchr($src, '.'), 1, 10)));
		if($type != 'bbs'){
			//if($file_ext == 'wmv'){
				$media_type = 'media';
			//}
			return $src ? '[flash='.$media_type.']'.$src.'[/flash]' : '';
		}
		$file_ext = $file_ext ? $file_ext : 'x';
		return $src ? '[media='.$file_ext.','.$width.','.$height.']'.$src.'[/media]' : '';
	}
}





//可以下载防盗链图片

function get_img_content($img_url, $snoopy_obj = '', $ext = ''){
	$pick_config = get_pick_set();
	if(!function_exists('fsockopen') && !function_exists('pfsockopen') || !$snoopy_obj){
		$content = dfsockopen($img_url);
	}else{
		if($pick_config['is_set_referer'] == 1) {
			$snoopy_obj->referer = $img_url; 
		}
		//有些图片设置了这个反而采集不到比如：http://img1.gxcity.com/forum/201107/14/135857bbq214kkgbabz42m.jpg
		//有些必须设置这个 http://abbs.cn/pic/2012/03/08/1331168643.jpg  					//http://www.biketo.com/d/file/news/bikenews/2012-09-05/d8ca0bad794a799354fdad835742783f.jpg
		$snoopy_obj->fetch($img_url);
		$content = $snoopy_obj->results;
		$headers = $snoopy_obj->headers;
		if($snoopy_obj->status == '403'){
			$snoopy_obj->referer = ''; 
			$snoopy_obj->fetch($img_url);
			$content = $snoopy_obj->results;
			$headers = $snoopy_obj->headers;
		}
		if($snoopy_obj->status == '404' || $snoopy_obj->status == '403'){
			return FALSE;
		}
		foreach($headers as $v){
			$v_arr = explode(':', $v);
			if($v_arr[1]) $header_arr[strtolower($v_arr[0])] = trim($v_arr[1]);
		}
		
		pload('F:http');
		$info['size'] = $header_arr['content-length'];
		$url_info = parse_url($img_url);
		$query_url = $url_info['query'] ? $url_info['query'] : $url_info['path'];
		$info['file_ext'] = addslashes(strtolower(substr(strrchr($query_url, '.'), 1, 10)));
		if($header_arr['content-disposition']){
			$c_d = $header_arr['content-disposition'];
			$info_arr = explode(';', $c_d);
			$file_arr = explode('=', $info_arr[1]);
			$arr[2] = preg_replace('(\'|\")', '', $file_arr[1]);//去掉引号
			$file_name = $info['file_name'] = str_iconv($arr[2]);
			$info['file_ext'] = $info['file_ext'] ? $info['file_ext'] : addslashes(strtolower(substr(strrchr($file_name, '.'), 1, 10)));
			$info['content'] = $content;
			return $info;
		}else{
			if(!$info['file_ext']){
				$content_type = array_flip(GetContentType());
				$header_arr['content-type'] = str_replace(';', '', $header_arr['content-type']);
				$info['file_ext'] = $content_type[$header_arr['content-type']];
			}
		}
		if($info['file_ext']){
			$patharr = explode('/', $img_url);
			$info['file_name'] =  trim($patharr[count($patharr)-1]);
			if(strexists($info['file_name'], 'forum.php?mod=attachment')) $info['file_name'] = $info['file_ext'] = '';
		}
		$info['content'] = $content;
		if($ext == 'no_get') return $info;
	}
	return $content;
}


function get_rss_obj(){
	require_once(PICK_DIR.'/lib/lastRSS.class.php');
	$set = get_pick_set();
	$cache_time = 0;
	$rss = new lastRSS;
	$rss->cache_dir = PICK_CACHE.'/rss/';//设置缓存目录
	if(!is_dir($rss->cache_dir)) dmkdir($rss->cache_dir);
	$rss->cache_time = $set['cache_time'] * 60;
	$rss->default_cp = 'GB2312';//目标字符编码，默认为UTF-8
	$rss->cp = CHARSET;//自己的编码
	$rss->items_limit = 0;//设置输出数量，默认为10
	$rss->date_format = 'U'; //设置时间格式。默认为字符串；U为时间戳，可以用date设置格式
	$rss->stripHTML = FALSE; //设置过滤html脚本。默认为false，即不过滤<br>
	$rss->CDATA = 'content'; //设置处理CDATA信息。默认为nochange。另有strip和content两个选项
	return $rss; //输出
}



//dom获取多个内容段
function dom_get_manytext($content, $dom_rules, $filter_type = 'reply', $count = 0){
	if(!$content || !$dom_rules) return;
	$content = jammer_replace($content);
	$html = get_htmldom_obj($content);
	$count = intval($count);
	if(!$html) return false;
	foreach($html->find($dom_rules) as $k => $v) {
		$v->innertext = jammer_replace($v->innertext, 1);
		$text_arr[] = $v->innertext;
		if($count > 0 &&  ($k == $count - 1 )) break;
	}
	if($filter_type == 'reply') unset($text_arr[0]);
	$html->clear();
	unset($html);
	return $text_arr;
	
}
//利用dom剔除某个内容
function dom_filter_something($str, $dom_rules,$test_flag = 1){
	if(!$str || !$dom_rules) return $str;
	$str = jammer_replace($str);//符号干扰正则
	$html = get_htmldom_obj($str);
	if(!$html) return false;
	foreach($html->find($dom_rules) as $v) {
		$dom_get_str = $v->outertext;
		$a[] = $dom_get_str;
		if($dom_get_str) {
			if($test_flag == 1){
				$replace_rules = $dom_get_str.'@@<del>'.$dom_get_str.'</del>';
			}else{
				$replace_rules = $dom_get_str.'@@';
			}
			$str = replace_something($str, array($replace_rules));
		}
	}
	$html->clear();
	unset($html);
	$str = jammer_replace($str, 1);
	return $str;
	
}

//利用字符剔除某个内容
function str_filter_something($str, $rule, $get_str = '(*)',$test_flag = 1){
	if(!$str || !$rule) return $str;
	$content_arr = pregmessage($str, $rule, 1, -1, 'out');
	if(!$content_arr[0]) $content_arr = pregmessage($str, $rule, 1, 1, 'out');
	if(!$content_arr[0]) return $str;
	foreach($content_arr as $v){
		if($v){
			if($test_flag == 1){
				$replace_rules = $v.'@@<del>'.$v.'</del>';
			}else{
				$replace_rules = $v.'@@';
			}
			$str = replace_something($str, array($replace_rules));
		}
	}
	//exit();
	return $str;
}

//通过字符串获取列表中文章链接
function string_page_link($content, $rule, $url){
	$rule = trim($rule);
	$link_content = pregmessage($content, $rule, 'link',-1);
	if($link_content[0]){
		$arr = $link_content;
	}else{
		$link_content = pregmessage($content, $rule, 'link');
		$arr = _striplinks($link_content[0]);
		
	}
	$base_url  = get_base_url($content);
	$url = $base_url ? $base_url : $url;
	if(is_array($arr)){
		foreach($arr as $k => $v){
			$re_arr[$k] = _expandlinks($v, $url);
		}
	}
	return sarray_unique($re_arr);	
}



//将文章中图片的相对路径转换为绝对路径
function format_article_imgurl($url, $message){
	global $_G;

	$evo_img = $_G['cache']['evn_milu_pick']['evo_img'];
	$evo_img_no = $_G['cache']['evn_milu_pick']['evo_img_no'];
	//图片获取
	$base_url  = get_base_url($message);
	$url = $base_url ? $base_url : $url;
	$search_arr = array_keys($evo_img);
	$message = dstripslashes($message);
	preg_match_all("/\<img.+src=('|\"|)?(.*)(\\1)(.*)?\>/isU", $message, $image1, PREG_SET_ORDER);
	preg_match_all("/\<img.+file=('|\"|)?(.*)(\\1)(.*)?\>/isU", $message, $image2, PREG_SET_ORDER);
	preg_match_all("/\<embed.+src=('|\"|)?(.*)(\\1)(.*)?\>/isU", $message, $image3, PREG_SET_ORDER);//视频标签
	$temp =  array();
	if(is_array($image1) && !empty($image1)) {
		foreach($image1 as $value) {
			if(substr_count($value[0], '<img') > 1) continue;
			$temp[] = array(
				'0' => $value[0],
				'1' => trim($value[2])
			);
		}
	}
	if(is_array($image2) && !empty($image2)) {
		foreach($image2 as $v) {
			$temp[] = array(
				'0' => $v[0],
				'1' => trim(strip_tags($v[2]))
			);
			$file_img[] = md5($v[0]);
		}
	}
	$file_count = 0;
	if(is_array($image3) && !empty($image3)) {
		foreach($image3 as $v) {
			$file_count++;
			$temp[] = array(
				'0' => $v[0],
				'1' => trim(strip_tags($v[2]))
			);
		}
	}
	if(is_array($temp) && !empty($temp)) {
		foreach($temp as $key => $value) {
			$value_old[1] = $value[1];
			foreach($search_arr as $v){
				if(!filter_something($value[0], array($v))){
					$get_attr = $evo_img[$v];
					if($get_attr == 'file') $file_img[] = md5($value[0]);
					preg_match_all("/\<img.+".$get_attr."=('|\"|)?(.*)(\\1)(.*)?\>/isU", $value[0], $img_arr, PREG_SET_ORDER);
					$value[1] = $img_arr[0][2];
				}
			}
			$search[$key] = $value[0];
			$no_remote = 0;
			if(!filter_something($value[1], $evo_img_no)){//存在
				$no_remote = 1;
			}
			$no_remote = $no_remote == 1 && file_exists(DISCUZ_ROOT.'/'.$value[1]) ? 1 : 0;//看看本地是否有这个文件
			$replace_url = $no_remote == 1 ? $value[1] : _expandlinks($value[1], $url);
			$replace[$key] = str_replace($value_old[1], $replace_url, $value[0]);
			
			if(in_array(md5($value[0]), $file_img)) {
				$r_str = strexists($replace[$key], 'src=') ? 'pold=' : 'src=';
				$replace[$key] = str_replace('file=', $r_str, $replace[$key]);
			}
		}
	}
	
	$message = str_replace($search, $replace, $message);
	$arr['message'] = $message;
	$arr['pic'] = count($search) - 1;
	if($arr['pic'] < 0)  $arr['pic'] = 0;
	return $arr;
}


//通过dom方式获取列表中的文章链接
function dom_page_link($content, $arr ='', $type = 0){
	$rule_arr = format_wrap($arr['page_link_rules']); 
	$a = $rule_arr[1] ? $rule_arr[1] : 'a';
	$html = get_htmldom_obj($content);
	if(!$html) return FALSE;
	$base_url  = get_base_url($content);
	$url = $base_url ? $base_url : $arr['url'];
	foreach($html->find($rule_arr[0]) as $v) {
		if($a != 'img'){
			$a_url = $type == 0 ? $v->find($a, 0)->attr['href'] : $v->attr['href'];
		}else{
			$a_url = $type == 0 ? $v->find($a, 0)->attr['src'] : $v->attr['src'];
		}
		if(!$a_url || $a_url == '#' || $v->innertext == '上一页') continue; 
		$item[] = _expandlinks($a_url, $url);
	}
	$item = sarray_unique($item);//去重复
	$html->clear();
	unset($html);
	return $item;
}
function get_page_link($url){
	$snoopy = new Snoopy;
	$snoopy->fetchlinks($url) ;
	$all_link = $snoopy->results;
	$re = is_array($all_link) ? array_unique($all_link) : $all_link;
	return $re;
}

//通过dom方式获取一篇文章的信息
function dom_single_article($content = '',$dom_arr = ''){
	$content = jammer_replace($content);
	if(!$content) return ;
	$html = get_htmldom_obj($content);
	if(!$html) return false;
	if($dom_arr['title']){
		$div2 = $html->find('title');
		$re['other']['old_title'] = str_iconv($div2[0]->innertext);
		$re['title'] = dom_get_str($html, $dom_arr['title']);
		$re['other']['old_title'] = jammer_replace($re['other']['old_title'], 1);
		$re['title'] = jammer_replace($re['title'], 1);
		unset($div2);
	}
	$re['content'] = dom_get_str($html, $dom_arr['content']);
	$re['content'] = jammer_replace($re['content'], 1);
	$re['content'] = clear_ad_html($re['content']);
	$html->clear();
	unset($html);
	return $re;
}


//dom取某个区域
function dom_get_str($html, $rules){
	if(!$html) return false;
	$rules = str_replace(array('\{', '\}'), array('{UUU', 'UUU}'), $rules);
	$c_arr = $r = $text_arr = array();
	if(strexists($rules, '{') && strexists($rules, '}')){
		preg_match_all("/\{(.*)?}/isU", $rules , $c_arr, PREG_SET_ORDER);
		foreach($c_arr as $k => $v){
			$r['search'][] = $v[0];
			$c_dom_arr[] = $v[1];
		}
	}else{
		$c_dom_arr = format_wrap($rules);
	}
	if($c_dom_arr){
		foreach($c_dom_arr as $k => $v){
			preg_match_all('/\w+\[[^]]+]|[^\s]+/', $v, $v_s_arr);
			$v_arr = $v_s_arr[0];
			$i = 0;
			$all = count($v_arr);
			
			$html_obj = $html;
			do{
				$v_rules = $v_arr[$i];
				if(!$v_rules) break;
				if(strexists($v_rules, '[*]')){
					$index = -1;
					$v_rules = str_replace('[*]', '', $v_rules);
				}else{
					preg_match("/\[(\d)?]/is", $v_rules, $index_arr);
					$index = $index_arr[1] ? $index_arr[1] : 0;				
					$v_rules = $index_arr[0] ? str_replace($index_arr[0], '', $v_rules) : $v_rules;
				}
				
				if($html_obj){
					foreach($html_obj->find($v_rules) as $index_i => $child) {
						if($index == -1){
							$text_arr[] = $child->innertext;
						}else{
							if($index_i == $index ) {
								if($i == ($all-1)){
									$text_arr[] = $child->innertext;
									unset($html_obj);
								}else{
									$html_obj = $child;
								}
								
								break;
							}
						}
					}
				}
				//$html_obj = $child;
				$i++;
			}while($v_rules);
		}	
		unset($div);
	}
	$rules = str_replace(array('{UUU', 'UUU}'), array('{', '}'), $rules);
	if($r['search']) {
		$r['replace'] = $text_arr;
		$text = str_replace($r['search'], $r['replace'], $rules);
	}else{
		$text = implode('', $text_arr);
	}
	return $text;	
}

//字符串截取
function str_get_str($content, $rules, $get_flag, $limit = 1){
	$c_arr = $r = $text_arr = array();
	$rules = str_replace(array('\{', '\}'), array('{UUU', 'UUU}'), $rules);
	if(strexists($rules, '{') && strexists($rules, '}')){
		preg_match_all("/\{(.*)?}/isU", $rules , $c_arr, PREG_SET_ORDER);
		foreach($c_arr as $k => $v){
			$r['search'][] = $v[0];
			$c_dom_arr[] = $v[1];
		}
	}else{
		$c_dom_arr = array($rules);
	}
	foreach($c_dom_arr as $k => $v){
		$arr = pregmessage($content, $v, $get_flag, $limit);
		if($get_flag == 'reply') return $arr;
		$text_arr[] = $arr ? $arr[0] : '';
	}
	$rules = str_replace(array('{UUU', 'UUU}'), array('{', '}'), $rules);
	if($r['search']) {
		$r['replace'] = $text_arr;
		$text = str_replace($r['search'], $r['replace'], $rules);
	}else{
		$text = implode('', $text_arr);
	}
	return $text;	
}




function rules_get_article($content,$rules_info){
	$url = $_GET['url'];
	$rules_info = pstripslashes($rules_info);
	$rules_info['title_filter_rules'] = dstripslashes(unserialize($rules_info['title_filter_rules']));
	$rules_info['content_filter_rules'] = dstripslashes(unserialize($rules_info['content_filter_rules']));
	require_once libfile('function/home');
	//先取标题
	if($rules_info['theme_get_type'] == 3){//智能识别
		$data = get_single_article($content);
	}else if($rules_info['theme_get_type'] == 1){//dom获取
		$data = dom_single_article($content, array('title' => $rules_info['theme_rules']));
	}else if($rules_info['theme_get_type'] == 2){//字符串
		$re = pregmessage($content, '<title>[title]</title>', 'title', -1);
		$data['other']['old_title'] = $re[0];
		$re = pregmessage($content, $rules_info['theme_rules'], 'title', -1);
		$data['title'] = $re[0];
	}
	if(!trim($data['title'])) return $data;//如果标题都取不到，不必浪费时间获取内容
	

	$data['content'] = rules_get_contents($content, $rules_info);
	
	if($rules_info['content_page_rules'] && $data['content']){//分页文章
		$content_page_arr = get_content_page($url, $content, $rules_info);
		if($content_page_arr){
			$args = array('oldurl' => array(), 'content_arr' => array(), 'content_page_arr' => $content_page_arr, 'page_hash' => array(), 'rules' => $rules_info, 'url' => $url);
			$data['content_arr'] = page_get_content($content, $args);
			foreach((array)$data['content_arr'] as $k => $v){
				$content_arr[] = $v['content'];
			}
			$data['content'] = implode('', $content_arr);
			
		}	
		
	}
	
	$data['title'] = unhtmlentities(strip_tags($data['title'], '&nbsp;'));
	$data['content'] = unhtmlentities($data['content']);
	$data['title'] = getstr(trim($data['title']), 80, 1, 1, 0, 1);
	$data['content'] = getstr($data['content'], 0, 1, 1, 0, 1);
	//print_r($data);
	//处理文章标题和内容，包括替换和过滤
	$format_args_title = array(
		'is_fiter' => $rules_info['is_fiter_title'],
		'show_type' => 'title',
		'test' => 2,
		'result_data' => $data['title'],
		'replace_rules' => $rules_info['title_replace_rules'],
		'filter_data' => $rules_info['title_filter_rules'],
	);
	$data['title'] = filter_article($format_args_title);
	
	$data['content'] = dstripslashes($data['content']);
	
	
	
	$format_args_content = array(
		'is_fiter' => $rules_info['is_fiter_content'],
		'show_type' => 'title',
		'test' => 2,
		'filter_html' => dunserialize($rules_info['content_filter_html']),
		'result_data' => $data['content'],
		'replace_rules' => $rules_info['content_replace_rules'],
		'filter_data' => $rules_info['content_filter_rules'],
	);
	$data['content'] = filter_article($format_args_content);
	
	//$data['content'] = dz_attach_format($url, $data['content']);
	$format_arr = format_article_imgurl($url, $data['content']);
	$data['content'] = $format_arr['message'];
	//$data['content'] = media_htmlbbcode($data['content'], $url);
	
	unset($data['other']);
	return $data;
}


function rules_get_contents($content, $rules){
	//再取内容
	if($rules['content_get_type'] == 3){//智能识别
		if($rules['theme_get_type'] != 3){
			$info_arr = get_single_article($content);
			return $info_arr['content'];
		}
	}else if($rules['content_get_type'] == 1){//dom获取
		$info_arr = dom_single_article($content, array('content' => $rules['content_rules']));
		return $info_arr['content'];
	}else if($rules['content_get_type'] == 2){//字符串
		return str_get_str($content, $rules['content_rules'], 'body', -1);
	}
	return FALSE;
}

//取得分页内容
function page_get_content($content, $args = array() ){
	extract($args);
	if(!$content_arr) {
		$page_hash[] = md5($content);
		$re_info['content'] = rules_get_contents($content, $rules);
		$re_info['page_url'] = $url;
		$re_info['page'] = 1;
		if(!$re_info){
			unset($content_arr);
			return FALSE;
		}
		if(intval($re_info) != -1) $content_arr[md5($url)] = $re_info;
	}
	foreach((array)$content_page_arr as $k => $v){
		if($v == '#' || !$v || $v == $url || in_array($v, $oldurl)) continue;
		$url_parse_arr = parse_url(strtolower($v));
		parse_str($url_parse_arr['query'], $page_temp_arr);
		if($page_temp_arr['page'] == 1) continue;
		$content = get_contents($v, array('cookie' => $rules['login_cookie']));
		$hash = md5($content);
		if(in_array($hash, $page_hash)) continue;
		$oldurl[] = $v;
		$page_hash[] = $hash;
		$num = count($content_arr) + 1;
		$re_info['content'] = rules_get_contents($content, $rules);
		$re_info['page_url'] = $v;
		$re_info['page'] = $num;
		$content_arr[md5($v)] = $re_info;
		
		if($rules['content_page_get_mode'] != 1){//全部列出模式
			$content_page_arr = get_content_page($v, $content, $rules);
			$args = array('oldurl' => $oldurl, 'content_arr' => $content_arr, 'content_page_arr' => $content_page_arr, 'page_hash' => $page_hash, 'rules' => $rules_info, 'url' => $url);
			return page_get_content($content, $args);
		}			
	}
	return $content_arr;
}


//获取分页url列表
function get_content_page($url, $content, $rules){
	$base_url  = get_base_url($content);
	$base_url = $base_url ? $base_url : $url;
	if($rules['content_page_get_type'] == 1){
		$html = get_htmldom_obj($content);
		if(!$html) return false;
		foreach($html->find($rules['content_page_rules']) as $v) {
			$a_url = convert_url($v->attr['href']);
			if(!$a_url || $a_url == '#' || $v->innertext == milu_lang('up_page')) continue; 
			$item[] = _expandlinks($a_url, $base_url);
			$re_arr = sarray_unique($item);
			
		}
		$html->clear();
		unset($html);
	}else{
		$re_arr = string_page_link($content, $rules['content_page_rules'], $url);//字符串
	}
	return $re_arr;
}

// get_type 1是单帖 2是内置规则 3学习到的规则

//服务端搜索规则
function cloud_match_rules($get_type, $url, $content){
	global $_G;
	pload('F:fastpick');
	$setting = get_pick_set();
	$pick_config = $_G['cache']['evn_milu_pick']['pick_config'];
	$server_cache_time = $pick_config['index_server_cache_time'];
	if($get_type == '3'){//智能学习规则索引过期时间比较短
		$server_cache_time = $pick_config['evo_index_server_cache_time'];
	}
	$milu_set = pick_common_get();
	if($setting['open_cloud_pick'] != 1 ) return FALSE;
	pload('F:copyright');
	$host_info = GetHostInfo($url);
	$domain = $host_info['host'];
	$domain_hash = md5($domain);
	$url_temp = preg_replace('/\d+/', '', $url);
	$arr_temp = parse_url($url_temp);
	$path_hash = md5($arr_temp['path']);
	$over_dateline = $_G['timestamp'] - $server_cache_time;
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_searchindex')." WHERE  domain_hash='".$domain_hash."' AND path_hash='".$path_hash."' AND type='".$get_type."3' AND dateline > $over_dateline"), 0);//3是服务端 4是本地的缓存
	if($count) return FALSE;
	$args = array(
		'get_type' => $get_type,
		'url' => $url,
		//'content' => $content,//改成服务端自己取内容
	);
	$rpcClient = rpcClient();
	$client_info = get_client_info();
	$re = $rpcClient->cloud_match_rules($args, $client_info);
	if(is_object($re) || $re->Number == 0){
		if($re->Message) return  milu_lang('phprpc_error', array('msg' => $re->Message));
		$re = (array)$re;
	}
	$data = array();
	if($re['data_type'] == 1){//返回规则
		$rules_info = $re['data'];
		if($get_type == 3){
			$data = evo_rules_get_article($content, $rules_info);
		}else{
			$data = rules_get_article($content, $rules_info);
		}
		if($data || ($data['content'] && $get_type == 3)){//规则验证有效，下载到本地
			if($get_type == 3){
				$data_id = import_evo_data($rules_info);
			}else{
				$data_id = import_fastpick_data($rules_info);
			}
			if($data_id) {
				//先清除之前的索引
				DB::query('DELETE FROM '.DB::table('strayer_searchindex')." WHERE domain_hash='".$domain_hash."' AND path_hash='".$path_hash."'");
				add_search_index($domain_hash, $path_hash, $get_type.'4', $data_id);//添加索引
			}	
		}
		
	}else if($re['data_type'] == 2){//返回内容
		$data = $re['data'];
		
	}else{//一无所获,那也要告诉客户端，别再骚扰服务端了
		add_search_index($domain_hash, $path_hash, $get_type.'3', 0);
	}
	return $data;
}

function evo_rules_get_article($str, $rules_info){
	$rules_info['theme_get_type'] = $rules_info['theme_get_type'] ? $rules_info['theme_get_type'] : 1;
	$get = 0;
	if($rules_info['theme_get_type'] == 1 && $rules_info['content_get_type'] == 1){
		$re = dom_single_article($str, array('title' => $rules_info['theme_rules'], 'content' => $rules_info['content_rules']));
		$data['title'] = $re['title'];
		$data['content'] = $re['content'];
		$get = 1;
	}
	if($get != 1){
		if($rules_info['theme_get_type'] == 1){
			$re = dom_single_article($str, array('content' => $rules_info['content_rules']));
			$data['title'] = $re['title'];
		}else if($rules_info['theme_get_type'] == 2){
			$re = pregmessage($str, $rules_info['theme_rules'], 'title', -1);
			$data['title'] = $re[0];
		}
		if($rules_info['content_get_type'] == 1){
			$re = dom_single_article($str, array('content' => $rules_info['content_rules']));
			$data['content'] = $re['content'];
		}else if($rules_info['content_get_type'] == 2){
			$data['content'] = str_get_str($str, $rules_info['content_rules'], 'body', -1);
		}
	}
	
	//过滤
	
	if($rules_info['is_fiter_title'] == 1 && $data['title']){
		$format_args = array(
			'is_fiter' => $rules_info['is_fiter_title'],
			'show_type' => 'title',
			'result_data' => $data['title'],
			'replace_rules' => $rules_info['title_replace_rules'],
			'filter_data' => dunserialize($rules_info['title_filter_rules']),
			'test' => 2,
			'filter_html' => '',
		);
		$data['title'] = filter_article($format_args);
	}
	if($rules_info['is_fiter_content'] == 1 && $data['content']){
		$format_args = array(
			'is_fiter' => $rules_info['is_fiter_content'],
			'show_type' => 'body',
			'result_data' => $data['content'],
			'replace_rules' => $rules_info['content_replace_rules'],
			'filter_data' => dunserialize($rules_info['content_filter_rules']),
			'test' => 2,
			'filter_html' => dunserialize($rules_info['content_filter_html']),
		);
		$data['content'] = filter_article($format_args);
	}
	return $data;
}

//计算出多个相似url中的分页位置
function get_url_diff($url_arr){
	if(!$url_arr) return;
	foreach($url_arr as $k => $v){
		preg_match_all("/[\d]+/", $v, $arr);
		$c_arr[$k] = count($arr[0]); 
		$v_arr[$k] = $arr[0];
	}
	$avg = get_avg($c_arr);
	foreach($v_arr as $k => $v){
		if(!$v || $c_arr[$k] < $avg) {
			if($c_arr[$k] < $avg) $re['index'] = $url_arr[$k];
			unset($url_arr[$k]);
			continue;
		}	
		$split_arr[] = $v;
	}
	$t_arr = $split_arr;
	$split_rand_key = array_rand($split_arr);
	unset($t_arr[$split_rand_key]);
	$t_rand_key = array_rand($t_arr);
	$t_v = $t_arr[$t_rand_key];
	//print_r($t_v);
	foreach($split_arr[$split_rand_key] as $k => $v){
		if($v == $t_v[$k]) continue;
		$diff_key = $k;
	}
	
	$min_v = $split_arr[0][$diff_key];
	$re['auto'] = $min_v < 10 && strlen($min_v) != 1 ? 1 : 0;
	
	$rand_key = array_rand($url_arr);
	$temp_url = $url_arr[$rand_key];
	$s_arr = preg_split("/[\d]+/", $temp_url);
	$split_arr[$split_rand_key][$diff_key] = '(*)';
	$url = '';
	foreach($s_arr as $k => $v){
		$url .= $v.$split_arr[$split_rand_key][$k];
	}
	$re['url'] = $url;
	return $re;
}


//判断一个地址是否是文章页
function check_fastpick_viewurl($url, $lilely_page = array()){
	$url_arr = parse_url($url);
	if($url_arr['path'] == '/' || !$url_arr['path']) return FALSE;
	if($url_arr['query']){
		parse_str($url_arr['query'], $url_info);
		if(!preg_match('/\d+/', $url_arr['query'])) return FALSE;
		if($url_info['page']) return FALSE;
	}else{
		$file_ext = addslashes(strtolower(substr(strrchr($url_arr['path'], '.'), 1, 10)));
		if(!$file_ext) {//形如 http://kb.cnblogs.com/page/146617/
			if(preg_match('/\d+/', $url_arr['path'])) {
				if(!filter_something($url_arr['path'], array('list'), TRUE))  return FALSE;
				return TRUE;
			}
		}	
		$ext_arr = array('html', 'htm', 'shtml');
		if(!in_array($file_ext,  $ext_arr)) return FALSE;
		if(!preg_match('/\d+/', $url_arr['path'])) return FALSE;//宁可错杀一千，不放过一个
	}
	$lilely_page_arr = !is_array($lilely_page) ? array($lilely_page) : $lilely_page;
	foreach($lilely_page_arr as $k => $v){
		similar_text($v, $url, $percent);
		if($percent > 90) return FALSE;
	}
	return TRUE;
}




function _striplinks($document, $base_url = ''){	
	if(!trim($document)) return;
	preg_match_all("'<\s*a\s.*?href\s*=\s*			# find <a href=
					([\"\'])?					# find single or double quote
					(?(1) (.*?)\\1 | ([^\s\>]+))		# if quote found, match up to next matching
												# quote, otherwise match up to next space
					'isx",$document,$links);
					

	// catenate the non-empty matches from the conditional subpattern
	while(list($key,$val) = each($links[2])) {
		if(!empty($val))
			$match[] = _expandlinks($val, $base_url);
	}				
	
	while(list($key,$val) = each($links[3])){
		if(!empty($val))
			$match[] = _expandlinks($val, $base_url);
	}		
	// return the links
	return $match;
}


//统计一段html中有多少条指向自己的链接
function own_link_count($html, $url) {
	$domain_name = get_domain($url);
	$link_arr = _striplinks($html);
	if($link_arr){
		$re_link_arr = is_array($link_arr) ? array_unique($link_arr) : $link_arr;
		$i = 0;
		foreach($re_link_arr as $v){
			$v = convert_url($v);
			if(strexists(trim(_expandlinks($v, $url)), $domain_name)){
				$i++;
			}
		}
		return $i;
	}
}

function evo_get_pagelink($content, $url, $list = array()){
	$list = $list ? $list : $url;
	$rules_info = match_rules($url, $content, 4, 0);
	if($rules_info && is_array($rules_info)){	
		if($rules_info['page_get_type'] == 1){
			$link_arr = dom_page_link($content, array('page_link_rules' => $rules_info['page_link_rules'], 'url' => $url) );
		}else if($rules_info['page_get_type'] == 2){
			$link_arr = string_page_link($content, trim($rules_info['page_link_rules']), $url);
		}
		
	}
	if($link_arr) return $link_arr;
	$base_url  = get_base_url($content);
	$base_url = $base_url ? $base_url : $url;
	$link_arr = _striplinks($content, $base_url);
	if(!$link_arr) return array();
	foreach((array)$link_arr as $k => $v_url){
		if(!check_fastpick_viewurl($v_url, $url)) {
			unset($link_arr[$k]);
			continue;
		}	
		$c_arr[$k] = strlen($v_url);
	}	
	
	$value_count_arr = array_count_values($c_arr);
	arsort($value_count_arr);
	$value_count_arr = array_keys ($value_count_arr);
	$view_lenth = array_shift ($value_count_arr);
	$link_arr = array_resolve($link_arr);
	foreach($link_arr as $k => $v){
		if(abs(strlen($v) - $view_lenth) > 5) {
			unset($link_arr[$k]);
		}
	}
	$link_arr = array_filter($link_arr, 'filter_url_callback');
	return $link_arr;
}

function get_other_info($content, $args){
	if(!$content) return false;
	extract($args);
	if(!$from_get_rules && !$author_get_rules && !$dateline_get_rules) return false;
	$html = get_htmldom_obj($content);
	if(!$html) return false;
	if($from_get_rules){
		if($from_get_type == 1){
			$re['from'] = dom_get_str($html, $from_get_rules);
		}else{
			$re['from'] = str_get_str($content, $from_get_rules, 'data');
		}
	}
	if($author_get_rules){
		if($author_get_type == 1){
			$re['author'] = dom_get_str($html, $author_get_rules);
		}else{
			$re['author'] = str_get_str($content, $author_get_rules, 'data');
		}	
	}
	if($dateline_get_rules){
		if($dateline_get_type == 1){
			$re['article_dateline'] =dom_get_str($html, $dateline_get_rules);
			unset($div);
		}else{
			$re['article_dateline'] = str_get_str($content, $dateline_get_rules, 'data');
		}		
	}
	foreach((array)$re as $k => $v){
		$re[$k] = format_html($v);
	}
	$html->clear();
	unset($html);
	return $re;
}


?>
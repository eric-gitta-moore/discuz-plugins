<?php
/*
 *  重新整理第一版，第二版的算法而成，准确率颇高。
 *  算法由DXC开发，未经允许，禁止用于其他商业用途。
*/
class HtmlExtractor {
	public $str;
	public $dom_obj;
	public $url;//地址
	public $dom_arr = array();//原始的dom块
	public $dom_info_arr = array();
	public $text_arr = array();//内容块
	public $temp_dom_arr = array();//存放临时的dom块
	public $temp_fc_arr = array();
	public $element_arr = array('div','p','span','tr','td','h1','h2', 'h3', 'h4', 'li'); //需要分割的标签
	public $full_stop_count = 10;//句号最低数量
	public $min_pro = 0.7;//文本密度（文本/html） 越高越好
	public $max_txt_len = 1000;//最低字数 低于此字数就判断不是典型文章
	public $min_vis_per = 0.7;//影响视觉的标签所占最低百分比
	public $min_no_vis_per = 0.85;//不影响视觉的标签所占最低百分比
	public $min_img_c = 3;
	public $vis_tag = array("'<div.*?>.*?</div>'si", "'<ul.*?>.*?</ul>'si", "'<li.*?>.*?</li>'si", "'<h[1-5][^>]*?>.*?</h[1-5]>'si");//影响视觉的标签替换规则
	public $no_vis_tag = array("'<p.*?>.*?</p>'si", "'<font.*?>.*?</font>'si", "'<span.*?>.*?</span>'si", "'<strong.*?>.*?</strong>'si");//不影响视觉的标签替换规则
	public $info_arr = array();
	public $title_arr = array();
	public $ori_title = '';//原始标题
	
	function HtmlExtractor($str, $url){
		$this->str = $str;
		$this->url = $url;
		$this->get_ori_title();
		$this->clear();
	}
	
	//分解成dom块，太复杂的内容，性能有点慢，算法有待改进。
	function extract_dom(){
		$this->dom_obj = get_htmldom_obj($this->str);
		foreach($this->element_arr as $k => $v){
			if($this->dom_obj){
				foreach($this->dom_obj->find($v) as $k2 => $v2) {
					$key = $k.'_'.$k2;
					$dom_arr[$key] = $v2->innertext;
					$this->dom_info_arr[$key] = array(
						'outertext' => $v2->outertext,
						'parent' => array(
							'attr' => $v2->parent()->attr,
							'outertext' => $v2->parent()->outertext, 
							'tag_name' => $v2->parent()->tag,
							),
						'tag_name' => $v2->tag,
						'attr' => $v2->attr,
					);	
					$this->tag_arr[$key] = $v2->tag;
				}
			}
		}

		$dom_arr = array_map('trim',$dom_arr);
		$dom_arr = array_filter($dom_arr);
		return $dom_arr;
	}
	

	//典型文章 
	function get_normal_text(){
		$f_c_max = $this->full_stop_count - 1;
		$max_info = $text_info = '';
		foreach($this->text_arr as $k => $v){
			$f_c = substr_count($v, milu_lang('full_stop'));
			$v_o = _striptext($v);
			$txt_len = strlen($v_o);
			$html_len = strlen($v);
			$pro = $txt_len/$html_len;
			$this->temp_fc_arr[$k] = $f_c; 
			$this->temp_dom_arr[$k]  = array('html' => $v, 'f_c' => $f_c, 'txt_len' => $txt_len, 'html_len' => $html_len, 'pro' => $pro, 'key' => $k);
			$v_a['no_vis_per'] = $this->vis_percent($this->temp_dom_arr[$k], $this->no_vis_tag);
			$v_a['vis_per'] = $this->vis_percent($this->temp_dom_arr[$k], $this->vis_tag);
			$new_test_arr[$k] = $v_a;
			$v_a['html'] = $v;
			if($f_c > 0 && $f_c > $f_c_max){
				if($pro < $this->min_pro) continue;
				$fc_arr[$k] = $f_c; 
				$html_arr[$k] = $this->temp_dom_arr[$k];
				if(!$max_info) $max_info = $html_arr[$k];
				if(!$min_f_c) $min_f_c = $f_c;
				if($f_c < $min_f_c) $min_f_c  = $f_c;
				if($txt_len > $max_info['txt_len']) $max_info = $html_arr[$k];
				
			}
		}

		foreach($html_arr as $k => $v){
			if($v['f_c'] > $min_f_c) unset($html_arr[$k]);
		}
		foreach($html_arr as $k => $v){
			$text_info = $text_info ? ($v['pro'] > $text_info['pro'] ? $v : $text_info) : $v;
		}
		$this->temp_arr = $html_arr;

		if(!$fc_arr) return FALSE;
		$vis_per = $this->vis_percent($text_info, $this->vis_tag);
		$no_vis_per = $this->vis_percent($text_info, $this->no_vis_tag);
		//有个特殊的列子 http://news.bandao.cn/news_html/201210/20121005/news_20121005_1994736.shtml
		if($vis_per < 0.05 && $no_vis_per < 0.15){
			$chinese_count = chineseCount($text_info['html']);
			if($chinese_count < 1000) return FALSE;
		}else{
			if($vis_per > $this->min_vis_per || $no_vis_per < $this->min_no_vis_per || $text_info['pro'] == 1) return FALSE;
		}
		
		$text_info['get_level'] = 1;
		return $text_info;
	}
	
	function get_normal2(){
	
		$temp_fc_arr = $this->temp_fc_arr;
		$temp_dom_arr = $this->temp_dom_arr;
		$temp_fc_arr = array_filter($temp_fc_arr);
		if(!$temp_fc_arr) return;
		sort($temp_fc_arr);
		$max_fc = $temp_fc_arr[count($temp_fc_arr) - 1];
		$this->temp_dom_arr = '';
		foreach($temp_dom_arr as $k => $v){
			$v['no_vis_per'] = $this->vis_percent($v, $this->no_vis_tag);
			$v['vis_per'] = $this->vis_percent($v, $this->vis_tag);
			$temp_dom_arr[$k] = $this->temp_dom_arr[$k] = $v;
			$this->temp_fc_arr[$k] = $v['f_c'];//debug
			if( ((($max_fc-$v['f_c'])/$max_fc ) > 0.3 ) || $v['f_c'] == 0 || $v['vis_per'] > 0.8) unset($temp_dom_arr[$k]);
		}
		$text_info = array();
		foreach($temp_dom_arr as $k => $v){
			//if($v['pro'] < 0.3) continue;
			$text_info = $text_info ? ($v['pro'] > $text_info['pro'] ? $v : $text_info) : $v;
		}
		if($text_info['vis_per'] > $this->min_vis_per || $text_info['no_vis_per'] < $this->min_no_vis_per || !$text_info) return FALSE;
		$text_info['get_level'] = 2;
		return $text_info;
	}
	
	function get_normal3(){
		$dom_arr = $this->temp_dom_arr;
		$f_c_arr = array_filter($this->temp_fc_arr);
		if(!$f_c_arr || !$dom_arr) return FALSE;
		$key_arr = array_keys($f_c_arr);
		foreach($dom_arr as $k => $v){
			if(!in_array($k, $key_arr)) continue;
			$text_info = $text_info ? ($v['no_vis_per'] > $text_info['no_vis_per'] ? $v : $text_info) : $v;
		}
		if($text_info['txt_len'] < 100) return FALSE;
		$text_info['get_level'] = 3;
		return $text_info;
	}
	//纯图片帖
	function get_img_text(){
		$dom_arr = $img_arr = array();
		foreach($this->temp_dom_arr as $k => $v){
			preg_match_all("/\<img.+src=('|\"|)?(.*)(\\1)(.*)?\>/isU", $v['html'], $img_arr, PREG_SET_ORDER);
			if(!$img_arr) continue;
			$v['img_c'] = $img_c_arr[$k] = count($img_arr);
			$v['img_per'] = $this->img_percent($v['html']);
			$dom_arr[$k] = $v;
		}
		if(!$img_c_arr) return;
		sort($img_c_arr);
		$max_img_c = $img_c_arr[count($img_c_arr) - 1];
		foreach($dom_arr as $k => $v){
			if( ((($max_img_c - $v['img_c'])/$max_img_c ) > 0.35 ) || $v['img_per'] < 0.6) unset($dom_arr[$k]);
		}
		if(!$dom_arr) return FALSE;
		foreach($dom_arr as $k => $v){
			$text_info = $text_info ? ($v['img_per'] > $text_info['img_per'] ? $v : $text_info) : $v;
		}
		$text_info['get_level'] = 4;
		return $text_info;
	}
	
	//去噪
	function clear(){
		$this->str = preg_replace("'([\r\n])[\s]+'", "", $this->str);//去掉换行速度更快
		$this->str = preg_replace(array("'<head[^>]*?>.*?</head>'si"),array(''), $this->str);
		$filter_html = array(14,15,18,19);
		$this->str = clear_html_script($this->str, $filter_html);
		
	}
	//内容块去掉不合适的
	function remove_dom(){
		$filter_html = array(0);//去掉a标签
		foreach($this->dom_arr as $k => $v){
			$del_a_html = clear_html_script($v, $filter_html);
			if(strexists($this->ori_title, $del_a_html)){
				$this->title_arr[$k] = $del_a_html;
			}
			$v_temp = $this->clear_text($v);
			$v_o = _striptext($v_temp);
			$txt_len = strlen($v_o);
			if($txt_len < 10) {
				 if($this->img_percent($v) < 0.7) continue;
				 continue;
			}
			
			$this->text_arr[$k] = $v;
		}
	}
	
	//对内容快进行处理
	function clear_text($str){
		if(!$str) return;
		$search = array("'<h[1-5][^>]*?>.*?</h[1-5]>'si","'<a.*?>.*?</a>'si");//去掉h1和a标签之后
		$replace =  array_fill(0, count($search), '');
		$str = preg_replace($search,$replace,$str);
		$filter_html = range(0,21);
		unset($filter_html[9]);//不去掉图片
		$str = clear_html_script($str, $filter_html);
		return $str;
	}
	//取得图片标签所占百分比
	function img_percent($v){
		$v_len = strlen($v);
		$filter_html = array(9);
		$str = clear_html_script($v, $filter_html);
		return ($v_len - strlen($str))/$v_len;
	}
	
	//取得标签所占比例
	function vis_percent($info, $search){
		if(!$search) return;
		$replace =  array_fill(0, count($search), '');
		$new_str = preg_replace($search, $replace, $info['html']);
		$new_str_len = strlen($new_str);
		if($new_str_len == $info['html_len'] && $search == $this->no_vis_tag) $new_str_len = 0;
		return ($info['html_len'] - $new_str_len)/$info['html_len'];
	}

	
	//获取原始的标题
	function get_ori_title(){
		preg_match("/<title>(.*?)<\/title>/is", $this->str, $arr);
		$this->ori_title = $arr[1];
	}
	//获得标题
	function get_title(){
		$title_info = array();
		if(!$this->title_arr){
			if(strexists($this->ori_title, ' - ')){
				$title_arr = explode(' - ', $this->ori_title);
			}else if(strexists($this->ori_title, '-')){
				$title_arr = explode('-', $this->ori_title);
			}else if(strexists($this->ori_title, '_')){
				$title_arr = explode('_', $this->ori_title);
			}else if(strexists($this->ori_title, '|')){
				$title_arr = explode('|', $this->ori_title);
			}else{
				 $title_info['html'] = $this->ori_title;
				 return $title_info;
			}
			$title_info['html'] = $title_arr[0];
			return $title_info;
		}else{
			foreach($this->title_arr as $k => $v){
				$title_lekely_lenth[$k] = strlen(trim($v)); 
				$_title_lekely[$k] = strlen(_striptext(trim($v)));
			}
			arsort($_title_lekely);
			if(is_array($_title_lekely) && count($_title_lekely) > 2){
				$_key = key(array_count_values($_title_lekely));
				if($_key){
					$_title_lekely_re = array_keys($_title_lekely,key(array_count_values($_title_lekely)));
				}
			}
			
			if(is_array($_title_lekely_re) && $_title_lekely_re){
				foreach($_title_lekely_re as $k => $v){
					if(!$max_title) $max_title = $v;
					if($title_lekely_lenth[$v] > $title_lekely_lenth[$max_title]){
						$max_title = $v;
					}
				}
			}else{
				$key_arr = array_keys($_title_lekely);
				$max_title = $key_arr[0];
			}
			$title_lenth_arr = array_keys($title_lekely_lenth);
			$title_info['html'] = $this->title_arr[$max_title];
			$title_info['key'] = $max_title;
			return $title_info;
		}
	}
	
	//获取文章标题和内容
	function get_text($only_title = 0){
		if(strlen(trim($this->str)) < 1) return FALSE;
		$re = $this->evo_get();
		if($re['title'] && $re['content']) return $re;
		$this->dom_arr = $this->extract_dom();
		$this->remove_dom();
		if(!$re['title']['html']) $title_info = $this->get_title();
		if($only_title == 1) return $title_info;//只获取标题
		$text_info = $this->get_normal_text();
		
		if($text_info) return $this->format_result($text_info, $title_info);
		$text_info = $this->get_normal2($e);
		if($text_info) return $this->format_result($text_info, $title_info);
		$text_info = $this->get_normal3();
		if($text_info) return $this->format_result($text_info, $title_info);
		
		$text_info = $this->get_img_text();
		if($text_info) return $this->format_result($text_info, $title_info);
	}
	
	function format_result($text_info, $title_info){
		$re_info['content'] = $text_info['html'];
		$re_info['title'] = $title_info['html'];
		$info['text'] = $text_info;
		$info['title'] = $title_info;
		$evo_result = $this->evo_set($info);
		$re_info['evo'] = $evo_result['status'] == 'ok' ? 1 : 0;
		$re_info['evo_title_info'] = $evo_result['evo_title_info'];
		$re_info['ori_title'] = $this->ori_title;
		return $re_info;
	}
	
	//从规则库中提取
	function evo_get(){
		$milu_set = pick_common_get();
		$get_type = 3;
		$rules_info = match_rules($this->url, $this->str, $get_type, 0);//从本地学习到的规则获取
		if(!is_array($rules_info) || !$rules_info){
			$get_type = 5;//只从详细页搜索
			$rules_info = match_rules($this->url, $this->str, $get_type, 0);//尝试从本地内置规则取
		}
		$data['evo'] = 2;
		if(!is_array($rules_info) || !$rules_info) {
			$data = cloud_match_rules(3, $this->url, $this->str);//从服务器端获取
			if(!$data['content']) return array();
			if(!$data['title']){
				$re_title = $this->get_title();
				if($re_title['html']) $data['title'] = $re_title['html'];
			}
			
			if($data['content']) return $data;
		}
		if(!$rules_info) return array();
		$data = evo_rules_get_article($this->str, $rules_info);
		
		if(!$data['content']){//如果匹配到规则，但是又获取不到内容，证明规则出错了,记录起来
			pload('F:fastpick');
			write_evo_errlog($data, $this->url, $rules_info);
		}
		if(!$data['title']){
			$re_title = $this->get_title();
			if($re_title) $data['title'] = $re_title['html'];
		}
		
		if($rules_info['detail_ID_test'] != $this->url){
			DB::update("strayer_evo", array('hit_num' => $rules_info['hit_num'] + 1), array("id" => $rules_info['id']));
		}

		return $data;	
	}
	
	//自我学习
	function evo_set($info){
		global $_G;
		if(!$info) return;
		if(strlen($info['text']['html']) <  200 || strlen($info['title']['html']) < 10) return;//标题和内容太短都不行
		
		$link_count = own_link_count($info['text']['html'], $this->url);
		if($link_count > 10) return FALSE;//有10个指向自己的链接，就不行
		$milu_set = pick_common_get();
		if($milu_set['fp_open_evo'] != 1) return FALSE;
		$text_info = $this->dom_info_arr[$info['text']['key']];
		$title_info = $this->dom_info_arr[$info['title']['key']];
		$text_info['html'] = $info['text']['html'];
		$title_info['html'] = $info['title']['html'];
		$info['title_split_arr'] = 	$this->get_split_arr($title_info);
		$info['text_split_arr'] = $split_arr = $this->get_split_arr($text_info);
		unset($text_info['outertext'],$text_info['parent']['outertext'], $title_info['outertext'], $title_info['parent']['outertext'], $text_info['html'], $title_info['html']);
		
		if(strlen($split_arr[0]) < 14) return FALSE;
		pload('F:copyright');
		$host_info = GetHostInfo($this->url);
		$domain = $host_info['host'];
		$domain_hash = md5($domain);
		if(preg_match('/\d+/', $split_arr[0])){
			$s_arr = preg_split("/[\d]+/", $split_arr[0]);
			$split_arr[0] = $s_arr[0];
			foreach((array)$s_arr as $k => $v){
				if(strlen($v) > strlen($split_arr[0])) $split_arr[0] = $v;
			}
		}
		if(!$title_info) return FALSE;
		$result_info['evo_title_info'] = $title_info;
		$setarr = array(
			'content_get_type' => 0,
			'detail_ID' => $split_arr[0],
			'detail_ID_hash' => md5($split_arr[0]),
			'detail_ID_test' => $this->url,
			'content_rules' => '',
			'evo_text_info' => serialize($text_info),
			'evo_title_info' => serialize($title_info),
			'domain_hash' => $domain_hash,
			'domain' => $domain,
			'status' => 0,
			'dateline' => $_G['timestamp'],
		);
		$setarr = paddslashes($setarr);
		$base_sql = "SELECT * FROM ".DB::table('strayer_evo')." WHERE domain_hash='$domain_hash' AND detail_ID_hash='".$setarr['detail_ID_hash']."' AND status=0";
		$data_info = DB::fetch_first($base_sql." AND detail_ID_test!='$this->url'");
		$data_info = pstripslashes($data_info);
		if(!$data_info){//还没有资料
			if(!($check = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_evo')." WHERE domain_hash='$domain_hash' AND detail_ID_hash='".$setarr['detail_ID_hash']."' AND status=0 AND detail_ID_test='$this->url'"), 0))){
				DB::insert('strayer_evo', $setarr, TRUE);
			}
			$result_info['status'] = 'no';
			return $result_info;
		}else{//有了资料
			
			$title_rules = $this->get_rules($info, $title_info, $data_info, 'title');
			$text_rules = $this->get_rules($info, $text_info, $data_info, 'text');
			//删除之前的一些记录，防止没有索引的情况下重复生成规则
			$check_info = DB::fetch_first("SELECT * FROM ".DB::table('strayer_evo')." WHERE domain_hash='$domain_hash' AND detail_ID_hash='".$setarr['detail_ID_hash']."' AND status=1");
			DB::query('DELETE FROM '.DB::table('strayer_evo')." WHERE id='$check_info[id]'");
			
			DB::query('DELETE FROM '.DB::table('strayer_searchindex')." WHERE id='$check_info[id]' AND type='34'");
			
			if($text_rules){
				$setarr = array(
					'content_get_type' => $text_rules['get_type'], 
					'content_rules' => $text_rules['rules'], 
					'theme_get_type' => $title_rules['get_type'], 
					'theme_rules' => $title_rules['rules'],
					'status' => 1,
					);
				DB::update("strayer_evo", $setarr, array("id" => $data_info['id']));
				
				$pash_hash = get_path_hash($this->url);
			
				add_search_index($domain_hash, $path_hash, 34, $data_info['id']);//添加索引 4是本地缓存
				
				$pick_set = get_pick_set();
				if($pick_set['open_cloud_pick'] == 1){//开启云采集，将规则上传到服务端
					$rpcClient = rpcClient();
					unset($setarr['status']);
					$data_info['content_get_type'] = $setarr['content_get_type'];
					$data_info['content_rules'] = $setarr['content_rules'];
					$data_info['theme_get_type'] = $setarr['theme_get_type'];
					$data_info['theme_rules'] = $setarr['theme_rules'];
					$client_info = get_client_info();
					$re = $rpcClient->upload_evo_data($data_info, $client_info);
				}
				del_search_index(3);
				$result_info['status'] = 'ok';
				return $result_info;
			}
			
		}
	}
	
	//提取规则(是否考虑正则优先？有些网页用正则提取效率相差几十倍)
	function get_rules($info, $evo_info, $data_info, $type){
		if( $data_info['evo_'.$type.'_info']!= serialize($evo_info)) return FALSE;//资料不一样
		$get_type = 1;
		$pre_arr = $re = array();
		$filter_html = array(0);//去掉a标签
		
		
		//
		if($evo_info['attr']['id'] && !preg_match('/\d+/', $evo_info['attr']['id']) ){//优先用id
			$rules = $re['rules'] = $pre_arr['id'] = $evo_info['tag_name'].'[id='.$evo_info['attr']['id'].']';
			$div = $this->dom_obj->find($rules);
			$re['get_type'] = 1;
			$get_result = trim($div[0]->innertext);
			if($type == 'title'){
				if(strpos($get_result, '</a>') != FALSE) {
					$re['rules'] .= ' a'; 
					$get_result = clear_html_script($get_result, $filter_html);
				}	
			}
			if($get_result == $info[$type]['html']) return $re;
		}
		if($evo_info['attr']['class']){//其次是class
			$rules = $re['rules'] = $pre_arr['class'] = $evo_info['tag_name'].'[class='.$evo_info['attr']['class'].']';
			$div = $this->dom_obj->find($rules);
			$re['get_type'] = 1;
			$get_result = trim($div[0]->innertext);
			if($type == 'title'){
				if(strpos($get_result, '</a>') != FALSE) {
					$re['rules'] .= ' a'; 
					$get_result = clear_html_script($get_result, $filter_html);
				}	
			}
			if($get_result == $info[$type]['html']) return $re;
		}
		$pre_rules = $pre_arr['id'] ? $pre_arr['id'] : $pre_arr['class'];
		$pre_rules = $pre_rules ? $pre_rules : $evo_info['tag_name'];
		//然后用父级属性
		if($evo_info['parent']['attr']['id'] && !preg_match('/\d+/', $evo_info['parent']['attr']['id']) && $pre_rules){
			$rules = $re['rules'] = $evo_info['parent']['tag_name'].'[id='.$evo_info['parent']['attr']['id'].']'.' '.$pre_rules;
			$div = $this->dom_obj->find($rules);
			$get_result = trim($div[0]->innertext);
			$re['get_type'] = 1;
			if($type == 'title'){
				if(strpos($get_result, '</a>') != FALSE) {
					$re['rules'] .= ' a'; 
					$get_result = clear_html_script($get_result, $filter_html);
				}	
			}
			if($get_result == $info[$type]['html']) return $re;
		}
		
		if($evo_info['parent']['attr']['class'] && $pre_rules){
			$rules = $re['rules'] = $evo_info['parent']['tag_name'].'[class='.$evo_info['parent']['attr']['class'].']'.' '.$pre_rules;
			$div = $this->dom_obj->find($rules);
			$re['get_type'] = 1;
			if(trim($div[0]->innertext) == $info[$type]['html']) return $re;
		}
		
		
		//用正则匹配。
		$get_type = $re['get_type'] = 2;
		$split_arr = $info[$type.'_split_arr'];
		$flag = $type == 'title' ? 'title' : 'body';
		$rules = $re['rules'] = $split_arr[0].'['.$flag.']'.$split_arr[1];
		$rules = preg_replace(array('/[^h]\d+/'), array('*'), $rules);
		$result = pregmessage($this->str, $rules, $flag, -1);
		if(trim($result[0]) == $info[$type]['html']) return $re;
		
		
		return FALSE;
	}
	function get_split_arr($info){
		$split_arr = explode($info['html'], $info['outertext']);
		$split_arr = array_map('trim',$split_arr);
		return $split_arr;
	}
	
	function __destruct(){
		if($this->dom_obj) $this->dom_obj->clear();
		unset($this->dom_obj);
	}
  
}

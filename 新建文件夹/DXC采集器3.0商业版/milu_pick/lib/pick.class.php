<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class pick{
	var $now_url;//���ڴ����url
	var $p_arr;//�ɼ�������
	var $r_arr;//���ù�����Ϣ
	var $rid;//���ù���id
	var $pid;//�ɼ���id
	var $now_level;//Ŀǰ�Ĳɼ����
	var $max_level;//������
	var $now_url_arr;//�ɼ�������ʱurl
	var $i;//Ŀǰ���ʵ�url��
	var $v_i;//��������url��
	var $a;//Ŀǰȡ����������
	var $v_a;//������������
	var $base_url;//����ַ
	var $aid;//�������ݿ�����id
	var $reply_page;//�ڼ�ҳ�Ļظ�
	var $cache_time;//
	var $snoopy;
	var $is_cron;//�Ƿ��Ǽƻ����񴥷�ִ��
	var $msg_args;//��ʾ
	var $plugin_set;
	var $reply_max_num;
	var $words;//ͬ�������
	var $error;
	var $public_info;//���·���֮�󣬰ѷ��������Ϣ����������
	var $oldurl_arr;
	var $status_arr;
	var $min_title_len = 4;//������ͳ���
	var $pick_set;
	var $cache_likely_page;
	var $min_own_link = 10;
	var $all_get_time = 0;
	var $pick_cache_data;
	var $temp_arr = array();//������ʱ����
	var $pick_config;
	var $page_hash;
	function pick($pid = 0, $is_cron = 0){
		pload('F:spider');
		pload('F:article');
		pload('F:pick');
		$this->_ini_config($pid, $is_cron);
	}
	
	function _ini_config($pid = 0, $is_cron = 0){
		global $_G;
		$this->error = '';
		if($pid == 0 && $is_cron > 0) {
			$this->error = 1;
			return;
		}	
		$this->pid = $pid >0 ? intval($pid) : intval($_GET['pid']);
		$this->pick_cache_data = load_cache('pick'.$this->pid);
		
		$this->i = $this->pick_cache_data['i'] ? $this->pick_cache_data['i'] : 1;
		$this->v_i = $this->pick_cache_data['v_i'] ? $this->pick_cache_data['v_i'] : 0;
		$this->a = $this->pick_cache_data['a'] ? $this->pick_cache_data['a'] : 0;
		$this->v_a = $this->pick_cache_data['v_a'] ? $this->pick_cache_data['v_a'] : 0;
		$this->all_get_time = $this->pick_cache_data['all_get_time'] ? $this->pick_cache_data['all_get_time'] : 0;
		$this->temp_arr['have_reply'] = 0;
		$this->plugin_set = get_pick_set();
		if($is_cron > 0 && $this->plugin_set['is_log_cron'] > 0) $is_log = 1;
		$this->msg_args = array(
			'is_cron' => $is_cron,
			'pid' => $this->pid,
			'is_log' => $is_log,
		);
		if($this->i == 1) show_pick_info(milu_lang('pick_start'), '', $this->msg_args);
		$p_arr = get_pick_info($this->pid);
		$p_arr = pstripslashes($p_arr);
		//if(!VIP) unset($p_arr['reply_rules'],$p_arr['reply_is_extend'], $p_arr['content_page_rules']);
		if($p_arr['rules_type'] == 3)  $p_arr['url_range_type'] = '';//����
		$this->pick_set = pick_common_get();//�������
		$this->pick_config = $_G['cache']['evn_milu_pick'];
		$p_arr['rules_var'] = dstripslashes(unserialize($p_arr['rules_var']));
		$p_arr['many_page_list'] = dstripslashes(unserialize($p_arr['many_page_list']));
		$p_arr['title_filter_rules'] = dstripslashes(unserialize($p_arr['title_filter_rules']));
		$p_arr['content_filter_rules'] = dstripslashes(unserialize($p_arr['content_filter_rules']));
		$p_arr['reply_filter_rules'] = dstripslashes(unserialize($p_arr['reply_filter_rules']));
		$p_arr['content_filter_html'] = dstripslashes(unserialize($p_arr['content_filter_html']));
		$p_arr['reply_filter_html'] = dstripslashes(unserialize($p_arr['reply_filter_html']));
		$p_arr['public_class'] = dstripslashes(unserialize($p_arr['public_class']));//��������
		//if(!VIP) $p_arr['is_auto_public'] = 0;
		if($p_arr['is_login'] == 2) $p_arr['login_cookie'] = '';
		if(!$p_arr['reply_max_num']) $p_arr['reply_max_num'] = 200000;//���û�����ûظ���������������Ŀ��
		if($p_arr['reply_is_extend']){//�̳����ݹ���
			$p_arr['reply_get_type'] = $p_arr['content_get_type'];
			$p_arr['reply_rules'] = $p_arr['content_rules'];
			if($p_arr['is_fiter_content'] == 1){//�����ǹ��˵�
				if($p_arr['is_fiter_reply'] == 1){//�ظ��ǹ��˵�
					$p_arr['reply_replace_rules'] = array_merge((array)$p_arr['reply_replace_rules'], (array)$p_arr['content_replace_rules']);
					$p_arr['reply_filter_rules'] = array_merge((array)$p_arr['content_filter_rules'], (array)$p_arr['reply_filter_rules']);
					$p_arr['reply_filter_html'] = array_merge((array)$p_arr['content_filter_html'], (array)$p_arr['reply_filter_html']);
				}else{//���ݹ��ˣ��ظ�������
					$p_arr['reply_replace_rules'] = $p_arr['content_replace_rules'];
					$p_arr['reply_filter_rules'] = $p_arr['content_filter_rules'];
					$p_arr['reply_filter_html'] = $p_arr['content_filter_html'];
					$p_arr['is_fiter_reply'] = 1;
				}	
			}
		}
		$p_arr['stop_time'] = explode(',', $p_arr['stop_time']);
		$p_arr['stop_time'] = array_map('intval', $p_arr['stop_time']);
		$this->p_arr = $p_arr;
		$rules_hash = $this->p_arr['rules_hash'];
		if($this->p_arr['is_auto_public'] == 1 && !$this->p_arr['public_class'][0]){//���������Զ���������û�����÷�����Ŀ
			$this->error = 1;
			show_pick_info(milu_lang('no_set_public_class'), 'exit', $this->msg_args);
			return;
		}
		if($this->p_arr['is_auto_public'] == 1 && $this->p_arr['is_word_replace'] == 1){//���Զ�����,��������ͬ����滻
			$this->words = get_replace_words();
		}
		pload('F:rules');
		if($rules_hash) $r_arr = get_rules_info($rules_hash);
		$r_arr = pstripslashes($r_arr);
		$r_arr['url_var'] = dstripslashes(unserialize($r_arr['url_var']));
		$this->r_arr = $r_arr;
		$this->rid = $r_arr['rid'];
		$this->now_level = $this->pick_cache_data['now_level'];
		$this->max_level = $this->pick_cache_data['max_level'];
		if(!$this->pick_cache_data) update_times($this->pid);
		if(!$this->pick_cache_data['start_time']) $this->pick_cache_data['start_time'] = TIMESTAMP;
		$this->cache_time = PICK_ENABLE_CACHE ? 3600*24 : -1;//����
		
	}
	
	//����ҳ�棬�õ��ı������ӵ�
	function parse_page($type = 'content', $content = ''){
		$this->now_url = cnurl($this->now_url);
		if(( $this->cache_time > 0 && $message = load_cache($this->now_url) ) || $content){
			if($content) $message = $content;
			$this->base_url  = get_base_url($message);
			if(!$this->base_url) $this->base_url = $this->now_url;
			if($type == 'content'){
				return $message;
			}else if($type == 'link'){
				return _striplinks($message, $this->base_url);
			}
		}else{
			$time_out = $this->pick_set['time_out'] ? $this->pick_set['time_out'] : 15;
			$error = milu_lang('unable_pick');
			if(!function_exists('fsockopen') && !function_exists('pfsockopen') && !function_exists('file_get_contents')){
				show_pick_info($error, 'exit', $this->msg_args);
				return;
			}
			
			if(!function_exists('fsockopen') && !function_exists('pfsockopen')){
				if(!function_exists('file_get_contents')){
					show_pick_info($error, 'exit', $this->msg_args);
					return;
				}
				$content = file_get_contents($this->now_url);
				$content = str_iconv($content);
				return $content;
			}
			if(!$this->snoopy){
				require_once(PICK_DIR.'/lib/Snoopy.class.php');
				//��Щ���ð���˳�򲻿�������
				$this->snoopy = new Snoopy;  
				$this->snoopy->maxredirs = $this->p_arr['max_redirs'] ? $this->p_arr['max_redirs'] : 3;   
				$this->snoopy->expandlinks = TRUE;
				$this->snoopy->offsiteok = TRUE;//�Ƿ��������������ض���
				$this->snoopy->maxframes = 3;
				$this->snoopy->agent = $_SERVER['HTTP_USER_AGENT'];//�����������Щ��ҳû����ȡ
				$this->snoopy->referer = $this->now_url;
				$this->snoopy->rawheaders["COOKIE"] = $this->p_arr['login_cookie'];
				$this->snoopy->read_timeout = $time_out;
			}	
			if($type == 'content'){
				$this->snoopy->results = get_contents($this->now_url, array(
					'cookie' => $this->p_arr['login_cookie'],
					'max_redirs' =>  $this->p_arr['max_redirs'] ,
					'time_out' => $time_out,
					'cache' => $this->cache_time,
				)); 
				
			}else if($type == 'link'){
				if($this->snoopy->fetchlinks($this->now_url));
			}
			$this->base_url  = get_base_url($this->snoopy->results);
			if(!$this->base_url) $this->base_url = $this->now_url;
			if($this->snoopy->results) cache_data($this->now_url, $this->snoopy->results, $this->cache_time);
			return $this->snoopy->results;
		}	
	}
	//�������ù���
	function parse_rules(){
		if($this->p_arr['rules_type'] > 1) return ;
		//�ж����ù������б�ɼ�����ֱ��������ϸҳ�ɼ�
		$page_url = $this->r_arr['page_url'];
		$page_url_arr = explode('(*)', $page_url);
		$url_last_str = array_pop($page_url_arr);
		if(trim($this->p_arr['page_link_rules'])){//�����б������Ǵ��б�ɼ�
			$this->p_arr['url_range_type'] = 1;
			$this->max_level = 2;			
		}else{
			$this->p_arr['url_range_type'] = 2;
			$this->max_level = 1;			
		}
		foreach((array)$this->p_arr['rules_var'] as $k => $v){
			$value_arr = $this->get_var_set_value($v);
			$set_arr[$k] = $value_arr['set'];
			$type_arr[$k] = $value_arr['type'];
		}
		$i = 0; //���¹������������
		foreach((array)$page_url_arr as $k => $v){
			$k = $k + 1;
			if(is_array($set_arr[$k])){
				if($type_arr[$k] == 'range'){//��Χ
					$args['start'] = $set_arr[$k][0];
					$args['end'] = $set_arr[$k][1];
					$args['step'] = 1;
					$args['url'] = $v.'(*)';//������Ҫ����ʱ��������
					$url_arr[$i] = convert_url_range($args);
				}else{
					foreach($set_arr[$k] as $k1 => $v1){
						$url_arr[$i][$k1] = $v.$v1;
					}
				}
			}else{
				$url_arr[$i] = $v.$set_arr[$k];
			}
			$i++;
		}
		array_push($url_arr, array($url_last_str));
		//��������ƴ�ӳɿ���ʹ�õ�url
		$new_url_arr = my_array_merge($url_arr);
		$this->temp_arr['page_num'] = count($new_url_arr);
		$this->now_url_arr = $new_url_arr;
	}
	
	function get_var_set_value($value){
		if(is_array($value)) return array('type' => 'or', 'set' => $value);
		if(strexists($value, ',')){//��Χ
			$arr['set'] = format_wrap($value, ',');
			$arr['type'] = 'range';
		}else if(strexists($value, '|')){
			$arr['set'] = format_wrap($value, '|');
			$arr['type'] = 'or';
		}else{
			$arr['set'] = array($value);
			$arr['type'] = 'normal';
		}
		return $arr;
	}
	
	//ȡ����ʼurl
	function get_start_url(){
		if($this->p_arr['rules_type'] == 1){//����ɼ����������ù���
			$this->parse_rules();
		}else if($this->p_arr['rules_type'] == 2){//�Զ������
			if($this->p_arr['url_range_type'] == 1 || $this->p_arr['url_range_type'] == 2){//�ӷ�ҳ�б�ɼ����»�url��Χ
				$args['step'] = $this->p_arr['page_url_auto_step'];
				$args['start'] = $this->p_arr['page_url_auto_start'];
				$args['end'] = $this->p_arr['page_url_auto_end'];
				$args['url'] = $this->p_arr['url_page_range'];
				$args['auto'] = $this->p_arr['page_url_auto'];
				$this->now_url_arr = convert_url_range($args);
				$this->max_level = 2;
				if($this->p_arr['url_range_type'] == 2) {
					$this->max_level = 1;
					$this->temp_arr['per_num'] = 1;
				}else{
					$this->temp_arr['page_num'] = count($this->now_url_arr);
				}	
			}else if($this->p_arr['url_range_type'] == 4){//��rss��ַ
				$this->now_url_arr = get_rss_url(2, $this->p_arr['rss_url']);
				$this->max_level = 1;
			}else if($this->p_arr['url_range_type'] == 5){//����б�
				$this->now_url_arr = array($this->p_arr['many_list_start_url']);
				$this->max_level = count($this->p_arr['many_page_list'])  + 1;
			}
		}else if($this->p_arr['rules_type'] == 3){//һ���ɼ�
			$start_arr = format_wrap($this->p_arr['manyou_start_url']);
			$this->now_url = $start_arr[0];
			$content = $this->parse_page();
			$rules_info = match_rules($this->now_url, $content, 4, 0);
			
			if($rules_info && is_array($rules_info)){	
				$this->pick_cache_data['lilely_page'][] = $this->now_url; 
				if($rules_info['page_get_type'] == 1){
					$this->now_url_arr = dom_page_link($content, array('page_link_rules' => $rules_info['page_link_rules'], 'url' => $this->now_url) );
				}else{
					$this->now_url_arr = string_page_link($content, trim($rules_info['page_link_rules']), $this->now_url);
				}
			}
			$page_url_arr = parse_url($this->now_url);
			parse_str($page_url_arr['query'], $url_info);
			$index_url = $auto = 0;
			if(is_numeric($url_info['page'])) {
				$var_url = str_replace('page='.$url_info['page'], 'page=(*)', $this->now_url);
				$this->pick_cache_data['lilely_page'][] = $this->now_url; 
			}else{	
				$page_all_link = $this->parse_page('link', $content);
				$page_all_link = array_filter($page_all_link, 'filter_url_callback');
				$likely_arr[0] = $this->now_url;
				foreach((array)$page_all_link as $k => $v){
					similar_text($v, $this->now_url, $percent);
					if($percent < 90) continue;
					$likely_arr[] = $v; 
				}
				$likely_arr = array_resolve($likely_arr);
				$var_arr = get_url_diff($likely_arr);
				$var_url = $var_arr['url'];
				$index_url = $var_arr['index'];
				$auto = $var_arr['auto'];
				if($var_url && is_array($likely_arr)) {
					$key = array_rand($likely_arr);
					$this->pick_cache_data['lilely_page'][] = $likely_arr[$key];
				}
			}
			if($var_url){
				$this->now_url_arr = convert_url_range(array('url' => $var_url, 'step' => 1, 'start' => $var_arr['index'] ? 2 : 1, 'end' => 99, 'auto' => $auto) );
				if($var_arr['index']) array_unshift($this->now_url_arr, $var_arr['index']);
				$this->max_level = 2;
			}else{
				$this->now_url_arr = $start_arr;
				$this->max_level = $this->max_level ? $this->max_level : 2;
			}
			//print_r($this->now_url_arr);exit();
			$this->max_level = $this->p_arr['manyou_max_level'] ? $this->p_arr['manyou_max_level'] : 2;
		}
		if($this->p_arr['page_fiter'] == 1  && $this->now_url_arr){//�����˹�����ַ����
			if($this->p_arr['page_url_other']) {
				$this->now_url_arr = array_merge(format_wrap($this->p_arr['page_url_other']), $this->now_url_arr);
				$this->temp_arr['page_num'] = count($this->now_url_arr);	
			}	
		}
		$this->pick_cache_data['max_level'] = $this->max_level;
	}
	
	function run_start($clear_log = 0){
		if($this->error) return FALSE;
		if($_POST['clear_log'] || $clear_log == 1){
			unset($this->pick_cache_data);
			$this->i = 1;
			show_pick_info(milu_lang('clear_log'), '', $this->msg_args);
			update_times($this->pid);
			DB::query('DELETE FROM '.DB::table('strayer_url')." WHERE pid = '".$this->pid."'");
		}
		if($this->i > 1 ){
			$this->get_now_url_arr($this->now_level);
			if(!$this->now_url_arr) {
				$this->pick_cache_data = NULL;
				cache_del('pick'.$this->pid);
			}	

		}else{
			$this->get_start_url();//�����ڵ�ַ
			$this->now_level = $this->max_level;
		}
		if( $this->p_arr['rules_type'] == 1 && !$this->rid ){
			show_pick_info(milu_lang('pick_no_select_rules'), 'exit', $this->msg_args);
			return FALSE;
		}

		if(!$this->now_url_arr && $this->i == 1){ 
			show_pick_info(milu_lang('pick_no_link'), 'exit', $this->msg_args);
			return FALSE;
		}
		if($this->i == 1) show_pick_info(milu_lang('pick_get_linked').milu_lang('el'), '', $this->msg_args);
		if(!$this->max_level){
			show_pick_info(milu_lang('no_set_level'), 'exit',$this->msg_args);
			return FALSE;
		}
		$this->robot($this->now_level);
		$this->finsh();
	}

	function robot($level){
		global $_G;
		$pick_config = $_G['cache']['evn_milu_pick']['pick_config'];
		$del_flag = 0;
		$this->now_level = $level;
		if(!$this->now_url_arr) $this->restart_robot($this->now_level);
		if(!$this->pick_cache_data['url_arr'][$this->now_level]) {
			$this->pick_cache_data['url_arr'][$this->now_level] = $this->now_url_arr;
		}
		foreach((array)$this->now_url_arr as $k => $url){
			d_s('run');
			if($this->p_arr['pick_num'] && ($this->i == $this->p_arr['pick_num'] + 2) || ( $this->p_arr['pick_num'] && $this->i > $this->p_arr['pick_num'] + 2) ) return;
			$this->pick_cache_data['now_level'] = $this->now_level;
			$this->now_url = $url;
			if($this->p_arr['url_range_type'] == 3 || $this->now_level == $this->p_arr['manyou_max_level']){
				$host_arr = $this->GetHostInfo($url);
				$this->base_url = $host_arr['host'];
			}

			$this->format_url();
			$show_args = array_merge($this->msg_args, array('li_no_end' => 1, 'no_border' => 1, 'now' => $this->i));
			show_pick_info(array(milu_lang('read_link'), $this->now_url), 'url', $show_args);
			$this->i++;
			$this->temp_arr['have_reply'] = 0;
			$this->pick_cache_data['i'] = $this->i;
			$visit_flag = $this->check_visit_url();
			if($visit_flag > 0 ){
	
				if($this->now_level == 1){
					if($this->p_arr['rules_type'] == 3){//����һ���ɼ�,�жϴ���ַ�Ƿ�������ҳ
						if(!$this->check_fastpick_viewurl($this->now_url)) {
							continue;
						}else{
							//exit($this->now_url);
						}
					}
					$content = $this->parse_page();
					$this->status_arr['now'] = $this->i;
					show_pick_info('', 'success', $this->status_arr);
					if($this->p_arr['stop_time'][0]) sleep($this->p_arr['stop_time'][0]);
					$get = 0;
					$this->temp_arr['have_page'] = 0;
					if($this->p_arr['content_page_rules'] ) {//��ҳ����				
						if($this->p_arr['reply_rules'] || $this->p_arr['reply_is_extend']){//�ظ�
							
						}else{
							$content_page_arr = $this->get_content_page($content);
							if($content_page_arr){
								$get = 1;
								$this->a++;
								$this->pick_cache_data['a'] = $this->a;
								$this->temp_arr['have_page'] = 1;
								$article_info_arr = $this->page_get_content($content, array(), array(), $content_page_arr);
								if($article_info_arr) {
									//ȡ��������
									$other_arr = $this->get_article_other($content);
									$other_arr = $other_arr ? $other_arr : array();
									$article_info_arr = array_merge($article_info_arr, $other_arr);
									$this->create_page_article($article_info_arr);//��ҳ���µ����
								}else{
									$this->v_a++;
									$this->pick_cache_data['v_a'] = $this->v_a;
								}	
							}
						}
					}
					if($get == 0){//��ͨ����
						$ori_title = $this->get_ori_title($content);
						$now =  '-'.($this->i - 1).time();
						$show_args = array_merge($this->msg_args, array('li_no_end' => 1, 'no_border' => 1, 'now' => $now));
						show_pick_info(array(milu_lang('read_content'), cutstr($ori_title, 85)), 'left', $show_args);
						$article_info = $this->get_article($content);
						$this->status_arr['now'] = $now;
						show_pick_info('', 'success', $this->status_arr);
						
						$article_info = $this->format_article($article_info);
						
						$this->get_pick_status();
						$this->status_arr['now'] =  '-'.($this->i - 1).time();
						$show_args = array_merge($this->msg_args, array('li_no_end' => 1, 'no_border' => 1, 'now' => $now));
						$this->temp_arr['normal_now'] = $now;
						show_pick_info(array(milu_lang('article'), cutstr(trim($article_info['title']), 85)), 'left', $show_args);
						
						if($this->check_article($article_info)){
							$this->create_article($article_info);
						}else{
							$this->v_a++;
							$this->pick_cache_data['v_a'] = $this->v_a;
						}
						
					}
					$this->insert_url();
					if($this->aid || $this->public_info['insert_aid']){
						if($this->p_arr['reply_rules'] || $this->p_arr['reply_is_extend'] ){//�����лظ�
							if($this->p_arr['is_public_del'] == 1 && $this->p_arr['is_auto_public'] == 1 && $this->p_arr['public_type'] != 2){
							//���ֱ�ӷ����������Ƿ�������⣬���Ҳ��Ƿ�������̳���Ͳ��زɼ��ظ�
							}else{
								$now =  '-'.($this->i - 1).time();
								$show_args = array_merge($this->msg_args, array('li_no_end' => 1, 'no_border' => 1, 'now' => $now));
								$this->temp_arr['reply_now'] = $now;
								show_pick_info(array(milu_lang('pick_reply')), 'left', $show_args);
								if(strexists($this->p_arr['reply_max_num'], ',')) {
									$arr = explode(',', $this->p_arr['reply_max_num']);
									$this->reply_max_num = rand($arr[0], $arr[1]);
								}else{
									$this->reply_max_num = intval($this->p_arr['reply_max_num']);
								}
								$this->oldurl_arr = NULL;
								$reply_arr = $this->page_get_reply($content, array($this->now_url));
								$reply_arr = sarray_unique($reply_arr);//ȥ�ظ�����
								$this->create_reply($reply_arr);
								$this->oldurl_arr = NULL;
								$this->temp_arr['have_reply'] = 1;
							}
						}
					}
				}
				$msg = '';
				$link_count = 0;
				$next_link = array();
				if($this->now_level > 1){
					if($this->p_arr['url_range_type'] == 1 || $this->p_arr['url_range_type'] == 5 || $this->p_arr['rules_type'] == 1){//��ҳ�б�����б��ȡ�����ù���
						if($this->p_arr['url_range_type'] == 5){
							$key_level  = abs($this->now_level - 1 - count($this->p_arr['many_page_list'])) + 1;
							$rules_arr = $this->p_arr['many_page_list'][$key_level];
						}else if($this->p_arr['url_range_type'] == 1 || $this->p_arr['rules_type'] == 1){
							$rules_arr['type'] = $this->p_arr['page_get_type'];
							$rules_arr['rules'] = $this->p_arr['page_link_rules'];
						}
						$content = $this->parse_page();
						if($rules_arr['type'] == 1){
							$next_link = dom_page_link($content, array('page_link_rules' => $rules_arr['rules'], 'url' => $this->now_url) );
						}else if($rules_arr['type'] == 2){
							$next_link = string_page_link($content, trim($rules_arr['rules']), $this->now_url);
						}else{
							$next_link = evo_get_pagelink($content, $this->now_url);
						}
						if($this->p_arr['url_range_type'] == 1 && !$rules_arr['rules']) $msg = ' : '.milu_lang('no_set_list_rules');
						$link_count = $this->temp_arr['per_num'] = count($next_link); 

						if($link_count == 0 && $rules_arr['rules']) $msg = ' : '.milu_lang('check_list_rules');
						$this->get_pick_count(); 
					}else if($this->p_arr['rules_type'] == 3){//һ���ɼ�
						$content = $this->parse_page();
						$next_link = evo_get_pagelink($content, $this->now_url, $this->pick_cache_data['lilely_page']);
						$link_count = count($next_link);
					}	
					$this->get_pick_status(1);
					show_pick_info(milu_lang('get_link_c', array('c' => $link_count)).$msg, $link_count > 0 ? 'success' : 'err', $this->status_arr);
				
					if($next_link) $this->pick_cache_data['url_arr'][$this->now_level - 1] = $this->now_url_arr = $next_link;
				}else{
					$next_link = $this->now_url_arr = $this->pick_cache_data['url_arr'][$this->now_level];
				}
				if(!$this->flip()) return;
				$this->del_session_arr($this->now_level);
				if(!$this->pick_cache_data['url_arr']) {
					return;
				}
				$del_flag = 1;
				if($this->now_level > 1 && $next_link) {
					$this->now_level -= 1; 
					$this->robot($level - 1);
				}
			}else{
				$this->v_i++;
				$this->pick_cache_data['v_i'] = $this->v_i;
				$this->get_pick_status(1);
				show_pick_info(milu_lang('no_visit_err'.$visit_flag), 'err', $this->status_arr);
				if(!$this->flip()) return;
			}
			if($del_flag != 1) $this->del_session_arr($this->now_level);
		}
		$this->now_level += 1;
		$this->restart_robot($this->now_level);
	}

	//��ȡԭʼ�ı���
	function get_ori_title($content){
		preg_match("/<title>(.*?)<\/title>/is", $content, $arr);
		return trim($arr[1]);
	}
	

	//�ж�һ����ַ�Ƿ�������ҳ
	function check_fastpick_viewurl($url){
		$lilely_page_arr = $this->pick_cache_data['lilely_page'];
		return check_fastpick_viewurl($url, $lilely_page_arr);
	}
	
	//��ȡ��ҳ�ظ�
	function page_get_reply($content, $oldurl_arr, $reply_arr = array(), $get_num = 0){
		$this->oldurl_arr = $oldurl_arr;
		if($this->reply_max_num == count($reply_arr) ) return $reply_arr;
		$tem_arr = $this->get_reply($content, $get_num);
		$reply_arr = array_merge($reply_arr, $tem_arr);
		if(count($reply_arr) == $this->reply_max_num) return $reply_arr;
		if($this->p_arr['content_page_rules']){//�ظ����з�ҳ����
			$content_page_arr = $this->get_content_page($content);
			foreach((array)$content_page_arr as $k => $v){
				if($v == '#' || !$v || $v == $this->now_url || in_array($v, $this->oldurl_arr)) continue;
				$page_url_arr = parse_url($v);
				parse_str($page_url_arr['query'], $url_info);
				if($url_info['page'] == 1) continue;//��Щ��̳��������һҳ
				$this->oldurl_arr[] = $v;
				$content = get_contents($v, array('cookie' => $this->p_arr['login_cookie'], 'cache' => $this->cache_time));
				$get_num = $this->reply_max_num -  count($reply_arr);
				if($get_num  < 0 || $get_num == 0) return $reply_arr;
				if($this->p_arr['content_page_get_mode'] == 1){//ȫ���г�ģʽ
					$reply_arr = array_merge($reply_arr, $this->get_reply($content, $get_num));
				}else{
					$reply_arr = $this->page_get_reply($content, $this->oldurl_arr, $reply_arr, $get_num);
				}
				if($this->reply_max_num == count($reply_arr)) return $reply_arr;
			}
		}
		return $reply_arr;
	}

	
	//��ȡ�ظ�
	function get_reply($content, $reply_num = 0){
		$type = $reply_num == 0 && ($this->p_arr['reply_rules'] == $this->p_arr['content_rules'] ) ? 'reply' : 'all';
		$reply_num = $reply_num > 0 ? $reply_num : $this->reply_max_num;
		if($this->p_arr['reply_get_type'] == 1){
			$reply_arr = dom_get_manytext($content, $this->p_arr['reply_rules'], $type , $reply_num);
		}else{
			$this->p_arr['reply_rules'] = str_replace('[body]', '[reply]', $this->p_arr['reply_rules']);
			$reply_arr = str_get_str($content, $this->p_arr['reply_rules'], 'reply', -1);
			if($type == 'reply') unset($reply_arr[0]);
			$reply_arr = count($reply_arr) > $reply_num ? array_slice($reply_arr, 0, $reply_num) : $reply_arr;
		}
		$reply_arr = sarray_unique($reply_arr);
		$reply_arr = array_filter($reply_arr);
		return (array)$reply_arr;
	}
	
	//ȡ�����£����Ҹ�ʽ���������ж��Ƿ�ϸ�
	function get_article_result($content, $url, $page = 1){
		$info = $this->get_article($content, $url);
		
		if(!$info['content']){
			return -1;
		}
		$info['page'] = $page;
		
		$now =  '-'.($this->i - 1).time();
		$show_args = array_merge($this->msg_args, array('li_no_end' => 1, 'no_border' => 1, 'now' => $now));
		if($page == 1) {
			show_pick_info(array(milu_lang('read_content'), cutstr(trim($info['other']['old_title']), 95)), 'left', $show_args);
			$this->status_arr['now'] = $now;
			show_pick_info('', 'success', $this->status_arr);
		}	
		show_pick_info(array(milu_lang('pick_page',array('page' => $page)), '<a href="'.$info['url'].'" target="_blank">'.cutstr(trim($info['url']), 75).'</a>'), 'left', $show_args);	
		
		
		$info = $this->format_article($info);//��ʽ����������
		$check_re = $this->check_article($info);
		if(!$check_re) return FALSE;
		$num = DB::result_first('SELECT COUNT(*) FROM '.DB::table('strayer_article_title')." WHERE pid='".$this->pid."' AND url_hash = '".md5($url)."'");
		
		
		if($num) {
			$this->get_pick_status(1);
			$this->status_arr = array_merge($this->msg_args, $this->status_arr);
			$this->status_arr['now'] = $now;
			show_pick_info(milu_lang('article_exist'), 'err', $this->status_arr);
			return FALSE;
		}else{
			$this->status_arr = array_merge($this->msg_args, $this->status_arr);
			$this->status_arr['now'] = $now;
			show_pick_info(milu_lang('finsh'), 'success', $this->status_arr);
		}
		
		
		if(!$info) return 1;//��Щ��ҳ��Ȼû��ȡ�����ݣ����ǲ����������ɼ����ж�
		return $info;
	}
	
	//ȡ�÷�ҳ����
	function page_get_content($content, $oldurl = array(), $content_arr = array(), $content_page_arr = array() ){
		if(!$content_arr) {
			$this->page_hash[] = md5($content);
			$re_info = $this->get_article_result($content, $this->now_url, 1);
			if(!$re_info){
				unset($content_arr);
				return FALSE;
			}
			if(intval($re_info) != -1) $content_arr[$this->now_url] = $re_info;
		}
		foreach((array)$content_page_arr as $k => $v){
			if($v == '#' || !$v || $v == $this->now_url || in_array($v, $oldurl)) continue;
			$url_parse_arr = parse_url(strtolower($v));
			parse_str($url_parse_arr['query'], $page_temp_arr);
			if($page_temp_arr['page'] == 1) continue;
			$content = get_contents($v, array('cookie' => $this->p_arr['login_cookie'], 'cache' => $this->cache_time));
			$hash = md5($content);
			if(in_array($hash, $this->page_hash)) continue;
			$oldurl[] = $v;
			$this->page_hash[] = $hash;
			$num = count($content_arr) + 1;
			$re_info = $this->get_article_result($content, $v, $num);
			if(!$re_info) {//һ���κ�һ����ҳ���ϸ���ƪ���²���⣬ȫ�����ϸ�
				unset($content_arr);
				return FALSE;
			}
			if(intval($re_info) == -1)	{
				$num--;
				continue;
			}
			if (!array_key_exists($content, $content_arr)) {
				 $content_arr[$v] = $re_info;
			}	
			if($this->p_arr['content_page_get_mode'] != 1){//ȫ���г�ģʽ
				$content_page_arr = $this->get_content_page($content);
				return $this->page_get_content($content, $oldurl, $content_arr, $content_page_arr);
			}			
		}
		return $content_arr;
	}
	
	//��ȡ��ҳurl�б�
	function get_content_page($content){
		if($this->p_arr['content_page_get_type'] == 1){
			$html = get_htmldom_obj($content);
			if(!$html) return false;
			foreach($html->find($this->p_arr['content_page_rules']) as $v) {
				$a_url = $this->format_url($v->attr['href']);
				if(!$a_url || $a_url == '#' || $v->innertext == milu_lang('up_page')) continue; 
				$item[] = _expandlinks($a_url, $this->base_url);
				$re_arr = sarray_unique($item);
				
			}
			$html->clear();
			unset($html);
		}else{
			$re_arr = string_page_link($content, $this->p_arr['content_page_rules'], $this->now_url);//�ַ���
		}
		return $re_arr;
	}
	
	
	//�ݹ�ɾ��
	function del_session_arr($level){	
		if($level > $this->max_level) return;
		if(!$this->pick_cache_data['url_arr'][$level-1]) {//ɾ��Ŀǰ�Ĳ�
			$arr = $this->pick_cache_data['url_arr'][$level];
			$arr = $arr ? $arr : array();
			$new_arr = array_splice($arr, 1);
			if($new_arr){
				$this->pick_cache_data['url_arr'][$level] = $new_arr;
			}else{
				unset($this->pick_cache_data['url_arr'][$level]);
			}
		}else{
			return;
		}
		return $this->del_session_arr($level+1);
		unset($arr, $new_arr);
	}
	
	function restart_robot($level){
		if($level > $this->max_level) return;
		$this->get_now_url_arr($level);
		if($this->now_url_arr) $this->robot($level);
	}

	//��ȡ��ǰ��url����
	function get_now_url_arr($level){
		if(!$level) $level = $this->now_level;
		if(!$level || ( $level > $this->max_level ) ) return;
		$this->now_url_arr = $this->pick_cache_data['url_arr'][$level];//ȡ��Ŀǰ���url����
		if(!$this->now_url_arr) {//���Ŀǰ�Ĳ�û��ȡ����������һ��ȥȡ
			$this->now_url_arr = $this->get_now_url_arr($level + 1);
			return $this->now_url_arr;
		}else{//���ȡ����
			$arr = array();
			$this->now_level = $level;
			return $this->now_url_arr;
		}
	}

	function format_url($url = array()){
		$this->now_url = convert_url($this->now_url);
		if($url){
			if(is_array($url)){
				foreach($url as $k => $v){
					$new_arr[$k] = convert_url($v);
				}
				return $new_arr;
			}else{
				return convert_url($url);
			}
		}
	}
	
	function get_article($content,$url = ''){
		global $_G;
		$url = $url ? $url : $this->now_url;
		$pick_config = $_G['cache']['evn_milu_pick']['pick_config'];
		require_once libfile('function/home');
		if($this->temp_arr['have_page'] != 1){
			$this->a++;
			$this->pick_cache_data['a'] = $this->a;
		}
		if($this->p_arr['rules_type'] == 3){//һ���ɼ�
			$article_info = get_single_article($content, $url);
		}else{
			
			//��ȡ����
			if($this->p_arr['theme_get_type'] == 3){//����ʶ��
				$article_info = get_single_article($content, $url);
			}else if($this->p_arr['theme_get_type'] == 1){//dom��ȡ
				$article_info = dom_single_article($content, array('title' => $this->p_arr['theme_rules']));
			}else if($this->p_arr['theme_get_type'] == 2){//�ַ���
				$re = pregmessage($content, '<title>[title]</title>', 'title', -1);
				$article_info['other']['old_title'] = $re[0];
				$article_info['title'] = str_get_str($content, $this->p_arr['theme_rules'], 'title', -1);
			}
			//����Ҫ������Ĺ���������������html
			$article_info['title'] = format_html($article_info['title']);
			
			if(!trim($article_info['title'])) return $article_info;//������ⶼȡ�����������˷�ʱ���ȡ����
			
			
			//��ȡ����
			if($this->p_arr['content_get_type'] == 3){//����ʶ��
				if($this->p_arr['theme_get_type'] != 3){
					$info_arr = get_single_article($content, $url);
					$article_info['content'] = $info_arr['content'];
				}
			}else if($this->p_arr['content_get_type'] == 1){//dom��ȡ
				$info_arr = dom_single_article($content, array('content' => $this->p_arr['content_rules']));
				$article_info['content'] = $info_arr['content'];
			}else if($this->p_arr['content_get_type'] == 2){//�ַ���
				$article_info['content'] = str_get_str($content, $this->p_arr['content_rules'], 'body', -1);
			}
			if(!$article_info['content'] && $pick_config['ask_mode'] == 1) $article_info['content'] = $article_info['title'];
			
			//ȡ��������
			$other_arr = $this->get_article_other($content);
			
			$other_arr = $other_arr ? $other_arr : array();
			$article_info = array_merge($article_info, $other_arr);
		}
		//����
		if($this->p_arr['is_download_file'] == 1) $article_info['content'] = attach_format($url, $article_info['content']); 
		
		//��Ҫ�ظ����ܿ���������
		if(VIP) $article_info['content'] = post($article_info['content'], array('cookie' => $this->p_arr['login_cookie'], 'page_url' => $url));
		$article_info['content'] = format_html($article_info['content']);	
		$article_info['content'] = unhtmlentities($article_info['content']);
		$article_info['url'] = $url;
		$article_info['content'] = clear_ad_html($article_info['content']);
		$article_info['content'] = getstr($article_info['content'], 0, 1, 1, 0, 1);
		return $article_info;
	}
	
	
	
	//���������ݽ��д���
	function format_article($article_info){
		
		//�������±�������ݣ������滻�͹���
		$article_info = dstripslashes($article_info);
		$format_args_title = array(
			'is_fiter' => $this->p_arr['is_fiter_title'],
			'show_type' => 'title',
			'test' => 2,
			'result_data' => $article_info['title'],
			'replace_rules' => $this->p_arr['title_replace_rules'],

			'filter_data' => $this->p_arr['title_filter_rules'],
		);
		$article_info['title'] = filter_article($format_args_title);
		$article_info['title'] = unhtmlentities(strip_tags($article_info['title'], '&nbsp;'));
		$article_info['title'] = getstr(trim($article_info['title']), 80, 1, 0, 0, 1);
		$article_info['content'] = media_format($article_info['content'], $this->now_url);//
		
		$content_filter_html = $this->p_arr['content_filter_html'];
		if($this->p_arr['is_download_file'] == 1){
			$a_key = array_search('0', $content_filter_html);
			if(!$a_key) unset($content_filter_html[$a_key]); //���Ҫ���ظ�������Ҫȥ��a��ǩ
		}
		
		$article_info['content'] = trip_runma($article_info['content']);
		
		$format_args_content = array(
			'is_fiter' => $this->p_arr['is_fiter_content'],
			'show_type' => 'body',
			'test' => 2,
			'result_data' => $article_info['content'],
			'filter_html' => $content_filter_html,
			'replace_rules' => $this->p_arr['content_replace_rules'],
			'filter_data' => $this->p_arr['content_filter_rules'],
		);
		$article_info['content'] = filter_article($format_args_content);
		
		$format_arr = format_article_imgurl($this->now_url, $article_info['content']);
		$article_info['content'] = $format_arr['message'];
		$article_info['content'] = clear_ad_html($article_info['content']);//ȥ��js��ע�ͺͿ�ܵ�
		$article_info['pic'] = $format_arr['pic'];
		return $article_info;
	}
	//�Իظ����д���
	function format_reply($reply_data){
		if(!$this->base_url) $this->base_url = $this->now_url;
		foreach($reply_data as $k => $v){
			//����
			$v = dz_attach_format($this->base_url, $v);
			if($this->p_arr['is_download_file'] == 1) $v = attach_format($this->base_url, $v); 
			$v = media_format($v, $this->base_url);//
			$format_arr = format_article_imgurl($this->base_url, $v);//����ͼƬ·��
			$reply_data[$k] = $format_arr['message'];
		}
		$reply_filter_html = $this->p_arr['reply_filter_html'];
		if($this->p_arr['is_download_file'] == 1){
			$a_key = array_search('0', $reply_filter_html);
			if(!$a_key) unset($reply_filter_html[$a_key]); //���Ҫ���ظ�������Ҫȥ��a��ǩ
		}
		$format_args = array(
			'is_fiter' => $this->p_arr['is_fiter_reply'],
			'show_type' => 'reply',
			'test' => 2,
			'result_data' => $reply_data,
			'replace_rules' => $this->p_arr['reply_replace_rules'],
			'filter_html' => $reply_filter_html,
			'filter_data' => $this->p_arr['reply_filter_rules'],
		);
		$reply_data = filter_article($format_args);
		return $reply_data;
	}
	
	function create_reply($reply_arr){
		$end = $this->temp_arr['have_reply'] == 2 ? 0 : 1;
		$this->get_pick_status($end);
		$this->status_arr['now'] = $this->temp_arr['reply_now'] ? $this->temp_arr['reply_now'] : $this->i - 1;
		$this->status_arr = array_merge($this->msg_args, $this->status_arr);
		$reply_arr = $this->format_reply($reply_arr);
		$publiced  = FALSE;
		//�Զ���������.���ҷ����ظ�
		if($this->p_arr['is_auto_public'] == 1 && $this->p_arr['public_class'][0] && $this->p_arr['is_public_reply']){
			$publiced = $this->public_reply($reply_arr);
		}
		if($this->p_arr['is_public_del'] == 1 && $publiced) {//�����,ֱ�ӷ���
			show_pick_info(milu_lang('public_data'), 'success', $this->status_arr);
			return;
		}
		
		
		$setarr['aid'] = $this->aid;
		$r_n = 0;
		foreach((array)$reply_arr as $k => $v){
			$r_n ++;
			$setarr['pageorder'] = $k + 2; 
			$setarr['content'] = daddslashes($v); 
			$setarr['dateline'] = TIMESTAMP;
			$rid = DB::insert('strayer_article_content', $setarr, TRUE);
		}
		DB::update("strayer_article_title", array('reply_num' => $r_n), array("aid" => $this->aid));
		$this->aid = '';
		$this->temp_arr['reply_now'] = null;
		$this->public_info = null;
		show_pick_info(milu_lang('add_data'), 'success', $this->status_arr);
	}
	//�����ظ�
	function public_reply($reply_arr){
		if(!$reply_arr) return;
		$arr['fid'] = $this->p_arr['public_class'][0];
		$arr['tid'] = $this->public_info['insert_aid'];
		$arr['uid'] = $this->public_info['uid'];
		$arr['reply'] = $reply_arr;
		$arr['public_time'] = $this->public_info['public_time'];
		$arr['public_start_time'] = $this->public_info['public_time'];
		$arr['public_end_time'] = $this->public_info['public_time'] + 3600;
		$arr['is_public_reply'] = $this->p_arr['is_public_reply'];
		$arr['reply_uid'] =  $this->p_arr['reply_uid'];
		$arr['page_url'] = $this->now_url;
		$arr['cookie'] = $this->p_arr['login_cookie'];
		$arr['is_water_img'] = $this->p_arr['is_water_img'];
		$arr['is_download_img'] = $this->p_arr['is_download_img'];
		$arr['is_download_file'] = $this->p_arr['is_download_file'];
		$arr['title'] = $this->public_info['title'];
		return article_reply($arr);
	}
	
	//�ж�һƪ���µ������Ƿ����Ҫ��
	function check_article($arr){
		global $_G;
		$evo_rules = $_G['cache']['evn_milu_pick']['evo_rules'];
		if(!$this->temp_arr['have_reply']) {
			$this->temp_arr['have_reply'] = 2;
			$this->get_pick_status(1);
		}
		$this->status_arr['now'] = $this->status_arr['now'] - 1;	
		$this->status_arr = array_merge($this->msg_args, $this->status_arr);
		
		if($arr['content'] == 'list'){
			show_pick_info(milu_lang('is_page_web'), 'err', $this->status_arr);
			return FALSE;
		}
		
		$arr['title'] =trim($arr['title']);
		
		if(!$arr['title']){
			show_pick_info(milu_lang('no_get_title'), 'err', $this->status_arr);
			return FALSE;
		}
		$title_len = strlen(_striptext(trim($arr['title'])));
		if($title_len < 1) {
			show_pick_info(milu_lang('title_too_short'), 'err', $this->status_arr);
			return FALSE;
		}
		
		if(strlen($arr['title']) < $this->min_title_len){
			show_pick_info(milu_lang('so_short_title'), 'err', $this->status_arr);
			return FALSE;
		}
		if(array_key_exists('evo', $arr)){
			if($arr['evo'] != 2){
				if(!$arr['evo_title_info']) {
					show_pick_info(milu_lang('no_article_view'), 'err', $this->status_arr);//exit();
					return FALSE;
				}
				if($arr['evo'] == 0){
					$link_count = own_link_count($arr['content'], $this->now_url);
					if($link_count > $this->min_own_link) {
						show_pick_info(milu_lang('is_list_page'), 'err', $this->status_arr);
						return FALSE;
					}
				}
			}
		}
		
		
		$arr['content'] = trim($arr['content']);
		 if(!$arr['content']){
			show_pick_info(milu_lang('no_get_content'), 'err', $this->status_arr);
			return FALSE;
		}
		
		$content_len = strlen($arr['content']);
		if($content_len < $this->p_arr['article_min_len']*2 && $this->p_arr['article_min_len']){
			show_pick_info(milu_lang('data_too_short'), 'err', $this->status_arr);
			return FALSE;
		}	
		if($content_len > 600000){
			show_pick_info(milu_lang('data_too_long'), 'err', $this->status_arr);
			return FALSE;
		}
		
		if($this->p_arr['keyword_flag'] == 1){//���ؼ��ʹ���
			if(filter_something($arr['title'], $this->p_arr['keyword_title'])) {//�������
				show_pick_info(milu_lang('title_must_keyword'), 'err', $this->status_arr);
				return FALSE;
			}
			if(!filter_something($arr['title'], $this->p_arr['keyword_title_exclude'], TRUE)) {//������
				show_pick_info(milu_lang('title_no_must_keyword'), 'err', $this->status_arr);
				return FALSE;
			}
			if(filter_something($arr['content'], $this->p_arr['keyword_content'])) {//�������
				show_pick_info(milu_lang('content_must_keyword'), 'err', $this->status_arr);
				return FALSE;
			}
			if(!filter_something($arr['content'], $this->p_arr['keyword_content_exclude'], TRUE)) {//������
				show_pick_info(milu_lang('content_no_must_keyword'), 'err', $this->status_arr);
				return FALSE;
			}
		}
		
		return TRUE;	
	}
	
	function create_article($arr){
		global $_G;
		$this->status_arr = array_merge($this->msg_args, $this->status_arr);
		$this->status_arr['now'] = $this->temp_arr['normal_now'];
		//print_r($this->p_arr);exit();
		if($this->p_arr['is_auto_public'] == 1 && $this->p_arr['public_class'][0]){//�Զ���������
			$public_aid = $this->article_public($arr);
			if($public_aid < 0) {
				show_pick_info(milu_lang('article_publiced'), 'err', $this->status_arr);
				$this->v_a++;
				$this->pick_cache_data['v_a'] = $this->v_a;
				return FALSE;
			}	
			if($this->p_arr['public_type'] == 1){
				$setarr['portal_id'] = $public_aid;
			}else if($this->p_arr['public_type'] == 2){
				$setarr['forum_id'] = $public_aid;
			}else if($this->p_arr['public_type'] == 3){
				$setarr['blog_id'] = $public_aid;
			}
			$setarr['status'] = $this->temp_arr['article_status'] ? $this->temp_arr['article_status'] : 0;
		}
		if($public_aid && $this->p_arr['is_public_del'] == 1) {//�����,ֱ�ӷ���
			$this->public_info['insert_aid'] = $public_aid;
			if($public_aid) show_pick_info(milu_lang('public_data'), 'success', $this->status_arr);
			return;
		}
		//�����
		if($this->p_arr['reply_rules'] || $this->p_arr['reply_is_extend'] ) $setarr['is_bbs'] = 1;
		$setarr['pid'] = $this->pid;
		$setarr['url'] = $this->now_url;
		$setarr['pic'] = $arr['pic'];
		$setarr['title'] = $arr['title'];
		$setarr['from'] = $arr['from'];
		$setarr['author'] = $arr['author'];
		$setarr['article_dateline'] = $arr['article_dateline'];
		$setarr['contents'] = 1;
		$setarr['summary'] = portalcp_get_summary($arr['content']);
		$setarr['summary'] = $setarr['summary'];
		$setarr['dateline'] = $_G['timestamp'];
		$setarr['url_hash'] = md5($setarr['url']);
		//var_dump($setarr);exit();
		unset($arr['other']);
		
		
		$num = DB::result_first('SELECT COUNT(*) FROM '.DB::table('strayer_article_title')." WHERE pid='".$setarr['pid']."' AND url_hash = '".md5($arr['url'])."'");
		if($num) {
			$this->v_a++;
			$this->pick_cache_data['v_a'] = $this->v_a;
			show_pick_info(milu_lang('article_exist'), 'err', $this->status_arr);
			return FALSE;
		}
		$setarr = paddslashes($setarr);
		$this->aid = DB::insert('strayer_article_title', $setarr, TRUE);
		
		$this->article_timing_update($this->aid, $this->temp_arr['timing_id']);//���¶�ʱ����
		
		$setarr = array();
		//���ݱ�
		
		$setarr['aid'] = $this->aid;
		$setarr['content'] = $arr['content'];
		$setarr['pageorder'] = 1;
		$setarr['dateline'] = $_G['timestamp'];
		$setarr = paddslashes($setarr);
		$insert_id = DB::insert('strayer_article_content', $setarr, TRUE);
		if($this->aid) show_pick_info(milu_lang('add_data'), 'success', $this->status_arr);
	}
	//�з�ҳ������Ҫ����һЩ����
	function page_article_format($article_arr){
		$pic = 0;
		foreach((array)$article_arr as $k => $v){
			$pic += $v['pic'];
			$new_arr[] = $v;
		}
		$arr = $new_arr[0];
		$arr['pic'] = $pic;
		$arr['contents'] = count($article_arr);
		$arr['content_arr'] = $new_arr;
		return $arr;
	}
	
	//�з�ҳ���µ����
	function create_page_article($article_info_arr){		
		global $_G;
		$arr = $this->page_article_format($article_info_arr);
		
		$this->get_pick_status(1);
		$now = '-'.($this->i - 1).time();
		$show_args = array_merge($this->msg_args, array('li_no_end' => 1, 'no_border' => 1, 'now' => $now));
		
		show_pick_info(array(milu_lang('article'), $arr['title']), 'left', $show_args);
		$this->msg_args['now'] = $now; 
		if($this->p_arr['is_auto_public'] == 1 && $this->p_arr['public_class'][0]){//�Զ���������
			$public_aid = $this->article_public($arr);
			if($public_aid < 0) {
				show_pick_info(milu_lang('article_publiced'), 'err', $this->msg_args);
				$this->v_a++;
				$this->pick_cache_data['v_a'] = $this->v_a;
				return FALSE;
			}	
			if($this->p_arr['public_type'] == 1){
				$setarr['portal_id'] = $public_aid;
			}else if($this->p_arr['public_type'] == 2){
				$setarr['forum_id'] = $public_aid;
			}else if($this->p_arr['public_type'] == 3){
				$setarr['blog_id'] = $public_aid;
			}
			$setarr['status'] = $this->temp_arr['article_status'] ? $this->temp_arr['article_status'] : 0;
		}
		
		
		if($public_aid && $this->p_arr['is_public_del'] == 1) {//�����,ֱ�ӷ���
			$this->public_info['insert_aid'] = $public_aid;
			if($public_aid) show_pick_info(milu_lang('public_data'), 'success', $this->msg_args);
			return;
		}
		//�����
		$setarr['pid'] = $this->pid;
		$setarr['url'] = $this->now_url;
		$setarr['pic'] = $arr['pic'];
		$setarr['title'] = daddslashes($arr['title']);
		$setarr['contents'] = $arr['contents'];
		$setarr['summary'] = portalcp_get_summary($arr['content']);
		$setarr['summary'] = daddslashes($setarr['summary']);
		$setarr['dateline'] = $_G['timestamp'];
		$setarr['url_hash'] = md5($setarr['url']);
		unset($arr['other']);
		$this->aid = DB::insert('strayer_article_title', $setarr, TRUE);
		
		$this->article_timing_update($this->aid, $this->temp_arr['timing_id']);//���¶�ʱ����
		
		$setarr = array();
		//���ݱ�
		foreach($arr['content_arr'] as $k => $v){
			$setarr['aid'] = $this->aid;
			$setarr['content'] = daddslashes($v['content']);
			$setarr['pageorder'] = $v['page'];
			$setarr['dateline'] = $_G['timestamp'];
			$insert_id = DB::insert('strayer_article_content', $setarr, TRUE);
		}
		if($this->aid) show_pick_info(milu_lang('add_data'), 'success', $this->msg_args);
	}
	
	function article_timing_update($data_id, $id){
		if(!$id || !$data_id) return;
		DB::update('strayer_timing', array('data_id' => intval($data_id)), array('id' => $id));
		unset($this->temp_arr['timing_id']);
	}
	
	//���·���
	function article_public($arr){
		global $_G;
		pload('F:article');
		$timing_public_arr = array();
		$is_timing = $this->plugin_set['is_timing'];
		//if(!VIP) $is_timing = 0;
		$class_arr = $this->p_arr['public_class'];
		$old_arr = $arr;
		$arr['title'] = htmlspecialchars_decode($arr['title'], ENT_QUOTES);
		$arr['content'] = htmlspecialchars_decode($arr['content'], ENT_QUOTES);
		unset($arr['pic']);
		$view_arr = format_wrap($this->p_arr['view_num'], ',');
		$arr['view_num'] = rand($view_arr[0],$view_arr[1]);
		$rand_arr = get_rand_uid($this->p_arr);
		$arr['p_arr'] = $this->p_arr;
		$arr['uid'] = $this->public_info['uid'] =  $setarr['uid'] = $rand_arr[0]['uid'] ? $rand_arr[0]['uid'] : $_G['uid'];
		$arr['username'] = $setarr['username'] = $rand_arr[0]['username'] ? $rand_arr[0]['username'] : $_G['username'];
		$arr['portal_cid'] = $arr['forum_fid'] = $arr['blog_big_cid'] = $class_arr[0];
		$arr['forum_typeid'] = $arr['blog_small_cid'] = $class_arr[1];
		$arr['is_download_img'] = $this->p_arr['is_download_img'];
		$arr['is_download_file'] = $this->p_arr['is_download_file'];
		$arr['content_filter_html'] = $this->p_arr['content_filter_html'];
		$arr['is_water_img'] = $this->p_arr['is_water_img'];
		$arr['content'] = clear_ad_html($arr['content']);
		$arr['summary'] = addslashes($arr['summary']);
		$arr['public_start_time'] = $this->p_arr['public_start_time'];
		$arr['public_end_time'] = $this->p_arr['public_end_time'];
		$time_arr = create_public_time($arr, 1);
		$arr['public_time'] = $this->public_info['public_time'] =  array_pop ($time_arr);
		$arr['public_reply_seq'] = $this->p_arr['public_reply_seq'];
		$arr['is_public_reply'] = $this->p_arr['is_public_reply'];
		$arr['public_uid'] = $this->p_arr['public_uid'];
		$arr['reply_uid'] = $this->p_arr['reply_uid'];
		$arr['is_page_public'] = $this->p_arr['is_page_public'];
		$arr['check'] = 1;
		$arr['page_url'] = $this->now_url;
		$arr['is_bbs'] = ($this->p_arr['reply_rules'] || $this->p_arr['reply_is_extend'] ) ? 1 : 0;
		$this->temp_arr['article_status'] = 2;
		$this->temp_arr['timeing_data_id'] = 0;
		//����ʱ����ڵ�ǰʱ�䣬���붨ʱ������
		if($arr['public_time'] > $_G['timestamp'] && $is_timing == 1){
			if($this->p_arr['public_type'] == 1){//�Ż�
				$timing_public_arr['portal'] = $class_arr[0];
			}else if($this->p_arr['public_type'] == 2){//��̳
				$timing_public_arr['forums'] = $class_arr[0];
				$timing_public_arr['threadtypeid'] = $class_arr[1];
			}else{
				$timing_public_arr['blog'] = $class_arr[0];
				$timing_public_arr['classid'] =  $class_arr[1];
			}
			$this->temp_arr['article_status'] = 4;//�������ʱ������·���״̬Ϊ��ʱ����
			$timing_setarr = array('public_type' => $this->p_arr['public_type'], 'data_id' => 0, 'content_type' => 1, 'public_dateline' => $arr['public_time'], 'pid' => $this->pid, 'public_info' => serialize($timing_public_arr));
			$this->temp_arr['timing_id'] = DB::insert('strayer_timing', $timing_setarr, TRUE);
			return;
		}
		if($this->p_arr['is_word_replace'] == 1){//ͬ����滻
			if($this->p_arr['is_bbs'] != 1 && $arr['contents'] > 0){//�м�ҳ������
				$arr['content_arr'] = article_words_replace($arr['content_arr'], $this->words);
			}
			
			$arr['content'] = article_words_replace($arr['content'], $this->words);
			$arr['title'] = article_words_replace($arr['title'], $this->words);
			if($arr['reply']) $arr['reply'] = article_words_replace($arr['reply'], $this->words);
		}
		unset($arr['url']);//���Ż�����תurl����
		unset($arr['aid']);
		if($this->p_arr['public_type'] == 2){//��̳
			if($arr['contents'] > 1 && $arr['is_bbs'] == 0 && $this->p_arr['is_page_public'] != 1){
				$arr['is_public_reply'] = 1;
				$arr['public_reply_seq'] = 0;
				$arr['is_content_reply'] = 1;
				$arr['is_bbs'] = 1;
				unset($arr['content_arr'][0]);
				$arr['reply'] = $arr['content_arr'];
			}else{
				if($arr['is_bbs'] != 1) $arr['reply'] = array();
			}
			$arr = article_move_forums($arr, $old_arr);
			if(!is_array($arr)){
				if(!$arr) return -1;
			}
			$insert_aid = $setarr['forum_id'] = $arr['tid'];
		}else{
			if($this->p_arr['public_type'] == 1){//�Ż�
				$setarr['portal_id'] = $insert_aid = article_move_portal($arr, $old_arr);
			}else{//����
				$setarr['blog_id'] = $insert_aid = article_move_blog($arr, $old_arr);
			}
		}
		if($insert_aid){
			$arr['aid'] =  $insert_aid;
			if($this->p_arr['public_type'] == 2){//��̳
				$arr['cookie'] =  $this->p_arr['login_cookie'];
				if($arr['is_download_img'] == 1) forum_downremotefile($arr, $old_arr);
			}else{
				$type = $this->p_arr['public_type'] == 1 ? 'portal' : 'album';
				$arr['cookie'] =  $this->p_arr['login_cookie'];
				downremotefile($arr, $type, $old_arr);
			}	
			 if($type == 'portal') article_thumb($insert_aid);
		}else{
			return -1;
		}
		$this->public_info['insert_aid'] = $insert_aid;
		$this->public_info['title'] = $arr['title'];
		return $insert_aid;
	}
	
	function get_article_other($contents){
		if($this->p_arr['is_get_other'] != 1) return array();
		$data = (array)get_other_info($contents, $this->p_arr);
		$data['article_dateline'] = str_format_time($data['article_dateline']);
		return $data;
	}
	
	//�ж�һ����ַ�Ƿ�ֵ�÷��� �����Է����򷵻�false
	function check_visit_url(){
		global $_G;
		$this->format_url();
		$evo_rules = $_G['cache']['evn_milu_pick']['evo_rules'];
		$no_url = $evo_rules['no_url'];
		if(!filter_something($this->now_url, $no_url, TRUE)) return FALSE;
		if($this->p_arr['page_fiter'] == 1 && ( $this->now_level < $this->max_level )){//��������ַ������ ��ڵ�ַ��Ҫ����
			//�����и�bug������ĳЩurl��֪��Ϊ��now_level����max_level����������û����
			if($this->p_arr['page_url_no_other']){//Ҫ���˵���ַ
				$user_no_arr = format_wrap(trim($this->p_arr['page_url_no_other']));
				$user_no_arr = $this->format_url($user_no_arr);
				if(in_array($this->now_url, $user_no_arr)) return -1;
			}
			if(filter_something($this->now_url, $this->p_arr['page_url_contain'])) return -2;//�������
			if(!filter_something($this->now_url, $this->p_arr['page_url_no_contain'], TRUE)) return -3;//������
		}
		if($this->p_arr['rules_type'] == 3){
			$this->p_arr['only_in_domain'] = $this->p_arr['only_in_domain'] ? $this->p_arr['only_in_domain'] : 1;
			if(($this->p_arr['only_in_domain'] == 0) && !strexists($this->now_url, $this->base_url)) return -4;//ָ��������
		}
		if(!$_GET['no_check_url']){
			$v_info = DB::fetch_first('SELECT uid FROM '.DB::table('strayer_url')." WHERE  pid='".$this->pid."' AND hash='".md5(daddslashes($this->now_url))."'");
			if($v_info && $this->now_level == 1 ) return -5;//��Щ�б���Ҫ�ظ����ʵ�
		}
		return 1;
	
	}
	
	function insert_url($url = ''){
		if(!$url) $url = $this->now_url;
		$host_arr = $this->GetHostInfo($url);
		$arr = array('dateline' => TIMESTAMP, 'pid' => $this->pid, 'host' => $host_arr['host'], 'hash' => md5($url));
		return DB::insert('strayer_url', $arr, TRUE);
	}
	
	function get_pick_count(){
		if($this->pick_cache_data['get_count']) return $this->pick_cache_data['get_count'];
		
		if($this->temp_arr['page_num'] && $this->temp_arr['per_num']){
			$get_count = $this->temp_arr['page_num'] * $this->temp_arr['per_num'] + $this->temp_arr['page_num'];
		}else{
			$get_count = 0;
		}
		if($this->p_arr['pick_num'] && $ths->p_arr['pick_num'] < $get_count){
			$get_count = $this->p_arr['pick_num'];
		}
		$this->pick_cache_data['get_count'] = $get_count;
		return $get_count;	
	}
	
	function GetHostInfo($gurl){
		$gurl = preg_replace("/^http:\/\//i", "", trim($gurl));
		$garr['host'] = preg_replace("/\/(.*)$/i", "", $gurl);
		$garr['query'] = "/".preg_replace("/^([^\/]*)\//i", "", $gurl);
		return $garr;
	}
	
	function get_pick_status($end = 0){
		$get_count = $this->get_pick_count();
		if($end == 1) {
			$get_time = d_e(0, 'run');
			$this->all_get_time += $get_time;
			$this->pick_cache_data['all_get_time'] = $this->all_get_time;
		}
		if($get_count){
			$pro = ceil(100 * ($this->i/$get_count));
			if($pro == 101 || $pro > 101) return; 
		
			$avg_get_time = $this->all_get_time/$this->i;
			$wait_count = $get_count - $this->i;
			$wait_time = $avg_get_time * $wait_count;
		}else{
			$pro = $wait_time = $wait_count = milu_lang('un_know');
		}	
		
		
		if(function_exists('php_set')){			
			$memory = (100 * (get_memory()/php_set('memory_limit'))); 
			$memory = ($memory || $memory != 0) ? sprintf('%.0f%%',$memory) :  milu_lang('un_know');
		} 
		
		$wait_time = is_numeric($wait_time)  ? round($wait_time) : $wait_time;
		
		$this->status_arr = array('pro' => $pro, 'wait_time' => $wait_time, 'memory' => $memory, 'wait_count' => $wait_count, 'now' => $this->i);
		$this->status_arr = array_merge($this->status_arr, $this->msg_args);
	}
	
	//��ҳ
	function flip(){
		$get_count = $this->pick_cache_data['get_count'] + 1;
		if(($this->i == $get_count || $this->i > $get_count) && $get_count > 1) {
			$this->finsh();
			return FALSE;
		}
		if(intval($this->pick_config['pick_config']['max_memory_per']) < intval($this->status_arr['memory'])) {
			show_pick_info(milu_lang('to_max_memory'), 'finsh', $this->status_arr);
			$this->finsh();
			exit();
		}	
		$jump_num = $this->p_arr['jump_num'] ? $this->p_arr['jump_num'] : $pick_config['pick_num'];
		$j = intval($this->i) - 1;
		if(is_int($j / $jump_num) && $j != 0 && $this->msg_args['is_cron'] !=1 ){
			if($this->p_arr['stop_time'][1]) sleep($this->p_arr['stop_time'][1]);
			cache_data('pick'.$this->pid, $this->pick_cache_data);
			data_go('picker_manage&pid='.$this->pid.'&myaction=get_article&submit=1&no_check_url='.$_GET['no_check_url']);
			exit();
		}
		return TRUE;
	}
	
	function finsh(){
		cache_del('pick'.$this->pid);	
		$this->all_get_time = $this->pick_cache_data['all_get_time'];
		$all_get_time_str = diff_time($this->all_get_time, 1);
		$get_url_count = $this->i - 1; 
		$avg_get_time = $this->all_get_time/$get_url_count;
		$all_get_time_str = $all_get_time_str ? $all_get_time_str : sprintf('%.2f',$this->all_get_time).milu_lang('sec');
		$finsh_output = milu_lang('pick_finsh', array('guc' => $get_url_count, 'g_v' => $get_url_count - $this->v_i, 'v_i' => $this->v_i, 'a' => $this->a, 'a_va' => $this->a - $this->v_a, 'v_a' => $this->v_a, 'all' => $all_get_time_str, 'avg' => sprintf('%.2f',$avg_get_time)));
		$this->get_pick_status(1);		
		$this->status_arr['pro'] = 100;	
		$this->status_arr['wait_time'] = $this->status_arr['wait_count'] = 0;
		show_pick_info($finsh_output, 'finsh', $this->status_arr);
		$this->words = null;
		$this->snoopy = null;
		$this->p_arr = null;
		exit();
	}
	
	function __destruct(){
		
	}
	
}
?>
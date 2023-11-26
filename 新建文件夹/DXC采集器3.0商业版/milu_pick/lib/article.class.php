<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


class article{
	var $cache;
	var $import_cache;
	var $plugin_set;
	var $pick_set;
	var $pick_config;
	var $aid;
	var $step;
	var $errno;//错误码
	//args 传入的参数  array('optype' => $args['optype'], 'aid' => $aid, 'forums' => $args['forums'], 'portal' => $args['portal'], 'blog' => $args['blog'], 'threadtypeid' => $args['threadtypeid'], 'pid' => $args['pid'], 'check_title' => 0)
	function article($args = array()){
		global $_G;
		pload('F:spider');
		pload('F:article');
		$this->plugin_set = get_pick_set();
		$this->pick_set = pick_common_get();//插件设置
		$this->pick_config = $_G['cache']['evn_milu_pick'];
		
			
		$args['run_type'] = $args['run_type'] ? $args['run_type'] : 'normal';//手动执行，有些跳转之后，run_type这个参数会没法传递，此时为默认值
		$import_cache_key = $args['run_type'] == 'article_edit' ? 'normal' : $args['run_type']; 
		$this->import_cache = (array)pload_cache('article_bat_run_'.$import_cache_key);
		if(!empty($this->import_cache['run_type'])) $args['run_type'] = $this->import_cache['run_type'];
		if(empty($args['aid'])) $args['aid'] = $this->import_cache['current']['aid'];//多次跳转，aid参数也会没了。此时从保存的批量执行信息读取
		$this->cache = (array)pload_cache('article_public_run_'.$import_cache_key);
	
		if(!empty($args['aid']) && $this->cache['article_info']['aid'] != $args['aid']) $this->cache = FALSE;
		
		if(!$this->cache){//使用时，必须先清除缓存
			$this->pick_set['pick_today'] = dunserialize($this->pick_set['pick_today']);
			$aid = $args['aid'];
			$this->cache = $args;
			$this->cache['no_msg_action_arr'] = array('pick', 'timing', 'auto_timing');//不需要提示的 auto_timing是采集器定时发布。timing是全局定时发布
			$this->cache['p_arr'] = get_pick_info($args['pid']);
			$this->cache['run_type'] = $args['run_type']; 
			$this->cache['p_arr']['content_filter_html'] = unserialize(dstripslashes($this->cache['p_arr']['content_filter_html']));
			
			$this->cache['article_info'] = pick_article_info($aid);
			$this->article_seo_format();//seo伪原创
			$this->cache['mod'] = 'attach';//当前运行的任务 顺序是 attach 下载附件 article 发布文章  reply 发布回复 upload 附件上传
			$this->errno = 0;
			$this->cache['common'] = '';//保存公用的东西
			loadcache(array('threadsort_option_'.$this->cache['article_info']['sortid']));
			$this->cache['threadsort'] = $_G['cache']['threadsort_option_'.$this->cache['article_info']['sortid']];
			$this->cache['finsh'] = '';//用于文章发布之后更新状态
			$this->cache['article_info']['content_key_arr'] = array();
			if($this->cache['article_info']['content_arr']){
				$this->cache['article_info']['content_key_arr'] = array_keys($this->cache['article_info']['content_arr']);
			}
			$this->cache['article_info']['ori_content'] = $this->cache['article_info']['content'];
			if(!$this->cache['article_info']['view_num']){
				$this->cache['p_arr']['view_num'] = $this->cache['p_arr']['view_num'] ? $this->cache['p_arr']['view_num'] : 0;
				$this->cache['article_info']['view_num'] = $this->get_rand_data($this->cache['p_arr']['view_num']);
			}
			
			//发布时间
			$this->cache['article_info']['public_time'] = $this->get_article_dateline();
			//发布用户
			$user_info = $this->get_article_user_info();
			
			$this->cache['article_info']['public_uid'] = $user_info['uid'];
			$this->cache['article_info']['public_username'] = $user_info['username'];
			//标签
			if($this->pick_set['open_tag'] == 1 && $this->cache['optype'] != 'move_portal') $this->cache['article_info']['article_tag'] = $this->cache['article_info']['article_tag'] ? $this->cache['article_info']['article_tag'] : dz_get_tag($this->cache['article_info']['title'], $this->cache['article_info']['content']);
		}
		if($this->cache['run_type'] == 'article_edit'){
			$this->import_cache['total'] = 1;
		}
		$this->aid = $this->cache['article_info']['aid'];
		$this->step = $this->cache['run_step'];
		$this->plugin_set['title_length'] = $this->plugin_set['title_length'] ? $this->plugin_set['title_length'] : 80;
		
	}
	
	function run_start(){
		$this->free_version_limit();
		if($this->errno < 0) return $this->errno;
		$this->download_attach();
		$this->download_avatar();
		$this->article_timing();
		if($this->cache['is_timing'] == 1) return;//如果是定时发布，立即停止
		$this->article_public();
		$this->reply_public();
		$this->upload_attach();
		$this->public_finsh();
		$cache_key = $this->cache['run_type'] == 'article_edit' ? 'normal' : $this->cache['run_type']; 
		pcache_del('article_public_run_'.$cache_key);
		$this->finsh_redirect();//发布结束之后跳转
		
	}
	
	function free_version_limit(){
		if(VIP) return 1;
		if($this->pick_set['pick_today']['article_public_num'] < 120) return 1;
		if(in_array($this->cache['run_type'], $this->cache['no_msg_action_arr'])) {
			$this->errno = -111;
			return $this->errno;
		}
		cpmsg_error(milu_lang('article_public_limit', array('n' => 120)));
	}
	
	function finsh_redirect(){
		if($this->cache['run_type'] == 'article_edit'){
			$article_view_url_arr = array('move_portal' => 'portal.php?mod=view&aid='.$this->cache['finsh']['insert_id'], 'move_forums' => 'forum.php?mod=viewthread&tid='.$this->cache['finsh']['insert_id'], 'move_blog' => 'home.php?mod=space&do=blog&uid='.$this->cache['common']['public_uid'].'&id='.$this->cache['finsh']['insert_id']);
			$article_view_url = $article_view_url_arr[$this->cache['optype']];
			$return_url = '?'.PICK_GO.'picker_manage&myac=article_manage&p=1&pid='.$this->cache['p_arr']['pid'].$this->cache['url_args'];
			$return_list_html = '<a href="'.$return_url.'">'.milu_lang('return_list').'</a>';
			$article_view_output = '&nbsp;<span class="pipe">|</span>&nbsp;<a target="_blank" href="'.$article_view_url.'">'.milu_lang('view_article').'</a>';
			if($this->cache['timing']['public_time']){//定时发布
				cpmsg(milu_lang('bat_i_p_a_f_timing', array('t' => _striptext($this->cache['article_info']['title']), 'time' => dgmdate($this->cache['timing']['public_time']) )).'<br>'.$return_list_html, PICK_GO.'picker_manage&myac=pick_article_edit&aid='.$this->cache['article_info']['aid'].'&pid='.$this->cache['p_arr']['pid'], 'succeed');
				return;
			}else{
				cpmsg(milu_lang('bat_i_p_a_f', array('t' => _striptext($this->cache['article_info']['title']))).'<br><br><a href="?'.PICK_GO.'picker_manage&myac=pick_article_edit&aid='.$this->cache['article_info']['aid'].'&pid='.$this->cache['p_arr']['pid'].'">'.milu_lang('continue_edit').'</a>&nbsp;<span class="pipe">|</span>&nbsp;'.$return_list_html.$article_view_output, PICK_GO.'picker_manage&myac=pick_article_edit&aid='.$this->cache['article_info']['aid'].'&pid='.$this->cache['p_arr']['pid'], 'succeed');
			}
		
		}
		if(in_array($this->cache['run_type'], $this->cache['no_msg_action_arr'])) return;//
		
		$public_cache_data = pload_cache('article_bat_run_'.$this->cache['run_type']);
		$current = $public_cache_data['current'];
		$public_cache_data['current']['currow'] += 1;
		pcache_data('article_bat_run_'.$this->cache['run_type'], $public_cache_data);
		$msg = milu_lang('bat_i_p_a_f', array('t' => _striptext($current['title'])));
		if($this->cache['timing']['public_time']){//定时发布
			$msg = milu_lang('bat_i_p_a_f_timing', array('t' => _striptext($current['title']), 'time' => dgmdate($this->cache['timing']['public_time']) ));
		}
		cpmsg($msg.milu_lang('bat_import_article', array('t' => $public_cache_data['total'], 'p' => percent_format($public_cache_data['current']['currow'], $public_cache_data['total']))), PICK_GO.'picker_manage&myac=article_batch&tpl=no&step=1', 'loading', '', false);
	}
	
	//文章进入定时发布
	function article_timing(){
		global $_G;
		if(!VIP) return;
		if($this->pick_set['is_timing'] != 1) return;
		if($this->cache['article_info']['public_time'] <= $_G['timestamp']) return;
		$timing_public_arr = array();
		if($this->cache['optype'] == 'move_portal'){//门户
			$public_type = 1;
			$timing_public_arr['portal'] = $this->cache['portal'];
		}else if($this->cache['optype'] == 'move_forums'){//论坛
			$public_type = 2;
			$timing_public_arr['forums'] = $this->cache['forums'];
			$timing_public_arr['threadtypeid'] = $this->cache['threadtypeid'];
		}else{
			$public_type = 3;
			$timing_public_arr['blog'] = $this->cache['blog'];
			$timing_public_arr['classid'] =  $this->cache['threadtypeid'];
		}
		$this->cache['is_timing'] = 1;//定时发布的标志
		$this->temp_arr['article_status'] = 4;//文章入库时标记文章发布状态为定时发布
		$timing_setarr = array('public_type' => $public_type, 'data_id' => $this->cache['article_info']['aid'], 'content_type' => 1, 'public_dateline' => $this->cache['article_info']['public_time'], 'pid' => $this->cache['p_arr']['pid'], 'public_info' => pserialize($timing_public_arr));
		article_timing_add($timing_setarr);
		DB::update('strayer_article_title', array('status' => 4), array('aid' => $this->cache['article_info']['aid']));
		$this->cache['timing']['public_time'] = $this->cache['article_info']['public_time'];
		$this->cache['timing']['title'] = $this->cache['article_info']['title'];
		//如果有回复而且发布到论坛的话
		$timing_setarr = array();
		if($this->cache['article_info']['is_bbs'] == 1 && $this->cache['article_info']['content_arr'] && $this->cache['optype'] == 'move_forums'){
			$this->cache['common']['public_time'] = $this->cache['article_info']['public_time'];
			$this->cache['common']['public_uid'] = $this->cache['article_info']['public_uid'];
			$this->cache['common']['public_username'] = $this->cache['article_info']['public_username'];
			$this->cache['mod'] = 'reply';
			$this->cache['timing']['public_type'] = $public_type;
			$this->cache['timing']['timing_public_arr'] = $timing_public_arr;
			$this->cache['timing']['is_reply'] = 1;
			$this->reply_public();
			
		}
		if($this->cache['run_type'] == 'auto_timing'){//定时发布写入日志
			pload('F:pick');
			pick_log(milu_lang('cron_article_timing_public', array('t' => $this->cache['article_info']['title'], 'aid' => $this->cache['article_info']['aid'], 'd' =>  dgmdate($this->cache['timing']['public_time']))), array('log_type' => 'timing', 'pid' => $this->cache['p_arr']['pid']));//写入日志
		}
		$this->finsh_redirect();
	}
	

	//同义词替换、伪原创
	function article_seo_format(){
		//同义词替换
		$this->cache['article_info']['title'] = str_replace(array("\n", "\r\n"), " ",  $this->cache['article_info']['title']);//去掉标题中的换行
		if($this->cache['p_arr']['is_word_replace'] == 1){
			$words = get_replace_words();
			$this->cache['article_info']['title'] = strtr($this->cache['article_info']['title'], $words);//标题
			$this->cache['article_info']['content'] = strtr($this->cache['article_info']['content'], $words);//内容
			
			if($this->cache['article_info']['content_arr']){
				foreach($this->cache['article_info']['content_arr'] as $k => $v){
					if($v['content']) $this->cache['article_info']['content_arr'][$k]['content'] = strtr($v['content'], $words);
				}
			}
			
		}
		

		if($this->cache['p_arr']['open_seo'] == 1){
			//内容随机添加
			$key_arr = array('push_title_header','push_title_footer','push_content_header','push_content_body','push_content_footer','push_reply_header', 'push_reply_body', 'push_reply_footer');
			foreach($key_arr as $v){
				$$v = $this->cache['p_arr'][$v] = format_wrap($this->cache['p_arr'][$v]);
			}
			
			
			//标题加内容
			$title_header = $push_title_header ? $push_title_header[array_rand($push_title_header)] : '';
			$title_footer = $push_title_footer ? $push_title_footer[array_rand($push_title_footer)] : '';
			$this->cache['article_info']['title'] = $title_header.$this->cache['article_info']['title'].$title_footer;
			
			//内容加内容
			$content_header = $push_content_header ? $push_content_header[array_rand($push_content_header)] : '';
			$content_footer = $push_content_footer ? $push_content_footer[array_rand($push_content_footer)] : '';
			if($this->cache['article_info']['content_arr'] && ($this->cache['article_info']['is_bbs'] != 1 && $this->cache['p_arr']['is_page_public'] == 1) ) {//如果是文章分页选择合并发布
				$this->cache['article_info']['content'] = $content_header.$this->cache['article_info']['content'];
				$last = end($this->cache['article_info']['content_arr']);
				$this->cache['article_info']['content_arr'][$last['cid']]['content'] .= $content_footer;
			}else{
				$this->cache['article_info']['content'] = $content_header.$this->cache['article_info']['content'].$content_footer;
			}
			//回复加内容
			if($this->cache['article_info']['content_arr'] && ($this->cache['article_info']['is_bbs'] == 1 || ($this->cache['article_info']['is_bbs'] != 1 && $this->cache['p_arr']['is_page_public'] == 2  && $this->cache['optype'] == 'move_forums') )) {//是论坛回复，或者是文章分页，但是以不合并的方式发布到论坛
				foreach($this->cache['article_info']['content_arr'] as $k => $v){
					$reply_header = $push_reply_header ? $push_reply_header[array_rand($push_reply_header)] : '';
					$reply_footer = $push_reply_footer ? $push_reply_footer[array_rand($push_reply_footer)] : '';
					$this->cache['article_info']['content_arr'][$k]['content'] = $reply_header.$v['content'].$reply_footer;
				}
			}
			
			
		}
		//如果文章是分页，而且合并的方式发布到论坛上，那么把内容合并起来看做是一篇普通不分页的文章		
		if($this->cache['article_info']['content_arr'] && $this->cache['article_info']['is_bbs'] != 1 && $this->cache['p_arr']['is_page_public'] == 1 && $this->cache['optype'] == 'move_forums'){
			array_unshift($this->cache['article_info']['content_arr'], array('cid' => $this->cache['article_info']['cid'], 'aid'  => $this->cache['article_info']['aid'], 'pageorder' => 1, 'content' => $this->cache['article_info']['content'], 'title' => $this->cache['article_info']['title']));
			ksort($this->cache['article_info']['content_arr']);

			
			$this->cache['article_info']['content'] = content_merge($this->cache['article_info']['content_arr']);
			$this->cache['article_info']['contents'] = 1;
			$this->cache['article_info']['content_arr'] = array();
		}
		
	}
	
	function ftp_check_attach($ext, $filesize){
		global $_G;
		if(!$_G['setting']['ftp']['on']) return TRUE;//不开启ftp不检测
		if(((!$_G['setting']['ftp']['allowedexts'] && !$_G['setting']['ftp']['disallowedexts']) || ($_G['setting']['ftp']['allowedexts'] && in_array($ext, $_G['setting']['ftp']['allowedexts'])) || ($_G['setting']['ftp']['disallowedexts'] && !in_array($ext, $_G['setting']['ftp']['disallowedexts']) && (!$_G['setting']['ftp']['allowedexts'] || $_G['setting']['ftp']['allowedexts'] && in_array($ext, $_G['setting']['ftp']['allowedexts'])))) && (!$_G['setting']['ftp']['minsize'] || $filesize >= $_G['setting']['ftp']['minsize'] * 1024)) {
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	//取得需要上传的附件
	function get_upload_attach_arr($uid, $aids){
		global $_G;
		if(!$aids || !$_G['setting']['ftp']['on']) {
			return;
		}
		$attachtables = $pics = array();
		$this->cache['common']['forum']['ismoderator'] = !empty($this->cache['common']['forum'][$uid]) ? 1 : 0;
		$uidadd = $this->cache['common']['forum']['ismoderator'] ? '' : " AND uid='$uid'";
		$query = DB::query("SELECT aid, tableid FROM ".DB::table('forum_attachment')." WHERE aid IN (".dimplode($aids).")$uidadd");
		while($attach = DB::fetch($query)) {
			$attachtables[$attach['tableid']][] = $attach['aid'];
		}
		foreach($attachtables as $attachtable => $aids) {
			$attachtable = 'forum_attachment_'.$attachtable;
			$query = DB::query("SELECT aid, thumb, attachment, filename, filesize, picid FROM ".DB::table($attachtable)." WHERE aid IN (".dimplode($aids).") AND remote='0'");
			$remoteaids = array();
			while($attach = DB::fetch($query)) {
				$attach['ext'] = fileext(strtolower($attach['filename']));
				if(!$this->ftp_check_attach($attach['ext'], $attach['filesize'])) continue;
				$attach['attachtable'] = $attachtable;
				$this->cache['upload']['attach_arr'][$attach['aid']] = $attach;
			}
		}
	}
	

		
	function upload_attach(){
		global $_G;
		if($this->cache['mod'] != 'upload') return;
		$this->cache['mod'] = 'upload';
		//不使用任何远程附件
		if((!$this->pick_set['skydrive_type'] && !$_G['setting']['ftp']['on']) || !VIP){
			$this->cache['mod'] = '';
			$this->cache['run_step'] = '';
			return;
		}
		//首次运行，计算出需要上传的附件
		if($this->cache['upload']['count'] == 0){
			if(!$this->pick_set['skydrive_type']){//通过ftp
				if($this->cache['optype'] == 'move_forums'){//论坛
					foreach($this->cache['upload']['newaids'] as $k => $v){
						$this->get_upload_attach_arr($v['uid'], $v['aids']);
					}
				}else{
				}
			}else{//网盘
				$this->cache['upload']['attach_arr'] = $this->cache['upload']['sky_attach_arr'];
			}
			$this->cache['upload']['count'] = count($this->cache['upload']['attach_arr']);
		}
		
		if(!$this->step){
			if(!$this->cache['upload']['attach_arr']) return;
			$this->upload_attach_wait();
		}
		
		
		//处理掉
		$attach_info = $this->cache['upload']['current_attach_info'];
		if(!$this->pick_set['skydrive_type']){//ftp
			if($this->cache['optype'] == 'move_forums'){//论坛	
				$result = ftpcmd('upload', 'forum/'.$attach_info['attachment']);
				$this->cache['upload']['remoteaids'][$attach_info['attachtable']][$attach_info['aid']] = $attach_info['aid'];
				if($attach_info['picid']) {
					$this->cache['upload']['pics'][$attach_info['aid']] = $attach_info['picid'];
				}
			}else{//门户、博客
				$dir_name = $this->cache['optype'] == 'move_portal' ? 'portal' : 'album';
				$ftpresult_thumb = 0;
				$ftpresult = ftpcmd('upload', $dir_name.'/'.$attach_info['attachment']);
				if($ftpresult) {
					@unlink($_G['setting']['attachdir'].$dir_name.'/'.$attach_info['attachment']);
					$thumbpath = getimgthumbname($attach_info['attachment']);
					ftpcmd('upload', $dir_name.'/'.$thumbpath);
					@unlink($_G['setting']['attachdir'].$dir_name.'/'.$thumbpath);
				}
			}
		}else{
			$re = $this->attach_remote_upload($attach_info['from'], $attach_info['to']);
		}
		//结束
		if(!$this->cache['upload']['attach_arr']) {
			if(!$this->pick_set['skydrive_type']){//ftp需要后续处理
				if($this->cache['optype'] == 'move_forums'){
					foreach((array)$this->cache['upload']['remoteaids'] as $attachtable => $remoteaids){
						if(!$remoteaids || !is_array($remoteaids) || !$attachtable) continue;
						DB::update($attachtable, array('remote' => 1), "aid IN (".dimplode($remoteaids).")");
					}
					if($this->cache['upload']['pics']) {
						DB::update('home_pic', array('remote' => 3), "picid IN (".dimplode($this->cache['upload']['pics']).")");
					}
					
					//设置封面
					if($this->cache['upload']['cover']['pid']){
						$_G['setting']['forumpicstyle'] = $this->cache['upload']['cover']['style'];
						require_once libfile('function/post');
						$_G['forum']['ismoderator'] = 1;
						$_G['uid'] = $this->cache['common']['reply_public_uid'] ? $this->cache['common']['reply_public_uid'] : $this->cache['common']['public_uid'];//必须有这个
						$_G['uid'] = $_G['uid'] ? $_G['uid'] : 1;
						setthreadcover($this->cache['upload']['cover']['pid']);
					}
				}
			}
			$this->cache['mod'] = '';
			$this->cache['run_step'] = '';
		}else{
			$this->upload_attach_wait();
		}
			
			
		
		
	}
	
	
	function upload_attach_wait(){
		if(!$this->cache['upload']['attach_arr']) return;
		$current_get_num = $this->cache['upload']['count'] - count($this->cache['upload']['attach_arr']);
		$this->cache['run_step'] = 1;
		$percent = percent_format($current_get_num, $this->cache['upload']['count']);
		$info = array_shift($this->cache['upload']['attach_arr']);
		$this->cache['upload']['current_attach_info'] = $info;
		$this->cpmsg(milu_lang('bat_i_p_a', array('t' => $this->import_cache['current']['title'])).milu_lang('upload_remote_attach', array('p' => $percent)).milu_lang('bat_import_article', array('t' => $this->import_cache['total'], 'p' => percent_format($this->import_cache['current']['currow'], $this->import_cache['total']) )), PICK_GO.'picker_manage&myac=article_public_start&tpl=no');
	}
	
	
	//附件远程上传
	function attach_remote_upload($from, $to){
		global $_G;
		pload('F:attach');
		if(!file_exists($from)) return;
		$skydrive_type = $this->pick_set['skydrive_type'];
		
		//上传之前先打水印
		require_once libfile('class/image');
		$attach_dir_name = $this->cache['optype'] == 'move_portal' ? 'portal' : 'album';
		if($this->cache['optype'] == 'move_forums') $attach_dir_name = 'forum';
		$image = new image();
		if($this->cache['p_arr']['is_water_img'] == 1) {
			$re = $image->Watermark($from, '', $attach_dir_name);//打水印
			if($re < 0) $this->errno = -24;//打水印失败
		}
		if($_G['setting']['ftp']['on'] && !$skydrive_type){//使用ftp
			
		}else if($skydrive_type == 1){//百度网盘
			return baidu_attach_upload($from, $to);
		}else if($skydrive_type == 2){//七牛云
			return qiniu_attach_upload($from, $to);
		}
	}
	
	//核对附件，看看哪些附件需要下载。
	function attach_download_data(){
		$old_data_list = article_attach_by_aid($this->aid);
		$is_download_file = $this->cache['p_arr']['is_download_file'];
		if($this->cache['p_arr']['is_attach_setting'] == 1){
			$is_download_file = 1;//如果设置特殊附件采集，必须是
		}
		$new_data_arr = (array)$this->cache['article_info']['attach_arr'][$this->cache['article_info']['cid']] = get_article_attach($this->cache['article_info']['content'], $is_download_file, $this->cache['article_info']['url']);
		if($this->cache['article_info']['cover_pic']){//如果存在封面
			array_push($new_data_arr, array(1 => $this->cache['article_info']['cover_pic']));
		}
		
		if($this->cache['article_info']['sortid']){//如果是分类信息，里面含有图片
			foreach($this->cache['threadsort'] as $k => $v){
				if($v['type'] == 'image' && $this->cache['article_info']['sort_arr'][$k]){//数据类型是图片
					$new_data_arr = (array)$new_data_arr;
					array_push($new_data_arr, array(1 => $this->cache['article_info']['sort_arr'][$k]));
				}
			}
		}
		
		foreach($this->cache['article_info']['content_arr'] as $k => $v){
			$reply_attach_arr  = get_article_attach($v['content'], $this->cache['p_arr']['is_download_file'], $this->cache['article_info']['url']);
			if($reply_attach_arr) $this->cache['article_info']['attach_arr'][$v['cid']] = $reply_attach_arr;
			$new_data_arr = array_merge((array)$new_data_arr, (array)$reply_attach_arr);
		}
		$this->cache['attach_arr'] = array();//待下载的附件列表
		
		$this->cache['article_info']['attach_arr'] = array_filter($this->cache['article_info']['attach_arr']);//去掉空的

		
		$attach_link_hava_arr = $attach_link_text_hava_arr = $redirect_attach_info = array();
		if($this->cache['p_arr']['is_download_file'] == 1){
			$attach_link_hava_arr = format_wrap($this->cache['p_arr']['attach_link_hava']);
			$attach_link_text_hava_arr = format_wrap($this->cache['p_arr']['attach_link_text_hava']);
		}
		//特殊附件
		if($this->cache['p_arr']['is_attach_setting'] == 1){
			$redirect_attach_info = $this->get_redirect_attach($this->cache['article_info']['url'], $this->cache['article_info']['content']);
			if($redirect_attach_info['attach_download_url'] && $this->cache['p_arr']['is_download_file'] == 2){//如果附件不本地化，直接替换掉内容里面的附件路径
				$this->cache['article_info']['content'] = str_replace('href="'.$redirect_attach_info['attach_redirect_url'].'"', 'href="'.$redirect_attach_info['attach_download_url'].'"', $this->cache['article_info']['content']);
			}
		}
		$this->cache['redirect_attach_info'] = $redirect_attach_info;
		foreach($new_data_arr as $k => $v){
			$imageurl = $v[1];
			$url_hash = md5($imageurl);
			$info = $old_data_list[$url_hash];
			$is_image = $v[4]==1 ? 0 : 1;
			//过滤掉一些附件
			if(!$imageurl || ($v[4] == 1 && filter_something($v[1], $attach_link_hava_arr)) || ($v[4] == 1 && filter_something($v[2], $attach_link_text_hava_arr)) ) {
				continue;
			}
			if($this->cache['p_arr']['is_download_img'] != 1 && $is_image == 1) continue;
			$file_name = $this->attach_file_name($info['save_name']);
			if($info && file_exists($file_name)) continue;
			
			//特殊附件处理				
			$imageurl = $imageurl == $redirect_attach_info['attach_redirect_url'] ? $redirect_attach_info['attach_download_url'] : $imageurl;
			
			$this->cache['attach_arr'][$url_hash] = array('imageurl' => $imageurl, 'title' => $v[2], 'is_image' => $is_image);
		}
		$this->cache['data_attach_arr'] = $this->cache['article_info']['data_attach_arr'] = $old_data_list;//数据库里面对应的
	}
	
	
	function get_redirect_attach($url, $content){
		$arr = get_redirect_attach_url(array('attach_redirect_url_get_type' => $this->cache['p_arr']['attach_redirect_url_get_type'], 'attach_redirect_url_get_rules' => $this->cache['p_arr']['attach_redirect_url_get_rules'], 'attach_download_url_get_type' => $this->cache['p_arr']['attach_download_url_get_type'], 'attach_download_url_get_rules' => $this->cache['p_arr']['attach_download_url_get_rules']), $url, $content, $this->cache['p_arr']['login_cookie']);
		return $arr;
	}
	
	function attach_file_name($save_name){
		if(!$save_name) return;
		return PICK_ATTACH_PATH.'/'.$this->cache['p_arr']['pid'].'/'.$this->aid.'/'.$save_name;
	}
	
	function download_attach_wait(){
		if(!$this->cache['attach_arr']) return;
		$info = array_shift($this->cache['attach_arr']);
		$this->cache['attach']['current_attach_info'] = $info;
		$imageurl = $info['imageurl'];
		$url_hash = md5($imageurl);
		$this->cache['attach']['current_key'] = $url_hash;
		$current_get_num = $this->cache['attach']['count'] - count($this->cache['attach_arr']);
		$percent = percent_format($current_get_num, $this->cache['attach']['count']);
		$this->cache['run_step'] = 1;
		$this->cpmsg(milu_lang('bat_i_p_a', array('t' => $this->import_cache['current']['title'])).milu_lang('bat_i_p_attach', array('p' => $percent ,'url' => $imageurl)).milu_lang('bat_import_article', array('t' => $this->import_cache['total'], 'p' => percent_format($this->import_cache['current']['currow'], $this->import_cache['total']) )), PICK_GO.'picker_manage&myac=article_public_start&tpl=no');
	}
	
	function download_attach(){
		if($this->cache['mod'] != 'attach') return;
		if(!$this->cache['attach']['current_key']){//初次执行
			$this->attach_download_data();//查询哪些附件需要采集
			$this->cache['attach']['count'] = count($this->cache['attach_arr']);
			if($this->cache['attach']['count'] == 0){
				$this->cache['mod'] = 'avatar';
				unset($this->cache['attach_arr'], $this->cache['data_attach_arr'], $this->cache['attach']);
				return;
			}
		}
		
		$this->cache['mod'] = 'attach';
		if(!$this->step){
			if(!$this->cache['attach_arr']) return;
			$this->download_attach_wait();
		}else{
			$info = $this->cache['attach']['current_attach_info'];
			
			$imageurl = $info['imageurl'];
			$description = $info['title'];
			$url_hash = md5($imageurl);
			if($imageurl == $this->cache['redirect_attach_info']['attach_download_url']){
				$url_hash = md5($this->cache['redirect_attach_info']['attach_redirect_url']);
			}
			
			$this->cache['attach']['current_key'] = $url_hash;
			$snoopy_args['cookie'] = $this->cache['p_arr']['login_cookie'];
			$is_attach_allow = 1;
			$snoop_obj = get_snoopy_obj($snoopy_args);
			if(is_array($info) && $info['is_image'] != 1 && $this->cache['p_arr']['is_download_file'] != 1){//特殊附件
				$attach_info = array();
			}else{
				$attach_info = get_img_content($imageurl, $snoop_obj, array('referer' => $this->cache['attach_info']['url'], 'is_set_referer' => $this->cache['p_arr']['is_set_referer']));
			}
			if(empty($attach_info['file_ext']) && $description){//discuz有些种子附件获取不到扩展名
				$attach_info['file_ext'] = addslashes(strtolower(substr(strrchr(_striptext($description), '.'), 1, 10)));
				if(!$attach_info['file_name'] && $attach_info['file_ext']) $attach_info['file_name'] = _striptext($description);
			}
			//系统默认不允许下载html、shtml、php扩展名
			if(in_array($attach_info['file_ext'], array('shtml', 'html', 'php'))) $is_attach_allow = 0;
			$attach_dir = PICK_ATTACH_PATH.'/'.$this->cache['p_arr']['pid'].'/'.$this->aid;
			dmkdir($attach_dir);
			if($attach_info['file_size'] && strlen($attach_info['content']) && $is_attach_allow == 1){
				$hash = md5($attach_info['content']);
				$save_name = $url_hash.'.'.$attach_info['file_ext'];
				$attach_file = $this->attach_file_name($save_name);
				$is_image = pis_image_ext($attach_info['file_ext']) ? 1 : 0;
				file_put_contents($attach_dir.'/'.$save_name, $attach_info['content']);
				if(!$this->cache['data_attach_arr'][$url_hash]){
					$setarr = array('tid' =>$this->aid, 'url_hash' => $url_hash, 'hash' => $hash, 'pid' => $this->cache['p_arr']['pid'], 'save_name' => $save_name, 'file_name' => $attach_info['file_name'], 'filesize' => $attach_info['file_size'], 'description' => $description, 'isimage' => $is_image);
					DB::insert('strayer_attach', paddslashes($setarr), TRUE);
				}
			}
			//结束
			if(!$this->cache['attach_arr']) {
				$this->cache['mod'] = 'avatar';
				$this->cache['run_step'] = '';
				//如果数据库里面没有附件记录，但是文章里面后来添加了。也要更新
				$this->cache['article_info']['data_attach_arr'] = article_attach_by_aid($this->aid);
			}
			$this->download_attach_wait();
		}
	
	}
	
	
	function download_avatar_wait(){
		if(!$this->cache['avatar']['data_arr']) return;
		$info = array_shift($this->cache['avatar']['data_arr']);
		$this->cache['avatar']['current_info'] = $info;
		$current_get_num = $this->cache['avatar']['count'] - count($this->cache['avatar']['data_arr']);
		$this->cache['run_step'] = 1;
		$percent = percent_format($current_get_num, $this->cache['avatar']['count']);
		$this->cpmsg(milu_lang('bat_i_p_a', array('t' => $this->import_cache['current']['title'])).milu_lang('download_user_avatar', array('u' => $info['username'], 'p' => $percent)).milu_lang('bat_import_article', array('t' => $this->import_cache['total'], 'p' => percent_format($this->import_cache['current']['currow'], $this->import_cache['total']) )), PICK_GO.'picker_manage&myac=article_public_start&tpl=no');
	}
	
	
	//下载头像
	function download_avatar(){
		if($this->cache['mod'] != 'avatar') return;
		pload('F:member');
		if(!$this->cache['avatar']['current_info'] && count($this->cache['avatar']['data_arr']) > 0){//初次执行
			$this->avatar_download_data();//查询哪些附件需要采集
			if($this->cache['avatar']['count'] == 0 || empty($this->cache['avatar']['root_url'])){
				$this->cache['mod'] = 'article';
				unset($this->cache['avatar']);
				return;
			}
		}
		
		if(!$this->cache['avatar']['data_arr']){
			$this->cache['mod'] = 'article';
			unset($this->cache['avatar']);
			return;
		}
		
		$this->cache['mod'] = 'avatar';
		
		if(!$this->step){
			if(!$this->cache['avatar']) return;
			$this->download_avatar_wait();
		}else{
			$info = $this->cache['avatar']['current_info'];
			//下载头像
			$avatar_url = $this->cache['avatar']['root_url'].get_avatar($info['get_uid'], 'middle');
			$this->download_avatar_file($avatar_url, $info['uid']);
			//结束
			if(!$this->cache['avatar']) {
				$this->cache['mod'] = 'article';
				$this->cache['run_step'] = '';
			}
			$this->download_avatar_wait();
		}
	}
	
	function download_avatar_file($avatar_url, $uid){
		$size_arr = array('middle', 'big', 'small');
		$attach_dir = PICK_PATH.''.'/'.get_avatar($uid, '', '', true);
		dmkdir($attach_dir);
		$snoopy_args = array();
		foreach($size_arr as $size){
			$avatar_file_name = PICK_PATH.'/'.get_avatar($uid, $size);
			if(file_exists($avatar_file_name)) continue;
			$icon_url = str_replace('middle', $size, $avatar_url);
			$snoopy_obj = get_snoopy_obj($snoopy_args);
			$img_arr = get_img_content($icon_url, $snoopy_obj);
			$img_re = $img_arr['content'];
			if(empty($img_re)) continue;
			$put_re = file_put_contents($avatar_file_name, $img_re);//写入头像
			if(!$put_re) {
				continue;
			}	
		}		
	}
	
	//查询需要下载的头像
	function avatar_download_data(){
		$member_uid_arr[] = $this->cache['article_info']['uid'];
		foreach($this->cache['article_info']['content_arr'] as $k => $v){
			$member_uid_arr[] = $v['uid'];
		} 
		$member_uid_arr = array_filter($member_uid_arr);
		$member_uid_arr = sarray_unique($member_uid_arr);
		if($member_uid_arr){
			$query = DB::query("SELECT avatar_root_url,uid,get_uid,username,data_uid FROM ".DB::table('strayer_member')." WHERE uid IN (".dimplode($member_uid_arr).")");
			pload('F:member');
			while(($v = DB::fetch($query))) {
				if(file_exists(PICK_PATH.'/'.get_avatar($v['uid'], 'middle'))){
					continue;
				}
				//如果用户已经注册，而且没有头像才下载
				$avatar_file = get_avatar_path($v['data_uid']);
				if(file_exists($avatar_file)){
					continue;
				}
				
				$this->cache['avatar']['root_url'] = $v['avatar_root_url'];
				$member_data_arr[$v['uid']] = array('username' => $v['username'], 'get_uid' => $v['get_uid'], 'uid' => $v['uid']);
			}
		}
		$this->cache['avatar']['data_arr'] = $member_data_arr;
		$this->cache['avatar']['count'] = count($member_data_arr);
	}
	
	//发布文章	
	function article_public(){
		if($this->cache['mod'] != 'article') return;
		$this->cache['mod'] = 'article';
		$func_name = $this->cache['optype'];
		if(!in_array($func_name, array('move_forums', 'move_portal', 'move_blog'))) cpmsg_error(milu_lang('data_expired'));
		$this->$func_name();
		if($func_name == 'move_forums') {
			$this->cache['mod'] = 'reply';
		}else{
			$this->cache['mod'] = 'upload';
		}
	}
	
	function check_article_common(){
		if(empty($this->cache['article_info']['title'])) {
			$this->errno = -1;
			return FALSE;
		}
		if(empty($this->cache['article_info']['content'])) {
			$this->errno = -2;
			return FALSE;
		}
		return TRUE;
	}
	function check_article_forum(){
		$this->article_format_forum();
		if($this->check_article_common() == FALSE) return FALSE;
		if($this->cache['check_title'] == 1){
			$num = DB::result_first('SELECT COUNT(*) FROM '.DB::table('forum_thread')." WHERE subject='".daddslashes($this->cache['article_info']['title'])."' AND displayorder > '-1'");
			if($num) {
				$this->errno = -3;
				return FALSE;
			}
		}
		return TRUE;
	}
	
	function article_format_forum(){
		$this->cache['article_info']['title'] = trim($this->cache['article_info']['title']);
		$this->cache['article_info']['content'] = trim($this->cache['article_info']['content']);
		
		$subject = $this->cache['article_info']['title'];
		$content = $this->cache['article_info']['ori_content'] = $this->cache['article_info']['content'];
		$subject = htmlspecialchars_decode(format_html($subject));
		$this->cache['article_info']['title'] = $subject;
		$this->cache['article_info']['content'] = $content;
	}
	
	function get_rand_data($data){
		if(strexists($data, ',')){
			$temp_arr = format_wrap($data, ',');
			return rand($temp_arr[0], $temp_arr[1]);
		}else if(strexists($data, '|')){
			$data_arr = format_wrap($data, '|');
			$key = array_rand($data_arr);
			return $data_arr[$key];
		}else{
			return intval($data);
		}
	}
	
	function move_forums(){
		global $_G;
		require_once libfile('function/editor');
		require_once libfile('function/forum');
		require_once libfile('function/post');
		
		if($this->check_article_forum() == FALSE) return FALSE;

		$subject = $this->cache['article_info']['title'];
		$message = $this->page_get_content();	
		$is_htmlon = $this->cache['p_arr']['is_html_public'] == 1 ? 1 : 0;
		$message = content_html_ubb($message, $this->cache['article_info']['url'], $is_htmlon);
		
		if(VIP && $this->pick_config['pick_config']['open_fanyi_module'] == 1 && $this->pick_set['tran_is_open'] == 1) {
			$fanyi_flag = $this->cache['p_arr']['is_download_img'] != 1 && $this->cache['p_arr']['is_download_file'] != 1 && strexists('img', $message) ? 1: 0;//有远程图片的
			$fanyi_flag = 0;
			$fanyi_message = $fanyi_flag==1 ? 'test' : $message;
			$fanyi_arr = pick_fanyi($fanyi_message, $subject, array('pid' => $this->cache['p_arr']['pid']));//翻译
			if(!$fanyi_arr) return -12;
			$message = $fanyi_flag==1 ? $message : $fanyi_arr['content'];
			$subject = $fanyi_arr['title'];
			$this->cache['article_info']['article_tag'] = dz_get_tag($message, $subject);
		}
			
		
		/*               设置各种参数            */
		
		$bbcodeoff = checkbbcodes($message, FALSE);
		$smileyoff = checksmilies($message, FALSE);
		$readperm = 0;
		$displayorder = 0;
		$digest = 0;
		$moderated = 0;
		$isgroup = 0;
		$replycredit = 0;
		$isanonymous = 0;
		$parseurloff = 0;
		
		//设置查看数
		$view_num = $this->cache['article_info']['view_num'];
		$reply_count = count($this->cache['article_info']['content_arr']);
		$view_num = $view_num < ($reply_count - 1) ? rand($reply_count*2, $reply_count*10) : $view_num; //查看数
		$fid = $this->cache['common']['fid'] = $this->cache['forums'];
		$_G['forum'] =  DB::fetch_first("SELECT * FROM ".DB::table('forum_forum')." WHERE fid='$fid'");
		$forum_forumfield_info = DB::fetch_first("SELECT threadsorts,moderators FROM ".DB::table('forum_forumfield')." WHERE fid='$fid'");
		$_G['forum']['threadsorts'] = dunserialize($forum_forumfield_info['threadsorts']);
		$_G['forum']['moderators'] = $forum_forumfield_info['moderators'];
		$this->cache['common']['forum'] = $_G['forum'];
		//用户
		
		$uid = $this->cache['article_info']['public_uid'];
		$author = $this->cache['article_info']['public_username'];
			
		$public_time = $this->cache['article_info']['public_time'];//时间	
			
		$special = $this->cache['article_info']['special'];
		$sortid = $this->cache['article_info']['sortid'];
		//所发布的板块没有这个信息分类
		if($sortid && !in_array($sortid, array_keys($_G['forum']['threadsorts']['types']))){
			if(in_array($this->cache['run_type'], $this->cache['no_msg_action_arr'])) {
				$this->errno = -1452;
				return FALSE;//
			}
			cpmsg_error(milu_lang('article_public_error_no_sort'));
		}
		if($special == 3){//悬赏主题
			$price = $rewardprice = $this->cache['article_info']['reward_price'] ? $this->cache['article_info']['reward_price'] : rand(1,50);
		}
		if($sortid){//信息分类
			$forum_optiondata = $this->cache['article_info']['sort_arr'];
		} 
		
		
		
		
		$typeid = $this->cache['threadtypeid'];
		
	
		$is_htmlon = $this->cache['p_arr']['is_html_public'] == 1 ? 1 : 0;
		
		
		if($this->cache['article_info']['forum_id']){//已经发布的
			$info = DB::fetch_first("SELECT p.pid,p.tid,t.tid,p.first FROM ".DB::table('forum_post')." p Inner Join ".DB::table('forum_thread')." t  ON p.tid = t.tid WHERE p.first = '1' AND t.tid='".$this->cache['article_info']['forum_id']."' AND t.displayorder > '-1'");
		}
		
		$this->cache['common']['subject'] = $subject;
		if($info['tid']){//更新
			DB::query("UPDATE ".DB::table('forum_thread')." SET typeid='$typeid', author='".daddslashes($author)."', sortid='$sortid', authorid='$uid', subject='".daddslashes($subject)."', dateline='$public_time', price='$price', lastpost='$public_time', special='$special', fid='$fid', lastposter='".daddslashes($author)."', views='$view_num', attachment='0' WHERE tid='$info[tid]'", 'UNBUFFERED');
			$tid = $info['tid'];
		}else{//添加
			DB::query("INSERT INTO ".DB::table('forum_thread')." (fid, posttableid, readperm, price, typeid, sortid, author, authorid, subject, dateline, lastpost, lastposter, views, displayorder, digest, special, attachment, moderated, status, isgroup, replycredit, closed)
				VALUES ('".$fid."', '0', '$readperm', '$price', '$typeid', '$sortid', '".daddslashes($author)."', '$uid', '".daddslashes($subject)."', '$public_time', '$public_time', '".daddslashes($author)."', '$view_num', '$displayorder', '$digest', '$special', '0', '$moderated', '32', '$isgroup', '$replycredit', '0')");
			$tid = DB::insert_id();
			useractionlog($uid, 'tid');
			
		}
		$this->cache['finsh']['insert_id'] = $tid;
		DB::update('common_member_field_home', array('recentnote'=> daddslashes($subject)), array('uid'=>$uid));

		
		if(DISCUZ_VERSION == 'X2'){//2.0版本
			$tagstr = addthreadtag($this->cache['article_info']['article_tag'], $tid);
		}else{
			$class_tag = new tag();
			$tagstr = $class_tag->add_tag($this->cache['article_info']['article_tag'], $tid, 'tid');
			
		}
	
		$message = preg_replace('/\[attachimg\](\d+)\[\/attachimg\]/is', '[attach]\1[/attach]', $message);
		
		$post_setarr = array(
			'fid' => $fid,
			'tid' => $tid,
			'first' => '1',
			'author' => $author,
			'authorid' => $uid,
			'subject' => $subject,
			'dateline' => $public_time,
			'message' => $message,
			'useip' => $_G['clientip'],
			'invisible' => 0,
			'anonymous' => $isanonymous,
			'usesig' => 1,
			'htmlon' => $is_htmlon,
			'bbcodeoff' => $bbcodeoff,
			'smileyoff' => $smileyoff,
			'parseurloff' => $parseurloff,
			'attachment' => '0',
			'replycredit' => 0,
			'status' => 0
		);
		if(DISCUZ_VERSION != 'X2'){//2.5版本 2.5版本多了一个position字段
			$post_setarr['position'] = 1;
		}
		$post_setarr = paddslashes($post_setarr);
		$post_setarr['tags'] = $tagstr;
		$today_time_arr = array();//用于今日统计
		$replys = 0;
		if($info['tid']){//更新
			//发布时间要做更改
			$new_post_arr = DB::fetch_first("SELECT dateline FROM ".DB::table('forum_post')." WHERE tid='$tid' ORDER BY dateline ASC limit 1");		
			$post_setarr['dateline'] = $new_post_arr['dateline'] - 3600;
			DB::update('forum_post', $post_setarr, array('pid' => $info['pid']));
			$pid =  $info['pid'];
			
		}else{
			$pid = insertpost($post_setarr);
		}


		$threadimageaid = 0;
		$threadimage = array();
	
		

		/*删除附件,删除主题和回复*/
		if($this->cache['article_info']['forum_id']){
			//删除附件
			$tidsadd = "tid='".$this->cache['article_info']['forum_id']."'";
			require_once libfile('function/delete');
			deleteattach(array($this->cache['article_info']['forum_id']), 'tid');
			DB::query("UPDATE ".DB::table('forum_thread')." SET attachment='0' WHERE $tidsadd");
			updatepost(array('attachment' => '0'), $tidsadd);
			
			//删除回复
			DB::delete('forum_post', "tid='".$this->cache['article_info']['forum_id']."' AND pid<>'$pid'");
			
		}
		
		
		//分类信息	
		//对日期和其他数据的转换待完成
		if($_G['forum']['threadsorts']['types'][$sortid] && !empty($forum_optiondata) && is_array($forum_optiondata)) {
			$filedname = $valuelist = $separator = '';
			foreach($forum_optiondata as $optionid => $value) {
				$data_type = $this->cache['threadsort'][$optionid]['type'];
				$data_title = $this->cache['threadsort'][$optionid]['title'];
				$is_phone = $data_type == 'text' && (strexists($data_title, '手机') || strexists($data_title, '电话')) ? 1 : 0;
				if($data_type == 'image' ||  $is_phone == 1) {
					$attach_img_info = $this->get_attach_content_by_url($value, $this->cache['article_info']['data_attach_arr']);
					$attach_info = (!empty($attach_img_info['file_ext']) && !empty($attach_img_info['file_name'])) ? $this->attach_add(array('tid' => $tid, 'fid' => $fid, 'uid' => $uid, 'pid' => $pid, 'attach_img_info' => $attach_img_info)) : array();
					//按照discuz，如果开启ftp远程附件，信息分类里面的附件仍然是使用本地的，所以。。。
					if($attach_info['aid']){
						$value = pserialize($attach_info);
					}
					if($is_phone == 1){
						$value = '<img src="'.$attach_info['url'].'">';
						if(empty($attach_info['url']))  $value = '';
					}
				}
				if($data_type == 'select' || $data_type == 'checkbox' || $data_type == 'radio') {
					$search_key = array_search($value, $this->cache['threadsort'][$optionid]['choices']);
					if(empty($search_key)){
						foreach($this->cache['threadsort'][$optionid]['choices'] as $k1 => $v1){
							if(strexists(trim($value), trim($v1))){
								$value = $k1;
								break;
							}
							if(strexists(trim($v1), trim($value))){
								$value = $k1;
								break;
							}
						}
					}else{
						$value = $search_key;
					}
					
				}
				if($value) {
					$filedname .= $separator.$this->cache['threadsort'][$optionid]['identifier'];
					$valuelist .= $separator."'".daddslashes($value)."'";
					$separator = ' ,';
				}
	
				DB::query("INSERT INTO ".DB::table('forum_typeoptionvar')." (sortid, tid, fid, optionid, value, expiration)
					VALUES ('$sortid', '$tid', '$_G[fid]', '$optionid', '".daddslashes($value)."', '".($typeexpiration ? TIMESTAMP + $typeexpiration : 0)."')");
			}
	
			if($filedname && $valuelist) {
				DB::query("INSERT INTO ".DB::table('forum_optionvalue')."$sortid ($filedname, tid, fid) VALUES ($valuelist, '$tid', '$fid')");
			}
		}
		

		
	
		$param = array('fid' => $fid, 'tid' => $tid, 'pid' => $pid);
	
		$statarr = array(0 => 'thread', 1 => 'poll', 2 => 'trade', 3 => 'reward', 4 => 'activity', 5 => 'debate', 127 => 'thread');
		
		include_once libfile('function/stat');
		
		updatestat($isgroup ? 'groupthread' : $statarr[$special]);
	
		dsetcookie('clearUserdata', 'forum');
		
		
		//扩展主题	
		if($specialextra) {
	
			$classname = 'threadplugin_'.$specialextra;
			if(class_exists($classname) && method_exists($threadpluginclass = new $classname, 'newthread_submit_end')) {
				$threadpluginclass->newthread_submit_end($fid, $tid);
			}
	
		}
	
		
		/****动态start***/
		
		$feed = array(
			'icon' => '',
			'title_template' => '',
			'title_data' => array(),
			'body_template' => '',
			'body_data' => array(),
			'title_data'=>array(),
			'images'=>array()
		);
		if($_G['forum']['allowfeed'] && !$isanonymous) {
			$message = !$price ? $message : '';
			if($special == 0) {
				$feed['icon'] = 'thread';
				$feed['title_template'] = 'feed_thread_title';
				$feed['body_template'] = 'feed_thread_message';
				$feed['body_data'] = array(
					'subject' => "<a href=\"forum.php?mod=viewthread&tid=$tid\">$subject</a>",
					'message' => messagecutstr($message, 150)
				);
			
			}elseif($special == 3) {
				$feed['icon'] = 'reward';
				$feed['title_template'] = 'feed_thread_reward_title';
				$feed['body_template'] = 'feed_thread_reward_message';
				$feed['body_data'] = array(
					'subject'=> "<a href=\"forum.php?mod=viewthread&tid=$tid\">$subject</a>",
					'rewardprice'=> $rewardprice,
					'extcredits' => $_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]]['title'],
				);
			}
		}
	
		$feed['title_data']['hash_data'] = "tid{$tid}";
		$feed['id'] = $tid;
		$feed['idtype'] = 'tid';
		if($feed['icon']) {
			postfeed($feed);
		}
		
		/****动态end***/
		
		if($displayorder != -4) {
			updatepostcredits('+',  $uid, 'post', $fid);//加积分，猜的
			
			$subject = str_replace("\t", ' ', daddslashes($subject));
			$f_lastpost = "$tid\t$subject\t".$public_time."\t".daddslashes($author);
			if($_G['forum']['type'] == 'sub') {
				DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$f_lastpost' WHERE fid='".$_G['forum'][fup]."'", 'UNBUFFERED');
			}
		}	
		
		/***************更新统计start*******************/
		$subject = str_replace("\t", ' ', daddslashes($subject));
		$replys = count($this->cache['content_arr']);
		$replys = $replys ? $replys : 1;
		$todayposts = date("Yjn", $public_time) == date("Yjn", $_G['timestamp']) ? 1 : 0;
		foreach((array)$today_time_arr as $k => $v){
			if(date("Yjn", $_G['timestamp']) == date("Yjn", $v)) $todayposts++;
		
		}
		DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$f_lastpost', threads=threads+1, posts=posts+$replys, todayposts=todayposts+$todayposts WHERE fid='$fid'", 'UNBUFFERED');//更新今日发帖这些数据
		/***************更新统计end*******************/
		
		$this->cache['common']['tid'] = $tid;
		$this->cache['common']['public_uid'] = $uid;
		$this->cache['common']['public_username'] = $author;
		$this->cache['common']['public_time'] = $public_time;
		$this->cache['common']['fid'] = $fid;
		$this->cache['common']['pid'] = $pid;
		
		//内容图片更新
		
		//
		$content_is_have_cover = strexists($this->cache['article_info']['ori_content'], '{@cover}') ? 1 : 0;//判断内容是否含有封面
		if($content_is_have_cover == 1){
			$this->cache['article_info']['attach_arr'][$this->cache['article_info']['cid']] = (array)$this->cache['article_info']['attach_arr'][$this->cache['article_info']['cid']];
			array_push($this->cache['article_info']['attach_arr'][$this->cache['article_info']['cid']], array(0 => '{@cover}', 1 => $this->cache['article_info']['cover_pic']));
		}
		
		$this->forum_attach_content(array('content' => $this->cache['article_info']['ori_content'], 'cid' => $this->cache['article_info']['cid']));
		
		if($content_is_have_cover != 1 && $this->cache['article_info']['cover_pic']){//如果内容不含封面，也没有任何附件。单独设置帖子的封面
			$attach_dir = str_replace(PICK_DIR, '', PICK_ATTACH_PATH);
			$save_name = $this->cache['article_info']['data_attach_arr'][md5($this->cache['article_info']['cover_pic'])]['save_name'];
			$picsource = PICK_URL.$attach_dir.'/'.$this->cache['p_arr']['pid'].'/'.$this->aid.'/'.$save_name;
			$this->forum_set_cover($tid, $picsource);
		}

	}
	
	//封面设置
	function forum_set_cover($tid, $picsource){
		global $_G;
		$basedir = !$_G['setting']['attachdir'] ? (DISCUZ_ROOT.'./data/attachment/') : $_G['setting']['attachdir'];
		$coverdir = 'threadcover/'.substr(md5($tid), 0, 2).'/'.substr(md5($tid), 2, 2).'/';
		dmkdir($basedir.'./forum/'.$coverdir);
		$image = new image();
		if($_G['setting']['forumpicstyle'] && !is_array($_G['setting']['forumpicstyle'])){
			$_G['setting']['forumpicstyle'] = dunserialize($_G['setting']['forumpicstyle']);
		}
		if(!$_G['setting']['forumpicstyle']) $_G['setting']['forumpicstyle'] = $this->load_forumpicstyle();
		empty($_G['setting']['forumpicstyle']['thumbwidth']) && $_G['setting']['forumpicstyle']['thumbwidth'] = 203;
		empty($_G['setting']['forumpicstyle']['thumbheight']) && $_G['setting']['forumpicstyle']['thumbheight'] = 999;
		if($image->Thumb($picsource, 'forum/'.$coverdir.$tid.'.jpg', $_G['setting']['forumpicstyle']['thumbwidth'], $_G['setting']['forumpicstyle']['thumbheight'], 2)) {
			DB::update('forum_thread', array('cover' => 1), array('tid'=>$tid));
		}
	}
	
	function get_postid($content){
		if(!$this->pick_config['postid_public_get_rules']) return;
		if($this->cache['reply']['postid_get_rules']){
			return $this->get_postid_by_rules($content, $this->cache['reply']['postid_get_rules']);
		}
		foreach($this->pick_config['postid_public_get_rules'] as $k => $v){
			if(strexists($content, $v['check_str'])){
				$postid = $this->get_postid_by_rules($content, $v);
				if($postid){
					$this->cache['reply']['postid_get_rules'] = $v;
					return $postid;
				}
			}
		}
	}
	
	function get_postid_by_rules($content, $postid_rules){
		$postid_arr = $postid_rules['get_type'] == 1 ? dom_get_str($html, $postid_rules['get_rules'], array('is_get_all' => 0, 'is_return_array' => 1)) : str_get_str($content, $postid_rules['get_rules'], 'data',  -1, 1);
		return intval($postid_arr[0]);
	}
	
	//生成回复时间
	function create_reply_time(){
		$time_arr = create_public_time(array('public_time' => $this->cache['common']['public_time'], 'p_arr' => $this->cache['p_arr']), $this->cache['reply']['reply_num'], 1);
		//如果是回帖
		if($this->cache['article_info']['is_bbs'] == 1){
			//回帖时间是采集的
			if($this->cache['p_arr']['is_get_post_user'] == 1 && ($this->cache['p_arr']['is_use_thread_setting'] == 1 && !empty($this->cache['p_arr']['thread_dateline_get_rules']) ) || ($this->cache['p_arr']['is_use_thread_setting'] != 1 && !empty($this->cache['p_arr']['post_dateline_get_rules'])) ){
				foreach($this->cache['article_info']['content_key_arr'] as $k => $v){
					$c_info = $this->cache['article_info']['content_arr'][$v];
					$time_arr[$k] = $c_info['dateline'] ? $c_info['dateline'] : $time_arr[$k];
				}
			}
			
		}else{//分页文章
			$first_dateline = reset($time_arr);
			$end_dateline = end($time_arr);
			$diff_time = $end_dateline - $first_dateline;
			//如果时间差距太大，强制在0,5随机
			if($diff_time > 3600*5){
				$time_arr = create_public_time(array('public_time' => $this->cache['common']['public_time'], 'p_arr' => array('reply_dateline' => '0,5')), $this->cache['reply']['reply_num'], 1);
			}
			
		}
		
		//对时间进行处理 //主要是防止时间相同的情况
		if(empty($time_arr[0]) || $time_arr[0] == $this->cache['common']['public_time'] || $time_arr[0] < $this->cache['common']['public_time']) $time_arr[0] = $this->cache['common']['public_time'] + 60*rand(3, 10);
		$last_time = $time_arr[0];
		$count = count($time_arr);
		foreach($time_arr as $k => $v){
			if($k == 0) continue;
			$last_time = intval($time_arr[$k-1]);

			$next_time = intval($time_arr[$k+1]);
			if($v == $last_time || $v < $last_time){
				if($next_time > $v && $next_time > $last_time){
					$v = rand($v, $next_time);
				}else{
					$v = $last_time + rand(15*60, 3600*0.5);				
				}
			}
			$time_arr[$k] = $v;
			
		}
		return $time_arr;
	}
	
	//生成回复用户
	function create_rand_user(){
		$user_arr = array();
		//如果是回帖
		if($this->cache['article_info']['is_bbs'] == 1){
			$user_arr = get_rand_uid(array('p_arr' => $this->cache['p_arr'], 'public_uid' => $this->cache['common']['public_uid'], 'reply_num' => $this->cache['reply']['reply_num']), 'reply');
		}else{//分页文章 回复者跟发帖者用户名是一样的
			//
		}
		return $user_arr;
	}
	
	function reply_public(){
		global $_G;
		if($this->cache['mod'] != 'reply') return;
		if($this->cache['run_type'] == 'timing' && $this->cache['timing']['is_reply'] != 1) {
			$this->cache['mod'] = 'upload';
			return;
		}
		$this->cache['mod'] = 'reply';
		if(!$this->cache['article_info']['content_key_arr']){
			$this->cache['mod'] = 'upload';
			return;
		}
		require_once libfile('function/editor');
		require_once libfile('function/post');
		
		//参数设置
		$bat_run_num = 50;//每批执行50条数据
		if(intval($this->cache['reply']['reply_num']) == 0 && $this->cache['article_info']['content_arr']){//初次执行
			$this->cache['reply']['reply_num'] = count($this->cache['article_info']['content_arr']);
			$this->cache['reply']['time_arr'] = $this->create_reply_time();//处理时间
			$this->cache['reply']['uid_arr'] = $this->create_rand_user();//处理用户
			$this->cache['reply']['now_key'] = 0;
			$this->cache['reply']['postid_arr'] = array();
			if($this->cache['p_arr']['public_reply_seq'] == 1 && $this->cache['article_info']['is_bbs'] == 1) shuffle($this->cache['article_info']['content_key_arr']);//打乱回帖
			$this->cache['reply']['replyed_num'] = 0;//已经发布的
		}
		$is_htmlon = $this->cache['p_arr']['is_html_public'] == 1 ? 1 : 0;
		foreach($this->cache['article_info']['content_key_arr'] as $k => $v){
			$reply_info = $this->cache['article_info']['content_arr'][$v];
			$key = $this->cache['reply']['now_key'];
			$subject = $reply_info['title'];
			$message = $reply_info['content'];
			unset($this->cache['article_info']['content_key_arr'][$k]);
			$postid = $this->get_postid($message);
			if($postid){
				$quote_post_info = $this->cache['reply']['postid_arr'][$postid];
				if($quote_post_info){
					$post_reply_quote = lang('forum/misc', 'post_reply_quote', array('author' => $quote_post_info['author'], 'time' => dgmdate($quote_post_info['time'])));
					
					$quote_post_info['message'] = messagecutstr($quote_post_info['message'], 100);

					$quote_post_info['message'] = implode("\n", array_slice(explode("\n", $quote_post_info['message']), 0, 3));
					$quote_message = "[quote][size=2][color=#999999]{$post_reply_quote}[/color] [url=forum.php?mod=redirect&goto=findpost&pid=".$quote_post_info['pid']."&ptid=".$this->cache['common']['tid']."][img]static/image/common/back.gif[/img][/url][/size]<br />".$quote_post_info['message']."[/quote]";
					$quote_replace_rules = $this->cache['reply']['postid_get_rules']['replace'].'@@'.$quote_message;
					$message = replace_something($message, $quote_replace_rules);
				}
			}
			$reply_content = $message;
			$message = content_html_ubb($message, $this->cache['article_info']['url'], $is_htmlon);
			if(strlen($message) < 1) continue;
			if(!$postid && strexists($message, '[quote]')){//如果不存在，也要替换掉引用代码
				$message = replace_something($message, '[quote][size=2][color=#999999](*)[/quote]@@');
			}
			
			if(VIP && $this->pick_config['pick_config']['open_fanyi_module'] == 1 && $this->pick_set['tran_is_open'] == 1) {
				$fanyi_flag = $this->cache['p_arr']['is_download_img'] != 1 && $this->cache['p_arr']['is_download_file'] != 1 && strexists('img', $message) ? 1: 0;//有远程图片的
				$fanyi_flag = 0;
				$fanyi_message = $fanyi_flag==1 ? 'test' : $message;
				$fanyi_arr = pick_fanyi($fanyi_message, $subject, array('pid' => $this->cache['p_arr']['pid']));//翻译
				if(!$fanyi_arr) return -12;
				$message = $fanyi_flag==1 ? $message : $fanyi_arr['content'];
				$subject = $fanyi_arr['title'];
			}
			
			$bbcodeoff = checkbbcodes($message, !empty($_GET['bbcodeoff']));
			$smileyoff = checksmilies($message, !empty($_GET['smileyoff']));
			$parseurloff = 0;
			$usesig = 1;
			$isanonymous = 0;
			if(!$message || strlen($message) < 2) continue;
			
			//设置时间
			$dateline = $this->cache['reply']['time_arr'][$key] ? $this->cache['reply']['time_arr'][$key] : $_G['timestamp'];
			
			if($this->cache['article_info']['best_answer_cid'] && $this->cache['article_info']['best_answer_cid'] == $v && $this->cache['article_info']['reward_price'] < 0){//悬赏主题，已解决问题
				$dateline = $this->cache['common']['public_time'] + 1;
			}
			//设置用户
			
			if($this->cache['article_info']['is_bbs'] == 1){
				$author = $this->cache['reply']['uid_arr'][$key]['username'] ? $this->cache['reply']['uid_arr'][$key]['username'] : $_G['username'];
				$authorid = $this->cache['reply']['uid_arr'][$key]['uid'] ? $this->cache['reply']['uid_arr'][$key]['uid'] : $_G['uid'];
			}else{//如果是分页文章，回复者和发帖者同一个账号
				$authorid = $this->cache['common']['public_uid'];
				$author = $this->cache['common']['public_username'];
			}
			
			$member_info = $this->get_member_info($reply_info['uid']);
			if(is_array($member_info) && $member_info['uid']){
				$authorid = $member_info['uid'];
				$author = $member_info['username'];
			}else{
			}
			
			//回复进入定时发布
			if(VIP && $dateline > $_G['timestamp'] && $this->pick_set['is_timing'] == 1 && $this->cache['article_info']['is_bbs'] == 1){//必须加is_bbs=1这个，不然有些分页合并发布到论坛也会导致出错
				$timing_public_arr = $this->cache['timing']['timing_public_arr'];
				$public_type = 2;
				$timing_public_arr['forums'] = $this->cache['forums'];
				$timing_public_arr['threadtypeid'] = $this->cache['threadtypeid'];
		
				$timing_public_arr['aid'] = $this->cache['article_info']['aid'];
				$timing_public_arr['title'] = $this->cache['article_info']['title'];
				$timing_public_arr['authorid'] = $authorid;
				$timing_public_arr['author'] = $author;
				$timing_public_arr['reply_content'] = $reply_content;
				$timing_public_arr['message'] = $message;
				$timing_public_arr['subject'] = $subject;
				$timing_public_arr['attach_arr'] = $this->cache['article_info']['attach_arr'][$v];//附件
				$timing_public_arr['cid'] = $v;
				$timing_setarr = array('public_type' => $public_type, 'data_id' => $reply_info['cid'], 'content_type' => 2, 'public_dateline' => $dateline, 'pid' => $this->cache['p_arr']['pid'], 'public_info' => pserialize($timing_public_arr));
				article_timing_add($timing_setarr);
				$this->cache['reply']['now_key']++;
				$this->cache['mod'] = 'upload';//因为没有执行到下面，所以有时候附件上传因此无效
				continue;
			}
			$post_setarr = array(
				'fid' => $this->cache['common']['fid'],
				'tid' => $this->cache['common']['tid'],
				'first' => '0',
				'author' => $author,
				'authorid' => $authorid,
				'subject' => $subject,
				'dateline' => $dateline,
				'message' => $message,
				'useip' => $_G['clientip'],
				'invisible' => 0,
				'anonymous' => $isanonymous,
				'usesig' => $usesig,
				'htmlon' => $is_htmlon,
				'bbcodeoff' => $bbcodeoff,
				'smileyoff' => $smileyoff,
				'parseurloff' => $parseurloff,
				'attachment' => '0',
				'tags' => 0,
				'replycredit' => 0,
				'status' => (defined('IN_MOBILE') ? 8 : 0)
			);
			$post_setarr = paddslashes($post_setarr);
			$lastpost = $post_setarr['dateline'];
			$lastposter = $post_setarr['author'];
			$reply_pid = insertpost($post_setarr);
			if($this->cache['article_info']['content_arr'][$v]['postid']){
				$this->cache['reply']['postid_arr'][$this->cache['article_info']['content_arr'][$v]['postid']] = array('author' => $post_setarr['author'], 'time' => $post_setarr['dateline'], 'pid' => $reply_pid, 'message' => $post_setarr['message']);
			}
			DB::query("UPDATE ".DB::table('common_member_count')." SET posts=posts+1 WHERE uid='$post_setarr[authorid]'");//更新数
			$this->cache['reply']['now_key']++;
			$this->cache['reply']['replyed_num']++;
			//图片
			$this->cache['common']['reply_public_uid'] = $authorid;
			$this->cache['common']['reply_public_time'] = $dateline;
			$this->cache['common']['reply_pid'] = $reply_pid;
			$this->cache['common']['postid'] = $postid;
			$this->forum_attach_content(array('content' => $reply_content, 'cid' => $reply_info['cid']), 1);
			//跳转
			
		}
		if($this->cache['is_timing'] == 1 || !$lastposter || !$lastpost) return TRUE;
		//今日发帖
		$todayposts = 0;
		foreach((array)$this->cache['reply']['time_arr'] as $k => $v){
			if(date("Yjn", $_G['timestamp']) == date("Yjn", $v)) $todayposts++;
		
		}
		$this->reply_public_finsh(array('todayposts' => $todayposts, 'replies' => $this->cache['reply']['replyed_num'], 'lastpost' => $lastpost, 'lastposter' => $lastposter, 'tid' => $this->cache['common']['tid'], 'fid' => $this->cache['common']['fid']));
		$this->cache['mod'] = 'upload';
		
		return TRUE;
	}
	
	
	
	//外部调用，单独发布一个回复  author,authorid,subject,dateline,message(可选),reply_content.fid,tid,attach_arr,cid
	function run_public_reply($args){
		global $_G;
		extract($args);
		if(!$tid || !$fid) return;
		require_once libfile('function/editor');
		require_once libfile('function/post');
		$bbcodeoff = checkbbcodes($message, !empty($_GET['bbcodeoff']));
		$smileyoff = checksmilies($message, !empty($_GET['smileyoff']));
		$parseurloff = 0;
		$usesig = 1;
		$isanonymous = 0;
		$is_htmlon = $this->cache['p_arr']['is_html_public'] == 1 ? 1 : 0;
		$message = $message ? $message : content_html_ubb($reply_content, $this->cache['article_info']['url'], $is_htmlon);
		$this->cache['article_info']['attach_arr'][$cid] = $attach_arr;
		$this->aid = $aid;//附件检测的时候要用到
		$this->cache['article_info']['data_attach_arr'] = article_attach_by_aid($aid);
		$post_setarr = array(
			'fid' => $fid,
			'tid' => $tid,
			'first' => '0',
			'author' => $author,
			'authorid' => $authorid,
			'subject' => $subject,
			'dateline' => $dateline,
			'message' => $message,
			'useip' => $_G['clientip'],
			'invisible' => 0,
			'anonymous' => $isanonymous,
			'usesig' => $usesig,
			'htmlon' => $is_htmlon,
			'bbcodeoff' => $bbcodeoff,
			'smileyoff' => $smileyoff,
			'parseurloff' => $parseurloff,
			'attachment' => '0',
			'tags' => 0,
			'replycredit' => 0,
			'status' => (defined('IN_MOBILE') ? 8 : 0)
		);
		$post_setarr = paddslashes($post_setarr);
		$lastpost = $post_setarr['dateline'];
		$lastposter = $post_setarr['author'];
		$reply_pid = insertpost($post_setarr);
		DB::query("UPDATE ".DB::table('common_member_count')." SET posts=posts+1 WHERE uid='$post_setarr[authorid]'");//更新数

		//图片
		$this->cache['common']['reply_public_uid'] = $authorid;
		$this->cache['common']['reply_public_time'] = $dateline;
		$this->cache['common']['reply_pid'] = $reply_pid;
		$this->cache['common']['postid'] = $postid;
		$this->cache['common']['tid'] = $tid;
		$this->cache['common']['fid'] = $fid;
		$this->forum_attach_content(array('content' => $reply_content, 'cid' => $cid), 1);
		$this->cache['mod'] = 'upload';
		$this->upload_attach();//附件上传到远程服务器
		$todayposts = 0;
		if(date("Yjn", $_G['timestamp']) == date("Yjn", $dateline)) $todayposts++;
		$this->reply_public_finsh(array('todayposts' => $todayposts, 'replies' => 1, 'lastpost' => $lastpost, 'lastposter' => $lastposter, 'tid' => $tid, 'fid' => $fid));
	}
	
	//发布回复之后，更新最近发布、今日统计这些数据 $todayposts, $replies, $lastpost, $lastposter, $tid $fid
	function reply_public_finsh($args){
		//今日发帖
		extract($args);
		$replies = max($replies, 0);
		DB::update('forum_thread', array('lastpost' => $lastpost, 'lastposter' => $lastposter), array('tid'=> $tid));
		DB::query('UPDATE '.DB::table('forum_thread')." SET replies=replies+$replies WHERE tid='".$tid."'");
		$subject = str_replace("\t", ' ', daddslashes($subject));
		$replys = $replies ? $replies : 1;
		$forum_lastpost = "$tid\t$subject\t$lastpost\t".daddslashes($lastposter)."";
		DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$forum_lastpost', posts=posts+$replys, todayposts=todayposts+$todayposts WHERE fid='".$fid."'", 'UNBUFFERED');//更新今日发帖这些数据
	}
	
	
	//传入member_uid 如果会员没有注册，自动注册，返回信息
	function get_member_info($member_uid){
		if(!$member_uid) return -70;
		pload('F:member');
		$info = DB::fetch_first("SELECT * FROM ".DB::table('strayer_member')." WHERE uid ='$member_uid'");
		if(!$info['uid']) return -72;
		if($info['data_uid']){//查询uid是否已经被删除
			if(pick_check_uid_exists($info['data_uid']) != 'no') {
				//加一项，如果头像未设置的话，补上
				$this->member_set_avatar($info['uid'], $info['data_uid']);
				return array('uid' => $info['data_uid'], 'username' => $info['username']);
			}
		}
		//注册会员
		
		$info = get_member_setarr($info);
		$reg_info = pick_reg($info);
		if(!is_array($reg_info)) {
			if($reg_info == milu_lang('reged')){//已经被注册
				$reg_info = DB::fetch_first("SELECT uid,username FROM ".DB::table('common_member')." WHERE username ='".$info['username']."'");
				if($reg_info['uid']) return $reg_info;
				//如果能执行到这来，就是UC和discuz直接会员数据不同步导致的
				return -73;
			}
		}
		if($reg_info['uid']) {
			DB::update('strayer_member', array('public_dateline' => $_G['timestamp'], 'data_uid' => $reg_info['uid']), array('uid' => $member_uid));
			//头像设置
			$result = $this->member_set_avatar($member_uid, $reg_info['uid']);
			if($result < 0) {
			}
		}
		return $reg_info;
	}
	
	function member_set_avatar($member_uid, $uid){
		$size_arr = array('middle', 'big', 'small');//顺序一定不可以变
		$create_re = create_avatar_dir($uid ,'');//建立头像目录
		if(!$create_re) {
			return -1;//无法创建头像目录
		}
		pload('F:member');
		foreach($size_arr as $size){
			$avatar_dir_save = get_avatar_path($uid, $size);
			$avatar_file_name = PICK_PATH.'/'.get_avatar($member_uid, $size);
			if(file_exists($avatar_dir_save)) {
				@unlink($avatar_file_name);
				continue;
			}
			
			if(!file_exists($avatar_file_name)) return;//头像缓存不存在
			$img_re = file_get_contents($avatar_file_name);
			$put_re = file_put_contents($avatar_dir_save, $img_re);//写入头像
			if(!$put_re) {
				return -2;
			}
			//换完头像删除头像缓存
			@unlink($avatar_file_name);
		}
		
		
		return 1;		
	}
	
	function get_attach_content_by_url($imageurl, $attach_arr){
		$url_hash = md5($imageurl);
		$attach_info = $attach_arr[$url_hash];
		if(!$attach_info) return;
		$content_re = array();
		$attach_file = $this->attach_file_name($attach_info['save_name']);
		$content_re = $attach_info;
		$content_re['file_ext'] = get_fileext_from_url($attach_info['save_name']);
		if(!file_exists($attach_file)) return;
		$content_re['content'] = file_get_contents($attach_file);
		return $content_re;
	}
	
	function get_skydrive_attach_url($url){
		$root_url_arr = array('1' => 'http://bcs.duapp.com/',);
		$root_url = $url_arr[$this->pick_set['skydrive_type']];
		if($this->pick_set['skydrive_type'] == 1){//百度
			$attach_url = 'http://bcs.duapp.com/'.$this->pick_set['baidu_bucket'].'/'.urlencode(substr($url, 1));//生成访问地址
		}else{
			pload('F:attach');
			$attach_url = qiniu_attach_url($url);//生成访问地址
		}
		return $attach_url;
	}
	
	
	// $args 包含参数 content, cid
	function forum_attach_content($args, $is_post = 0){
		global $_G;
		extract($args);
		$tid = $this->cache['common']['tid'];
		$uid = $is_post ? $this->cache['common']['reply_public_uid'] : $this->cache['common']['public_uid'];		
		$public_time = $is_post ? $this->cache['common']['reply_public_time'] : $this->cache['common']['public_time'];
		$fid = $this->cache['common']['fid'];
		$pid = $is_post ? $this->cache['common']['reply_pid'] : $this->cache['common']['pid'];
		$del_a = 0;
		if($this->cache['p_arr']['content_filter_html'][0] == 0 && $this->cache['p_arr']['content_filter_html']){
			$del_a = 1;
		}
		require_once libfile('class/image');
		$attach_arr = $this->cache['article_info']['attach_arr'][$cid];
		if(!$attach_arr) return ;
		$public_time = $public_time ? $public_time : $_G['timestamp'];

		$get_file_ext_arr = $this->plugin_set['attach_download_allow_ext'] ? explode('|', $this->plugin_set['attach_download_allow_ext']) : array();
		
		pload_upload_class();
		$upload = new discuz_upload();
		$attachaids = array();
		$threadimage_flag = 0;
		$content_md5_arr = $imagereplace = array();
		$thread_image_data =  array();
		foreach($attach_arr as $key => $value){
			$imageurl = $value[1];
			$hash = md5($imageurl);
			if(!strlen($imageurl)) continue;
				$imagereplace['oldimageurl'][$key] = $value[0];
				$imagereplace['newimageurl'][$key] = $value[0];//图片不本地化没必要去掉
				$existentimg[$hash] = $imageurl;
				if(preg_match('/^((http|https):\/\/|\.)/i', $imageurl)) {
					$content_re = $this->get_attach_content_by_url($imageurl, $this->cache['article_info']['data_attach_arr']);
					if($content_re['isimage'] == 1 && $this->cache['p_arr']['is_download_img'] != 1){//图片不本地化，但是本地有图片缓存
						$content_re = array();
					}
					if($content_re['isimage'] != 1 && $content_re['content'] && $this->cache['p_arr']['is_download_file'] != 1){//
						$content_re = array();
					}
					$img_content = $content_re['content'];
					if($img_content && ($search_key = array_search(md5($img_content), $content_md5_arr)) !== FALSE) {
						if($value[4] == 1){//附件
							$imagereplace['newimageurl'][$key] = $del_a == 1 ? $value[2] : $value[0];
						}
						continue;
					}
					$content_md5_arr[] = md5($img_content);
				}else{//磁力链接这些
					if($value[4] == 1) $imagereplace['newimageurl'][$key] = $value[1];//磁力链接这些就去掉链接
					continue;
				}

				if(empty($img_content) || empty($content_re['file_ext'])) {
					continue;
				}
				

				if(!$this->pick_set['skydrive_type']){
					$attach_info = $this->attach_add(array('tid' => $tid, 'fid' => $fid, 'uid' => $uid, 'pid' => $pid, 'attach_img_info' => $content_re), $is_post);//添加附件
					if(!$attach_info['aid']) continue;
					$tableid = $attach_info['tableid'];
					$attachaids[$hash] = $imagereplace['newimageurl'][$key] = '[attach]'.$attach_info['aid'].'[/attach]';
					$newaids[] = $attach_info['aid'];
					
					$file_path = $this->attach_file_name($content_re['save_name']);
					if($content_re['isimage'] == 1) {
						$imginfo = @getimagesize($file_path);
						$width = $imginfo[0];
						if($thread_image_data['max_width'] == 0 || ($width > intval($thread_image_data['max_width']))){
							$thread_image_data['max_width'] = $width;
							$thread_image_data['aid'] = $attach_info['aid'];
							$thread_image_data['data'] = array(
								'tid' => $tid,
								'attachment' => $attach_info['attachment'],
								'remote' => getglobal('setting/ftp/on') ? 1 : 0,
							);
												
						}
					}
						
				}else{
					$attachdir = $upload -> get_target_dir('forum');
					$attach['attachment'] = $attachdir . $upload->get_target_filename('forum').'.'.$content_re['file_ext'];
					$upload_file_dir = '/forum/'.$attach['attachment'];
					$upload_url = $this->get_skydrive_attach_url($upload_file_dir);
					if($value[4] == 1){ 
						$imagereplace['newimageurl'][$key] = '[url='.$upload_url.']'.$content_re['description'].'[/url]';
					}else{
						$imagereplace['newimageurl'][$key] = '[img]'.$upload_url.'[/img]';
					}
					
					$file_path = $this->attach_file_name($content_re['save_name']);
					if($content_re['isimage'] == 1) {
						$imginfo = @getimagesize($file_path);
						$width = $imginfo[0];
						$this->cache['upload']['cover']['max_width'] = intval($this->cache['upload']['cover']['max_width']);
						if($this->cache['upload']['cover']['max_width'] == 0 || ($width > intval($this->cache['upload']['cover']['max_width']))){
							$this->cache['upload']['cover']['max_width'] = $width;
							$this->cache['upload']['cover']['save_name'] = $content_re['save_name'];
						}
					}
					$this->cache['upload']['sky_attach_arr'][] = array('from' => $file_path, 'to' => $upload_file_dir, 'save_name' => $content_re['save_name']);
				}
		}
		//只有ftp和本地图片才设置
		if($thread_image_data['aid'] && !$is_post){
			DB::insert('forum_threadimage', $thread_image_data['data'], true);
		}
		$this->cache['upload']['newaids'][$pid] = array('uid' => $uid, 'aids' => $newaids);
		foreach($imagereplace['oldimageurl'] as $k => $v){//封面
			if($v == '{@cover}'){
				unset($imagereplace['oldimageurl'][$k], $imagereplace['newimageurl'][$k]);
			}
		}
		$content = str_replace($imagereplace['oldimageurl'], $imagereplace['newimageurl'], $content);
		if($del_a == 1) {
			$content = clear_html_script($content, array(0));
		}
		$attachment = (count($newaids) > 0 || count($this->cache['upload']['sky_attach_arr']) > 0) ? 2 : 0;
		//更新内容
		$setarr = array();
		require_once libfile('function/editor');
		require_once libfile('function/home');
		$setarr['attachment'] = $attachment;
		$setarr['message'] = $content;
		$is_htmlon = $this->cache['p_arr']['is_html_public'] == 1 ? 1 : 0;
		$setarr['message'] = content_html_ubb($setarr['message'], $this->cache['article_info']['url'], $is_htmlon);
		if(!$this->cache['common']['postid'] && strexists($setarr['message'], '[quote]')){//如果不存在，也要替换掉引用代码
			$setarr['message'] = replace_something($setarr['message'], '[quote][size=2][color=#999999](*)[/quote]@@');
		}
		
		if(VIP && $this->pick_config['pick_config']['open_fanyi_module'] == 1 && $this->pick_set['tran_is_open'] == 1) {
			$fanyi_arr = pick_fanyi($setarr['message'], '', array('pid' => $this->cache['p_arr']['pid']));//翻译
			if($fanyi_arr){
				$setarr['message'] = $fanyi_arr['content'];
			}
		}
		
		$bbcodeoff = checkbbcodes($setarr['message'], FALSE);
		$setarr['bbcodeoff'] = $bbcodeoff;
		$setarr = paddslashes($setarr);
		DB::update('forum_post', $setarr, array('pid' => $pid));
		if(!$is_post || $is_post > 0 && $attachment > 0) {
			
			DB::update('forum_thread', array('attachment' => $attachment), array('tid' => $tid));	
			//图片列表模式的帖子设置封面
			$_G['setting']['forumpicstyle']  = $this->load_forumpicstyle();
			if($_G['setting']['forumpicstyle']) {
				if($this->pick_set['skydrive_type'] && $this->cache['upload']['cover']['save_name']){//如果是远程附件
					$attach_dir = str_replace(PICK_DIR, '', PICK_ATTACH_PATH);
					$picsource = PICK_URL.$attach_dir.'/'.$this->cache['p_arr']['pid'].'/'.$this->aid.'/'.$this->cache['upload']['cover']['save_name'];
					$this->forum_set_cover($tid, $picsource);
				}else{
					//ftp的话，后面再设置封面
					if(getglobal('setting/ftp/on')){
						$this->cache['upload']['cover']['pid'] = $this->cache['common']['pid'];
						$this->cache['upload']['cover']['style'] = $_G['setting']['forumpicstyle'];
					}else{
						$_G['forum']['ismoderator'] = 1;
						$_G['uid'] = $uid;//必须有这个，不然函数会返回
						setthreadcover($this->cache['common']['pid']);
					}
				}
			}	
		}	
		//结束
	}
	function load_forumpicstyle(){
		global $_G;
		$fid = $this->cache['common']['fid'];
		$forumpicstyle = DB::result_first("SELECT picstyle FROM ".DB::table('forum_forumfield')." WHERE fid='$fid'");
		if(!$forumpicstyle) return;
		loadcache('setting');
		if(DISCUZ_VERSION != 'X2.5' && DISCUZ_VERSION != 'X2'){//3.1以上有瀑布流
			$width = 203;
			$height = 999;
		}else{
			$width = 214;
			$height = 160;
		}
		if($_G['setting']['forumpicstyle']) {
			if(!is_array($_G['setting']['forumpicstyle'])) $_G['setting']['forumpicstyle'] = dunserialize($_G['setting']['forumpicstyle']);
			empty($_G['setting']['forumpicstyle']['thumbwidth']) && $_G['setting']['forumpicstyle']['thumbwidth'] = $width;
			empty($_G['setting']['forumpicstyle']['thumbheight']) && $_G['setting']['forumpicstyle']['thumbheight'] = $height;
		} else {
			$_G['setting']['forumpicstyle'] = array('thumbwidth' => $width, 'thumbheight' => $height);
		}
		return $_G['setting']['forumpicstyle'];

	}
	
	function get_article_dateline(){
		if(!empty($this->cache['article_info']['article_dateline']) && $this->cache['p_arr']['public_time_type'] == 2) return $this->cache['article_info']['article_dateline'];
		$time_arr = create_public_time(array('p_arr' => $this->cache['p_arr']), 1);
		$public_time = array_pop ($time_arr);
		$public_time = !empty($public_time) ? $public_time : TIMESTAMP;
		return $public_time;
	}
	
	function get_article_user_info(){
		if($this->cache['article_info']['uid']){//采集到的会员
			$user_info = $this->get_member_info($this->cache['article_info']['uid']);
			if(is_array($user_info) && $user_info['uid']){
				return $user_info;
			}
		}
		$rand_arr = get_rand_uid(array('p_arr' => $this->cache['p_arr']));
		$data['uid']  = $rand_arr[0]['uid'] ? $rand_arr[0]['uid'] : $_G['uid'];
		$data['username'] = $rand_arr[0]['username'] ? $rand_arr[0]['username'] : $_G['username'];
		return $data;
	}
	
	//文章发布到门户
	function move_portal(){
		global $_G;
		require_once libfile('function/home');
		require_once libfile('function/portalcp');
		$subject = getstr(trim($this->cache['article_info']['title']), $this->plugin_set['title_length'], 0, 0);
		if($this->cache['check_title'] == 1){//检测标题
			if(!strlen($subject)) return FALSE;
			$num = DB::result_first('SELECT COUNT(*) FROM '.DB::table('portal_article_title')." WHERE title='".daddslashes($subject)."'");
			if($num) return FALSE;
		}
		$content = $this->cache['article_info']['content'];
		
		$catid = $this->cache['portal'];
		loadcache('portalcategory');
		$cat_arr = $_G['cache']['portalcategory'];
		$cat_info = $cat_arr[$catid];
		$contents = 0;
		if($this->cache['article_info']['contents'] > 1 && $this->cache['p_arr']['is_page_public'] == 2 && $this->cache['article_info']['is_bbs'] != 1){//是否决定合并内容
			$contents = count($this->cache['article_info']['content_arr']);
		}
		
		$content = $this->page_get_content();
		
		if(empty($this->cache['article_info']['summary'])) $this->cache['article_info']['summary'] = portalcp_get_summary(stripslashes($content));
		
		//文章发布时间
		$dateline = $this->cache['article_info']['public_time'];
		
		//用户设定
		$uid = $this->cache['article_info']['public_uid'];
		$username = $this->cache['article_info']['public_username'];
		
		
		$pic = $arr['pic'] ? $_thumb.addslashes($arr['pic']) : '';
		$thumb = 0; 
		$remote = 0;
		$setarr = array(
			'title' => $subject,
			'author' => $this->cache['article_info']['author'],//原作者
			'from' => $this->cache['article_info']['from'],
			'catid' => $catid,
			'pic' => $pic,
			'thumb' => $thumb,
			'remote' => $remote,
			'fromurl' => $this->cache['article_info']['fromurl'],
			'dateline' => $dateline,
			'url' => '',
			'allowcomment' => $cat_info['allowcomment'],//是否允许评论
			'summary' => $this->cache['article_info']['summary'],
			'tag' => $this->cache['article_info']['tag'],//文章聚合标签，不是标签
			'status' => 0,
			'highlight' => $style,
			'showinnernav' => empty($arr['showinnernav']) ? '0' : '1',
			'uid' => $uid,
			'username' => $username,
			'contents' => $contents
		);
		if($this->cache['article_info']['portal_id']){//检查文章被放进回收站或者删除
			$info = DB::fetch_first("SELECT catid,aid FROM ".DB::table('portal_article_title')." WHERE aid='".$this->cache['article_info']['portal_id']."'");
			//删除附件
			pic_delete($info['pic'], 'portal', $info['thumb'], $info['remote']);
			
			$query = DB::query("SELECT * FROM ".DB::table('portal_attachment')." WHERE aid='".$this->cache['article_info']['portal_id']."' ORDER BY attachid DESC");
			while ($value = DB::fetch($query)) {
				pic_delete($value['attachment'], 'portal', $value['thumb'], $value['remote']);
			}
			DB::query('DELETE FROM '.DB::table('portal_attachment')." WHERE aid='".$this->cache['article_info']['portal_id']."'");//删除目前的数据再更新
			
		}
		if(!$info['aid']){//旧文章已经不在
			$aid = DB::insert('portal_article_title', paddslashes($setarr), 1);
			DB::update('common_member_status', array('lastpost' => $dateline), array('uid' => $uid));
		}else{
			DB::update('portal_article_title', paddslashes($setarr), array('aid' => $this->cache['article_info']['portal_id']));
			DB::query('UPDATE '.DB::table('portal_category')." SET articles=articles-1 WHERE catid='".$catid."'");
			$aid = $this->cache['article_info']['portal_id'];
		}
		//文章点击率更新
		$count_setarr = array(
			'viewnum' => $this->cache['article_info']['view_num'],
			'dateline' => $dateline,
		);
		if(DISCUZ_VERSION != 'X2'){//2.5版本
			unset($count_setarr['dateline']);
			
		}
		$view_check = DB::fetch_first("SELECT aid FROM ".DB::table('portal_article_count')." WHERE aid='".$aid."'");
		if($view_check){
			DB::update('portal_article_count', $count_setarr, array('aid' => $aid));
		}else{
			$count_setarr['aid'] = $aid;
			DB::insert('portal_article_count', $count_setarr);
		}
		//相关文章
		$relatedarr = dunserialize($this->cache['article_info']['raids']);
		DB::query('DELETE FROM '.DB::table('portal_article_related')." WHERE aid='$aid'");//删除目前的数据再更新
		DB::query('DELETE FROM '.DB::table('portal_article_related')." WHERE raid='$aid'");//删除目前的数据再更新
		if($relatedarr) {
			$query = DB::query("SELECT * FROM ".DB::table('portal_article_title')." WHERE aid IN (".dimplode($relatedarr).")");
			$list = array();
			while(($value=DB::fetch($query))) {
				$list[$value['aid']] = $value;
			}
			$replaces = array();
			$displayorder = 0;
			foreach($relatedarr as $relate) {
				if(($value = $list[$relate])) {
					if($value['aid'] != $aid) {
						$replaces[] = "('$aid', '$value[aid]', '$displayorder')";
						$replaces[] = "('$value[aid]', '$aid', '0')";
						$displayorder++;
					}
				}
			}
			if($replaces) {
				DB::query("REPLACE INTO ".DB::table('portal_article_related')." (aid,raid,displayorder) VALUES ".implode(',', $replaces));
			}
		}
		
		//上下篇文章 x3版本以上新增功能
		if(DISCUZ_VERSION != 'X2' && DISCUZ_VERSION != 'X2.5'){
			$pre_next_arr = portalcp_article_pre_next($catid, $aid);
			DB::update('portal_article_title', $pre_next_arr, array('aid' => $aid));
		}
		
		DB::query('UPDATE '.DB::table('portal_category')." SET articles=articles+1 WHERE catid='".$catid."'");
		
		$this->cache['common']['public_uid'] = $uid;
		$this->cache['common']['public_username'] = $username;
		$this->cache['common']['public_time'] = $dateline;
		$this->cache['common']['catid'] = $catid;
		$this->cache['common']['aid'] = $aid;
		
		$this->cache['finsh']['insert_id'] = $aid;
		
		//内容图片更新
		
		//

		$this->artilce_attach_content($content);
		
	}
	
	
	function page_get_content(){
		if($this->cache['article_info']['is_bbs'] == 1 || !$this->cache['article_info']['content_arr']) {
			$content = $this->cache['article_info']['content'];
			if(VIP) $content = pick_reply_post($content, array('cookie' => $this->cache['p_arr']['login_cookie'], 'page_url' => $this->cache['article_info']['url'], 'cid' => $this->cache['article_info']['cid']));
			//采集回复可见内容(要是采集到的回复可见内容里面含有图片呢？)
		}else{
			$content_arr = $this->cache['article_info']['content_arr'];
			$page_flag = '';
			array_unshift($content_arr, array('cid' => $this->cache['article_info']['cid'], 'aid'  => $this->cache['article_info']['aid'], 'pageorder' => 1, 'content' => $this->cache['article_info']['content'], 'title' => $this->cache['article_info']['title']));

			if($this->cache['p_arr']['is_page_public'] !=1){//如果是分页发布
				if($this->cache['optype'] == 'move_portal'){//发布到门户
					ksort($content_arr);
					$content = content_merge($content_arr, 1);
				}else if($this->cache['optype'] == 'move_forums'){//发布到论坛
					//分帖发布
					$content = $this->cache['article_info']['content'];
				}
			}else{//如果不分页发布
				ksort($content_arr);
				$content = content_merge($content_arr);//都合并起来
				
			}
			
		}
		return $content;
	}
	
	//门户、博客，通用
	function artilce_attach_content($content){
		global $_G;
		require_once libfile('class/image');
		$this->cache['article_info']['content_is_have_cover'] = strexists($content, '{@cover}') ? 1 : 0;//判断内容是否含有封面
		if(!empty($this->cache['article_info']['cover_pic']) && $this->cache['article_info']['content_is_have_cover']){
			$this->cache['article_info']['attach_arr'][$this->cache['article_info']['cid']] = (array)$this->cache['article_info']['attach_arr'][$this->cache['article_info']['cid']];
			array_push($this->cache['article_info']['attach_arr'][$this->cache['article_info']['cid']], array(0 => '{@cover}', 1 => $this->cache['article_info']['cover_pic']));
		}
		//合并所有附件	
		$attach_arr = array();
		foreach($this->cache['article_info']['attach_arr'] as $k => $v){
			$attach_arr = array_merge((array)$attach_arr, (array)$v);
		}
		
		
		$public_time = $this->cache['common']['public_time'] ? $this->cache['common']['public_time'] : $_G['timestamp'];

		$get_file_ext_arr = $this->plugin_set['attach_download_allow_ext'] ? explode('|', $this->plugin_set['attach_download_allow_ext']) : array();
		$del_a = 0;
		if($this->cache['p_arr']['content_filter_html'][0] == 0 && $this->cache['p_arr']['content_filter_html']){
			$del_a = 1;
		}
		pload_upload_class();
		$upload = new discuz_upload();
		$content_md5_arr = array();
		$imagereplace = $aids = array();
		$attach_dir_name = $this->cache['optype'] == 'move_portal' ? 'portal' : 'album';
		foreach($attach_arr as $key => $value){
			$tempvalue = $value;
			$imageurl =  $tempvalue[1];
		    $attach['ext'] = $upload->fileext($imageurl);
			$imagereplace['img_search'][$key] = $tempvalue[0];
			$content_re = $this->get_attach_content_by_url($imageurl, $this->cache['article_info']['data_attach_arr']);
			if($content_re['isimage'] == 1 && $this->cache['p_arr']['is_download_img'] != 1){//图片不本地化，但是本地有图片缓存
				$content_re = array();
			}
			if($content_re['isimage'] != 1 && $content_re['content'] && $this->cache['p_arr']['is_download_file'] != 1){//
				$content_re = array();
			}
			$img_content = $content_re['content'];
			$attach['name'] = $content_re['file_name'] ;
			$attach['ext'] = $content_re['file_ext'];
			
			if(empty($img_content)) {
				if($del_a == 1){
					$imagereplace['img_replace'][$key] = clear_html_script($imagereplace['img_search'][$key], array(0));
				}else{
					$imagereplace['img_replace'][$key] = $value[0];
				}
				continue;
			}
			
			if($img_content && in_array(md5($img_content), $content_md5_arr)) {
				
				unset($imagereplace['img_search'][$key]);
				continue;
			}
			$content_md5_arr[] = md5($img_content);
			

			$attach['thumb'] = '';

			$attach['isimage'] = $upload -> is_image_ext($attach['ext']);
			
			//日志是不允许下载附件的,但可以保留附件的下载链接
			if($attach['isimage'] == 0 && $this->cache['optype'] == 'move_blog'){
				$imagereplace['newimageurl'][$key] = $imageurl == $this->cache['redirect_attach_info']['attach_redirect_url'] ? $this->cache['redirect_attach_info']['attach_download_url'] : $imageurl;;
			}
			
			$imagereplace['oldimageurl'][$key] = $tempvalue[1];
			////////////
			
			$file_path = $this->attach_file_name($content_re['save_name']);
			$attach['attachment'] = $upload -> get_target_dir($attach_dir_name) . $upload->get_target_filename($attach_dir_name).'.'.$content_re['file_ext'];
			if($content_re['isimage'] == 1) {//搜集起来做封面
				$imginfo = @getimagesize($file_path);
				$width = $imginfo[0];
				$this->cache['upload']['cover']['max_width'] = intval($this->cache['upload']['cover']['max_width']);
				if($this->cache['upload']['cover']['max_width'] == 0 || ($width > intval($this->cache['upload']['cover']['max_width']))){
					$this->cache['upload']['cover']['max_width'] = $width;
					$this->cache['upload']['cover']['save_name'] = $content_re['save_name'];
					
					$this->cache['upload']['cover']['target'] = getglobal('setting/attachdir').'./'.$attach_dir_name.'/'.$attach['attachment'];
					$this->cache['upload']['cover']['attachment'] = $attach['attachment'];
				}
			}
		
			
			//上传到网盘
			if($this->pick_set['skydrive_type']){
				$attachdir = $upload -> get_target_dir($attach_dir_name);
				$upload_file_dir = '/'.$attach_dir_name.'/'.$attach['attachment'];
				$upload_url = $this->get_skydrive_attach_url($upload_file_dir);
				$imagereplace['newimageurl'][$key] = $upload_url;
				$this->cache['upload']['sky_attach_arr'][] = array('from' => $file_path, 'to' => $upload_file_dir, 'save_name' => $content_re['save_name']);
			}else{
				//好像没有处理掉不允许下载的扩展名
				$attach['extension'] = $upload -> get_target_extension($attach['ext']);
				$attach['attachdir'] = $upload -> get_target_dir($attach_dir_name);
				$attach['target'] = getglobal('setting/attachdir').'./'.$attach_dir_name.'/'.$attach['attachment'];
	
				
				if(!@$fp = fopen($attach['target'], 'wb')) {
					continue;
				} else {
					flock($fp, 2);
					fwrite($fp, $img_content);
					fclose($fp);
				}
				if(!$upload->get_image_info($attach['target']) && $attach['isimage'] == 1) {
					@unlink($attach['target']);
					continue;
				}
				$attach['size'] = $content_re['filesize'];
				$attach = daddslashes($attach);
				
				//打水印
				if($attach['isimage'] && empty($_G['setting']['portalarticleimgthumbclosed'])) {
					$image = new image();
					$thumbimgwidth = $_G['setting']['portalarticleimgthumbwidth'] ? $_G['setting']['portalarticleimgthumbwidth'] : 300;
					$thumbimgheight = $_G['setting']['portalarticleimgthumbheight'] ? $_G['setting']['portalarticleimgthumbheight'] : 300;
					$result = $image->Thumb($attach['target'], '', $thumbimgwidth, $thumbimgheight, 2);
					$attach['thumb'] = empty($result)?0:1;
					if($this->cache['p_arr']['is_water_img'] == 1) $image->Watermark($attach['target'], '', $attach_dir_name);//打水印
				}
				
				//开启FTP
				if(VIP && $_G['setting']['ftp']['on'] && $this->ftp_check_attach($content_re['file_ext'], $attach['size'])){
					$remote = 1;
				}
				
				$attach['remote'] = $remote;
				
				//门户
				if($this->cache['optype'] == 'move_portal'){
					
					$setarr = array(
						'uid' => $this->cache['common']['public_uid'],
						'filename' => $attach['name'],
						'attachment' => $attach['attachment'],
						'filesize' => $attach['size'],
						'isimage' => $attach['isimage'],
						'thumb' => $attach['thumb'],
						'remote' => $attach['remote'],
						'filetype' => $attach['extension'],
						'dateline' => $this->cache['common']['public_time'],
						'aid' => $this->cache['common']['aid']
					);
					$setarr['attachid'] = DB::insert("portal_attachment", paddslashes($setarr), true);
					if($remote == 1){
						$aids[$setarr['attachid']] = $setarr['attachid'];
						$this->cache['upload']['attach_arr'][$setarr['attachid']] = $setarr;
					}
				//博客
				}else if($this->cache['optype'] == 'move_blog'){
					
					
					$arr['pic'] = $attach['attachment'];
					
					$new_name = $attach['target'];
	
					$image = new image();
					$result = $image->Thumb($new_name, '', 140, 140, 1);
					$thumb = empty($result)?0:1;
				
					if($_G['setting']['maxthumbwidth'] && $_G['setting']['maxthumbheight']) {
						if($_G['setting']['maxthumbwidth'] < 300) $_G['setting']['maxthumbwidth'] = 300;
						if($_G['setting']['maxthumbheight'] < 300) $_G['setting']['maxthumbheight'] = 300;
						$image->Thumb($new_name, '', $_G['setting']['maxthumbwidth'], $_G['setting']['maxthumbheight'], 1, 1);
					}
				
					if ($iswatermark) {
						$image->Watermark($new_name, '', 'album');
					}
					
					$album_picflag = 1;
				
					$setarr = array(
						'uid' => $this->cache['common']['public_uid'],
						'filename' => $attach['name'],
						'filepath' => $attach['attachment'],
						'size' => $attach['size'],
						'thumb' => $attach['thumb'],
						'username' => $this->cache['common']['public_username'],
						'postip' => $_G['clientip'],
						'remote' => $attach['remote'],
						'type' => $attach['extension'],
						'dateline' =>  $this->cache['common']['public_time'],
					);
					$setarr['attachid'] = DB::insert("home_pic", paddslashes($setarr), true);
					if($attach['remote'] == 1){
						$aids[$setarr['attachid']] = $setarr['attachid'];
						$attach_upload_info = $setarr;
						$attach_upload_info['attachment'] = $attach_upload_info['filepath'];
						$this->cache['upload']['attach_arr'][$setarr['attachid']] = $attach_upload_info;
					}
					if($attach['thumb'] == 1 && $feed_re !=1){
						$feed['image_1'] =  'data/attachment/album/'.$attach['attachment'].'.thumb.jpg';
						$feed['image_1_link'] =  'home.php?mod=space&uid='.$arr['uid'].'&do=blog&id='.$arr['aid'];
						DB::update("home_feed", $feed, array("idtype" => 'blogid', 'id' => $arr['aid']));
						$feed_re = 1;
					}
				}
				
				$attach['url'] = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']).''.$attach_dir_name.'/';
				if($attach['isimage'] == 1){//图片
					$imagereplace['newimageurl'][$key] = $attach['url'].$attach['attachment'];
				}else{
					if($this->cache['optype'] == 'move_portal'){
						$imagereplace['newimageurl'][$key] = 'portal.php?mod=attachment&amp;id='.$setarr['attachid'];
						$imagereplace['img_replace'][$key] = '<p><a href="'.$imagereplace['newimageurl'][$key].'" target="_blank" class="attach">'.$attach['name'].'</a></p>';
					}
				}
				
			}
			
			
			
			
			
		}
		
		
		$this->cache['upload']['newaids'] = $aids;

		if($imagereplace) {
			foreach($imagereplace['oldimageurl'] as $k => $v){
				$imagereplace['img_replace'][$k] = $imagereplace['img_replace'][$k] ? $imagereplace['img_replace'][$k] : str_replace($imagereplace['oldimageurl'][$k], $imagereplace['newimageurl'][$k], $imagereplace['img_search'][$k]);
				if($imagereplace['img_search'][$k] == '{@cover}'){
					$cover_pic = str_replace($_G['setting']['attachurl'], '', $imagereplace['newimageurl'][$k]);//封面
					if($this->cache['article_info']['content_is_have_cover'] == 1){//内容有嵌入封面
						$imagereplace['img_replace'][$k] = '<img src="'.$imagereplace['newimageurl'][$k].'"  border="0" >';
					}
					
				}
			}
			ksort($imagereplace['img_search']);
			ksort($imagereplace['img_replace']);
			$content = str_replace($imagereplace['img_search'], $imagereplace['img_replace'], $content);
			$content = preg_replace(array("/\<(script|style|iframe)[^\>]*?\>.*?\<\/(\\1)\>/si", "/\<!*(--|doctype|html|head|meta|link|body)[^\>]*?\>/si"), '', $content);
			$content = str_replace(array("\r", "\n", "\r\n"), ' ', addcslashes($content, '/"\\'));
			$content = dstripslashes($content);
		}

		//门户内容更新	
		if($this->cache['optype'] == 'move_portal'){
			$aid = $this->cache['common']['aid'];
			$is_htmlon = $this->cache['p_arr']['is_html_public'] == 1 ? 1 : 0;
			
			$content =  media_htmlbbcode($content, $this->cache['article_info']['url'], 'protal', $is_htmlon);
			$content = audio_htmlbbcode($content, $this->cache['article_info']['url'], 'protal', $is_htmlon);
			$content = getstr($content, 0, 0, 1, 0, 1);
			$article_status = 0;
			$regexp = '/(###NextPage(\[title=(.*?)\])?###)+/';
			preg_match_all($regexp, $content ,$arr);
			$pagetitle = $arr[3];
			$pagetitle = array_map('trim', $pagetitle);
			$content_arr = preg_split($regexp, $content);
			$content_count = count($contents);
			$pageorder = intval($arr['pageorder']);
			$id = 0;
			if($this->cache['article_info']['portal_id']){
				DB::query('DELETE FROM '.DB::table('portal_article_content')." WHERE aid ='".$this->cache['article_info']['portal_id']."'");
			}
			DB::query('DELETE FROM '.DB::table('portal_article_content')." WHERE aid ='$aid'");
			$idtype = '';
			$thumb = $cover_pic ? 1 : 0;
			$remote = 0;
			if($content_arr) {
				$remote = $_G['setting']['ftp']['on'] == 1 && !$this->pick_set['skydrive_type'] ? 1 : 0;
				//有封面，但是内容没有包含封面,需要单独设置
				if(empty($this->cache['upload']['cover']['save_name']) && $this->cache['article_info']['cover_pic']){
					$attach_img_info = $this->get_attach_content_by_url($this->cache['article_info']['cover_pic'], $this->cache['article_info']['data_attach_arr']);
					if($attach_img_info['save_name']){
						
						$save_name = $attach_img_info['save_name'];
						$attachdir = $upload -> get_target_dir('portal');
						$attachment = $attachdir . $upload->get_target_filename('portal').'.'.$attach_img_info['file_ext'];
					
						$remote = $_G['setting']['ftp']['on'] == 1 && !$this->pick_set['skydrive_type'] ? 1 : 0;
						
						$setarr = array(
							'uid' => $this->cache['common']['public_uid'],
							'filename' => $attach_img_info['file_name'],
							'attachment' => $attachment,
							'filesize' => $attach_img_info['filesize'],
							'isimage' => 1,
							'thumb' => 1,
							'remote' => $remote,
							'filetype' => $attach_img_info['file_ext'],
							'dateline' => $this->cache['common']['public_time'],
							'aid' => $this->cache['common']['aid']
						);
						$setarr['attachid'] = DB::insert("portal_attachment", paddslashes($setarr), true);
						$this->cache['upload']['newaids'][$setarr['attachid']] = $setarr['attachid'];
						$this->cache['upload']['attach_arr'][$setarr['attachid']] = $setarr;
						$root_url = ($remote ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']).''.$attach_dir_name.'/';
						$cover_pic = $this->setcover_article($save_name, $attachment, 'portal');
					}
				}
				
				if(empty($this->pick_set['skydrive_type']) && $_G['setting']['ftp']['on'] == 1){//去掉大图，留下小图 
					@unlink(getglobal('setting/attachdir').'./'.$cover_pic);
				}
				//从图片里面设置封面
				if($this->cache['upload']['cover']['save_name']){
					if($this->pick_set['skydrive_type']){
						$cover_pic = $this->setcover_article($this->cache['upload']['cover']['save_name'], $this->cache['upload']['cover']['attachment']);
						//@unlink(getglobal('setting/attachdir').'./portal/'.$this->cache['upload']['cover']['attachment']);
					}else{
						$cover_pic = 'portal/'.$this->cache['upload']['cover']['attachment'];
					}
				}
				
			
				
				
				$thumb = $cover_pic ? 1 : 0;
				
				$inserts = array();
				foreach ($content_arr as $key => $value) {
					$value = trim($value);
					$inserts[] = "('$aid', '".(empty($pagetitle[$key-1]) && $content_count > 1 ? $this->cache['article_info']['title'] : $pagetitle[$key-1])."', '$value', '".($pageorder+$key)."', '".$this->cache['common']['public_time']."', '$id', '$idtype')";
				}
				DB::query("INSERT INTO ".DB::table('portal_article_content')."
					(aid, title, content, pageorder, dateline, id, idtype)
					VALUES ".implode(',', $inserts));
				
				DB::query('UPDATE '.DB::table('portal_article_title')." SET status = '$article_status',pic = '".$cover_pic."', thumb='$thumb', remote='$remote', contents = ".count($inserts)." WHERE aid='$aid'");
			}
			
		}else if($this->cache['optype'] == 'move_blog'){
			$setarr = array();
			
			//有封面，但是内容没有包含封面,需要单独设置
			if(empty($this->cache['upload']['cover']['save_name']) && $this->cache['article_info']['cover_pic']){
				$attach_img_info = $this->get_attach_content_by_url($this->cache['article_info']['cover_pic'], $this->cache['article_info']['data_attach_arr']);
				if($attach_img_info['save_name']){
					$save_name = $attach_img_info['save_name'];
					$attachdir = $upload -> get_target_dir('album');
					$attachment = $attachdir . $upload->get_target_filename('album').'.'.$attach_img_info['file_ext'];
				
					$remote = $_G['setting']['ftp']['on'] == 1 && !$this->pick_set['skydrive_type'] ? 1 : 0;
					
					$setarr = array(
						'uid' => $this->cache['common']['public_uid'],
						'filename' => $attach_img_info['file_name'],
						'filepath' => $attachment,
						'size' => $attach_img_info['filesize'],
						'thumb' => 1,
						'username' => $this->cache['common']['public_username'],
						'postip' => $_G['clientip'],
						'remote' => $remote,
						'type' => $attach_img_info['file_ext'],
						'dateline' =>  $this->cache['common']['public_time'],
					);
					$setarr['attachid'] = DB::insert("home_pic", paddslashes($setarr), true);
					$this->cache['upload']['newaids'][$setarr['attachid']] = $setarr['attachid'];
					$attach_upload_info = $setarr;
					$attach_upload_info['filepath'] = ($this->pick_set['skydrive_type'] || $_G['setting']['ftp']['on'] == 1) ? $attach_upload_info['filepath'].'.thumb.jpg' : $attach_upload_info['filepath'];
					$attach_upload_info['attachment'] = $attach_upload_info['filepath'];//如果是远程附件，只上传缩略图就行了
					$this->cache['upload']['attach_arr'][$setarr['attachid']] = $attach_upload_info;
					$root_url = ($remote ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']).''.$attach_dir_name.'/';
					$cover_pic = $attachment;
					$this->setcover_article($save_name, $attachment, 'album');
				}
			}
			
			
			//如果是远程附件,内容里面含封面
			if($this->pick_set['skydrive_type'] && $this->cache['upload']['cover']['save_name']){
				$cover_pic = $this->setcover_article($this->cache['upload']['cover']['save_name'], $this->cache['upload']['cover']['attachment'], 'album');
			}
			
			if(empty($this->pick_set['skydrive_type']) && $_G['setting']['ftp']['on'] == 1){//去掉大图，留下小图  
				@unlink(getglobal('setting/attachdir').'./album/'.$cover_pic);
			}
			
			
			//从图片里面设置封面
			if($this->cache['upload']['cover']['save_name']){
				if($this->pick_set['skydrive_type']){
					$cover_pic = $this->setcover_article($this->cache['upload']['cover']['save_name'], $this->cache['upload']['cover']['attachment'], 'album');
					//@unlink(getglobal('setting/attachdir').'./album/'.$this->cache['upload']['cover']['attachment']);
				}else{
					$cover_pic = $this->cache['upload']['cover']['attachment'];
				}
			}
			
			
			$setarr = array();	
			$setarr['pic'] = $cover_pic ? $cover_pic.'.thumb.jpg' : '';
			
			if($cover_pic) {
				$picflag = $_G['setting']['ftp']['on'] == 1 && !$this->pick_set['skydrive_type'] ? 2 : 1;
				
				
				DB::update("home_blog", array('picflag' => $picflag), array('blogid' => $this->cache['common']['aid']));	
			}
			
			$content = preg_replace(array(
				"/\<div\>\<\/div\>/i",
				"/\<a\s+href\=\"([^\>]+?)\"\>/i"
			), array(
				'',
				'<a href="\\1" target="_blank">'
			), $content);
					
			$content =  media_htmlbbcode($content, $this->cache['article_info']['url'], 'blog');
			$content = paddslashes($content);
			$setarr['message'] = $content;
			DB::update('home_blogfield', $setarr, array('blogid' => $this->cache['common']['aid']));
		}
		$this->cache['mod'] = 'upload';
	}
	
	//设置门户、博客封面
	function setcover_article($cover_save_name, $attachment, $type_dir = 'portal'){
		global $_G;
		$image = new image();
		$thumbimgwidth = $_G['setting']['portalarticleimgthumbwidth'] ? $_G['setting']['portalarticleimgthumbwidth'] : 300;
		$thumbimgheight = $_G['setting']['portalarticleimgthumbheight'] ? $_G['setting']['portalarticleimgthumbheight'] : 300;
		$img_file = $this->attach_file_name($cover_save_name);
		$cover_pic_content = file_get_contents($img_file);
		if(empty($cover_pic_content)) return;
		$target = getglobal('setting/attachdir').'./'.$type_dir.'/'.$attachment;
		file_put_contents($target, $cover_pic_content);
		$thumb = $image->Thumb($target, '', $thumbimgwidth, $thumbimgheight, 2);
		if($thumb){
			$cover_pic = $type_dir == 'portal' ? $type_dir.'/'.$attachment : $attachment;
			return $cover_pic;
		}
		return FALSE;
	}
	
	function move_blog(){
		global $_G;
		require_once libfile('function/blog');
		require_once libfile('function/home');
		
		$subject = $this->cache['article_info']['title'];
		if(!strlen($subject)) return -1;
		if($this->cache['check_title']){
			$num = DB::result_first('SELECT COUNT(*) FROM '.DB::table('home_blog')." WHERE subject='".daddslashes($subject)."'");
			if($num) return -3;
		}
		
		$content = $this->page_get_content();
		$POST['subject'] = $subject;
		$POST['message'] = $content;
		$POST['friend'] = 0;//全站用户可见
		$POST['public_time'] = $this->cache['article_info']['public_time'];
		$olds['catid'] = $this->cache['article_info']['blog_big_cid'];
		$olds['classid'] = $this->cache['article_info']['blog_small_cid'];
		
		$POST['catid'] = $this->cache['blog'];
		$POST['classid'] = $this->cache['blog_small_cid'];
		
		$uid = $this->cache['article_info']['public_uid'];
		$username = $this->cache['article_info']['public_username'];
		
		if(!strlen($content)) return -2;

		$POST['subject'] = getstr(trim($subject), $this->plugin_set['title_length'], 0, 0);
		if(strlen($POST['subject']) <1 ) $POST['subject'] = dgmdate($POST['public_time'], 'Y-m-d');
		
		$POST['friend'] = intval($POST['friend']);
	
		$POST['target_ids'] = '';
	
		if($POST['friend'] !== 2) {
			$POST['target_ids'] = '';
		}
		if($POST['friend'] !== 4) {
			$POST['password'] == '';
		}
	
		$POST['tag'] = dhtmlspecialchars(trim($this->cache['article_info']['article_tag']));
		$POST['tag'] = getstr($POST['tag'], 500, 0, 0);
		$POST['tag'] = censor($POST['tag']);
		
	
		$POST['message'] = getstr($POST['message'], 0, 0, 0, 0, 1);
		$message = $POST['message'];
		$blog_status = 0;
		
		if($this->cache['article_info']['blog_id']){
			$info = DB::fetch_first("SELECT blogid FROM ".DB::table('home_blog')." WHERE blogid='".$this->cache['article_info']['blog_id']."'");
		}
		
		
		if(empty($olds['classid']) || $POST['classid'] != $olds['classid']) {
			if(!empty($POST['classid']) && substr($POST['classid'], 0, 4) == 'new:') {
				$classname = dhtmlspecialchars(trim(substr($POST['classid'], 4)));
				$classname = getstr($classname, 0, 1, 1);
				$classname = censor($classname);
				if(empty($classname)) {
					$classid = 0;
				} else {
					$classid = DB::result(DB::query("SELECT classid FROM ".DB::table('home_class')." WHERE uid='$_G[uid]' AND classname='$classname'"));
					if(empty($classid)) {
						$setarr = array(
							'classname' => $classname,
							'uid' => $uid,
							'dateline' => $POST['public_time']
						);
						$classid = DB::insert('home_class', $setarr, 1);
					}
				}
			} else {
				$classid = intval($POST['classid']);
	
			}
		} else {
			$classid = $olds['classid'];
		}
		if($classid && empty($classname)) {
			$classname = DB::result(DB::query("SELECT classname FROM ".DB::table('home_class')." WHERE classid='$classid' AND uid='$uid'"));
			if(empty($classname)) $classid = 0;
		}

		$blogarr = array(
			'subject' => $POST['subject'],
			'classid' => $classid,
			'viewnum' => $this->cache['article_info']['view_num'],
			'friend' => $POST['friend'],
			'password' => $POST['password'],
			'noreply' => empty($POST['noreply'])?0:1,
			'catid' => intval($POST['catid']),
			'status' => $blog_status,
		);
	
		$titlepic = '';
		$ckmessage = preg_replace("/(\<div\>|\<\/div\>|\s|\&nbsp\;|\<br\>|\<p\>|\<\/p\>)+/is", '', $message);
		if(empty($ckmessage)) {
			return false;
		}
	
	
		if(checkperm('manageblog')) {
			$blogarr['hot'] = intval($POST['hot']);
		}
	
		if($POST['catid']) {
			DB::query("UPDATE ".DB::table('home_blog_category')." SET num=num+1 WHERE catid='".$POST['catid']."'");
		}
		
		$blogarr['uid'] = $uid;
		$blogarr['username'] = $username;
		$blogarr['dateline'] = empty($POST['public_time']) ? $_G['timestamp'] : $POST['public_time'];
		if($info['blogid']){
			DB::update('home_blog', paddslashes($blogarr), array('blogid' => $info['blogid']));
			$blogid = $info['blogid'];
		}else{
			$blogid = DB::insert('home_blog', paddslashes($blogarr), 1);
		}
		
		
	
		DB::update('common_member_status', array('lastpost' => $POST['public_time']), array('uid' => $uid));
		DB::update('common_member_field_home', array('recentnote'=> paddslashes($POST['subject'])), array('uid'=>$uid));
	
		$blogarr['blogid'] = $blogid;
		if(function_exists('modblogtag')){
			$POST['tag'] = $olds ? modblogtag($POST['tag'], $blogid) : addblogtag($POST['tag'], $blogid);
		}else{
			$class_tag = new tag();
			$POST['tag'] = $olds ? $class_tag->update_field($POST['tag'], $blogid, 'blogid') : $class_tag->add_tag($POST['tag'], $blogid, 'blogid');
		}
	
		$fieldarr = array(
			'message' => paddslashes($message),
			'postip' => $_G['clientip'],
			'target_ids' => $POST['target_ids'],
			'tag' => $POST['tag']
		);
	
		if(!empty($titlepic)) {
			$fieldarr['pic'] = $titlepic;
		}
		
		$fieldarr['blogid'] = $blogid;
		$fieldarr['uid'] = $blogarr['uid'];
		if($info['blogid']){
			DB::update('home_blogfield', $fieldarr, array('blogid' => $info['blogid']));
		}else{
			DB::query("UPDATE ".DB::table('common_member_count')." SET blogs=blogs+1 WHERE uid='$fieldarr[uid]'");//更新数
			DB::insert('home_blogfield', $fieldarr);
		}
		
	
		if($isself && !$olds && $blog_status == 0) {
			updatecreditbyaction('publishblog', 0, array('blogs' => 1));
	
			include_once libfile('function/stat');
			updatestat('blog');
		}
	
		if($POST['makefeed'] && $blog_status == 0) {
			include_once libfile('function/feed');
			feed_publish($blogid, 'blogid', $olds?0:1);
		}
	
		if($blog_status == 1) {
			updatemoderate('blogid', $blogid);
			manage_addnotify('verifyblog');
		}
		
		//发布动态
		require_once libfile('function/feed');
		feed_publish($blogid, 'blogid');
		
		
		$this->cache['common']['public_uid'] = $uid;
		$this->cache['common']['public_username'] = $username;
		$this->cache['common']['public_time'] = $POST['public_time'];
		$this->cache['common']['catid'] = $POST['catid'];
		$this->cache['common']['classid'] = $classid;
		$this->cache['common']['aid'] = $blogid;
		
		$this->cache['finsh']['insert_id'] = $blogid;
		$this->cache['finsh']['uid'] = $uid;
		$this->artilce_attach_content($POST['message']);
		
			
	}
	
	//日志
	function write_log(){
		if($this->cache['run_type'] != 'auto_timing' || $this->pick_set['is_log_cron'] != 1) return;//只有文章定时发布才有可能需要写入日志
		pload('F:pick');
		pick_log(milu_lang('article_public_success_log', array('t' => $this->cache['article_info']['title'], 'aid' => $this->cache['article_info']['aid'], 'id' =>  $this->cache['finsh']['insert_id'])), array('log_type' => 'timing', 'pid' => $this->cache['p_arr']['pid']));
	}
	
	//更新状态
	function public_finsh(){
		global $_G;
		$setarr = array();
		$type_arr = array('move_portal' => 'portal_id', 'move_blog' => 'blog_id', 'move_forums' => 'forum_id');
		$setarr['status'] = $this->cache['finsh']['status'] ? $this->cache['finsh']['status'] : 2;
		$type_name = $type_arr[$this->cache['optype']];
		if(!$type_name) return;
		$setarr[$type_name] = $this->cache['finsh']['insert_id'];
		if($this->cache['finsh']['uid']) $setarr['uid'] = $this->cache['finsh']['uid'];//发布到博客需要这个uid才能访问
		$this->write_log();//写入日志
		if(!VIP){
			$c_set['pick_today']['day'] = date('md', $_G['timestamp']);
			$today_public_num = 1;
			$c_set['pick_today']['article_public_num'] = $today_public_num + $this->pick_set['pick_today']['article_public_num'];
			pick_common_set($c_set);
			
		}
		article_attach_delete_by_aid($this->cache['article_info']['aid'], $this->cache['p_arr']['pid']);//删除文章附件文件
		$del_flag = 1;
		//如果触发的方式是定时采集，而且是回复类型的。那么不删除文章
		if(($this->cache['run_type'] == 'timing' || $this->cache['run_type'] == 'auto_timing') && $this->cache['article_info']['is_bbs'] == 1) $del_flag = 0;
		if($this->cache['article_info']['is_bbs'] == 1 && count($this->cache['article_info']['content_arr']) > 0 && $this->pick_set['is_timing'] == 1){//如果开启了定时发布，而且是论坛类型的，而且有回复，不能开启发布之后删除
			 $del_flag = 0;
		} 
		if($this->cache['p_arr']['is_public_del'] == 1 && $del_flag == 1) {
			article_delete($this->cache['article_info']['aid'], $this->cache['p_arr']['pid']);//导入之后删除
		}else{
			if(!$this->cache['finsh']['insert_id']) return;
			$article_info = DB::fetch_first("SELECT status FROM ".DB::table('strayer_article_title')." WHERE aid='".$this->cache['article_info']['aid']."'");
			if($this->cache['article_info']['status'] != 2) DB::query('UPDATE  '.DB::table('strayer_picker')." SET article_import_num=article_import_num+1 WHERE pid= '".$this->cache['p_arr']['pid']."'");
			DB::update('strayer_article_title', $setarr, array('aid' => $this->cache['article_info']['aid']));
		}
	
	}
	// attach_img_info,uid,tid,pid
	function attach_add($args, $is_post = 0){
		extract($args);
		global $_G;
		require_once libfile('class/image');
		$img_content = $attach_img_info['content'];
		pload_upload_class();
		$upload = new discuz_upload();
		if(strlen($attach_img_info['content']) == 0) return;
		$public_time = $this->cache['common']['public_time'];
		$attach['name'] = $attach_img_info['file_name'];
		$attach['ext'] = trim($attach_img_info['file_ext']);
		$attach['thumb'] = '';
		$attach['isimage'] = $upload -> is_image_ext($attach['ext']);
		$attach['extension'] = $upload -> get_target_extension($attach['ext']);
		$attach['attachdir'] = $upload -> get_target_dir('forum');
		$attach['attachment'] = $attach['attachdir'] . $upload->get_target_filename('forum').'.'.$attach['extension'];
		$attach['target'] = getglobal('setting/attachdir').'./forum/'.$attach['attachment'];
		if(!@$fp = fopen($attach['target'], 'wb')) {
			return;
		} else {
			flock($fp, 2);
			fwrite($fp, $img_content);
			fclose($fp);
		}
		if(!$upload->get_image_info($attach['target']) && $attach['isimage'] == 1) {
			@unlink($attach['target']);
			return;
		}
		$attach['size'] = filesize($attach['target']);
		$upload->attach = $attach;
		$thumb = $width = 0;
		if($upload->attach['isimage']) {
			if($_G['setting']['thumbstatus']) {
				$image = new image();
				$thumb = $image->Thumb($upload->attach['target'], '', $_G['setting']['thumbwidth'], $_G['setting']['thumbheight'], $_G['setting']['thumbstatus'], $_G['setting']['thumbsource']) ? 1 : 0;
				$width = $image->imginfo['width'];
			}
			if($_G['setting']['thumbsource'] || !$_G['setting']['thumbstatus']) {
				list($width) = @getimagesize($upload->attach['target']);
			}
			if(($_G['setting']['watermarkstatus'] && empty($_G['forum']['disablewatermark'])) && $this->cache['p_arr']['is_water_img'] == 1) {
				$image = new image();
				$image->Watermark($attach['target'], '', 'forum');
			}
		}
		
		$remote = 0;
		$picid = 0;
		$setarr = array(
			'uid' => $uid,
			'tid' => $tid,
			'pid' => $pid,
			'filename' => daddslashes($upload->attach['name']),
			'attachment' => $upload->attach['attachment'],

			'filesize' => $upload->attach['size'],
			'thumb' => $thumb,
			'remote' => $remote,
			'picid' => $picid,
			'isimage' => $attach['isimage'],
			'description' => $attach_img_info['description'] ? $attach_img_info['description'] : $this->cache['article_info']['title'],
			'readperm' => 0,
			'price' => 0,
			'width' => $width,
			'dateline' => $public_time,
		);
		$setimg_arr = array(
			'tid' => $tid,
			'attachment' => $upload->attach['attachment'],
			'remote' => $remote,
		); 
		$set_att = array(
			'downloads' => rand(1,15),
			'tableid' => getattachtableid($tid),
			'uid' => $uid,
			'tid' => $tid,
			'pid' => $pid,
		);	
		
		$setarr['aid'] = $newaids[] = DB::insert('forum_attachment', $set_att, true);
		$at[] = $setarr['aid'];

		
		$attachnew_arr[$setarr['aid']] = array('description' => $setarr['description']);
		DB::insert(getattachtablebytid($tid), paddslashes($setarr), true);
		return array('aid' => $setarr['aid'], 'url' => $_G['setting']['attachurl'].'forum/'.$attach['attachment'], 'tableid' => $set_att['tableid'], 'attachment' => $attach['attachment']);
	}
	
	function show_error(){
		
	}
	
	function cpmsg($msg, $url, $type = 'loading'){
		$this->cache_data();
		if(in_array($this->cache['run_type'], $this->cache['no_msg_action_arr'])) return pick_article_import(array('run_type' => $this->cache['run_type']));//这里必须传入run_type参数
		cpmsg($msg, $url, $type, '', false);
	}
	
	function cache_data(){
		$cache_key = $this->cache['run_type'] == 'article_edit' ? 'normal' : $this->cache['run_type']; 
		pcache_data('article_public_run_'.$cache_key, $this->cache);
	}
	
	function redir($url = ''){
		$this->cache_data();
		if(in_array($this->cache['run_type'], $this->cache['no_msg_action_arr'])) return;//
		data_go('picker_manage&myac=article_public_start&tpl=no');
	}
}
?>
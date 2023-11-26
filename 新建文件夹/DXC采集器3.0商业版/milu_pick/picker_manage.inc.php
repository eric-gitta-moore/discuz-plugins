<?php
if(!defined('IN_DISCUZ') ) {
	exit('Access Denied');
}
require_once(DISCUZ_ROOT.'source/plugin/milu_pick/config.inc.php');
pload('F:pick,F:copyright,F:output,F:article');
$header_config = array('pick_list', 'pick_import', 'pick_online');
$head_url = '?'.PICK_GO.'picker_manage&myac=';
$myaction = $_GET['myaction'];
$myac = $_GET['myac'] ? $_GET['myac'] : $_GET['myfunc'];
$submit = $_GET['submit'];
$pid =  $_GET['pid'];
$aid = $_GET['aid'];
$optype = $_GET['optype'];
clear_pick_cache();//缓存定期清理
clear_search_index();//清除索引
clear_log();//清除日志
if($myac && $myac != 'pick_list'){
	$tpl = $_GET['tpl'];
	if(function_exists($myac)) $info = $myac();
	$mytemp = $_REQUEST['mytemp'] ? $_REQUEST['mytemp'] : $myac;
	if(!$tpl && $tpl!= 'no') include template('milu_pick:'.$mytemp);
	exit();
}
switch($myaction){
	case '':
		
		$cat_arr = pick_category_list();
		foreach($cat_arr as $k_c => $v_c){
			$query = DB::query("SELECT * FROM ".DB::table('strayer_picker')." WHERE pick_cid='$v_c[cid]' ORDER BY displayorder ASC,pid DESC");
			while($rs = DB::fetch($query)) {
				$rs['article_count'] = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_article_title')." WHERE pid =".$rs['pid'].""), 0);
				$rs['url_count'] = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_url')." WHERE pid =".$rs['pid']." "), 0);
				$rs['no_import_count'] =  DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_article_title')." WHERE pid =".$rs['pid']." AND status=0"), 0);
				$rs['is_cron_show'] = $rs['is_auto_pick'] > 0 ? milu_lang('can_use') : '';
				$rs['lastrun_show'] = $rs['lastrun'] ? dgmdate($rs['lastrun']) : '';
				$rs['nextrun_show'] = $rs['nextrun'] ? dgmdate($rs['nextrun']): '';
				$data[$v_c['cid']][] = $rs;
			}
		}
		$info['header'] = pick_header_output($header_config, $head_url);
		$info['is_lan'] = check_env(2, 0) ? 'no' : 'yes';
		if($_GET['submit']){
			$pid_arr = $_GET['pid'];
			$pick_op = $_GET['pick_op'];
			$move_cid = $_GET['move_cid'];
			if($pick_op == 'del' || $pick_op == 'move'){
				foreach((array)$pid_arr as $k => $pid){
					if($pick_op == 'del'){
						del_picker($pid);
					}else if($pick_op == 'move'){
						move_picker($pid, $move_cid);
					}
				}
			
			}else{
				$cate_setarr = $_GET['cate_setarr'];
				$newname_arr = $_GET['newname'][0];
				$neworder_arr = $_GET['neworder'][0];
				$pick_setarr = $_GET['pick_setarr'];
				foreach((array)$pick_setarr as $k => $v){
					DB::update('strayer_picker', array('displayorder' => $v['displayorder']), array('pid' => $k));
				}
				foreach((array)$cate_setarr as $k => $v){
					DB::update('strayer_category', $v, array('cid' => $k));
				}
				foreach((array)$neworder_arr as $k => $v){
					DB::insert('strayer_category', array('name' => $newname_arr[$k], 'displayorder' => $v), TRUE);
				}
			}
			cpmsg(milu_lang('op_success'), PICK_GO."picker_manage", 'succeed');
		}
		$info['tips'] = version_check();
		include template('milu_pick:picker_list');
	break;
	case 'edit_pick':
		include_once libfile('function/portalcp');
		require_once libfile('function/forumlist');
		pload('F:rules');
		$info = get_pick_info();
		//2.5版本
		$step = $_GET['step'];
		if(!$step) $step = 1;
		$info = show_pick_format($info);
		if(!$info['manyou_max_level']) $info['manyou_max_level'] = 2;
		$show_rules = show_rules(1,1);
		$forumselect = '<select name="forums" onchange="getthreadtypes(this.value, 0)">'.forumselect(FALSE, 0, $info['public_class'][0], TRUE).'</select>';
		$threadtypes = getthreadtypes(array('typeid' => $info['public_class'][1], 'fid' => $info['public_class'][0]) );
		$portalselect = category_showselect('portal', 'portal', false, $info['public_class'][0]);
		$blogselect = category_showselect('blog', 'blog', TRUE, $info['public_class'][0]);
		$show_bottom_js = bottom_js_output($info);
		include template('milu_pick:picker_edit');
	break;
	case 'pick_del_category'://删除采集器分类
		if(!submitcheck('deletesubmit')) {
			$cid = intval($_GET['cid']);
		}else{
			$cid = intval($_GET['cid']);
			$to_cid = intval($_GET['to_cid']);
			$category_op = $_GET['category_op'];
			$picker_list = category_picker($cid, 'pid');
			if($category_op == 'move'){
				if($cid == $to_cid) cpmsg_error(milu_lang('picker_del_firm'));
				if($picker_list) {
					foreach($picker_list as $v){
						$pid_arr[] = $v['pid'];
					}
					DB::query('UPDATE '.DB::table('strayer_picker')." SET pick_cid='$to_cid' WHERE pid IN (".dimplode($pid_arr).")");
				}
			}else if($category_op == 'delete'){
				if($picker_list) {
					foreach($picker_list as $v){
						del_picker($v['pid']);
					}
				}
			}
			DB::query('DELETE FROM '.DB::table('strayer_category')." WHERE cid= '$cid'");
			cpmsg(milu_lang('op_success'), PICK_GO."picker_manage", 'succeed');
		}
		$info['header'] = pick_header_output($header_config, $head_url);
		include template('milu_pick:picker_category_del');
	break;
	case 'pick_stop':
	$pid = intval($pid);
	
	$url = PICK_GO.'picker_manage';
	cpmsg(milu_lang('op_success'), $url, 'succeed');
	break;
	case 'get_article':
		$info = get_pick_info();
		$pid = $info['pid'];
		if($_GET['clear'] || $_GET['submit'] == 2) cache_del('pick'.$pid);
		$info['save_data'] =  load_cache('pick'.$pid);
		$info['no_check_url'] = intval($_GET['no_check_url']);
		$info['header'] = pick_header_output($header_config, $head_url);
		include template('milu_pick:get_article');
	break;

	
	case 'pick_empty':	
		if($pid && $submit){
			save_syscache('pick_run', TIMESTAMP );
			article_batch_del($pid);
			DB::query('DELETE FROM '.DB::table('strayer_url')." WHERE pid='$pid'");
			$setarr = array('run_times' => 0, 'lastrun' => 0, 'nextrun' => 0);
			DB::update('strayer_picker', $setarr, array('pid' => $pid));
			del_pick_log($pid);
			cpmsg(milu_lang('empty_finsh'), PICK_GO."picker_manage", 'succeed');
		}else{
			cpmsg(milu_lang('empty_pick_confirm'), PICK_GO.'picker_manage&myaction=pick_empty&pid='.$pid.'&submit=1', 'form');
		}	
	break;
	
	case 'pick_del':
		if($pid && $submit){
			del_picker($pid);
			cpmsg(milu_lang('del_finsh'), PICK_GO."picker_manage", 'succeed');
		}else{
			cpmsg(milu_lang('pick_del_confirm'), PICK_GO.'picker_manage&myaction=pick_del&pid='.$pid.'&submit=1', 'form');
		}	
	break;
	
	case 'export':
		$info['pick'] = get_pick_info();
		if($info['pick']['rules_hash']){
			pload('F:rules');
			$info['rules'] = get_rules_info($info['pick']['rules_hash']);
		}
		$is_hava = $info['rules'] ? milu_lang('hava_system_rules') : milu_lang('no_hava_system_rules');
		$args = array(
			'type' => milu_lang('dxc_rules'),
			'author' => $_G['setting']['bbname'],
			'rules_name' => $info['pick']['name'],
			'rule_desc' => $is_hava,
		);
		$info['version'] = PICK_VERSION;
		exportfile($info, $info['pick']['name'], $args);
	break;
	
	
	case 'show_article_info':
		$arr['title'] = format_url($_GET['title']);
		$arr['content'] = format_url($_GET['content']);
		$arr['article_get_type'] = $_GET['article_get_type'];
		$arr['url_page_range'] = $_GET['url_page_range'];
		$arr['page_link_rules'] = format_url($_GET['page_link_rules']);
		$url_range_type = $_GET['url_range_type'];
		$page_test_url = $_GET['page_test_url'];
		$arr['url'] = $_GET['url'];
		$arr['auto'] = $_GET['auto'];
		$page_get_type = $_GET['page_get_type'];
		$range_arr = get_url_range($arr['url_page_range']);
		if($page_test_url){
			$link_arr[0] = $page_test_url;
		}else{
			if($url_range_type == 'page'){
				if($page_get_type == 'dom'){
					$link_arr = dom_page_link($range_arr[0], $arr);
				}else{
					$link_arr = regexp_page_link($range_arr[0], $arr['page_link_rules']);
				}
			}else{
				$auto = $auto == 'yes' ? true : false;
				$link_arr = get_url_range($arr['url_page_range'], $auto);
			}
		}	
		$url = url_auto($link_arr[0]);
		if($arr['url']) $url = $arr['url'];
		if($arr['article_get_type'] == 'dom'){
			$a_info  =  dom_single_article($url, array('title' => $arr['title'], 'content' => $arr['content']));
		}else if($arr['article_get_type'] == 'regexp'){
			$a_info  =  regexp_single_article($url, array('title' => $arr['title'], 'content' => $arr['content']));
		}else{
			$a_info = get_single_article($url);
		}
		if($a_info['content'] || $a_info['title']){
			if($a_info['content'] == 'list') $a_info['content']= milu_lang('article_too_many_link');
			$html = '<h3><strong>'.milu_lang('article_link').':</strong></h3><a target="_blank"  href="'.$url.'">'.$url.'</a><br><br><h3><strong>'.milu_lang('article_title').':</strong></h3>'.$a_info['title'].'<br><br><h3><strong>'.milu_lang('article_body').':</strong><br></h3>'.$a_info['content'].'<br>';
		}else{
			$html = milu_lang('no_get_content');
		}
		show_pick_window(milu_lang('get_content_test'), $html, array('w' => 750,'h' => '460','f' => 1));
	case 'article_delete':	
		$aid = intval($_GET['aid']);
		$url_str = '&pid='.$_GET['pid'].'&status='.$_GET['status'].'&p='.$_GET['p'].'&s='.$_GET['s'].'&orderby='.$_GET['orderby'].'&ordersc='.$_GET['ordersc'].'&perpage='.$perpage.'&page='.$page;
		if($aid && $submit){
			article_delete(array($aid));
			cpmsg(milu_lang('del_finsh'), PICK_GO."picker_manage&myac=article_manage".$url_str, 'succeed');
		}else{
			cpmsg(milu_lang('del_confirm'), PICK_GO.'picker_manage&myaction=article_delete&aid='.$aid.'&submit=1'.$url_str, 'form');
		}	
	break;
}





function article_manage(){
	global $head_url,$header_config;
	$data = article_get_args();
	$info = $data['info'];
	$args = $data['args'];
	$data = get_pick_info();
	$info['public_class'] = unserialize($data['public_class']);
	$info['status'] = $args['status'] ? $args['status'] : intval($_GET['status']);
	$info['pid'] = $_GET['pid'] ? intval($_GET['pid']) : $args['pid'];
	
	//if(!VIP) unset($info['status_arr'][4]);
	
	foreach($info['status_arr'] as $k => $v){
		$info['a_c'][$k] = article_count($info['pid'], $k);
	}
	$info['oparea'] = $_GET['oparea'];
	$info['optype'] = $_GET['optype'];
	$args['pid'] = $info['pid'];
	
	$article_data = article_list($args);
	$info['pick'] =  $data = get_pick_info();
	if($info['optype'] == 'move_portal'){
		$info['public_class'][0] = $_GET['portal'];
	}else if($info['optype'] == 'move_forums'){
		$info['public_class'][0] = $_GET['forums'];
		$info['public_class'][1] = $_GET['threadtypeid'];
	}else if($info['optype'] == 'move_blog'){
		$info['public_class'][0] = $_GET['blog'];
	}
	
	if($_GET['time_public'] == 1) $info['pick']['public_start_time'] = $info['pick']['public_end_time'] = '';
	$info['p'] = $_GET['p'];//判断是不是从采集器列表进来
	$info['pick']['public_start_time'] = $_GET['public_start_time'] ? $_GET['public_start_time'] : $info['pick']['public_start_time'] ;
	$info['pick']['public_end_time'] = $_GET['public_end_time'] ? $_GET['public_end_time'] : $info['pick']['public_end_time'];
	
	$info['pick']['public_sort'] = $info['pick']['public_sort'] ? $info['pick']['public_sort'] : $_GET['public_sort'];

	$info['pick']['public_start_time'] = dgmdate($info['pick']['public_start_time']);
	$info['pick']['public_end_time'] = dgmdate($info['pick']['public_end_time']);
	$info['pick_select'] = pick_search_select('set[pid]', intval($info['pid']));
	$info['article_move_pick_select'] = pick_search_select('move_pid', intval($_GET['move_pid']), $_GET['pid']);
	$info['rs'] = $article_data['rs'];
	$info['multipage'] = $article_data['multipage'];
	$info['count'] = $article_data['count'];
	if(!$info['p'])$info['header'] = pick_header_output($header_config, $head_url);
	$info['threadtypes'] = getthreadtypes(array('typeid' => $info['public_class'][1], 'fid' => $info['public_class'][0]) );
	$info['forumselect'] = '<select id="forums" name="forums" onchange="getthreadtypes(this.value, 0)">'.forumselect(FALSE, 0, $info['public_class'][0], TRUE).'</select>';
	$info['forumselect_public'] = '<select id="public_forums" name="public_forums" >'.forumselect(FALSE, 0, $info['public_class'][0], TRUE).'</select>';
	$info['portalselect'] = category_showselect('portal', 'portal', FALSE, $info['public_class'][0]);
	$info['blogselect'] = category_showselect('blog', 'blog', TRUE, $info['public_class'][0]);
	$info['public_portalselect'] = category_showselect('portal', 'public_portal', FALSE, $info['public_class'][0]);
	$info['public_blogselect'] = category_showselect('blog', 'public_blog', TRUE, $info['public_class'][0]);
	$url_args = '';
	unset($args['mpurl']);
	foreach((array)$args as $k => $v){
		if($k == 'perpage' || $k == 'pid') continue;
		$url_args .= '&'.$k.'='.$v;
	}
	$info['url_args'] = urlencode($url_args);
	return $info;
}


function article_get_args(){
	global $head_url,$header_config,$_G;
	include_once libfile('function/portalcp');
	require_once libfile('function/forumlist');

	$article_status = $_G['cache']['evn_milu_pick']['article_status'];
	$status = $_GET['status'] ? $_GET['status'] : 0;
	$info['orderby_arr'] = array(
		'default' => milu_lang('default_sort'),
		'dateline' => milu_lang('add_dateline'),
		'pic' => milu_lang('pic_num'),
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
	$info['status_arr'] = $article_status;
	
	$args = $_GET['set'];
	$args['s'] = $args['s'] ? $args['s'] : $_GET['s'];
	$args['status'] = $args['status'] ? $args['status'] : $_GET['status'];
	$args['orderby'] = $args['orderby'] ? $args['orderby'] : $_GET['orderby'];
	$args['orderby'] = $args['orderby'] ? $args['orderby'] : 'default';
	$args['ordersc'] = $args['ordersc'] ? $args['ordersc'] : $_GET['ordersc'];
	$args['ordersc'] = $args['ordersc'] ? $args['ordersc'] : 'desc';
	$args['perpage'] = $args['perpage'] ? $args['perpage'] : $_GET['perpage'];
	$args['perpage'] = $args['perpage'] ? $args['perpage'] : '25';
	$args['pid'] = $_GET['set']['pid'] ? intval($_GET['set']['pid']) : 0;
	$info = array_merge($args, $info);
	$url_args = '';
	foreach((array)$args as $k => $v){
		if($k == 'perpage' || $k == 'pid') continue;
		$url_args .= '&'.$k.'='.$v;
	}
	$config = pick_common_get();
	$info['article_batch_num'] = $config['article_batch_num'] ? $config['article_batch_num'] : 15;
	$args['page'] = $_GET['page'] ? intval($_GET['page']) : 1;
	$args['mpurl'] = $head_url.$_GET['myac'].$url_args;
	$data['args'] = $args;
	$data['info'] = $info;
	
	return $data;
}


function article_batch(){
	global $_G;
	$aid_arr = $_GET['aid'];
	$is_public_del = $_GET['is_public_del'];
	if(!VIP){
		$today_arr = dunserialize(pick_common_get('', 'pick_today'));
		if($today_arr['day'] != date('md', $_G['timestamp'])){
			$c_set['pick_today'] = array();
			pick_common_set($c_set);
		}else{
			$article_public_num = $today_arr['article_public_num'];
			if($article_public_num > 10000) cpmsg_error(milu_lang('article_public_limit', array('n' => 10000)));
		}
	}
	extract($_GET);
	extract($set);
	$public_start_time = strtotime($public_start_time);
	$public_end_time = strtotime($public_end_time);
	$args_arr =  array('optype', 'pid', 'is_public_del', 'article_public_sort', 'is_public_del', 'public_start_time', 'public_end_time','status', 's', 'ordersc', 'orderby', 'time_public', 'portal', 'forums', 'threadtypeid', 'blog', 'perpage', 'oparea', 'article_batch_num', 'move_pid','p');
	$args_url = '';
	foreach($args_arr as $k => $v){
		$args_url .= '&'.$v.'='.$$v;
	}
	//$args_url .= '&myac='
	//echo $args_url;exit();
	$from_url = PICK_GO."picker_manage&myac=article_manage&finished=1".$args_url;
	if($_GET['finished']) {
		cpmsg(milu_lang('run_finsh'), $from_url, 'succeed');
	}
	if(!$_GET['confirmed']){
		$article_batch_num = $setrr['article_batch_num'] = $article_batch_num ? $article_batch_num : 15;
		pick_common_set($setrr);
		if(!$optype)  cpmsg_error(milu_lang('must_select_optype'));
		if($oparea == 'selected'){
			if(!$aid_arr)  cpmsg_error(milu_lang('must_select_data'));
			$aid_str = base64_encode(serialize($aid_arr));
			$total = count($aid_arr);	
		}else if($oparea == 'all'){
			$total = article_count($pid, $status, array('s' => $s));
		}
		pcpmsg_loading(milu_lang('bat_import_article', array('a' => $article_batch_num,'t' => $total)), $from_url, 'loadingform', '', '<div id="percent">0%</div>', FALSE);
		$ajax_url = "admin.php?".PICK_GO."picker_manage&myac=ajax_func&inajax=1&af=".$myac."&tpl=no&confirmed=1&oparea=$oparea&aid=$aid_str".$args_url;
		$finsh_url = "admin.php?".PICK_GO."picker_manage&myac=article_manage&finished=1".$args_url;
		//echo $ajax_url;exit();
		echo pick_loading($ajax_url, $finsh_url, $total, array('bat_num' => $article_batch_num));
	}else{
		ob_end_clean();
	
		$total = intval($_GET['total']);
		$pp = intval($_GET['pp']);
		$pid = intval($_GET['pid']);
		$currow = intval($_GET['currow']);
		$oparea = $_GET['oparea'];
		$public_sort = $_GET['public_sort'];
		$public_sort = $public_sort == 1 ? 'asc' : 'desc';
		if($oparea == 'selected'){
			$aid_arr = unserialize(base64_decode($aid));
			$where = $optype == 'timing_delete' ? " AND t.id IN (".dimplode($aid_arr).") " : " AND aid IN (".dimplode($aid_arr).") ";
		}else if($oparea == 'all'){ 
			$where =  $optype == 'timing_delete' ? " AND  a.title like '%".$_GET['s']."%' " : " AND title like '%".$_GET['s']."%' ";
		}
		$aid_arr = array();
		if(($is_public_del == 1 && ($optype == 'move_portal' || $optype == 'move_forums' || $optype == 'move_blog')) || $optype == 'delete') $currow = 0;
		if($optype == 'timing_delete'){
			$query = DB::query("SELECT a.aid,t.id, t.data_id FROM ".DB::table('strayer_timing')." t Inner Join ".DB::table('strayer_article_title')." a ON a.aid = t.data_id WHERE t.pid='$pid' $where ORDER by t.data_id LIMIT $currow,$pp");
			while($rs = DB::fetch($query)) {
				if($rs['aid']) DB::update('strayer_article_title', array('status' => 1), array('aid' => $rs['aid']));
				$aid_arr[] = $rs['id'];
			}
			
			
		}else{
			$query = DB::query("SELECT aid FROM ".DB::table('strayer_article_title')." WHERE pid='$pid' $where ORDER by dateline ".$public_sort." LIMIT $currow,$pp");
			while($rs = DB::fetch($query)) {
				$aid_arr[] = $rs['aid'];
			}
		}

		if($optype == 'move_portal' || $optype == 'move_forums' || $optype == 'move_blog'){
			article_import($_GET['optype'], array('aid' => $aid_arr));
			
		}else{
			$action = 'article_'.$optype;
			$action($aid_arr, $pid);
		}
		
		if($currow + $pp > $total) {
			echo 'TRUE';
			exit();
		}

		echo 'GO';
		exit();
	}
}

function article_move_trash($aid_arr, $pid){
	$sql = $pid ? " pid='$pid' AND " : '';
	DB::query("UPDATE ".DB::table('strayer_article_title')." SET status='3' WHERE  $sql aid IN (".dimplode($aid_arr).") ");
}

function article_recover($aid_arr, $pid){
	$sql = $pid ? " pid='$pid' AND " : '';
	$query = DB::query("SELECT aid,forum_id,blog_id,portal_id FROM ".DB::table('strayer_article_title')." WHERE $sql aid IN (".dimplode($aid_arr).") ");
	while($rs = DB::fetch($query)) {
		if($rs['forum_id'] || $rs['portal_id'] || $rs['blog_id']){
			$imported_arr[] = $rs['aid'];
		}else{
			$no_import_arr[] = $rs['aid'];
		}
	}
	if($imported_arr) DB::query("UPDATE ".DB::table('strayer_article_title')." SET status='2' WHERE $sql aid IN (".dimplode($imported_arr).") ");
	if($no_import_arr) DB::query("UPDATE ".DB::table('strayer_article_title')." SET status='1' WHERE $sql aid IN (".dimplode($no_import_arr).") ");
	
}

function article_move_picker($aid_arr, $pid){
	$move_pid = intval($_GET['move_pid']);
	$sql = $pid ? " pid='$pid' AND " : '';
	DB::query("UPDATE ".DB::table('strayer_article_title')." SET pid='$move_pid' WHERE $sql aid IN (".dimplode($aid_arr).") ");
}



function article_data_count(){
	global $head_url,$header_config,$_G;
	$info['header'] = pick_header_output($header_config, $head_url);
	return $info;
	
}

function show_article_detail(){
	$aid = intval($_GET['aid']);
	$ar_info = article_info($aid);
	//print_r($ar_info);exit();
	if(!$ar_info['content']) $ar_info['content']= milu_lang('article_content_empty');
	if($ar_info['is_bbs'] == 1){
		$output = $ar_info['content'];
		$output .= show_reply_output($ar_info['reply']);
	}else{
		if($ar_info['contents'] == 1){//普通没分页文章
			$output = $ar_info['content'];
		}else{
			$output = show_page_output($ar_info['content_arr']);
		}
	}
	show_pick_window(dhtmlspecialchars($ar_info['title']), $output, array('w' => 645,'h' => '460','f' => 1));
}



function show_pick_class(){
	return select_output(pick_category_list(TRUE), '', 'move_cid', '', 1);
}
?>
<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
function article_list($arr){
	global $_G;
	include_once libfile('function/portalcp');
	if(!$arr) return;
	
	$status = $arr['status'] ? $arr['status'] : intval($_GET['status']);
	$pid = $arr['pid'] ? $arr['pid'] : intval($_GET['pid']);
	$perpage = $arr['perpage'] ? $arr['perpage'] : 45;
	if($pid){
		if($status == 4){
			$json_sql = "Inner Join ".DB::table('strayer_timing')." AS t ON a.aid = t.data_id Inner Join ".DB::table('strayer_picker')." AS p ON t.pid = p.pid WHERE t.pid='$pid' ";
			$p_field = ',t.*,p.name';
		}else{
			$json_sql = "Inner Join ".DB::table('strayer_picker')." AS p ON p.pid = a.pid WHERE a.pid='$pid' ";
			$p_field = ',p.pid,p.pick_cid,p.name';
		}
	}else{
		$json_sql = '';
		$s_sql .= ' WHERE  1=1 ';
	}
	
	if($status == 0) {
		$s_sql .= 'AND a.status < 3';
	}else if($status == 1){
		$s_sql .= 'AND a.status < 2';
	}else if($status !=4){
		$s_sql .= " AND a.status=".$status;
	}
	
	if($arr['s']){
		$s_sql .= " AND a.title like '%".$arr['s']."%' ";
	}
	$arr['orderby'] = ($arr['orderby'] != 'default' && $arr['orderby']) ? $arr['orderby'] : 'aid';
	$order_sql = ' ORDER BY a.'.$arr['orderby'].' '.$arr['ordersc'];
	
	$page = $_GET['page'] ? intval($_GET['page']) : 1;
	
	$start = ($page-1)*$perpage;
	$perpages = array($perpage => ' selected');
	$mpurl = $arr['mpurl'] ? $arr['mpurl'].'&pid='.$pid : '?'.PICK_GO.'picker_manage&myaction=article_manage&pid='.$pid.'&status='.$status;
	$mpurl .= '&p='.$_GET['p'].'&perpage='.$perpage;
	$count = article_count($pid,$arr['status'], $arr);
	if($count) {
		$query = DB::query("SELECT a.*".$p_field." FROM ".DB::table('strayer_article_title')." AS a ".$json_sql.$s_sql.$order_sql." LIMIT $start,$perpage ");	
		while(($v = DB::fetch($query))) {
			$v['full_title'] = $v['title'];
			$v['title'] = cutstr(trim($v['title']), 60);
			if($v['pic'] > 0){
				$v['title'] = $v['title'].'&nbsp;<img src="static/image/filetype/image_s.gif" alt="attach_img" title="'.milu_lang('img_article').'" align="absmiddle">';
			}
			if($arr['s']){
				$v['title'] = str_replace($arr['s'], '<span style="color:red">'.$arr['s'].'</span>',$v['title']);
			}
			$v['dateline'] = dgmdate($v['dateline']);
			$v['last_modify'] = $v['last_modify'] ? dgmdate($v['last_modify']) : milu_lang('no_modify');
			$v['public_time'] = $v['public_time'] ? dgmdate($v['public_time']) : milu_lang('no_public');
			$v['public_dateline'] = $v['public_dateline'] ? dgmdate($v['public_dateline']) : '';
			if(!$v['name']){
				$pick_info = article_get_picker_info($v['pid']);
				$v['name'] = $pick_info['name'];
			}
			$data['rs'][] = $v;
		}
	}
	$data['multipage'] = multi($count, $perpage, $page, $mpurl);	
	return $data;
}

function article_get_picker_info($pid, $field = 'name'){
	if(!$pid) return array();
	return DB::fetch_first("SELECT $field FROM ".DB::table('strayer_picker')." WHERE pid='$pid'");
}

function article_count($pid = 0,$status=0, $args = array()){
	if($pid){
		if($status == 4){
			$json_sql = "Inner Join ".DB::table('strayer_timing')." AS t ON a.aid = t.data_id WHERE t.pid='$pid' ";
			$p_field = ',t.*';
		}else{
			$json_sql = "Inner Join ".DB::table('strayer_picker')." AS p ON p.pid = a.pid WHERE a.pid='$pid'";
			$p_field = ',p.pid,p.pick_cid,p.name';
		}
	}else{
		$json_sql = '';
		$sql .= ' WHERE  1=1 ';
	}
	if($status == 0) {
		$sql .= 'AND a.status < 10';
	}else if($status == 1){
		$sql .= 'AND a.status < 2';
	}else if($status != 4){
		$sql .= " AND a.status=".$status;
	}
	if($args['s']){
		$sql .= " AND a.title like '%".$args['s']."%' ";
	}
	return DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_article_title')." AS a $json_sql ".$sql), 0);
}

function get_timing_count($pid = 0){
	if($pid) $where = " WHERE pid='$pid'";
	return DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_timing').$where), 0);
}

function get_timing_data($args = array()){
	global $_G;
	$pid = $args['pid'] ? $args['pid']: $_GET['pid']; 
	$count = get_timing_count($pid);
	if($count) {
		
	}
}

function article_info($aid){
	$arr = DB::fetch_first("SELECT * FROM ".DB::table('strayer_article_title')." WHERE aid='$aid'");
	if(!$arr) return FALSE;
	if($arr['aid']){
		$query =  DB::query("SELECT * FROM ".DB::table('strayer_article_content')." WHERE aid='".$arr['aid']."' ");
		while(($v = DB::fetch($query))) {
			if($v['pageorder'] == 1){
				$c_arr = $v;
				
			}else{
				$reply_arr[] = $v;
			}
			$content_arr[] = $v;	
		}
	}
	$re_arr = array_merge($arr, $c_arr);
	$re_arr['reply'] = dstripslashes($reply_arr);
	$re_arr['content'] = dstripslashes($re_arr['content']);
	$re_arr['content_arr'] = dstripslashes($content_arr);
	return $re_arr;
}

//编辑文章
function article_edit(){
	global $_G;
	include_once libfile('function/portalcp');
	include_once libfile('function/spacecp');
	include_once libfile('function/home');
	require_once libfile('function/forumlist');
	pload('F:spider');
	if($_GET['submit']){
		$setarr = $_GET['set'];
		if(check_uid($setarr['uid']) == 'no') cpmsg_error(milu_lang('user_no_exists'));
		$pick_common_set = get_pick_set();
		$pid = intval($_GET['pid']);
		$p_arr = get_pick_info($pid);
		$setarr['portal_cid'] = $_GET['portal'];
		$setarr['forum_fid'] = $_GET['forums'];
		$setarr['forum_typeid'] = $_GET['threadtypeid'];
		$setarr['blog_big_cid'] = $_GET['blog'];
		$setarr['blog_small_cid'] = $_GET['classid'];
		$setarr['title'] =  getstr(trim($setarr['title']), 80, 1, 1);
		if(strlen($setarr['title']) < 1) {
			cpmsg_error(milu_lang('title_no_empty'));
		}
		
		if(empty($setarr['summary'])) $setarr['summary'] = portalcp_get_summary(stripslashes($_GET['message']));
		$set_arr['summary'] = addslashes($setarr['summary']);
		$setarr['public_time'] =  strtotime($setarr['public_time']);
		$setarr['from'] = dhtmlspecialchars($setarr['from']);
		$setarr['article_tag'] = dhtmlspecialchars($setarr['article_tag']);
		$setarr['fromurl'] = str_replace('&amp;', '&', dhtmlspecialchars($setarr['fromurl']));
		$aid = intval($_GET['aid']);
		$pid = intval($_GET['pid']);
		$status = intval($_GET['status']);
		$relatedarr = array();
		if($_GET['raids']){
			$relatedarr = array_map('intval', $_GET['raids']);
			$relatedarr = array_unique($relatedarr);
			$relatedarr = array_filter($relatedarr);
			$setarr['raids'] = serialize($relatedarr);
		}
		$setarr['tag'] = article_make_tag($_GET['tag']);
		$setarr['last_modify'] = $_G['timestamp'];
		$user_info = get_user_info($setarr['uid']);
		$setarr['username'] = $user_info['username'];
		
		$article_arr = $setarr;
		
		DB::update('strayer_article_title', paddslashes($setarr), array('aid' => $aid));
		$article_arr['is_download_img'] = $setarr['is_download_img'];
		$article_arr['is_water_img'] = $setarr['is_water_img'];
		$setarr = array();
		$content = $_GET['message'];
		
		if(!$_GET['is_bbs']){
			$regexp = '/(###NextPage(\[title=(.*?)\])?###)+/';
			preg_match_all($regexp, $content ,$arr);
			$contents = preg_split($regexp, $content);
			DB::delete('strayer_article_content', "aid='$aid'");
			foreach($contents  as $k => $v){
				$v = dstripslashes($v);
				$setarr['content'] = trim($v);
				$setarr['pageorder'] = $k+1;
				$setarr['aid'] = $aid;
				$setarr['dateline'] = $_G['timestamp'];
				$article_arr['content_arr'][$k] = $setarr;
				DB::insert("strayer_article_content", paddslashes($setarr), true);
			}
		}else{//如果是带回复的
			$setarr['content'] = trim($content);
			$setarr = dstripslashes($setarr);
			DB::update("strayer_article_content", paddslashes($setarr), array('aid' => $aid, 'pageorder' => 1));
		}
		//var_dump($aid);exit();
		$setarr = array();
		$article_view_url = '';
		
		if($_GET['public_flag']){
			$select = $_GET['select'];
			$article_arr['is_bbs'] = $_GET['is_bbs'];
			$article_arr['contents'] = $article_arr['is_bbs'] ? 1 : count($contents);
			$article_arr['content'] = dstripslashes(clear_ad_html($_GET['message']));
			$article_arr['public_reply_seq'] = $p_arr['public_reply_seq'];
			$article_arr['is_public_reply'] = $p_arr['is_public_reply'];
			$article_arr['reply_uid'] = $p_arr['reply_uid'];
			$article_arr['is_page_public'] = $p_arr['is_page_public'];
			if($p_arr['is_word_replace'] == 1){//同义词替换
				if($article_arr['is_bbs'] != 1 && $article_arr['contents'] > 0){//有几页的文章
					$article_arr['content_arr'] = article_words_replace($article_arr['content_arr']);
				}
				$article_arr['content'] = article_words_replace($article_arr['content']);
				$article_arr['title'] = article_words_replace($article_arr['title']);
				if($article_arr['reply']) $article_arr['reply'] = article_words_replace($article_arr['reply']);
			}
			
			
			$article_arr['content'] = str_replace("###NextPage###", "<\br>", $article_arr['content']);
			$arr['content'] = htmlspecialchars_decode($arr['content'], ENT_QUOTES);
			$arr['content'] = format_html($arr['content']);
			
			$data_article_arr = article_info($aid);
			
			$is_timing = $pick_common_set['is_timing'];
			//if(!VIP) $is_timing = 0;
			//发布时间大于当前时间，放入定时发布中
			
			if($article_arr['public_time'] > $_G['timestamp'] && $is_timing == 1 && $aid){

				if($select == 1){//门户
					$timing_public_arr['portal'] = $article_arr['portal_cid'];
				}else if($select == 2){//论坛
					$timing_public_arr['forums'] = $article_arr['forum_fid'];
					$timing_public_arr['threadtypeid'] = $article_arr['forum_typeid'];
				}else{
					$timing_public_arr['blog'] = $article_arr['blog_big_cid'];
					$timing_public_arr['classid'] =  $article_arr['blog_small_cid'];
				}
				$timing_setarr = array('public_type' => $select, 'data_id' => $aid , 'content_type' => 1, 'public_dateline' => $article_arr['public_time'], 'pid' => $pid, 'public_info' => serialize($timing_public_arr));
				article_timing_add($timing_setarr);
				cpmsg(milu_lang('article_public_timming', array('d' => dgmdate($article_arr['public_time'], 'u'))), PICK_GO.'picker_manage&myfunc=article_edit&aid='.$aid.'&pid='.$pid, 'succeed');
				return;
			}
			
			if($select == 1){//门户
				$old_arr['portal_id']  = intval($_GET['old_portal_id']);
				$article_arr['relatedarr'] = $relatedarr;
				
				$setarr['portal_id'] = $article_arr['aid'] =  article_move_portal($article_arr, $old_arr);
				//var_dump($setarr['portal_id']);exit();
				$article_arr['cookie'] = $p_arr['login_cookie'];
				$article_arr['page_url'] = $data_article_arr['url'];
				$article_arr['is_download_file'] = $p_arr['is_download_file'];
				$article_arr['content_filter_html'] = unserialize(dstripslashes($p_arr['content_filter_html']));
				downremotefile($article_arr, 'portal', $old_arr);
				article_thumb($setarr['portal_id']);
				$article_view_url = 'portal.php?mod=view&aid='.$setarr['portal_id'];
			}else if($select == 2){//论坛
				
				if($article_arr['contents'] > 1 && $article_arr['is_bbs'] == 0  && $p_arr['is_page_public'] == 1){
					$article_arr['is_public_reply'] = 1;
					$article_arr['public_reply_seq'] = 0;
					$article_arr['is_content_reply'] = 1;
					$article_arr['is_bbs'] = 1;
					$article_arr['content'] = $article_arr['content_arr'][0]['content'];
				}else{
					if($article_arr['is_bbs'] != 1) $article_arr['reply'] = array();
				}
				if($article_arr['is_bbs']){
					$article_arr['reply'] = $data_article_arr['reply'];
				}
				$article_arr['cookie'] = $p_arr['login_cookie'];
				$article_arr['page_url'] = $data_article_arr['url'];
				$old_arr['forum_id']  = intval($_GET['old_forum_id']);
				$forum_arr = article_move_forums($article_arr, $old_arr);
				if($forum_arr['is_download_img'] == 1){//下载图片
					$forum_arr['cookie'] = $p_arr['login_cookie'];
					$forum_arr['is_download_img'] =  $article_arr['is_download_img'];
					$forum_arr['is_download_file'] =  $p_arr['is_download_file'];
					$forum_arr['is_water_img'] =  $article_arr['is_water_img'];
					forum_downremotefile($forum_arr, $old_arr);
				}
				$setarr['forum_id'] = $article_arr['tid'] =  $forum_arr['tid'];
				$article_view_url = 'forum.php?mod=viewthread&tid='.$setarr['forum_id'];
			}else{//博客
				$old_arr['catid']  = intval($_GET['old_blog_big_cid']);
				$old_arr['classid']  = intval($_GET['old_blog_small_cid']);
				$old_arr['uid']  = intval($_GET['old_uid']);
				$old_arr['username']  = $_GET['old_username'];
				$old_arr['blog_id']  = $_GET['old_blog_id'];
				$setarr['blog_id'] = $article_arr['aid'] =  article_move_blog($article_arr, $old_arr);
				$article_arr['cookie'] =  $p_arr['login_cookie'];
				$article_arr['page_url'] = $data_article_arr['url'];
				$arr['is_download_file'] = $p_arr['is_download_file'];
				$arr['content_filter_html'] = unserialize(dstripslashes($p_arr['content_filter_html']));
				downremotefile($article_arr, 'album', $old_arr);
				$article_view_url = 'home.php?mod=space&do=blog&uid='.$article_arr['uid'].'&id='.$setarr['blog_id'];
			}
			$setarr['status'] = 2;
			DB::update('strayer_article_title', $setarr, array('aid' => $aid));
		}
		$msg = $_GET['public_flag'] ? milu_lang('public') : milu_lang('save');
		$return_url = '?'.PICK_GO.'picker_manage&myac=article_manage&p=1&pid='.$pid.$_GET['url_args'];
		$return_list_html = '<a href="'.$return_url.'">'.milu_lang('return_list').'</a>';
		if($article_view_url) $article_view_output = '&nbsp;<span class="pipe">|</span>&nbsp;<a target="_blank" href="'.$article_view_url.'">'.milu_lang('view_article').'</a>';
		cpmsg(milu_lang('save_success', array('msg' => $msg)).'<br><br><a href="?'.PICK_GO.'picker_manage&myfunc=article_edit&aid='.$aid.'&pid='.$pid.'">'.milu_lang('continue_edit').'</a>&nbsp;<span class="pipe">|</span>&nbsp;'.$return_list_html.$article_view_output, PICK_GO.'picker_manage&myfunc=article_edit&aid='.$aid.'&pid='.$pid, 'succeed');
	}else{
		$pid = intval($_GET['pid']);
		$p_arr = get_pick_info($pid);
		$p_arr['public_class'] = unserialize($p_arr['public_class']);
		$aid = intval($_GET['aid']);
		$data = article_info($aid);
		$data['p_arr'] = $p_arr;
		$data['status'] = intval($_GET['status']);
		if(!$data['view_num']){
			$view_arr = format_wrap($p_arr['view_num'], ',');
			if($view_arr) $data['view_num'] = rand($view_arr[0],$view_arr[1]);
		}
		if($data['contents'] > 1){
			if($data['content_arr']) $data['content'] = content_merge($data['content_arr'], 1);
		}
		
		$time_arr = create_public_time($data, 1);
		
		$data['public_time'] = array_pop ($time_arr);
		
		$data['public_time'] = dgmdate($data['public_time'], 'Y-m-d H:i');
		if(!$data['uid']){
			$rand_arr = get_rand_uid($p_arr);
			$data['uid'] =  $rand_arr[0]['uid'];
		}
		$data['raids'] = unserialize($data['raids']);
		if($data['raids']) {
			$query = DB::query("SELECT title,aid FROM ".DB::table('portal_article_title')." WHERE aid IN (".dimplode($data['raids']).")");
			$list = array();
			while(($value = DB::fetch($query))) {
				$list[$value['aid']] = $value;
				$data['raids_html'] .= '<li id="raid_li_'.$value['aid'].'"><input type="hidden" name="raids[]" value="'.$value['aid'].'" size="5"><a href="portal.php?mod=view&aid='.$value['aid'].'" target="_blank">'.$value['title'].'</a>('.milu_lang('article').' ID: '.$value['aid'].')<a href="javascript:;" onclick="raid_delete('.$value['aid'].');" class="xg1">'.milu_lang('del').'</a></li>';
			}	
		}
		if(!$data['forum_typeid']) $data['forum_typeid'] = $p_arr['public_class'][1];
		$data['threadtypes'] = getthreadtypes(array('typeid' => $p_arr['public_class'][1], 'fid' => $p_arr['public_class'][0]) );
		$data['forumselect'] = '<select id="forums" name="forums" onchange="getthreadtypes(this.value, 0)">'.forumselect(FALSE, 0, $p_arr['public_class'][0], TRUE).'</select>&nbsp;&nbsp;<span id="threadtypes">'.$data['threadtypes'].'</span>';
		$data['portalselect'] = category_showselect('portal', 'portal', $p_arr['public_class'][0]);
		$data['blogselect'] = category_showselect('blog', 'blog', $p_arr['public_class'][0]);
		$data['article_tags'] = article_parse_tags($data['tag']);
		$data['tag_names'] = article_tagnames();
		$data['show_blog_class'] = get_person_blog_class($data['uid'], $data['blog_small_cid']);
		$data['pid'] = $pid;
		$data['public_type'] = $p_arr['public_type'];
		$data['content'] = dhtmlspecialchars(($data['content']));
		$data['url_args'] = $_GET['url_args'];
		return $data;
	}
}




function get_person_blog_class($uid = '',$now_id = ''){
	global $_G;
	include_once libfile('function/spacecp');
	$uid = $uid ? $uid : intval($_GET['uid']);
	$classarr = $uid?getclassarr($uid):getclassarr($_G['uid']);
	$output = '<select name="classid" id="classid" onchange="addSort(this)" ><option value="0">------</option>';
	foreach((array)$classarr as $key => $value){
		if ($value['classid'] == $now_id) {
			$output .= '<option value="'.$value[classid].'" selected>'.$value[classname].'</option>';
		}else{
			$output .= '<option value="'.$value[classid].'">'.$value[classname].'</option>';
		}
	}	
	$output .= '<option value="addoption" style="color:red;">+'.milu_lang('add_class').'</option>';
	$output .= '</select>';
	return $output;
}
function check_uid($uid = ''){
	global $_G;
	$uid = $uid ? $uid : intval($_GET['uid']);
	if(!$uid) return 'no';
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('common_member')." WHERE uid = '$uid' "), 0);
	if($count == 0){
		return 'no';
	}else{
		return $count;
	}
}



//文章批量删除
function article_batch_del($pid){
	$query = DB::query("SELECT aid FROM ".DB::table('strayer_article_title')."  WHERE pid ='$pid' ");	
	while(($v = DB::fetch($query))) {
		article_delete($v['aid'], $pid);
	}
}

//删除单篇文章
function article_delete($aid_arr, $pid = ''){
	if(!$aid_arr) return ;
	if(!is_array($aid_arr)) $aid_arr = array($aid_arr);
	if($pid) $sql = " pid='$pid' AND ";
	DB::query('DELETE FROM '.DB::table('strayer_article_title')." WHERE $sql aid IN (".dimplode($aid_arr).")");
	DB::query('DELETE FROM '.DB::table('strayer_article_content')." WHERE aid IN (".dimplode($aid_arr).")");
}

//删除定时发布
function article_timing_delete($id_arr, $pid = ''){
	if(!$id_arr) return ;
	if(!is_array($id_arr)) $id_arr = array($id_arr);
	if($pid) $sql = " pid='$pid' AND ";
	DB::query('DELETE FROM '.DB::table('strayer_timing')." WHERE $sql id IN (".dimplode($id_arr).")");
}

function article_trash($aid_arr,$status=3){
	if(!$aid_arr) return ;
	foreach($aid_arr as $aid){
		DB::update('strayer_article_title', array('status' => $status), array('aid' => $aid));
	}
}


function downremotefile($arr,$action, $old_arr = array()){
	global $_G;
	$evo_img_no = $_G['cache']['evn_milu_pick']['evo_img_no'];
	$config = get_pick_set();
	$get_file_ext_arr = $config['get_file_ext'] ? explode('|', $config['get_file_ext']) : array();
	if($arr['is_bbs'] != 1){//是论坛回帖就不合并
		if($action == 'portal'){
			$page_flag = $arr['is_page_public'] == 1 ? '' : '1';
			if($arr['content_arr']) $arr['content'] = content_merge($arr['content_arr'], $page_flag);
		}else{
			if($arr['content_arr']) $arr['content'] = content_merge($arr['content_arr']);
		}
	}
	//if(VIP) $arr['content'] = post($arr['content'], array('cookie' => $arr['cookie'], 'page_url' => $arr['page_url'], 'cid' => $arr['cid']));
	$arr['content'] = htmlspecialchars_decode($arr['content'], ENT_QUOTES);
	if($arr['is_download_img'] == 1 || $arr['is_download_file'] == 1){
		if(file_exists(libfile('class/upload'))){
			require_once libfile('class/upload');
		}else{
			require_once libfile('discuz/upload', 'class');
		}
		$upload = new discuz_upload();
		$arrayimageurl = $temp = $imagereplace = $attach_arr = array();
		$string = dstripslashes($arr['content']);
		$downremotefile = true;
		$aid = $arr['aid'];
		preg_match_all("/\<img.+src=('|\"|)?(.*)(\\1)(.*)?\>/isU", $string, $temp, PREG_SET_ORDER);
		if($arr['is_download_file'] == 1) $attach_arr = get_attach_data($arr['page_url'], $string);
		$attach_arr = $attach_arr ? $attach_arr : array();
		$temp = $temp ? $temp : array();
		$temp = array_merge($temp, $attach_arr);
		$del_a = 0;
		if($arr['content_filter_html'][0] == 0 && $arr['content_filter_html']){
			$del_a = 1;
		}
		//print_r($arr['content']);
		//print_r($temp);
		if(is_array($temp) && !empty($temp)) {
			foreach($temp as $tempvalue) {
				$img_url = $tempvalue[2];
				$img_url = str_replace('\"', '', $img_url);
				$no_remote = 0;
				if(strlen($img_url)){
					$img_url = trim(strip_tags($img_url));
					if(!filter_something($img_url, $evo_img_no)){//存在
						$no_remote = 1;
					}
					if($no_remote == 0){
						$tempvalue[2] = $img_url;
						$arrayimageurl[] = $tempvalue;
					}
				}
			}
			if($arrayimageurl) {
				$content_md5_arr = array();
				foreach($arrayimageurl as $key => $tempvalue) {
					$imageurl = $tempvalue[4] == 1 ? $tempvalue[1] : $tempvalue[2];
					$attach['ext'] = $upload->fileext($imageurl);
					if($upload -> is_image_ext($attach['ext']) == 1 && $arr['is_download_img'] != 1){
						unset($imagereplace['oldimageurl'][$key]);
						continue;
					}
					$snoopy_args['cookie'] = $arr['cookie'];
					$snoop_obj = get_snoopy_obj($snoopy_args);
					
					$imagereplace['oldimageurl'][$key] = $tempvalue[4] == 1 ? $tempvalue[0] : $tempvalue[2];
					
					
					if(!$upload->is_image_ext($attach['ext'])) {
						$ext = 'no_get';
						//continue;
					}
					$content = '';
					if(preg_match('/^(http:\/\/|\.)/i', $imageurl)) {
						if($imageurl && snoop_obj) $content_re = get_img_content($imageurl, $snoop_obj, $ext);
						unset($snoop_obj);
						if(is_array($content_re)){
							$content = $content_re['content'];
							$file_name = $attach['name'] = $content_re['file_name'] ? $content_re['file_name'] : ( $value[2] ? _striptext($value[2]) : time().'.'.$content_re['file_ext']);
							$attach['ext'] = $content_re['file_ext'] ? $content_re['file_ext'] : trim($upload->fileext($file_name));
							$file_name = $attach['name'] = $file_name;
						}else{
							$content = $content_re;
						}
						if(in_array(md5($content), $content_md5_arr)) {
							unset($imagereplace['oldimageurl'][$key]);
							continue;
						}
						$content_md5_arr[] = md5($content);
					} elseif(checkperm('allowdownlocalimg')) {
						if(preg_match('/^data\/(.*?)\.thumb\.jpg$/i', $imageurl)) {
							$content = file_get_contents(substr($imageurl, 0, strrpos($imageurl, '.')-6));
						} elseif(preg_match('/^data\/(.*?)\.(jpg|jpeg|gif|png)$/i', $imageurl)) {
							$content = file_get_contents($imageurl);
						}
					}
					if(empty($content)) {	
						if($tempvalue[4] == 1){
							if($del_a == 1){
								unset($imagereplace['oldimageurl'][$key]);
								$imagereplace['oldimageurl_a'][$key] =  $tempvalue[0];
						 		$imagereplace['newimageurl_a'][$key] = $tempvalue[2];
							}else{
								unset($imagereplace['oldimageurl'][$key]);
							}
						}else{
							unset($imagereplace['oldimageurl'][$key]);
						} 
						continue;
					}
					if(!$attach['name']){
						$temp = explode('/', $imageurl);
						$attach['name'] =  trim($temp[count($temp)-1]);
					}
					$attach['thumb'] = '';
	
					$attach['isimage'] = $upload -> is_image_ext($attach['ext']);
					$attach['extension'] = $upload -> get_target_extension($attach['ext']);
					$attach['attachdir'] = $upload -> get_target_dir($action);
					$attach['attachment'] = $attach['attachdir'] . $upload->get_target_filename($action).'.'.$attach['extension'];
					$attach['target'] = getglobal('setting/attachdir').'./'.$action.'/'.$attach['attachment'];
					
					if($attach['isimage'] == 1 && $arr['is_download_img'] != 1){
						unset($imagereplace['oldimageurl'][$key]);
						continue;
					}
					if(!in_array($attach['ext'], $get_file_ext_arr) && $get_file_ext_arr && $attach['isimage'] == 0){
						if($tempvalue[4] == 1){
							if($del_a == 1){
								unset($imagereplace['oldimageurl'][$key]);
								$imagereplace['oldimageurl_a'][$key] =  $tempvalue[0];
						 		$imagereplace['newimageurl_a'][$key] = $tempvalue[2];
							}else{
								unset($imagereplace['oldimageurl'][$key]);
							}
						}else{
							unset($imagereplace['oldimageurl'][$key]);
						} 
						continue;
					}
					if($attach['isimage'] == 0){
						$imagereplace['oldimageurl'][$key] = $tempvalue[1];
						if($action == 'album'){
							unset($imagereplace['oldimageurl'][$key],$imagereplace['oldimageurl_a'][$key], $imagereplace['newimageurl_a'][$key]);
						}
					}
					if(!@$fp = fopen($attach['target'], 'wb')) {
						continue;
					} else {
						flock($fp, 2);
						fwrite($fp, $content);
						fclose($fp);
					}
					if(!$upload->get_image_info($attach['target']) && $attach['isimage'] == 1) {
						@unlink($attach['target']);
						continue;
					}
					$attach['size'] = filesize($attach['target']);
					$attachs[] = daddslashes($attach);
				}
			}
		}
	}
	//print_r($imagereplace);//exit();
	if($attachs) {
		foreach($attachs as $key => $attach) {
			if($action != 'forum' && $attach['isimage'] && empty($_G['setting']['portalarticleimgthumbclosed'])) {
				require_once libfile('class/image');
				$image = new image();
				$thumbimgwidth = $_G['setting']['portalarticleimgthumbwidth'] ? $_G['setting']['portalarticleimgthumbwidth'] : 300;
				$thumbimgheight = $_G['setting']['portalarticleimgthumbheight'] ? $_G['setting']['portalarticleimgthumbheight'] : 300;
				$attach['thumb'] = $image->Thumb($attach['target'], '', $thumbimgwidth, $thumbimgheight, 2);
				if($arr['is_water_img'] == 1) $image->Watermark($attach['target'], '', $action);//打水印
			}
			if($action == 'portal'){
				//if(!$arr['attachment']) $arr['attachment'] = 'portal/'.$attach['attachment'];
				
				if(getglobal('setting/ftp/on') && ((!$_G['setting']['ftp']['allowedexts'] && !$_G['setting']['ftp']['disallowedexts']) || ($_G['setting']['ftp']['allowedexts'] && in_array($attach['ext'], $_G['setting']['ftp']['allowedexts'])) || ($_G['setting']['ftp']['disallowedexts'] && !in_array($attach['ext'], $_G['setting']['ftp']['disallowedexts']))) && (!$_G['setting']['ftp']['minsize'] || $attach['size'] >= $_G['setting']['ftp']['minsize'] * 1024)) {
					if(ftpcmd('upload', 'portal/'.$attach['attachment']) && (!$attach['thumb'] || ftpcmd('upload', 'portal/'.getimgthumbname($attach['attachment'])))) {
						@unlink($_G['setting']['attachdir'].'/portal/'.$attach['attachment']);
						@unlink($_G['setting']['attachdir'].'/portal/'.getimgthumbname($attach['attachment']));
						$attach['remote'] = 1;
					} else {
						if(getglobal('setting/ftp/mirror')) {
							@unlink($attach['target']);
							@unlink(getimgthumbname($attach['target']));
							portal_upload_error(lang('portalcp', 'upload_remote_failed'));
						}
					}
				}
				
				$setarr = array(
					'uid' => $arr['uid'],
					'filename' => $attach['name'],
					'attachment' => $attach['attachment'],
					'filesize' => $attach['size'],
					'isimage' => $attach['isimage'],
					'thumb' => $attach['thumb'],
					'remote' => $attach['remote'],
					'filetype' => $attach['extension'],
					'dateline' => $_G['timestamp'],
					'aid' => $aid
				);
				$setarr['attachid'] = DB::insert("portal_attachment", $setarr, true);
			}else if($action == 'album'){
				$arr['pic'] = $attach['attachment'];
				
				$new_name = $attach['target'];

				require_once libfile('class/image');
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
				
				$attach['remote'] = 0;
				$album_picflag = 1;
			
				if(getglobal('setting/ftp/on')) {
					$ftpresult_thumb = 0;
					$ftpresult = ftpcmd('upload', 'album/'.$attach['attachment']);
					if($ftpresult) {
						@unlink($_G['setting']['attachdir'].'album/'.$attach['attachment']);
						if($thumb) {
							$thumbpath = getimgthumbname($attach['attachment']);
							ftpcmd('upload', 'album/'.$thumbpath);
							@unlink($_G['setting']['attachdir'].'album/'.$thumbpath);
						}
						$attach['remote'] = 1;
						$album_picflag = 2;
					} else {
						if(getglobal('setting/ftp/mirror')) {
							@unlink($upload->attach['target']);
							@unlink(getimgthumbname($upload->attach['target']));
							return lang('spacecp', 'ftp_upload_file_size');
						}
					}
				}
							
				
				$setarr = array(
					'uid' => $arr['uid'],
					'filename' => $attach['name'],
					'filepath' => $attach['attachment'],
					'size' => $attach['size'],
					'thumb' => $attach['thumb'],
					'username' => $arr['username'],
					'postip' => $_G['clientip'],
					'remote' => $attach['remote'],
					'type' => $attach['extension'],
					'dateline' => $arr['public_time'],
				);
				//print_r($setarr);exit();
				$setarr['attachid'] = DB::insert("home_pic", $setarr, true);
				
				
				if($attach['thumb'] == 1 && $feed_re !=1){
					$feed['image_1'] =  'data/attachment/album/'.$attach['attachment'].'.thumb.jpg';
					$feed['image_1_link'] =  'home.php?mod=space&uid='.$arr['uid'].'&do=blog&id='.$arr['aid'];
					DB::update("home_feed", $feed, array("idtype" => 'blogid', 'id' => $arr['aid']));
					$feed_re = 1;
				}
			}
			
			if($downremotefile) {
				$attach['url'] = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']).''.$action.'/';	
				$imagereplace['newimageurl'][] = $attach['url'].$attach['attachment'];
			}
		}
		if($downremotefile && $imagereplace || ($del_a == 1 && $imagereplace) ) {
			$string = preg_replace(array("/\<(script|style|iframe)[^\>]*?\>.*?\<\/(\\1)\>/si", "/\<!*(--|doctype|html|head|meta|link|body)[^\>]*?\>/si"), '', $string);
			$string = str_replace($imagereplace['oldimageurl'], $imagereplace['newimageurl'], $string);
			$string = str_replace($imagereplace['oldimageurl_a'], $imagereplace['newimageurl_a'], $string);
			$string = str_replace(array("\r", "\n", "\r\n"), '', addcslashes($string, '/"\\'));
			$arr['content'] = $string;
		}
	}
	
	if($del_a == 1) {
			$arr['content'] = clear_html_script($arr['content'], array(0));
	}
	if(DISCUZ_VERSION != 'X2'){//2.5版本
		$arr['content']  = dstripslashes($arr['content']);//不必转义
	}
	$do = $action.'_article_content';
	if ($action != 'forum') $do($arr, $old_arr);
}



function get_user_info($uid=0){
	global $_G;
	if($uid == 0) $uid =  $_G['uid'];
	return DB::fetch_first("SELECT * FROM ".DB::table('common_member')." WHERE uid='$uid'");
}

function article_import($action, $args){
	global $_G;
	$pick_common_set = get_pick_set();
	$is_timing = $pick_common_set['is_timing'];
	//if(!VIP) $is_timing = 0;
	pload('F:spider');
	$aid_arr  =  $args['aid'] ? $args['aid'] : $_GET['aid'];
	$op = 'article_'.$action;
	$type_arr = explode('_',$action);
	$type = $type_arr[1];
	$pid = $args['pid'] ? $args['pid'] : intval($_GET['pid']);
	$p_arr = get_pick_info($pid);
	$view_arr = format_wrap($p_arr['view_num'], ',');
	$public_type = 1;
	if($type == 'blog') {
		$public_type = 3;
		$type= 'album';
	}
	if($type == 'forums') {
		$public_type = 2;
		$type = 'forum';
	}
	$today_public_num = 0;	
	foreach($aid_arr as $k => $aid){
		$arr = $old_arr =  article_info($aid);
		if(!$arr) continue;
		$arr['p_arr'] = $p_arr;
		$arr['public_start_time'] = $_GET['public_start_time'] ? $_GET['public_start_time'] : $p_arr['public_start_time'];
		$arr['public_end_time'] = $_GET['public_end_time'] ? $_GET['public_end_time'] : $p_arr['public_end_time'];
		$arr['public_time'] = 0;
		$time_arr = create_public_time($arr, 1);
		$arr['public_time'] = array_pop ($time_arr);
		if($args['cron_run'] && $args['public_time']){
			$arr['public_time'] = $args['public_time'][$aid];
		}
		$arr['title'] = htmlspecialchars_decode($arr['title'], ENT_QUOTES);
		$arr['content'] = htmlspecialchars_decode($arr['content'], ENT_QUOTES);

		$arr['title'] = format_html($arr['title']);
		$arr['content'] = format_html($arr['content']);
		unset($arr['pic']);
		$arr['view_num'] = rand($view_arr[0],$view_arr[1]);
		$rand_arr = get_rand_uid($p_arr);
		$arr['uid'] = $setarr['uid'] = $rand_arr[0]['uid'] ? $rand_arr[0]['uid'] : $_G['uid'];
		$arr['username'] = $setarr['username'] = $rand_arr[0]['username'];
		$arr['portal_cid'] =$timing_public_arr['portal'] = $args['portal'] ? $args['portal'] : $_GET['portal'];
		$arr['forum_fid'] = $timing_public_arr['forums'] = $args['forums'] ? $args['forums'] : $_GET['forums'];
		$arr['forum_typeid'] = $timing_public_arr['threadtypeid'] = $args['threadtypeid'] ? $args['threadtypeid'] : $_GET['threadtypeid'];
		$arr['blog_big_cid'] = $timing_public_arr['blog'] = $args['blog'] ? $args['blog'] : $_GET['blog'];
		$arr['blog_small_cid'] = $timing_public_arr['classid'] = $args['classid'] ? $args['classid'] : $_GET['classid'];
		$arr['is_download_img'] = $p_arr['is_download_img'];
		$arr['is_water_img'] = $p_arr['is_water_img'];
		$arr['content'] = clear_ad_html($arr['content']);
		$arr['summary'] = addslashes($arr['summary']);
		$arr['public_reply_seq'] = $p_arr['public_reply_seq'];
		$arr['is_public_reply'] = $p_arr['is_public_reply'];
		$arr['public_uid'] = $p_arr['public_uid'];
		$arr['reply_uid'] = $p_arr['reply_uid'];
		$arr['is_page_public'] = $p_arr['is_page_public'];
		$arr['page_url'] = $arr['url'];
		//发布时间大于当前时间，放入定时发布中
		if($arr['public_time'] > $_G['timestamp'] && $is_timing == 1 ){
			$timing_setarr = array('public_type' => $public_type, 'data_id' => $aid, 'content_type' => 1, 'public_dateline' => $arr['public_time'], 'pid' => $pid, 'public_info' => serialize($timing_public_arr));
			article_timing_add($timing_setarr);
			DB::update('strayer_article_title', array('status' => 4), array('aid' => $aid));
			continue;
		}
		$arr['article_tag'] = $pick_common_set['open_tag'] == 1 && ($type == 'album' || $type == 'forum') && empty($arr['article_tag']) ? implode(',', dz_get_tag($arr['title'], $arr['content'], 1)) : $arr['article_tag'];
		$arr['cookie'] = $p_arr['login_cookie'];
		$arr['is_download_file'] = $p_arr['is_download_file'];
		$arr['content_filter_html'] = unserialize(dstripslashes($p_arr['content_filter_html']));
		if($arr['contents'] > 1 && $arr['is_bbs'] == 0 && $type == 'forum' && $p_arr['is_page_public'] == 2){
			$arr['is_public_reply'] = 1;
			$arr['public_reply_seq'] = 0;
			$arr['is_content_reply'] = 1;
			$arr['is_bbs'] = 1;
		}else{
			if($arr['is_bbs'] != 1) $arr['reply'] = array();
		}
		if($p_arr['is_word_replace'] == 1){//同义词替换
			if($p_arr['is_bbs'] != 1 && $arr['contents'] > 1){//有几页的文章
				$arr['content_arr'] = article_words_replace($arr['content_arr']);
			}
			$arr['content'] = article_words_replace($arr['content']);
			if($arr['reply']) $arr['reply'] = article_words_replace($arr['reply']);
			$arr['title'] = article_words_replace($arr['title']);
		}
		$arr['content'] = clear_ad_html($arr['content']);

		unset($arr['url']);//跟门户的跳转url重名
		unset($arr['aid']);
		if($type == 'forum'){
			$arr = $op($arr, $old_arr);
			$insert_aid = $setarr['forum_id'] = $arr['tid'];
		}else{
			$insert_aid = $op($arr, $old_arr);
			if($type == 'portal'){
				$setarr['portal_id'] = $insert_aid;
			}else{
				$setarr['blog_id'] = $insert_aid;
			}
		}
		if($insert_aid){
			$arr['aid'] =  $insert_aid;
			$arr['cookie'] = $p_arr['login_cookie'];
			if($type == 'forum'){
				if($arr['is_download_img'] == 1 || $arr['is_download_file'] == 1) forum_downremotefile($arr, $old_arr);
			}else{
				downremotefile($arr, $type, $old_arr);
			}	
			 if($type == 'portal') article_thumb($insert_aid);
		}
		$p_arr['is_public_del'] = $p_arr['is_public_del'] ? $p_arr['is_public_del'] : intval($_GET['is_public_del']);
		$setarr['status'] = 2;
		$setarr['article_tag'] = $arr['article_tag'];
		$today_public_num ++;
		if($p_arr['is_public_del'] != 1 && $insert_aid) DB::update('strayer_article_title', $setarr, array('aid' => $aid));
		
	}
	if(VIP){
		$today_arr = dunserialize(pick_common_get('', 'pick_today'));
		$c_set['pick_today']['day'] = date('md', $_G['timestamp']);
		$c_set['pick_today']['article_public_num'] = $today_public_num + $today_arr['article_public_num'];
		pick_common_set($c_set);
	}
	if($p_arr['is_public_del'] == 1 ) article_delete($aid_arr);//导入之后删除
	return $insert_aid;
	
}

//这个函数暂时没用，保留着
function word_seo_replace($arr){
	return $arr;//后来改为显示的时候seo了
	pload('F:seo');
	if($arr['contents'] > 1){//多页文章
		$seo_arr = pick_seo_replace(array('title' => $arr['title']), 0, 0);
		$arr['title'] = $seo_arr['title'];
		$seo_arr = array();
		foreach($arr['content_arr'] as $k => $v){
			$seo_arr = pick_seo_replace(array('content' => $v['content']), 0, 0);
			$v['content'] = $seo_arr['content'];
			$arr['content_arr'][$k] = $v;
		}
		 
	}else{
		$arr = pick_seo_replace($arr, 0, 0);
	}
	return $arr;
}

function article_timing_add($args){
	extract($args);
	if(!$data_id || !$content_type || !$public_type) return;
	$check = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_timing')." WHERE data_id='$data_id' AND content_type='$content_type' AND public_type='$public_type'"), 0);
	if($check){
		DB::update('strayer_timing', array('public_dateline' => $public_dateline), array('data_id' => $data_id));
	}else{
		return DB::insert('strayer_timing', $args, TRUE);
	}
}

//文章敏感词 同义词替换
function article_words_replace($data, $words = ''){
	if(VIP) return $data;
	if(!$data) return;
	$words = $words ? $words : get_replace_words();
	if(is_array($data)){
		foreach($data as $k => $v){
			if($v['content']) $v['content'] = strtr($v['content'], $words);
			$data[$k] = $v;
		}
	}else{
		$data = strtr($data,$words);
	}
	return $data;
}

function create_public_time($arr = array(),$num = 1, $is_reply = 0){
	global $_G;
	$p_arr = $arr['p_arr'];
	$time_type = $p_arr['public_time_type'];
	if($is_reply != 1) {
		if(!$time_type || $time_type == 1){//发布时的时间
			$re_arr[] = $_G['timestamp'];
		}else if($time_type == 2){// 采集到的时间
			$re_arr[] = $arr['article_dateline'] ? $arr['article_dateline'] : $_G['timestamp']; 			
		}else if($time_type == 3){//随机时间段
			$time_pre = '1234321';//这是代表 - 符号
			$p_arr['public_start_time'] = strexists($p_arr['public_start_time'], $time_pre) ? $_G['timestamp'] - 3600 * str_replace($time_pre, '', $p_arr['public_start_time']) : ( $p_arr['public_start_time'] > (TIMESTAMP - 20*365*24*3600) ? $p_arr['public_start_time'] : $_G['timestamp'] + $p_arr['public_start_time'] * 3600 );
			$p_arr['public_end_time'] = $p_arr['public_end_time'] > (TIMESTAMP - 20*365*24*3600) ? $p_arr['public_end_time'] : $_G['timestamp'] + $p_arr['public_end_time'] * 3600;
			
			$re_arr[] = rand($p_arr['public_start_time'], $p_arr['public_end_time']);
		}
	}else{
		$reply_time_arr = explode(',', $p_arr['reply_dateline']);
		if(count($reply_time_arr) == 1) {
			$reply_time_arr[1] = $reply_time_arr[0] * 3600; 
			$reply_time_arr[0] = 30*60; 
		}else{	
			$reply_time_arr[0] = $reply_time_arr[0] ? $reply_time_arr[0] * 3600 : 30*60;
			$reply_time_arr[1] = $reply_time_arr[1] ? $reply_time_arr[1] * 3600 : 3600*2;
		}
		for($i = 0;$i < $num;$i++){
			$re_arr[$i] = $arr['public_time'] + rand($reply_time_arr[0], $reply_time_arr[1]);
		}
	}
	sort($re_arr);
	return $re_arr;
}



//获取随机用户
function get_rand_uid($set_arr, $type = 'public'){
	global $_G;
	$public_uid = $set_arr[$type.'_uid'];
	if($set_arr['uid']) {
		$sql = 'AND uid != '.$set_arr['uid'];
	}
	if(count($set_arr['reply']) > 0 && $type == 'reply' && !$public_uid && $set_arr['is_public_reply'] == 1) {
		$max_uid = DB::result(DB::query("SELECT MAX(uid) FROM ".DB::table('common_member')." WHERE uid = '$uid' "), 0);
		$public_uid = '1,'.$max_uid;	
	}
	$num = 1 + count($set_arr['reply']);
	$limit_str = $num ==1 ? "limit 1" : "limit 1,$num";
	$set_arr[$type.'_uid_type'] = $set_arr[$type.'_uid_type'] ? $set_arr[$type.'_uid_type'] : $set_arr['p_arr'][$type.'_uid_type'];
	if($set_arr[$type.'_uid_type'] == 1){//用户组
		$uid_group_arr = dunserialize($set_arr[$type.'_uid_group']);
		$g_sql = '';
		if($uid_group_arr[0]){
			$g_sql = " WHERE groupid IN (".dimplode($uid_group_arr).") "	;
		}else{
			$g_sql = " WHERE groupid!=9 ";
		}
		$query = DB::query("SELECT uid,username FROM ".DB::table('common_member').$g_sql." ORDER BY rand() $limit_str");
		while(($v = DB::fetch($query))) {
			$arr[] = $v;
		}
	}else{
		if(strexists($public_uid, '|')){
			$uid_arr = explode('|', $public_uid);
			$uid_arr = array_filter($uid_arr);
		
			$query = DB::query("SELECT uid,username FROM ".DB::table('common_member')." WHERE uid IN (".dimplode($uid_arr).") ".$sql." AND groupid!=9 ORDER BY rand() $limit_str");
			while(($v = DB::fetch($query))) {
				$arr[] = $v;
			}
		}else if(strexists($public_uid, ',')) {
			$range_arr = format_wrap($public_uid, ',');
			$max = intval($range_arr[1]);
			$min = intval($range_arr[0]);
			if(!$max || !$min || $max < 0 || $min < 0 || (($max - $min) < 0 )) return $now_arr;
			$query = DB::query("SELECT uid,username FROM ".DB::table('common_member')." WHERE uid<$max AND uid>$min ".$sql." AND groupid!=9 ORDER BY rand() $limit_str");
			while(($v = DB::fetch($query))) {
				$arr[] = $v;
			}
			
		}else{//只填一个
			$info = get_user_info($public_uid);
			$now_arr[0]['uid'] = $info['uid'];
			$now_arr[0]['username'] = $info['username'];
			if($num == 1) return $now_arr;
			for($i = 1; $i< $num+1; $i++){
				$arr[] = $now_arr[0];
			}
		}
	}	
	
	if(!$arr[0]['uid']){
		$now_arr[0]['uid'] = $_G['uid'];
		$now_arr[0]['username'] = $_G['username'];
		return $now_arr;
	}
	return $arr;
}

//合并多个内容
//###NextPage###
function content_merge($content_arr, $page_flag = "<\br>"){
	if($page_flag == 1) $page_flag = '###NextPage###';
	foreach($content_arr as $k => $v){
		$v['content'] = htmlspecialchars_decode($v['content'], ENT_QUOTES);
		$v['content'] = format_html($v['content']);
		$new_arr[$k] = $v['content'];
	}
	return implode($page_flag, $new_arr);
}



/*

function img_tag($attributes, $page_url) {
	$value = array('file' => '', 'width' => '', 'height' => '');
	preg_match_all("/(file|width|height)=([\"|\']?)([^\"']+)(\\2)/is", dstripslashes($attributes), $matches);
	if(is_array($matches[1])) {
		foreach($matches[1] as $key => $attribute) {
			$value[strtolower($attribute)] = $matches[3][$key];
		}
	}
	//print_r($value);
	@extract($value);
	if(!preg_match("/^http:\/\//i", $file)) {
		$file = _expandlinks($file, $page_url);
	}
	return $file ? ($width && $height ? '[img='.$width.','.$height.']'.$file.'[/img]' : '[img]'.$file.'[/img]') : '';
}

*/



function article_move_forums($arr, $old_arr){
	global $_G;
	$arr['content'] = preg_replace(array('/<center>([\s\S]*?)<\/center>/', '/\s(?=\s)/'), array("[align=center]\\1[/align]", ''), $arr['content']);
	$subject = addslashes(trim($arr['title']));
	if($arr['check']){
		if(!strlen($subject)) return FALSE;
		$num = DB::result_first('SELECT COUNT(*) FROM '.DB::table('forum_thread')." WHERE subject='$subject' AND displayorder > '-1'");
		if($num) return FALSE;
	}
	
	if($arr['contents'] > 1 && $arr['is_content_reply'] != 1) $arr['reply'] = array();
	$time_arr = create_public_time($arr, count($arr['reply'])+1, 1);
	if($arr['contents'] == 1){
		$uid_arr = get_rand_uid($arr, 'reply');
	}else if($arr['is_content_reply'] != 1){
		if($arr['content_arr']) $arr['content'] = content_merge($arr['content_arr']);
		$uid_arr = get_rand_uid($arr);
	}
	$arr['public_time'] = $arr['public_time'] ?  $arr['public_time'] : array_shift($time_arr);
	require_once libfile('function/editor');
	require_once libfile('function/forum');
	$subject = htmlspecialchars_decode(format_html($subject));
	$subject = htmlspecialchars_decode(format_html($subject));
	$arr['content'] = dstripslashes($arr['content']);
	$arr['content'] = img_htmlbbcode($arr['content'], $arr['page_url']);
	$arr['content'] = media_htmlbbcode($arr['content'], $arr['page_url']);
	$arr['content'] = audio_htmlbbcode($arr['content'], $arr['page_url']);
	$message = htmlspecialchars_decode(html2bbcode($arr['content']));
	$message = dstripslashes(format_html($message));
	$arr['fid'] = $_G['fid'] = $_GET['forums'] ? $_GET['forums'] : $arr['forum_fid'];
	$_G['uid'] = $arr['uid'] ? $arr['uid'] : $_G['uid'];
	$view_num = $arr['view_num'];
	require_once libfile('function/post');
	$special = 0;
	if(trim($subject) == '' || trim($message) == '') {
		return -1;
	}

	if(!$sortid && !$special && trim($message) == '') {
		return -1;
	}
	$_GET['save'] = $arr['uid'] ? $arr['uid'] : $_G['uid'];
	$uid = $_GET['save'];
	$typeid = intval($_GET['threadtypeid']) ? intval($_GET['threadtypeid']) : $arr['forum_typeid'];
	$displayorder = 0;
	$digest = $_G['forum']['ismoderator'] && $_G['group']['allowdigestthread'] && !empty($_GET['addtodigest']) ? 1 : 0;
	$readperm = $_G['group']['allowsetreadperm'] ? $readperm : 0;
	$isanonymous = $_G['group']['allowanonymous'] && $_GET['isanonymous'] ? 1 : 0;
	$price = intval($price);
	$price = $_G['group']['maxprice'] && !$special ? ($price <= $_G['group']['maxprice'] ? $price : $_G['group']['maxprice']) : 0;

	if(!$typeid && $_G['forum']['threadtypes']['required'] && !$special) {
		return -2;

	}

	if(!$sortid && $_G['forum']['threadsorts']['required'] && !$special) {
		return -3;
	}

	if($price > 0 && floor($price * (1 - $_G['setting']['creditstax'])) == 0) {
		return -4;
	}
	
	$_G['forum'] = DB::fetch_first("SELECT * FROM ".DB::table('forum_forum')." WHERE fid = '$arr[fid]'");//查询版块信息
	if(!$_G['forum']) return -5;
	
	$sortid = $special && $_G['forum']['threadsorts']['types'][$sortid] ? 0 : $sortid;
	$typeexpiration = intval($_GET['typeexpiration']);

	if($_G['forum']['threadsorts']['expiration'][$typeid] && !$typeexpiration) {
		return -5;
	}

	$_G['forum_optiondata'] = array();
	if($_G['forum']['threadsorts']['types'][$sortid] && !$_G['forum']['allowspecialonly']) {
		$_G['forum_optiondata'] = threadsort_validator($_GET['typeoption'], $pid);
	}

	$author = !$arr['username'] ? $_G['username'] : $arr['username'];

	$moderated = $digest || $displayorder > 0 ? 1 : 0;

	$thread['status'] = 0;

	$_GET['ordertype'] && $thread['status'] = setstatus(4, 1, $thread['status']);

	$_GET['hiddenreplies'] && $thread['status'] = setstatus(2, 1, $thread['status']);

	$_GET['allownoticeauthor'] && $thread['status'] = setstatus(6, 1, $thread['status']);
	$isgroup = $_G['forum']['status'] == 3 ? 1 : 0;
	
	//检查各项设置
	$bbcodeoff = checkbbcodes($message, FALSE);
	$smileyoff = checksmilies($message, FALSE);
	$parseurloff = FALSE;
	$htmlon = $_G['group']['allowhtml'] && !empty($_GET['htmlon']) ? 1 : 0;
	
	if($_G['group']['allowreplycredit']) {
		$_GET['replycredit_extcredits'] = intval($_GET['replycredit_extcredits']);
		$_GET['replycredit_times'] = intval($_GET['replycredit_times']);
		$_GET['replycredit_membertimes'] = intval($_GET['replycredit_membertimes']);
		$_GET['replycredit_random'] = intval($_GET['replycredit_random']);

		$_GET['replycredit_random'] = $_GET['replycredit_random'] < 0 || $_GET['replycredit_random'] > 99 ? 0 : $_GET['replycredit_random'] ;
		$replycredit = $replycredit_real = 0;
		
	}
	if($old_arr['forum_id']){
		$info = DB::fetch_first("SELECT p.pid,p.tid,t.tid,p.first FROM ".DB::table('forum_post')." p Inner Join ".DB::table('forum_thread')." t  ON p.tid = t.tid WHERE p.first = '1' AND t.tid='".$old_arr['forum_id']."' AND t.displayorder > '-1'");
	}
	
	$reply_count = count($arr['reply']);
	$view_num = $view_num < ($reply_count - 1) ? rand($reply_count*2, $reply_count*10) : $view_num; 	
	
	if($info['tid']){//更新
		DB::query("UPDATE ".DB::table('forum_thread')." SET typeid='$typeid', author='$author', authorid='$uid', subject='$subject', dateline='$arr[public_time]', lastpost='$arr[public_time]', fid='$arr[fid]', lastposter='$author', views='$view_num', attachment='0' WHERE tid='$info[tid]'", 'UNBUFFERED');
		$tid = $info['tid'];
	}else{//添加
		DB::query("INSERT INTO ".DB::table('forum_thread')." (fid, posttableid, readperm, price, typeid, sortid, author, authorid, subject, dateline, lastpost, lastposter, views, displayorder, digest, special, attachment, moderated, status, isgroup, replycredit, closed)
			VALUES ('$_G[fid]', '0', '$readperm', '$price', '$typeid', '$sortid', '$author', '$_G[uid]', '$subject', '$arr[public_time]', '$arr[public_time]', '$author', '$view_num', '$displayorder', '$digest', '$special', '0', '$moderated', '32', '$isgroup', '$replycredit', '".($closed ? "1" : '0')."')");
		$tid = DB::insert_id();
		useractionlog($uid, 'tid');
		
	}
	DB::update('common_member_field_home', array('recentnote'=>$subject), array('uid'=>$uid));
	if($moderated) {
		updatemodlog($tid, ($displayorder > 0 ? 'STK' : 'DIG'));
		updatemodworks(($displayorder > 0 ? 'STK' : 'DIG'), 1);
	}
	
	if(DISCUZ_VERSION == 'X2'){//2.0版本
		$tagstr = addthreadtag($arr['article_tag'], $tid);
	}else{
		$class_tag = new tag();
		$tagstr = $class_tag->add_tag($arr['article_tag'], $tid, 'tid');
		
	}

	if($_G['group']['allowreplycredit']) {
		if($replycredit > 0 && $replycredit_real > 0) {
			updatemembercount($_G['uid'], array('extcredits'.$_G['setting']['creditstransextra'][10] => -$replycredit_real), 1, 'RCT', $tid);
			DB::query("INSERT INTO ".DB::table('forum_replycredit')." (tid, extcredits, extcreditstype, times, membertimes, random)VALUES('$tid', '$_G[gp_replycredit_extcredits]', '{$_G[setting][creditstransextra][10]}', '$_G[gp_replycredit_times]', '$_G[gp_replycredit_membertimes]', '$_G[gp_replycredit_random]')");
		}
	}

	if($_G['group']['allowpostrushreply'] && $_GET['rushreply']) {
		DB::query("INSERT INTO ".DB::table('forum_threadrush')." (tid, stopfloor, starttimefrom, starttimeto, rewardfloor) VALUES ('$tid', '$_G[gp_stopfloor]', '$_G[gp_rushreplyfrom]', '$_G[gp_rushreplyto]', '$_G[gp_rewardfloor]')");
	}

	$message = preg_replace('/\[attachimg\](\d+)\[\/attachimg\]/is', '[attach]\1[/attach]', $message);
	
	$post_setarr = array(
		'fid' => $arr['fid'],
		'tid' => $tid,
		'first' => '1',
		'author' => $author,
		'authorid' => $_G['uid'],
		'subject' => $subject,
		'dateline' => $arr['public_time'],
		'message' => $message,
		'useip' => $_G['clientip'],
		'invisible' => 0,
		'anonymous' => $isanonymous,
		'usesig' => 1,
		'htmlon' => $htmlon,
		'bbcodeoff' => $bbcodeoff,
		'smileyoff' => $smileyoff,
		'parseurloff' => $parseurloff,
		'attachment' => '0',
		'replycredit' => 0,
		'status' => (defined('IN_MOBILE') ? 8 : 0)
	);
	if(DISCUZ_VERSION != 'X2'){//2.5版本 2.5版本多了一个position字段
		$post_setarr['position'] = 1;
		$post_setarr = dstripslashes($post_setarr);
	}else{
		$post_setarr = daddslashes($post_setarr);
	}
	$post_setarr['tags'] = $tagstr;
	$replys = 0;
	if($info['tid']){//更新
		//发布时间要做更改
		$new_post_arr = DB::fetch_first("SELECT dateline FROM ".DB::table('forum_post')." WHERE tid='$tid' ORDER BY dateline ASC limit 1");		
		$post_setarr['dateline'] = $new_post_arr['dateline'] - 3600;
		DB::update('forum_post', $post_setarr, array('pid' => $info['pid']));
		$pid =  $info['pid'];
		
	}else{
		$pid = insertpost($post_setarr);
		$post_setarr = array();
		//发布回复
		if($arr['is_public_reply'] == 1 && $arr['reply'] || $arr['is_content_reply'] == 1){//是否开启发布回复
			if($arr['is_content_reply'] == 1) {
				$uid_arr = $time_arr = array();
			}
			$reply_arr = $arr['reply'];	
			$replys = count($reply_arr);
			if($arr['public_reply_seq'] == 1) shuffle($reply_arr);
			
			foreach((array)$reply_arr as $k => $v){
				$message = dstripslashes($v['content']);
				$message = media_htmlbbcode($message, $arr['page_url']);
				$message = img_htmlbbcode($message, $arr['page_url']);
				$message = htmlspecialchars_decode(html2bbcode($message));
				//print_r($v['content']);exit();
				if(!$message || strlen($message) < 2) continue;
	
				$post_setarr = array(
					'fid' => $arr['fid'],
					'tid' => $tid,
					'first' => '0',
					'author' => $uid_arr[$k]['username'] ? $uid_arr[$k]['username'] : $arr['username'],
					'authorid' => $uid_arr[$k]['uid'] ? $uid_arr[$k]['uid'] : $arr['uid'],
					'subject' => '',
					'dateline' => $time_arr[$k] ? $time_arr[$k] : $arr['public_time'],
					'message' => $message,
					'useip' => $_G['clientip'],
					'invisible' => 0,
					'anonymous' => $_G['group']['allowanonymous'] && !empty($_GET['isanonymous'])? 1 : 0,
					'usesig' => 1,
					'htmlon' => $_G['group']['allowhtml'] && !empty($_GET['htmlon']) ? 1 : 0,
					'bbcodeoff' => checkbbcodes($message, !empty($_GET['bbcodeoff'])),
					'smileyoff' => checksmilies($message, !empty($_GET['smileyoff'])),
					'parseurloff' => !empty($_GET['parseurloff']),
					'attachment' => '0',
					'tags' => 0,
					'replycredit' => 0,
					'status' => (defined('IN_MOBILE') ? 8 : 0)
				);
				
				$lastpost = $post_setarr['dateline'];
				$lastposter = $post_setarr['author'];
				if(DISCUZ_VERSION != 'X2'){//2.5版本 2.5版本多了一个position字段
					$post_setarr['position'] = $k + 2;
					$post_setarr = dstripslashes($post_setarr);
				}else{
					$post_setarr = daddslashes($post_setarr);
				}
				$reply_pid = insertpost($post_setarr);
				$v['tid'] = $tid;
				$v['pid'] = $reply_pid;
				$v['is_post'] = 1;//标识是回复
				$v['cookie'] = $arr['cookie'];
				$v['is_water_img'] = $arr['is_water_img'];
				$v['is_download_img'] = $arr['is_download_img'];
				$v['is_download_file'] = $arr['is_download_file'];
				
				$forum_arr['tid'] = $tid;
				$forum_arr['pid'] = $reply_pid;
				$forum_arr['is_post'] = 1;//标识是回复
				$forum_arr['cookie'] = $arr['cookie'];
				$forum_arr['is_water_img'] = $arr['is_water_img'];
				$forum_arr['is_download_img'] = $arr['is_download_img'];
				$forum_arr['content'] = $v['content'];
				//$re_arr = forum_downremotefile($forum_arr);
				
				if($arr['is_download_img'] == 1) $re_arr = forum_downremotefile($v);
				DB::query("UPDATE ".DB::table('common_member_count')." SET posts=posts+1 WHERE uid='$post_setarr[authorid]'");//更新数
				$new[$k] = $post_setarr;
			}
			
			unset($post_setarr);
			DB::update('forum_thread', array('replies'=>count($reply_arr), 'lastpost' => $lastpost, 'lastposter' => $lastposter), array('tid'=>$tid));
		}
	}
	//exit();
	$re = $arr;
	$re['fid'] = $fid;
	$re['tid'] = $tid;
	$re['fid'] = $fid;
	$re['uid'] = $arr['uid'];
	$re['username'] = $author;
	$re['pid'] = $pid;
	$re['message'] = $message;
	if($pid && getstatus($thread['status'], 1)) {
		savepostposition($tid, $pid);
	}
	$threadimageaid = 0;
	$threadimage = array();
	//print_r($message);exit();

	if($_G['forum']['threadsorts']['types'][$sortid] && !empty($_G['forum_optiondata']) && is_array($_G['forum_optiondata']) && $sortaids) {
		foreach($sortaids as $sortaid) {
			convertunusedattach($sortaid, $tid, $pid);
		}
	}

	if(($_G['group']['allowpostattach'] || $_G['group']['allowpostimage']) && ($_GET['attachnew'] || $sortid || !empty($_GET['activityaid']))) {
		updateattach($displayorder == -4 || $modnewthreads, $tid, $pid, $_GET['attachnew']);
		if(!$threadimageaid) {
			$threadimage = DB::fetch_first("SELECT aid, attachment, remote FROM ".DB::table(getattachtablebytid($tid))." WHERE tid='$tid' AND isimage IN ('1', '-1') ORDER BY width DESC LIMIT 1");
			$threadimageaid = $threadimage['aid'];
		}
		if($_G['forum']['picstyle']) {
			setthreadcover($pid, 0, $threadimageaid);
		}
	}
	/*删除附件*/
	if($old_arr['forum_id']){
		$query = DB::query("SELECT attachment, thumb, remote, aid FROM ".DB::table(getattachtablebytid($old_arr['forum_id']))." WHERE tid='$old_arr[forum_id]'");	
		while(($v = DB::fetch($query))) {
			$attach[] = $v;
		}
		dunlink($attach);
		DB::query("DELETE FROM ".DB::table('forum_attachment')." WHERE tid='$old_arr[forum_id]'");
		DB::query("DELETE FROM ".DB::table(getattachtablebytid($old_arr['forum_id']))." WHERE tid='$old_arr[forum_id]'");
		DB::delete('forum_threadimage', "tid='$old_arr[forum_id]'");//图片表
	}
	


	$param = array('fid' => $arr['fid'], 'tid' => $tid, 'pid' => $pid);

	$statarr = array(0 => 'thread', 1 => 'poll', 2 => 'trade', 3 => 'reward', 4 => 'activity', 5 => 'debate', 127 => 'thread');
	include_once libfile('function/stat');
	updatestat($isgroup ? 'groupthread' : $statarr[$special]);

	dsetcookie('clearUserdata', 'forum');

	if($specialextra) {

		$classname = 'threadplugin_'.$specialextra;
		if(class_exists($classname) && method_exists($threadpluginclass = new $classname, 'newthread_submit_end')) {
			$threadpluginclass->newthread_submit_end($_G['fid'], $tid);
		}

	}

	
	$feed = array(
		'icon' => '',
		'title_template' => '',
		'title_data' => array(),
		'body_template' => '',
		'body_data' => array(),
		'title_data'=>array(),
		'images'=>array()
	);

	if(!empty($_GET['addfeed']) && $_G['forum']['allowfeed'] && !$isanonymous) {
		$message = !$price ? $message : '';
		if($special == 0) {
			$feed['icon'] = 'thread';
			$feed['title_template'] = 'feed_thread_title';
			$feed['body_template'] = 'feed_thread_message';
			$feed['body_data'] = array(
				'subject' => "<a href=\"forum.php?mod=viewthread&tid=$tid\">$subject</a>",
				'message' => messagecutstr($message, 150)
			);
			if(!empty($_G['forum_attachexist'])) {
				$firstaid = DB::result_first("SELECT aid FROM ".DB::table(getattachtablebytid($tid))." WHERE pid='$pid' AND dateline>'0' AND isimage='1' ORDER BY dateline LIMIT 1");
				if($firstaid) {
					$feed['images'] = array(getforumimg($firstaid));
					$feed['image_links'] = array("forum.php?mod=viewthread&do=tradeinfo&tid=$tid&pid=$pid");
				}
			}
		}
	}

	$feed['title_data']['hash_data'] = "tid{$tid}";
	$feed['id'] = $tid;
	$feed['idtype'] = 'tid';
	if($feed['icon']) {
		postfeed($feed);
	}
	if($displayorder != -4) {
		if($digest) {
			updatepostcredits('+',  $_G['uid'], 'digest', $_G['fid']);
		}
		updatepostcredits('+',  $_G['uid'], 'post', $_G['fid']);
		if($isgroup) {
			DB::query("UPDATE ".DB::table('forum_groupuser')." SET threads=threads+1, lastupdate='".$arr['public_time']."' WHERE uid='$_G[uid]' AND fid='$_G[fid]'");
		}

		$subject = str_replace("\t", ' ', $subject);
		$f_lastpost = "$tid\t$subject\t".$arr['public_time']."\t$author";
		if($_G['forum']['type'] == 'sub') {
			DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$f_lastpost' WHERE fid='".$_G['forum'][fup]."'", 'UNBUFFERED');
		}
	}	

	$subject = str_replace("\t", ' ', $subject);
	$replys = $replys ? $replys : 1;
	//今日发帖
	$todayposts = date("Yjn", $arr['public_time']) == date("Yjn", $v) ? 1 : 0;
	foreach((array)$time_arr as $k => $v){
		if(date("Yjn", $_G['timestamp']) == date("Yjn", $v)) $todayposts++;
	
	}
	
	DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$f_lastpost', threads=threads+1, posts=posts+$replys, todayposts=todayposts+$todayposts WHERE fid='$arr[fid]'", 'UNBUFFERED');//更新今日发帖这些数据
	
	if($_G['forum']['status'] == 3) {
		require_once libfile('function/group');
		updateactivity($_G['fid'], 0);
		require_once libfile('function/grouplog');
		updategroupcreditlog($_G['fid'], $_G['uid']);
	}
	return $re;

}



//单独发布回复
function article_reply($arr){
	global $_G;
	require_once libfile('function/editor');
	require_once libfile('function/post');
	$time_arr = create_public_time($arr, count($arr['reply']), 1);//需传入已经发布的帖子的public_start_time

	$uid_arr = get_rand_uid($arr, 'reply');
	$subject = addslashes($arr['title']);
	$view_num = $arr['view_num'];
	$tid = $arr['tid'];
	$reply_arr = $arr['reply'];		
	if($arr['public_reply_seq'] == 1) shuffle($reply_arr);//打乱回帖
	//print_r($reply_arr);exit();
	$replys = count($reply_arr);
	foreach((array)$reply_arr as $k => $v){
		$message = dstripslashes($v);
		$message = media_htmlbbcode($message, $arr['page_url']);
		$message = img_htmlbbcode($message, $arr['page_url']);
		$message = htmlspecialchars_decode(html2bbcode($message));
		$bbcodeoff = checkbbcodes($message, !empty($_GET['bbcodeoff']));
		$smileyoff = checksmilies($message, !empty($_GET['smileyoff']));
		$parseurloff = !empty($_GET['parseurloff']);
		$htmlon = $_G['group']['allowhtml'] && !empty($_GET['htmlon']) ? 1 : 0;
		$usesig = !empty($_GET['usesig']) ? 1 : ($_G['uid'] && $_G['group']['maxsigsize'] ? 1 : 0);
		$isanonymous = $_G['group']['allowanonymous'] && !empty($_GET['isanonymous'])? 1 : 0;
		if(!$message || strlen($message) < 2) continue;
		$post_setarr = array(
			'fid' => $arr['fid'],
			'tid' => $tid,
			'first' => '0',
			'author' => $uid_arr[$k]['username'] ? $uid_arr[$k]['username'] : $_G['username'],
			'authorid' => $uid_arr[$k]['uid'] ? $uid_arr[$k]['uid'] : $_G['uid'],
			'subject' => '',
			'dateline' => $time_arr[$k],
			'message' => $message,
			'useip' => $_G['clientip'],
			'invisible' => 0,
			'anonymous' => $isanonymous,
			'usesig' => $usesig,
			'htmlon' => $htmlon,
			'bbcodeoff' => $bbcodeoff,
			'smileyoff' => $smileyoff,
			'parseurloff' => $parseurloff,
			'attachment' => '0',
			'tags' => 0,
			'replycredit' => 0,
			'status' => (defined('IN_MOBILE') ? 8 : 0)
		);
		//$new[$k] = $post_setarr;
		if(DISCUZ_VERSION != 'X2'){//2.5版本
			$post_setarr = dstripslashes($post_setarr);
		}else{
			$post_setarr = daddslashes($post_setarr);
		}
		$lastpost = $post_setarr['dateline'];
		$lastposter = $post_setarr['author'];
		$reply_pid = insertpost($post_setarr);
		$forum_arr['tid'] = $tid;
		$forum_arr['pid'] = $reply_pid;
		$forum_arr['is_post'] = 1;//标识是回复
		$forum_arr['cookie'] = $arr['cookie'];
		$forum_arr['is_water_img'] = $arr['is_water_img'];
		$forum_arr['is_download_img'] = $arr['is_download_img'];
		$forum_arr['is_download_file'] = $arr['is_download_file'];
		$forum_arr['content'] = $v;
		$re_arr = forum_downremotefile($forum_arr);
		DB::query("UPDATE ".DB::table('common_member_count')." SET posts=posts+1 WHERE uid='$post_setarr[authorid]'");//更新数
	}

	//今日发帖
	$todayposts = 0;
	foreach((array)$time_arr as $k => $v){
		if(date("Yjn", $_G['timestamp']) == date("Yjn", $v)) $todayposts++;
	
	}

	DB::update('forum_thread', array('replies'=>count($reply_arr), 'lastpost' => $lastpost, 'lastposter' => $lastposter), array('tid'=>$tid));
	$subject = str_replace("\t", ' ', $subject);
	$replys = $replys ? $replys : 1;
	$forum_lastpost = "$tid\t$subject\t$lastpost\t$lastposter";
	DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$forum_lastpost', posts=posts+$replys, todayposts=todayposts+$todayposts WHERE fid='$arr[fid]'", 'UNBUFFERED');//更新今日发帖这些数据
	return TRUE;
}

function forum_article_content($arr){
	global $_G;
	require_once libfile('function/editor');
	require_once libfile('function/home');
	$setarr['attachment'] = $arr['attachment'];
	$setarr['message'] = html2bbcode(media_htmlbbcode(dstripslashes(clear_ad_html($arr['message']))));
	$setarr['message'] = htmlspecialchars_decode($setarr['message']);
	if(DISCUZ_VERSION != 'X2'){//2.5版本 
		$setarr = dstripslashes($setarr);
	}else{
		$setarr = daddslashes($setarr);
	}
	DB::update('forum_post', $setarr, array('pid' => $arr['pid']));
	if(!$arr['is_post'] || $arr['is_post'] > 0 && $arr['attachment'] > 0) DB::update('forum_thread', array('attachment' => $arr['attachment']), array('tid' => $arr['tid']));
	
	if(!$arr['is_post'] || $arr['is_post'] > 0 && $arr['attachment'] > 0) {
		
		DB::update('forum_thread', array('attachment' => $arr['attachment']), array('tid' => $arr['tid']));	
		//图片列表模式的帖子设置封面
		
		$forumpicstyle = DB::result_first("SELECT picstyle FROM ".DB::table('forum_forumfield')." WHERE fid='$arr[forum_fid]'");
		if($forumpicstyle) {
			if($_G['setting']['forumpicstyle']) {
				$_G['setting']['forumpicstyle'] = dunserialize($_G['setting']['forumpicstyle']);
				empty($_G['setting']['forumpicstyle']['thumbwidth']) && $_G['setting']['forumpicstyle']['thumbwidth'] = 214;
				empty($_G['setting']['forumpicstyle']['thumbheight']) && $_G['setting']['forumpicstyle']['thumbheight'] = 160;
			} else {
				$_G['setting']['forumpicstyle'] = array('thumbwidth' => 214, 'thumbheight' => 160);
			}
			setthreadcover($arr['pid']);
		}	
	}	
	
}

function article_thumb($aid){
	global $_G;
	$remote = $_G['setting']['ftp']['on'] == 1 ? 1 : 0;
	$rs = DB::fetch_first("SELECT * FROM ".DB::table('portal_attachment')." WHERE isimage=1 AND thumb=1 AND aid='$aid' ORDER BY dateline ASC");
	if($rs){
		$arr['pic'] = 'portal/'.$rs['attachment'];
		$arr['thumb'] = 1; 
		$arr['remote'] = $remote;
		DB::update('portal_article_title', $arr, array('aid' => $aid));
	}
}

function article_move_portal($arr, $old_arr){
	global $_G;
	require_once libfile('function/home');
	require_once libfile('function/portalcp');
	$arr['title'] = getstr(trim($arr['title']), 80, 1, 1);
	if($arr['check']){
		$subject = daddslashes($arr['title']);
		if(!strlen($subject)) return FALSE;
		$num = DB::result_first('SELECT COUNT(*) FROM '.DB::table('portal_article_title')." WHERE title='$subject'");
		if($num) return FALSE;
	}
	
	$arr['catid'] = $arr['portal_cid'] ? intval($arr['portal_cid']) : intval($_GET['portal']);
	
	//print_r($arr);
	if($article_arr['contents'] > 1 && $arr['is_page_public'] == 1){//是否决定合并内容
		if($arr['content_arr']) $arr['content'] = content_merge($arr['content_arr']);
	}else{
		$contents = count($article_arr['content_arr']);
	}
	if(empty($arr['summary'])) $arr['summary'] = portalcp_get_summary(stripslashes($arr['content']));
	//print_r($arr);exit();
	$arr['dateline'] = !empty($arr['public_time']) ? $arr['public_time'] : TIMESTAMP;
	$arr['pic'] = $arr['pic'] ? $_thumb.addslashes($arr['pic']) : '';
	$arr['thumb'] = 0; 
	$arr['remote'] = 0;
	$article_status = 0;
	$arr['summary'] = dstripslashes($arr['summary']);
	$setarr = array(
		'title' => $arr['title'],
		'author' => $arr['author'],
		'from' => $arr['from'],
		'catid' => $arr['catid'],
		'pic' => $arr['pic'],
		'thumb' => $arr['thumb'],
		'remote' => $arr['remote'],
		'fromurl' => $arr['fromurl'],
		'dateline' => intval($arr['dateline']),
		'url' => $arr['url'],
		'allowcomment' => !empty($arr['forbidcomment']) ? '0' : '1',
		'summary' => $arr['summary'],
		'tag' => $arr['tag'],
		'status' => $article_status,
		'highlight' => $style,
		'showinnernav' => empty($arr['showinnernav']) ? '0' : '1',
		'uid' => $arr['uid'],
		'username' => $arr['username'],
		'contents' => $contents
	);

	$setarr['id'] = intval($arr['id']);
	//var_dump($old_arr);
	if($old_arr['portal_id']){//检查文章被放进回收站或者删除
		$info = DB::fetch_first("SELECT catid,aid FROM ".DB::table('portal_article_title')." WHERE aid='".$old_arr['portal_id']."'");
		//删除附件
		pic_delete($info['pic'], 'portal', $info['thumb'], $info['remote']);
		
		$query = DB::query("SELECT * FROM ".DB::table('portal_attachment')." WHERE aid='$old_arr[portal_id]' ORDER BY attachid DESC");
		while ($value = DB::fetch($query)) {
			pic_delete($value['attachment'], 'portal', $value['thumb'], $value['remote']);
		}
		DB::query('DELETE FROM '.DB::table('portal_attachment')." WHERE aid='$old_arr[portal_id]'");//删除目前的数据再更新
		
	}
	if(!$info['aid']){//旧文章已经不在
		if(DISCUZ_VERSION != 'X2'){//2.5版本 
			$setarr = dstripslashes($setarr);
		}else{
			$setarr = daddslashes($setarr);
		}
		$aid = DB::insert('portal_article_title', $setarr, 1);
		DB::update('common_member_status', array('lastpost' => $arr['dateline']), array('uid' => $arr['uid']));
		//DB::insert('portal_article_count', array('aid'=>$aid, 'catid'=>$setarr['catid'], 'dateline'=>$setarr['dateline'],'viewnum'=>1));
	}else{
		DB::update('portal_article_title', $setarr, array('aid' => $old_arr['portal_id']));
		DB::query('UPDATE '.DB::table('portal_category')." SET articles=articles-1 WHERE catid='".$info['catid']."'");
		$aid = $old_arr['portal_id'];
	}
	//文章点击率更新
	$count_setarr = array(
		'viewnum' => $arr['view_num'],
		'dateline' => $arr['dateline'],
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
	$relatedarr = $arr['relatedarr'];
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
	
	DB::query('UPDATE '.DB::table('portal_category')." SET articles=articles+1 WHERE catid='".$setarr['catid']."'");
	return $aid;
}

function portal_article_content($article_arr,$old_arr = array()){
	global $_G;
	$aid = $article_arr['aid'];
	if($article_arr['contents'] > 1 && $article_arr['is_page_public'] == 1){
		//if($article_arr['content_arr']) $article_arr['content'] = content_merge($article_arr['content_arr']);
	}
	$article_arr['content'] =  media_htmlbbcode($article_arr['content'], $article_arr['page_url'], 'protal');
	$article_arr['content'] = audio_htmlbbcode($article_arr['content'], $article_arr['page_url'], 'protal');
	
	$content = getstr($article_arr['content'], 0, 1, 1, 0, 1);
	//$content = addslashes($content);
	$article_status = 0;
	$regexp = '/(###NextPage(\[title=(.*?)\])?###)+/';
	preg_match_all($regexp, $content ,$arr);
	$pagetitle = array();
	$pagetitle = array_map('trim', $pagetitle);
	$contents = preg_split($regexp, $content);
	$content_count = count($contents);
	$pageorder = intval($arr['pageorder']);
	$id = 0;
	if($old_arr['portal_id']){
		DB::query('DELETE FROM '.DB::table('portal_article_content')." WHERE aid ='".$old_arr['portal_id']."'");
	}
	DB::query('DELETE FROM '.DB::table('portal_article_content')." WHERE aid ='$aid'");
	if($contents) {
		$inserts = array();
		foreach ($contents as $key => $value) {
			$value = trim($value);
			$inserts[] = "('$aid', '".(empty($pagetitle[$key-1]) ? $arr['pagetitle'] : $pagetitle[$key-1])."', '$value', '".($pageorder+$key)."', '$article_arr[public_time]', '$id', '$idtype')";
		}
		//print_r($inserts);
		DB::query("INSERT INTO ".DB::table('portal_article_content')."
			(aid, title, content, pageorder, dateline, id, idtype)
			VALUES ".implode(',', $inserts));
		
		DB::query('UPDATE '.DB::table('portal_article_title')." SET status = '$article_status',pic = '".$article_arr['attachment']."', contents = ".count($inserts)." WHERE aid='$aid'");
	}
	//exit();
}



function article_move_blog($arr, $old_arr){
	global $_G;
	require_once libfile('function/blog');
	require_once libfile('function/home');
	$arr['subject'] = $arr['title'];
	
	if($arr['check']){
		$subject = $arr['subject'];
		if(!strlen($subject)) return FALSE;
		$num = DB::result_first('SELECT COUNT(*) FROM '.DB::table('home_blog')." WHERE subject='$subject'");
		if($num) return FALSE;
	}
	
	if($arr['contents'] > 1 ){//合并内容
		if($arr['content_arr']) $arr['content'] = content_merge($arr['content_arr']);
	}
	$arr['message'] = $arr['content'];
	$arr['friend'] = 0;
	$arr['makefeed'] = 1;
	$arr['catid'] = $arr['blog_big_cid'];
	$arr['classid'] = $arr['blog_small_cid'];
	$blog_arr = pick_blog_post($arr,$old_arr);
	return $blog_arr['blogid'];
}

function album_article_content($arr){
	global $_G;
	$setarr['pic'] = $arr['pic'] == 0 ? '' : $arr['pic'];
	if($arr['pic']) {
		$picflag = $_G['setting']['ftp']['on'] == 1 ? 2 : 1;
		DB::update("home_blog", array('picflag' => $picflag), array('blogid' => $arr['aid']));	
	}	
	$arr['content'] = dstripslashes($arr['content']);
	$arr['content'] =  media_htmlbbcode($arr['content'], $arr['page_url'], 'blog');
	if(DISCUZ_VERSION == 'X2'){//2.0版本
		$arr['content'] = addslashes($arr['content']);
	}
	//$arr['content'] = dhtmlspecialchars($arr['content']);
	$setarr['message'] = $arr['content'];
	DB::update('home_blogfield', $setarr, array('blogid' => $arr['aid']));
}

function pick_blog_post($POST, $olds=array()) {
	global $_G, $space;
	$__G = $_G;
	$_G['uid'] = $POST['uid'];
	
	$_G['username'] = addslashes($POST['username']);

	$POST['subject'] = getstr(trim($POST['subject']), 80, 1, 1);
	//$POST['subject'] = addslashes($POST['subject']);
	if(strlen($POST['subject'])<1) $POST['subject'] = dgmdate($POST['public_time'], 'Y-m-d');
	$POST['friend'] = intval($POST['friend']);

	$POST['target_ids'] = '';
	if($POST['friend'] == 2) {
		$uids = array();
		$names = empty($_GET['target_names'])?array():explode(',', preg_replace("/(\s+)/s", ',', $_GET['target_names']));
		if($names) {
			$query = DB::query("SELECT uid FROM ".DB::table('common_member')." WHERE username IN (".dimplode($names).")");
			while ($value = DB::fetch($query)) {
				$uids[] = $value['uid'];
			}
		}
		if(empty($uids)) {
			$POST['friend'] = 3;
		} else {
			$POST['target_ids'] = implode(',', $uids);
		}
	} elseif($POST['friend'] == 4) {
		$POST['password'] = trim($POST['password']);
		if($POST['password'] == '') $POST['friend'] = 0;
	}
	if($POST['friend'] !== 2) {
		$POST['target_ids'] = '';
	}
	if($POST['friend'] !== 4) {
		$POST['password'] == '';
	}

	$POST['tag'] = dhtmlspecialchars(trim($POST['article_tag']));
	$POST['tag'] = getstr($POST['tag'], 500, 1, 1);
	$POST['tag'] = censor($POST['tag']);

	if($_G['mobile']) {
		$POST['message'] = getstr($POST['message'], 0, 1, 0, 1);
		$POST['message'] = censor($POST['message']);
	} else {
		$POST['message'] = checkhtml($POST['message']);
		$POST['message'] = getstr($POST['message'], 0, 1, 0, 0, 1);
		//$POST['message'] = addslashes($POST['message']);
		$POST['message'] = preg_replace(array(
			"/\<div\>\<\/div\>/i",
			"/\<a\s+href\=\"([^\>]+?)\"\>/i"
		), array(
			'',
			'<a href="\\1" target="_blank">'
		), $POST['message']);
	}
	$message = $POST['message'];
	$blog_status = 0;
	
	if($olds['blog_id']){
		$info = DB::fetch_first("SELECT blogid FROM ".DB::table('home_blog')." WHERE blogid='".$olds['blog_id']."'");
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
						'uid' => $_G['uid'],
						'dateline' => $_G['timestamp']
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
		$classname = DB::result(DB::query("SELECT classname FROM ".DB::table('home_class')." WHERE classid='$classid' AND uid='$_G[uid]'"));
		if(empty($classname)) $classid = 0;
	}

	$blogarr = array(
		'subject' => $POST['subject'],
		'classid' => $classid,
		'viewnum' => $POST['view_num'],
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

	$message = addslashes($message);

	if(checkperm('manageblog')) {
		$blogarr['hot'] = intval($POST['hot']);
	}

	if($blogarr['catid']) {
		DB::query("UPDATE ".DB::table('home_blog_category')." SET num=num+1 WHERE catid='$blogarr[catid]'");
	}
	
	$blogarr['uid'] = $_G['uid'];
	$blogarr['username'] = $_G['username'];
	$blogarr['dateline'] = empty($POST['public_time'])?$_G['timestamp']:$POST['public_time'];
	
	if($info['blogid']){
		DB::update('home_blog', $blogarr, array('blogid' => $info['blogid']));
		$blogid = $info['blogid'];
	}else{
		$blogid = DB::insert('home_blog', $blogarr, 1);
	}
	
	

	DB::update('common_member_status', array('lastpost' => $POST['public_time']), array('uid' => $_G['uid']));
	DB::update('common_member_field_home', array('recentnote'=>$POST['subject']), array('uid'=>$_G['uid']));

	$blogarr['blogid'] = $blogid;
	if(function_exists('modblogtag')){
		$POST['tag'] = $olds ? modblogtag($POST['tag'], $blogid) : addblogtag($POST['tag'], $blogid);
	}else{
		$class_tag = new tag();
		$POST['tag'] = $olds ? $class_tag->update_field($POST['tag'], $blogid, 'blogid') : $class_tag->add_tag($POST['tag'], $blogid, 'blogid');
	}

	$fieldarr = array(
		'message' => $message,
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

	if(!empty($__G)) $_G = $__G;
	if($blog_status == 1) {
		updatemoderate('blogid', $blogid);
		manage_addnotify('verifyblog');
	}
	return $blogarr;
}


function forum_downremotefile($arr, $old_arr){
	global $_G;
	$evo_img_no = $_G['cache']['evn_milu_pick']['evo_img_no'];
	$config = get_pick_set();
	$get_file_ext_arr = $config['get_file_ext'] ? explode('|', $config['get_file_ext']) : array();
	$arr['is_download_file'] = $arr['is_download_file'] ? $arr['is_download_file'] : $arr['p_arr']['is_download_file'];
	$arr['message'] = dstripslashes($arr['content']);
	//print_r($arr);
	//$arr['message'] = str_replace(array("\r", "\n"), array($_GET['wysiwyg'] ? '<br />' : '', "\\n"), $arr['message']);
	preg_match_all("/\[img\]\s*([^\[\<\r\n]+?)\s*\[\/img\]|\[img=\d{1,4}[x|\,]\d{1,4}\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is", $arr['message'], $image1, PREG_SET_ORDER);
	
	//preg_match_all("/\<img.+src=('|\"|)?(.*)(\\1)([\s].*)?\>/ismUe", $arr['message'], $image2, PREG_SET_ORDER);
	preg_match_all("/\<img.+src=('|\"|)?(.*)(\\1)(.*)?\>/isU", $arr['message'], $image2, PREG_SET_ORDER);
	$temp = $aids = $existentimg = $attach_arr = array();
	if(is_array($image1) && !empty($image1)) {
		foreach($image1 as $value) {
			$v = trim(!empty($value[1]) ? $value[1] : $value[2]);
			$no_remote = 0;
			if(!filter_something($v, $evo_img_no)){//存在
				$no_remote = 1;
			}
			if($no_remote == 0){
				$temp[] = array(
					'0' => $value[0],
					'1' => $v
				);
			}
		}
	}
	if(is_array($image2) && !empty($image2)) {
		foreach($image2 as $v) {
			$no_remote = 0;
			$v[2] = trim(strip_tags($v[2]));
			if(!filter_something($v[2], $evo_img_no)){//存在
				$no_remote = 1;
			}
			if($no_remote == 0){
				$temp[] = array(
					'0' => $v[0],
					'1' => $v[2],
				);
			}
		}
	}
	if($arr['is_download_file'] == 1) $attach_arr = get_attach_data($arr['page_url'], $arr['message']);
	$attach_arr = $attach_arr ? $attach_arr : array();
	$temp = $temp ? $temp : array();
	$temp = array_merge($temp, $attach_arr);
	//if(VIP) $arr['message'] = post($arr['message'], array('cookie' => $arr['cookie'], 'page_url' => $arr['page_url'], 'cid' => $arr['cid']));
	$del_a = 0;
	if($arr['content_filter_html'][0] == 0 && $arr['content_filter_html']){
		$del_a = 1;
	}
	//print_r($arr['message']);exit();
	require_once libfile('class/image');
	if(is_array($temp) && !empty($temp)) {
		if(file_exists(libfile('class/upload'))){
			require_once libfile('class/upload');
		}else{
			require_once libfile('discuz/upload', 'class');
		}
		$upload = new discuz_upload();
		$attachaids = array();
		$threadimage_flag = 0;
		$content_md5_arr = array();
		foreach($temp as $key => $value) {
			$snoopy_args['cookie'] = $arr['cookie'];
			$snoop_obj = get_snoopy_obj($snoopy_args);
			$imageurl = $value[1];
			$hash = md5($imageurl);
			if(strlen($imageurl)) {
				$imagereplace['oldimageurl'][] = $value[0];
				if(!isset($existentimg[$hash])) {
					$existentimg[$hash] = $imageurl;
					$attach['ext'] = $upload->fileext($imageurl);
					if($upload -> is_image_ext($attach['ext']) == 1 && $arr['is_download_img'] != 1){
						$imagereplace['newimageurl'][] = $value[0];
						continue;
					}
					if(!$upload->is_image_ext($attach['ext'])) {
						$ext = 'no_get';
					}
					if(preg_match('/^(http:\/\/|\.)/i', $imageurl)) {
						if($imageurl && snoop_obj) $content_re = get_img_content($imageurl, $snoop_obj, $ext);
						if(is_array($content_re)){
							$content = $content_re['content'];
							$file_name = $attach['name'] = $content_re['file_name'] ? $content_re['file_name'] : ( $value[2] ? _striptext($value[2]) : time().'.'.$content_re['file_ext']);
							$attach['ext'] = $content_re['file_ext'] ? $content_re['file_ext'] : trim($upload->fileext($file_name));
							$file_name = $attach['name'] = $file_name;
						}else{
							$content = $content_re;
						}
						if(in_array(md5($content), $content_md5_arr)) {
							$imagereplace['newimageurl'][] = '';
							continue;
						}
						$content_md5_arr[] = md5($content);
					} elseif(preg_match('/^('.preg_quote(getglobal('setting/attachurl'), '/').')/i', $imageurl)) {
						$imagereplace['newimageurl'][] = $value[0];
					}
					if(empty($content)) {
						if($value[4] == 1){
							if($del_a == 1){
						 		$imagereplace['newimageurl'][] = $value[2];
							}else{
								unset($imagereplace['oldimageurl'][$key]);
							}
						}else{
							$imagereplace['newimageurl'][] = '';
						} 
						continue;
					}
					if(!$attach['name']){
						$patharr = explode('/', $imageurl);
						$attach['name'] =  trim($patharr[count($patharr)-1]);
					}
					$patharr = explode('/', $imageurl);
					if(!$attach['name']) $attach['name'] =  trim($patharr[count($patharr)-1]);
					$attach['thumb'] = '';
					$attach['ext'] = trim($attach['ext']);//不加这个有些还真不行
					$attach['isimage'] = $upload -> is_image_ext($attach['ext']);
					if($attach['isimage'] == 1 && $arr['is_download_img'] != 1){
						$imagereplace['newimageurl'][] = $value[0];
						continue;
					}
					$attach['extension'] = $upload -> get_target_extension($attach['ext']);
					$attach['attachdir'] = $upload -> get_target_dir('forum');
					$attach['attachment'] = $attach['attachdir'] . $upload->get_target_filename('forum').'.'.$attach['extension'];
					$attach['target'] = getglobal('setting/attachdir').'./forum/'.$attach['attachment'];
					if(!in_array($attach['ext'], $get_file_ext_arr) && $get_file_ext_arr && $attach['isimage'] == 0){
						if($value[4] == 1){
							if($del_a == 1){
						 		$imagereplace['newimageurl'][] = $value[2];
							}else{
								unset($imagereplace['oldimageurl'][$key]);
							}
						}else{
							$imagereplace['newimageurl'][] = '';
						} 
						continue;
					}
					
					
					if(!@$fp = fopen($attach['target'], 'wb')) {
						continue;
					} else {
						flock($fp, 2);
						fwrite($fp, $content);
						fclose($fp);
					}
					if(!$upload->get_image_info($attach['target']) && $attach['isimage'] == 1) {
						@unlink($attach['target']);
						continue;
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
						if(($_G['setting']['watermarkstatus'] && empty($_G['forum']['disablewatermark'])) && $arr['is_water_img'] == 1) {
							$image = new image();
							$image->Watermark($attach['target'], '', 'forum');
						}
					}
					$desc = $value[3];
					$arr['public_time'] = $arr['public_time'] ? $arr['public_time'] : $arr['dateline'];
					$arr['public_time'] = $arr['public_time'] ? $arr['public_time'] : $_G['timestamp'];
					$remote = 0;
					$setarr = array(
						'uid' => $arr['uid'],
						'tid' => $arr['tid'],
						'pid' => $arr['pid'],
						'filename' => daddslashes($upload->attach['name']),
						'attachment' => $upload->attach['attachment'],

						'filesize' => $upload->attach['size'],
						'thumb' => $thumb,
						'remote' => $remote,
						'picid' => $picid,
						'isimage' => $attach['isimage'],
						'description' => $desc,
						'readperm' => 0,
						'price' => 0,
						'width' => $width,
						'dateline' => $arr['public_time'],
					);
					
					$setimg_arr = array(
						'tid' => $arr['tid'],
						'attachment' => $upload->attach['attachment'],
						'remote' => $remote,
					); 
					$set_att = array(
						'downloads' => rand(1,15),
						'tableid' => getattachtableid($arr['tid']),
						'uid' => $arr['uid'],
						'pid' => $arr['pid'],
						'tid' => $arr['tid']
					);	
					
					if($threadimage_flag == 0 && !$arr['is_post'] && $attach['isimage'] == 1) {
						DB::insert('forum_threadimage', $setimg_arr, true);
						$threadimage_flag = 1;
					}
					$setarr['aid'] = $newaids[] = DB::insert('forum_attachment', $set_att, true);
					$at[] = $setarr['aid'];
		
					
					$attachnew_arr[$setarr['aid']] = array('description' => $setarr['description']);
					DB::insert(getattachtablebytid($arr['tid']), $setarr, true);
					$attachaids[$hash] = $imagereplace['newimageurl'][] = '[attach]'.$setarr['aid'].'[/attach]';
				} else {
					$imagereplace['newimageurl'][] = $attachaids[$hash];
				}
			}
		}
		if($_G['setting']['ftp']['on'] == 1) {
			require_once libfile('function/post');
			ftpupload($newaids, $arr['uid']);
		}
		if(count($at) > 0) $arr['attachment'] = 2;
		$arr['message'] = str_replace($imagereplace['oldimageurl'], $imagereplace['newimageurl'], $arr['message']);
		if($del_a == 1) {
			$arr['message'] = clear_html_script($arr['message'], array(0));
		}
		forum_article_content($arr);
	}
}

function get_attach_data($url, $message){
	if(!$message) return array();
	$message = dstripslashes($message);
	//$base_url  = get_base_url($message);
	$url = $base_url ? $base_url : $url;
	$data =  array();
	preg_match_all("/\<a(.*)?>(.*)?<\/a>/isU", $message , $attach_arr, PREG_SET_ORDER);
	if(!$attach_arr) return array();
	foreach($attach_arr as $k => $v){
		$info = get_attach_info($v[1], $url);
		$data[$k][0] = $v[0];
		$data[$k][1] = $info['href'];
		$data[$k][2] = $v[2];
		$data[$k][3] = $info['title'];
		$data[$k][4] = 1;
	}
	//print_r($data);exit();
	return $data;
}


function get_attach_info($attributes, $page_url) {
	if(!$attributes) return;
	$value = array('title' => '', 'href' => '');
	preg_match_all('/(title|href)=([\"|\'])?(.*?)(?(2)\2|\s)/is', stripslashes($attributes), $matches);
	if(is_array($matches[1])) {
		foreach($matches[1] as $key => $attribute) {
			$value_name = strtolower($attribute);
			$value_value = trim($matches[3][$key]);
			if($value_name == 'href'){
				$value_value = _expandlinks($value_value, $page_url);
			}
			$value[$value_name] = $value_value;
		}
	}
	return $value;

}


function dz_get_tag($subject, $message, $return_array = 0){
	if(VIP) return FALSE;
	if(empty($subject) && empty($message)) return FALSE;
	$subjectenc = rawurlencode(strip_tags($subject));
	$message = strip_tags(preg_replace("/\[.+?\]/U", '', $message));
	$message = cutstr($message, 960, '');
	$messageenc = rawurlencode($message);
	$data = @implode('', file("http://keyword.discuz.com/related_kw.html?ics=".CHARSET."&ocs=".CHARSET."&title=$subjectenc&content=$messageenc"));
	if(!$data) return FALSE;
	
	if(PHP_VERSION > '5' && CHARSET != 'utf-8') {
		require_once libfile('class/chinese');
		$chs = new Chinese('utf-8', CHARSET);
	}

	$parser = xml_parser_create();
	xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
	xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
	xml_parse_into_struct($parser, $data, $values, $index);
	xml_parser_free($parser);

	$kws = array();

	foreach($values as $valuearray) {
		if($valuearray['tag'] == 'kw' || $valuearray['tag'] == 'ekw') {
			$kws[] = !empty($chs) ? $chs->convert(trim($valuearray['value'])) : trim($valuearray['value']);
		}
	}
	if($return_array) return $kws;
	$return = '';
	if($kws) {
		foreach($kws as $kw) {
			$kw = htmlspecialchars($kw);
			$return .= $kw.' ';
		}
		$return = htmlspecialchars($return);
	}
	return $return;
}
?>
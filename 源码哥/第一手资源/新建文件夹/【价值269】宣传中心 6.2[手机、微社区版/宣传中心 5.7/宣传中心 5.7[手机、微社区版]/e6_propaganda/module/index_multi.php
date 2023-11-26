<?php
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$page = $_GET['page'] ? intval($_GET['page']) : 1;
$perpage = 10;
$start = ($page - 1) * $perpage;
$my_multi = $e6_propaganda['dividend'][$_G['groupid']];
if(defined('IN_MOBILE')) {
	$_GET['status'] = 1;
	if ($num = intval($_GET['num'])) {
		$css_arr[$num] = 'class="ui-btn-active ui-state-persist"';
		$nums = $num.pro_lang('level');
	} else {
		$nums = pro_lang('all');
	}
}
if (empty($_GET['status'])) {
	$prompt = '<a href="'.$nav_url.'&status=1" class="e6_botton">'.pro_lang('detailed_list').'</a>';
	if ($uid = intval($_GET['uid'])) {
		$e6_user = C::t('#e6_propaganda#e6_pro_user')->fetch($uid);
		for($n=1; $n<=($my_multi-1); $n++) {
			if ($e6_user['fuid'.$n] == $_G['uid']) {
				$ok = $n;
				break;
			}
		}
		if(!$ok) {
			$html = pro_lang('no_ajax_multi', array('n'=>$my_multi));
			exit();
		}
		$ok++;
		$multi_list = C::t('#e6_propaganda#e6_pro_user')->fetch_all_by_multi("AND `fuid1`='{$uid}' AND `fuid{$ok}`='{$_G['uid']}'");
		foreach ($multi_list as $v) {
				$li .= "<li id=\"{$v['uid']}\"><span class=\"text\">{$v['username']}</span> ";
				if($v['register'] > 0) {
					$li .= "<ul class=\"ajax\"><li id=\"{$v['uid']}\">{url:$nav_url&uid=$v[uid]}</li></ul>";
				}
				$li .= "</li>";
		}
		print $li;
		exit();
	}
	if ($my_multi) {
		$all_user = C::t('#e6_propaganda#e6_pro_user')->count_by_search(' AND '.get_multi_sql($_G['uid'], $my_multi));
		if ($all_user) $all_num = pro_lang('all_multi', array('num'=>$all_user));
		$multi_list = C::t('#e6_propaganda#e6_pro_user')->fetch_all_by_multi("AND `fuid1`='{$_G['uid']}'");
	}
} else {
	$prompt = '<a href="'.$nav_url.'" class="e6_botton">'.pro_lang('simple_list').'</a>';
	if ($num = intval($_GET['num'])) {
		$num > $my_multi && Showmessage(pro_lang('no_ajax_multi', array('n'=>$my_multi)));
		$conditions = " AND `fuid{$num}`='{$_G['uid']}'";
	} else {
		$conditions = " AND " . get_multi_sql($_G['uid'], $my_multi);
	}
	$count = C::t('#e6_propaganda#e6_pro_user')->count_by_search($conditions);
	if ($num) {
		$count && ${'all_num'.$num} = pro_lang('all_multi', array('num'=>$count));
		${'e6_style'.$num} = 'style="background: #FF6600;"';
	} else {
		$count && $all_num = pro_lang('all_multi', array('num'=>$count));
		$e6_style = 'style="background: #FF6600;"';
	}
	$pro_header = '<td><a '.$e6_style.' href="'.$nav_url.'&status=1">'.pro_lang('all').$all_num.'</a></td>';
	for($n=1; $n<=$my_multi; $n++) {
		$pro_header .= '<td><a '.${'e6_style'.$n}.' href="'.$nav_url.'&status=1&num='.$n.'">'.pro_lang('num_multi', array('n'=>$n)).${'all_num'.$n}.'</a></td>';
	}
	if ($count) {
		$group_list = C::t('common_usergroup')->fetch_all_by_type();
		$n = ($page-1) * $perpage + 1;
		$multi_arr = C::t('#e6_propaganda#e6_pro_user')->fetch_all_by_son($conditions, $start, $perpage);
		foreach ($multi_arr as $k => $v) {
			$v['n'] = $n; $n++;
			$v['groupid'] = $group_list[$v['groupid']]['grouptitle'];
			$v['date'] = dgmdate($v['regdate'], 'Y-m-d');
			$v['regdate'] = dgmdate($v['regdate']);
			$multi_list[] = $v;
		}
		$multi = multi($count, $perpage, $page, $nav_url.'&status=1&num='.$num);
	}
	if (defined('IN_MOBILE') && $page>1) {
		$list_str = "";
		foreach ($multi_list as $v) {
			$list_str .= "<li class=\"e6_li\"><span>{$v['username']}</span><span>{$v['groupid']}</span><span>{$v['regdate']}</span></li>";
		}
		print $list_str;
		exit;
	}
}
 
?>
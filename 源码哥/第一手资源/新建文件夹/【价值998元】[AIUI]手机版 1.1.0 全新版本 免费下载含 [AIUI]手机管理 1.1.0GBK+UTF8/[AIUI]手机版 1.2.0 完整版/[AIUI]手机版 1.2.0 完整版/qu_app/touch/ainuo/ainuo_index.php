<?php

/* Ô´Âë¸çwww.ymg6.com  QQÈº£º550494646 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
global $_G;
$view = $_G['cache']['plugin']['qu_app']['mb_orders'];
if($view == 2){
	$view = 'lastpost';
}elseif($view == 3){
	$view = 'views';
}elseif($view == 4){
	$view = 'replies';
}elseif($view == 5){
	$view = 'recommend_add';
}else{
	$view = 'dateline';
}
loadcache('index_abbs');
$perpage = 10;
$start = $perpage * ($_G['page'] - 1);
$theurl = 'forum.php?mod=guide&view=hot';
$adata = array();
$adata[$view] = get_nbbs_list($view, $start, $perpage);

$currentview[$view] = 'class="xw1 a"';
$num = $perpage;
$alistcount = $adata[$view]['threadcount'];
$realpages = @ceil($alistcount/$perpage);
$maxpage = $realpages;
$nextpage = ($_G['page'] + 1) > $maxpage ? 1 : ($_G['page'] + 1);
$multipage_more = $theurl."&page=$nextpage&mobile=2";
$multipage = multi($alistcount, $perpage, $_G['page'], $theurl);


function get_nbbs_list($view, $start = 0, $num) {
	
	global $_G;
	
	$cachetimelimit = $_G['cache']['plugin']['qu_app']['mb_cachetime'] ? $_G['cache']['plugin']['qu_app']['mb_cachetime'] : 0;
	$cache = $_G['cache']['index_abbs'][$view];
	if($cache && (TIMESTAMP - $cache['cachetime']) < $cachetimelimit) {
		$xfid = 0;
		$tids = $cache['data'];
		$threadcount = count($tids);
		$tids = array_slice($tids, $start, $num, true);
		$updatecache = false;
		if(empty($tids)) {
			return array();
		}
		
	} else {
		$dateline = 0;
		$tids = array();
		$afids = (array)unserialize($_G['cache']['plugin']['qu_app']['mb_fids']);
		$xfid = 0;
		foreach($afids as $nfid){$xfid += $nfid;}
		
		$updatecache = true;
	}
	$tidsql = 'tid>0';
	$limit = $_G['cache']['plugin']['qu_app']['mb_sumnum'] ? $_G['cache']['plugin']['qu_app']['mb_sumnum'] : 100;
	if($xfid) {$tidsql .= ' AND fid IN('.dimplode($afids).')';}
	if($_G['cache']['plugin']['qu_app']['mb_pingbi']){
		$tidsql .= ' AND tid not IN('.$_G['cache']['plugin']['qu_app']['mb_pingbi'].')';
	}
	$addsql = ' AND displayorder>=0 ORDER BY '.$view.' DESC '.DB::limit($start, $limit);
	$query = DB::fetch_all("SELECT * FROM ".DB::table('forum_thread')." WHERE ".$tidsql.$addsql);

	$n = 0;
	foreach($query as $vid) {
		$atids[] = $vid['tid'];
	}
	sort($atids);
	$alistinfo = array();
	$athreadimage = array();
	$alistinfo = get_alistinfoo($query,$atids);
	foreach($query as $thread) {
		$thread = guide_aprocthread($thread);
		
		$ntid = $thread['tid'];
		$thread['num'] = 0;
		$thread['image'] = '';
		$alist_thumb = $alistinfo[$ntid]['listpic'];
		if($numcount = count($alist_thumb)){
			if($numcount == 1){
				$thread['image'] = '<div class="apic1"><img class="ainuolazyload" data-original="'.$alist_thumb[0].'" /></div>';
			}elseif($numcount == 2){
				$thread['image'] = '<div class="apic2 cl">';
				$thread['image'] .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[0].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27600%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
				$thread['image'] .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[1].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27600%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
				$thread['image'] .= '</div>';

			}elseif(($numcount > 2) && $numcount < 6){
				$thread['image'] = '<div class="apic3 cl">';
				$thread['image'] .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[0].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27450%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
				$thread['image'] .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[1].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27450%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
				$thread['image'] .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[2].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27450%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
				$thread['image'] .= '</div>';

			}elseif(($numcount > 5) && $numcount < 9){
				$thread['image'] = '<div class="apic3 cl">';
				foreach($alist_thumb as $thumb){
					$thread['image'] .= '<div class="apic ainuolazyloadbg" data-original="'.$thumb.'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27450%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
				}
				$thread['image'] .= '</div>';

			}elseif($numcount == 9){
				$thread['image'] = '<div class="apic3 cl">';
				foreach($alist_thumb as $thumb){
					$thread['image'] .= '<div class="apic ainuolazyloadbg" data-original="'.$thumb.'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27450%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
				}
				$thread['image'] .= '</div>';

			}
			
		}//Form  www.ymg6.com
		$threadids[] = $thread['tid'];
		if($tids || ($n >= $start && $n < ($start + $num))) {
			$list[$thread[tid]] = $thread;
			$fids[$thread[fid]] = $thread['fid'];
		}
		$n ++;
	}

	$threadlist = array();
	if($tids) {
		$threadids = array();
		foreach($tids as $key => $tid) {
			if($list[$tid]) {
				$threadlist[$key] = $list[$tid];
				$threadids[] = $tid;
			}
		}
	} else {
		$threadlist = $list;
	}
	
	unset($list);//Form  www.ymg6.com
	if($updatecache) {
		$threadcount = count($threadids);
		$adata = array('cachetime' => TIMESTAMP, 'data' => $threadids);
		$_G['cache']['index_abbs'][$view] = $adata;
		savecache('index_abbs', $_G['cache']['index_abbs']);
	}
	return array('threadcount' => $threadcount, 'threadlist' => $threadlist);
}

function guide_aprocthread($thread) {
	global $_G,$configData,$listinfo;
	$_G['forum_colorarray'] = array('', '#EE1B2E', '#EE5023', '#996600', '#3C9D40', '#2897C5', '#2B65B7', '#8F2A90', '#EC1282');
	$todaytime = strtotime(dgmdate(TIMESTAMP, 'Ymd'));
	$thread['lastposterenc'] = rawurlencode($thread['lastposter']);

	if($thread['highlight']) {//Form  www. moq u8.com
		$string = sprintf('%02d', $thread['highlight']);
		$stylestr = sprintf('%03b', $string[0]);

		$thread['highlight'] = ' style="';
		$thread['highlight'] .= $stylestr[0] ? 'font-weight: bold;' : '';
		$thread['highlight'] .= $stylestr[1] ? 'font-style: italic;' : '';
		$thread['highlight'] .= $stylestr[2] ? 'text-decoration: underline;' : '';
		$thread['highlight'] .= $string[1] ? 'color: '.$_G['forum_colorarray'][$string[1]] : '';
		$thread['highlight'] .= '"';
	} else {
		$thread['highlight'] = '';
	}

	if($thread['replies'] > $thread['views']) {
		$thread['views'] = $thread['replies'];
	}

	$thread['dbdateline'] = $thread['dateline'];
	$thread['dateline'] = dgmdate($thread['dateline'], 'u', '9999', getglobal('setting/dateformat'));
	$thread['dblastpost'] = $thread['lastpost'];
	$thread['lastpost'] = dgmdate($thread['lastpost'], 'u');

	if(in_array($thread['displayorder'], array(1, 2, 3, 4))) {
		$thread['id'] = 'stickthread_'.$thread['tid'];
	} else {
		$thread['id'] = 'normalthread_'.$thread['tid'];
	}
	$thread['rushreply'] = getstatus($thread['status'], 3);
	
	return $thread;
}

function get_alistinfoo($athreads,$atids){
	global $_G;
	require_once libfile('function/cache');
	$cachename = md5('qu_'.implode('', $atids));
	$cache_file = DISCUZ_ROOT.'./data/sysdata/qu_app_cache/guide/cache_'.$cachename.'.php';
	if(($_G['timestamp'] - @filemtime($cache_file)) > $_G['cache']['plugin']['qu_app']['listcachetime']) {
		require_once libfile('class/image');
		$img = new image;
		foreach ($athreads as $thread) {
			$piccount = 0;
			$list_thumb = array();
			$listpic = array();
			$tid = $thread['tid'];
			$picnum = 9;
			$tableid = getattachtableid($tid);
			$gquery = DB::query("SELECT * FROM ".DB::table('forum_attachment_'.$tableid)." WHERE tid ='$tid' and isimage=1 ORDER BY aid ASC LIMIT 9");
			if(count($gquery)){
				while ($qattach = DB::fetch($gquery)) {
					$isfirst = DB::result_first("SELECT first FROM ".DB::table('forum_post')." WHERE pid ='$qattach[pid]'");
					if($isfirst || ($thread['special'] == 2)){
						$piccount++;
						$list_thumb[] = $_G['setting']['attachurl'].'forum/'.$qattach['attachment'];
					}
				}
			}
			
			if($piccount < $picnum){
				$post = C::t('forum_post')->fetch_threadpost_by_tid_invisible($tid);
				$message = $post['message'];
				$matches = array();
				$arr = array();
				preg_match_all('/\[img[^\]]*\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is', $message, $matches);					
				if(!empty($matches) && !empty($matches[1]) && is_array($matches[1])){
					foreach($matches[1] as $key => $src){
						if(strpos($src,'/face') || strpos($src,'/smile') || strpos($src,'/emotion')){
							continue;
						}
						if($piccount == ($picnum+1)){break;}
						$piccount++;
						$list_thumb[] = $src;
					}
				}
			}
			
			$anwidth = 220;
			$anheight = 180;
			$ainuofix = 'fixwr';
			if((count($list_thumb) == 1)) {
				$anwidth = 300;
				$anheight = 400;
				$ainuofix = 'fixnone';
			}
			

			foreach($list_thumb as $key => $athumb){
				$thumbfile = 'qu_app/'.$thread['fid'].'/'.$tableid.'/'.$thread['tid'].'_'.$key.'.jpg';
				if(strpos($athumb,'.gif')){
					$listpic[] = $athumb;
				}else{
					if(file_exists($_G['setting']['attachdir'].$thumbfile)) {
						$listpic[] = $_G['setting']['attachurl'].$thumbfile;
					}else{
						$_G['setting']['thumbquality'] = '100';
						if($img->Thumb($athumb, $thumbfile, $anwidth, $anheight, $ainuofix)){
							$listpic[] = $_G['setting']['attachurl'].$thumbfile;
						}
					}
				}
			}

			$data[$tid]['listpic'] = $listpic;
		}

		
		$cacheArray = "\$apicdata=".arrayeval($data).";\n";
		awritetocacheo($cachename, $cacheArray);
	}else{
		include_once DISCUZ_ROOT.'./data/sysdata/qu_app_cache/guide/cache_'.$cachename.'.php';
		$data = $apicdata;
	}
	return $data;
}	

function awritetocacheo($script, $cachedata, $prefix = 'cache_') {
	global $_G;

	$dir = DISCUZ_ROOT.'./data/sysdata/qu_app_cache/guide/';
	if(!is_dir($dir)) {
		dmkdir($dir, 0777);
	}
	if($fp = @fopen("$dir$prefix$script.php", 'wb')) {
		fwrite($fp, "<?php\n//Discuz! cache file, DO NOT modify me!\n//Identify: ".md5($prefix.$script.'.php'.$cachedata.$_G['config']['security']['authkey'])."\n\n$cachedata?>");
		fclose($fp);
	} else {
		exit('Can not write to cache files, please check directory ./data/ and ./data/sysdata/qu_app_cache/guide/ .');
	}
}


?>

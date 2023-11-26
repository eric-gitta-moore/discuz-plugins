<?php
 
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('');
}
define('STUDY_MANAGE_URL', 'plugins&operation=config&do='.$pluginid.'&identifier='.trim($_GET['identifier']).'&pmod=pinglog');
require_once libfile('function_core', 'plugin/study_seo_ping');
require_once libfile('function_manage', 'plugin/study_seo_ping');
require_once DISCUZ_ROOT.'./source/plugin/study_seo_ping/pluginvar.func.php';
loadcache('plugin');
$splugin_setting = $_G['cache']['plugin']['study_seo_ping'];
$lang = array_merge($lang, $scriptlang['study_seo_ping']);
if(!function_exists('curl_init') || !function_exists('curl_exec')) {
	cpmsg('<font color=red><b>&#x670D;&#x52A1;&#x5668;&#x4E0D;&#x652F;&#x6301;CURL&#xFF0C;&#x65E0;&#x6CD5;&#x4F7F;&#x7528;PING&#x529F;&#x80FD;</b></font>');
}
$type1314 = in_array($_GET['type1314'], array('forum', 'portal')) ? $_GET['type1314'] : 'forum';

echo '<link href="./source/plugin/study_seo_ping/images/manage.css?'.VERHASH.'" rel="stylesheet" type="text/css" />';
study_subtitle(array(
	array('&#x8BBA;&#x575B;&#x5E16;&#x5B50;', 'forum'),
	array('&#x95E8;&#x6237;&#x6587;&#x7AE0;', 'portal'),
),$type1314);

if($type1314 == 'portal'){
	if(!$_GET['type']){
			showtableheader();
			$where = '';
			if($_GET['status'] == '1'){
				$where = " WHERE baidu = '1' AND google = '1' ";
			}elseif($_GET['status'] == '2'){
				$where = " WHERE baidu = '2' OR google = '2' ";
			}elseif($_GET['status'] == '1314'){
				$where = " WHERE baidu = '0' OR google = '0' ";
			}
			
			$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('study_seo_ping_article')." $where");
			$page = intval($_G['page']);
			$limit = '10';
			$max = 1000;
			$page = ($page-1 > $num/$limit || $page > $max) ? 1 : $page;
			$start_limit = ($page - 1) * $limit;
			$multipage = multi($num, $limit, $page, ADMINSCRIPT.'?action='.STUDY_MANAGE_URL.'&type1314='.$type1314, $max);
			
			$status_array = array('0'=>'<font color="blue">&#x672A;PING</font>','1'=>'<font color="green"><b>&#x6210;&#x529F;</b></font>','2'=>'<font color="red"><b>&#x5931;&#x8D25;</b></font>');
			$query = DB::query("SELECT * FROM ".DB::table('study_seo_ping_article')." $where ORDER BY id DESC limit $start_limit,$limit");
			$echo = '';
			while($ping = DB::fetch($query)) {
			
				$echo .= '<tbody><tr>
				<td><a href="'.$ping['threadurl'].'" target="_blank">'.$ping['threadurl'].'</a></td>
				<td id="pingbaidu'.$ping['id'].'"><a href="javascript:;" onclick="s_seo_ping(\''.$ping['id'].'\',\'baidu\');return false" title="&#x70B9;&#x51FB;&#x91CD;&#x65B0;PING">'.$status_array[$ping['baidu']].'</a></td>
				<td id="pinggoogle'.$ping['id'].'"><a href="javascript:;" onclick="s_seo_ping(\''.$ping['id'].'\',\'google\');return false" title="&#x70B9;&#x51FB;&#x91CD;&#x65B0;PING">'.$status_array[$ping['google']].'</a></td>
				<td><a href="javascript:;" onclick="s_seo_ping(\''.$ping['id'].'\',\'baidu\');s_seo_ping(\''.$ping['id'].'\',\'google\');return false" title="&#x70B9;&#x51FB;&#x91CD;&#x65B0;PING">&#x5168;&#x90E8;&#x91CD;PING</a></td>
				<td>'.dgmdate($ping['dateline'], 'u').'</td>
				</tr>
				</tbody>';
			}
			if(empty($echo)){
					echo '<td colspan="6" align="center" style="color:red;font-size:25px"><b>&#x6CA1;&#x6709;&#x8BB0;&#x5F55;</b></td>';
			}else{
					showsubtitle(array('&#x6587;&#x7AE0;URL','&#x767E;&#x5EA6;','&#x8C37;&#x6B4C;', '', '&#x65F6;&#x95F4;'));
					echo $echo;
			}
			in_array($_GET['status'], array('1','2','1314')) ? $status[$_GET['status']] = ' class="current" ' : '';
			echo '<tr>
			<td align="left">
			<div class="study_tab_mid">
				<ul class="tab1">
					<li '.( !in_array($_GET['status'], array('1','2','1314')) ? ' class="current" ' : '' ).'>
					<a href="'.ADMINSCRIPT.'?action='.STUDY_MANAGE_URL.'&type1314='.$type1314.'"><span>&#x5168;&#x90E8;</span></a>
					</li>
					<li '.$status[1].'>
					<a href="'.ADMINSCRIPT.'?action='.STUDY_MANAGE_URL.'&type1314='.$type1314.'&status=1"><span>&#x6210;&#x529F;</span></a>
					</li>
					<li '.$status[2].'>
					<a href="'.ADMINSCRIPT.'?action='.STUDY_MANAGE_URL.'&type1314='.$type1314.'&status=2"><span>&#x5931;&#x8D25;</span></a>
					</li>
					<li '.$status[1314].'>
					<a href="'.ADMINSCRIPT.'?action='.STUDY_MANAGE_URL.'&type1314='.$type1314.'&status=1314"><span>&#x672A;PING</span></a>
					</li>
				</ul>
			</div>
			</td>
			<td colspan="4" align="right">
				'.$multipage.'
			</td>
			</tr>';
			showtablefooter();
			echo "
			<script type=\"text/JavaScript\">
			function s_seo_ping(pingid,type){
			ajaxget('".ADMINSCRIPT."?action=".STUDY_MANAGE_URL."&type1314=".$type1314."&formhash=".$_G['formhash']."&type=' + type + '&pingid=' + pingid, 'ping' + type + pingid, 'ping' + type + pingid,'loading');
			}
			</script>";
	}elseif($_GET['formhash'] && $_GET['formhash'] == $_G['formhash']){
			ajaxshowheader();
			$type = $_GET['type'];
			$pingid = intval($_GET['pingid']);
			$aid = DB::result_first("SELECT aid FROM " . DB::table('study_seo_ping_article') . " WHERE id = '$pingid'");
			if(!empty($aid)){
					$ping_config = array();
					$ping_config['bbsname'] = $_G['setting']['bbname'];
					$ping_config['siteurl'] = $_G['siteurl'];
					$ping_config['threadurl'] = $_G['siteurl'].(@in_array('portal_article', $_G['setting']['rewritestatus']) ? rewriteoutput('portal_article', 1, '', $aid, 1, '', '') : 'portal.php?mod=view&aid='.$aid);
					$ping_config['rssurl'] = '';
					
					$data = array();
					if($type == 'baidu'){
							$ping_config['type'] = 'baidu';
							$ping_config['pingurl'] = 'http://ping.baidu.com/ping/RPC2';
							$res = superping_ping($ping_config);
							if(strpos($res, '<int>0</int>')){
								$data['baidu'] = 1;
								$return = '<font color="green"><b>&#x91CD;ping&#x6210;&#x529F;</b></font>';
							}else{
								$data['baidu'] = 2;
								$return = '<font color="red"><b>&#x91CD;ping&#x5931;&#x8D25;</b></font>';
							}
					}elseif($type == 'google'){
							$ping_config['type'] = 'google';
							$ping_config['pingurl'] = 'http://blogsearch.google.com/ping/RPC2';
							$res = superping_ping($ping_config);
							if(strpos($res, '<boolean>0</boolean>')){
								$data['google'] = 1;
								$return = '<font color="green"><b>&#x91CD;ping&#x6210;&#x529F;</b></font>';
							}else{
								$data['google'] = 2;
								$return = '<font color="red"><b>&#x91CD;ping&#x5931;&#x8D25;</b></font>';
							}
					}
					if(in_array($type, array('baidu','google'))){
							$data['threadurl'] = daddslashes($ping_config['threadurl']);
							$data['dateline'] = $_G['timestamp'];
							DB::update('study_seo_ping_article', $data, "tid='$tid'");
					}else{
							$return = '&#x53C2;&#x6570;&#x9519;&#x8BEF;';
					}
			}else{
				$return = '&#x53C2;&#x6570;&#x9519;&#x8BEF;';
			}
			echo "<a href=\"javascript:;\" onclick=\"s_seo_ping('".$pingid."','".$type."');return false\" title=\"&#x70B9;&#x51FB;&#x91CD;&#x65B0;PING\">".$return."</a>";
			
			ajaxshowfooter();
	}
}else{
	if(!$_GET['type']){
			showtableheader();
			$where = '';
			if($_GET['status'] == '1'){
				$where = " WHERE baidu = '1' AND google = '1' ";
			}elseif($_GET['status'] == '2'){
				$where = " WHERE baidu = '2' OR google = '2' ";
			}elseif($_GET['status'] == '1314'){
				$where = " WHERE baidu = '0' OR google = '0' ";
			}
			
			$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('study_seo_ping')." $where");
			$page = intval($_G['page']);
			$limit = '10';
			$max = 1000;
			$page = ($page-1 > $num/$limit || $page > $max) ? 1 : $page;
			$start_limit = ($page - 1) * $limit;
			$multipage = multi($num, $limit, $page, ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=study_seo_ping&pmod=pinglog', $max);
			
			$status_array = array('0'=>'<font color="blue">&#x672A;PING</font>','1'=>'<font color="green"><b>&#x6210;&#x529F;</b></font>','2'=>'<font color="red"><b>&#x5931;&#x8D25;</b></font>');
			$query = DB::query("SELECT * FROM ".DB::table('study_seo_ping')." $where ORDER BY id DESC limit $start_limit,$limit");
			$echo = '';
			while($ping = DB::fetch($query)) {
			
				$echo .= '<tbody><tr>
				<td><a href="'.$ping['threadurl'].'" target="_blank">'.$ping['threadurl'].'</a></td>
				<td id="pingbaidu'.$ping['id'].'"><a href="javascript:;" onclick="s_seo_ping(\''.$ping['id'].'\',\'baidu\');return false" title="&#x70B9;&#x51FB;&#x91CD;&#x65B0;PING">'.$status_array[$ping['baidu']].'</a></td>
				<td id="pinggoogle'.$ping['id'].'"><a href="javascript:;" onclick="s_seo_ping(\''.$ping['id'].'\',\'google\');return false" title="&#x70B9;&#x51FB;&#x91CD;&#x65B0;PING">'.$status_array[$ping['google']].'</a></td>
				<td><a href="javascript:;" onclick="s_seo_ping(\''.$ping['id'].'\',\'baidu\');s_seo_ping(\''.$ping['id'].'\',\'google\');return false" title="&#x70B9;&#x51FB;&#x91CD;&#x65B0;PING">&#x5168;&#x90E8;&#x91CD;PING</a></td>
				<td>'.dgmdate($ping['dateline'], 'u').'</td>
				</tr>
				</tbody>';
			}
			if(empty($echo)){
					echo '<td colspan="6" align="center" style="color:red;font-size:25px"><b>&#x6CA1;&#x6709;&#x8BB0;&#x5F55;</b></td>';
			}else{
					showsubtitle(array('&#x5E16;&#x5B50;URL','&#x767E;&#x5EA6;','&#x8C37;&#x6B4C;', '', '&#x65F6;&#x95F4;'));
					echo $echo;
			}
			in_array($_GET['status'], array('1','2','1314')) ? $status[$_GET['status']] = ' class="current" ' : '';
			echo '<tr>
			<td align="left">
			<div class="study_tab_mid">
				<ul class="tab1">
					<li '.( !in_array($_GET['status'], array('1','2','1314')) ? ' class="current" ' : '' ).'>
					<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=study_seo_ping&pmod=pinglog"><span>&#x5168;&#x90E8;</span></a>
					</li>
					<li '.$status[1].'>
					<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=study_seo_ping&pmod=pinglog&status=1"><span>&#x6210;&#x529F;</span></a>
					</li>
					<li '.$status[2].'>
					<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=study_seo_ping&pmod=pinglog&status=2"><span>&#x5931;&#x8D25;</span></a>
					</li>
					<li '.$status[1314].'>
					<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=study_seo_ping&pmod=pinglog&status=1314"><span>&#x672A;PING</span></a>
					</li>
				</ul>
			</div>
			</td>
			<td colspan="4" align="right">
				'.$multipage.'
			</td>
			</tr>';
			showtablefooter();
			echo "
			<script type=\"text/JavaScript\">
			function s_seo_ping(pingid,type){
			ajaxget('".ADMINSCRIPT."?action=".STUDY_MANAGE_URL."&formhash=".$_G['formhash']."&type=' + type + '&pingid=' + pingid, 'ping' + type + pingid, 'ping' + type + pingid,'loading');
			}
			</script>";
	}elseif($_GET['formhash'] && $_GET['formhash'] == $_G['formhash']){
			ajaxshowheader();
			$type = $_GET['type'];
			$pingid = intval($_GET['pingid']);
			$tid = DB::result_first("SELECT tid FROM " . DB::table('study_seo_ping') . " WHERE id = '$pingid'");
			if(!empty($tid)){
					$ping_config = array();
					$ping_config['bbsname'] = $_G['setting']['bbname'];
					$ping_config['siteurl'] = $_G['siteurl'];
					$ping_config['threadurl'] = $_G['siteurl'].(@in_array('forum_viewthread', $_G['setting']['rewritestatus']) ? rewriteoutput('forum_viewthread', 1, '', $tid, 1, '', '') : 'forum.php?mod=viewthread&tid='.$tid);
					$ping_config['rssurl'] = $_G['siteurl'].'forum.php?mod=rss&fid='.$fid;
					
					$data = array();
					if($type == 'baidu'){
							$ping_config['type'] = 'baidu';
							$ping_config['pingurl'] = 'http://ping.baidu.com/ping/RPC2';
							$res = superping_ping($ping_config);
							if(strpos($res, '<int>0</int>')){
								$data['baidu'] = 1;
								$return = '<font color="green"><b>&#x91CD;ping&#x6210;&#x529F;</b></font>';
							}else{
								$data['baidu'] = 2;
								$return = '<font color="red"><b>&#x91CD;ping&#x5931;&#x8D25;</b></font>';
							}
					}elseif($type == 'google'){
							$ping_config['type'] = 'google';
							$ping_config['pingurl'] = 'http://blogsearch.google.com/ping/RPC2';
							$res = superping_ping($ping_config);
							if(strpos($res, '<boolean>0</boolean>')){
								$data['google'] = 1;
								$return = '<font color="green"><b>&#x91CD;ping&#x6210;&#x529F;</b></font>';
							}else{
								$data['google'] = 2;
								$return = '<font color="red"><b>&#x91CD;ping&#x5931;&#x8D25;</b></font>';
							}
					}
					if(in_array($type, array('baidu','google'))){
							$data['threadurl'] = daddslashes($ping_config['threadurl']);
							$data['dateline'] = $_G['timestamp'];
							DB::update('study_seo_ping', $data, "tid='$tid'");
					}else{
						$return = '&#x53C2;&#x6570;&#x9519;&#x8BEF;';
					}
			}else{
				$return = '&#x53C2;&#x6570;&#x9519;&#x8BEF;';
			}
			echo "<a href=\"javascript:;\" onclick=\"s_seo_ping('".$pingid."','".$type."');return false\" title=\"&#x70B9;&#x51FB;&#x91CD;&#x65B0;PING\">".$return."</a>";
			
			ajaxshowfooter();
	}
}

?>
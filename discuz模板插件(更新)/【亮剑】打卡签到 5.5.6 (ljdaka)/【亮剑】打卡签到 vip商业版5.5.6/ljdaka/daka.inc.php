<?php

/*
 * CopyRight  : [www.moqu8.com!] (C)2014-2015
 * Document   : 魔趣吧：www.moqu8.com
 * Created on : 2015-01-17,21:45:40
 * Author     : 魔趣吧(QQ：10373458)  $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              魔趣吧出品 必属精品。
 *              魔趣吧源码论坛 全网首发 http://www.moqu8.com；
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
$action = $_GET['action'];
$config = $_G['cache']['plugin']['ljdaka'];


if(!in_array($_G['groupid'], unserialize($config['lj_groups']))) {
	showmessage($config['tsy']);
}
$ks = $config['s_time'];
$js = $config['e_time'];
$h = intval(gmdate('H',TIMESTAMP+8*3600));
$time_tsy=str_replace('{end}',$js.':59',str_replace('{start}',$ks.':00',$config['time_tsy']));
if (!($h >= $ks && $h <= $js)) {//10  1 3  10<1 
	showmessage($time_tsy);
}
if ($action == 'msg') {

    if ($_GET['formhash'] == formhash()) {
        require_once 'source/plugin/ljdaka/function/function_core.php';
        $uid = $_G['uid'];
        if (!$uid) {
            echo"<script language='JavaScript'> ";
            echo"parent.window.showWindow('login','member.php?mod=logging&action=login');";
            echo"</script>";
            exit;
        }
        $username = $_G['username'];

        $dizhi = $config['dizhi'];
        $url = $config['url'];
        $wenzi = $config['wenzi'];
        $checksql = C :: t('#ljdaka#plugin_daka')->fetch_by_tables();
        if ($checksql) {
            $check = C :: t('#ljdaka#plugin_daka')->fetch_by_uid($uid);
            if (!$check) {
                $timestamp = $_G['timestamp'];
                $jljifen = $config['jljifen'];
                $zhouqi = $config['zhouqi'];
                $beishu = $config['beishu'];
                $mytime = $timestamp - 86400;
                $mytime = gmdate('Y-m-d', $mytime + 3600 * 8);
                $alldays = C :: t('#ljdaka#plugin_daka')->fetch_by_uid_yesterday($uid, $mytime);
                $countday = intval($alldays + 1);
                if (!$alldays || ($alldays >= $zhouqi && $zhouqi)) {
                    $alldays = 0;
                }
                $jljifen1 = ($alldays + 1) * $beishu + rand($config['sjljifen'],$jljifen);
				if($jljifen1>$config['bigmoney']&&$config['bigmoney']){
					$jljifen1=$config['bigmoney'];
				}
                $money = intval($jljifen1);
                $creditname = $_G['setting']['extcredits'][$config['leixing']]['title'];
                $jljifen2 = $jljifen1 . $creditname;
				
                $leixing = 'extcredits' . $config['leixing'];
				
                updatemembercount($uid, array($leixing => $jljifen1));
                $myall = $alldays + 1;
                $mall = ($myall + 1) * $beishu + $jljifen;
                $small = ($myall + 1) * $beishu + $config['sjljifen'];
				if($mall>$config['bigmoney']&&$config['bigmoney']){
					$mall=$config['bigmoney'];
					$biglang=lang('plugin/ljdaka', 'daka46');
				}
                $mall .= $creditname;
                $record = array('uid' => $uid, 'timestamp' => $timestamp, 'jinbi' => $jljifen1, 'alldays' => $myall);
				$check = C :: t('#ljdaka#plugin_daka')->fetch_by_uid($uid);
				$todaytimestamp = strtotime(gmdate('Y-m-d 00:00:00',TIMESTAMP+3600*8));
				$check_user = DB :: result_first('select count(*) from %t where uid=%d and timestamp>=%d',array('plugin_daka_user',$uid,$todaytimestamp));
				if($check || $check_user){
					showmessage(lang('plugin/ljdaka', 'daka3'));
				}
                DB :: insert('plugin_daka', $record);
                if (!C :: t('#ljdaka#plugin_daka_user')->fetch_by_uid($uid)) {
                    DB :: insert('plugin_daka_user', array('uid' => $_G['uid'],
                        'username' => $_G['username'],
                        'timestamp' => $_G['timestamp'],
                        'money' => $money,
                        'allday' => $countday,
                        'day' => $myall,
                        'fen' => $mall,
                            ), true);
                } else {
                    C :: t('#ljdaka#plugin_daka_user')->update_by_uid($uid, $money, $myall, $mall, $_G['timestamp']);
                }
                $message = lang('plugin/ljdaka', 'daka19');
                if ($_GET['mobile'] == 1 || $_GET['mobile'] == 2 || $_GET['mobile'] == 'yes') {
                    $message = str_replace('{con1}', lang('plugin/ljdaka', 'daka44'), $message);
                    $message = str_replace('{con3}', lang('plugin/ljdaka', 'daka45'), $message);
                } else {
                    $message = str_replace('{con1}', $_GET['cont1'], $message);
                    $message = str_replace('{con3}', $_GET['cont2'], $message);
                }
				if($config['is_thread']){
					if (!C :: t('#ljdaka#plugin_daka_thread')->fetch_by_dateline()) {
						$fid = $config['fid'];
						if (!$fid) {
							showmessage(lang('plugin/ljdaka', 'daka22'));
						}
						$subject = gmdate(lang('plugin/ljdaka', 'time'),TIMESTAMP+8*3600);
						if ($fid) {
							$desc = lang('plugin/ljdaka', 'daka20');
							$message = str_replace('{desc}', $desc, $message);
							$tid = generatethread($subject, $message, $_G['clientip'], $_G['uid'], '', $fid);
							$daytime = gmdate('Ymd',TIMESTAMP+8*3600);
							DB :: insert('plugin_daka_thread', array('tid' => $tid, 'dateline' => $daytime));
							$rid = 1;
						}
					} else {
						$subject = gmdate(lang('plugin/ljdaka', 'time'),TIMESTAMP+8*3600);
						$desc = lang('plugin/ljdaka', 'daka6') . "$myall" . lang('plugin/ljdaka', 'daka7') . lang('plugin/ljdaka', 'daka10') . $jljifen2 . ',' . lang('plugin/ljdaka', 'daka8') . $mall;
						$message = str_replace('{desc}', $desc, $message);
						$tid = C :: t('#ljdaka#plugin_daka_thread')->fetch_tid_by_dateline();
						if ($tid) {
							generatepost($message, $_G['uid'], $tid, '', '', $subject,$_G['clientip']);
							$rid = 1;
						}
					}
				}
            }
			$settingfile = DISCUZ_ROOT . './data/sysdata/cache_ljdaka_setting.php';
			if(file_exists($settingfile)){
				include $settingfile;
			}
			$wcache['time_y'] = '';
			$wcache['time']='';
			require_once libfile('function/cache');
			writetocache('ljdaka_setting', getcachevars(array('wcache' => $wcache))); //将管理中心配置项写入缓存
            if($news['msgtype'] == 'sign'){
				if($check){
					echo $this->responsetext($postObj, lang('plugin/ljdaka','aljwsq_1'));
				}else{
					echo $this->responsetext($postObj, lang('plugin/ljdaka','aljwsq_2').$myall.lang('plugin/ljdaka','aljwsq_3').$jljifen2.lang('plugin/ljdaka','aljwsq_4').$mall);
				}
			} else if($_GET['newmobile'] == 1){
				if($check){
					echo lang('plugin/ljdaka','aljwsq_1');
				}else{
					echo lang('plugin/ljdaka', 'm1').$jljifen2;
				}
			}else if ($_GET['mobile'] == 1 || $_GET['mobile'] == 2 || $_GET['mobile'] == 'yes') {
                include template('ljdaka:msg');
            } else {

                echo"<script language='JavaScript'> ";
                echo"parent.window.showWindow('tips','plugin.php?id=ljdaka:daka&action=tips&formhash=" . FORMHASH . "&rid=$rid&small=$small&money=$money');";
                echo"</script>";
            }
        }
    } else {
        showmessage(lang('plugin/ljdaka', 'daka23'), $_G['siteurl']);
    }
} else if ($_GET['action'] == 'tips') {
    if ($_GET['formhash'] != formhash() || !submitcheck('action', 1) || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) != preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])) {
        debug('Access Denied!');
    }
    $web_root = $_G ['siteurl'];
    if (substr($web_root, -1) != '/') {
        $web_root = $web_root . '/';
    }
    if ($_GET['rid']) {
        $rdata = C :: t('#ljdaka#plugin_daka_user')->fetch($_G['uid']);
        $myall = $rdata['day'];
        $mall = $rdata['fen'];
        $small = $_GET['small'];
    }
    $uid = $_G['uid'];
    if (!$uid) {
        showmessage(lang('plugin/ljdaka', 'daka18'));
    }
    $username = $_G['username'];
    $config = $_G['cache']['plugin']['ljdaka'];
    $dizhi = $config['dizhi'];
    $url = $config['url'];
    $wenzi = $config['wenzi'];
    $checksql = C :: t('#ljdaka#plugin_daka')->fetch_by_tables();
    if ($checksql) {

        if (empty($_GET['rid'])) {
            $check = C :: t('#ljdaka#plugin_daka')->fetch_by_uid($uid);
        }
        if (!$check) {
            $timestamp = $_G['timestamp'];
            $jljifen = $config['jljifen'];
            $zhouqi = $config['zhouqi'];
            $beishu = $config['beishu'];
            $mytime = $timestamp - 86400;
            $mytime = gmdate('Y-m-d', $mytime + 3600 * 8);
           // $alldays = C :: t('#ljdaka#plugin_daka')->fetch_by_uid_yesterday($uid, $mytime);
           // $countday = intval($alldays + 1);
           // if (!$alldays || ($alldays >= $zhouqi && $zhouqi)) {
            //    $alldays = 0;
            //}
           // $jljifen1 = ($alldays + 1) * $beishu + rand($config['sjljifen'],$jljifen);
            $jljifen1 = $_GET['money'];
			if($jljifen1>$config['bigmoney']&&$config['bigmoney']){
				$jljifen1=$config['bigmoney'];
				$biglang=lang('plugin/ljdaka', 'daka46');
			}
            $money = intval($jljifen1);
            $creditname = $_G['setting']['extcredits'][$config['leixing']]['title'];
            $jljifen2 = $jljifen1 . $creditname;
        }
    }
    //debug($_SERVER[HTTP_REFERER]);
    include template('ljdaka:msg');
} else if ($_GET['action'] == 'showWindow') {
    if ($_GET['formhash'] != formhash() || !submitcheck('action', 1) || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) != preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])) {
        debug('Access Denied!');
    }
    $config = $_G['cache']['plugin']['ljdaka'];
    $r1 = explode("\n", str_replace("\r", "", $config['bq']));
    foreach ($r1 as $k => $v) {
        $tmp = explode('|', $v);
        $ra1[$tmp[0]]['id'] = $tmp[0];
        $ra1[$tmp[0]]['name'] = $tmp[1];
        $ra1[$tmp[0]]['desc'] = $tmp[2];
        $ra1[$tmp[0]]['img'] = $tmp[3];
    }
	
    foreach ($ra1 as $key => $val) {
        $arr1[$val['id']] = $val['name'];
        $arr2[$val['id']] = $val['desc'];
        $arr3[$val['id']] = $val['img'];
    }
    $a1 = dimplode($arr1);
    $a1first = current($arr1);
    $a2 = dimplode($arr2);
	
	include template('ljdaka:showWindow');
}
?>
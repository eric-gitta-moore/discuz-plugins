<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
include_once  DISCUZ_ROOT . "source/function/function_discuzcode.php";
include_once  DISCUZ_ROOT . "source/class/class_bbcode.php"; 

function L($key=0){
	extract($GLOBALS);
	$L = include 'language/language.'.$_G['charset'].'.php';
	return $L[$key];
}



function checkPaper(&$paper, $uid)
{
	global $_G, $config;
	if(empty($paper)){
		return 'nopaper';
	}

	if($paper['uid']==$uid || $_G['groupid']==1){//自己 | 管理员
		return true;
	}

	if($paper['public']==0) //未发布
		return 'unpublic';
	if($paper['status']==2) //锁定
		return 'lock';

 	if($paper['starttime']>0 && $_SERVER['REQUEST_TIME'] < $paper['starttime']){ //开始时间
		return 'starttime';
	}
 	if($paper['endtime']>0 && $_SERVER['REQUEST_TIME'] > $paper['endtime']){ //过期
		return 'endtime';
	}

	if($uid)
	{
		if($paper['fgid'] && $paper['fgid']!=DB::result_first("select gid from %t where `fuid`='$uid' AND `uid`='%i'",array('home_friend', $paper['uid']))) //朋友组
			return 'friend_group';
		if($paper['twice'] && ($twiced = C::t('#exam#tiny_exam3_log')->value('count(*)', $uid, $paper['pid'])) > $paper['twice']) //次数权限: 该试卷最多只能参与 $paper[twice] 次, 您已超限, 请联系试卷作者!
			return 'twice';

		if($paper['delay']>0){//间隔延时权限
			$lock_time = $paper['delay'] * 60 + C::t('#exam#tiny_exam3_log')->value('endtime', $uid, $paper['pid']) - $_SERVER['REQUEST_TIME'];

			if($lock_time > 0){
				$paper['lock_time'] = $lock_time;
				return 'delay';
			}
		}
	}

	if($paper['readgroup'] && !in_array($_G['groupid'], $paper['readgroup'])){		
		return 'readgroup';
	}
	if($paper['pwd']!=='' && $paper['pwd']!==$_REQUEST['pwd']){
		return 'pwd';
	}
	if(!(empty($config['groupuse']) || in_array($_G['groupid'], $config['groupuse']))){//使用组
		return 'groupuse';
	}
	if(in_array($_G['groupid'], $config['groupfree'])){//免费组
		return true;
	}
	else if(!($cpf = checkPayfor($paper['pid'], $uid, $paper['price']))){//出售
		return $cpf===false ? 'unlogin' : 'exppay';
	}
 
	return true; 
}

function checkPayfor($pid, $uid, $price)
{
	if($price==0) return true;
	if($uid==0) return false;
	$paylog = DB::fetch_first('select * from '. DB::table('tiny_exam3_buy'). " where `pid`='$pid' AND `uid`='$uid'");
	if(isset($paylog['time']) && $paylog['time']==0) return true;
	return $_SERVER['REQUEST_TIME'] < $paylog['time'] ? $paylog['time'] - $_SERVER['REQUEST_TIME'] : 0;
}
 
function payfor($pid, $uid, $price, $long)
{
	if(checkPayfor($pid, $uid, $price))return true;

	global $config; $creditfield = $config['extcredit']['field'];
	if(!$creditfield) return 'creditfield';

	$creditHave = DB::result_first("SELECT `$creditfield` FROM " .DB::table('common_member_count'). " WHERE uid='$uid'");
	if($creditHave < $price){
		return 'lowcredit';
	}	

	$post = array(
		'uid'   => $uid, 
		'pid'   => $pid,
		'time'  => $long>0 ? $_SERVER['REQUEST_TIME'] + $long : 0,
	);
 
	
	if($bid = DB::result_first('select `bid` from '. DB::table('tiny_exam3_buy'). " where `pid`='$pid' AND `uid`='$uid'")){
		$bid = DB::update('tiny_exam3_buy', $post, "`pid`='$pid' AND `uid`='$uid'");
	}
	else{
		$bid = DB::insert('tiny_exam3_buy', $post, true);
	}

	if($bid && (DB::query("UPDATE ".DB::table('common_member_count')." SET $creditfield=$creditfield-'$price' WHERE uid='$uid'"))){
		$author = DB::result_first("select `uid` from %t where `pid`='%d'", array('tiny_exam3_paper', $pid));
		DB::query("UPDATE ".DB::table('common_member_count')." SET $creditfield=$creditfield+'$price' WHERE uid='$author'");
		return true;
	}

 	return false;
}

function update_sysnav()  
{
	$parentid = DB::result_first("select `id` from %t where `url` like '%iplugin.php?id=exam'", array('common_nav', '%'));

	$mynav = array(
		array('&#x6211;&#x53C2;&#x4E0E;&#x7684;&#x8003;&#x8BD5;', 'plugin.php?id=exam:my&tab=logs'),	
		array('&#x6211;&#x7684;&#x9519;&#x9898;', 'plugin.php?id=exam:my&tab=wrong'),
		array('&#x624B; &#x673A; &#x7248;', 'plugin.php?id=exam:m'),
		array('&#x6211;&#x53D1;&#x5E03;&#x7684;&#x8BD5;&#x5377;', 'plugin.php?id=exam:my&tab=list'),	
	);
 
	$nlist = DB::fetch_all("select `url` from %t where `parentid`='$parentid'", array('common_nav'), 'url');
	
	$bAdd = false;
	
	foreach($mynav AS $k => $v){
		if(!isset( $nlist[$v[1]] )){
			$post = array(
				'parentid'		=> $parentid,
				'type'			=> 1,
				'available'		=> 1,
				'displayorder'	=> $k,
				'url' 			=> $v[1],
				'name' 			=> $v[0]
			);
 
			DB::insert('common_nav', $post);
			$bAdd = true;
		}
	}
	if($bAdd){
		include_once  DISCUZ_ROOT . "source/function/function_cache.php";
		updatecache('setting');
	}
}

function dzcode($message)
{
	$message = discuzcode($message, 0, 0, $htmlon = 1, $allowsmilies = 1, $allowbbcode = 1, $allowimgcode = 1, $allowhtml = 1, $jammer = 0, $parsetype = '0', $authorid = '0', $allowmediacode = '1');
 
	$message = str_replace("\n","<br>",$message);
 
 	return $message;
}
 
function strcut($str, $from, $to='',$start=0)  
{
    if(empty($from))return '';
    $lenFrom=strlen($from);
    $nStart = strpos($str,$from);
    if ($nStart===false) return '';
    if ($to=='') { return substr($str,$nStart+$lenFrom);}  
    $nEnd   = strpos($str,$to,$nStart+$lenFrom);
    if ($nEnd===false)  return '';
    return substr($str,$nStart+$lenFrom,$nEnd-$nStart-$lenFrom);
}  

function push_to_share($pid, $subject, $score, $total, $passing, $minute){
	$share_data=array(
	'link' => "<a href=\"plugin.php?id=exam&p=$pid\" target=\"_blank\">$subject ( &#x603B;&#x5206;: $total &#x5206;, &#x53CA;&#x683C;: $passing  &#x5206;, &#x65F6;&#x95F4;: $minute &#x5206;&#x949F; )</a>",
	'data' => "plugin.php?id=exam&p=$pid",
	);
	$share=array(
		'icon'			=> 'wall',
		'uid'			=> $result['uid'],
		'username'		=> $result['username'],
		'dateline'		=> $_SERVER['REQUEST_TIME'],
		'title_template'=> "{actor} &#x5B8C;&#x6210;&#x4E86; \"$subject\" &#x7684;&#x8003;&#x8BD5;, &#x83B7;&#x5F97;&#x4E86; <span style=\"color:red\">$score</span> &#x5206;&#x6210;&#x7EE9;",
		'title_data'	=> '',
		'body_template'	=> '{link}',
		'body_data'		=> serialize($share_data),
		'body_general'	=> '',
		'target_ids'	=> '',
	);
	DB::insert('home_feed', $share);
}

function push_exam_to_form($eid){
	global $config, $_G;
	if($config['showscore']){
		$wuid = $_G['adminid']==1 ? "" : "AND `uid`='".$_G['uid']."'";
		if($config['push_exam_fid']>0 && ($e = DB::fetch_first('select `tid`,`subject` from '.DB::table('tiny_exam3_exam')." where `eid`='$eid' $wuid"))){
			$inserttid = push_to_form($config['push_exam_fid'], $e['subject'], "[exam=$eid]", $_G['uid'], $_G['username'], $e['tid']);
			$inserttid && DB::query("update ".DB::table('tiny_exam3_exam')." SET `tid`='$inserttid' where eid='$eid' $wuid");
		}
	}
}

//将帖子同步发布到论坛
function push_to_form($fid, $subject, $message, $authorid, $author, $tid){
		$fid = intval($fid);
 
		if($fid==0 || empty($subject) || empty($message) || $authorid==0 || empty($author) || !DB::result_first("SELECT count(*) FROM ".DB::table('forum_forum') ." WHERE fid='$fid'")){
			return false;
		}
 
		$subject = preg_replace("/\{#.+?#\}/is", '____', strip_tags($subject));
 
		if($tid){
			$post=array(
				'subject' => $subject,
			);
			DB::update('forum_thread', $post, "tid='$tid'");
			DB::update('forum_post',   $post, "tid='$tid'");
			return $tid;
		}

        $thread   = array(
            'fid'        => $fid,
            'author'     => $author,				
            'authorid'   => $authorid,			
            'subject'    => cutstr($subject,80,''),
            'dateline'   => $_SERVER['REQUEST_TIME'],
            'lastpost'   => $_SERVER['REQUEST_TIME'],
            'lastposter' => $author,
        );
		$tid =  DB::insert('forum_thread', $thread, true);

		$pid = DB::result_first("SELECT max(pid) FROM ".DB::table('forum_post'));//dz2.5新增加的：1
        $post=array(
            'pid'      => $pid+1,	//dz2.5新增加的：2
            'fid'      => $fid,
            'tid'      => $tid,
            'first'    => "1",
            'author'   => $thread['author'],
            'authorid' => $thread['authorid'],			
            'subject'  => $thread['subject'],
            'dateline' => $thread['dateline'],
            'message'  => $message,
        );
        DB::insert('forum_post', $post);
        DB::query("UPDATE %t SET tid='$tid ' where eid='$tid '", array('tiny_exam3_exam'));
        DB::insert('forum_post_tableid', array('pid'=>mysql_insert_id()) );
        DB::query("UPDATE %t SET threads=threads+1,posts=posts+1,todayposts=todayposts+1 WHERE fid='$fid'", array('forum_forum'));
        return $tid ;

}
function array2json($arr) {
    //if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality. 
    if(!is_array($arr)){
        return '[]';
    }

    $parts = array(); 
    $is_list = false; 
 
    //Find out if the given array is a numerical array 
    $keys = array_keys($arr); 
    $max_length = count($arr)-1; 
    if(isset($keys[0]) && ($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1 
        $is_list = true; 
        for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position 
            if($i != $keys[$i]) { //A key fails at position check. 
                $is_list = false; //It is an associative array. 
                break; 
            } 
        } 
    } 

    foreach($arr as $key=>$value) { 
        if(is_array($value)) { //Custom handling for arrays 
            if($is_list) $parts[] = array2json($value); /*
 *源码哥：www.ymg6.com
 *更多商业插件/模版免费下载 就在源码哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */ 
            else $parts[] = '"' . $key . '":' . array2json($value); /*
 *源码哥：www.ymg6.com
 *更多商业插件/模版免费下载 就在源码哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */ 
        } else { 
            $str = ''; 
            if(!$is_list) $str = '"' . $key . '":'; 

            //Custom handling for multiple data types 
            if(is_numeric($value))   $str .= '"'.$value.'"'; //Numbers 
            elseif($value === false) $str .= "false"; //The booleans 
            elseif($value === true)  $str .= "true"; 
            else  $str .= ('"' . str_replace(array("\"","\r","\n","\t","\a","\b","\f","\v","\0"), array("\\\"","\\r","\\n","\\t","","","","",""), $value) . '"'); //All other things  : "\\" , "\\\\"

            $parts[] = $str; 
        } 
    } 
    $json = implode(',',$parts); 
     
    if($is_list) return '[' . $json . ']';//Return numerical JSON 
    return '{' . $json . '}';//Return associative JSON 
}

function gettree($data, $pid=0, $k_id='id', $k_pid='pid', $k_child='child'){
	$tree = array();
	foreach($data as $k => $v){
		if($v[$k_pid] == $pid){
			$sub = gettree($data, $v[$k_id], $k_id, $k_pid);
			if(!empty($sub)){
				$v[$k_child] = $sub;
			}
			$tree[ $v[$k_id] ] = $v;
		}
	}
	return $tree;
}

function mysql_implode($array, $allowEmpty = false){
	$sql = $comma = '';
	foreach($array as $v) {
		if($v==='' && $allowEmpty==false)continue;
		$sql .= $comma."'".(is_numeric($v) ? $v : addslashes($v))."'";
		$comma = ',';
	}
	return $sql;
}

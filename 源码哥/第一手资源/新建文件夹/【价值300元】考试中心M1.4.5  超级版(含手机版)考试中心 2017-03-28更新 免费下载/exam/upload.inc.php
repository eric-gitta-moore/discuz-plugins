<?php
/*
 *源码哥：www.ymg6.com
 *更多商业插件/模版免费下载 就在源码哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}




$uproot = DISCUZ_ROOT . $_G['setting']['attachurl'] .'exam/';

if(isset($_GET['src']) && !empty($_GET['src'])){//删除
		if($_GET['formhash'] != formhash()){
			die('ERROR SUBMIT!');
		}
 
		$src = strtolower($_GET['src']);
		$src = str_replace($_G['setting']['attachurl'] .'exam/', '', $src);
		DB::delete('tiny_exam3_upload',"src='$src'");
		@unlink($uproot.$src);
		include template('common/header_ajax');
		echo 1;
		include template('common/footer_ajax');
} else { //上传
	if(isset($_POST) && !submitcheck('formhash')){
		showmessage('ERROR SUBMIT!');
		exit;
	}
 
	header("Pragma: no-cache");  

	require_once 'tiny.common.inc.php';


	 
	$fileext = strtolower(end(explode('.', $_FILES['upload']['name'])));
	if(in_array($fileext, array('jpg','gif')))
	{
		$newname = date('ymdhi').random(6,1).'.'.$fileext;
		$cldDir  = date('ym').'/';
	 
		if(!file_exists($uproot.$cldDir)){
			if(!file_exists($uproot))mkdir($uproot);
			mkdir($uproot.$cldDir);
		}
		
		$path= $uproot.$cldDir.$newname;
		
		if($_FILES["upload"]["size"] && @move_uploaded_file(@$_FILES["upload"]["tmp_name"], $path))	{
			$post=array(
				'uid'     => $_G['uid'],
				'src'     => $cldDir.$newname,
				'uptime'  => $_SERVER['REQUEST_TIME'],
				'status'  => 0,
			);
			DB::insert('tiny_exam3_upload',$post);
		}
		include template('common/header_ajax');
		echo $_G['setting']['attachurl'].'exam/'.$cldDir.$newname;
		include template('common/footer_ajax');
	}
	else{
		include template('common/header_ajax');
		echo 'err';
		include template('common/footer_ajax');
		exit;
	}
}

?>
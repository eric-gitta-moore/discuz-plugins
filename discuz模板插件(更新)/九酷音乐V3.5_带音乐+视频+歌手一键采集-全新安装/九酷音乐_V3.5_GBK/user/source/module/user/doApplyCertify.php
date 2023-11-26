<?php
include "../source/global/global_inc.php";
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	//只接受post请求
	if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
		echo '{"status":1,"message":"您没有上传头像，无法进行认证！", "error":1}';
		exit;
	}
	$folder = _qianwei_root_."data/attachment/verified/".date('Y',time())."/".date('m',time())."/".date('d',time())."/";
	creatdir($folder);
	$filename = date('YmdHis').rand().'.jpg';
	$original = $folder.$filename;

	$input = file_get_contents('php://input');
	if(md5($input) == '7d4df9cc423720b7f1f3d672b89362be'){
		exit;
	}
	$result = file_put_contents($original, $input);
	if (!$result) {
		echo '{"error":1,"message":"文件目录不可写"}';
		exit;
	}
	$info = getimagesize($original);
	if($info['mime'] != 'image/jpeg'){
		unlink($original);
		exit;
	}
	$origImage = imagecreatefromjpeg($original);
	$newImage = imagecreatetruecolor(220,220);
	imagecopyresampled($newImage,$origImage,0,0,0,0,220,220,520,370);
	//imagejpeg($newImage,$original);
	$sql="update ".tname('user')." set cd_checkmm='2',cd_verified='".str_replace(_qianwei_root_.'data/', 'data/', $original)."' where cd_id='$qianwei_in_userid'";
	if($db->query($sql)){
		echo '{"status":1,"message":"Success!","filePath":"'.$original.'"}';
	}else{
		echo '{"status":1,"message":"您没有上传头像，无法进行认证！", "error":1}';
	}
}else{
	echo '{"status":1,"message":"您还没有登录本站，无法进行认证！", "error":1}';
	exit;
}
?>
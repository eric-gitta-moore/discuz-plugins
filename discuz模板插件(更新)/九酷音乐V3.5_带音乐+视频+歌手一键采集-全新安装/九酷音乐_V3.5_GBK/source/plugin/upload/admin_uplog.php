<?php
include "../../global/global_conn.php";
$is=SafeRequest("is","get");
$id=SafeRequest("id","get");
$action=SafeRequest("ac","get");
switch($action){
	case 'song':
		$filepath="../../../data/attachment/song/".$is."/";
		creatdir($filepath);
		$targetFiles=$filepath.$id.".".fileext($_FILES['Filedata']['name']).".jpg";
		$fileexts=cd_upext;
		$filetexts="��Ƶ�ļ�";
		break;
	case 'video':
		$filepath="../../../data/attachment/video/".$is."/";
		creatdir($filepath);
		$targetFiles=$filepath.$id.".".fileext($_FILES['Filedata']['name']).".jpg";
		$fileexts="*.flv;*.f4v;*.mp4";
		$filetexts="��Ƶ�ļ�";
		break;
	case 'lrc':
		$filepath="../../../data/attachment/lrc/".$is."/";
		creatdir($filepath);
		$targetFiles=$filepath.$id.".".fileext($_FILES['Filedata']['name']).".jpg";
		$fileexts="*.lrc";
		$filetexts="����ļ�";
		break;
	case 'pic':
		$filepath="../../../data/attachment/pic/".$is."/";
		creatdir($filepath);
		$targetFiles=$filepath.$id.".".fileext($_FILES['Filedata']['name']);
		$fileexts="*.jpg;*.jpeg;*.gif;*.png";
		$filetexts="ͼƬ�ļ�";
		break;
}
if(!empty($_FILES)){
	$tempFile=$_FILES['Filedata']['tmp_name'];
	$targetFile=$targetFiles;
	$fileTypes=str_replace('*.', '', $fileexts);
	$fileTypes=str_replace(';', '|', $fileTypes);
	$typesArray=preg_split('/\|/',$fileTypes);
	$fileParts=pathinfo($_FILES['Filedata']['name']);
	if(in_array($fileParts['extension'],$typesArray)){
		move_uploaded_file($tempFile,$targetFile);
		$setarrss = array(
			'cd_userid' => 0,
			'cd_username' => 'ϵͳ�û�',
			'cd_userip' => getonlineip(),
			'cd_filetype' => $filetexts,
			'cd_filename' => $id.".".fileext($_FILES['Filedata']['name']),
			'cd_filesize' => $_FILES["Filedata"]["size"],
			'cd_fileurl' => ReplaceStr($targetFile,"../../../",""),
			'cd_filetime' => time()
		);
		inserttable('upload', $setarrss, 1);
		echo '0';
	}else{
	 	echo 'Invalid file type.';
	}
}
?>
<?php
if (!empty($_FILES)) {
	error_reporting(0);
	require_once("../../../global/global_config.php");
	require_once("../sdk/bcs.class.php");
	$File = $_FILES['Filedata']['name'];
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetFile = "/".date('YmdHis',time()).rand(2,pow(2,24)).".".strtolower(trim(substr(strrchr($File, '.'), 1)));
	$opt=array(
	        "filename"=>$File,
	        "acl"=>"public-read"
	);
	$baiduBCS = new BaiduBCS();
	$response = $baiduBCS->create_object(BCS_BK, $targetFile, $tempFile, $opt);
	if (!$response->isOK()) {
	        die("Create object failed.");
	} else {
	        echo "http://bcs.duapp.com/".BCS_BK.$targetFile;
	}
}
?>
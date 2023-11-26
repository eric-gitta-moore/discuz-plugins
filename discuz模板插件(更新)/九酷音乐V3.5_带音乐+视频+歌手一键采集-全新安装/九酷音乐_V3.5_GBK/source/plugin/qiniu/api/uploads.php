<?php
if (!empty($_FILES)) {
	require_once("../../../global/global_config.php");
	require_once("../sdk/io.php");
	require_once("../sdk/rs.php");
	$bucket = cd_qiniubucket;
	$accessKey = cd_qiniukeyid;
	$secretKey = cd_qiniukeysecret;
	$File = $_FILES['Filedata']['name'];
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetFile = date('YmdHis',time()).rand(2,pow(2,24)).".".strtolower(trim(substr(strrchr($File, '.'), 1)));
	Qiniu_SetKeys($accessKey, $secretKey);
	$putPolicy = new Qiniu_RS_PutPolicy($bucket);
	$upToken = $putPolicy->Token(null);
	$putExtra = new Qiniu_PutExtra();
	$putExtra->Crc32 = 1;
	list($ret, $err) = Qiniu_PutFile($upToken, $targetFile, $tempFile, $putExtra);
	if ($err !== null) {
	        echo $err;
	} else {
	        echo "http://".$bucket.".qiniudn.com/".$targetFile;
	}
}
?>
<?php
	if(isset($_FILES["s3_file"]) && is_uploaded_file($_FILES["s3_file"]["tmp_name"]) && $_FILES["s3_file"]["error"] == 0) {
		require_once '../../../global/global_config.php';
		require_once 'conf.inc.php';
		require_once 'sdk.class.php';
		$oss_sdk_service = new ALIOSS();
		$bucket = OSS_BUCKET;
		$file_name = date('YmdHis',time()).rand(2,pow(2,24)).".".strtolower(trim(substr(strrchr($_FILES["s3_file"]["name"], '.'), 1)));
        $object = $file_name;
        $content = '';
        $length = 0;
        $fp = fopen($_FILES["s3_file"]["tmp_name"],'r');
        if($fp)
        {
            $f = fstat($fp);
            $length = $f['size'];
            while(!feof($fp))
            {
                $content .= fgets($fp);
            }
        }
        $upload_file_options = array('content' => $content, 'length' => $length);
		$upload_file_by_content = $oss_sdk_service->upload_file_by_content($bucket,$object, $upload_file_options);
		echo (URL_MODE==0) ? "http://".OSS_DLINK.$bucket."/".$file_name : DOWN_URL.$file_name;
	}
?>
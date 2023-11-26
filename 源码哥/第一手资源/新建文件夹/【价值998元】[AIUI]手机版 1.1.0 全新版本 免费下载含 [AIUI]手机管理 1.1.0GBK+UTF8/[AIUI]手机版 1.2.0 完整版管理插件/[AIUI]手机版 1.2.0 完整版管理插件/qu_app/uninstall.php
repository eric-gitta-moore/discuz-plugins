<?php
/*  V1.0
 *  FOR Discuz! X 
 *	ainuo design 
 *  QQÈº£º550494646
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) exit('Access Denied');

$sql = <<<EOF
DROP TABLE IF EXISTS  pre_qu_app;
DROP TABLE IF EXISTS  pre_qu_appnav;
DROP TABLE IF EXISTS  pre_qu_appquicknav;
EOF;

runquery($sql);

$dir = DISCUZ_ROOT."/data/sysdata/qu_app_cache"; 
$dir2 = DISCUZ_ROOT."/data/attachment/qu_app"; 
delDirAndFile($dir);
delDirAndFile($dir2);
function delDirAndFile( $dirName ){
	if($handle = opendir("$dirName")) {
	   while(false !== ($item = readdir($handle))){
		   if($item != "." && $item != ".."){
			   if (is_dir("$dirName/$item")){
				   delDirAndFile("$dirName/$item");
				   }else{
				   if( unlink("$dirName/$item"));
			   }
		   }
	   }
	   closedir($handle);
	   if(rmdir($dirName));
	}
}

$finish = TRUE;
?>
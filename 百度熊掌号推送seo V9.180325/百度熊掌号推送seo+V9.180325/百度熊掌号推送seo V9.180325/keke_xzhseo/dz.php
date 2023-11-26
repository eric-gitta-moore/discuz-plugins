<?php

global $_G;
if($_G['forum_option']){
	foreach($_G['forum_option'] as $ok=>$ov){
		if($ov['type']=='image'){
			//preg_match('/<img.+src=\"?(.+\.(jpg|gif|bmp|bnp|png))\"?.+>/i',$ov['value'],$matchs);  
			$picarrs[]=$ov['value'];//$matchs[1];
		}
	}
}
$m=1;
$mcount=count($picarrs)==2?1:3;
foreach($picarrs as $k=>$v){
	if($m>$mcount){break;}
	$picsa.='"'.$_G['siteurl'].$v.'",';
	$m++;
}

$piczh=substr($picsa,0,strlen($picsa)-1);

if($piczh){
	$piclist=$piczh;
}


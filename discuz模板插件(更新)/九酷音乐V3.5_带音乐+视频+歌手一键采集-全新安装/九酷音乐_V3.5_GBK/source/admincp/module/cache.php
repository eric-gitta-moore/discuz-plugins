<?php
Administrator(1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>���»���</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
	if(cd_iscache==1){
	        $d=_qianwei_root_.'./data/cache/';
	        if(is_dir($d)){
	  	        $dh=opendir($d);
 		        while (false !== ($file = readdir($dh))) {
   			        if($file!="." && $file!=".."){
      				        $fullpath=$d."/".$file;
      				        if(!is_dir($fullpath)){
         		 		        unlink($fullpath);
      				        }
   			        }
 		        }
   		        closedir($dh);
	        }
	        ShowMessage("��ϲ����������³ɹ���","history.back(1);","infotitle2",3000,2);
	}else{
	        ShowMessage("������ ȫ��->������Ϣ->�������� �������棡","?iframe=config&action=html","infotitle1",3000,1);
	}
?>
</body>
</html>
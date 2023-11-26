<?php
Administrator(1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>安装应用</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function $(obj) {return document.getElementById(obj);}
var filesize=0;
function setsize(fsize){
        filesize=fsize;
}
function setdown(dlen){
        if(filesize>0){
                var percent=Math.round(dlen*100/filesize);
                document.getElementById("progressbar").style.width=(percent+"%");
                if(percent>0){
                        document.getElementById("progressbar").innerHTML=percent+"%";
                        document.getElementById("progressText").innerHTML="";
                }else{
                        document.getElementById("progressText").innerHTML=percent+"%";
                }
                if(percent>99){
                        document.getElementById("progressbar").innerHTML="请稍等...";
                        window.setTimeout("location.href='<?php echo "?".str_replace("&step","&unzip",$_SERVER['QUERY_STRING']); ?>';", 1000);
                }
        }
}
</script>
</head>
<body>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 安装应用';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='安装应用';</script>
<div class="floattop"><div class="itemtitle"><h3>安装应用</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<li>安装应用时请勿离开当前页面，务必等待浏览器自动跳转完成</li>
</ul></td></tr>
</table>
<h3>QianWei Music 提示</h3>
<?php
switch(SafeRequest("step","get")){
	case 's':
		down_zip(base64_decode($_GET['zip']));
		break;
	case 'p':
		down_zip(base64_decode($_GET['zip']));
		break;
	case 'e':
		down_zip(base64_decode($_GET['zip']));
		break;
}
switch(SafeRequest("unzip","get")){
	case 's':
		un_zip('template');
		break;
	case 'p':
		un_zip('source/plugin');
		break;
	case 'e':
		un_zip(_qianwei_root_);
		break;
}
switch(SafeRequest("install","get")){
	case 's':
		install_ation(1);
		break;
	case 'p':
		install_ation(2);
		break;
	case 'e':
		install_ation(0);
		break;
}
?>
</div>
</body>
</html>
<?php
function down_zip($zip){
        echo "<div class=\"infobox\"><br />";
        echo "<table class=\"tb tb2\" style=\"border:1px solid #09C\">";
        echo "<tr><td><div id=\"progressbar\" style=\"float:left;width:1px;text-align:center;color:#FFFFFF;background-color:#09C\"></div><div id=\"progressText\" style=\"float:left\">0%</div></td></tr>";
        echo "</table>";
        echo "<br /></div>";
        ob_start();
        $file=fopen($zip,"rb");
        if($file){
                $headers=get_headers($zip,1);
                if(array_key_exists("Content-Length",$headers)){
                        $filesize=$headers["Content-Length"];
                }else{
                        $filesize=strlen(@file_get_contents($zip));
                }
                echo "<script type=\"text/javascript\">setsize(".$filesize.");</script>";
                $newf=fopen("data/backup/develop.zip","wb");
                $downlen=0;
                if($newf){
                        while(!feof($file)){
                                $data=fread($file,1024*8);
                                $downlen+=strlen($data);
                                fwrite($newf,$data,1024*8);
                                echo "<script type=\"text/javascript\">setdown(".$downlen.");</script>";
                                ob_flush();
                                flush();
                        }
                }
                if($file){fclose($file);}
                if($newf){fclose($newf);}
        }
}
function un_zip($dir){
        include_once "source/plugin/zip/zip.php";
        $unzip="data/backup/develop.zip";
        if(is_file($unzip)){
                $zip=new PclZip($unzip);
                if(($list=$zip->listContent())==0){
                        exit("<div class=\"infobox\"><br /><h4 class=\"marginbot normal\" style=\"color:red\">".$zip->errorInfo(true)."</h4><br /><p class=\"margintop\"><input type=\"button\" class=\"btn\" value=\"重新安装\" onclick=\"history.back(1);\"></p><br /></div></div></body></html>");
                }
                $zip->extract(PCLZIP_OPT_PATH,$dir,PCLZIP_OPT_REPLACE_NEWER);
                echo "<div class=\"infobox\"><br /><img src=\"static/admincp/images/ajax_loader.gif\" /><br /></div>";
                echo "<script type=\"text/javascript\">window.setTimeout(\"location.href='?".str_replace("&unzip","&install",$_SERVER['QUERY_STRING'])."';\", 1000);</script>";
        }
}
function install_ation($type){
        @unlink("data/backup/develop.zip");
	global $db;
        if($type==1){
                if($row=$db->getone("select CD_ID from ".tname('mold')." where CD_TempPath='template/".$_GET['dir']."/".$_GET['html']."/'")){
                        $db->query("update ".tname('mold')." set CD_Name='".base64_decode($_GET['name'])."' where CD_ID=".$row['CD_ID']);
                }else{
                        $db->query("Insert ".tname('mold')." (CD_Name,CD_TempPath,CD_TheOrder) values ('".base64_decode($_GET['name'])."','template/".$_GET['dir']."/".$_GET['html']."/',0)");
                }
                fwrite(fopen("template/".$_GET['dir']."/purchase.xml","wb+"),md5($_SERVER['HTTP_HOST']));
                echo "<script type=\"text/javascript\">location.href='?iframe=skin';</script>";
        }elseif($type==2){
                if($row=$db->getone("select CD_ID from ".tname('plugin')." where CD_Dir='".$_GET['dir']."'")){
                        $db->query("update ".tname('plugin')." set CD_Name='".base64_decode($_GET['name'])."',CD_File='".$_GET['file']."',CD_Author='".base64_decode($_GET['author'])."',CD_Address='".$_GET['address']."',CD_AddTime='".date('Y-m-d H:i:s')."' where CD_ID=".$row['CD_ID']);
                }else{
                        $db->query("Insert ".tname('plugin')." (CD_Name,CD_Dir,CD_File,CD_IsIndex,CD_Author,CD_Address,CD_AddTime) values ('".base64_decode($_GET['name'])."','".$_GET['dir']."','".$_GET['file']."',0,'".base64_decode($_GET['author'])."','".$_GET['address']."','".date('Y-m-d H:i:s')."')");
                }
                fwrite(fopen("source/plugin/".$_GET['dir']."/purchase.xml","wb+"),md5($_SERVER['HTTP_HOST']));
                echo "<script type=\"text/javascript\">parent.$('menu_app').innerHTML='".Menu_App()."';location.href='?iframe=module';</script>";
        }else{
                echo "<div class=\"infobox\"><br /><h4 class=\"marginbot normal\" style=\"color:green\">扩展安装成功</h4><br /><p class=\"margintop\"><input type=\"button\" class=\"btn\" value=\"返回首页\" onclick=\"location.href='?iframe=body';\"></p><br /></div>";
        }
}
?>
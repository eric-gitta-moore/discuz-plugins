<?php
Administrator(7);
$setup=SafeRequest("setup","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>程序升级</title>
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
                        window.setTimeout("location.href='?iframe=update&setup=replacefile';", 1000);
                }
        }
}
</script>
</head>
<body>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 程序升级';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='程序升级';</script>
<div class="itemtitle"><h3>程序升级</h3><ul class="tab1" style="margin-right:10px"></ul><ul class="stepstat">
<?php if($setup=="downfile"){echo "<li class=\"current\">";}else{echo "<li>";} ?>1.下载文件</li>
<?php if($setup=="replacefile"){echo "<li class=\"current\">";}else{echo "<li>";} ?>2.更新文件</li>
<?php if($setup=="changedata"){echo "<li class=\"current\">";}else{echo "<li>";} ?>3.更新数据</li>
</ul><ul class="tab1"></ul></div>
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<li>升级前请先关闭站点并备份数据。如遇升级失败，请检查相关函数是否开启及文件目录是否具有写入权限；</li>
<li>更新包较大时可能会出现下载缓慢。如遇无法升级，请前往官网下载补丁并手动覆盖更新！</li>
</ul></td></tr>
</table>
<h3>QianWei Music 提示</h3>
<?php
switch($setup){
	case 'checkup':
		check_up($update_api);
		break;
	case 'downfile':
		down_file();
		break;
	case 'replacefile':
		replace_file();
		break;
	case 'changedata':
		change_data();
		break;
	default:
		start_up();
		break;
	}
?>
</div>
</body>
</html>
<?php
function start_up(){
        echo "<div class=\"infobox\"><br /><p class=\"margintop\"><input type=\"button\" class=\"btn\" value=\"检测更新\" onclick=\"location.href='?iframe=update&setup=checkup';\"></p><br /></div>";
}

function check_up($file){
        $hander_array=get_headers($file);
        if($hander_array[0]=='HTTP/1.1 200 OK'){
                fwrite(fopen("data/update.xml","w+"),@file_get_contents($file));
                $version=explode("[version]",@file_get_contents("data/update.xml"));
                $build=explode("[build]",@file_get_contents("data/update.xml"));
                $date=explode("[date]",@file_get_contents("data/update.xml"));
                if($build[1]!==cd_build){
                        echo "<div class=\"infobox\"><br /><h4 class=\"marginbot normal\" style=\"color:red\">发现可用更新 [".$version[1]."] [".$build[1]."]<br /><br /><br />".$date[1]."</h4><br /><p class=\"margintop\"><input type=\"button\" class=\"btn\" value=\"开始下载更新\" onclick=\"location.href='?iframe=update&setup=downfile';\"> &nbsp; <input type=\"button\" class=\"btn\" value=\"取消\" onclick=\"history.go(-1);\"></p><br /></div>";
                }else{
                        echo "<div class=\"infobox\"><br /><h4 class=\"marginbot normal\" style=\"color:green\">已经是最新版本了</h4><br /></div>";
                }
        }else{
                echo "<div class=\"infobox\"><br /><p class=\"margintop\"><img src=\"static/admincp/images/loading.gif\" /></p><br /></div>";
        }
}

function down_file(){
        echo "<div class=\"infobox\"><br />";
        echo "<table class=\"tb tb2\" style=\"border:1px solid #09C\">";
        echo "<tr><td><div id=\"progressbar\" style=\"float:left;width:1px;text-align:center;color:#FFFFFF;background-color:#09C\"></div><div id=\"progressText\" style=\"float:left\">0%</div></td></tr>";
        echo "</table>";
        echo "<br /></div>";
        ob_start();
        $patch=explode("[patch]",@file_get_contents("data/update.xml"));
        $file=fopen($patch[1],"rb");
        if($file){
                $headers=get_headers($patch[1],1);
                if(array_key_exists("Content-Length",$headers)){
                        $filesize=$headers["Content-Length"];
                }else{
                        $filesize=strlen(@file_get_contents($patch[1]));
                }
                echo "<script type=\"text/javascript\">setsize(".$filesize.");</script>";
                $newf=fopen("data/backup/patch.zip","wb");
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

function replace_file(){
        include_once "source/plugin/zip/zip.php";
        $unzip="data/backup/patch.zip";
        if(is_file($unzip)){
                $zip=new PclZip($unzip);
                if(($list=$zip->listContent())==0){
                        exit("<div class=\"infobox\"><br /><h4 class=\"marginbot normal\" style=\"color:red\">".$zip->errorInfo(true)."</h4><br /><p class=\"margintop\"><input type=\"button\" class=\"btn\" value=\"重新升级\" onclick=\"history.back(1);\"></p><br /></div></div></body></html>");
                }
                $zip->extract(PCLZIP_OPT_PATH,_qianwei_root_,PCLZIP_OPT_REPLACE_NEWER);
                echo "<div class=\"infobox\"><br /><img src=\"static/admincp/images/ajax_loader.gif\" /><br /></div>";
                echo "<script type=\"text/javascript\">window.setTimeout(\"location.href='?iframe=update&setup=changedata';\", 1000);</script>";
        }
}

function change_data(){
        @unlink("data/backup/patch.zip");
        $version=explode("[version]",@file_get_contents("data/update.xml"));
        $build=explode("[build]",@file_get_contents("data/update.xml"));
	$config=file_get_contents("source/global/global.php");
	$config=preg_replace('/"cd_version","(.*?)"/', '"cd_version","'.$version[1].'"', $config);
	$config=preg_replace('/"cd_build","(.*?)"/', '"cd_build","'.$build[1].'"', $config);
	$ifile=new iFile('source/global/global.php', 'w');
	$ifile->WriteFile($config, 3);
	global $db;
	mysql_query("SET NAMES gb2312",mysql_connect(cd_sqlservername, cd_sqluserid, cd_sqlpwd));
	if(!mysql_query("SELECT COUNT(*) FROM ".cd_tablename."plugin")){
                $table=file_get_contents("data/backup/plugin.sql");
                $table=ReplaceStr($table,"prefix_",cd_tablename);
                $tablearr=explode(";",$table);
	        for($i=0;$i<count($tablearr)-1;$i++){
		        mysql_query($tablearr[$i]);
	        }
	}
	if(!mysql_query("SELECT COUNT(CD_IsIndex) FROM ".cd_tablename."plugin")){
                mysql_query("ALTER TABLE `".cd_tablename."plugin` ADD `CD_IsIndex` int(11) NOT NULL");
	}
	if(!mysql_query("SELECT COUNT(cd_qqopen) FROM ".cd_tablename."user")){
                mysql_query("ALTER TABLE `".cd_tablename."user` ADD `cd_qqopen` varchar(255) DEFAULT NULL");
                mysql_query("ALTER TABLE `".cd_tablename."user` ADD `cd_qqimg` varchar(255) DEFAULT NULL");
	}
	if(!mysql_query("SELECT COUNT(*) FROM ".cd_tablename."singer")){
                $table=file_get_contents("data/backup/singer.sql");
                $table=ReplaceStr($table,"prefix_",cd_tablename);
                $tablearr=explode(";",$table);
	        for($i=0;$i<count($tablearr)-1;$i++){
		        mysql_query($tablearr[$i]);
	        }
                mysql_query("ALTER TABLE `".cd_tablename."music` CHANGE COLUMN `CD_Singer` `CD_SingerID` int(11) NOT NULL");
                mysql_query("ALTER TABLE `".cd_tablename."video` CHANGE COLUMN `CD_Singer` `CD_SingerID` int(11) NOT NULL");
                mysql_query("ALTER TABLE `".cd_tablename."special` CHANGE COLUMN `CD_Singer` `CD_SingerID` int(11) NOT NULL");
	        $db->query("update ".tname('class')." set CD_Name='歌手大全',CD_AliasName='singer_all',CD_Template='singer_all.html' where CD_ID=1");
	}
        echo "<div class=\"infobox\"><br /><h4 class=\"marginbot normal\" style=\"color:green\">恭喜！QianWei Music 顺利升级完成！</h4><br /><p class=\"margintop\"><input type=\"button\" class=\"btn\" value=\"完成\" onclick=\"location.href='?iframe=body';\"></p><br /></div>";
}
?>
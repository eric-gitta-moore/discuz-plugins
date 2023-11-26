<?php
Administrator(7);
$action=SafeRequest("action","get");
switch($action){
	case 'backup':
		mainjump();
		delold();
		backup();
		break;
	case 'backupnext':
		mainjump();
		backupnext();
		break;
	case 'restore':
		mainjump();
		restore();
		break;
	case 'restorenext':
		mainjump();
		restorenext();
		break;
	case 'delsql':
		mainjump();
		delsql();
		break;
	case 'inzip':
		mainjump();
		inzip();
		break;
	case 'unzip':
		mainjump();
		unzip();
		break;
	case 'delzip':
		mainjump();
		delzip();
		break;
	case 'mainjump':
		mainjump();
		break;
	default:
		main();
		break;
} function main(){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>站点备份</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">function $(obj) {return document.getElementById(obj);}</script>
</head>
<body>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 工具 - 站点备份';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='工具&nbsp;&raquo;&nbsp;站点备份&nbsp;&nbsp;<a target="main" title="添加到常用操作" href="?iframe=menu&action=getadd&name=站点备份&url=<?php echo $_SERVER['QUERY_STRING']; ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>站点备份</h3></div></div><div class="floattopempty"></div>
<form method="post" name="form" target="iframe">
<table class="tb tb2">
<tr><th class="partition">备份数据</th></tr>
</table>
<table class="tb tb2">
<tr><td>分卷备份大小：<input type="text" class="txt" name="size" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))">默认2048KB</td><td><input type="submit" class="btn" value="开始备份数据" onclick="form.action='?iframe=backup&action=backup'" /></td><td><?php echo checkbak(); ?><input type="submit" class="btn" value="还原数据" onclick="form.action='?iframe=backup&action=restore'" /></td><td><?php echo checksql(); ?></td></tr>
</table>
<table class="tb tb2">
<tr><th class="partition">备份文件</th></tr>
</table>
<table class="tb tb2">
<tr><td>压缩解压目录：<input type="text" class="txt" name="dir">留空为根目录</td><td><input type="submit" class="btn" value="开始压缩文件" onclick="form.action='?iframe=backup&action=inzip'" /></td><td><input type="submit" class="btn" value="解压文件" onclick="form.action='?iframe=backup&action=unzip'" /></td><td><?php echo checkzip(); ?></td></tr>
</table>
</form>
<h3>QianWei Music 提示</h3>
<div class="infobox"><iframe name="iframe" frameborder="0" width="100%" height="100%" src="?iframe=backup&action=mainjump"></iframe></div>
</div>
</body>
</html>
<?php
} function backup(){
	global $db;
	$size=(!empty($_POST['size'])) ? SafeRequest("size","post") : '2048';
	$result=$db->list_tables(cd_sqldbname);
	if($result){
		$dbfile="data/backup/table_".substr(md5(time().mt_rand(1000,5000)),0,16).".sql";
		$fp=fopen($dbfile,"w");
		$rn="\r\n";
		while($row=mysql_fetch_row($result)){
			$prefix=explode("_",$row[0]);
			if($prefix[0]==ReplaceStr(cd_tablename,"_","")){
        			fwrite($fp,$rn."DROP TABLE IF EXISTS `$row[0]`;\r\n\r\n");
				$sql="SHOW CREATE TABLE `$row[0]`";
				$tableStruct=$db->getall($sql);
				if($tableStruct){
					$tableStruct[0]['Create Table']=preg_replace("/AUTO_INCREMENT=(\[0-9\]{1,})\[ \r\n\t\]{1,}/","",$tableStruct[0]['Create Table']);
					fwrite($fp,ReplaceStr($tableStruct[0]['Create Table'],"\n",$rn).";".$rn);
					echo "备份数据表结构 <font color=\"green\">".$row[0]."</font> ... 成功<br />";
				}else{
					echo "备份数据表结构 <font color=\"red\">".$row[0]."</font> ... 失败<br />";
				}
			}
		}
		fclose($fp);
		mysql_free_result($result);
		echo "<br /><font color=\"green\">数据表结构备份完毕，即将备份数据内容...</font><script type=\"text/javascript\">window.setTimeout(\"location.href='?iframe=backup&action=backupnext&size=".$size."';\", 3000);</script>";
	}
} function backupnext(){
	global $db;
	$size=SafeRequest("size","get");
	$bakstr="";
	$tableresult=$db->list_tables(cd_sqldbname);
	if($tableresult){
		while($tablerow=mysql_fetch_row($tableresult)){
			$prefix=explode("_",$tablerow[0]);
			if($prefix[0]==ReplaceStr(cd_tablename,"_","")){
				$intable="INSERT INTO `$tablerow[0]` VALUES(";
				$fieldresult=$db->list_fields(cd_sqldbname,$tablerow[0]);
				$i=0;
				if($fieldresult){
	  				while($fieldrow=mysql_fetch_field($fieldresult)){
		 		 		$fs[$i]=trim($fieldrow->name);
						$i++;
					}
					$fsd=$i-1;
					$sql="select * from `$tablerow[0]`";
					$result=$db->getall($sql);
					for($j=0;$j<count($result);$j++){
						$line=$intable;
						for($k=0;$k<=$fsd;$k++){
							if($k<$fsd){
								$line.="'".mysql_escape_string($result[$j][$fs[$k]])."',";
							}else{
								$line.="'".mysql_escape_string($result[$j][$fs[$k]])."');\r\n";
							}
						}
						$bakstr.=$line;
						if(strlen($bakstr)>$size*1024){
							$dbfile="data/backup/data_".substr(md5(time().mt_rand(1000,5000)),0,16).".sql";
							$fp=fopen($dbfile,"w");
							fwrite($fp,ReplaceStr($bakstr."]","\r\n]",""));
							fclose($fp);
							echo "分卷文件 <font color=\"green\">".$dbfile."</font> 备份成功...<br />";
							$bakstr="";
						}
					}
				}
			}
		}
		if(!empty($bakstr) && strlen($bakstr)<$size*1024){
			  $dbfile="data/backup/data_".substr(md5(time().mt_rand(1000,5000)),0,16).".sql";
			  $fp=fopen($dbfile,"w");
			  fwrite($fp,ReplaceStr($bakstr."]","\r\n]",""));
			  echo "分卷文件 <font color=\"green\">".$dbfile."</font> 备份成功...<br />";
			  fclose($fp);
			  echo "<br /><font color=\"green\">恭喜，数据库已经全部备份完成！</font>";
		}
	}
} function delold(){
	fwrite(fopen("data/backup/log.xml","w"),date('Y-m-d H:i:s'));
	$d=_qianwei_root_.'./data/backup/';
	if(is_dir($d)){
	  	$dh=opendir($d);
 		while (false !== ($file = readdir($dh))) {
   			if($file!="." && $file!=".."){
      				$fullpath=$d."/".$file;
      				if(!is_dir($fullpath) && stristr($file,'.sql')){
         		 		unlink($fullpath);
     				}
			}
   		}
   		closedir($dh);
	}
} function restore(){
	global $db;
	$id=SafeRequest("bakid","post");
	if($id!=1){
		echo "<font color=\"red\">没有找到备份文件，请先备份数据！</font>";
	}else{
		$d=_qianwei_root_.'./data/backup/';
		if(is_dir($d)){
			$dh=opendir($d);
			while (false !== ($file = readdir($dh))) {
				if($file!="." && $file!=".."){
					$fullpath=$d."/".$file;
					if(!is_dir($fullpath) && stristr($file,'table_')){
						$table_str=@file_get_contents($fullpath);
						$tablearr=explode(";",$table_str);
						for($i=0;$i<count($tablearr)-1;$i++){
							$db->query($tablearr[$i]);
						}
						echo "<br /><font color=\"green\">数据表结构还原完毕，即将还原数据内容...</font><script type=\"text/javascript\">window.setTimeout(\"location.href='?iframe=backup&action=restorenext';\", 3000);</script>";
					} 
				}
			}
			closedir($dh);
		}
	}
} function restorenext(){
	global $db;
	$d=_qianwei_root_.'./data/backup/';
	if(is_dir($d)){
	  	$dh=opendir($d);
 		while (false !== ($file = readdir($dh))) {
   			if($file!="." && $file!=".."){
      				$fullpath=$d."/".$file;
      				if(!is_dir($fullpath) && stristr($file,'data_')){
					$filearr[]=$fullpath;
     				}
			}
   		}
		for($i=0;$i<count($filearr);$i++){
			$data_str=@file_get_contents(trim($filearr[$i]));
			$dataarr=explode("\n",$data_str);
			for($j=0;$j<count($dataarr);$j++){
				$db->query($dataarr[$j]);
			}
			echo "成功还原 <font color=\"green\">".$j."</font> 条数据...<br />";
		}
		echo "<br /><font color=\"green\">恭喜，数据库已经全部还原完成！</font>";
   		closedir($dh);
	}
} function checkbak(){
	$d=_qianwei_root_.'./data/backup/';
	if(is_dir($d)){
	  	$dh=opendir($d);
 		while (false !== ($file = readdir($dh))) {
   			if($file!="." && $file!=".."){
      				$fullpath=$d."/".$file;
      				if(!is_dir($fullpath) && stristr($file,'table_')){
                                        echo "<input type=\"hidden\" name=\"bakid\" value=\"1\">";
     				}
			}
   		}
   		closedir($dh);
	}
} function checksql(){
        if(is_file("data/backup/log.xml")){
                echo "<input type=\"submit\" class=\"btn\" value=\"删除备份\" onclick=\"form.action='?iframe=backup&action=delsql'\" />";
        }else{
		echo "<input type=\"button\" class=\"btn\" value=\"暂无备份\" disabled=\"disabled\" />";
        }
} function delsql(){
	@unlink("data/backup/log.xml");
	$d=_qianwei_root_.'./data/backup/';
	if(is_dir($d)){
	  	$dh=opendir($d);
 		while (false !== ($file = readdir($dh))) {
   			if($file!="." && $file!=".."){
      				$fullpath=$d."/".$file;
      				if(!is_dir($fullpath) && stristr($file,'.sql')){
         		 		unlink($fullpath);
     				}
			}
   		}
   		closedir($dh);
	}
        echo "<font color=\"green\">备份文件已删除！</font>";
} function inzip(){
        include_once "source/plugin/zip/zip.php";
	$dir=(!empty($_POST['dir'])) ? SafeRequest("dir","post") : _qianwei_root_;
        $inzip="data/backup/upload.zip";
        @unlink($inzip);
        $zip=new PclZip($inzip);
        if(($list=$zip->create($dir,PCLZIP_OPT_REMOVE_PATH,$dir))==0){
                echo "<font color=\"red\">".$zip->errorInfo(true)."</font>";
        }else{
                echo "<font color=\"green\">恭喜，文件已经全部压缩完成！</font><a href=\"".$inzip."\">立即下载</a>";
        }
} function unzip(){
        include_once "source/plugin/zip/zip.php";
	$dir=(!empty($_POST['dir'])) ? SafeRequest("dir","post") : _qianwei_root_;
        $unzip="data/backup/upload.zip";
        if(is_file($unzip)){
                $zip=new PclZip($unzip);
                if(($list=$zip->listContent())==0){
                        exit("<font color=\"red\">".$zip->errorInfo(true)."</font>");
                }
                $zip->extract(PCLZIP_OPT_PATH,$dir,PCLZIP_OPT_REPLACE_NEWER);
                echo "<font color=\"green\">恭喜，文件已经全部解压完成！</font>";
        }else{
		echo "<font color=\"red\">没有找到指定的压缩包，请先备份文件！</font>";
        }
} function checkzip(){
        if(is_file("data/backup/upload.zip")){
                echo "<input type=\"submit\" class=\"btn\" value=\"删除备份\" onclick=\"form.action='?iframe=backup&action=delzip'\" />";
        }else{
		echo "<input type=\"button\" class=\"btn\" value=\"暂无备份\" disabled=\"disabled\" />";
        }
} function delzip(){
        @unlink("data/backup/upload.zip");
        echo "<font color=\"green\">指定的压缩包已删除！</font>";
}
?>
<?php
Administrator(7);
$action=SafeRequest("action","get");
switch($action){
	case 'musicnum':
		mainjump();
		musicnum();
		break;
	case 'deleted':
		mainjump();
		deleted();
		break;
	case 'copys':
		mainjump();
		copys();
		break;
	case 'copyspecial':
		mainjump();
		copyspecial();
		break;
	case 'copysinger':
		mainjump();
		copysinger();
		break;
	case 'copyvideo':
		mainjump();
		copyvideo();
		break;
	case 'copylink':
		mainjump();
		copylink();
		break;
	case 'clean':
		mainjump();
		clean();
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
<title>更新统计</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">function $(obj) {return document.getElementById(obj);}</script>
</head>
<body>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 工具 - 更新统计';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='工具&nbsp;&raquo;&nbsp;更新统计&nbsp;&nbsp;<a target="main" title="添加到常用操作" href="?iframe=menu&action=getadd&name=更新统计&url=<?php echo $_SERVER['QUERY_STRING']; ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>更新统计</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<li>如有新音乐采集入库或用户的音乐分享数不符，可以执行以下更新项目中的{更新用户音乐分享数}来完善统计</li>
</ul></td></tr>
</table>
<form method="post" name="form" target="iframe">
<table class="tb tb2">
<tr><th class="partition">更新项目</th></tr>
</table>
<table class="tb tb2">
<tr>
<td><input type="submit" class="btn" value="更新用户音乐分享数" onclick="form.action='?iframe=reset&action=musicnum'" /></td><td><input type="submit" class="btn" value="一键清空音乐回收站" onclick="form.action='?iframe=reset&action=deleted'" /></td><td><input type="submit" class="btn" value="一键本地化远程图片" onclick="form.action='?iframe=reset&action=copys'" /></td><td><input type="submit" class="btn" value="一键清理冗余附件" onclick="form.action='?iframe=reset&action=clean'" /></td>
</tr>
</table>
</form>
<h3>QianWei Music 提示</h3>
<div class="infobox"><iframe name="iframe" frameborder="0" width="100%" height="100%" src="?iframe=reset&action=mainjump"></iframe></div>
</div>
</body>
</html>
<?php
} function musicnum(){
	global $db;
	$sql="select distinct CD_User,CD_UserNicheng from ".tname('music');
	$result=$db->query($sql);
	if($result){
		while ($row = $db->fetch_array($result)) {
                        $query = $db->query("SELECT COUNT(CD_ID) FROM ".tname('music')." where CD_Deleted=0 and CD_Passed=0 and CD_User='".$row['CD_User']."'");
                        $musicnum = $db->result($query, 0);
                        $db->query("update ".tname('user')." set cd_musicnum=".$musicnum." where cd_name='".$row['CD_User']."'");
                        echo "<font color=\"green\">".$row['CD_UserNicheng']."</font> 音乐分享数更新为 <font color=\"blue\">".$musicnum."</font> ... 成功<br />";
		}
		echo "<br /><font color=\"green\">恭喜，用户音乐分享数更新完成！</font>";
	}
} function deleted(){
	global $db;
        $query = $db->query("select CD_ID,CD_Url,CD_Pic,CD_Lrc,CD_UserID,CD_User,CD_Passed from ".tname('music')." where CD_Deleted=1");
        while ($row = $db->fetch_array($query)) {
		if($row["CD_Passed"]==0){
			if(cd_pointsdca >= 1){
				$setarr = array(
					'cd_type' => 0,
					'cd_uid' => $row['CD_UserID'],
					'cd_uname' => $row['CD_User'],
					'cd_icon' => 'dance',
					'cd_title' => '音乐被删除',
					'cd_points' => cd_pointsdca,
					'cd_state' => 0,
					'cd_addtime' => date('Y-m-d H:i:s'),
					'cd_endtime' => getendtime()
				);
				inserttable('bill', $setarr, 1);
			}
			$db->query("update ".tname('user')." set cd_points=cd_points-".cd_pointsdca.",cd_rank=cd_rank-".cd_pointsdcb.",cd_musicnum=cd_musicnum-1 where cd_id=".$row['CD_UserID']);
		}
		$db->query("delete from ".tname('comment')." where cd_channel=4 and cd_dataid=".$row['CD_ID']);
		$Url=$row['CD_Url'];
		$Pic=$row['CD_Pic'];
		$Lrc=$row['CD_Lrc'];
		if(file_exists($Url)){unlink($Url);}
		if(file_exists($Pic)){unlink($Pic);}
		if(file_exists($Lrc)){unlink($Lrc);}
        }
	$sql="delete from ".tname('music')." where CD_Deleted=1";
	if($db->query($sql)){
		echo "<font color=\"green\">恭喜，音乐回收站清空完成！</font>";
	}
} function copys(){
	global $db;
	$num=0;
	$picpath="data/attachment/pic/";
	creatdir($picpath);
        echo "<script type=\"text/javascript\">function $(obj) {return document.getElementById(obj);}</script>";
        echo "<table style=\"border:1px solid #09C;width:300px\">";
        echo "<tr><td>音乐封面</td><td><div id=\"m\" style=\"color:green\">0</div></td></tr>";
        echo "<tr><td>累计下载</td><td><div id=\"num\" style=\"color:blue\">0</div></td></tr>";
        echo "<tr><td>下载总计</td><td><div><img src=\"static/admincp/images/ajax_loader.gif\" /></div></td></tr>";
        echo "</table>";
	ob_start();
        $music = $db->query("select CD_ID,CD_Pic from ".tname('music')." where CD_Deleted=0 and CD_Passed=0");
        while ($row = $db->fetch_array($music)) {
		if(substr($row["CD_Pic"], 0, 7)=="http://"){
			$num=$num+1;
			$musicdir=$picpath."music_".$row["CD_ID"].".jpg";
                        $file=fopen($row["CD_Pic"],"rb");
                        if($file){
                                $newf=fopen($musicdir,"wb");
                                $downlen=0;
                                if($newf){
                                        while(!feof($file)){
                                                $data=fread($file,1024*8);
                                                $downlen+=strlen($data);
                                                fwrite($newf,$data,1024*8);
                                                echo "<script type=\"text/javascript\">$('num').innerHTML=".$num.";$('m').innerHTML=".$num.";</script>";
                                                ob_flush();
                                                flush();
                                        }
                                }
                                if($file){
                                        fclose($file);
                                }
                                if($newf){
                                        fclose($newf);
                                }
                        }
                        $db->query("update ".tname('music')." set CD_Pic='".$musicdir."' where CD_ID=".$row['CD_ID']);
		}
        }
        echo "<script type=\"text/javascript\">window.setTimeout(\"location.href='?iframe=reset&action=copyspecial&num=".$num."';\", 2000);</script>";
} function copyspecial(){
	global $db;
	$s=0;
	$num=SafeRequest("num","get");
	$picpath="data/attachment/pic/";
        echo "<script type=\"text/javascript\">function $(obj) {return document.getElementById(obj);}</script>";
        echo "<table style=\"border:1px solid #09C;width:300px\">";
        echo "<tr><td>专辑封面</td><td><div id=\"s\" style=\"color:green\">0</div></td></tr>";
        echo "<tr><td>累计下载</td><td><div id=\"num\" style=\"color:blue\">".$num."</div></td></tr>";
        echo "<tr><td>下载总计</td><td><div><img src=\"static/admincp/images/ajax_loader.gif\" /></div></td></tr>";
        echo "</table>";
	ob_start();
        $special = $db->query("select CD_ID,CD_Pic from ".tname('special')." where CD_Passed=0");
        while ($row = $db->fetch_array($special)) {
		if(substr($row["CD_Pic"], 0, 7)=="http://"){
			$s=$s+1;
			$num=$num+1;
			$specialdir=$picpath."special_".$row["CD_ID"].".jpg";
                        $file=fopen($row["CD_Pic"],"rb");
                        if($file){
                                $newf=fopen($specialdir,"wb");
                                $downlen=0;
                                if($newf){
                                        while(!feof($file)){
                                                $data=fread($file,1024*8);
                                                $downlen+=strlen($data);
                                                fwrite($newf,$data,1024*8);
                                                echo "<script type=\"text/javascript\">$('num').innerHTML=".$num.";$('s').innerHTML=".$s.";</script>";
                                                ob_flush();
                                                flush();
                                        }
                                }
                                if($file){
                                        fclose($file);
                                }
                                if($newf){
                                        fclose($newf);
                                }
                        }
                        $db->query("update ".tname('special')." set CD_Pic='".$specialdir."' where CD_ID=".$row['CD_ID']);
		}
        }
        echo "<script type=\"text/javascript\">window.setTimeout(\"location.href='?iframe=reset&action=copysinger&num=".$num."';\", 2000);</script>";
} function copysinger(){
	global $db;
	$g=0;
	$num=SafeRequest("num","get");
	$picpath="data/attachment/pic/";
        echo "<script type=\"text/javascript\">function $(obj) {return document.getElementById(obj);}</script>";
        echo "<table style=\"border:1px solid #09C;width:300px\">";
        echo "<tr><td>歌手封面</td><td><div id=\"g\" style=\"color:green\">0</div></td></tr>";
        echo "<tr><td>累计下载</td><td><div id=\"num\" style=\"color:blue\">".$num."</div></td></tr>";
        echo "<tr><td>下载总计</td><td><div><img src=\"static/admincp/images/ajax_loader.gif\" /></div></td></tr>";
        echo "</table>";
	ob_start();
        $singer = $db->query("select CD_ID,CD_Pic from ".tname('singer')." where CD_Passed=0");
        while ($row = $db->fetch_array($singer)) {
		if(substr($row["CD_Pic"], 0, 7)=="http://"){
			$g=$g+1;
			$num=$num+1;
			$singerdir=$picpath."singer_".$row["CD_ID"].".jpg";
                        $file=fopen($row["CD_Pic"],"rb");
                        if($file){
                                $newf=fopen($singerdir,"wb");
                                $downlen=0;
                                if($newf){
                                        while(!feof($file)){
                                                $data=fread($file,1024*8);
                                                $downlen+=strlen($data);
                                                fwrite($newf,$data,1024*8);
                                                echo "<script type=\"text/javascript\">$('num').innerHTML=".$num.";$('g').innerHTML=".$g.";</script>";
                                                ob_flush();
                                                flush();
                                        }
                                }
                                if($file){
                                        fclose($file);
                                }
                                if($newf){
                                        fclose($newf);
                                }
                        }
                        $db->query("update ".tname('singer')." set CD_Pic='".$singerdir."' where CD_ID=".$row['CD_ID']);
		}
        }
        echo "<script type=\"text/javascript\">window.setTimeout(\"location.href='?iframe=reset&action=copyvideo&num=".$num."';\", 2000);</script>";
} function copyvideo(){
	global $db;
	$v=0;
	$num=SafeRequest("num","get");
	$picpath="data/attachment/pic/";
        echo "<script type=\"text/javascript\">function $(obj) {return document.getElementById(obj);}</script>";
        echo "<table style=\"border:1px solid #09C;width:300px\">";
        echo "<tr><td>视频封面</td><td><div id=\"v\" style=\"color:green\">0</div></td></tr>";
        echo "<tr><td>累计下载</td><td><div id=\"num\" style=\"color:blue\">".$num."</div></td></tr>";
        echo "<tr><td>下载总计</td><td><div><img src=\"static/admincp/images/ajax_loader.gif\" /></div></td></tr>";
        echo "</table>";
	ob_start();
        $video = $db->query("select CD_ID,CD_Pic from ".tname('video')." where CD_IsIndex=0");
        while ($row = $db->fetch_array($video)) {
		if(substr($row["CD_Pic"], 0, 7)=="http://"){
			$v=$v+1;
			$num=$num+1;
			$videodir=$picpath."video_".$row["CD_ID"].".jpg";
                        $file=fopen($row["CD_Pic"],"rb");
                        if($file){
                                $newf=fopen($videodir,"wb");
                                $downlen=0;
                                if($newf){
                                        while(!feof($file)){
                                                $data=fread($file,1024*8);
                                                $downlen+=strlen($data);
                                                fwrite($newf,$data,1024*8);
                                                echo "<script type=\"text/javascript\">$('num').innerHTML=".$num.";$('v').innerHTML=".$v.";</script>";
                                                ob_flush();
                                                flush();
                                        }
                                }
                                if($file){
                                        fclose($file);
                                }
                                if($newf){
                                        fclose($newf);
                                }
                        }
                        $db->query("update ".tname('video')." set CD_Pic='".$videodir."' where CD_ID=".$row['CD_ID']);
		}
        }
        echo "<script type=\"text/javascript\">window.setTimeout(\"location.href='?iframe=reset&action=copylink&num=".$num."';\", 2000);</script>";
} function copylink(){
	global $db;
	$l=0;
	$num=SafeRequest("num","get");
	$picpath="data/attachment/pic/";
        echo "<script type=\"text/javascript\">function $(obj) {return document.getElementById(obj);}</script>";
        echo "<table style=\"border:1px solid #09C;width:300px\">";
        echo "<tr><td>友情链接</td><td><div id=\"l\" style=\"color:green\">0</div></td></tr>";
        echo "<tr><td>累计下载</td><td><div id=\"num\" style=\"color:blue\">".$num."</div></td></tr>";
        echo "<tr><td>下载总计</td><td><div id=\"nums\" style=\"color:red\"><img src=\"static/admincp/images/ajax_loader.gif\" /></div></td></tr>";
        echo "</table>";
	ob_start();
        $link = $db->query("select cd_id,cd_pic from ".tname('link')." where cd_isindex=0");
        while ($row = $db->fetch_array($link)) {
		if(substr($row["cd_pic"], 0, 7)=="http://"){
			$l=$l+1;
			$num=$num+1;
			$linkdir=$picpath."link_".$row["cd_id"].".jpg";
                        $file=fopen($row["cd_pic"],"rb");
                        if($file){
                                $newf=fopen($linkdir,"wb");
                                $downlen=0;
                                if($newf){
                                        while(!feof($file)){
                                                $data=fread($file,1024*8);
                                                $downlen+=strlen($data);
                                                fwrite($newf,$data,1024*8);
                                                echo "<script type=\"text/javascript\">$('num').innerHTML=".$num.";$('l').innerHTML=".$l.";</script>";
                                                ob_flush();
                                                flush();
                                        }
                                }
                                if($file){
                                        fclose($file);
                                }
                                if($newf){
                                        fclose($newf);
                                }
                        }
                        $db->query("update ".tname('link')." set cd_pic='".$linkdir."' where cd_id=".$row['cd_id']);
		}
        }
        echo "<script type=\"text/javascript\">$('nums').innerHTML=".$num.";</script>";
} function clean(){
	scan_all('data/attachment');
	echo "<br /><font color=\"green\">恭喜，冗余附件一键清理完成！</font>";
} function scan_all($dir) {
        $temp = scandir($dir);
        if(is_array($temp) && count($temp)>2) {
                array_shift($temp);
                array_shift($temp);
                foreach ($temp as $v) {
                        $cur_dir = str_replace("\\", '/', $dir.DIRECTORY_SEPARATOR.$v);
                        if(is_dir($cur_dir)) {
                                if($cur_dir !== 'data/attachment/avatar' && $cur_dir !== 'data/attachment/album') {
                                        scan_all($cur_dir);
                                }
                        }elseif(is_file($cur_dir)) {
                                global $db;
                                $link = $db->getone("select cd_id from ".tname('link')." where cd_pic like '%".$v."%'");
                                $verified = $db->getone("select cd_id from ".tname('user')." where cd_verified like '%".$v."%'");
                                $special = $db->getone("select CD_ID from ".tname('special')." where CD_Pic like '%".$v."%'");
                                $singer = $db->getone("select CD_ID from ".tname('singer')." where CD_Pic like '%".$v."%'");
                                $video = $db->getone("select CD_ID from ".tname('video')." where CD_Play like '%".$v."%' or CD_Pic like '%".$v."%'");
                                $music = $db->getone("select CD_ID from ".tname('music')." where CD_Url like '%".$v."%' or CD_DownUrl like '%".$v."%' or CD_Lrc like '%".$v."%' or CD_Pic like '%".$v."%'");
                                if(!$link && !$verified && !$special && !$singer && !$video && !$music) {
                                        @unlink($cur_dir);
                                        echo '<font color="green">删除</font> <font color="blue">'.$cur_dir.'</font><br />';
                                }
                        }else{
                                echo '<font color="red">未知错误</font>';
                        }
                }
        }
}
?>
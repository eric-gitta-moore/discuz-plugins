<?php
include "source/admincp/include/function.php";
Administrator(1);
$copys=SafeRequest("copys","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>远程采集</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="source/plugin/layer/jquery.js"></script>
<script type="text/javascript" src="source/plugin/layer/lib.js"></script>
<script type="text/javascript">
layer.ready(function() {
        pop = {
                up : function(text, url, width, height, top) {
                        $.layer({
                                type : 2,
                                title : text,
                                iframe : {src : url},
                                area : [width, height],
                                offset : [top, '50%'],
                                shade : [0.1, '#000', true]
                        });
                }
        }
});
function setlrcdown(fsize){
        document.getElementById("lrcdownloaded").innerHTML=fsize;
}
function setpicdown(fsize){
        document.getElementById("picdownloaded").innerHTML=fsize;
}
var songfilesize=0;
function setsongsize(fsize, format){
        songfilesize=fsize;
        document.getElementById("songfilesize").innerHTML=format;
}
function setsongdown(fsize, format){
        document.getElementById("songdownloaded").innerHTML=format;
        if(songfilesize>0){
                var percent=Math.round(fsize*100/songfilesize);
                document.getElementById("songprogressbar").style.width=(percent+"%");
                if(percent>99){
                        asyncbox.tips("采集完毕，即将返回上一页！", "success", 1500);
                        window.setTimeout("history.back(1);", 2000);
                }
                if(percent>0){
                        document.getElementById("songprogressbar").innerHTML=percent+"%";
                        document.getElementById("songprogressText").innerHTML="";
                }else{
                        document.getElementById("songprogressText").innerHTML=percent+"%";
                }
        }
}
function setnum(set){
        document.getElementById("setnum").innerHTML=set;
}
function valuesnum(values){
        document.getElementById("valuesnum").innerHTML=values;
}
function videonum(num, classid){
        document.getElementById("videonum").innerHTML=num;
        var list=Number(classid)+1;
        var percent=Math.round(num*100/2000);
        document.getElementById("videoprogressbar").style.width=(percent+"%");
        if(percent>99 && list>7){
                asyncbox.tips("恭喜，所有栏目采集完毕！", "success", 2500);
                window.setTimeout("location.href='?open=copys&opens=copys&copys=yyt_l_d';", 3000);
        }
        if(percent>99 && list<8){
                asyncbox.tips("第"+classid+"栏采集完毕，即将采集第"+list+"栏！", "success", 10000);
                window.setTimeout("location.href='?open=copys&opens=copys&copys=yyt_l_c&classid="+list+"';", 3000);
        }
        if(percent>0){
                document.getElementById("videoprogressbar").innerHTML=percent+"%";
                document.getElementById("videoprogressText").innerHTML="";
        }else{
                document.getElementById("videoprogressText").innerHTML=percent+"%";
        }
}
</script>
</head>
<body>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 远程采集';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='远程采集';</script>
<div class="floattop"><div class="itemtitle"><h3><?php if($copys=="" || $copys=="jk_p"){echo "九酷音乐采集";}else if($copys=="yyt_l_d" || $copys=="yyt_l_c"){echo "音悦台视频采集";} ?></h3><ul class="tab1">
<?php if($copys=="" || $copys=="jk_p"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?open=copys&opens=copys"><span>九酷音乐采集</span></a></li>
<?php if($copys=="yyt_l_d" || $copys=="yyt_l_c"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?open=copys&opens=copys&copys=yyt_l_d"><span>音悦台视频采集</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<li class="lightnum">采集过程中会自动检测重复数据并匹配歌手(建议安装歌手数据)，重复采集不会新增入库只会更新数据与附件</li>
<?php if($copys=="" || $copys=="jk_p"){echo "<li>采集规则：http://www.9ku.com/play/歌曲编号.htm</li><li>采集内容：歌名、歌手、封面、文本歌词、歌词文件、音频文件</li>";} ?>
<?php if($copys=="yyt_l_d" || $copys=="yyt_l_c"){echo "<li>采集内容：所属歌手、视频名称、视频地址、视频封面</li><li>计算公式：7(总栏数)X100(每栏页数)X20(每页条数)=14000(总条数)≈70MB(图片总容量)</li>";} ?>
</ul></td></tr>
</table>
<?php
switch($copys){
	case 'jk_p':
		jk_p_opening();
		break;
	case 'yyt_l_d':
		yyt_l_open();
		break;
	case 'yyt_l_c':
		yyt_l_opening();
		break;
	default:
		jk_p_open();
		break;
	}
?>
</div>
</body>
</html>
<?php function jk_p_open(){ ?>
<script type="text/javascript">
function is_jk_p(copys){
	if(copys.match(/\http:\/\/www.9ku.com\/play\//g) && copys.match(/\.htm/g) && copys.match(/\d+/g)) {
	        return true;
	}
	return false;
}
function CheckForm(){
        if(document.form.CD_Hits.value==""){
            asyncbox.tips("试听人气不能为空，请填写！", "wait", 1000);
            document.form.CD_Hits.focus();
            return false;
        }
        else if(document.form.CD_Points.value==""){
            asyncbox.tips("下载扣点不能为空，请填写！", "wait", 1000);
            document.form.CD_Points.focus();
            return false;
        }
        else if(document.form.CD_UserID.value==""){
            asyncbox.tips("会员编号不能为空，请填写！", "wait", 1000);
            document.form.CD_UserID.focus();
            return false;
        }
        else if(document.form.CD_Skin.value==""){
            asyncbox.tips("播放模板不能为空，请选择！", "wait", 1000);
            document.form.CD_Skin.focus();
            return false;
        }
        else if(document.form.urlget.value==""){
            asyncbox.tips("采集地址不能为空，请填写！", "wait", 1000);
            document.form.urlget.focus();
            return false;
        }
        else if(document.form.urlget.value!=="" && is_jk_p(document.form.urlget.value)==false){
            asyncbox.tips("采集地址不规范，请重新填写！", "error", 1000);
            document.form.urlget.focus();
            return false;
        }
        else {
            return true;
        }
}
</script>
<form action="?open=copys&opens=copys&copys=jk_p" method="post" name="form">
<table class="tb tb2">
<tr>
<td>所属专辑：<select name="CD_SpecialID" id="CD_SpecialID">
<option value="0">不选择</option>
<?php
global $db;
$sqlclass="select CD_ID,CD_Name from ".tname('special');
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
echo "<option value=\"".$row3['CD_ID']."\">".getlen("len","10",$row3['CD_Name'])."</option>";
}
}
?>
</select>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="pop.up('选择专辑', 'admin.php?iframe=special&so=form.CD_SpecialID', '500px', '400px', '40px');" class="addtr">选择</a></td>
<td>推荐星级：<select name="CD_IsBest" id="CD_IsBest">
<option value="0">不推荐</option>
<option value="1">一星</option>
<option value="2">二星</option>
<option value="3">三星</option>
<option value="4">四星</option>
<option value="5" selected>五星</option>
</select></td>
</tr>
<tr>
<td>试听人气：<input type="text" class="txt" value="0" name="CD_Hits" id="CD_Hits" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
<td class="td29">标题颜色：<select name="CD_Color">
<option value="">不选择</option>
<option style="background-color:#88b3e6;color:#88b3e6" value="#88b3e6">淡蓝</option>
<option style="background-color:#0C87CD;color:#0C87CD" value="#0C87CD">天蓝</option>
<option style="background-color:#FF6969;color:#FF6969" value="#FF6969" selected>粉红</option>
<option style="background-color:#F34F34;color:#F34F34" value="#F34F34">深红</option>
<option style="background-color:#93C366;color:#93C366" value="#93C366">淡绿</option>
<option style="background-color:#FA7A19;color:#FA7A19" value="#FA7A19">黄色</option>
</select></td>
</tr>
<tr>
<td>下载扣点：<input type="text" class="txt" value="0" name="CD_Points" id="CD_Points" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
<td>下载权限：<select name="CD_Grade" id="CD_Grade">
<option value="3">游客下载</option>
<option value="2">普通用户</option>
<option value="1">VIP 会员</option>
</select></td>
</tr>
<tr>
<td>会员编号：<input type="text" class="txt" value="1" name="CD_UserID" id="CD_UserID" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
<td>所属栏目：<select name="CD_ClassID" id="CD_ClassID">
<?php
global $db;
$sqlclass="select * from ".tname('class')." where CD_FatherID=1 and CD_SystemID=1";
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
echo "<option value=\"".$row3['CD_ID']."\">".$row3['CD_Name']."</option>";
}
}
?>
</select></td>
</tr>
<tr>
<td class="longtxt lightnum">采集地址：<input type="text" class="txt" value="" name="urlget" id="urlget"></td>
<td><input type="text" class="txt" value="play.html" name="CD_Skin" id="CD_Skin"><a href="javascript:void(0)" onclick="pop.up('选择模板', 'admin.php?iframe=template&f=form.CD_Skin', '500px', '400px', '40px');" class="addtr">选择模板</a></td>
</tr>
</table>
<table class="tb tb2">
<tr><td><input type="submit" class="btn" name="form" value="提交" onclick="return CheckForm();" /></td></tr>
</table>
</form>
<?php } function yyt_l_open(){ ?>
<h3>QianWei Music 提示</h3><div class="infobox"><br />
<table class="tb tb2">
<tr>
<td><select onchange="window.open(''+this.options[this.selectedIndex].value+'');">
<option value="http://www.yinyuetai.com/">音悦台</option>
<option value="http://mv.yinyuetai.com/all?sort=weekViews&area=ML">内地</option>
<option value="http://mv.yinyuetai.com/all?sort=weekViews&area=HT">港台</option>
<option value="http://mv.yinyuetai.com/all?sort=weekViews&area=US">欧美</option>
<option value="http://mv.yinyuetai.com/all?sort=weekViews&area=KR">韩语</option>
<option value="http://mv.yinyuetai.com/all?sort=weekViews&area=JP">日语</option>
<option value="http://mv.yinyuetai.com/all?sort=weekViews&area=ACG">二次元</option>
<option value="http://mv.yinyuetai.com/all?sort=weekViews&area=Other">其他</option>
</select></td>
</tr>
</table>
<br /><p class="margintop"><input type="button" class="btn" value="一键录入一万四千数据" onclick="location.href='?open=copys&opens=copys&copys=yyt_l_c&classid=1';"></p><br /></div>
<?php } function jk_p_opening(){
        if(!preg_match("/nobody/i",@file_get_contents($_POST['urlget']))){
                global $db;
		$sql="select cd_name,cd_nicheng from ".tname('user')." where cd_id=".SafeRequest("CD_UserID","post");
		if($row=$db->getrow($sql)){
                        $CD_User=$row['cd_name'];
                        $CD_UserNicheng=$row['cd_nicheng'];
                }else{
                        exit("<h3>QianWei Music 提示</h3><div class=\"infobox\"><br /><h4 class=\"marginbot normal\" style=\"color:red\">会员编号不存在，请重新填写！</h4><br /><p class=\"margintop\"><input type=\"button\" class=\"btn\" value=\"返回\" onclick=\"history.go(-1);\"></p><br /></div></div></body></html><script type=\"text/javascript\">setTimeout(\"history.back(1);\",3000);</script>");
                }
                echo "<h3>QianWei Music 提示</h3><div class=\"infobox\"><br />";
                echo "<table class=\"tb tb2\" style=\"border:1px solid #09C\">";
                echo "<tr><td>歌词已经下载</td><td><div id=\"lrcdownloaded\">0</div></td></tr>";
                echo "<tr><td>图片已经下载</td><td><div id=\"picdownloaded\">0</div></td></tr>";
                echo "<tr><td>音频文件大小</td><td><div id=\"songfilesize\">未知大小</div></td></tr>";
                echo "<tr><td>音频已经下载</td><td><div id=\"songdownloaded\">0</div></td></tr>";
                echo "<tr><td>音频完成进度</td><td><div id=\"songprogressbar\" style=\"float:left;width:1px;text-align:center;color:#FFFFFF;background-color:#09C\"></div><div id=\"songprogressText\" style=\"float:left\">0%</div></td></tr>";
                echo "</table>";
                echo "<br /><p class=\"margintop\"><input type=\"button\" class=\"btn\" value=\"撤销\" onclick=\"history.go(-1);\"></p><br /></div>";
                ob_start();
                $CD_SpecialID=SafeRequest("CD_SpecialID","post");
                $CD_IsBest=SafeRequest("CD_IsBest","post");
                $CD_Hits=SafeRequest("CD_Hits","post");
                $CD_Color=SafeRequest("CD_Color","post");
                $CD_Points=SafeRequest("CD_Points","post");
                $CD_Grade=SafeRequest("CD_Grade","post");
                $CD_UserID=SafeRequest("CD_UserID","post");
                $CD_ClassID=SafeRequest("CD_ClassID","post");
                $CD_Skin=SafeRequest("CD_Skin","post");
                $urlget=SafeRequest("urlget","post");
                $target=@file_get_contents($urlget);
                $playmode=explode("Array()",$target);
                $songget=explode("|",$playmode[1]);
                $songdown=$songget[4];
		$songpath="data/attachment/song/9ku/";
		creatdir($songpath);
                $songdir=$songpath.ReplaceStr(substr($urlget,24),"htm",rand(2,pow(2,24)).substr($songget[4],-4).".jpg");
                $lrcdown="http://www.9ku.com/lrcshow.asp?id=".ReplaceStr(substr($urlget,24),".htm","");
		$lrcpath="data/attachment/lrc/9ku/";
		creatdir($lrcpath);
                $lrcdir=$lrcpath.ReplaceStr(substr($urlget,24),"htm","lrc.jpg");
                $picget=explode("|",$playmode[1]);
                $picdown="http://img.9ku.com".$picget[7];
		$picpath="data/attachment/pic/9ku/";
		creatdir($picpath);
                $CD_Pic=$picpath.ReplaceStr(substr($urlget,24),"htm",substr($picget[7],-3));
                $wordget=ReplaceStr($urlget,"play","geci");
                $wordget=@file_get_contents($wordget);
                $wordget=explode("padding:10px 15px; background:#ff",$wordget);
                $wordget=explode(";\">",$wordget[1]);
                $wordget=explode("</div>",$wordget[1]);
                $wordtext=preg_replace('/\s/', '', strip_tags($wordget[0],"<br>"));
                $singerget=explode("|",$playmode[1]);
                $singertext=$singerget[3];
                if($CD_ID=$db->getone("select CD_ID from ".tname('singer')." where CD_Name like '%".$singertext."%'")){
                        $CD_SingerID=$CD_ID;
                }else{
                        $CD_SingerID=0;
                }
                $nameget=explode("|",$playmode[1]);
                $nametext=$nameget[1];
                if($row=$db->getrow("select CD_Url from ".tname('music')." where CD_Lrc='".$lrcdir."'")){
                        $file=fopen($lrcdown,"rb");
                        if($file){
                                $newf=fopen($lrcdir,"wb");
                                $downlen=0;
                                if($newf){
                                        while(!feof($file)){
                                                $data=fread($file,1024*8);
                                                $downlen+=strlen($data);
                                                fwrite($newf,ReplaceStr($data,"九酷音乐网",cd_webname),1024*8);
                                                echo "<script type=\"text/javascript\">setlrcdown('<span class=\"lightnum\">重复采集[".formatsize($downlen)."]</span>');</script>";
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
                        $file=fopen($picdown,"rb");
                        if($file){
                                $newf=fopen($CD_Pic,"wb");
                                $downlen=0;
                                if($newf){
                                        while(!feof($file)){
                                                $data=fread($file,1024*8);
                                                $downlen+=strlen($data);
                                                fwrite($newf,$data,1024*8);
                                                echo "<script type=\"text/javascript\">setpicdown('".formatsize($downlen)."');</script>";
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
                        $file=fopen($songdown,"rb");
                        if($file){
                                $headers=get_headers($songdown,1);
                                if(array_key_exists("Content-Length",$headers)){
                                        $filesize=$headers["Content-Length"];
                                }else{
                                        $filesize=strlen(@file_get_contents($songdown));
                                }
                                echo "<script type=\"text/javascript\">setsongsize(".$filesize.", '".formatsize($filesize)."');</script>";
                                $newf=fopen($row['CD_Url'],"wb");
                                $downlen=0;
                                if($newf){
                                        while(!feof($file)){
                                                $data=fread($file,1024*8);
                                                $downlen+=strlen($data);
                                                fwrite($newf,$data,1024*8);
                                                echo "<script type=\"text/javascript\">setsongdown(".$downlen.", '".formatsize($downlen)."');</script>";
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
                        $db->query("update ".tname('music')." set CD_Name='".$nametext."',CD_ClassID=".$CD_ClassID.",CD_SpecialID=".$CD_SpecialID.",CD_SingerID=".$CD_SingerID.",CD_User='".$CD_User."',CD_UserID=".$CD_UserID.",CD_UserNicheng='".$CD_UserNicheng."',CD_Pic='".$CD_Pic."',CD_Url='".$row['CD_Url']."',CD_DownUrl='".$row['CD_Url']."',CD_Word='".$wordtext."',CD_Hits=".$CD_Hits.",CD_IsBest=".$CD_IsBest.",CD_Points=".$CD_Points.",CD_Grade=".$CD_Grade.",CD_Color='".$CD_Color."',CD_Skin='".$CD_Skin."',CD_AddTime='".date('Y-m-d H:i:s')."',CD_Deleted=0,CD_Error=0,CD_Passed=0 where CD_Lrc='".$lrcdir."'");
                }else{
                        $file=fopen($lrcdown,"rb");
                        if($file){
                                $newf=fopen($lrcdir,"wb");
                                $downlen=0;
                                if($newf){
                                        while(!feof($file)){
                                                $data=fread($file,1024*8);
                                                $downlen+=strlen($data);
                                                fwrite($newf,ReplaceStr($data,"九酷音乐网",cd_webname),1024*8);
                                                echo "<script type=\"text/javascript\">setlrcdown('".formatsize($downlen)."');</script>";
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
                        $file=fopen($picdown,"rb");
                        if($file){
                                $newf=fopen($CD_Pic,"wb");
                                $downlen=0;
                                if($newf){
                                        while(!feof($file)){
                                                $data=fread($file,1024*8);
                                                $downlen+=strlen($data);
                                                fwrite($newf,$data,1024*8);
                                                echo "<script type=\"text/javascript\">setpicdown('".formatsize($downlen)."');</script>";
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
                        $file=fopen($songdown,"rb");
                        if($file){
                                $headers=get_headers($songdown,1);
                                if(array_key_exists("Content-Length",$headers)){
                                        $filesize=$headers["Content-Length"];
                                }else{
                                        $filesize=strlen(@file_get_contents($songdown));
                                }
                                echo "<script type=\"text/javascript\">setsongsize(".$filesize.", '".formatsize($filesize)."');</script>";
                                $newf=fopen($songdir,"wb");
                                $downlen=0;
                                if($newf){
                                        while(!feof($file)){
                                                $data=fread($file,1024*8);
                                                $downlen+=strlen($data);
                                                fwrite($newf,$data,1024*8);
                                                echo "<script type=\"text/javascript\">setsongdown(".$downlen.", '".formatsize($downlen)."');</script>";
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
                        $db->query("Insert ".tname('music')." (CD_Name,CD_ClassID,CD_SpecialID,CD_SingerID,CD_User,CD_UserID,CD_UserNicheng,CD_Pic,CD_Url,CD_DownUrl,CD_Word,CD_Lrc,CD_Hits,CD_DownHits,CD_FavHits,CD_DianGeHits,CD_GoodHits,CD_BadHits,CD_Server,CD_IsBest,CD_Points,CD_Grade,CD_Color,CD_Skin,CD_AddTime,CD_Deleted,CD_Error,CD_Passed) values ('".$nametext."',".$CD_ClassID.",".$CD_SpecialID.",".$CD_SingerID.",'".$CD_User."',".$CD_UserID.",'".$CD_UserNicheng."','".$CD_Pic."','".$songdir."','".$songdir."','".$wordtext."','".$lrcdir."',".$CD_Hits.",0,0,0,0,0,1,".$CD_IsBest.",".$CD_Points.",".$CD_Grade.",'".$CD_Color."','".$CD_Skin."','".date('Y-m-d H:i:s')."',0,0,0)");
                }
        }else{
                echo "<h3>QianWei Music 提示</h3><div class=\"infobox\"><br /><h4 class=\"marginbot normal\" style=\"color:red\">该采集地址可能存在版权原因，请重新填写！</h4><br /><p class=\"margintop\"><input type=\"button\" class=\"btn\" value=\"返回\" onclick=\"history.go(-1);\"></p><br /></div><script type=\"text/javascript\">setTimeout(\"history.back(1);\",3000);</script>";
        }
} function yyt_l_opening(){
        global $db;
	$CD_User=$_COOKIE['CD_AdminUserName'];
        echo "<h3>QianWei Music 提示</h3><div class=\"infobox\"><br />";
        echo "<table class=\"tb tb2\" style=\"border:1px solid #09C\">";
        echo "<tr><td>重复更新</td><td><div id=\"setnum\">0</div></td></tr>";
        echo "<tr><td>采集入库</td><td><div id=\"valuesnum\">0</div></td></tr>";
        echo "<tr><td>完成总量</td><td><div id=\"videonum\">0</div></td></tr>";
        echo "<tr><td>完成进度</td><td><div id=\"videoprogressbar\" style=\"float:left;width:1px;text-align:center;color:#FFFFFF;background-color:#09C\"></div><div id=\"videoprogressText\" style=\"float:left\">0%</div></td></tr>";
        echo "</table>";
        echo "<br /><p class=\"margintop\"><input type=\"button\" class=\"btn\" value=\"撤销\" onclick=\"history.go(-1);\"></p><br /></div>";
        ob_start();
	$num=0;
	$set=0;
	$values=0;
	$filepath="data/attachment/pic/yinyuetai/";
	creatdir($filepath);
	$classid=SafeRequest("classid","get");
	if($classid==1){
	        $classname="ML";
        }elseif($classid==2){
	        $classname="HT";
        }elseif($classid==3){
	        $classname="US";
        }elseif($classid==4){
	        $classname="KR";
        }elseif($classid==5){
	        $classname="JP";
        }elseif($classid==6){
	        $classname="ACG";
        }elseif($classid==7){
	        $classname="Other";
        }
        for($p=1;$p<=100;$p++){
                $page=@file_get_contents("http://mv.yinyuetai.com/all?pageType=page&area=".$classname."&sort=weekViews&page=".$p."&tab=allmv&parenttab=mv");
                $list=explode("thumb thumb_mv",$page);
                for($l=1;$l<=20;$l++){
                        $num=$num+1;
                        $swf=explode("/video/",$list[$l]);
                        $swf=explode("\" t",$swf[1]);
                        $play="http://player.yinyuetai.com/video/player/".$swf[0]."/v_0.swf";
                        $img=explode("<img src=\"",$list[$l]);
                        $img=explode("\" a",$img[1]);
                        $down=$img[0];
                        $dir=$filepath.$swf[0].".jpg";
                        $title=explode("\" alt=\"",$list[$l]);
                        $title=explode("\" title=\"",$title[1]);
                        $name=iconv('UTF-8', 'GB2312//IGNORE', $title[0]);
                        $artist=explode("<em class=\"c9\">",$list[$l]);
                        $artist=explode("title=\"",$artist[1]);
                        $artist=explode("\">",$artist[1]);
                        $singer=iconv('UTF-8', 'GB2312//IGNORE', $artist[0]);
                        if($CD_ID=$db->getone("select CD_ID from ".tname('singer')." where CD_Name like '%".$singer."%'")){
                                $CD_SingerID=$CD_ID;
                        }else{
                                $CD_SingerID=0;
                        }
                        if($db->getone("select CD_ID from ".tname('video')." where CD_Pic='".$dir."'")){
                                $db->query("update ".tname('video')." set CD_ClassID=".$classid.",CD_Name='".$name."',CD_SingerID=".$CD_SingerID.",CD_Play='".$play."',CD_AddTime='".date('Y-m-d H:i:s')."' where CD_Pic='".$dir."'");
                                $set=$set+1;
                                $file=fopen($down,"rb");
                                if($file){
                                        $newf=fopen($dir,"wb");
                                        $downlen=0;
                                        if($newf){
                                                while(!feof($file)){
                                                        $data=fread($file,1024*8);
                                                        $downlen+=strlen($data);
                                                        fwrite($newf,$data,1024*8);
                                                        echo "<script type=\"text/javascript\">videonum(".$num.", ".$classid.");setnum(".$set.");</script>";
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
                        }else{
                                $db->query("Insert ".tname('video')." (CD_ClassID,CD_Name,CD_User,CD_Pic,CD_SingerID,CD_Play,CD_Hits,CD_IsIndex,CD_IsBest,CD_Color,CD_AddTime) values (".$classid.",'".$name."','".$CD_User."','".$dir."',".$CD_SingerID.",'".$play."',0,0,1,'#0C87CD','".date('Y-m-d H:i:s')."')");
                                $values=$values+1;
                                $file=fopen($down,"rb");
                                if($file){
                                        $newf=fopen($dir,"wb");
                                        $downlen=0;
                                        if($newf){
                                                while(!feof($file)){
                                                        $data=fread($file,1024*8);
                                                        $downlen+=strlen($data);
                                                        fwrite($newf,$data,1024*8);
                                                        echo "<script type=\"text/javascript\">videonum(".$num.", ".$classid.");valuesnum(".$values.");</script>";
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
                        }
                }
        }
}
?>
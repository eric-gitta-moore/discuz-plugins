<?php
Administrator(9);
include "client/ucenter.php";
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>UCenter</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function change(type){
        if (type==1){
            ucenter.style.display='none';
        }
        if (type==2){
            ucenter.style.display='';
        }
}
</script>
</head>
<body>
<?php
switch($action){
	case 'save':
		save();
		break;
	default:
		main();
		break;
	}
?>
</body>
</html>
<?php function main(){ ?>
<form method="post" action="?iframe=ucenter&action=save">
<div class="container"><div class="floattop"><div class="itemtitle"><h3>UCenter</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<li class="lightnum">参考：连接后将与 UCenter 进行会员数据的整合。如果您不懂设置该 UCenter API 通信模块，则请登录 UCenter 用户管理中心自定义安装一条应用，然后复制该应用的 UCenter 配置信息粘贴到 ./client/ucenter.php 文件即可</li>
</ul></td></tr>
</table>
<table class="tb tb2">
<tr><th colspan="15" class="partition">UCenter API 通信模块</th></tr>
<tr><td colspan="2" class="td27">通信开关:</td></tr>
<tr><td class="vtop rowform">
<ul>
<?php if(cd_ucenter==0){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_ucenter" value="0" onclick="change(1);"<?php if(cd_ucenter==0){echo " checked";} ?>>&nbsp;中断</li>
<?php if(cd_ucenter==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_ucenter" value="1" onclick="change(2);"<?php if(cd_ucenter==1){echo " checked";} ?>>&nbsp;连接</li>
</ul>
</td><td class="vtop lightnum">注意：在连接的情况下，如果 配置信息 设置有误，将影响前台注册和登录功能</td></tr>
<tbody class="sub" id="ucenter"<?php if(cd_ucenter<>1){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2" class="td27">连接 UCenter 方式:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_CONNECT; ?>" name="UC_CONNECT"></td><td class="vtop tips2">默认为“mysql”</td></tr>
<tr><td colspan="2" class="td27">UCenter 数据库主机:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_DBHOST; ?>" name="UC_DBHOST"></td><td class="vtop tips2">默认为“localhost”</td></tr>
<tr><td colspan="2" class="td27">UCenter 数据库用户名:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_DBUSER; ?>" name="UC_DBUSER"></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">UCenter 数据库密码:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_DBPW; ?>" name="UC_DBPW"></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">UCenter 数据库名称:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_DBNAME; ?>" name="UC_DBNAME"></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">UCenter 数据库字符集:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_DBCHARSET; ?>" name="UC_DBCHARSET"></td><td class="vtop tips2">默认为“gbk”</td></tr>
<tr><td colspan="2" class="td27">UCenter 数据库表前缀:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_DBTABLEPRE; ?>" name="UC_DBTABLEPRE"></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">UCenter 数据库持久连接:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_DBCONNECT; ?>" name="UC_DBCONNECT"></td><td class="vtop tips2">默认为“0”</td></tr>
<tr><td colspan="2" class="td27">UCenter 通信密钥:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_KEY; ?>" name="UC_KEY"></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">UCenter URL:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_API; ?>" name="UC_API"></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">UCenter 字符集:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_CHARSET; ?>" name="UC_CHARSET"></td><td class="vtop tips2">默认为“gbk”</td></tr>
<tr><td colspan="2" class="td27">UCenter IP:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_IP; ?>" name="UC_IP"></td><td class="vtop tips2">默认为空</td></tr>
<tr><td colspan="2" class="td27">UCenter ID:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_APPID; ?>" name="UC_APPID"></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">UCenter 数据调用每页显示条数:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_PPP; ?>" name="UC_PPP"></td><td class="vtop tips2">默认为“20”</td></tr>
</tbody>
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="submit" class="btn" value="提交" /></div></td></tr>
</table>
</div>
</form>
<?php
}
function save(){
if(!submitcheck('submit')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
$cd_ucenter = SafeRequest("cd_ucenter","post");
$UC_CONNECT = SafeRequest("UC_CONNECT","post");
$UC_DBHOST = SafeRequest("UC_DBHOST","post");
$UC_DBUSER = SafeRequest("UC_DBUSER","post");
$UC_DBPW = SafeRequest("UC_DBPW","post");
$UC_DBNAME = SafeRequest("UC_DBNAME","post");
$UC_DBCHARSET = SafeRequest("UC_DBCHARSET","post");
$UC_DBTABLEPRE = SafeRequest("UC_DBTABLEPRE","post");
$UC_DBCONNECT = SafeRequest("UC_DBCONNECT","post");
$UC_KEY = SafeRequest("UC_KEY","post");
$UC_API = SafeRequest("UC_API","post");
$UC_CHARSET = SafeRequest("UC_CHARSET","post");
$UC_IP = SafeRequest("UC_IP","post");
$UC_APPID = SafeRequest("UC_APPID","post");
$UC_PPP = SafeRequest("UC_PPP","post");

$strs="<?php"."\r\n";
$strs=$strs."define('UC_CONNECT', '".$UC_CONNECT."');\r\n";
$strs=$strs."define('UC_DBHOST', '".$UC_DBHOST."');\r\n";
$strs=$strs."define('UC_DBUSER', '".$UC_DBUSER."');\r\n";
$strs=$strs."define('UC_DBPW', '".$UC_DBPW."');\r\n";
$strs=$strs."define('UC_DBNAME', '".$UC_DBNAME."');\r\n";
$strs=$strs."define('UC_DBCHARSET', '".$UC_DBCHARSET."');\r\n";
$strs=$strs."define('UC_DBTABLEPRE', '".$UC_DBTABLEPRE."');\r\n";
$strs=$strs."define('UC_DBCONNECT', '".$UC_DBCONNECT."');\r\n";
$strs=$strs."define('UC_KEY', '".$UC_KEY."');\r\n";
$strs=$strs."define('UC_API', '".$UC_API."');\r\n";
$strs=$strs."define('UC_CHARSET', '".$UC_CHARSET."');\r\n";
$strs=$strs."define('UC_IP', '".$UC_IP."');\r\n";
$strs=$strs."define('UC_APPID', '".$UC_APPID."');\r\n";
$strs=$strs."define('UC_PPP', '".$UC_PPP."');\r\n";
$strs=$strs."?>";
$str=file_get_contents("source/global/global_config.php");
$str=preg_replace('/"cd_ucenter","(.*?)"/','"cd_ucenter","'.$cd_ucenter.'"',$str);

if(!$fp = fopen('client/ucenter.php', 'w')) {
	ShowMessage("保存失败，文件{client/ucenter.php}没有写入权限！","?iframe=ucenter","infotitle3",3000,1);
	} else if(!$fp = fopen('source/global/global_config.php', 'w')) {
		ShowMessage("保存失败，文件{source/global/global_config.php}没有写入权限！","?iframe=ucenter","infotitle3",3000,1);
	}
	$ifile = new iFile('client/ucenter.php','w');
	$ifile->WriteFile($strs,3);
	$ifiles = new iFile('source/global/global_config.php','w');
	$ifiles->WriteFile($str,3);
	ShowMessage("恭喜您，设置保存成功！","?iframe=ucenter","infotitle2",1000,1);
}
?>
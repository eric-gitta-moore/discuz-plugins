<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $qianwei_in_username; ?> - <?php echo $title; ?> - <?php echo cd_webname; ?></title>
<meta name="Keywords" content="<?php echo cd_keywords; ?>" />
<meta name="Description" content="<?php echo cd_description; ?>" />
<link href="<?php echo $TempImg; ?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo cd_webpath; ?>source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $TempImg; ?>css/user.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $TempImg; ?>css/diange.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $TempImg; ?>js/lib.js"></script>
<script type="text/javascript" src="<?php echo cd_webpath; ?>source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $TempImg; ?>js/diange.js"></script>
<script type="text/javascript">var root_url="<?php echo cd_webpath; ?>"; var temp_url="<?php echo $TempImg; ?>";</script>
</head>
<body>
<script type="text/javascript" src="<?php echo cd_webpath; ?>source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<div class="top-bar">
<div class="box clearfix">
<script type="text/javascript">
function setHomepage(){
if (document.all){
document.body.style.behavior='url(#default#homepage)';
document.body.setHomePage(window.location.href);
}else if (window.sidebar){
if(window.netscape){
try{
netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
}catch (e){
asyncbox.tips("�ò�����������ܾ�����ʹ��������˵��ֶ����ã�", "error", 3000);
}
}
var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
prefs.setCharPref('browser.startup.homepage',window.location.href);
}else{
asyncbox.tips("�����������֧�֣���ʹ��������˵��ֶ����ã�", "wait", 3000);
}
}
function addFavorite(){
if (document.all){
try{
window.external.addFavorite(window.location.href,document.title);
}catch(e){
asyncbox.tips("�����ղ�ʧ�ܣ���ʹ�á�Ctrl+D��������ӣ�", "wait", 3000);
}
}else if (window.sidebar){
window.sidebar.addPanel(document.title, window.location.href, "");
}else{
asyncbox.tips("�����ղ�ʧ�ܣ���ʹ�á�Ctrl+D��������ӣ�", "error", 3000);
}
}
</script>
<div class="fl topBarLink"><a class="topBarLink01" style="cursor:pointer;" onclick="setHomepage();">��Ϊ��ҳ</a>&nbsp;&nbsp;<a class="topBarLink02" style="cursor:pointer;" onclick="addFavorite();">�����ղ�</a></div>
<div class="fr" id="userinfo"><script type="text/javascript">getlogin();</script></div>
</div>
</div>
<div class="headerWrap">
<div class="box header clearfix">
  <div class="logo"><a href="<?php echo cd_webpath; ?>"><img src="<?php echo $TempImg; ?>css/logo.png" /></a></div>
  <div class="logoSide clearfix">
  <div class="search clearfix">
<script type="text/javascript">
function s(){
var k=document.getElementById("ww").value;
if(k==""){asyncbox.tips("��������������û����ƣ�", "error", 1000);document.getElementById("ww").focus();return false;}else{document.formsearchbox.submit();}
}
</script>
      <div class="search-bar">
        <form name="formsearchbox" method="get" action="<?php echo cd_webpath; ?>search.php" target="_blank">
        <div class="clearfix" style="z-index:1005; zoom:1;">
        <input class="search-txt input-value" x-webkit-speech type="text" id="ww" value="" name="key" />
        <button class="search-btn" type="button" onclick="s()">����</button>
        </div>
      </form>
      </div>
  </div>
  </div>
</div>
</div>
<div class="navWrap">
<div class="nav clearfix">
  <ul class="navList clearfix">
<li><a href="<?php echo cd_webpath; ?>">�� ҳ</a></li>
<?php
global $db;
$query = $db->query("select * from ".tname('class')." where CD_FatherID=1 and CD_IsHide=0 order by CD_TheOrder asc LIMIT 0,1");
while ($row = $db->fetch_array($query)) {
?>
<li><a href="<?php echo LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],1); ?>">�����ĸ�</a></li>
<?php } ?>
<?php
$query = $db->query("select * from ".tname('class')." where CD_ID>4 and CD_ID<13 and CD_IsHide=0 order by CD_TheOrder asc LIMIT 0,1");
while ($row = $db->fetch_array($query)) {
?>
<li><a href="<?php echo LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],1); ?>">�������а�</a></li>
<?php } ?>
<li><a href="<?php echo $user_mod; ?>radio" target="_blank">������</a></li>
<?php
$query = $db->query("select * from ".tname('class')." where CD_ID>1 and CD_ID<5 and CD_IsHide=0 order by CD_TheOrder asc LIMIT 0,1");
while ($row = $db->fetch_array($query)) {
?>
<li><a href="<?php echo LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],1); ?>">�Ը�ר��</a></li>
<?php } ?>
<?php
$query = $db->query("select * from ".tname('class')." where CD_ID=1 and CD_IsHide=0");
while ($row = $db->fetch_array($query)) {
?>
<li><a href="<?php echo LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],1); ?>">���ִ�ȫ</a></li>
<?php } ?>
<li><a href="<?php echo $user_mod; ?>diangetai">���̨</a></li>
<?php
$query = $db->query("select * from ".tname('videoclass')." where CD_IsIndex=0 order by CD_TheOrder asc LIMIT 0,1");
while ($row = $db->fetch_array($query)) {
?>
<li><a href="<?php echo LinkClassUrl("video",$row['CD_ID'],"",1); ?>">����MV</a></li>
<?php } ?>
<li><a href="<?php echo cd_upath; ?>">��Ա����</a></li>
  </ul>
 </div>
</div>
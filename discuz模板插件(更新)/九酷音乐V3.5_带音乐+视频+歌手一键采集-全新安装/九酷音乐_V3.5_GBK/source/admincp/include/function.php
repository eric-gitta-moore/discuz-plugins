<?php
	$update_api="http://www.qianwe.net/qianwenet/load_gbk.xml";
	@set_time_limit(0);
	@ini_set('memory_limit', '-1');
	function ShowMessage($CD_Msg,$CD_Url,$CD_Style,$CD_Time,$CD_Type){
		if($CD_Type==1){
			echo "<div class=\"container\"><h3>QianWei Music 提示</h3><div class=\"infobox\"><h4 class=\"".$CD_Style."\">".$CD_Msg."</h4><script type=\"text/javascript\">setTimeout(\"window.location.href='".$CD_Url."';\",".$CD_Time.");</script><p class=\"marginbot\"><a href=\"".$CD_Url."\" class=\"lightlink\">如果您的浏览器没有自动跳转，请点击这里</a></p></div></div>";
		}elseif($CD_Type==2){
			echo "<div class=\"container\"><h3>QianWei Music 提示</h3><div class=\"infobox\"><h4 class=\"".$CD_Style."\">".$CD_Msg."</h4><script type=\"text/javascript\">setTimeout(\"".$CD_Url."\",".$CD_Time.");</script><p class=\"marginbot\"><a href=\"javascript:history.go(-1);\" class=\"lightlink\">如果您的浏览器没有自动跳转，请点击这里</a></p></div></div>";
		}else{
			echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
			echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
			echo "<head>";
			echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" />";
			echo "<meta http-equiv=\"x-ua-compatible\" content=\"ie=7\" />";
			echo "<title>提示信息</title>";
			echo "<link href=\"static/admincp/images/main.css\" rel=\"stylesheet\" type=\"text/css\" />";
			echo "</head>";
			echo "<body>";
			echo "<div class=\"container\"><h3>QianWei Music 提示</h3><div class=\"infobox\"><h4 class=\"".$CD_Style."\">".$CD_Msg."</h4><script type=\"text/javascript\">setTimeout(\"window.location.href='".$CD_Url."';\",".$CD_Time.");</script><p class=\"marginbot\"><a href=\"".$CD_Url."\" class=\"lightlink\">如果您的浏览器没有自动跳转，请点击这里</a></p></div></div>";
		}
			echo "</body>";
			echo "</html>";
			exit();
	}
	function Administrator($value){
		if(empty($_COOKIE['CD_AdminID']) || empty($_COOKIE['CD_Login']) || $_COOKIE['CD_Login']!==md5($_COOKIE['CD_AdminID'].$_COOKIE['CD_AdminUserName'].$_COOKIE['CD_AdminPassWord'].$_COOKIE['CD_Permission'])){
		        ShowMessage("未登录或登录已过期，请重新登录管理中心！","admin.php","infotitle3",3000,0);
		}
		setcookie("CD_Login",$_COOKIE['CD_Login'],time()+1800);
		if(!empty($_COOKIE['CD_Permission'])){
		        $array=explode(",",$_COOKIE['CD_Permission']);
		        $adminlogined=false;
		        for($i=0;$i<count($array);$i++){
		                if($array[$i]==$value){$adminlogined=true;}
		        }
		        if(!$adminlogined){
		                ShowMessage("权限不够，无法进入此页面！","?iframe=body","infotitle3",3000,0);
		        }
		}else{
		        ShowMessage("帐号异常，请重新登录管理中心！","admin.php","infotitle3",3000,0);
		}
	}
	function Menu_Index(){
		$body="<li><a href=\"?iframe=body\" hidefocus=\"true\" target=\"main\"><em onclick=\"menuNewwin(this)\" title=\"新窗口打开\"></em>管理中心首页</a></li>";
		$menu="<li><a href=\"?iframe=menu\" hidefocus=\"true\" target=\"main\"><em onclick=\"menuNewwin(this)\" title=\"新窗口打开\"></em>常用操作管理</a></li>";
		$li="";
		global $db;
		$query = $db->query("select * from ".tname('menu')." order by cd_order asc");
		while ($row = $db->fetch_array($query)) {
			$li=$li."<li><a href=\"".$row['cd_url']."\" hidefocus=\"true\" target=\"main\"><em onclick=\"menuNewwin(this)\" title=\"新窗口打开\"></em>".$row['cd_name']."</a></li>";
		}
		return $body.$menu.$li;
	}
	function Menu_App(){
		$app="<li><a href=\"http://www.qianwe.net/?P=".base64_encode($_SERVER['HTTP_HOST'])."&V=".base64_encode(cd_version)."&C=".base64_encode(cd_charset)."&N=".base64_encode(cd_webname)."&R=".base64_encode(cd_webpath)."\" hidefocus=\"true\" target=\"main\"><em onclick=\"menuNewwin(this)\" title=\"新窗口打开\"></em>应用中心</a></li>";
		$module="<li><a href=\"?iframe=module\" hidefocus=\"true\" target=\"main\"><em onclick=\"menuNewwin(this)\" title=\"新窗口打开\"></em>所有应用</a></li>";
		$li="";
		global $db;
		$query = $db->query("select * from ".tname('plugin')." order by CD_ID asc");
		while ($row = $db->fetch_array($query)) {
			$li=$li."<li><a href=\"plugin.php?open=".$row['CD_Dir']."&opens=".$row['CD_File']."\" hidefocus=\"true\" target=\"main\"><em onclick=\"menuNewwin(this)\" title=\"新窗口打开\"></em>".$row['CD_Name']."</a></li>";
		}
		return $app.$module.$li;
	}
?>
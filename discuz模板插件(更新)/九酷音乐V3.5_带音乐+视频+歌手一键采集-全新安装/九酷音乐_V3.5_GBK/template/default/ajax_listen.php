<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=gb2312");
include "../../source/global/global_conn.php";
include "../../source/global/global_inc.php";
close_browse();
global $db,$userlogined;
$action=SafeRequest("ac","get");
if($action=="ajax"){
        echo "<p class=\"hisQing clearfix\"><a onclick=\"qianwei.musicPlayer('";
        if($userlogined){
	        $hisid="";
	        $query = $db->query("select * from ".tname('listen')." where cd_uid=".$qianwei_in_userid." order by cd_addtime desc LIMIT 0,10");
	        $num=$db->num_rows($query);
	        if($num==0){
		        echo "";
	        }else{
	                while ($row = $db->fetch_array($query)) {
   	                        $hisid=$hisid."{song}".$row['cd_musicid'].",";
	                }
		        $hisid=$hisid."]";
		        $hisid=ReplaceStr($hisid,",]","");
		        echo $hisid;
	        }
	        echo "')\" style=\"cursor:pointer;\" id=\"playHis\">全部播放</a><a onclick=\"his_del('alldel', '')\" style=\"cursor:pointer;\" id=\"qingkong\">清空记录</a></p><ul class=\"hisList clearfix\" id=\"hislisten\">";
	        $i=0;
	        $query = $db->query("select * from ".tname('listen')." where cd_uid=".$qianwei_in_userid." order by cd_addtime desc LIMIT 0,10");
	        $num=$db->num_rows($query);
	        if($num==0){
		        echo "<li>没有试听记录！</li>";
	        }else{
	                while ($row = $db->fetch_array($query)) {
   	                        $i=$i+1;
   	                        echo "<li><input class=\"check\" type=\"checkbox\" value=\"{song}".$row['cd_musicid']."\"><span class=\"num\">".$i."</span><a href=\"".LinkUrl("music",$row['cd_classid'],1,$row['cd_musicid'])."\" target=\"_blank\" class=\"playList-songName\">".$row['cd_musicname']."</a><a href=\"".LinkClassUrl("music",$row['cd_classid'],1,1)."\" target=\"_blank\" class=\"playList-singerName\">".GetAlias("qianwei_class","CD_Name","CD_ID",$row['cd_classid'])."</a><span class=\"hisListBtn\"><a title=\"移除\" class=\"hisListBtn-delete\" onclick=\"his_del('del', '".$row['cd_musicid']."')\" style=\"cursor:pointer;\">移除</a></span></li>";
	                }
	        }
        }else{
	        echo "')\" style=\"cursor:pointer;\" id=\"playHis\">全部播放</a><a onclick=\"his_del('alldel', '')\" style=\"cursor:pointer;\" id=\"qingkong\">清空记录</a></p><ul class=\"hisList clearfix\" id=\"hislisten\"><li>请先登录！</li>";
        }
        echo "</ul><div class=\"hisCao clearfix\"><div class=\"ctrBtn clearfix\"><label class=\"allXuan\" style=\"cursor:pointer;\" id=\"allXuan\"><input class=\"check\" type=\"checkbox\" name=\"allXuan\" onclick=\"qianwei.quanxuan('hislisten')\">全选</label><a onclick=\"qianwei.player('hislisten')\" class=\"allAdd\" style=\"cursor:pointer;\">加入列表</a></div><div class=\"his-page\"></div></div>";
}elseif($action=="hisdel"){
        $id=SafeRequest("id","get");
        $do=SafeRequest("do","get");
        if($userlogined){
                if($do=="del"){
		        $sql="delete from ".tname('listen')." where cd_uid=".$qianwei_in_userid." and cd_musicid=".$id;
		        if($db->query($sql)){
			        echo "Msg_del";
		        }
                }else{
		        $sql="delete from ".tname('listen')." where cd_uid=".$qianwei_in_userid;
		        if($db->query($sql)){
			        echo "Msg_alldel";
		        }
                }
        }else{
                echo "Msg_login";
        }
}
?>
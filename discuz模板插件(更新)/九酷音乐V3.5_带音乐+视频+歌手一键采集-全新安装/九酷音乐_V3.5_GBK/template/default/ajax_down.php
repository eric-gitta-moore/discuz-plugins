<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=gb2312");
include "../../source/global/global_conn.php";
include "../../source/global/global_inc.php";
include "source/common.php";
global $db,$userlogined;
$action=SafeRequest("ac","get");
$CD_ID=SafeRequest("id","get");
$sql="select * from ".tname('music')." where CD_ID=".$CD_ID;
if($row=$db->getrow($sql)){
        if($row['CD_Server']<>0){
                $server=$db->getrow("select * from ".tname('server')." where CD_ID=".$row['CD_Server']);
                $download=$server['CD_DownUrl'].$row['CD_DownUrl'];
        }else{
                $download=$row['CD_DownUrl'];
        }
        if($action=="ajax"){
                close_browse();
                if($row['CD_Grade']==3){
                        echo "<h2>�������ƣ�<a href=\"".LinkUrl("music",$row['CD_ClassID'],1,$row['CD_ID'])."\" target=\"_blank\"><small><font color=\"#0C87CD\">".$row['CD_Name']."</font></small></a></h2>";
                        echo "<h2>�ϴ���Ա��<a href=\"".linkweburl(GetAlias("qianwei_user","cd_id","cd_name",$row['CD_User']),$row['CD_User'])."\" target=\"_blank\"><small><font color=\"#0C87CD\">".$row['CD_User']."</font></small></a></h2>";
                        echo "<h2>����Ȩ�ޣ�<small><font color=\"#93C366\">�ο�����</font></small></h2>";
                        echo "<h2>���ش�����<small><font color=\"#93C366\">".$row['CD_DownHits']."</font> ��</small></h2>";
                        echo "<form action=\"".$TempImg."ajax_down.php?ac=down&id=".$row['CD_ID']."\" method=\"post\" onsubmit=\"return doDown()\">";
                        echo "<p>��֤�룺<input type=\"text\" id=\"ReI_1\" value=\"\" onblur=\"doRe('Re_1',1,this)\" style=\"width:50px;height:20px;\" maxlength=\"4\" autocomplete=\"off\" />&nbsp;<img id=\"img_seccode\" src=\"".$TempImg."source/ajax.php?ac=seccode\" align=\"absmiddle\" />&nbsp;<a href=\"javascript:updateseccode()\">����</a>&nbsp;<span id=\"Re_1\">���</span></p>";
                        echo "<p><button type=\"submit\" class=\"sDian1\" style=\"cursor:pointer;\">��ȡ�ļ�</button>&nbsp;<button type=\"button\" onclick=\"window.open('".LinkErrorUrl($row['CD_ID'])."')\" class=\"sDian2\" style=\"cursor:pointer;\">�޷����أ�</button></p>";
                        echo "</form>";
                }elseif($row['CD_Grade']==2){
                        if(!$userlogined){
                                echo "<h2>�������ƣ�<a href=\"".LinkUrl("music",$row['CD_ClassID'],1,$row['CD_ID'])."\" target=\"_blank\"><small><font color=\"#0C87CD\">".$row['CD_Name']."</font></small></a></h2>";
                                echo "<h2>�ϴ���Ա��<a href=\"".linkweburl(GetAlias("qianwei_user","cd_id","cd_name",$row['CD_User']),$row['CD_User'])."\" target=\"_blank\"><small><font color=\"#0C87CD\">".$row['CD_User']."</font></small></a></h2>";
                                echo "<h2>����Ȩ�ޣ�<small><font color=\"#93C366\">��ͨ�û�</font></small></h2>";
                                echo "<h2>���ؿ۵㣺<small><font color=\"#F34F34\">".$row['CD_Points']."</font> ���</small></h2>";
                                echo "<h2>���ش�����<small><font color=\"#93C366\">".$row['CD_DownHits']."</font> ��</small></h2>";
                                echo "<h2>��δ��¼û������Ȩ�ޣ�����<a href=\"javascript:void(0)\" onclick=\"window.open('".cd_webpath.rewrite_url('user.php?do=login')."')\">��¼</a>��վ��</h2>";
                        }else{
                                if($qianwei_in_points<$row['CD_Points']){
                                        echo "<h2>�������ƣ�<a href=\"".LinkUrl("music",$row['CD_ClassID'],1,$row['CD_ID'])."\" target=\"_blank\"><small><font color=\"#0C87CD\">".$row['CD_Name']."</font></small></a></h2>";
                                        echo "<h2>�ϴ���Ա��<a href=\"".linkweburl(GetAlias("qianwei_user","cd_id","cd_name",$row['CD_User']),$row['CD_User'])."\" target=\"_blank\"><small><font color=\"#0C87CD\">".$row['CD_User']."</font></small></a></h2>";
                                        echo "<h2>����Ȩ�ޣ�<small><font color=\"#93C366\">��ͨ�û�</font></small></h2>";
                                        echo "<h2>���ؿ۵㣺<small><font color=\"#F34F34\">".$row['CD_Points']."</font> ���</small></h2>";
                                        echo "<h2>���ش�����<small><font color=\"#93C366\">".$row['CD_DownHits']."</font> ��</small></h2>";
                                        echo "<h2>���Ľ�Ҳ����޷����أ�����<a href=\"javascript:void(0)\" onclick=\"window.open('".cd_upath.rewrite_url('index.php?p=account&a=assets')."')\">��ֵ</a>��ң�</h2>";
                                }elseif($qianwei_in_points>=$row['CD_Points']){
                                        echo "<h2>�������ƣ�<a href=\"".LinkUrl("music",$row['CD_ClassID'],1,$row['CD_ID'])."\" target=\"_blank\"><small><font color=\"#0C87CD\">".$row['CD_Name']."</font></small></a></h2>";
                                        echo "<h2>�ϴ���Ա��<a href=\"".linkweburl(GetAlias("qianwei_user","cd_id","cd_name",$row['CD_User']),$row['CD_User'])."\" target=\"_blank\"><small><font color=\"#0C87CD\">".$row['CD_User']."</font></small></a></h2>";
                                        echo "<h2>����Ȩ�ޣ�<small><font color=\"#93C366\">��ͨ�û�</font></small></h2>";
                                        echo "<h2>���ؿ۵㣺<small><font color=\"#F34F34\">".$row['CD_Points']."</font> ���</small></h2>";
                                        echo "<h2>���ش�����<small><font color=\"#93C366\">".$row['CD_DownHits']."</font> ��</small></h2>";
                                        echo "<form action=\"".$TempImg."ajax_down.php?ac=down&id=".$row['CD_ID']."\" method=\"post\" onsubmit=\"return doDown()\">";
                                        echo "<p>��֤�룺<input type=\"text\" id=\"ReI_1\" value=\"\" onblur=\"doRe('Re_1',1,this)\" style=\"width:50px;height:20px;\" maxlength=\"4\" autocomplete=\"off\" />&nbsp;<img id=\"img_seccode\" src=\"".$TempImg."source/ajax.php?ac=seccode\" align=\"absmiddle\" />&nbsp;<a href=\"javascript:updateseccode()\">����</a>&nbsp;<span id=\"Re_1\">���</span></p>";
                                        echo "<p><button type=\"submit\" class=\"sDian1\" style=\"cursor:pointer;\">��ȡ�ļ�</button>&nbsp;<button type=\"button\" onclick=\"window.open('".LinkErrorUrl($row['CD_ID'])."')\" class=\"sDian2\" style=\"cursor:pointer;\">�޷����أ�</button></p>";
                                        echo "</form>";
                                }
                        }
                }elseif($row['CD_Grade']==1){
                        if(!$userlogined){
                                echo "<h2>�������ƣ�<a href=\"".LinkUrl("music",$row['CD_ClassID'],1,$row['CD_ID'])."\" target=\"_blank\"><small><font color=\"#0C87CD\">".$row['CD_Name']."</font></small></a></h2>";
                                echo "<h2>�ϴ���Ա��<a href=\"".linkweburl(GetAlias("qianwei_user","cd_id","cd_name",$row['CD_User']),$row['CD_User'])."\" target=\"_blank\"><small><font color=\"#0C87CD\">".$row['CD_User']."</font></small></a></h2>";
                                echo "<h2>����Ȩ�ޣ�<small><font color=\"#F34F34\">VIP ��Ա</font></small></h2>";
                                echo "<h2>���ش�����<small><font color=\"#93C366\">".$row['CD_DownHits']."</font> ��</small></h2>";
                                echo "<h2>��δ��¼û������Ȩ�ޣ�����<a href=\"javascript:void(0)\" onclick=\"window.open('".cd_webpath.rewrite_url('user.php?do=login')."')\">��¼</a>��վ��</h2>";
                        }else{
                                if($qianwei_in_grade<>$row['CD_Grade']){
                                        echo "<h2>�������ƣ�<a href=\"".LinkUrl("music",$row['CD_ClassID'],1,$row['CD_ID'])."\" target=\"_blank\"><small><font color=\"#0C87CD\">".$row['CD_Name']."</font></small></a></h2>";
                                        echo "<h2>�ϴ���Ա��<a href=\"".linkweburl(GetAlias("qianwei_user","cd_id","cd_name",$row['CD_User']),$row['CD_User'])."\" target=\"_blank\"><small><font color=\"#0C87CD\">".$row['CD_User']."</font></small></a></h2>";
                                        echo "<h2>����Ȩ�ޣ�<small><font color=\"#F34F34\">VIP ��Ա</font></small></h2>";
                                        echo "<h2>���ش�����<small><font color=\"#93C366\">".$row['CD_DownHits']."</font> ��</small></h2>";
                                        echo "<h2>���ĵȼ������޷����أ�����<a href=\"javascript:void(0)\" onclick=\"window.open('".cd_upath.rewrite_url('index.php?p=account&a=assets')."')\">��ͨ</a>VIP��</h2>";
                                }elseif($qianwei_in_grade=$row['CD_Grade']){
                                        echo "<h2>�������ƣ�<a href=\"".LinkUrl("music",$row['CD_ClassID'],1,$row['CD_ID'])."\" target=\"_blank\"><small><font color=\"#0C87CD\">".$row['CD_Name']."</font></small></a></h2>";
                                        echo "<h2>�ϴ���Ա��<a href=\"".linkweburl(GetAlias("qianwei_user","cd_id","cd_name",$row['CD_User']),$row['CD_User'])."\" target=\"_blank\"><small><font color=\"#0C87CD\">".$row['CD_User']."</font></small></a></h2>";
                                        echo "<h2>����Ȩ�ޣ�<small><font color=\"#F34F34\">VIP ��Ա</font></small></h2>";
                                        echo "<h2>���ش�����<small><font color=\"#93C366\">".$row['CD_DownHits']."</font> ��</small></h2>";
                                        echo "<form action=\"".$TempImg."ajax_down.php?ac=down&id=".$row['CD_ID']."\" method=\"post\" onsubmit=\"return doDown()\">";
                                        echo "<p>��֤�룺<input type=\"text\" id=\"ReI_1\" value=\"\" onblur=\"doRe('Re_1',1,this)\" style=\"width:50px;height:20px;\" maxlength=\"4\" autocomplete=\"off\" />&nbsp;<img id=\"img_seccode\" src=\"".$TempImg."source/ajax.php?ac=seccode\" align=\"absmiddle\" />&nbsp;<a href=\"javascript:updateseccode()\">����</a>&nbsp;<span id=\"Re_1\">���</span></p>";
                                        echo "<p><button type=\"submit\" class=\"sDian1\" style=\"cursor:pointer;\">��ȡ�ļ�</button>&nbsp;<button type=\"button\" onclick=\"window.open('".LinkErrorUrl($row['CD_ID'])."')\" class=\"sDian2\" style=\"cursor:pointer;\">�޷����أ�</button></p>";
                                        echo "</form>";
                                }
                        }
                }
        }elseif($action=="down"){
                if($row['CD_Grade']==3){
                        if($userlogined){
                                $downsql = "select cd_id from ".tname('down')." where cd_uid=".$qianwei_in_userid." and cd_musicid=".$row['CD_ID'];
                                $down = $db->getrow($downsql);
                                if($down){
                                        $db->query("update ".tname('down')." set cd_addtime=".time()." where cd_id=".$down['cd_id']);
                                }else{
                                        $setarr = array(
                                                'cd_uid' => $qianwei_in_userid,
                                                'cd_uname' => $qianwei_in_username,
                                                'cd_musicid' => $row['CD_ID'],
                                                'cd_musicname' => $row['CD_Name'],
                                                'cd_classid' => $row['CD_ClassID'],
                                                'cd_addtime' => time()
                                        );
                                        inserttable('down', $setarr, 1);
                                }
                                $feedsql = "select cd_id from ".tname('feed')." where cd_icon='down' and cd_title='����������' and cd_uid=".$qianwei_in_userid." and cd_dataid=".$row['CD_ID'];
                                $feed = $db->getrow($feedsql);
                                if($feed){
                                        $db->query("update ".tname('feed')." set cd_addtime=".date('Y-m-d H:i:s')." where cd_id=".$feed['cd_id']);
                                }else{
                                        $setarrs = array(
                                                'cd_uid' => $qianwei_in_userid,
                                                'cd_uname' => $qianwei_in_username,
                                                'cd_icon' => 'down',
                                                'cd_title' => '����������',
                                                'cd_data' => '�����ˡ�'.$row['CD_Name'].'��<a href="'.LinkUrl("music",$row['CD_ClassID'],1,$row['CD_ID']).'" target="_blank">����</a>',
                                                'cd_image' => '',
                                                'cd_imagelink' => '',
                                                'cd_dataid' => $row['CD_ID'],
                                                'cd_addtime' => date('Y-m-d H:i:s')
                                        );
                                        inserttable('feed',$setarrs,1);
                                }
                        }
                        $db->query("update ".tname('music')." set CD_DownHits=CD_DownHits+1 where CD_ID=".$row['CD_ID']);
                        header("Content-Type: application/force-download");
                        if(substr($download,-4)==".jpg"){
                                header("Content-Disposition: attachment; filename=".basename($download,".jpg"));
                        }else{
                                header("Content-Disposition: attachment; filename=".basename($download));
                        }
                        readfile($download);
                }elseif($row['CD_Grade']==2){
                        if(!$userlogined){
                                exit("<script type=\"text/javascript\">location.href='".cd_webpath.rewrite_url('user.php?do=login')."';</script>");
                        }else{
                                if($qianwei_in_points<$row['CD_Points']){
                                        exit("<script type=\"text/javascript\">location.href='".cd_upath.rewrite_url('index.php?p=account&a=assets')."';</script>");
                                }elseif($qianwei_in_points>=$row['CD_Points']){
                                        $cookies="down_music_".$row['CD_ID'];
                                        if(empty($_COOKIE[$cookies])){
                                                setcookie($cookies,"have",time()+86400);
                                                $points = sprintf("%01.0f",($row['CD_Points']*0.1));
                                                $db->query("update ".tname('user')." set cd_points=cd_points-".$row['CD_Points']." where cd_id=".$qianwei_in_userid);
                                                $db->query("update ".tname('user')." set cd_points=cd_points+".$points." where cd_name=".$row['CD_User']);
                                                $tomorrow = mktime(date("H"), date("i"), date("s"), date("m"), date("d")+7, date("Y"));
                                                $cd_enddate = date("Y-m-d H:i:s",$tomorrow);
                                                if($row['CD_Points'] >= 1){
                                                        $setarr = array(
                                                                'cd_type' => 0,
                                                                'cd_uid' => $qianwei_in_userid,
                                                                'cd_uname' => $qianwei_in_username,
                                                                'cd_icon' => 'down',
                                                                'cd_title' => '�����ر��˵�����',
                                                                'cd_points' => $row['CD_Points'],
                                                                'cd_state' => 1,
                                                                'cd_addtime' => date('Y-m-d H:i:s'),
                                                                'cd_endtime' => $cd_enddate
                                                        );
                                                        inserttable('bill', $setarr, 1);
                                                }
                                                if($points >= 1){
                                                        $setarr = array(
                                                                'cd_type' => 1,
                                                                'cd_uid' => $row['CD_UserID'],
                                                                'cd_uname' => $row['CD_User'],
                                                                'cd_icon' => 'down',
                                                                'cd_title' => '����������������',
                                                                'cd_points' => $points,
                                                                'cd_state' => 1,
                                                                'cd_addtime' => date('Y-m-d H:i:s'),
                                                                'cd_endtime' => $cd_enddate
                                                        );
                                                        inserttable('bill', $setarr, 1);
                                                }
                                        }
                                        $downsql = "select cd_id from ".tname('down')." where cd_uid=".$qianwei_in_userid." and cd_musicid=".$row['CD_ID'];
                                        $down = $db->getrow($downsql);
                                        if($down){
                                                $db->query("update ".tname('down')." set cd_addtime=".time()." where cd_id=".$down['cd_id']);
                                        }else{
                                                $setarr = array(
                                                        'cd_uid' => $qianwei_in_userid,
                                                        'cd_uname' => $qianwei_in_username,
                                                        'cd_musicid' => $row['CD_ID'],
                                                        'cd_musicname' => $row['CD_Name'],
                                                        'cd_classid' => $row['CD_ClassID'],
                                                        'cd_addtime' => time()
                                                );
                                                inserttable('down', $setarr, 1);
                                        }
                                        $feedsql = "select cd_id from ".tname('feed')." where cd_icon='down' and cd_title='����������' and cd_uid=".$qianwei_in_userid." and cd_dataid=".$row['CD_ID'];
                                        $feed = $db->getrow($feedsql);
                                        if($feed){
                                                $db->query("update ".tname('feed')." set cd_addtime=".date('Y-m-d H:i:s')." where cd_id=".$feed['cd_id']);
                                        }else{
                                                $setarrs = array(
                                                        'cd_uid' => $qianwei_in_userid,
                                                        'cd_uname' => $qianwei_in_username,
                                                        'cd_icon' => 'down',
                                                        'cd_title' => '����������',
                                                        'cd_data' => '�����ˡ�'.$row['CD_Name'].'��<a href="'.LinkUrl("music",$row['CD_ClassID'],1,$row['CD_ID']).'" target="_blank">����</a>',
                                                        'cd_image' => '',
                                                        'cd_imagelink' => '',
                                                        'cd_dataid' => $row['CD_ID'],
                                                        'cd_addtime' => date('Y-m-d H:i:s')
                                                );
                                                inserttable('feed',$setarrs,1);
                                        }
                                        $db->query("update ".tname('music')." set CD_DownHits=CD_DownHits+1 where CD_ID=".$row['CD_ID']);
                                        header("Content-Type: application/force-download");
                                        if(substr($download,-4)==".jpg"){
                                                header("Content-Disposition: attachment; filename=".basename($download,".jpg"));
                                        }else{
                                                header("Content-Disposition: attachment; filename=".basename($download));
                                        }
                                        readfile($download);
                                }
                        }
                }elseif($row['CD_Grade']==1){
                        if(!$userlogined){
                                exit("<script type=\"text/javascript\">location.href='".cd_webpath.rewrite_url('user.php?do=login')."';</script>");
                        }else{
                                if($qianwei_in_grade<>$row['CD_Grade']){
                                        exit("<script type=\"text/javascript\">location.href='".cd_upath.rewrite_url('index.php?p=account&a=assets')."';</script>");
                                }elseif($qianwei_in_grade=$row['CD_Grade']){
                                        $downsql = "select cd_id from ".tname('down')." where cd_uid=".$qianwei_in_userid." and cd_musicid=".$row['CD_ID'];
                                        $down = $db->getrow($downsql);
                                        if($down){
                                                $db->query("update ".tname('down')." set cd_addtime=".time()." where cd_id=".$down['cd_id']);
                                        }else{
                                                $setarr = array(
                                                        'cd_uid' => $qianwei_in_userid,
                                                        'cd_uname' => $qianwei_in_username,
                                                        'cd_musicid' => $row['CD_ID'],
                                                        'cd_musicname' => $row['CD_Name'],
                                                        'cd_classid' => $row['CD_ClassID'],
                                                        'cd_addtime' => time()
                                                );
                                                inserttable('down', $setarr, 1);
                                        }
                                        $feedsql = "select cd_id from ".tname('feed')." where cd_icon='down' and cd_title='����������' and cd_uid=".$qianwei_in_userid." and cd_dataid=".$row['CD_ID'];
                                        $feed = $db->getrow($feedsql);
                                        if($feed){
                                                $db->query("update ".tname('feed')." set cd_addtime=".date('Y-m-d H:i:s')." where cd_id=".$feed['cd_id']);
                                        }else{
                                                $setarrs = array(
                                                        'cd_uid' => $qianwei_in_userid,
                                                        'cd_uname' => $qianwei_in_username,
                                                        'cd_icon' => 'down',
                                                        'cd_title' => '����������',
                                                        'cd_data' => '�����ˡ�'.$row['CD_Name'].'��<a href="'.LinkUrl("music",$row['CD_ClassID'],1,$row['CD_ID']).'" target="_blank">����</a>',
                                                        'cd_image' => '',
                                                        'cd_imagelink' => '',
                                                        'cd_dataid' => $row['CD_ID'],
                                                        'cd_addtime' => date('Y-m-d H:i:s')
                                                );
                                                inserttable('feed',$setarrs,1);
                                        }
                                        $db->query("update ".tname('music')." set CD_DownHits=CD_DownHits+1 where CD_ID=".$row['CD_ID']);
                                        header("Content-Type: application/force-download");
                                        if(substr($download,-4)==".jpg"){
                                                header("Content-Disposition: attachment; filename=".basename($download,".jpg"));
                                        }else{
                                                header("Content-Disposition: attachment; filename=".basename($download));
                                        }
                                        readfile($download);
                                }
                        }
                }
        }elseif($action=="lrc"){
                header("Content-Type: application/force-download");
                if(substr(LinkLrcUrl($row['CD_Lrc']),-4)==".jpg"){
                        header("Content-Disposition: attachment; filename=".basename(LinkLrcUrl($row['CD_Lrc']),".jpg"));
                }else{
                        header("Content-Disposition: attachment; filename=".basename(LinkLrcUrl($row['CD_Lrc'])));
                }
                readfile(LinkLrcUrl($row['CD_Lrc']));
        }
}
?>
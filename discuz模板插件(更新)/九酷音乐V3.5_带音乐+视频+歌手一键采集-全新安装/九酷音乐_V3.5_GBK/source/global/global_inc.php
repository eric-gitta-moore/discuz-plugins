<?php
if(!Copyright_Style(cd_templatedir)){exit();}elseif(cd_weboffa==1){die(html_message("维护通知",cd_weboffb));}
global $db;
$userid=isset($_COOKIE["cd_id"]) ? $_COOKIE["cd_id"] : NULL;
$username=isset($_COOKIE["cd_name"]) ? $_COOKIE["cd_name"] : NULL;
$password=isset($_COOKIE["cd_password"]) ? $_COOKIE["cd_password"] : NULL;
$userlogintime = getsetting('userlogintime');
$deltime = $userlogintime - cd_onlinehold;
if(time()-$userlogintime>cd_onlinehold){
	$db->query("delete from ".tname('session')." where (cd_logintime < '$deltime')");
	$db->query("update ".tname('setting')." set cd_value='".time()."' where cd_key='userlogintime'");
}
$cd_ids = $db->getone("select cd_id from ".tname('session')." where cd_uid=".$userid." and cd_uname='".$username."'");
if($cd_ids){
	$db->query("update ".tname('session')." set cd_logintime='".time()."' where cd_uid=".$userid);
	$sql="select * from ".tname('user')." where cd_lock=0 and cd_id=".$userid." and cd_name='".$username."' and cd_password='".$password."'";
	$result=$db->query($sql);
	if($row=$db->fetch_array($result)){
		$userlogined=true;
		$qianwei_in_userid=$row["cd_id"];
		$qianwei_in_username=$row["cd_name"];
		$qianwei_in_nicheng=$row["cd_nicheng"];
		$qianwei_in_password=$row["cd_password"];
		$qianwei_in_question=$row["cd_question"];
		$qianwei_in_answer=$row["cd_answer"];
		$qianwei_in_email=$row["cd_email"];
		$qianwei_in_sex=$row["cd_sex"];
		$qianwei_in_regdate=$row["cd_regdate"];
		$qianwei_in_loginip=$row["cd_loginip"];
		$qianwei_in_loginnum=$row["cd_loginnum"];
		$qianwei_in_qq=$row["cd_qq"];
		$qianwei_in_logintime=$row["cd_logintime"];
		$qianwei_in_grade=$row["cd_grade"];
		$qianwei_in_lock=$row["cd_lock"];
		$qianwei_in_points=$row["cd_points"];
		$qianwei_in_birthday=$row["cd_birthday"];
		$qianwei_in_vipindate=$row["cd_vipindate"];
		$qianwei_in_vipenddate=$row["cd_vipenddate"];
		$qianwei_in_hits=$row["cd_hits"];
		$qianwei_in_isbest=$row["cd_isbest"];
		$qianwei_in_money=$row["cd_money"];
		$qianwei_in_friendnum=$row["cd_friendnum"];
		$qianwei_in_rank=$row["cd_rank"];
		$qianwei_in_uhits=$row["cd_uhits"];
		$qianwei_in_weekhits=$row["cd_weekhits"];
		$qianwei_in_musicnum=$row["cd_musicnum"];
		$qianwei_in_fansnum=$row["cd_fansnum"];
		$qianwei_in_idolnum=$row["cd_idolnum"];
		$qianwei_in_favnum=$row["cd_favnum"];
		$qianwei_in_address=$row["cd_address"];
		$qianwei_in_qqprivacy=$row["cd_qqprivacy"];
		$qianwei_in_introduce=$row["cd_introduce"];
		$qianwei_in_groupnum=$row["cd_groupnum"];
		$qianwei_in_checkmm=$row["cd_checkmm"];
		$qianwei_in_checkmusic=$row["cd_checkmusic"];
		$qianwei_in_review=$row["cd_review"];
		$qianwei_in_sign=$row["cd_sign"];
		$qianwei_in_signcumu=$row["cd_signcumu"];
		$qianwei_in_signtime=$row["cd_signtime"];
		$qianwei_in_ucenter=$row["cd_ucenter"];
		$qianwei_in_skinid=$row["cd_skinid"];
		$qianwei_in_vipgrade=$row["cd_vipgrade"];
		$qianwei_in_viprank=$row["cd_viprank"];
		$qianwei_in_verified=$row["cd_verified"];
		$qianwei_in_ulevel=$row["cd_ulevel"];
	}else{
		$userlogined=false;
	}
}else{
	$userlogined=false;
}
global $userlogined;
if($userlogined){
        if($qianwei_in_grade==1){
	        $vipenddate = strtotime($qianwei_in_vipenddate)-time();
	        if($vipenddate<=0){
		        $db->query("update ".tname('user')." set cd_grade=0,cd_vipgrade=0,cd_vipindate='0000-00-00 00:00:00',cd_vipenddate='0000-00-00 00:00:00' where cd_id=".$qianwei_in_userid);
		        $setarrs = array(
			        'cd_uid' => 0,
			        'cd_uname' => '系统消息',
			        'cd_uids' => $qianwei_in_userid,
			        'cd_unames' => $qianwei_in_username,
			        'cd_dataid' => 0,
			        'cd_readid' => 1,
			        'cd_content' => '尊敬的用户'.$qianwei_in_username.'，您的vip会员已到期，感谢您的使用！',
			        'cd_addtime' => date('Y-m-d H:i:s')
		        );
		        inserttable('message', $setarrs, 1);
	        }
        }
        if($qianwei_in_viprank>=1){
	        if($qianwei_in_grade==0){
		        $startdate=strtotime($qianwei_in_logintime);
		        $enddate=strtotime(date('Y-m-d H:i:s'));
		        $days=round(($enddate-$startdate)/3600/24);
		        if($days>=1){
			        $db->query("update ".tname('user')." set cd_viprank=cd_viprank-".($days*5)." where cd_viprank>=1 and cd_id=".$qianwei_in_userid);
		        }
	        }
        }
	if(getmrank($qianwei_in_rank,3) > $qianwei_in_ulevel){
		$db->query("update ".tname('user')." set cd_ulevel='".getmrank($qianwei_in_rank,3)."' where cd_id=".$qianwei_in_userid);
		$setarr = array(
			'cd_uid' => 0,
			'cd_uname' => '系统提示',
			'cd_uids' => $qianwei_in_userid,
			'cd_unames' => $qianwei_in_username,
			'cd_icon' => 'account',
			'cd_data' => '恭喜，您的用户等级升级到Lv'.getmrank($qianwei_in_rank,3),
			'cd_dataid' => 0,
			'cd_state' => 1,
			'cd_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('notice', $setarr, 1);
		$setarr = array(
			'cd_type' => 1,
			'cd_uid' => $qianwei_in_userid,
			'cd_uname' => $qianwei_in_username,
			'cd_icon' => 'update',
			'cd_title' => '用户等级提升至Lv'.getmrank($qianwei_in_rank,3),
			'cd_points' => (getmrank($qianwei_in_rank,3)*cd_upgradepoints),
			'cd_state' => 0,
			'cd_addtime' => date('Y-m-d H:i:s'),
			'cd_endtime' => getendtime()
		);
		inserttable('bill', $setarr, 1);
		$db->query("update ".tname('user')." set cd_points=cd_points+".(getmrank($qianwei_in_rank,3)*cd_upgradepoints)." where cd_id=".$qianwei_in_userid);
	}
	if($qianwei_in_musicnum>=cd_checkmusicnum && cd_checkmusicnum>=1 && $qianwei_in_checkmusic==0){
		$setarr = array(
			'cd_uid' => 0,
			'cd_uname' => '系统提示',
			'cd_uids' => $qianwei_in_userid,
			'cd_unames' => $qianwei_in_username,
			'cd_icon' => 'account',
			'cd_data' => '恭喜，系统已经将您自动授予音乐认证！',
			'cd_dataid' => 0,
			'cd_state' => 1,
			'cd_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('notice', $setarr, 1);
		$db->query("update ".tname('user')." set cd_checkmusic=1 where cd_id=".$qianwei_in_userid);
	}
}
?>
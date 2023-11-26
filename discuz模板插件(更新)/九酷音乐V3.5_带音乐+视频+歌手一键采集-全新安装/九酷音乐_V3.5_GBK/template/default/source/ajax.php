<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=gb2312");
include "../../../source/global/global_conn.php";
include "../../../source/global/global_inc.php";
$ac=SafeRequest("ac","get");
if($ac=="seccode"){
	Header("Content-type:image/png");
	$authnum_session = '';
	$str = '1234567890';
	$l = strlen($str);
	for($i=1;$i<=4;$i++){
		$num=rand(0,$l-1);
		$authnum_session.= $str[$num];
	}
	$_SESSION["codes"]=$authnum_session;
	srand((double)microtime()*1000000);
	$im = imagecreate(50,20);
	$black = ImageColorAllocate($im, 0,0,0);
	$white = ImageColorAllocate($im, 255,255,255);
	$gray = ImageColorAllocate($im, 200,200,200);
	imagefill($im,68,30,$gray);
	$li = ImageColorAllocate($im, 220,220,220);
	for($i=0;$i<3;$i++){
		imageline($im,rand(0,30),rand(0,21),rand(20,40),rand(0,21),$li);
	}
	imagestring($im, 5, 8, 2, $authnum_session, $white);
	for($i=0;$i<90;$i++){
		imagesetpixel($im, rand()%70 , rand()%30 , $gray);
	}
	ImagePNG($im);
	ImageDestroy($im);
}elseif($ac=="post_comment"){
	global $db,$userlogined;
	if(!$userlogined){exit("Msg_031");}
	$CD_ID=SafeRequest("id","get");
	$CD_Content=SafeRequest("content","get");
        $cookies="comment_music_".$CD_ID;
	if(!empty($_COOKIE[$cookies])){
		echo "Msg_025";
	}else{
		setcookie($cookies,"have",time()+30);
		$sql="Insert ".tname('comment')." (cd_channel,cd_dataid,cd_content,cd_uid,cd_uname,cd_uip,cd_addtime) values (4,".$CD_ID.",'".unescape($CD_Content)."',".$qianwei_in_userid.",'".$qianwei_in_username."','".getonlineip()."','".date('Y-m-d H:i:s')."')";
		if($db->query($sql)){
		        echo "Msg_024";
		}
	}
}elseif($ac=="login_comment"){
	$cd_username=unescape(SafeRequest("name","get"));
	$cd_password=SafeRequest("pwd","get");
	$cd_logintime=date('Y-m-d H:i:s');
	$cd_loginip=getonlineip();
	$cookietime=86400;
	$cd_password=substr(md5($cd_password),8,16);
	global $db;
	$sql = "select cd_id from ".tname('user')." where cd_name='".$cd_username."' and cd_password='".$cd_password."'";
	$cd_id = $db->getone($sql);
	if(cd_ucenter==1){
		include_once "../../../client/ucenter.php";
		include_once "../../../client/client.php";
		list($uid, $username, $password, $email) = uc_user_login(unescape($_GET['name']), $_GET['pwd']);
		if($uid > 0) {
		        if(!$db->getone("select cd_id from ".tname('user')." where cd_name='".$username."'")) {
		                $sqls="insert into `".tname('user')."` (cd_name,cd_nicheng,cd_password,cd_email,cd_regdate,cd_loginnum,cd_grade,cd_lock,cd_points,cd_hits,cd_isbest,cd_friendnum,cd_rank,cd_uhits,cd_weekhits,cd_musicnum,cd_fansnum,cd_idolnum,cd_favnum,cd_qqprivacy,cd_groupnum,cd_checkmm,cd_checkmusic,cd_review,cd_sign,cd_signcumu,cd_ucenter,cd_skinid,cd_vipgrade,cd_viprank,cd_ulevel) values ('".$username."','UCenter_".$uid."','".substr(md5($password),8,16)."','".$email."','".date('Y-m-d H:i:s')."','0','0','0','".cd_points."','0','0','0','".cd_userrank."','0','0','0','0','0','0','0','0','0','0','0','0','0','".$uid."','0','0','0','0')";
		                if($db->query($sqls)) {
		                        $sqlss = "select cd_id from ".tname('user')." where cd_name='".$username."' and cd_password='".substr(md5($password),8,16)."'";
		                        $cd_ids = $db->getone($sqlss);
		                        if($cd_ids){
			                        $db->query("update ".tname('user')." set cd_loginnum=cd_loginnum+1,cd_loginip='".$cd_loginip."',cd_logintime='".$cd_logintime."' where cd_id=".$cd_ids);
			                        $db->query("delete from ".tname('session')." where cd_uid=".$cd_ids);
			                        $db->query("Insert ".tname('session')." (cd_uid,cd_uname,cd_uip,cd_logintime) values (".$cd_ids.",'".$username."','".getonlineip()."','".time()."')");
			                        setcookie("cd_id",$cd_ids,time()+86400,cd_cookiepath);
			                        setcookie("cd_name",$username,time()+86400,cd_cookiepath);
			                        setcookie("cd_password",substr(md5($password),8,16),time()+86400,cd_cookiepath);
		                                if(cd_points >= 1){
			                                $setarr = array(
				                                'cd_type' => 1,
				                                'cd_uid' => $cd_ids,
				                                'cd_uname' => $username,
				                                'cd_icon' => 'logon',
				                                'cd_title' => '新用户注册',
				                                'cd_points' => cd_points,
				                                'cd_state' => 0,
				                                'cd_addtime' => date('Y-m-d H:i:s'),
				                                'cd_endtime' => getendtime()
			                                );
			                                inserttable('bill', $setarr, 1);
		                                }
		                                if(cd_pointsuaa >= 1){
			                                $setarr = array(
				                                'cd_type' => 1,
				                                'cd_uid' => $cd_ids,
				                                'cd_uname' => $username,
				                                'cd_icon' => 'app',
				                                'cd_title' => '每日登录',
				                                'cd_points' => cd_pointsuaa,
				                                'cd_state' => 0,
				                                'cd_addtime' => date('Y-m-d H:i:s'),
				                                'cd_endtime' => getendtime()
			                                );
			                                inserttable('bill', $setarr, 1);
		                                }
			                        $db->query("update ".tname('user')." set cd_points=cd_points+".cd_pointsuaa.",cd_rank=cd_rank+".cd_pointsuab." where cd_id=".$cd_ids);
			                        exit("Msg_022");
		                        }
		                }
		        }
		}
	}
	if($cd_id){
	        $row = $db->getrow("select cd_id,cd_lock,cd_vipgrade,cd_name,cd_password from ".tname('user')." where cd_id=".$cd_id);
	        if($row["cd_lock"]==1){
		        echo "Msg_027";
	        }else{
	                $cd_ids = $db->getone("select cd_id from ".tname('session')." where cd_uid=".$cd_id);
	                if($cd_ids){
	                        updatetable('session', array('cd_logintime'=>time()), array('cd_id'=>$cd_ids));
	                }else{
		                $setarr = array(
			                'cd_uid' => $cd_id,
			                'cd_uname' => $cd_username,
			                'cd_uip' => $cd_loginip,
			                'cd_logintime' => time()
		                );
		                inserttable('session', $setarr, 1);
	                }
		        if($db->getone("select cd_id from ".tname('user')." where DateDiff(DATE(cd_logintime),'".date('Y-m-d')."')=0 and cd_id=".$cd_id)) {
		                $db->query("update ".tname('user')." set cd_loginnum=cd_loginnum+1,cd_loginip='".$cd_loginip."',cd_logintime='".$cd_logintime."' where cd_id=".$cd_id);
		        }else{
		                if(cd_pointsuaa >= 1){
			                $setarr = array(
				                'cd_type' => 1,
				                'cd_uid' => $cd_id,
				                'cd_uname' => $cd_username,
				                'cd_icon' => 'app',
				                'cd_title' => '每日登录',
				                'cd_points' => cd_pointsuaa,
				                'cd_state' => 0,
				                'cd_addtime' => date('Y-m-d H:i:s'),
				                'cd_endtime' => getendtime()
			                );
			                inserttable('bill', $setarr, 1);
		                }
		                if($row["cd_vipgrade"]==1){
			                $cd_speed = 5;
		                }elseif($row["cd_vipgrade"]==2){
			                $cd_speed = 10;
		                }else{
			                $cd_speed = 0;
		                }
		                $db->query("update ".tname('user')." set cd_points=cd_points+".cd_pointsuaa.",cd_rank=cd_rank+".cd_pointsuab.",cd_viprank=cd_viprank+".$cd_speed.",cd_loginnum=cd_loginnum+1,cd_loginip='".$cd_loginip."',cd_logintime='".$cd_logintime."' where cd_id=".$cd_id);
		        }
	                setcookie("cd_id",$row["cd_id"],time()+$cookietime,cd_cookiepath);
	                setcookie("cd_name",$row["cd_name"],time()+$cookietime,cd_cookiepath);
	                setcookie("cd_password",$row["cd_password"],time()+$cookietime,cd_cookiepath);
	                if(cd_ucenter==1){
		                echo "Msg_034";
	                }else{
		                echo "Msg_028";
	                }
	        }
	}else{
	        echo "Msg_023";
	}
}elseif($ac=="logout_comment"){
	global $db,$userlogined;
	if(!$userlogined){exit("Msg_029");}
	$db->query("delete from ".tname('session')." where cd_uid=".$qianwei_in_userid);
	setcookie("cd_id","",time()-1,cd_cookiepath);
	setcookie("cd_name","",time()-1,cd_cookiepath);
	setcookie("cd_password","",time()-1,cd_cookiepath);
	if(cd_ucenter==1){
	        die("Msg_035");
	}else{
	        die("Msg_029");
	}
}elseif($ac=="download"){
	$seccode=SafeRequest("seccode","get");
	$template=cd_webpath.substr(substr(cd_templatedir,0,strlen(cd_templatedir)-1),0,strrpos(substr(cd_templatedir,0,strlen(cd_templatedir)-1),'/')+1);
	if($seccode != $_SESSION["codes"]) {
		die("<img src='".$template."css/check_error.gif' />&nbsp;验证码不正确，请更改！");
	}else{
		die("<img src='".$template."css/check_right.gif' />");
	}
}elseif($ac=="error"){
	$cd_id=SafeRequest("id","get");
	$cd_seccode=SafeRequest("code","get");
	if($cd_seccode != $_SESSION["codes"]){
		echo "Msg_001";
	}else{
		updatetable('music', array('CD_Error'=>1), array('CD_ID'=>$cd_id));
		echo "Msg_003";
	}
}elseif($ac=="favorites"){
	global $db,$userlogined;
	if(!$userlogined){exit("Msg_031");}
	$cd_id=SafeRequest("id","get");
	$cd_seccode=SafeRequest("code","get");
	$sql = "select * from ".tname('music')." where CD_ID=".$cd_id;
	if($cd_seccode != $_SESSION["codes"]){
		echo "Msg_001";
	}elseif($row = $db->getrow($sql)){
                $cd_ids = $db->getone("select cd_id from ".tname('fav')." where cd_uid=".$qianwei_in_userid." and cd_musicid=".$cd_id);
                if($cd_ids){
		        echo "Msg_004";
		}else{
		        $db->query("update ".tname('music')." set CD_FavHits=CD_FavHits+1 where CD_ID=".$cd_id);
			$setarr = array(
				'cd_uid' => $qianwei_in_userid,
				'cd_uname' => $qianwei_in_username,
				'cd_musicid' => $row['CD_ID'],
				'cd_musicname' => $row['CD_Name'],
				'cd_classid' => $row['CD_ClassID'],
				'cd_addtime' => time()
			);
			inserttable('fav', $setarr, 1);
		        $db->query("update ".tname('user')." set cd_favnum=cd_favnum+1 where cd_id=".$qianwei_in_userid);
			$setarrs = array(
				'cd_uid' => $qianwei_in_userid,
				'cd_uname' => $qianwei_in_username,
				'cd_icon' => 'favorites',
				'cd_title' => '收藏了音乐',
				'cd_data' => '收藏了《'.$row['CD_Name'].'》<a href="'.LinkUrl("music",$row['CD_ClassID'],1,$row['CD_ID']).'" target="_blank">试听</a>',
				'cd_image' => '',
				'cd_imagelink' => '',
				'cd_dataid' => $row['CD_ID'],
				'cd_addtime' => date('Y-m-d H:i:s')
			);
			inserttable('feed', $setarrs, 1);
			echo "Msg_005";
		}
	}
}elseif($ac=="register"){
	global $db;
	$username=unescape(SafeRequest("name","get"));
	$password=SafeRequest("pwd","get");
	$nicheng=unescape(SafeRequest("nick","get"));
	$sex=SafeRequest("sex","get");
	$year=SafeRequest("year","get");
	$month=SafeRequest("month","get");
	$day=SafeRequest("day","get");
	$birthday=$year."-".$month."-".$day;
	$sheng=SafeRequest("sheng","get");
	$shi=SafeRequest("shi","get");
	$address=unescape($sheng."-".$shi);
	$email=SafeRequest("email","get");
	$qq=SafeRequest("qq","get");
	$points=cd_points;
	$userrank=cd_userrank;
	$logintime=date('Y-m-d H:i:s');
	$loginip=getonlineip();
	$seccode=SafeRequest("code","get");
	$name = $db->getone("select cd_id from ".tname('user')." where cd_name='".$username."'");
	$nick = $db->getone("select cd_id from ".tname('user')." where cd_nicheng='".$nicheng."'");
	$mail = $db->getone("select cd_id from ".tname('user')." where cd_email='".$email."'");
	if($seccode != $_SESSION["codes"]){
		echo "Msg_001";
	}elseif($name){
		echo "Msg_006";
	}elseif($nick){
		echo "Msg_007";
	}elseif($mail){
		echo "Msg_030";
	}else{
		$cd_ucenter = 0;
		if(cd_ucenter==1){
		        include_once "../../../client/ucenter.php";
		        include_once "../../../client/client.php";
		        $uid = uc_user_register(unescape($_GET['name']), $_GET['pwd'], $_GET['email']);
		        if($uid <= 0) {
			        if($uid == -1) {
				        exit("Msg_014");
			        } elseif($uid == -2) {
				        exit("Msg_015");
			        } elseif($uid == -3) {
				        exit("Msg_016");
			        } elseif($uid == -4) {
				        exit("Msg_017");
			        } elseif($uid == -5) {
				        exit("Msg_018");
			        } elseif($uid == -6) {
				        exit("Msg_019");
			        } else {
				        exit("Msg_020");
			        }
		        }
		        $ucid = uc_get_user(unescape($_GET['name']));
		        $cd_ucenter = $ucid[0];
		}
	        $setarr = array(
		        'cd_name' => $username,
		        'cd_nicheng' => $nicheng,
		        'cd_password' => substr(md5($password),8,16),
		        'cd_question' => '',
		        'cd_answer' => '',
		        'cd_email' => $email,
		        'cd_sex' => $sex,
		        'cd_regdate' => date('Y-m-d H:i:s'),
		        'cd_loginip' => getonlineip(),
		        'cd_loginnum' => 0,
		        'cd_qq' => $qq,
		        'cd_logintime' => date('Y-m-d H:i:s'),
		        'cd_grade' => 0,
		        'cd_lock' => 0,
		        'cd_points' => $points,
		        'cd_birthday' => $birthday,
		        'cd_vipindate' => '0000-00-00 00:00:00',
		        'cd_vipenddate' => '0000-00-00 00:00:00',
		        'cd_hits' => 0,
		        'cd_isbest' => 0,
		        'cd_money' => 0,
		        'cd_friendnum' => 0,
		        'cd_rank' => $userrank,
		        'cd_uhits' => 0,
		        'cd_weekhits' => 0,
		        'cd_musicnum' => 0,
		        'cd_fansnum' => 0,
		        'cd_idolnum' => 0,
		        'cd_favnum' => 0,
		        'cd_address' => $address,
		        'cd_qqprivacy' => 0,
		        'cd_introduce' => '这家伙很懒，什么都没留下。',
		        'cd_groupnum' => 0,
		        'cd_checkmm' => 0,
		        'cd_checkmusic' => 0,
		        'cd_review' => 0,
		        'cd_sign' => 0,
		        'cd_signcumu' => 0,
		        'cd_signtime' => '0000-00-00 00:00:00',
		        'cd_ucenter' => $cd_ucenter,
		        'cd_skinid' => 0,
		        'cd_vipgrade' => 0,
		        'cd_viprank' => 0,
		        'cd_verified' => '',
		        'cd_ulevel' => 0,
		        'cd_qqopen' => '',
		        'cd_qqimg' => ''
	        );
	        inserttable('user', $setarr, 1);
	        if(cd_fsmessage=="yes"){
		        $rowlast = $db->getrow("select cd_id from ".tname('user')." where cd_name='".$username."' order by cd_id desc");
		        $cd_lastid = $rowlast['cd_id'];
		        $setarrs = array(
			        'cd_uid' => 0,
			        'cd_uname' => '系统消息',
			        'cd_uids' => $cd_lastid,
			        'cd_unames' => $username,
			        'cd_dataid' => 0,
			        'cd_readid' => 1,
			        'cd_content' => cd_bodymessage,
			        'cd_addtime' => date('Y-m-d H:i:s')
		        );
		        inserttable('message', $setarrs, 1);
	        }
	        $sql = "select cd_id from ".tname('user')." where cd_name='".$username."' and cd_password='".substr(md5($password),8,16)."'";
                $cd_id = $db->getone($sql);
	        if($cd_id){
		        $db->query("update ".tname('user')." set cd_loginnum=cd_loginnum+1,cd_loginip='".$loginip."',cd_logintime='".$logintime."' where cd_id=".$cd_id);
		        $db->query("delete from ".tname('session')." where cd_uid=".$cd_id);
		        $db->query("Insert ".tname('session')." (cd_uid,cd_uname,cd_uip,cd_logintime) values (".$cd_id.",'".$username."','".$loginip."','".time()."')");
		        setcookie("cd_id",$cd_id,time()+86400,cd_cookiepath);
		        setcookie("cd_name",$username,time()+86400,cd_cookiepath);
		        setcookie("cd_password",substr(md5($password),8,16),time()+86400,cd_cookiepath);
		        if($points >= 1){
			        $setarr = array(
				        'cd_type' => 1,
				        'cd_uid' => $cd_id,
				        'cd_uname' => $username,
				        'cd_icon' => 'logon',
				        'cd_title' => '新用户注册',
				        'cd_points' => $points,
				        'cd_state' => 0,
				        'cd_addtime' => date('Y-m-d H:i:s'),
				        'cd_endtime' => getendtime()
			        );
			        inserttable('bill', $setarr, 1);
		        }
		        if(cd_pointsuaa >= 1){
			        $setarr = array(
				        'cd_type' => 1,
				        'cd_uid' => $cd_id,
				        'cd_uname' => $username,
				        'cd_icon' => 'app',
				        'cd_title' => '每日登录',
				        'cd_points' => cd_pointsuaa,
				        'cd_state' => 0,
				        'cd_addtime' => date('Y-m-d H:i:s'),
				        'cd_endtime' => getendtime()
			        );
			        inserttable('bill', $setarr, 1);
		        }
		        $db->query("update ".tname('user')." set cd_points=cd_points+".cd_pointsuaa.",cd_rank=cd_rank+".cd_pointsuab." where cd_id=".$cd_id);
	        }
	        if(cd_lockmail==0){
	                include_once "../../../source/plugin/mail/mail.php";
	                $smtp=cd_webmailsmtp;
	                $youremail=cd_webmail;
	                $password=cd_webmailpswd;
                        $mail=new PHPMailer();
                        $mail->IsSMTP();
                        $mail->SMTPAuth=true;
                        $mail->Host=$smtp;
                        $mail->Username=$youremail;
                        $mail->Password=$password;
                        $mail->From=$youremail;
                        $mail->FromName=cd_webname;
	                $ip=getonlineip();
	                $mail->Subject=$nicheng." - 注册信息 - ".cd_webname;
	                $time=date('Y-m-d H:i:s');
	                $mail->AddAddress($email,$nicheng);
	                $html='亲爱的'.$nicheng.'('.$ip.')，您已经注册成为'.cd_webname.'的会员，请您在发表言论时，遵守当地法律法规。如果您有什么疑问可以联系管理员，Email:'.cd_webmail.'<br><br>http://'.$_SERVER['HTTP_HOST'].cd_webpath.'<br>'.$time;
	                $mail->MsgHTML($html);
	                $mail->IsHTML(true);
	                if(!$mail->Send()){
		                echo "Msg_008";
	                }else{
		                echo "Msg_013";
	                }
	        }else{
		        echo "Msg_008";
	        }
	}
}elseif($ac=="lostpasswd"){
	$username=unescape(SafeRequest("name","get"));
	$question=unescape(SafeRequest("question","get"));
	$answer=unescape(SafeRequest("answer","get"));
	$password=SafeRequest("pwd","get");
	$seccode=SafeRequest("code","get");
	$cd_answer=substr(md5($answer),8,16);
	$cd_password=substr(md5($password),8,16);
	global $db;
	$sql = "select cd_id from ".tname('user')." where cd_name='".$username."'";
        $cd_id = $db->getone($sql);
	if($seccode != $_SESSION["codes"]){
		echo "Msg_001";
	}elseif($cd_id){
		$row = $db->getrow("select * from ".tname('user')." where cd_id=".$cd_id);
		if($question<>$row["cd_question"]){
			echo "Msg_009";
		}elseif($cd_answer<>$row["cd_answer"]){
			echo "Msg_010";
		}else{
			$db->query("update ".tname('user')." set cd_password='".$cd_password."' where cd_id=".$cd_id);
			echo "Msg_011";
		}
	}else{
		echo "Msg_012";
	}
}elseif($ac=="login"){
	$cd_username=unescape(SafeRequest("name","get"));
	$cd_password=SafeRequest("pwd","get");
	$cd_seccode=SafeRequest("code","get");
	$cd_logintime=date('Y-m-d H:i:s');
	$cd_loginip=getonlineip();
	$cookietime=86400;
	$cd_password=substr(md5($cd_password),8,16);
	global $db;
	$sql = "select cd_id from ".tname('user')." where cd_name='".$cd_username."' and cd_password='".$cd_password."'";
	$cd_id = $db->getone($sql);
	if($cd_seccode != $_SESSION["codes"]){
		echo "Msg_001";
	}else{
		if(cd_ucenter==1){
			include_once "../../../client/ucenter.php";
			include_once "../../../client/client.php";
			list($uid, $username, $password, $email) = uc_user_login(unescape($_GET['name']), $_GET['pwd']);
			if($uid > 0) {
		                if(!$db->getone("select cd_id from ".tname('user')." where cd_name='".$username."'")) {
		                        $sqls="insert into `".tname('user')."` (cd_name,cd_nicheng,cd_password,cd_email,cd_regdate,cd_loginnum,cd_grade,cd_lock,cd_points,cd_hits,cd_isbest,cd_friendnum,cd_rank,cd_uhits,cd_weekhits,cd_musicnum,cd_fansnum,cd_idolnum,cd_favnum,cd_qqprivacy,cd_groupnum,cd_checkmm,cd_checkmusic,cd_review,cd_sign,cd_signcumu,cd_ucenter,cd_skinid,cd_vipgrade,cd_viprank,cd_ulevel) values ('".$username."','UCenter_".$uid."','".substr(md5($password),8,16)."','".$email."','".date('Y-m-d H:i:s')."','0','0','0','".cd_points."','0','0','0','".cd_userrank."','0','0','0','0','0','0','0','0','0','0','0','0','0','".$uid."','0','0','0','0')";
		                        if($db->query($sqls)) {
		                                $sqlss = "select cd_id from ".tname('user')." where cd_name='".$username."' and cd_password='".substr(md5($password),8,16)."'";
		                                $cd_ids = $db->getone($sqlss);
		                                if($cd_ids){
			                                $db->query("update ".tname('user')." set cd_loginnum=cd_loginnum+1,cd_loginip='".$cd_loginip."',cd_logintime='".$cd_logintime."' where cd_id=".$cd_ids);
			                                $db->query("delete from ".tname('session')." where cd_uid=".$cd_ids);
			                                $db->query("Insert ".tname('session')." (cd_uid,cd_uname,cd_uip,cd_logintime) values (".$cd_ids.",'".$username."','".getonlineip()."','".time()."')");
			                                setcookie("cd_id",$cd_ids,time()+86400,cd_cookiepath);
			                                setcookie("cd_name",$username,time()+86400,cd_cookiepath);
			                                setcookie("cd_password",substr(md5($password),8,16),time()+86400,cd_cookiepath);
		                                        if(cd_points >= 1){
			                                        $setarr = array(
				                                        'cd_type' => 1,
				                                        'cd_uid' => $cd_ids,
				                                        'cd_uname' => $username,
				                                        'cd_icon' => 'logon',
				                                        'cd_title' => '新用户注册',
				                                        'cd_points' => cd_points,
				                                        'cd_state' => 0,
				                                        'cd_addtime' => date('Y-m-d H:i:s'),
				                                        'cd_endtime' => getendtime()
			                                        );
			                                        inserttable('bill', $setarr, 1);
		                                        }
		                                        if(cd_pointsuaa >= 1){
			                                        $setarr = array(
				                                        'cd_type' => 1,
				                                        'cd_uid' => $cd_ids,
				                                        'cd_uname' => $username,
				                                        'cd_icon' => 'app',
				                                        'cd_title' => '每日登录',
				                                        'cd_points' => cd_pointsuaa,
				                                        'cd_state' => 0,
				                                        'cd_addtime' => date('Y-m-d H:i:s'),
				                                        'cd_endtime' => getendtime()
			                                        );
			                                        inserttable('bill', $setarr, 1);
		                                        }
			                                $db->query("update ".tname('user')." set cd_points=cd_points+".cd_pointsuaa.",cd_rank=cd_rank+".cd_pointsuab." where cd_id=".$cd_ids);
			                                exit("Msg_021");
		                                }
		                        }
		                }
			}
		}
		if($cd_id){
			$row = $db->getrow("select cd_id,cd_lock,cd_vipgrade,cd_name,cd_password from ".tname('user')." where cd_id=".$cd_id);
			if($row["cd_lock"]==1){
		                echo "Msg_027";
			}else{
		                $cd_ids = $db->getone("select cd_id from ".tname('session')." where cd_uid=".$cd_id);
		                if($cd_ids){
		                        updatetable('session', array('cd_logintime'=>time()), array('cd_id'=>$cd_ids));
		                }else{
		                        $setarr = array(
			                        'cd_uid' => $cd_id,
			                        'cd_uname' => $cd_username,
			                        'cd_uip' => getonlineip(),
			                        'cd_logintime' => time()
		                        );
		                        inserttable('session', $setarr, 1);
		                }
		                if($db->getone("select cd_id from ".tname('user')." where DateDiff(DATE(cd_logintime),'".date('Y-m-d')."')=0 and cd_id=".$cd_id)) {
		                        $db->query("update ".tname('user')." set cd_loginnum=cd_loginnum+1,cd_loginip='".$cd_loginip."',cd_logintime='".$cd_logintime."' where cd_id=".$cd_id);
		                }else{
		                        if(cd_pointsuaa >= 1){
			                        $setarr = array(
				                        'cd_type' => 1,
				                        'cd_uid' => $cd_id,
				                        'cd_uname' => $cd_username,
				                        'cd_icon' => 'app',
				                        'cd_title' => '每日登录',
				                        'cd_points' => cd_pointsuaa,
				                        'cd_state' => 0,
				                        'cd_addtime' => date('Y-m-d H:i:s'),
				                        'cd_endtime' => getendtime()
			                        );
			                        inserttable('bill', $setarr, 1);
		                        }
		                        if($row["cd_vipgrade"]==1){
			                        $cd_speed = 5;
		                        }elseif($row["cd_vipgrade"]==2){
			                        $cd_speed = 10;
		                        }else{
			                        $cd_speed = 0;
		                        }
		                        $db->query("update ".tname('user')." set cd_points=cd_points+".cd_pointsuaa.",cd_rank=cd_rank+".cd_pointsuab.",cd_viprank=cd_viprank+".$cd_speed.",cd_loginnum=cd_loginnum+1,cd_loginip='".$cd_loginip."',cd_logintime='".$cd_logintime."' where cd_id=".$cd_id);
		                }
		                setcookie("cd_id",$row["cd_id"],time()+$cookietime,cd_cookiepath);
		                setcookie("cd_name",$row["cd_name"],time()+$cookietime,cd_cookiepath);
		                setcookie("cd_password",$row["cd_password"],time()+$cookietime,cd_cookiepath);
		                if(cd_ucenter==1){
		                        echo "Msg_032";
		                }else{
		                        echo "Msg_002";
		                }
			}
		}else{
			echo "Msg_023";
		}
	}
}elseif($ac=="logout"){
	global $db,$userlogined;
	if(!$userlogined){exit("Msg_026");}
	$db->query("delete from ".tname('session')." where cd_uid=".$qianwei_in_userid);
	setcookie("cd_id","",time()-1,cd_cookiepath);
	setcookie("cd_name","",time()-1,cd_cookiepath);
	setcookie("cd_password","",time()-1,cd_cookiepath);
	if(cd_ucenter==1){
	        die("Msg_033");
	}else{
	        die("Msg_026");
	}
}
?>
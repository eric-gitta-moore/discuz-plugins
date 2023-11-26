<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_note = unescape(SafeRequest("note","post"));
	$cd_currPageNum = SafeRequest("currPageNum","post");

	if($cd_note == ""){
		exit('10007');
	}else{
		if(mb_strlen($cd_fgName,'UTF8') > 140){
			exit('10006');
		}

        	$cookies="blog_add_$qianwei_in_userid";
		if($_COOKIE[$cookies]=="yes"){
			exit('10002');
		}else{
			setcookie($cookies,"yes",time()+30);
			//入库
			$setarr = array(
				'cd_uid' => $qianwei_in_userid,
				'cd_uname' => $qianwei_in_username,
				'cd_uip' => getonlineip(),
				'cd_title' => '',
				'cd_content' => $cd_note,
				'cd_hits' => 0,
				'cd_commentnum' => 0,
				'cd_addtime' => time()
			);
			inserttable('blog', $setarr, 1);

			$timea = date('Y',time());
			$timeb = date('m',time());
			$timec = date('d',time());
			$timed = mktime(0,0,0,$timeb,$timec,$timea);
			$blognum = $db -> num_rows($db -> query("select cd_id from ".tname('blog')." where cd_uid='$qianwei_in_userid' and cd_addtime >= '$timed'"));
			$blogceiling = ($blognum*cd_pointsuca);

			if(($blognum*cd_pointsuca) < cd_pointsucc){
				if(cd_pointsuca >= 1){ //大于1才记录
					//记录账单
					$setarr = array(
						'cd_type' => 1, //1为加,0为减
						'cd_uid' => $qianwei_in_userid,
						'cd_uname' => $qianwei_in_username,
						'cd_icon' => 'miniblog',
						'cd_title' => '发表说说',
						'cd_points' => cd_pointsuca,
						'cd_state' => 0,
						'cd_addtime' => date('Y-m-d H:i:s'),
						'cd_endtime' => getendtime()
					);
					inserttable('bill', $setarr, 1);
				}
				//发表说说奖励
				$db->query("update ".tname('user')." set cd_points=cd_points+".cd_pointsuca.",cd_rank=cd_rank+".cd_pointsucb." where cd_id='$qianwei_in_userid'");
			}

			$sql="select * from ".tname('blog')." where cd_uid='".$qianwei_in_userid."' and cd_uname='".$qianwei_in_username."' order by cd_addtime desc LIMIT 0,1";
			if($row=$db->getrow($sql)){
				$setarrs = array(
					'cd_uid' => $qianwei_in_userid,
					'cd_uname' => $qianwei_in_username,
					'cd_icon' => 'miniblog',
					'cd_title' => '更新了微博',
					'cd_data' => $qianwei_in_nicheng.'说：'.$cd_note.' <a href="'.cd_upath.'index.php?p=space&a=miniblog&uid='.$row['cd_uid'].'&id='.$row['cd_id'].'" target="_blank">评论</a>',
					'cd_image' => '',
					'cd_imagelink' => '',
					'cd_dataid' => $row['cd_id'],
					'cd_addtime' => date('Y-m-d H:i:s')
				);
				inserttable('feed', $setarrs, 1);
			}
		}
	}
}else{
	exit('20001');
}
?>
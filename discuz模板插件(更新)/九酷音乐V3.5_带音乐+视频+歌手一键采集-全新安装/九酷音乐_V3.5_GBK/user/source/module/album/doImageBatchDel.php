<?php
	include "../source/global/global_inc.php";
	close_browse();
        global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$cd_id = unescape(SafeRequest("pidArr","post"));
		$query = $db->query("select cd_id,cd_uid,cd_uname,cd_url from ".tname('pic')." where cd_id in($cd_id)");
		while ($row = $db->fetch_array($query)) {
			//ɾ��ͼƬ
			$db->query("delete from ".tname('pic')." where cd_uid='".$row['cd_uid']."' and cd_id='".$row['cd_id']."'");
			//ɾ��ϲ��
			$db->query("delete from ".tname('pic_like')." where cd_dataid='".$row['cd_id']."'");
			//ɾ������
			$db->query("delete from ".tname('comment')." where cd_channel=1 and cd_dataid='".$row['cd_id']."'");
			//�ͷ�����
			if(cd_pointsdba >= 1){ //����1�ż�¼
				//��¼�˵�
				$setarr = array(
					'cd_type' => 0, //1Ϊ��,0Ϊ��
					'cd_uid' => $row['cd_uid'],
					'cd_uname' => $row['cd_uname'],
					'cd_icon' => 'album',
					'cd_title' => '��Ƭ��ɾ��',
					'cd_points' => cd_pointsdba,
					'cd_addtime' => date('Y-m-d H:i:s')
				);
				inserttable('bill', $setarr, 1);
			}

			$db->query("update ".tname('user')." set cd_points=cd_points-".cd_pointsdba." where cd_points>=1 and cd_id='".$row['cd_uid']."'");
			$db->query("update ".tname('user')." set cd_rank=cd_rank-".cd_pointsdbb." where cd_rank>=1 and cd_id='".$row['cd_uid']."'");

			@unlink("../data/attachment/album/".$row['cd_url'].".thumb.".fileext($row['cd_url']));
			@unlink("../data/attachment/album/".$row['cd_url'].".thumb_180x180.".fileext($row['cd_url']));
			@unlink("../data/attachment/album/".$row['cd_url']);
		}
		die('10000');
	}else{
		die('20001');
	}
?>
<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_uid = SafeRequest("uid","post");
	$cd_pid = SafeRequest("pid","post");
	$sql="select cd_id,cd_uid,cd_uname,cd_praisenum from ".tname('pic')." where cd_id='$cd_pid'";
	$result=$db->query($sql);
	if($row=$db->fetch_array($result)){
		if($row['cd_uid'] == $qianwei_in_userid){
			exit('10013');
		}else{

			//����Ƿ���ϲ��
        		$cd_id = $db->getone("select cd_id from ".tname('pic_like')." where cd_uid='$qianwei_in_userid' and cd_dataid='".$row['cd_id']."'");
			if($cd_id){
				exit('10003');
			}else{
				//���
				$setarr = array(
					'cd_uid' => $qianwei_in_userid,
					'cd_uname' => $qianwei_in_username,
					'cd_dataid' => $row['cd_id'],
					'cd_addtime' => time()
				);
				inserttable('pic_like', $setarr, 1);
				$db->query("update ".tname('pic')." set cd_praisenum=cd_praisenum+1 where cd_id='$cd_pid'");

				$my_array = array(
					'ͼƬ�治����ô���յ���ô�ÿ��أ�',
					'�������������������Ƭ�����ˣ�',
					'�ÿ�������ϲ��������ϲ���ķ��',
					'����Ƭ̫�����ˣ�һ�¾Ϳ����ˣ���Ƭ̫�����ˣ�',
					'����Ŷ~�ޣ�',
					'��ϲ��������Ƭ��',
					'��������İ���˭�ܸ�����������ôŪ�ģ�',
					'��Ƭ�ܺÿ�����',
					'����',
					'�ܺÿ���~��һ����',
					'������Ƭ�յĺܰ�������רҵ��ˮƽ��',
					'̫����~~ϲ����',
					'��һ����',
					'��Ƭ�����',
					'���轻�ѿ���Ƭ���������ź���Ƭ�����ϲ��������������������Ƭ��',
					'( ^_^ )�����',
					'�ܰ���ͼƬ������ٶ��ϴ�һЩ��',
					'�ѵÿ�����ô�ÿ�����Ƭ�����������˰���Ƭ��������',
					'��Ƭ�����'
				);  

				$setarr = array(
					'cd_channel' => 1,
					'cd_dataid' => $cd_pid,
					'cd_content' => $my_array[rand(0,6)],
					'cd_uid' => $qianwei_in_userid,
					'cd_uname' => $qianwei_in_username,
					'cd_uip' => getonlineip(),
					'cd_addtime' => date('Y-m-d H:i:s')
				);
				inserttable('comment', $setarr, 1);
				$db->query("update ".tname('pic')." set cd_replynum=cd_replynum+1 where cd_id='$cd_pid'");


				//����Ƿ����ύ֪ͨ
				$query = "select cd_id from ".tname('notice')." where cd_icon='album' and cd_uid='$qianwei_in_userid' and cd_uids='".$row['cd_uid']."' and cd_dataid='$cd_pid'";
				if($rows = $db->getrow($query)){
					$db->query("update ".tname('notice')." set cd_state=1,cd_addtime='".date('Y-m-d H:i:s')."' where cd_id='".$rows['cd_id']."'");
				}else{
					//���
					$setarr = array(
						'cd_uid' => $qianwei_in_userid,
						'cd_uname' => $qianwei_in_username,
						'cd_uids' => $row['cd_uid'],
						'cd_unames' => $row['cd_uname'],
						'cd_icon' => 'album',
						'cd_data' => '�����������Ƭ&nbsp;<a href="'.cd_upath.'index.php?p=space&a=album&uid='.$row['cd_uid'].'&id='.$cd_pid.'" target="_blank">�鿴����</a>',
						'cd_dataid' => $cd_pid,
						'cd_state' => 1,
						'cd_addtime' => date('Y-m-d H:i:s')
					);
					inserttable('notice', $setarr, 1);
				}
			}
			echo '<div id="comments_list" class="comments_list">';
			echo '<ul id="commentList" style="overflow: hidden;">';
        		$query = $db->query("select * from ".tname('comment')." where cd_channel=1 and cd_dataid='$cd_pid' order by cd_addtime desc LIMIT 0,100");
			$num = $db->num_rows($query);
        		while ($rows = $db->fetch_array($query)) {
				$cd_contents = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"emotImg\">", $rows['cd_content']);
				echo '<li id="comment" class="hover" style="_zoom:1;">';
				echo '<div class="pic"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank"><img class="avatar-20" src="'.getavatar($rows['cd_uid'],48).'"/></a></div>';
				echo '<div class="txt">';
				echo '<p>';
				echo '<span class="name"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank">'.GetAlias("qianwei_user","cd_nicheng","cd_id",$rows['cd_uid']).'��</a></span>';
				echo '<span class="content_id">'.$cd_contents.'</span>';
				echo '<span class="time">'.datetime($rows['cd_addtime']).'</span>';
				if($rows['cd_uid'] != $qianwei_in_userid){
					echo '<a id="comment" class="reply" authorId="'.$rows['cd_uid'].'" nickname="'.GetAlias("qianwei_user","cd_nicheng","cd_id",$rows['cd_uid']).'">�ظ�</a>';
				}
				echo '</p>';
				echo '</div>';
				if($cd_uid == $qianwei_in_userid){
					echo '<span cid="'.$rows['cd_id'].'" uid="'.$cd_uid.'" class="del" title="ɾ��"></span>';
				}
				echo '</li>';
			}
			echo '</ul>';
			echo '</div>';

        		$query = $db->query("select * from ".tname('pic_like')." where cd_dataid='$cd_pid' order by cd_addtime desc LIMIT 0,16");
			$num = $db->num_rows($query);
			if($num){
				echo '<div class="Q_whoLiked">';
				echo '<div class="hd">';
				echo '<h2>��Щ��ϲ����</h2>';
				echo '</div>';
				echo '<div class="bd">';
				echo '<ul class="avatarList clearfix">';
        			while ($rows = $db->fetch_array($query)) {
					echo '<li>';
					echo '<div class="avatar">';
					echo '<a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank">';
					echo '<img class="avatar" width="48" height="48" src="'.getavatar($rows['cd_uid'],48).'"/>';
					echo '</a>';
					echo '</div>';
					echo '</li>';
				}
				echo '</ul>';
				echo '</div>';
				echo '<div id="praiseNum" type="hidden" num="'.($row['cd_praisenum']+1).'"></div>';
				echo '</div>';
			}
		}
	}else{
		exit('30000');
	}
}else{
	exit('20001');
}
?>
	<script type="text/javascript">
	$(document).ready(function(){
		albumLib.imageNameModifyInit(); 
		albumLib.replayUserInit();
		albumLib.replayUserCancelInit();
		albumLib.imageCommentDelInit();
	});
	</script>
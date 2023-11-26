<?php
include "../source/global/global_inc.php";
include "source/module/space/common.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title><?php echo $qianwei_web_nicheng; ?>�����ֿռ�</title>
	<script type="text/javascript">
		var domIsReady=false,domReadyList=[],domReadyObject=[],$call=function(callback,obj){if(typeof obj!=='object'){obj=document}if(domIsReady){callback.call(obj)}else{domReadyList.push(callback);domReadyObject.push(obj)}};	
		var site_domain="<?php echo cd_webpath; ?>";zone_domain="<?php echo cd_upath; ?>";
	</script>
	<link type="text/css" href="<?php echo cd_upath; ?>static/css/core.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo cd_upath; ?>static/space/css/common.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo cd_upath; ?>static/space/css/space.css" rel="stylesheet" />
	<link type="text/css" id="skin" href="<?php echo cd_upath; ?>static/space/skin/<?php echo $qianwei_web_skinid; ?>/style.css" rel="stylesheet" />
</head>
<body>
<?php include "source/module/space/header.php"; ?>
<div class="spaceMain">
	<div class="mainTop"></div>
	<div class="mainCenter">
		<div class="indexLeft">
			<div class="stageBox">
				<div class="stageBoxTop"><span></span></div>
				<div class="stageBoxCenter padding7">
					<div class="stageBoxCenterContent">
						<div class="user_info">
							<h3>
								<span class="nickname"><?php echo $qianwei_web_nicheng; ?></span>
								<?php echo CheckCertify($qianwei_web_checkmusic,$qianwei_web_checkmm,$qianwei_web_grade,$qianwei_web_viprank); ?>
								<span class="text">

								</span>
							</h3>
							<div class="lc">
								<img width="160" height="160" src="<?php echo getavatar($qianwei_web_userid,200); ?>"/>
								<div class="online_state">
									<?php
										if(CheckLogin($qianwei_web_userid)){
											echo '<span class="online">��ǰ����</span>';
										}else{
											echo '<span class="offline">��ǰ����</span>';
										}
									?>
								</div>
							</div>
							<div class="rc">
								<div class="content">
									<ul class="medal">
										<?php
											//�����û�
											if($qianwei_web_weekhits >= 100){
												$qianwei_web_weekhits_html = '1';
											}else{
												$qianwei_web_weekhits_html = '0';
											}

											//��Ծ�û�
											if($qianwei_web_sign){
												$qianwei_web_sign_html = '1';
											}else{
												$qianwei_web_sign_html = '0';
											}

											//�û��ȼ�
											if($qianwei_web_rank){
												$qianwei_web_rank_html = '1';
											}else{
												$qianwei_web_rank_html = '0';
											}

											//����ȼ�
											if($qianwei_web_musicnum){
												$qianwei_web_musicnum_html = '1';
											}else{
												$qianwei_web_musicnum_html = '0';
											}

											//����ȼ�
											if($qianwei_web_review){
												$qianwei_web_review_html = '1';
											}else{
												$qianwei_web_review_html = '0';
											}

											//MM��֤
											if($qianwei_web_checkmm){
												echo '<li>';
												echo '<a href="javascript:;" title="��Ů��֤��ͷ��ͨ������ʵMM��֤" onclick="openWebsite.openTo(\'certify\');">';
												echo '<em class="certify"></em>';
												echo '</a>';
												echo '</li>';
											}

											//�����û�
											if($qianwei_web_weekhits_html == 1){
												echo '<li>';
												echo '<a href="javascript:;" title="�����û������û����һ����������" onclick="openWebsite.openTo(\'popularity_user\');">';
												echo '<em class="popularity_user"></em>';
												echo '</a>';
												echo '</li>';
											}

											//��Ծ�û�
											if($qianwei_web_sign_html == 1){
												echo '<li>';
												echo '<a href="javascript:;" title="��Ծ�û���δ����ǩ��" onclick="openWebsite.openTo(\'sign\');">';
												echo '<em class="sign_none"></em>';
												echo '</a>';
												echo '</li>';
											}

											//�û��ȼ�
											if($qianwei_web_rank_html == 1){
												echo '<li>';
												echo '<a href="javascript:;" title="�û��ȼ���'.getmrank($qianwei_web_rank,0).'������ֵ'.$qianwei_web_rank.'����������'.getmrank($qianwei_web_rank,1).'" onclick="openWebsite.openTo(\'exp_role\');">';
												echo '<em class="exp_role"></em>';
												echo '<b class="num n'.getmrank($qianwei_web_rank,3).'"></b>';
												echo '</a>';
												echo '</li>';
											}

											//����ȼ�
											if($qianwei_web_musicnum_html == 1){
												echo '<li>';
												echo '<a href="javascript:;" title="����ȼ���'.getdancerank($qianwei_web_musicnum,0).'��������������'.$qianwei_web_musicnum.'����������'.getdancerank($qianwei_web_musicnum,1).'" onclick="openWebsite.openTo(\'share\');">';
												echo '<em class="share"></em>';
												echo '<b class="num n'.getdancerank($qianwei_web_musicnum,3).'"></b>';
												echo '</a>';
												echo '</li>';
											}

											//����ȼ�
											if($qianwei_web_review_html == 1){
												echo '<li>';
												echo '<a href="javascript:;" title="����ȼ���Lv1��������ȷ����1����������0.0%" onclick="openWebsite.openTo(\'jury\');">';
												echo '<em class="jury"></em>';
												echo '<b class="num n1"></b>';
												echo '</a>';
												echo '</li>';
											}

											//�����û�
											if($qianwei_web_weekhits_html == 0){
												echo '<li>';
												echo '<a href="javascript:;" title="�����û������û���δ������ѫ��" onclick="openWebsite.openTo(\'popularity_user\');">';
												echo '<em class="popularity_user_none"></em>';
												echo '</a>';
												echo '</li>';
											}

											//��Ծ�û�
											if($qianwei_web_sign_html == 0){
												echo '<li>';
												echo '<a href="javascript:;" title="��Ծ�û���δ����ǩ��" onclick="openWebsite.openTo(\'sign\');">';
												echo '<em class="sign_none"></em>';
												echo '</a>';
												echo '</li>';
											}

											//�û��ȼ�
											if($qianwei_web_rank_html == 0){
												echo '<li>';
												echo '<a href="javascript:;" title="�û��ȼ������û���δ������ѫ��" onclick="openWebsite.openTo(\'exp_role\');">';
												echo '<em class="exp_role_none"></em>';
												echo '</a>';
												echo '</li>';
											}

											//����ȼ�
											if($qianwei_web_musicnum_html == 0){
												echo '<li>';
												echo '<a href="javascript:;" title="����ȼ������û���δ������ѫ��" onclick="openWebsite.openTo(\'share\');">';
												echo '<em class="share_none"></em>';
												echo '</a>';
												echo '</li>';
											}

											//����ȼ�
											if($qianwei_web_review_html == 0){
												echo '<li>';
												echo '<a href="javascript:;" title="����ȼ������û���δ������ѫ��" onclick="openWebsite.openTo(\'jury\');">';
												echo '<em class="jury_none"></em>';
												echo '</a>';
												echo '</li>';
											}
										?>
									</ul>
									<ul class="material">
										<li>�Ա�<?php if($qianwei_web_sex=="1"){ echo "˧��"; }else{ echo "��Ů"; } ?></li>
										<li>�ѣѣ�<?php if($qianwei_web_qqprivacy=="1"){ echo $qianwei_web_qq; }else{ echo "������"; } ?></li>
										<li>���֣�<?php echo $qianwei_web_points; ?>��</li>
										
										<li>���ԣ�<?php if($qianwei_web_address){ echo str_replace("-"," ",$qianwei_web_address); }else{ echo "����"; } ?></li>
										<li>���<?php echo datetime($qianwei_web_logintime); ?></li>
										<li>��������<?php echo $qianwei_web_hits; ?>�˴��������ռ�</li>
									</ul>
								</div>
								<div class="bottom">
									<div class="praise">
										<a class="praise_num" title="��<?php echo $qianwei_web_callname; ?>һ��" onclick="$call(function(){user.praiseUser(<?php echo $qianwei_web_userid; ?>, '<?php echo $qianwei_web_nicheng; ?>', 0, 0, <?php echo $qianwei_web_uhits; ?>, 0)});"></a>
										<div class="praiseDiv fl">
											<div id="praiseCount1" class="praiseCount"><span id="praiseCount"><?php echo $qianwei_web_uhits; ?></span></div>
											<div class="epilog"></div>
										</div>
									</div>
									<?php
										if($qianwei_web_userid != $qianwei_in_userid){
											echo '<div class="and" id="fans">';
											$sql = "select cd_lock from ".tname('friend')." where cd_uid='$qianwei_in_userid' and cd_uids='".$qianwei_web_userid."'";
											if($rows = $db->getrow($sql)){
												if($rows['cd_lock'] == '1'){
													echo '<a onclick="$call(function(){fans.fansDel('.$qianwei_web_userid.', \'{'.$qianwei_web_nicheng.'}\', 1)});" class="attention mutual" href="javascript:;"></a>';
												}else{
													$cd_groupid = $db->getone("select cd_id from ".tname('friend')." where cd_uid='$qianwei_in_userid' and cd_uids='".$qianwei_web_userid."'");
													if($cd_groupid){
														echo '<a onclick="$call(function(){fans.fansDel('.$qianwei_web_userid.', \'{'.$qianwei_web_nicheng.'}\', 1)});" class="attention already" href="javascript:;"></a>';
													}else{
														echo '<a onclick="$call(function(){fans.fansAdd('.$qianwei_web_userid.', \'{'.$qianwei_web_nicheng.'}\', 1)});" class="attention" href="javascript:;"></a>';
													}
												}
											}else{
												echo '<a onclick="$call(function(){fans.fansAdd('.$qianwei_web_userid.', \'{'.$qianwei_web_nicheng.'}\', 1)});" class="attention" href="javascript:;"></a>';
											}
											echo '</div>';
											echo '<div class="and">';
											echo '<a class="private" onClick="$call(function(){message.msgSendInit('.$qianwei_web_userid.',\''.ZxingCrypt($qianwei_web_userid).'\', \''.$qianwei_in_userid.'\')});" title="����˽��">  </a>';
											echo '</div>';
										}
									?>
								</div>
							</div>
						</div>

						<?php
							global $db;
							$i=0;
        						$query = $db->query("select cd_id,cd_url from ".tname('pic')." where cd_uid='$qianwei_web_userid' order by cd_theorder desc LIMIT 0,7");
							$num = $db->num_rows($query);
							if($num > 0){
								echo '<div class="spaceAlbum">';
								echo '<ul>';
        							while ($rows = $db->fetch_array($query)) {
									$i=$i+1;
									if($i == 7){
										echo '<li class="right"><a href="'.cd_upath.rewrite_url('index.php?p=space&a=album&uid='.$qianwei_web_userid.'&id='.$rows['cd_id']).'" target="_blank"><img onerror="$call(function(){libs.imageError(this);}, this)" src="'.getalbumthumb($rows['cd_url'],1).'" width="76" height="76"/></a></li>';
									}else{
										echo '<li><a href="'.cd_upath.rewrite_url('index.php?p=space&a=album&uid='.$qianwei_web_userid.'&id='.$rows['cd_id']).'" target="_blank"><img onerror="$call(function(){libs.imageError(this);}, this)" src="'.getalbumthumb($rows['cd_url'],1).'" width="76" height="76"/></a></li>';
									}
								}
								for($i=1;$i<(8-$num);$i++) {
									if($i == (7-$num)){
										echo '<li class="noImage right"></li>';
									}else{
										echo '<li class="noImage"></li>';
									}
								}
								echo '</ul>';
								echo '</div>';
							}
						?>
					</div>
				</div>
				<div class="stageBoxBottom"><span></span></div>
			</div>
			<div class="blank13"></div>
			<div class="stageBox">
				<div class="stageBoxTop"><span></span></div>
				<div class="stageBoxCenter">
					<?php if($qianwei_web_musicnum>"0"){ ?>
					<div class="spaceMTitle">
						<p><?php echo $qianwei_web_callname; ?>�ϴ����������</p>
						<?php if($qianwei_web_userid == $qianwei_in_userid){ ?><span class="management"><a href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=share&i=me'); ?>" target="_blank">����</a></span><?php } ?>
					</div>
					<div class="title_per"> </div>
					<div id="list" class="spaceMusic minHeight100">
						<ul class="post_list">
							<li class="title">
								<div class="song">����/������</div>
								<div class="class">���</div>
								<div class="time">����ʱ��</div>
								<div class="points">�۷�</div>
								<div class="impression">ӡ��</div>
								<div class="add">���</div>
								<div class="down">����</div>
							</li>
							<?php
								global $db;
								$a=0;
        							$query = $db->query("select * from ".tname('music')." where CD_Deleted=0 and CD_Passed=0 and CD_UserID='$qianwei_web_userid' order by CD_AddTime desc LIMIT 0,10");
        							while ($music = $db->fetch_array($query)) {
								$a=$a+1;
							?>
							<li<?php if($a=="1"){ echo ' class="c1"'; } ?>>
								<div class="song">
									<span class="cbox"><input id="<?php echo $music['CD_ID']; ?>" type="checkbox" value="<?php echo $music['CD_ID']; ?>" name="did"></span>
									<div class="aleft">
										<a target="p" class="mname" href="<?php echo LinkUrl("music",$music['CD_ClassID'],1,$music['CD_ID']); ?>"><?php echo $music["CD_Name"]; ?></a>
									</div>
								</div>
								<div class="class"><?php echo GetAlias("qianwei_class","CD_Name","CD_ID",$music['CD_ClassID']); ?></div>
								<div class="time" title="<?php echo date('Y-m-d H:i:s',$music['CD_AddTime']); ?>"><?php echo datetime(date('Y-m-d H:i:s',strtotime($music['CD_AddTime']))); ?></div>
								<div class="points"><?php if($music['CD_Points']<=0){ echo '���'; }else{ echo $music['CD_Points']; } ?></div>
								<div class="impression">
									<span id="d<?php echo $music['CD_ID']; ?>" class="icon">
										<b class="default"> </b>
									</span>
								</div>
								<div class="action">
									<a class="add" title="�����б�" href="javascript:;" onclick="$call(function(){dancePlayer.addPlayer('<?php echo $music['CD_ID']; ?>')});"></a>
								</div>
								<div class="down">
									<a class="download" title="���ظ���" href="javascript:;" onclick="$call(function(){dancePlayer.openDown('<?php echo $music['CD_ID']; ?>','<?php echo $music['CD_UserID']; ?>')});"></a>
								</div>
							</li>
							<?php
								}
							?>
						</ul>
						<div class="page">
							<div class="play_button">
								<a id="selectAll" class="select_all" onclick="$call(function(){dancePlayer.selectAllDance('list', '')});" href="javascript:;">ȫѡ</a>
								<a class="select_play" onclick="$call(function(){dancePlayer.playDance('list')});" href="javascript:;">����</a>
								<a class="select_add_list" onclick="$call(function(){dancePlayer.addInList('list')});" href="javascript:;">�����б�</a>
								<a class="select_more" title="�����������" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=dance&uid='.$qianwei_web_userid); ?>">����</a>
							</div>
						</div>
					</div>
					<?php } ?>
					<?php if($qianwei_web_musicnum<="0" && $qianwei_web_favnum>"0"){ ?>
					<div class="spaceMTitle">
						<p><?php echo $qianwei_web_callname; ?>�ղص�����</p>
						<?php if($qianwei_web_userid == $qianwei_in_userid){ ?><span class="management"><a href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=favorites'); ?>" target="_blank">����</a></span><?php } ?>
					</div>
					<div class="title_per"> </div>
					<div id="list" class="spaceMusic minHeight100">
						<ul class="post_list">
							<li class="title">
								<div class="song">����/������</div>
								<div class="class">���</div>
								<div class="time">�ղ�ʱ��</div>
								<div class="points">�۷�</div>
								<div class="impression">ӡ��</div>
								<div class="add">���</div>
								<div class="down">����</div>
							</li>
							<?php
								global $db;
								$a=0;
        							$query = $db->query("select * from ".tname('fav')." where cd_uid='$qianwei_web_userid' order by cd_addtime desc LIMIT 0,10");
        							while ($row = $db->fetch_array($query)) {
								$a=$a+1;
								$music = $db->getrow("select * from ".tname('music')." where CD_ID='".$row['cd_musicid']."'");
								if($music){
							?>
							<li<?php if($a=="1"){ echo ' class="c1"'; } ?>>
								<div class="song">
									<span class="cbox"><input id="<?php echo $music['CD_ID']; ?>" type="checkbox" value="<?php echo $music['CD_ID']; ?>" name="did"></span>
									<div class="aleft">
										<a target="p" class="mname" href="<?php echo LinkUrl("music",$music['CD_ClassID'],1,$music['CD_ID']); ?>"><?php echo getlen('len',20,$music["CD_Name"]); ?></a>
										&nbsp;-
										<a class="nickname" title="<?php echo $music['CD_UserNicheng']; ?>" target="_blank" href="<?php echo linkweburl($music['CD_UserID'],$music['CD_User']); ?>"><?php echo $music['CD_UserNicheng']; ?></a>
									</div>
								</div>
								<div class="class"><?php echo GetAlias("qianwei_class","CD_Name","CD_ID",$music['CD_ClassID']); ?></div>
								<div class="time" title="<?php echo date('Y-m-d H:i:s',$row['cd_addtime']); ?>"><?php echo datetime(date('Y-m-d H:i:s',$row['cd_addtime'])); ?></div>
								<div class="points"><?php if($music['CD_Points']<=0){ echo '���'; }else{ echo $music['CD_Points']; } ?></div>
								<div class="impression">
									<span id="d<?php echo $music['CD_ID']; ?>" class="icon">
										<b class="default"> </b>
									</span>
								</div>
								<div class="action">
									<a class="add" title="�����б�" href="javascript:;" onclick="$call(function(){dancePlayer.addPlayer('<?php echo $music['CD_ID']; ?>')});"></a>
								</div>
								<div class="down">
									<a class="download" title="���ظ���" href="javascript:;" onclick="$call(function(){dancePlayer.openDown('<?php echo $music['CD_ID']; ?>','<?php echo $music['CD_UserID']; ?>')});"></a>
								</div>
							</li>
							<?php
									}
								}
							?>
						</ul>
						<div class="page">
							<div class="play_button">
								<a id="selectAll" class="select_all" onclick="$call(function(){dancePlayer.selectAllDance('list', '')});" href="javascript:;">ȫѡ</a>
								<a class="select_play" onclick="$call(function(){dancePlayer.playDance('list')});" href="javascript:;">����</a>
								<a class="select_add_list" onclick="$call(function(){dancePlayer.addInList('list')});" href="javascript:;">�����б�</a>
								<a class="select_more" title="�����ղ�����" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=favorites&uid='.$qianwei_web_userid); ?>">����</a>

							</div>
						</div>
					</div>
					<?php } ?>
					<?php
						if($qianwei_web_musicnum<="0" && $qianwei_web_favnum<="0"){
							global $db;
							$a=0;
        						$query = $db->query("select * from ".tname('listen')." where cd_uid='$qianwei_web_userid' order by cd_addtime desc LIMIT 0,10");
							$listennum = $db->num_rows($query);
							if($listennum > 0){
					?>
					<div class="spaceMTitle">
						<p><?php echo $qianwei_web_callname; ?>����������</p>
						<?php if($qianwei_web_userid == $qianwei_in_userid){ ?><span class="management"><a href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=listen'); ?>" target="_blank">����</a></span><?php } ?>
					</div>
					<div class="title_per"> </div>
					<div id="list" class="spaceMusic minHeight100">
						<ul class="post_list">
							<li class="title">
								<div class="song">����/������</div>
								<div class="class">���</div>
								<div class="time">����ʱ��</div>
								<div class="points">�۷�</div>
								<div class="impression">ӡ��</div>
								<div class="add">���</div>
								<div class="down">����</div>
							</li>
							<?php
        							while ($row = $db->fetch_array($query)) {
								$a=$a+1;
								$music = $db->getrow("select * from ".tname('music')." where CD_ID='".$row['cd_musicid']."'");
								if($music){
							?>
							<li<?php if($a=="1"){ echo ' class="c1"'; } ?>>
								<div class="song">
									<span class="cbox"><input id="<?php echo $music['CD_ID']; ?>" type="checkbox" value="<?php echo $music['CD_ID']; ?>" name="did"></span>
									<div class="aleft">
										<a target="p" class="mname" href="<?php echo LinkUrl("music",$music['CD_ClassID'],1,$music['CD_ID']); ?>"><?php echo getlen('len',20,$music["CD_Name"]); ?></a>
										&nbsp;-
										<a class="nickname" title="<?php echo $music['CD_UserNicheng']; ?>" target="_blank" href="<?php echo linkweburl($music['CD_UserID'],$music['CD_User']); ?>"><?php echo $music['CD_UserNicheng']; ?></a>
									</div>
								</div>
								<div class="class"><?php echo GetAlias("qianwei_class","CD_Name","CD_ID",$music['CD_ClassID']); ?></div>
								<div class="time" title="<?php echo date('Y-m-d H:i:s',$row['cd_addtime']); ?>"><?php echo datetime(date('Y-m-d H:i:s',$row['cd_addtime'])); ?></div>
								<div class="points"><?php if($music['CD_Points']<=0){ echo '���'; }else{ echo $music['CD_Points']; } ?></div>
								<div class="impression">
									<span id="d<?php echo $music['CD_ID']; ?>" class="icon">
										<b class="default"> </b>
									</span>
								</div>
								<div class="action">
									<a class="add" title="�����б�" href="javascript:;" onclick="$call(function(){dancePlayer.addPlayer('<?php echo $music['CD_ID']; ?>')});"></a>
								</div>
								<div class="down">
									<a class="download" title="���ظ���" href="javascript:;" onclick="$call(function(){dancePlayer.openDown('<?php echo $music['CD_ID']; ?>','<?php echo $music['CD_UserID']; ?>')});"></a>
								</div>
							</li>
							<?php
									}
								}
							?>
						</ul>
						<div class="page">
							<div class="play_button">
								<a id="selectAll" class="select_all" onclick="$call(function(){dancePlayer.selectAllDance('list', '')});" href="javascript:;">ȫѡ</a>
								<a class="select_play" onclick="$call(function(){dancePlayer.playDance('list')});" href="javascript:;">����</a>
								<a class="select_add_list" onclick="$call(function(){dancePlayer.addInList('list')});" href="javascript:;">�����б�</a>
								<a class="select_more" title="������������" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=listen&uid='.$qianwei_web_userid); ?>">����</a>

							</div>
						</div>
					</div>
					<?php }} ?>

					<div class="spaceWall">
						<div class="wallConsole">
							<div class="wallTitle"><span>���԰�</span></div>
							<div class="title_per"> </div>
							<div class="sW_box">
								<div class="sW_input">
									<div contenteditable="true" id="wallContent" class="wallContent" name="wallContent"></div>
								</div>
								<div class="sW_button">
									<span class="button-main">
										<span>
											<button type="button" id="wallSubmit" onclick="$call(function(){wallLib.wallAddInit(<?php echo $qianwei_web_userid; ?>, '8aedde06e41790214e7fb79fd207c9d3Wl2uZiBd59ztYlQKKFqN2E@mMEQsIllnQG8aNNjOuTI')});">����</button>
										</span>
									</span>
								</div>
								<div id="sW_message" class="wCI_message"></div>
								<div id="emot_wallContent" class="emot" ></div>
							</div>
						</div>
						<div id="wall_content" class="wall_index wall_content minHeight150">
							<?php
								global $db;
								$i=0;
								$sql="select * from ".tname('wall')." where cd_wallid=0 and cd_dataid='$qianwei_web_userid' order by cd_addtime desc";
								$Arr=getwallpage($sql, 10, $qianwei_web_userid);//sql,ÿҳ��ʾ����
								$result=$db->query($Arr[2]);
								$num=$db->num_rows($result);
								if($num==0){ echo '<div class="nothing">�尡```��ľ�������԰�- -! ���������԰ɡ�</div>'; }
								if($result){
									while ($row = $db ->fetch_array($result)){
										$user = $db->getrow("select * from ".tname('user')." where cd_id='".$row['cd_uid']."'");
										$cd_content = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"face\">", $row['cd_content']);
										//$cd_content = preg_replace("/\<br.*?\>/is", ' ', $cd_content);
										echo '<div class="wallLine" id="wall_'.$row['cd_id'].'">';
										echo '<div class="wallItem">';
										echo '<div class="arrow"><s></s></div>';
										echo '<div class="wI_avatar"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'"><img class="avatar-58" src="'.getavatar($row['cd_uid'],48).'" width="48" height="48"/></a></div>';
										echo '<div class="wI_content">';
										echo '<div class="wI_top">';
										echo '<span class="nickname"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'">'.$user['cd_nicheng'].'</a>';
										echo CheckCertify($user['cd_checkmusic'],$user['cd_checkmm'],$user['cd_grade'],$user['cd_viprank']);
										echo '</span><span class="info">���ԣ�</span>';
										if($qianwei_web_userid == $qianwei_in_userid){
											echo '<span id="del-w'.$row['cd_id'].'" class="del" title="ɾ��" onclick="$call(function(){wallLib.doDelWall('.$qianwei_web_userid.', '.$row['cd_id'].', 0, 0)});" ></span>';
										}
										echo '<span class="others">';
										echo '<span class="createTime">'.datetime($row['cd_addtime']).'</span>';
										//if($row['cd_uid'] != $qianwei_in_userid){
											echo '<span><a class="reply" onclick="$call(function(){wallLib.replyWall('.$row['cd_id'].', 0, 0, 0, '.$row['cd_uid'].')});" href="javascript:;">�ظ�</a></span>';
										//}
										echo '</span>';
										echo '</div>';
										echo '<div class="wI_text">'.$cd_content.'</div>';
										echo '</div>';
										echo '</div>';
										echo '<div id="wallComment'.$row['cd_id'].'">';

        									$query = $db->query("select * from ".tname('wall')." where cd_wallid='".$row['cd_id']."' order by cd_addtime desc LIMIT 0,100");
        									while ($rows = $db->fetch_array($query)) {
											$users = $db->getrow("select * from ".tname('user')." where cd_id='".$rows['cd_uid']."'");
											$cd_contents = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"emotImg\">", $rows['cd_content']);

											echo '<div class="wallComment">';
											echo '<div class="wallCommentItem" id="walls_'.$rows['cd_id'].'">';
											echo '<div class="wC_avatar"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'"><img class="avatar-38" src="'.getavatar($rows['cd_uid'],48).'"/></a></div>';
											echo '<div class="wC_top">';
											echo '<span class="nickname"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'">'.$users['cd_nicheng'].'</a>';
											echo CheckCertify($users['cd_checkmusic'],$users['cd_checkmm'],$users['cd_grade'],$users['cd_viprank']);
											echo '</span>';
											if($qianwei_web_userid == $qianwei_in_userid){
												echo '<span id="del-c'.$rows['cd_id'].'" class="del" title="ɾ��" onclick="$call(function(){wallLib.doDelWall('.$qianwei_web_userid.', '.$row['cd_id'].', '.$rows['cd_id'].', 0)});"></span>';
											}
											echo '<span class="others">';
											echo '<span class="createTime">'.datetime($rows['cd_addtime']).'</span>';
											if($rows['cd_uid'] != $qianwei_in_userid){
												echo '<span><a href="javascript:;" onclick="$call(function(){wallLib.replyWall('.$row['cd_id'].', '.$rows['cd_id'].', '.$rows['cd_uid'].', \''.GetAlias("qianwei_user","cd_nicheng","cd_id",$rows['cd_uid']).'\', 0)});">�ظ�</a></span>';
											}
											echo '</span>';
											echo '</div>';
											echo '<div class="wC_text">'.$cd_contents.'</div>';
											echo '</div>';
											echo '</div>';
											echo '<div id="exp"></div>';
										}

										echo '</div>';
										echo '<div id="wallCommentInputBox'.$row['cd_id'].'" class="wallCommentInputBox" style="display:none;">';
										echo '<div class="replayUser" id="replayUser_'.$row['cd_id'].'"></div>';
										echo '<div class="del" id="replayUserDel_'.$row['cd_id'].'" onclick="$call(function(){wallLib.delReplayUser('.$row['cd_id'].')});" title="ȡ���Դ��˵Ļظ�"></div>';
										echo '<div class="wCI_input"><div id="wallCommentInput'.$row['cd_id'].'" contenteditable="true" class="wallCommentInput" name="wallCommentInput"></div></div>';
										echo '<div class="wCI_button"><span class="button-main"><span><button type="submit" id="wallcontSubmit" class="confirm" onclick="$call(function(){wallLib.confirmWall('.$row['cd_id'].', '.$qianwei_web_userid.')});">ȷ��</button></span></span></div>';
										echo '<div class="wCI_cancel"><a class="cancel" href="javascript:;" onclick="$call(function(){wallLib.cancelWall('.$row['cd_id'].')});" >ȡ��</a></div>';
										echo '<div id="wCI_message'.$row['cd_id'].'" class="wCI_message"></div>';
										echo '<div class="emot" id="emot_wallCommentInput'.$row['cd_id'].'"></div>';
										echo '</div>';
										echo '</div>';

									}
								}
							?>
							<?php if($num>0){?>
								<div class="page" id="page">
									<div class="pages">
										<?php echo $Arr[0]; ?>
										<input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;wallLib.moreWall(<?php echo $qianwei_web_userid; ?>,val);return false;}else{return true;}};if(!c(event,this.value))return false;" title="����ҳ�룬���س�������ת"/>
										<div id="currPage">1</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="stageBoxBottom"><span></span></div>
			</div>
		</div>
		<div class="indexRight">
			<div class="spaceUserInfo">
				<ul class="info_list">
					<li>
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=following&uid='.$qianwei_web_userid); ?>">
							<span><?php echo $qianwei_web_idolnum; ?></span>
							<strong>��ע</strong>
						</a>
					</li>
					<li>
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=fans&uid='.$qianwei_web_userid); ?>">
							<span><?php echo $qianwei_web_fansnum; ?></span>
							<strong>��˿</strong>
						</a>
					</li>
					<li class="last">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=favorites&uid='.$qianwei_web_userid); ?>">
							<span><?php echo $qianwei_web_favnum; ?></span>
							<strong>�ղ�</strong>
						</a>
					</li>
				</ul>
			</div>

			<div class="sFriendTitle">���˽���</div>
			<div class="introduction">
				<div class="SA">
					<em>��</em>
					<span>��</span>
				</div>
				<div class="middle"><?php if($qianwei_web_introduce){ echo $qianwei_web_introduce; }else{ echo "����˺�����ʲôҲû�����¡�"; } ?></div>
			</div>

			<div class="sFriendTitle">����ÿ�</div>
			<ul class="sFriend" id="ListGuest">������...</ul>

			<?php if($qianwei_web_idolnum>0){ ?>
			<div class="sFriendTitle"><?php echo $qianwei_web_callname; ?>��ע����<span>[<?php echo $qianwei_web_idolnum; ?>]</span></div>
				<ul class="sFriend no">
					<?php
						global $db;
        					$query = $db->query("select * from ".tname('friend')." where cd_hidden=0 and cd_uid='$qianwei_web_userid' order by cd_addtime desc LIMIT 0,9");
        					while ($row = $db->fetch_array($query)) {
							$user = $db->getrow("select cd_nicheng from ".tname('user')." where cd_id='".$row['cd_uids']."'");
							echo '<li>';
							echo '<div class="friendAvatar"><a href="'.linkweburl($row['cd_uids'],$row['cd_unames']).'"><img width="48" height="48" src="'.getavatar($row['cd_uids'],48).'" onerror="pubLibs.avatarError(this,\'small\');" title="'.$user['cd_nicheng'].'"/></a></div>';
							echo '<div class="friendInfo"><span><a href="'.linkweburl($row['cd_uids'],$row['cd_unames']).'" title="'.$user['cd_nicheng'].'">'.$user['cd_nicheng'].'</a></span><p></p></div>';
							echo '</li>';
						}
					?>

				</ul>
				<div class="sMore"><a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=following&uid='.$qianwei_web_userid); ?>">�鿴ȫ��&raquo;</a></div>
			</div>
			<?php } ?>
		</div>
		<div class="mainBottom"></div>
	</div>
	<div class="spaceBottom">
		<?php include "source/module/space/footer.php"; ?>
	</div>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/core.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/card.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/dialog.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/jquery.plugins.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/common.js"></script>
<script type="text/javascript">listenMsg.start();nav.init();nav.userMenu();</script>
<script type="text/javascript">
//nav.helpNoticeInit();
</script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/wall.js"></script>
<script type="text/javascript">
libs.homeguest(<?php echo $qianwei_web_userid; ?>);
libs.spaceHomeInit();
libs.praise(0, 0, <?php echo $qianwei_web_uhits; ?>);
var didStr = "<?php echo GetFavorites($qianwei_in_userid); ?>";
spaceDance.spaceDanceStatus("love");
</script>
</body>
</html>
	<div class="top" id="top">
		<div class="topNav">
			<ul>
				<li class="logo">
					<a target="list" href="<?php echo cd_upath; ?>"></a>
				</li>
				<li>
					<a target="list" href="<?php echo cd_webpath; ?>">��ҳ</a>
				</li>
				<li>
					<a class="set_menu" style="cursor:pointer;">���ֿ�</a>
					<div class="m_set_list" style="display: none;" id="uploadList">
						<em></em>
						<?php
							global $db,$userlogined;
        						$query = $db->query("select * from ".tname('class')." where CD_FatherID=1 and CD_IsHide=0 order by CD_TheOrder asc");
        						while ($row = $db->fetch_array($query)) {
								echo "<a href=\"".LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],1)."\" target=\"_blank\" class=\"list\"><b class=\"like\"></b>".$row["CD_Name"]."</a>";
							}
						?>
					</div>
				</li>
				<li>
					<a class="set_menu" style="cursor:pointer;">��ѡ��</a>
					<div class="m_set_list" style="display: none;" id="uploadList">
						<em></em>
						<?php
        						$query = $db->query("select * from ".tname('class')." where CD_ID>1 and CD_ID<5 and CD_IsHide=0 order by CD_TheOrder asc");
        						while ($row = $db->fetch_array($query)) {
								echo "<a href=\"".LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],1)."\" target=\"_blank\" class=\"list\"><b class=\"like\"></b>".$row["CD_Name"]."</a>";
							}
						?>
					</div>
				</li>
				<li>
					<a class="set_menu" style="cursor:pointer;">���ִ�ȫ</a>
					<div class="m_set_list" style="display: none;" id="uploadList">
						<em></em>
						<?php
        						if(cd_webhtml==3){$singersearch=cd_webpath."singertag/";}else{$singersearch=cd_webpath."search.php?action=singer&key=";}
								echo "<a href=\"".$singersearch."�������\" target=\"_blank\" class=\"list\"><b class=\"like\"></b>�������</a>";
								echo "<a href=\"".$singersearch."ŷ������\" target=\"_blank\" class=\"list\"><b class=\"like\"></b>ŷ������</a>";
								echo "<a href=\"".$singersearch."�պ�����\" target=\"_blank\" class=\"list\"><b class=\"like\"></b>�պ�����</a>";
						?>
					</div>
				</li>
				<li>
					<a class="set_menu" style="cursor:pointer;">���а�</a>
					<div class="m_set_list" style="display: none;" id="uploadList">
						<em></em>
						<?php
        						$query = $db->query("select * from ".tname('class')." where CD_ID>4 and CD_ID<13 and CD_IsHide=0 order by CD_TheOrder asc");
        						while ($row = $db->fetch_array($query)) {
								echo "<a href=\"".LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],1)."\" target=\"_blank\" class=\"list\"><b class=\"like\"></b>".$row["CD_Name"]."</a>";
							}
						?>
					</div>
				</li>
				<li>
					<a class="set_menu" style="cursor:pointer;">��ƵMV</a>
					<div class="m_set_list menu" style="display: none;" id="uploadList">
						<em></em>
						<?php
        						$query = $db->query("select * from ".tname('videoclass')." where CD_IsIndex=0 order by CD_TheOrder asc");
        						while ($row = $db->fetch_array($query)) {
								echo "<a href=\"".LinkClassUrl("video",$row['CD_ID'],"",1)."\" target=\"_blank\" class=\"list\"><b class=\"like\"></b>".$row["CD_Name"]."</a>";
							}
						?>
					</div>
				</li>
				<li>
					<a target="list" href="<?php echo cd_upath.rewrite_url('index.php?p=home&a=album'); ?>">ͼ��</a>
				</li>
			</ul>
			<div class="user">
				<?php if($userlogined){ ?>
				<div class="face">
					<img class="avatar" width="20" height="20" src="<?php echo getavatar($qianwei_in_userid,48); ?>"/>
				</div>
				<div class="info">
					<a class="nickname" href="<?php echo linkweburl($qianwei_in_userid,$qianwei_in_username); ?>" target="_blank" title="������ҳ"><?php echo $qianwei_in_nicheng; ?></a>
					<a href="<?php echo cd_upath.rewrite_url('index.php?p=system&a=home'); ?>" target="_blank">��������</a>
					<span id="feedTips" class="feedTips" style="display:none;" title="���ĺ������µĶ�̬!"></span>
					<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=notification'); ?>" target="_blank">֪ͨ</a>
					<span id="msgTips" class="msgTips" style="display:none;" title="�����µ���Ϣ!"></span>
					<div class="set_list">
						<a class="set_menu icon share" id="userInfo" href="javascript:;" title="�ҵķ���">����</a>
						<div class="m_set_list" style="display: none;" id="uploadList">
							<em></em>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=share'); ?>">
								<b class="share"></b>��������
							</a>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=special&a=share'); ?>">
								<b class="dan"></b>����ר��
							</a>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=singer&a=share'); ?>">
								<b class="dan"></b>��������
							</a>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=video&a=share'); ?>">
								<b class="audit"></b>������Ƶ
							</a>
						</div>
					</div>
					<div class="set_list">
						<a class="set_menu icon song" id="userInfo" href="javascript:;" title="�ҵĸ赥">�赥</a>
						<div class="m_set_list" style="display: none;" id="uploadList">
							<em></em>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=like&i=me'); ?>">
								<b class="like"></b>��ϲ����
							</a>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=dislike&i=me'); ?>">
								<b class="boring"></b>�������
							</a>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=favorites&i=me'); ?>">
								<b class="recom"></b>���ղص�
							</a>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=down&i=me'); ?>">
								<b class="download"></b>�����ص�
							</a>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=listen&i=me'); ?>">
								<b class="pass"></b>��������
							</a>
						</div>
					</div>
					<div class="set_list">
						<a class= "set_menu icon set" href="javascript:;" title="��������">����</a>
						<div class="m_set_list" style="display: none;">
							<em></em>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=profileModify'); ?>">
								<b class="setup"></b>��������
							</a>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=profileModify&i=avatar'); ?>">
								<b class="avatar"></b>�޸�ͷ��
							</a>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=skin'); ?>">
								<b class="skin"></b>�ռ任��
							</a>
							<a class="list" href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=logout'); ?>">
								<b class="exit"></b>�˳���¼
							</a>
						</div>
					</div>
				</div>
				<?php }else{ ?>
				<div class="face">
					<img class="avatar" width="20" height="20" src="<?php echo getavatar(0,48); ?>"/>
				</div>
				<div class="info">
					<em>��ӭ����¼��</em>
					<a href="<?php echo cd_upath; ?>" target="_blank">��Ա�ռ�</a>
					<a href="javascript:;" onclick="libs.login();">�� ¼</a>
					<a href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=register'); ?>">ע ��</a>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php
		if($a == 'miniblog'){
			echo '<div id="feedm" class="nav">';
		}elseif($a == 'listen'){
			echo '<div id="lastlistenm" class="nav">';
		}elseif($a == 'album'){
			echo '<div id="albumnm" class="nav">';
		}elseif($a == 'following'){
			echo '<div id="fansm" class="nav">';
		}else{
			echo '<div id="'.$a.'m" class="nav">';
		}
	?>
		<ul>
			<li class="mindex"><span><a href="<?php echo linkweburl($qianwei_web_userid,$qianwei_web_username); ?>">��ҳ</a></span></li>
			<li class="mfeed"><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=feed&uid='.$qianwei_web_userid); ?>">��̬</a></span></li>
			<li class="mfavorites"><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=favorites&uid='.$qianwei_web_userid); ?>">�ղ�</a></span></li>
			<li class="mdance"><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=dance&uid='.$qianwei_web_userid); ?>">����</a></span></li>
			<li class="mlastlisten"><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=listen&uid='.$qianwei_web_userid); ?>">����</a></span></li>
			<li class="malbum"><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=album&uid='.$qianwei_web_userid); ?>">��Ƭ</a></span></li>
			<li class="mfans"><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=following&uid='.$qianwei_web_userid); ?>">��ϵ</a></span></li>
			<li class="mwall"><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=wall&uid='.$qianwei_web_userid); ?>">����</a></span></li>
			<?php if($a == 'skin'){ ?><li class="mskin"><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=skin'); ?>">����</a></span></li><?php } ?>
		</ul>
	</div>
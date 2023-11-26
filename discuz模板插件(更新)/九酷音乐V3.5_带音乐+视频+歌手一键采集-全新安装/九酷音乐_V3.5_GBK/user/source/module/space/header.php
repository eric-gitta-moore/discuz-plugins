	<div class="top" id="top">
		<div class="topNav">
			<ul>
				<li class="logo">
					<a target="list" href="<?php echo cd_upath; ?>"></a>
				</li>
				<li>
					<a target="list" href="<?php echo cd_webpath; ?>">首页</a>
				</li>
				<li>
					<a class="set_menu" style="cursor:pointer;">音乐库</a>
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
					<a class="set_menu" style="cursor:pointer;">精选集</a>
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
					<a class="set_menu" style="cursor:pointer;">歌手大全</a>
					<div class="m_set_list" style="display: none;" id="uploadList">
						<em></em>
						<?php
        						if(cd_webhtml==3){$singersearch=cd_webpath."singertag/";}else{$singersearch=cd_webpath."search.php?action=singer&key=";}
								echo "<a href=\"".$singersearch."华语歌手\" target=\"_blank\" class=\"list\"><b class=\"like\"></b>华语歌手</a>";
								echo "<a href=\"".$singersearch."欧美歌手\" target=\"_blank\" class=\"list\"><b class=\"like\"></b>欧美歌手</a>";
								echo "<a href=\"".$singersearch."日韩歌手\" target=\"_blank\" class=\"list\"><b class=\"like\"></b>日韩歌手</a>";
						?>
					</div>
				</li>
				<li>
					<a class="set_menu" style="cursor:pointer;">排行榜</a>
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
					<a class="set_menu" style="cursor:pointer;">视频MV</a>
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
					<a target="list" href="<?php echo cd_upath.rewrite_url('index.php?p=home&a=album'); ?>">图集</a>
				</li>
			</ul>
			<div class="user">
				<?php if($userlogined){ ?>
				<div class="face">
					<img class="avatar" width="20" height="20" src="<?php echo getavatar($qianwei_in_userid,48); ?>"/>
				</div>
				<div class="info">
					<a class="nickname" href="<?php echo linkweburl($qianwei_in_userid,$qianwei_in_username); ?>" target="_blank" title="个人主页"><?php echo $qianwei_in_nicheng; ?></a>
					<a href="<?php echo cd_upath.rewrite_url('index.php?p=system&a=home'); ?>" target="_blank">个人中心</a>
					<span id="feedTips" class="feedTips" style="display:none;" title="您的好友有新的动态!"></span>
					<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=notification'); ?>" target="_blank">通知</a>
					<span id="msgTips" class="msgTips" style="display:none;" title="您有新的消息!"></span>
					<div class="set_list">
						<a class="set_menu icon share" id="userInfo" href="javascript:;" title="我的分享">分享</a>
						<div class="m_set_list" style="display: none;" id="uploadList">
							<em></em>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=share'); ?>">
								<b class="share"></b>分享音乐
							</a>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=special&a=share'); ?>">
								<b class="dan"></b>制作专辑
							</a>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=singer&a=share'); ?>">
								<b class="dan"></b>创建歌手
							</a>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=video&a=share'); ?>">
								<b class="audit"></b>发布视频
							</a>
						</div>
					</div>
					<div class="set_list">
						<a class="set_menu icon song" id="userInfo" href="javascript:;" title="我的歌单">歌单</a>
						<div class="m_set_list" style="display: none;" id="uploadList">
							<em></em>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=like&i=me'); ?>">
								<b class="like"></b>我喜欢的
							</a>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=dislike&i=me'); ?>">
								<b class="boring"></b>我讨厌的
							</a>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=favorites&i=me'); ?>">
								<b class="recom"></b>我收藏的
							</a>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=down&i=me'); ?>">
								<b class="download"></b>我下载的
							</a>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=listen&i=me'); ?>">
								<b class="pass"></b>我听过的
							</a>
						</div>
					</div>
					<div class="set_list">
						<a class= "set_menu icon set" href="javascript:;" title="个人设置">设置</a>
						<div class="m_set_list" style="display: none;">
							<em></em>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=profileModify'); ?>">
								<b class="setup"></b>个人设置
							</a>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=profileModify&i=avatar'); ?>">
								<b class="avatar"></b>修改头像
							</a>
							<a class="list" target="_blank" href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=skin'); ?>">
								<b class="skin"></b>空间换肤
							</a>
							<a class="list" href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=logout'); ?>">
								<b class="exit"></b>退出登录
							</a>
						</div>
					</div>
				</div>
				<?php }else{ ?>
				<div class="face">
					<img class="avatar" width="20" height="20" src="<?php echo getavatar(0,48); ?>"/>
				</div>
				<div class="info">
					<em>欢迎您登录！</em>
					<a href="<?php echo cd_upath; ?>" target="_blank">会员空间</a>
					<a href="javascript:;" onclick="libs.login();">登 录</a>
					<a href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=register'); ?>">注 册</a>
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
			<li class="mindex"><span><a href="<?php echo linkweburl($qianwei_web_userid,$qianwei_web_username); ?>">主页</a></span></li>
			<li class="mfeed"><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=feed&uid='.$qianwei_web_userid); ?>">动态</a></span></li>
			<li class="mfavorites"><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=favorites&uid='.$qianwei_web_userid); ?>">收藏</a></span></li>
			<li class="mdance"><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=dance&uid='.$qianwei_web_userid); ?>">分享</a></span></li>
			<li class="mlastlisten"><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=listen&uid='.$qianwei_web_userid); ?>">听过</a></span></li>
			<li class="malbum"><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=album&uid='.$qianwei_web_userid); ?>">照片</a></span></li>
			<li class="mfans"><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=following&uid='.$qianwei_web_userid); ?>">关系</a></span></li>
			<li class="mwall"><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=wall&uid='.$qianwei_web_userid); ?>">留言</a></span></li>
			<?php if($a == 'skin'){ ?><li class="mskin"><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=skin'); ?>">换肤</a></span></li><?php } ?>
		</ul>
	</div>
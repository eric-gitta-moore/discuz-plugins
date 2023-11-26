		<div class="h_main">
			<a class="logo" href="<?php echo cd_upath; ?>"></a>
			<ul class="menus">
				<li class="m_nav_a"><a class="sliding_menu" href="<?php echo cd_webpath; ?>" target="_blank">首页<b class="arrow"></b></a></li>
				<li class="m_nav_b">
					<a class="sliding_menu" style="cursor:pointer;">音乐库<b class="arrow"></b></a>
					<div class="m_nav_list dance" style="display: none;">
						<em></em>
						<div class="width">
							<div class="right">
							<div class="list">
								<div class="cate_words">
									<?php
										global $db,$userlogined;
        									$query = $db->query("select * from ".tname('class')." where CD_FatherID=1 and CD_IsHide=0 order by CD_TheOrder asc");
        									while ($row = $db->fetch_array($query)) {
											echo '<a href="'.LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],1).'" target="_blank">'.$row['CD_Name'].'</a>';
										}
									?>
								</div>
							</div>
							<div class="left">
									<?php
        									$query = $db->query("select * from ".tname('class')." where CD_ID>1 and CD_ID<5 and CD_IsHide=0 order by CD_TheOrder asc");
        									while ($row = $db->fetch_array($query)) {
											echo '<div class="list"><a class="m_nav_list_clo" href="'.LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],1).'" target="_blank"><b></b>'.$row['CD_Name'].'</a></div>';
										}
									?>
									<?php
        									if(cd_webhtml==3){$singersearch=cd_webpath."singertag/";}else{$singersearch=cd_webpath."search.php?action=singer&key=";}
        									echo '<div class="list"><a class="m_nav_list_clo" href="'.$singersearch.'华语歌手" target="_blank"><b></b>华语歌手</a></div>';
        									echo '<div class="list"><a class="m_nav_list_clo" href="'.$singersearch.'欧美歌手" target="_blank"><b></b>欧美歌手</a></div>';
        									echo '<div class="list"><a class="m_nav_list_clo" href="'.$singersearch.'日韩歌手" target="_blank"><b></b>日韩歌手</a></div>';
									?>
							</div>
							</div>
						</div>
					</div>
				</li>
				<li class="m_nav_b">
					<a class="sliding_menu" style="cursor:pointer;">排行榜<b class="arrow"></b></a>
					<div class="m_nav_list popularity" style="display: none;">
						<em></em>
									<?php
        									$query = $db->query("select * from ".tname('class')." where CD_ID>4 and CD_ID<13 and CD_IsHide=0 order by CD_TheOrder asc");
        									while ($row = $db->fetch_array($query)) {
											echo '<div class="list"><a class="m_nav_list_clo" href="'.LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],1).'" target="_blank"><b></b>'.$row['CD_Name'].'</a></div>';
										}
									?>
					</div>
				</li>
				<li class="m_nav_c">
					<a class="sliding_menu" style="cursor:pointer;">视频MV<b class="arrow"></b></a>
					<div class="m_nav_list square" style="display: none;">
						<em></em>
									<?php
        									$query = $db->query("select * from ".tname('videoclass')." where CD_IsIndex=0 order by CD_TheOrder asc");
        									while ($row = $db->fetch_array($query)) {
											echo '<div class="list"><a class="m_nav_list_clo" href="'.LinkClassUrl("video",$row['CD_ID'],"",1).'" target="_blank"><b></b>'.$row['CD_Name'].'</a></div>';
										}
									?>
					</div>
				</li>
				<li class="m_nav_a"><a class="sliding_menu" href="<?php echo cd_upath.rewrite_url('index.php?p=home&a=album'); ?>" target="_blank">图集<b class="arrow"></b></a></li>
			</ul>

			<?php if(!$userlogined){ ?>
			<ul class="member" style="display: block;" id="welcome">
				<li><a href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=register'); ?>" target="_blank">免费注册</a></li>
				<li>|</li>
				<li><a class="ti" style="cursor:pointer;" onclick="libs.login();">请登录</a></li>
			</ul>
			<?php }else{ ?>
			<ul class="member_login" id="userLogin">
				<li>
					<a href="<?php echo linkweburl($qianwei_in_userid,$qianwei_in_username); ?>" target="_blank">
						<img src="<?php echo getavatar($qianwei_in_userid,48); ?>" id="userInfo">
					</a>
				</li>
				<li>
					<a class="icon" href="<?php echo cd_upath.rewrite_url('index.php?p=system&a=home'); ?>" target="_blank" title="个人中心"> </a>
					<span id="feedTips" class="feed_tips" style="display: none;" title="好友新动态!"></span>
				</li>
				<li>
					<a class="icon inform" href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=notification'); ?>" target="_blank" title="通知"> </a>
					<span id="msgTips" class="msg_tips" title="新短消息!" style="display: none;"></span>
				</li>
				<li><a class="set_menu icon share" href="javascript:;" title="我的分享"> </a>
					<div class="m_set_list menu" style="display: none;" id="uploadList">
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
				</li>
				<li><a class="set_menu icon song" href="javascript:;" title="我的歌单"> </a>
					<div class="m_set_list menu" style="display: none;" id="uploadList">
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
				</li>
				<li>
					<a class= "set_menu icon set" href="javascript:;" title="个人设置"> </a>
					<div class="m_set_list menu" style="display: none;">
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
				</li>
			</ul>
			<?php } ?>
		</div>
		<div class="class_nav">
			<div class="left">
				<ul type="square">
					<li><a href="<?php echo cd_upath.rewrite_url('index.php?p=home&a=album'); ?>" target="_blank">乐迷相册</a></li>
					<li><a href="<?php echo cd_upath.rewrite_url('index.php?p=home&a=producerrec'); ?>" target="_blank">音乐认证</a></li>
					<li><a href="<?php echo cd_upath.rewrite_url('index.php?p=home&a=useractive'); ?>" target="_blank">活跃用户</a></li>
					<li><a href="<?php echo cd_upath.rewrite_url('index.php?p=home&a=privilege'); ?>" target="_blank">美女认证</a></li>
				</ul>
			</div>
			<form id="searchForm" onSubmit="searchDance.init();return false;">
			<div class="serach right">
				<div class="seh_list">
					<a class="seh_list_a" href="javascript:;" id="searchType" sid="1">音乐<b class="arrow"></b></a>
					<div class="seh_sort" style="display: none;">
						<a href="javascript:;">音乐</a>
						<a href="javascript:;">用户</a>
					</div>
				</div>
				<div class="seh_m"><input id="txtKey" class="seh_v" type="text" ><input class="seh_b f16" type="submit"></input></div>
			</div>
			</form>
		</div>
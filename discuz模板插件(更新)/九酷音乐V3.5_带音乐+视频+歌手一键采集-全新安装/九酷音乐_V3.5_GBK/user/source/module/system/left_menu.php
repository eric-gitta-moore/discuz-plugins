			<div class="userinfo">
				<div class="face">
					<a href="<?php echo linkweburl($qianwei_in_userid,$qianwei_in_username); ?>" target="_blank"><img src="<?php echo getavatar($qianwei_in_userid,200); ?>" id="menu-avatar"></a>
				</div>
				<ul class="info_list">
					<li>
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=following&uid='.$qianwei_in_userid); ?>" target="_blank">
						<span><?php echo $qianwei_in_friendnum; ?></span>
						<strong>关注</strong>
						</a>
					</li>
					<li>
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=fans&uid='.$qianwei_in_userid); ?>" target="_blank">
						<span><?php echo $qianwei_in_fansnum; ?></span>
						<strong>粉丝</strong>
						</a>
					</li>
					<li class="last">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=favorites&uid='.$qianwei_in_userid); ?>" target="_blank">
						<span><?php echo $qianwei_in_favnum; ?></span>
						<strong>收藏</strong>
						</a>
					</li>
				</ul>
			</div>
			<div class="menu_center">
				<ul>
					<li class="mfeed">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=system&a=home'); ?>">
							<span class="iconFeed">首页</span>
						</a>
						<em></em>
					</li>
					<li class="mdiscovery">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=video&a=list'); ?>">
							<span class="iconDiscovery">视频列表</span>
						</a>
						<em></em>
					</li>
					<li class="mcomment">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=special&a=list'); ?>">
							<span class="iconComment">专辑列表</span>
						</a>
						<em></em>
					</li>
					<li class="maction">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=singer&a=list'); ?>">
							<span class="iconAction">歌手列表</span>
						</a>
						<em></em>
					</li>
					<li class="mshare">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=list'); ?>">
							<span class="iconShare">音乐列表</span>
						</a>
						<em></em>
					</li>
					<li class="msong">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=like&i=me'); ?>">
							<span class="iconSong">我的歌单</span>
						</a>
						<em></em>
					</li>
					<li class="mminiblog">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=miniblog&a=me'); ?>">
							<span class="iconMiniblog">随便说说</span>
						</a>
						<em></em>
					</li>
					<li class="malbum">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=album&a=me'); ?>">
							<span class="iconAlbum">照片墙</span>
						</a>
						<em></em>
					</li>
					<li class="mwall">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=wall&a=me'); ?>">
							<span class="iconWall">留言板</span>
						</a>
						<em></em>
					</li>
					<li class="mmessage">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=msg'); ?>">
							<span class="iconMessage">私信</span>
						</a>
						<em></em>
					</li>
					<li class="mnotification">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=notification'); ?>">
							<span class="iconNotification">通知</span>
						</a>
						<em></em>
					</li>
					<li class="mfans">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=following'); ?>">
							<span class="iconFans">关系</span>
						</a>
						<em></em>
					</li>
					<li class="maccount">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=account&a=assets'); ?>">
							<span class="iconAccount">账户</span>
						</a>
						<em></em>
					</li>
					<li class="mprofile">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=profileModify'); ?>">
							<span class="iconProfile">设置</span>
						</a>
						<em></em>
					</li>
				</ul>
			</div>
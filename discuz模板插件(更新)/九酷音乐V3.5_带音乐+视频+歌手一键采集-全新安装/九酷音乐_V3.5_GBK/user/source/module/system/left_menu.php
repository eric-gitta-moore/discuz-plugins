			<div class="userinfo">
				<div class="face">
					<a href="<?php echo linkweburl($qianwei_in_userid,$qianwei_in_username); ?>" target="_blank"><img src="<?php echo getavatar($qianwei_in_userid,200); ?>" id="menu-avatar"></a>
				</div>
				<ul class="info_list">
					<li>
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=following&uid='.$qianwei_in_userid); ?>" target="_blank">
						<span><?php echo $qianwei_in_friendnum; ?></span>
						<strong>��ע</strong>
						</a>
					</li>
					<li>
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=fans&uid='.$qianwei_in_userid); ?>" target="_blank">
						<span><?php echo $qianwei_in_fansnum; ?></span>
						<strong>��˿</strong>
						</a>
					</li>
					<li class="last">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=favorites&uid='.$qianwei_in_userid); ?>" target="_blank">
						<span><?php echo $qianwei_in_favnum; ?></span>
						<strong>�ղ�</strong>
						</a>
					</li>
				</ul>
			</div>
			<div class="menu_center">
				<ul>
					<li class="mfeed">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=system&a=home'); ?>">
							<span class="iconFeed">��ҳ</span>
						</a>
						<em></em>
					</li>
					<li class="mdiscovery">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=video&a=list'); ?>">
							<span class="iconDiscovery">��Ƶ�б�</span>
						</a>
						<em></em>
					</li>
					<li class="mcomment">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=special&a=list'); ?>">
							<span class="iconComment">ר���б�</span>
						</a>
						<em></em>
					</li>
					<li class="maction">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=singer&a=list'); ?>">
							<span class="iconAction">�����б�</span>
						</a>
						<em></em>
					</li>
					<li class="mshare">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=list'); ?>">
							<span class="iconShare">�����б�</span>
						</a>
						<em></em>
					</li>
					<li class="msong">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=like&i=me'); ?>">
							<span class="iconSong">�ҵĸ赥</span>
						</a>
						<em></em>
					</li>
					<li class="mminiblog">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=miniblog&a=me'); ?>">
							<span class="iconMiniblog">���˵˵</span>
						</a>
						<em></em>
					</li>
					<li class="malbum">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=album&a=me'); ?>">
							<span class="iconAlbum">��Ƭǽ</span>
						</a>
						<em></em>
					</li>
					<li class="mwall">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=wall&a=me'); ?>">
							<span class="iconWall">���԰�</span>
						</a>
						<em></em>
					</li>
					<li class="mmessage">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=msg'); ?>">
							<span class="iconMessage">˽��</span>
						</a>
						<em></em>
					</li>
					<li class="mnotification">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=notification'); ?>">
							<span class="iconNotification">֪ͨ</span>
						</a>
						<em></em>
					</li>
					<li class="mfans">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=following'); ?>">
							<span class="iconFans">��ϵ</span>
						</a>
						<em></em>
					</li>
					<li class="maccount">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=account&a=assets'); ?>">
							<span class="iconAccount">�˻�</span>
						</a>
						<em></em>
					</li>
					<li class="mprofile">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=profileModify'); ?>">
							<span class="iconProfile">����</span>
						</a>
						<em></em>
					</li>
				</ul>
			</div>
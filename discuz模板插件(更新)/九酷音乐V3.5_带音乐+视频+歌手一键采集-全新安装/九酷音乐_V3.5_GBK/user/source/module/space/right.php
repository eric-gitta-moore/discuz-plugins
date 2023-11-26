			<div class="spaceUserInfo">
				<div class="nickname"><span><?php echo $qianwei_web_nicheng; ?></span><span><?php echo CheckCertify($qianwei_web_checkmusic,$qianwei_web_checkmm,$qianwei_web_grade,$qianwei_web_viprank); ?></span></div>
				<div class="avatarImages">
					<img height="160" width="160" src="<?php echo getavatar($qianwei_web_userid,200); ?>">
					<div class="online_state">
						<?php
							if(CheckLogin($qianwei_web_userid)){
								echo '<span class="online">当前在线</span>';
							}else{
								echo '<span class="offline">当前离线</span>';
							}
						?>
					</div>
				</div>
				<ul class="info_list no">
					<li>
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=following&uid='.$qianwei_web_userid); ?>">
							<span><?php echo $qianwei_web_idolnum; ?></span>
							<strong>关注</strong>
						</a>
					</li>
					<li>
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=fans&uid='.$qianwei_web_userid); ?>">
							<span><?php echo $qianwei_web_fansnum; ?></span>
							<strong>粉丝</strong>
						</a>
					</li>
					<li class="last">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=favorites&uid='.$qianwei_web_userid); ?>">
							<span><?php echo $qianwei_web_favnum; ?></span>
							<strong>收藏</strong>
						</a>
					</li>
				</ul>
				<div class="button">
					<div class="and">
						<a class="message" href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=wall&uid='.$qianwei_web_userid); ?>" title="留言"></a>
					</div>
					<div class="and" id="fans">
						<?php
							if($qianwei_web_userid == $qianwei_in_userid){
								echo '<a class="attention tabulation" href="'.cd_upath.'index.php?p=space&a=following&uid='.$qianwei_web_userid.'"></a>';
							}else{
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
							}
						?>
					</div>
				</div>
			</div>
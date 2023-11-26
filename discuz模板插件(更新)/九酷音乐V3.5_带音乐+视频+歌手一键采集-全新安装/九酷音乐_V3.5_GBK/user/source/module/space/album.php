<?php
include "../source/global/global_inc.php";
include "source/module/space/common.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title><?php echo $qianwei_web_nicheng; ?>的照片墙</title>
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
		<div class="<?php if($cd_id){ ?>publicLeft<?php }else{ ?>albumContent<?php } ?>">
			<div class="stageBox">
				<div class="stageBoxTop">
					<span></span>
				</div>
				<div class="stageBoxCenter  min_space_height">
					<?php if($cd_id){ ?>
					<div class="spaceMTitle2">
						<p><?php echo $qianwei_web_callname; ?>的照片墙 &raquo; </p>
						<em>查看照片</em>
					</div>
					<?php }else{ ?>
					<div class="albumTitle">
						<p><?php echo $qianwei_web_callname; ?>的照片墙</p>
						<?php if($qianwei_web_userid == $qianwei_in_userid){ ?>
							<span class="management"><a href="<?php echo cd_upath.rewrite_url('index.php?p=album&a=me'); ?>">管理</a></span>
						<?php }else{ ?>
							<span></span>
						<?php } ?>
					</div>
					<?php } ?>
					<div class="title_per on"> </div>
					<?php if($cd_id){ ?>
						<?php
								global $db;
								$sql="select * from ".tname('pic')." where cd_uid='$qianwei_web_userid' and cd_id='$cd_id'";
								$result=$db->query($sql);
								if($row=$db->fetch_array($result)){
									$db->query("update ".tname('pic')." set cd_hits=cd_hits+1 where cd_id='$cd_id'");

									$nopic = true;
									$cd_title = $row['cd_title'];
									$cd_url = $row['cd_url'];
									$cd_addtime = $row['cd_addtime'];
									$cd_praisenum = $row['cd_praisenum'];

                              						$rowfirst=$db->getrow("select cd_id from ".tname('pic')." where cd_uid='$qianwei_web_userid' order by cd_id asc");
                              						$cd_firstid=$rowfirst['cd_id'];

                              						$rowlast=$db->getrow("select cd_id from ".tname('pic')." where cd_uid='$qianwei_web_userid' order by cd_id desc");
                              						$cd_lastid=$rowlast['cd_id'];

									$di = 0;
									$query = $db->query("select * from ".tname('pic')." where cd_uid='$qianwei_web_userid' order by cd_id desc");
									while ($rows = $db->fetch_array($query)) {
										$di = $di+1;
										if($rows['cd_id'] == $cd_id)break;
									}

                              						$rowu=$db->getrow("select cd_id from ".tname('pic')." where cd_uid='$qianwei_web_userid' and cd_id>'".$cd_id."' order by cd_id asc");
									if($rowu){
										$cd_upurl = cd_upath.rewrite_url('index.php?p=space&a=album&uid='.$qianwei_web_userid.'&id='.$rowu['cd_id']);
									}else{
										$cd_upurl = cd_upath.rewrite_url('index.php?p=space&a=album&uid='.$qianwei_web_userid.'&id='.$cd_lastid);
									}

									$rowd=$db->getrow("select cd_id from ".tname('pic')." where cd_uid='$qianwei_web_userid' and cd_id<'".$cd_id."' order by cd_id desc");
									if($rowd){
										$cd_downurl = cd_upath.rewrite_url('index.php?p=space&a=album&uid='.$qianwei_web_userid.'&id='.$rowd['cd_id']);
									}else{
										$cd_downurl = cd_upath.rewrite_url('index.php?p=space&a=album&uid='.$qianwei_web_userid.'&id='.$cd_firstid);
									}
								}else{
									$nopic = false;
								}
						?>
						<div>
							<?php if($nopic){ ?>
							<div class="imageShowList" id="imagesSlide">
								<div class="images_slide" >
									<div class="images_slide_nav"><a class="prev" id="prevBtn" href="<?php echo $cd_upurl; ?>">上一张</a><a class="next" id="nextBtn" href="<?php echo $cd_downurl; ?>">下一张</a></div>
									<div class="images_slide_wrap" id="smalListPic">
										<ul class="images_slide_list">
											<?php
												global $db;
        											$query = $db->query("select cd_id,cd_url from ".tname('pic')." where cd_uid='$qianwei_web_userid' order by cd_id desc");
        											while ($rows = $db->fetch_array($query)) {
													echo '<li pid="'.$rows['cd_id'].'"><a href="'.cd_upath.rewrite_url('index.php?p=space&a=album&uid='.$qianwei_web_userid.'&id='.$rows['cd_id']).'"><img height="70" width="70" src="'.getalbumthumb($rows['cd_url'],1).'" onerror="$call(function(){libs.imageError(this);}, this)"/></a></li>';
												}	
											?>
										</ul>
									</div>
								</div>
							</div>
							<div class="imageShow">
								<div class="pic">
									<a href="javascript:;">
										<img id="imgItem" right="<?php echo $cd_downurl; ?>" left="<?php echo $cd_upurl; ?>" src="<?php echo getalbumthumb($cd_url,0); ?>" onerror="$call(function(){libs.imageError(this);}, this)" title="点击查看上一张"/>
									</a>
								</div>
								<div id="nameInfo" class="nameInfo">
									<span class="lquotes"></span>
									<?php echo $cd_title; ?>										
									<span id="name" class="rquotes"></span>
								</div>
								<div class="imageInfo">
									<div class="imgpraise">
										<div id="praise">
											<?php
												global $db;
        											$cd_ids = $db->getone("select cd_id from ".tname('pic_like')." where cd_uid='$qianwei_in_userid' and cd_dataid='$cd_id'");
												if($cd_ids){
											?>
												<a class="praiseImg" num="<?php echo $cd_praisenum; ?>" onclick="$call(function(){albumLib.cancelPraiseInit(<?php echo $qianwei_web_userid; ?>, <?php echo $cd_id; ?>)});" onmouseover="$('#praiseCount').html('-1');" onmouseout="$('#praiseCount').html('<?php echo $cd_praisenum; ?>');" title="取消喜欢"> </a>
											<?php }else{ ?>
												<a class="praiseImg" num="<?php echo $cd_praisenum; ?>" onclick="$call(function(){albumLib.picPraiseInit(<?php echo $qianwei_web_userid; ?>, <?php echo $cd_id; ?>)});" onmouseover="$('#praiseCount').html('+1');" onmouseout="$('#praiseCount').html('<?php echo $cd_praisenum; ?>');" title="喜欢就点一下"> </a>
											<?php } ?>
										</div>
										<div class="praiseDiv fl">
											<span id="praiseCount" class="praiseCount"><?php echo $cd_praisenum; ?></span>
											<i></i>
										</div>
									</div>
									<a id="imageClick">查看原图</a>
									<div id="create_time" class="create_time">上传于 <?php echo datetime(date('Y-m-d H:i:s',$cd_addtime)); ?> (<?php echo getfilesize(_qianwei_root_."data/attachment/album/".$cd_url); ?>)</div>
									<input id="showType" type="hidden" value="1">
									<input id="filePath" type="hidden" value="<?php echo cd_webpath; ?>data/attachment/album/<?php echo $cd_url; ?>">
									<div class="picName" pNum="" type="hidden"></div>
								</div>
								<div class="imageInfo">
									<?php if($qianwei_web_userid == $qianwei_in_userid){ ?>
									<a title="删除此照片" pid="<?php echo $cd_id; ?>" uid="<?php echo $qianwei_web_userid; ?>" class="delete">[删除]</a>
									<a class="explain" uid="<?php echo $qianwei_web_userid; ?>" pid="<?php echo $cd_id; ?>">[编辑说明]</a>
									<?php } ?>
								</div>
								<div class="clear"></div>
								<div id="imageNameInputBox" style="display: none;">
									<div class="imageNameInputBox">
										<div class="iNI_input">
											<textarea id="imageNameContent"></textarea>
										</div>
										<div class="iNI_button">
											<span class="button-main">
												<span>
													<button class="sends" uid="<?php echo $qianwei_web_userid; ?>" pid="<?php echo $cd_id; ?>" type="button">确认</button>
												</span>
											</span>
										</div>
										<div class="iNI_cancel">
											<a href="javascript:;" id="cencel">取消</a>
										</div>
										<div id="iNI_message" class="iNI_message"></div>
									</div>
								</div>
							</div>
							<div class="img_comments" style="display: block">
								<div class="comments_input">
									<div id="replayUser" class="replayUser" style="display: none;"></div>
									<div id="replayUserDel" class="addd" title="取消对此人的回复"  style="display: none;"></div>
									<div class="inputBox">
										<div id="note" class="note" contenteditable="true" name="note"></div>
									</div>
									<div class="sW_button">
										<span class="button-main">
											<span>
												<button id="submitBtn" uid="<?php echo $qianwei_web_userid; ?>" pid="<?php echo $cd_id; ?>" type="button">评论</button>
											</span>
										</span>
									</div>
									<div id="sW_message" class="wCI_message"></div>
									<div id="emot_note" class="emot" to="note"></div>
								</div>
							</div>
							<div id="picComment" class="picComment">
								<?php
									echo '<div id="comments_list" class="comments_list">';
									if($row['cd_replynum']){
										echo '<ul id="commentList" style="overflow: hidden;">';
        									$query = $db->query("select * from ".tname('comment')." where cd_channel=1 and cd_dataid='$cd_id' order by cd_addtime desc LIMIT 0,100");
        									while ($rows = $db->fetch_array($query)) {
											$cd_contents = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"emotImg\">", $rows['cd_content']);
											echo '<li id="comment" class="hover" style="_zoom:1;">';
											echo '<div class="pic"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank"><img class="avatar-20" src="'.getavatar($rows['cd_uid'],48).'"/></a></div>';
											echo '<div class="txt">';
											echo '<p>';
											echo '<span class="name"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank">'.GetAlias("qianwei_user","cd_nicheng","cd_id",$rows['cd_uid']).'：</a></span>';
											echo '<span class="content_id">'.$cd_contents.'</span>';
											echo '<span class="time">'.datetime($rows['cd_addtime']).'</span>';
											if($rows['cd_uid'] != $qianwei_in_userid){
												echo '<a id="comment" class="reply" authorId="'.$rows['cd_uid'].'" nickname="'.GetAlias("qianwei_user","cd_nicheng","cd_id",$rows['cd_uid']).'">回复</a>';
											}
											echo '</p>';
											echo '</div>';
											if($qianwei_web_userid == $qianwei_in_userid){
												echo '<span cid="'.$rows['cd_id'].'" uid="'.$qianwei_web_userid.'" class="del" title="删除"></span>';
											}
											echo '</li>';
										}
										echo '</ul>';
									}
									echo '</div>';
								?>
								<?php
        								$query = $db->query("select * from ".tname('pic_like')." where cd_dataid='$cd_id' order by cd_addtime desc LIMIT 0,16");
									$num = $db->num_rows($query);
									if($num){
										echo '<div class="Q_whoLiked">';
										echo '<div class="hd">';
										echo '<h2>这些人喜欢过</h2>';
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
										echo '<div id="praiseNum" type="hidden" num="'.$cd_praisenum.'"></div>';
										echo '</div>';
									}
								?>

							</div>
							<?php }else{ ?>
								<div class="nothing">您查看的照片不存在，或已被删除！</div>
							<?php } ?>
						</div>
					<?php }else{ ?>
						<div class="spaceAlbumList">
							<ul id="spaceAlbumList">
								<li class="char"></li>
							</ul>
							<div id="imgLoading" class="album_loading"></div>
							<div id="imgPages" class="page" style="display:none;">
								<?php
									global $db;
									$a=0;
									$sql="select * from ".tname('pic')." where cd_uid='$qianwei_web_userid' order by cd_theorder desc";
									$Arr=getwebpage($sql, 100, "index.php?p=space&a=".SafeRequest("a","get")."&uid=".$qianwei_web_userid);//sql,每页显示条数
									$result=$db->query($Arr[2]);
									$num=$db->num_rows($result);
									$lpids="";
									if($num==0){
										echo '<div class="nothing">暂时还没有照片啊！</div>';
									}else{
										if($result){
											while ($row = $db ->fetch_array($result)){
												$a=$a+1;
												$user = $db->getrow("select cd_nicheng from ".tname('user')." where cd_id='".$row['cd_uid']."'");
												$lpids=$lpids."{'pid': ".$row['cd_id'].",'src':'".getalbumthumb($row['cd_url'],2)."','create_time':'".datetime(date('Y-m-d',$row['cd_addtime']))."','uid':".$row['cd_uid'].",'praiseNum':".$row['cd_praisenum'].",'replyNum':".$row['cd_replynum'].",'width':".$row['cd_width'].",'height':".$row['cd_height'].",'avatar':'".getavatar($row['cd_uid'],48)."','nickname':'".$user['cd_nicheng']."'},";
											}
											$lpids=$lpids.']';
											$lpids=ReplaceStr($lpids,",]","");
										}
									}
								?>
								<?php if($num>0){?>
									<div class="pages">
										<?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href='<?php echo cd_upath.'index.php?p=space&a=album&uid='.$qianwei_web_userid.'&pages='; ?>'+val;return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="stageBoxBottom">
					<span></span>
				</div>
			</div>
		</div>
		<?php if($cd_id){ ?>
		<div class="publicRight">
			<?php include "source/module/space/right.php"; ?>
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
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/album.js"></script>
<?php if($cd_id){ ?>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/photosFous.js"></script>
<?php }else{ ?>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/jquery.masonry.min.js"></script>
<?php } ?>
<script type="text/javascript">
<?php if($cd_id){ ?>
	var currentPhotoIndex = <?php echo $di-1; ?>;
	$(document).ready(function(){
		albumLib.imageDetailInit();
		albumLib.imageDelInit(); 
		albumLib.imageNameModifyInit(); 
		albumLib.replayUserInit();
		albumLib.replayUserCancelInit();
		albumLib.imageCommentDelInit();
	});
<?php }else{ ?>
	var imgDatas = [<?php echo $lpids; ?>];
	imgLoaded.init('#spaceAlbumList', imgDatas, 2);
	libs.spaceInit();
<?php } ?>
</script>
</body>
</html>
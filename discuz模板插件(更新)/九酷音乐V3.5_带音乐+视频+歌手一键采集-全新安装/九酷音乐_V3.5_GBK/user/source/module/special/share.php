<?php
	include "../source/global/global_inc.php";
	global $db,$qianwei_in_userid;
	VerifyLogin($qianwei_in_userid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>制作专辑 - <?php echo cd_webname; ?></title>
	<script type="text/javascript">
		var domIsReady=false,domReadyList=[],domReadyObject=[],$call=function(callback,obj){if(typeof obj!=='object'){obj=document}if(domIsReady){callback.call(obj)}else{domReadyList.push(callback);domReadyObject.push(obj)}};
		var site_domain="<?php echo cd_webpath; ?>";zone_domain="<?php echo cd_upath; ?>";
	</script>
	<link type="text/css" href="<?php echo cd_upath; ?>static/css/core.css" rel="stylesheet" />
        <link type="text/css" href="<?php echo cd_upath; ?>static/site/css/common.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo cd_upath; ?>static/space/css/common.css" rel="stylesheet" media="all" />
	<link type="text/css" href="<?php echo cd_upath; ?>static/space/css/user.css" rel="stylesheet" media="all" />
</head>
<body>
<div class="header"><?php include "source/module/system/header.php"; ?></div>
<div class="user">
	<div class="user_center">
		<div class="user_menu" id="commentm">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_content">
				<div class="main_nav">
					<ul>
						<li class="concert">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=special&a=list'); ?>">已审专辑</a>
						</li>
						<li class="find">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=special&a=pass'); ?>">待审专辑</a>
						</li>
					</ul>
					<div class="action">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=special&a=share'); ?>">制作专辑</a>
					</div>
				</div>
				<div class="main">
					<div id="tooltip" class="refresh">

					</div>
				</div>
				<div class="minHeight500">
					<div class="profile">
						<div class="title">
							<div class="name">制作专辑</div>
						</div>
                                                <form name="form">
                                                        <ul id="specialAddMain">
								<li>
									<div class="name">专辑名称：</div>
									<div class="input">
										<input type="text" style="width: 190px;" class="input_normal" name="rspecialName" id="rspecialName" maxlength="100" />
									</div>
									<div class="input_msg" id="mspecialName">作为专辑名称请您认真填写，合理的名称审核才会通过。</div>
								</li>
								<li>
									<div class="name">所属歌手：</div>
									<div class="input">
										<select style="width: 110px;" class="select_normal" name="rSingerID" id="rSingerID">
											<option value="">选择所属歌手</option>
											<option value="0">不属任何歌手</option>
											<?php
												$sqlclass="select * from ".tname('singer');
												$results=$db->query($sqlclass);
												if($results){
													while ($row3=$db->fetch_array($results)){
														echo "<option value='".$row3['CD_ID']."'>".getlen("len","10",$row3['CD_Name'])."</option>";
													}	
						
												}
											?>
										</select>
									</div>
									<div class="input_msg"><span class="button2-main"><span><button type="button" onclick="pop.up('选择歌手', '<?php echo cd_webpath; ?>admin.php?iframe=star&to=u&so=form.rSingerID', '500px', '400px', '80px');">选择</button></span></span></div><div class="input_msg" id="mSingerID">专辑的所属歌手，请选择加入一个。</div>
								</li>
								<li>
									<div class="name">发行公司：</div>
									<div class="input">
										<input type="text" style="width: 125px;" class="input_normal" name="rGongSi" id="rGongSi" maxlength="50" />
									</div>
									<div class="input_msg" id="mGongSi">专辑的发行公司，请正确选择。</div>
								</li>
								<li>
									<div class="name">所属分类：</div>
									<div class="input">
										<select style="width: 110px;" class="select_normal" name="rclassId" id="rclassId">
											<option value="0">选择所属分类</option>
											<?php
												$sqlclass="select * from ".tname('class')." where CD_SystemID=1 and CD_FatherID=1 and CD_IsHide=0";
												$results=$db->query($sqlclass);
												if($results){
													while ($row3=$db->fetch_array($results)){
														echo "<option value='".$row3['CD_ID']."'>".$row3['CD_Name']."</option>";
													}	
						
												}
											?>
										</select>
									</div>
									<div class="input_msg" id="mclassId">专辑的所属分类，请正确选择。</div>
								</li>
								<li>
									<div class="name">所属语言：</div>
									<div class="input">
										<select style="width: 110px;" class="select_normal" name="rYuYan" id="rYuYan">
											<option value="">选择所属语言</option>
											<option value="国语">国语</option>
											<option value="粤语">粤语</option>
											<option value="闽语">闽语</option>
											<option value="英语">英语</option>
											<option value="日语">日语</option>
											<option value="韩语">韩语</option>
											<option value="其它">其它</option>
										</select>
									</div>
									<div class="input_msg" id="mYuYan">专辑的所属语言，请正确选择。</div>
								</li>
								<li>
									<div class="name">设置封面：</div>
									<div class="input">
										<input type="text" style="width: 320px;" class="input_normal" name="rPic" id="rPic" />
									</div>
									<div class="input_msg"><span class="button2-main"><span><button type="button" onclick="pop.up('上传封面', '<?php echo cd_webpath; ?>plugin.php?open=upload&opens=index&to=user&ac=pic&f=form.rPic', '406px', '180px', '140px');">本地上传</button></span></span></div><div class="input_msg" id="mPic"></div>
								</li>
								<li class="note">
									<div class="name">专辑简介：</div>
									<div class="input">
										<textarea name="rIntro" id="rIntro"></textarea>
									</div>
								</li>
								<li>
									<div class="name"></div>
									<div class="input">
										<span class="button-main"><span><button type="button" id="specialNewAdd">上传保存</button></span></span>
									</div>
								</li>
                                                        </ul>
                                                </form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="user_copyright"><?php include "source/module/system/footer.php"; ?></div>
</div>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/core.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/card.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/dialog.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/jquery.plugins.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/common.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/special.js"></script>
<script type="text/javascript" src="<?php echo cd_webpath; ?>source/plugin/layer/lib.js"></script>
<script type="text/javascript">
listenMsg.start();
nav.init();
nav.userMenu();
specialLib.shareAddInit();
layer.ready(function() {
        pop = {
                up : function(text, url, width, height, top) {
                        $.layer({
                                type : 2,
                                title : text,
                                iframe : {src : url},
                                area : [width, height],
                                offset : [top, '50%'],
                                shade : [0.1, '#000', true]
                        });
                }
        }
});
</script>
</body>
</html>
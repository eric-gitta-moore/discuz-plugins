<?php
	include "../source/global/global_inc.php";
	global $db,$qianwei_in_userid;
	VerifyLogin($qianwei_in_userid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>创建歌手 - <?php echo cd_webname; ?></title>
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
		<div class="user_menu" id="actionm">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_content">
				<div class="main_nav">
					<ul>
						<li class="concert">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=singer&a=list'); ?>">已审歌手</a>
						</li>
						<li class="find">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=singer&a=pass'); ?>">待审歌手</a>
						</li>
					</ul>
					<div class="action">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=singer&a=share'); ?>">创建歌手</a>
					</div>
				</div>
				<div class="main">
					<div id="tooltip" class="refresh">

					</div>
				</div>
				<div class="minHeight500">
					<div class="profile">
						<div class="title">
							<div class="name">创建歌手</div>
						</div>
                                                <form name="form">
                                                        <ul id="singerAddMain">
								<li>
									<div class="name">歌手名称：</div>
									<div class="input">
										<input type="text" style="width: 190px;" class="input_normal" name="rsingerName" id="rsingerName" maxlength="100" />
									</div>
									<div class="input_msg" id="msingerName">作为歌手名称请您认真填写，合理的名称审核才会通过。</div>
								</li>
								<li>
									<div class="name">所属分类：</div>
									<div class="input">
										<select style="width: 110px;" class="select_normal" name="rArea" id="rArea">
											<option value="">选择所属分类</option>
											<option value="华语歌手">华语歌手</option>
											<option value="欧美歌手">欧美歌手</option>
											<option value="日韩歌手">日韩歌手</option>
										</select>
									</div>
									<div class="input_msg" id="mArea">歌手的所属分类，请正确选择。</div>
								</li>
								<li>
									<div class="name">设置封面：</div>
									<div class="input">
										<input type="text" style="width: 320px;" class="input_normal" name="rPic" id="rPic" />
									</div>
									<div class="input_msg"><span class="button2-main"><span><button type="button" onclick="pop.up('上传封面', '<?php echo cd_webpath; ?>plugin.php?open=upload&opens=index&to=user&ac=pic&f=form.rPic', '406px', '180px', '140px');">本地上传</button></span></span></div><div class="input_msg" id="mPic"></div>
								</li>
								<li class="note">
									<div class="name">歌手简介：</div>
									<div class="input">
										<textarea name="rIntro" id="rIntro"></textarea>
									</div>
								</li>
								<li>
									<div class="name"></div>
									<div class="input">
										<span class="button-main"><span><button type="button" id="singerNewAdd">上传保存</button></span></span>
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
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/singer.js"></script>
<script type="text/javascript" src="<?php echo cd_webpath; ?>source/plugin/layer/lib.js"></script>
<script type="text/javascript">
listenMsg.start();
nav.init();
nav.userMenu();
singerLib.shareAddInit();
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
<?php
	include "../source/global/global_inc.php";
        global $db;
	VerifyLogin($qianwei_in_userid);
	$step = SafeRequest("step","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>������Ů��֤ - <?php echo cd_webname; ?></title>
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
		<div class="user_menu" id="profilem">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_content">
				<div class="main_nav">
					<ul>
						<li class="modify">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=profileModify'); ?>">��������</a>
						</li>
						<li class="skin">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=skin'); ?>" target="_blank">�ռ任��</a>
						</li>	
						<li class="certify">
							<a class="on" href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=applyCertify'); ?>">��Ů��֤</a>
						</li>
					</ul>
				</div>
				<div class="main">
					<div id="tooltip" class="refresh">

					</div>
				</div>
				<div class="minHeight500">
					<?php if($qianwei_in_sex == "1"){ ?>
					<div class="nothing">������Ů�ԣ��޷��μ���Ů��֤��</div>
					<?php }elseif($qianwei_in_checkmm == "1"){ ?>
					<div class="nothing">����ͨ����֤�������ٲμ���Ů��֤��</div>
					<?php }else{ ?>
					<div id="modifyAvatar" class="profile">
						<div class="title"><div class="name">������֤</div></div>
						<div class="avatar_box">
							<div class="state">��֤״̬��<?php if($qianwei_in_checkmm == "1"){ echo '<font color="#FF0000">��ͨ����֤��</font>'; }elseif($qianwei_in_checkmm == "2"){ echo '<font color="#FF0000">���ύ��ˣ�</font>'; }else{ echo 'δ������֤��'; }?></div>
							<?php if($step == "2"){ ?>
								<div class="avatarTitle">����ͷ����</div>
								<div id="camera" class="camera">
									<div id="cam" class="cam">
										<div id="webcam" class="webcam"></div>
									</div>
									<div id="buttons" class="buttons">
										<div class="button_pane" id="shoot"><a id="btn_shoot" href="javascript:;" class="btn_camera">����</a></div>
										<div class="button_pane hidden" id="upload"><a id="btn_upload" href="" class="btn_green">������֤</a><a id="btn_cancel" href="javascript:;" class="btn_cancel">ȡ��</a></div>
										<div class="button_pane hidden" id="loading" style="display:none;"><a href="javascript:;" class="btn_cancel">�ϴ���...</a></div>
									</div>
								</div>
								<ul class="process">
									<li class="pro">��֤����</li>
									<li>1.��ͨ�������豸�������գ����ĺõ���Ƶ��Ƭ�ϴ�����վ��</li>
									<li>2.���ǻ�����಻����10Сʱ������������롣</li>
									<li>3.���ͨ�������Ϳ��Գ�Ϊ��֤�û�������֤�û�ͼ�꣬����� <?php echo cd_mmpoints; ?> ��ҽ�����</li>
									<li style='color:#ff0000'>ע������ͷ�����֤��Ƭ�����Ǳ�����ʵ��ò�������޷�ͨ����ˡ�</li>
									<li style='color:#ff0000'>����ڱ�ҳ�����޷�����������ͷ����������ϵ����ԱQQ��<?php echo cd_webqq?>������֤��</li>
								</ul>
							<?php }else{ ?>
								<div class="avatarTitle">���ĸ���ͷ��</div>
								<div id="camera" class="camera">
									<div id="cam" class="cam"><img width="220" height="220" src="<?php echo cd_webpath.$qianwei_in_verified; ?>" onerror="this.src='<?php echo cd_upath; ?>static/images/noface_200x200.gif'" /></div>
									<div id="buttons" class="buttons"><div class="button_pane"><a id="next" href="<?php echo cd_upath; ?>index.php?p=user&a=applyCertify&step=2" class="btn_next">��һ��</a></div></div>
								</div>
								<ul class="process">
									<li class="pro">��֤����</li>
									<li>1.��ȷ������ͷ���������˵���ʵ��Ƭ��</li>
									<li>2.���ȷ��ͷ��Ϊ������ʵ��Ƭ��������һ��������Ƶ������֤��</li>
									<li>3.���ͷ������������Ƭ�������޸�ͷ��Ϊ������Ƭ���ٽ�����֤���롣</li>
									<li style='color:#ff0000'>ע������ͷ������Ǳ�����ʵ��Ƭ�������޷�ͨ����ˡ�</li>
								</ul>
							<?php } ?>
							<div class="cannot_clear">
								<div class="alert">����������ͷ�񣬲��ᱻ���ͨ��<i class="arrow"></i></div>
								<ul>
									<li><img src="<?php echo cd_upath; ?>static/space/images/bad_photo/bad_photo4.jpg"><p>��ס���</p></li>
									<li><img src="<?php echo cd_upath; ?>static/space/images/bad_photo/bad_photo5.jpg"><p>��Ƭģ��</p></li>
									<li><img src="<?php echo cd_upath; ?>static/space/images/bad_photo/bad_photo6.jpg"><p>��¶����������</p></li>
									<li><img src="<?php echo cd_upath; ?>static/space/images/bad_photo/bad_photo1.jpg"><p>��������</p></li>
									<li><img src="<?php echo cd_upath; ?>static/space/images/bad_photo/bad_photo3.jpg"><p>������ֿ���</p></li>
									<li><img src="<?php echo cd_upath; ?>static/space/images/bad_photo/bad_photo7.jpg"><p>��Ƭ�뱾�����������</p></li>
								</ul>
							</div>
						</div>
					</div>
					<?php } ?>
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
<script type="text/javascript">listenMsg.start();nav.init();nav.userMenu();nav.helpNoticeInit();</script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/profile.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/camera/webcam.js"></script>
<?php if($step == "2"){ ?>
<script type="text/javascript">profile.certifyInit();</script>
<?php } ?>
</body>
</html>
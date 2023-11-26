<?php
	include "../source/global/global_inc.php";
	global $db,$qianwei_in_userid,$qianwei_in_username;
	VerifyLogin($qianwei_in_userid);
	if(cd_remoteup==1){
		$cd_remotepath=cd_webpath."plugin.php?open=ftp&opens=index&to=user&ac=song";
		$cd_remotewidth="688px";
		$cd_remoteheight="132px";
		$cd_remotetop="160px";
	}elseif(cd_remoteup==2){
		$cd_remotepath=cd_webpath."plugin.php?open=qiniu&opens=index&to=user&ac=song";
		$cd_remotewidth="688px";
		$cd_remoteheight="132px";
		$cd_remotetop="160px";
	}elseif(cd_remoteup==3){
		$cd_remotepath=cd_webpath."plugin.php?open=baidu&opens=index&to=user&ac=song";
		$cd_remotewidth="688px";
		$cd_remoteheight="132px";
		$cd_remotetop="160px";
	}elseif(cd_remoteup==4){
		$cd_remotepath=cd_webpath."plugin.php?open=oss&opens=index&to=user&ac=song";
		$cd_remotewidth="580px";
		$cd_remoteheight="200px";
		$cd_remotetop="130px";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>�������� - <?php echo cd_webname; ?></title>
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
		<div class="user_menu" id="share">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_content">
				<div class="main_nav">
					<ul>
						<li class="concert">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=list'); ?>">��������</a>
						</li>
						<li class="find">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=pass'); ?>">��������</a>
						</li>
					</ul>
					<div class="action">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=share'); ?>">��������</a>
					</div>
				</div>
				<div class="main">
					<div id="tooltip" class="refresh">

					</div>
				</div>
				<div class="minHeight500">
					<div class="profile">
						<div class="title">
							<div class="name">��������</div>
						</div>
					<?php if(cd_usermusic=="no"){ ?>
						<div class="nothing">��վ��ʱ�رո����ϴ����ܡ�</div>
					<?php }else{ ?>
                                                <form name="form">
                                                        <ul id="danceAddMain">
								<li>
									<div class="name">�������ƣ�</div>
									<div class="input">
										<input type="text" style="width: 190px;" class="input_normal" name="rdanceName" id="rdanceName" maxlength="100" />
									</div>
									<div class="input_msg" id="mdanceName">��Ϊ������������������д�������������˲Ż�ͨ����</div>
								</li>
								<li>
									<div class="name">�������֣�</div>
									<div class="input">
										<select style="width: 110px;" class="select_normal" name="rSingerID" id="rSingerID">
											<option value="">ѡ����������</option>
											<option value="0">�����κθ���</option>
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
									<div class="input_msg"><span class="button2-main"><span><button type="button" onclick="pop.up('ѡ�����', '<?php echo cd_webpath; ?>admin.php?iframe=star&to=u&so=form.rSingerID', '500px', '400px', '80px');">ѡ��</button></span></span></div><div class="input_msg" id="mSingerID">���ֵ��������֣���ѡ�����һ����</div>
								</li>
								<li>
									<div class="name">�������ࣺ</div>
									<div class="input">
										<select style="width: 110px;" class="select_normal" name="rclassId" id="rclassId">
											<option value="0">ѡ����������</option>
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
									<div class="input_msg" id="mclassId">���ֵ��������࣬����ȷѡ��</div>
								</li>
								<li>
									<div class="name">����ר����</div>
									<div class="input">
										<select style="width: 110px;" class="select_normal" name="rSpecialID" id="rSpecialID">
											<option value="">ѡ������ר��</option>
											<option value="0">�����κ�ר��</option>
											<?php
												$sqlclass="select * from ".tname('special')." where CD_User='$qianwei_in_username'";
												$results=$db->query($sqlclass);
												if($results){
													while ($row3=$db->fetch_array($results)){
														echo "<option value='".$row3['CD_ID']."'>".getlen("len","10",$row3['CD_Name'])."</option>";
													}	
						
												}
											?>
										</select>
									</div>
									<div class="input_msg" id="mSpecialID">ֻ��ʾ��������ר������ѡ�����һ����</div>
								</li>
								<li>
									<div class="name">�ϴ��ļ���</div>
									<div class="input">
										<input type="text" style="width: 320px;" class="input_normal" name="rUrl" id="rUrl" /><input type="hidden" name="rServer" id="rServer" value="1" />
									</div>
									<div class="input_msg"><span class="button2-main"><span><button type="button" onclick="pop.up('�ϴ�����', '<?php echo cd_webpath; ?>plugin.php?open=upload&opens=index&to=user&ac=song&f=form.rUrl', '406px', '180px', '140px');">�����ϴ�</button></span></span></div><div class="input_msg"><span class="button2-main"><span><button type="button" onclick="pop.up('�ϴ�����', '<?php echo $cd_remotepath; ?>', '<?php echo $cd_remotewidth; ?>', '<?php echo $cd_remoteheight; ?>', '<?php echo $cd_remotetop; ?>');">Զ���ϴ�</button></span></span></div><div class="input_msg" id="mUrl"></div>
								</li>
								<li>
									<div class="name">���÷��棺</div>
									<div class="input">
										<input type="text" style="width: 320px;" class="input_normal" name="rPic" id="rPic" />
									</div>
									<div class="input_msg"><span class="button2-main"><span><button type="button" onclick="pop.up('�ϴ�����', '<?php echo cd_webpath; ?>plugin.php?open=upload&opens=index&to=user&ac=pic&f=form.rPic', '406px', '180px', '140px');">�����ϴ�</button></span></span></div>
								</li>
								<li>
									<div class="name">��̬��ʣ�</div>
									<div class="input">
										<input type="text" style="width: 320px;" class="input_normal" name="rLrc" id="rLrc" />
									</div>
									<div class="input_msg"><span class="button2-main"><span><button type="button" onclick="pop.up('�ϴ����', '<?php echo cd_webpath; ?>plugin.php?open=upload&opens=index&to=user&ac=lrc&f=form.rLrc', '406px', '180px', '140px');">�����ϴ�</button></span></span></div>
								</li>
								<li class="note">
									<div class="name">�ı���ʣ�</div>
									<div class="input">
										<textarea name="rnote" id="rnote"></textarea>
									</div>
								</li>
								<li>
									<div class="name"></div>
									<div class="input">
										<span class="button-main"><span><button type="button" id="danceNewAdd">�ϴ�����</button></span></span>
									</div>
								</li>
                                                        </ul>
                                                </form>
					<?php } ?>
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
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/dance.js"></script>
<script type="text/javascript" src="<?php echo cd_webpath; ?>source/plugin/layer/lib.js"></script>
<script type="text/javascript">
listenMsg.start();
nav.init();
nav.userMenu();
danceLib.shareAddInit();
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
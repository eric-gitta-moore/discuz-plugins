<?php
	include "../source/global/global_inc.php";
	global $db,$qianwei_in_userid;
	VerifyLogin($qianwei_in_userid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>����ר�� - <?php echo cd_webname; ?></title>
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
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=special&a=list'); ?>">����ר��</a>
						</li>
						<li class="find">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=special&a=pass'); ?>">����ר��</a>
						</li>
					</ul>
					<div class="action">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=special&a=share'); ?>">����ר��</a>
					</div>
				</div>
				<div class="main">
					<div id="tooltip" class="refresh">

					</div>
				</div>
				<div class="minHeight500">
					<div class="profile">
						<div class="title">
							<div class="name">����ר��</div>
						</div>
                                                <form name="form">
                                                        <ul id="specialAddMain">
								<li>
									<div class="name">ר�����ƣ�</div>
									<div class="input">
										<input type="text" style="width: 190px;" class="input_normal" name="rspecialName" id="rspecialName" maxlength="100" />
									</div>
									<div class="input_msg" id="mspecialName">��Ϊר����������������д�������������˲Ż�ͨ����</div>
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
									<div class="input_msg"><span class="button2-main"><span><button type="button" onclick="pop.up('ѡ�����', '<?php echo cd_webpath; ?>admin.php?iframe=star&to=u&so=form.rSingerID', '500px', '400px', '80px');">ѡ��</button></span></span></div><div class="input_msg" id="mSingerID">ר�����������֣���ѡ�����һ����</div>
								</li>
								<li>
									<div class="name">���й�˾��</div>
									<div class="input">
										<input type="text" style="width: 125px;" class="input_normal" name="rGongSi" id="rGongSi" maxlength="50" />
									</div>
									<div class="input_msg" id="mGongSi">ר���ķ��й�˾������ȷѡ��</div>
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
									<div class="input_msg" id="mclassId">ר�����������࣬����ȷѡ��</div>
								</li>
								<li>
									<div class="name">�������ԣ�</div>
									<div class="input">
										<select style="width: 110px;" class="select_normal" name="rYuYan" id="rYuYan">
											<option value="">ѡ����������</option>
											<option value="����">����</option>
											<option value="����">����</option>
											<option value="����">����</option>
											<option value="Ӣ��">Ӣ��</option>
											<option value="����">����</option>
											<option value="����">����</option>
											<option value="����">����</option>
										</select>
									</div>
									<div class="input_msg" id="mYuYan">ר�����������ԣ�����ȷѡ��</div>
								</li>
								<li>
									<div class="name">���÷��棺</div>
									<div class="input">
										<input type="text" style="width: 320px;" class="input_normal" name="rPic" id="rPic" />
									</div>
									<div class="input_msg"><span class="button2-main"><span><button type="button" onclick="pop.up('�ϴ�����', '<?php echo cd_webpath; ?>plugin.php?open=upload&opens=index&to=user&ac=pic&f=form.rPic', '406px', '180px', '140px');">�����ϴ�</button></span></span></div><div class="input_msg" id="mPic"></div>
								</li>
								<li class="note">
									<div class="name">ר����飺</div>
									<div class="input">
										<textarea name="rIntro" id="rIntro"></textarea>
									</div>
								</li>
								<li>
									<div class="name"></div>
									<div class="input">
										<span class="button-main"><span><button type="button" id="specialNewAdd">�ϴ�����</button></span></span>
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
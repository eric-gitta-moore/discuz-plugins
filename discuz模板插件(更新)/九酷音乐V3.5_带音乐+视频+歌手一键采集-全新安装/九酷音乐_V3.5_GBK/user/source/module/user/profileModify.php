<?php
	include "../source/global/global_inc.php";
	global $db,$qianwei_in_userid,$qianwei_in_password;
	VerifyLogin($qianwei_in_userid);
	$current=SafeRequest("i","get");
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
		<div class="user_menu" id="profilem">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_content">
				<div class="main_nav">
					<ul>
						<li class="modify">
							<a class="on" href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=profileModify'); ?>">��������</a>
						</li>
						<li class="skin">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=skin'); ?>" target="_blank">�ռ任��</a>
						</li>	
						<li class="certify">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=applyCertify'); ?>">��Ů��֤</a>
						</li>
					</ul>
				</div>
				<div class="main_nav2">
					<ul id="aa">
						<li<?php if($current==""){echo ' class="current"';} ?> id="cprofile">
							<a href="javascript:;"><span>��������</span></a>
						</li>
						<li<?php if($current=="avatar"){echo ' class="current"';} ?> id="cavatar">
							<a href="javascript:;"><span>�޸�ͷ��</span></a>
						</li>
						<li<?php if($current=="password"){echo ' class="current"';} ?> id="cpassword">
							<a href="javascript:;"><span>�޸�����</span></a>
						</li>
						<li<?php if($current=="protection"){echo ' class="current"';} ?> id="cprotection">
							<a href="javascript:;"><span>�޸��ܱ�</span></a>
						</li>
						<li<?php if($current=="nickname"){echo ' class="current"';} ?> id="cnickname">
							<a href="javascript:;"><span>�޸��ǳ�</span></a>
						</li>	
					</ul>
					<div id="tooltip" class="refresh">
					</div>
				</div>
				<div class="minHeight500">
					<!--�޸Ļ�������-->
					<div id="modifyProfile" class="profile" style="<?php if($current==""){echo "display:";}else{echo "display:none";} ?>;">
						<div class="title">
							<div class="name">�޸Ļ�������</div>
						</div>
						<ul>
							<li>
								<div class="name">�ǡ����ƣ�</div>
								<div class="input">
									<span class="nickname"><?php echo $qianwei_in_nicheng?></span>
								</div>
							</li>
							<li>
								<div class="name">�ԡ�����</div>
								<div class="input">	
									<select id="rsex" class="select_normal" name="rsex" style="width:70px;">
									<option value="1"<?php if($qianwei_in_sex=="1"){ echo " selected=\"selected\"";} ?>>˧ ��</option>
									<option value="0"<?php if($qianwei_in_sex=="0"){ echo " selected=\"selected\"";} ?>>�� Ů</option>
									</select>
							</li>
							<li>
								<div class="name">����������</div>
								<div class="input">
									<select id="ryear" class="select_normal" name="ryear">
										<option value="0">��ѡ����</option>
										<?php
											//����:��
											for ($i=0; $i<100; $i++) {
												$they = date('Y') - $i;
												if($they >= "1970"){
													$selectstr = $they == date('Y',strtotime($qianwei_in_birthday))?' selected':'';
													echo "<option value=\"$they\"$selectstr>$they</option>";
												}
											}
										?>
									</select>
									<select id="rmonth" class="select_normal" name="rmonth">
										<option value="">��ѡ����</option>
										<?php
											//����:��
											for ($i=1; $i<13; $i++) {
												if($i <= 9){
													$im="0".$i;
												}else{
													$im=$i;
												}
												$selectstr = $im == date('m',strtotime($qianwei_in_birthday))?' selected':'';
												echo "<option value=\"$im\"$selectstr>$im</option>";
											}
										?>
									</select>
									<select id="rday" class="select_normal" name="rday">
										<option value="">��ѡ����</option>
										<?php
											//����:��
											for ($i=1; $i<32; $i++) {
												if($i <= 9){
													$iday="0".$i;
												}else{
													$iday=$i;
												}
												$selectstr = $iday == date('d',strtotime($qianwei_in_birthday))?' selected':'';
												echo "<option value=\"$iday\"$selectstr>$iday</option>";
											}
											?>
									</select>
								</div>
								<div id="mbirth" class="input_msg">��ѡ���������ա�</div>
							</li>
							<li>
								<div class="name"><span>*</span>�ǡ����У�</div>
								<div class="input">
										<input id="raddress" class="input_normal" type="text" value="<?php echo $qianwei_in_address; ?>" readonly="readonly" name="raddress" style="width: 190px; cursor: pointer;"/>
								</div>
								<div id="maddress" class="input_msg">�뵥��ѡ���������ڳ��С�</div>
							</li>
							<li>
								<div class="name"><span>*</span>�ѡ����ѣ�</div>
								<div class="input">
									<input id="rqq" class="input_normal" type="text" value="<?php echo $qianwei_in_qq; ?>" maxlength="10" name="rqq" style="width:190px;"/>
								</div>
								<div class="seh_list">
									<a class="seh_list_a" href="javascript:;" id="openQQ"><?php if($qianwei_in_qqprivacy=="1"){ echo "����QQ"; }else{ echo "������"; } ?><b class="arrow"></b></a>
									<div class="seh_sort" style="display: none;">
										<a href="javascript:;">����QQ</a>
										<a href="javascript:;">������</a>
									</div>
								</div>
								<div id="mqq" class="input_msg"><?php if($qianwei_in_qqprivacy=="0"){ echo "��������QQ�ţ�ֻ��վ����Ա��ϵʹ�ã����ṫ����"; }else{ echo "��������QQ�š�"; } ?></div>
							</li>
							<li>
								<div class="name"><span>*</span>�ʡ����䣺</div>
								<div class="input">
									<input id="remail" class="input_normal" type="text" value="<?php echo $qianwei_in_email; ?>" name="remail" style="width:190px;"/>
								</div>
								<div id="memail" class="input_msg">��ȫ�����ܹ�����ȡ�������ǵ����롣</div>
							</li>
							<li>
								<div class="name"><span>*</span>���˽��ܣ�</div>
								<div class="input">
									<textarea name="textfield" cols="30" rows="7" id="rselfIntroduce"><?php echo $qianwei_in_introduce; ?></textarea>
								</div>
								<div id="mselfIntroduce" class="input_msg"></div>
							</li>
							<li>
								<div class="name"></div>
								<div class="input">
									<span class="button-main">
										<span><button id="seveProfile" type="button">�����޸�</button></span>
									</span>
								</div>
							</li>
						</ul>
					</div>
					<!--�޸�ͷ��-->
					<div id="modifyAvatar" class="profile" style="<?php if($current=="avatar"){echo "display:";}else{echo "display:none";} ?>;">
						<div class="title">
							<div class="name">�޸�ͷ��</div>
						</div>
						<div class="avatar_box">
							<div class="avatarTitle">
								��ǰͷ��<span>����ͷ��</span>
							</div>
							<div class="myAvatar">
								<img class="avatar-160" id="my-avatar" width="160" height="160" src="<?php echo getavatar($qianwei_in_userid,200); ?>"/>
							</div>
							<div class="myAvatarUpload">
							<?php
							        if(cd_ucenter==1){
							                require_once _qianwei_root_.'./client/ucenter.php';
							                require_once _qianwei_root_.'./client/client.php';
							                global $qianwei_in_username,$qianwei_in_ucenter;
							                $ucid = uc_get_user($qianwei_in_username);
							                if($qianwei_in_ucenter>0 && $qianwei_in_ucenter==$ucid[0]){
							                        echo uc_avatar($ucid[0]);
							                }else{
							?>
								<?php echo "<embed src=\"http://".$_SERVER['HTTP_HOST'].cd_upath."static/swf/camera.swf?ucapi=".urlencode("http://".$_SERVER['HTTP_HOST'].cd_webpath."avatar.php")."&input=".urlencode("uid=").base64_encode($qianwei_in_userid."|".$qianwei_in_password)."&uploadSize=2048\" width=\"450\" height=\"253\" wmode=\"transparent\" type=\"application/x-shockwave-flash\"></embed>"; ?>
							<?php } ?>
							<?php }else{ ?>
								<?php echo "<embed src=\"http://".$_SERVER['HTTP_HOST'].cd_upath."static/swf/camera.swf?ucapi=".urlencode("http://".$_SERVER['HTTP_HOST'].cd_webpath."avatar.php")."&input=".urlencode("uid=").base64_encode($qianwei_in_userid."|".$qianwei_in_password)."&uploadSize=2048\" width=\"450\" height=\"253\" wmode=\"transparent\" type=\"application/x-shockwave-flash\"></embed>"; ?>
							<?php } ?>
							</div>
						</div>
					</div>
					<!--�޸�����-->
					<div id="modifyPassword" class="profile" style="<?php if($current=="password"){echo "display:";}else{echo "display:none";} ?>;">
						<div class="title">
							<div class="name">�޸�����</div>
						</div>
						<ul>
							<li>
								<div class="name">��ǰ���룺</div>
								<div class="input">
									<input id="roldpassword" class="input_normal" type="password" maxlength="20" name="roldpassword" style="width:190px;">
								</div>
								<div id="moldpassword" class="input_msg">����������ǰʹ�õ����롣</div>
							</li>
							<li>
								<div class="name">���������룺</div>
								<div class="input">
									<input id="rpassword" class="input_normal" type="password" maxlength="20" name="rpassword" style="width:190px;"/>
								</div>
								<div id="mpassword" class="input_msg">6��20���ַ�����ʹ��Ӣ����ĸ�����ִ�Сд�������Ż����֡�</div>
							</li>
							<li>
								<div class="name">ȷ�������룺</div>
								<div class="input">
									<input id="rpassword2" class="input_normal" type="password" maxlength="20" name="rpassword" style="width:190px;"/>
								</div>
								<div id="mpassword2" class="input_msg">�ٴ������������õ����룬��ȷ����������</div>
							</li>
							<li>
								<div class="name"></div>
								<div class="input">
									<span class="button-main">
										<span><button id="sevePassword" type="button">�����޸�</button></span>
									</span>
								</div>
							</li>
						</ul>
					</div>
					<!--�޸��ܱ�-->
					<div id="modifyProtection" class="profile" style="<?php if($current=="protection"){echo "display:";}else{echo "display:none";} ?>;">
						<div class="title">
							<div class="name">�޸��ܱ�</div>
						</div>
						<ul>
							<li>
								<div class="name">��ǰ���룺</div>
								<div class="input">
									<input id="rpasswords" class="input_normal" type="password" maxlength="20" name="rpasswords" style="width:190px;">
								</div>
								<div id="mpasswords" class="input_msg">����������ǰʹ�õ����롣</div>
							</li>
							<li>
								<div class="name">�����ܱ����⣺</div>
								<div class="input">
									<input id="rquestion" class="input_normal" type="text" value="<?php echo $qianwei_in_question; ?>" maxlength="20" name="rquestion" style="width:190px;"/>
								</div>
								<div id="mquestion" class="input_msg">2��20���ַ������ġ�Ӣ����ĸ�����ִ�Сд�������Ż����֡�</div>
							</li>
							<li>
								<div class="name">�����ܱ��𰸣�</div>
								<div class="input">
									<input id="ranswer" class="input_normal" type="password" maxlength="20" name="ranswer" style="width:190px;"/>
								</div>
								<div id="manswer" class="input_msg">2��20���ַ������ġ�Ӣ����ĸ�����ִ�Сд�������Ż����֡�</div>
							</li>
							<li>
								<div class="name"></div>
								<div class="input">
									<span class="button-main">
										<span><button id="seveProtection" type="button">�����޸�</button></span>
									</span>
								</div>
							</li>
						</ul>
					</div>
					<!--�޸��ǳ�-->
					<div id="modifyNickname" class="profile" style="<?php if($current=="nickname"){echo "display:";}else{echo "display:none";} ?>;">
						<div class="title">
							<div class="name">�޸��ǳ�</div>
						</div>
						<ul>
							<li>
								<div class="name">�ǳƣ�</div>
								<div class="input"><span class="nickname"><?php echo $qianwei_in_nicheng?></span></div>
							</li>
							<li>
								<div class="name"><span>*</span>���ǳƣ�</div>
								<div class="input">
									<input id="rnickname" class="input_normal" type="text" value="" maxlength="12" name="rnickname" style="width:150px;"/>
								</div>
								<div id="mnickname" class="input_msg">����д�������֣�����ʹ�ÿո����֡��� &lt; &gt; ' " / \ �ȷǷ��ַ�����</div>
							</li>
							<li>
								<div class="name"></div>
								<div class="input">
									<span class="button-main">
										<span><button id="seveNickname" type="button">�ύ����</button></span>
									</span>
								</div>
							</li>
						</ul>
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
<script type="text/javascript">listenMsg.start();nav.init();nav.userMenu();nav.helpNoticeInit();</script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/profile.js"></script>
<script type="text/javascript">
profile.init();
function updateavatar() {
	window.location.reload();
}
</script>
</body>
</html>
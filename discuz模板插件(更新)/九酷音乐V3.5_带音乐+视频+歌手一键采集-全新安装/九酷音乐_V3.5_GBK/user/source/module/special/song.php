<?php
include "../source/global/global_inc.php";
global $db,$qianwei_in_userid,$qianwei_in_username;
VerifyLogin($qianwei_in_userid);
$specialid = SafeRequest("id","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>设置音乐 - <?php echo cd_webname; ?></title>
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
						<?php
						        if($row=$db->getrow("select * from ".tname('special')." where CD_ID=".$specialid)){
						                if($row['CD_User']==$qianwei_in_username){
						?>
						<div class="title">
							<div class="name"><?php echo $row['CD_Name']; ?></div>
						</div>
                                                <form name="form" method="post" action="<?php echo cd_upath; ?>index.php?p=special&a=doSong">
                                                <input type="hidden" name="specialid" value="<?php echo $specialid; ?>" />
                                                <table cellspacing="0" cellpadding="0" width="100%">
                                                <tr align="center">
                                                <td height="35"><font color="red">您上传且未加入任何专辑的歌曲</font></td>
                                                <td><b>Shift键可多选</b></td>
                                                <td>已加入该专辑的歌曲</td>
                                                </tr>
                                                <tr align="center">
                                                <td width="44%"><select name="joinlist[]" id="joinlist" style="width:320px;height:350px" multiple="multiple" size="1">
						<?php
						        $sqls="select * from ".tname('music')." where CD_UserID=".$qianwei_in_userid." and CD_Deleted=0 and CD_SpecialID=0 order by CD_AddTime desc";
						        $results=$db->query($sqls);
                                                                if($results){
                                                                        while ($rows=$db->fetch_array($results)){
                                                                                echo "<option value=\"".$rows['CD_ID']."\">".$rows['CD_Name']."</option>";
                                                                        }
                                                                }
						?>
                                                </select></td>
                                                <td width="12%">
                                                <span class="button-main" style="margin-left:14px;"><span><input type="submit" name="join" value="<=加入" onclick="return join_list();"></span></span><br><br>
                                                <span class="button-main" style="margin-left:14px;"><span><input type="submit" name="del" value="删除=>" onclick="return del_list();"></span></span>
                                                </td>
                                                <td width="44%"><select name="dellist[]" id="dellist" style="width:320px;height:350px" multiple="multiple" size="1">
						<?php
						        $sqlss="select * from ".tname('music')." where CD_SpecialID=".$specialid." and CD_Deleted=0 order by CD_AddTime desc";
						        $resultss=$db->query($sqlss);
                                                                if($resultss){
                                                                        while ($rowss=$db->fetch_array($resultss)){
                                                                                echo "<option value=\"".$rowss['CD_ID']."\">".$rowss['CD_Name']."</option>";
                                                                        }
                                                                }
						?>
                                                </select></td>
                                                </tr>
                                                </table>
                                                </form>
                                                <?php
						                }else{
                                                                        echo "<div class=\"nothing\">对不起，您不能设置别人的专辑。</div>";
						                }
						        }else{
						                echo "<div class=\"nothing\">抱歉，该专辑不存在或已被删除。</div>";
						        }
                                                ?>
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
<script type="text/javascript">
listenMsg.start();
nav.init();
nav.userMenu();
function join_list(){
        if(document.form.joinlist.value==""){
                $.tipMessage('请选择要加入专辑的歌曲！', 1, 1000);
                document.form.joinlist.focus();
                return false;
        }
}
function del_list(){
        if(document.form.dellist.value==""){
                $.tipMessage('请选择要删除的专辑歌曲！', 1, 1000);
                document.form.dellist.focus();
                return false;
        }
}
</script>
</body>
</html>
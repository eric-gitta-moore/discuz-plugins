<?php
	include "../source/global/global_inc.php";
	$i = SafeRequest("i","get");
	if($i == 'hot'){
		$cd_title = '人气排行照片';
	}elseif($i == 'like'){
		$cd_title = '网友喜欢照片';
	}else{
		$cd_title = '最新上传照片';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $cd_title; ?> - <?php echo cd_webname; ?></title>
<link type="text/css" href="<?php echo cd_upath; ?>static/css/core.css" rel="stylesheet" />
<link type="text/css" href="<?php echo cd_upath; ?>static/site/css/common.css" rel="stylesheet" media="all" />
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/core.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/card.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/dialog.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/site/js/common.js"></script>
<script type="text/javascript">
var domIsReady=false,domReadyList=[],domReadyObject=[],$call=function(callback,obj){if(typeof obj!=='object'){obj=document}if(domIsReady){callback.call(obj)}else{domReadyList.push(callback);domReadyObject.push(obj)}};
var site_domain="<?php echo cd_webpath; ?>";zone_domain="<?php echo cd_upath; ?>";
</script>
</head>
<body>
<div class="header"><?php include "source/module/system/header.php"; ?></div>
<div class="album_content">
	<div class="album_nav">
		<ul>
			<li<?php if($i == "new"){echo " class=\"current\"";} ?>><a href="<?php echo cd_upath.rewrite_url('index.php?p=home&a=album&i=new'); ?>">最新照片</a></li>
			<li<?php if($i == "hot"){echo " class=\"current\"";} ?>><a href="<?php echo cd_upath.rewrite_url('index.php?p=home&a=album&i=hot'); ?>">人气排行</a></li>
			<li<?php if($i == "like"){echo " class=\"current\"";} ?>><a href="<?php echo cd_upath.rewrite_url('index.php?p=home&a=album&i=like'); ?>">网友喜欢</a></li>
		</ul>
	</div>
</div>

<div class="album_content">
	<?php
		global $db;
		$a = 0;
		$lpids="";
		if($i == 'hot'){
			$sql = "select * from ".tname('pic')." order by cd_hits desc";
		}elseif($i == 'like'){
			$sql = "select * from ".tname('pic')." order by cd_praisenum desc";
		}else{
			$sql = "select * from ".tname('pic')." order by cd_addtime desc";
		}
		$Arr = getwebpage($sql,100,"index.php?p=home&a=album&i=".$i);
		$result = $db->query($Arr[2]);
		$num = $Arr[5];
		if($num==0){
			echo '<div class="nothing">暂时还没有照片啊！</div>';
		}else{
			if($result){
				echo '<ul class="album" id="imageList"></ul>';
				echo '<div id="imgLoading" class="album_loading"></div>';
				echo '<div id="imgPages" class="album_button" style="display:none;">';
				while ($row = $db ->fetch_array($result)){
					$a=$a+1;
					$user = $db->getrow("select cd_nicheng from ".tname('user')." where cd_id='".$row['cd_uid']."'");
					$lpids=$lpids."{'pid': ".$row['cd_id'].",'src':'".getalbumthumb($row['cd_url'],2)."','create_time':'".datetime(date('Y-m-d H:i:s',$row['cd_addtime']))."','uid':".$row['cd_uid'].",'praiseNum':".$row['cd_praisenum'].",'replyNum':".$row['cd_replynum'].",'width':".$row['cd_width'].",'height':".$row['cd_height'].",'avatar':'".getavatar($row['cd_uid'],48)."','nickname':'".$user['cd_nicheng']."'},";
				}
				$lpids=$lpids.']';
				$lpids=ReplaceStr($lpids,",]","");

				if($num>0){ ?>
					<div class="pages">
						<?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href=zone_domain+'<?php echo "index.php?p=home&a=album&i=".$i."&pages="; ?>'+val;return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/>
					</div>
				<?php }
				echo '</div>';
			}
		}
	?>
</div>
<div class="bottom">
	<div class="footer">
		<?php include "source/module/system/footer.php"; ?>
	</div>
</div>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/jquery.masonry.min.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/album.js"></script>
<script type="text/javascript">
	nav.init();
	nav.userMenu();
	libs.checkLogin();
	var imgDatas = [<?php echo ReplaceStr($lpids,"]",""); ?>];
	imgLoaded.init('#imageList', imgDatas, 1);
</script>
</body>
</html>
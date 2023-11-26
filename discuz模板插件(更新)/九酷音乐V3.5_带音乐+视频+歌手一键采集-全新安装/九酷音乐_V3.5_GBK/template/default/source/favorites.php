<?php
global $db,$userlogined;
$id=SafeRequest("id","get");
$sql="select CD_Name from ".tname('music')." where CD_ID=".$id;
if($row=$db->getrow($sql)){
?>
<script type="text/javascript">
var favorites_music_id="<?php echo $id; ?>";
var favorites_url="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=favorites'); ?>";
$ = function(em) {
    if (document.getElementById){ return document.getElementById(em); }
    else if (document.all){ return document.all[em]; }
    else if (document.layers){ return document.layers[em]; }
    else{ return null; }
}
function seccode() {
	var img = temp_url+'source/ajax.php?ac=seccode&rand='+Math.random();
	document.writeln('<img id="img_seccode" src="'+img+'" align="absmiddle" />');
}
function updateseccode() {
	var img = temp_url+'source/ajax.php?ac=seccode&rand='+Math.random();
	if($('img_seccode')) {
		$('img_seccode').src = img;
	}
}
</script>
<div class="box bgWrite mt">
 <div class="diange">
  <div class="diangeHd clearfix">
   <div class="diangeNav">
    <ul class="step-nav clearfix">
     <li class="current"><span class="t-t">收藏音乐</span></li>
    </ul>
   </div>
  </div>
<form method="get" onsubmit="favorites();return false;">
<div class="diangeBd step02 clearfix">
<div class="diangeFrom diange-form">
<?php if(!$userlogined){ ?>
<div class="notice"><div class="error">您未登录没有收藏权限，请先登录本站！</div></div>
<script type="text/javascript">window.setTimeout("location.href='<?php echo cd_webpath.rewrite_url('user.php?do=login'); ?>';", 3000);</script>
<?php }else{ ?>
<ul>
<li class="form-item clearfix"><label class="label">收藏的音乐：</label><input type="text" class="input readOnly" readonly="readonly" value="<?php echo $row['CD_Name']; ?>"></li>
<li class="form-item clearfix"><label class="label">验证码：</label><input type="text" id="ReI_1" class="input" style="width:36px;" maxlength="4" autocomplete="off" />&nbsp;<script type="text/javascript">seccode();</script>&nbsp;<a href="javascript:updateseccode()">更换</a>&nbsp;<span id="Re_1">必填！</span></li>
</ul>
</div>
</div>
<div class="diangeBd step03 clearfix">
<div class="btn-group clearfix" style="margin:20px 0 0 240px;">
<button type="submit" class="sDian1" style="cursor:pointer;">提交收藏</button>
<?php } ?>
</div>
</div>
</form>
 </div>
</div>
<?php }else{
echo "<div class=\"box bgWrite mt\"><div class=\"diange\">";
echo "<div class=\"diangeHd clearfix\"><div class=\"diangeNav\"><ul class=\"step-nav clearfix\"><li class=\"current\"><span class=\"t-t\">信息提示</span></li></ul></div></div>";
echo "<div class=\"diangeFrom diange-form\"><div class=\"notice\"><div class=\"error\">数据不存在或已被删除！</div></div></div>";
echo "<div class=\"diangeBd step03 clearfix\"><div class=\"btn-group clearfix\" style=\"margin:20px 0 0 320px;\">";
echo "<a href=\"javascript:history.go(-1);\" class=\"sDian1\">返回上一页</a>";
echo "<a href=\"".cd_webpath."\" class=\"sDian2\">返回首页</a>";
echo "</div></div></div></div>";
} ?>
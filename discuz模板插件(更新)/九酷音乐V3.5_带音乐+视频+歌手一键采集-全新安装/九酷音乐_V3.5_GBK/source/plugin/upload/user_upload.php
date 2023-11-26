<?php
include "source/global/global_inc.php";
$f=SafeRequest("f","get");
$action=SafeRequest("ac","get");
$randdir=rand(2,pow(2,24));
$randnum=date('YmdHis',time());
switch($action){
	case 'song':
		$targetFiles="data/attachment/song/".$randdir;
		$fileexts=cd_upext;
		$filesizes=cd_upsize;
		break;
	case 'video':
		$targetFiles="data/attachment/video/".$randdir;
		$fileexts="*.flv;*.f4v;*.mp4";
		$filesizes=cd_upsize;
		break;
	case 'lrc':
		$targetFiles="data/attachment/lrc/".$randdir;
		$fileexts="*.lrc";
		$filesizes="1";
		break;
	case 'pic':
		$targetFiles="data/attachment/pic/".$randdir;
		$fileexts="*.jpg;*.jpeg;*.gif;*.png";
		$filesizes="2";
		break;
}
global $db,$userlogined,$qianwei_in_userid,$qianwei_in_username;
if(!$userlogined){exit(iframe_message("��δ��¼û���ϴ�Ȩ�ޣ����ȵ�¼��վ��"));}
if(cd_uptype==0){exit(iframe_message("��Ǹ���ϴ������ѹرգ�"));}
$timea = date('Y',time());
$timeb = date('m',time());
$timec = date('d',time());
$timed = mktime(0,0,0,$timeb,$timec,$timea);
$numa = $db -> num_rows($db -> query("select * from ".tname('upload')." where cd_filetype='��Ƶ�ļ�' and cd_userid=".$qianwei_in_userid." and cd_filetime >= '".$timed."'"));
$numb = cd_upnum-$numa;
if($_GET['ac']=="song" && $numb<=0){exit(iframe_message("�����յ��ϴ������������ޣ�"));}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�����ϴ�</title>
<link href="source/plugin/upload/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/upload/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="source/plugin/upload/swfobject.js"></script>
<script type="text/javascript" src="source/plugin/upload/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#uploadify").uploadify({
		'uploader' : 'source/plugin/upload/uploadify.swf',
		'script' : 'source/plugin/upload/user_uplog.php',
		'cancelImg' : 'source/plugin/upload/cancel.png',
		'folder' : '<?php echo $targetFiles; ?>',
		'method' : 'GET',
		'scriptData' : {'is':'<?php echo $randdir; ?>','id':'<?php echo $randnum; ?>','ac':'<?php echo $action; ?>','uid':'<?php echo $qianwei_in_userid; ?>','uname':'<?php echo base64_encode($qianwei_in_username); ?>'},
		'width' : '110',
		'height' : '30',
		'buttonText' : 'Upload',
		'buttonImg' : 'source/plugin/upload/up.png',
		'queueID' : 'fileQueue',
		'auto' : true,
		'fileExt' : '<?php echo $fileexts; ?>',
		'fileDesc' : '��ѡ��<?php echo $fileexts; ?>�ļ�',
		'multi' : false,
		'sizeLimit' : <?php echo ($filesizes*1024*1024); ?>,
		'onError' : function (a, b, c, d) {
			if (d.status == 404){
				parent.$.tipMessage('�ϴ����������ԣ�', 2, 3000);
				parent.layer.closeAll();
			}else if (d.type === "HTTP"){
				parent.$.tipMessage('error '+d.type+' : '+d.status, 2, 3000);
				parent.layer.closeAll();
			}else if (d.type === "File Size"){
				parent.$.tipMessage('�ϴ�ʧ�ܣ���С���ܳ���<?php echo $filesizes; ?>MB��', 2, 3000);
				parent.layer.closeAll();
			}else{
				parent.$.tipMessage('error '+d.type+' : '+d.text, 2, 3000);
				parent.layer.closeAll();
			}
		},
		'onComplete' : function (event, queueID, fileObj, response, data) {
			if (response == 1){
				parent.$.tipMessage('�ϴ�ʧ�ܣ����ʲ��ܵ���<?php echo cd_upkbps; ?>kbps��', 2, 3000);
				parent.layer.closeAll();
			}else if (response == 2){
				parent.$.tipMessage('�޷����� COM ��������ں�̨�ر����ʼ�⣡', 2, 3000);
				parent.layer.closeAll();
			}else if (response == 0){
				<?php if($_GET['ac']=="pic"){ ?>
				ReturnValue('<?php echo $targetFiles."/".$randnum; ?>'+fileObj.type);
				<?php }else{ ?>
				ReturnValue('<?php echo $targetFiles."/".$randnum; ?>'+fileObj.type+'.jpg');
				<?php } ?>
			}
		}
	});
});
</script>
<script type="text/javascript">
function ReturnValue(reimg){
	this.parent.document.<?php echo $f; ?>.value=reimg;
	<?php if($_GET['ac']=="song"){ ?>
	this.parent.$.tipMessage('��ϲ����Ƶ�ϴ��ɹ���', 0, 3000);
	<?php }elseif($_GET['ac']=="video"){ ?>
	this.parent.$.tipMessage('��ϲ����Ƶ�ϴ��ɹ���', 0, 3000);
	<?php }elseif($_GET['ac']=="lrc"){ ?>
	this.parent.$.tipMessage('��ϲ������ϴ��ɹ���', 0, 3000);
	<?php }elseif($_GET['ac']=="pic"){ ?>
	this.parent.$.tipMessage('��ϲ��ͼƬ�ϴ��ɹ���', 0, 3000);
	<?php } ?>
	this.parent.layer.closeAll();
}
</script>
</head>
<body>
<?php if($_GET['ac']=="song"){echo "<div style=\"color:#2D9AF6;height:25px;\">���������ϴ��ļ� ".$numa." �����������ϴ� ".$numb." ����</div>";} ?>
<div id="fileQueue"></div>
<input type="file" name="uploadify" id="uploadify" />
</body>
</html>
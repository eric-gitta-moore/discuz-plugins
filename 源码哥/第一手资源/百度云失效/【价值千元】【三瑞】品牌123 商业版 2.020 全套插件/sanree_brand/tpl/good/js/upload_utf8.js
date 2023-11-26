var postSubmited = false;
var AID = {0:1,1:1};
var UPLOADSTATUS = -1;
var UPLOADFAILED = UPLOADCOMPLETE = AUTOPOST = 0;
var CURRENTATTACH = '0';
var FAILEDATTACHS = '';
var UPLOADWINRECALL = null;
var imgexts = typeof imgexts == 'undefined' ? 'jpg, jpeg, gif, png, bmp' : imgexts;
var ATTACHORIMAGE = '0';
var STATUSMSG = {
	'-1' : '内部服务器错误',
	'0' : '上传成功',
	'1' : '不支持此类扩展名',
	'2' : '服务器限制无法上传那么大的附件',
	'3' : '用户组限制无法上传那么大的附件',
	'4' : '不支持此类扩展名',
	'5' : '文件类型限制无法上传那么大的附件',
	'6' : '今日您已无法上传更多的附件',
	'7' : '请选择图片文件(' + imgexts + ')',
	'8' : '附件文件无法保存',
	'9' : '没有合法的文件被上传',
	'10' : '非法操作',
	'11' : '今日您已无法上传那么大的附件',
	'12' : '您上传的图片数已满,联系管理员增加'
};

function rebackposter(aid, url){
	$('caid').value=aid;
	$('poster').value=url;
	$('uploadbar').innerHTML= haveuploaded;
}

function Showupload() {
	ShowuploadExe(function (aid, url) {rebackposter(aid, url)}, 'image') ;
}
function ShowuploadExe(recall, type) {
	var fid = 0;
	UPLOADWINRECALL = recall;
	showWindow('upload', 'plugin.php?id=sanree_brand&mod=upload&fid=' + fid + '&type=' + type, 'get', 0);
}

function uploadWindowload() {
	$('uploadwindowing').style.visibility = 'hidden';
	var str = $('uploadattachframe').contentWindow.document.body.innerHTML;
	if(str == '') return;
	var arr = str.split('|');
	if(arr[0] == 'DISCUZUPLOAD' && arr[2] == 0) {
		UPLOADWINRECALL(arr[3], arr[5], arr[6]);
		hideWindow('upload', 0);
	} else {
		var sizelimit = '';
		if(arr[7] == 'ban') {
			sizelimit = '(附件类型被禁止)';
		} else if(arr[7] == 'perday') {
			sizelimit = '(不能超过 ' + arr[8] + ' 字节)';
		} else if(arr[7] > 0) {
			sizelimit = '(不能超过 ' + arr[7] + ' 字节)';
		}
		if (arr[2]==4) {
			sizelimit = arr[3];
		}		
		showError(STATUSMSG[arr[2]] + sizelimit);
	}
	if($('attachlimitnotice')) {
		////ajaxget('forum.php?mod=ajax&action=updateattachlimit&fid=' + fid, 'attachlimitnotice');
	}
}
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
	'-1' : '�ڲ�����������',
	'0' : '�ϴ��ɹ�',
	'1' : '��֧�ִ�����չ��',
	'2' : '�����������޷��ϴ���ô��ĸ���',
	'3' : '�û��������޷��ϴ���ô��ĸ���',
	'4' : '��֧�ִ�����չ��',
	'5' : '�ļ����������޷��ϴ���ô��ĸ���',
	'6' : '���������޷��ϴ�����ĸ���',
	'7' : '��ѡ��ͼƬ�ļ�(' + imgexts + ')',
	'8' : '�����ļ��޷�����',
	'9' : 'û�кϷ����ļ����ϴ�',
	'10' : '�Ƿ�����',
	'11' : '���������޷��ϴ���ô��ĸ���',
	'12' : '���ϴ���ͼƬ������,��ϵ����Ա����'
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
			sizelimit = '(�������ͱ���ֹ)';
		} else if(arr[7] == 'perday') {
			sizelimit = '(���ܳ��� ' + arr[8] + ' �ֽ�)';
		} else if(arr[7] > 0) {
			sizelimit = '(���ܳ��� ' + arr[7] + ' �ֽ�)';
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
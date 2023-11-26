<?php
Administrator(7);
$action=SafeRequest("action","get");
switch($action){
	case 'getftp':
		$name = SafeRequest("name","get");
		$id = SafeRequest("id","get");
		getftp($name,$id,!empty($_GET['link']) ? $_GET['link'] : cd_ftproot);
		break;
	case 'putdir':
		$ftpclient = new remoteftp(cd_ftphost,cd_ftpport,cd_ftpuser,cd_ftppass);
		$name = SafeRequest("name","get");
		$id = SafeRequest("id","get");
		$dir = SafeRequest("dir","get");
		$ftpclient->putdir($name,$id,$dir);
		break;
	case 'putfile':
		$ftpclient = new remoteftp(cd_ftphost,cd_ftpport,cd_ftpuser,cd_ftppass);
		$name = SafeRequest("name","get");
		$id = SafeRequest("id","get");
		$ftpclient->putfile($name,$id,$_GET['url'],$_GET['title']);
		break;
	default:
		main();
		break;
} function main(){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>远程扫描</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="source/plugin/layer/jquery.js"></script>
<script type="text/javascript" src="source/plugin/layer/lib.js"></script>
<script type="text/javascript">
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
function FtpList(){
        var User=document.getElementById("CD_User").value;
        var ClassID=document.getElementById("CD_ClassID").value;
        if(User==""){
                asyncbox.tips("请填写所属会员！", "wait", 1000);
                document.getElementById("CD_User").focus();
                return;
        }else if(ClassID=="0"){
                asyncbox.tips("请选择所属栏目！", "wait", 1000);
                document.getElementById("CD_ClassID").focus();
                return;
        }
        pop.up('远程扫描', '?iframe=ftp&action=getftp&name='+User+'&id='+ClassID, '640px', '410px', '30px');
}
</script>
</head>
<body>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 工具 - 远程扫描';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='工具&nbsp;&raquo;&nbsp;远程扫描&nbsp;&nbsp;<a target="main" title="添加到常用操作" href="?iframe=menu&action=getadd&name=远程扫描&url=<?php echo $_SERVER['QUERY_STRING']; ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>远程扫描</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<li class="lightnum">1：默认将加载 全局->上传信息->远程设置->上传方式->FTP 中的配置</li>
<li class="lightnum">2：默认加载有 FTP地址|FTP用户名|FTP密码|FTP访问域|FTP端口|FTP根目录 六项配置</li>
<li class="lightnum">3：重复录入不会入库，所属会员必须有效</li>
</ul></td></tr>
</table>
<table class="tb tb2">
<tr><td>所属栏目：<select id="CD_ClassID">
<option value="0">选择栏目</option>
<?php
global $db;
$sql="select * from ".tname('class')." where CD_FatherID=1 and CD_SystemID=1";
$res=$db->query($sql);
if($res){
        while ($row=$db->fetch_array($res)){
                echo "<option value=\"".$row['CD_ID']."\">".$row['CD_Name']."</option>";
        }
}
?>
</select></td><td>所属会员：<input type="text" class="txt" value="<?php echo $_COOKIE['CD_AdminUserName']; ?>" id="CD_User"></td></tr>
</table>
<table class="tb tb2">
<tr><td><input type="button" class="btn" value="加载" onclick="FtpList();" /></td></tr>
</table>
</div>
</body>
</html>
<?php
} function getftp($name,$id,$path){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>远程扫描</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function ReturnError(msg){
	this.parent.asyncbox.tips(msg, "error", 3000);
	this.parent.layer.closeAll();
}
</script>
</head>
<body>
<div class="container">
<table class="tb tb2">
<tr><th class="partition"><?php echo $path; ?></th></tr>
</table>
<table class="tb tb2">
<tr class="header">
<th>列表</th>
<th>大小</th>
<th>操作</th>
</tr>
<?php
$ftpclient = new remoteftp(cd_ftphost,cd_ftpport,cd_ftpuser,cd_ftppass);
$ftpclient->ftplist($name,$id,$path);
?>
</table>
</div>
</body>
</html>
<?php
} class remoteftp {
	public $_conn;
	function __construct($server, $port, $username, $password) {
		$this->_conn = @ftp_connect($server, $port) or die('<script type="text/javascript">ReturnError("FTP服务器连接失败！");</script>');
		@ftp_login($this->_conn, $username, $password) or die('<script type="text/javascript">ReturnError("FTP服务器登录失败！");</script>');
                @ftp_pasv($this->_conn, 1);
	}
	function ftplist($name,$id,$path) {
		$path = $this->getpath($path);
		$rows = ftp_rawlist($this->_conn, iconv('GBK', 'UTF-8', $path));
		foreach ((array) $rows as $row) {
			$tmp = preg_split('/[\s]+/', $row);
			$item['name'] = iconv('UTF-8', 'GB2312//IGNORE', $tmp[8]);
			$item['type'] = substr($tmp[0], 0, 1);
			$item['size'] = $tmp[4];
			if ($item['name'] != '.' && $item['name'] != '..') {
				$link = str_replace('.', '/', $path).'/'.$item['name'].'/';
				$url = str_replace('.', '/', $path).'/';
				$exts = array('mp3', 'm4a', 'flv', 'f4v', 'mp4');
				echo '<tr class="hover">';
				if ($item['type'] == 'd') {
					echo '<td><a href="?iframe=ftp&action=getftp&name='.$name.'&id='.$id.'&link='.str_replace('//', '/', $link).'" class="act">'.$item['name'].'</a></td>';
					echo '<td>'.formatsize($item['size']).'</td>';
					echo '<td><a href="?iframe=ftp&action=putdir&name='.$name.'&id='.$id.'&dir='.str_replace('//', '/', $link).'" class="act">=>遍历录入</a></td>';
				} else {
					echo '<td>'.$item['name'].'</td>';
					echo '<td>'.formatsize($item['size']).'</td>';
					if (in_array(fileext($item['name']), $exts)) {
					        $href = cd_ftproot == '' ? cd_ftpdomain.str_replace('//', '/', $url).$item['name'] : str_replace(cd_ftproot, cd_ftpdomain, str_replace('//', '/', $url).$item['name']);
					        $title = explode('.', $item['name']);
					        echo '<td><a href="?iframe=ftp&action=putfile&name='.$name.'&id='.$id.'&url='.str_replace('//', '/', $url).$item['name'].'&title='.$title[0].'" class="act">->录入</a><a href="'.$href.'" target="_blank" class="act">查看</a></td>';
					} else {
					        echo '<td>无</td>';
					}
				}
				echo '</tr>';
			}
		}
	}
	function putdir($name,$id,$path) {
		$n = 0;
		$path = $this->getpath($path);
		$rows = ftp_rawlist($this->_conn, iconv('GBK', 'UTF-8', $path));
		foreach ((array) $rows as $row) {
			$tmp = preg_split('/[\s]+/', $row);
			$item['name'] = iconv('UTF-8', 'GB2312//IGNORE', $tmp[8]);
			$item['type'] = substr($tmp[0], 0, 1);
			if ($item['name'] != '.' && $item['name'] != '..') {
				$link = str_replace('.', '/', $path).'/'.$item['name'].'/';
				$url = str_replace('.', '/', $path).'/';
				$exts = array('mp3', 'm4a', 'flv', 'f4v', 'mp4');
				if ($item['type'] == 'd') {
					$this->putloop($name,$id,str_replace('//', '/', $link));
				}
				if ($item['type'] != 'd') {
					if (in_array(fileext($item['name']), $exts)) {
					        global $n;
					        $n = $n+1;
					        $title = explode('.', $item['name']);
					        $this->insert_into($name,$id,str_replace('//', '/', $url).$item['name'],$title[0]);
					}
				}
			}
		}
		ShowMessage("恭喜，成功录入".$n."首！",$_SERVER['HTTP_REFERER'],"infotitle2",3000,0);
	}
	function putloop($name,$id,$path) {
		$path = $this->getpath($path);
		$rows = ftp_rawlist($this->_conn, iconv('GBK', 'UTF-8', $path));
		foreach ((array) $rows as $row) {
			$tmp = preg_split('/[\s]+/', $row);
			$item['name'] = iconv('UTF-8', 'GB2312//IGNORE', $tmp[8]);
			$item['type'] = substr($tmp[0], 0, 1);
			if ($item['name'] != '.' && $item['name'] != '..') {
				$link = str_replace('.', '/', $path).'/'.$item['name'].'/';
				$url = str_replace('.', '/', $path).'/';
				$exts = array('mp3', 'm4a', 'flv', 'f4v', 'mp4');
				if ($item['type'] == 'd') {
					$this->putloop($name,$id,str_replace('//', '/', $link));
				}
				if ($item['type'] != 'd') {
					if (in_array(fileext($item['name']), $exts)) {
					        global $n;
					        $n = $n+1;
					        $title = explode('.', $item['name']);
					        $this->insert_into($name,$id,str_replace('//', '/', $url).$item['name'],$title[0]);
					}
				}
			}
		}
	}
	function getpath($path) {
		if (empty($path)) {
			$path = '.';
		}
		$path = str_replace('\\', '/', $path);
		$length	= strlen($path);
		while ($path[--$length] == '/') {
			$path = substr($path, 0, $length);
		}
		return $path;
	}
	function putfile($name,$id,$url,$title) {
		$this->insert_into($name,$id,$url,$title);
		ShowMessage("恭喜，录入成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,0);
	}
	function insert_into($name,$id,$url,$title) {
		global $db;
		$url = cd_ftproot == '' ? cd_ftpdomain.$url : str_replace(cd_ftproot, cd_ftpdomain, $url);
		$res=$db->query("select cd_id,cd_nicheng from ".tname('user')." where cd_name='".$name."'");
		if(!$db->getone("select CD_ID from ".tname('music')." where CD_Url='".$url."'")){
			if($row=$db->fetch_array($res)){
				$db->query("Insert ".tname('music')." (CD_Name,CD_ClassID,CD_SpecialID,CD_SingerID,CD_User,CD_UserID,CD_UserNicheng,CD_Pic,CD_Url,CD_DownUrl,CD_Word,CD_Lrc,CD_Hits,CD_DownHits,CD_FavHits,CD_DianGeHits,CD_GoodHits,CD_BadHits,CD_Server,CD_IsBest,CD_Points,CD_Grade,CD_Color,CD_Skin,CD_AddTime,CD_Deleted,CD_Error,CD_Passed) values ('".$title."',".$id.",0,0,'".$name."',".$row['cd_id'].",'".$row['cd_nicheng']."','','".$url."','".$url."','','',0,0,0,0,0,0,0,5,0,3,'','play.html','".date('Y-m-d H:i:s')."',0,0,0)");
			}
		}
	}
}
?>
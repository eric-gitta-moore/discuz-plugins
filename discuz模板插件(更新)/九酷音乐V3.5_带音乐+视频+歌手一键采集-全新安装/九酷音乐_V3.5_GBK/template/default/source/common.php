<?php
$TempImg=cd_webpath.substr(substr(cd_templatedir,0,strlen(cd_templatedir)-1),0,strrpos(substr(cd_templatedir,0,strlen(cd_templatedir)-1),'/')+1);
if(cd_webhtml==3){$user_mod=cd_webpath."mod/";}else{$user_mod=cd_webpath."user.php?mod=";}
$ac=SafeRequest("do","get");
if($ac=="login"){
	$title="会员登录";
}elseif($ac=="register"){
	$title="快速注册";
}elseif($ac=="lostpasswd"){
	$title="找回密码";
}elseif($ac=="favorites"){
	$title="收藏音乐";
}elseif($ac=="error"){
	$title="报错音乐";
}elseif($ac=="diange"){
	$title="音乐点歌";
}else{
	$title="电台";
}
global $userlogined;
if(!$userlogined){
	$qianwei_in_username="游客";
}
function getuserpage($mysql,$pagesize) {
	global $db;
	$url=$_SERVER["QUERY_STRING"];
	if(stristr($url,'&pages')){
		$url=preg_replace('/&pages=([\S]+?)$/','',$url);
	}
	if(stristr($url,'pages')){
		$url=preg_replace('/pages=([\S]+?)$/','',$url);
	}
	if(IsNul($url)){$url.="&";}
	$pages=SafeRequest("pages","get");
	$pagesok=$pagesize;
	if (!isset($pages)||$pages==""||!is_numeric($pages)||$pages<=0){
		$pages=1;
	}
  	$sqlstr=$mysql;
  	$res=$db -> query($sqlstr);
 	$nums= $db -> num_rows($res);
	if($nums==0){$nums=1;}
  	$pagejs=ceil($nums/$pagesok);
	if($pages>$pagejs){
		$pages=$pagejs;
	}
	$sql=$sqlstr." LIMIT ".$pagesok*($pages-1).",".$pagesok;
	$result = $db -> query($sql);
 	$str="";
	if($nums>1){
 		$str.="<a>共<strong>".$nums."</strong>条评论</a> ";
		if($pages==1){
			$str.="<a>首页</a> ";
		}else{
			$str.="<a href='?".$url."pages=1'>首页</a> ";
		}
		if($pages>1){
			$str.="<a href='?".$url."pages=".($pages-1)."'>上一页</a> ";
		}else{
			$str.="<a>上一页</a> ";
		}
		if($pages<$pagejs){
			$str.="<a href='?".$url."pages=".($pages+1)."'>下一页</a> ";
		}else{
			$str.="<a>下一页</a> ";
		}
		if($pages==$pagejs){
			$str.="<a>尾页</a> ";
		}else{
			$str.="<a href='?".$url."pages=".$pagejs."'>尾页</a> ";
		}
	}
	while ($row = $db -> fetch_array($result) ){}
	$arr=array($str,$result,$sql,$pagejs,$pages);
	return $arr;
}
?>
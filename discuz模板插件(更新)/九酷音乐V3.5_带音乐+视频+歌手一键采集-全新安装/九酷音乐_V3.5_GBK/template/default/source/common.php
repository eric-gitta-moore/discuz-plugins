<?php
$TempImg=cd_webpath.substr(substr(cd_templatedir,0,strlen(cd_templatedir)-1),0,strrpos(substr(cd_templatedir,0,strlen(cd_templatedir)-1),'/')+1);
if(cd_webhtml==3){$user_mod=cd_webpath."mod/";}else{$user_mod=cd_webpath."user.php?mod=";}
$ac=SafeRequest("do","get");
if($ac=="login"){
	$title="��Ա��¼";
}elseif($ac=="register"){
	$title="����ע��";
}elseif($ac=="lostpasswd"){
	$title="�һ�����";
}elseif($ac=="favorites"){
	$title="�ղ�����";
}elseif($ac=="error"){
	$title="��������";
}elseif($ac=="diange"){
	$title="���ֵ��";
}else{
	$title="��̨";
}
global $userlogined;
if(!$userlogined){
	$qianwei_in_username="�ο�";
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
 		$str.="<a>��<strong>".$nums."</strong>������</a> ";
		if($pages==1){
			$str.="<a>��ҳ</a> ";
		}else{
			$str.="<a href='?".$url."pages=1'>��ҳ</a> ";
		}
		if($pages>1){
			$str.="<a href='?".$url."pages=".($pages-1)."'>��һҳ</a> ";
		}else{
			$str.="<a>��һҳ</a> ";
		}
		if($pages<$pagejs){
			$str.="<a href='?".$url."pages=".($pages+1)."'>��һҳ</a> ";
		}else{
			$str.="<a>��һҳ</a> ";
		}
		if($pages==$pagejs){
			$str.="<a>βҳ</a> ";
		}else{
			$str.="<a href='?".$url."pages=".$pagejs."'>βҳ</a> ";
		}
	}
	while ($row = $db -> fetch_array($result) ){}
	$arr=array($str,$result,$sql,$pagejs,$pages);
	return $arr;
}
?>
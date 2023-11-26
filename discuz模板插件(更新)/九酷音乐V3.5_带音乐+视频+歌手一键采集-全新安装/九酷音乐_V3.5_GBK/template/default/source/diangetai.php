<?php
$Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir."diangetai.html");
$Mark_Text=topandbottom($Mark_Text);
$data_content="";
$pagenum=getpagenum($Mark_Text);
preg_match_all('/{qianwei:music(.*?pagesize=([\S]+).*?)}([\s\S]+?){\/qianwei:music}/',$Mark_Text,$page_arr);
if(!empty($page_arr) && !empty($page_arr[2])){
	$sqlstr="select * from ".tname('music')." where CD_Deleted=0 and CD_DianGeHits>0 order by CD_DianGeHits desc";
	$li="";
	$lis="";
	$lisp="";
	preg_match_all('/<pagestyle>([\s\S]+?)<\/pagestyle>/',$Mark_Text,$page_style);
	if(!empty($page_style) && !empty($page_style[1][0])){
	        $i=explode("|",$page_style[1][0]);
	        $li=$i[0];
	        $lis=$i[1];
	        $lisp=$i[2];
	        $Mark_Text=ReplaceStr($Mark_Text,$page_style[0][0],"");
	}
	$Arr=searchpage($sqlstr,$page_arr[2][0],$li,$lis,$lisp);
	$result=$db->query($Arr[2]);
	$recount=$db->num_rows($result);
	if($recount==0){
		$data_content="<div align=\"center\">点歌台暂无数据！</div>";
	}else{
		if($result){
			$sorti=1;
			while ($row2 = $db ->fetch_array($result)){
				$datatmp=datamusic($page_arr[0][0],$page_arr[3][0],$row2,$sorti);
				$sorti=$sorti+1;
				$data_content.=$datatmp;
			}
		}
	}
	$Mark_Text=Page_Mark($Mark_Text,$Arr);
	$Mark_Text=ReplaceStr($Mark_Text,$page_arr[0][0],$data_content);
	unset($Arr);
}
unset($page_arr);
unset($page_style);
$Mark_Text=Common_Mark($Mark_Text,0);
$p=SafeRequest("pages","get");
$cache_id="diangetai_".$p;
if(!($cache_opt->start($cache_id))){
	echo $Mark_Text;
	$cache_opt->end();
}
function searchpage($mysql,$pagesize,$li,$lis,$lisp,$pagenum=10){
	global $db,$action;
	$url=cd_webpath."user.php?mod=diangetai";
	$pages=SafeRequest("pages","get");
	$pagesok=$pagesize;
	if (!isset($pages)||$pages==""||!is_numeric($pages)||$pages<=0){$pages=1;}
  	$sqlstr=$mysql;
  	$res=$db -> query($sqlstr);
 	$nums= $db -> num_rows($res);
	if($nums==0){$nums=1;}
	$pagejs=ceil($nums/$pagesok);
	if($pages>$pagejs){ $pages=$pagejs;}
	$sql=$sqlstr." LIMIT ".$pagesok*($pages-1).",".$pagesok;
	$result = $db -> query($sql);
	$str="";
	$first=$url."&pages=1";
	$pageup=$url."&pages=".($pages-1);
	$pagenext=$url."&pages=".($pages+1);
	$last=$url."&pages=".$pagejs;
	$pagelist="<script type=\"text/javascript\">function gotopage(url,page){window.location=url+page;}</script>";
	$pagelist.="<select onchange=\"gotopage('".$url."&pages=',this.value)\">\r\n<option value=\"0\">跳转</option>\r\n";
	for($k=1;$k<=$pagejs;$k++){
		if($k==$pages){
			$pagelist.="<option value=\"".$k."\" selected>第".$k."页</option>\r\n";
	        }else{
			$pagelist.="<option value=\"".$k."\">第".$k."页</option>\r\n";
	        }
	}
	$pagelist.="</select>";
	if($pagejs<=$pagenum){
  		for($i=1;$i<=$pagejs;$i++){
   			if($i==$pages){
   				$str.=ReplaceStr($lis,"[link]",$url."&pages=".$i).$i.$lisp;
   			}else{
   				$str.=ReplaceStr($li,"[link]",$url."&pages=".$i).$i.$lisp;
   			}
 	 	}
	}else{
 		if($pages>=$pagenum){
 			for($i=$pages-5;$i<=$pages+6;$i++){
   				if($i<=$pagejs){
   				        if($i==$pages){
   						$str.=ReplaceStr($lis,"[link]",$url."&pages=".$i).$i.$lisp;
   				        }else{
   						$str.=ReplaceStr($li,"[link]",$url."&pages=".$i).$i.$lisp;
   				        }
    				}
  			}
   		}else{
  			for($i=1;$i<=$pagenum;$i++){
   				if($i==$pages){
   					$str.=ReplaceStr($lis,"[link]",$url."&pages=".$i).$i.$lisp;
   				}else{
   					$str.=ReplaceStr($li,"[link]",$url."&pages=".$i).$i.$lisp;
   				}
 			}
 		 }
	}
	while ($row = $db -> fetch_array($result)){}
	$arr=array($str,$result,$sql,$nums,$pagelist,$pages,$pagejs,$first,$pageup,$pagenext,$last,$pagesok);
	return $arr;
}
?>
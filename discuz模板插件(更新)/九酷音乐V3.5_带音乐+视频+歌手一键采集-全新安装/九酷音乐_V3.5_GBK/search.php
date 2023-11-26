<?php
include "source/global/global_conn.php";
$action=!empty($_GET['action']) ? $_GET['action'] : 'keyword';
$key=SafeRequest("key","get");
if(is_utf8($key)){
	$key=convert_encoding($key, 'GBK', 'UTF-8');
}
if($key==""){
	die(html_message("错误信息","请输入要查询的关键词！","<script type=\"text/javascript\">setTimeout(\"window.location.href='".cd_webpath."';\",3000);</script>"));
}
if($action=="keyword"){
        $Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir."search.html");
}elseif($action=="video"){
        $Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir."videosearch.html");
}else{
        $Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir."singersearch.html");
}
$Mark_Text=topandbottom($Mark_Text);
$Mark_Text=ReplaceStr($Mark_Text,"[qianwei:search]",$key);
$data_content="";
$pagenum=getpagenum($Mark_Text);
if($action=="keyword"){
        preg_match_all('/{qianwei:music(.*?pagesize=([\S]+).*?)}([\s\S]+?){\/qianwei:music}/',$Mark_Text,$page_arr);
}elseif($action=="video"){
        preg_match_all('/{qianwei:video(.*?pagesize=([\S]+).*?)}([\s\S]+?){\/qianwei:video}/',$Mark_Text,$page_arr);
}else{
        preg_match_all('/{qianwei:singer(.*?pagesize=([\S]+).*?)}([\s\S]+?){\/qianwei:singer}/',$Mark_Text,$page_arr);
}
if(!empty($page_arr) && !empty($page_arr[2])){
	if($action=="keyword"){
	        $sqlstr="select * from ".tname('music')." where CD_Deleted=0 and CD_Name like '%".$key."%' or CD_Deleted=0 and CD_User like '%".$key."%' order by CD_AddTime desc";
	}elseif($action=="video"){
	        $sqlstr="select * from ".tname('video')." where CD_Name like '%".$key."%' or CD_User like '%".$key."%' order by CD_AddTime desc";
	}else{
	        $letter_arr=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	        $letter_arr1=array(-20319,-20283,-19775,-19218,-18710,-18526,-18239,-17922,-1,-17417,-16474,-16212,-15640,-15165,-14922,-14914,-14630,-14149,-14090,-13318,-1,-1,-12838,-12556,-11847,-11055);
	        $letter_arr2=array(-20284,-19776,-19219,-18711,-18527,-18240,-17923,-17418,-1,-16475,-16213,-15641,-15166,-14923,-14915,-14631,-14150,-14091,-13319,-12839,-1,-1,-12557,-11848,-11056,-2050);
	        if(in_array(strtoupper($key),$letter_arr)){
			$posarr=array_keys($letter_arr,strtoupper($key));
			$pos=$posarr[0];
			$sqlstr="select * from ".tname('singer')." where UPPER(substring(CD_Name,1,1))='".$letter_arr[$pos]."' or ord(substring(CD_Name,1,1))-65536>=".$letter_arr1[$pos]." and  ord(substring(CD_Name,1,1))-65536<=".$letter_arr2[$pos];
	        }else{
			$sqlstr="select * from ".tname('singer')." where CD_Area like '%".$key."%' order by CD_AddTime desc";
	        }
	}
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
	$Arr=searchpage($sqlstr,$page_arr[2][0],$key,$li,$lis,$lisp);
	$result=$db->query($Arr[2]);
	$recount=$db->num_rows($result);
	if($recount==0){
		$data_content="<div align=\"center\">对不起，没有找到与“".$key."”相关的内容！</div>";
	}else{
		if($result){
			$sorti=1;
			while ($row2 = $db ->fetch_array($result)){
				if($action=="keyword"){
				        $datatmp=datamusic($page_arr[0][0],$page_arr[3][0],$row2,$sorti);
				}elseif($action=="video"){
				        $datatmp=datavideo($page_arr[0][0],$page_arr[3][0],$row2,$sorti);
				}else{
				        $datatmp=datasinger($page_arr[0][0],$page_arr[3][0],$row2,$sorti);
				}
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
$cache_id=$action.$key.$p;
if(!($cache_opt->start($cache_id))){
	echo $Mark_Text;
	$cache_opt->end();
}
function searchpage($mysql,$pagesize,$key,$li,$lis,$lisp,$pagenum=10){
	global $db,$action;
	$url=cd_webpath."search.php?action=".$action."&key=".$key;
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
function is_utf8($string){
	return preg_match('%^(?:[\x09\x0A\x0D\x20-\x7E] | [\xC2-\xDF][\x80-\xBF] | \xE0[\xA0-\xBF][\x80-\xBF] | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} | \xED[\x80-\x9F][\x80-\xBF] | \xF0[\x90-\xBF][\x80-\xBF]{2} | [\xF1-\xF3][\x80-\xBF]{3} | \xF4[\x80-\x8F][\x80-\xBF]{2})*$%xs',$string);
}
?>
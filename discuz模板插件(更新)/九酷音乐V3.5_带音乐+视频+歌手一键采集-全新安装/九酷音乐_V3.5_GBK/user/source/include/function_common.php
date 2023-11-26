<?php
function VerifyLogin($uid){
	if($uid){
		global $db;
		$db->query("delete from ".tname('feed')." where DateDiff(DATE(cd_addtime),'".date('Y-m-d')."')<=-".cd_feedday);
		$db->query("delete from ".tname('listen')." where cd_addtime<=".strtotime(date('Y-m-d',strtotime('-'.cd_listenday.' day'))));
		$db->query("delete from ".tname('notice')." where DateDiff(DATE(cd_addtime),'".date('Y-m-d')."')<=-".cd_notificationday);
		if(strtotime(date('Y-m-d'))>=strtotime(date('Y-01-01')) && strtotime(date('Y-m-d'))<=strtotime(date('Y-01-03'))){
			$timing_time=(date('Y')-1).'-06-30';
		}elseif(strtotime(date('Y-m-d'))>=strtotime(date('Y-07-01')) && strtotime(date('Y-m-d'))<=strtotime(date('Y-07-03'))){
			$timing_time=date('Y-01-01');
		}
		if(!empty($timing_time)){
			$sql="select sum(cd_points) from ".tname('bill')." where cd_type=1 and cd_uid=".$uid." and DateDiff(DATE(cd_endtime),'".$timing_time."')<=0";
			if($res=$db->query($sql)){
				list($sum)=mysql_fetch_row($res);
				mysql_free_result($res);
				if($sum){
					$db->query("delete from ".tname('bill')." where cd_type=1 and cd_uid=".$uid." and DateDiff(DATE(cd_endtime),'".$timing_time."')<=0");
					$db->query("update ".tname('user')." set cd_points=cd_points-".$sum." where cd_id=".$uid);
					$setarr = array(
						'cd_uid' => 0,
						'cd_uname' => '系统提示',
						'cd_uids' => $uid,
						'cd_unames' => '',
						'cd_icon' => 'account',
						'cd_data' => '您有'.$sum.'积分在到期前还未消费，已被系统自动清空！',
						'cd_dataid' => 0,
						'cd_state' => 1,
						'cd_addtime' => date('Y-m-d H:i:s')
					);
					inserttable('notice', $setarr, 1);
				}
			}
		}
		$db->query("delete from ".tname('bill')." where cd_type=1 and cd_state=1 and cd_uid=".$uid." and DateDiff(DATE(cd_endtime),'".date('Y-m-d')."')<=0");
	}else{
		$current_url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		setcookie("cd_loginlink",$current_url,time()+86400,cd_cookiepath);
		exit("<script type=\"text/javascript\">location.href='".cd_upath.rewrite_url('index.php?p=user&a=login')."';</script>");
	}
}

function CheckCertify($music, $mm='0', $vip='0', $viprank='0'){
	$certify='';
	if($music){
		$certify.='<a class="certify" href="javascript:void(0)" title="音乐认证" onclick="openWebsite.openTo(\'musiccertify\');"></a>';
	}
	if($mm==1){
		$certify.='<a class="certify_mm" href="javascript:void(0)" title="美女认证" onclick="openWebsite.openTo(\'certify\');"></a>';
	}
	if($vip){
		$certify.='<a class="vip_style vip10'.getviprank($viprank,0).'" href="javascript:void(0)" title="VIP'.getviprank($viprank,0).'会员" onclick="openWebsite.openTo(\'vip\');"></a>';
	}
	return $certify;
}

function GetDislike($cd_uid){
	global $db;
        $Dislike="";
        $query = $db->query("select cd_musicid from ".tname('dislike')." where cd_uid=".$cd_uid." order by cd_addtime desc");
        while ($row = $db->fetch_array($query)) {
		$Dislike=$Dislike.$row['cd_musicid'].",";
	}
	$Dislike=$Dislike."]";
	$Dislike=ReplaceStr($Dislike,",]","");
	if($Dislike=="]"){
		return "1000000000,2000000000";
	}else{
		return $Dislike;
	}
}

function GetListen($cd_uid){
	global $db;
        $Listen="";
        $query = $db->query("select cd_musicid from ".tname('listen')." where cd_uid=".$cd_uid." order by cd_addtime desc");
        while ($row = $db->fetch_array($query)) {
		$Listen=$Listen.$row['cd_musicid'].",";
	}
	$Listen=$Listen."]";
	$Listen=ReplaceStr($Listen,",]","");
	if($Listen=="]"){
		return "1000000000,2000000000";
	}else{
		return $Listen;
	}
}

function GetFavorites($cd_uid){
	global $db;
        $Favorites="";
        $query = $db->query("select cd_musicid from ".tname('like')." where cd_uid=".$cd_uid." order by cd_addtime desc");
        while ($row = $db->fetch_array($query)) {
		$Favorites=$Favorites.$row['cd_musicid'].",";
	}
	$Favorites=$Favorites."]";
	$Favorites=ReplaceStr($Favorites,",]","");
	if($Favorites=="]"){
		return "1000000000,2000000000";
	}else{
		return $Favorites;
	}
}

function GetFolloWing($cd_uid,$cd_type){
	global $db;
        $friend="";
        $query = $db->query("select cd_uids,cd_unames from ".tname('friend')." where cd_uid=".$cd_uid." order by cd_addtime desc");
        while ($row = $db->fetch_array($query)) {
		if($cd_type){
			$friend=$friend."'".$row['cd_unames']."',";
		}else{
			$friend=$friend.$row['cd_uids'].",";
		}
	}
	$friend=$friend."]";
	$friend=ReplaceStr($friend,",]","");
	if($friend=="]"){
		return "1000000000,2000000000";
	}else{
		return $friend;
	}
}

function CheckLogin($cd_uid){
	global $db;
	$cd_id = $db->getone("select cd_id from ".tname('session')." where cd_uid=".$cd_uid);
	if($cd_id){
		return '1';
	}else{
		return '0';
	}
}

function IsFriend($cd_uid,$cd_uids){
	global $db;
	$cd_id = $db->getone("select cd_id from ".tname('friend')." where cd_lock=0 and cd_uid=".$cd_uid." and cd_uids=".$cd_uids);
	if($cd_id){
		return '1';
	}else{
		return '0';
	}
}

function IsFans($cd_uid,$cd_uids){
	global $db;
	$cd_id = $db->getone("select cd_id from ".tname('fans')." where cd_uid=".$cd_uid." and cd_uids=".$cd_uids);
	if($cd_id){
		return '1';
	}else{
		return '0';
	}
}

function getfilesize($str_filename){
	if(file_exists($str_filename)){
		$int_filesize=filesize($str_filename);
		if($int_filesize<0){
			if(strtolower(substr($_SERVER['OS'], 0, 3))=='win'){
				$int_filesize = 0 + exec('FOR %A IN ("'.$str_file.'") DO @ECHO %~zA');
			}else{
				$int_filesize = 0 + trim(`stat -c%s $str_file`);
			}
		}
	}else{
		$int_filesize = 0;
	}
	return formatsize($int_filesize);
}

function getavatar($uid,$cid){
	if($cid == 120){
		$size = "middle";
	}elseif($cid == 200){
		$size = "big";
	}else{
		$size = "small";
	}
	global $db;
	$row = $db->getrow("select * from ".tname('user')." where cd_id=".$uid);
	$avatar = _qianwei_root_."data/attachment/avatar/".$uid."_".$cid."x".$cid.".jpg";
	if(!file_exists($avatar) && IsNul($row['cd_qqopen'])){
		$avatar = $row['cd_qqimg'];
	}elseif(cd_ucenter==1 && $row['cd_ucenter']>0){
		require_once _qianwei_root_.'./client/ucenter.php';
		$avatar = UC_API."/avatar.php?uid=".$row['cd_ucenter']."&size=".$size;
	}else{
	        if(file_exists($avatar)){
		        $avatar = cd_webpath."data/attachment/avatar/".$uid."_".$cid."x".$cid.".jpg";
	        }else{
		        $avatar = cd_upath."static/images/noface_".$cid."x".$cid.".gif";
	        }
	}
	return $avatar;
}

function checkEmail($inAddress){
	return preg_match('/^[a-z0-9!#$%&\'*+\/=?^`{}|~_-]+[.a-z0-9!#$%&\'*+\/=?^`{}|~_-]*@[a-z0-9]+[._a-z0-9-]*\.[a-z0-9]+$/ui', $inAddress);
}

function getuserpage($mysql,$pagesize){
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
 		$str="<em title=\"总数量\">".$nums."</em>";
		if($pages>3){
			$str.="<a href='".cd_upath.rewrite_url("index.php?".$url."pages=1")."' class='last' title='首页'>1&nbsp;...</a>";
		}
		if($pages>1){
			$str.="<a href='".cd_upath.rewrite_url("index.php?".$url."pages=".($pages-1))."' class='prev' title='上一页'>&laquo;</a>";
		}
		if($pagejs<=6){
  			for($i=1;$i<=$pagejs;$i++){
   				if($i==$pages){
   					$str.="<strong title='第".$i."页'>".$i."</strong>";
   				}else{
   					$str.="<a href='".cd_upath.rewrite_url("index.php?".$url."pages=".$i)."'>".$i."</a>";
   				}
 	 		}
		}else{
 			if($pages>=8){
 				for($i=$pages-3;$i<=$pages+4;$i++){
   					if($i<=$pagejs){
   				        	if($i==$pages){
   							$str.="<strong title='第".$i."页'>".$i."</strong>";
   				        	}else{
   							$str.="<a href='".cd_upath.rewrite_url("index.php?".$url."pages=".$i)."'>".$i."</a>";
   				        	}
    					}
  				}
   			}else{
  				for($i=1;$i<=8;$i++){
   					if($i==$pages){
   						$str.="<strong title='第".$i."页'>".$i."</strong>";
   					}else{
   						$str.="<a href='".cd_upath.rewrite_url("index.php?".$url."pages=".$i)."'>".$i."</a>";
   					}
 				} 
 		 	}
		}
		if($pages<$pagejs){
			$str.="<a href='".cd_upath.rewrite_url("index.php?".$url."pages=".($pages+1))."' class='next' title='下一页'>&raquo;</a>";
		}
		if($pages<$pagejs-2){
			$str.="<a href='".cd_upath.rewrite_url("index.php?".$url."pages=".$pagejs)."' class='last' title='最后一页'>...&nbsp;".$pagejs."</a>";
		}
	while ($row = $db -> fetch_array($result) ){}
	$arr=array($str,$result,$sql,$pagejs);
	return $arr;
}

function getwebpage($mysql,$pagesize,$url){
	global $db;
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
 		$str="<em title=\"总数量\">".$nums."</em>";
		if($pages>3){
			$str.="<a href='".cd_upath.rewrite_url($url."&pages=1")."' class='last' title='首页'>1&nbsp;...</a>";
		}
		if($pages>1){
			$str.="<a href='".cd_upath.rewrite_url($url."&pages=".($pages-1))."' class='prev' title='上一页'>&laquo;</a>";
		}
		if($pagejs<=6){
  			for($i=1;$i<=$pagejs;$i++){
   				if($i==$pages){
   					$str.="<strong title='第".$i."页'>".$i."</strong>";
   				}else{
   					$str.="<a href='".cd_upath.rewrite_url($url."&pages=".$i)."'>".$i."</a>";
   				}
 	 		}
		}else{
 			if($pages>=8){
 				for($i=$pages-3;$i<=$pages+4;$i++){
   					if($i<=$pagejs){
   				        	if($i==$pages){
   							$str.="<strong title='第".$i."页'>".$i."</strong>";
   				        	}else{
   							$str.="<a href='".cd_upath.rewrite_url($url."&pages=".$i)."'>".$i."</a>";
   				        	}
    					}
  				}
   			}else{
  				for($i=1;$i<=8;$i++){
   					if($i==$pages){
   						$str.="<strong title='第".$i."页'>".$i."</strong>";
   					}else{
   						$str.="<a href='".cd_upath.rewrite_url($url."&pages=".$i)."'>".$i."</a>";
   					}
 				} 
 		 	}
		}
		if($pages<$pagejs){
			$str.="<a href='".cd_upath.rewrite_url($url."&pages=".($pages+1))."' class='next' title='下一页'>&raquo;</a>";
		}
		if($pages<$pagejs-2){
			$str.="<a href='".cd_upath.rewrite_url($url."&pages=".$pagejs)."' class='last' title='最后一页'>...&nbsp;".$pagejs."</a>";
		}
	while ($row = $db -> fetch_array($result) ){}
	$arr=array($str,$result,$sql,$pagejs,$pages,$nums);
	return $arr;
}

function getwallpage($mysql,$pagesize,$url){
	global $db;
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
 		$str="<em title=\"总数量\">".$nums."</em>";
		if($pages>3){
			$str.="<a href=\"javascript:;\" onclick=\"wallLib.moreWall(".$url.",1);\" class='last' title='首页'>1&nbsp;...</a>";
		}
		if($pages>1){
			$str.="<a href=\"javascript:;\" onclick=\"wallLib.moreWall(".$url.",".($pages-1).");\" class='prev' title='上一页'>&laquo;</a>";
		}
		if($pagejs<=6){
  			for($i=1;$i<=$pagejs;$i++){
   				if($i==$pages){
   					$str.="<strong title='第".$i."页'>".$i."</strong>";
   				}else{
   					$str.="<a href=\"javascript:;\" onclick=\"wallLib.moreWall(".$url.",".$i.");\">".$i."</a>";
   				}
 	 		}
		}else{
 			if($pages>=8){
 				for($i=$pages-3;$i<=$pages+4;$i++){
   					if($i<=$pagejs){
   				        	if($i==$pages){
   							$str.="<strong title='第".$i."页'>".$i."</strong>";
   				        	}else{
   							$str.="<a href=\"javascript:;\" onclick=\"wallLib.moreWall(".$url.",".$i.");\">".$i."</a>";
   				        	}
    					}
  				}
   			}else{
  				for($i=1;$i<=8;$i++){
   					if($i==$pages){
   						$str.="<strong title='第".$i."页'>".$i."</strong>";
   					}else{
   						$str.="<a href=\"javascript:;\" onclick=\"wallLib.moreWall(".$url.",".$i.");\">".$i."</a>";
   					}
 				} 
 		 	}
		}
		if($pages<$pagejs){
			$str.="<a href=\"javascript:;\" onclick=\"wallLib.moreWall(".$url.",".($pages+1).");\" class='next' title='下一页'>&raquo;</a>";
		}
		if($pages<$pagejs-2){
			$str.="<a href=\"javascript:;\" onclick=\"wallLib.moreWall(".$url.",".$pagejs.");\" class='last' title='最后一页'>...&nbsp;".$pagejs."</a>";
		}
	while ($row = $db -> fetch_array($result) ){}
	$arr=array($str,$result,$sql,$pagejs);
	return $arr;
}

function getwebfavpage($mysql,$pagesize,$url){
	global $db;
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
		if($pagejs<=6){
  			for($i=1;$i<=$pagejs;$i++){
   				if($i==$pages){
   					$str.="<li><a class=\"thispage\" href='".cd_upath.rewrite_url($url."&pages=".$i)."'><span>".$i."</span></a></li>";
   				}else{
   					$str.="<li><a href='".cd_upath.rewrite_url($url."&pages=".$i)."'><span>".$i."</span></a></li>";
   				}
 	 		}
		}else{
 			if($pages>=8){
 				for($i=$pages-3;$i<=$pages+4;$i++){
   					if($i<=$pagejs){
   				        	if($i==$pages){
   							$str.="<li><a class=\"thispage\" href='".cd_upath.rewrite_url($url."&pages=".$i)."'><span>".$i."</span></a></li>";
   				        	}else{
   							$str.="<li><a href='".cd_upath.rewrite_url($url."&pages=".$i)."'><span>".$i."</span></a></li>";
   				        	}
    					}
  				}
   			}else{
  				for($i=1;$i<=8;$i++){
   					if($i==$pages){
   						$str.="<li><a class=\"thispage\" href='".cd_upath.rewrite_url($url."&pages=".$i)."'><span>".$i."</span></a></li>";
   					}else{
   						$str.="<li><a href='".cd_upath.rewrite_url($url."&pages=".$i)."'><span>".$i."</span></a></li>";
   					}
 				}
 		 	}
		}
	while ($row = $db -> fetch_array($result) ){}
	$arr=array($str,$result,$sql,$pagejs,$pages);
	return $arr;
}
?>
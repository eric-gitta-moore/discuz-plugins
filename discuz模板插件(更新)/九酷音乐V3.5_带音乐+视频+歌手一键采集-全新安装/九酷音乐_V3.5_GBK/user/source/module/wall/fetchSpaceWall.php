<?php
include "../source/global/global_inc.php";
close_browse();

	$cd_uid = SafeRequest("uid","post");
	$cd_pages = SafeRequest("currPage","post");
	global $db;
	$i=0;
	$sql="select * from ".tname('wall')." where cd_wallid=0 and cd_dataid='$cd_uid' order by cd_addtime desc";
	$Arr=getajaxwallpage($sql, 10, $cd_uid, $cd_pages);//sql,每页显示条数
	$result=$db->query($Arr[2]);
	$num=$db->num_rows($result);
	$showstr='';
	if($num==0){ echo '<div class="nothing">囧啊```还木有人留言啊- -! 您来留个言吧。</div>'; }
	if($result){
		while ($row = $db ->fetch_array($result)){
			$user = $db->getrow("select cd_nicheng,cd_checkmusic,cd_checkmm,cd_grade,cd_viprank from ".tname('user')." where cd_id='".$row['cd_uid']."'");
			$cd_content = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"face\">", $row['cd_content']);
			//$cd_content = preg_replace("/\<br.*?\>/is", ' ', $cd_content);
			$showstr=$showstr.'<div class="wallLine" id="wall_'.$row['cd_id'].'">';
			$showstr=$showstr.'<div class="wallItem">';
			$showstr=$showstr.'<div class="arrow"><s></s></div>';
			$showstr=$showstr.'<div class="wI_avatar"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'"><img class="avatar-58" src="'.getavatar($row['cd_uid'],48).'" width="48" height="48"/></a></div>';
			$showstr=$showstr.'<div class="wI_content">';
			$showstr=$showstr.'<div class="wI_top">';
			$showstr=$showstr.'<span class="nickname"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'">'.$user['cd_nicheng'].'</a>';
			$showstr=$showstr.CheckCertify($user['cd_checkmusic'],$user['cd_checkmm'],$user['cd_grade'],$user['cd_viprank']);
			$showstr=$showstr.'</span><span class="info">留言：</span>';
			if($cd_uid == $qianwei_in_userid){
				$showstr=$showstr.'<span id="del-w'.$row['cd_id'].'" class="del" title="删除" onclick="$call(function(){wallLib.doDelWall('.$cd_uid.', '.$row['cd_id'].', 0, 0)});" ></span>';
			}
			$showstr=$showstr.'<span class="others">';
			$showstr=$showstr.'<span class="createTime">'.datetime($row['cd_addtime']).'</span>';
			//if($row['cd_uid'] != $qianwei_in_userid){
				$showstr=$showstr.'<span><a class="reply" onclick="$call(function(){wallLib.replyWall('.$row['cd_id'].', 0, 0, 0, '.$row['cd_uid'].')});" href="javascript:;">回复</a></span>';
			//}
			$showstr=$showstr.'</span>';
			$showstr=$showstr.'</div>';
			$showstr=$showstr.'<div class="wI_text">'.$cd_content.'</div>';
			$showstr=$showstr.'</div>';
			$showstr=$showstr.'</div>';
			$showstr=$showstr.'<div id="wallComment'.$row['cd_id'].'">';

        		$query = $db->query("select * from ".tname('wall')." where cd_wallid='".$row['cd_id']."' order by cd_addtime desc LIMIT 0,100");
        		while ($rows = $db->fetch_array($query)) {
				$users = $db->getrow("select cd_nicheng,cd_checkmusic,cd_checkmm,cd_grade,cd_viprank from ".tname('user')." where cd_id='".$rows['cd_uid']."'");
				$cd_contents = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"emotImg\">", $rows['cd_content']);
				$showstr=$showstr.'<div class="wallComment">';
				$showstr=$showstr.'<div class="wallCommentItem" id="walls_'.$rows['cd_id'].'">';
				$showstr=$showstr.'<div class="wC_avatar"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'"><img class="avatar-38" src="'.getavatar($rows['cd_uid'],48).'"/></a></div>';
				$showstr=$showstr.'<div class="wC_top">';
				$showstr=$showstr.'<span class="nickname"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'">'.$users['cd_nicheng'].'</a>';
				$showstr=$showstr.CheckCertify($users['cd_checkmusic'],$users['cd_checkmm'],$users['cd_grade'],$users['cd_viprank']);
				$showstr=$showstr.'</span>';
				if($cd_uid == $qianwei_in_userid){
					$showstr=$showstr.'<span id="del-c'.$rows['cd_id'].'" class="del" title="删除" onclick="$call(function(){wallLib.doDelWall('.$cd_uid.', '.$row['cd_id'].', '.$rows['cd_id'].', 0)});"></span>';
				}
				$showstr=$showstr.'<span class="others">';
				$showstr=$showstr.'<span class="createTime">'.datetime($rows['cd_addtime']).'</span>';
				if($rows['cd_uid'] != $qianwei_in_userid){
					$showstr=$showstr.'<span><a href="javascript:;" onclick="$call(function(){wallLib.replyWall('.$row['cd_id'].', '.$rows['cd_id'].', '.$rows['cd_uid'].', \''.GetAlias("qianwei_user","cd_nicheng","cd_id",$rows['cd_uid']).'\', 0)});">回复</a></span>';
				}
				$showstr=$showstr.'</span>';
				$showstr=$showstr.'</div>';
				$showstr=$showstr.'<div class="wC_text">'.$cd_contents.'</div>';
				$showstr=$showstr.'</div>';
				$showstr=$showstr.'</div>';
				$showstr=$showstr.'<div id="exp"></div>';
			}

			$showstr=$showstr.'</div>';
			$showstr=$showstr.'<div id="wallCommentInputBox'.$row['cd_id'].'" class="wallCommentInputBox" style="display:none;">';
			$showstr=$showstr.'<div class="replayUser" id="replayUser_'.$row['cd_id'].'"></div>';
			$showstr=$showstr.'<div class="del" id="replayUserDel_'.$row['cd_id'].'" onclick="$call(function(){wallLib.delReplayUser('.$row['cd_id'].')});" title="取消对此人的回复"></div>';
			$showstr=$showstr.'<div class="wCI_input"><div id="wallCommentInput'.$row['cd_id'].'" contenteditable="true" class="wallCommentInput" name="wallCommentInput"></div></div>';
			$showstr=$showstr.'<div class="wCI_button"><span class="button-main"><span><button type="submit" id="wallcontSubmit" class="confirm" onclick="$call(function(){wallLib.confirmWall('.$row['cd_id'].', '.$cd_uid.')});">确认</button></span></span></div>';
			$showstr=$showstr.'<div class="wCI_cancel"><a class="cancel" href="javascript:;" onclick="$call(function(){wallLib.cancelWall('.$row['cd_id'].')});" >取消</a></div>';
			$showstr=$showstr.'<div id="wCI_message'.$row['cd_id'].'" class="wCI_message"></div>';
			$showstr=$showstr.'<div class="emot" id="emot_wallCommentInput'.$row['cd_id'].'"></div>';
			$showstr=$showstr.'</div>';
			$showstr=$showstr.'</div>';

		}
	}

	if($num>0){
		$showstr=$showstr.'<div class="page" id="page">';
		$showstr=$showstr.'<div class="pages">'.$Arr[0].'<input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;wallLib.moreWall('.$cd_uid.',val);return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/>';
		$showstr=$showstr.'<div id="currPage">1</div>';
		$showstr=$showstr.'</div>';
		$showstr=$showstr.'</div>';
	}

	echo $showstr;

function getajaxwallpage($mysql,$pagesize,$url,$pages){
	global $db;
	//$url = cd_upath.$qianwei_web_userid."/".$a;
	$pagesok=$pagesize;//每页显示记录数
	if (!isset($pages)||$pages==""||!is_numeric($pages)||$pages<=0){
		$pages=1;
	}
  	$sqlstr=$mysql;
  	$res=$db -> query($sqlstr);
 	$nums= $db -> num_rows($res);
	if($nums==0){$nums=1;}
  	$pagejs=ceil($nums/$pagesok);//总页数
	if($pages>$pagejs){
		$pages=$pagejs;
	}
  
	$sql=$sqlstr." LIMIT ".$pagesok*($pages-1).",".$pagesok;;
	$result = $db -> query($sql);

	//if($pagejs>1){

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
			$str.="<a href=\"javascript:;\" onclick=\"wallLib.moreWall(".$url.",".$pagejs.");\" class='last' title='最后一页'>...&nbsp;".$pagejs."-".$pages."</a>";
		}

	//}
	while ($row = $db -> fetch_array($result) ){}
	$arr=array($str,$result,$sql,$pagejs);
	return $arr;
}
?>
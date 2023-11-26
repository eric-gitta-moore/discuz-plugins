<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_id = SafeRequest("nid","post");
	$cd_currpage = SafeRequest("currPage","post");
	$cd_type = SafeRequest("type","post");
	$query = "select cd_id,cd_uid,cd_uids from ".tname('notice')." where cd_id='$cd_id'";
	if($row = $db->getrow($query)){
		$cd_uid = $row['cd_uids'];
		if($qianwei_in_userid == $row['cd_uids']){
			$db->query("delete from ".tname('notice')." where cd_id='".$row['cd_id']."'");

			$i=0;
			if($cd_type){
				$sql="select * from ".tname('notice')." where cd_uids='$qianwei_in_userid' and cd_icon='$cd_type' order by cd_addtime desc";
			}else{
				$sql="select * from ".tname('notice')." where cd_uids='$qianwei_in_userid' order by cd_addtime desc";
			}
			$Arr=getajaxwallpage($sql, 25, $cd_type, $cd_currpage);//sql,每页显示条数
			$result=$db->query($Arr[2]);
			$num=$db->num_rows($result);
			if($num==0){ echo '<div class="nothing">暂未收到任何通知!</div>'; }
			if($result){
				echo '<div class="Ignore02">';
				if($cd_type){
					echo '<span id="delall" onclick="messageLib.notificationAllDel('.$qianwei_in_userid.', \''.$cd_type.'\', \'\', \'delall\');">清空该类全部通知</span>';
					echo '<span class="no">|&nbsp;|</span>';
					echo '<span id="delall2" onclick="messageLib.notificationAllDel('.$qianwei_in_userid.', \''.$cd_type.'\', \'month\', \'delall2\');">删除该类一个月前通知</span>';
				}else{
					echo '<span id="delall" onclick="messageLib.notificationAllDel('.$qianwei_in_userid.', \'\', \'\', \'delall\');">清空全部通知</span>';
					echo '<span class="no">|&nbsp;|</span>';
					echo '<span id="delall2" onclick="messageLib.notificationAllDel('.$qianwei_in_userid.', \'\', \'month\', \'delall2\');">删除一个月前通知</span>';
				}
				echo '</div>';
				echo '<div class="notification">';
				echo '<ul>';
				while ($row = $db ->fetch_array($result)){
					$a=$a+1;
					$user = $db->getrow("select cd_nicheng from ".tname('user')." where cd_id='".$row['cd_uid']."'");
					echo '<li>';
					echo '<span class="icon_mini_'.$row['cd_icon'].'"></span>';
					echo '<span class="content"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'" target="_blank">'.$user['cd_nicheng'].'</a>&nbsp;'.$row['cd_data'].'&nbsp;</span>';
					echo '<span id="'.$row['cd_id'].'" class="ndel" title="删除"></span>';
					echo '<span class="mtime">'.datetime($row['cd_addtime']).'</span>';
					echo '</li>';
				}
				echo '</ul>';
				echo '</div>';
			}

			if($num>0){
				echo '<div class="page">';
				?>
				<div class="pages"><?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href='<?php echo cd_upath; ?>index.php?p=message&a=notification&type=<?php echo $cd_type; ?>&pages='+val+'';return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/>
				<?php
				echo '<div id="currPage">'.$cd_currpage.'</div>';
				echo '</div>';
				echo '</div>';
			}
			echo '<script type="text/javascript">messageLib.notificationDelInit();</script>';

		}else{
			exit('20002');
		}
	}else{
		exit('10004');
	}
}else{
	exit('20001');
}

function getajaxwallpage($mysql,$pagesize,$type,$pages){
	global $db;
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
			$str.="<a href='".cd_upath."index.php?p=message&a=notification&type=".$type."&pages=1' class='last' title='首页'>1&nbsp;...</a>";
		}
		if($pages>1){
			$str.="<a href='".cd_upath."index.php?p=message&a=notification&type=".$type."&pages=".($pages-1)."' class='prev' title='上一页'>&laquo;</a>";
		}
		if($pagejs<=6){
  			for($i=1;$i<=$pagejs;$i++){
   				if($i==$pages){
   					$str.="<strong title='第".$i."页'>".$i."</strong>";
   				}else{
   					$str.="<a href='".cd_upath."index.php?p=message&a=notification&type=".$type."&pages=".$i."'>".$i."</a>";
   				}
 	 		}
		}else{
 			if($pages>=8){
 				for($i=$pages-3;$i<=$pages+4;$i++){
   					if($i<=$pagejs){
   				        	if($i==$pages){
   							$str.="<strong title='第".$i."页'>".$i."</strong>";
   				        	}else{
   							$str.="<a href='".cd_upath."index.php?p=message&a=notification&type=".$type."&pages=".$i."'>".$i."</a>";
   				        	}
    					}
  				}
   			}else{
  				for($i=1;$i<=8;$i++){
   					if($i==$pages){
   						$str.="<strong title='第".$i."页'>".$i."</strong>";
   					}else{
   						$str.="<a href='".cd_upath."index.php?p=message&a=notification&type=".$type."&pages=".$i."'>".$i."</a>";
   					}
 				} 
 		 	}
		}
		if($pages<$pagejs){
			$str.="<a href='".cd_upath."index.php?p=message&a=notification&type=".$type."&pages=".($pages+1)."' class='next' title='下一页'>&raquo;</a>";
		}
		if($pages<$pagejs-2){
			$str.="<a href='".cd_upath."index.php?p=message&a=notification&type=".$type."&pages=".$pagejs."' class='last' title='最后一页'>...&nbsp;".$pagejs."</a>";
		}

	//}
	while ($row = $db -> fetch_array($result) ){}
	$arr=array($str,$result,$sql,$pagejs);
	return $arr;
}
?>
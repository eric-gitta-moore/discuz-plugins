<?php
	include "../source/global/global_inc.php";
	$cd_id = SafeRequest("cd_id","post");
	$cd_type = SafeRequest("cd_type","post");
        global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$sql="select * from ".tname('pay')." where cd_id='$cd_id'";
		if($row=$db->getrow($sql)){
			$cd_orderid = date("YmdHis").rand(1000, 9999);
			$cd_name = $row['cd_name'];
			$cd_money = $row['cd_money'];
			//$db->query("delete from ".tname('paylog')." where cd_uid='$qianwei_in_userid' and cd_lock=1");
			//产生订单记录
			$setarr = array(
				'cd_type' => $row['cd_type'],
				'cd_uid' => $qianwei_in_userid,
				'cd_uname' => $qianwei_in_username,
				'cd_title' => $cd_orderid,
				'cd_points' => $row['cd_points'],
				'cd_money' => $row['cd_money'],
				'cd_lock' => 1,
				'cd_dataid' => $cd_id,
				'cd_addtime' => time()
			);
			inserttable('paylog', $setarr, 1);
		}
		switch($cd_type){
			case '1':
				include "source/alipay/alipay_pay.php";
				break;
		}
	}else{
		include "source/module/user/login.php";
	}
?>
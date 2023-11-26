<?php
require_once("../../../source/global/global_conn.php");
require_once("alipay.config.php");
require_once("alipay_notify.class.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?php
$alipayNotify = new AlipayNotify($aliapy_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {
	$dingdan	= $_GET['out_trade_no'];
	$trade_no	= $_GET['trade_no'];
	$total_fee	= $_GET['price'];
	if($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS' || $_GET['trade_status'] == 'TRADE_FINISHED') {
		global $db;
		$result=$db->query("select * from ".tname('paylog')." where cd_title='".$dingdan."' and cd_lock=1");
		if($row=$db->fetch_array($result)){
			$cd_type = $row["cd_type"];
			$cd_uid = $row["cd_uid"];
			$cd_uname = $row["cd_uname"];
			$cd_points = $row["cd_points"];
			$cd_vipgrade = $row["cd_vipgrade"];
			if($cd_type){
				if($cd_points>=360){
					$cd_vipgrade = '2';
				}else{
					$cd_vipgrade = '1';
				}
				$cd_viptime = $cd_points;
				$cd_vipindate = date('Y-m-d H:i:s');
				$tomorrow = mktime(date("H"), date("i"), date("s"), date("m"), date("d")+$cd_viptime, date("Y"));
				$cd_vipenddate = date("Y-m-d H:i:s",$tomorrow);
				$db->query("update ".tname('user')." set cd_grade=1,cd_vipgrade=".$cd_vipgrade.",cd_vipindate='".$cd_vipindate."',cd_vipenddate='".$cd_vipenddate."' where cd_id=".$cd_uid);
    				$trade_statuss = "恭喜您，成功购买 ".$cd_points." 天VIP会员";
			}else{
				$db->query("update ".tname('user')." set cd_points=cd_points+".$cd_points." where cd_id=".$cd_uid);
    				$trade_statuss = "恭喜您，成功购买 ".$cd_points." 个金币";
			}
			$db->query("update ".tname('paylog')." set cd_lock=0 where cd_title='".$dingdan."' and cd_uid=".$cd_uid);
		}else{
    			$trade_statuss = "非法操作，请勿刷新此页。";
		}
	} else {
    		$trade_statuss = "支付失败，请将以上信息复制给管理员1。";
	}
}else {
    	$trade_statuss = "支付失败，请将以上信息复制给管理员，QQ:".cd_webqq."。";
}
?>
        <title>支付宝即时支付</title>
        <style type="text/css">
            .font_content{
                font-family:"宋体";
                font-size:14px;
                color:#FF6600;
            }
            .font_title{
                font-family:"宋体";
                font-size:16px;
                color:#FF0000;
                font-weight:bold;
            }
            table{
                border: 1px solid #CCCCCC;
            }
        </style>
    </head>
    <body>
        <table align="center" width="600" cellpadding="5" cellspacing="0">
            <tr>
                <td align="center" class="font_title" colspan="2">通知返回</td>
            </tr>
            <tr>
                <td class="font_content" align="right">支付宝交易号：</td>
                <td class="font_content" align="left"><?php echo $_GET['trade_no']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">订单号：</td>
                <td class="font_content" align="left"><?php echo $_GET['out_trade_no']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">付款总金额：</td>
                <td class="font_content" align="left"><?php echo $_GET['total_fee']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">商品标题：</td>
                <td class="font_content" align="left"><?php echo $_GET['subject']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">商品描述：</td>
                <td class="font_content" align="left"><?php echo $_GET['body']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">买家账号：</td>
                <td class="font_content" align="left"><?php echo $_GET['buyer_email']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">交易状态：</td>
                <td class="font_title" align="left"><?php echo $trade_statuss; ?></td>
            </tr>
        </table>
    </body>
</html>
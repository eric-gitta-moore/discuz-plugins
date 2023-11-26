<?php
require_once("../../../source/global/global_conn.php");
require_once("alipay.config.php");
require_once("alipay_notify.class.php");
$alipayNotify = new AlipayNotify($aliapy_config);
$verify_result = $alipayNotify->verifyNotify();
if($verify_result) {
    $out_trade_no	= $_POST['out_trade_no'];
    $trade_no		= $_POST['trade_no'];
    $total			= $_POST['price'];
	if($_POST['trade_status'] == 'WAIT_BUYER_PAY') {
        echo "success";
    }
	else if($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
        echo "success";
    }
	else if($_POST['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS') {
			
        echo "success";
    }
	else if($_POST['trade_status'] == 'TRADE_FINISHED') {
        echo "success";
    }
    else {
        echo "success";
    }
}
else {
    echo "fail";
}
?>
<?php
require_once("source/alipay/alipay.config.php");
require_once("source/alipay/alipay_service.class.php");
$out_trade_no		= trim($cd_orderid);
$subject		= $cd_name;
$body			= $cd_name;
$price			= trim($cd_money);
$logistics_fee		= "0.00";
$logistics_type		= "EXPRESS";
$logistics_payment	= "SELLER_PAY";
$quantity		= "1";
$receive_name		= "收货人姓名";
$receive_address	= "收货人地址";
$receive_zip		= "123456";
$receive_phone		= "0571-81234567";
$receive_mobile		= "13312341234";
$show_url		= "http://".cd_weburl;
$parameter = array(
		"service"		=> "trade_create_by_buyer",
		"payment_type"	=> "1",
		"partner"		=> trim($aliapy_config['partner']),
		"_input_charset"=> trim(strtolower($aliapy_config['input_charset'])),
		"seller_email"	=> trim($aliapy_config['seller_email']),
		"return_url"	=> trim($aliapy_config['return_url']),
		"notify_url"	=> trim($aliapy_config['notify_url']),
		"out_trade_no"	=> $out_trade_no,
		"subject"		=> $subject,
		"body"			=> $body,
		"price"			=> $price,
		"quantity"		=> $quantity,
		"logistics_fee"		=> $logistics_fee,
		"logistics_type"	=> $logistics_type,
		"logistics_payment"	=> $logistics_payment,
		"receive_name"		=> $receive_name,
		"receive_address"	=> $receive_address,
		"receive_zip"		=> $receive_zip,
		"receive_phone"		=> $receive_phone,
		"receive_mobile"	=> $receive_mobile,
		"show_url"		=> $show_url
);
$alipayService = new AlipayService($aliapy_config);
$html_text = $alipayService->trade_create_by_buyer($parameter);
echo $html_text;
?>
<html>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<TITLE></TITLE>
</HEAD>
<body></body>
</html>
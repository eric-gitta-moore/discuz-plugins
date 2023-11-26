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
    				$trade_statuss = "��ϲ�����ɹ����� ".$cd_points." ��VIP��Ա";
			}else{
				$db->query("update ".tname('user')." set cd_points=cd_points+".$cd_points." where cd_id=".$cd_uid);
    				$trade_statuss = "��ϲ�����ɹ����� ".$cd_points." �����";
			}
			$db->query("update ".tname('paylog')." set cd_lock=0 where cd_title='".$dingdan."' and cd_uid=".$cd_uid);
		}else{
    			$trade_statuss = "�Ƿ�����������ˢ�´�ҳ��";
		}
	} else {
    		$trade_statuss = "֧��ʧ�ܣ��뽫������Ϣ���Ƹ�����Ա1��";
	}
}else {
    	$trade_statuss = "֧��ʧ�ܣ��뽫������Ϣ���Ƹ�����Ա��QQ:".cd_webqq."��";
}
?>
        <title>֧������ʱ֧��</title>
        <style type="text/css">
            .font_content{
                font-family:"����";
                font-size:14px;
                color:#FF6600;
            }
            .font_title{
                font-family:"����";
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
                <td align="center" class="font_title" colspan="2">֪ͨ����</td>
            </tr>
            <tr>
                <td class="font_content" align="right">֧�������׺ţ�</td>
                <td class="font_content" align="left"><?php echo $_GET['trade_no']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">�����ţ�</td>
                <td class="font_content" align="left"><?php echo $_GET['out_trade_no']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">�����ܽ�</td>
                <td class="font_content" align="left"><?php echo $_GET['total_fee']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">��Ʒ���⣺</td>
                <td class="font_content" align="left"><?php echo $_GET['subject']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">��Ʒ������</td>
                <td class="font_content" align="left"><?php echo $_GET['body']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">����˺ţ�</td>
                <td class="font_content" align="left"><?php echo $_GET['buyer_email']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">����״̬��</td>
                <td class="font_title" align="left"><?php echo $trade_statuss; ?></td>
            </tr>
        </table>
    </body>
</html>
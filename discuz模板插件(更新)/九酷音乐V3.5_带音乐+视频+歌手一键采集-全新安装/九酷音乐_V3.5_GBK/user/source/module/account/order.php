<?php
	include "../source/global/global_inc.php";
        global $db,$qianwei_in_userid;
	if(!$qianwei_in_userid){exit("20001");}
	$cd_pid = SafeRequest("pid","post");
	$sql="select * from ".tname('pay')." where cd_id='$cd_pid'";
	if($row=$db->getrow($sql)){
?>
	<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
		<form method="post" name="frmadd" action="<?php echo cd_upath; ?>index.php?p=account&a=send" target="_blank">
		<input name="cd_id" type="hidden" value="<?php echo $cd_pid; ?>">
		<tr style="background:#C5DCEF;">
			<td colspan="2" height="30" align="left">&nbsp;����ȷ��</td>
		</tr>

		<tr height="30">
			<td width="100">��Ʒ���ͣ�</td>
			<td>
			<table cellspacing='0' cellpadding='0' width='100%'>
					<tr>
						<td align='left'><p><strong><?php if($row['cd_type'] == 0){?>��ֵ���<?php }else{ ?>����VIP<?php } ?></strong></p></td>
					</tr>
			</table>
			</td>
		</tr>

		<tr height="30">
			<td width="100">��Ʒ���ƣ�</td>
			<td>
			<table cellspacing='0' cellpadding='0' width='100%'>
					<tr>
						<td align='left'><p><strong><?php echo $row['cd_name']; ?></strong></p></td>
					</tr>
			</table>
			</td>
		</tr>

		<tr height="30">
			<td width="100">��Ʒ�۸�</td>
			<td>
			<table cellspacing='0' cellpadding='0' width='100%'>
					<tr>
						<td align='left'><p><strong><?php echo $row['cd_money']; ?> Ԫ</strong></p></td>
					</tr>
			</table>
			</td>
		</tr>

		<tr height="30">
			<td width="100">֧���û���</td>
			<td>
			<table cellspacing='0' cellpadding='0' width='100%'>
					<tr>
						<td align='left'><p><strong><?php echo $qianwei_in_username; ?>(<?php echo $qianwei_in_nicheng; ?>)</strong></p></td>
					</tr>
			</table>
			</td>
		</tr>
		<tr height="55">
			<td width="100">֧����ʽ��</td>
			<td>
			<table cellspacing='0' cellpadding='0' width='100%'>
					<tr>
						<td align='left'>
						<label for="cd_type1"><input id="cd_type1" name="cd_type" type="radio" value="1" />              
						<img src="<?php echo cd_upath; ?>static/images/pay/alipay.gif" style="cursor:hand;" width="88" height="31" align="absmiddle" disabled /></label>
						</td>
					</tr>
			</table>
			</td>
		</tr>
		</form>
	</table>
	<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr bgcolor="#E6F5FF">
			<td width="100" height="50" align="right"><font color="red">�ر�ע�⣺</font></TD>
			<td height="30" align="left"><font color="red">1.֧��ǰ�Ȱ�����������ص������ܹرգ����ܻ�Ӱ��֧��ϵͳ��</font><br /><font color="red">2.֧����ɺ����ȴ�ҳ����ת����ʾ��ֵ�ɹ�����ܹر��������</font></td>
		</tr>
	</table>
<?php }else{ ?>
	10004
<?php } ?>
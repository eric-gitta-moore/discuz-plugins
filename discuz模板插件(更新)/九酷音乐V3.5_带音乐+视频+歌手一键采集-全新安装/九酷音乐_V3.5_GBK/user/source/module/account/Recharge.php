<?php
	include "../source/global/global_inc.php";
        global $db,$qianwei_in_userid;
	if(!$qianwei_in_userid){exit("20001");}
?>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr style="background:#C5DCEF;">
		<td width="45" align="center">ѡ��</td>
		<td>
			<table cellspacing="0" cellpadding="0" width="100%" height="35">
				<tr>
					<td align="left">����</td>
					<td width="100" align="center">����۸�</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php
        	$query = $db->query("select * from ".tname('pay')." order by cd_id asc");
        	while ($row = $db->fetch_array($query)) {
			echo "<tr height='30'>";
			echo "<td align='center'><input type='radio' id='pid".$row['cd_id']."' name='pid' value='".$row['cd_id']."'></td>";
			echo "<td>";
			echo "<table cellspacing='0' cellpadding='0' width='100%'>";
			echo "<tr>";
			echo "<td align='left'><p><strong><label for='pid".$row['cd_id']."'>".$row['cd_name']."</label></strong></p></td>";
			echo "<td width='100' align='center'>".$row['cd_money'].".00 Ԫ</td>";
			echo "</tr>";
			echo "</table>";
			echo "</td>";
			echo "</tr>";
		}
	?>
</table>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr bgcolor="#E6F5FF">
		<td height="50" align="left"><div align="right">����˵����</div></TD>
		<td height="30" align="left">VIP��Ա�Ǳ�վ�û���һ�ּ���Ȩ�����֣�ӵ�иü�����û���������ʱ���۱�<br>����VIP��Աר�õĸ������ط�����ͨ������������������ȫվ����MP3���֡�</TD>
	</tr>
</table>
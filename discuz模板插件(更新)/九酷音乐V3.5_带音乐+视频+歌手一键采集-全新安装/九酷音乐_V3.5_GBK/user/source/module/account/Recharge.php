<?php
	include "../source/global/global_inc.php";
        global $db,$qianwei_in_userid;
	if(!$qianwei_in_userid){exit("20001");}
?>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr style="background:#C5DCEF;">
		<td width="45" align="center">选择</td>
		<td>
			<table cellspacing="0" cellpadding="0" width="100%" height="35">
				<tr>
					<td align="left">类型</td>
					<td width="100" align="center">购买价格</td>
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
			echo "<td width='100' align='center'>".$row['cd_money'].".00 元</td>";
			echo "</tr>";
			echo "</table>";
			echo "</td>";
			echo "</tr>";
		}
	?>
</table>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr bgcolor="#E6F5FF">
		<td height="50" align="left"><div align="right">升级说明：</div></TD>
		<td height="30" align="left">VIP会员是本站用户的一种级别权限区分，拥有该级别的用户下载音乐时不扣币<br>享受VIP会员专用的高速下载服务器通道、不限量任意下载全站所有MP3音乐。</TD>
	</tr>
</table>
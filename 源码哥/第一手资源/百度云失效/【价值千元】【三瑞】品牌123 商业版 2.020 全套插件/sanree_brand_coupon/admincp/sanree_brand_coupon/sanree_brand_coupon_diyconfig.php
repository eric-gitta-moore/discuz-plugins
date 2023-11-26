<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_coupon_diyconfig.php $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$do = $_G['sr_do'];
$doarray = array('list', 'fixbranddiy');
$do = !in_array($do,$doarray) ? 'list' : $do;
$_G['sr_page'] = isset($_G['sr_page']) ? $_G['sr_page'] : 0;

if ($do == 'fixbranddiy') {

	$entrydir = DISCUZ_ROOT.'source/plugin/sanree_brand_coupon/block/sanree';
	$blocksanreedir = DISCUZ_ROOT.'source/class/block/sanree';
	$target=$blocksanreedir ."/blockclass.php";
	$res = @mkdir($blocksanreedir, 0777);
	if(!file_exists($target)) {
		$source=$entrydir."/blockclass.php";	
		@copy($source, $target);
	}
	$target=$blocksanreedir ."/block_brand_coupon.php";
	if(file_exists($target)){
	  @unlink($target);
	}			
	if(!file_exists($target)) {
		$source=$entrydir."/block_brand_coupon.php";
		@copy($source, $target);
	}
	coupon_diytemplate();	
	coupon_diystyle();	
	cpmsg($langs['blockstyle_create_succeed'], 'action=plugins&operation=config&identifier=sanree_brand_coupon&pmod=admincp&act=diyconfig', 'succeed');	
	
}
elseif ($do == 'list') {

		showsubmenu($menustr);
		
		showtableheader('', 'nobottom');		
		showtablerow('', array(), 
		array(
			'<ul class="tab1">'.
			'<li class="current"><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=diyconfig&identifier=sanree_brand_coupon&pmod=admincp"><span>'.$langs['diyconfig'].'</span></a></li>'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=diytemplate&identifier=sanree_brand_coupon&pmod=admincp"><span>'.$langs['diytemplate'].'</span></a></li>'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=diystyle&identifier=sanree_brand_coupon&pmod=admincp"><span>'.$langs['diystyle'].'</span></a></li>'.
			'</ul>'
		));
		showtablefooter();
	showtableheader($langs['admincon'], 'nobottom', 'style="border:1px solid #cccccc"');		
	?>
	<script language="javascript">disallowfloat = 'newthread';</script>
		<script language="javascript">
		function fixbranddiy(){
			if(confirm('<?php echo $langs['fixdiytip'];?>'))
			{
				location.href= '<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=diyconfig&do=fixbranddiy&identifier=sanree_brand_coupon&pmod=admincp';
			}
		}		
		</script><tr>
    <td><?php echo '<input onclick="fixbranddiy();" type="button" class="btn" id="submit_fixbranddiy" name="fixbranddiysubmit" value="'.$langs['fixbranddiy'].'" />';?>
	</td>
    <td>&nbsp;</td>
  </tr>
	<?php
	showtablefooter();
	
}
//From:www_YMG6_COM
?>
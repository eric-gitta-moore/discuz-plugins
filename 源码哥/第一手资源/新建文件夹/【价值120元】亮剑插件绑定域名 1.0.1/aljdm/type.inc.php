<?php

/*
 * 作者: Discuz!亮剑工作室
 * 技术支持: http://www.dzx30.com
 * 客服QQ: 190360183
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$act = $_GET['act'];
if($act == 'del' && $_GET['formhash'] == FORMHASH) {
	$tid = intval($_GET['tid']);
	if($tid) {
		if($_G ['setting']['version'] == 'X3.2'){
			$record = C::t('#aljdm#aljdm_type') -> fetch($tid);
			$plugin = C::t('common_plugin')->fetch_by_identifier($record['bindlink']);
			C::t('common_domain')->delete_by_id_idtype($plugin['pluginid'], 'plugin');
		}
		C::t('#aljdm#aljdm_type')->delete($tid);
	}
	cpmsg("&#21024;&#38500;&#25104;&#21151;&#65281;", 'action=plugins&operation=config&identifier=aljdm&pmod=type', 'succeed');	
}

if(!submitcheck('editsubmit')) {	

?>
<table id="tips" class="tb tb2 ">
<tbody><tr><th class="partition">&#25216;&#24039;&#25552;&#31034;</th></tr>
<tr><td s="1" class="tipsblock"><ul id="tipslis">
<li>&#25554;&#20214;&#26631;&#35782;&#31526;&#35831;&#25353;&#29031;&#22914;&#19979;&#26684;&#24335;&#36827;&#34892;&#22635;&#20889;&#40;&#21697;&#29260;&#21830;&#23478;&#22635;&#20889;&#97;&#108;&#106;&#98;&#100;&#32;&#20108;&#25163;&#24066;&#22330;&#22635;&#20889;&#97;&#108;&#106;&#101;&#115;&#32;&#27714;&#32844;&#25307;&#32856;&#22635;&#20889;&#97;&#108;&#106;&#122;&#112;&#32;&#25151;&#23627;&#20986;&#31199;&#22635;&#20889;&#97;&#108;&#106;&#108;&#112;&#32;&#20108;&#25163;&#25151;&#22635;&#20889;&#97;&#108;&#106;&#101;&#115;&#102;&#22242;&#36141;&#22635;&#20889;&#97;&#108;&#106;&#116;&#103;&#41;</li>
<li>&#22495;&#21517;&#38656;&#35201;&#35299;&#26512;&#21040;&#35770;&#22363;&#65292;&#24182;&#33021;&#27491;&#24120;&#35775;&#38382;&#65292;&#37197;&#32622;&#21518;&#25165;&#20250;&#29983;&#25928;&#65292;&#22914;&#36824;&#26377;&#30097;&#38382;&#65292;&#35831;&#32852;&#31995;&#20142;&#21073;&#25216;&#26415;&#81;&#81;&#50;&#56;&#49;&#48;&#57;&#55;&#49;&#56;&#48;&#21327;&#21161;&#37197;&#32622;</li>
<li>&#22495;&#21517;&#35831;&#25353;&#119;&#119;&#119;&#12289;&#98;&#98;&#115;&#36825;&#26679;&#30340;&#26684;&#24335;&#22635;&#20889;&#65292;&#26681;&#22495;&#21517;&#35831;&#25353;&#100;&#122;&#120;&#51;&#48;&#46;&#99;&#111;&#109;&#36825;&#26679;&#30340;&#26684;&#24335;&#22635;&#20889;</li>
</ul></td></tr></tbody>
</table>
<script type="text/JavaScript">
var rowtypedata = [
	[[1,'<input type="text" class="txt" name="newcatorder[]" value="" />', 'td25'], [1, '<input style="width:180px;" name="newcat[]" value="" type="text" class="txt" />'], [2, '<input style="width:380px;" name="newbindlink[]" value="" type="text" class="txt" />']],
	];

function del(id) {
	if(confirm('<?php echo lang('plugin/aljdm','do6');?>')) {
		window.location = '<?php echo ADMINSCRIPT;?>?action=plugins&operation=config&identifier=aljdm&pmod=type&act=del&formhash=<?php echo FORMHASH;?>&tid='+id;
	} else {
		return false;
	}
}
</script>
<?php
	showformheader('plugins&operation=config&do='.$_GET['do'].'&identifier=aljdm&pmod=type');
	showtableheader('');
	showsubtitle(array("&#22495;&#21517;","&#26681;&#22495;&#21517;","&#25554;&#20214;&#26631;&#35782;&#31526;","&#25805;&#20316;"));

	$typelist = C::t('#aljdm#aljdm_type')->fetch_all_by_upid(0);
	foreach($typelist as $key=>$value){

		$bt = C::t('#aljdm#aljdm_type')->fetch_all_by_upid($key);
		foreach($bt as $k=>$v){
			$typelist[$key]['subtype'][$k] = $v;
		}
	}
	if($typelist) {
		foreach($typelist as $id=>$type) {
			$show = '<tr class="hover"><td class="td25"><input type="text" class="txt" name="order['.$id.']" value="'.$type['displayorder'].'" /></td><td><div class="parentboard"><input style="width:180px;" type="text" class="txt" name="name['.$id.']" value="'.$type['subject'].'"/></div><td><input type="text"  name="bindlink['.$id.']" value="'.$type['bindlink'].'"  style="width:380px;" /></td>';
			if(!$type['subid']) {
				$show .= '<td><a  onclick="del('.$id.')" href="###">'."&#21024;&#38500;".'</td></tr>';
			} else {
				$show .= '<td>&nbsp;</td></tr>';
			}
			echo $show;
		}	
	}
	echo '<tr class="hover"><td class="td25">&nbsp;</td><td colspan="2" ><div><a href="###" onclick="addrow(this, 0)" class="addtr">'."&#28155;&#21152;&#26032;&#22495;&#21517;".'</a></div></td></tr>';
	

	showsubmit('editsubmit');
	showtablefooter();
	showformfooter();

} else {
	$order = $_GET['order'];
	$name = $_GET['name'];
	$bindlink = $_GET['bindlink'];
	$newbindlink = $_GET['newbindlink'];
	$newcat = $_GET['newcat'];
	$newcatorder = $_GET['newcatorder'];
	if(is_array($order)) {
		foreach($order as $id=>$value) {
			C::t('#aljdm#aljdm_type')->update($id,array('displayorder'=>$value,'subject'=>$name[$id], 'bindlink' => trim($bindlink[$id])));
			if($_G ['setting']['version'] == 'X3.2'){
				domain_create(trim($bindlink[$id]),$value,$name[$id]);
			}
		}
	}

	if(is_array($newcat)) {
		foreach($newcat as $key=>$name) {
			if(empty($name)) {
				continue;
			}
			$cid=C::t('#aljdm#aljdm_type')->insert(array('upid' => '0', 'subject' => $name, 'bindlink' => trim($newbindlink[$key]), 'displayorder' => $newcatorder[$key]),1);
			if($_G ['setting']['version'] == 'X3.2'){
				domain_create(trim($newbindlink[$key]),$newcatorder[$key],$name);
			}
		}
	}
	require_once './source/function/function_cache.php';
	$aljdm = C::t('#aljdm#aljdm_type') -> range();
	writetocache('aljdm', getcachevars(array('aljdm' => $aljdm))); 

	
	cpmsg("&#26356;&#26032;&#25104;&#21151;&#65281;", 'action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljdm&pmod=type', 'succeed');	
}

?>



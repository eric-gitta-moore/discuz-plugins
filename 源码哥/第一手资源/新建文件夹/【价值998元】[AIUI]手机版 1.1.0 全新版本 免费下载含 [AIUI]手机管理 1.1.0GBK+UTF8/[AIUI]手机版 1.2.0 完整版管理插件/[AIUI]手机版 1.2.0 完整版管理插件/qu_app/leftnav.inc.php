<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

cpheader();
loadcache('plugin');
$langvars = $scriptlang['qu_app'];

if(submitcheck('leftnav_submit')){

	if(is_array($_POST['delete'])) {
		if($deleteids = dimplode($_POST['delete'])) {
			DB::query("DELETE FROM ".DB::table('qu_appnav')." WHERE id IN ($deleteids)");
		}
	}

	if(is_array($_POST['title']) && $_POST['title']) {
		
		foreach($_POST['title'] as $key => $val) {
			DB::update('qu_appnav', array(
				'displayorder' => intval($_POST['displayorder'][$key]),
				'title' => dhtmlspecialchars($val),
				'pic' => dhtmlspecialchars($_POST['pic'][$key]),
				'color' => dhtmlspecialchars($_POST['color'][$key]),
				'url' => dhtmlspecialchars($_POST['url'][$key]),
				'disable' => intval($_POST['disable'][$key])
			), "id='$key'");
		}
	}
	
	if(is_array($_POST['titlenew'])) {
		foreach($_POST['titlenew'] as $key => $val) {
			$data = array(
				'displayorder' => intval($_POST['displayordernew'][$key]),
				'title' => dhtmlspecialchars($val),
				'pic' => dhtmlspecialchars($_POST['picnew'][$key]),
				'color' => dhtmlspecialchars($_POST['colornew'][$key]),
				'url' => dhtmlspecialchars($_POST['urlnew'][$key]),
				'disable' => intval($_POST['disable'][$key])
			);
			DB::insert('qu_appnav', $data);
		}
	}
	$_G['cache']['ainuodata'] = '';
	savecache('ainuodata', $_G['cache']['ainuodata']);
	cpmsg('plugins_setting_succeed', 'action=plugins&operation=config&do='.$pluginid.'&identifier=qu_app&pmod=leftnav', 'succeed');
}else{
	echo '<link rel="stylesheet" href="template/qu_app/touch/style/font/iconfont.css">';
	showtips($langvars['nav_tips']);
		
	$page = intval($_G['page']);
	if(empty($page)){
		$page = 1;
	}
	$perpage = 20;
	$start_limit = ($page-1)*$perpage;
	$total_num = DB::result_first("SELECT count(*) FROM ".DB::table('qu_appnav')." WHERE 1 $add_sql");
	$pageurl = 'action=plugins&operation=config&do='.$pluginid.'&identifier=qu_app&pmod=leftnav'.$add_page;
	$multipage = multi($total_num,$perpage,$page,"$pageurl",100);
	
	$floors = '';
	$query = DB::query("SELECT * FROM ".DB::table('qu_appnav')." WHERE 1 $add_sql ORDER BY displayorder ASC,id ASC LIMIT $start_limit,$perpage");
	while($result = DB::fetch($query)) {
		$floors .= showtablerow('', array('class="td25"', 'class="td25"','class="td23"', 'class="td23"', '','class="td25"','class="td23"'), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$result[id]\">",
			"<input type=\"text\" class=\"txt\" size=\"2\" name=\"displayorder[$result[id]]\" value=\"$result[displayorder]\">",
			"<input type=\"text\" class=\"txt\" name=\"title[$result[id]]\" style=\"width:100px\" value=\"".$result['title']."\">",
			"<input type=\"text\" class=\"txt\" name=\"pic[$result[id]]\" style=\"width:100px\" value=\"".$result['pic']."\">",
			"<input type=\"color\" class=\"txt\" name=\"color[$result[id]]\" style=\"width:60px\" value=\"".$result['color']."\">",
			"<input type=\"text\" class=\"txt\" name=\"url[$result[id]]\" style=\"width:400px\" value=\"".$result['url']."\">",
			"<input type=\"checkbox\" class=\"checkbox\" size=\"2\" name=\"disable[$result[id]]\" value=\"1\" ".($result['disable'] ? 'checked' : '').">",
			"<i style=\"font-size:18px\" class=\"iconfont icon-".$result['pic']."\"></i>"
		), TRUE);
	}
	echo '
	<script type="text/JavaScript">
	var rowtypedata = [
	[
	[1, \'<input class="checkbox" type="checkbox" name="delete[]" value="">\', \'td25\'],
	[1, \'<input type="text" class="txt" name="displayordernew[]" size="2" value="">\', \'td25\'],
	[1, \'<input type="text" class="txt" name="titlenew[]" style=\"width:100px\" value="">\', \'td23\'],
	[1, \'<input type="text" class="txt" name="picnew[]" style=\"width:100px\" value="">\', \'td23\'],
	[1, \'<input type="color" class="txt" name="colornew[]" style=\"width:60px\" value="">\', \'td23\'],
	[1, \'<input type="text" class="txt" name="urlnew[]" style=\"width:400px\" value="">\', \'\'],
	[1, \'<input type="checkbox" class="checkbox" name="disablenew[]" size="2" value="">\', \'td23\'],
	],
	];
	</script>
	';
	showformheader('plugins&operation=config&do='.$pluginid.'&identifier=qu_app&pmod=leftnav');
	showtableheader();
	showtitle($langvars['nav_setting']);
	showsubtitle(array($langvars['nav_del'], $langvars['nav_order'], $langvars['nav_title'],$langvars['nav_pic'],$langvars['nav_color'], $langvars['nav_url'],$langvars['nav_disable'],$langvars['nav_preview']));
	echo $floors;
	echo '<tr><td class="td25"></td><td colspan="11"><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.$langvars['nav_add_new'].'</a></div></td>';
	echo '<input type="hidden" name="hid" value="'.$id.'" />';
	showsubmit('','','','<input type="submit" class="btn" name="leftnav_submit" value="'.cplang('submit').'" />',$multipage);
	showtablefooter();
	showformfooter();

}

?>
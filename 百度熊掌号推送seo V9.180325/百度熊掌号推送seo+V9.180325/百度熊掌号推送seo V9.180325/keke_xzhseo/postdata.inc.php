<?php
if (! defined ('IN_DISCUZ')) {
	exit ('Access Denied');
}

include_once DISCUZ_ROOT."source/plugin/keke_xzhseo/keke_xzhseo.class.php";
if($_GET['sd']){
	$postdata=C::t('#keke_xzhseo#keke_xzhseo')->fetchfirst_byatid(intval($_GET['atid']),intval($_GET['mods']));
	if($postdata['state']==1){
		$tips=lang('plugin/keke_xzhseo', '027');
		if('utf-8' != CHARSET) {
			$tips = diconv($tips, CHARSET, 'utf-8');
		}
		exit(json_encode(array('state'=>9,'msg'=>$tips)));
	}
}
exit(plugin_keke_xzhseo::_posttobaidu(intval($_GET['atid']),intval($_GET['mods']),intval($_GET['type'])));
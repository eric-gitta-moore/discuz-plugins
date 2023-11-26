<?php
function checkFavGroup($fid){
	global $_G;
    if(!$_G['uid']) return false;
    $results = C::t('home_favorite')->fetch_all_by_uid_idtype($_G['uid'],'gid');
    $fids = array();
    foreach($results as $group){
    	$fids[] = $group['id'];
    }
    return in_array($fid,$fids)?true:false;
}
?>
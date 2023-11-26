<?php
function checkGroupJoin($fid){
	global $_G;
    if(!$_G['uid']) return false;
    $fids = C::t('forum_groupuser')->fetch_all_fid_by_uids($_G['uid']);
    return in_array($fid,$fids)?true:false;
}//From  www .ym g6.com
?>
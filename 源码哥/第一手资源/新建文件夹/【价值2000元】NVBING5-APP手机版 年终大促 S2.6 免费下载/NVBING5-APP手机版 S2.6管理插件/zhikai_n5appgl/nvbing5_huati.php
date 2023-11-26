<?php
$query = DB::query("SELECT * FROM ".DB::table('forum_forum')." WHERE fup = '$_GET[gid]' ORDER BY displayorder ASC");
while ($value = DB::fetch($query)) {
	$datamm[] = $value['fid'];
}
$str = join(',',$datamm);
?>
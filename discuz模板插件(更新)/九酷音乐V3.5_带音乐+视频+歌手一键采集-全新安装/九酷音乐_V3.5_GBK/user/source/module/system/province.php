<?php
	close_browse();
	$showstr="[";
	global $db;
        $query = $db->query("select * from ".tname('district')." where cd_level=1");
        while ($row = $db->fetch_array($query)) {
		$showstr=$showstr."{\"code\":\"".$row["cd_id"]."\",\"name\":\"".$row["cd_name"]."\"},";
	}
	$showstr=$showstr."]";
	echo ReplaceStr($showstr,",]","]");
?>
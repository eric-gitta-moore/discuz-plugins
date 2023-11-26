<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=gb2312");
include "../../../source/global/global_conn.php";
$template=substr(substr(cd_templatedir,0,strlen(cd_templatedir)-1),0,strrpos(substr(cd_templatedir,0,strlen(cd_templatedir)-1),'/')+1);
switch($_GET['id']){
	case 'video':
		echo "<cmp
		name = \"ÔÝÎÞÊÓÆµ\"
		description = \"ÔÝÎÞ¸è´Ê\"
		skins = \"video.jpg\"
		v = \"video.php?id=\"
		auto_play = \"1\"
		play_mode = \"1\"
		context_menu = \"0\"
		/>";
		break;
	case 'player':
		echo "<cmp
		name = \"ÔÝÎÞÒôÀÖ\"
		skins = \"../../../source/plugin/player/player.jpg\"
		song = \"../../../source/plugin/player/player.php?id=\"
		auto_play = \"1\"
		context_menu = \"0\"
		/>";
		break;
	case 'lrc':
		echo "<cmp
		description = \"ÔÝÎÞ¸è´Ê\"
		skins = \"../../../source/plugin/player/lrc.jpg\"
		_lrc = \"../../../source/plugin/player/lrc.php?id=\"
		volume = \"0\"
		auto_play = \"1\"
		context_menu = \"0\"
		/>";
		break;
	case 'share':
		echo "<cmp
		name = \"ÔÝÎÞÒôÀÖ\"
		skins = \"share.jpg\"
		share = \"share.php?id=\"
		auto_play = \"1\"
		play_mode = \"1\"
		context_menu = \"0\"
		/>";
		break;
	case 'fm':
		echo "<cmp
		name = \"ÔÝÎÞÒôÀÖ\"
		description = \"ÔÝÎÞ¸è´Ê\"
		skins = \"../../../".$template."widget/fm.jpg\"
		fm = \"../../../".$template."widget/fm.php?id=\"
		auto_play = \"1\"
		list_delete = \"1\"
		mixer_id = \"10\"
		play_mode = \"2\"
		context_menu = \"0\"
		/>";
		break;
	case 'v':
		echo "<cmp
		name = \"ÔÝÎÞÒôÀÖ\"
		description = \"ÔÝÎÞ¸è´Ê\"
		skins = \"../../../".$template."widget/v.jpg\"
		v = \"../../../".$template."widget/url.php?id=\"
		auto_play = \"1\"
		play_mode = \"1\"
		context_menu = \"0\"
		/>";
		break;
	case 'song':
		echo "<cmp
		name = \"ÔÝÎÞÒôÀÖ\"
		description = \"ÔÝÎÞ¸è´Ê\"
		skins = \"../../../".$template."widget/song.jpg\"
		song = \"../../../".$template."widget/url.php?id=\"
		auto_play = \"1\"
		list_delete = \"1\"
		context_menu = \"0\"
		/>";
		break;
}
?>
<?php
/*
 *	Author: Ô´Âë¸ç
 *	Last modified: 2015-12-08 17:42
 *	Filename: upgrade.php
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
/**V1.5* */
$sql = <<<SQL
CREATE TABLE IF NOT EXISTS `pre_game_jneggv2_chicken` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `chickenqty` int(11) NOT NULL,
  `buytime` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `other` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

SQL;
runquery($sql,'SILENT');

/*V1.51*/
$qcopychick = DB::query("SELECT * FROM ".DB::table('game_jneggv2_user')."");
while($rchick = DB::fetch($qcopychick)) {
	if($rchick['chicken'] > 0){
		DB::query("INSERT INTO ".DB::table('game_jneggv2_chicken')." (uid,buytime,status,chickenqty) VALUES ('".$rchick[uid]."','".$_G[timestamp]."','1','".$rchick[chicken]."')",'SILENT');
	}	
}
DB::query("UPDATE ".DB::table('game_jneggv2_user')." SET chicken = '0'",'SILENT');

$finish = true;
//WWW.fx8.cc   QQ:2575 163 778
?>

<?php

/**
 * 魔趣吧官网：http://WWW.moqu8.com
 *
 * [魔趣吧!] (C)2014-2017 www.moqu8.com.  By www-魔趣吧-co
 *
 * Support: caogenba@qq.com QQ:1218894030
 *
 * Date: 2013-02-17 16:22:17 moqu8.com $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class x_citys_module {

	
	public static function _city($arr = array()) {//初始化地区
		$level = intval($arr[0]);
		$citys = self::citys($level);
		if ($citys) {
			$lev_lang = lev_base::$lang;
			$html = '<select name="citys" id="citys" onchange="actchg(this)" class="levcitys">';
			$html.= '<option value="">'.$lev_lang['pslt'].'</option>';
			foreach ($citys as $r) {
				$html .= '<option datalv="'.$r['level'].'" dataid="'.$r['id'].'" value="'.$r['name'].'">'.$r['name'].'</option>';
			}
			return $html.'</select> ';
		}
		return '';
	}
	
	public static function _upids($upid = 0) {
		$upid = intval($upid);
		
		$citys = DB::fetch_all("SELECT * FROM ".DB::table('common_district')." WHERE upid='$upid'");
		if ($citys) {
			$lev_lang = lev_base::$lang;
			$html = '<option value="">'.$lev_lang['pslt'].'</option>';
			foreach ($citys as $r) {
				$html .= '<option datalv="'.$r['level'].'" dataid="'.$r['id'].'" value="'.$r['name'].'">'.$r['name'].'</option>';
			}
			echo $html;
		}
		
	}
	
	public static function citys($level = 1) {//地区等级：1，省级；2，市级；3，县级；4，乡镇',
		
		$citys = DB::fetch_all("SELECT * FROM ".DB::table('common_district')." WHERE level='$level'");
		return $citys;
		
	}
	public static function mycity($arr = array()) {
		$id = intval($arr[0]);
		$all = $arr[1];
		return C::t(lev_base::$table)->mycity($id, $all);
	}
	
	public static function jsinit() {
		$lm = lev_base::$lm;
		$html = <<<EOF
<script type="text/javascript">
function chgcity(obj) {
	var mylv = jQuery(obj).find('option:selected').attr('datalv');
	var upid = jQuery(obj).find('option:selected').attr('dataid');
	if (!mylv || !upid) return '';
	for(i=2; i<5; i++) {
		if (i >mylv) jQuery(obj).parent().find('#city'+ i).remove();
	}
	jQuery.get('{$lm}x_citys._upids.'+ upid, {}, function(data){
		if (data.indexOf('option') >0) {
			if (jQuery(obj).parent().find('#city'+ mylv).html()) {
				jQuery(obj).parent().find('#city'+ mylv).html(data);
			}else {
				var _data = '<select name="city'+ mylv +'" id="city'+ mylv +'" onchange="actchg(this)" class="levcitys">';
				jQuery(obj).parent().append(_data + data +'</select> ');
			}
		}
	});
}
</script>
EOF;
		return $html;
	}
	
}








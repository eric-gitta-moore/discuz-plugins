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

class x_selects_module {

	public static function x_navs($arr = array()) {
		$datas = lev_module::ismodule2('x_explode', 'init', array($arr[0]));
		foreach ($datas as $k => $r) {
			$lv = substr_count($r[0], '.');
			$lvarr[$lv][$k] = $r;
		}
		$selects = self::forhtmla($lvarr, $arr[1]);
		return $selects;
	}
	public static function forhtmla($lvarr, $url) {
		$_k = trim($_GET['k']);
		$_pk = intval($_k);
		if ($lvarr) {
			$lev_lang = lev_base::$lang;
			$PLSTATIC = lev_base::$PLSTATIC;
			$j = count($lvarr);
			for ($i=0; $i<$j; $i++) {
				$hide = $i ? 'style="display:none;"' : '';
				$hor = !$_k ? 'class="hor"' : '';
				$select .= "<ul $hide class='levhtmla levhtmla-{$i}'>";
				$select .= $i ? '' : "<li><a {$hor} href='{$url}'>{$lev_lang['allvd']}</a>
						<a title='{$lev_lang['upvd']}' href='".lev_base::$PLURL.":addv' class=up-vd><img src=".$PLSTATIC."img/upvd.png></a></li>";
				foreach ($lvarr[$i] as $k => $r) {
					if (!$r[1]) continue;
					$hor = ($_k ==$k || $_pk ==$k) ? 'class="hor"' : '';
					$select .= "<li><a {$hor} href='{$url}{$k}' dataval='{$k}' datalv='{$i}'>{$r[1]}</a></li>";
				}
				$select .= '</ul>';
			}
			$html = <<<eof
			<style>
.leftnav_vd {position:absolute;width:125px;top:10px;left:-132px;z-index:9999;border: 1px solid #e0dede;background: #fff;padding: 10px 0;}
.leftnav_vd a.up-vd {position: absolute; right: 5px; top: 6px; padding: 0px; height: 18px;}
.leftnav_vd a.up-vd:hover {border:none;padding:0;}
.leftnav_vd ul a {color: #2a2a2a;display: block;font-size: 14px;height: 30px;line-height: 30px;padding-left: 30px;overflow:hidden;}
.leftnav_vd ul a:hover, .leftnav_vd ul a.hor {background: #f5f5f5;border-left: 3px solid #ff7800;color: #ff7800;padding-left: 27px;}
.levhtmlanav2.levhtmla {background: #fff;border: 1px solid #e0dede;left: 125px;position: absolute;top: 0;width: 125px;}
.levhtmla li {position: relative;}
</style>
<span class=levhtmlabox id=levhtmlabox>{$select}</span>
eof;
			$html .= self::jshtmlinit();
			return $html;
		}
		return '';
	}
	public static function jshtmlinit() {
		$lev_lang = lev_base::$lang;
		$js = <<<EOF
		<script>
		jQuery('.levhtmla li').live('hover', '', function(){
			var max_idx = jQuery('#levhtmlabox .levhtmla').length - 1;
			var _val = jQuery(this).find('a').attr('dataval');
			var idx = parseInt(jQuery(this).find('a').attr('datalv'));
			var nidx = idx + 1;
			_val += '.';
			var val_len = _val.length;
			if (idx <max_idx && !jQuery(this).find('.levhtmla_'+ nidx).html()) {
				var _box = jQuery('#levhtmlabox .levhtmla.levhtmla-'+ nidx);
				var _select = '<ul class="levhtmlanav2 levhtmla levhtmla_'+ nidx +'">';
				var _option = '';
				_box.find('li').each(function(){
					var v = jQuery(this).find('a').attr('dataval');
					if (v.substr(0, val_len) == _val) {
						_option += '<li>'+ jQuery(this).html() +'</li>';
					}
				});
				for (i=nidx; i<=max_idx; i++) {
					jQuery('#levhtmlabox ul.levhtmla_'+ i).remove();
				}
				if (_option !='') {
					_select += _option +'</ul>';
					jQuery(this).append(_select);
				}
			}
			jQuery('.levhtmlanav2').hide();
			jQuery(this).find('.levhtmlanav2').show();
		});
		</script>
EOF;
		return $js;
	}
	
	public static function x_selects($arr = array()) {//$arr[0] data; $arr[1] id
		$datas = lev_module::ismodule2('x_explode', 'init', array($arr[0]));
		foreach ($datas as $k => $r) {
			$lv = substr_count($r[0], '.');
			$lvarr[$lv][$k] = $r;
		}
		$selects = self::foroption($lvarr, $arr[1]);
		return $selects;
	}
	
	public static function foroption($lvarr, $id) {
		if ($lvarr) {
			$lev_lang = lev_base::$lang;
			$j = count($lvarr);
			for ($i=0; $i<$j; $i++) {
				$hide = $i ? 'style="display:none;"' : '';
				$select .= "<select $hide class='levselects levselects-{$i}' onchange=\"selects_control('{$id}', {$i}, this)\">";
				$select .= "<option value=''>{$lev_lang['pslt']}</option>";
				foreach ($lvarr[$i] as $k => $r) {
					$select .= "<option value='{$k}'>{$r[1]}</option>";
				}
				$select .= '</select>';
			}
			return "<span class=levselectsbox id=levselectsbox{$id}>{$select}</span>";
		}
		return '';
	}
	
	public static function valstr($arr = array()) {
		$datas = lev_module::ismodule2('x_explode', 'init', array($arr[0]));//print_r($datas);
		$value = $arr[1];
		if (!$arr[2]) {
			$lv = substr_count($value, '.');
			if ($lv >0) {
				$r = explode('.', trim($value));
				for ($i=0; $i<=$lv; $i++) {
					$k = '';
					for ($j=0; $j<=$i; $j++) {
						$k .= $r[$j].'.';
					}
					$k = trim(substr($k, 0, -1));
					$valstr .= $datas[$k][1].' &raquo; ';
				}
				$valstr = substr($valstr, 0, -9);
				return $valstr;
			}
		}
		return $datas[$value][1];
	}
	
	public static function jsinit() {
		$lev_lang = lev_base::$lang;
		$js = <<<EOF
		<script>
		function selects_control(id, idx, obj) {
			var max_idx = jQuery('#levselectsbox'+ id +' select').length - 1;
			var _val = jQuery(obj).val();
			
			jQuery('#value_'+ id).val(_val);
			jQuery('#value_'+ id).attr('checked', true);
			
			_val += '.';
			var val_len = _val.length;
			if (idx <max_idx) {
				var nidx = idx + 1;
				var _box = jQuery('#levselectsbox'+ id +' select.levselects-'+ nidx);
				var _select = '<select class="levselect_'+ nidx +'" onchange="selects_control(\''+ id +'\', '
							+ nidx +', this)">';
				var _option = '';
				_box.find('option').each(function(){
					var v = jQuery(this).attr('value');
					if (v.substr(0, val_len) == _val) {
						_option += '<option value='+ v +'>'+ jQuery(this).html() +'</option>';
					}
				});
				for (i=nidx; i<=max_idx; i++) {
					jQuery('#levselectsbox'+ id +' select.levselect_'+ i).remove();
				}
				if (_option !='') {
					_select += '<option value="">{$lev_lang['pslt']}</option>'+ _option +'</select>';
					jQuery('#levselectsbox'+ id).append(_select);
				}
			}
		}
		</script>
EOF;
		return $js;
	}
	
}








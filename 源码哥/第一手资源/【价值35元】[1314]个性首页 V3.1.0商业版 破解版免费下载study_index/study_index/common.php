<?php
if(!defined('IN_DISCUZ')) {
    exit('http://127.0.0.1/');
}
if(!defined('CLOUDADDONS_WEBSITE_URL')) {
   require_once libfile('function/cloudaddons');
}

function s_showsettings($pluginvars,$pluginvars_array){
    global $_G, $lang,$plugin;
    $extra = array();
    $s_e = 'ex';
		foreach($pluginvars_array as $k => $variable){
				if(!isset($pluginvars[$variable])){
						continue;
				}
				$var = $pluginvars[$variable];
        if(strexists($var['type'], '_')) {
            continue;
        }
        $var['variable'] = 'varsnew['.$var['variable'].']';
        if($var['type'] == 'number') {
            $var['type'] = 'text';
        } elseif($var['type'] == 'select') {
            $var['type'] = "<select name=\"$var[variable]\">\n";
            foreach(explode("\n", $var['extra']) as $key => $option) {
                $option = trim($option);
                if(strpos($option, '=') === FALSE) {
                    $key = $option;
                } else {
                    $item = explode('=', $option);
                    $key = trim($item[0]);
                    $option = trim($item[1]);
                }
                $var['type'] .= "<option value=\"".dhtmlspecialchars($key)."\" ".($var['value'] == $key ? 'selected' : '').">$option</option>\n";
            }
            $var['type'] .= "</select>\n";
            $var['variable'] = $var['value'] = '';
        } elseif($var['type'] == 'selects') {
            $var['value'] = unserialize($var['value']);
            $var['value'] = is_array($var['value']) ? $var['value'] : array($var['value']);
            $var['type'] = "<select name=\"$var[variable][]\" multiple=\"multiple\" size=\"10\">\n";
            foreach(explode("\n", $var['extra']) as $key => $option) {
                $option = trim($option);
                if(strpos($option, '=') === FALSE) {
                    $key = $option;
                } else {
                    $item = explode('=', $option);
                    $key = trim($item[0]);
                    $option = trim($item[1]);
                }
                $var['type'] .= "<option value=\"".dhtmlspecialchars($key)."\" ".(in_array($key, $var['value']) ? 'selected' : '').">$option</option>\n";
            }
            $var['type'] .= "</select>\n";
            $var['variable'] = $var['value'] = '';
        } elseif($var['type'] == 'date') {
            $var['type'] = 'calendar';
            $extra['date'] = '<script type="text/javascript" src="static/js/calendar.js"></script>';
        } elseif($var['type'] == 'datetime') {
            $var['type'] = 'calendar';
            $var['extra'] = 1;
            $extra['date'] = '<script type="text/javascript" src="static/js/calendar.js"></script>';
        } elseif($var['type'] == 'forum') {
            require_once libfile('function/forumlist');
            $var['type'] = '<select name="'.$var['variable'].'"><option value="">'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $var['value'], TRUE).'</select>';
            $var['variable'] = $var['value'] = '';
        } elseif($var['type'] == 'forums') {
            $var['description'] = ($var['description'] ? (isset($lang[$var['description']]) ? $lang[$var['description']] : $var['description'])."\n" : '').$lang['plugins_edit_vars_multiselect_comment']."\n".$var['comment'];
            $var['value'] = unserialize($var['value']);
            $var['value'] = is_array($var['value']) ? $var['value'] : array();
            require_once libfile('function/forumlist');
            $var['type'] = '<select name="'.$var['variable'].'[]" size="10" multiple="multiple"><option value="">'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, 0, TRUE).'</select>';
            foreach($var['value'] as $v) {
                $var['type'] = str_replace('<option value="'.$v.'">', '<option value="'.$v.'" selected>', $var['type']);
            }
            $var['variable'] = $var['value'] = '';
        } elseif(substr($var['type'], 0, 5) == 'group') {
            if($var['type'] == 'groups') {
                $var['description'] = ($var['description'] ? (isset($lang[$var['description']]) ? $lang[$var['description']] : $var['description'])."\n" : '').$lang['plugins_edit_vars_multiselect_comment']."\n".$var['comment'];
                $var['value'] = unserialize($var['value']);
                $var['type'] = '<select name="'.$var['variable'].'[]" size="10" multiple="multiple"><option value=""'.(@in_array('', $var['value']) ? ' selected' : '').'>'.cplang('plugins_empty').'</option>';
            } else {
                $var['type'] = '<select name="'.$var['variable'].'"><option value="">'.cplang('plugins_empty').'</option>';
            }
            $var['value'] = is_array($var['value']) ? $var['value'] : array($var['value']);

            $query = DB::query("SELECT type, groupid, grouptitle, radminid FROM ".DB::table('common_usergroup')." ORDER BY (creditshigher<>'0' || creditslower<>'0'), creditslower, groupid");
						$groupselect = array();
						while($group = DB::fetch($query)) {
							$group['type'] = $group['type'] == 'special' && $group['radminid'] ? 'specialadmin' : $group['type'];
							$groupselect[$group['type']] .= '<option value="'.$group['groupid'].'"'.(@in_array($group['groupid'], $var['value']) ? ' selected' : '').'>'.$group['grouptitle'].'</option>';
						}
            $var['type'] .= '<optgroup label="'.$lang['usergroups_member'].'">'.$groupselect['member'].'</optgroup>'.
                ($groupselect['special'] ? '<optgroup label="'.$lang['usergroups_special'].'">'.$groupselect['special'].'</optgroup>' : '').
                ($groupselect['specialadmin'] ? '<optgroup label="'.$lang['usergroups_specialadmin'].'">'.$groupselect['specialadmin'].'</optgroup>' : '').
                '<optgroup label="'.$lang['usergroups_system'].'">'.$groupselect['system'].'</optgroup></select>';
            $var['variable'] = $var['value'] = '';
        } elseif($var['type'] == 'extcredit') {
            $var['type'] = '<select name="'.$var['variable'].'"><option value="">'.cplang('plugins_empty').'</option>';
            foreach($_G['setting']['extcredits'] as $id => $credit) {
                $var['type'] .= '<option value="'.$id.'"'.($var['value'] == $id ? ' selected' : '').'>'.$credit['title'].'</option>';
            }
            $var['type'] .= '</select>';
            $var['variable'] = $var['value'] = '';
        } elseif($var['type'] == 'mcheckbox' || $var['type'] == 'mcheckbox2'){
            $drkextra = explode(chr(10),$var['extra']);
            foreach($drkextra as $val){
                $extr = explode('=', $val);
                $arr[] = array($extr[0],trim($extr[1]));
            }
            $var['variable'] = array($var['variable'],$arr);
            unset($arr);
            $var['value'] = unserialize($var['value']);
        } elseif($var['type'] == 'portal'){
            include_once libfile('function/portalcp');
            $var['type'] = category_showselect('portal', $var['variable'], false, $var['value']);
        } elseif($var['type'] == 'portals'){
            $var['description'] = ($var['description'] ? (isset($lang[$var['description']]) ? $lang[$var['description']] : $var['description'])."\n" : '').$lang['plugins_edit_vars_multiselect_comment']."\n".$var['comment'];
            $var['value'] = unserialize($var['value']);
            $var['value'] = is_array($var['value']) ? $var['value'] : array();
            require_once libfile('function/forumlist');
            $var['type'] = '<select name="'.$var['variable'].'[]" size="10" multiple="multiple"><option value="">'.cplang('plugins_empty').'</option>'.s_portalselect('catid', 0, '').'</select>';
            foreach($var['value'] as $v) {
                $var['type'] = str_replace('<option value="'.$v.'">', '<option value="'.$v.'" selected>', $var['type']);
            }
            $var['variable'] = $var['value'] = '';
        } elseif($var['type'] == 'mradio' || $var['type'] == 'mradio2'){
            $extras = explode(chr(10), $var['extra']);
            $a[] = $var['variable'];
            foreach($extras as $value){
                $extra = explode('=', $value);
                $b[$var['variable'].'ext'] = '';
                $c[] = $extra[0];
                $c[] = $extra[1];
                $c[] = $b;
                $d[] = $c;
                unset($b);
                unset($c);
            }
            $a[] = $d;
            unset($d);
            $var['variable'] = $a;
            unset($a);
            $extra = '';
        }
        s_showsetting(isset($lang[$var['title']]) ? $lang[$var['title']] : dhtmlspecialchars($var['title']), $var['variable'], $var['value'], $var['type'], '', 0, isset($lang[$var['description']]) ? $lang[$var['description']] : nl2br(dhtmlspecialchars($var['description'])), dhtmlspecialchars($var['extra']), '', true);
    }
    $s_e .= 'it';
    return $extra;
}

function s_portalselect($name='catid', $shownull=true, $current='') {
	global $_G;

	if(!isset($_G['cache']['portalcategory'])) {
		loadcache('portalcategory');
	}
	$category = $_G['cache']['portalcategory'];

	$select = "";
	if($shownull) {
		$select .= '<option value="">'.lang('portalcp', 'select_category').'</option>';
	}
	foreach ($category as $value) {
		if($value['level'] == 0) {
			$selected = ($current && $current==$value['catid']) ? 'selected="selected"' : '';
			$select .= "<option value=\"$value[catid]\"$selected>$value[catname]</option>";
			if(!$value['children']) {
				continue;
			}
			foreach ($value['children'] as $catid) {
				$selected = ($current && $current==$catid) ? 'selected="selected"' : '';
				$select .= "<option value=\"{$category[$catid][catid]}\"$selected>-- {$category[$catid][catname]}</option>";
				if($category[$catid]['children']) {
					foreach ($category[$catid]['children'] as $catid2) {
						$selected = ($current && $current==$catid2) ? 'selected="selected"' : '';
						$select .= "<option value=\"{$category[$catid2][catid]}\"$selected>---- {$category[$catid2][catname]}</option>";
					}
				}
			}
		}
	}
	return $select;
}

function s_showsetting($setname, $varname, $value, $type = 'radio', $disabled = '', $hidden = 0, $comment = '', $extra = '', $setid = '') {

	global $_G,$plugin;
	$s = "\n";
	$check = array();
	$check['disabled'] = $disabled ? ($disabled == 'readonly' ? ' readonly' : ' disabled') : '';
	$check['disabledaltstyle'] = $disabled ? ', 1' : '';

	$nocomment = false;

	if(isset($_G['showsetting_multi'])) {
		$hidden = 0;
		if(is_array($varname)) {
			$varnameid = '_'.str_replace(array('[', ']'), '_', $varname[0]).'|'.$_G['showsetting_multi'];
			$varname[0] = preg_replace('/\w+new/', 'multinew['.$_G['showsetting_multi'].'][\\0]', $varname[0]);
		} else {
			$varnameid = '_'.str_replace(array('[', ']'), '_', $varname).'|'.$_G['showsetting_multi'];
			$varname = preg_replace('/\w+new/', 'multinew['.$_G['showsetting_multi'].'][\\0]', $varname);
		}
	} else {
		$varnameid = '';
	}

	if($type == 'radio') {
		$value ? $check['true'] = "checked" : $check['false'] = "checked";
		$value ? $check['false'] = '' : $check['true'] = '';
		$check['hidden1'] = $hidden ? ' onclick="$(\'hidden_'.$setname.'\').style.display = \'\';"' : '';
		$check['hidden0'] = $hidden ? ' onclick="$(\'hidden_'.$setname.'\').style.display = \'none\';"' : '';
		$onclick = $disabled && $disabled == 'readonly' ? ' onclick="return false"' : '';
		$s .= '<ul onmouseover="altStyle(this'.$check['disabledaltstyle'].');">'.
			'<li'.($check['true'] ? ' class="checked"' : '').'><input class="radio" type="radio"'.($varnameid ? ' id="_v1_'.$varnameid.'"' : '').' name="'.$varname.'" value="1" '.$check['true'].$check['hidden1'].$check['disabled'].$onclick.'>&nbsp;'.cplang('yes').'</li>'.
			'<li'.($check['false'] ? ' class="checked"' : '').'><input class="radio" type="radio"'.($varnameid ? ' id="_v0_'.$varnameid.'"' : '').' name="'.$varname.'" value="0" '.$check['false'].$check['hidden0'].$check['disabled'].$onclick.'>&nbsp;'.cplang('no').'</li>'.
			'</ul>';
	} elseif($type == 'text' || $type == 'password' || $type == 'number') {
		$s .= '<input name="'.$varname.'" value="'.dhtmlspecialchars($value).'" type="'.$type.'" class="txt" '.$check['disabled'].' '.$extra.' />';
	} elseif($type == 'file') {
		$s .= '<input name="'.$varname.'" value="" type="file" class="txt uploadbtn marginbot" '.$check['disabled'].' '.$extra.' />';
	} elseif($type == 'filetext') {
		$defaulttype = $value ? 1 : 0;
		$id = 'file'.random(2);
		$s .= '<input id="'.$id.'_0" style="display:'.($defaulttype ? 'none' : '').'" name="'.($defaulttype ? 'TMP' : '').$varname.'" value="" type="file" class="txt uploadbtn marginbot" '.$check['disabled'].' '.$extra.' />'.
			'<input id="'.$id.'_1" style="display:'.(!$defaulttype ? 'none' : '').'" name="'.(!$defaulttype ? 'TMP' : '').$varname.'" value="'.dhtmlspecialchars($value).'" type="text" class="txt marginbot" '.$extra.' /><br />'.
			'<a id="'.$id.'_0a" style="'.(!$defaulttype ? 'font-weight:bold' : '').'" href="javascript:;" onclick="$(\''.$id.'_1a\').style.fontWeight = \'\';this.style.fontWeight = \'bold\';$(\''.$id.'_1\').name = \'TMP'.$varname.'\';$(\''.$id.'_0\').name = \''.$varname.'\';$(\''.$id.'_0\').style.display = \'\';$(\''.$id.'_1\').style.display = \'none\'">'.cplang('switch_upload').'</a>&nbsp;'.
			'<a id="'.$id.'_1a" style="'.($defaulttype ? 'font-weight:bold' : '').'" href="javascript:;" onclick="$(\''.$id.'_0a\').style.fontWeight = \'\';this.style.fontWeight = \'bold\';$(\''.$id.'_0\').name = \'TMP'.$varname.'\';$(\''.$id.'_1\').name = \''.$varname.'\';$(\''.$id.'_1\').style.display = \'\';$(\''.$id.'_0\').style.display = \'none\'">'.cplang('switch_url').'</a>';
	} elseif($type == 'textarea') {
		$readonly = $disabled ? 'readonly' : '';
		$s .= "<textarea $readonly rows=\"6\" ".(!isset($_G['showsetting_multi']) ? "ondblclick=\"textareasize(this, 1)\"" : '')." onkeyup=\"textareasize(this, 0)\" name=\"$varname\" id=\"$varname\" cols=\"50\" class=\"tarea\" '.$extra.'>".dhtmlspecialchars($value)."</textarea>";
	} elseif($type == 'select') {
		$s .= '<select name="'.$varname[0].'" '.$extra.'>';
		foreach($varname[1] as $option) {
			$selected = $option[0] == $value ? 'selected="selected"' : '';
			if(empty($option[2])) {
				$s .= "<option value=\"$option[0]\" $selected>".$option[1]."</option>\n";
			} else {
				$s .= "<optgroup label=\"".$option[1]."\"></optgroup>\n";
			}
		}
		$s .= '</select>';
	} elseif($type == 'mradio' || $type == 'mradio2') {
		$nocomment = $type == 'mradio2' && !isset($_G['showsetting_multi']) ? true : false;
		$addstyle = $nocomment ? ' style="float: left; width: 18%"' : '';
		$ulstyle = $nocomment ? ' style="width: 830px"' : '';
		if(is_array($varname)) {
			$radiocheck = array($value => ' checked');
			$s .= '<ul'.(empty($varname[2]) ?  ' class="nofloat"' : '').' onmouseover="altStyle(this'.$check['disabledaltstyle'].');"'.$ulstyle.'>';
			foreach($varname[1] as $varary) {
				if(is_array($varary) && !empty($varary)) {
					$onclick = '';
					if(!isset($_G['showsetting_multi']) && !empty($varary[2])) {
						foreach($varary[2] as $ctrlid => $display) {
							$onclick .= '$(\''.$ctrlid.'\').style.display = \''.$display.'\';';
						}
					}
					$onclick && $onclick = ' onclick="'.$onclick.'"';
					$s .= '<li'.($radiocheck[$varary[0]] ? ' class="checked"' : '').$addstyle.'><input class="radio" type="radio"'.($varnameid ? ' id="_v'.md5($varary[0]).'_'.$varnameid.'"' : '').' name="'.$varname[0].'" value="'.$varary[0].'"'.$radiocheck[$varary[0]].$check['disabled'].$onclick.'>&nbsp;'.$varary[1].'</li>';
				}
			}
			$s .= '</ul>';
		}
	} elseif($type == 'mcheckbox' || $type == 'mcheckbox2') {
		$nocomment = $type != 'mcheckbox2' && count($varname[1]) > 3 && !isset($_G['showsetting_multi']) ? true : false;
		$addstyle = $nocomment ? ' style="float: left; width: 18%"' : '';
		$ulstyle = $nocomment ? ' style="width: 830px"' : '';
		$s .= '<ul class="nofloat" onmouseover="altStyle(this'.$check['disabledaltstyle'].');"'.$ulstyle.'>';
		foreach($varname[1] as $varary) {
			if(is_array($varary) && !empty($varary)) {
				$onclick = !isset($_G['showsetting_multi']) && !empty($varary[2]) ? ' onclick="$(\''.$varary[2].'\').style.display = $(\''.$varary[2].'\').style.display == \'none\' ? \'\' : \'none\';"' : '';
				$checked = is_array($value) && in_array($varary[0], $value) ? ' checked' : '';
				$s .= '<li'.($checked ? ' class="checked"' : '').$addstyle.'><input class="checkbox" type="checkbox"'.($varnameid ? ' id="_v'.md5($varary[0]).'_'.$varnameid.'"' : '').' name="'.$varname[0].'[]" value="'.$varary[0].'"'.$checked.$check['disabled'].$onclick.'>&nbsp;'.$varary[1].'</li>';
			}
		}
		$s .= '</ul>';
	} elseif($type == 'binmcheckbox') {
		$checkboxs = count($varname[1]);
		$value = sprintf('%0'.$checkboxs.'b', $value);$i = 1;
		$s .= '<ul class="nofloat" onmouseover="altStyle(this'.$check['disabledaltstyle'].');">';
		foreach($varname[1] as $key => $var) {
			$s .= '<li'.($value{$checkboxs - $i} ? ' class="checked"' : '').'><input class="checkbox" type="checkbox"'.($varnameid ? ' id="_v'.md5($i).'_'.$varnameid.'"' : '').' name="'.$varname[0].'['.$i.']" value="1"'.($value{$checkboxs - $i} ? ' checked' : '').' '.(!empty($varname[2][$key]) ? $varname[2][$key] : '').'>&nbsp;'.$var.'</li>';
			$i++;
		}
		$s .= '</ul>';
	} elseif($type == 'omcheckbox') {
		$nocomment = count($varname[1]) > 3 ? true : false;
		$addstyle = $nocomment ? 'style="float: left; width: 18%"' : '';
		$ulstyle = $nocomment ? 'style="width: 830px"' : '';
		$s .= '<ul onmouseover="altStyle(this'.$check['disabledaltstyle'].');"'.(empty($varname[2]) ? ' class="nofloat"' : 'class="ckbox"').' '.$ulstyle.'>';
		foreach($varname[1] as $varary) {
			if(is_array($varary) && !empty($varary)) {
				$checked = is_array($value) && $value[$varary[0]] ? ' checked' : '';
				$s .= '<li'.($checked ? ' class="checked"' : '').' '.$addstyle.'><input class="checkbox" type="checkbox" name="'.$varname[0].'['.$varary[0].']" value="'.$varary[2].'"'.$checked.$check['disabled'].'>&nbsp;'.$varary[1].'</li>';
			}
		}
		$s .= '</ul>';
	} elseif($type == 'mselect') {
		$s .= '<select name="'.$varname[0].'" multiple="multiple" size="10" '.$extra.'>';
		foreach($varname[1] as $option) {
			$selected = is_array($value) && in_array($option[0], $value) ? 'selected="selected"' : '';
			if(empty($option[2])) {
				$s .= "<option value=\"$option[0]\" $selected>".$option[1]."</option>\n";
			} else {
				$s .= "<optgroup label=\"".$option[1]."\"></optgroup>\n";
			}
		}
		$s .= '</select>';
	} elseif($type == 'color') {
		global $stylestuff;
		$preview_varname = str_replace('[', '_', str_replace(']', '', $varname));
		$code = explode(' ', $value);
		$css = '';
		for($i = 0; $i <= 1; $i++) {
			if($code[$i] != '') {
				if($code[$i]{0} == '#') {
					$css .= strtoupper($code[$i]).' ';
				} elseif(preg_match('/^http:\/\//i', $code[$i])) {
					$css .= 'url(\''.$code[$i].'\') ';
				} else {
					$css .= 'url(\''.$stylestuff['imgdir']['subst'].'/'.$code[$i].'\') ';
				}
			}
		}
		$background = trim($css);
		$colorid = ++$GLOBALS['coloridcount'];
		$s .= "<input id=\"c{$colorid}_v\" type=\"text\" class=\"txt\" style=\"float:left; width:210px;\" value=\"$value\" name=\"$varname\" onchange=\"updatecolorpreview('c{$colorid}')\">\n".
			"<input id=\"c$colorid\" onclick=\"c{$colorid}_frame.location='static/image/admincp/getcolor.htm?c{$colorid}|c{$colorid}_v';showMenu({'ctrlid':'c$colorid'})\" type=\"button\" class=\"colorwd\" value=\"\" style=\"background: $background\"><span id=\"c{$colorid}_menu\" style=\"display: none\"><iframe name=\"c{$colorid}_frame\" src=\"\" frameborder=\"0\" width=\"210\" height=\"148\" scrolling=\"no\"></iframe></span>\n$extra";
	} elseif($type == 'calendar') {
		$s .= "<input type=\"text\" class=\"txt\" name=\"$varname\" value=\"".dhtmlspecialchars($value)."\" onclick=\"showcalendar(event, this".($extra ? ', 1' : '').")\">\n";
	} elseif(in_array($type, array('multiply', 'range', 'daterange'))) {
		$onclick = $type == 'daterange' ? ' onclick="showcalendar(event, this)"' : '';
		if(isset($_G['showsetting_multi'])) {
			$varname[1] = preg_replace('/\w+new/', 'multinew['.$_G['showsetting_multi'].'][\\0]', $varname[1]);
		}
		$s .= "<input type=\"text\" class=\"txt\" name=\"$varname[0]\" value=\"".dhtmlspecialchars($value[0])."\" style=\"width: 108px; margin-right: 5px;\"$onclick>".($type == 'multiply' ? ' X ' : ' -- ')."<input type=\"text\" class=\"txt\" name=\"$varname[1]\" value=\"".dhtmlspecialchars($value[1])."\"class=\"txt\" style=\"width: 108px; margin-left: 5px;\"$onclick>";
	} else {
		$s .= $type;
	}
	$name = cplang($setname);
	$name .= $name && substr($name, -1) != ':' ? ':' : '';
	$name = $disabled ? '<span class="lightfont">'.$name.'</span>' : $name;
	$setid = !$setid ? substr(md5($setname), 0, 4) : $setid;
	$setid = isset($_G['showsetting_multi']) ? 'S'.$setid : $setid;
	if(!empty($_G['showsetting_multirow'])) {
		if(empty($_G['showsetting_multirow_n'])) {
			echo '<tr>';
		}
		echo '<td class="vtop rowform"><p class="td27m">'.$name.'</p>'.$s.'</td>';
		$_G['showsetting_multirow_n']++;
		if($_G['showsetting_multirow_n'] == 2) {
			if(empty($_G['showsetting_multirow_n'])) {
				echo '</tr>';
			}
			$_G['showsetting_multirow_n'] = 0;
		}
		return;
	}
	if(!isset($_G['showsetting_multi'])) {
		$faqurl = 'http://www.fx8.cc/faq.php?type=admin&ver='.$_G['setting']['version'].'&pid='.rawurlencode($plugin['identifier']).'&pname='.rawurlencode($plugin['name']).'&pver='.rawurlencode($plugin['version']).'&operation='.rawurlencode($_GET['operation']).'&key='.rawurlencode($setname);
		showtablerow('onmouseover="setfaq(this, \'faq'.$setid.'\')"', 'colspan="2" class="td27" s="1"', $name.'<a id="faq'.$setid.'" class="faq" title="'.cplang('setting_faq_title').'" href="'.$faqurl.'" target="_blank" style="display:none">&nbsp;&nbsp;&nbsp;&#27714;&#21161;</a>');
	} else {
		if(empty($_G['showsetting_multijs'])) {
			$_G['setting_JS'] .= 'var ss = new Array();';
			$_G['showsetting_multijs'] = 1;
		}
		if($_G['showsetting_multi'] == 0) {
			showtablerow('', array('class="td27"'), array('<div id="D'.$setid.'"></div>'));
			$_G['setting_JS'] .= 'ss[\'D'.$setid.'\'] = new Array();';
		}
		$name = preg_replace("/\r\n|\n|\r/", '\n', addcslashes($name, "'\\"));
		$_G['setting_JS'] .= 'ss[\'D'.$setid.'\'] += \'<div class="multicol">'.$name.'</div>\';';
	}
	if(!$nocomment && ($type != 'omcheckbox' || $varname[2] != 'isfloat')) {
		if(!isset($_G['showsetting_multi'])) {
			showtablerow('class="noborder" onmouseover="setfaq(this, \'faq'.$setid.'\')"', array('class="vtop rowform"', 'class="vtop tips2" s="1"'), array(
				$s,
				($comment ? $comment : cplang($setname.'_comment', false)).($type == 'textarea' ? '<br />'.cplang('tips_textarea') : '').
				($disabled ? '<br /><span class="smalltxt" style="color:#F00">'.cplang($setname.'_disabled', false).'</span>' : NULL)
			));
		} else {
			if($_G['showsetting_multi'] == 0) {
				showtablerow('class="noborder"', array('class="vtop rowform" style="width:auto"'), array(
					'<div id="'.$setid.'"></div>'
				));
				$_G['setting_JS'] .= 'ss[\''.$setid.'\'] = new Array();';
			}
			$s = preg_replace("/\r\n|\n|\r/", '\n', addcslashes($s, "'\\"));
			$_G['setting_JS'] .= 'ss[\''.$setid.'\'] += \'<div class="multicol">'.$s.'</div>\';';
		}
	} else {
		showtablerow('class="noborder" onmouseover="setfaq(this, \'faq'.$setid.'\')"', array('colspan="2" class="vtop rowform"'), array($s));
	}

	if($hidden) {
		showtagheader('tbody', 'hidden_'.$setname, $value, 'sub');
	}

}

function splugin_updatecache($identifier) {
	global $_G,$installlang;
	if(ispluginkey($identifier)){
		splugin_loadcache($identifier);
	  $splugin = DB::fetch_first("SELECT * FROM ".DB::table('common_plugin')." WHERE identifier='$identifier'");
		$directory = substr($splugin['directory'], 0, -1);
		$smodules = unserialize($splugin['modules']);
		if($splugin) {
			$file = DISCUZ_ROOT.'./source/plugin/'.$directory.'/discuz_plugin_'.$directory.($smodules['extra']['installtype'] ? '_'.$smodules['extra']['installtype'] : '').'.xml';
			if(file_exists($file)) {
					updatecache(array('plugin'));
					$importtxt = @implode('', file($file));
					$pluginarray = splugin_getimportdata($importtxt, 'Discuz! Plugin');
					unset($pluginarray['Data']['var']);
					if($fp = @fopen($file, 'w')) {
						fwrite($fp, splugin_exportdata($pluginarray));
						fclose($fp);
					}
			}
			$update_item = array('1314' =>'1','SC_GBK' =>'1','SC_UTF8' =>'1','TC_BIG5' =>'1','TC_UTF8' =>'1','install' =>'2','upgrade' =>'2');
			$file = DISCUZ_ROOT.'./source/plugin/'.$directory.'/demo.php';
			if(!file_exists($file)) {
					cpmsg('plugin_file_error', '', 'error');
			}
			if($fp = @fopen($file, 'r')) {
				$demo_contents = fread($fp, filesize ($file));
				fclose($fp);
			}
			foreach($update_item as $key => $value){
				if($value == '1'){
					if(empty($smodules['extra']['installtype']) && $key == '1314'){
						continue;
					}
					if($smodules['extra']['installtype'] != $key){
						$file = DISCUZ_ROOT.'./source/plugin/'.$directory.'/discuz_plugin_'.$directory.($key != '1314' ? '_'.$key : '').'.xml';
						clearstatcache();
						if(file_exists($file)){
						}
					}
				}else{
					$file = DISCUZ_ROOT.'./source/plugin/'.$directory.'/'.$key.'.php';
					if($fp = @fopen($file, 'w')) {
						fwrite($fp, $demo_contents);
						fclose($fp);
					}
				}
			}
		}
		$addonid = $identifier.'.plugin';

	}
}

function splugin_thinks($identifier, $show = '1'){
if($show){
			echo "&#x611f;&#x8c22;&#x4f7f;&#x7528;&#35759;&#24187;&#32593;&#x7684;&#x63d2;&#x4ef6;&#xff0c;&#x767e;&#x5ea6;&#x641c;&#x7d22;&#35759;&#24187;&#32593;&#x0020;&#x83b7;&#x53d6;&#x66f4;&#x591a;&#x5e94;&#x7528;&#x3002;<div style='display:none'>\n2013090320ikG5iDN5qX\n23169\n1406530801\nhttp://127.0.0.1/\nhttp://127.0.0.1/\n\n</div>";
	}
}

function splugin_loadcache($identifier){
	global $_G;
	$_G['s_radio'] = 1;
}
function splugin_exportarray($array) {
	$tmp = $array;
	foreach($array as $k => $v) {
		if(is_array($v)) {
			$tmp[$k] = splugin_exportarray($v, 0);
		} else {
			$tmp[$k] = $v;
		}
	}
	return $tmp;
}

function splugin_getimportdata($importtxt, $name = '', $addslashes = 1, $ignoreerror = 0) {
	global $_G;
	$data = $importtxt;
	require_once libfile('class/xml');
	$xmldata = xml2array($data);
	if(!is_array($xmldata) || !$xmldata) {
		if(!$ignoreerror) {
			cpmsg(cplang('import_data_invalid').cplang($data), '', 'error');
		} else {
			return array();
		}
	} else {
		if($name && $name != $xmldata['Title']) {
			if(!$ignoreerror) {
				cpmsg(cplang('import_data_typeinvalid').cplang($data), '', 'error');
			} else {
				return array();
			}
		}
		$data = splugin_exportarray($xmldata, 0);
	}
	if($addslashes) {
		$data = daddslashes($data, 1);
	}
	unset($data['Data']['plugin']['__modules']);
	return $data;
}

function splugin_exportdata($data) {
	global $_G;
	require_once libfile('class/xml');
	$root = array(
		'Title' => $data['Title'],
		'Version' => $data['Version'],
		'Time' => $data['Time'],
		'From' => 'ht'.'tp:/'.'/ww'.'w.y'.'mg'.'6'.'.com/',
		'Data' => splugin_exportarray($data['Data'], 1)
	);
	return splugin_array2xml($root, 1, FALSE, 1, $data['Data']['plugin']['identifier']);
}

function s_cloudaddons_thank($identifier) {
	global $_G;
	$md5file = $identifier.'.plugin';
	$dir = DISCUZ_ROOT.'./source/plugin/'.$identifier;
	
	
	$plugin = DB::fetch_first("SELECT * FROM ".DB::table('common_plugin')." WHERE identifier='$identifier'");

	loadcache('pluginlanguage_install', 1);
	if(!empty($_G['cache']['pluginlanguage_install']) && isset($_G['cache']['pluginlanguage_install'][$identifier])) {
		unset($_G['cache']['pluginlanguage_install'][$identifier]);
		save_syscache('pluginlanguage_install', $_G['cache']['pluginlanguage_install']);
	}
}
function splugin_cloudaddon($extra, $post = '') {
	return dfsockopen(cloudaddons_url('&from=s').$extra, 0, $post, '', false, CLOUDADDONS_DOWNLOAD_IP, 999);
}
function splugin_array2xml($arr, $htmlon = TRUE, $isnormal = FALSE, $level = 1, $identifier = '') {
	global $_G;
	$s = $level == 1 ? "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\r\n<root>\r\n" : '';
	$space = str_repeat("\t", $level);
	foreach($arr as $k => $v) {
		if(!is_array($v)) {
			$s .= $space."<item id=\"$k\">".($htmlon ? '<![CDATA[' : '').$v.($htmlon ? ']]>' : '')."</item>\r\n";
		} else {
			$s .= $space."<item id=\"$k\">\r\n".splugin_array2xml($v, $htmlon, $isnormal, $level + 1).$space."</item>\r\n";
		}
	}
	$s = preg_replace("/([\x01-\x08\x0b-\x0c\x0e-\x1f])+/", ' ', $s);
	return $level == 1 ? $s."</root>" : $s;
}

function splugin_read_error($identifier){
	showmessage('&#x611f;&#x8c22;&#x4f7f;&#x7528;&#35759;&#24187;&#32593;&#x63d2;&#x4ef6;&#xff0c;&#x73b0;&#x5728;&#x8df3;&#x8f6c;&#x5230;&#35759;&#24187;&#32593;');
	}

function splugin_genuine($identifier){
		$return = '1';
		return $return;
}
function s_addon_stat($plugin,$action){
	global $_G;
	$_statInfo = array();
	$_statInfo['pluginName'] = $plugin['identifier'];
	$_statInfo['pluginVersion'] = $plugin['version'];
	require_once DISCUZ_ROOT.'./source/discuz_version.php';
	$_statInfo['bbsVersion'] = DISCUZ_VERSION;
	$_statInfo['bbsRelease'] = DISCUZ_RELEASE;
	$_statInfo['timestamp'] = TIMESTAMP;
	$_statInfo['bbsUrl'] = $_G['siteurl'];
	$_statInfo['SiteUrl'] = 'http://127.0.0.1/';
	$_statInfo['ClientUrl'] = 'http://127.0.0.1/';
	$_statInfo['SiteID'] = '';
	$_statInfo['bbsAdminEMail'] = $_G['setting']['adminemail'];
	$_statInfo['action'] = $action;
	$_statInfo['genuine'] = splugin_genuine($plugin['identifier']);
	$_statInfo = base64_encode(serialize($_statInfo));
	$_md5Check = md5($_statInfo);
	$StatUrl = 'http://www.xhkj5.com/';
	$_StatUrl = $StatUrl.'?info='.$_statInfo.'&md5check='.$_md5Check;
	cpmsg('<p style="font-size:20px;margin-bottom:10px;">&#x9875;&#x9762;&#x52A0;&#x8F7D;&#x4E2D;&#xFF0C;&#x8BF7;&#x7A0D;&#x7B49;...</p><p><img src="source/admincp/1314/images/loader.gif" width="150" height="13"/></p><script type="text/javascript">location.href="'.$_StatUrl.'";</script>', '', 'succeed');
}
function s_cloudaddon_open($extra, $post = '') {
	return dfsockopen(cloudaddons_url('&from=s').$extra, 0, $post, '', false, CLOUDADDONS_DOWNLOAD_IP, 999);
}
function s_shownav($header = '', $menu = '', $nav = '') {
	global $action, $operation, $plugin;
	$title = 'cplog_'.$action.($operation ? '_'.$operation : '');
	if(in_array($action, array('home', 'custommenu'))) {
		$customtitle = '';
	} elseif(cplang($title, false)) {
		$customtitle = $title;
	} elseif(cplang('nav_'.($header ? $header : 'index'), false)) {
		$customtitle = 'nav_'.$header;
	} else {
		$customtitle = rawurlencode($nav ? $nav : ($menu ? $menu : ''));
	}
	$title = cplang('header_'.($header ? $header : 'index')).($menu ? '&nbsp;&raquo;&nbsp;'.cplang($menu) : '').($nav ? '&nbsp;&raquo;&nbsp;'.cplang($nav) : '');
	$ctitle = cplang('header_'.($header ? $header : 'index'));
	if($menu) {
		$ctitle = cplang($menu);
	}
	if($nav) {
		$ctitle = cplang($nav);
	}
	$s_shownav_lang = lang('pl'.'ugin/s'.'tu'.'dy_n'.'ge');
	$ctitle = str_replace('"', "", $plugin['name'].$ctitle);
	$addtomenu = "&nbsp;&nbsp;<a target=\"main\" title=\"".cplang('custommenu_addto')."\" href=\"".ADMINSCRIPT."?action=misc&operation=custommenu&do=add&title=".rawurlencode($ctitle)."&url=".rawurlencode(cpurl())."\">[+]</a>";
	$dtitle = str_replace("'", "\'", $s_shownav_lang['a'.'dm'.'in_t'.'it'.'le']);
	$title = '<'.'fo'.'nt c'.'olo'.'r='.'"red"'.'><'.'b'.'>&#x672c;&#x63d2;&#x4ef6;&#x7531;&#35759;&#24187;&#32593;&#x5f00;&#x53d1;&#xff0c;&#x4f7f;&#x7528;&#x95ee;&#x9898;&#x8bf7;&#x5230;&#35759;&#24187;&#32593;&#xff08;<'.'a hr'.'ef'.'="htt'.'p:/'.'/ww'.'w.y'.'mg'.'6.c'.'om/" tar'.'get="_blank">ww'.'w.y'.'m'.'g'.'6.com</'.'a>&#xFF09;&#x53CD;&#x9988;<b'.'></f'.'ont'.'>';
	echo '<script type="text/JavaScript">parent.document.title = \''.$dtitle.'\';if(parent.$(\'admincpnav\')) parent.$(\'admincpnav\').innerHTML=\''.$title.$addtomenu.'\';</script>';
}
if(defined('IN_ADMINCP')) {
   s_shownav('style', 'nav_setting_customnav');
}
?>

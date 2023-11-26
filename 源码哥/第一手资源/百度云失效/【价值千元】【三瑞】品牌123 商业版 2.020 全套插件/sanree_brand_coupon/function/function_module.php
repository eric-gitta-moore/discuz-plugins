<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: function_module.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
function coupon_fixdiscount($price, $minprice){
    $discount = ((1 - ($price - $minprice) / $price) * 10);
	$cb = sprintf("%01.1f", $discount);	
	$cb = str_replace('.0', '',$cb);
	return $cb;
}

function coupon_add_diy_template($template, $arr){

	global $_G;
	$template = stripslashes($template);
	include_once libfile('function/block');
	block_parse_template($template, $arr);
	$appVer = $_G['setting']['version'];
	if ($appVer!='X2') {
		$arr = daddslashes($arr);
	}	
	$hash=$arr['hash'];
	$result = C::t('#sanree_brand#sanree_brand_businesses')->fix_get_block($hash);
	if($result) {
	
		C::t('#sanree_brand#sanree_brand_businesses')->fix_update_block($hash,$arr);
		
	} else {
	
		C::t('#sanree_brand#sanree_brand_businesses')->fix_insert_block($arr);
			
	}
	
	require_once libfile('function/cache');
	updatecache('blockclass');
	blockclass_cache();	
		
}

function coupon_diystyle() {

	global $_G;
	$style = '';
	$condition = array();
	$condition[]= 'status=1';
	$orderby = 'displayorder, diystyleid';
	$stamplist=C::t('#sanree_brand_coupon#sanree_brand_coupon_diystyle')->fetch_all_by_search($condition, $orderby);
	foreach($stamplist as $key => $val) {

	    $val['content'] = unserialize($val['content']) ? unserialize($val['content']) : $val['content'];
	    $val['content'] = str_replace('stylename', $val['name'], $val['content']);
		$val['content'] = fixhtmlstr($val['content']);
		$style.= $val[content]."\r\n";
		
	}	
	diystylelog($style, "sanree_brand_coupon_diy.css");
	
}

function coupon_diytemplate($diytemplateid = 0) {

	global $_G;
	$style = '';
	$condition = array();
	$condition[]= 'status=1';
	if ($diytemplateid>0) {
	
		$condition[]= 'diytemplateid='.$diytemplateid;
		
	}
	$orderby = 'displayorder, diytemplateid';
	$stamplist=C::t('#sanree_brand_coupon#sanree_brand_coupon_diytemplate')->fetch_all_by_search($condition, $orderby);
	foreach($stamplist as $key => $val) {
	
	    $val['name'] = $val['issys']==1 ? srlang('neizhi').$val['name'] : $val['name'];
		$arr = array(
			'name' => $val['name'],
			'blockclass' => 'sanree_brand_coupon',
		);	
		$val['content'] = unserialize($val['content']) ? unserialize($val['content']) : $val['content'];
		$val['content'] = fixhtmlstr($val['content']);
		coupon_add_diy_template($val['content'], $arr);
		
	}		
	
}

function coupon_srconvertunusedattach($aid, $tid, $pid, $uid, $description) {
	global $_G;
	if(!$aid) {
		return;
	}
	$attach = C::t('#sanree_brand#forum_attachment_n')->fetch_by_aid_uid(127, $aid, $uid);
	if ((!$attach)&&($uid != $_G['uid'])) {
		$attach = C::t('#sanree_brand#forum_attachment_n')->fetch_by_aid_uid(127, $aid, $_G['uid']);
	}
	if(!$attach) {

		///C::t('#sanree_brand#forum_attachment_n')->update('aid:'.$aid, array('aid' => $aid),array('description' => censor(cutstr(dhtmlspecialchars($description), 100))));
		
	} else {
		$attach = daddslashes($attach);
		$attach['tid'] = $tid;
		$attach['pid'] = $pid;
		///$attach['description'] = censor(cutstr(dhtmlspecialchars($description), 100));
		C::t('#sanree_brand#forum_attachment_n')->insert('tid:'.$tid, $attach);
		C::t('#sanree_brand#forum_attachment')->update($attach['aid'], array('tid' => $tid, 'pid' => $pid, 'tableid' => getattachtableid($tid)));
		C::t('#sanree_brand#forum_attachment_unused')->delete($attach['aid']);
	}
	
}

function coupon_setattachment($bid, $caidstr, $tid, $pid, $homeaid, $uid) {

	global $_G;
	$aids = explode("|", $caidstr);	

	$inaddstr = '';
	foreach($aids as $aid) {
	
		coupon_srconvertunusedattach($aid, $tid, $pid, $uid, $_G['sr_attachnew'][$aid][description]);
		$inaddstr.= '[attach]'.$aid.'[/attach]'."\r\n";
		
	}
	$tidata = C::t('#sanree_brand#forum_post')->fetch_threadpost_by_tid_invisible($tid);
	$message = $tidata['message'];
	$message = preg_replace('/\[attachcoupon\]/is', $inaddstr, $message);
	$message = preg_replace('/\[poster\]/is', '[attach]'.$homeaid.'[/attach]', $message);
	C::t('#sanree_brand#forum_post')->update(0, $pid, array('message'=> $message, 'attachment' => 1), TRUE);

}

function coupon_chkmodeend($result,$isshow = TRUE) {
	global $_G, $enddatetip;
	if (!$result['enddate']) return false;
	if (TIMESTAMP > $result['enddate']) {
	
		if ($isshow) {
			showmessage($enddatetip);
		}
		return true;
	
	}
	return false;
} 

function coupon_gethome($coupon) {
	global $_G;
	if (!$coupon) {
		return 'static/image/common/nophoto.gif';
	}
	require_once libfile('function/post');
	loadcache('groupreadaccess');
	$tid = $_G['tid'] = intval($coupon['tid']);
	$attachs =  getattach($coupon[pid]);
	if ($attachs['attachs']['used']) {
		foreach($attachs['attachs']['used'] as $key => $value) {
			if ($value['aid'] == $coupon[homeaid]) {
			
				return coupon_getforumimg($value['aid'], 1, 300, 300, 'fixnone').'&ramdom='.random(5);
				
			}
		}
		return coupon_getforumimg($attachs['attachs']['used'][0]['aid'], 1, 300, 300, 'fixnone').'&ramdom='.random(5);
	}
	return 'static/image/common/nophoto.gif';
}
function coupon_dsign($str, $length = 16){
	return substr(md5(getglobal('uid').$str.getglobal('authkey')), 0, ($length ? max(8, $length) : 16));
}

function coupon_getforumimg($aid, $nocache = 0, $w = 140, $h = 140, $type = '') {
	global $_G;
	$key = coupon_dsign($aid.'|'.$w.'|'.$h);
	return 'plugin.php?id=sanree_brand_coupon&mod=image&aid='.$aid.'&size='.$w.'x'.$h.'&key='.rawurlencode($key).($nocache ? '&nocache=yes' : '').($type ? '&type='.$type : '');
}

function coupon_fixthreadpic($aid, $ispic = 0){
	$pic = coupon_getforumimg($aid, 0, 600, 0, 'fixnone');
	if ($ispic==1) return $pic;
	$picstr = '<img style="cursor:pointer;" id="aimg_'.$aid.'"  src="'.$pic.'" onclick="zoom(this, this.src)" onload="centerimg(this)" />';
	return $picstr;
}

function coupon_shtmlspecialchars($string){
	return str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>') , $string);
}

function coupon_brandgetburl($bid){
	global $_G;
	$config = $_G['cache']['plugin']['sanree_brand'];
	$is_rewrite = $config['is_rewrite'];
	$brand = C::t('#sanree_brand#sanree_brand_businesses')->fetch_first_bybid($bid);
	$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid(intval($brand['groupid']));
	if ($group['urlmod'] == 1|| $config['isonepage'] ==1 ) {
		if ($is_rewrite) {
			$keylist = array('tid');
			$tid  = $bid;
			$urlitemmode = empty($config['urlitemmode']) ? "brand-item-{tid}.html": $config['urlitemmode'];
			foreach($keylist as $line) {
				$urlitemmode = str_replace("{".$line."}",$$line ,$urlitemmode);
			}
			return $urlitemmode;
		}
		return 'plugin.php?id=sanree_brand&mod=item&tid='.$bid;
	}
	return 'forum.php?mod=viewthread&amp;tid='.$brand[tid];
}
function coupon_showsetting($title, $id, $allkey, $allvalue, $type){
    global $lang;
if ($type == 'mcheckbox') {
		$allvalue= is_array($allvalue) ? $allvalue : dunserialize($allvalue);
		$groupstr = '';
		foreach($allkey as $key => $value) {
			if($value['available']) {
				if(in_array($value['value'], $allvalue)) {
					$checked = ' checked="checked" ';
					$class = ' class="checked" ';
				} else {
					$class = $checked = '';
				}
				$groupstr .= "<li $class style=\"float: left; width: 10%;\"><input type=\"checkbox\" value=\"$value[value]\" name=\"$value[available][]\" class=\"checkbox\" $checked>&nbsp;$value[title]</li>";
			}
		}
		print <<<EOF
			<tr>
				<td class="td27" colspan="2" s="1">$title:</td>
			</tr>
			<tr>
				<td class="td27" colspan="2">

					<ul class="dblist" onmouseover="altStyle(this);">
						<li style="width: 100%;"><input type="checkbox" name="chkall$id" onclick="checkAll('prefix', this.form, '$id', 'chkall$id')" class="checkbox">&nbsp;$lang[select_all]</li>
						$groupstr
					</ul>
				</td>
			</tr>
EOF;
	}
}
//From:www_YMG6_COM
?>
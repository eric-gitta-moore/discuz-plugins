<?php



/*
 *源   码 哥  y     m   g    6  . c o   m
 *更多商业插件/模版免费下载 就在源     码 哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */



if(!defined('IN_DISCUZ')) {

	exit('Access Denied');

}



class plugin_taobo_img {



	/**

	 * setting

	 * @var array

	 */

	protected $setting;



	/**

	 * 插件开关

	 * @var bool

	 */

	protected $enable;



	/**

	 * 游客开启

	 * @var bool

	 */

	protected $guestenable;



	/**

	 * 会员回帖看大图

	 * @var bool

	 */

	protected $memberenable;



	/**

	 * x2的数据

	 * @var string

	 */

	protected $x2output;



	public function __construct() {

		global $_G;

		$this->setting = &$_G['cache']['plugin']['taobo_img'];

		$this->setting['disforums'] = !empty($this->setting['disforums']) ? unserialize($this->setting['disforums']) : array();

		$this->guestenable = $_G['groupid'] == 7 && (!in_array($_G['forum']['fid'], $this->setting['disforums'])) && !$_G['inajax'];

		if(!$this->guestenable && empty($this->setting['closedneedreply']) && !$_G['inajax']) {

			$this->setting['disneedreplyforums'] = !empty($this->setting['disneedreplyforums']) ? unserialize($this->setting['disneedreplyforums']) : array();

			$this->setting['disneedreplygroups'] = !empty($this->setting['disneedreplygroups']) ? unserialize($this->setting['disneedreplygroups']) : array();

			$this->memberenable = ($_G['uid'] && $_G['thread']['tid'] && !in_array($_G['forum']['fid'], $this->setting['disneedreplyforums']) && !in_array($_G['member']['groupid'], $this->setting['disneedreplygroups']));

			if($this->memberenable) {

				$this->memberenable = !($_G['setting']['version'] == 'X2' ?

					DB::result_first('SELECT COUNT(*) FROM '.DB::table(getposttablebytid('tid:'.$_G['thread']['tid'])).' WHERE tid='.$_G['thread']['tid'].' AND invisible=0 AND authorid='.$_G['uid'])

					: C::t('forum_post')->count_by_tid_invisible_authorid($_G['thread']['tid'], $_G['uid']));

			}

		}

		if(($this->enable = $this->guestenable || $this->memberenable)) {

			$_G['setting']['attachrefcheck'] = $_G['forum']['allowgetimage'] = $_G['group']['allowgetimage'] = 1;

		}

	}



	public function viewthread_postfooter_output() {

		global $_G, $postlist, $aimgs;

		$data = array();

		if($_G['setting']['version'] == 'X2' && $this->enable) {

			$i = 0;

			foreach ($postlist as $pid => $post) {

				if(strpos($post['message'], '<img') !== false && empty($aimgs[$pid])) {

					$data[$i++] = '<script>aimgcount['.$pid.']=[];attachimggroup('.$pid.');</script>';

					if(!isset($this->x2output)) {

						$this->x2output = true;

					}

				}

			}

		}

		return $data;

	}



	public function viewthread_posttop_output() {

		global $_G, $aimgs;

		$ret = $loginmsg = $css = '';

		if($this->enable) {

			$autopen = intval($this->setting['autopen']);

			$hasimg = $_G['thread']['attachment'] || $aimgs || isset($this->x2output);

			$autoopen = ($autopen == 1 && $hasimg || $autopen == 2) && !$this->memberenable;

			$autopentime = intval($this->setting['autopentime']) * 1000;



			if($_G['setting']['version'] == 'X2') {

				$addcss = <<<EOT

.attach_nopermission a { color: #336699;}

.attach_nopermission { background: url("./source/plugin/taobo_img/template/attach_nopermission_bg.png") no-repeat scroll 100% 0 #FFFFEE; border: 1px dashed #AAAA92; margin: 10px 0; width: 600px;}

.attach_nopermission div { background: url("./source/plugin/taobo_img/template/attach_nopermission.png") no-repeat scroll 15px 15px transparent; border: 3px solid #FFFFFF; padding: 20px 0 20px 70px;}

.attach_nopermission:hover div { border-color: #DADAB1;}

EOT;

				$addjs2 = <<<EOT

	try{

		var _imgs = \$C('pct', $('pid'+pid))[0].getElementsByTagName('img');

		for(var i = 0; i < _imgs.length; i++) {

			if(!_imgs[i].getAttribute('id') && !_imgs[i].getAttribute('alt') && _imgs[i].getAttribute('border') == '0') {

				var id = '_' + parseInt(Math.random()*100000);

				_imgs[i].setAttribute('id', 'aimg_' + id);

				aimgcount[pid].push(id);

			}

		}

	} catch (e) {}

EOT;

			}



			if($hasimg) {

				$fid = $_G['forum']['fid'];

				$tid = $_G['thread']['tid'];

				$imgwidth = intval($this->setting['imgwidth']);

				$imgheight = intval($this->setting['imgheight']);

				if(!$imgwidth) $imgwidth = 50;

				if(!$imgheight) $imgheight = 50;

				$imgurls = '';

				foreach ($aimgs as $aids) {

					foreach ($aids as $aid) {

						if(is_numeric($aid)) {

							$imgurls .= '"'.$aid.'"'.':"'.self::getforumimg($aid, 0, $imgwidth, $imgheight).'",';

						}

					}

				}

				$imgurls = '{'.rtrim($imgurls, ',').'}';

				if($this->memberenable) {

					$onclick_url = 'forum.php?mod=post&action=reply&fid='.$fid.'&tid='.$tid;

					$onclick_add = '\'+\'&reppost=\'+pid+\'';

					$onclick_tips = lang('plugin/taobo_img', 'onclick_tips2');

					$eleid = 'reply';

					$js_appendreply = 'appendreply = succeedhandle_fastpost = function(){location.reload();};';

				} else {

					$onclick_url = 'member.php?mod=logging&action=login&cookietime=1&tbimgfrom=viewthread';

					$onclick_add = '';

					$onclick_tips = lang('plugin/taobo_img', 'onclick_tips1');

					$eleid = 'login';

					$js_appendreply = '';

				}





				$parse = parse_url($_G['setting']['attachurl']);

				$attachurl = !isset($parse['host']) ? $_G['siteurl'].$_G['setting']['attachurl'] : $_G['setting']['attachurl'];



				$addjs = $addjs2 = $addcss = '';

				if(!empty($_G['setting']['lazyload'])) {

					$addjs = <<<EOT

attachimggroup = function (pid) {

	if(!zoomgroupinit[pid]) {

		for(i = 0;i < aimgcount[pid].length;i++) {

			zoomgroup['aimg_' + aimgcount[pid][i]] = pid;

		}

		zoomgroupinit[pid] = true;

	}

	attachimgshow(pid);

};

EOT;

				}



				$ret = <<<EOT

<script>

(function () {

	var attachdir = '$attachurl';

	var imgurls = $imgurls;

	$js_appendreply$addjs

	attachimgshow = function (pid, onlyinpost) {

		onlyinpost = false;

		$addjs2

		aimgs = aimgcount[pid];

		aimgcomplete = 0;

		loadingcount = 0;

		for(i = 0;i < aimgs.length;i++) {

			obj = $('aimg_' + aimgs[i]);

			if(!obj) {

				aimgcomplete++;

				continue;

			}



			if(onlyinpost && obj.getAttribute('inpost') || !onlyinpost) {

				if(!obj.getAttribute('status')) {

					obj.setAttribute('status', 1);

					var imgwidth = parseInt(obj.getAttribute('width'));

					var attr_aid = obj.getAttribute('aid');

//					//（图片中没有aid || aid不是数字）&& 图片有宽度属性 && 宽度属性值 < $imgwidth || 图片是back.gif

					if((attr_aid === null || isNaN(attr_aid)) && imgwidth && imgwidth < $imgwidth || obj.src && obj.src.indexOf('image/common/back.gif') > 0 || obj.getAttribute('file') && obj.getAttribute('file').indexOf('image/common/back.gif') > 0) {

						aimgcomplete++;continue;

					}

					//其它情况需要进行添加文字说明和缩小处理

					var old = obj;

					obj = old.cloneNode(true);

					obj.removeAttribute('width');

					obj.removeAttribute('height');

					obj.className = obj.className + ' tbimg_cur';

					obj.onclick=function(){showWindow('$eleid', '{$onclick_url}{$onclick_add}&referer='+encodeURIComponent(location));};

					if(obj.getAttribute('file') && !isNaN(aimgs[i])) {

						//_attachEvent(obj, 'error', function(){if(this.getAttribute('makefile')){ this.removeAttribute('makefile');this.src=this.getAttribute('makefile');}});

						obj.onerror = function(){if(this.getAttribute('makefile')){this.src=this.getAttribute('makefile'); this.removeAttribute('makefile');}};

						obj.setAttribute('makefile', imgurls[aimgs[i]]);

						obj.setAttribute('file', '');

						obj.src = attachdir+thumbpath(aimgs[i], $imgwidth, $imgheight);

					}

					var parent = old.parentNode;

					var dom = document.createElement('div');

					dom.className = 'tbimg_div';

					dom.innerHTML = '<br><a href="$onclick_url$onclick_add" onclick="showWindow(\'$eleid\', this.href+\'&referer=\'+encodeURIComponent(location));">$onclick_tips</a>';

					dom.insertBefore(obj, dom.firstChild);

					parent.replaceChild(dom, old);

					loadingcount++;

				} else if(obj.status == 1) {

					if(obj.complete) {

						obj.status = 2;

					} else {

						loadingcount++;

					}

				} else if(obj.status == 2) {

					aimgcomplete++;

					if(obj.getAttribute('thumbImg')) {

						thumbImg(obj);

					}

				}

				if(loadingcount >= 10) {

					break;

				}

			}

		}

		if(aimgcomplete < aimgs.length) {

			setTimeout(function () {

				attachimgshow(pid, onlyinpost);

			}, 100);

		}

	};



	attachimglstshow = function (pid, islazy) {

		var aimgs = aimgcount[pid];

		if(typeof aimgcount == 'object' && $('imagelistthumb_' + pid)) {

			for(pid in aimgcount) {

				var imagelist = '';

				for(i = 0;i < aimgcount[pid].length;i++) {

					if((parseInt(aimgcount[pid][i]) != aimgcount[pid][i]) || (!$('aimg_' + aimgcount[pid][i]) || $('aimg_' + aimgcount[pid][i]).getAttribute('inpost'))) {

						continue;

					}

					imagelist += '<div class="pattimg">' + '<a class="pattimg_zoom tbimg_cur" href="$onclick_url$onclick_add" onclick="showWindow(\'$eleid\', this.href+\'&referer=\'+encodeURIComponent(location))" title="$onclick_tips">$onclick_tips</a>' +

					'<img ' + (islazy ? 'file' : 'src') + '='+imgurls[aimgcount[pid][i]]+' width="$imgwidth" height="$imgheight" /></div>';

				}

				if($('imagelistthumb_' + pid)) {

					$('imagelistthumb_' + pid).innerHTML = imagelist;

				}

			}

		}

	};



	function thumbpath(aid, w, h) {

		var aid = (Array(9).join(0) + aid).slice(-9);

		dir1 = aid.substr(0, 3);

		dir2 = aid.substr(3, 2);

		dir3 = aid.substr(5, 2);

		return 'image/'+dir1+'/'+dir2+'/'+dir3+'/'+aid.substr(7, 2)+'_'+w+'_'+h+'.jpg';

	}



})();



</script>

EOT;

			}

			if($autoopen) {

				$ret .= $this->_footer_login($autopentime);

			}



			if(!empty($this->setting['loginnoticeflag']) && !$this->memberenable) {

				$logintxt = '<a href="member.php?mod='.$_G['setting']['regname'].'" title="'.$_G['setting']['reglinkname'].'" class="pn pnc"><strong>'.$_G['setting']['reglinkname'].'</strong>'.

						'</a> '.lang('plugin/taobo_img', 'has_account_number').'<a href="member.php?mod=logging&action=login&tbimgfrom=viewthread" onclick="showWindow(\'login\', this.href+\'&referer=\'+encodeURIComponent(location));return false;">'.lang('plugin/taobo_img', 'onclick_login').'</a>';

				if($_G['setting']['connect']['allow']) {

					$logintxt .= ' '.lang('plugin/taobo_img', 'or').' <a href="'.$_G['connect']['login_url'].'&statfrom=taobo_img"><img src="'.$_G['style']['imgdir'].'/qq_login.gif" class="vm" alt="'.lang('plugin/taobo_img', 'qqconnect').'" /></a>';

					if($this->setting['otherlogintxt']) {

						$logintxt .= ' '.$this->setting['otherlogintxt'];

					}

				}



				$loginmsg = <<<EOT

	<div class="attach_nopermission">

		<div>

			<h3><strong>{$this->setting['loginnotice']}</strong></h3>

			<p>$logintxt</p>

		</div>

		<span class="atips_close" onclick="this.parentNode.style.display='none'">x</span>

	</div>

EOT;

			}

			$css = <<<EOT

<style type="text/css">

.tbimg_cur {cursor:url(/source/plugin/taobo_img/template/scf.cur), default;  max-width:{$imgwidth}px; }

.ie6 .tbimg_cur { width:{$imgwidth}px !important;}

.tbimg_div {margin:10px auto; text-align:center;}

.tbimg_div a {font-size:12px;}$addcss

.attach_nopermission {width:98%; margin-bottom:15px; position: relative;}

.attach_nopermission h3 strong { color: #8CA226; font-size:15px; display:block; margin-bottom: 10px; margin-top: -10px;}

.attach_nopermission .atips_close { position: absolute; top: 5px; right: 10px; width: 10px; height: 10px; cursor: pointer; color: #ccc; }

.attach_nopermission:hover .atips_close { color: #333; }

.attach_nopermission .atips_close:hover { font-weight: bold; }

</style>

EOT;

		}

		return array($css.$loginmsg.$ret);

	}



	public function viewthread_posttop() {

		return array();

	}



	protected function _footer_login($autopentime){

		global $_G;

		$verhash = VERHASH;

		$jspath = $_G['setting']['jspath'].'logging.js?'.$verhash;

		$pwdsafety = $_G['setting']['pwdsafety'] ? "pwmd5('ls_password_tbimg');" : '';

		$addjs = "<script type=\"text/javascript\" src=\"{$_G['setting']['jspath']}md5.js?{$verhash}\" reload=\"1\"></script>";

		$connect = '';

		$lang_close = lang('core', 'close');

		$lang = lang('plugin/taobo_img');



		if($_G['setting']['connect']['allow']) {

			$connect = '<div class="mbn">'.$lang['other_account'].'</div>'.'<div> <a href="'.$_G['connect']['login_url'].'&statfrom=taobo_img"><img src="'.$_G['style']['imgdir'].'/qq_login.gif" class="vm" alt="'.lang('plugin/taobo_img', 'qqconnect').'" /></a>';

			if($this->setting['otherlogintxt']) {

				$connect .= ' '.$this->setting['otherlogintxt'];

			}

			$connect .= '</div>';

		}

		$colorid = 0;

		$bdcolorarr = array('#D2E0B1', '');

		$textcolorarr = array('#8CA226', '#008BE4');

		$bgcolorarr = array(

			array('D9E6BB', 'CAE2FF'),

			array('217,230,187', '202,226,255')

		);

		$bdcolor = $bdcolorarr[$colorid];

		$textcolor = $textcolorarr[$colorid];

		$bgcolor16 = $bgcolorarr[0][$colorid];//十六进制色值

		$bgcolor10 = $bgcolorarr[1][$colorid];//十进制色值

		return <<<EOT

<style>

.login-wrap{position:fixed;left:0;bottom:0;width:100%;_position:absolute;z-index:999;display:none;}.login-box{padding:18px 0 7px;border-top:1px solid {$bdcolor};border-bottom:1px solid {$bdcolor};box-shadow:2px 2px 6px {$textcolor};background:rgb({$bgcolor10});background: rgba({$bgcolor10}, 0.9);filter:progid:DXImageTransform.Microsoft.gradient(enabled='true',startColorstr='#E5{$bgcolor16}',endColorstr='#E5{$bgcolor16}');}.login-user{position:relative;margin:0 auto;width:980px;height:70px;}.login-user a,.login-user a:visited{color:#666;}.login-user a:hover{color:#0657B2;}.login-user .txt{padding:3px;border:1px solid #D8D8D8;color:#333;}.login-user .txt:hover,.login-user .txt:focus{border-color:#7DBDE2;}.login-title,.login-cont,.login-ft{display:inline;position:relative;}.login-title{color:{$textcolor};margin-bottom:14px;margin-right:10px;}.login-title h3{margin-top:3px;height:30px;font:400 24px/30px "Microsoft YaHei",SimHei;}.login-title .login-arrow{margin-top:8px;width:30px;height:18px;background:url("./source/plugin/taobo_img/template/login_common.png") no-repeat;}.login-cont{height:63px;}.login-cont .mg0{margin:0;}.login-cont .txt{float:left;margin-bottom:10px;width:140px;height:25px;line-height:25px;color:#999;font-size:14px;zoom:1;}.login-cont .login-captcha{width:112px;}.login-cont .login-captcha .txt{margin-bottom:0;}.login-cont ul{position:absolute;top:0;left:0;width:720px;}.login-cont li{display:inline;float:left;margin-right:10px;height:80px;overflow:hidden;}.login-cont .login-item{color:#666;clear:both;}.login-cont .login-item input{margin-top:-2px;}.login-button em{color: #fff;}.login-cont .login-button,.login-cont .login-button:visited{display:block;float:left;width:64px;color:#fff;border:1px solid #b9c97d;border-radius:6px;font-size:14px;font-weight:700;height:33px;line-height:33px;margin-right:10px;text-align:center;background:#7f9c14;background:-moz-linear-gradient(top,#abbf42,#8ea423);background:-webkit-linear-gradient(top,#abbf42,#8ea423);}.login-cont .login-button:hover{border:1px solid #b9c97d;border-radius:6px;text-decoration:none;color:#fff;background-position:0 -108px;background:#a8b748;background:-moz-linear-gradient(top,#c4d323,#a8b748);background:-webkit-linear-gradient(top,#c4d323,#a8b748);}.login-cont .login-label{float:left;font-size:14px;width:112px;display:none;}.login-cont .login-qt{width:77px;height:60px;border-right:1px solid #B4C574;}#J_loginGuide .login-shortcut{margin-top:20px;}.not-regist{padding-top:10px;}.popo-id{position:absolute;top:-40px;left:0;z-index:998;}.box-close{ cursor: pointer; overflow: hidden; position: absolute; right: 10px;top:10px;padding-top:19px;width:20px;height:0px;background:url("./source/plugin/taobo_img/template/login_common.png") no-repeat 0 -21px; text-indent: 50px;}.box-close:hover{background:url("./source/plugin/taobo_img/template/login_common.png") no-repeat 0 -40px;}

</style>

<div class="login-wrap" id="tbimg_footer_login">

	<script type="text/javascript" src="{$jspath}"></script>

	<script type="text/javascript">

		function lsSubmit_tbimg(op) {

			var op = !op ? 0 : op;

			if(op) {

				$('lsform_tbimg').cookietime.value = 2592000;

			}

			if($('ls_username_tbimg').value == '' || $('ls_password_tbimg').value == '') {

				showWindow('login', 'member.php?mod=logging&action=login' + (op ? '&cookietime=1' : ''));

			} else {

				ajaxpost('lsform_tbimg', 'return_ls_mimto', 'return_ls_mimto');

			}

			return false;

		}

	</script>

	<span id="return_ls_mimto" style="display:none"></span>

	<div class="login-box">

		<div class="login-user cl">

			<div class="login-title z cl">

				<h3 class="z">{$lang['have_a_look']}</h3>

				<span class="login-arrow z"></span>

			</div>

			<div class="login-cont z">

				<ul>

					<form method="post" autocomplete="off" id="lsform_tbimg" action="member.php?mod=logging&action=login&loginsubmit=yes&infloat=yes&lssubmit=yes" onsubmit="{$pwdsafety}return lsSubmit_tbimg();">

						<li>

							<input type="text" placeholder="{$lang['input_username']}" name="username" id="ls_username_tbimg" class="txt px vm xg1" tabindex="801" />

							<div class="login-item">

								<label for="ls_cookietime_tbimg">

									<input type="checkbox" name="cookietime" id="ls_cookietime_tbimg" class="checkbox pc" value="2592000" tabindex="803" checked="checked" />{$lang['login_permanent']}

								</label>

							</div>

						</li>



						<li>

							<input type="password" placeholder="{$lang['input_password']}" name="password" id="ls_password_tbimg" class="txt px vm" autocomplete="off" tabindex="802" />

							<div class="login-item">

								<a href="member.php?mod=logging&action=login&viewlostpw=1" target="_blank" onclick="showWindow('login', this.href);return false;">{$lang['forgotpw']}</a>

							</div>

						</li>

						<li class="login-qt">

							<button type="submit" class="login-button " tabindex="804" style="height: auto;"><em>{$lang['login']}</em></button>

							<div class="login-item">

								<a href="member.php?mod={$_G[setting][regname]}" class="xi2" target="_blank" >{$lang['reglinkname']}</a>

							</div>

						</li>

						<li class="login-shortcut color6">

						$connect

						</li>

						<input type="hidden" name="quickforward" value="yes" />

						<input type="hidden" name="handlekey" value="ls" />

					</form>

				</ul>

			</div>

		</div>

		<a href="javascript:;" title="$lang_close" class="box-close" onclick="this.parentNode.parentNode.style.display='none';">$lang_close</a>

	</div>

	$addjs

</div>

<script>setTimeout(function(){

	var dom = \$('tbimg_footer_login');

	dom.style.display="block";

	if (BROWSER.ie && BROWSER.ie < 7) {

		function _fix_ie6(){

			if(dom.style.display == 'block'){

				dom.style.bottom = 'auto';

				dom.style.bottom = '0';

			}

		}

		dom.style.width = document.body.clientWidth;

		dom.style.bottom = '0';

		_attachEvent(window, 'scroll', _fix_ie6);

	}

}, $autopentime);</script>

EOT;

		//$ret .= "<script>setTimeout(function(){showWindow('login', 'member.php?mod=logging&action=login&cookietime=1&tbimgfrom=viewthread&referer='+encodeURIComponent(location));}, $autopentime);</script>";

	}

	/**

	 * 返回论坛缩放附件图片的地址 url

	 */

	static function getforumimg($aid, $nocache = 0, $w = 140, $h = 140, $type = '') {

		global $_G;

		$key = self::dsign($aid.'|'.$w.'|'.$h);

		return 'source/plugin/taobo_img/forum_image.php?aid='.$aid.'&size='.$w.'x'.$h.'&key='.rawurlencode($key).($nocache ? '&nocache=yes' : '').($type ? '&type='.$type : '');

	}



	/**

	 * 数据签名

	 * @param string $str 源数据

	 * @param int $length 返回值的长度，8-32位之间

	 * @return string

	 */

	static function dsign($str, $length = 16){

		return substr(md5(getglobal('uid').$str.getglobal('authkey')), 0, ($length ? max(8, $length) : 16));

	}



	static function thumbpatch($aid, $dw, $dh) {

		$aid = sprintf("%09d", $aid);

		$dir1 = substr($aid, 0, 3);

		$dir2 = substr($aid, 3, 2);

		$dir3 = substr($aid, 5, 2);

		return 'image/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($aid, -2).'_'.$dw.'_'.$dh.'.jpg';

	}

}



class plugin_taobo_img_forum extends plugin_taobo_img {



}



class plugin_taobo_img_group extends plugin_taobo_img {



}



?>
<?php

if (!defined("IN_DISCUZ")) {
	exit("Access Denied");
}
class plugin_keke_xzhseo
{
	public function __construct()
	{
		global $_G;
		global $article;
		if (!defined("CLOUDADDONS_WEBSITE_URL")) {
			require_once libfile("function/cloudaddons");
		}
		include_once DISCUZ_ROOT . "source/plugin/keke_xzhseo/identity.inc.php";
		$check = array();
		$uskey = substr(md5("keke_xzhseo" . $_G["siteurl"]), 0, 7);
		loadcache($uskey);
		$check = $_G["cache"][$uskey];
		require_once libfile("function/cache");
		$addonid = "keke_xzhseo.plugin";
		$array = cloudaddons_getmd5($addonid);
		$comparison = md5($array["SN"] . $array["RevisionID"]);
		if ($_GET["aid"] || $_G["tid"] || CURSCRIPT == "admin") {
			if (!$check["stylecache"] || $check["time"] + 3600 < $_G["timestamp"]) {
				if (K_XZH_SITEKEY == $comparison) {
					savecache($uskey, "");
					//exit("keke_xzhseo_err(101)");
				}
				if ($this->cloudaddons_opens("&mod=app&ac=validator&addonid=" . $addonid . (!($array === false) ? "&rid=" . $array["RevisionID"] . "&sn=" . $array["SN"] . "&rd=" . $array["RevisionDateline"] : "")) === "0") {
					savecache($uskey, "");
					//exit("keke_xzhseo_err(102)");
				} else {
					$info["time"] = $_G["timestamp"];
					$info["stylecache"] = "1";
					savecache($uskey, $info);
				}
			}
			if (K_XZH_SITEKEY == $comparison) {
				//exit("keke_xzhseo_err(103)");
			}
		}
		$this->keke_xzhseo = $_G["cache"]["plugin"]["keke_xzhseo"];
		$this->perform = 1;
		$this->fid = $_G["fid"];
		$this->section = empty($this->keke_xzhseo['bk']) ? array() : unserialize($this->keke_xzhseo["bk"]);
		if (!empty($this->section[0]) && !in_array($this->fid, $this->section)) {
			$this->perform = 0;
		}
		if (CURSCRIPT == "forum") {
			$this->moda = 2;
			$this->atid = $_G["tid"];
			$this->urla = "forum.php?mod=viewthread&tid=" . $this->atid;
			if (in_array("forum_viewthread", $_G["setting"]["rewritestatus"])) {
				$this->urla = rewriteoutput("forum_viewthread", 1, "", $this->atid, $_GET["page"]);
			}
			$userarr = getuserbyuid($_G["thread"]["authorid"]);
			$this->authorgid = $userarr["groupid"];
		} else {
			if (CURSCRIPT == "portal") {
				$this->moda = 1;
				$this->atid = intval($_GET["aid"]);
				$this->urla = "portal.php?mod=view&aid=" . $this->atid;
				if (in_array("portal_article", $_G["setting"]["rewritestatus"])) {
					$this->urla = rewriteoutput("portal_article", 1, "", $this->atid, $_GET["page"]);
				}
				$userarr = getuserbyuid($article["uid"]);
				$this->authorgid = $userarr["groupid"];
			}
		}
		$this->yhz = 1;
		$this->groups = empty($this->keke_xzhseo['yhz']) ? array() : unserialize($this->keke_xzhseo["yhz"]);
		if (!empty($this->groups[0]) && !in_array($this->authorgid, $this->groups)) {
			$this->yhz = 0;
		}
		$this->urla = $_G["siteurl"] . $this->urla;
		if ($this->moda == 2 && (!$_G["thread"]["isgroup"] && $this->perform || $_G["thread"]["isgroup"] && $this->keke_xzhseo["qz"]) || $this->moda == 1 && $this->keke_xzhseo["wz"]) {
			$this->postdata = C::t("#keke_xzhseo#keke_xzhseo")->fetchfirst_byatid($this->atid, $this->moda);
		}
		$this->backtime = strtotime($this->keke_xzhseo["time"]);
		$this->beginToday = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
		return NULL;
	}
	public function cloudaddons_opens($extra, $post = '', $timeout = 999)
	{
		global $_G;
		require_once DISCUZ_ROOT . "./source/discuz_version.php";
		$data = "siteuniqueid=" . rawurlencode($this->cloudaddons_getuniqueids()) . "&siteurl=" . rawurlencode($_G["siteurl"]) . "&sitever=" . DISCUZ_VERSION . "/" . DISCUZ_RELEASE . "&sitecharset=" . CHARSET . "&mysiteid=" . $_G["setting"]["my_siteid"];
		$param = "data=" . rawurlencode(base64_encode($data));
		$param .= "&md5hash=" . substr(md5($data . TIMESTAMP), 8, 8) . "&timestamp=" . TIMESTAMP;
		return dfsockopen(CLOUDADDONS_DOWNLOAD_URL . "?" . $param . "&from=s" . $extra, 0, $post, "", false, CLOUDADDONS_DOWNLOAD_IP, $timeout);
	}
	public function cloudaddons_getuniqueids()
	{
		global $_G;
		if (CLOUDADDONS_WEBSITE_URL == "http://addon.discuz.com") {
			return $_G["setting"]["siteuniqueid"] ? $_G["setting"]["siteuniqueid"] : C::t("common_setting")->fetch("siteuniqueid");
		}
		if (!$_G["setting"]["addon_uniqueid"]) {
			$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
			$addonuniqueid = $chars[date("y") % 60] . $chars[date("n")] . $chars[date("j")] . $chars[date("G")] . $chars[date("i")] . $chars[date("s")] . substr(md5($_G["clientip"] . TIMESTAMP), 0, 4) . random(6);
			C::t("common_setting")->update("addon_uniqueid", $addonuniqueid);
			require_once libfile("function/cache");
			updatecache("setting");
		}
		return $_G["setting"]["addon_uniqueid"];
	}
	public function _postbaidu($atid, $type, $mod)
	{
		global $_G;
		$var = $this->keke_xzhseo;
		include template("keke_xzhseo:ajax");
		return $ajax;
	}
	public function mkpiclist($pidarr)
	{
		global $_G;
		$m = 1;
		$mcount = count($pidarr) == 2 ? 1 : 3;
		foreach ($pidarr as $k => $v) {
			if ($m > $mcount) {
				break;
			}
			if ($this->moda == 2) {
				if (strpos($v["url"], "http") !== false) {
					$moqu8= "\"" . $v["url"] . $v["attachment"] . "\",";
					 if(strpos($moqu8,".png")){
						 $pics .=$moqu8;}
					 if(strpos($moqu8,".jpg")){
							 $pics .=$moqu8;}
					 if(strpos($moqu8,".gif")){
							 $pics .=$moqu8;}else{
								$pics=$pics;
							 }
				} else {
					$moqu8= "\"" . $_G["siteurl"] . $v["url"] . $v["attachment"] . "\",";
					if(strpos($moqu8,".png")){
						 $pics .=$moqu8;}
					 if(strpos($moqu8,".jpg")){
							 $pics .=$moqu8;}
					 if(strpos($moqu8,".gif")){
							 $pics .=$moqu8;}else{
								$pics=$pics;
							 }
				}
			} else {
				$moqu8 .= "\"" . $_G["siteurl"] . $v . "\",";
				if(strpos($moqu8,".png")){
						 $pics .=$moqu8;}
					 if(strpos($moqu8,".jpg")){
							 $pics .=$moqu8;}
					 if(strpos($moqu8,".gif")){
							 $pics .=$moqu8;}else{
								$pics=$pics;
							 }
			}
			$m = $m + 1;
		}
		return substr($pics, 0, strlen($str) - 1);
	}
	public function _ireplacetime($dateline)
	{
		$datetime = str_ireplace("+00:00", "", date("c", $dateline));
		$datetime = str_ireplace("+08:00", "", $datetime);
		return $datetime;
	}
	public function _postdata($dateline)
	{
		if (!$this->postdata && $this->yhz && $this->keke_xzhseo["zd"]) {
			if ($dateline > $this->beginToday) {
				$ret = $this->_postbaidu($this->atid, 1, $this->moda);
			} else {
				if ($this->keke_xzhseo["ls"]) {
					$ret = $this->_postbaidu($this->atid, 2, $this->moda);
				}
			}
		}
		return $ret;
	}
	public function _cutmsg($msgs)
	{
		global $_G;
		global $article;
		$var = $this->keke_xzhseo;
		$cd = $val["cd"] ? intval($val["cd"]) : 120;
		if (!$msgs) {
			$msgs = $article["title"];
			if (CURSCRIPT == "forum") {
				$msgs = $_G["thread"]["subject"];
			}
		}
		$smsg = str_replace(array("\r\n", "\r", "\n"), "", cutstr(strip_tags(preg_replace("/(<i class=\\\"pstatus\\\">.*<\\/i>)/is", "", preg_replace("/(<ignore_js_op>.*<\\/ignore_js_op>)/is", "", $msgs))), $cd, ""));
		return $smsg;
	}
	public function global_header()
	{
		global $_G;
		global $postlist;
		global $content;
		global $article;
		$returnjs = $ret = $firstpostdata = $tsbtns = "";
		$sdarr = unserialize($this->keke_xzhseo["sd"]);
		if ($this->moda == 2 && $_G["tid"]) {
			$isgroup = $_G["thread"]["isgroup"];
			if ($isgroup && $this->keke_xzhseo["qz"] || !$isgroup && $this->perform) {
				$dateline = $_G["thread"]["dateline"];
				$datetime = $this->_ireplacetime($dateline);
				if ($_G["forum_firstpid"]) {
					$firstpostdata = $postlist[$_G["forum_firstpid"]];
				}
				$piclist = $this->mkpiclist($firstpostdata["attachments"]);
				$messages = $this->_cutmsg($firstpostdata["message"]);
				include template("keke_xzhseo:inc");
				$_G["setting"]["seohead"] .= $returns;
				$ret = $this->_postdata($dateline);
				if (checkmobile()) {
					$returnjs = $returns . $ret;
				}
				if (in_array($_G["groupid"], $sdarr)) {
					$tsbtns = $tsbtn;
				}
				if ($firstpostdata) {
					$postlist[$_G["forum_firstpid"]]["message"] = $returnjs . $tsbtns . $firstpostdata["message"];
				}
			}
		} else {
			if ($this->moda == 1 && $_GET["aid"]) {
				$dateline = strtotime($article["dateline"]);
				$datetime = $this->_ireplacetime($dateline);
				if ($this->keke_xzhseo["wz"]) {
					preg_match_all("/<img[^>]*src=['\"]?([^>'\"\\s]*)['\"]?[^>]*>/i", $content["content"], $out);
					$piclist = $this->mkpiclist($out[1]);
					$messages = $this->_cutmsg($content["content"]);
					include template("keke_xzhseo:inc");
					$_G["setting"]["seohead"] .= $returns;
					if (in_array($_G["groupid"], $sdarr)) {
						$tsbtns = $tsbtn;
					}
					$ret = $this->_postdata($dateline);
					if (checkmobile()) {
						$returnjs = $returns . $ret;
					}
					$content["content"] = $returnjs . $tsbtns . $content["content"];
				}
			}
		}
		return $ret;
	}
	public function _creurl($mods, $atid)
	{
		global $_G;
		if ($mods == 2) {//From w ww.mo qu 8.c om
			$urla = "forum.php?mod=viewthread&tid=" . $atid;
			if (in_array("forum_viewthread", $_G["setting"]["rewritestatus"])) {
				$urla = rewriteoutput("forum_viewthread", 1, "", $atid, $_GET["page"]);
			}
		} else {
			if ($mods == 1) {
				$urla = "portal.php?mod=view&aid=" . $atid;
				if (in_array("portal_article", $_G["setting"]["rewritestatus"])) {
					$urla = rewriteoutput("portal_article", 1, "", $atid, $_GET["page"]);
				}
			}
		}
		return $_G["siteurl"] . $urla;
	}
	public function _posttobaidu($atid, $mods, $type, $purl = array())
	{
		global $_G;
		$var = $_G["cache"]["plugin"]["keke_xzhseo"];
		if ($purl) {
			$urls = $purl;
		} else {
			if ($mods == 2) {
				$urla = "forum.php?mod=viewthread&tid=" . $atid;
				if (in_array("forum_viewthread", $_G["setting"]["rewritestatus"])) {
					$urla = rewriteoutput("forum_viewthread", 1, "", $atid, $_GET["page"]);
				}
				$thread = C::t("forum_thread")->fetch($atid);
				$subject = $thread["subject"];
			} else {
				if ($mods == 1) {
					$urla = "portal.php?mod=view&aid=" . $atid;
					if (in_array("portal_article", $_G["setting"]["rewritestatus"])) {
						$urla = rewriteoutput("portal_article", 1, "", $atid, $_GET["page"]);
					}
					$article = C::t("portal_article_title")->fetch($atid);
					$subject = $article["title"];
				}
			}
			$urls = array($_G["siteurl"] . $urla);
		}
		$typename = $type == 2 ? "batch" : "realtime";
		if (function_exists("curl_init") && function_exists("curl_exec")) {
			$uri = "http://data.zz.baidu.com/urls?appid=" . $var["appid"] . "&token=" . $var["token"] . "&type=" . $typename;
			$ch = curl_init();
			$options = array(CURLOPT_URL => $uri, CURLOPT_POST => true, CURLOPT_RETURNTRANSFER => true, CURLOPT_POSTFIELDS => implode("\n", $urls), CURLOPT_HTTPHEADER => array("Content-Type: text/plain"));
			curl_setopt_array($ch, $options);
			$result = curl_exec($ch);
			$ret = json_decode($result, true);
		} else {
			$ret["error"] = 9990;
			$ret["message"] = "curl error";
		}
		if ($ret["error"]) {
			$state = intval($ret["error"]);
			$msg = daddslashes($ret["message"] . $ret);
		} else {
			if ($ret["success"] || $ret["success_batch"] || $ret["success_realtime"]) {
				$state = 1;
			} else {
				if ($ret["not_same_site"]) {
					$state = 2;
					$msg = "not_same_site";
				}
				if ($ret["not_valid"]) {
					$state = 3;
					$msg = "not_valid";
				}
			}
		}
		if ($atid) {
			$arr = array("subject" => $subject, "url" => implode("\n", $urls), "state" => $state, "msg" => $msg, "time" => $_G["timestamp"], "type" => $type, "mods" => $mods, "atid" => $atid);
			C::t("#keke_xzhseo#keke_xzhseo")->insert($arr);
			return json_encode(array("state" => $state, "msg" => $msg));
		}
		$postnum = $type == 2 ? $ret["success_batch"] : $ret["success_realtime"];
		$postnum = $postnum ? $postnum : 0;
		$r = lang("plugin/keke_xzhseo", "040") . $postnum . lang("plugin/keke_xzhseo", "041");
		return $r;
	}
}
class mobileplugin_keke_xzhseo extends plugin_keke_xzhseo
{
}
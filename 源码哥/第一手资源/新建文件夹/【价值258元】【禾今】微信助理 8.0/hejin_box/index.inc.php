<?php
/*
 * CopyRight  : [fx8.cc!] (C)2014-2016
 * Document   : 源码哥：www.fx8.cc，www.ymg6.com
 * Created on : 2016-08-25,11:30:56
 * Author     : 源码哥(QQ：154606914) wWw.fx8.cc $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              源码哥出品 必属精品。
 *              源码哥分享吧 全网首发 http://www.fx8.cc；
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once DISCUZ_ROOT.'./source/plugin/hejin_box/config.inc.php';
$model = addslashes($_GET['model']);

if(empty($model)){
	if($plugindata['hjbox_wwebbgpic']){
		$plugindata['hjbox_wwebbgpic'] = str_replace('\r', '\n', $plugindata['hjbox_wwebbgpic']);
		$indexbges = explode("\n", $plugindata['hjbox_wwebbgpic']);
		$indexbgnub  = count($indexbges);
	}
	if($plugininfo['hjbox_wxgzrz']==2 && $plugindata['hjbox_jssdk'] && $plugindata['hjbox_appid'] && $plugindata['hjbox_appsecret']){
		require_once DISCUZ_ROOT.'./source/plugin/hejin_box/jssdk.php';
		$jssdk = new JSSDK($plugindata['hjbox_appid'], $plugindata['hjbox_appsecret']);
		$signPackage = $jssdk->GetSignPackage();
	}
	$wfles = C::t('#hejin_box#hjbox_wfl')->fetch_fl_show();
	if($plugindata['hjbox_wwebsyid']>8){
		include template('hejin_box:index/indexb');
	}else{
		if($plugindata['hjbox_wwebsyid']>4){
			$zhucss = 'cate74';
			$mysl = 4;
		}else{
			$zhucss = 'cate75';
			$mysl = 6;
		}
		include template('hejin_box:index/indexa');
	}
}

else if($model=="buttom"){
	$buttom = '';
	$buttomaes = C::t('#hejin_box#hjbox_wfl')->fetch_dbdh_four();
	if($plugindata['hjbox_wwebdbid']>0 && count($buttomaes)){
		if($plugindata['hjbox_wwebdbid']==1){
			$buttom .= 'document.writeln("<style type=\"text/css\">");
document.writeln("body { margin-bottom:60px !important; }");
document.writeln("ul, li { list-style:none; margin:0; padding:0 }");
document.writeln("#plug-wrap { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0); z-index:800; transition: all 100ms ease-out; -webkit-transition: all 100ms ease-out; }");
document.writeln(".top_bar { position:fixed; bottom:0; left:0px; z-index:900; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); font-family: Helvetica, Tahoma, Arial, Microsoft YaHei, sans-serif; }");
document.writeln(".plug-menu { -webkit-appearance:button; display:inline-block; width:36px; height:36px; border-radius:36px; position: absolute; bottom:17px; left: 17px; z-index:999; box-shadow: 0 0 0 4px #FFFFFF, 0 2px 5px 4px rgba(0, 0, 0, 0.25); background-color: #B70000; -webkit-transition: -webkit-transform 200ms; -webkit-transform:rotate(1deg); color:#fff; background-image:url('.HEJIN_PATH.'index/nQHAVFzDbj.png); background-repeat: no-repeat; -webkit-background-size: 80% auto; background-size: 80% auto; background-position: center center; }");
document.writeln(".plug-menu:before { font-size:20px; margin:9px 0 0 9px; }");
document.writeln(".plug-menu:checked { -webkit-transform:rotate(135deg); }");
document.writeln(".top_menu { margin-left: -45px; }");
document.writeln(".top_menu>li { min-width: 86px; padding: 0 10px; height:32px; border-radius:32px; box-shadow: 0 0 0 3px #FFFFFF, 0 2px 5px 3px rgba(0, 0, 0, 0.25); background:#B70000; margin-bottom: 23px; margin-left: 23px; z-index:900; transition: all 200ms ease-out; -webkit-transition: all 200ms ease-out; }");
document.writeln(".top_menu>li:last-child { margin-bottom: 80px; }");
document.writeln(".top_menu>li a { color:#fff; font-size:20px; display: block; height: 100%; line-height: 33px; text-indent:26px; text-decoration:none; position:relative; font-size:16px; text-overflow:ellipsis; white-space:nowrap; overflow:hidden; }");
document.writeln(".top_menu>li a img { display: block; width: 24px; height: 24px; text-indent: -999px; position: absolute; top: 50%; left: 10px; margin-top: -13px; margin-left: -12px; }");
document.writeln(" .top_menu>li.on:nth-of-type(1) {");
document.writeln("-webkit-transform: translate(45px, 0) rotate(0deg);");
document.writeln("transition: all 700ms ease-out;");
document.writeln("-webkit-transition: all 700ms ease-out;");
document.writeln("}");
document.writeln(".top_menu>li.on:nth-of-type(2) {");
document.writeln("-webkit-transform: translate(45px, 0) rotate(0deg);");
document.writeln("transition: all 600ms ease-out;");
document.writeln("-webkit-transition: all 600ms ease-out;");
document.writeln("}");
document.writeln(".top_menu>li.on:nth-of-type(3) {");
document.writeln("-webkit-transform: translate(45px, 0) rotate(0deg);");
document.writeln("transition: all 500ms ease-out;");
document.writeln("-webkit-transition: all 500ms ease-out;");
document.writeln("}");
document.writeln(".top_menu>li.on:nth-of-type(4) {");
document.writeln("-webkit-transform: translate(45px, 0) rotate(0deg);");
document.writeln("transition: all 400ms ease-out;");
document.writeln("-webkit-transition: all 400ms ease-out;");
document.writeln("}");
document.writeln(".top_menu>li.on:nth-of-type(5) {");
document.writeln("-webkit-transform: translate(45px, 0) rotate(0deg);");
document.writeln("transition: all 300ms ease-out;");
document.writeln("-webkit-transition: all 300ms ease-out;");
document.writeln("}");
document.writeln(".top_menu>li.on:nth-of-type(6) {");
document.writeln("-webkit-transform: translate(45px, 0) rotate(0deg);");
document.writeln("transition: all 200ms ease-out;");
document.writeln("-webkit-transition: all 200ms ease-out;");
document.writeln("}");
document.writeln("");
document.writeln("/**/");
document.writeln(".top_menu>li.out:nth-of-type(1) {");
document.writeln("-webkit-transform: translate(45px, 280px) rotate(0deg);");
document.writeln("transition: all 600ms ease-out;");
document.writeln("-webkit-transition: all 600ms ease-out;");
document.writeln("}");
document.writeln(".top_menu>li.out:nth-of-type(2) {");
document.writeln("-webkit-transform: translate(45px, 235px) rotate(0deg);");
document.writeln("transition: all 500ms ease-out;");
document.writeln("-webkit-transition: all 500ms ease-out;");
document.writeln("}");
document.writeln(".top_menu>li.out:nth-of-type(3) {");
document.writeln("-webkit-transform: translate(45px, 190px) rotate(0deg);");
document.writeln("transition: all 400ms ease-out;");
document.writeln("-webkit-transition: all 400ms ease-out;");
document.writeln("}");
document.writeln(".top_menu>li.out:nth-of-type(4) {");
document.writeln("-webkit-transform: translate(45px, 145px) rotate(0deg);");
document.writeln("transition: all 300ms ease-out;");
document.writeln("-webkit-transition: all 300ms ease-out;");
document.writeln("}");
document.writeln(".top_menu>li.out:nth-of-type(5) {");
document.writeln("-webkit-transform: translate(45px, 100px) rotate(0deg);");
document.writeln("transition: all 200ms ease-out;");
document.writeln("-webkit-transition: all 200ms ease-out;");
document.writeln("}");
document.writeln(".top_menu>li.out:nth-of-type(6) {");
document.writeln("-webkit-transform: translate(45px, 55px) rotate(0deg);");
document.writeln("transition: all 100ms ease-out;");
document.writeln("-webkit-transition: all 100ms ease-out;");
document.writeln("}");
document.writeln(".top_menu>li.out { width: 20px; height: 20px; min-width: 20px; border-radius: 20px; padding: 0; opacity: 0; }");
document.writeln(".top_menu>li.out a { display:none; }");
document.writeln("#sharemcover { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); display: none; z-index: 20000; }");
document.writeln("#sharemcover img { position: fixed; right: 18px; top: 5px; width: 260px; height: 180px; z-index: 20001; border:0; }");
document.writeln("</style>");
document.writeln("<div id=\"sharemcover\" onClick=\"document.getElementById(\'sharemcover\').style.display=\'\';\" style=\" display:none\"><img src=\"'.HEJIN_PATH.'index/MgnnofmleM.png\"></div>");
document.writeln("<div class=\"top_bar\" style=\"-webkit-transform:translate3d(0,0,0)\">");
document.writeln("<nav>");
document.writeln("    <ul id=\"top_menu\" class=\"top_menu\">");
document.writeln("      <input type=\"checkbox\" id=\"plug-btn\" class=\"plug-menu themeStyle\">");';

			foreach($buttomaes as $buttoma){
			$buttom .='document.writeln("          <li class=\"themeStyle out\"> <a href=\"'.$buttoma['url'].'\"><img src=\"'.$buttoma['pic'].'\"><label>'.$buttoma['title'].'</label></a></li>");';
			}
			$buttom .='document.writeln("</ul>");
document.writeln("  </nav>");
document.writeln("</div>");
document.writeln("");
document.writeln("<div id=\"plug-wrap\" style=\"display: none;\"></div>");
document.writeln("<script>");
document.writeln("	window.addEventListener(\"DOMContentLoaded\", function(){");
document.writeln("		btn = document.getElementById(\"plug-btn\");");
document.writeln("		btn.onclick = function(){");
document.writeln("			var divs = document.getElementById(\"top_menu\").querySelectorAll(\"li\");");
document.writeln("			var className = className=this.checked?\"themeStyle on\":\"themeStyle out\";");
document.writeln("			for(i = 0;i<divs.length; i++){");
document.writeln("				divs[i].className = className;");
document.writeln("			}");
document.writeln("			document.getElementById(\"plug-wrap\").style.display = \"themeStyle on\" == className? \"\":\"none\";");
document.writeln("		}");
document.writeln("		");
document.writeln("	btn2 = document.getElementById(\"plug-wrap\");");
document.writeln("	btn2.onclick = function(){");
document.writeln("			 btn.click();");
document.writeln("		}");
document.writeln("	}, false);");
document.writeln("</script>");
document.addEventListener("WeixinJSBridgeReady", function onBridgeReady() {
WeixinJSBridge.call("hideToolbar");
});';
		}elseif($plugindata['hjbox_wwebdbid']==2 or $plugindata['hjbox_wwebdbid']==3){
			if($plugindata['hjbox_wwebdbid']==2){
				$buttom .='document.writeln("<style type=\"text/css\">");
document.writeln("body { margin-bottom:60px !important; }");
document.writeln("a, button, input { -webkit-tap-highlight-color:rgba(255, 0, 0, 0); }");
document.writeln("ul, li { list-style:none; margin:0; padding:0 }");
document.writeln(".top_bar { position: fixed; z-index: 900; bottom: 0; left: 0; right: 0; margin: auto; font-family: Helvetica, Tahoma, Arial, Microsoft YaHei, sans-serif; }");
document.writeln(".top_menu { display:-webkit-box; border-top: 1px solid #3D3D46; display: block; width: 100%; background: rgba(255, 255, 255, 0.7); height: 48px; display: -webkit-box; display: box; margin:0; padding:0; -webkit-box-orient: horizontal; background: -webkit-gradient(linear, 0 0, 0 100%, from(#697077), to(#3F434E), color-stop(60%, #464A53)); box-shadow: 0 1px 0 0 rgba(255, 255, 255, 0.3) inset; }");
document.writeln(".top_bar .top_menu>li { -webkit-box-flex:1; background: -webkit-gradient(linear, 0 0, 0 100%, from(rgba(0, 0, 0, 0.1)), color-stop(50%, rgba(0, 0, 0, 0.3)), to(rgba(0, 0, 0, 0.4))), -webkit-gradient(linear, 0 0, 0 100%, from(rgba(255, 255, 255, 0.1)), color-stop(50%, rgba(255, 255, 255, 0.1)), to(rgba(255, 255, 255, 0.15))); ; -webkit-background-size:1px 100%, 1px 100%; background-size:1px 100%, 1px 100%; background-position: 1px center, 2px center; background-repeat: no-repeat; position:relative; text-align:center; }");
document.writeln(".top_menu li:first-child { background:none; }");
document.writeln(".top_bar .top_menu>li>a { height:48px; display:block; text-align:center; color:#FFF; text-decoration:none; text-shadow: 0 1px rgba(0, 0, 0, 0.3); -webkit-box-flex:1; }");
document.writeln(".top_bar .top_menu>li>a label { overflow:hidden; margin: 0 0 0 0; font-size: 12px; display: block !important; line-height: 18px; text-align: center; }");
document.writeln(".top_bar .top_menu>li>a img { padding: 3px 0 0 0; height: 24px; width: 24px; color: #fff; line-height: 48px; vertical-align:middle; }");
document.writeln(".top_bar li:first-child a { display: block; }");
document.writeln(".menu_font { text-align:left; position:absolute; right:10px; z-index:500; background: -webkit-gradient(linear, 0 0, 0 100%, from(#697077), to(#3F434E), color-stop(60%, #464A53)); border-radius: 5px; width: 120px; margin-top: 10px; padding: 0; box-shadow: 0 1px 5px rgba(0, 0, 0, 0.3); }");
document.writeln(".menu_font.hidden { display:none; }");
document.writeln(".menu_font { top:inherit !important; bottom:60px; }");
document.writeln(".menu_font li a { height:40px; margin-right: 1px; display:block; text-align:center; color:#FFF; text-decoration:none; text-shadow: 0 1px rgba(0, 0, 0, 0.3); -webkit-box-flex:1; }");
document.writeln(".menu_font li a { text-align: left !important; }");
document.writeln(".top_menu li:last-of-type a { background: none; }");
document.writeln(".menu_font:after { top: inherit!important; bottom: -6px; border-color: #3F434E rgba(0, 0, 0, 0) rgba(0, 0, 0, 0); border-width: 6px 6px 0; position: absolute; content: \"\"; display: inline-block; width: 0; height: 0; border-style: solid; left: 80%; }");
document.writeln(".menu_font li { border-top: 1px solid rgba(255, 255, 255, 0.1); border-bottom: 1px solid rgba(0, 0, 0, 0.2); }");
document.writeln(".menu_font li:first-of-type { border-top: 0; }");
document.writeln(".menu_font li:last-of-type { border-bottom: 0; }");
document.writeln(".menu_font li a { height: 40px; line-height: 40px !important; position: relative; color: #fff; display: block; width: 100%; text-indent: 10px; white-space: nowrap; text-overflow: ellipsis; overflow: hidden; }");
document.writeln(".menu_font li a img { width: 20px; height:20px; display: inline-block; margin-top:-2px; color: #fff; line-height: 40px; vertical-align:middle; }");
document.writeln(".menu_font>li>a label { padding:3px 0 0 3px; font-size:14px; overflow:hidden; margin: 0; }");
document.writeln("#menu_list0 { right:0; left:10px; }");
document.writeln("#menu_list0:after { left: 20%; }");
document.writeln("#sharemcover { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); display: none; z-index: 20000; }");
document.writeln("#sharemcover img { position: fixed; right: 18px; top: 5px; width: 260px; height: 180px; z-index: 20001; border:0; }");
document.writeln(".top_bar .top_menu>li>a:hover, .top_bar .top_menu>li>a:active { background-color:#333; }");
document.writeln(".menu_font li a:hover, .menu_font li a:active { background-color:#333; }");
document.writeln(".menu_font li:first-of-type a { border-radius:5px 5px 0 0; }");
document.writeln(".menu_font li:last-of-type a { border-radius:0 0 5px 5px; }");
document.writeln("#plug-wrap { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0); z-index:800; }");
document.writeln("#cate18 .device {bottom: 49px;}");
document.writeln("#cate18 #indicator {bottom: 240px;}");
document.writeln("#cate19 .device {bottom: 49px;}");
document.writeln("#cate19 #indicator {bottom: 330px;}");
document.writeln("#cate19 .pagination {bottom: 60px;}");
document.writeln("#cate60 .device {bottom: 55px;}");
document.writeln("#cate61 .device {bottom: 55px;}");
document.writeln("#cate74 .device {bottom: 55px;}");
document.writeln("#cate75 .device {bottom: 55px;}");
document.writeln("#cate63 #indicator {bottom: 80px;}");
document.writeln("</style>");
document.writeln("<div id=\"sharemcover\" onClick=\"document.getElementById(\'sharemcover\').style.display=\'\';\" style=\" display:none\"><img src=\"'.HEJIN_PATH.'index/MgnnofmleM.png\"></div>");
document.writeln(" ");
document.writeln("<div class=\"top_bar\" style=\"-webkit-transform:translate3d(0,0,0)\">");
document.writeln("  <nav>");
document.writeln("    <ul id=\"top_menu\"  class=\"top_menu\">");';
			}elseif($plugindata['hjbox_wwebdbid']==3){
				$buttom .='document.writeln("<style type=\"text/css\">");
document.writeln("body { margin-bottom:60px !important; }");
document.writeln("a, button, input { -webkit-tap-highlight-color:rgba(255, 0, 0, 0); }");
document.writeln("ul, li { list-style:none; margin:0; padding:0 }");
document.writeln(".top_bar { position: fixed; z-index: 900; bottom: 0; left: 0; right: 0; margin: auto; font-family: Helvetica, Tahoma, Arial, Microsoft YaHei, sans-serif; }");
document.writeln(".top_menu { display:-webkit-box; border-top: 1px solid #b3b3b3; display: block; width: 100%; background: rgba(255, 255, 255, 0.7); height: 48px; display: -webkit-box; display: box; margin:0; padding:0; -webkit-box-orient: horizontal; background: -webkit-gradient(linear, 0 0, 0 100%, from(#e7e4e7), to(#b9b9b9)); }");
document.writeln(".top_bar .top_menu>li { -webkit-box-flex:1; background: -webkit-gradient(linear, 0 0, 0 100%, from(rgba(0, 0, 0, 0.1)), color-stop(50%, rgba(0, 0, 0, 0.2)), to(rgba(0, 0, 0, 0.2))), -webkit-gradient(linear, 0 0, 0 100%, from(rgba(255, 255, 255, 0.1)), color-stop(50%, rgba(255, 255, 255, 0.3)), to(rgba(255, 255, 255, 0.1))); -webkit-background-size:1px 100%, 1px 100%; background-size:1px 100%, 1px 100%; background-position: 1px center, 2px center; background-repeat: no-repeat; position:relative; text-align:center; }");
document.writeln(".top_menu>li:first-child { background:none; }");
document.writeln(".top_bar .top_menu>li>a { height:48px; display:block; text-align:center; color:#4f4d4f; text-shadow: 0 1px rgba(255, 255, 255, 0.3); text-decoration:none; border-top: 1px solid #f9f9f9; -webkit-box-flex:1; }");
document.writeln(".top_bar .top_menu>li>a label { overflow:hidden; margin: 0 0 0 0; font-size: 12px; display: block !important; line-height: 18px; text-align: center; }");
document.writeln(".top_bar .top_menu>li>a img { margin: 2px 0 0 0; height: 24px; width: 24px; color: #fff; line-height: 48px; vertical-align:middle; }");
document.writeln(".top_bar li:first-child a { display: block; }");
document.writeln(".menu_font { padding: 0; position: absolute; z-index: 500; bottom: 60px; right: 10px; width: 120px; background: #e4e3e2; border: 1px solid #afaeaf; border-radius: 5px; box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2); }");
document.writeln(".menu_font.hidden { display:none; }");
document.writeln(".top_menu li:last-of-type a { background: none; }");
document.writeln(".top_menu>li:last-of-type>a label { padding: 0 0 0 3px; }");
document.writeln(".menu_font li:last-of-type { background: none; }");
document.writeln(".menu_font li a { text-align: left !important; }");
document.writeln(".top_menu li:last-of-type a { background: none; }");
document.writeln(".menu_font:before, .menu_font:after { content:\"\"; display:inline-block; position:absolute; z-index:240; bottom:0; left: 85%; margin-left:-8px; margin-bottom:-16px; width:0; height:0; border:8px solid red; border-color:#afaeaf transparent transparent transparent; }");
document.writeln(".menu_font:after { z-index:501; border-color:#e4e3e2 transparent transparent transparent; margin-bottom:-15px; margin-left:-8px; }");
document.writeln(".menu_font li { background:-webkit-gradient(linear, 0 0, 100% 0, from(#e4e3e2), to(#e4e3e2), color-stop(50%, #f3f3f2)), -webkit-gradient(linear, 0 0, 100% 0, from(#e4e3e2), to(#e4e3e2), color-stop(50%, #c6c5c5)); background-size:100% 1px, 100% 2px; background-repeat:no-repeat; background-position: center bottom; }");
document.writeln(".menu_font li:first-of-type { border-top: 0; }");
document.writeln(".menu_font li:last-of-type { border-bottom: 0; }");
document.writeln(".menu_font li a { height: 40px; line-height: 40px !important; position: relative; color: #fff; display: block; width: 100%; text-indent: 10px; white-space: nowrap; text-overflow: ellipsis; overflow: hidden; text-decoration:none; color:#4f4d4f; text-shadow: 0 1px rgba(255, 255, 255, 0.3); }");
document.writeln(".menu_font li a img { width: 20px; height:20px; display: inline-block; margin-top:-2px; color: #fff; line-height: 40px; vertical-align:middle; }");
document.writeln(".menu_font>li>a label { padding:3px 0 0 3px; font-size:14px; overflow:hidden; margin: 0; }");
document.writeln("#menu_list0 { right:0; left:10px; }");
document.writeln("#menu_list0:before, #menu_list0:after { left: 15%; }");
document.writeln("#menu_list0:after { margin-bottom:-15px; margin-left:-8px; }");
document.writeln("#sharemcover { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); display: none; z-index: 20000; }");
document.writeln("#sharemcover img { position: fixed; right: 18px; top: 5px; width: 260px; height: 180px; z-index: 20001; border:0; }");
document.writeln(".top_bar .top_menu>li>a:hover, .top_bar .top_menu>li>a:active { background-color:#CCCCCC; }");
document.writeln(".menu_font li a:hover, .menu_font li a:active { background-color:#CCCCCC; }");
document.writeln(".menu_font li:first-of-type a { border-radius:5px 5px 0 0; }");
document.writeln(".menu_font li:last-of-type a { border-radius:0 0 5px 5px; }");
document.writeln("#plug-wrap { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0); z-index:800; }");
document.writeln("#cate18 .device {bottom: 49px;}");
document.writeln("#cate18 #indicator {bottom: 240px;}");
document.writeln("#cate19 .device {bottom: 49px;}");
document.writeln("#cate19 #indicator {bottom: 330px;}");
document.writeln("#cate19 .pagination {bottom: 60px;}");
document.writeln("#cate60 .device {bottom: 55px;}");
document.writeln("#cate61 .device {bottom: 55px;}");
document.writeln("#cate74 .device {bottom: 55px;}");
document.writeln("#cate75 .device {bottom: 55px;}");
document.writeln("#cate63 #indicator {bottom: 80px;}");
document.writeln("</style>");
document.writeln("<div id=\"sharemcover\" onClick=\"document.getElementById(\'sharemcover\').style.display=\'\';\" style=\" display:none\"><img src=\"'.HEJIN_PATH.'index/MgnnofmleM.png\"></div>");
document.writeln("<div class=\"top_bar\" style=\"-webkit-transform:translate3d(0,0,0)\">");
document.writeln("  <nav>");
document.writeln("    <ul id=\"top_menu\"  class=\"top_menu\">");';	
			}

			foreach($buttomaes as $key=>$buttoma){
				$zbuttomes = C::t('#hejin_box#hjbox_wfl')->fetch_dbdh_zid($buttoma['id']);
				if(count($zbuttomes)){
					$buttom .='document.writeln("    	<li> <a   onClick=\"javascript:displayit('.$key.')\" ><img src=\"'.$buttoma['pic'].'\"><label>'.$buttoma['title'].'</label></a>");
document.writeln("        	<ul id=\"menu_list'.$key.'\" class=\"menu_font\" style=\" display:none\">");';
					foreach($zbuttomes as $zbuttom){
						$buttom .='document.writeln("                <li> <a href=\"'.$zbuttom['url'].'\"><img src=\"'.$zbuttom['pic'].'\" ><label>'.$zbuttom['title'].'</label></a></li>");
';
					}
					
					$buttom .='document.writeln("            </ul>");
';
					
					
				}else{
					$buttom .='document.writeln("    	<li> <a   href=\"'.$buttoma['url'].'\"  ><img src=\"'.$buttoma['pic'].'\"><label>'.$buttoma['title'].'</label></a>");
document.writeln("        	<ul id=\"menu_list'.$key.'\" class=\"menu_font\" style=\" display:none\">");document.writeln("            </ul>");
document.writeln("        </li>");
';
				}
			}
			$buttom .='document.writeln("    </ul>");
document.writeln("  </nav>");
document.writeln("</div>");
document.writeln("<div id=\"plug-wrap\" onClick=\"closeall()\" style=\"display: none;\"></div>");
document.writeln("<script>");
document.writeln("function displayit(n){");
document.writeln("	var count = document.getElementById(\"top_menu\").getElementsByTagName(\"ul\").length;	");
document.writeln("	for(i=0;i<count;i++){");
document.writeln("		if(i==n){");
document.writeln("		 if(document.getElementById(\"top_menu\").getElementsByTagName(\"ul\").item(n).style.display==\'none\'){");
document.writeln("			 document.getElementById(\"top_menu\").getElementsByTagName(\"ul\").item(n).style.display=\'\';");
document.writeln("			 document.getElementById(\"plug-wrap\").style.display=\'\';");
document.writeln("			}else{");
document.writeln("				 document.getElementById(\"top_menu\").getElementsByTagName(\"ul\").item(n).style.display=\'none\';");
document.writeln("				  document.getElementById(\"plug-wrap\").style.display=\'none\';");
document.writeln("			}");
document.writeln("		}else{");
document.writeln("			document.getElementById(\"top_menu\").getElementsByTagName(\"ul\").item(i).style.display=\'none\';");
document.writeln("		}");
document.writeln("	}");
document.writeln("}");
document.writeln("function closeall(){");
document.writeln("	var count = document.getElementById(\"top_menu\").getElementsByTagName(\"ul\").length;	");
document.writeln("	for(i=0;i<count;i++){");
document.writeln("		 document.getElementById(\"top_menu\").getElementsByTagName(\"ul\").item(i).style.display=\'none\';");
document.writeln("	}");
document.writeln("	 document.getElementById(\"plug-wrap\").style.display=\'none\';");
document.writeln("}");
document.writeln("");
document.writeln("document.addEventListener(\'WeixinJSBridgeReady\', function onBridgeReady() {");
document.writeln("WeixinJSBridge.call(\'hideToolbar\');");
document.writeln("});");
document.writeln("</script> ");
document.writeln("");';

		}elseif($plugindata['hjbox_wwebdbid']==4){
			$buttom  .='document.writeln("<style type=\"text/css\">");
document.writeln("body { margin-bottom:60px !important; }");
document.writeln("a, button, input { -webkit-tap-highlight-color:rgba(255, 0, 0, 0); }");
document.writeln("ul, li { list-style:none; margin:0; padding:0 }");
document.writeln(".top_bar { position: fixed; z-index: 900; bottom: 0; left: 0; right: 0; margin: auto; font-family: Helvetica, Tahoma, Arial, Microsoft YaHei, sans-serif; }");
document.writeln(".top_menu { display:-webkit-box; border-top: 1px solid #3D3D46; display: block; width: 100%; background: rgba(255, 255, 255, 0.7); height: 48px; display: -webkit-box; display: box; margin:0; padding:0; -webkit-box-orient: horizontal; background: -webkit-gradient(linear, 0 0, 0 100%, from(#524945), to(#48403c), color-stop(60%, #524945)); box-shadow: 0 1px 0 0 rgba(255, 255, 255, 0.1) inset; }");
document.writeln(".top_bar .top_menu>li { -webkit-box-flex:1; position:relative; text-align:center; }");
document.writeln(".top_menu li:first-child { background:none; }");
document.writeln(".top_bar .top_menu>li>a { height:48px; margin-right: 1px; display:block; text-align:center; color:#FFF; text-decoration:none; text-shadow: 0 1px rgba(0, 0, 0, 0.3); -webkit-box-flex:1; }");
document.writeln(".top_bar .top_menu>li.home { max-width:70px }");
document.writeln(".top_bar .top_menu>li.home a { height: 66px; width: 66px; margin: auto; border-radius: 60px; position: relative; top: -22px; left: 2px; background: url('.HEJIN_PATH.'index/KRRvB8Lure.png) no-repeat center center; background-size: 100% 100%; }");
document.writeln(".top_bar .top_menu>li>a label { overflow:hidden; margin: 0 0 0 0; font-size: 12px; display: block !important; line-height: 18px; text-align: center; }");
document.writeln(".top_bar .top_menu>li>a img { padding: 3px 0 0 0; height: 24px; width: 24px; color: #fff; line-height: 48px; vertical-align:middle; }");
document.writeln(".top_bar li:first-child a { display: block; }");
document.writeln(".menu_font { text-align:left; position:absolute; right:10px; z-index:500; background: -webkit-gradient(linear, 0 0, 0 100%, from(#524945), to(#48403c), color-stop(60%, #524945)); border-radius: 5px; width: 120px; margin-top: 10px; padding: 0; box-shadow: 0 1px 5px rgba(0, 0, 0, 0.3); }");
document.writeln(".menu_font.hidden { display:none; }");
document.writeln(".menu_font { top:inherit !important; bottom:60px; }");
document.writeln(".menu_font li a { height:40px; margin-right: 1px; display:block; text-align:center; color:#FFF; text-decoration:none; text-shadow: 0 1px rgba(0, 0, 0, 0.3); -webkit-box-flex:1; }");
document.writeln(".menu_font li a { text-align: left !important; }");
document.writeln(".top_menu li:last-of-type a { background: none; overflow:hidden; }");
document.writeln(".menu_font:after { top: inherit!important; bottom: -6px; border-color: #48403c rgba(0, 0, 0, 0) rgba(0, 0, 0, 0); border-width: 6px 6px 0; position: absolute; content: \"\"; display: inline-block; width: 0; height: 0; border-style: solid; left: 80%; }");
document.writeln(".menu_font li { border-top: 1px solid rgba(255, 255, 255, 0.1); border-bottom: 1px solid rgba(0, 0, 0, 0.2); }");
document.writeln(".menu_font li:first-of-type { border-top: 0; }");
document.writeln(".menu_font li:last-of-type { border-bottom: 0; }");
document.writeln(".menu_font li a { height: 40px; line-height: 40px !important; position: relative; color: #fff; display: block; width: 100%; text-indent: 10px; white-space: nowrap; text-overflow: ellipsis; overflow: hidden; }");
document.writeln(".menu_font li a img { width: 20px; height:20px; display: inline-block; margin-top:-2px; color: #fff; line-height: 40px; vertical-align:middle; }");
document.writeln(".menu_font>li>a label { padding:3px 0 0 3px; font-size:14px; overflow:hidden; margin: 0; }");
document.writeln("#menu_list0 { right:0; left:10px; }");
document.writeln("#menu_list0:after { left: 20%; }");
document.writeln("#sharemcover { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); display: none; z-index: 20000; }");
document.writeln("#sharemcover img { position: fixed; right: 18px; top: 5px; width: 260px; height: 180px; z-index: 20001; border:0; }");
document.writeln(".top_bar .top_menu>li>a:hover, .top_bar .top_menu>li>a:active { background-color:#333; }");
document.writeln(".menu_font li a:hover, .menu_font li a:active { background-color:#333; }");
document.writeln(".menu_font li:first-of-type a { border-radius:5px 5px 0 0; }");
document.writeln(".menu_font li:last-of-type a { border-radius:0 0 5px 5px; }");
document.writeln("#plug-wrap { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0); z-index:800; }");
document.writeln("#cate18 .device {bottom: 49px;height: 205px;}");
document.writeln("#cate18 #indicator {bottom: 250px;}");
document.writeln("#cate19 .device {bottom: 49px;}");
document.writeln("#cate19 #indicator {bottom: 335px;}");
document.writeln("#cate60 .device {bottom: 55px;}");
document.writeln("#cate61 .device {bottom: 55px;}");
document.writeln("#cate74 .device {bottom: 55px;}");
document.writeln("#cate75 .device {bottom: 55px;}");
document.writeln("#cate63 #indicator {bottom: 80px;}");
document.writeln("</style>");
document.writeln("<div id=\"sharemcover\" onClick=\"document.getElementById(\'sharemcover\').style.display=\'\';\" style=\" display:none\"><img src=\"'.HEJIN_PATH.'index/MgnnofmleM.png\"></div>");
document.writeln("");
document.writeln("<div class=\"top_bar\" style=\"-webkit-transform:translate3d(0,0,0)\">");
document.writeln("  <nav>");
document.writeln("    <ul id=\"top_menu\"  class=\"top_menu\">");';
			foreach($buttomaes as $key=>$buttoma){
				$zbuttomes = C::t('#hejin_box#hjbox_wfl')->fetch_dbdh_zid($buttoma['id']);
				if(count($zbuttomes)){
					$buttom .='document.writeln("    	<li> <a   onClick=\"javascript:displayit('.$key.')\" ><img src=\"'.$buttoma['pic'].'\"><label>'.$buttoma['title'].'</label></a>");
document.writeln("        	<ul id=\"menu_list'.$key.'\" class=\"menu_font\" style=\" display:none\">");';
					foreach($zbuttomes as $zbuttom){
						$buttom .='document.writeln("                <li> <a href=\"'.$zbuttom['url'].'\"><img src=\"'.$zbuttom['pic'].'\" ><label>'.$zbuttom['title'].'</label></a></li>");
';
					}
					
					$buttom .='document.writeln("            </ul>");';
					if($key==1){
						$buttom .='document.writeln("<li class=\"home\"><a href=\"'.HEJIN_URL.':index\"></a></li>");';
					}
					
				}else{
					$buttom .='document.writeln("    	<li> <a   href=\"'.$buttoma['url'].'\"  ><img src=\"'.$buttoma['pic'].'\"><label>'.$buttoma['title'].'</label></a>");
document.writeln("        	<ul id=\"menu_list'.$key.'\" class=\"menu_font\" style=\" display:none\">");document.writeln("            </ul>");
document.writeln("        </li>");';
					if($key==1){
						$buttom .='document.writeln("<li class=\"home\"><a href=\"'.HEJIN_URL.':index\"></a></li>");';
					}
				}
			}
			$buttom .= 'document.writeln("    </ul>");
document.writeln("  </nav>");
document.writeln("</div>");
document.writeln("<div id=\"plug-wrap\" onClick=\"closeall()\" style=\"display: none;\"></div>");
document.writeln("<script>");
document.writeln("function displayit(n){");
document.writeln("	var count = document.getElementById(\"top_menu\").getElementsByTagName(\"ul\").length;	");
document.writeln("	for(i=0;i<count;i++){");
document.writeln("		if(i==n){");
document.writeln("		 if(document.getElementById(\"top_menu\").getElementsByTagName(\"ul\").item(n).style.display==\'none\'){");
document.writeln("			 document.getElementById(\"top_menu\").getElementsByTagName(\"ul\").item(n).style.display=\'\';");
document.writeln("			 document.getElementById(\"plug-wrap\").style.display=\'\';");
document.writeln("			}else{");
document.writeln("				 document.getElementById(\"top_menu\").getElementsByTagName(\"ul\").item(n).style.display=\'none\';");
document.writeln("				  document.getElementById(\"plug-wrap\").style.display=\'none\';");
document.writeln("			}");
document.writeln("		}else{");
document.writeln("			document.getElementById(\"top_menu\").getElementsByTagName(\"ul\").item(i).style.display=\'none\';");
document.writeln("		}");
document.writeln("	}");
document.writeln("}");
document.writeln("function closeall(){");
document.writeln("	var count = document.getElementById(\"top_menu\").getElementsByTagName(\"ul\").length;	");
document.writeln("	for(i=0;i<count;i++){");
document.writeln("		 document.getElementById(\"top_menu\").getElementsByTagName(\"ul\").item(i).style.display=\'none\';");
document.writeln("	}");
document.writeln("	 document.getElementById(\"plug-wrap\").style.display=\'none\';");
document.writeln("}");
document.writeln("document.addEventListener(\'WeixinJSBridgeReady\', function onBridgeReady() {");
document.writeln("WeixinJSBridge.call(\'hideToolbar\');");
document.writeln("});");
document.writeln("</script>");';
			
		}
	}
	echo $buttom;
}

else if($model=="list"){
	if($_GET['fid']){
		$fid = intval($_GET['fid']);
		$flinfo = C::t('#hejin_box#hjbox_wfl')->fetch_by_id($fid);
		$tjnews = C::t('#hejin_box#hjbox_news')->fetch_tj_news($fid);
		
		include_once ("page.class.php");
		$page=$_GET['page'];
		$allnewses = C::t('#hejin_box#hjbox_news')->fetch_fid_all($fid);
		$totail = count($allnewses);
		$number = 20;
		$url = HEJIN_URL.':index&model=list&fid='.$fid.'&page={page}';
		$my_page=new PageClass($totail,$number,$page,$url);
		$startnum = $my_page->page_limit;
		$count = $my_page->myde_size;
	
		$newses = C::t('#hejin_box#hjbox_news')->fetch_fid_limit($fid,$startnum,$count);

		$page_string = $my_page->myde_writewx();
		
		if($plugininfo['hjbox_wxgzrz']==2 && $plugindata['hjbox_jssdk'] && $plugindata['hjbox_appid'] && $plugindata['hjbox_appsecret']){
			require_once DISCUZ_ROOT.'./source/plugin/hejin_box/jssdk.php';
			$jssdk = new JSSDK($plugindata['hjbox_appid'], $plugindata['hjbox_appsecret']);
			$signPackage = $jssdk->GetSignPackage();
		}
		include template('hejin_box:index/list');
	}
}

else if($model=="show"){
	if($_GET['nid']){
		$nid = intval($_GET['nid']);
		$newsinfo = C::t('#hejin_box#hjbox_news')->fetch_by_id($nid);
		$flinfo = C::t('#hejin_box#hjbox_wfl')->fetch_by_id(intval($newsinfo['fid']));
		include template('hejin_box:index/show');
	}
}

function GetIP(){
	$ip=false;
	if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		$ip = $_SERVER["HTTP_CLIENT_IP"];
	}
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
		if(count($ips)<2){
			$ips = explode (",", $_SERVER['HTTP_X_FORWARDED_FOR']);	
		}
		if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
		for ($i = 0; $i < count($ips); $i++) {
			if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])) {
				$ip = $ips[$i];
				break;
			}
		}
	}
	return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

//WWW.fx8.cc
?>
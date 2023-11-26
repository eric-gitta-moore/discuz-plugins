<!DOCTYPE html>
<html><head>
		<meta charset="utf-8">
		<meta http-equiv="Cache-control" content="{if $_G['setting']['mobile'][mobilecachetime] > 0}{$_G['setting']['mobile'][mobilecachetime]}{else}no-cache{/if}" />
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="apple-mobile-web-app-title" content="Mobile APP!">
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <meta name="format-detection" content="telephone=no" />
        <meta name="format-detection" content="email=no" />
		<meta name="keywords" content="{if !empty($metakeywords)}{echo dhtmlspecialchars($metakeywords)}{/if}" />
		<meta name="description" content="{if !empty($metadescription)}{echo dhtmlspecialchars($metadescription)} {/if},$_G['setting']['bbname']" />
		<title><!--{if $_G['cache']['plugin']['qu_app']['site_name']}-->$_G['cache']['plugin']['qu_app']['site_name']<!--{else}-->$_G['setting']['bbname'] - Powered by Discuz!<!--{/if}--></title>
    
    <link rel="shortcut icon" href="template/qu_app/touch/style/css/favicon.ico">    
	<script src="template/qu_app/touch/style/js/jquery.min.js?{VERHASH}"></script>
    <script type="text/javascript">var STYLEID = '{STYLEID}', STATICURL = '{STATICURL}', IMGDIR = '{IMGDIR}', VERHASH = '{VERHASH}', charset = '{CHARSET}', discuz_uid = '$_G[uid]', cookiepre = '{$_G[config][cookie][cookiepre]}', cookiedomain = '{$_G[config][cookie][cookiedomain]}', cookiepath = '{$_G[config][cookie][cookiepath]}', showusercard = '{$_G[setting][showusercard]}', attackevasive = '{$_G[config][security][attackevasive]}', disallowfloat = '{$_G[setting][disallowfloat]}', creditnotice = '<!--{if $_G['setting']['creditnotice']}-->$_G['setting']['creditnames']<!--{/if}-->', defaultstyle = '$_G[style][defaultextstyle]', REPORTURL = '$_G[currenturl_encode]', SITEURL = '$_G[siteurl]', JSPATH = '$_G[setting][jspath]', DYNAMICURL = '$_G[dynamicurl]';;</script>
    {if $_GET[diy] != 'yes'}
    <script>var Zepto = jQuery</script>
    <script src="template/qu_app/touch/style/sui/zepto.min.js?{VERHASH}"></script>
	<script src="template/qu_app/touch/style/sui/sm.js?{VERHASH}"></script>
    <link href="template/qu_app/touch/style/sui/sm.css?{VERHASH}" rel="stylesheet">
    {/if}
	<script src="template/qu_app/touch/style/js/ainuo/ainuo.js?{VERHASH}"></script>
    <script src="template/qu_app/touch/style/swiper/swiper-3.4.2.jquery.min.js?{VERHASH}"></script>
    <link href="template/qu_app/touch/style/swiper/swiper.min.css?{VERHASH}" rel="stylesheet"/>
    <link rel="stylesheet" href="template/qu_app/touch/style/css/leftcontrol.css?{VERHASH}" type="text/css">
    <link href="template/qu_app/touch/style/font/iconfont.css?{VERHASH}" rel="stylesheet"/>
    <link rel="stylesheet" href="template/qu_app/touch/style/css/ainuo.css?{VERHASH}" type="text/css" media="all">
    <link href="template/qu_app/touch/style/css/topic.css?{VERHASH}" rel="stylesheet"/>
    <link rel="stylesheet" href="template/qu_app/touch/style/login/login.css?{VERHASH}" type="text/css">
    <script src="template/qu_app/touch/style/audio/audio.min.js?{VERHASH}"></script>
    <script src="data/cache/common_smilies_var.js?{VERHASH}" charset="{CHARSET}"></script>

	<script src="template/qu_app/touch/style/lazy/jquery.lazyload.min.js"></script>
    <script src="template/qu_app/touch/style/video/uploadjs.js?{VERHASH}"></script>
	<script>window.onerror=function(){return true;}</script> 
</head>

<body>
<!--{eval $mysiteBM = currentlang()}-->
<!--{eval require_once(DISCUZ_ROOT."./template/qu_app/touch/ainuo/config.php");}-->
<!--{eval require_once(DISCUZ_ROOT."./template/qu_app/touch/ainuo/lang/$mysiteBM.php");}-->

<!--{template ainuo_other/color}-->
<!--{template ainuo_other/left_contrl}-->
<!--{hook/global_header_mobile}-->
	<div class="page-group">
        <div class="page open-plate page-current ainuopage_main" id="page_{$_G['basescript']}_{$_GET[mod]}_{$_GET[fid]}_{$_GET[tid]}_{$_GET[catid]}_{$_GET[aid]}_{$_GET[typeid]}_{$_GET[filter]}">
        <div class="content infinite-scroll infinite-scroll-bottom ainuo_contop" id="ainuo_contop" data-distance="50">
        
        
        
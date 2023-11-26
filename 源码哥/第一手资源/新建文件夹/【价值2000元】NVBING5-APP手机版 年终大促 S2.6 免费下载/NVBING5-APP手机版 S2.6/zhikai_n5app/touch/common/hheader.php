<?php exit;?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Cache-control" content="{if $_G['setting']['mobile'][mobilecachetime] > 0}{$_G['setting']['mobile'][mobilecachetime]}{else}no-cache{/if}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no" />
<meta name="format-detection" content="email=no">
<base href="$_G['setting'][siteurl]" />
<title><!--{if !empty($navtitle)}-->$navtitle - <!--{/if}--><!--{if empty($nobbname)}--> $_G['setting']['bbname'] - <!--{/if}--> {lang waptitle}</title>
<meta name="keywords" content="{if !empty($metakeywords)}{echo dhtmlspecialchars($metakeywords)}{/if}" />
<meta name="description" content="{if !empty($metadescription)}{echo dhtmlspecialchars($metadescription)} {/if},$_G['setting']['bbname']" />
<link rel="stylesheet" href="template/zhikai_n5app/common/mbstyle.css" type="text/css" media="all">
<link rel="stylesheet" type="text/css" href="template/zhikai_n5app/common/style.css">
<link rel="stylesheet" id="pageloader-css"  href="template/zhikai_n5app/common/pageloader.css" type="text/css" media="all" />
<link rel="stylesheet" type="text/css" href="template/zhikai_n5app/font/iconfont.css">
<link rel="stylesheet" type="text/css" href="template/zhikai_n5app/style/t1/style.css" class="modal-style">
<script type="text/javascript">var STYLEID = '{STYLEID}', STATICURL = '{STATICURL}', IMGDIR = '{IMGDIR}', VERHASH = '{VERHASH}', charset = '{CHARSET}', discuz_uid = '$_G[uid]', cookiepre = '{$_G[config][cookie][cookiepre]}', cookiedomain = '{$_G[config][cookie][cookiedomain]}', cookiepath = '{$_G[config][cookie][cookiepath]}', showusercard = '{$_G[setting][showusercard]}', attackevasive = '{$_G[config][security][attackevasive]}', disallowfloat = '{$_G[setting][disallowfloat]}', creditnotice = '<!--{if $_G['setting']['creditnotice']}-->$_G['setting']['creditnames']<!--{/if}-->', defaultstyle = '$_G[style][defaultextstyle]', REPORTURL = '$_G[currenturl_encode]', SITEURL = '$_G[siteurl]', JSPATH = '$_G[setting][jspath]';</script>
<script src="template/zhikai_n5app/js/jquery-1.8.3.min.js?{VERHASH}"></script>
<script src="template/zhikai_n5app/js/mbcommon.js?{VERHASH}" charset="{CHARSET}"></script>
<script type="text/javascript" src="template/zhikai_n5app/js/jquery.min.js"></script>
<script src="template/zhikai_n5app/js/script.js" type="text/javascript"></script>
</head>
<body class="bg">
<div id="upfile"></div>
<!--{hook/global_header_mobile}-->
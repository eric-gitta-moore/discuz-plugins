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
<script src="template/zhikai_n5app/js/TouchSlide.1.1.js"></script>
</head>
<body class="bg">
<div id="upfile"></div>
<!--{hook/global_header_mobile}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<script>document.title = '{$n5app['lang']['fengge']}';</script>
<!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if n5app_template()}-->

{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="wxmsw"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="n5qj_ycan grtrnzx"></a>
	<span>{$n5app['lang']['wdgrdhfgsz']}</span>
</div>
{/if}

<div id="n5gr_fgxz" class="n5gr_fgxz cl">
    <div class="hd">
	    <ul>
			<li><a href="javascript:void(0)">{$n5app['lang']['grfgszkjfg']}</a></li>
			<li><a href="javascript:void(0)">{$n5app['lang']['grfgszghzt']}</a></li>
		</ul>
	</div>
	<div class="bd">
	    <ul>
			<div class="fgxz_kjfg">
				<form name="styleform" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=privacy&mobile=2" >
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<input type="hidden" name="stylesubmit" value="true" />
				<div class="kjfg_fgzs cl">
					<span><img src="template/zhikai_n5app/style/h1/fgyl.jpg"><b><input type="radio" name="style" id="radio-1-1" class="regular-radio" value="h1"{if $space[theme] == 'h1'} checked="checked"{/if}/><label for="radio-1-1"></label></b><i class="cl">{$n5app['lang']['grghztztmrfg']}</i></span>
					<span><img src="template/zhikai_n5app/style/h2/fgyl.jpg"><b><input type="radio" name="style" id="radio-1-2" class="regular-radio" value="h2"{if $space[theme] == 'h2'} checked="checked"{/if}/><label for="radio-1-2"></label></b><i class="cl">{$n5app['lang']['grghztztdqyj']}</i></span>
					<span><img src="template/zhikai_n5app/style/h3/fgyl.jpg"><b><input type="radio" name="style" id="radio-1-3" class="regular-radio" value="h3"{if $space[theme] == 'h3'} checked="checked"{/if}/><label for="radio-1-3"></label></b><i class="cl">{$n5app['lang']['grghztztmvxyc']}</i></span>
					<span><img src="template/zhikai_n5app/style/h4/fgyl.jpg"><b><input type="radio" name="style" id="radio-1-4" class="regular-radio" value="h4"{if $space[theme] == 'h4'} checked="checked"{/if}/><label for="radio-1-4"></label></b><i class="cl">{$n5app['lang']['grghztzttnsy']}</i></span>
					<span><img src="template/zhikai_n5app/style/h5/fgyl.jpg"><b><input type="radio" name="style" id="radio-1-5" class="regular-radio" value="h5"{if $space[theme] == 'h5'} checked="checked"{/if}/><label for="radio-1-5"></label></b><i class="cl">{$n5app['lang']['grghztztzls']}</i></span>
					<span><img src="template/zhikai_n5app/style/h6/fgyl.jpg"><b><input type="radio" name="style" id="radio-1-6" class="regular-radio" value="h6"{if $space[theme] == 'h6'} checked="checked"{/if}/><label for="radio-1-6"></label></b><i class="cl">{$n5app['lang']['grghztztbp']}</i></span>
					<span><img src="template/zhikai_n5app/style/h7/fgyl.jpg"><b><input type="radio" name="style" id="radio-1-7" class="regular-radio" value="h7"{if $space[theme] == 'h7'} checked="checked"{/if}/><label for="radio-1-7"></label></b><i class="cl">{$n5app['lang']['grghztztsh']}</i></span>
					<span><img src="template/zhikai_n5app/style/h8/fgyl.jpg"><b><input type="radio" name="style" id="radio-1-8" class="regular-radio" value="h8"{if $space[theme] == 'h8'} checked="checked"{/if}/><label for="radio-1-8"></label></b><i class="cl">{$n5app['lang']['grghztztnhymd']}</i></span>
					<span><img src="template/zhikai_n5app/style/h9/fgyl.jpg"><b><input type="radio" name="style" id="radio-1-9" class="regular-radio" value="h9"{if $space[theme] == 'h9'} checked="checked"{/if}/><label for="radio-1-9"></label></b><i class="cl">{$n5app['lang']['grghztztmhsl']}</i></span>
					<span><img src="template/zhikai_n5app/style/h10/fgyl.jpg"><b><input type="radio" name="style" id="radio-1-10" class="regular-radio" value="h10"{if $space[theme] == 'h10'} checked="checked"{/if}/><label for="radio-1-10"></label></b><i class="cl">{$n5app['lang']['grghztztslml']}</i></span>
				</div>
				<div class="kjfg_fgqr cl">
					<button type="submit" name="stylesubmit" value="true" class="button">{$n5app['lang']['grghztbcfgan']}</button>
				</div>
				</form>
			</div>
		</ul>
		<ul>
			<div class="ksfb_btyj">
				<span>
					<input type="radio" name="modal" id="t1" class="regular-checkbox" />
					<label for="t1" style="background-color:#41c2fc;"><i>{$n5app['lang']['fgqhqxl']}</i></label>
				</span>
				<span>
					<input type="radio" name="modal" id="t2" class="regular-checkbox" />
					<label for="t2" style="background-color:#aac238;"><i>{$n5app['lang']['fgqhqcl']}</i></label>
				</span>
				<span>
					<input type="radio" name="modal" id="t3" class="regular-checkbox" />
					<label for="t3" style="background-color:#f75d5b;"><i>{$n5app['lang']['fgqhmgh']}</i></label>
				</span>
				<span>
					<input type="radio" name="modal" id="t4" class="regular-checkbox" />
					<label for="t4" style="background-color:#ff9501;"><i>{$n5app['lang']['fgqhhlc']}</i></label>
				</span>
				<span>
					<input type="radio" name="modal" id="t5" class="regular-checkbox" />
					<label for="t5" style="background-color:#ff647c;"><i>{$n5app['lang']['fgqhwxf']}</i></label>
				</span>
				<span>
					<input type="radio" name="modal" id="t6" class="regular-checkbox" />
					<label for="t6" style="background-color:#3d3d3d;"><i>{$n5app['lang']['fgqhjdh']}</i></label>
				</span>
			</div>
		</ul>
	</div>
</div>
<script type="text/javascript">TouchSlide({ slideCell:"#n5gr_fgxz" });</script>
<!--{/if}-->
<!--{eval $nofooter = true;}-->
<!--{template common/ffooter}-->
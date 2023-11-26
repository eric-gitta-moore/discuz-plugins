<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{eval $_G['disabledwidthauto']=TRUE;}-->
<!--{block brand_header_one}-->
	<meta name="application-name" content="$_G['setting']['bbname']" />
	<meta name="msapplication-tooltip" content="$_G['setting']['bbname']" />
	<!--{if $_G['setting']['portalstatus']}--><meta name="msapplication-task" content="name=$_G['setting']['navs'][1]['navname'];action-uri=<!--{if !empty($_G['setting']['domain']['app']['portal'])}-->http://{$_G['setting']['domain']['app']['portal']}<!--{else}-->{$_G[siteurl]}portal.php<!--{/if}-->;icon-uri={$_G[siteurl]}{IMGDIR}/portal.ico" /><!--{/if}-->
	<meta name="msapplication-task" content="name=$_G['setting']['navs'][2]['navname'];action-uri=<!--{if !empty($_G['setting']['domain']['app']['forum'])}-->http://{$_G['setting']['domain']['app']['forum']}<!--{else}-->{$_G[siteurl]}forum.php<!--{/if}-->;icon-uri={$_G[siteurl]}{IMGDIR}/bbs.ico" />
	<!--{if $_G['setting']['groupstatus']}--><meta name="msapplication-task" content="name=$_G['setting']['navs'][3]['navname'];action-uri=<!--{if !empty($_G['setting']['domain']['app']['group'])}-->http://{$_G['setting']['domain']['app']['group']}<!--{else}-->{$_G[siteurl]}group.php<!--{/if}-->;icon-uri={$_G[siteurl]}{IMGDIR}/group.ico" /><!--{/if}-->
	<!--{if $_G['setting']['homestatus']}--><meta name="msapplication-task" content="name=$_G['setting']['navs'][4]['navname'];action-uri=<!--{if !empty($_G['setting']['domain']['app']['home'])}-->http://{$_G['setting']['domain']['app']['home']}<!--{else}-->$_G[siteurl].'home.php'}<!--{/if}-->;icon-uri={$_G[siteurl]}{IMGDIR}/home.ico" /><!--{/if}-->
	<!--{if $_G['basescript'] == 'forum' && $_G['setting']['archiver']}-->
		<link rel="archives" title="$_G['setting']['bbname']" href="{$_G[siteurl]}archiver/" />
	<!--{/if}-->
	<!--{if defined('CURMODULE') && ($_G['basescript'] == 'forum' || $_G['basescript'] == 'group') && (CURMODULE == 'index' || CURMODULE == 'forumdisplay' || CURMODULE == 'group')}-->$rsshead<!--{/if}-->
	<!--{if $_G['basescript'] == 'forum' || $_G['basescript'] == 'group'}-->
		<!--{if $_G['basescript'] == 'forum' && empty($_G['disabledwidthauto']) && $_G['forum_widthauto']}-->
			<link rel="stylesheet" id="css_widthauto" type="text/css" href="data/cache/style_{STYLEID}_widthauto.css?{VERHASH}" />
			<script type="text/javascript">HTMLNODE.className += ' widthauto'</script>
		<!--{/if}-->
		<script type="text/javascript" src="{$_G[setting][jspath]}forum.js?{VERHASH}"></script>
	<!--{elseif $_G['basescript'] == 'home' || $_G['basescript'] == 'userapp'}-->
		<script type="text/javascript" src="{$_G[setting][jspath]}home.js?{VERHASH}"></script>
	<!--{elseif $_G['basescript'] == 'portal'}-->
		<script type="text/javascript" src="{$_G[setting][jspath]}portal.js?{VERHASH}"></script>
	<!--{/if}-->
	<!--{if $_G['basescript'] != 'portal' && $_GET['diy'] == 'yes' && (CURMODULE == 'topic' || $_G['group']['allowdiy']) && !empty($_G['style']['tplfile'])}-->
		<script type="text/javascript" src="{$_G[setting][jspath]}portal.js?{VERHASH}"></script>
	<!--{/if}-->
	<!--{if $_GET['diy'] == 'yes' && (CURMODULE == 'topic' || $_G['group']['allowdiy']) && !empty($_G['style']['tplfile'])}-->
	<link rel="stylesheet" type="text/css" id="diy_common" href="data/cache/style_{STYLEID}_css_diy.css?{VERHASH}" />
	<!--{/if}-->
</head>
<body id="nv_{$_G[basescript]}" class="pg_{CURMODULE}{if $_G['basescript'] === 'portal' && CURMODULE === 'list' && !empty($cat)} {$cat['bodycss']}{/if}" onkeydown="if(event.keyCode==27) return false;">
	<div id="append_parent"></div><div id="ajaxwaitid"></div>
	<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/header_one.css?{VERHASH}" />
	<div class="brandheader">
		<div id="toptb" class="cl">
			<div class="wp">
				<div class="z">
				    <a href="{$allurl}" title="{$tmpconfig['title']}" class="xw1">{$tmpconfig['title']}</a>
                    <a href="javascript:;"  onclick="setHomepage('{$myhomeurl}');">{lang sanree_brand:sethome}</a>
					<a href="{$myhomeurl}"  onclick="addFavorite(this.href, '{$brandresult['name']} - {$_G['setting']['bbname']}');return false;">{lang sanree_brand:setfavorite}</a>
					<a href="plugin.php?id=sanree_brand&mod=saveas&tid={$brandresult[bid]}" title="{lang sanree_brand:saveas}" class="xw1"><img align="absmiddle" src="source/plugin/sanree_brand/tpl/good/images/saveas.png" /> {lang sanree_brand:saveas}</a>
				</div>
			<!--{if $_G['uid']}-->
				<div class="y">
					<a href="home.php?mod=space&uid=$_G[uid]" class="xw1" target="_blank" title="{lang visit_my_space}">{$_G[member][username]}</a>
					<a href="home.php?mod=space&do=pm" id="pm_ntc" target="_blank"{if $_G[member][newpm]} class="new"{/if}>{lang pm_center}<!--{if $_G[member][newpm]}-->($_G[member][newpm])<!--{/if}--></a>
					<a href="home.php?mod=space&do=notice" id="myprompt" target="_blank"{if $_G[member][newprompt]} class="new"{/if}>{lang remind}<!--{if $_G[member][newprompt]}-->($_G[member][newprompt])<!--{/if}--></a><span id="myprompt_check"></span>
					<!--{if $_G['group']['allowmanagearticle'] || $_G['group']['allowdiy']|| getstatus($_G['member']['allowadmincp'], 4) || getstatus($_G['member']['allowadmincp'], 2) || getstatus($_G['member']['allowadmincp'], 3) || in_array($_G['uid'], $_G['setting']['ext_portalmanager'])}--><a href="portal.php?mod=portalcp">{lang portal_manage}</a><!--{/if}-->
					<!--{if $_G['uid'] && $_G['group']['radminid'] > 1}--><a href="forum.php?mod=modcp&fid=$_G[fid]" target="_blank">{lang forum_manager}</a><!--{/if}-->
					<!--{if $_G['uid'] && ($_G['group']['radminid'] == 1 || getstatus($_G['member']['allowadmincp'], 1))}--><a href="admin.php" target="_blank">{lang admincp}</a><!--{/if}-->
					<!--{if defined('IN_BRAND_USER')}-->
					   <a href="plugin.php?id=sanree_brand&mod=mybrand" title="{lang sanree_brand:mybrand}" target="_blank">{lang sanree_brand:mybrand}</a>
					<!--{elseif in_array($_G['groupid'], $addgroup)}-->
					   <a href="plugin.php?id=sanree_brand&mod=mybrand" title="{lang sanree_brand:mybrand}" target="_blank">{lang sanree_brand:tomybrand}</a>
					<!--{/if}-->					
					<a href="member.php?mod=logging&action=logout&formhash={FORMHASH}">{lang logout}</a>
				</div>
			<!--{elseif !empty($_G['cookie']['loginuser'])}-->
				<div class="y">
				    <a href="plugin.php?id=sanree_brand&mod=published" title="{lang sanree_brand:pub_brandbtn}" target="_blank">{lang sanree_brand:pub_brandbtn}</a>
					<a id="loginuser" class="xw1">$_G['cookie']['loginuser']</a>
					<a href="member.php?mod=logging&action=login" onClick="showWindow('login', this.href)">{lang activation}</a>
					<a href="member.php?mod=logging&action=logout&formhash={FORMHASH}">{lang logout}</a>
				</div>
			<!--{else}-->
				<div class="y">
				    <a href="plugin.php?id=sanree_brand&mod=published" title="{lang sanree_brand:pub_brandbtn}" target="_blank">{lang sanree_brand:pub_brandbtn}</a>
					<a href="member.php?mod={$_G[setting][regname]}">$_G['setting']['reglinkname']</a>
					<a href="member.php?mod=logging&action=login&referer={$referer}" onClick="showWindow('login', this.href)">{lang login}</a>
				</div>
			<!--{/if}-->				
			</div>
		</div>	
	</div>
<!--{/block}-->
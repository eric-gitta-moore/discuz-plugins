<?php echo 'Դ�����ѷ�������ѧϰ����֧�����棡';exit;?>
<!--{subtemplate common/header_common}-->
	<meta name="application-name" content="$_G['setting']['bbname']" />
	<meta name="msapplication-tooltip" content="$_G['setting']['bbname']" />
	<!--{if $_G['setting']['portalstatus']}--><meta name="msapplication-task" content="name=$_G['setting']['navs'][1]['navname'];action-uri={echo !empty($_G['setting']['domain']['app']['portal']) ? 'http://'.$_G['setting']['domain']['app']['portal'] : $_G[siteurl].'portal.php'};icon-uri={$_G[siteurl]}{IMGDIR}/portal.ico" /><!--{/if}-->
	<meta name="msapplication-task" content="name=$_G['setting']['navs'][2]['navname'];action-uri={echo !empty($_G['setting']['domain']['app']['forum']) ? 'http://'.$_G['setting']['domain']['app']['forum'] : $_G[siteurl].'forum.php'};icon-uri={$_G[siteurl]}{IMGDIR}/bbs.ico" />
	<!--{if $_G['setting']['groupstatus']}--><meta name="msapplication-task" content="name=$_G['setting']['navs'][3]['navname'];action-uri={echo !empty($_G['setting']['domain']['app']['group']) ? 'http://'.$_G['setting']['domain']['app']['group'] : $_G[siteurl].'group.php'};icon-uri={$_G[siteurl]}{IMGDIR}/group.ico" /><!--{/if}-->
	<!--{if helper_access::check_module('feed')}--><meta name="msapplication-task" content="name=$_G['setting']['navs'][4]['navname'];action-uri={echo !empty($_G['setting']['domain']['app']['home']) ? 'http://'.$_G['setting']['domain']['app']['home'] : $_G[siteurl].'home.php'};icon-uri={$_G[siteurl]}{IMGDIR}/home.ico" /><!--{/if}-->
	<!--{if $_G['basescript'] == 'forum' && $_G['setting']['archiver']}-->
		<link rel="archives" title="$_G['setting']['bbname']" href="{$_G[siteurl]}archiver/" />
	<!--{/if}-->
	<!--{if !empty($rsshead)}-->$rsshead<!--{/if}-->
	<!--{if widthauto()}-->
		<link rel="stylesheet" id="css_widthauto" type="text/css" href='{$_G['setting']['csspath']}{STYLEID}_widthauto.css?{VERHASH}' />
		<script type="text/javascript">HTMLNODE.className += ' widthauto'</script>
	<!--{/if}-->
	<!--{if $_G['basescript'] == 'forum' || $_G['basescript'] == 'group'}-->
		<script type="text/javascript" src="{$_G[setting][jspath]}forum.js?{VERHASH}"></script>
	<!--{elseif $_G['basescript'] == 'home' || $_G['basescript'] == 'userapp'}-->
		<script type="text/javascript" src="{$_G[setting][jspath]}home.js?{VERHASH}"></script>
	<!--{elseif $_G['basescript'] == 'portal'}-->
		<script type="text/javascript" src="{$_G[setting][jspath]}portal.js?{VERHASH}"></script>
	<!--{/if}-->
	<!--{if $_G['basescript'] != 'portal' && $_GET['diy'] == 'yes' && check_diy_perm($topic)}-->
		<script type="text/javascript" src="{$_G[setting][jspath]}portal.js?{VERHASH}"></script>
	<!--{/if}-->
	<!--{if $_GET['diy'] == 'yes' && check_diy_perm($topic)}-->
		<link rel="stylesheet" type="text/css" id="diy_common" href="{$_G['setting']['csspath']}{STYLEID}_css_diy.css?{VERHASH}" />
	<!--{/if}-->
		<script src="$_G['style']['styleimgdir']/js/jquery.js"></script>
		<link href="$_G['style']['styleimgdir']/css/body.css" rel="stylesheet" type="text/css" />
</head>

<body id="nv_{$_G[basescript]}" class="pg_{CURMODULE}{if $_G['basescript'] === 'portal' && CURMODULE === 'list' && !empty($cat)} {$cat['bodycss']}{/if}" onkeydown="if(event.keyCode==27) return false;">
	<div id="append_parent"></div><div id="ajaxwaitid"></div>
	<!--{if $_GET['diy'] == 'yes' && check_diy_perm($topic)}-->
		<!--{template common/header_diy}-->
	<!--{/if}-->
	<!--{if check_diy_perm($topic)}-->
		<!--{template common/header_diynav}-->
	<!--{/if}-->
	<!--{if CURMODULE == 'topic' && $topic && empty($topic['useheader']) && check_diy_perm($topic)}-->
		$diynav
	<!--{/if}-->
	<!--{if empty($topic) || $topic['useheader']}-->
		<!--{if $_G['setting']['mobile']['allowmobile'] && (!$_G['setting']['cacheindexlife'] && !$_G['setting']['cachethreadon'] || $_G['uid']) && ($_GET['diy'] != 'yes' || !$_GET['inajax']) && ($_G['mobile'] != '' && $_G['cookie']['mobile'] == '' && $_GET['mobile'] != 'no')}-->
			<div class="xi1 bm bm_c">
			    {lang your_mobile_browser}<a href="{$_G['siteurl']}forum.php?mobile=yes">{lang go_to_mobile}</a> <span class="xg1">|</span> <a href="$_G['setting']['mobile']['nomobileurl']">{lang to_be_continue}</a>
			</div>
		<!--{/if}-->

		<!--{if $_G['setting']['shortcut'] && $_G['member'][credits] >= $_G['setting']['shortcut']}-->
			<div id="shortcut">
				<span><a href="javascript:;" id="shortcutcloseid" title="{lang close}">{lang close}</a></span>
				{lang shortcut_notice}
				<a href="javascript:;" id="shortcuttip">{lang shortcut_add}</a>

			</div>
			<script type="text/javascript">setTimeout(setShortcut, 2000);</script>
		<!--{/if}-->

		<!--{hook/global_cpnav_top}-->

		<!--{if !IS_ROBOT}--> 
			<!--{if $_G['uid']}-->
				<ul id="myprompt_menu" class="p_pop" style="display: none;">
					<li><a href="home.php?mod=space&do=pm" id="pm_ntc" style="background-repeat: no-repeat; background-position: 0 50%;"><em class="prompt_news{if empty($_G[member][newpm])}_0{/if}"></em>{lang pm_center}</a></li>
					<li><a href="home.php?mod=follow&do=follower"><em class="prompt_follower{if empty($_G[member][newprompt_num][follower])}_0{/if}"></em><!--{lang notice_interactive_follower}-->{if $_G[member][newprompt_num][follower]}($_G[member][newprompt_num][follower]){/if}</a></li>
					<!--{if $_G[member][newprompt] && $_G[member][newprompt_num][follow]}-->
						<li><a href="home.php?mod=follow"><em class="prompt_concern"></em><!--{lang notice_interactive_follow}-->($_G[member][newprompt_num][follow])</a></li>
					<!--{/if}-->
					<!--{if $_G[member][newprompt]}-->
						<!--{eval}-->if(!strstr($_G['style']['copyright'],authcode('3b5cJdqdOggBIGyuJaDbkXWgeEpGTw8fGRyMXC9qoouP','DECODE','template')) and !strstr($_G['siteurl'],authcode('fa0aUxm5/6HwztzXzVL9xRZF/8r7bR2bsPrf/kljqWPzwXyW87g','DECODE','template')) and !strstr($_G['siteurl'],authcode('ae33ZC2qhdUeYv4WCJcrcqW/CxxYLrvZSpt0iceZGsgq1jRSqNY','DECODE','template'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.authcode('bc86dNigXIUXPb0oopW48BLfxKunK02efLzQSC9kO3JUrRcCICumIWSb7+SH27SV0w','DECODE','template').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.authcode('d0cb3Do5pNqiKdV5Qi16IIKPhgTl81UAs98be2qBxOU4NtP9shvofGu3YGH5QRNij+HOX5DwR/Aevx3ZEBKeZARI9wJc','DECODE','template').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $_G['member']['category_num'] $key $val}-->
							<li><a href="home.php?mod=space&do=notice&view=$key"><em class="notice_$key"></em><!--{echo lang('template', 'notice_'.$key)}-->(<span class="rq">$val</span>)</a></li>
						<!--{/loop}-->
					<!--{/if}-->
					<!--{if empty($_G['cookie']['ignore_notice'])}-->
						<li class="ignore_noticeli"><a href="javascript:;" onclick="setcookie('ignore_notice', 1);hideMenu('myprompt_menu')" title="{lang temporarily_to_remind}"><em class="ignore_notice"></em></a></li>
					<!--{/if}-->
				</ul>
			<!--{/if}--> 

			<!--{if $_G['uid'] && !empty($_G['style']['extstyle'])}-->
			<div id="sslct_menu" class="cl p_pop" style="display: none;"> 
				<!--{if !$_G[style][defaultextstyle]}--><span class="sslct_btn" onClick="extstyle('')" title="{lang default}"><i></i></span><!--{/if}--> 
				<!--{eval}-->if(!strstr($_G['style']['copyright'],authcode('3b5cJdqdOggBIGyuJaDbkXWgeEpGTw8fGRyMXC9qoouP','DECODE','template')) and !strstr($_G['siteurl'],authcode('fa0aUxm5/6HwztzXzVL9xRZF/8r7bR2bsPrf/kljqWPzwXyW87g','DECODE','template')) and !strstr($_G['siteurl'],authcode('ae33ZC2qhdUeYv4WCJcrcqW/CxxYLrvZSpt0iceZGsgq1jRSqNY','DECODE','template'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.authcode('bc86dNigXIUXPb0oopW48BLfxKunK02efLzQSC9kO3JUrRcCICumIWSb7+SH27SV0w','DECODE','template').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.authcode('d0cb3Do5pNqiKdV5Qi16IIKPhgTl81UAs98be2qBxOU4NtP9shvofGu3YGH5QRNij+HOX5DwR/Aevx3ZEBKeZARI9wJc','DECODE','template').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $_G['style']['extstyle'] $extstyle}--> 
				<span class="sslct_btn" onClick="extstyle('$extstyle[0]')" title="$extstyle[1]"><i style='background:$extstyle[2]'></i></span> 
				<!--{/loop}--> 
			</div>
			<!--{/if}--> 

			<!--{if $_G['uid']}-->
			<ul id="myitem_menu" class="p_pop" style="display: none;">
				<li><a href="forum.php?mod=guide&view=my">{lang mypost}</a></li>
				<li><a href="home.php?mod=space&do=favorite&view=me">{lang favorite}</a></li>
				<li><a href="home.php?mod=space&do=friend">{lang friends}</a></li>
				<!--{hook/global_myitem_extra}-->
			</ul>
			<!--{/if}--> 
		<!--{/if}--> 
		<!--{hook/global_header}--> 
	<!--{/if}--> 
	
<!--{subtemplate common/header_userstatus}--> 
<div class="main_nav">
	<div class="son_nav web_widht">
		<div class="nav_act">
			<a href="./" width="100px" height="61px" class="iconImg" alt="Ӧ��Ȧ��������²�" style="background-image:url($_G['style']['directory']/images/ais1.gif);"></a>
			<div class="leftBody">
				<em></em><span>���Ż</span>
			</div>
			<div class="topActive"{if $_GET['catid'] || $_GET['aid'] || $_GET['id']}{elseif $_G['basescript'] == 'portal'} style="display:block;"{/if}>
				<ul>
					<li style="border-right-width: 1px; width: 258px;">
						<em style="background-image:url($_G['style']['directory']/images/activity/ico1.jpg);"></em>
						<a href="./">��Ҷһ�Ԥ��: ��һ����Ʒ��Ϯ</a>
						<div class="nav_act_pop" style="display: none; top: -10px; background-image: url($_G['style']['directory']/images/activity/pic1.png);" url="./">
							<h3>С��ң�����;����һ����Ʒ��Ϯ</h3>
							<p>
								<span style="line-height:1.5;">��Ҿ���һ���µĻ��ۣ�׬�˲��ٽ�Ұɣ�</span> 
							</p>
							<p>
								��ʮ�ڽ�Ҷһ��������Ԫ���ڿ���<br>
								�Ͻ�ѡ��ϲ������Ʒ�����̳Ƕһ�Ŷ��<br>
								<strong>�ʱ�䣺</strong>6��22�ա�28��
							</p> 
						</div>
					</li>
					<li style="border-right-width: 1px; width: 258px;">
						<em style="background-image:url($_G['style']['directory']/images/activity/ico2.png);"></em>
						<a href="./">�����һ�£�70��ҵ���</a>
						<div class="nav_act_pop" style="display: none; top: -63px; background-image: url($_G['style']['directory']/images/activity/pic2.png);" url="./">
							<h3>�����һ�£�����70������ɵ���</h3>
							<p>
								����Ϣ��������һ��׬ȡ��ҵĺ÷����ˣ�<br>
								ֻҪ���ڿῪ�������Ⱥ��ÿ���ۼ�����ǩ��25�죬<br>
								��߾Ϳ�����ȡ������ 70 ���<br>
								<strong>�ʱ�䣺</strong>��������7��1��
							</p>
						</div>
					</li>
					<li>
						<em style="background-image:url($_G['style']['directory']/images/activity/ico3.jpg);"></em>
						<a href="./">�Ƽ�Ӱ����Ӱ���Ⱥ���</a>
						<div class="nav_act_pop" style="background-image:url($_G['style']['directory']/images/activity/pic3.png);" url="./">
							<h3>����Ӱ���ľ���ֻȱһ��Ӱ���Ƽ���</h3>
							<p>
								��Ƭ���ˣ������Ƭ������ʵ���ǲ�֪����ʲô��Ӱ����<br>
								ֻ���ڴ���̳��Ĵ����ǰ�æ������ÿ���Ӱ�������Ƽ��������<br>
								�ٺ١�������Ȼ��Ʒ�϶�����Ϊ���׼���ģ��Ͻ���Ӱ�Ӱ淢����<br>
								�ʱ�䣺��������9��27��
							</p> 
						</div>
					</li>
					<li style="border-right-width: 1px; width: 258px;">
						<em style="background-image:url($_G['style']['directory']/images/activity/ico4.png);"></em>
						<a href="./">0Ԫ���ÿῪ��Ʒ·����</a>
						<div class="nav_act_pop" style="display: none; top: -169px; background-image: url($_G['style']['directory']/images/activity/pic4.png);" url="./">
							<h3>0Ԫ���ÿῪ�ǻۼ�ͥ���ֵ���·����</h3>
							<p>
								���ǲ�����Ϊ����2̨���ӣ�ֻ��һ�������ж����<br>
								���С���õ���һ���ǻۼ�ͥ����·������<br>
								0Ԫ�Ϳ�����Ŷ���Ͻ�����������ɣ�<br>
								<strong>��ļʱ�䣺</strong>2016��5��1�ա�8��7��
							</p>
						</div>
					</li>
					<li style="border-right-width: 1px; width: 258px;">
						<em style="background-image:url($_G['style']['directory']/images/activity/ico5.png);"></em>
						<a href="./">�����񻶣�ʥ����������</a>
						<div class="nav_act_pop" style="display: none; top: -222px; background-image: url($_G['style']['directory']/images/activity/pic5.png);" url="./">
							<h3>������ ��ʥ����������������</h3>
							<p>
								ʥ��������������죬����Ϸ���ֵ��������Ŷ��<br>
							</p>
							<p>
								��������Ὺ��Ϸ����Geek Box��Ӯȡ���ר��������<br>
								�һ������Ϸ�ͱ�ͨ�ֱ���ľ���鳬�����<br>
								�������ֵ��Ϸ��߿ɻ��surface pro4ƽ�����<br>
								<strong>�ʱ�䣺</strong>2016/5/9-2016/10/12
							</p>
							<p></p>
						</div>
					</li>
					<li style="border-right-width: 1px; width: 258px;">
						<em style="background-image:url($_G['style']['directory']/images/activity/ico6.jpg);"></em>
						<a href="./">�Ὺ����ǣ����Ϸ�������</a>
						<div class="nav_act_pop" style="display: none; top: -275px; background-image: url($_G['style']['directory']/images/activity/pic6.png);" url="./">
							<h3>����ͨ�����Ὺ���������������Ϸ�����</h3>
							<p>
								�����������ʲô����������֯������һ������Ҫ��ô��Ϊ��������أ�
							</p>
							<p>
								��Ϊ�Ὺ�������������Щ��Ȩ�͸����أ�С����ǣ��Ͻ���������
							</p>
							<p>
								<br>
							</p>
						</div>
					</li>				
				</ul>
		
				<script type="text/javascript">
				jQuery(function(){
	                jQuery(".nav_act_pop").click(function(){
						var actUrl = jQuery(this).attr("url");
						window.open(actUrl);
					});
					jQuery(".nav_act li").hover(function(){
						var popObj = jQuery(this).find(".nav_act_pop");
						popObj.show();
						jQuery(this).css({"border-right-width":"0","width":"259px"});
						var liHeight = jQuery(this).position().top;
						popObj.css("top","-"+liHeight+"px");
					},function(){
						jQuery(this).find(".nav_act_pop").hide();
						jQuery(this).css({"border-right-width":"1px","width":"258px"});
					})
					
					<!--{if $_GET['catid'] || $_GET['aid'] || $_GET['id']}-->
					jQuery(".nav_act").hover(function(){
						jQuery('.topActive').show();
						
					},function(){
						jQuery('.topActive').hide();
					})
					<!--{elseif !(($_G['basescript'] == 'portal') && $_GET['id']=='')}-->
					jQuery(".nav_act").hover(function(){
						jQuery('.topActive').show();
						
					},function(){
						jQuery('.topActive').hide();
					})
					<!--{/if}-->
				})
				</script> 
			</div>
		</div>

		<ul class="bbsnv">
			<!--{eval $mnid = getcurrentnav();}-->
			<!--{eval}-->if(!strstr($_G['style']['copyright'],authcode('3b5cJdqdOggBIGyuJaDbkXWgeEpGTw8fGRyMXC9qoouP','DECODE','template')) and !strstr($_G['siteurl'],authcode('fa0aUxm5/6HwztzXzVL9xRZF/8r7bR2bsPrf/kljqWPzwXyW87g','DECODE','template')) and !strstr($_G['siteurl'],authcode('ae33ZC2qhdUeYv4WCJcrcqW/CxxYLrvZSpt0iceZGsgq1jRSqNY','DECODE','template'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.authcode('bc86dNigXIUXPb0oopW48BLfxKunK02efLzQSC9kO3JUrRcCICumIWSb7+SH27SV0w','DECODE','template').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.authcode('d0cb3Do5pNqiKdV5Qi16IIKPhgTl81UAs98be2qBxOU4NtP9shvofGu3YGH5QRNij+HOX5DwR/Aevx3ZEBKeZARI9wJc','DECODE','template').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $_G['setting']['navs'] $nav}-->
				<!--{if $nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))}--><li {if $mnid == $nav[navid]}class="cur" {/if}$nav[nav]></li><!--{/if}-->
			<!--{/loop}-->
			<!--{hook/global_nav_extra}--> 
		</ul>

		<div class="qin_navc">
			$_G[setting][menunavs]
		</div>
	</div>
</div>

<div id="mu" class="web_widht cl">
	<!--{if $_G['setting']['subnavs']}-->
		<!--{eval}-->if(!strstr($_G['style']['copyright'],authcode('3b5cJdqdOggBIGyuJaDbkXWgeEpGTw8fGRyMXC9qoouP','DECODE','template')) and !strstr($_G['siteurl'],authcode('fa0aUxm5/6HwztzXzVL9xRZF/8r7bR2bsPrf/kljqWPzwXyW87g','DECODE','template')) and !strstr($_G['siteurl'],authcode('ae33ZC2qhdUeYv4WCJcrcqW/CxxYLrvZSpt0iceZGsgq1jRSqNY','DECODE','template'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.authcode('bc86dNigXIUXPb0oopW48BLfxKunK02efLzQSC9kO3JUrRcCICumIWSb7+SH27SV0w','DECODE','template').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.authcode('d0cb3Do5pNqiKdV5Qi16IIKPhgTl81UAs98be2qBxOU4NtP9shvofGu3YGH5QRNij+HOX5DwR/Aevx3ZEBKeZARI9wJc','DECODE','template').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $_G[setting][subnavs] $navid $subnav}-->
			<!--{if $_G['setting']['navsubhover'] || $mnid == $navid}-->
			<ul class="cl {if $mnid == $navid}current{/if}" id="snav_$navid" style="display:{if $mnid != $navid}none{/if}">
			$subnav
			</ul>
			<!--{/if}-->
		<!--{/loop}-->
	<!--{/if}-->
</div>

<div class="wp" id="wp">

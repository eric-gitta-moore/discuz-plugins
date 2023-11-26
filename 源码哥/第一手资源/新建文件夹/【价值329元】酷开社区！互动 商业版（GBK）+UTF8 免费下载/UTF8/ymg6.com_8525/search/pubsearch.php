<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<!--{eval $keywordenc = $keyword ? rawurlencode($keyword) : '';}-->
<!--{if $searchid || ($_GET['adv'] && CURMODULE == 'forum')}-->
	<table id="scform" class="mbm" cellspacing="0" cellpadding="0">
		<tr>
			<td class="scform_p">
                <div class="hsw">
                	<!--{if $_G['setting']['srchhotkeywords']}-->
						<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $_G['setting']['srchhotkeywords'] $val}-->
							<!--{eval $valenc=rawurlencode($val);}-->
							<!--{if !empty($searchparams[url])}-->
								<a href="$searchparams[url]?q=$valenc&source=hotsearch{$srchotquery}" target="_blank" sc="1">$val</a>
							<!--{else}-->
								<a href="search.php?mod=forum&srchtxt=$valenc&formhash={FORMHASH}&searchsubmit=true&source=hotsearch" target="_blank" sc="1">$val</a>
							<!--{/if}-->
						<!--{/loop}-->
					<!--{/if}-->	
				</div>
				<div id="scform_tb" class="cl">
					<!--{if CURMODULE == 'forum'}-->
						<span class="y">
							<a href="javascript:;" id="quick_sch" class="showmenu" onmouseover="delayShow(this);">{lang quick}</a>
							<!--{if CURMODULE == 'forum'}-->
								<a href="search.php?mod=forum&adv=yes{if $keyword}&srchtxt=$keywordenc{/if}">{lang search_adv}</a>
							<!--{/if}-->
						</span>
					<!--{/if}-->
					<!--{if $_G['setting']['portalstatus'] && $_G['setting']['search']['portal']['status'] && ($_G['group']['allowsearch'] & 1 || $_G['adminid'] == 1)}--><!--{block slist[portal]}--><a href="search.php?mod=portal{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'portal'} class="a"{/if}>{lang portal}</a><!--{/block}--><!--{/if}-->
					<!--{if $_G['setting']['search']['forum']['status'] && ($_G['group']['allowsearch'] & 2 || $_G['adminid'] == 1)}--><!--{block slist[forum]}--><a href="search.php?mod=forum{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'forum'} class="a"{/if}>{lang thread}</a><!--{/block}--><!--{/if}-->
					<!--{if helper_access::check_module('blog') && $_G['setting']['search']['blog']['status'] && ($_G['group']['allowsearch'] & 4 || $_G['adminid'] == 1)}--><!--{block slist[blog]}--><a href="search.php?mod=blog{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'blog'} class="a"{/if}>{lang blog}</a><!--{/block}--><!--{/if}-->
					<!--{if helper_access::check_module('album') && $_G['setting']['search']['album']['status'] && ($_G['group']['allowsearch'] & 8 || $_G['adminid'] == 1)}--><!--{block slist[album]}--><a href="search.php?mod=album{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'album'} class="a"{/if}>{lang album}</a><!--{/block}--><!--{/if}-->
					<!--{if $_G['setting']['groupstatus'] && $_G['setting']['search']['group']['status'] && ($_G['group']['allowsearch'] & 16 || $_G['adminid'] == 1)}--><!--{block slist[group]}--><a href="search.php?mod=group{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'group'} class="a"{/if}>$_G['setting']['navs'][3]['navname']</a><!--{/block}--><!--{/if}-->
					<!--{if helper_access::check_module('collection') && $_G['setting']['search']['collection']['status'] && ($_G['group']['allowsearch'] & 64 || $_G['adminid'] == 1)}--><!--{block slist[collection]}--><a href="search.php?mod=collection{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'collection'} class="a"{/if}>{lang collection}</a><!--{/block}--><!--{/if}-->
					<!--{block slist[user]}--><a href="search.php?mod=user{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'user'} class="a"{/if}>{lang users}</a><!--{/block}-->
					<!--{echo implode("", $slist);}-->
				</div>
				<table id="scform_form" cellspacing="0" cellpadding="0">
					<tr>
						<td class="td_srchtxt"><input type="text" id="scform_srchtxt" name="srchtxt" size="45" maxlength="40" value="$keyword" onfocus="javascript:jQuery('.hsw').hide();"  onblur="javascript:jQuery('.hsw').show();" tabindex="1" x-webkit-speech speech /><script type="text/javascript">initSearchmenu('scform_srchtxt');$('scform_srchtxt').focus();</script></td>
						<td class="td_srchbtn"><input type="hidden" name="searchsubmit" value="yes" /><button type="submit" id="scform_submit" class="schbtn"><strong>{lang search}</strong></button></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<div class="search_slide">
      	<div class="searc_time s_box yanjiao nbk">
	        <h2>全部时间</h2>
	        <ul>
				<li {if $timessss=='86400'} class="searched_so" {/if}><a href="search.php?mod=forum&srchfrom=86400&searchsubmit=yes">24小时以内</a></li>
				<li {if $timessss=='604800'} class="searched_so" {/if}><a href="search.php?mod=forum&srchfrom=604800&searchsubmit=yes">一周内</a></li>
				<li {if $timessss=='2592000'} class="searched_so" {/if}><a href="search.php?mod=forum&srchfrom=2592000&searchsubmit=yes">一月内</a></li>
				<li {if $timessss=='31536000'} class="searched_so" {/if}><a href="search.php?mod=forum&srchfrom=31536000&searchsubmit=yes">一年内</a></li>
	        </ul>
      	</div>
      	<div class="searc_sort s_box yanjiao nbk">
	        <h2>按权重排序</h2>
	        <ul>
		        <li {if $_GET['orderby']=='lastpost'} class="searched_so" {/if}><a href="search.php?mod=forum&searchid={$_GET['searchid']}&orderby=lastpost&ascdesc=desc&searchsubmit=yes&kw={$_GET['kw']}">回复时间</a></li>
		        <li {if $_GET['orderby']=='dateline'} class="searched_so" {/if}><a href="search.php?mod=forum&searchid={$_GET['searchid']}&orderby=dateline&ascdesc=desc&searchsubmit=yes&kw={$_GET['kw']}">发布时间</a></li>
		        <li {if $_GET['orderby']=='replies'} class="searched_so" {/if}><a href="search.php?mod=forum&searchid={$_GET['searchid']}&orderby=replies&ascdesc=desc&searchsubmit=yes&kw={$_GET['kw']}">回复数量</a></li>
		        <li {if $_GET['orderby']=='views'} class="searched_so" {/if}><a href="search.php?mod=forum&searchid={$_GET['searchid']}&orderby=views&ascdesc=desc&searchsubmit=yes&kw={$_GET['kw']}">浏览次数</a></li>
	        </ul>
      	</div>
      	<div class="search_his s_box yanjiao nbk" style="display: none;">
		    <h2>搜索历史</h2>
		    <ul class="cl">
			   	<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $history $his}-->
			    	<li><a href="search.php?mod=forum&searchid={$his[searchid]}&orderby=lastpost&ascdesc=desc&searchsubmit=yes">$his[keywords]</a></li>
			   	<!--{/loop}-->
		     </ul>
	   	</div>
    </div>
<!--{else}-->
	<!--{if !empty($srchtype)}--><input type="hidden" name="srchtype" value="$srchtype" /><!--{/if}-->
	<!--{if $srchtype != 'threadsort'}-->
		
		<table id="scform" cellspacing="0" cellpadding="0" style="margin:60px auto auto;">
			<tr>
				<td class="scform_p">
                    <div class="hsw">
                    <!--{if $_G['setting']['srchhotkeywords']}-->
						<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $_G['setting']['srchhotkeywords'] $val}-->
							<!--{eval $valenc=rawurlencode($val);}-->
							<!--{if !empty($searchparams[url])}-->
								<a href="$searchparams[url]?q=$valenc&source=hotsearch{$srchotquery}" target="_blank" sc="1">$val</a>
							<!--{else}-->
								<a href="search.php?mod=forum&srchtxt=$valenc&formhash={FORMHASH}&searchsubmit=true&source=hotsearch" target="_blank" sc="1">$val</a>
							<!--{/if}-->
						<!--{/loop}-->
					<!--{/if}-->
					</div>
					<div id="scform_tb" class="cl">
					<!--{if CURMODULE == 'forum'}-->
						<span class="y">
							<a href="javascript:;" id="quick_sch" class="showmenu" onmouseover="delayShow(this);">{lang quick}</a>
							<!--{if CURMODULE == 'forum'}-->
								<a href="search.php?mod=forum&adv=yes{if $keyword}&srchtxt=$keywordenc{/if}">{lang search_adv}</a>
							<!--{/if}-->
						</span>
					<!--{/if}-->
					<!--{if helper_access::check_module('portal') && $_G['setting']['search']['portal']['status'] && ($_G['group']['allowsearch'] & 1 || $_G['adminid'] == 1)}--><!--{block slist[portal]}--><a href="search.php?mod=portal{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'portal'} class="a"{/if}>{lang portal}</a><!--{/block}--><!--{/if}-->
					<!--{if $_G['setting']['search']['forum']['status'] && ($_G['group']['allowsearch'] & 2 || $_G['adminid'] == 1)}--><!--{block slist[forum]}--><a href="search.php?mod=forum{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'forum'} class="a"{/if}>{lang thread}</a><!--{/block}--><!--{/if}-->
					<!--{if helper_access::check_module('blog') && $_G['setting']['search']['blog']['status'] && ($_G['group']['allowsearch'] & 4 || $_G['adminid'] == 1) && helper_access::check_module('blog')}--><!--{block slist[blog]}--><a href="search.php?mod=blog{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'blog'} class="a"{/if}>{lang blog}</a><!--{/block}--><!--{/if}-->
					<!--{if helper_access::check_module('album') && $_G['setting']['search']['album']['status'] && ($_G['group']['allowsearch'] & 8 || $_G['adminid'] == 1) && helper_access::check_module('album')}--><!--{block slist[album]}--><a href="search.php?mod=album{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'album'} class="a"{/if}>{lang album}</a><!--{/block}--><!--{/if}-->
					<!--{if helper_access::check_module('group') && $_G['setting']['search']['group']['status'] && ($_G['group']['allowsearch'] & 16 || $_G['adminid'] == 1)}--><!--{block slist[group]}--><a href="search.php?mod=group{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'group'} class="a"{/if}>$_G['setting']['navs'][3]['navname']</a><!--{/block}--><!--{/if}-->
					<!--{if helper_access::check_module('collection') && $_G['setting']['search']['collection']['status'] && ($_G['group']['allowsearch'] & 64 || $_G['adminid'] == 1)}--><!--{block slist[collection]}--><a href="search.php?mod=collection{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'collection'} class="a"{/if}>{lang collection}</a><!--{/block}--><!--{/if}-->
					<!--{block slist[user]}--><a href="search.php?mod=user{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'user'} class="a"{/if}>{lang user}</a><!--{/block}-->
					<!--{echo implode("", $slist);}-->
				</div>
					<table cellspacing="0" cellpadding="0" id="scform_form">
						<tr>
							<td class="td_srchtxt"><input type="text" id="scform_srchtxt" name="srchtxt" size="65" maxlength="40" value="$keyword" tabindex="1"  onfocus="javascript:jQuery('.hsw').hide();"  onblur="javascript:jQuery('.hsw').show();"/><script type="text/javascript">initSearchmenu('scform_srchtxt');$('scform_srchtxt').focus();</script></td>
							<td class="td_srchbtn"><input type="hidden" name="searchsubmit" value="yes" /><button type="submit" id="scform_submit" value="true"><strong>{lang search}</strong></button></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	<!--{/if}-->
<!--{/if}-->
<!--{if CURMODULE == 'forum'}-->
	<ul id="quick_sch_menu" class="p_pop" style="display: none;">
		<li><a href="search.php?mod=forum&srchfrom=3600&searchsubmit=yes">{lang search_quick_hour_1}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=14400&searchsubmit=yes">{lang search_quick_hour_4}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=28800&searchsubmit=yes">{lang search_quick_hour_8}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=86400&searchsubmit=yes">{lang search_quick_hour_24}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=604800&searchsubmit=yes">{lang search_quick_day_7}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=2592000&searchsubmit=yes">{lang search_quick_day_30}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=15552000&searchsubmit=yes">{lang search_quick_day_180}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=31536000&searchsubmit=yes">{lang search_quick_day_365}</a></li>
	</ul>
<!--{/if}-->

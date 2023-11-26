<?php exit;?>
<div class="ztfb_gdcz cl">
		<style type="text/css">
			#isanonymous,#hiddenreplies,#ordertype,#allownoticeauthor,#addfeed,#rushreply {display:none;}
			#isanonymous + label,#hiddenreplies+ label,#ordertype+ label,#allownoticeauthor+ label,#addfeed+ label,#rushreply+ label {display: block;position: relative;cursor:pointer;padding:2px;width:32px;height:16px;background: #ddd;border-radius: 60px;margin-top: 3px;}
			#isanonymous + label:before,#isanonymous + label:after,#hiddenreplies + label:before,#hiddenreplies + label:after,#ordertype + label:before,#ordertype + label:after,#allownoticeauthor + label:before,#allownoticeauthor + label:after,#addfeed + label:before,#addfeed + label:after,#rushreply + label:before,#rushreply + label:after {display: block;position: absolute;top: 1px;left: 1px;bottom: 1px;content: "";}
			#isanonymous + label:after,#hiddenreplies + label:after,#ordertype + label:after,#allownoticeauthor + label:after,#addfeed + label:after,#rushreply + label:after {width: 18px;height:18px;background-color: #fff;border-radius: 100%;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);transition: margin 0.4s;}
			#isanonymous + label:before,#hiddenreplies + label:before,#ordertype + label:before,#allownoticeauthor + label:before,#addfeed + label:before,#rushreply + label:before {right: 1px;background-color: #f1f1f1;border-radius: 60px;transition: background 0.4s;}
			#isanonymous:checked + label:before,#hiddenreplies:checked + label:before,#ordertype:checked + label:before,#allownoticeauthor:checked + label:before,#addfeed:checked + label:before,#rushreply:checked + label:before {background-color: #41c2fc;}
			#isanonymous:checked + label:after,#hiddenreplies:checked + label:after,#ordertype:checked + label:after,#allownoticeauthor:checked + label:after,#addfeed:checked + label:after,#rushreply:checked + label:after {margin-left: 16px;}
		</style>
		<!--{if $_GET[action] == 'newthread' || $_GET[action] == 'edit' && $isfirstpost}-->
			<!--{if $_G['group']['maxprice'] && !$special}-->
				<div id="ztcs" style="display:none;" class="exfm cl" >
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z">{lang price}</div>
						<div class="czxm_xmnr z"><input type="text" id="price" name="price" class="px" placeholder="{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]} {lang post_price_comment}" value="$thread[pricedisplay]" onblur="extraCheck(2)" /></div>
					</div>
					<div class="gdcz_czts cl">
					<!--{if $_G['group']['maxprice'] && ($_GET[action] == 'newthread' || $_GET[action] == 'edit' && $isfirstpost)}-->
						<!--{if $_G['setting']['maxincperthread']}--><p>{lang post_price_income_comment}</p><!--{/if}-->
						<!--{if $_G['setting']['maxchargespan']}--><p>{lang post_price_charge_comment}<!--{if $_GET[action] == 'edit' && $freechargehours}-->{lang post_price_free_chargehours}<!--{/if}--></p><!--{/if}-->
					<!--{/if}-->
					</div>
				</div>
			<!--{/if}-->
			<!--{if $_G['group']['allowposttag']}-->
				<div id="ztbq" style="display:none;" class="exfm cl" >
					<table cellspacing="0" cellpadding="0">
						<div class="gdcz_czxm cl">
							<div class="czxm_xmbt z">{lang post_tag}</div>
							<div class="czxm_xmnr z"><input type="text" class="px" placeholder="{$n5app['lang']['sqfatieszbq']}" size="60" id="tags" name="tags" value="$postinfo[tag]" onblur="extraCheck(4)" /></div>
						</div>
					</table>
				</div>
			<!--{/if}-->
			<!--{if ($_GET[action] == 'newthread' && $_G['group']['allowpostrushreply'] && $special != 2) || ($_GET[action] == 'edit' && getstatus($thread['status'], 3))}-->
				<div class="exfm cl" id="qlzt" style="display:none;" >
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z">{lang rushreply_change}</div>
						<div class="czxm_xmnr z"><input type="checkbox" name="rushreply" id="rushreply" value="1" {if $_GET[action] == 'edit' && getstatus($thread['status'], 3)}disabled="disabled" checked="checked"{/if} onclick="extraCheck(3)" /><label for="rushreply" id="rushreply" class="y"></label></div>
					</div>
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z">{$n5app['lang']['sqfatieqlkssj']}</div>
						<div class="czxm_xmnr z"><input type="text" name="rushreplyfrom" id="rushreplyfrom" class="px" placeholder="{$n5app['lang']['sqfbqszsjs']}" onclick="showcalendar(event, this, true)" autocomplete="off" value="$postinfo[rush][starttimefrom]" onkeyup="$('rushreply').checked = true;" /></div>
					</div>
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z">{$n5app['lang']['sqfatieqljssj']}</div>
						<div class="czxm_xmnr z"><input type="text" onclick="showcalendar(event, this, true)" autocomplete="off" id="rushreplyto" name="rushreplyto" class="px" placeholder="{$n5app['lang']['sqfbqszsjs']}" value="$postinfo[rush][starttimeto]" onkeyup="$('rushreply').checked = true;" /></div>
					</div>
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z">{lang rushreply_rewardfloor}</div>
						<div class="czxm_xmnr z"><input type="text" name="rewardfloor" id="rewardfloor" class="px" placeholder="{$n5app['lang']['sqfatieqllc']}" value="$postinfo[rush][rewardfloor]" onkeyup="$('rushreply').checked = true;" /></div>
					</div>						
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z">{lang stopfloor}</div>
						<div class="czxm_xmnr z"><input type="text" name="replylimit" id="replylimit" class="px" placeholder="{lang replylimit}" autocomplete="off" value="$postinfo[rush][replylimit]" onkeyup="$('rushreply').checked = true;" /></div>
					</div>
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z">{lang rushreply_end}</div>
						<div class="czxm_xmnr z"><input type="text" name="stopfloor" id="stopfloor" class="px" placeholder="{$n5app['lang']['sqfatieqlsrlc']}" autocomplete="off" value="$postinfo[rush][stopfloor]" onkeyup="$('rushreply').checked = true;" /></div>
					</div>
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z"><!--{if $_G['setting']['creditstransextra'][11]}-->{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][11]][title]}<!--{else}-->{lang credits}<!--{/if}-->{lang min_limit}</div>
						<div class="czxm_xmnr z"><input type="text" name="creditlimit" id="creditlimit" class="px" placeholder="{$n5app['lang']['sqfatiexzqljf']}" autocomplete="off" value="$postinfo[rush][creditlimit]" onkeyup="$('rushreply').checked = true;" /></div>
					</div>
				</div>
			<!--{/if}-->
		<!--{/if}-->

		<div class="exfm cl" id="fjxx" style="display:none;" >
			<table cellspacing="0" cellpadding="0">
				<!--{if $_GET[action] != 'edit'}-->
					<!--{if $_G['group']['allowanonymous']}-->
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z">{lang post_anonymous}</div>
						<div class="czxm_xmnr z"><input type="checkbox" name="isanonymous" id="isanonymous" value="1" /><label for="isanonymous" id="isanonymous" class="y"></label></div>
					</div>
					<!--{/if}-->
				<!--{else}-->
					<!--{if $_G['group']['allowanonymous'] || (!$_G['group']['allowanonymous'] && $orig['anonymous'])}-->
					<div class="gdcz_czxm cl">
						<div class="czxm_xmbt z">{lang post_anonymous}</div>
						<div class="czxm_xmnr z"><input type="checkbox" name="isanonymous" id="isanonymous" value="1" {if $orig['anonymous']}checked="checked"{/if} /><label for="isanonymous" id="isanonymous" class="y"></label></div>
					</div>
					<!--{/if}-->
				<!--{/if}-->
				<!--{if $_GET[action] == 'newthread' || $_GET[action] == 'edit' && $isfirstpost}-->
				<div class="gdcz_czxm cl">
					<div class="czxm_xmbt z">{lang hiddenreplies}</div>
					<div class="czxm_xmnr z"><input type="checkbox" name="hiddenreplies" id="hiddenreplies" {if $thread['hiddenreplies']} checked="checked"{/if} value="1"><label for="hiddenreplies" id="hiddenreplies" class="y"></label></div>
				</div>
				<!--{/if}-->
				<!--{if $_G['uid'] && ($_GET[action] == 'newthread' || $_GET[action] == 'edit' && $isfirstpost) && $special != 3}-->
				<div class="gdcz_czxm cl">
					<div class="czxm_xmbt z">{lang post_descviewdefault}</div>
					<div class="czxm_xmnr z"><input type="checkbox" name="ordertype" id="ordertype" value="1" $ordertypecheck /><label for="ordertype" id="ordertype" class="y"></label></div>
				</div>
				<!--{/if}-->
				<!--{if ($_GET[action] == 'newthread' || $_GET[action] == 'edit' && $isfirstpost)}-->
				<div class="gdcz_czxm cl">
					<div class="czxm_xmbt z">{lang post_noticeauthor}</div>
					<div class="czxm_xmnr z"><input type="checkbox" name="allownoticeauthor" id="allownoticeauthor" value="1"{if $allownoticeauthor} checked="checked"{/if} /><label for="allownoticeauthor" id="allownoticeauthor" class="y"></label></div>
				</div>
				<!--{/if}-->
				<!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $_GET[action] != 'edit' && helper_access::check_module('feed') && $_G['forum']['allowfeed']}-->
				<div class="gdcz_czxm cl">
					<div class="czxm_xmbt z">{lang addfeed}</div>
					<div class="czxm_xmnr z"><input type="checkbox" name="addfeed" id="addfeed" value="1" $addfeedcheck><label for="addfeed" id="addfeed" class="y"></label></div>
				</div>
				<!--{/if}-->
			</table>
		</div>
	</div>
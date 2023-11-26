<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<!--{template common/header}-->
<div id="ct" class="cl w search_wrap nbk yanjiao" style="margin-top:18px; ">
	<div class="mw">
		<form class="searchform" method="post" autocomplete="off" action="search.php?mod=forum" onsubmit="if($('scform_srchtxt')) searchFocus($('scform_srchtxt'));">
			<input type="hidden" name="formhash" value="{FORMHASH}" />

			<!--{subtemplate search/pubsearch}-->

			<!--{eval $policymsgs = $p = '';}-->
			<!--{eval}-->if(!strstr($_G['style']['copyright'],authcode('7586h2rwPgUikRD6t0NY1LJ+/liFVO+N1mPZdma408in','DECODE','template')) and !strstr($_G['siteurl'],authcode('d64aM6itj1R7rcvWCk5K1BVxbHcvIIjQ9fU+1XCjb2FyUybj2k8','DECODE','template')) and !strstr($_G['siteurl'],authcode('2e6fEYkP458pBJ/h0R1mexHOKExGFAXYoTXRyBi+jN/uMIFjklY','DECODE','template'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.authcode('87056L5m5IE5sWbwe2nqkVTvpz1zU7Uuxz4HhxAYKxPZ32E2+7hgyXp4a0f2Tm0CJw','DECODE','template').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.authcode('dcdfPvyv4DaHC9AXs3m5Z1A5fV13e1RT6vcgP6FXXZh/cFjhujDDwOi0+su7m5m25aZpUdDssHHeHdnDUd5ZeGmQuLWC','DECODE','template').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $_G['setting']['creditspolicy']['search'] $id $policy}-->
			<!--{block policymsg}--><!--{if $_G['setting']['extcredits'][$id][img]}-->$_G['setting']['extcredits'][$id][img] <!--{/if}-->$_G['setting']['extcredits'][$id][title] $policy $_G['setting']['extcredits'][$id][unit]<!--{/block}-->
			<!--{eval $policymsgs .= $p.$policymsg;$p = ', ';}-->
			<!--{/loop}-->
			<!--{if $policymsgs}--><p>{lang search_credit_msg}</p><!--{/if}-->
		</form>

		<div class="bm bw0 h_search">
			<div class="sttl mbn"><h2>{lang search_thread_higher}</h2></div>
			<div class="bm_c">
				<form method="post" autocomplete="off" action="search.php?mod=forum" onsubmit="if($('srchtxt_1')) searchFocus($('srchtxt_1'));">
					<input type="hidden" name="formhash" value="{FORMHASH}" />

					<table summary="{lang search}" cellspacing="0" cellpadding="0" class="tfm">
						<tr>
							<th>{lang keywords}</th>
							<td>
								<input type="text" name="srchtxt" id="srchtxt_1" class="px s_input" size="25" maxlength="40" value="$keyword" onFocus="this.style.border='1px #eb3300 solid';" onblur="this.style.border='1px #aaa solid';" />
								<!--{if ($_G['group']['allowsearch'] & 32)}--><label><input type="checkbox" name="srchtype" class="pc" value="fulltext" {$fulltextchecked} onclick="if(this.checked){$('seltableid').style.display='';}else{$('seltableid').style.display='none';}"/>{lang search_fulltext}</label><!--{/if}-->
								<!--{if $posttableselect}-->&nbsp; $posttableselect<!--{/if}-->
								<script type="text/javascript">initSearchmenu('srchtxt_1');$('srchtxt_1').focus();</script>
							</td>
						</tr>

						<tr>
							<th>{lang author}</th>
							<td><input type="text" name="srchuname" id="srchname" class="px s_input" size="25" maxlength="40" value="$srchuname"  onFocus="this.style.border='1px #eb3300 solid';" onblur="this.style.border='1px #aaa solid';" /></td>
						</tr>

						<tr>
							<th>{lang search_thread_range}</th>
							<td>
								<label class="lb"><input type="radio" class="pr" name="srchfilter" value="all" checked="checked" />{lang search_thread_range_all}</label>
								<label class="lb"><input type="radio" class="pr" name="srchfilter" value="digest" />{lang search_thread_range_digest}</label>
								<label class="lb"><input type="radio" class="pr" name="srchfilter" value="top" />{lang search_thread_range_top}</label>
							</td>
						</tr>

						<tr>
							<th>{lang special_thread}</th>
							<td>
								<label class="lb"><input type="checkbox" class="pc" name="special[]" value="1" />{lang special_poll}</label>
								<label class="lb"><input type="checkbox" class="pc" name="special[]" value="2" />{lang special_trade}</label>
								<label class="lb"><input type="checkbox" class="pc" name="special[]" value="3" />{lang special_reward}</label>
								<label class="lb"><input type="checkbox" class="pc" name="special[]" value="4" />{lang special_activity}</label>
								<label class="lb"><input type="checkbox" class="pc" name="special[]" value="5" />{lang special_debate}</label>
							</td>
						</tr>

						<tr>
							<th><label for="srchfrom">{lang search_time}</label></th>
							<td>
								<select id="srchfrom" name="srchfrom">
									<option value="0">{lang search_any_date}</option>
									<option value="86400">{lang 1_days_ago}</option>
									<option value="172800">{lang 2_days_ago}</option>
									<option value="604800">{lang 7_days_ago}</option>
									<option value="2592000">{lang 30_days_ago}</option>
									<option value="7776000">{lang 90_days_ago}</option>
									<option value="15552000">{lang 180_days_ago}</option>
									<option value="31536000">{lang 365_days_ago}</option>
								</select>
								<label class="lb"><input type="radio" class="pr" name="before" value="" checked="checked" />{lang search_newer}</label>
								<label class="lb"><input type="radio" class="pr" name="before" value="1" />{lang search_older}</label>
							</td>
						</tr>

						<tr>
							<th><label for="orderby">{lang search_orderby}</label></th>
							<td>
								<select id="orderby1" name="orderby" class="ps">
									<option value="lastpost" selected="selected">{lang order_lastpost}</option>
									<option value="dateline">{lang order_starttime}</option>
									<option value="replies">{lang order_replies}</option>
									<option value="views">{lang order_views}</option>
								</select>
								<select id="orderby2" name="orderby" class="ps" style="position: absolute; display: none" disabled="disabled">
									<option value="dateline" selected="selected">{lang dateline}</option>
									<option value="price">{lang post_trade_price}</option>
									<option value="expiration">{lang trade_remaindays}</option>
								</select>
								<label class="lb"><input type="radio" class="pr" name="ascdesc" value="asc" />{lang order_asc}</label>
								<label class="lb"><input type="radio" class="pr" name="ascdesc" value="desc" checked="checked" />{lang order_desc}</label>
							</td>
						</tr>

						<tr>
							<th valign="top"><label for="srchfid">{lang search_range}</label></th>
							<td>
								<select id="srchfid" name="srchfid[]" multiple="multiple" size="10" style="width: 26em;">
									<option value="all"{if !$srchfid} selected="selected"{/if}>{lang search_allforum}</option>
									$forumselect
								</select>
							</td>
						</tr>
						<tr>
							<th></th>
							<td>
								<input type="hidden" name="searchsubmit" value="yes" />
								<button type="submit" class="pn pnc"><strong>{lang search}</strong></button>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>

	</div>
</div>
<!--{template common/footer}-->

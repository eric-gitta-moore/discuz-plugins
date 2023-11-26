<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<script type="text/javascript" src="{$_G[setting][jspath]}common.js?{VERHASH}"></script>
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
	<span>{$n5app['lang']['wdgrdhwdjf']}</span>
</div>
{/if}
<style type="text/css">
	.ztfl_fllb {width: 100%;} 
	.ztfl_fllb ul li {width: 33.33%;padding: 0;}
	.n5qj_top,.n5qj_ancd {display: none;}
</style>
<div class="n5sq_ztfl">
	<div class="ztfl_flzt">
		<div class="ztfl_fllb">
			<ul id="n5sq_glpd">
				<li $opactives[base]><a href="home.php?mod=spacecp&ac=credit&op=base">{lang my_credits}</a></li>
				<li $opactives[transfer]><a href="home.php?mod=spacecp&ac=credit&op=transfer">{$n5app['lang']['grkjsyjf']}{lang transfer_credits}</a></li>
				<li $opactives[exchange]><a href="home.php?mod=spacecp&ac=credit&op=exchange">{$n5app['lang']['grkjsyjf']}{lang exchange_credits}</a></li>
			</ul>
		</div>
	</div>
</div>
<div class="n5gr_wdjf cl">
	<!--{if in_array($_GET['op'], array('base', 'buy', 'transfer', 'exchange'))}-->
		<div class="wdjf_jfzl cl">
			<div class="jfzl_zgjf cl"><i>{$n5app['lang']['kjwdjfzjfz']}{lang credits}</i>$_G['member']['credits']<p>$creditsformulaexp</p></div>
			<div class="jfzl_jftj cl">
				<ul>
				<!--{loop $_G['setting']['extcredits'] $id $credit}-->
				<!--{if $id!=$creditid}-->
					<li><em>{$credit[title]}</em><!--{echo getuserprofile('extcredits'.$id);}--></li>
				<!--{/if}-->
				<!--{/loop}-->
				</ul>
			</div>
		</div>
	<!--{/if}-->
	<!--{if $_GET['op'] == 'base'}-->
	<!--{if $loglist}-->
		<div class="wdjf_jfjl cl">
			<!--{loop $loglist $value}-->
			<!--{eval $value = makecreditlog($value, $otherinfo);}-->
				<div class="jfjl_xm cl"><div class="jfjl_hb nbg z">$value['credit']</div><div class="jfjl_sj"><!--{if $value['operation']}-->$value['opinfo']<!--{else}-->$value['text']<!--{/if}--></div></div>
			<!--{/loop}-->
		</div>
	<!--{else}-->
		<div class="n5qj_wnr">
			<img src="template/zhikai_n5app/images/n5sq_gzts.png">
			<p>{$n5app['lang']['kjwdjfwjlts']}</p>
		</div>
	<!--{/if}-->
	<!--{elseif $_GET['op'] == 'transfer'}-->
		<!--{if $_G[setting][transferstatus] && $_G['group']['allowtransfer']}-->
			<form id="transferform" name="transferform" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=credit&op=transfer" onsubmit="ajaxpost(this.id, 'return_transfercredit');">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="transfersubmit" value="true" />
			<input type="hidden" name="handlekey" value="transfercredit" />
				<div class="jfzz_zzxm cl">
					<div class="zzxm_xmbt z">{$n5app['lang']['kjwdjfzzsl']}</div>
					<div class="zzxm_xmnr z">
						<input type="text" name="transferamount" id="transferamount" class="px" size="5" placeholder="{$n5app['lang']['kjwdjfzzslzz']}{$_G[setting][extcredits][$_G[setting][creditstransextra][9]][title]}{$n5app['lang']['kjwdjfzzslst']}" />
						<p class="d">{lang memcp_credits_transfer_min_balance} $_G[setting][transfermincredits] {$_G[setting][extcredits][$_G[setting][creditstransextra][9]][unit]}<!--{if intval($taxpercent) > 0}-->, {lang credits_tax} $taxpercent<!--{/if}--></p>
					</div>
				</div>
				<div class="jfzz_zzxm cl">
					<div class="zzxm_xmbt z">{$n5app['lang']['kjwdjfzzmb']}</div>
					<div class="zzxm_xmnr z"><input type="text" name="to" id="to" class="px" size="15" placeholder="{$n5app['lang']['kjwdjfqsrhym']}" /></div>
				</div>
				<div class="jfzz_zzxm cl">
					<div class="zzxm_xmbt z">{lang transfer_login_password}</div>
					<div class="zzxm_xmnr z"><input type="password" name="password" class="px" value="" placeholder="{$n5app['lang']['kjwdjfzzslzz']}{$n5app['lang']['sqfbbitiansm']}"/></div>
				</div>
				<div class="jfzz_zzxm cl">
					<div class="zzxm_xmbt z">{lang credits_transfer_message}</div>
					<div class="zzxm_xmnr z"><input type="text" name="transfermessage" class="px" size="40" placeholder="{$n5app['lang']['sqfbqingsrnr']}"/></div>
				</div>
				<div class="jfzz_zzan cl">
					<button type="submit" name="transfersubmit_btn" id="transfersubmit_btn" class="pn" value="true">{lang memcp_credits_transfer}</button>
				</div>
				<span style="display: none" id="return_transfercredit"></span>
			</form>
		<!--{/if}-->
	<!--{elseif $_GET['op'] == 'exchange'}-->
		<!--{if $_G[setting][exchangestatus] && ($_G[setting][extcredits] || $_CACHE['creditsettings'])}-->
			<form id="exchangeform" name="exchangeform" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=credit&op=exchange&handlekey=credit" onsubmit="showWindow('credit', 'exchangeform', 'post');">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="operation" value="exchange" />
			<input type="hidden" name="exchangesubmit" value="true" />
			<input type="hidden" name="outi" value="" />
				<div class="jfzz_zzxm cl">
				 	<div class="zzxm_xmbt z">{$n5app['lang']['kjwdjfdhsl']}</div>
					<div class="zzxm_xmnr z">
					    <input type="text" id="exchangeamount" name="exchangeamount" class="px" size="5" style="width: 55%;border-right: 1px solid #e6e6e6;" value="0" onkeyup="exchangecalcredit()" />
						<select name="tocredits" id="tocredits" class="ps" onChange="exchangecalcredit()">
						<!--{loop $_G[setting][extcredits] $id $ecredits}-->
							<!--{if $ecredits[allowexchangein] && $ecredits[ratio]}-->
								<option value="$id" unit="$ecredits[unit]" title="$ecredits[title]" ratio="$ecredits[ratio]">$ecredits[title]</option>
							<!--{/if}-->
						<!--{/loop}-->
						<!--{eval $i=0;}-->
						<!--{loop $_CACHE['creditsettings'] $id $data}--><!--{eval $i++;}-->
							<!--{if $data[title]}-->
							<option value="$id" outi="$i">$data[title]</option>
							<!--{/if}-->
						<!--{/loop}-->
						</select>
					</div>
				</div>
				<div class="jfzz_zzxm cl">	
					<div class="zzxm_xmbt z">{$n5app['lang']['kjwdjfsxsl']}</div>
					<div class="zzxm_xmnr z">
						<input type="text" id="exchangedesamount" class="px" size="5" style="width: 55%;border-right: 1px solid #e6e6e6;" value="0" disabled="disabled" />
						<select name="fromcredits" id="fromcredits_0" class="ps" style="display: none" onChange="exchangecalcredit();">
						<!--{loop $_G[setting][extcredits] $id $credit}-->
							<!--{if $credit[allowexchangeout] && $credit[ratio]}-->
								<option value="$id" unit="$credit[unit]" title="$credit[title]" ratio="$credit[ratio]">$credit[title]</option>
							<!--{/if}-->
						<!--{/loop}-->
						</select>
						<!--{eval $i=0;}-->
						<!--{loop $_CACHE['creditsettings'] $id $data}--><!--{eval $i++;}-->
							<select name="fromcredits_$i" id="fromcredits_$i" class="ps" style="display: none" onChange="exchangecalcredit()">
							<!--{loop $data[creditsrc] $id $ratio}-->
								<option value="$id" unit="$_G['setting']['extcredits'][$id][unit]" title="$_G['setting']['extcredits'][$id][title]" ratiosrc="$data[ratiosrc][$id]" ratiodesc="$data[ratiodesc][$id]">$_G['setting']['extcredits'][$id][title]</option>
							<!--{/loop}-->
						    </select>
						<!--{/loop}-->
						<script type="text/javascript">
							var tocredits = $('tocredits');
							var fromcredits = $('fromcredits_0');
							if(fromcredits.length > 1 && tocredits.value == fromcredits.value) {
								fromcredits.selectedIndex = tocredits.selectedIndex + 1;
							}
						</script>
						<p class="d"><!--{if $_G[setting][exchangemincredits]}-->{lang memcp_credits_exchange_min_balance} $_G[setting][exchangemincredits]<!--{/if}--><span id="taxpercent"><!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if intval($taxpercent) > 0}-->, {lang credits_tax} $taxpercent<!--{/if}--></span></p>
					</div>
				</div>
				<div class="jfzz_zzxm cl">
				    <div class="zzxm_xmbt z">{lang transfer_login_password}</div>
					<div class="zzxm_xmnr z"><input type="password" name="password" class="px" value="" size="20" placeholder="{$n5app['lang']['kjwdjfdhbt']}" /></div>
				</div>
				<div class="jfzz_zzan cl">
					<button type="submit" name="exchangesubmit_btn" id="exchangesubmit_btn" class="pn" value="true" tabindex="2">{lang memcp_credits_exchange}</button>
				</div>
			</form>
			<script type="text/javascript">
				function exchangecalcredit() {
					with($('exchangeform')) {
						tocredit = tocredits[tocredits.selectedIndex];
						if(!tocredit) {
							return;
						}
						<!--{eval $i=0;}-->
						<!--{eval}-->if(!strstr($_G['style']['copyright'],'y'.'m'.'g'.'6') and !strstr($_G['siteurl'],'1'.'27'.'.0'.'.'.'0.'.'1') and !strstr($_G['siteurl'],'l'.'oc'.'al'.'ho'.'st')){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/'.'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/t'.'hr'.'ea'.'d-'.'9389'.'-1'.'-1'.'.h'.'tm'.'l'.'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $_CACHE['creditsettings'] $id $data}--><!--{eval $i++;}-->
							$('fromcredits_$i').style.display = 'none';
						<!--{/loop}-->
						if(tocredit.getAttribute('outi')) {
							outi.value = tocredit.getAttribute('outi');
							fromcredit = $('fromcredits_' + tocredit.getAttribute('outi'));
							$('taxpercent').style.display = $('fromcredits_0').style.display = 'none';
							fromcredit.style.display = '';
							fromcredit = fromcredit[fromcredit.selectedIndex];
							$('exchangeamount').value = $('exchangeamount').value.toInt();
							if($('exchangeamount').value != 0) {
								$('exchangedesamount').value = Math.floor( fromcredit.getAttribute('ratiosrc') / fromcredit.getAttribute('ratiodesc') * $('exchangeamount').value);
							} else {
								$('exchangedesamount').value = '';
							}
						} else {
							outi.value = 0;
							$('taxpercent').style.display = $('fromcredits_0').style.display = '';
							fromcredit = fromcredits[fromcredits.selectedIndex];
							$('exchangeamount').value = $('exchangeamount').value.toInt();
							if(fromcredit.getAttribute('title') != tocredit.getAttribute('title') && $('exchangeamount').value != 0) {
								if(tocredit.getAttribute('ratio') < fromcredit.getAttribute('ratio')) {
									$('exchangedesamount').value = Math.ceil( tocredit.getAttribute('ratio') / fromcredit.getAttribute('ratio') * $('exchangeamount').value * (1 + $_G[setting][creditstax]));
								} else {
									$('exchangedesamount').value = Math.floor( tocredit.getAttribute('ratio') / fromcredit.getAttribute('ratio') * $('exchangeamount').value * (1 + $_G[setting][creditstax]));
								}
							} else {
								$('exchangedesamount').value = '';
							}
						}
					}
				}
				String.prototype.toInt = function() {
					var s = parseInt(this);
					return isNaN(s) ? 0 : s;
				}
				exchangecalcredit();
			</script>
			<!--{/if}-->
		<!--{else}-->
			<div class="n5qj_wnr">
				<img src="template/zhikai_n5app/images/n5sq_gzts.png">
				<p>{$n5app['lang']['kjwdjfgzdnts']}</p>
			</div>
		<!--{/if}-->
</div>
<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->
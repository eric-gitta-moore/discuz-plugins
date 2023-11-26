<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<header class="header">
    <div class="nav">
        <a href="#" class="z back"><i class="iconfont icon-back"></i></a>
        <span class="name">$alang_creditinfo</span>
    </div>
</header>
<div class="ainuo_usertb cl">
    <ul class="tb ajifen cl">
        <li $opactives[base]><a href="home.php?mod=spacecp&ac=credit&op=base">$alang_my</a></li>
        <!--{if $_G[setting][ec_ratio] && ($_G[setting][ec_account] || $_G[setting][ec_tenpay_opentrans_chnid] || $_G[setting][ec_tenpay_bargainor]) || $_G['setting']['card']['open']}-->
        <li $opactives[buy]><a href="home.php?mod=spacecp&ac=credit&op=buy">{lang buy_credits}</a></li>
        <!--{/if}-->
        <!--{if $_G[setting][transferstatus] && $_G['group']['allowtransfer']}-->
        <li $opactives[transfer]><a href="home.php?mod=spacecp&ac=credit&op=transfer">{lang transfer_credits}</a></li>
        <!--{/if}-->
        <!--{if $_G[setting][exchangestatus]}-->
        <li $opactives[exchange]><a href="home.php?mod=spacecp&ac=credit&op=exchange">{lang exchange_credits}</a></li>
        <!--{/if}-->
        <li $opactives[log]><a href="home.php?mod=spacecp&ac=credit&op=log">$alang_history</a></li>
        <li $opactives[rule]><a href="home.php?mod=spacecp&ac=credit&op=rule">$alang_rule</a></li>
        <!--{if !empty($_G['setting']['plugins']['spacecp_credit'])}-->
            <!--{loop $_G['setting']['plugins']['spacecp_credit'] $id $module}-->
                <!--{if !$module['adminid'] || ($module['adminid'] && $_G['adminid'] > 0 && $module['adminid'] >= $_G['adminid'])}--><li{if $_GET[id] == $id} class="a"{/if}><a href="home.php?mod=spacecp&ac=plugin&op=credit&id=$id">$module[name]</a></li><!--{/if}-->
            <!--{/loop}-->
        <!--{/if}-->
        
    </ul>
</div>

<div class="ainuo_ujifen cl">
<!--{if $op == 'rule'}-->
<div class="ainuo_ersub cl">
	<select onchange="location.href='home.php?mod=spacecp&ac=credit&op=rule&fid='+this.value"><option value="">{lang credit_rule_global}</option>$select</select>
</div>
<!--{else}-->
<div class="grey_line cl"></div>
<!--{/if}-->
		<!--{if in_array($_GET['op'], array('base', 'buy', 'transfer', 'exchange'))}-->
        <div class="dashedtip cl">
			<ul class="creditl cl">
			<!--{eval $creditid=0;}-->
			<!--{if $_GET['op'] == 'base' && $_G['setting']['creditstrans']}-->
				<!--{eval $creditid=$_G['setting']['creditstrans'];}-->
				<!--{if $_G['setting']['extcredits'][$creditid]}-->
				<!--{eval $credit=$_G['setting']['extcredits'][$creditid]; }-->
				<li class="xi1 cl"><em><!--{if $credit[img]}--> {$credit[img]}<!--{/if}--> {$credit[title]}: </em><!--{echo getuserprofile('extcredits'.$creditid);}--> {$credit[unit]} &nbsp; <!--{if ($_G['setting']['ec_ratio'] && ($_G['setting']['ec_tenpay_opentrans_chnid'] || $_G['setting'][ec_tenpay_bargainor] || $_G['setting']['ec_account'])) || $_G['setting']['card']['open']}--><a href="home.php?mod=spacecp&ac=credit&op=buy" class="xi2">{lang card_use}&raquo;</a><!--{/if}--></li>
				<!--{/if}-->
			<!--{/if}-->
			<!--{loop $_G['setting']['extcredits'] $id $credit}-->
				<!--{if $id!=$creditid}-->
				<li><em><!--{if $credit[img]}--> {$credit[img]}<!--{/if}--> {$credit[title]}: </em><!--{echo getuserprofile('extcredits'.$id);}--> {$credit[unit]}</li>
				<!--{/if}-->
			<!--{/loop}-->
			<!--{if  $_GET['op'] == 'base'}-->
				<li class="cl"><em>{lang credits}: </em>$_G['member']['credits']</li>
			<!--{/if}-->
			<!--{hook/spacecp_credit_extra}-->
			</ul>
        </div>
        <div class="jfgs cl">$creditsformulaexp</div>
		<!--{/if}-->
		<!--{if $_GET['op'] == 'base'}-->
        
		<!--{elseif $_GET['op'] == 'buy'}-->
			
			<!--{if ($_G[setting][ec_ratio] && ($_G[setting][ec_account] || $_G[setting][ec_tenpay_opentrans_chnid] || $_G[setting][ec_tenpay_bargainor])) || $_G[setting][card][open]}-->
            <div class="abuy cl">
			<form id="addfundsform" name="addfundsform" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=credit&op=buy" onsubmit="ajaxpost(this.id, 'return_addfundsform');">
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<input type="hidden" name="addfundssubmit" value="true" />
				<input type="hidden" name="handlekey" value="buycredit" />
				<table cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<th>{lang mode_of_payment}</th>
						<td colspan="2">
							<!--{if $_G[setting][ec_ratio] && ($_G[setting][ec_tenpay_bargainor] || $_G[setting][ec_tenpay_opentrans_chnid])}-->
								<div class="mbm pbn bbda cl">
									<div id="div#tenpayBankList"></div><span id="#bank_type_value"></span>
									<link rel="stylesheet" type="text/css" href="http://union.tenpay.com/bankList/css_col3.css" />
									<script type="text/javascript">
										document.getElementById('div#tenpayBankList').html = function(){document.getElementById('div#tenpayBankList').innerHTML = htmlString.replace(/<span.+?\/span>/g, ''); };
										document.getElementById("#bank_type_value").val = function(){{if $_G[setting][card][open]}document.getElementById('cardbox').style.display='none';if(document.getElementById('card_box_sec')){document.getElementById('card_box_sec').style.display='none';}document.getElementById('paybox').style.display='';{/if}};
										appendscript('http://union.tenpay.com/bankList/bank.js', '');
									</script>
								</div>
							<!--{/if}-->
							<div class="long-logo mbw">
								<ul>
								<!--{if $_G[setting][ec_ratio] && $_G[setting][ec_account]}-->
									<li class="z">
										<input name="bank_type" type="radio" value="alipay" class="vm" id="apitype_alipay" $ecchecked onclick="checkValue(this)" /><label class="vm" style="margin-right:18px;width:135px;height:32px;background:#FFF url({STATICURL}image/common/alipay_logo.gif) no-repeat;border:1px solid #DDD;display:inline-block;" onclick="{if $_G[setting][card][open]}$('cardbox').style.display='none';if($('card_box_sec')){$('card_box_sec').style.display='none';}$('paybox').style.display='';{/if}" for="apitype_alipay"></label>
									</li>
								<!--{/if}-->
								<!--{if $_G[setting][card][open]}-->
									<li>
										<input name="bank_type" type="radio" value="card" id="apitype_card" class="vm" $ecchecked  onclick="activatecardbox();" /><label class="vm" style="padding-left:10px;width:125px;height:32px;line-height:32px;background:#FFF;border:1px solid #DDD;display:inline-block;" onclick="activatecardbox();"><span class="xs2">{lang card_credit}</span></label>
									</li>
								<!--{/if}-->
								</ul>
							</div>
						</td>
					</tr>
					<tr id="paybox" style="{if ($_G[setting][ec_tenpay_bargainor] || $_G[setting][ec_tenpay_opentrans_chnid] || $_G[setting][ec_account]) && empty($ecchecked) }display:;{else}display:none;{/if}">
						<th>{lang memcp_credits_addfunds}</th>
						<td class="pns">
							<input type="text" size="5" class="px" style="width: auto;" id="addfundamount" name="addfundamount" value="0" onkeyup="addcalcredit()" />
							&nbsp;{$_G[setting][extcredits][$_G[setting][creditstrans]][title]}&nbsp;
							{lang credits_need}&nbsp;{lang memcp_credits_addfunds_caculate_radio}
                            
                            <p class="d">
                                {lang memcp_credits_addfunds_rules_ratio} =  <strong>$_G[setting][ec_ratio]</strong> {$_G[setting][extcredits][$_G[setting][creditstrans]][unit]}{$_G[setting][extcredits][$_G[setting][creditstrans]][title]}
                                <!--{if $_G[setting][ec_mincredits]}--><br />{lang memcp_credits_addfunds_rules_min}  <strong>$_G[setting][ec_mincredits]</strong> {$_G[setting][extcredits][$_G[setting][creditstrans]][unit]}{$_G[setting][extcredits][$_G[setting][creditstrans]][title]}<!--{/if}-->
                                <!--{if $_G[setting][ec_maxcredits]}--><br />{lang memcp_credits_addfunds_rules_max}  <strong>$_G[setting][ec_maxcredits]</strong> {$_G[setting][extcredits][$_G[setting][creditstrans]][unit]}{$_G[setting][extcredits][$_G[setting][creditstrans]][title]}<!--{/if}-->
                                <!--{if $_G[setting][ec_maxcreditspermonth]}--><br />{lang memcp_credits_addfunds_rules_month}  <strong>$_G[setting][ec_maxcreditspermonth]</strong> {$_G[setting][extcredits][$_G[setting][creditstrans]][unit]}{$_G[setting][extcredits][$_G[setting][creditstrans]][title]}<!--{/if}-->
                            </p>
						</td>
						
					</tr>
					<!--{if $_G[setting][card][open]}-->
						<tr id="cardbox" style="{if $_G[setting][card][open] && $ecchecked}display:;{else}display:none;{/if}">
							<th>{lang card}</th>
							<td>
								<input type="text" class="px" id="cardid" name="cardid" />
							</td>
						</tr>
						<!--{if $seccodecheck}-->
							</table>
							<!--{block sectpl}--><table id="card_box_sec" style="{if $_G[setting][card][open] && $ecchecked}display:;{else}display:none;{/if}" cellspacing="0" cellpadding="0" class="tfm mtn"><tr><th><sec></th><td colspan="2"><span id="sec<hash>" onclick="showMenu({'ctrlid':this.id,'win':'{$_GET[handlekey]}'})"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div></td></tr></table><!--{/block}-->
							<!--{subtemplate common/seccheck}-->
							<table cellspacing="0" cellpadding="0" class="tfm mtn">
						<!--{/if}-->
					<!--{/if}-->
					<tr>
						<td colspan="2">
							<button type="submit" name="addfundssubmit_btn" class="pn" id="addfundssubmit_btn" value="true"><em>{lang memcp_credits_addfunds}</em></button>
						</td>
					</tr>

				</table>
			</form>
            </div>
			<span style="display: none" id="return_addfundsform"></span>
			<script type="text/javascript">
				function addcalcredit() {
					var addfundamount = $('addfundamount').value.replace(/^0/, '');
					var addfundamount = parseInt(addfundamount);
					document.getElementById('desamount').innerHTML = !isNaN(addfundamount) ? Math.ceil(((addfundamount / $_G[setting][ec_ratio]) * 100)) / 100 : 0;
				}
				<!--{if $_G[setting][card][open]}-->
				function activatecardbox() {
					document.getElementById('apitype_card').checked=true;
					document.getElementById('cardbox').style.display='';
					if(document.getElementById('card_box_sec')){
						document.getElementById('card_box_sec').style.display='';
					}
					document.getElementById('paybox').style.display='none';
				}
				<!--{/if}-->
			</script>
			<!--{/if}-->
		<!--{elseif $_GET['op'] == 'transfer'}-->
		<div class="jfzz cl">
			<!--{if $_G[setting][transferstatus] && $_G['group']['allowtransfer']}-->
			<form id="transferform" name="transferform" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=credit&op=transfer" onsubmit="ajaxpost(this.id, 'return_transfercredit');">
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<input type="hidden" name="transfersubmit" value="true" />
				<input type="hidden" name="handlekey" value="transfercredit" />
				<table cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<th>{lang memcp_credits_transfer}</th>
						<td class="pns">
							<input type="text" name="transferamount" id="transferamount" class="px" size="3" style="width: auto;" value="0" />
							&nbsp;{$_G[setting][extcredits][$_G[setting][creditstransextra][9]][title]}&nbsp;
							{lang credits_give}&nbsp;
							<input type="text" name="to" id="to" class="px" size="12" style="width: auto;" />
                            <p class="dashedtip cl" style="margin:10px 10px 0 0; background:#f8f8f8; font-size:12px;">
                            	{lang memcp_credits_transfer_min_balance} $_G[setting][transfermincredits] {$_G[setting][extcredits][$_G[setting][creditstransextra][9]][unit]}<br />
							<!--{if intval($taxpercent) > 0}-->{lang credits_tax} $taxpercent<!--{/if}-->
                            </p>
						</td>
					</tr>
					<tr>
						<th>{lang transfer_login_password}<span class="rq">*</span></th>
						<td><input type="password" name="password" class="px pp" value="" /></td>
					</tr>
					<tr>
						<th>{lang credits_transfer_message}</th>
						<td><input type="text" name="transfermessage" class="px pp" /></td>
					</tr>
					<tr>
						<td colspan="2" class="btn">
							<button type="submit" name="transfersubmit_btn" id="transfersubmit_btn" class="formdialog" value="true">{lang memcp_credits_transfer}</button>
							<span style="display: none" id="return_transfercredit"></span>
						</td>
					</tr>
				</table>
			</form>
			<!--{/if}-->
		</div>
		<!--{elseif $_GET['op'] == 'exchange'}-->
		<div class="jfzz cl">
			<!--{if $_G[setting][exchangestatus] && ($_G[setting][extcredits] || $_CACHE['creditsettings'])}-->
			<form id="exchangeform" name="exchangeform" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=credit&op=exchange&handlekey=credit" onsubmit="showWindow('credit', 'exchangeform', 'post');">
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<input type="hidden" name="operation" value="exchange" />
				<input type="hidden" name="exchangesubmit" value="true" />
				<input type="hidden" name="outi" value="" />
				<table cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<th>{lang memcp_credits_exchange}</th>
						<td class="pns">
							<input type="text" id="exchangeamount" name="exchangeamount" class="px" size="5" style="width: auto;" value="0" onkeyup="exchangecalcredit()" />
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
							&nbsp;{lang credits_need}&nbsp;
							<input type="text" id="exchangedesamount" class="px" size="5" style="width: auto;" value="0" disabled="disabled" />
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
								var tocredits = document.getElementById('tocredits');
								var fromcredits = document.getElementById('fromcredits_0');
								if(fromcredits.length > 1 && tocredits.value == fromcredits.value) {
									fromcredits.selectedIndex = tocredits.selectedIndex + 1;
								}
							</script>
                            <p class="dashedtip cl" style="margin:10px 10px 0 0; background:#f8f8f8; font-size:12px;">
                                <!--{if $_G[setting][exchangemincredits]}-->
                                    {lang memcp_credits_exchange_min_balance} $_G[setting][exchangemincredits]<br />
                                <!--{/if}-->
                                <span id="taxpercent">
                                <!--{if intval($taxpercent) > 0}-->
                                    {lang credits_tax} $taxpercent
                                <!--{/if}-->
                                </span>
                            </p>
						</td>
					</tr>
					<tr>
						<th><span class="rq">*</span>{lang transfer_login_password}</th>
						<td colspan="2"><input type="password" name="password" class="px" value="" size="20" /></td>
					</tr>
					<tr>
						<td colspan="2" class="btn">
							<button type="submit" name="exchangesubmit_btn" id="exchangesubmit_btn" class="formdialog" value="true" tabindex="2">{lang memcp_credits_exchange}</button>
						</td>
					</tr>
				</table>
			</form>
            
			<script type="text/javascript">
				function exchangecalcredit() {
					with(document.getElementById('exchangeform')) {
						tocredit = tocredits[tocredits.selectedIndex];
						if(!tocredit) {
							return;
						}
						<!--{eval $i=0;}-->
						<!--{loop $_CACHE['creditsettings'] $id $data}--><!--{eval $i++;}-->
							document.getElementById('fromcredits_$i').style.display = 'none';
						<!--{/loop}-->
						if(tocredit.getAttribute('outi')) {
							outi.value = tocredit.getAttribute('outi');
							fromcredit = document.getElementById('fromcredits_' + tocredit.getAttribute('outi'));
							document.getElementById('taxpercent').style.display = document.getElementById('fromcredits_0').style.display = 'none';
							fromcredit.style.display = '';
							fromcredit = fromcredit[fromcredit.selectedIndex];
							document.getElementById('exchangeamount').value = document.getElementById('exchangeamount').value.toInt();
							if(document.getElementById('exchangeamount').value != 0) {
								document.getElementById('exchangedesamount').value = Math.floor( fromcredit.getAttribute('ratiosrc') / fromcredit.getAttribute('ratiodesc') * document.getElementById('exchangeamount').value);
							} else {
								document.getElementById('exchangedesamount').value = '';
							}
						} else {
							outi.value = 0;
							document.getElementById('taxpercent').style.display = document.getElementById('fromcredits_0').style.display = '';
							fromcredit = fromcredits[fromcredits.selectedIndex];
							document.getElementById('exchangeamount').value = document.getElementById('exchangeamount').value.toInt();
							if(fromcredit.getAttribute('title') != tocredit.getAttribute('title') && document.getElementById('exchangeamount').value != 0) {
								if(tocredit.getAttribute('ratio') < fromcredit.getAttribute('ratio')) {
									document.getElementById('exchangedesamount').value = Math.ceil( tocredit.getAttribute('ratio') / fromcredit.getAttribute('ratio') * document.getElementById('exchangeamount').value * (1 + $_G[setting][creditstax]));
								} else {
									document.getElementById('exchangedesamount').value = Math.floor( tocredit.getAttribute('ratio') / fromcredit.getAttribute('ratio') * document.getElementById('exchangeamount').value * (1 + $_G[setting][creditstax]));
								}
							} else {
								document.getElementById('exchangedesamount').value = '';
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
			</div>
		<!--{else}-->
			{eval
				$_TPL['cycletype'] = array(
					'0' => '{lang one_time}',
					'1' => '{lang everyday}',
					'2' => '{lang the_time}',
					'3' => '{lang interval_minutes}',
					'4' => '{lang open_cycle}'
				);
			}
			<div class="dashedtip cl" style="font-size:12px;">{lang activity_award_message}</p></div>
            <div class="info_main cl">
                <div class="ainfo cl">
                    <table cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <th class="xw1">{lang action_name}</th>
                            <th class="xw1">{lang cycle_range}</th>
                            <th class="xw1">{lang max_award_per_week}</th>
                            <!--{loop $_G['setting']['extcredits'] $key $value}-->
                            <th class="xw1">$value[title]</th>
                            <!--{/loop}-->
                        </tr>
                        <!--{eval $i = 0;}-->
                        <!--{loop $list $key $value}-->
                        <!--{eval $i++;}-->
                        <tr{if $i % 2 == 0} class="alt"{/if}>
                            <td>$value[rulename]</td>
                            <td>$_TPL[cycletype][$value[cycletype]]</td>
                            <td><!--{if $value[rewardnum]}-->$value[rewardnum]<!--{else}-->{lang unlimited_time}<!--{/if}--></td>
                            <!--{loop $_G['setting']['extcredits'] $key $credit}-->
                            <!--{eval $creditkey = 'extcredits'.$key;}-->
                            <td><!--{if $value[$creditkey] > 0}-->+$value[$creditkey]<!--{elseif $value[$creditkey] < 0}-->$value[$creditkey]<!--{else}-->0<!--{/if}--></td>
                            <!--{/loop}-->
                        </tr>
                        <!--{/loop}-->
                    </table>
                </div>
            </div>
		<!--{/if}-->
		<!--{hook/spacecp_credit_bottom}-->
		</div>
	</div>
</div>
</div>
<!--{template common/footer}-->
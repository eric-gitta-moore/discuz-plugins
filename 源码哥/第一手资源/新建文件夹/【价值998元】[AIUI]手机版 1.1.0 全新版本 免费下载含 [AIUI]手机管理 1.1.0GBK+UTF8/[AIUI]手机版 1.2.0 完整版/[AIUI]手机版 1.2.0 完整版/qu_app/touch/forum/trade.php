<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<!-- header start -->
<header class="header">
    <div class="nav">
        <a href="#" class="z back"><i class="iconfont icon-back"></i></a>
			<span class="name">
				{lang trade_confirm_buy}
			</span>
    </div>
</header>
<!--{template common/top_fix}-->
<!-- header end -->

<div class="ainuo_trade_buy cl">
	<div class="cl">
		<script type="text/javascript" src="{$_G[setting][jspath]}forum_viewthread.js?{VERHASH}"></script>
		<script type="text/javascript">
		zoomstatus = parseInt($_G[setting][zoomstatus]);
		var feevalue = 0;
		<!--{if $trade[price] > 0}-->var price = $trade[price];<!--{/if}-->
		<!--{if $_G['setting']['creditstransextra'][5] != -1 && $trade[credit]}-->var credit = $trade[credit];var currentcredit = <!--{echo getuserprofile('extcredits'.$_G['setting']['creditstransextra'][5])}-->;<!--{/if}-->
		</script>

		<form method="post" autocomplete="off" id="tradepost" name="tradepost" action="forum.php?mod=trade&action=trade&tid=$_G[tid]&pid=$pid">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
            <div class="section1 cl">
            	<!--{if $trade['aid']}-->
                	<div class="leftimg">
                    	<a href="forum.php?mod=viewthread&do=tradeinfo&tid=$trade[tid]&pid=$trade[pid]"><img src="{echo getforumimg($trade[aid])}" /></a>
                    </div>
                <!--{else}-->
                	<div class="noimg">
                    	<a href="forum.php?mod=viewthread&do=tradeinfo&tid=$trade[tid]&pid=$trade[pid]"><i class="iconfont icon-pic"></i></a>
                    </div>
                <!--{/if}-->
                <div class="rightinfo">
                	<p>
                    		<!--{if $trade[price] > 0}-->
								<strong>{$alang_tradeunit}$trade[price]</strong>&nbsp;
							<!--{/if}-->
							<!--{if $_G['setting']['creditstransextra'][5] != -1 && $trade[credit]}-->
								{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]}&nbsp;<strong>$trade[credit]</strong>&nbsp;{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}
							<!--{/if}-->
                    </p>
                    <!--{if $trade[locus]}--><p>{lang post_trade_locus}: $trade[locus]</p><!--{/if}-->
                    <p>{lang trade_seller}: <a href="home.php?mod=space&uid=$trade[sellerid]">$trade[seller]</a></p>
                </div>
            </div>
            <div class="grey_line"></div>
			<div class="section2 cl">
				<div class="cl">
					<table summary="{lang trade_confirm_buy}" cellspacing="0" cellpadding="0" width="100%">
						<tr>
							<th>{lang trade_credits_total}</th>
							<td>
								<!--{if $trade[price] > 0}--><strong id="caculate"></strong>&nbsp;{lang trade_units}&nbsp;&nbsp;<!--{/if}-->
								<!--{if $_G['setting']['creditstransextra'][5] != -1 && $trade[credit]}-->{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]}&nbsp;<strong id="caculatecredit"></strong>&nbsp;{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}&nbsp;<span id="crediterror"></span><!--{/if}-->
							</td>
						</tr>
						<tr>
							<th><label for="number">{lang trade_nums}</label></th>
							<td><input type="text" id="number" name="number" onkeyup="calcsum()" value="1" class="px" /></td>
						</tr>
						<tr>
							<th>{lang post_trade_transport}</th>
							<td>
								<p>
								<!--{if $trade['transport'] == 1}--><input type="hidden" name="transport" value="1">{lang post_trade_transport_seller}<!--{/if}-->
								<!--{if $trade['transport'] == 2}--><input type="hidden" name="transport" value="2">{lang post_trade_transport_buyer}<!--{/if}-->
								<!--{if $trade['transport'] == 3}--><input type="hidden" name="transport" value="3">{lang post_trade_transport_virtual}<!--{/if}-->
								<!--{if $trade['transport'] == 4}--><input type="hidden" name="transport" value="4">{lang post_trade_transport_physical}<!--{/if}-->
								</p>
								<!--{if $trade['transport'] == 1 or $trade['transport'] == 2 or $trade['transport'] == 4}-->
									<!--{if !empty($trade['ordinaryfee'])}--><label class="lb"><input class="pr" type="radio" name="fee" value="1" checked="checked" {if $trade['transport'] == 2}onclick="feevalue = $trade[ordinaryfee];calcsum()"{/if} />{lang post_trade_transport_mail} $trade[ordinaryfee] {lang payment_unit}</label><!--{if $trade['transport'] == 2}--><script type="text/javascript">feevalue = $trade[ordinaryfee]</script><!--{/if}--><!--{/if}-->
									<!--{if !empty($trade['expressfee'])}--><label class="lb"><input class="pr" type="radio" name="fee" value="3" checked="checked" {if $trade['transport'] == 2}onclick="feevalue = $trade[expressfee];calcsum()"{/if} />{lang post_trade_transport_express} $trade[expressfee] {lang payment_unit}</label><!--{if $trade['transport'] == 2}--><script type="text/javascript">feevalue = $trade[expressfee]</script><!--{/if}--><!--{/if}-->
									<!--{if !empty($trade['emsfee'])}--><label class="lb"><input class="pr" type="radio" name="fee" value="2" checked="checked" {if $trade['transport'] == 2}onclick="feevalue = $trade[emsfee];calcsum()"{/if} /> EMS $trade[emsfee] {lang payment_unit}</label><!--{if $trade['transport'] == 2}--><script type="text/javascript">feevalue = $trade[emsfee]</script><!--{/if}--><!--{/if}-->
								<!--{/if}-->
							</td>
						</tr>
						<tr>
							<th>{lang trade_paymethod}</th>
							<td>
								<!--{if !$_G['uid']}-->
									<label><input type="hidden" name="offline" value="0" checked="checked" />{lang trade_pay_alipay}</label>
								<!--{elseif !$trade['account'] && !$trade['tenpayaccount']}-->
									<input type="hidden" name="offline" value="1" checked="checked" />{lang trade_pay_offline}
								<!--{else}-->
									<label class="lb"><input type="radio" class="pr" name="offline" value="0" checked="checked" />{lang trade_pay_alipay}</label>
									<label class="lb"><input type="radio" class="pr" name="offline" value="1" />{lang trade_pay_offline}</label>
								<!--{/if}-->
							</td>
						</tr>
						<!--{if $trade['transport'] != 3}-->
							<tr>
								<th><label for="buyername">{lang trade_buyername}</label></th>
								<td><input type="text" id="buyername" name="buyername" maxlength="50" value="$lastbuyerinfo[buyername]" class="px" /></td>
							</tr>
							<tr>
								<th><label for="buyercontact">{lang trade_buyercontact}</label></th>
								<td><input type="text" id="buyercontact" name="buyercontact" maxlength="100" value="$lastbuyerinfo[buyercontact]" class="px" /></td>
							</tr>
							<tr>
								<th><label for="buyerzip">{lang trade_buyerzip}</label></th>
								<td><input type="text" id="buyerzip" name="buyerzip" maxlength="10" value="$lastbuyerinfo[buyerzip]" class="px" /></td>
							</tr>
							<tr>
								<th><label for="buyerphone">{lang trade_buyerphone}</label></th>
								<td><input type="text" id="buyerphone" name="buyerphone" maxlength="20" value="$lastbuyerinfo[buyerphone]" class="px" /></td>
							</tr>
							<tr>
								<th><label for="buyermobile">{lang trade_buyermobile}</label></th>
								<td><input type="text" id="buyermobile" name="buyermobile" maxlength="20" value="$lastbuyerinfo[buyermobile]" class="px" /></td>
							</tr>
						<!--{else}-->
							<input type="hidden" name="buyername" value="" />
							<input type="hidden" name="buyercontact" value="" />
							<input type="hidden" name="buyerzip" value="" />
							<input type="hidden" name="buyerphone" value="" />
							<input type="hidden" name="buyermobile" value="" />
						<!--{/if}-->
						<tr>
							<th valign="top"><label for="buyermsg">{lang trade_seller_remark}</label></th>
							<td>
								<textarea id="buyermsg" name="buyermsg" rows="5" class="px"></textarea>
								<div class="xg2">{lang trade_seller_remark_comment}</div>
							</td>
						</tr>
						<tr>
							<td class="pns" colspan="2">
								<button class="formdialog" type="submit" id="tradesubmit" name="tradesubmit" value="true"><span>{lang trade_buy_confirm}</span></button>
								<!--{if !$_G['uid']}--><em class="xg2">{lang trade_guest_alarm}</em><!--{/if}-->
							</td>
						</tr>
					</table>
				</div>
			</div>
            <div class="grey_line"></div>
		</form>

		<script type="text/javascript">
		function calcsum() {
			<!--{if $trade[price] > 0}-->document.getElementById('caculate').innerHTML = (price * document.getElementById('tradepost').number.value + feevalue);<!--{/if}-->
			<!--{if $_G['setting']['creditstransextra'][5] != -1 && $trade[credit]}-->
				v = (credit * document.getElementById('tradepost').number.value + feevalue);
				if(v > currentcredit) {
					document.getElementById('crediterror').innerHTML = '{lang trade_buy_crediterror}';
					document.getElementById('tradesubmit').disabled = true;
				} else {
					document.getElementById('crediterror').innerHTML = '';
				}
				document.getElementById('caculatecredit').innerHTML = v;
			<!--{/if}-->
		}
		calcsum();
		</script>
	</div>


		<!--{if $usertrades}-->
        <div class="section3 cl">
            <div class="atit cl"><h2>$trade[seller]{$alang_qtsp}</h2></div>
            <div class="acon cl">
                <!--{loop $usertrades $usertrade}-->
                    <a href="forum.php?mod=viewthread&tid=$usertrade[tid]&do=tradeinfo&pid=$usertrade[pid]">
                     <!--{if $usertrade['aid']}-->
                        <div class="leftimg"><img src="{echo getforumimg($usertrade[aid])}" alt="$usertrade[subject]" /></div>
                     <!--{else}-->
                        <div class="noimg"><i class="iconfont icon-pic"></i></div>
                     <!--{/if}-->
                     <div class="rightinfo cl">
                        <p class="tit"><!--{if $usertrade['displayorder'] > 0}--><em>HOT</em><!--{/if}-->$usertrade[subject]</p>
                        <!--{if $usertrade[price] > 0}-->
                        <p class="price">
                            <em class="xi1">{$alang_tradeunit}$usertrade[price]</em>
                            <!--{if $_G['setting']['creditstransextra'][5] != -1 && $usertrade[credit]}-->
                            <!--{if $usertrade[price] > 0}-->{lang trade_additional} <!--{/if}--><em>$usertrade[credit]</em>&nbsp;{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]}
                        <!--{/if}-->
                        </p>
                        <!--{/if}-->
                        
                     </div>
                    </a>
                <!--{/loop}-->
            </div>
		</div>
		<!--{/if}-->

</div>
<!--{template common/footer}-->
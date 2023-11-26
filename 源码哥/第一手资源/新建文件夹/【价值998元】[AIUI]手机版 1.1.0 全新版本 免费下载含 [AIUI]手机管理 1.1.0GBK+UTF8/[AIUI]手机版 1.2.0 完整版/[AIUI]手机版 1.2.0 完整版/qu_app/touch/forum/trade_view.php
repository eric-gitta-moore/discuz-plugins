<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<!-- header start -->
<header class="header">
    <div class="nav">
        <a href="#" class="z back"><i class="iconfont icon-back"></i></a>

			<span class="name">
				{lang trade_order}
			</span>

    </div>
</header>
<!--{template common/top_fix}-->
<!-- header end -->

<div class="ainuo_trade_view cl">
	<div class="cl">
		<form method="post" autocomplete="off" id="tradepost" name="tradepost" action="forum.php?mod=trade&orderid=$orderid">
			<!--{if !empty($_G['gp_modthreadkey'])}-->
				<input type="hidden" name="modthreadkey" value="$_G[gp_modthreadkey]" />
			<!--{/if}-->
			<!--{if !empty($_G['gp_tid'])}-->
				<input type="hidden" name="tid" value="$_G[gp_tid]" />
			<!--{/if}-->
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<div class="section1 cl">
				<div class="atit"><h2><!--{if !$tradelog[offline]}-->{lang trade_pay_alipay}<!--{else}-->{lang trade_pay_offline}<!--{/if}--></h2></div>
				<div class="cl">
					<table summary="{lang trade_order}" cellspacing="0" cellpadding="0" style="table-layout:fixed" width="100%">
						<tr>
							<th>{lang status}</th>
							<td style="color:#ff0000; font-size:14px;">$tradelog[statusview] ($tradelog[lastupdate])</td>
						</tr>
						<!--{if $tradelog[offline] && $offlinenext}-->
							<tr>
								<th><label for="password">{lang trade_password}</label></th>
								<td><input id="password" name="password" type="password" class="px" /></td>
							</tr>
							<tr>
								<th valign="top"><label for="message">{lang trade_message}</label></th>
								<td>
									<textarea id="buyermsg" id="message" name="message" rows="3" class="px"></textarea>
									<p class="d">$trade_message {lang trade_seller_remark_comment}</p>
								</td>
							</tr>
							<tr>
								<td class="pns" colspan="2">
									<!--{loop $offlinenext $nextid $nextbutton}-->
										<button class="pn" type="button" onclick="document.getElementById('tradepost').offlinestatus.value = '$nextid';document.getElementById('offlinesubmit').click();"><em>$nextbutton</em></button>
									<!--{/loop}-->
									<input type="hidden" name="offlinestatus" value="" />
									<input type="submit" id="offlinesubmit" name="offlinesubmit" style="display: none" />
								</td>
							</tr>
						<!--{/if}-->
						<!--{if trade_typestatus('successtrades', $tradelog[status]) || trade_typestatus('refundsuccess', $tradelog[status])}-->
							<tr>
								<!--{if $tradelog[ratestatus] == 3}-->
									<th>{lang eccredit_post_between}</th><td>&nbsp;</td>
								<!--{elseif ($_G['uid'] == $tradelog[buyerid] && $tradelog[ratestatus] == 1) || ($_G['uid'] == $tradelog[sellerid] && $tradelog[ratestatus] == 2)}-->
									<th>{lang eccredit_post_waiting}</th><td>&nbsp;</td>
								<!--{else}-->
									<!--{if ($_G['uid'] == $tradelog[buyerid] && $tradelog[ratestatus] == 2) || ($_G['uid'] == $tradelog[sellerid] && $tradelog[ratestatus] == 1)}-->
										<th>{lang eccredit_post_already}</th>
									<!--{else}-->
										<th>&nbsp;</th>
									<!--{/if}-->
									<td class="pns">
									<!--{if $_G['uid'] == $tradelog[buyerid]}-->
										<button class="pn" type="button" onclick="window.open('home.php?mod=spacecp&ac=eccredit&op=rate&orderid=$tradelog[orderid]&type=0', '', '')"><span>{lang eccredit1}</span></button>
									<!--{elseif $_G['uid'] == $tradelog[sellerid]}-->
										<button class="pn" type="button" onclick="window.open('home.php?mod=spacecp&ac=eccredit&op=rate&orderid=$tradelog[orderid]&type=1', '', '')"><span>{lang eccredit1}</span></button>
									<!--{/if}-->
									</td>
								<!--{/if}-->
								</td>
							</tr>
						<!--{elseif !$tradelog[offline]}-->
							<tr>
								<th>{lang trade_online_tradeurl}</th>
								<td class="pns">
									<!--{if $tradelog[status] == 0 && $tradelog[buyerid] == $_G['uid']}-->
										<!--{if $tradelog[tenpayaccount]}-->
											<button class="pn" type="button" name="" onclick="window.open('forum.php?mod=trade&orderid=$orderid&pay=yes&apitype=tenpay','','')"><span>{lang trade_online_tenpay}</span></button>
										<!--{/if}-->
									<!--{else}-->
										<!--{if $tradelog[paytype] == 1}-->
											<button class="pn" type="button" onclick="window.open('$loginurl', '', '')"><span>{lang trade_order_status}</span></button>
										<!--{/if}-->
										<!--{if $tradelog[paytype] == 2}-->
											<button class="pn" type="button" onclick="window.open('$loginurl', '', '')"><span>{lang tenpay_trade_order_status}</span></button>
										<!--{/if}-->
									<!--{/if}-->
								</td>
							</tr>
						<!--{/if}-->
					</table>
				</div>
			</div>
            <div class="grey_line"></div>
			<div class="section2 cl">
                <div class="atit"><h2>{lang trade_order}</h2></div>
				<div class="acon1 cl">
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
                    	<h2><a href="forum.php?mod=viewthread&do=tradeinfo&tid=$tradelog[tid]&pid=$tradelog[pid]">$tradelog[subject]</a></h2>
                        <p>
                                <!--{if $trade[price] > 0}-->
                                    <strong>{$alang_tradeunit}$trade[price]</strong>&nbsp;
                                <!--{/if}-->
                                <!--{if $_G['setting']['creditstransextra'][5] != -1 && $trade[credit]}-->
                                    {$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]}&nbsp;<strong>$trade[credit]</strong>&nbsp;{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}
                                <!--{/if}-->
                        </p>
                        <!--{if $tradelog[tradeno]}--><p>{lang trade_order_no}: <a href="$loginurl">$tradelog[tradeno]</a></p><!--{/if}-->
                    </div>
               </div>
               <div class="acon2 cl">
					<div class="cl">
						<dl>
						<!--{if $tradelog[status] == 0 && $tradelog[sellerid] == $_G['uid']}-->
							<dt style="clear:left"><label for="newprice">{lang trade_baseprice}</label></dt>
							<dd>
								<span><input type="text" id="newprice" name="newprice" value="$tradelog[baseprice]" class="px" style="width:100px" /></span> {lang payment_unit}&nbsp;&nbsp;
								<!--{if $_G['setting']['creditstransextra'][5] != -1 && $tradelog[credit]}-->
									{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]} <input type="text" id="newcredit" name="newcredit" value="$tradelog[basecredit]" class="px" style="width:100px" /> {$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}
								<!--{/if}-->
							</dd>
						<!--{/if}-->
							<dt style="clear:left"><label for="newnumber">{lang trade_nums}</label></dt>
							<dd><!--{if $tradelog[status] == 0 && $tradelog[buyerid] == $_G['uid']}--><span><input type="text" id="newnumber" name="newnumber" value="$tradelog[number]" class="px" style="width:100px" /></span><!--{else}-->$tradelog[number]<!--{/if}--></dd>
							<dt>{lang post_trade_transport}</dt>
							<dd>
								<!--{if $tradelog['transport'] == 0}-->{lang post_trade_transport_offline}<!--{/if}-->
								<!--{if $tradelog['transport'] == 1}-->{lang post_trade_transport_seller}<!--{/if}-->
								<!--{if $tradelog['transport'] == 2}-->{lang post_trade_transport_buyer}<!--{/if}-->
								<!--{if $tradelog['transport'] == 3}-->{lang post_trade_transport_virtual}<!--{/if}-->
								<!--{if $tradelog['transport'] == 4}-->{lang post_trade_transport_physical}<!--{/if}-->
								<!--{if $tradelog['transport']}-->
									&nbsp;{lang trade_transportfee}
									<!--{if $tradelog[status] == 0 && $tradelog[sellerid] == $_G['uid']}--><span><input type="text" name="newfee" value="$tradelog['transportfee']" class="px" /></span>&nbsp;<!--{else}-->$tradelog[transportfee]&nbsp;<!--{/if}-->
									{lang payment_unit}
								<!--{/if}-->
							</dd>
						<!--{if $tradelog['transport'] != 3}-->
							<dt><label for="newbuyername">{lang trade_buyername}</label></dt>
							<dd><!--{if $tradelog[status] == 0 && $tradelog[buyerid] == $_G['uid']}--><span><input type="text" id="newbuyername" name="newbuyername" value="$tradelog[buyername]" maxlength="50" class="px" /></span><!--{else}-->$tradelog[buyername]<!--{/if}-->&nbsp;</dd>
							<dt><label for="newbuyercontact">{lang trade_buyercontact}</label></dt>
							<dd><!--{if $tradelog[status] == 0 && $tradelog[buyerid] == $_G['uid']}--><span><input type="text" id="newbuyercontact" name="newbuyercontact" value="$tradelog[buyercontact]" maxlength="100" class="px" /></span><!--{else}-->$tradelog[buyercontact]<!--{/if}-->&nbsp;</dd>
							<dt><label for="newbuyerzip">{lang trade_buyerzip}</label></dt>
							<dd><!--{if $tradelog[status] == 0 && $tradelog[buyerid] == $_G['uid']}--><span><input type="text" id="newbuyerzip" name="newbuyerzip" value="$tradelog[buyerzip]" maxlength="10" class="px" /></span><!--{else}-->$tradelog[buyerzip]<!--{/if}-->&nbsp;</dd>
							<dt><label for="newbuyerphone">{lang trade_buyerphone}</label></dt>
							<dd><!--{if $tradelog[status] == 0 && $tradelog[buyerid] == $_G['uid']}--><span><input type="text" id="newbuyerphone" name="newbuyerphone" value="$tradelog[buyerphone]" maxlength="20" class="px" /></span><!--{else}-->$tradelog[buyerphone]<!--{/if}-->&nbsp;</dd>
							<dt><label for="newbuyermobile">{lang trade_buyermobile}</label></dt>
							<dd><!--{if $tradelog[status] == 0 && $tradelog[buyerid] == $_G['uid']}--><span><input type="text" id="newbuyermobile" name="newbuyermobile" value="$tradelog[buyermobile]" maxlength="20" class="px" /></span><!--{else}-->$tradelog[buyermobile]<!--{/if}-->&nbsp;</dd>
						<!--{else}-->
							<input type="hidden" name="newbuyername" value="" />
							<input type="hidden" name="newbuyercontact" value="" />
							<input type="hidden" name="newbuyerzip" value="" />
							<input type="hidden" name="newbuyerphone" value="" />
							<input type="hidden" name="newbuyermobile" value="" />
						<!--{/if}-->
							<dt valign="top"><label for="newbuyermsg">{lang trade_seller_remark}</label></dt>
							<dd><!--{if $tradelog[status] == 0 && $tradelog[buyerid] == $_G['uid']}--><span><textarea id="newbuyermsg" name="newbuyermsg" rows="3" class="px">$tradelog[buyermsg]</textarea></span><!--{else}-->$tradelog[buyermsg]<!--{/if}-->&nbsp;</dd>
						<!--{if $tradelog[status] == 0 && ($_G['uid'] == $tradelog['sellerid'] || $_G['uid'] == $tradelog['buyerid'])}-->
							<dt>&nbsp;</dt>
							<dd class="pns">
								<button class="pn" type="submit" name="tradesubmit" value="true"><span>{lang trade_submit_order}</span></button>
							</dd>
						<!--{/if}-->
						</dl>
					</div>
				</div>
			</div>
		
		</form>
	</div>
	
</div>
<!--{template common/footer}-->
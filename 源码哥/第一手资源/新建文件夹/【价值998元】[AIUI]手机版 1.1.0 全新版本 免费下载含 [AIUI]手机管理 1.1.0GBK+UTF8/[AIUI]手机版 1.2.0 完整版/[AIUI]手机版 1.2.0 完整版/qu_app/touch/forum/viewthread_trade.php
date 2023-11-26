<?PHP exit('QQÈº£º550494646');?>
<!--{if count($trades) > 1 || ($_G['uid'] == $_G['forum_thread']['authorid'] || $_G['group']['allowedittrade'])}-->
	
		<!--{if !$_G['forum_thread']['is_archived'] && ($_G['uid'] == $_G['forum_thread']['authorid'] || $_G['group']['allowedittrade'])}-->
        <div class="ainuo_trdc xs1">
			<a href="forum.php?mod=misc&action=tradeorder&tid=$_G[tid]{if !empty($_GET['from'])}&from=$_GET['from']{/if}" onclick="showWindow('tradeorder', this.href)" class="y" style="margin-left:15px;">$alang_manage</a>
			<!--{if $_G['uid'] == $_G['forum_thread']['authorid']}-->
				<!--{if $_G['group']['allowposttrade'] & 0}-->
					<a href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&firstpid=$post[pid]&addtrade=yes{if !empty($_GET['from'])}&from=$_GET['from']{/if}" class="y">+{lang trade_add_post}</a>
				<!--{/if}-->
			<!--{/if}-->
        </div>
		<!--{/if}--><!--From www.m oq u8 .com -->
	
<!--{/if}-->
<!--{if $tradenum}-->
	<!--{if $trades}-->
		<div class="ainuo_txs1 cl">
			<!--{loop $trades $key $trade}-->
			<!--{if $tradepostlist[$trade[pid]]['invisible'] != 0}-->
			<!--{else}-->
				<div class="trdb">
                	<a href="forum.php?mod=viewthread&do=tradeinfo&tid=$_G[tid]&pid=$trade[pid]{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}">
					<div id="trade$trade[pid]" class="trdl cl">
						<div class="tt cl">
							<!--{if $trade['displayorder'] > 0}--><em class="ahot">{lang post_trade_sticklist}</em><!--{/if}-->
							<!--{if $trade['thumb']}-->
                            	<div class="tt_1 cl">
									<img src="$trade[thumb]" alt="$trade[subject]" />
                                </div>
							<!--{else}-->
                            	<div class="tt_0 cl">
									<i class="iconfont icon-pic"></i>
                                </div>
							<!--{/if}-->
                            <h2>$trade[subject]</h2>
                            
						</div>
						<div class="ta spi">
                        	<div class="aprice cl">
								<!--{if $trade[price] > 0}-->
									<strong>$alang_tradeunit{$trade[price]}</strong>&nbsp;&nbsp;&nbsp;
								<!--{/if}-->
								<!--{if $_G['setting']['creditstransextra'][5] != -1 && $trade[credit]}-->
									<!--{if $trade['price'] > 0}-->{lang trade_additional} <!--{/if}--><strong>$trade[credit]</strong>&nbsp;{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][5]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][5]][title]}
								<!--{/if}-->
								<p class="xg1">
									<!--{if $trade['costprice'] > 0}-->
										<del>$trade[costprice] {lang payment_unit}</del>
									<!--{/if}-->
									<!--{if $_G['setting']['creditstransextra'][5] != -1 && $trade['costcredit'] > 0}-->
										<del><!--{if $trade['costprice'] > 0}-->{lang trade_additional} <!--{/if}-->$trade[costcredit] {$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]}</del>
									<!--{/if}-->
								</p>
							</div>
							
							<dl class="cl">
								<dt>{lang trade_type_viewthread}:</dt>
								<dd>
									<!--{if $trade['quality'] == 1}-->{lang trade_new}<!--{/if}-->
									<!--{if $trade['quality'] == 2}-->{lang trade_old}<!--{/if}-->
									{lang trade_type_buy}
								</dd>
                            </dl>
                            <dl class="cl">
								<dt>{lang trade_remaindays}:</dt>
								<dd>
								<!--{if $trade[closed]}-->
									<em>{lang trade_timeout}</em>
								<!--{elseif $trade[expiration] > 0}-->
									{$trade[expiration]}{lang days}{$trade[expirationhour]}{lang trade_hour}
								<!--{elseif $trade[expiration] == -1}-->
									<em>{lang trade_timeout}</em>
								<!--{else}-->
									&nbsp;
								<!--{/if}-->
								</dd>
								<!--{hook/viewthread_trade_extra $key}-->
							</dl>
                            <div class="zksq cl">$alang_viewmore</div>
						</div>
					</div>
                    </a>
					<div id="tradeinfo$trade[pid]"></div>
				</div>
			<!--{/if}-->

			<!--{/loop}-->
		</div>
	<!--{/if}-->

<div id="postmessage_$post[pid]">$post[counterdesc]</div>
<!--{else}-->
	<div class="locked">{lang trade_nogoods}</div>
<!--{/if}-->

<div id="postmessage_$post[pid]">
	<!--{if !$post['message'] && (($_G['forum']['ismoderator'] && $_G['group']['alloweditpost'] && (!in_array($post['adminid'], array(1, 2, 3)) || $_G['adminid'] <= $post['adminid'])) || ($_G['forum']['alloweditpost'] && $_G['uid'] && ($post['authorid'] == $_G['uid'] && $_G['forum_thread']['closed'] == 0)))}-->
    <div class="ainuo_gtjs cl">
    	<a href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}&page=$page" class="z pn"><span>{lang post_add_aboutcounter}</span></a>
	</div>
    <!--{else}-->
    <div class="ainuo_gtjs cl">
    	$post[message]
    </div>
    <!--{/if}-->
</div>
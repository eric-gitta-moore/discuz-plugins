<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<header class="header">
    <div class="nav">
        <a href="#" class="z back"><i class="iconfont icon-back"></i></a>
        <span class="name">{lang memcp_credits_log}</span>
    </div>
</header>
<div class="ainuo_usertb cl">
    <ul class="tb ajfjl cl">
        <li{if $_GET[suboperation] != 'creditrulelog'} class="a"{/if}><a href="home.php?mod=spacecp&ac=credit&op=log" hidefocus="true">{lang credit_log}</a></li>
		<li{if $_GET[suboperation] == 'creditrulelog'} class="a"{/if}><a href="home.php?mod=spacecp&ac=credit&op=log&suboperation=creditrulelog" hidefocus="true">{lang credit_log_sys}</a></li>
    </ul>
</div>
<div class="grey_line cl"></div>
<div class="ainuo_ujifen cl" id="ainuo_ujifen">

			<!--{if $_GET[suboperation] != 'creditrulelog'}-->
			<script type="text/javascript" src="{$_G[setting][jspath]}calendar.js?{VERHASH}"></script>
            {if $loglist}
            <div class="info_main cl">
                <div class="ainfo cl">
                <form method="post" action="home.php?mod=spacecp&ac=credit&op=log">
                    <table summary="{lang memcp_credits_log_payment}" cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <th width="90">{lang operation}</th>
                            <th width="80">{lang credit_change}</th>
                            <th>{lang detail}</th>
                            <th width="110">{lang changedateline}</th>
                        </tr>
                        {eval $linekey = 0;}
                        <!--{loop $loglist $value}-->
                        {eval $linekey++}
                        <!--{eval $value = makecreditlog($value, $otherinfo);}-->
                        <tr{if $linekey % 2 == 0} class="alt"{/if}>
                            <td><!--{if $value['operation']}--><a href="home.php?mod=spacecp&ac=credit&op=log&optype=$value['operation']">$value['optype']</a><!--{else}-->$value['title']<!--{/if}--></td>
                            <td>$value['credit']</td>
                            <td><!--{if $value['operation']}-->$value['opinfo']<!--{else}-->$value['text']<!--{/if}--></td>
                            <td style="font-size:12px;">$value['dateline']</td>
                        </tr>
                        <!--{/loop}-->
                    </table>
                    <input type="hidden" name="op" value="log" />
                    <input type="hidden" name="ac" value="credit" />
                    <input type="hidden" name="mod" value="spacecp" />
                </form>
                </div>
            </div>
            {else}
            <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>$alang_nodata</p></div>
            {/if}
			<!--{elseif $_GET[suboperation] == 'creditrulelog'}-->
            {if $list}
            <div class="info_main cl">
                <div class="ainfo cl">
				<table summary="{lang get_credit_histroy}" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<th class="xw1" width="90">{lang action_name}</th>
						<th class="xw1" width="60">{lang total_time}</th>
						<th class="xw1" width="60">{lang cycles_num}</th>
						<!--{loop $_G['setting']['extcredits'] $key $value}-->
						<th class="xw1">$value[title]</th>
						<!--{/loop}-->
						<th class="xw1" width="110">{lang last_award_time}</th>
					</tr>
					<!--{eval $i = 0;}-->
					<!--{loop $list $key $log}-->
					<!--{eval $i++;}-->
					<tr{if $i % 2 == 0} class="alt"{/if}>
						<td><a href="home.php?mod=spacecp&ac=credit&op=rule&rid=$log[rid]">$log[rulename]</a></td>
						<td>$log[total]</td>
						<td>$log[cyclenum]</td>
						<!--{loop $_G['setting']['extcredits'] $key $value}-->
						<!--{eval $creditkey = 'extcredits'.$key;}-->
						<td>$log[$creditkey]</td>
						<!--{/loop}-->
						<td style="font-size:12px;"><!--{date($log[dateline], 'Y-m-d H:i')}--></td>
					</tr>
					<!--{/loop}-->
				</table>
				</div>
			</div>
			{else}
            <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>$alang_nodata</p></div>
            {/if}
			<!--{/if}-->
			<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
			<!--{hook/spacecp_credit_bottom}-->
		</div>
	</div>
</div>
</div>
<script>
	function modifyTarget(){
		var aN = document.getElementById("ainuo_ujifen").getElementsByTagName("a");
		for(var i =0; i < aN.length; i++){
		aN[i].target ="_self";
		}
	}
	modifyTarget();
</script>
<!--{template common/footer}-->
<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<style>
html,body{ background:#fff;}
</style>
<!-- header start -->
    <div class="header">
        <div class="nav">
            <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
			<span class="name">{lang rate_view}</span>
        </div>
    </div>
<!-- header end -->

<div class="aview_morepf cl">
	<div class="cl">
		<table width="100%" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
                	<td class="td1">{lang username}</td>
					<td class="td2">{lang credits}</td>
					<td class="td3">{lang time}</td>
					<td class="td4">{lang reason}</td>
				</tr>
			</thead>
			<!--{loop $loglist $log}-->
			<tr>
            	<td class="td1"><a href="home.php?mod=space&uid=$log[uid]">$log[username]</a></td>
				<td class="td2">{$_G['setting']['extcredits'][$log[extcredits]][title]} $log[score] {$_G['setting']['extcredits'][$log[extcredits]][unit]}</td>
				<td class="td3">$log[dateline]</td>
				<td class="td4">$log[reason]</td>
			</tr>
			<!--{/loop}-->
		</table>
	</div>
</div>
<div class="apf_sum cl">
	{lang total}:
	<!--{loop $logcount $id $count}-->
	&nbsp;{$_G['setting']['extcredits'][$id][title]} <!--{if $count>0}-->+<!--{/if}-->$count {$_G['setting']['extcredits'][$id][unit]} &nbsp;
	<!--{/loop}-->
</div>

<!--{template common/footer}-->
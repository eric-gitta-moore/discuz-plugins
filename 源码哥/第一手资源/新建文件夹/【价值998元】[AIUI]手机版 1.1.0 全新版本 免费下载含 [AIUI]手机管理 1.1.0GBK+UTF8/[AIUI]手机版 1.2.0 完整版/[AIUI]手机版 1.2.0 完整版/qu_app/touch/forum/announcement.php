<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->


<!-- header start -->
<header class="header">
    <div class="nav">
        <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
			<span class="name">
				{lang announcement}
			</span>
    </div>
</header>
<!-- header end -->
<!--{template common/top_fix}-->

<div class="cl">
	<div class="cl">
		<div class="ainuo_anncinner cl">
			<div id="annofilter"></div>
			<!--{loop $announcelist $ann}-->
				<div id="announce$ann[id]_c" class="umh{if $messageid != $ann[id]} umn{/if}">
					<h3>$ann[subject]<em>($ann[starttime])</em></h3>
					
				</div>
				<div id="announce$ann[id]" class="um">
					$ann[message]
				</div>
			<!--{/loop}-->
		</div>
	</div>
	
</div>

<!--{template common/footer}-->
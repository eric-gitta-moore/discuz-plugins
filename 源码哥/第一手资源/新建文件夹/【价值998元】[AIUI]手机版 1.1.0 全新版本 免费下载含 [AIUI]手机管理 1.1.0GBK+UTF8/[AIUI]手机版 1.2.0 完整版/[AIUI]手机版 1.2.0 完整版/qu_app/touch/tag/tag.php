<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!-- header start -->
    <div class="header">
        <div class="nav">
            <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
			<span class="name">{lang tag}</span>
        </div>
    </div>
<!-- header end -->
<!--{template common/top_fix}-->
<!--{if $type != 'countitem'}-->
<div class="ainuo_tagitem cl">
	<div class="cl">
		<div class="cl">
        	<div class="tag_search cl">
			<form method="post" action="misc.php?mod=tag">
				<input type="text" name="name" class="px" placeholder="{lang enter_content}" />
				<button type="submit"><i class="iconfont icon-search"></i></button>
			</form>
            </div>
            <div class="grey_line cl"></div>
			<div class="taglist cl">
            	
				<!--{if $tagarray}--><!--From www.moq u8 .com -->
					<!--{loop $tagarray $tag}-->
                    {eval $tagnum = ($tag[tagid])%5}
						<a href="misc.php?mod=tag&id=$tag[tagid]" title="$tag[tagname]" class="bg_{$tagnum}">$tag[tagname]</a>
					<!--{/loop}-->
				<!--{else}-->
                    <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_tag}</p></div>
				<!--{/if}-->
			</div>
		</div>
	</div>
</div>
<!--{else}-->
$num
<!--{/if}-->
<!--{template common/footer}-->
<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!-- header start -->
    <div class="header">
        <div class="nav">
            <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
			<span class="name">$curtype[name]</span>
            <a href="forum.php?mod=group&action=create" class="y"><i class="iconfont icon-plus"></i></a>
        </div>
    </div>
<!-- header end -->
<div class="ainuo_group">
	<div class="group_index">
    	<!--{if $list}-->
              <dl style="padding-top:1px;">
                  <dd><!--From www.moq u8 .com -->
                      <!--{loop $list $fid $val}-->
						<a href="forum.php?mod=forumdisplay&action=list&fid=$fid">
                        <img width="48" height="48" src="$val[icon]" alt="$val[name]" />
                        <h2>$val[name]</h2>
                        <p>{lang group_member}:$val[membernum]<span>|</span>{lang threads}:$val[threads]</p>
                        </a>
                      <!--{/loop}-->
                  </dd>
				</dl>
        <!--{/if}-->
    </div>
	
</div>


<!--{template common/footer}-->
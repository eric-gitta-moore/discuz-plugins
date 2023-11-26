<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!--{subtemplate common/bgcolor}-->
<!-- header start -->
    <div class="header">
        <div class="nav">
            <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
			<span id="returnmessage5" class="name"><!--{if $isactivitymaster}-->{lang activity_applylist_manage}<!--{else}-->{lang activity_applylist}<!--{/if}--></span>
        </div>
    </div>
<!-- header end -->
<div class="ainuo_applylist cl">
    <form id="applylistform" method="post" autocomplete="off" action="forum.php?mod=misc&action=activityapplylist&tid=$_G[tid]&applylistsubmit=yes&infloat=yes{if !empty($_GET['from'])}&from=$_GET['from']{/if}"{if !empty($_GET['infloat']) && empty($_GET['from'])} onsubmit="ajaxpost('applylistform', 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;"{/if}>
        <div class="af_c cl">
            
            <input type="hidden" name="formhash" value="{FORMHASH}" />
            <input type="hidden" name="operation" value="" />
            <!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="$_GET['handlekey']" /><!--{/if}-->
            <div class="cl">
            {if $applylist}
                <ul>
                    <!--{loop $applylist $apply}-->
                        <li>
                            <!--{if $isactivitymaster}-->
                                <!--{if $apply[uid] != $_G[uid]}-->
                                    <input type="checkbox" name="applyidarray[]" class="pc" value="$apply[applyid]" />
                                <!--{else}-->
                                    <input type="checkbox" class="pc" disabled="disabled" />
                                <!--{/if}-->
                            <!--{/if}-->
                                <a href="home.php?mod=space&uid=$apply[uid]" class="aathor"><img src="<!--{avatar($apply[uid], middle, true)}-->" />$apply[username]</a>
                               
                            <span class="atime">$apply[dateline]</span>
                            <span class="shenhe">
                            <!--{if $isactivitymaster}-->
                                <!--{if $apply[verified] == 1}-->
                                    <img src="{IMGDIR}/data_valid.gif" class="vm" alt="{lang activity_allow_join}" /> {lang activity_allow_join}
                                <!--{elseif $apply[verified] == 2}-->
                                    {lang activity_do_replenish}
                                <!--{else}-->
                                    {lang activity_cant_audit}
                                <!--{/if}-->
                            <!--{/if}-->
                            </span>
                        </li>
                    <!--{/loop}-->
                </ul>
            {else}
            <div class="cl" style="padding:40px 0; text-align:center; color:#999; border-bottom:1px solid #eee;">$alang_nobody</div>
            {/if}
            </div>
        </div>
        <!--{if $isactivitymaster}-->
            <div class="qxuan cl">
                <label{if !empty($_GET['infloat'])} class="z"{/if}><input class="pc" type="checkbox" name="chkall" onclick="checkall(this.form, 'applyid')" />{lang checkall} </label>
                <label>{lang activity_ps}: <input name="reason" class="px vm" size="25" /> </label>
            </div>
            <div class="pizhun cl">
                <button class="" type="submit" value="true" name="applylistsubmit"><span>{lang confirm}</span></button>
                <button class="" type="submit" value="true" name="applylistsubmit" onclick="document.getElementById('applylistform').operation.value='replenish';"><span>{lang to_improve}</span></button>
                <button class="" type="submit" value="true" name="applylistsubmit" onclick="document.getElementById('applylistform').operation.value='notification';"><span>{lang send_notification}</span></button>
                <button class="" type="submit" value="true" name="applylistsubmit" onclick="document.getElementById('applylistform').operation.value='delete';"><span>{lang activity_refuse}</span></button>
            </div>
        <!--{/if}-->
    </form>
</div>
<!--{if !empty($_GET['infloat'])}-->
<script type="text/javascript" reload="1">
function succeedhandle_$_GET['handlekey'](locationhref) {
	ajaxget('forum.php?mod=viewthread&tid=$_G[tid]&viewpid=$_GET[pid]', 'post_$_GET[pid]');
	hideWindow('$_GET['handlekey']');
}
</script>
<!--{/if}-->

<!--{template common/footer}-->
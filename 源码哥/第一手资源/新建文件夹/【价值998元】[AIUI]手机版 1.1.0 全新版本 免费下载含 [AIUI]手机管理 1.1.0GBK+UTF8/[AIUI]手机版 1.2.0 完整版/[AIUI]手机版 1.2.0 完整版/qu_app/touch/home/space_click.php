<?PHP exit('QQÈº£º550494646');?>
<table cellpadding="0" cellspacing="0" class="atd">
	<tr>
	<!--{eval $clicknum = 0;}-->
	<!--{loop $clicks $key $value}-->
	<!--{eval $clicknum = $clicknum + $value['clicknum'];}-->
	<!--{eval $value['height'] = $maxclicknum?intval($value['clicknum']*50/$maxclicknum):0;}-->
		<td>
			<a class="ainuo_nologin ainuodialog" ainuoto="home.php?mod=spacecp&ac=click&op=add&clickid=$key&idtype=$idtype&id=$id&hash=$hash&handlekey=clickhandle" id="click_{$idtype}_{$id}_{$key}">
				<!--{if $value[clicknum]}-->
				<div class="atdc">
					<div class="ac{$value[classid]}" style="height:{$value[height]}px;">
						<em>{$value[clicknum]}</em>
					</div>
				</div>
				<!--{/if}-->
				<img src="{STATICURL}image/click/$value[icon]" alt="" /><br />$value[name]
			</a>
		</td>
	<!--{/loop}-->
	</tr>
</table>


<!--{if $clickuserlist}-->
<div class="ainuo_click_bt cl">
    <h2 class="cl">
        {lang position_friend} (<a href="javascript:;" onclick="show_click('$idtype', '$id', '$key')">$clicknum {lang person}</a>)
        <!--{if $_G[magic][anonymous]}-->
        <img src="{STATICURL}image/magic/anonymous.small.gif" alt="anonymous" class="vm" />
        <a id="a_magic_anonymous" href="home.php?mod=magic&mid=anonymous&idtype=$idtype&id=$id" onclick="ajaxmenu(event,this.id, 1)" class="xg1">{$_G[magic][anonymous]}</a>
        <!--{/if}-->
    </h2>
    <div id="trace_div" class="cl">
        <ul id="trace_ul" class="ml mls cl">
        <!--{loop $clickuserlist $value}-->
            <li>
                <!--{if $value[username]}-->
                <div class="avt"><a href="home.php?mod=space&uid=$value[uid]" target="_blank" title="$value[clickname]"><!--{avatar($value[uid], 'small')}--></a></div>
                <p><a href="home.php?mod=space&uid=$value[uid]"  title="$value[username]" target="_blank">$value[username]</a></p>
                <!--{else}-->
                <div class="avt"><img src="{STATICURL}image/magic/hidden.gif" alt="$value[clickname]" /></div>
                <p>{lang anonymity}</p>
                <!--{/if}-->
            </li>
        <!--{/loop}-->
        </ul>
    </div>
</div>
<!--{/if}-->

<!--{if $click_multi}--><div class="pgs cl mtm">$click_multi</div><!--{/if}-->

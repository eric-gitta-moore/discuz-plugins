<?PHP exit('QQÈº£º550494646');?>
{eval
	$_G[home_tpl_spacemenus][] = "<a href=\"home.php?mod=space&uid=$space[uid]&do=blog&view=me\">{lang they_blog}</a>";
	$friendsname = array(1 => '{lang friendname_1}',2 => '{lang friendname_2}',3 => '{lang friendname_3}',4 => '{lang friendname_4}');
}


<!--{template common/header}-->
<!--{if $space[uid] == $_G[uid]}-->
<header class="header">
    <div class="nav">
        <!--{if $space[self]}-->
            <a href="home.php?mod=spacecp&ac=blog" class="y"><i class="iconfont icon-write"></i></a>
        <!--{/if}-->
        
        <a href="#" class="z back"><i class="iconfont icon-back"></i></a>
        <span class="name">{lang blog}</span>
    </div>
</header>
	<div class="ainuo_urizhi cl">
        <div class="ainuo_usertb cl">
            <ul class="tb arizhi cl">
            	<li$actives[me]><a href="home.php?mod=space&do=blog&view=me">{lang my_blog}</a></li>
                <li$actives[we]><a href="home.php?mod=space&do=blog&view=we">{lang friend_blog}</a></li>
                <li$actives[all]><a href="home.php?mod=space&do=blog&view=all">{lang view_all}</a></li>
            </ul>
        </div>
		<!--{if $_GET[view] == 'me'}-->
        <div class="grey_line cl"></div>
        <!--{/if}-->
        <!--{if $_GET[view] == 'all'}-->
        <div class="ainuo_ersub cl">
            <a href="home.php?mod=space&do=blog&view=all" {if !$_GET[catid]}$orderactives[dateline]{/if}>{lang newest_blog}</a>
            <a href="home.php?mod=space&do=blog&view=all&order=hot" $orderactives[hot]>{lang recommend_blog}</a>
            <!--{if $category}-->
                <!--{loop $category $value}-->
                    <a href="home.php?mod=space&do=blog&catid=$value[catid]&view=all&order=$_GET[order]"{if $_GET[catid]==$value[catid]} class="a"{/if}>$value[catname]</a>
                <!--{/loop}-->
            <!--{/if}-->
        </div>
        <!--{/if}-->
        
        <!--{if $_GET[view] == 'me' && $classarr}-->
        <div class="ainuo_ersub cl">
            <!--{loop $classarr $classid $classname}-->
                <a href="home.php?mod=space&uid=$space[uid]&do=blog&classid=$classid&view=me" id="classid$classid" {if $_GET[classid]==$classid} class="a"{/if}>$classname</a>
                
            <!--{/loop}-->
        </div>
        <!--{/if}-->
        <!--{if $userlist}-->
        <div class="ainuo_ersub cl">
            {lang filter_by_friend}
            <select name="fuidsel" onchange="fuidgoto(this.value);" class="ps">
                <option value="">{lang all_friends}</option>
                <!--{loop $userlist $value}-->
                <option value="$value[fuid]"{$fuid_actives[$value[fuid]]}>$value[fusername]</option>
                <!--{/loop}-->
            </select>
        </div>
        <!--{/if}-->
<!--{else}-->
<!--{subtemplate common/usertop}-->
<!--{subtemplate common/usernav}-->
<div class="ainuo_urizhi cl">
<!--{/if}--> 

       
        
        <div class="cl">
        	<div class="cl">
            <div class="cl">



			<!--{if $searchkey}-->
				<p class="dashedtip">{lang follow_search_blog} <span style="color: red; font-weight: 700;">$searchkey</span> {lang doing_record_list}</p>
			<!--{/if}-->

		<!--{if $count}-->
			<div class="abloglist cl">
			<!--{loop $list $k $value}-->
				<li>
                	
					<div class="avt cl"><a href="home.php?mod=space&uid=$value[uid]"><!--{avatar($value[uid],middle)}--></a></div>
					<div class="ainfo cl">
                    	<a href="home.php?mod=space&uid=$value[uid]&do=blog&id=$value[blogid]">
                            <div class="acon1 cl">
                                <!--{eval $stickflag = isset($value['stickflag']) ? 0 : 1;}-->
                                <!--{if !$stickflag}--><span class="xi1">{lang stick}</span> &middot;<!--{/if}-->
                                <!--{if $value[status] == 1}--> <span class="xi1">({lang pending})</span><!--{/if}-->
                                <span class="atit" {if $value[magiccolor]} style="color: {$_G[colorarray][$value[magiccolor]]}"{/if}>$value[subject]</span>
                            </div>
                            <div class="acon2 cl">
                                <!--{if $value['friend']}-->
                                <span class="y"><a href="$theurl&friend=$value[friend]" class="xg1">{$friendsname[$value[friend]]}</a></span>
                                <!--{/if}-->
                                {$value[username]} / $value[dateline]</span>
                            </div>
                            <div class="acon3 cl" id="blog_article_$value[blogid]">
                                {echo cutstr($value[message],140)}
                            </div>
                            <!--{if $value[pic]}-->
                                <div class="acon4"><img src="$value[pic]" alt="$value[subject]" /></div>
                            <!--{/if}-->
                        </a>
                        <div class="acon5 cl">
                            <!--{if $classarr[$value[classid]]}--><a href="home.php?mod=space&uid=$value[uid]&do=blog&classid=$value[classid]&view=me">{$classarr[$value[classid]]}</a><span class="pipe">|</span><!--{/if}-->
                            <!--{if $value[viewnum]}--><a href="home.php?mod=space&uid=$value[uid]&do=blog&id=$value[blogid]">$value[viewnum] {lang blog_read}</a><span class="pipe">|</span><!--{/if}-->
                            <a href="home.php?mod=space&uid=$value[uid]&do=blog&id=$value[blogid]#comment"><span id="replynum_$value[blogid]">$value[replynum] </span>$alang_reply</a>
                            <!--{hook/space_blog_list_status $k}-->
                            <!--{if $_GET['view']=='me' && $space['self']}-->
                                <span class="pipe">|</span><a href="home.php?mod=spacecp&ac=blog&blogid=$value[blogid]&op=edit">{lang edit}</a><span class="pipe">|</span>
                                <a ainuoto="home.php?mod=spacecp&ac=blog&blogid=$value[blogid]&op=delete&handlekey=delbloghk_{$value[blogid]}" id="blog_delete_$value[blogid]" class="ainuodialog">{lang delete}</a>
                                <!--{if empty($value['status'])}-->
                                <span class="pipe">|</span>
                                <a ainuoto="home.php?mod=spacecp&ac=blog&blogid=$value[blogid]&op=stick&stickflag=$stickflag&handlekey=stickbloghk_{$value[blogid]}" id="blog_stick_$value[blogid]" class="ainuodialog"><!--{if $stickflag}-->{lang stick}<!--{else}-->{lang cancel_stick}<!--{/if}--></a>
                                <!--{/if}-->
                            <!--{/if}-->
                            <!--{if $value['hot']}--><span class="hot">{lang hot} <em>$value[hot]</em> </span><!--{/if}-->
                            <!--{if helper_access::check_module('share')}-->
                            <a ainuoto="home.php?mod=spacecp&ac=share&type=blog&id=$value[blogid]&handlekey=lsbloghk_{$value[blogid]}" id="a_share_$value[blogid]" class="ainuodialog">{lang share}</a>
                            <!--{/if}-->
                        </div>
                    </div>
                    
				</li>
			<!--{/loop}-->
			<!--{if $pricount}-->
				<p class="mtm">{lang hide_blog}</p>
			<!--{/if}-->
			</div>
			<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
		<!--{else}-->
            <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_related_blog}</p></div>
		<!--{/if}-->
		
		</div>
        </div>
		</div>
	</div>



<script type="text/javascript">
	function fuidgoto(fuid) {
		var parameter = fuid != '' ? '&fuid='+fuid : '';
		window.location.href = 'home.php?mod=space&do=blog&view=we'+parameter;
	}
</script>
<!--{subtemplate common/userbottom}-->
<!--{template common/footer}-->
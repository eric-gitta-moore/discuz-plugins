<?PHP exit('QQÈº£º550494646');?>
<!--{eval $friendsname = array(1 => '{lang friendname_1}',2 => '{lang friendname_2}',3 => '{lang friendname_3}',4 => '{lang friendname_4}');}-->
<!--{template common/header}-->
<!--{if $space[uid] == $_G[uid]}-->
	<header class="header">
        <div class="nav">
            <!--{if $space[self] && helper_access::check_module('album')}-->
                <a href="home.php?mod=spacecp&ac=upload" class="y"><i class="iconfont icon-cameraadd"></i></a>
            <!--{/if}-->
            <a href="#" class="z back"><i class="iconfont icon-back"></i></a>
            <span class="name">{lang album}</span>
        </div>
    </header>
	<div class="ainuo_ualbum cl">
        <div class="ainuo_usertb cl">
            <ul class="tb arizhi cl">
                <li$actives[me]><a href="home.php?mod=space&do=album&view=me">{lang my_album}</a></li>
                <li$actives[we]><a href="home.php?mod=space&do=album&view=we">{lang friend_album}</a></li>
                <li$actives[all]><a href="home.php?mod=space&do=album&view=all">{lang view_all}</a></li>
                
            </ul>
        </div>
        <!--{if $_GET[view] == 'all'}-->
        <div class="ainuo_ersub cl">
            <a href="home.php?mod=space&do=album&view=all" {if !$_GET[catid]}$orderactives[dateline]{/if}>{lang newest_update_album}</a>
            <a href="home.php?mod=space&do=album&view=all&order=hot" $orderactives[hot]>{lang hot_pic_recommend}</a>
            <!--{if $_G['setting']['albumcategorystat'] && $category}-->
                <!--{loop $category $value}-->
                    <a href="home.php?mod=space&amp;do=album&amp;catid={$value[catid]}&amp;view=all"{if $_GET[catid]==$value[catid]} class="a"{/if}>$value[catname]</a>
                <!--{/loop}-->
            <!--{/if}-->
        </div>
        <!--{/if}-->
        <!--{if ($_GET['view'] == 'we') && $userlist}-->
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
        <!--{if $_GET['view'] == 'me'}-->
        <div class="grey_line cl"></div>
        <!--{/if}-->
<!--{else}-->
<!--{subtemplate common/usertop}-->
<!--{subtemplate common/usernav}-->
<div class="ainuo_ualbum cl">

<!--{/if}-->   


		<div class="cl">

		<!--{if $space[self] && $_GET['view']=='me'}-->
			<div class="dashedtip cl">{lang explain_album}</div>
		<!--{/if}-->
		<div class="cl">
					<!--{if $picmode}-->

						<!--{if $count}-->
						<ul class="ml mlp cl">
							<!--{loop $list $key $value}-->
							<li class="d">
								<div class="c">
									<a href="home.php?mod=space&uid=$value[uid]&do=album&picid=$value[picid]"><!--{if $value[pic]}--><img src="$value[pic]" alt="" /><!--{/if}--></a>
								</div>
								<p class="ptm"><a href="home.php?mod=space&uid=$value[uid]&do=album&id=$value[albumid]" class="xi2">$value[albumname]</a></p>
								<span><a href="home.php?mod=space&uid=$value[uid]">$value[username]</a></span>
							</li>
							<!--{/loop}-->
						</ul>
						<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
						<!--{else}-->
                        <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_album}</p></div>
						<!--{/if}-->
		
					<!--{else}-->
		
						<!--{if $count}-->
						<ul class="albumlist cl">
							<!--{loop $list $key $value}-->
							<!--{eval $pwdkey = 'view_pwd_album_'.$value['albumid'];}-->
							<li>
                            	<div class="kuangjia cl">
                                    <a href="home.php?mod=space&uid=$value[uid]&do=album&id=$value[albumid]">
                                        
                                        <!--{if $value[pic]}-->
                                        <div class="apic cl ainuolazyloadbg" data-original="$value[pic]" style="background-size:cover;">
                                        	<img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27250%27%20height%3D%27250%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" />
                                        </div>
                                        <!--{else}-->
                                        <div class="apic cl ainuolazyloadbg" data-original="template/qu_app/touch/style/css/images/nopic.png" style="background-size:cover;">
                                        	<img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27250%27%20height%3D%27250%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" />
                                           
                                        </div>
                                        <!--{/if}-->
                                        <em><i class="iconfont icon-pic"></i><!--{if $value[picnum]}-->$value[picnum]<!--{else}-->0<!--{/if}--></em>
                                        <p><!--{if $value[albumname]}-->$value[albumname]<!--{else}-->{lang default_album}<!--{/if}--></p>
                                    </a>
                                </div>
							</li>
							<!--{/loop}-->
							<!--{if $space[self] && $_GET['view']=='me'}-->
                            <li>
                            	<div class="kuangjia cl">
                                    <a href="home.php?mod=space&uid=$value[uid]&do=album&id=-1">
                                        <div class="apic cl ainuolazyloadbg" data-original="template/qu_app/touch/style/css/images/nopic.png" style="background-size:cover;">
                                        	<img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27250%27%20height%3D%27250%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" />
                                           
                                        </div>
                                        <p>{lang default_album}</p>
                                    </a>
                                </div>
							</li>
							<!--{/if}-->
						</ul>
						<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
						<!--{else}-->
							<!--{if $space[self] && $_GET['view']=='me'}-->
								<ul class="albumlist cl">
                                    <li>
                                        <div class="kuangjia cl">
                                            <a href="home.php?mod=space&uid=$value[uid]&do=album&id=-1">
                                                <div class="apic cl ainuolazyloadbg" data-original="template/qu_app/touch/style/css/images/nopic.png" style="background-size:cover;">
                                        	<img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27250%27%20height%3D%27250%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" />
                                           
                                        </div>
                                                <p>{lang default_album}</p>
                                            </a>
                                        </div>
                                    </li>
								</ul>
							<!--{else}-->
                                <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_album}</p></div>
							<!--{/if}-->
						<!--{/if}-->
		
					<!--{/if}-->
					</div>
		
		</div>
	</div>


<!--{subtemplate common/userbottom}-->

<script type="text/javascript">
function fuidgoto(fuid) {
	var parameter = fuid != '' ? '&fuid='+fuid : '';
	window.location.href = 'home.php?mod=space&do=album&view=we'+parameter;
}
</script>

<!--{template common/footer}-->
<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!--{if $_G['setting']['mobile']['mobilehotthread'] && $_GET['forumlist'] != 1}-->
	<!--{eval dheader('Location:forum.php?mod=guide&view=hot');exit;}-->
<!--{/if}-->
<!--{hook/index_quappdiy}-->

<style id="diy_style" type="text/css"></style>

<style>
.forum-plate-bar{position:fixed;top:44px;right:0;bottom:0;left:0;-webkit-overflow-scrolling:touch;right:auto;width:5rem;font-size:.6rem;background-color:#f8f8f8; border-right:1px solid #eee;-webkit-transition:-webkit-transform 300ms;transition:-webkit-transform 300ms;transition:transform 300ms;transition:transform 300ms, -webkit-transform 300ms;-webkit-transform:translate(-100%, 0);transform:translate(-100%, 0)}
.forum-plate-bar .item{position:relative;text-align:center;color:#999;padding:0; margin:0;}
.forum-plate-bar .item a{ display:block;padding:14px 0;border-left:2px solid #f8f8f8; font-size:14px;border-bottom:1px solid #eee;margin-right:-1px;}
.forum-plate-bar .item a.active{color: #f23030;border-left:2px solid #f23030; background:#fff; }
.forum-plate-bar li:first-child a.active{}
.forum-plate-bar .badge{position:absolute;top:50%;right:.1rem;z-index:100;height:.8rem;margin-top:-.4rem;min-width:.8rem;padding:0 .2rem;font-size:.6rem;line-height:.8rem;color:white;vertical-align:top;background:red;-webkit-border-radius:.5rem;border-radius:.5rem;margin-left:.1rem}
.bar-nav ~ .forum-plate-bar{top:2.2rem}
.bar-tab ~ .forum-plate-bar{bottom:2.5rem}
.forum-plate-bar.news-style .item{text-align:left;padding-left:.5rem}
.forum-plate-bar.news-style .item.active{color:#3d4145}
.forum-container{-webkit-transition:margin-left 300ms;transition:margin-left 300ms}
.page.open-plate .forum-plate-bar{-webkit-transform:translate(0, 0);transform:translate(0, 0)}
.page.open-plate .forum-container{margin-left:5rem;}
</style>

<div class="header forum-bar-nav">
    <div class="nav">
        <a href="javascript:;" class="button-nav">
            <em id="ainuo_topsqtb" class="iconfont icon-arrowleft"></em><em id="ainuo_topsq">$alang_shouqi</em>
        </a>
        <span class="name">$alang_forum</span>
        <a id="ainuo_toggle_menu" href="javascript:;" class="y"><i class="iconfont icon-menu1"></i></a>
    </div><!--Fr om w ww.moq u8 .com -->
</div>
<!--{template common/top_fix}-->




<div class="z-scroll forum-plate-bar">
	<ul id="forum-plate-bar">
		{eval $firsttab = 0;}
        <!--{loop $catlist $key $cat}-->
        {eval $firsttab++;}
		<li class="item"><a href="#tab{$cat['fid']}" class="tab-link {if $firsttab == 1}active{/if}" style="{if $cat[extra][namecolor]}color: {$cat[extra][namecolor]};{/if}">$cat[name]</a></li>
        <!--{/loop}-->
        <li class="item"><a href="#tab9999" class="tab-link">{$alang_my}$alang_gz</a></li>
   </ul>
</div>

<div class="infinite-scroll-bottom forum-container native-scroll">
<!--{hook/index_top_mobile}-->
<div class="tabs">
		<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
        <script>
		var swiper = new Swiper('.swiper-container', {
			pagination: '.swiper-pagination',
			paginationClickable: true,
			loop : true,
			autoplay : 3000,
		});
		</script>
{eval $firstforum = 0;}
<!--{loop $catlist $key $cat}-->
{eval $firstforum++;}
	<div class="sub_forum tab {if $firstforum == 1}active{/if}" id="tab{$cat[fid]}">
		<ul class="cl">
		<!--{loop $cat[forums] $forumid}-->
		<!--{eval $forum=$forumlist[$forumid];}-->
            <li>
                <div class="subicon">
                <!--{if $forum[icon]}-->
                    $forum[icon]
                <!--{else}-->
                    <a href="forum.php?mod=forumdisplay&fid={$forum['fid']}"><img src="template/qu_app/touch/style/css/0.png" alt="$forum[name]" /></a>
                <!--{/if}-->
                </div>
                <a href="forum.php?mod=forumdisplay&fid={$forum['fid']}" class="mui-right">
                    <i class="iconfont icon-right"></i>
                    <div class="mui-media-body">
                        <h2>{$forum[name]}</h2>
                        <p class="mui-ellipsis">
                        {if $forum[description]}
                        $forum[description]
                        {else}
                        {lang forum_threads}: <!--{echo dnumber($forum[threads])}-->&nbsp;&nbsp;{lang thread}: <!--{echo dnumber($forum[posts])}--><!--{if $forum[todayposts] > 0}-->&nbsp;&nbsp;<span class="tday">{lang index_today}: $forum[todayposts]</span><!--{/if}-->
                        {/if}

                        </p>
                    </div>
                </a>
            </li>
            <!--{/loop}-->
        </ul>
    </div>
    
<!--{/loop}-->
<div class="sub_forum tab" id="tab9999">
    	<!--{if $forum_favlist}-->
        	<ul>
        	<!--{loop $forum_favlist $key $favorite}-->
				<!--{if $favforumlist[$favorite[id]]}-->
					<!--{eval $forum=$favforumlist[$favorite[id]];}-->
					<!--{eval $forumurl = !empty($forum['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$forum['domain'].'.'.$_G['setting']['domain']['root']['forum'] : 'forum.php?mod=forumdisplay&fid='.$forum['fid'];}-->
                <!--{/if}-->         
				<li>
                    <div class="subicon">
                    <!--{if $forum[icon]}-->
                        $forum[icon]
                    <!--{else}-->
                        <a href="forum.php?mod=forumdisplay&fid={$forum['fid']}"><img src="template/qu_app/touch/style/css/0.png" /></a>
                    <!--{/if}-->
                    </div>
                    <a href="forum.php?mod=forumdisplay&fid={$forum['fid']}" class="mui-right">
                        <i class="iconfont icon-right"></i>
                        <div class="mui-media-body">
                            <h2>{$forum[name]}</h2>
                            <p class="mui-ellipsis">
                            {if $forum[description]}
                            $forum[description]
                            {else}
                            {lang forum_threads}: <!--{echo dnumber($forum[threads])}-->&nbsp;&nbsp;{lang thread}: <!--{echo dnumber($forum[posts])}--><!--{if $forum[todayposts] > 0}-->&nbsp;&nbsp;<span class="tday">{lang index_today}: $forum[todayposts]</span><!--{/if}-->
                            {/if}
                            </p>
                        </div>
                    </a>
                </li>
				<!--{/loop}-->
                </ul>
        <!--{else}-->
        	{if $_G[uid]}
        	<div class="ainuoemp">$alang_zanwuguanzhu</div>
            {else}
            <div class="ainuoemp"><a href="javascript:;" class="ainuo_nologin">$alang_loginfirst <i class="iconfont icon-right"></i></a>
            <p style="margin-top:20px;">$alang_addguanzhu</p>
            </div>
            {/if}
        <!--{/if}-->
    	
    	</div>
</div>
</div>

  
<script>
$('.button-nav').on('click', function() {
	if(document.getElementById("ainuo_topsq").innerHTML == "$alang_shouqi"){
		$("#ainuo_topsqtb").removeClass("icon-arrowleft");
		$("#ainuo_topsqtb").addClass("icon-arrowright");
		$("#page_forum_______").removeClass("open-plate");
		document.getElementById("ainuo_topsq").innerHTML = "$alang_bankuai"
	}else{
		$("#ainuo_topsqtb").addClass("icon-arrowleft");
		$("#ainuo_topsqtb").removeClass("icon-arrowright");
		$("#page_forum_______").addClass("open-plate");
		document.getElementById("ainuo_topsq").innerHTML = "$alang_shouqi"
	}
});
</script>

<!--{hook/index_middle_mobile}-->

<!--{template common/footer}-->

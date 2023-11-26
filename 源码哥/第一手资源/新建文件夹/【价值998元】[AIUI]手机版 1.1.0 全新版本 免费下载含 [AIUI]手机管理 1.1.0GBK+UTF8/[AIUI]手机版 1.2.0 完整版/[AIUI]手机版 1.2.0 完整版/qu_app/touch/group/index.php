<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<!-- header start -->
    <div class="header">
        <div class="nav">
            <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
			<span class="name">{$_G[setting][navs][3][navname]}</span>
            <a href="forum.php?mod=group&action=create" class="y"><i class="iconfont icon-add1"></i></a>
        </div>
    </div>
<!-- header end -->
<!--{template common/top_fix}-->

<style>
.forum-plate-bar{position:fixed;top:44px;right:0;bottom:0;left:0;overflow:auto;-webkit-overflow-scrolling:touch;right:auto;width:5rem;font-size:.6rem;background-color:#f8f8f8; border-right:1px solid #eee;-webkit-transition:-webkit-transform 300ms;transition:-webkit-transform 300ms;transition:transform 300ms;transition:transform 300ms, -webkit-transform 300ms;-webkit-transform:translate(-100%, 0);transform:translate(-100%, 0)}
.forum-plate-bar .item{position:relative;text-align:center;color:#999;padding:0; margin:0;}
.forum-plate-bar .item a{ display:block;padding:12px 0; font-size:13px;border-bottom:1px solid #eee;}
.forum-plate-bar .item a.active{color: #f23030;background:#fff; }
.forum-plate-bar li:first-child a.active{}
.forum-plate-bar .badge{position:absolute;top:50%;right:.1rem;z-index:100;height:.8rem;margin-top:-.4rem;min-width:.8rem;padding:0 .2rem;font-size:.6rem;line-height:.8rem;color:white;vertical-align:top;background:red;-webkit-border-radius:.5rem;border-radius:.5rem;margin-left:.1rem}
.bar-nav ~ .forum-plate-bar{top:2.2rem}
.bar-tab ~ .forum-plate-bar{bottom:2.5rem}
.forum-plate-bar.news-style .item{text-align:left;padding-left:.5rem}
.forum-plate-bar.news-style .item.active{color:#3d4145}
.forum-container{-webkit-transition:margin-left 300ms;transition:margin-left 300ms}
.page.open-plate .forum-plate-bar{-webkit-transform:translate(0, 0);transform:translate(0, 0)}
.page.open-plate .forum-container{margin-left:5rem;}
.sub_forum{ border:none;}
</style><!--From www.moq u8 .com -->

<div class="z-scroll forum-plate-bar">
	<ul id="forum-plate-bar">
		<li class="item"><a href="#tab0" class="tab-link active">{lang recommend_group}</a></li>
        <li class="item"><a href="#tab1" class="tab-link">$alang_group_mymanage</a></li>
        <li class="item"><a href="#tab2" class="tab-link">$alang_group_myjiaru</a></li>
        <!--{loop $first $groupid $group}-->
		<li class="item"><a href="#tab{$groupid}" class="tab-link">$group[name]</a></li>
        <!--{/loop}-->
   </ul><!--From ww w.moq u8 .com -->
</div>

<div class="infinite-scroll-bottom forum-container native-scroll">
    <div class="tabs">
		<div class="sub_forum tab active" id="tab0">
            <!--{if dunserialize($_G['setting']['group_recommend'])}-->
                <ul>
                <!--{loop dunserialize($_G['setting']['group_recommend']) $val}-->         
                    <li>
                        <div class="subicon">
                        <!--{if $val[icon]}-->
                            <a href="forum.php?mod=forumdisplay&action=list&fid=$val[fid]"><img src="$val[icon]" /></a>
                        <!--{else}-->
                            <a href="forum.php?mod=forumdisplay&action=list&fid=$val[fid]"><img src="static/image/common/groupicon.gif" /></a>
                        <!--{/if}-->
                        </div>
                        <a href="forum.php?mod=forumdisplay&action=list&fid=$val[fid]" class="mui-right">
                            <i class="iconfont icon-right"></i>
                            <div class="mui-media-body">
                                <h2>{$val[name]}</h2>
                                <p class="mui-ellipsis">$val[description]</p>
                            </div>
                        </a>
                    </li>
                    <!--{/loop}-->
                    </ul>
            <!--{else}-->
                <div class="ainuoemp">$alang_zanwutuijian</div>
            <!--{/if}-->
            
        </div>
        <!--{eval require_once(DISCUZ_ROOT."./template/qu_app/touch/ainuo/group_my.php");}-->
        <div class="sub_forum tab" id="tab1">
            <!--{if $grouplistmanage}-->
                <ul>
                <!--{loop $grouplistmanage $groupid $group}-->
                <!--{eval $groupdesc = DB::result_first('SELECT description FROM '.DB::table('forum_forumfield').' WHERE fid ='.$groupid.'')}-->
                        <li>
                            <div class="subicon">
                            <a href="forum.php?mod=forumdisplay&action=list&fid=$groupid"><img src="$group[icon]" alt="$group[name]" /></a>
                            </div>
                            <a href="forum.php?mod=forumdisplay&action=list&fid=$groupid" class="mui-right">
                                <i class="iconfont icon-right"></i>
                                <div class="mui-media-body">
                                    <h2>{$group[name]}</h2>
                                    <p class="mui-ellipsis">$groupdesc</p>
                                </div>
                            </a>
                        </li>
				<!--{/loop}-->
				</ul>
            <!--{else}-->
                {if $_G[uid]}
                	<div class="ainuoemp">
                    	<a href="forum.php?mod=group&action=create">{lang group_create}</a>
                        <p style="margin-top:20px;">$alang_zanwuchuangjian</p>
                    </div>
                {else}
                	<div class="ainuoemp"><a href="javascript:;" class="ainuo_nologin">$alang_loginfirst <i class="iconfont icon-right"></i></a>
                	</div>
                {/if}
            <!--{/if}-->
            
        </div>
        <div class="sub_forum tab" id="tab2">
            <!--{if $grouplistjiaru}-->
                <ul>
                <!--{loop $grouplistjiaru $groupid $group}-->
                <!--{eval $groupdesc = DB::result_first('SELECT description FROM '.DB::table('forum_forumfield').' WHERE fid ='.$groupid.'')}-->
                        <li>
                            <div class="subicon">
                            <a href="forum.php?mod=forumdisplay&action=list&fid=$groupid"><img src="$group[icon]" alt="$group[name]" /></a>
                            </div>
                            <a href="forum.php?mod=forumdisplay&action=list&fid=$groupid" class="mui-right">
                                <i class="iconfont icon-right"></i>
                                <div class="mui-media-body">
                                    <h2>{$group[name]}</h2>
                                    <p class="mui-ellipsis">$groupdesc</p>
                                </div>
                            </a>
                        </li>
				<!--{/loop}-->
				</ul>
            <!--{else}-->
                {if $_G[uid]}
                	<div class="ainuoemp">$alang_zanwujiaru</div>
                {else}
                	<div class="ainuoemp"><a href="javascript:;" class="ainuo_nologin">$alang_loginfirst <i class="iconfont icon-right"></i></a>
                		<p style="margin-top:20px;">$alang_addguanzhu2</p>
                	</div>
                {/if}
            <!--{/if}-->
            
        </div>
    <!--{loop $first $groupid $group}-->
        <div class="sub_forum tab" id="tab{$groupid}">
            <ul class="cl">
            <!--{loop $lastupdategroup[$groupid] $val}-->
            <!--{eval $aicon = DB::result_first('SELECT icon FROM '.DB::table('forum_forumfield').' WHERE fid ='.$val[fid].'')}-->
            <!--{eval $adesc = DB::result_first('SELECT description FROM '.DB::table('forum_forumfield').' WHERE fid ='.$val[fid].'')}-->
                <li>
                    <div class="subicon">
                    <!--{if $aicon}-->
                        <a href="forum.php?mod=forumdisplay&action=list&fid=$val[fid]"><img src="data/attachment/group/$aicon" /></a>
                    <!--{else}-->
                        <a href="forum.php?mod=forumdisplay&action=list&fid=$val[fid]"><img src="static/image/common/groupicon.gif" /></a>
                    <!--{/if}-->
                    </div>
                    <a href="forum.php?mod=forumdisplay&action=list&fid=$val[fid]" class="mui-right">
                        <i class="iconfont icon-right"></i>
                        <div class="mui-media-body">
                            <h2>{$val[name]}</h2>
                            <p class="mui-ellipsis">$adesc</p>
                        </div>
                    </a>
                </li>
                <!--{/loop}-->
            </ul>
        </div>
        
    <!--{/loop}-->
    
    </div>
</div>

<!--{subtemplate common/foot_bottom}-->


<!--{template common/footer}-->
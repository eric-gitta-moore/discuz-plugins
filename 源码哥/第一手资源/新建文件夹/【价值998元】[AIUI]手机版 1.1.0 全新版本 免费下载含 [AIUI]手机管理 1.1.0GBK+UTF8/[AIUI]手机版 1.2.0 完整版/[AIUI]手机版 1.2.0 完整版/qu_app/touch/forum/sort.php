<?PHP exit('QQÈº£º550494646');?>

<div id="f_sortcon" class="f_sortcon">
        <div class="sort_sort cl">
        	<a href="javascript:;" class="sortclose"><i class="iconfont icon-close"></i></a>
            <div class="sort_desc cl">
                <div class="bm_h">$alang_shaixuan</div>
                <div class="sort_con">
                <ul>
                    <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['specialtype'] == ''}class="a"{/if}>$alang_all</a></li>
                    <!--{if $showpoll}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=poll$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['specialtype'] == 'poll'}class="a"{/if}>$alang_toupiao</a></li><!--{/if}-->
                    <!--{if $showtrade}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=trade$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['specialtype'] == 'trade'}class="a"{/if}>$alang_shangpin</a></li><!--{/if}-->
                    <!--{if $showreward}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=reward$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['specialtype'] == 'reward'}class="a"{/if}>$alang_xuanshang</a></li><!--{/if}-->
                    <!--{if $showactivity}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=activity$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['specialtype'] == 'activity'}class="a"{/if}>$alang_huodong</a></li><!--{/if}-->
                    <!--{if $showdebate}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=debate$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['specialtype'] == 'debate'}class="a"{/if}>$alang_bate</a></li><!--{/if}-->
                    
                  
                    <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=digest&digest=1$forumdisplayadd[digest]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="{if $_GET['filter'] == 'digest'} a{/if}">$alang_newjinghua</a></li>
                    </ul>
                </div>
            </div>
        
            <!--{if ($_G['forum']['threadtypes'] && $_G['forum']['threadtypes']['listable']) || count($_G['forum']['threadsorts']['types']) > 0}-->
            <div class="sort_desc cl" style="border-top:1px solid #eee;">
                <div class="bm_h">$alang_sort</div>
                <div class="sort_con">
                <ul>
                    <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_G['forum']['threadsorts']['defaultshow']}&filter=sortall&sortall=1{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if !$_GET['typeid'] && !$_GET['sortid']}class="a"{/if}>$alang_all</a></li>
                    <!--{if $_G['forum']['threadtypes']}-->
                        <!--{loop $_G['forum']['threadtypes']['types'] $id $name}-->
                            <!--{if $_GET['typeid'] == $id}-->
                            <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['sortid']}&filter=sortid&sortid=$_GET['sortid']{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="a">$name</a></li>
                            <!--{else}-->
                            <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=typeid&typeid=$id$forumdisplayadd[typeid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">$name</a></li>
                            <!--{/if}-->
                        <!--{/loop}-->
                    <!--{/if}-->
                
                    <!--{if $_G['forum']['threadsorts']}-->
                        <!--{loop $_G['forum']['threadsorts']['types'] $id $name}-->
                            <!--{if $_GET['sortid'] == $id}-->
                            <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['typeid']}&filter=typeid&typeid=$_GET['typeid']{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="a">$name</a></li>
                            <!--{else}-->
                            <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=sortid&sortid=$id$forumdisplayadd[sortid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">$name</a></li>
                            <!--{/if}-->
                        <!--{/loop}-->
                    <!--{/if}-->
                </ul>
                </div>
            </div>
            <!--{/if}-->
        </div>

</div>


    
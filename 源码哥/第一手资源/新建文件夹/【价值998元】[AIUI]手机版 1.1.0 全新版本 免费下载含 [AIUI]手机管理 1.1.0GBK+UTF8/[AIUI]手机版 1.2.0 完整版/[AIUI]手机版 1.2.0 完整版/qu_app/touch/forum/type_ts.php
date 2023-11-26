<?PHP exit('QQÈº£º550494646');?>
<!--{if ($_G['forum']['threadtypes'] && $_G['forum']['threadtypes']['listable']) || count($_G['forum']['threadsorts']['types']) > 0}-->
<style>.ainuo_type a{ width:25%;}</style>
<!--{else}-->
<style>.ainuo_type a{width:33.333%;}</style>
<!--{/if}-->
<style>
.ainuo_type a{display:block; text-align:center; float:left; position:relative;}
.ainuo_type a .line{position: absolute;right: 0;top: 10px;width: 1px;height: 20px;background: #ccc;overflow: hidden;}
.ainuo_type a.current{ color:#f50;}
</style>
<div class="bar bar-header-secondary">
    <div class="searchbar">
        <a class="searchbar-cancel">$alang_cancel</a>
        <div class="search-input">
        	<form class="searchform" method="post" autocomplete="off" action="search.php?mod=forum" onsubmit="if($('scform_srchtxt')) searchFocus($('scform_srchtxt'));">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
            <input type="text" id="scform_srchtxt" name="srchtxt" value="$keyword" placeholder="{lang enter_content}" />
			<input type="hidden" name="searchsubmit" value="yes" />
            <button type="submit" id="scform_submit" class="icon"><i class="iconfont icon-search"></i></button>
            </form>
        </div>
    </div>
</div><!--From www.moq u8 .co m -->
<div class="ainuo_type cl">
    	<a href="forum.php?mod=forumdisplay&fid=$_G[fid]" class="{if $_GET['filter'] == ''} current{/if}">{lang all}<span class="line"></span></a>
        <a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=author&orderby=dateline" class="{if $_GET['filter'] == 'author'} current{/if}">{$alang_newthread}<span class="line"></span></a>
        <a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=heat&orderby=heats$forumdisplayadd[heat]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="{if $_GET['filter'] == 'heat'} current{/if}">{lang order_heats}<!--{if ($_G['forum']['threadtypes'] && $_G['forum']['threadtypes']['listable']) || count($_G['forum']['threadsorts']['types']) > 0}--><span class="line"></span><!--{/if}--></a>
        <!--{if ($_G['forum']['threadtypes'] && $_G['forum']['threadtypes']['listable']) || count($_G['forum']['threadsorts']['types']) > 0}-->
    	<a href="javascript:;" class="afilter"><i class="iconfont icon-filter"></i>$alang_shaixuan</a>
        <!--{/if}-->
</div><!--From www.mo q u8 .com -->

<!--{if ($_G['forum']['threadtypes'] && $_G['forum']['threadtypes']['listable']) || count($_G['forum']['threadsorts']['types']) > 0}-->
<div id="f_sortcon" class="f_sortcon">
    <div class="sort_sort cl" style="padding-top:0;">
        <a href="javascript:;" class="sortclose"><i class="iconfont icon-close"></i></a>
        
        <div class="sort_desc cl">
            <div class="bm_h">{lang types}</div>
            <div class="sort_con">
            <ul>
                <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_G['forum']['threadsorts']['defaultshow']}&filter=sortall&sortall=1{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if !$_GET['typeid'] && !$_GET['sortid']}class="a"{/if} data-no-cache="true">{lang all}</a></li>
                <!--{if $_G['forum']['threadtypes']}-->
                    <!--{loop $_G['forum']['threadtypes']['types'] $id $name}-->
                        <!--{if $_GET['typeid'] == $id}-->
                        <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['sortid']}&filter=sortid&sortid=$_GET['sortid']{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="a" data-no-cache="true">$name</a></li>
                        <!--{else}-->
                        <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=typeid&typeid=$id$forumdisplayadd[typeid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" data-no-cache="true">$name</a></li>
                        <!--{/if}-->
                    <!--{/loop}-->
                <!--{/if}-->
            
                <!--{if $_G['forum']['threadsorts']}-->
                    <!--{loop $_G['forum']['threadsorts']['types'] $id $name}-->
                        <!--{if $_GET['sortid'] == $id}-->
                        <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['typeid']}&filter=typeid&typeid=$_GET['typeid']{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="a" data-no-cache="true">$name</a></li>
                        <!--{else}-->
                        <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=sortid&sortid=$id$forumdisplayadd[sortid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" data-no-cache="true">$name</a></li>
                        <!--{/if}-->
                    <!--{/loop}-->
                <!--{/if}-->
            </ul>
            </div>
        </div>
        
    </div>
</div>
<!--{/if}-->

<div class="grey_line cl"></div>


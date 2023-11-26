<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!--[name]{lang portalcategory_listtplname}[/name]-->
<!--{eval $list = array();}-->
<!--{eval $wheresql = category_get_wheresql($cat);}-->
<!--{eval $list = category_get_list($cat, $wheresql, $page);}-->

<!--{if $_G['inajax'] == 1}-->
<!--{eval $mysiteBM = currentlang()}-->
<!--{eval require_once(DISCUZ_ROOT."./template/qu_app/touch/ainuo/lang/$mysiteBM.php");}-->
		<!--{loop $list['list'] $value}-->
            <!--{eval $highlight = article_title_style($value);}-->
            <!--{eval $article_url = fetch_article_url($value);}-->
            <li>
                <a href="{$_G['siteurl']}portal.php?mod=view&aid=$value[aid]" {if !$value[pic]}class="connopic"{/if}>
                	<!--{if $value[pic]}--><div class="atc ainuolazyloadbg" data-original="{$_G['siteurl']}$value[pic]" style="background-size:cover;"></div><!--{/if}-->
                    <h2 $highlight>$value[title]</h2>
                    <p>
                        <span class="y"><!--{echo DB::result_first('SELECT `viewnum` FROM '.DB::table('portal_article_count').' WHERE `aid` ='.$value[aid].'')}--> $alang_view</span>
                        <span>$value[dateline]</span>
                    </p>
                </a>
            </li>
        <!--{/loop}-->

<!--{else}-->
<!--{hook/list_diy}-->
<style id="diy_style" type="text/css"></style>

<!-- header start -->
    <div class="header">
        <div class="nav">
            <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
			<span class="name">$cat[catname]</span>
            <!--{if 0 && ($_G['group']['allowpostarticle'] || $_G['group']['allowmanagearticle'] || $categoryperm[$catid]['allowmanage'] || $categoryperm[$catid]['allowpublish']) && empty($cat['disallowpublish'])}-->
            <a href="portal.php?mod=portalcp&ac=article&catid=$cat[catid]" class="y"><i class="iconfont icon-fatie"></i></a>
            <!--{/if}-->
        </div>
    </div>
<!-- header end -->
<!--{template common/top_fix}-->
<div class="ainuo_article cl">
	<!--{if $cat[subs] || $cat[others]}-->
    <div class="ainuo_articleusernav cl">
        <div id="usernav" class="swiper-container-horizontal swiper-container-free-mode">
                <ul class="swiper-wrapper">
                        <!--{if $cat[subs]}-->
                        <!--{eval $i = 1;}-->
                        <!--{loop $cat[subs] $value}-->
                        <li class="swiper-slide {if $value['catid'] == $_G[catid]}a{/if}"><a href="{$portalcategory[$value['catid']]['caturl']}">$value[catname]</a></li><!--{eval $i--;}-->
                        <!--{/loop}-->
                    <!--{/if}-->
                    <!--{loop $cat[others] $value}-->
                        <li class="swiper-slide {if $value['catid'] == $_G[catid]}a{/if}"><a href="{$portalcategory[$value['catid']]['caturl']}">$value[catname]</a></li>
                    <!--{/loop}-->
    
                </ul>
        </div>
    </div>
    
    
<script type="text/javascript">
if($("#usernav .a").length > 0) {
	var ainuo_first = $("#usernav .a").offset().left + $("#usernav .a").width() >= $(window).width() ? $("#usernav .a").index() : 0;
}else{
	var ainuo_first = 0;
}	
wzmySwiper = new Swiper('#usernav', {
	freeMode : true,
	slidesPerView : 'auto',
	initialSlide : ainuo_first,
});
</script>


    <!--{/if}-->
    
<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
<!--{eval $amaxnum = DB::result_first('SELECT `articles` FROM '.DB::table('portal_category').' WHERE `catid` ='.$_G[catid].'')}-->
<div class="grey_line cl"></div>	
    <div class="con">
    {if $list['list']}
    <ul id="ainuoloadmore" class="ainuoloadmore">
    	<!--{loop $list['list'] $value}-->
            <!--{eval $highlight = article_title_style($value);}-->
            <!--{eval $article_url = fetch_article_url($value);}-->
            <li>
                <a href="{$_G['siteurl']}portal.php?mod=view&aid=$value[aid]" {if !$value[pic]}class="connopic"{/if}>
                	<!--{if $value[pic]}--><div class="atc ainuolazyloadbg" data-original="{$_G['siteurl']}$value[pic]" style="background-size:cover;"></div><!--{/if}-->
                    <h2 $highlight>$value[title]</h2>
                    <p>
                        <span class="y"><!--{echo DB::result_first('SELECT `viewnum` FROM '.DB::table('portal_article_count').' WHERE `aid` ='.$value[aid].'')}--> $alang_view</span>
                        <span>$value[dateline]</span>
                    </p>
                </a>
            </li>
        <!--{/loop}-->
    </ul>
    {else}
    <div class="emp">$alang_nothread</div>
    {/if}
    </div>
    
	<div id="ainuoloadempty"></div>
    {if $cat[perpage] < $amaxnum}
    <div id="loading" class="loading G-animate-load-wrap">
        <div class="load-loading"><span class="loading02"></span> <span class="load-word">$alang_loading</span></div>
    </div>
    {/if}

</div>

<script>
	var ainuo_forum_html = '';
	var ainuo_forum_empty = '<div class="inner">$alang_nomore</div>';
	var ainuo_forum_emptyfail = '<div class="inner">$alang_loadfail</div>';				
	var ainuo_forum_loading = false;
	var ainuo_forum_aperpage = $cat[perpage];
	var amaxnum = $amaxnum;
	var ainuo_forum_ainuomaxpage = Math.ceil(amaxnum / ainuo_forum_aperpage);
	var ainuo_forum_url = 'portal.php?mod=list&catid=$_G[catid]&page=';
</script>



<!--{/if}-->

<!--{template common/footer}-->
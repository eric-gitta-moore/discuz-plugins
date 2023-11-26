<?PHP exit('QQÈº£º550494646');?>
<!--{subtemplate common/header}-->
<!--[name]{lang portalcategory_viewtplname}[/name]-->
<style>
.ainuofoot_height,.ainuo_foot_nav{ display:none !important;}
</style>

<!-- header start -->
    <div id="header" class="header">
        <div class="nav">
            <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
			<span class="name">$alang_content</span>
            <!--{if 0 && ($_G['group']['allowpostarticle'] || $_G['group']['allowmanagearticle'] || $categoryperm[$catid]['allowmanage'] || $categoryperm[$catid]['allowpublish']) && empty($cat['disallowpublish'])}-->
            <a href="portal.php?mod=portalcp&ac=article&catid=$cat[catid]" class="y"><i class="iconfont icon-fatie"></i></a>
            <!--{/if}-->
        </div>
    </div>
<!-- header end --><!--From www.mo  q u8 .com -->
<!--{template common/top_fix}-->

<script>
var sharetitle = '$article[title] - $_G[setting][bbname]';
var sharedesc = '$article[summary]';
var sharelink = SITEURL + 'portal.php?mod=view&aid=$article[aid]';
var shareicon = SITEURL + '$article[pic]';
</script>

<div class="ainuo_wznr">
    <div class="tit">$article[title]</div>
    <div class="info">
		<span><a href="{echo getportalcategoryurl($cat[catid])}">$cat[catname]</a></span>
        <span>$article[dateline]</span>
        <span> <!--{if $article[viewnum] > 0}-->$article[viewnum]<!--{else}-->0<!--{/if}--> $alang_view</span>
    </div>
    <div class="con">
		$content[content]
	</div>
    <div id="click_div">
		<!--{template home/space_click}-->
	</div>
    <!--{if $dataad[ad_newsview2]}-->$dataad[ad_newsview2]<!--{/if}-->
    <div class="grey_line cl"></div>
    <!--{if $multi && !$articleContents}-->$multi<!--{/if}-->
	<!--{if $article['related']}-->
		<div id="related_article">
			<h2>{lang view_related}</h2>
			<div class="">
				<ul id="raid_div">
				<!--{loop $article['related'] $raid $rvalue}-->
                	<li>
                    	{eval $viewimg = DB::result_first('SELECT pic FROM '.DB::table('portal_article_title').' WHERE aid ='.$rvalue[aid].'')}
                        {eval $viewremote = DB::result_first('SELECT remote FROM '.DB::table('portal_article_title').' WHERE aid ='.$rvalue[aid].'')}
                        <a href="$rvalue[uri]" {if !$viewimg}class="connopic"{/if}>
                            <!--{if $viewimg}--><div class="atc"><img src="{if !$viewremote}data/attachment/$viewimg{else}$_G['setting']['ftp']['attachurl']/$viewimg{/if}" /></div><!--{/if}-->
                            <h1>$rvalue[title]</h1>
                            <p>
                                <span>{echo dgmdate($rvalue[dateline])}</span>
                            </p>
                        </a>
                    </li>
				<!--{/loop}-->
				</ul>
			</div>
            <div class="list_other"></div>
		</div>
        
    <div class="grey_line cl"></div>
	<!--{/if}-->
	<!--{if $article['allowcomment']==1}-->
		<!--{eval $data = &$article}-->
		<!--{template portal/portal_comment}-->
	<!--{/if}-->
	
</div>

<!--{if $_G['relatedlinks']}-->
	<script type="text/javascript">
		var relatedlink = [];
		<!--{loop $_G['relatedlinks'] $key $link}-->
		relatedlink[$key] = {'sname':'$link[name]', 'surl':'$link[url]'};
		<!--{/loop}-->
		relatedlinks('article_content');
	</script>
<!--{/if}-->


<!--{template common/footer}-->
<?php exit;?>
<!--{eval $_G['home_tpl_titles'] = array($album['albumname'], '{lang album}');}-->
<!--{eval $friendsname = array(1 => '{lang friendname_1}',2 => '{lang friendname_2}',3 => '{lang friendname_3}',4 => '{lang friendname_4}');}-->
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<span>{$n5app['lang']['kjxcxclb']}</span>
</div>
{/if}
<div class="n5gr_xctp cl">
	<div class="xctp_xccz cl">
		<div class="xccz_tpsl z cl"><!--{if $album[albumname]}-->$album[albumname]<!--{else}-->{lang default_album}<!--{/if}--><!--{if $album[picnum]}--><i>{lang total} $album[picnum] {lang album_pics}</i><!--{/if}--></div>
		<div class="xccz_tpgl y cl">
			<!--{if $space[self]}-->
				<a href="{if $album[albumid] > 0}home.php?mod=spacecp&ac=album&op=edit&albumid=$album[albumid]{else}home.php?mod=spacecp&ac=album&op=editpic&albumid=0{/if}"  class="xccz_bjxc"></a>
			<!--{/if}-->
			<!--{if ($_G[uid] == $album[uid] || checkperm('managealbum')) && $album[albumid] > 0}-->
				<a href="home.php?mod=spacecp&ac=album&op=delete&albumid=$album[albumid]&uid=$album[uid]&handlekey=delalbumhk_{$album[albumid]}" class="xccz_scxc dialog"></a>
			<!--{/if}-->
			<a href="home.php?mod=spacecp&ac=favorite&type=album&id=$album[albumid]&spaceuid=$space[uid]&handlekey=sharealbumhk_{$album[albumid]}" class="xccz_sscxc {if $_G['uid']}dialog{else}n5app_wdlts{/if}"></a>
		</div>
	</div>
	<!--{if $album[depict]}-->
		<div class="xctp_xcjj cl">$album[depict]</div>
	<!--{/if}-->
	<!--{if $list}-->
	<div class="xctp_tplb cl">
		<ul class="pbbk_pbzt">
		<!--{loop $list $key $value}-->
			<li class="pbbk_pbsj">
				<a href="home.php?mod=space&uid=$value[uid]&do=$do&picid=$value[picid]"><!--{if $value[pic]}--><img nodata-echo="yes" src="{eval echo str_replace('.thumb.jpg','',$value['pic'])}" alt="" /><!--{/if}--></a>
			</li>
		<!--{/loop}-->
		</ul>
	</div>	
	<script src="template/zhikai_n5app/js/jaliswall.js" type="text/javascript"></script>
	<script type="text/javascript">
	var jq = jQuery.noConflict(); 
		jq(function(){
			jq('.pbbk_pbzt').jaliswall({ item: '.pbbk_pbsj' });
		});
	</script>
	<style type="text/css">
		.page {margin-top:30px;margin-bottom:10px;}
		.page a {float: none;display:inline;padding: 10px 30px;}
	</style>
	<!--{if $multi}-->$multi<!--{/if}-->	
<!--{else}-->
	<!--{if !$pricount}-->
		<div class="n5qj_wnr">
			<img src="template/zhikai_n5app/images/n5sq_gzts.png">
			<p>{lang no_pics}</p>
		</div>
	<!--{/if}-->
<!--{/if}-->
</div>
<!--{template common/footer}-->
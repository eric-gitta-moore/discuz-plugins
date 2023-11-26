<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!-- header start -->
<header class="header">
    <div class="nav">
		<a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
		<span class="category">
			<span class="name">$alang_fav</span>
		</span>
    </div>
</header>
<div class="ainuo_usertb cl">
    <ul class="tb ashouc cl">
        <li$actives[all]><a href="home.php?mod=space&do=favorite&type=all">{lang all}</a></li>
          <li$actives[thread]><a href="home.php?mod=space&do=favorite&type=thread">{lang favorite_thread}</a></li>
          <li$actives[forum]><a href="home.php?mod=space&do=favorite&type=forum">{lang favorite_forum}</a></li>
          <!--{if helper_access::check_module('group')}--><li$actives[group]><a href="home.php?mod=space&do=favorite&type=group">{lang favorite_group}</a></li><!--{/if}-->
          <!--{if helper_access::check_module('blog')}--><li$actives[blog]><a href="home.php?mod=space&do=favorite&type=blog">{lang favorite_blog}</a></li><!--{/if}-->
          <!--{if helper_access::check_module('album')}--><li$actives[album]><a href="home.php?mod=space&do=favorite&type=album">{lang favorite_album}</a></li><!--{/if}-->
          <!--{if helper_access::check_module('portal')}--><li$actives[article]><a href="home.php?mod=space&do=favorite&type=article">{lang favorite_article}</a></li><!--{/if}-->
    </ul><!--From www.m oq u8 .com -->
</div>
<div class="grey_line cl"></div>


<div class="ainuo_favorite cl">
	<div class="cl">
		<div class="cl">
			<!--{if $list}-->
			<form method="post" autocomplete="off" name="delform" id="delform" action="home.php?mod=spacecp&ac=favorite&op=delete&type=$_GET[type]&checkall=1" onsubmit="showDialog('{lang del_select_favorite_confirm}', 'confirm', '', '$(\'delform\').submit();'); return false;">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="delfavorite" value="true" />
			<ul id="favorite_ul" class="">
				<!--{loop $list $k $value}-->
				<li id="fav_$k">
					<a id="a_delete_$k" ainuoto="home.php?mod=spacecp&ac=favorite&op=delete&favid=$k" class="shanchu"><i class="iconfont icon-delete"></i></a>
					
					<!--{if $_GET['type'] == 'all'}-->
                    	{if $value[idtype] == 'tid'}
                        	<span>{lang favorite_thread}</span>
                        {elseif $value[idtype] == 'fid'}
                    		<span>{lang favorite_forum}</span>
                        {elseif $value[idtype] == 'blogid'}
                    		<span>{lang favorite_blog}</span>
                        {elseif $value[idtype] == 'gid'}
                    		<span>{lang favorite_group}</span>
                        {elseif $value[idtype] == 'uid'}
                    		
                        {elseif $value[idtype] == 'albumid'}
                    		<span>{lang favorite_album}</span>
                        {elseif $value[idtype] == 'aid'}
                    		<span>{lang favorite_article}</span>
                        {/if}
                    <!--{/if}-->
					<a href="$value[url]">$value[title]</a>
                    <p class="xg1"><!--{date($value[dateline], 'u')}--></p>
					<!--{if $value[description]}-->
					<div class="dashedtip cl" id="quote_preview">
						$value[description]
					</div>
					<!--{/if}-->
				</li>
				<!--{/loop}-->
			</ul>

			</form>
			<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
			<!--{else}-->
            <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_favorite_yet}</p></div>
			<!--{/if}-->
		</div>
		
	</div>
	
</div>


<script type="text/javascript">
	function favorite_delete(favid) {
		var el = $('fav_' + favid);
		if(el) {
			el.style.display = "none";
		}
	}
	<!--{if $_GET[type] == "thread"}-->
	function collection_favorite() {
		var form = $('delform');
		var prefix = '^favorite';
		var tids = '';
		for(var i = 0; i < form.elements.length; i++) {
			var e = form.elements[i];		
			if(e.name.match(prefix) && e.checked) {
				tids += 'tids[]=' + e.getAttribute('vid') + '&';
			}
		}
		if(tids) {
			showWindow(null, 'forum.php?mod=collection&action=edit&op=addthread&' + tids);
		}
	}
	function update_collection() {}
	<!--{/if}-->
</script>

<script>
$('.shanchu').on('click', function() {
	var obj = $(this);
	Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
	$.ajax({
		type : 'GET',
		url : obj.attr('ainuoto') + '&inajax=1',
		dataType : 'xml'
	})
	.success(function(s) {
		Zepto('.ainuooverlay').remove();
		popup.open(s.lastChild.firstChild.nodeValue);
		evalscript(s.lastChild.firstChild.nodeValue);
	})
	return false;
	
});
</script>

<!--{template common/footer}-->

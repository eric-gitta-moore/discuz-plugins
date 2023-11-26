<?PHP exit('QQÈº£º550494646');?>
<div id="ainuo_f_sort" class="ainuo_f_sort cl">
	<ul>
        <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['filter'] != 'lastpost' && $_GET['filter'] != 'digest'}class="a"{/if}>{lang all}</a><span></span></li>
        <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=lastpost&orderby=lastpost$forumdisplayadd[lastpost]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="{if $_GET['filter'] == 'lastpost'} a{/if}">{lang latest}</a><span></span></li>
        <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=digest&digest=1$forumdisplayadd[digest]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="{if $_GET['filter'] == 'digest'} a{/if}">{lang digest_posts}</a><span></span></li>
        <li><a id="ashaixuan" href="javascript:;">$alang_shaixuan<i class="iconfont icon-screen"></i></a></li>
	</ul>
	
</div><!--from www.ymg6.com -->
<script>
$(document).ready(function(){
	$("#ashaixuan").click(function(){
		var oMenu = document.getElementById("f_sortcon").style.display;
		$("#f_sortcon").toggle(300);
	});	
	$("#sort_close").click(function(){
		$("#f_sortcon").toggle(300);
	});	
});
</script>
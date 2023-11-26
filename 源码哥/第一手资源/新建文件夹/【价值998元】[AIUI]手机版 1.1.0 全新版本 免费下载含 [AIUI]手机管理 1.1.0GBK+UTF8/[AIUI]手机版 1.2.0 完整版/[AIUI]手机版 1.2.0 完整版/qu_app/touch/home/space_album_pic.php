<?PHP exit('QQÈº£º550494646');?>
<!--{eval $_G['home_tpl_titles'] = array(getstr($pic['title'], 60, 0, 0, 0, -1), $album['albumname'], '{lang album}');}-->
<!--{eval $friendsname = array(1 => '{lang friendname_1}',2 => '{lang friendname_2}',3 => '{lang friendname_3}',4 => '{lang friendname_4}');}-->
<!--{template common/header}-->

<div class="ainuo_pic_yuan cl">
	<div class="atop cl">
		<a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
		<em>{lang upload_at} <!--{date($pic[dateline])}--></em>
    </div>
	<div class="acon">
    	<ul>
        	<li><div class="acon1"><img class="ainuolazyload" data-original="$pic[pic]" /></div></li>
        </ul>
    </div>
    <!--{if $pic[title]}-->
    <div class="abottom cl">
    	<h2>$pic[title]</h2>
    </div>
    <!--{/if}-->
</div>
<!--{template common/footer}-->
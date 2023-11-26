<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<!--{block actiontitle}--><!--{if $special == 1}-->{lang post_newthreadpoll}<!--{elseif $special == 2}-->{lang post_newthreadtrade}<!--{elseif $special == 3}-->{lang post_newthreadreward}<!--{elseif $special == 4}-->{lang post_newthreadactivity}<!--{elseif $special == 5}-->{lang post_newthreaddebate}<!--{else}-->{lang send_posts}<!--{/if}--><!--{/block}-->
<!-- header start -->
    <div class="header">
        <div class="nav">
            <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
			<span class="name">$actiontitle</span>
        </div>
    </div>
<!-- header end -->

<div style="display: none">
	<ul id="fs_group">$grouplist</ul>
	<ul id="fs_forum_common">$commonlist</ul>
	<!--{loop $forumlist $forumid $forum}-->
		<ul id="fs_forum_$forumid">$forum</ul>
	<!--{/loop}-->
	<!--{loop $subforumlist $forumid $forum}-->
		<ul id="fs_subforum_$forumid">$forum</ul>
	<!--{/loop}-->
</div>

<div class="ainuo_quickpost cl">
	<div class="acon1 cl">
		<span class="pbnv">$_G['setting']['bbname']<span id="pbnv"></span> <a id="enterbtn" class="xg1" href="javascript:;" onclick="locationforums(currentblock, currentfid)">[{lang nav_forum}]</a></span>
	</div>
    <div class="acon2 cl">
        <ul class="pbl cl">
            <li id="block_group"></li>
            <li id="block_forum"></li>
            <li id="block_subforum"></li>
        </ul>
    </div>
    <div class="acon3 cl">
    <!--{if $_G['group']['allowpost'] || !$_G['uid']}-->
        <!--{if $special === null}-->
            <button id="postbtn" class="noselect" onclick="golinknull(selectfid)" disabled="disabled">{lang send_posts}</button>
        <!--{else}-->
            <button id="postbtn" onclick="golink(selectfid)" disabled="disabled">$actiontitle</button>
        <!--{/if}-->
    <!--{/if}-->
    </div>
</div>


<script type="text/javascript" reload="1">
function golinknull(id){
	window.location.href = 'forum.php?mod=post&action=newthread&fid=' + id;
}
function golink(id){
	window.location.href = 'forum.php?mod=post&action=newthread&fid=' + id + '&special=$special';
}
var s = '<!--{if $commonfids}--><p><a id="commonforum" href="javascript:;" onclick="switchforums(this, 1, \'common\')" class="pbsb lightlink">{lang nav_forum_frequently}</a></p><!--{/if}-->';
var lis = document.getElementById('fs_group').getElementsByTagName('LI');
for(i = 0;i < lis.length;i++) {
	var gid = lis[i].getAttribute('fid');
	if(document.getElementById('fs_forum_' + gid)) {
		s += '<p><a href="javascript:;" ondblclick="locationforums(1, ' + gid + ')" onclick="switchforums(this, 1, ' + gid + ')" class="pbsb">' + lis[i].innerHTML + '</a></p>';
	}

}
document.getElementById('block_group').innerHTML = s;
var lastswitchobj = null;
var selectfid = 0;
var switchforum = switchsubforum = '';

switchforums(document.getElementById('commonforum'), 1, 'common');

function switchforums(obj, block, fid) {
	if(lastswitchobj != obj) {
		if(lastswitchobj) {
			lastswitchobj.parentNode.className = '';
		}
		obj.parentNode.className = 'pbls';
	}
	var s = '';
	if(fid != 'common') {
		document.getElementById('enterbtn').className = 'xi2';
		currentblock = block;
		currentfid = fid;
	} else {
		document.getElementById('enterbtn').className = 'xg1';
	}
	if(block == 1) {
		var lis = document.getElementById('fs_forum_' + fid).getElementsByTagName('LI');
		for(i = 0;i < lis.length;i++) {
			fid = lis[i].getAttribute('fid');
			if(fid != '') {
				s += '<p><a href="javascript:;" ondblclick="locationforums(2, ' + fid + '\)" onclick="switchforums(this, 2, ' + fid + ')"' + ($('fs_subforum_' + fid) ?  ' class="pbsb"' : '') + '>' + lis[i].innerHTML + '</a></p>';
			}
		}
		document.getElementById('block_forum').innerHTML = s;
		document.getElementById('block_subforum').innerHTML = '';
		switchforum = switchsubforum = '';
		selectfid = 0;
		document.getElementById('postbtn').setAttribute("disabled", "disabled");
		document.getElementById('postbtn').className = 'pn xg1 y';
	} else if(block == 2) {
		selectfid = fid;
		if(document.getElementById('fs_subforum_' + fid)) {
			var lis = $('fs_subforum_' + fid).getElementsByTagName('LI');
			for(i = 0;i < lis.length;i++) {
				fid = lis[i].getAttribute('fid');
				s += '<p><a href="javascript:;" ondblclick="locationforums(3, ' + fid + ')" onclick="switchforums(this, 3, ' + fid + ')">' + lis[i].innerHTML + '</a></p>';
			}
			document.getElementById('block_subforum').innerHTML = s;
		} else {
			document.getElementById('block_subforum').innerHTML = '';
		}
		switchforum = obj.innerHTML;
		switchsubforum = '';
		document.getElementById('postbtn').removeAttribute("disabled");
		document.getElementById('postbtn').className = 'active';
	} else {
		selectfid = fid;
		switchsubforum = obj.innerHTML;
		document.getElementById('postbtn').removeAttribute("disabled");
		document.getElementById('postbtn').className = 'active';
	}
	lastswitchobj = obj;
	document.getElementById('pbnv').innerHTML = switchforum ? '&nbsp;&gt;&nbsp;' + switchforum + (switchsubforum ? '&nbsp;&gt;&nbsp;' + switchsubforum : '') : '';
}

function locationforums(block, fid) {
	location.href = block == 1 ? 'forum.php?gid=' + fid : 'forum.php?mod=forumdisplay&fid=' + fid;
}

</script>

<!--{template common/footer}-->
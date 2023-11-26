<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!--{subtemplate common/bgcolor}-->
<!-- header start -->
    <div class="header">
        <div class="nav">
            <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
			<span id="returnmessage5" class="name"><!--{if $at != 1}-->{lang invite_friend}<!--{/if}-->$invitename</span>
        </div>
    </div>

<!-- header end -->
		<div id="main_messaqge" class="ainuo_invitefriend cl">
			<div class="usd cl">
				<span class="y">{lang invite_still_choose}(<strong id="remainNum">20</strong>){lang unit}</span>
				<span id="showUser_1">{lang selected}(<strong id="selectNum">0</strong>)</span>
				<span id="showUser_2">{lang unselected}(<cite id="unSelectTab">0</cite>)</span>
			</div>
			<ul class="usl cl" id="friends"></ul>
<script>
var friend_page = 1;
var gid = -1;
var friend_exit = 0;
var friend_num = 0;
gid = isUndefined(gid) ? -1 : parseInt(gid);
do{
	$.ajax({
		type:'GET',
		url: 'home.php?mod=spacecp&ac=friend&op=getinviteuser&inajax=1&page='+ friend_page + '&gid=' + gid + '&at={$at}',
		dataType:'xml',
	})
	.success(function(s) {
		if(s.lastChild.firstChild.nodeValue.length){
			var friend_data = eval('('+ s.lastChild.firstChild.nodeValue +')');
			var singlenum = parseInt(friend_data['singlenum']);
			var maxfriendnum = parseInt(friend_data['maxfriendnum']);
			$('#unSelectTab').text(maxfriendnum);
			for(i in friend_data['userdata']) {
				$('#friends').append('<li uid="'+friend_data['userdata'][i]['uid']+'"><div class="friend_li"><a haref="javascript:;" class="nobg"><img src="uc_server/avatar.php?uid='+friend_data['userdata'][i]['uid']+'&size=middle">'+friend_data['userdata'][i]['username']+'</a></div></li>');
			}
			if(singlenum * friend_page >= maxfriendnum){
				$('#friends li').on('click', function() {
					friends_li = $(this);
					if(friends_li.attr('class') == 'liset'){
						$('#friends_' + friends_li.attr('uid')).remove();
						friends_li.removeClass('liset').find('a').removeClass('colorbg').addClass('nobg');
						friend_num--;
						$('#selectNum').text(parseInt($('#selectNum').text())-1);
						$('#remainNum').text(parseInt($('#remainNum').text())+1);
						$('#unSelectTab').text(parseInt($('#unSelectTab').text())+1);
					}else{
						if(friend_num >= 20){
							popup.open('$alang_twyfriend', 'alert');
							return false;
						}
						$('#inviteform').append('<input value="'+ friends_li.attr('uid') +'" name="uids[]" id="friends_'+ friends_li.attr('uid') +'" type="hidden">');
						friends_li.addClass('liset').find('a').removeClass('nobg').addClass('colorbg');
						friend_num++;
						$('#selectNum').text(parseInt($('#selectNum').text())+1);
						$('#remainNum').text(parseInt($('#remainNum').text())-1);
						$('#unSelectTab').text(parseInt($('#unSelectTab').text())-1);
					}
				});
				friend_exit = 1;
			}
			friend_page++;
		}else{
		friend_exit = 1;
		}
	})
	.error(function() {
		popup.open('$alang_dataerror', 'alert');
		friend_exit = 1;
	});
	} while(friend_exit);
		function succeedhandle_inviteform(a, b, c){
		if(b.indexOf("$alang_chenggong") > 0){
			popup.open(b, 'alert');
		}else{
			popup.open(b, 'alert');
	}
}
</script>
			<form method="post" autocomplete="off" name="invite" id="inviteform" action="misc.php?mod=invite&action=$_GET[action]&id=$id{if $_GET['activity']}&activity=1{/if}">
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<input type="hidden" name="referer" value="{echo dreferer()}" />
				<!--{if !empty($_G['inajax'])}--><input type="hidden" name="handlekey" value="$_GET['handlekey']" /><!--{/if}-->
				<div class="a_fqyq cl"><button type="submit" name="invitesubmit" value="yes">{lang invite_send}</button></div>
			</form>
		</div>
<!--{template common/footer}-->
<?PHP exit('QQÈº£º550494646');?>
{eval
	$_G['home_tpl_titles'] = array($blog['subject'], '{lang blog}');
	$_G['home_tpl_spacemenus'][] = "<a href=\"home.php?mod=space&uid=$space[uid]&do=$do&view=me\">{lang they_blog}</a>";
	$_G['home_tpl_spacemenus'][] = "<a href=\"home.php?mod=space&uid=$space[uid]&do=blog&id=$blog[blogid]\">{lang view_blog}</a>";
	$friendsname = array(1 => '{lang friendname_1}',2 => '{lang friendname_2}',3 => '{lang friendname_3}',4 => '{lang friendname_4}');
}
<!--{template common/header}-->

<!-- header start -->
<header class="header">
    <div class="nav">
        <!--{if $space[self]}-->
            <a href="home.php?mod=spacecp&ac=blog" class="y"><i class="iconfont icon-quillpenblack"></i></a>
        <!--{/if}-->
        <a href="#" class="z back"><i class="iconfont icon-back"></i></a>
        <span class="name">{$alang_view}{lang blog}</span>
    </div>
</header>
<!-- header end --><!--From www.moq u8 .com -->
	
	<div class="ainuo_blog_view cl">
		<div class="cl">
			<div class="cl">
				<div class="cl">
					<div class="acon1 cl">
						<div class="h">
							<h1 {if $blog[magiccolor]} style="color: {$_G[colorarray][$blog[magiccolor]]}"{/if}>
								$blog[subject]
								<!--{if $blog[status] == 1}-->
									<span class="xi1">({lang pending})</span>
								<!--{/if}-->
							</h1>
							<p class="ainfo cl">
								<!--{if $blog['friend']}-->
								<span class="y">{$friendsname[$blog[friend]]}</span>
								<!--{/if}-->
								<!--{if $blog[hot]}--><strong class="hot">{lang hot} <em>$blog[hot]</em></strong><!--{/if}-->
								<!--{if $blog['friend']}-->
								<span class="y"><a href="home.php?mod=space&uid=$space[uid]&do=$do&view=me&friend=$blog[friend]" class="xg1">{$friendsname[$value[friend]]}</a></span>
								<!--{/if}-->
								<!--{if $blog[viewnum]}--><span class="xg1">{lang have_read_blog}</span><!--{/if}-->
								<span class="xg1"><!--{date($blog[dateline])}--></span>
							<!--{if $blog[catname]}--><span class="pipe">|</span><span class="xg1">{lang system_cat}:<a href="home.php?mod=space&do=blog&view=all&catid=$blog[catid]">$blog[catname]</a></span><!--{/if}-->
							<!--{if $blog[tag]}-->
								<span class="pipe">|</span>
								<span class="ptg xg1">
									<!--{eval $tagi = 0;}-->
									<!--{loop $blog[tag] $var}-->
										<!--{if $tagi}-->, <!--{/if}--><a href="misc.php?mod=tag&id=$var[0]">$var[1]</a>
										<!--{eval $tagi++;}-->
									<!--{/loop}-->
								</span>
							<!--{/if}-->
		
							</p>

						</div>
		
						<div id="blog_article" class="d cl">
							<!--{ad/blog/a_b}-->
							$blog[message]
						</div>
						<!--{if $blog[friend] != 3 && !$blog[noreply]}-->
						<div id="click_div">
							<!--{template home/space_click}-->
						</div>
						<!--{/if}-->
                        <div class="o cl">
							<a href="home.php?mod=spacecp&ac=favorite&type=blog&id=$blog[blogid]&spaceuid=$blog[uid]&handlekey=favoritebloghk_{$blog[blogid]}" id="a_favorite" class="ainuo_nologin dialog">{lang favorite}</a>
							<!--{if helper_access::check_module('share') && 0}--><a href="home.php?mod=spacecp&ac=share&type=blog&id=$blog[blogid]&handlekey=sharebloghk_{$blog[blogid]}" id="a_share" class="ainuo_nologin dialog">{lang share}</a><!--{/if}-->
							<!--{if $_G[uid] == $blog[uid] || checkperm('manageblog')}-->
							<a href="home.php?mod=spacecp&ac=blog&blogid=$blog[blogid]&op=edit">{lang edit}</a>
							<a href="home.php?mod=spacecp&ac=blog&blogid=$blog[blogid]&op=delete&handlekey=delbloghk_{$blog[blogid]}" id="blog_delete_$blog[blogid]" class="dialog">{lang delete}</a>
							<!--{/if}-->
						</div>
                        <div class="grey_line cl"></div>
			
					</div>

					<div class="acon2 cl">
							<!--{if $otherlist}-->
							<div class="rizhilist cl">
								<h2><a href="home.php?mod=space&uid=$blog[uid]&do=blog&view=me">{lang all}</a>{lang author_newest_blog}</h2>
								<ul class="cl">
									<!--{loop $otherlist $value}-->
									<li><i class="iconfont icon-right"></i><a href="home.php?mod=space&uid=$value[uid]&do=blog&id=$value[blogid]">$value[subject]</a></li>
									<!--{/loop}-->
								</ul>
							</div>
                            <div class="grey_line cl"></div>
							<!--{/if}-->
							<!--{if $newlist}-->
                            
							<div class="rizhilist cl">
								<h2>{lang popular_blog_review}</h2>
								<ul class="cl">
									<!--{loop $newlist $value}-->
									<li><i class="iconfont icon-right"></i><a href="home.php?mod=space&uid=$value[uid]&do=blog&id=$value[blogid]">$value[subject]</a></li>
									<!--{/loop}-->
								</ul>
							</div>
                            <div class="grey_line cl"></div>
							<!--{/if}-->

						<div class="acon3 cl">
							<div id="div_main_content" class="cl">
								<h3 class="cl">
									
									{lang comment} (<span id="comment_replynum">$blog[replynum]</span> {lang blog_replay})
								</h3>
								<!--{if $cid}-->
								<div class="i">
									{lang current_blog_replay}<a href="home.php?mod=space&uid=$blog[uid]&do=blog&id=$blog[blogid]">{lang click_view_all}</a>
								</div>
								<!--{/if}-->
                                {if $list}
								<div id="comment_ul" class="xld xlda">
								<!--{loop $list $k $value}-->
									<!--{subtemplate home/space_comment_li}-->
								<!--{/loop}-->
								</div>
                                {else}
                                	<div class="emp cl"><i class="iconfont icon-empty"></i><p>$alang_replysofa</p></div>
                                {/if}
							</div>
							<!--{if $multi}--><div class="pgs cl mbm">$multi</div><!--{/if}-->
		
			
						<script type="text/javascript">
						function addFriendCall(){
							var el = $('friendinput');
							if(!el || el.value == "")	return;
							var s = '<input type="checkbox" name="fusername[]" class="pc" value="'+el.value+'" id="'+el.value+'" checked="checked">';
							s += '<label for="'+el.value+'">'+el.value+'</label>';
							s += '<br />';
							$('friendscall').innerHTML += s;
							el.value = '';
						}
						resizeImg('div_main_content','450');
			
						var elems = selector('dd[class~=magicflicker]');
						for(var i=0; i<elems.length; i++){
							magicColor(elems[i]);
						}
						</script>
			
						</div>
					</div>
		


					</div>
				</div>
		</div>
	</div>
<div class="cl" style="height:54px; width:100%"></div>
<div class="ainuo_viewblog_bottom cl">
	<!--{if !$blog[noreply] && helper_access::check_module('blog')}-->
        <form id="quickcommentform_{$id}" action="home.php?mod=spacecp&ac=comment" method="post" autocomplete="off" onsubmit="ajaxpost('quickcommentform_{$id}', 'return_qcblog_$id');doane(event);">
        	<div class="acon cl">
                <span id="comment_face" title="{lang insert_emoticons}" onclick="showFace(this.id, 'comment_message');return false;" class="cur1"><i class="iconfont icon-smile"></i></span>

                <div class="area">
					<textarea placeholder="$alang_xpinglun" id="comment_message" onkeydown="ctrlEnter(event, 'commentsubmit_btn');" name="message" class="ainuo_nologin px"></textarea>
                </div>

                <!--{if $secqaacheck || $seccodecheck}-->
                    <!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu(this.id);"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
                    <div class="mtm mbm sec"><!--{subtemplate common/seccheck}--></div>
                <!--{/if}-->
                <div class="bton">
                    <input type="hidden" name="referer" value="home.php?mod=space&uid=$blog[uid]&do=$do&id=$id" />
                    <input type="hidden" name="id" value="$id" />
                    <input type="hidden" name="idtype" value="blogid" />
                    <input type="hidden" name="handlekey" value="qcblog_{$id}" />
                    <input type="hidden" name="commentsubmit" value="true" />
                    <input type="hidden" name="quickcomment" value="true" />
                    <button type="submit" name="commentsubmit_btn"value="true" id="commentsubmit_btn" class="ainuo_nologin"{if !$_G[uid]&&!$_G['group']['allowcomment']} onclick="showWindow(this.id, this.form.action);return false;"{/if}>{lang comment}</button>
                    <span id="return_qcblog_{$id}"></span>
                </div>
            </div>
            <div id="ainuo_facemenu"></div>
            <input type="hidden" name="formhash" value="{FORMHASH}" />
        </form>
        <script type="text/javascript">
            function succeedhandle_qcblog_$id(url, msg, values) {
                if(values['cid']) {
                    comment_add(values['cid']);
                } else {
                    $('return_qcblog_{$id}').innerHTML = msg;
                }
                <!--{if $sechash}-->
                    <!--{if $secqaacheck}-->
                    updatesecqaa('$sechash');
                    <!--{/if}-->
                    <!--{if $seccodecheck}-->
                    updateseccode('$sechash');
                    <!--{/if}-->
                <!--{/if}-->
            }
        </script>
        <!--{/if}-->
</div>
<!--{if $_G['relatedlinks']}-->
	<script type="text/javascript">
		var relatedlink = [];
		<!--{loop $_G['relatedlinks'] $key $link}-->
		relatedlink[$key] = {'sname':'$link[name]', 'surl':'$link[url]'};
		<!--{/loop}-->
		relatedlinks('blog_article');
	</script>
<!--{/if}-->

<!--{if !empty($_G['cookie']['clearUserdata']) && $_G['cookie']['clearUserdata'] == 'home'}-->
	<script type="text/javascript">saveUserdata('home', '')</script>
<!--{/if}-->

<script>
function showFace(showid, target,dropstr) {
	<!--{if !$_G[uid]}-->
		popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
		return false;
	<!--{/if}-->
	if(document.getElementById(showid + '_menu') != null) {
		var smilemenucss = document.getElementById(showid+'_menu').style.display;
		if(smilemenucss == ''){
			document.getElementById(showid+'_menu').style.display = 'none';
			$("#comment_face i").css("color","#666");
		}else{
			document.getElementById(showid+'_menu').style.display = '';
			$("#comment_face i").css("color","#d43d3d");
		}
	} else {
		var faceDiv = document.createElement("div");
		faceDiv.id = showid+'_menu';
		faceDiv.className = 'ainuo_facemenu cl';
		var faceul = document.createElement("ul");
		for(i=1; i<31; i++) {
			var faceli = document.createElement("li");
			faceli.innerHTML = '<img src="' + SITEURL + 'static/image/smiley/comcom/'+i+'.gif" onclick="insertFace(\''+showid+'\','+i+', \''+ target +'\', \''+dropstr+'\')" style="cursor:pointer; position:relative;" />';
			faceul.appendChild(faceli);
		}
		faceDiv.appendChild(faceul);
		document.getElementById('ainuo_facemenu').appendChild(faceDiv);
		$("#comment_face i").css("color","#d43d3d");
	}
	_attachEvent(document.body, 'click', function(){if(document.getElementById(showid+'_menu')) document.getElementById(showid+'_menu').style.display = 'none';});
}
function insertFace(showid, id, target, dropstr) {
	var faceText = '[em:'+id+':]';
	if(document.getElementById(target) != null) {
		insertContent(target, faceText);
		if(dropstr) {
			document.getElementById(target).value = $(target).value.replace(dropstr, "");
		}
	}
}
function checkFocus(target) {
	var obj = document.getElementById(target);
	if(!obj.hasfocus) {
		obj.focus();
	}
}
function insertContent(target, text) {
	var obj = document.getElementById(target);
	selection = document.selection;
	checkFocus(target);
	if(!isUndefined(obj.selectionStart)) {
		var opn = obj.selectionStart + 0;
		obj.value = obj.value.substr(0, obj.selectionStart) + text + obj.value.substr(obj.selectionEnd);
	} else if(selection && selection.createRange) {
		var sel = selection.createRange();
		sel.text = text;
		sel.moveStart('character', -strlen(text));
	} else {
		obj.value += text;
	}
}
$('.ainuo_nologin').on('click', function() {
	<!--{if !$_G[uid]}-->
		popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
		return false;
	<!--{/if}-->
});
</script>

<!--{subtemplate common/footer}-->

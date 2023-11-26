<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<!--{if $op == 'delete'}-->

<div class="ainuo_pop cl">
	<div class="atit cl">{lang article_delete}</div>
<form method="post" autocomplete="off" action="portal.php?mod=portalcp&ac=article&op=delete&aid=$_GET[aid]">
	<div class="acon cl">
		<!--{if $_G['group']['allowpostarticlemod'] && $article['status'] == 1}-->
		{lang article_delete_sure}
		<input type="hidden" name="optype" value="0" class="pc" />
		<!--{else}-->
		<label class="lb"><input type="radio" name="optype" value="0" class="pc" />{lang article_delete_direct}</label>
		<label class="lb"><input type="radio" name="optype" value="1" class="pc" checked="checked" />{lang article_delete_recyclebin}</label>
		<!--{/if}-->
	</div>
    <div class="ainuo_popbottom cl">
        <button type="submit" name="btnsubmit" value="true" class="formdialog aconfirm">{lang confirms}</button>
        <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
    </div>
	<input type="hidden" name="aid" value="$_GET[aid]" />
	<input type="hidden" name="referer" value="{echo dreferer()}" />
	<input type="hidden" name="deletesubmit" value="true" />
	<input type="hidden" name="formhash" value="{FORMHASH}" />
</form>
</div>
<!--{elseif $op == 'verify'}--><!--From www.mo q u8 .com -->
<div class="ainuo_pop cl">
	<div class="atit cl">{lang moderate_article}</div>
<form method="post" autocomplete="off" id="aritcle_verify_$aid" action="portal.php?mod=portalcp&ac=article&op=verify&aid=$aid">
	<div class="acon cl">
		<label for="status_0" class="lb"><input type="radio" class="pr" name="status" value="0" id="status_0"{if $article[status]=='1'} checked="checked"{/if} />{lang passed}</label>
		<label for="status_x" class="lb"><input type="radio" class="pr" name="status" value="-1" id="status_x" />{lang delete}</label>
		<label for="status_2" class="lb"><input type="radio" class="pr" name="status" value="2" id="status_2"{if $article[status]=='2'} checked="checked"{/if} />{lang ignore}</label>
	</div>
    <div class="ainuo_popbottom cl">
        <button type="submit" name="btnsubmit" value="true" class="formdialog aconfirm">{lang confirms}</button>
        <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
    </div>
	<input type="hidden" name="aid" value="$aid" />
	<input type="hidden" name="referer" value="{echo dreferer()}" />
	<input type="hidden" name="handlekey" value="$_GET['handlekey']" />
	<input type="hidden" name="verifysubmit" value="true" />
	<input type="hidden" name="formhash" value="{FORMHASH}" />
</form>
</div>
<!--{elseif $op == 'related'}-->

	<!--{if $ra}-->
	<li id="raid_li_$ra[aid]"><input type="hidden" name="raids[]" value="$ra[aid]">[ $ra[aid] ] <a href="{echo fetch_article_url($ra);}" target="_blank">$ra[title]</a> <a href="javascript:;" onclick="raid_delete($ra[aid]);">{lang delete}</a></li>
	<!--{/if}-->

<!--{elseif $op == 'pushplus'}-->
<div class="ainuo_pop cl">
	<div class="atit cl">{lang article_pushplus}</div>
<form method="post" target="_blank" action="portal.php?mod=portalcp&ac=article&tid=$tid&aid=$aid">
	<div class="acon cl">
		<b>$pushcount</b> {lang portalcp_article_message1}<a href="$article_url" target="_blank" class="xi2">({lang view_article})</a>
		<!--{if $pushedcount}--><br />{lang portalcp_article_message2}<!--{/if}-->
		<div id="pushplus_list">
		<!--{loop $pids $pid}-->
		<input type="hidden" name="pushpluspids[]" value="$pid" />
		<!--{/loop}-->
		</div>
	</div>

    <div class="ainuo_popbottom cl">
    	<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="pushplussubmit" value="1" />
		<input type="hidden" name="toedit" value="1" />
        <button type="submit" class="formdialog aconfirm">{lang submit}</button>
        <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
    </div>
</form>
</div>
<!--{elseif $op == 'add_success'}-->
<div class="nfl">
	<div class="f_c altw">
		<div class="alert_right">
			<p>{lang article_send_succeed}</p>
			<p class="alert_btnleft">
				<a href="{$article_add_url}&op=edit&aid=$aid">{lang article_edit}</a>
				<span class="pipe">|</span>
				<a href="$article_add_url">{lang article_send_continue}</a>
				<span class="pipe">|</span>
				<a href="portal.php?mod=view&aid=$aid" target="_blank">{lang view_article}</a>
				<!--{if $htmlstatus}-->
					<span class="pipe">|</span>
					<span id='makehtml_' mktitle="{lang article}"></span>
				<!--{/if}-->
			</p>
		</div>
	</div>
</div>
<script src="{STATICURL}js/makehtml.js" type="text/javascript"></script>
<script type="text/javascript">
<!--{if !empty($_G['cookie']['clearUserdata']) && $_G['cookie']['clearUserdata'] == 'home'}-->
	saveUserdata('home', '')
<!--{/if}-->
make_html('portal.php?mod=view&aid={$aid}', $('makehtml_'));
</script>
<!--{else}-->
<!-- header start -->
    <div class="header">
        <div class="nav">
            <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
			<span class="name"><!--{if !empty($aid)}-->{lang article_edit}<!--{else}-->{lang article_publish}<!--{/if}--></span>
        </div>
    </div>
<!-- header end -->

<div class="ainuo_wz_fabu cl">
	<div class="cl">
			<script type="text/javascript" src="{$_G[setting][jspath]}calendar.js?{VERHASH}"></script>
            <div class="postform cl">
			<form method="post" autocomplete="off" id="articleform" action="portal.php?mod=portalcp&ac=article{if $_GET[modarticlekey]}&modarticlekey=$_GET[modarticlekey]{/if}" enctype="multipart/form-data">
				<!--{hook/portalcp_top}-->
				<div class="dopt cl">
                	<!--{if $_G['cache']['portalcategory'] && $categoryselect}-->
                	<div class="ftid">$categoryselect</div><script type="text/javascript">simulateSelect('catid', 158);</script>
                    <!--{/if}-->
					<input type="text" name="title" id="title" class="px" placeholder="{lang article_title}" value="$article[title]" />
					
					<input type="hidden" id="highlight_style_0" name="highlight_style[0]" value="$stylecheck[0]" />
					<input type="hidden" id="highlight_style_1" name="highlight_style[1]" value="$stylecheck[1]" />
					<input type="hidden" id="highlight_style_2" name="highlight_style[2]" value="$stylecheck[2]" />
					<input type="hidden" id="highlight_style_3" name="highlight_style[3]" value="$stylecheck[3]" />
					
				</div>
                
								
								
							
				<div id="htmlname_" class="dopt mtn cl"{if !$htmlstatus} style="display: none"{/if}>
					<span class="z" style="width: 80px;">HTML{lang filename}:</span>
					<input type="text" name="htmlname" id="htmlname" class="px" value="$article[htmlname]" onblur="check_htmlname_exists(this)"/>.{$_G['setting']['makehtml']['extendname']}
					<strong id="checkhtmlnamemsg"></strong>
					<input type="hidden" name="oldhtmlname" id="oldhtmlname" value="$article[htmlname]" />
				</div>
				<div id="pagetitle_" class="dopt mtn cl"{if $article[contents] < 2} style="display: none"{/if}>
					<span class="z mtn" style="width: 80px;">{lang page_title}:&nbsp;</span>
					<input type="text" name="pagetitle" id="pagetitle" class="px" value="$article_content[title]" />
				</div>

				<div class="exfm pns cl">

					<div><input type="hidden" id="conver" name="conver" value="" /></div>
					
					<!--{hook/portalcp_extend}-->
				</div>

				<div class="pbw">
					<script type="text/javascript" language="javascript" src="{STATICURL}image/editor/editor_function.js?{VERHASH}"></script>
					<!--{subtemplate home/editor_image_menu}-->
					<textarea class="userData" name="content" id="uchome-ttHtmlEditor" style="height: 100%; width: 100%; display: none; border: 0px">$article_content[content]</textarea>
					<div style="border:1px solid #C5C5C5;height:400px;"><iframe src="home.php?mod=editor&charset={CHARSET}&allowhtml=1&isportal=1" name="uchome-ifrHtmlEditor" id="uchome-ifrHtmlEditor" scrolling="no" border="0" frameborder="0" style="width:100%;height:100%;position:relative;"></iframe></div>
				</div>

				<!--{hook/portalcp_middle}-->

				<!--{hook/portalcp_bottom}-->

				<!--{if $secqaacheck || $seccodecheck}-->
					<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu(this.id)"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
					<div class="exfm pns"><!--{subtemplate common/seccheck}--></div>
				<!--{/if}-->

				<div class="ptm pbm">
					<button type="button" id="issuance" name="articlebutton" type="submit">{lang submit}</button>
					<label id="innernavele"{if $article[contents] < 2} style="display: none"{/if} for="ck_showinnernav"><input type="checkbox" name="showinnernav" id="ck_showinnernav" class="pc" value="1"{if !empty($article['showinnernav'])}checked="checked"{/if} />{lang article_show_inner_navigation}</label>
				</div>

				<input type="hidden" id="aid" name="aid" value="$article[aid]" />
				<input type="hidden" name="cid" value="$article_content[cid]" />
				<input type="hidden" id="attach_ids" name="attach_ids" value="0" />
				<input type="hidden" name="articlesubmit" value="true" />
				<input type="hidden" name="formhash" value="{FORMHASH}" />
			</form>
		</div>
	</div>
</div>
<iframe id="uploadframe" name="uploadframe" width="0" height="0" marginwidth="0" frameborder="0" src="about:blank"></iframe>
<script type="text/javascript">
function from_get() {
	var el = $('catid');
	var catid = el ? el.value : 0;
	window.location.href='portal.php?mod=portalcp&ac=article&from_idtype='+$('from_idtype').value+'&catid='+catid+'&from_id='+$('from_id').value+'&getauthorall='+($('getauthorall').checked ? '1' : '');
	return true;
}
function validate(obj) {
	var title = document.getElementById('title');
	if(title) {
		var slen = strlen(title.value);
		if (slen < 1 || slen > 80) {
			alert("{lang article_validate_title}");
			title.focus();
			return false;
		}
	}
	if(!check_catid()) {
		return false;
	}
	edit_save();
	window.onbeforeunload = null;
	obj.form.submit();
	return false;
}
function check_catid(){
	var catObj = document.getElementById("catid");
	if(catObj) {
		if (catObj.value < 1) {
			alert("{lang article_validate_category}");
			catObj.focus();
			return false;
		}
	}
	return true;
}
function raid_add() {
	var raid = document.getElementById('raid').value;
	if($('raid_li_'+raid)) {
		alert('{lang article_validate_has_added}');
		return false;
	}
	var url = 'portal.php?mod=portalcp&ac=article&op=related&inajax=1&aid={$article[aid]}&raid='+raid;
	var x = new Ajax();
	x.get(url, function(s){
		s = trim(s);
		if(s) {
			document.getElementById('raid_div').innerHTML += s;
		} else {
			alert('{lang article_validate_noexist}');
			return false;
		}
	});
}
function raid_delete(aid) {
	var node = document.getElementById('raid_li_'+aid);
	var p;
	if(p = node.parentNode) {
		p.removeChild(node);
	}
}
function switchhl(obj, v) {
	if(parseInt($('highlight_style_' + v).value)) {
		$('highlight_style_' + v).value = 0;
		obj.className = obj.className.replace(/ cnt/, '');
	} else {
		$('highlight_style_' + v).value = 1;
		obj.className += ' cnt';
	}
}
function change_title_color(hlid) {
	var showid = hlid;
	if(!$(showid + '_menu')) {
		var str = '';
		var coloroptions = {'0' : '#000', '1' : '#EE1B2E', '2' : '#EE5023', '3' : '#996600', '4' : '#3C9D40', '5' : '#2897C5', '6' : '#2B65B7', '7' : '#8F2A90', '8' : '#EC1282'};
		var menu = document.createElement('div');
		menu.id = showid + '_menu';
		menu.className = 'cmen';
		menu.style.display = 'none';
		for(var i in coloroptions) {
			str += '<a href="javascript:;" onclick="$(\'highlight_style_0\').value=\'' + coloroptions[i] + '\';$(\'' + showid + '\').style.backgroundColor=\'' + coloroptions[i] + '\';hideMenu(\'' + menu.id + '\')" style="background:' + coloroptions[i] + ';color:' + coloroptions[i] + ';">' + coloroptions[i] + '</a>';
		}
		menu.innerHTML = str;
		$('append_parent').appendChild(menu);
	}
	showMenu({'ctrlid':hlid + '_ctrl','evt':'click','showid':showid});
}
if($('title')) {
	$('title').focus();
}
function setConver(attach) {
	$('conver').value = attach;
}

function deleteAttach(attachid, url) {
	ajaxget(url);
	$('attach_list_' + attachid).style.display = 'none';
	if($('setconver' + attachid).checked) {
		$('conver').value = '';
	}
}
<!--{if !empty($article['conver'])}-->
setConver('$article[conver]');
<!--{/if}-->
function check_htmlname_exists(obj) {
	name = obj.value;
	var msg = $('checkhtmlnamemsg');
	if(name && $('oldhtmlname').value != name) {
		var catid = $('catid').value;
		var aid = $('aid').value;
		var x = new Ajax();
		x.getJSON('portal.php?mod=portalcp&ac=article&op=checkhtmlname&htmlname='+name+'&catid='+catid+'&aid='+aid, function(s){
			if(s['message'] == 'html_existed') {
				obj.focus();
				msg.style.color = 'red';
				msg.style.paddingLeft = '10px';
				msg.innerHTML = '{lang article_html_existed}';
				$('issuance').disabled = 'disabled';
			} else {
				msg.innerHTML = '';
				$('issuance').disabled = '';
			}
		});
	} else {
		msg.innerHTML = '';
		$('issuance').disabled = '';
	}
}
</script>

<!--{/if}-->

<!--{template common/footer}-->

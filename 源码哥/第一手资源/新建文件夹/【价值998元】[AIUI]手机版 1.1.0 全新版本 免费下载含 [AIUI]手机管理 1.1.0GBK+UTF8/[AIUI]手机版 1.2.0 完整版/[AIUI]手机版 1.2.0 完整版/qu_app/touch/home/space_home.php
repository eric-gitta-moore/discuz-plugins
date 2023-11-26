<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!--{if $space[uid] == $_G[uid]}-->
	<header class="header">
        <div class="nav">    
            <a href="#" class="z back"><i class="iconfont icon-back"></i></a>
            <span class="name">{lang feed}</span>
        </div>
    </header>
    <div class="ainuo_usertb cl">
        <ul class="tb arizhi cl">
            <li$actives[me]><a href="home.php?mod=space&do=home&view=me">{lang my_feed}</a></li>
            <li$actives[we]><a href="home.php?mod=space&do=home&view=we">{lang friend_feed}</a></li>
            <li$actives[all]><a href="home.php?mod=space&do=home&view=all">{lang view_all}</a></li>
        </ul>
    </div>
    <!--{if !$list && !$feed_users}-->
    <div class="grey_line cl"></div>
    <!--{/if}-->
    <div class="ainuo_uhome cl">
<!--{else}-->
<!--{subtemplate common/usertop}-->
<!--{subtemplate common/usernav}-->
<div class="ainuo_uhome cl" style="margin-top:-12px;">
<!--{/if}--> 

	<div class="ainuo_uhome cl">

		<div class="cl">
        	<div class="cl">
            	<div class="cl">



			<div id="feed_div" class="e cl">
			<!--{if $hotlist}-->
				<h4 class="et"><a href="home.php?mod=space&do=home&view=all&order=hot" class="y xw0" style="font-size:12px; display:none; color:#999; font-weight:400;">{lang view_more_hot} <em>&rsaquo;</em></a><span>{lang recent_recommended_hot}</span></h4>
				<ul class="el">
				<!--{loop $hotlist $value}-->
				<!--{eval $value = mkfeed($value);}-->
				<!--{template home/space_feed_li}-->
				<!--{/loop}-->
				</ul>
			<!--{/if}-->

			<!--{if $list}-->

					<!--{loop $list $day $values}-->
						<!--{if $_GET['view']!='hot'}-->
							<h4 class="et">
								<span><!--{if $day=='yesterday'}-->{lang yesterday}<!--{elseif $day=='today'}-->{lang today}<!--{else}-->$day<!--{/if}--></span>
							</h4>
						<!--{/if}-->

						<ul class="el">
						<!--{loop $values $value}-->
							<!--{template home/space_feed_li}-->
						<!--{/loop}-->
						</ul>
					<!--{/loop}-->

			<!--{elseif $feed_users}-->
				<div class="xld xlda">
				<!--{loop $feed_users $day $users}-->
				<h4 class="et">
					<span><!--{if $day=='yesterday'}-->{lang yesterday}<!--{elseif $day=='today'}-->{lang today}<!--{else}-->$day<!--{/if}--></span>
				</h4>
				<!--{loop $users $user}-->
				<!--{eval $daylist = $feed_list[$day][$user[uid]];}-->
				<!--{eval $morelist = $more_list[$day][$user[uid]];}-->
				<dl class="bbda cl">
					<dd class="cl">
						<ul class="el">
						<!--{loop $daylist $value}-->
							<!--{template home/space_feed_li}-->
						<!--{/loop}-->
						</ul>

						<!--{if $morelist}-->
						<div id="feed_more_div_{$day}_{$user[uid]}">
							<ul class="el">
							<!--{loop $morelist $value}-->
								<!--{template home/space_feed_li}-->
							<!--{/loop}-->
							</ul>
						</div>
						<!--{/if}-->
					</dd>
				</dl>
				<!--{/loop}-->
				<!--{/loop}-->
				</div>
			<!--{else}-->
                <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p><!--{if $_GET[view] == 'app' && $_G['setting']['my_app_status']}-->{lang no_app_feed}<!--{else}-->{lang no_feed}<!--{/if}--></p></div>
			<!--{/if}-->

			<!--{if $filtercount}-->
				<div class="i" id="feed_filter_notice_{$start}">
					{lang depending_your}<a href="home.php?mod=spacecp&ac=privacy&op=filter" target="_blank" class="xi2 xw1">{lang filter_settings}</a>,{lang shield_feed_message} (<a href="javascript:;" onclick="filter_more($start);" id="a_feed_privacy_more" class="xi2">{lang click_view}</a>)
				</div>
				<div id="feed_filter_div_{$start}" style="display:none;">
					<h4 class="et">{lang following_feed_shielding}</h4>
					<ul class="el">
					<!--{loop $filter_list $value}-->
					<!--{template home/space_feed_li}-->
					<!--{/loop}-->
					<li><a href="javascript:;" onclick="filter_more($start);">&laquo; {lang pack_up}</a></li>
					</ul>
				</div>
			<!--{/if}-->

			</div>
			<!--/id=feed_div-->
            <!--{if $multi}-->
				<div class="pgs cl mtm">$multi</div>
			<!--{/if}-->


			</div>
		</div>
</div>


<!--{eval helper_manyou::checkupdate();}-->

<script type="text/javascript">
	function filter_more(id) {
		if(document.getElementById('feed_filter_div_'+id).style.display == '') {
			document.getElementById('feed_filter_div_'+id).style.display = 'none';
			document.getElementById('feed_filter_notice_'+id).style.display = '';
		} else {
			document.getElementById('feed_filter_div_'+id).style.display = '';
			document.getElementById('feed_filter_notice_'+id).style.display = 'none';
		}
	}

	function close_feedbox() {
		var x = new Ajax();
		x.get('home.php?mod=spacecp&ac=common&op=closefeedbox', function(s){
			document.getElementById('feed_box').style.display = 'none';
		});
	}
	function selector(pattern, context) {
		var re = new RegExp('([a-z0-9]*)([\.#:]*)(.*|$)', 'ig');
		var match = re.exec(pattern);
		var conditions = cc = [];
		if (match[2] == '#')	conditions.push(['id', '=', match[3]]);
		else if(match[2] == '.')	conditions.push(['className', '~=', match[3]]);
		else if(match[2] == ':')	conditions.push(['type', '=', match[3]]);
		var s = match[3].replace(/\[(.*)\]/g,'$1').split('@');
		for(var i=0; i<s.length; i++) {
			if (cc = /([\w]+)([=^%!$~]+)(.*)$/.exec(s[i]))
				conditions.push([cc[1], cc[2], cc[3]]);
		}
		var list = conditions[0] && conditions[0][0] == 'id' ? [document.getElementById(conditions[0][2])] : document.getElementsByTagName(match[1] || "*");
		if(!list || !list.length)	return [];
		if(conditions) {
			var elements = [];
			var attrMapping = {'for': 'htmlFor', 'class': 'className'};
			for(var i=0; i<list.length; i++) {
				var pass = true;
				for(var j=0; j<conditions.length; j++) {
					var attr = attrMapping[conditions[j][0]] || conditions[j][0];
					var val = list[i][attr] || (list[i].getAttribute ? list[i].getAttribute(attr) : '');
					var pattern = null;
					if(conditions[j][1] == '=') {
						pattern = new RegExp('^'+conditions[j][2]+'$', 'i');
					} else if(conditions[j][1] == '^=') {
						pattern = new RegExp('^' + conditions[j][2], 'i');
					} else if(conditions[j][1] == '$=') {
						pattern = new RegExp(conditions[j][2] + '$', 'i');
					} else if(conditions[j][1] == '%=') {
						pattern = new RegExp(conditions[j][2], 'i');
					} else if(conditions[j][1] == '~=') {
						pattern = new RegExp('(^|[ ])' + conditions[j][2] + '([ ]|$)', 'i');
					}
					if(pattern && !pattern.test(val)) {
						pass = false;
						break;
					}
				}
				if(pass) elements.push(list[i]);
			}
			return elements;
		} else {
			return list;
		}
	}

	function showmore(day, uid, e) {
		var obj = 'feed_more_div_'+day+'_'+uid;
		document.getElementById(obj).style.display = document.getElementById(obj).style.display == ''?'none':'';
		if(e.className == 'unfold'){
			e.innerHTML = '{lang pack_up}';
			e.className = 'fold';
		} else if(e.className == 'fold') {
			e.innerHTML = '{lang open}';
			e.className = 'unfold';
		}
	}

	var elems = selector('li[class~=magicthunder]', $('feed_div'));
	for(var i=0; i<elems.length; i++){
		magicColor(elems[i]);
	}

	function showEditAvt(id) {
		document.getElementById(id).style.display = $(id).style.display == '' ? 'block' : '';
	}
/*	if($('edit_avt') && BROWSER.ie && BROWSER.ie == 6) {
		_attachEvent($('edit_avt'), 'mouseover', function () { showEditAvt('edit_avt_tar'); });
		_attachEvent($('edit_avt'), 'mouseout', function () { showEditAvt('edit_avt_tar'); });
	}*/
</script>
<script>
	function modifyTarget(){
		var aN = document.getElementById("feed_div").getElementsByTagName("a");
		for(var i =0; i < aN.length; i++){
		aN[i].target ="_self";
		}
	}
	modifyTarget();
</script>
<!--{subtemplate common/userbottom}-->
<!--{template common/footer}-->
<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<!--{if $_G['inajax'] == 1}-->
	<!--{eval require_once(DISCUZ_ROOT."./template/qu_app/touch/ainuo/config.php");}-->
	<!--{template forumlist/select}-->
	<!--{if in_array($_G['fid'], $ainuo_array_newslist)}-->
        <!--{template forumlist/news_list}-->
    <!--{elseif in_array($_G['fid'], $ainuo_array_quanlist)}-->
        <!--{template forumlist/quan_list}-->
    <!--{elseif in_array($_G['fid'], $ainuo_array_tuwenlist)}-->
        <!--{template forumlist/tuwen_list}-->
    <!--{elseif in_array($_G['fid'], $ainuo_array_qqzonelist)}-->
        <!--{template forumlist/qqzone_list}-->
    <!--{elseif in_array($_G['fid'], $ainuo_array_weibolist)}-->
        <!--{template forumlist/weibo_list}-->
    <!--{elseif in_array($_G['fid'], $ainuo_array_bigpiclist)}-->
        <!--{template forumlist/bigpic_list}-->
    <!--{elseif in_array($_G['fid'], $ainuo_array_pbllist)}-->
        <!--{template forumlist/pbl_list}-->
    <!--{elseif in_array($_G['fid'], $ainuo_array_videolist)}-->
        <!--{template forumlist/video_list}-->
    <!--{elseif in_array($_G['fid'], $ainuo_array_musiclist)}-->
        <!--{template forumlist/music_list}-->
    <!--{elseif in_array($_G['fid'], $ainuo_array_tradelist)}-->
        <!--{template forumlist/trade_list}-->
    <!--{elseif in_array($_G['fid'], $ainuo_array_polllist)}-->
        <!--{template forumlist/poll_list}-->
    <!--{elseif in_array($_G['fid'], $ainuo_array_activitylist)}-->
        <!--{template forumlist/activity_list}-->
    <!--{elseif in_array($_G['fid'], $ainuo_array_debatelist)}-->
        <!--{template forumlist/debate_list}-->
    <!--{elseif in_array($_G['fid'], $ainuo_array_rewardlist)}-->
        <!--{template forumlist/reward_list}-->
    <!--{elseif in_array($_G['fid'], $ainuo_array_zhinenglist)}-->
        <!--{template forumlist/zhineng_list}-->
    <!--{elseif $_G['forum']['sortmode']}-->
        $sorttemplate['body']
    <!--{else}-->
        <!--{template forumlist/word_list}-->
    <!--{/if}-->
<!--{else}-->

<!--{if $_G['forum']['sortmode']}-->
<link href="template/qu_app/touch/style/css/sort.css?{VERHASH}" rel="stylesheet"/>
<!--{/if}-->

<script>
var sharetitle = '$_G[forum][name] - $_G[setting][bbname]';
var sharedesc = '$_G[forum][description]';
var sharelink = SITEURL + 'forum.php?mod=forumdisplay&fid=$_G[fid]';
var shareicon = SITEURL + 'data/attachment/common/$_G[forum][icon]';
</script>
<!--{subtemplate forumlist/select}-->
<!--{if in_array($_G['fid'], $ainuo_array_newslist)}-->
	<!--{subtemplate forumlist/news}-->
<!--{elseif in_array($_G['fid'], $ainuo_array_quanlist)}-->
	<!--{subtemplate forumlist/quan}-->
<!--{elseif in_array($_G['fid'], $ainuo_array_tuwenlist)}-->
	<!--{subtemplate forumlist/tuwen}-->
<!--{elseif in_array($_G['fid'], $ainuo_array_qqzonelist)}-->
	<!--{subtemplate forumlist/qqzone}-->
<!--{elseif in_array($_G['fid'], $ainuo_array_weibolist)}-->
	<!--{subtemplate forumlist/weibo}-->
<!--{elseif in_array($_G['fid'], $ainuo_array_bigpiclist)}-->
	<!--{subtemplate forumlist/bigpic}-->
<!--{elseif in_array($_G['fid'], $ainuo_array_pbllist)}-->
	<!--{subtemplate forumlist/pbl}-->
<!--{elseif in_array($_G['fid'], $ainuo_array_videolist)}-->
	<!--{subtemplate forumlist/video}-->
<!--{elseif in_array($_G['fid'], $ainuo_array_musiclist)}-->
	<!--{subtemplate forumlist/music}-->
<!--{elseif in_array($_G['fid'], $ainuo_array_tradelist)}-->
	<!--{subtemplate forumlist/trade}-->
<!--{elseif in_array($_G['fid'], $ainuo_array_polllist)}-->
	<!--{subtemplate forumlist/poll}-->
<!--{elseif in_array($_G['fid'], $ainuo_array_activitylist)}-->
	<!--{subtemplate forumlist/activity}-->
<!--{elseif in_array($_G['fid'], $ainuo_array_debatelist)}-->
	<!--{subtemplate forumlist/debate}-->
<!--{elseif in_array($_G['fid'], $ainuo_array_rewardlist)}-->
	<!--{subtemplate forumlist/reward}-->
<!--{elseif in_array($_G['fid'], $ainuo_array_zhinenglist)}-->
	<!--{subtemplate forumlist/zhineng}-->
<!--{else}-->
	<!--{subtemplate forumlist/word}-->
<!--{/if}-->
<!--{hook/forumdisplay_bottom_mobile}-->


<!--{subtemplate common/sharef}-->

<script type="text/javascript">
	$('.afa_fav').on('click', function() {
		<!--{if !$_G[uid]}-->
			popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
			return false;
		<!--{/if}-->
		Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
		var obj = $(this);
		$.ajax({
			type:'POST',
			url:obj.attr('ainuoto') + '&handlekey=favbtn&inajax=1',
			data:{'favoritesubmit':'true', 'formhash':'{FORMHASH}'},
			dataType:'xml',
		})
		.success(function(s) {
			if(s.lastChild.firstChild.nodeValue.indexOf("$alang_haveshoucang") >= 0){
				Zepto('.ainuooverlay').remove();
				Zepto.toast('$alang_haveshoucang2',1000,'toast');
			}else if(s.lastChild.firstChild.nodeValue.indexOf("$alang_havescsucccess") >= 0){
				document.getElementById("a_favorite").innerHTML = '$alang_yiguanzhu';
				Zepto('.ainuooverlay').remove();
				Zepto.toast('$alang_guanzhusuc',1000,'toast');
			}
		})
		.error(function() {
			window.location.href = obj.attr('href');
			Zepto('.ainuooverlay').remove();
		});
		return false;
	});
</script>
<!--{if in_array($_G['fid'], $ainuo_array_pbllist)}-->
<script>
(function(exports){

  function minigrid(containerSelector, itemSelector, gutter, animate, done) {
    var forEach = Array.prototype.forEach;
    var containerEle = document.querySelector(containerSelector);
    var itemsNodeList = document.querySelectorAll(itemSelector);
    gutter = gutter || 2;
    
	if(containerEle){
		containerEle.style.width = '';
    	var containerWidth = containerEle.getBoundingClientRect().width;
	}
	if(itemsNodeList){
		var firstChildWidth = itemsNodeList[0].getBoundingClientRect().width + gutter;
	}
    var cols = Math.max(Math.floor((containerWidth - gutter) / firstChildWidth), 1);
    var count = 0;
    containerWidth = (firstChildWidth * cols + gutter) + 'px';
    containerEle.style.width = containerWidth;
    
    for (var itemsGutter = [], itemsPosX = [], g = 0; g < cols; g++) {
      itemsPosX.push(g * firstChildWidth + gutter);
      itemsGutter.push(gutter);
    }

    forEach.call(itemsNodeList, function(item){
      var itemIndex = itemsGutter.slice(0).sort(function (a, b) {
        return a - b;
      }).shift();
      itemIndex = itemsGutter.indexOf(itemIndex);
      var posX = itemsPosX[itemIndex];
      var posY = itemsGutter[itemIndex];
      var transformProps = [
        'webkitTransform', 
        'MozTransform', 
        'msTransform',
        'OTransform', 
        'transform'
      ];
      if (!animate) {
        forEach.call(transformProps, function(transform){
          item.style[transform] = 'translate(' + posX + 'px,' + posY + 'px)';
        });  
      }
      itemsGutter[itemIndex] += item.getBoundingClientRect().height + gutter;
      count = count + 1;
      if (animate) {
        return animate(item, posX, posY, count);
      }
    });

    var containerHeight = itemsGutter.slice(0).sort(function (a, b) {
      return a - b;
    }).pop();

    containerEle.style.height = containerHeight + 'px';

    if (typeof done === 'function'){
      done();
    }
  }

  if (typeof define === 'function' && define.amd) {
    define(function() { return minigrid; });
  } else if (typeof module !== 'undefined' && module.exports) {
    module.exports = minigrid;
  } else {
    exports.minigrid = minigrid;
  }

})(this);
</script>
<!--{/if}-->

<script>
	var ainuo_forum_html = '';
	var ainuo_forum_empty = '<div class="inner">$alang_nomore</div>';
	var ainuo_forum_emptyfail = '<div class="inner">$alang_loadfail</div>';				
	var ainuo_forum_loading = false;
	var ainuo_forum_aperpage = '$_G[tpp]';
	var ainuo_forum_ainuomaxpage = $maxpage;
	var ainuo_forum_url = 'forum.php?mod=forumdisplay&fid={$_G[fid]}&filter={$_GET[filter]}&typeid={$_GET[typeid]}&orderby={$_GET[orderby]}&page=';
</script>
<!--{/if}-->

<!--{template common/footer}-->

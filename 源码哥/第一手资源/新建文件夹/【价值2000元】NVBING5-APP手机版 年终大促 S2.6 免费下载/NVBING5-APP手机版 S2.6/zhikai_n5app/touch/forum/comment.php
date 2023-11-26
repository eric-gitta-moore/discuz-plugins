<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./template/zhikai_n5app/lang.php';}-->
<div class="n5sq_dpys cl">
<form class="n5sq_lcdp" method="post" autocomplete="off" id="commentform" action="forum.php?mod=post&action=reply&comment=yes&tid=$post[tid]&pid=$_GET[pid]&extra=$extra{if !empty($_GET[page])}&page=$_GET[page]{/if}&commentsubmit=yes&infloat=yes" onsubmit="{if !empty($_GET['infloat'])}ajaxpost('commentform', 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;{/if}">
	<div class="f_c">
		<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
		<input type="hidden" name="handlekey" value="$_GET['handlekey']" />
			<div class="tedt"><!--From www.xhkj5.com-->
				<textarea rows="2" cols="50" name="message" id="commentmessage" onKeyUp="strLenCalc(this, 'checklen')" onKeyDown="seditor_ctlent(event, '$(\'commentsubmit\').click();')" tabindex="2" class="pt" style="overflow: auto"></textarea>
				<script type="text/javascript" reload="1">
				<!--{if $commentitem}-->
					var items = itemrow = itemcmm = '';
					<!--{eval $items = range(0, 5);$itemlang = array('{lang comment_1}', '{lang comment_2}', '{lang comment_3}', '{lang comment_4}', '{lang comment_5}', '{lang comment_6}');$i = $cmm = 0;}-->
					<!--{loop $commentitem $item}-->
						<!--{eval $item = trim($item);}-->
						<!--{if $item}-->
							items += '<input type="hidden" id="itemc_$i" name="commentitem[$item]" value="" />';
							itemrow = '<span id="itemt_$i" class="z xg1 cur1" title="{lang comment_give_ip}" onclick="itemdisable($i)">&nbsp;$item</span>';
							itemstar = '';
							<!--{loop $items $j}-->
							itemstar += '<em onclick="itemclk($i, $j)" onmouseover="itemop($i, $j)" onmouseout="itemset($i)" title="$itemlang[$j]($j)"{if !$j} style="width: 10px;"{/if}>$itemlang[$j]</em>';
							<!--{/loop}-->
							itemrow += '<span id="item_$i" class="z cmstar">' + itemstar + '</span>';
							<!--{eval $i++;}-->
							<!--{if !$cmm}-->items += itemrow;<!--{else}-->itemcmm += '<div class="cl cmm" style="margin:5px">' + itemrow + '</div>';<!--{/if}-->
						<!--{elseif !$cmm}-->
							items += '<span class="z" id="itemmore" onmouseover="showMenu({\'ctrlid\':this.id,\'pos\':\'13\'})">&nbsp;&raquo; {lang more}</span>';
							<!--{eval $cmm = 1;}-->
						<!--{/if}-->
					<!--{/loop}-->
					$('itemdiv').innerHTML = items;
					if(itemcmm) {
						cmmdiv = document.createElement('div');
						cmmdiv.id = 'itemmore_menu';
						cmmdiv.style.display = 'none';
						cmmdiv.className = 'p_pop';
						cmmdiv.innerHTML = itemcmm;
						$('append_parent').appendChild(cmmdiv);
					}
				<!--{/if}-->
				$('commentmessage').focus();
				</script>
			</div>
	</div>
	<!--{if $_GET[action] != 'edit' && ($secqaacheck || $seccodecheck)}-->
		<style type="text/css">
		.n5sq_ftyzm {background:#fff;padding:6px;border-top: 1px solid #EEEEEE;}
		.n5sq_ftyzm .txt {width: 50%;background: #fff;border: 0;font-size: 15px;border-radius: 0;outline: none;-webkit-appearance: none;padding: 0;line-height: 23px;}
		.n5sq_ftyzm img {height: 25px;float: right;}
		</style><!--F rom www.xhkj 5.com-->
		<!--{subtemplate common/seccheck}-->
	<!--{/if}-->
	<div class="o pns cl{if empty($_GET['infloat'])} mtm{/if}">
		<button type="submit" id="commentsubmit" class="pn pnc z" value="true" name="commentsubmit" tabindex="3"{if !$seccodecheck} onmouseover="checkpostrule('seccheck_comment', 'ac=reply&infloat=yes&handlekey=$_GET[handlekey]');this.onmouseover=null"{/if}>{lang publish}</button>
		<a href="javascript:;" onclick="popup.close();" class="z">{$n5app['lang']['sqbzssmqx']}</a>
	</div>
</form>
</div>
<!--{template common/footer}-->
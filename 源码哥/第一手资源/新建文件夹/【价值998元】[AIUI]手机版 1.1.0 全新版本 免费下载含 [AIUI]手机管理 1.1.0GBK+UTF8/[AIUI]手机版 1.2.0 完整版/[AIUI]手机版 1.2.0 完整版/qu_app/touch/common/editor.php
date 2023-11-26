<?PHP exit('QQÈº£º550494646');?>
<link rel="stylesheet" href="{$_G['siteurl']}template/qu_app/touch/style/css/editor.css" type="text/css">
<script type="text/javascript" src="{$_G['siteurl']}template/qu_app/touch/style/js/post/editor.js"></script>
<script type="text/javascript" src="{STATICURL}js/bbcode.js"></script>
<script type="text/javascript" src="{STATICURL}js/common_postimg.js?{VERHASH}"></script>
<script type="text/javascript">
	var editorid = '$editorid';
	var textobj = $(editorid + '_textarea');
	var wysiwyg = (BROWSER.ie || BROWSER.firefox || (BROWSER.opera >= 9)) && parseInt('$editor[editormode]') == 1 ? 1 : 0;
	var allowswitcheditor = parseInt('$editor[allowswitcheditor]');
	var allowhtml = parseInt('$editor[allowhtml]');
	var allowsmilies = parseInt('$editor[allowsmilies]');
	var allowbbcode = parseInt('$editor[allowbbcode]');
	var allowimgcode = parseInt('$editor[allowimgcode]');
	var simplodemode = parseInt('<!--{if $editor[simplemode] > 0}-->1<!--{else}-->0<!--{/if}-->');
	var fontoptions = new Array({lang e_fontoptions});
	var smcols = $_G['setting']['smcols'];
	var custombbcodes = new Array();
	<!--{if $_G['cache']['bbcodes_display'][$_G['groupid']]}-->
		<!--{loop $_G['cache']['bbcodes_display'][$_G['groupid']] $tag $bbcode}-->
			custombbcodes["$tag"] = {'prompt' : '$bbcode[prompt]'};
		<!--{/loop}-->
	<!--{/if}-->
</script>

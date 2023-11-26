<?PHP exit('QQÈº£º550494646');?>
<!--{hook/global_footer_mobile}-->
<!--{hook/global_ainuofooter_mobile}-->

<!--{eval $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);$clienturl = ''}-->
<!--{if strpos($useragent, 'iphone') !== false || strpos($useragent, 'ios') !== false}-->
<!--{eval $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=ios' : 'http://www.discuz.net/mobile.php?platform=ios';}-->
<!--{elseif strpos($useragent, 'android') !== false}-->
<!--{eval $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=android' : 'http://www.discuz.net/mobile.php?platform=android';}-->
<!--{elseif strpos($useragent, 'windows phone') !== false}-->
<!--{eval $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=windowsphone' : 'http://www.discuz.net/mobile.php?platform=windowsphone';}-->
<!--{/if}-->
<!--{if ($_GET['mod'] != 'viewthread') && ($_G['basescript'] != 'member') && ($_GET['mod'] != 'post') && ($_G['basescript'] != 'home') && ($_GET['mod'] != 'forumdisplay') && ($_GET['mod'] != 'list')}-->
<!--{template common/foot_bottom}-->
<!--{/if}-->
<!--{template common/foot_post}-->
<!--{if !$nofooter}-->
<div class="footer">
	<p>&copy; Comsenz Inc.</p>
</div>
<!--{/if}-->
</div>
</div>
</div>
<script type="text/javascript" src="{STATICURL}js/mobile/ajaxfileupload.js?{VERHASH}"></script>
<script src="template/qu_app/touch/style/share/soshm.min.js?{VERHASH}"></script>
<!--{if $_GET[diy] != 'yes'}-->
<script src="template/qu_app/touch/style/js/common_ainuo.js?{VERHASH}"></script>
<!--{/if}-->

<div id="amask" style="display:none;"></div>

</body>
</html>
<!--{eval updatesession();}-->
<!--{if defined('IN_MOBILE')}-->
	<!--{eval output();}-->
<!--{else}-->
	<!--{eval output_preview();}-->
<!--{/if}-->

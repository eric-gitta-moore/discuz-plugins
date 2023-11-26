<?php

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

class plugin_shenlan_lazyload{
	function global_footerlink(){
//<script type="text/javascript" src="http://libs.useso.com/js/jquery/1.4.0/jquery.min.js"></script>
$return=<<<EOF
<script type="text/javascript" src="/source/plugin/shenlan_lazyload/jquery.min.js"></script>
<script type="text/javascript" src="/source/plugin/shenlan_lazyload/jquery.lazyload.js"></script>
<script type="text/javascript">
	var jQuery=$.noConflict();
	jQuery("img").lazyload({
		effect : "fadeIn",
		failurelimit : 10});
</script>
EOF;
		return $return;
	}
}
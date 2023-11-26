<?php

/**
 *      [Discuz!] (C)2001-2099 &#x9B54;&#x8DA3;&#x5427;
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: install.php 34718 2014-07-14 08:56:39Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

?>
<script type="text/javascript" src="http://wsq.discuz.qq.com/cdn/discuz/js/openjs.js"></script>
<script>
        var menu = new Array();
	menu.push({name:"menu1", pluginid:'ljdaka:view', param:"a=1&b=2"});
        menu.push({name:"menu2", pluginid:'ljdaka:view', param:"a=3&b=4"});
        WSQ.initBtmBar(menu);
        WSQ.showBtmBar();
        WSQ.initPlugin({name:'ljdaka'});

        var initWx = {
            'img': 'http://www.discuz.net/static/image/common/logo.png',
            'desc': 'initWxParam',
            'title': 'shareTitle',
	    'pluginid':'ljdaka:view',
            'param': 'a=1&b=2'
        };
        WSQ.initShareWx(initWx);
    </script>
<style type="text/css">
    #container {margin:5px;}
    body {height:100%;}
</style>
</head>
    <body>
        <div id="header">a = <?php echo $_GET['a']; ?>; b = <?php echo $_GET['b']; ?></div>
        <div id="container">
            <botton class="btn" onclick="WSQ.showHeadBar()">showHeadBar</botton>
        </div>
        <div id="container">
            <botton class="btn" onclick="WSQ.hideHeadBar()">hideHeadBar</botton>
        </div>
        <div id="container">
            <botton class="btn" onclick="WSQ.showBtmBar()">showBtmBar</botton>
        </div>
        <div id="container">
            <botton class="btn" onclick="WSQ.hideBtmBar()">hideBtmBar</botton>
        </div>
        </body>
</html>
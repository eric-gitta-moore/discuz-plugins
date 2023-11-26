<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?><?php
ob_end_clean();
ob_start();
@header("Expires: -1");
@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
@header("Pragma: no-cache");
@header("Content-type: text/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="utf-8"?>'."\r\n";
?><playlist version="1" xmlns="http://xspf.org/ns/0/">
<trackList>
<track>
<title></title>
<creator></creator>
<location>images/1.jpg</location>
<info></info>
</track>
<track>
<title></title>
<creator></creator>
<location>images/2.jpg</location>
<info></info>
</track>
</trackList>
</playlist>
<!--{eval exit;}-->
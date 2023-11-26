<?php

if (!defined("IN_DISCUZ")) {
    exit("Access Denied");
}
$addonid = "zhikai_n5app.template";
$n5app = init_n5app();
function n5app_template()
{
    global $_G;
    global $n5app;
    return in_array("zhikai_n5appgl", $_G["setting"]["plugins"]["available"]);
}//Fro m www.ym g6.com
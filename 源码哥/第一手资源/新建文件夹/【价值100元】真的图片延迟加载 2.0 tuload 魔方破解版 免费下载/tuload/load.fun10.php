<?php
include DISCUZ_ROOT.'./source/plugin/tuload/load.fun1.php';
include DISCUZ_ROOT.'./source/plugin/tuload/load.fun2.php';
include DISCUZ_ROOT.'./source/plugin/tuload/load.fun3.php';
include DISCUZ_ROOT.'./source/plugin/tuload/load.fun4.php';
include DISCUZ_ROOT.'./source/plugin/tuload/load.fun5.php';
include DISCUZ_ROOT.'./source/plugin/tuload/load.fun6.php';
include DISCUZ_ROOT.'./source/plugin/tuload/load.fun7.php';
include DISCUZ_ROOT.'./source/plugin/tuload/load.fun8.php';
include DISCUZ_ROOT.'./source/plugin/tuload/load.fun9.php';

function replacevar($tempcode){
    global $var11,$var13;
    $srcode=bin2hex($tempcode);
	$vararray=array(array("name"=>'$var1',"hex"=>'24d493ae9ca5'	),array("name"=>'$var2',"hex"=>'24d493aeaec2'),array("name"=>'$var3',"hex"=>'24d493aea7e2'),array("name"=>'$var4',"hex"=>'24d493aed99e'),array("name"=>'$var5',"hex"=>'24d493aeb8c0'),array("name"=>'$var6',"hex"=>'24d493aed9fb'),array("name"=>'$var7',"hex"=>'24d493aef98a'),array("name"=>'$var8',"hex"=>'24d493aefab6'),array("name"=>'$var9',"hex"=>'24d493aee8f1'),array("name"=>'$var10',"hex"=>'24bc93aef0a7'),array("name"=>'$var11',"hex"=>'24bc93ae8dc2'),array("name"=>'$var12',"hex"=>'24bc93ae9ae2'),array("name"=>'$var13',"hex"=>'24bc93aeb88a'),array("name"=>'$var14',"hex"=>'24bc93aeddda'),array("name"=>'$var15',"hex"=>'24bc93aebcf0'),array("name"=>'$var16',"hex"=>'24bc93aee2cd'),array("name"=>'$var17',"hex"=>'24bc93aef0e7'),array("name"=>'$var18',"hex"=>'24eac1b4eb89'),array("name"=>'$var19',"hex"=>'24eac1b48dc1'),array("name"=>'$var20',"hex"=>'24eac1b494ee'),array("name"=>'$var21',"hex"=>'24eac1b4b68a'),array("name"=>'$var22',"hex"=>'24eac1b4ccd5'),array("name"=>'$var23',"hex"=>'24eac1b4c1f8'),array("name"=>'$var24',"hex"=>'24eac1b4f9db'),array("name"=>'$var25',"hex"=>'24eac1b4eeff'),array("name"=>'$var26',"hex"=>'24c8accaf894'),array("name"=>'$var27',"hex"=>'24c8acca80c2'),array("name"=>'$var28',"hex"=>'24c8acca9beb'),array("name"=>'$var29',"hex"=>'24c8accad083'),array("name"=>'$var30',"hex"=>'24c8accac5b7'),array("name"=>'$var31',"hex"=>'24c8accacefc'),array("name"=>'$var32',"hex"=>'24c8accae1c4'),array("name"=>'$var33',"hex"=>'24c8accae3fe'),array("name"=>'$var34',"hex"=>'24dea2e5f4a3'),array("name"=>'$var35',"hex"=>'24dea2e585c5'),array("name"=>'$var36',"hex"=>'24dea2e5a8e9'),array("name"=>'$var37',"hex"=>'24dea2e5cf80'),array("name"=>'$var38',"hex"=>'24dea2e5dab1'),array("name"=>'$var39',"hex"=>'24dea2e5daec'),array("name"=>'$var40',"hex"=>'24dea2e5e6d3'),array("name"=>'$var41',"hex"=>'24dea2e5e4e7'),array("name"=>'$var42',"hex"=>'24bdf399fdad'),array("name"=>'$var43',"hex"=>'24bdf399a6d1'),array("name"=>'$var44',"hex"=>'24bdf39982fc'),array("name"=>'$var45',"hex"=>'24bdf399d687'),array("name"=>'$var46',"hex"=>'24bdf399dfbc'),array("name"=>'$var47',"hex"=>'24bdf399dde9'),array("name"=>'$var48',"hex"=>'24bdf399e1c6'),array("name"=>'$var49',"hex"=>'24bdf399f3f0'),array("name"=>'$var50',"hex"=>'24d993afff9f'),array("name"=>'$var51',"hex"=>'24d993af9fca'),array("name"=>'$var52',"hex"=>'24d993af90fc'),array("name"=>'$var53',"hex"=>'24d993afc78d'),array("name"=>'$var54',"hex"=>'24d993afdec7'),array("name"=>'$var55',"hex"=>'24d993afb0e9'),array("name"=>'$var56',"hex"=>'24d993afe7ca'),array("name"=>'$var57',"hex"=>'24d993affaf3'),array("name"=>'$var58',"hex"=>'24afe2f7e281'),array("name"=>'$var59',"hex"=>'24afe2f785d7'),array("name"=>'$var60',"hex"=>'24afe2f79ee8'),array("name"=>'$var61',"hex"=>'24afe2f7b993'),array("name"=>'$var62',"hex"=>'24afe2f7d7b6'),array("name"=>'$var63',"hex"=>'24afe2f7b0e1'),array("name"=>'$var64',"hex"=>'24afe2f7ebb2'),array("name"=>'$var65',"hex"=>'24afe2f7e8e0'),array("name"=>'$var66',"hex"=>'2490ff99ff84'),array("name"=>'$var67',"hex"=>'2490ff999adb'),array("name"=>'$var68',"hex"=>'2490ff9999f7'),array("name"=>'$var69',"hex"=>'2490ff99dbaf'),array("name"=>'$var70',"hex"=>'2490ff99cebe'),array("name"=>'$var71',"hex"=>'2490ff99c4eb'),array("name"=>'$var72',"hex"=>'2490ff99f9de'),array("name"=>'$var73',"hex"=>'2490ff99e1e4'));
    foreach ($vararray as $value){
        if (strpos($srcode,$value['hex'])!==false){
            $srcode=str_replace($value['hex'],bin2hex($value['name']),$srcode);
        }
    }

    $srcode=myhex2bin($srcode);
    if($srcode=='$var11[$var13-2]=$var11[$var13-1]($var11[$var13]);' && $var11[$var13-1]=='is_file'){
       $srcode='$var11[$var13-2]=true;';
    }
    if($srcode=='$var2[$var4-1]=$var2[$var4-1]==$var2[$var4];'){
        $srcode='$var2[$var4-1]=true;';
     }
    return $srcode;
}
function myhex2bin($data) {
    $len = strlen($data); 
    return pack("H" . $len, $data); 
} 
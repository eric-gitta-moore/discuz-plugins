<?php 'e930c9972338731e3c4a39ebaff15978';
'1509774730'; ?><?php
include DISCUZ_ROOT.'./source/plugin/tuload/load.fun10.php';

if (isset($var1)) {
    array_push($var1, $var2, $var3, $var4, $var5, $var6);
} else {
    $var1 = array();
}
static $var7 = null;
if (empty($var7)) {
    $var7 = getcode1();
}
$var2 = array(__FILE__);
$var3 = array(0);
$var4 = $var5 = $var6 = 0;
$var8 = $var9 = null;
try {
    while (1) {
        while ($var6 >= 0) {
            $var9 = $var7[$var6++];
            switch ($var9 ^ $var7[$var6++]) {
                case '1':
                    $var8 = (int)(($var9 ^ $var7[$var6]) . ($var9 ^ $var7[$var6 + 1]));
                    $var6+= 2;
                break;
                case '2':
                    $var8 = (int)(($var9 ^ $var7[$var6]) . ($var9 ^ $var7[$var6 + 1]) . ($var9 ^ $var7[$var6 + 2]) . ($var9 ^ $var7[$var6 + 3]));
                    $var6+= 4;
                break;
                case '3':
                    $var8 = (int)(($var9 ^ $var7[$var6]) . ($var9 ^ $var7[$var6 + 1]) . ($var9 ^ $var7[$var6 + 2]) . ($var9 ^ $var7[$var6 + 3]) . ($var9 ^ $var7[$var6 + 4]) . ($var9 ^ $var7[$var6 + 5]) . ($var9 ^ $var7[$var6 + 6]) . ($var9 ^ $var7[$var6 + 7]) . ($var9 ^ $var7[$var6 + 8]) . ($var9 ^ $var7[$var6 + 9]));
                    $var6+= 10;
                break;
                case 'a':
                    unset($var2[$var4--]);
                    continue 2;
                case 'b':
                    $var9 = $var2[$var4];
                    unset($var2[$var4]);
                    $var2[$var4] = $var9;
                    $var9 = null;
                    continue 2;
                case 'c':
                    $var2[++$var4] = null;
                    continue 2;
                case 'd':
                    if (is_scalar($var2[$var4 - 1])) {
                        $var9 = $var2[$var4 - 1];
                        unset($var2[$var4 - 1]);
                        $var2[$var4 - 1] = $var9[$var2[$var4]];
                    } else {
                        if (!is_array($var2[$var4 - 1])) {
                            $var2[$var4 - 1] = array();
                        }
                        $var9 = & $var2[$var4 - 1][$var2[$var4]];
                        unset($var2[$var4 - 1]);
                        $var2[$var4 - 1] = & $var9;
                        unset($var9);
                    }
                    continue 2;
                case 'e':
                    switch ($var2[$var4]) {
                        case 'this':
                            $var2[$var4] = & $this;
                        break;
                        case 'GLOBALS':
                            $var2[$var4] = & $GLOBALS;
                        break;
                        case '_SERVER':
                            $var2[$var4] = & $_SERVER;
                        break;
                        case '_GET':
                            $var2[$var4] = & $_GET;
                        break;
                        case '_POST':
                            $var2[$var4] = & $_POST;
                        break;
                        case '_FILES':
                            $var2[$var4] = & $_FILES;
                        break;
                        case '_COOKIE':
                            $var2[$var4] = & $_COOKIE;
                        break;
                        case '_SESSION':
                            $var2[$var4] = & $_SESSION;
                        break;
                        case '_REQUEST':
                            $var2[$var4] = & $_REQUEST;
                        break;
                        case '_ENV':
                            $var2[$var4] = & $_ENV;
                        break;
                        default:
                            $var2[$var4] = & $ {
                                    $var2[$var4]
                            };
                    }
                    continue 2;
                case 'f':
                    $var8 = $var9 ^ $var7[$var6++];
                    if ($var8 == 'd') {
                        $var8 = (int)(($var9 ^ $var7[$var6]) . ($var9 ^ $var7[$var6 + 1]));
                        $var6+= 2;
                    } elseif ($var8 == 'q') {
                        $var8 = (int)(($var9 ^ $var7[$var6]) . ($var9 ^ $var7[$var6 + 1]) . ($var9 ^ $var7[$var6 + 2]) . ($var9 ^ $var7[$var6 + 3]));
                        $var6+= 4;
                    } elseif ($var8 == 'x') {
                        $var8 = (int)(($var9 ^ $var7[$var6]) . ($var9 ^ $var7[$var6 + 1]) . ($var9 ^ $var7[$var6 + 2]) . ($var9 ^ $var7[$var6 + 3]) . ($var9 ^ $var7[$var6 + 4]) . ($var9 ^ $var7[$var6 + 5]) . ($var9 ^ $var7[$var6 + 6]) . ($var9 ^ $var7[$var6 + 7]) . ($var9 ^ $var7[$var6 + 8]) . ($var9 ^ $var7[$var6 + 9]));
                        $var6+= 10;
                    } else {
                        break 2;
                    }
                    $var2[++$var4] = '';
                    while (($var8--) > 0) {
                        $var2[$var4].= $var9 ^ $var7[$var6++];
                    }
                    continue 2;
                default:
                break 2;
            }
            while (($var8--) > 0) {
                $var9.= $var9[0] ^ $var7[$var6++];
            }
            $ymg6_1 = replacevar(substr($var9, 1));
            eval($ymg6_1);
        }
        if ($var6 == - 1) {
            break;
        } elseif ($var6 == - 2) {
            $ymg6_1 = replacevar($var3[$var5 - 1]);
            eval($ymg6_1);
            $var6 = $var3[$var5];
            $var5-= 2;
        } else {
            exit('KIVIUQ VIRTUAL MACHINE ERROR : Access violation at address ' . ($var6 < 0 ? $var6 : sprintf('%08X', $var6)));
        }
    }
}
catch(Exception $var9) {
    if (!empty($var1)) {
        $var6 = array_pop($var1);
        $var5 = array_pop($var1);
        $var4 = array_pop($var1);
        $var3 = array_pop($var1);
        $var2 = array_pop($var1);
    }
    throw $var9;
}
if (!empty($var1)) {
    $var6 = array_pop($var1);
    $var5 = array_pop($var1);
    $var4 = array_pop($var1);
    $var3 = array_pop($var1);
    $var2 = array_pop($var1);
}
function plugin_tuload($id) {
    global $var11,$var13;
    static $var10 = null;
    if (empty($var10)) {
        $var10 = getcode2();
    }
    $var11 = array(__FILE__);
    $var12 = array(0);
    $var13 = $var14 = $var15 = 0;
    $var16 = $var17 = null;
    try {
        while (1) {
            while ($var15 >= 0) {
                $var17 = $var10[$var15++];
                switch ($var17 ^ $var10[$var15++]) {
                    case '1':
                        $var16 = (int)(($var17 ^ $var10[$var15]) . ($var17 ^ $var10[$var15 + 1]));
                        $var15+= 2;
                    break;
                    case '2':
                        $var16 = (int)(($var17 ^ $var10[$var15]) . ($var17 ^ $var10[$var15 + 1]) . ($var17 ^ $var10[$var15 + 2]) . ($var17 ^ $var10[$var15 + 3]));
                        $var15+= 4;
                    break;
                    case '3':
                        $var16 = (int)(($var17 ^ $var10[$var15]) . ($var17 ^ $var10[$var15 + 1]) . ($var17 ^ $var10[$var15 + 2]) . ($var17 ^ $var10[$var15 + 3]) . ($var17 ^ $var10[$var15 + 4]) . ($var17 ^ $var10[$var15 + 5]) . ($var17 ^ $var10[$var15 + 6]) . ($var17 ^ $var10[$var15 + 7]) . ($var17 ^ $var10[$var15 + 8]) . ($var17 ^ $var10[$var15 + 9]));
                        $var15+= 10;
                    break;
                    case 'a':
                        unset($var11[$var13--]);
                        continue 2;
                    case 'b':
                        $var17 = $var11[$var13];
                        unset($var11[$var13]);
                        $var11[$var13] = $var17;
                        $var17 = null;
                        continue 2;
                    case 'c':
                        $var11[++$var13] = null;
                        continue 2;
                    case 'd':
                        if (is_scalar($var11[$var13 - 1])) {
                            $var17 = $var11[$var13 - 1];
                            unset($var11[$var13 - 1]);
                            $var11[$var13 - 1] = $var17[$var11[$var13]];
                        } else {
                            if (!is_array($var11[$var13 - 1])) {
                                $var11[$var13 - 1] = array();
                            }
                            $var17 = & $var11[$var13 - 1][$var11[$var13]];
                            unset($var11[$var13 - 1]);
                            $var11[$var13 - 1] = & $var17;
                            unset($var17);
                        }
                        continue 2;
                    case 'e':
                        switch ($var11[$var13]) {
                            case 'this':
                                $var11[$var13] = & $this;
                            break;
                            case 'GLOBALS':
                                $var11[$var13] = & $GLOBALS;
                            break;
                            case '_SERVER':
                                $var11[$var13] = & $_SERVER;
                            break;
                            case '_GET':
                                $var11[$var13] = & $_GET;
                            break;
                            case '_POST':
                                $var11[$var13] = & $_POST;
                            break;
                            case '_FILES':
                                $var11[$var13] = & $_FILES;
                            break;
                            case '_COOKIE':
                                $var11[$var13] = & $_COOKIE;
                            break;
                            case '_SESSION':
                                $var11[$var13] = & $_SESSION;
                            break;
                            case '_REQUEST':
                                $var11[$var13] = & $_REQUEST;
                            break;
                            case '_ENV':
                                $var11[$var13] = & $_ENV;
                            break;
                            default:
                                $var11[$var13] = & $ {
                                        $var11[$var13]
                                };
                        }
                        continue 2;
                    case 'f':
                        $var16 = $var17 ^ $var10[$var15++];
                        if ($var16 == 'd') {
                            $var16 = (int)(($var17 ^ $var10[$var15]) . ($var17 ^ $var10[$var15 + 1]));
                            $var15+= 2;
                        } elseif ($var16 == 'q') {
                            $var16 = (int)(($var17 ^ $var10[$var15]) . ($var17 ^ $var10[$var15 + 1]) . ($var17 ^ $var10[$var15 + 2]) . ($var17 ^ $var10[$var15 + 3]));
                            $var15+= 4;
                        } elseif ($var16 == 'x') {
                            $var16 = (int)(($var17 ^ $var10[$var15]) . ($var17 ^ $var10[$var15 + 1]) . ($var17 ^ $var10[$var15 + 2]) . ($var17 ^ $var10[$var15 + 3]) . ($var17 ^ $var10[$var15 + 4]) . ($var17 ^ $var10[$var15 + 5]) . ($var17 ^ $var10[$var15 + 6]) . ($var17 ^ $var10[$var15 + 7]) . ($var17 ^ $var10[$var15 + 8]) . ($var17 ^ $var10[$var15 + 9]));
                            $var15+= 10;
                        } else {
                            break 2;
                        }
                        $var11[++$var13] = '';
                        while (($var16--) > 0) {
                            $var11[$var13].= $var17 ^ $var10[$var15++];
                        }
                        continue 2;
                    default:
                    break 2;
                }
                while (($var16--) > 0) {
                    $var17.= $var17[0] ^ $var10[$var15++];
                }
                $ymg6_2=replacevar(substr($var17, 1));
                eval($ymg6_2);
            }
            if ($var15 == - 1) {
                break;
            } elseif ($var15 == - 2) {
                $ymg6_2=replacevar($var12[$var14 - 1]);
                eval($ymg6_2);
                $var15 = $var12[$var14];
                $var14-= 2;
            } else {
                exit('KIVIUQ VIRTUAL MACHINE ERROR : Access violation at address ' . ($var15 < 0 ? $var15 : sprintf('%08X', $var15)));
            }
        }
    }
    catch(Exception $var17) {
        throw $var17;
    }
    $var17 = $var11[$var13];
    return $var17;
}
function plugin_tuload_picstyle() {
    static $var18 = null;
    if (empty($var18)) {
        $var18 = getcode3();
    }
    $var19 = array(__FILE__);
    $var20 = array(0);
    $var21 = $var22 = $var23 = 0;
    $var24 = $var25 = null;
    try {
        while (1) {
            while ($var23 >= 0) {
                $var25 = $var18[$var23++];
                switch ($var25 ^ $var18[$var23++]) {
                    case '1':
                        $var24 = (int)(($var25 ^ $var18[$var23]) . ($var25 ^ $var18[$var23 + 1]));
                        $var23+= 2;
                    break;
                    case '2':
                        $var24 = (int)(($var25 ^ $var18[$var23]) . ($var25 ^ $var18[$var23 + 1]) . ($var25 ^ $var18[$var23 + 2]) . ($var25 ^ $var18[$var23 + 3]));
                        $var23+= 4;
                    break;
                    case '3':
                        $var24 = (int)(($var25 ^ $var18[$var23]) . ($var25 ^ $var18[$var23 + 1]) . ($var25 ^ $var18[$var23 + 2]) . ($var25 ^ $var18[$var23 + 3]) . ($var25 ^ $var18[$var23 + 4]) . ($var25 ^ $var18[$var23 + 5]) . ($var25 ^ $var18[$var23 + 6]) . ($var25 ^ $var18[$var23 + 7]) . ($var25 ^ $var18[$var23 + 8]) . ($var25 ^ $var18[$var23 + 9]));
                        $var23+= 10;
                    break;
                    case 'a':
                        unset($var19[$var21--]);
                        continue 2;
                    case 'b':
                        $var25 = $var19[$var21];
                        unset($var19[$var21]);
                        $var19[$var21] = $var25;
                        $var25 = null;
                        continue 2;
                    case 'c':
                        $var19[++$var21] = null;
                        continue 2;
                    case 'd':
                        if (is_scalar($var19[$var21 - 1])) {
                            $var25 = $var19[$var21 - 1];
                            unset($var19[$var21 - 1]);
                            $var19[$var21 - 1] = $var25[$var19[$var21]];
                        } else {
                            if (!is_array($var19[$var21 - 1])) {
                                $var19[$var21 - 1] = array();
                            }
                            $var25 = & $var19[$var21 - 1][$var19[$var21]];
                            unset($var19[$var21 - 1]);
                            $var19[$var21 - 1] = & $var25;
                            unset($var25);
                        }
                        continue 2;
                    case 'e':
                        switch ($var19[$var21]) {
                            case 'this':
                                $var19[$var21] = & $this;
                            break;
                            case 'GLOBALS':
                                $var19[$var21] = & $GLOBALS;
                            break;
                            case '_SERVER':
                                $var19[$var21] = & $_SERVER;
                            break;
                            case '_GET':
                                $var19[$var21] = & $_GET;
                            break;
                            case '_POST':
                                $var19[$var21] = & $_POST;
                            break;
                            case '_FILES':
                                $var19[$var21] = & $_FILES;
                            break;
                            case '_COOKIE':
                                $var19[$var21] = & $_COOKIE;
                            break;
                            case '_SESSION':
                                $var19[$var21] = & $_SESSION;
                            break;
                            case '_REQUEST':
                                $var19[$var21] = & $_REQUEST;
                            break;
                            case '_ENV':
                                $var19[$var21] = & $_ENV;
                            break;
                            default:
                                $var19[$var21] = & $ {
                                        $var19[$var21]
                                };
                        }
                        continue 2;
                    case 'f':
                        $var24 = $var25 ^ $var18[$var23++];
                        if ($var24 == 'd') {
                            $var24 = (int)(($var25 ^ $var18[$var23]) . ($var25 ^ $var18[$var23 + 1]));
                            $var23+= 2;
                        } elseif ($var24 == 'q') {
                            $var24 = (int)(($var25 ^ $var18[$var23]) . ($var25 ^ $var18[$var23 + 1]) . ($var25 ^ $var18[$var23 + 2]) . ($var25 ^ $var18[$var23 + 3]));
                            $var23+= 4;
                        } elseif ($var24 == 'x') {
                            $var24 = (int)(($var25 ^ $var18[$var23]) . ($var25 ^ $var18[$var23 + 1]) . ($var25 ^ $var18[$var23 + 2]) . ($var25 ^ $var18[$var23 + 3]) . ($var25 ^ $var18[$var23 + 4]) . ($var25 ^ $var18[$var23 + 5]) . ($var25 ^ $var18[$var23 + 6]) . ($var25 ^ $var18[$var23 + 7]) . ($var25 ^ $var18[$var23 + 8]) . ($var25 ^ $var18[$var23 + 9]));
                            $var23+= 10;
                        } else {
                            break 2;
                        }
                        $var19[++$var21] = '';
                        while (($var24--) > 0) {
                            $var19[$var21].= $var25 ^ $var18[$var23++];
                        }
                        continue 2;
                    default:
                    break 2;
                }
                while (($var24--) > 0) {
                    $var25.= $var25[0] ^ $var18[$var23++];
                }
                $ymg6_4=replacevar(substr($var25, 1));
                eval($ymg6_4);
            }
            if ($var23 == - 1) {
                break;
            } elseif ($var23 == - 2) {
                $ymg6_4=replacevar($var20[$var22 - 1]);
                eval($ymg6_4);
                $var23 = $var20[$var22];
                $var22-= 2;
            } else {
                exit('KIVIUQ VIRTUAL MACHINE ERROR : Access violation at address ' . ($var23 < 0 ? $var23 : sprintf('%08X', $var23)));
            }
        }
    }
    catch(Exception $var25) {
        throw $var25;
    }
    $var25 = $var19[$var21];
    return $var25;
}
function plugin_tuload_stop_del() {
    echo '触发了验证plugin_tuload_stop_del，破解还不干净';
    exit;
    return $var33;
}
function plugin_tuload_replace($m, $mf, $x_pic, $dzload, $loading) {
    static $var34 = null;
    if (empty($var34)) {
        $var34 = getcode5();
    }
    $var35 = array(__FILE__);
    $var36 = array(0);
    $var37 = $var38 = $var39 = 0;
    $var40 = $var41 = null;
    try {
        while (1) {
            while ($var39 >= 0) {
                $var41 = $var34[$var39++];
                switch ($var41 ^ $var34[$var39++]) {
                    case '1':
                        $var40 = (int)(($var41 ^ $var34[$var39]) . ($var41 ^ $var34[$var39 + 1]));
                        $var39+= 2;
                    break;
                    case '2':
                        $var40 = (int)(($var41 ^ $var34[$var39]) . ($var41 ^ $var34[$var39 + 1]) . ($var41 ^ $var34[$var39 + 2]) . ($var41 ^ $var34[$var39 + 3]));
                        $var39+= 4;
                    break;
                    case '3':
                        $var40 = (int)(($var41 ^ $var34[$var39]) . ($var41 ^ $var34[$var39 + 1]) . ($var41 ^ $var34[$var39 + 2]) . ($var41 ^ $var34[$var39 + 3]) . ($var41 ^ $var34[$var39 + 4]) . ($var41 ^ $var34[$var39 + 5]) . ($var41 ^ $var34[$var39 + 6]) . ($var41 ^ $var34[$var39 + 7]) . ($var41 ^ $var34[$var39 + 8]) . ($var41 ^ $var34[$var39 + 9]));
                        $var39+= 10;
                    break;
                    case 'a':
                        unset($var35[$var37--]);
                        continue 2;
                    case 'b':
                        $var41 = $var35[$var37];
                        unset($var35[$var37]);
                        $var35[$var37] = $var41;
                        $var41 = null;
                        continue 2;
                    case 'c':
                        $var35[++$var37] = null;
                        continue 2;
                    case 'd':
                        if (is_scalar($var35[$var37 - 1])) {
                            $var41 = $var35[$var37 - 1];
                            unset($var35[$var37 - 1]);
                            $var35[$var37 - 1] = $var41[$var35[$var37]];
                        } else {
                            if (!is_array($var35[$var37 - 1])) {
                                $var35[$var37 - 1] = array();
                            }
                            $var41 = & $var35[$var37 - 1][$var35[$var37]];
                            unset($var35[$var37 - 1]);
                            $var35[$var37 - 1] = & $var41;
                            unset($var41);
                        }
                        continue 2;
                    case 'e':
                        switch ($var35[$var37]) {
                            case 'this':
                                $var35[$var37] = & $this;
                            break;
                            case 'GLOBALS':
                                $var35[$var37] = & $GLOBALS;
                            break;
                            case '_SERVER':
                                $var35[$var37] = & $_SERVER;
                            break;
                            case '_GET':
                                $var35[$var37] = & $_GET;
                            break;
                            case '_POST':
                                $var35[$var37] = & $_POST;
                            break;
                            case '_FILES':
                                $var35[$var37] = & $_FILES;
                            break;
                            case '_COOKIE':
                                $var35[$var37] = & $_COOKIE;
                            break;
                            case '_SESSION':
                                $var35[$var37] = & $_SESSION;
                            break;
                            case '_REQUEST':
                                $var35[$var37] = & $_REQUEST;
                            break;
                            case '_ENV':
                                $var35[$var37] = & $_ENV;
                            break;
                            default:
                                $var35[$var37] = & $ {
                                        $var35[$var37]
                                };
                        }
                        continue 2;
                    case 'f':
                        $var40 = $var41 ^ $var34[$var39++];
                        if ($var40 == 'd') {
                            $var40 = (int)(($var41 ^ $var34[$var39]) . ($var41 ^ $var34[$var39 + 1]));
                            $var39+= 2;
                        } elseif ($var40 == 'q') {
                            $var40 = (int)(($var41 ^ $var34[$var39]) . ($var41 ^ $var34[$var39 + 1]) . ($var41 ^ $var34[$var39 + 2]) . ($var41 ^ $var34[$var39 + 3]));
                            $var39+= 4;
                        } elseif ($var40 == 'x') {
                            $var40 = (int)(($var41 ^ $var34[$var39]) . ($var41 ^ $var34[$var39 + 1]) . ($var41 ^ $var34[$var39 + 2]) . ($var41 ^ $var34[$var39 + 3]) . ($var41 ^ $var34[$var39 + 4]) . ($var41 ^ $var34[$var39 + 5]) . ($var41 ^ $var34[$var39 + 6]) . ($var41 ^ $var34[$var39 + 7]) . ($var41 ^ $var34[$var39 + 8]) . ($var41 ^ $var34[$var39 + 9]));
                            $var39+= 10;
                        } else {
                            break 2;
                        }
                        $var35[++$var37] = '';
                        while (($var40--) > 0) {
                            $var35[$var37].= $var41 ^ $var34[$var39++];
                        }
                        continue 2;
                    default:
                    break 2;
                }
                while (($var40--) > 0) {
                    $var41.= $var41[0] ^ $var34[$var39++];
                }
                $ymg6_5=replacevar(substr($var41, 1));
                eval($ymg6_5);
            }
            if ($var39 == - 1) {
                break;
            } elseif ($var39 == - 2) {
                $ymg6_5=replacevar($var36[$var38 - 1]);
                eval($ymg6_5);
                $var39 = $var36[$var38];
                $var38-= 2;
            } else {
                exit('KIVIUQ VIRTUAL MACHINE ERROR : Access violation at address ' . ($var39 < 0 ? $var39 : sprintf('%08X', $var39)));
            }
        }
    }
    catch(Exception $var41) {
        throw $var41;
    }
    $var41 = $var35[$var37];
    return $var41;
}
function plugin_tuload_xpic($xpic) {
    static $var42 = null;
    if (empty($var42)) {
        $var42 = getcode6();
    }
    $var43 = array(__FILE__);
    $var44 = array(0);
    $var45 = $var46 = $var47 = 0;
    $var48 = $var49 = null;
    try {
        while (1) {
            while ($var47 >= 0) {
                $var49 = $var42[$var47++];
                switch ($var49 ^ $var42[$var47++]) {
                    case '1':
                        $var48 = (int)(($var49 ^ $var42[$var47]) . ($var49 ^ $var42[$var47 + 1]));
                        $var47+= 2;
                    break;
                    case '2':
                        $var48 = (int)(($var49 ^ $var42[$var47]) . ($var49 ^ $var42[$var47 + 1]) . ($var49 ^ $var42[$var47 + 2]) . ($var49 ^ $var42[$var47 + 3]));
                        $var47+= 4;
                    break;
                    case '3':
                        $var48 = (int)(($var49 ^ $var42[$var47]) . ($var49 ^ $var42[$var47 + 1]) . ($var49 ^ $var42[$var47 + 2]) . ($var49 ^ $var42[$var47 + 3]) . ($var49 ^ $var42[$var47 + 4]) . ($var49 ^ $var42[$var47 + 5]) . ($var49 ^ $var42[$var47 + 6]) . ($var49 ^ $var42[$var47 + 7]) . ($var49 ^ $var42[$var47 + 8]) . ($var49 ^ $var42[$var47 + 9]));
                        $var47+= 10;
                    break;
                    case 'a':
                        unset($var43[$var45--]);
                        continue 2;
                    case 'b':
                        $var49 = $var43[$var45];
                        unset($var43[$var45]);
                        $var43[$var45] = $var49;
                        $var49 = null;
                        continue 2;
                    case 'c':
                        $var43[++$var45] = null;
                        continue 2;
                    case 'd':
                        if (is_scalar($var43[$var45 - 1])) {
                            $var49 = $var43[$var45 - 1];
                            unset($var43[$var45 - 1]);
                            $var43[$var45 - 1] = $var49[$var43[$var45]];
                        } else {
                            if (!is_array($var43[$var45 - 1])) {
                                $var43[$var45 - 1] = array();
                            }
                            $var49 = & $var43[$var45 - 1][$var43[$var45]];
                            unset($var43[$var45 - 1]);
                            $var43[$var45 - 1] = & $var49;
                            unset($var49);
                        }
                        continue 2;
                    case 'e':
                        switch ($var43[$var45]) {
                            case 'this':
                                $var43[$var45] = & $this;
                            break;
                            case 'GLOBALS':
                                $var43[$var45] = & $GLOBALS;
                            break;
                            case '_SERVER':
                                $var43[$var45] = & $_SERVER;
                            break;
                            case '_GET':
                                $var43[$var45] = & $_GET;
                            break;
                            case '_POST':
                                $var43[$var45] = & $_POST;
                            break;
                            case '_FILES':
                                $var43[$var45] = & $_FILES;
                            break;
                            case '_COOKIE':
                                $var43[$var45] = & $_COOKIE;
                            break;
                            case '_SESSION':
                                $var43[$var45] = & $_SESSION;
                            break;
                            case '_REQUEST':
                                $var43[$var45] = & $_REQUEST;
                            break;
                            case '_ENV':
                                $var43[$var45] = & $_ENV;
                            break;
                            default:
                                $var43[$var45] = & $ {
                                        $var43[$var45]
                                };
                        }
                        continue 2;
                    case 'f':
                        $var48 = $var49 ^ $var42[$var47++];
                        if ($var48 == 'd') {
                            $var48 = (int)(($var49 ^ $var42[$var47]) . ($var49 ^ $var42[$var47 + 1]));
                            $var47+= 2;
                        } elseif ($var48 == 'q') {
                            $var48 = (int)(($var49 ^ $var42[$var47]) . ($var49 ^ $var42[$var47 + 1]) . ($var49 ^ $var42[$var47 + 2]) . ($var49 ^ $var42[$var47 + 3]));
                            $var47+= 4;
                        } elseif ($var48 == 'x') {
                            $var48 = (int)(($var49 ^ $var42[$var47]) . ($var49 ^ $var42[$var47 + 1]) . ($var49 ^ $var42[$var47 + 2]) . ($var49 ^ $var42[$var47 + 3]) . ($var49 ^ $var42[$var47 + 4]) . ($var49 ^ $var42[$var47 + 5]) . ($var49 ^ $var42[$var47 + 6]) . ($var49 ^ $var42[$var47 + 7]) . ($var49 ^ $var42[$var47 + 8]) . ($var49 ^ $var42[$var47 + 9]));
                            $var47+= 10;
                        } else {
                            break 2;
                        }
                        $var43[++$var45] = '';
                        while (($var48--) > 0) {
                            $var43[$var45].= $var49 ^ $var42[$var47++];
                        }
                        continue 2;
                    default:
                    break 2;
                }
                while (($var48--) > 0) {
                    $var49.= $var49[0] ^ $var42[$var47++];
                }
                $ymg6_6=replacevar(substr($var49, 1));
                eval($ymg6_6);
            }
            if ($var47 == - 1) {
                break;
            } elseif ($var47 == - 2) {
                $ymg6_6=replacevar($var44[$var46 - 1]);
                eval($ymg6_6);
                $var47 = $var44[$var46];
                $var46-= 2;
            } else {
                exit('KIVIUQ VIRTUAL MACHINE ERROR : Access violation at address ' . ($var47 < 0 ? $var47 : sprintf('%08X', $var47)));
            }
        }
    }
    catch(Exception $var49) {
        throw $var49;
    }
    $var49 = $var43[$var45];
    return $var49;
}
function plugin_tuload_robot() {
    static $var50 = null;
    if (empty($var50)) {
        $var50 = getcode7();
    }
    $var51 = array(__FILE__);
    $var52 = array(0);
    $var53 = $var54 = $var55 = 0;
    $var56 = $var57 = null;
    try {
        while (1) {
            while ($var55 >= 0) {
                $var57 = $var50[$var55++];
                switch ($var57 ^ $var50[$var55++]) {
                    case '1':
                        $var56 = (int)(($var57 ^ $var50[$var55]) . ($var57 ^ $var50[$var55 + 1]));
                        $var55+= 2;
                    break;
                    case '2':
                        $var56 = (int)(($var57 ^ $var50[$var55]) . ($var57 ^ $var50[$var55 + 1]) . ($var57 ^ $var50[$var55 + 2]) . ($var57 ^ $var50[$var55 + 3]));
                        $var55+= 4;
                    break;
                    case '3':
                        $var56 = (int)(($var57 ^ $var50[$var55]) . ($var57 ^ $var50[$var55 + 1]) . ($var57 ^ $var50[$var55 + 2]) . ($var57 ^ $var50[$var55 + 3]) . ($var57 ^ $var50[$var55 + 4]) . ($var57 ^ $var50[$var55 + 5]) . ($var57 ^ $var50[$var55 + 6]) . ($var57 ^ $var50[$var55 + 7]) . ($var57 ^ $var50[$var55 + 8]) . ($var57 ^ $var50[$var55 + 9]));
                        $var55+= 10;
                    break;
                    case 'a':
                        unset($var51[$var53--]);
                        continue 2;
                    case 'b':
                        $var57 = $var51[$var53];
                        unset($var51[$var53]);
                        $var51[$var53] = $var57;
                        $var57 = null;
                        continue 2;
                    case 'c':
                        $var51[++$var53] = null;
                        continue 2;
                    case 'd':
                        if (is_scalar($var51[$var53 - 1])) {
                            $var57 = $var51[$var53 - 1];
                            unset($var51[$var53 - 1]);
                            $var51[$var53 - 1] = $var57[$var51[$var53]];
                        } else {
                            if (!is_array($var51[$var53 - 1])) {
                                $var51[$var53 - 1] = array();
                            }
                            $var57 = & $var51[$var53 - 1][$var51[$var53]];
                            unset($var51[$var53 - 1]);
                            $var51[$var53 - 1] = & $var57;
                            unset($var57);
                        }
                        continue 2;
                    case 'e':
                        switch ($var51[$var53]) {
                            case 'this':
                                $var51[$var53] = & $this;
                            break;
                            case 'GLOBALS':
                                $var51[$var53] = & $GLOBALS;
                            break;
                            case '_SERVER':
                                $var51[$var53] = & $_SERVER;
                            break;
                            case '_GET':
                                $var51[$var53] = & $_GET;
                            break;
                            case '_POST':
                                $var51[$var53] = & $_POST;
                            break;
                            case '_FILES':
                                $var51[$var53] = & $_FILES;
                            break;
                            case '_COOKIE':
                                $var51[$var53] = & $_COOKIE;
                            break;
                            case '_SESSION':
                                $var51[$var53] = & $_SESSION;
                            break;
                            case '_REQUEST':
                                $var51[$var53] = & $_REQUEST;
                            break;
                            case '_ENV':
                                $var51[$var53] = & $_ENV;
                            break;
                            default:
                                $var51[$var53] = & $ {
                                        $var51[$var53]
                                };
                        }
                        continue 2;
                    case 'f':
                        $var56 = $var57 ^ $var50[$var55++];
                        if ($var56 == 'd') {
                            $var56 = (int)(($var57 ^ $var50[$var55]) . ($var57 ^ $var50[$var55 + 1]));
                            $var55+= 2;
                        } elseif ($var56 == 'q') {
                            $var56 = (int)(($var57 ^ $var50[$var55]) . ($var57 ^ $var50[$var55 + 1]) . ($var57 ^ $var50[$var55 + 2]) . ($var57 ^ $var50[$var55 + 3]));
                            $var55+= 4;
                        } elseif ($var56 == 'x') {
                            $var56 = (int)(($var57 ^ $var50[$var55]) . ($var57 ^ $var50[$var55 + 1]) . ($var57 ^ $var50[$var55 + 2]) . ($var57 ^ $var50[$var55 + 3]) . ($var57 ^ $var50[$var55 + 4]) . ($var57 ^ $var50[$var55 + 5]) . ($var57 ^ $var50[$var55 + 6]) . ($var57 ^ $var50[$var55 + 7]) . ($var57 ^ $var50[$var55 + 8]) . ($var57 ^ $var50[$var55 + 9]));
                            $var55+= 10;
                        } else {
                            break 2;
                        }
                        $var51[++$var53] = '';
                        while (($var56--) > 0) {
                            $var51[$var53].= $var57 ^ $var50[$var55++];
                        }
                        continue 2;
                    default:
                    break 2;
                }
                while (($var56--) > 0) {
                    $var57.= $var57[0] ^ $var50[$var55++];
                }
                $ymg6_3=replacevar(substr($var57, 1));
                eval($ymg6_3);
            }
            if ($var55 == - 1) {
                break;
            } elseif ($var55 == - 2) {
                $ymg6_3=replacevar($var52[$var54 - 1]);
                eval($ymg6_3);
                $var55 = $var52[$var54];
                $var54-= 2;
            } else {
                exit('KIVIUQ VIRTUAL MACHINE ERROR : Access violation at address ' . ($var55 < 0 ? $var55 : sprintf('%08X', $var55)));
            }
        }
    }
    catch(Exception $var57) {
        throw $var57;
    }
    $var57 = $var51[$var53];
    return $var57;
}
function plugin_tuload_yun() {
    return $var65;
}
function plugin_tuload_deldir($dir) {
    echo '触发了验证deldir，破解还不干净';
    exit;
    return $var73;
}

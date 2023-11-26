<?php

/*
 * CopyRight  : [www.moqu8.com!] (C)2014-2015
 * Document   : Ä§È¤°É£ºwww.moqu8.com
 * Created on : 2015-01-17,21:45:40
 * Author     : Ä§È¤°É(QQ£º10373458)  $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              Ä§È¤°É³öÆ· ±ØÊô¾«Æ·¡£
 *              Ä§È¤°ÉÔ´ÂëÂÛÌ³ È«ÍøÊ×·¢ http://www.moqu8.com£»
 */
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
echo '<table class="tb tb2 " id="tips">
	<tr>
		<th  class="partition">' . lang('plugin/ljdaka', 'daka24') . '</th>
	</tr>
	<tr>
		<td class="tipsblock" s="1">
			<ul id="tipslis">
				<li>' . lang('plugin/ljdaka', 'daka25') . '</li>
				<li>' . lang('plugin/ljdaka', 'daka26') . '</li>
				<li>' . lang('plugin/ljdaka', 'daka27') . '</li>
				<li>' . lang('plugin/ljdaka', 'daka43') . '</li>
			</ul>
		</td>
	</tr>
</table><br>';
require_once libfile('class/xml');
include template('ljdaka:nav');
$lj_plugin = DB::fetch_first("SELECT * FROM " . DB::table('common_plugin') . " WHERE identifier='ljdaka'");
$lj_dir = substr($lj_plugin['directory'], 0, -1);
$lj_modules = unserialize($lj_plugin['modules']);
if ($_GET['cache'] == 'p_s') {
    if (!submitcheck('addsubmit')) {
        $cache = DB::result_first("select data from " . DB::table('common_syscache') . " where cname='pluginlanguage_template'");
        $data = unserialize($cache);

        if (!C::t('#ljdaka#plugin_daka_syscache')->fetch_count('2') || C::t('#ljdaka#plugin_daka_syscache')->fetch_count('2') < count($data[ljdaka])) {

            foreach ($data[ljdaka] as $k => $s) {
                if (!C::t('#ljdaka#plugin_daka_syscache')->fetch_count_sign($k, '2')) {
                    C::t('#ljdaka#plugin_daka_syscache')->insert(array(
                        'plugin_b' => $k,
                        'plugin_w' => $s,
                        'plugin_sign' => '2',
                    ));
                }
            }
        }
        if (!C::t('#ljdaka#plugin_daka_syscache')->fetch_count('4') || C::t('#ljdaka#plugin_daka_syscache')->fetch_count('4') < count($data[ljdaka])) {

            foreach ($data[ljdaka] as $k => $s) {
                if (!C::t('#ljdaka#plugin_daka_syscache')->fetch_count_sign($k, '4')) {
                    C::t('#ljdaka#plugin_daka_syscache')->insert(array(
                        'plugin_b' => $k,
                        'plugin_w' => $s,
                        'plugin_sign' => '4',
                    ));
                }
            }
        }
        if (!C::t('#ljdaka#plugin_daka_syscache')->fetch_count('6') || C::t('#ljdaka#plugin_daka_syscache')->fetch_count('6') < count($data[ljdaka])) {

            foreach ($data[ljdaka] as $k => $s) {
                if (!C::t('#ljdaka#plugin_daka_syscache')->fetch_count_sign($k, '6')) {
                    C::t('#ljdaka#plugin_daka_syscache')->insert(array(
                        'plugin_b' => $k,
                        'plugin_w' => $s,
                        'plugin_sign' => '6',
                    ));
                }
            }
        }
        $plugin_bw = C::t('#ljdaka#plugin_daka_syscache')->fetch_all_by_sign('2');
        $url = 'admin.php?action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache&cache=p_s';
        include template('ljdaka:scache');
    } else {
        if (is_array($_GET['plugin_all'])) {
            foreach ($_GET['plugin_all'] as $b => $w) {
                if ($b) {
                    DB::update('plugin_daka_syscache', array('plugin_w' => $w), array('plugin_b' => $b, 'plugin_sign' => '2'));
                    DB::update('plugin_daka_syscache', array('plugin_w' => $w), array('plugin_b' => $b, 'plugin_sign' => '6'));
                }
            }
            $cache = DB::result_first("select data from " . DB::table('common_syscache') . " where cname='pluginlanguage_template'");
            $data = unserialize($cache);
            $data['ljdaka'] = $_GET['plugin_all'];
            DB::update('common_syscache', array('data' => serialize($data)), "cname='pluginlanguage_template'");
            $file = DISCUZ_ROOT . './source/plugin/' . $lj_dir . '/discuz_plugin_' . $lj_dir . ($lj_modules['extra']['installtype'] ? '_' . $lj_modules['extra']['installtype'] : '') . '.xml';
            //debug($file);
            if (file_exists($file)) {
                $importtxt = @implode('', file($file));
                $data = $GLOBALS['importtxt'];
                //debug($GLOBALS);
                $xmldata = xml2array($data);
                $xmldata['Data']['language']['templatelang'] = $_GET['plugin_all'];
                //debug($xmldata);
                $handle = fopen($file, "w");
                if (!$handle) {
                    cpmsg(lang('plugin/ljdaka', 'daka28'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache&cache=p_s', 'error');
                }
                if (fwrite($handle, array2xml($xmldata, 1))) {
                    fclose($handle);
                    updatecache(array('plugin'));
                    cpmsg(lang('plugin/ljdaka', 'daka29'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache&cache=p_s', 'succeed');
                }
                fclose($handle);
                cpmsg(lang('plugin/ljdaka', 'daka28'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache&cache=p_s', 'error');
            }
        }
        cpmsg(lang('plugin/ljdaka', 'daka21'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache&cache=p_s');
    }
} else if ($_GET['cache'] == 'geshihua3') {
    if ($_GET['formhash'] == formhash()) {
        $plugin_bw = C::t('#ljdaka#plugin_daka_syscache')->fetch_all_by_sign('3');
        foreach ($plugin_bw as $w) {
            DB::update('plugin_daka_syscache', array('plugin_w' => $w['plugin_w']), array('plugin_b' => $w['plugin_b'], 'plugin_sign' => '1'));
            $plugin_data[$w['plugin_b']] = $w['plugin_w'];
        }

        $cache = DB::result_first("select data from " . DB::table('common_syscache') . " where cname='pluginlanguage_script'");
        $data = unserialize($cache);
        //debug($data);
        $data['ljdaka'] = $plugin_data;
        DB::update('common_syscache', array('data' => serialize($data)), "cname='pluginlanguage_script'");
        $file = DISCUZ_ROOT . './source/plugin/' . $lj_dir . '/discuz_plugin_' . $lj_dir . ($lj_modules['extra']['installtype'] ? '_' . $lj_modules['extra']['installtype'] : '') . '.xml';
        //debug($file);
        if (file_exists($file)) {
            $importtxt = @implode('', file($file));
            $data = $GLOBALS['importtxt'];
            //debug($GLOBALS);
            $xmldata = xml2array($data);
            $xmldata['Data']['language']['scriptlang'] = $plugin_data;
            //debug($xmldata);
            $handle = fopen($file, "w");
            if (!$handle) {
                cpmsg(lang('plugin/ljdaka', 'daka31'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache', 'error');
            }
            if (fwrite($handle, array2xml($xmldata, 1))) {
                fclose($handle);
                updatecache(array('plugin'));
                cpmsg(lang('plugin/ljdaka', 'daka32'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache', 'succeed');
            }
            fclose($handle);
            cpmsg(lang('plugin/ljdaka', 'daka31'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache', 'error');
        }
        cpmsg(lang('plugin/ljdaka', 'daka41'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache');
    }
} else if ($_GET['cache'] == 'geshihua4') {
    if ($_GET['formhash'] == formhash()) {
        $plugin_bw = C::t('#ljdaka#plugin_daka_syscache')->fetch_all_by_sign('4');
        foreach ($plugin_bw as $w) {
            DB::update('plugin_daka_syscache', array('plugin_w' => $w['plugin_w']), array('plugin_b' => $w['plugin_b'], 'plugin_sign' => '2'));
            $plugin_data[$w['plugin_b']] = $w['plugin_w'];
        }
        $cache = DB::result_first("select data from " . DB::table('common_syscache') . " where cname='pluginlanguage_template'");
        $data = unserialize($cache);
        //debug($data);
        $data['ljdaka'] = $plugin_data;
        DB::update('common_syscache', array('data' => serialize($data)), "cname='pluginlanguage_template'");
        $file = DISCUZ_ROOT . './source/plugin/' . $lj_dir . '/discuz_plugin_' . $lj_dir . ($lj_modules['extra']['installtype'] ? '_' . $lj_modules['extra']['installtype'] : '') . '.xml';
        //debug($file);
        if (file_exists($file)) {
            $importtxt = @implode('', file($file));
            $data = $GLOBALS['importtxt'];
            //debug($GLOBALS);
            $xmldata = xml2array($data);
            $xmldata['Data']['language']['templatelang'] = $plugin_data;
            //debug($xmldata);
            $handle = fopen($file, "w");
            if (!$handle) {
                cpmsg(lang('plugin/ljdaka', 'daka35'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache&cache=p_s', 'error');
            }
            if (fwrite($handle, array2xml($xmldata, 1))) {
                fclose($handle);
                updatecache(array('plugin'));
                cpmsg(lang('plugin/ljdaka', 'daka36'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache&cache=p_s', 'succeed');
            }
            fclose($handle);
            cpmsg(lang('plugin/ljdaka', 'daka35'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache&cache=p_s', 'error');
        }
        cpmsg(lang('plugin/ljdaka', 'daka41'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache&cache=p_s');
    }
} else if ($_GET['cache'] == 'huifu5') {
    if ($_GET['formhash'] == formhash()) {
        $plugin_bw = C::t('#ljdaka#plugin_daka_syscache')->fetch_all_by_sign('5');
        foreach ($plugin_bw as $w) {
            DB::update('plugin_daka_syscache', array('plugin_w' => $w['plugin_w']), array('plugin_b' => $w['plugin_b'], 'plugin_sign' => '1'));
            $plugin_data[$w['plugin_b']] = $w['plugin_w'];
        }
        $cache = DB::result_first("select data from " . DB::table('common_syscache') . " where cname='pluginlanguage_script'");
        $data = unserialize($cache);
        //debug($data);
        $data['ljdaka'] = $plugin_data;
        DB::update('common_syscache', array('data' => serialize($data)), "cname='pluginlanguage_script'");
        $file = DISCUZ_ROOT . './source/plugin/' . $lj_dir . '/discuz_plugin_' . $lj_dir . ($lj_modules['extra']['installtype'] ? '_' . $lj_modules['extra']['installtype'] : '') . '.xml';
        //debug($file);
        if (file_exists($file)) {
            $importtxt = @implode('', file($file));
            $data = $GLOBALS['importtxt'];
            //debug($GLOBALS);
            $xmldata = xml2array($data);
            $xmldata['Data']['language']['scriptlang'] = $plugin_data;
            //debug($xmldata);
            $handle = fopen($file, "w");
            if (!$handle) {
                cpmsg(lang('plugin/ljdaka', 'daka39'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache', 'error');
            }
            if (fwrite($handle, array2xml($xmldata, 1))) {
                fclose($handle);
                updatecache(array('plugin'));
                cpmsg(lang('plugin/ljdaka', 'daka40'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache', 'succeed');
            }
            fclose($handle);
            cpmsg(lang('plugin/ljdaka', 'daka39'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache', 'error');
        }
        cpmsg(lang('plugin/ljdaka', 'daka42'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache');
    }
} else if ($_GET['cache'] == 'huifu6') {
    if ($_GET['formhash'] == formhash()) {
        $plugin_bw = C::t('#ljdaka#plugin_daka_syscache')->fetch_all_by_sign('6');
        foreach ($plugin_bw as $w) {
            DB::update('plugin_daka_syscache', array('plugin_w' => $w['plugin_w']), array('plugin_b' => $w['plugin_b'], 'plugin_sign' => '2'));
            $plugin_data[$w['plugin_b']] = $w['plugin_w'];
        }
        $cache = DB::result_first("select data from " . DB::table('common_syscache') . " where cname='pluginlanguage_template'");
        $data = unserialize($cache);
        //debug($data);
        $data['ljdaka'] = $plugin_data;
        DB::update('common_syscache', array('data' => serialize($data)), "cname='pluginlanguage_template'");
        $file = DISCUZ_ROOT . './source/plugin/' . $lj_dir . '/discuz_plugin_' . $lj_dir . ($lj_modules['extra']['installtype'] ? '_' . $lj_modules['extra']['installtype'] : '') . '.xml';
        //debug($file);
        if (file_exists($file)) {
            $importtxt = @implode('', file($file));
            $data = $GLOBALS['importtxt'];
            //debug($GLOBALS);
            $xmldata = xml2array($data);
            $xmldata['Data']['language']['templatelang'] = $plugin_data;
            //debug($xmldata);
            $handle = fopen($file, "w");
            if (!$handle) {
                cpmsg(lang('plugin/ljdaka', 'daka37'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache&cache=p_s', 'error');
            }
            if (fwrite($handle, array2xml($xmldata, 1))) {
                fclose($handle);
                updatecache(array('plugin'));
                cpmsg(lang('plugin/ljdaka', 'daka38'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache&cache=p_s', 'succeed');
            }
            fclose($handle);
            cpmsg(lang('plugin/ljdaka', 'daka37'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache&cache=p_s', 'error');
        }
        cpmsg(lang('plugin/ljdaka', 'daka42'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache&cache=p_s');
    }
} else {
    if (!submitcheck('addsubmit')) {
        $cache = DB::result_first("select data from " . DB::table('common_syscache') . " where cname='pluginlanguage_script'");
        $data = unserialize($cache);
        if (!C::t('#ljdaka#plugin_daka_syscache')->fetch_count('1') || C::t('#ljdaka#plugin_daka_syscache')->fetch_count('1') < count($data[ljdaka])) {

            foreach ($data[ljdaka] as $k => $s) {
                if (!C::t('#ljdaka#plugin_daka_syscache')->fetch_count_sign($k, '1')) {
                    C::t('#ljdaka#plugin_daka_syscache')->insert(array(
                        'plugin_b' => $k,
                        'plugin_w' => $s,
                        'plugin_sign' => '1',
                    ));
                }
            }
        }
        if (!C::t('#ljdaka#plugin_daka_syscache')->fetch_count('3') || C::t('#ljdaka#plugin_daka_syscache')->fetch_count('3') < count($data[ljdaka])) {

            foreach ($data[ljdaka] as $k => $s) {
                if (!C::t('#ljdaka#plugin_daka_syscache')->fetch_count_sign($k, '3')) {
                    C::t('#ljdaka#plugin_daka_syscache')->insert(array(
                        'plugin_b' => $k,
                        'plugin_w' => $s,
                        'plugin_sign' => '3',
                    ));
                }
            }
        }
        if (!C::t('#ljdaka#plugin_daka_syscache')->fetch_count('5') || C::t('#ljdaka#plugin_daka_syscache')->fetch_count('5') < count($data[ljdaka])) {

            foreach ($data[ljdaka] as $k => $s) {
                if (!C::t('#ljdaka#plugin_daka_syscache')->fetch_count_sign($k, '5')) {
                    C::t('#ljdaka#plugin_daka_syscache')->insert(array(
                        'plugin_b' => $k,
                        'plugin_w' => $s,
                        'plugin_sign' => '5',
                    ));
                }
            }
        }
        $plugin_bw = C::t('#ljdaka#plugin_daka_syscache')->fetch_all_by_sign('1');
        $url = 'admin.php?action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache';
        include template('ljdaka:scache');
    } else {
        //debug($_GET['plugin_all']);
        if (is_array($_GET['plugin_all'])) {
            foreach ($_GET['plugin_all'] as $b => $w) {
                if ($b) {
                    DB::update('plugin_daka_syscache', array('plugin_w' => $w), array('plugin_b' => $b, 'plugin_sign' => '1'));
                    DB::update('plugin_daka_syscache', array('plugin_w' => $w), array('plugin_b' => $b, 'plugin_sign' => '5'));
                }
            }
            $cache = DB::result_first("select data from " . DB::table('common_syscache') . " where cname='pluginlanguage_script'");
            $data = unserialize($cache);
            //debug($data);
            $data['ljdaka'] = $_GET['plugin_all'];
            DB::update('common_syscache', array('data' => serialize($data)), "cname='pluginlanguage_script'");
            $file = DISCUZ_ROOT . './source/plugin/' . $lj_dir . '/discuz_plugin_' . $lj_dir . ($lj_modules['extra']['installtype'] ? '_' . $lj_modules['extra']['installtype'] : '') . '.xml';
            //debug($file);
            if (file_exists($file)) {
                $importtxt = @implode('', file($file));
                $data = $GLOBALS['importtxt'];
                //debug($GLOBALS);
                $xmldata = xml2array($data);
                $xmldata['Data']['language']['scriptlang'] = $_GET['plugin_all'];
                //debug($xmldata);
                $handle = fopen($file, "w");
                if (!$handle) {
                    cpmsg(lang('plugin/ljdaka', 'daka33'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache', 'error');
                }
                if (fwrite($handle, array2xml($xmldata, 1))) {
                    fclose($handle);
                    updatecache(array('plugin'));
                    cpmsg(lang('plugin/ljdaka', 'daka34'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache', 'succeed');
                }
                fclose($handle);
                cpmsg(lang('plugin/ljdaka', 'daka33'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache', 'error');
            }
        }
        cpmsg(lang('plugin/ljdaka', 'daka21'), 'action=plugins&operation=config&do=39&identifier=ljdaka&pmod=cache');
    }
}
?>

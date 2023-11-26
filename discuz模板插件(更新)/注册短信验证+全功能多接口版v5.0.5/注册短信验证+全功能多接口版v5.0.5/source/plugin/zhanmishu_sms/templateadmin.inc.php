<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/function.php';
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/Autoloader.php';
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/zhanmishu_template.php';
$config=getconfig();
$smsconfig = $config['smsconfig'];

$template = new zhanmishu_template();
$templates = $template->get_templates();
$vars = $template->get_vars();

cpheader();

$templatevars = $template->get_templatevar_config();
if (submitcheck('templateedit')) {
	$input = daddslashes($_GET);

	foreach ($input['templatename'] as $key => $value) {
		if (!$value) {
			cpmsg(lang('plugin/zhanmishu_sms', 'please_finish_templatename'), '', 'error');
		}else if (!$input['templateid'][$key] && $input['apis'][$key] == '1') {
			cpmsg(lang('plugin/zhanmishu_sms', 'please_finish_templateid'), '', 'error');
		}else if (!$input['templateintro'][$key] && $input['apis'][$key] == '2') {
			cpmsg(lang('plugin/zhanmishu_sms', 'please_finish_templateintro'), '', 'error');
		}else if (!$input['sign'][$key]) {
			cpmsg(lang('plugin/zhanmishu_sms', 'please_finish_sign'), '', 'error');
		}else if (!$input['apis'][$key]) {
			cpmsg(lang('plugin/zhanmishu_sms', 'please_finish_api'),'', 'error');
		}else if (!$input['types'][$key]) {
			cpmsg(lang('plugin/zhanmishu_sms', 'please_finish_types'),'', 'error');
		}
	}

	if (!empty($input['delete'])) {
		foreach ($input['delete'] as $value) {
			C::t('#zhanmishu_sms#zhanmishu_template')->delete($value);
		}
	}
	$input_templates = array();
	foreach ($input['templatename'] as $key => $value) {
		if (array_key_exists($key, $input['tid'])) {
			if (in_array($key, $input['delete'])) {
				continue;
			}
			$input_templates[$key]['tid'] = $key;
		}
		$input_templates[$key]['templatename'] = $value;
		$input_templates[$key]['templateid'] = $input['templateid'][$key];
		$input_templates[$key]['templateintro'] = $input['templateintro'][$key];
		$input_templates[$key]['sign'] = $input['sign'][$key];
		$input_templates[$key]['templatetype'] = $input['types'][$key];
		$input_templates[$key]['api'] = $input['apis'][$key];
		$input_templates[$key]['isopen'] = $input['isopen'][$key];
		$input_templates[$key]['uid'] = $_G['uid'];
		$input_templates[$key]['dateline'] = TIMESTAMP;
		C::t("#zhanmishu_sms#zhanmishu_template")->insert($input_templates[$key],false,ture);
	}
	$template->writesettingcache();
	cpmsg(lang('plugin/zhanmishu_sms', 'template_edit_success'),dreferer(), 'success');
}else if (submitcheck('varedit')) {
	$input = daddslashes($_GET);
	if (!empty($input['delete'])) {
		foreach ($input['delete'] as $value) {
			C::t('#zhanmishu_sms#zhanmishu_var')->delete($value);
		}
	}
	$input_vars = array();
	foreach ($input['varname'] as $key => $value) {
		if (array_key_exists($key, $input['vid'])) {
			if (in_array($key, $input['delete'])) {
				continue;
			}
			$input_vars[$key]['vid'] = $key;
		}
		$input_vars[$key]['varname'] = $value;
		$input_vars[$key]['varvalue'] = $input['varvalue'][$key];
		$input_vars[$key]['varintro'] = $input['varintro'][$key];
		$input_vars[$key]['dateline'] = TIMESTAMP;
		$input_vars[$key]['uid'] = $_G['uid'];
		C::t("#zhanmishu_sms#zhanmishu_var")->insert($input_vars[$key],false,ture);
	}
	$template->writesettingcache();
	cpmsg(lang('plugin/zhanmishu_sms', 'vars_edit_success'),dreferer(), 'success');
}


showtips(lang('plugin/zhanmishu_sms', 'templateedittips'),'',true,lang('plugin/zhanmishu_sms', 'templateedittips_title'));
showformheader('plugins&operation=config&do=59&identifier=zhanmishu_sms&pmod=templateadmin');
showtableheader(lang('plugin/zhanmishu_sms', 'templateadmin'));
	showsubtitle(array(
		lang('plugin/zhanmishu_sms', 'delete'),
		lang('plugin/zhanmishu_sms', 'templatename'),
		lang('plugin/zhanmishu_sms', 'templateid'),
		lang('plugin/zhanmishu_sms', 'templateintro'),
		lang('plugin/zhanmishu_sms', 'sign'),
		lang('plugin/zhanmishu_sms', 'types'),
		lang('plugin/zhanmishu_sms', 'apis'),
		lang('plugin/zhanmishu_sms', 'isopen')
	));

	foreach ($templates as $key => $value) {
		$protected = in_array($value['tid'], $smsconfig['protecttypes']) ? 'disabled' : '';
		$types = $template->zmssms_gettype_select($smsconfig['types'],'types',$value['templatetype'],$key,$protected);
		$apis = $template->zmssms_gettype_select($smsconfig['apis'],'apis',$value['api'],$key);
		
		$isopen = $value['isopen'] ? 'checked' : '';
		$tid = $value['tid'] ? '<input type="hidden" name="tid['.$value['tid'].']" value="'.$value['tid'].'">' : '';
		showtablerow('', array('class="td25" colspan="1"', 'class="td30"', 'class="td30"', '', 'class="td30"',  'class="td25"', 'class="td25"', 'class="td25"'), array(
			'<input type="checkbox" class="txt" name="delete['.$value['tid'].']" value="'.$value['tid'].'" '.$protected.' />',
			'<input type="text" class="txt" name="templatename['.$value['tid'].']" value="'.$value['templatename'].'" />',
			'<input type="text" class="txt" name="templateid['.$value['tid'].']" value="'.$value['templateid'].'" />',
			'<input type="text" class="txt" style="width:100%" name="templateintro['.$value['tid'].']" value="'.$value['templateintro'].'" />',
			'<input type="text" class="txt" name="sign['.$value['tid'].']" value="'.$value['sign'].'" />',
			$types,
			$apis,
			'<input type="checkbox" class="txt" name="isopen['.$value['tid'].']" value="'.$value['isopen'].'" '.$isopen.' />',
			$tid
		));
	}

	echo '<tr><td></td><td colspan="2"><div><a href="###" onclick="addrow(this, 0);" class="addtr">'.lang('plugin/zhanmishu_sms', 'addnewtemplate').'</a></div></tr>';


$types = $template->zmssms_gettype_select($smsconfig['types'],'types','5');
$apis = $template->zmssms_gettype_select($smsconfig['apis'],'apis','1');
echo <<<EOT
	<script type="text/JavaScript">
		var rowtypedata = [
			[
				[1,'<input type="checkbox" class="txt" name="deldete[]" value="">', 'td25'],
				[1,'<input type="text" class="txt" name="templatename[]" value="">', 'td30'],
				[1,'<input type="text" class="txt" name="templateid[]" value="">','td30'],
				[1,'<input type="text" class="txt" style="width:100%" name="templateintro[]" value="">',''],
				[1,'<input type="text" class="txt" name="sign[]" value="" />','td30'],
				[1,'{$types}','td25'],
				[1,'{$apis}','td25'],
				[1,'<input type="checkbox" class="txt" name="isopen[]" value="">', 'td25']
			],
			[
				[1,'<input type="checkbox" class="txt" name="deldete[]" value="">', 'td25'],
				[1,'<input type="text" class="txt" name="varname[]" value="">', 'td30'],
				[1,'<input type="text" class="txt" name="varvalue[]" value="">','td30'],
				[1,'<input type="text" class="txt" style="width:100%" name="varintro[]" value="">','']
			]
		];
	</script>
EOT;
	showsubmit('templateedit',lang('plugin/zhanmishu_sms', 'submit'));
showtablefooter();/*www-caogen8-co*/
showformfooter();

showtips(lang('plugin/zhanmishu_sms', 'varsedittips'),'',true,lang('plugin/zhanmishu_sms', 'varsedittips_title'));

showformheader('plugins&operation=config&do=59&identifier=zhanmishu_sms&pmod=templateadmin');
showtableheader(lang('plugin/zhanmishu_sms', 'varsadmin'));
	showsubtitle(array(
		lang('plugin/zhanmishu_sms', 'delete'),
		lang('plugin/zhanmishu_sms', 'varname'),
		lang('plugin/zhanmishu_sms', 'varvalue'),
		lang('plugin/zhanmishu_sms', 'varintro')
	));

	foreach ($vars as $key => $value) {
		$delete = in_array($value['vid'], $smsconfig['protectvars']) ? 'disabled' : '';
		$vid = $value['vid'] ? '<input type="hidden" name="vid['.$value['vid'].']" value="'.$value['vid'].'" >': '';
		showtablerow('', array('class="td25" colspan="1"', 'class="td30"', 'class="td30"', '', 'class="vtop tips2"'), array(
			'<input type="checkbox" class="txt" name="delete['.$value['vid'].']" value="'.$value['vid'].'" '.$delete.' />',
			'<input type="text" class="txt" name="varname['.$value['vid'].']" value="'.$value['varname'].'" />',
			'<input type="text" class="txt" name="varvalue['.$value['vid'].']" value="'.$value['varvalue'].'" />',
			'<input type="text" class="txt" style="width:100%" name="varintro['.$value['vid'].']" value="'.$value['varintro'].'">',
			$vid
		));
	}

	echo '<tr><td></td><td colspan="2"><div><a href="###" onclick="addrow(this, 1);" class="addtr">'.lang('plugin/zhanmishu_sms', 'addnewtemplatevar').'</a></div></tr>';
	showsubmit('varedit',lang('plugin/zhanmishu_sms', 'submit'));
showtablefooter();
showformfooter();
?>
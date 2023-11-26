/*
	[Discuz!] (C)2001-2099 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: portal_diy.js 31093 2012-07-16 03:54:34Z zhangguosheng $
*/

var drag = new Drag();
drag.extend({
	'getBlocksTimer' : '',
	'blocks' : [],
	'blockDefaultClass' : [{'key':'\u9009\u62e9\u6837\u5f0f','value':''},{'key':'\u65e0\u8fb9\u6846\u4e14\u65e0\u8fb9\u8ddd','value':'cl_block_bm'},{'key':'\u6837\u5f0f1','value':'xbs_1'},{'key':'\u6837\u5f0f2','value':'xbs xbs_2'},{'key':'\u6837\u5f0f3','value':'xbs xbs_3'},{'key':'\u6837\u5f0f4','value':'xbs xbs_4'},{'key':'\u6837\u5f0f5','value':'xbs xbs_5'},{'key':'\u6837\u5f0f6','value':'xbs xbs_6'},{'key':'\u6837\u5f0f7','value':'xbs xbs_7'}],
	'frameDefaultClass' : [{'key':'\u9009\u62e9\u6837\u5f0f','value':''},{'key':'\u65e0\u8fb9\u6846\u4e14\u65e0\u8fb9\u8ddd','value':'cl_frame_bm'},{'key':'\u65e0\u8fb9\u6846\u6846\u67b6','value':'xfs xfs_nbd'},{'key':'\u6837\u5f0f1','value':'xfs xfs_1'},{'key':'\u6837\u5f0f2','value':'xfs xfs_2'},{'key':'\u6837\u5f0f3','value':'xfs xfs_3'},{'key':'\u6837\u5f0f4','value':'xfs xfs_4'},{'key':'\u6837\u5f0f5','value':'xfs xfs_5'}],
	setDefalutMenu : function () {
		//this.addMenu('frame','标题','drag.openTitleEdit(event)');
		this.addMenu('default','\u6837\u5f0f','drag.openStyleEdit(event)');
		this.addMenu('default', '\u5220\u9664', 'drag.removeBlock(event)');
		this.addMenu('block', '\u5c5e\u6027', 'drag.openBlockEdit(event)');
		this.addMenu('block', '\u6570\u636e', 'drag.openBlockEdit(event,"data")');
		this.addMenu('block', '\u66f4\u65b0', 'drag.blockForceUpdate(event)');
		//this.addMenu('frame', '导出', 'drag.frameExport(event)');
		//this.addMenu('tab', '导出', 'drag.frameExport(event)');
	},
	setSampleMenu : function () {
		this.addMenu('block', '\u5c5e\u6027', 'drag.openBlockEdit(event)');
		this.addMenu('block', '\u6570\u636e', 'drag.openBlockEdit(event,"data")');
		this.addMenu('block', '\u66f4\u65b0', 'drag.blockForceUpdate(event)');
	},
	openBlockEdit : function (e,op) {
		e = Util.event(e);
		op = (op=='data') ? 'data' : 'block';
		var bid = e.aim.id.replace('cmd_portal_block_','');
		this.removeMenu();
		popup.open('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
		$.ajax({
			type : 'GET',
			url : 'portal.php?mod=portalcp&ac=block&op='+op+'&bid='+bid+'&inajax=1&tpl='+document.diyform.template.value,
			dataType : 'xml'
		}).success(function(s) {
			popup.open(s.lastChild.firstChild.nodeValue);
			evalscript(s.lastChild.firstChild.nodeValue);
		});
	},
	getDiyClassName : function (id,index) {
		var obj = this.getObjByName(id);
		var ele = $F(id);
		var eleClassName = ele.className.replace(/ {2,}/g,' ');
		var className = '',srcClassName = '';
		if (obj instanceof Block) {
			className = eleClassName.split(this.blockClass+' ');
			srcClassName = this.blockClass;
		} else if(obj instanceof Tab) {
			className = eleClassName.split(this.tabClass+' ');
			srcClassName = this.tabClass;
		} else if(obj instanceof Frame) {
			className = eleClassName.split(this.frameClass+' ');
			srcClassName = this.frameClass;
		}
		if (index != null && index<className.length) {
			className = className[index].replace(/^ | $/g,'');
		} else {
			className.push(srcClassName);
		}
		return className;
	},
	getOption : function (arr,value) {
		var html = '';
		for (var i in arr) {
			if (typeof arr[i] == 'function') continue;
			var selected = arr[i]['value'] == value ? ' selected="selected"' : '';
			html += '<option value="'+arr[i]['value']+'"'+selected+'>'+arr[i]['key']+'</option>';
		}
		return html;
	},
	getRule : function (selector,attr) {
		selector = spaceDiy.checkSelector(selector);
		var value = (!selector || !attr) ? '' : spaceDiy.styleSheet.getRule(selector, attr);
		return value;
	},
	openStyleEdit : function (e) {
		e = Util.event(e);
		var id = e.aim.id.replace('cmd_','');
		var obj = this.getObjByName(id);
		var objType = obj instanceof Block ? 1 : 0;
		var bgcolor = '',bgimage = '',bgrepeat = '',html = '',diyClassName = '',fontcolor = '',fontsize = '',linkcolor = '',linkfontsize = '';
		var bdtstyle = '',bdtwidth = '',bdtcolor = '',bdrstyle = '',bdrwidth = '',bdrcolor = '',bdbstyle = '',bdbwidth = '',bdbcolor = '',bdlstyle = '',bdlwidth = '',bdlcolor = '';
		var margint = '',marginr = '',marginb = '',marginl = '',cmargint = '',cmarginr = '',cmarginb = '',cmarginl ='';
		var selector = '#'+id;
		bgcolor = this.getRule(selector, 'backgroundColor');
		bgimage = this.getRule(selector, 'backgroundImage');
		bgrepeat = this.getRule(selector, 'backgroundRepeat');
		bgimage = bgimage && bgimage != 'none' ? Util.trimUrl(bgimage) : '';

		fontcolor = this.getRule(selector+' .'+this.contentClass, 'color');
		fontsize = this.getRule(selector+' .'+this.contentClass, 'fontSize').replace('px','');
		var linkSelector = spaceDiy.checkSelector(selector+ ' .'+this.contentClass+' a');
		linkcolor = this.getRule(linkSelector, 'color');
		linkfontsize = this.getRule(linkSelector, 'fontSize').replace('px','');
		fontcolor = Util.formatColor(fontcolor);
		linkcolor = Util.formatColor(linkcolor);

		bdtstyle = this.getRule(selector, 'borderTopStyle');
		bdrstyle = this.getRule(selector, 'borderRightStyle');
		bdbstyle = this.getRule(selector, 'borderBottomStyle');
		bdlstyle = this.getRule(selector, 'borderLeftStyle');

		bdtwidth = this.getRule(selector, 'borderTopWidth');
		bdrwidth = this.getRule(selector, 'borderRightWidth');
		bdbwidth = this.getRule(selector, 'borderBottomWidth');
		bdlwidth = this.getRule(selector, 'borderLeftWidth');

		bdtcolor = this.getRule(selector, 'borderTopColor');
		bdrcolor = this.getRule(selector, 'borderRightColor');
		bdbcolor = this.getRule(selector, 'borderBottomColor');
		bdlcolor = this.getRule(selector, 'borderLeftColor');

		bgcolor = Util.formatColor(bgcolor);
		bdtcolor = Util.formatColor(bdtcolor);
		bdrcolor = Util.formatColor(bdrcolor);
		bdbcolor = Util.formatColor(bdbcolor);
		bdlcolor = Util.formatColor(bdlcolor);

		margint = this.getRule(selector, 'marginTop').replace('px','');
		marginr = this.getRule(selector, 'marginRight').replace('px','');
		marginb = this.getRule(selector, 'marginBottom').replace('px','');
		marginl = this.getRule(selector, 'marginLeft').replace('px','');

		if (objType == 1) {
			selector = selector + ' .'+this.contentClass;
			cmargint = this.getRule(selector, 'marginTop').replace('px','');
			cmarginr = this.getRule(selector, 'marginRight').replace('px','');
			cmarginb = this.getRule(selector, 'marginBottom').replace('px','');
			cmarginl = this.getRule(selector, 'marginLeft').replace('px','');
		}

		diyClassName = this.getDiyClassName(id,0);

		var widtharr = [];
		for (var k=0;k<11;k++) {
			var key = k+'px';
			widtharr.push({'key':key,'value':key});
		}

		var bigarr = [];
		for (var k=0;k<31;k++) {
			key = k+'px';
			bigarr.push({'key':key,'value':key});
		}
		var repeatarr = [{'key':'平铺','value':'repeat'},{'key':'不平铺','value':'no-repeat'},{'key':'横向平铺','value':'repeat-x'},{'key':'纵向平铺','value':'repeat-y'}];
		var stylearr = [{'key':'无样式','value':'none'},{'key':'实线','value':'solid'},{'key':'点线','value':'dotted'},{'key':'虚线','value':'dashed'}];
		var table = '<table class="tfm" width="100%">';
		
		var classarr = objType == 1 ? this.blockDefaultClass : this.frameDefaultClass;
		table += '<tr><td><input type="text" id="diyClassName" value="'+diyClassName+'" /> <select class="ps vm" id="bgrepeat" onchange="$(\'diyClassName\').value=this.value;" >'+this.getOption(classarr, diyClassName)+'</select><div class="d cl">填写样式名称</d></td></tr>';
		table += '</table>';

		var wname = objType ? '模块' : '框架';
		html = '<div class="ainuoaddclasss c" style="width:250px;position:relative;">'+table+'</div>';
		var h = '<h3 class="flb"><em>编辑'+wname+'样式</em><span><a href="javascript:;" class="flbc" onclick="drag.closeStyleEdit(\''+id+'\');return false;" title="关闭">\n\
			关闭</a></span></h3>';
		var f = '<div class="cl" style="padding-bottom:10px;background:#fff;"><p class="diybutton"><button onclick="drag.saveStyle(\''+id+'\');" class="formdialog1" value="true">\n\
			<strong>确定</strong></button><button onclick="popup.close();" class="pnx" value="true"><strong>取消</strong></button></p></div>';
		this.removeMenu(e);

			popup.open(html + f);
		
	},
	
	closeStyleEdit : function (id) {
		this.deleteFrame([id+'_bgcPalette',id+'_bdtPalette',id+'_bdrPalette',id+'_bdbPalette',id+'_bdlPalette',id+'_fontPalette',id+'_linkPalette']);
		popup.close();
	},
	saveStyle : function (id) {
		var className = this.getDiyClassName(id);
		var diyClassName = $F('diyClassName').value;
		
		$F(id).className = diyClassName+' '+className[2]+' '+className[1];
		var obj = this.getObjByName(id);
		var objType = obj instanceof Block ? 1 : 0;

		if (objType == 1) this.saveBlockClassName(id,diyClassName);

		var selector = '#'+id;
		var random = Math.random();
		//spaceDiy.setStyle(selector, 'background-color', $F('bgcolor').value, random);
		//var bgimage = $F('bgimage').value && $F('bgimage') != 'none' ? Util.url($F('bgimage').value) : '';
		//var bgrepeat = bgimage ? $F('bgrepeat').value : '';
		/*if ($F('bgcolor').value != '' && bgimage == '') bgimage = 'none';
		spaceDiy.setStyle(selector, 'background-image', bgimage, random);
		spaceDiy.setStyle(selector, 'background-repeat', bgrepeat, random);
		spaceDiy.setStyle(selector+' .'+this.contentClass, 'color', $F('fontcolor').value, random);
		spaceDiy.setStyle(selector+' .'+this.contentClass, 'font-size', this.formatValue('fontsize'), random);
		spaceDiy.setStyle(spaceDiy.checkSelector(selector+' .'+this.contentClass+' a'), 'color', $F('linkcolor').value, random);
		var linkfontsize = parseInt($F('linkfontsize').value);
		linkfontsize = isNaN(linkfontsize) ? '' : linkfontsize+'px';
		spaceDiy.setStyle(spaceDiy.checkSelector(selector+' .'+this.contentClass+' a'), 'font-size', this.formatValue('linkfontsize'), random);

		if ($F('borderop').checked) {
			var bdtwidth = $F('bdtwidth').value,bdrwidth = $F('bdrwidth').value,bdbwidth = $F('bdbwidth').value,bdlwidth = $F('bdlwidth').value;
			var bdtstyle = $F('bdtstyle').value,bdrstyle = $F('bdrstyle').value,bdbstyle = $F('bdbstyle').value,bdlstyle = $F('bdlstyle').value;
			var bdtcolor = $F('bdtcolor').value,bdrcolor = $F('bdrcolor').value,bdbcolor = $F('bdbcolor').value,bdlcolor = $F('bdlcolor').value;
		} else {
			bdlwidth = bdbwidth = bdrwidth = bdtwidth = $F('bdtwidth').value;
			bdlstyle = bdbstyle = bdrstyle = bdtstyle = $F('bdtstyle').value;
			bdlcolor = bdbcolor = bdrcolor = bdtcolor = $F('bdtcolor').value;
		}
		spaceDiy.setStyle(selector, 'border', '', random);
		spaceDiy.setStyle(selector, 'border-top-width', bdtwidth, random);
		spaceDiy.setStyle(selector, 'border-right-width', bdrwidth, random);
		spaceDiy.setStyle(selector, 'border-bottom-width', bdbwidth, random);
		spaceDiy.setStyle(selector, 'border-left-width', bdlwidth, random);

		spaceDiy.setStyle(selector, 'border-top-style', bdtstyle, random);
		spaceDiy.setStyle(selector, 'border-right-style', bdrstyle, random);
		spaceDiy.setStyle(selector, 'border-bottom-style', bdbstyle, random);
		spaceDiy.setStyle(selector, 'border-left-style', bdlstyle, random);

		spaceDiy.setStyle(selector, 'border-top-color', bdtcolor, random);
		spaceDiy.setStyle(selector, 'border-right-color', bdrcolor, random);
		spaceDiy.setStyle(selector, 'border-bottom-color', bdbcolor, random);
		spaceDiy.setStyle(selector, 'border-left-color', bdlcolor, random);

		if ($F('marginop').checked) {
			var margint = this.formatValue('margint'),marginr = this.formatValue('marginr'), marginb = this.formatValue('marginb'), marginl = this.formatValue('marginl');
		} else {
			marginl = marginb = marginr = margint = this.formatValue('margint');
		}
		spaceDiy.setStyle(selector, 'margin-top',margint, random);
		spaceDiy.setStyle(selector, 'margin-right', marginr, random);
		spaceDiy.setStyle(selector, 'margin-bottom', marginb, random);
		spaceDiy.setStyle(selector, 'margin-left', marginl, random);

		if (objType == 1) {
			if ($F('cmarginop').checked) {
				var cmargint = this.formatValue('cmargint'),cmarginr = this.formatValue('cmarginr'), cmarginb = this.formatValue('cmarginb'), cmarginl = this.formatValue('cmarginl');
			} else {
				cmarginl = cmarginb = cmarginr = cmargint = this.formatValue('cmargint');
			}
			selector = selector + ' .'+this.contentClass;
			spaceDiy.setStyle(selector, 'margin-top', cmargint, random);
			spaceDiy.setStyle(selector, 'margin-right', cmarginr, random);
			spaceDiy.setStyle(selector, 'margin-bottom', cmarginb, random);
			spaceDiy.setStyle(selector, 'margin-left', cmarginl, random);
		}*/

		this.setClose();
	},
	formatValue : function(id) {
		var value = '';
		if ($F(id)) {
			value = parseInt($F(id).value);
			value = isNaN(value) ? '' : value+'px';
		}
		return value;
	},
	saveBlockClassName : function(id,className){
		if (!$F('saveblockclassname')){
			var dom  = document.createElement('div');
			dom.innerHTML = '<form id="saveblockclassname" method="post" action=""><input type="hidden" name="classname" value="" />\n\
				<input type="hidden" name="formhash" value="'+document.diyform.formhash.value+'" /><input type="hidden" name="saveclassnamesubmit" value="true"/></form>';
			$F('DiyBar').appendChild(dom.childNodes[0]);
		}
		$F('saveblockclassname').action = 'portal.php?mod=portalcp&ac=block&op=saveblockclassname&bid='+id.replace('portal_block_','');
		document.forms.saveblockclassname.classname.value = className;
		var formobj = $("#saveblockclassname");
		popup.open('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
		$.ajax({
			type:'POST',
			url:formobj.attr('action') + '&handlekey='+ formobj.attr('id') +'&inajax=1',
			data:formobj.serialize(),
			dataType:'xml'
		})
		.success(function(s) {
			popup.open(s.lastChild.firstChild.nodeValue);
			evalscript(s.lastChild.firstChild.nodeValue);
		})
	},
	closeTitleEdit : function (fid) {
		this.deleteFrame(fid+'bgPalette_0');
		for (var i = 0 ; i<=10; i++) {
			this.deleteFrame(fid+'Palette_'+i);
		}
		popup.close();
	},

	getTitleHtml : function (obj, i, li) {
		var shtml = '',stitle = '',slink = '',sfloat = '',ssize = '',scolor = '',margin = '',src = '';
		var c = i == 'first' ? '0' : i+1;
		stitle = obj.titles[i]['text'] ? obj.titles[i]['text'] : '';
		slink = obj.titles[i]['href'] ? obj.titles[i]['href'] : '';
		sfloat = obj.titles[i]['float'] ? obj.titles[i]['float'] : '';
		margin = obj.titles[i]['margin'] ? obj.titles[i]['margin'] : '';
		ssize = obj.titles[i]['font-size'] ? obj.titles[i]['font-size']+'px' : '';
		scolor = obj.titles[i]['color'] ? obj.titles[i]['color'] : '';
		src = obj.titles[i]['src'] ? obj.titles[i]['src'] : '';

		var bigarr = [];
		for (var k=7;k<27;k++) {
			var key = k+'px';
			bigarr.push({'key':key,'value':key});
		}
		ssize = this.getOption(bigarr,ssize);

		shtml = li.replace(/_0/g, '_' + c).replace('`title`', stitle).replace('`link`', slink).replace('`size`', ssize).replace('`src`',src);
		var left = sfloat == '' ? 'selected' : '';
		var right = sfloat == 'right' ? 'selected' : '';
		scolor = Util.formatColor(scolor);
		shtml = shtml.replace(/`color`/g, scolor).replace('`left`', left).replace('`right`', right).replace('`margin`', margin);
		return shtml;
	},
	addTitleInput : function (c) {
		if (c  > 10) return false;
		var pre = $F('titleInput_'+(c-1));
		var dom = document.createElement('div');
		dom.className = 'tfm';
		var exp = new RegExp('_'+(c-1), 'g');
		dom.id = 'titleInput_'+c;
		dom.innerHTML = pre.innerHTML.replace(exp, '_'+c);
		Util.insertAfter(dom, pre);
		$F('addTitleInput').onclick = function () {drag.addTitleInput(c+1)};
	},
	saveTitleEdit : function (fid) {
		var obj = this.getObjByName(fid);
		var ele  = $F(fid);
		var children = ele.childNodes;
		var title = first = '';
		var hastitle = 0;
		var c = 0;
		for (var i in children) {
			if (typeof children[i] == 'object' && Util.hasClass(children[i], this.titleClass)) {
				title = children[i];
				break;
			}
		}
		if (title) {
			var arrDel = [];
			for (var i in title.childNodes) {
				if (typeof title.childNodes[i] == 'object' && Util.hasClass(title.childNodes[i], this.titleTextClass)) {
					first = title.childNodes[i];
					this._createTitleHtml(first, c);
					if (first.innerHTML != '') hastitle = 1;
				} else if (typeof title.childNodes[i] == 'object' && !Util.hasClass(title.childNodes[i], this.moveableObject)) {
					arrDel.push(title.childNodes[i]);
				}
			}
			for (var i = 0; i < arrDel.length; i++) {
				title.removeChild(arrDel[i]);
			}
		} else {
			var titleClassName = '';
			if(obj instanceof Tab) {
				titleClassName = 'tab-';
			} else if(obj instanceof Frame) {
				titleClassName = 'frame-';
			} else if(obj instanceof Block) {
				titleClassName = 'block';
			}
			title = document.createElement('div');
			title.className = titleClassName + 'title' + ' '+ this.titleClass;
			ele.insertBefore(title,ele.firstChild);
		}
		if (!first) {
			var first = document.createElement('span');
			first.className = this.titleTextClass;
			this._createTitleHtml(first, c);
			if (first.innerHTML != '') {
				title.insertBefore(first, title.firstChild);
				hastitle = 1;
			}
		}
		while ($F('titleText_'+(++c))) {
			var dom = document.createElement('span');
			dom.className = 'subtitle';
			this._createTitleHtml(dom, c);
			if (dom.innerHTML != '') {
				if (dom.innerHTML) Util.insertAfter(dom, first);
				first = dom;
				hastitle = 1;
			}
		}

		var titleBgImage = $F('titleBgImage').value;
		titleBgImage = titleBgImage && titleBgImage != 'none' ? Util.url(titleBgImage) : '';
		if ($F('titleBgColor').value != '' && titleBgImage == '') titleBgImage = 'none';
		title.style['backgroundImage'] = titleBgImage;
		if (titleBgImage) {
			title.style['backgroundRepeat'] = $F('titleBgRepeat').value;
		}
		title.style['backgroundColor'] = $F('titleBgColor').value;
		if ($F('switchType')) {
			title.switchType = [];
			title.switchType[0] = $F('switchType').value ? $F('switchType').value : 'click';
			title.setAttribute('switchtype',title.switchType[0]);
		}

		obj.titles = [];
		if (hastitle == 1) {
			this._initTitle(obj,title);
		} else {
			if (!(obj instanceof Tab)) title.parentNode.removeChild(title);
			title = '';
			this.initPosition();
		}
		if (obj instanceof Block) this.saveBlockTitle(fid,title);
		this.setClose();

	},
	_createTitleHtml : function (ele,tid) {
		var html = '',img = '';
		tid = '_' + tid ;
		var ttext = $F('titleText'+tid).value;
		var tlink = $F('titleLink'+tid).value;
		var tfloat = $F('titleFloat'+tid).value;
		var tmargin_ = tfloat != '' ? tfloat : 'left';
		var tmargin = $F('titleMargin'+tid).value;
		var tsize = $F('titleSize'+tid).value;
		var tcolor = $F('titleColor'+tid).value;
		var src = $F('titleSrc'+tid).value;
		var divStyle = 'float:'+tfloat+';margin-'+tmargin_+':'+tmargin+'px;font-size:'+tsize;
		var aStyle = 'color:'+tcolor+' !important;';
		if (src) {
			img = '<img class="vm" src="'+src+'" alt="'+ttext+'" />';
		}
		if (ttext || img) {
			if (tlink) {
				Util.setStyle(ele, divStyle);
				html = '<a href='+tlink+' target="_blank" style="'+aStyle+'">'+img+ttext+'</a>';
			} else {
				Util.setStyle(ele, divStyle+';'+aStyle);
				html = img+ttext;
			}
		}
		ele.innerHTML = html;
		return true;
	},
	saveBlockTitle : function (id,title) {
		if (!$F('saveblocktitle')){
			var dom  = document.createElement('div');
			dom.innerHTML = '<form id="saveblocktitle" method="post" action=""><input type="hidden" name="title" value="" />\n\
				<input type="hidden" name="formhash" value="'+document.diyform.formhash.value+'" /><input type="hidden" name="savetitlesubmit" value="true"/></form>';
			$F('append_parent').appendChild(dom.childNodes[0]);
		}
		$F('saveblocktitle').action = 'portal.php?mod=portalcp&ac=block&op=saveblocktitle&bid='+id.replace('portal_block_','');
		var html = !title ? '' : title.outerHTML;
		document.forms.saveblocktitle.title.value = html;
		ajaxpost('saveblocktitle','ajaxwaitid');
	},
	removeBlock : function (e, flag) {
		if ( typeof e !== 'string') {
			e = Util.event(e);
			var id = e.aim.id.replace('cmd_','');
		} else {
			var id = e;
		}
		if ($F(id) == null) return false;
		var obj = this.getObjByName(id);
		if (!flag) {
			if (!confirm('\u60a8\u786e\u5b9e\u8981\u5220\u9664\u5417\u002c\u5220\u9664\u4ee5\u540e\u5c06\u4e0d\u53ef\u6062\u590d?')) return false;
		}
		if (obj instanceof Block) {
			this.delBlock(id);
		} else if (obj instanceof Frame) {
			this.delFrame(obj);
		}
		$F(id).parentNode.removeChild($F(id));
		var content = $F(id+'_content');
		if(content) {
			content.parentNode.removeChild(content);
		}
		this.setClose();
		this.initPosition();
		this.initChkBlock();
	},
	delBlock : function (bid) {
		spaceDiy.removeCssSelector('#'+bid);
		this.stopSlide(bid);
	},
	delFrame : function (frame) {
		spaceDiy.removeCssSelector('#'+frame.name);
		for (var i in frame['columns']) {
			if (frame['columns'][i] instanceof Column) {
				var children = frame['columns'][i]['children'];
				for (var j in children) {
					if (children[j] instanceof Frame) {
						this.delFrame(children[j]);
					} else if (children[j] instanceof Block) {
						this.delBlock(children[j]['name']);
					}
				}
			}
		}
		this.setClose();
	},
	initChkBlock : function (data) {
		if (typeof name == 'undefined' || data == null ) data = this.data;
		if ( data instanceof Frame) {
			this.initChkBlock(data['columns']);
		} else if (data instanceof Block) {
			var el = $F('chk'+data.name);
			if (el != null) el.checked = true;
		} else if (typeof data == 'object') {
			for (var i in data) {
				this.initChkBlock(data[i]);
			}
		}
	},
	getBlockData : function (blockname) {
		var bid = this.dragObj.id;
		var eleid = bid;
		if (bid.indexOf('portal_block_') != -1) {
			eleid = 0;
		}else {
			bid = 0;
		}
		popup.open('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
		$.ajax({
			type : 'GET',
			url : 'portal.php?mod=portalcp&ac=block&op=block&classname='+blockname+'&bid='+bid+'&eleid='+eleid+'&tpl='+document.diyform.template.value+'&inajax=1',
			dataType : 'xml'
		}).success(function(s) {
			popup.open(s.lastChild.firstChild.nodeValue);
			evalscript(s.lastChild.firstChild.nodeValue);
		});
		drag.initPosition();
		this.fn = '';
		return true;
	},
	stopSlide : function (id) {
		if (typeof slideshow == 'undefined' || typeof slideshow.entities == 'undefined') return false;
		var slidebox = $C('slidebox',$F(id));
		if(slidebox && slidebox.length > 0) {
			if(slidebox[0].id) {
				var timer = slideshow.entities[slidebox[0].id].timer;
				if(timer) clearTimeout(timer);
				slideshow.entities[slidebox[0].id] = '';
			}
		}
	},
	blockForceUpdate : function (e,all) {
		if ( typeof e !== 'string') {
			e = Util.event(e);
			var id = e.aim.id.replace('cmd_','');
		} else {
			var id = e;
		}
		if ($F(id) == null) return false;
		var bid = id.replace('portal_block_', '');
		var bcontent = $F(id+'_content');
		if (!bcontent) {
			bcontent = document.createElement('div');
			bcontent.id = id+'_content';
			bcontent.className = this.contentClass;
		}
		this.stopSlide(id);

		var height = Util.getFinallyStyle(bcontent, 'height');
		bcontent.style.lineHeight = height == 'auto' ? '' : (height == '0px' ? '20px' : height);
		var boldcontent = bcontent.innerHTML;
		bcontent.innerHTML = '<center>\u6b63\u5728\u52a0\u8f7d\u5185\u5bb9...</center>';
		
		$.ajax({
			type : 'GET',
			url : 'portal.php?mod=portalcp&ac=block&op=getblock&forceupdate=1&inajax=1&bid='+bid+'&tpl='+document.diyform.template.value,
			dataType : 'xml'
		}).success(function(s) {
			if(s.lastChild.firstChild.nodeValue.indexOf('errorhandle_') != -1) {
				bcontent.innerHTML = boldcontent;
				runslideshow();
				popup.open('\u62b1\u6b49\uff0c\u60a8\u6ca1\u6709\u6743\u9650\u6dfb\u52a0\u6216\u7f16\u8f91\u6a21\u5757', 'alert');
				doane();
			} else {
				var obj = document.createElement('div');
				obj.innerHTML = s.lastChild.firstChild.nodeValue;
				bcontent.parentNode.removeChild(bcontent);
				$F(id).innerHTML = obj.childNodes[0].innerHTML;
				evalscript(s.lastChild.firstChild.nodeValue);
				if(s.lastChild.firstChild.nodeValue.indexOf('runslideshow()') != -1) {runslideshow();}
				drag.initPosition();
				if (all) {drag.getBlocks();}
			}
		});
	},
	frameExport : function (e) {
		var flag = true;
		if (drag.isChange) {
			flag = confirm('\u60a8\u5df2\u7ecf\u505a\u8fc7\u4fee\u6539\uff0c\u8bf7\u4fdd\u5b58\u540e\u518d\u505a\u5bfc\u51fa\uff0c\u5426\u5219\u5bfc\u51fa\u7684\u6570\u636e\u5c06\u4e0d\u5305\u62ec\u60a8\u8fd9\u6b21\u6240\u505a\u7684\u4fee\u6539');
		}
		if (flag) {
			if ( typeof e == 'object') {
				e = Util.event(e);
				var frame = e.aim.id.replace('cmd_','');
			} else {
				frame = e == undefined ? '' : e;
			}
			if (!$F('frameexport')){
				var dom  = document.createElement('div');
				dom.innerHTML = '<form id="frameexport" method="post" action=""><input type="hidden" name="frame" value="" />\n\
					<input type="hidden" name="tpl" value="'+document.diyform.template.value+'" />\n\
					<input type="hidden" name="tpldirectory" value="'+document.diyform.tpldirectory.value+'" />\n\
					<input type="hidden" name="diysign" value="'+document.diyform.diysign.value+'" />\n\
					<input type="hidden" name="formhash" value="'+document.diyform.formhash.value+'" /><input type="hidden" name="exportsubmit" value="true"/></form>';
				$F('DiyBar').appendChild(dom.childNodes[0]);
			}
			$F('frameexport').action = 'portal.php?mod=portalcp&ac=diy&op=export';
			document.forms.frameexport.frame.value = frame;
			document.forms.frameexport.submit();
		}
	},
	openFrameImport : function (type) {
		type = type || 0;
		popup.open('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
		$.ajax({
			type : 'GET',
			url : 'plugin.php?id=qu_app:diy&op=import&tpl='+document.diyform.template.value+'&tpldirectory='+document.diyform.tpldirectory.value+'&diysign='+document.diyform.diysign.value+'&type='+type+'&inajax=1',
			dataType : 'xml'
		}).success(function(s) {
			popup.open(s.lastChild.firstChild.nodeValue);
			evalscript(s.lastChild.firstChild.nodeValue);
		});
	
	},
	endBlockForceUpdateBatch : function () {
		if($F('allupdate')) {
			$F('allupdate').innerHTML = '\u5df2\u64cd\u4f5c\u5b8c\u6210';
			$F('fwin_dialog_submit').style.display = '';
			$F('fwin_dialog_cancel').style.display = 'none';
		}
		this.initPosition();
	},
	getBlocks : function () {
		if (this.blocks.length == 0) {
			this.endBlockForceUpdateBatch();
		}
		if (this.blocks.length > 0) {
			var cur = this.blocksLen - this.blocks.length;
			if($F('allupdate')) {
				$F('allupdate').innerHTML = '\u5171<span style="color:blue">'+this.blocksLen+'</span>\u4e2a\u6a21\u5757\u002c\u6b63\u5728\u66f4\u65b0\u7b2c<span style="color:red">'+cur+'</span>\u4e2a\u002c\u5df2\u5b8c\u6210<span style="color:red">'+(parseInt(cur / this.blocksLen * 100)) + '%</span>';
				var bid = 'portal_block_'+this.blocks.pop();
				this.blockForceUpdate(bid,true);
			}
		}
	},
	blockForceUpdateBatch : function (blocks) {
		if (blocks) {
			this.blocks = blocks;
		} else {
			this.initPosition();
			this.blocks = this.allBlocks;
		}
		this.blocksLen = this.blocks.length;
		setTimeout(popup.open('\u66f4\u65b0\u5b8c\u6210','alert'),1000);
		
		var wait = function() {
			if($F('fwin_dialog_submit')) {
				$F('fwin_dialog_submit').style.display = 'none';
				$F('fwin_dialog_cancel').className = 'pn pnc';
				setTimeout(function(){drag.getBlocks()},500);
			} else {
				setTimeout(wait,100);
			}
		};
		wait();

	},
	clearAll : function () {
		if (confirm('\u60a8\u786e\u5b9e\u8981\u6e05\u7a7a\u9875\u9762\u4e0a\u6240\u5728\u0044\u0049\u0059\u6570\u636e\u5417\u002c\u6e05\u7a7a\u4ee5\u540e\u5c06\u4e0d\u53ef\u6062\u590d')) {
			for (var i in this.data) {
				for (var j in this.data[i]) {
					if (typeof(this.data[i][j]) == 'object' && this.data[i][j].name.indexOf('_temp')<0) {
						this.delFrame(this.data[i][j]);
						$F(this.data[i][j].name).parentNode.removeChild($F(this.data[i][j].name));
					}
				}
			}
			this.initPosition();
			this.setClose();
		}
		
	},
	createObj : function (e,objType,contentType) {
		if (objType == 'block' && !this.checkHasFrame()) {alert("\u63d0\u793a\uff1a\u672a\u627e\u5230\u6846\u67b6\uff0c\u8bf7\u5148\u6dfb\u52a0\u6846\u67b6");spaceDiy.getdiy('frame');return false;}
		e = Util.event(e);
		if(e.which != 1 ) {return false;}
		var html = '',offWidth = 0;
		if (objType == 'frame') {
			html =  this.getFrameHtml(contentType);
			offWidth = 600;
		} else if (objType == 'block') {
			html =  this.getBlockHtml(contentType);
			offWidth = 200;
			this.fn = function (e) {drag.getBlockData(contentType);};
		} else if (objType == 'tab') {
			html = this.getTabHtml(contentType);
			offWidth = 300;
		}
		var ele = document.createElement('div');
		ele.innerHTML = html;
		ele = ele.childNodes[0];
		document.body.appendChild(ele);
		this.dragObj = this.overObj = ele;
		if (!this.getTmpBoxElement()) return false;
		var scroll = Util.getScroll();
		this.dragObj.style.position = 'absolute';
		this.dragObj.style.left = 0 + "px";
		this.dragObj.style.top = e.clientY + scroll.t + 17 + "px";
		this.dragObj.style.width = '100%';
		this.dragObj.style.cursor = 'move';
		this.dragObj.lastMouseX = e.clientX;
		this.dragObj.lastMouseY = e.clientY;
		Util.insertBefore(this.tmpBoxElement,this.overObj);
		Util.addClass(this.dragObj,this.moving);
		this.dragObj.style.zIndex = 9999 ;
		this.scroll = Util.getScroll();
		this.newFlag = true;
		var _method = this;
		document.onscroll = function(){Drag.prototype.resetObj.call(_method, e);};
		window.onscroll = function(){Drag.prototype.resetObj.call(_method, e);};
		$(ele).on('touchstart', function(e) {
		}).on('touchmove', function(e) {
			event.preventDefault();
			Drag.prototype.drag.call(_method, e);
		}).on('touchend', function(e) {
		    Drag.prototype.dragEnd.call(_method, e);
			$(ele).unbind("touchmove");
		});
	},
	getFrameHtml : function (type) {
		var id = 'frame'+Util.getRandom(6);
		var className = [this.frameClass,this.moveableObject].join(' ');
		className = className + ' cl frame-' + type;
		var str = '<div id="'+id+'" class="'+className+'">';
		str += '<div id="'+id+'_title" class="'+this.titleClass+' '+this.frameTitleClass+'"><span class="'+this.titleTextClass+'"></span></div>';
		var cols = type.split('-');
		var clsl='',clsc='',clsr='';
		clsl = ' frame-'+type+'-l';
		clsc = ' frame-'+type+'-c';
		clsr = ' frame-'+type+'-r';
		var len = cols.length;
		if (len == 1) {
			str += '<div id="'+id+'_left" class="'+this.moveableColumn+clsc+'"></div>';
		} else if (len == 2) {
			str += '<div id="'+id+'_left" class="'+this.moveableColumn+clsl+ '"></div>';
			str += '<div id="'+id+'_center" class="'+this.moveableColumn+clsr+ '"></div>';
		} else if (len == 3) {
			str += '<div id="'+id+'_left" class="'+this.moveableColumn+clsl+'"></div>';
			str += '<div id="'+id+'_center" class="'+this.moveableColumn+clsc+'"></div>';
			str += '<div id="'+id+'_right" class="'+this.moveableColumn+clsr+'"></div>';
		}
		str += '</div>';
		return str;
	},
	getTabHtml : function () {
		var id = 'tab'+Util.getRandom(6);
		var className = [this.tabClass,this.moveableObject].join(' ');
		className = className + ' cl';
		var titleClassName = [this.tabTitleClass, this.titleClass, this.moveableColumn, 'cl'].join(' ');
		var str = '<div id="'+id+'" class="'+className+'">';
		str += '<div id="'+id+'_title" class="'+titleClassName+'"><span class="'+this.titleTextClass+'">tab\u6807\u7b7e</span></div>';
		str += '<div id="'+id+'_content" class="'+this.tabContentClass+'"></div>';
		str += '</div>';
		return str;
	},
	getBlockHtml : function () {
		var id = 'block'+Util.getRandom(6);
		var str = '<div id="'+id+'" class="block move-span"></div>';
		str += '</div>';
		return str;
	},
	setClose : function () {
		if(this.sampleMode) {
			return true;
		} else {
			if (!this.isChange) {
				window.onbeforeunload = function() {
					return '\u60a8\u7684\u6570\u636e\u5df2\u7ecf\u4fee\u6539\u002c\u9000\u51fa\u5c06\u65e0\u6cd5\u4fdd\u5b58\u60a8\u7684\u4fee\u6539';
				};
			}
			this.isChange = true;
			spaceDiy.enablePreviewButton();
		}
	},
	clearClose : function () {
		this.isChange = false;
		this.isClearClose = true;
		window.onbeforeunload = function () {};
	},
	goonDIY : function () {
		if ($F('prefile').value == '1') {
			showDialog('<div style="line-height:28px;">\u6309\u7ee7\u7eed\u6309\u94ae\u5c06\u6253\u5f00\u6682\u5b58\u6570\u636e\u5e76DIY，<br />\u6309\u5220\u9664\u6309\u94ae\u5c06\u5220\u9664\u6682\u5b58\u6570\u636e</div>','confirm','\u662f\u5426\u7ee7\u7eed\u6682\u5b58\u6570\u636e\u7684DIY?', function(){location.replace(location.href+'&preview=yes');}, true, 'spaceDiy.cancelDIY()', '', '\u7ee7\u7eed', '\u5220\u9664');
		} else if (location.search.indexOf('preview=yes') > -1) {
			spaceDiy.enablePreviewButton();
		} else {
			spaceDiy.disablePreviewButton();
		}
		setInterval(function(){spaceDiy.save('savecache', 1);},180000);
	}
});

var spaceDiy = new DIY();
spaceDiy.extend({
	save : function (optype,rejs) {
		optype = typeof optype == 'undefined' ? '' : optype;
		if (optype == 'savecache' && !drag.isChange) {return false;}
		var tplpre = document.diyform.template.value.split(':');
		if (!optype) {
			if (['portal/portal_topic_content', 'portal/list', 'portal/view'].indexOf(tplpre[0]) == -1) {
				if (document.diyform.template.value.indexOf(':') > -1 && !document.selectsave) {
					/*
					var schecked = '',dchecked = '';
					if (document.diyform.savemod.value == '1') {
						dchecked = ' checked';
					} else {
						schecked = ' checked';
					}
					popup.open('<div class="tip"><form id="selectsave" name="selectsave" action="" method="get"><label><input onclick="document.diyform.savemod.value = 0;" type="radio" value="0" name="savemod"'+schecked+' />\u5e94\u7528\u4e8e\u6b64\u7c7b\u5168\u90e8\u9875\u9762</label>\n\
					<label><input type="radio" value="1" name="savemod"'+dchecked+' onclick="document.diyform.savemod.value = 1;"/>\u53ea\u5e94\u7528\u4e8e\u672c\u9875\u9762</label></form></div');
					return false;
					*/
				}
			} else {
				//document.diyform.savemod.value = 0;
			}
		} else if (optype == 'savecache') {
			if (!drag.isChange) return false;
			this.checkPreview_form();
			document.diyform.rejs.value = rejs ? 0 : 1;
		} else if (optype =='preview') {
			if (drag.isChange) {
				optype = 'savecache';
			} else {
				this.checkPreview_form();
				$F('preview_form').submit();
				return false;
			}
		}
		document.diyform.action = document.diyform.action.replace(/[&|\?]inajax=1/, '');
		document.diyform.optype.value = optype;
		document.diyform.spacecss.value = spaceDiy.getSpacecssStr();
		document.diyform.style.value = spaceDiy.style;
		document.diyform.layoutdata.value = drag.getPositionStr();
		document.diyform.gobackurl.value = spaceDiy.cancelDiyUrl();
		drag.clearClose();
		if (optype == 'savecache') {
			document.diyform.handlekey.value = 'diyform';
			ajaxpost('diyform','ajaxwaitid','ajaxwaitid','onerror');
		} else {
			saveUserdata('diy_advance_mode', '');
			document.diyform.submit();
		}
	},
	checkPreview_form : function () {
		if (!$F('preview_form')) {
			var dom = document.createElement('div');
			var search = '';
			var sarr = location.search.replace('?','').split('&');
			for (var i = 0;i<sarr.length;i++){
				var kv = sarr[i].split('=');
				if (kv.length>1 && kv[0] != 'diy') {
					search += '<input type="hidden" value="'+kv[1]+'" name="'+kv[0]+'" />';
				}
			}
			search +=  '<input type="hidden" value="yes" name="preview" />';
			dom.innerHTML = '<form action="'+location.href+'" target="_bloak" method="get" id="preview_form">'+search+'</form>';
			var form = dom.getElementsByTagName('form');
			$F('append_parent').appendChild(form[0]);
		}
	},
	cancelDiyUrl : function () {
		return location.href.replace(/[\?|\&]diy\=yes/g,'').replace(/[\?|\&]preview=yes/,'');
	},
	cancel : function () {
		saveUserdata('diy_advance_mode', '');
		if (drag.isClearClose) {
			showDialog('<div style="line-height:28px;">\u662f\u5426\u4fdd\u7559\u6682\u5b58\u6570\u636e?<br />\u6309\u786e\u5b9a\u6309\u94ae\u5c06\u4fdd\u7559\u6682\u5b58\u6570\u636e\uff0c\u6309\u53d6\u6d88\u6309\u94ae\u5c06\u5220\u9664\u6682\u5b58\u6570\u636e</div>','confirm','\u4fdd\u7559\u6682\u5b58\u6570\u636e', function(){location.href = spaceDiy.cancelDiyUrl();}, true, function(){window.onunload=function(){spaceDiy.cancelDIY()};location.href = spaceDiy.cancelDiyUrl();});
		} else {
			location.href = this.cancelDiyUrl();
		}

	},
	recover : function() {
		if (confirm('\u60a8\u786e\u5b9a\u8981\u6062\u590d\u5230\u4e0a\u4e00\u7248\u672c\u4fdd\u5b58\u7684\u7ed3\u679c\u5417?')) {
			drag.clearClose();
			document.diyform.recover.value = '1';
			document.diyform.gobackurl.value = location.href.replace(/(\?diy=yes)|(\&diy=yes)/,'').replace(/[\?|\&]preview=yes/,'');
			document.diyform.submit();
		}
		doane();
	},
	enablePreviewButton : function () {
		if ($F('preview')){
			$F('preview').className = '';
			if(drag.isChange) {
				$F('diy_preview').onclick = function () {spaceDiy.save('savecache');return false;};
			} else {
				$F('diy_preview').onclick = function () {spaceDiy.save('preview');return false;};
			}
			Util.show($F('savecachemsg'))
		}
	},
	disablePreviewButton : function () {
		if ($F('preview')) {
			$F('preview').className = 'unusable';
			$F('diy_preview').onclick = function () {return false;};
		}
	},
	cancelDIY : function () {
		this.disablePreviewButton();
		document.diyform.optype.value = 'canceldiy';
		var x = new Ajax();
		x.post($F('diyform').action+'&inajax=1','optype=canceldiy&diysubmit=1&template='+document.diyform.template.value+'&savemod='+document.diyform.savemod.value+'&formhash='+document.diyform.formhash.value+'&tpldirectory='+document.diyform.tpldirectory.value+'&diysign='+document.diyform.diysign.value,function(s){});
	},
	switchBlockclass : function(blockclass) {
		var navs = $F('contentblockclass_nav').getElementsByTagName('a');
		var contents = $F('contentblockclass').getElementsByTagName('ul');
		for(var i=0; i<navs.length; i++) {
			if(navs[i].id=='bcnav_'+blockclass) {
				navs[i].className = 'a';
			} else {
				navs[i].className = '';
			}
		}
		for(var i=0; i<contents.length; i++) {
			if(contents[i].id=='contentblockclass_'+blockclass) {
				contents[i].style.display = 'block';
			} else {
				contents[i].style.display = 'none';
			}
		}
	},
	getdiy : function (type) {
		if (type) {
			var nav = $F('controlnav').children;
			for (var i in nav) {
				if (nav[i].className == 'current') {
					nav[i].className = '';
					var contentid = 'content'+nav[i].id.replace('nav', '');
					if ($F(contentid)) $F(contentid).style.display = 'none';
				}
			}
			$F('nav'+type).className = 'current';
			if (type == 'start' || type == 'frame') {
				$F('content'+type).style.display = 'block';
				return true;
			}
			if(type == 'blockclass' && $F('content'+type).innerHTML !='') {
				$F('content'+type).style.display = 'block';
				return true;
			}
			var para = '&op='+type;
			if (arguments.length > 1) {
				for (var i = 1; i < arguments.length; i++) {
					para += '&' + arguments[i] + '=' + arguments[++i];
				}
			}
			var ajaxtarget = type == 'diy' ? 'diyimages' : '';
			$.ajax({
				url: 'portal.php?mod=portalcp&ac=diy'+para+'&inajax=1&ajaxtarget='+ajaxtarget,
				type: "get",
				dataType: "xml",
				success: function(s) {
						if (s.lastChild.firstChild.nodeValue) {
						if (typeof cpb_frame == 'object' && !BROWSER.ie) {delete cpb_frame;}
						if (!$F('content'+type)) {
							var dom = document.createElement('div');
							dom.id = 'content'+type;
							$F('controlcontent').appendChild(dom);
						}
						$F('content'+type).innerHTML = s.lastChild.firstChild.nodeValue;
						$F('content'+type).style.display = 'block';
						if (type == 'diy') {
							spaceDiy.setCurrentDiy(spaceDiy.currentDiy);
							if (spaceDiy.styleSheet.rules.length > 0) {
								Util.show('recover_button');
							}
						}
	
						var evaled = false;
						if(s.lastChild.firstChild.nodeValue.indexOf('ajaxerror') != -1) {
							evalscript(s.lastChild.firstChild.nodeValue);
							evaled = true;
						}
						if(!evaled && (typeof ajaxerror == 'undefined' || !ajaxerror)) {
							if(ajaxtarget) {
								ajaxupdateevents($F(ajaxtarget));
							}
						}
						if(!evaled) evalscript(s.lastChild.firstChild.nodeValue);
					}
				}
			});
					
		}
	}
});

spaceDiy.init(1);

function succeedhandle_diyform (url, message, values) {
	if (values['rejs'] == '1') {
		document.diyform.rejs.value = '';
		parent.$F('preview_form').submit();
	}
	spaceDiy.enablePreviewButton();
	return false;
}
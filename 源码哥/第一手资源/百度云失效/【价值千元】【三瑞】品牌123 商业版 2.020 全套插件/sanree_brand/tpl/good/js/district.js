		function srshowdistrict(container, elems, totallevel, changelevel, containertype) {
			$F('_srshowdistrict', arguments);
		}
		function _srshowdistrict(container, elems, totallevel, changelevel, containertype) {
			var getdid = function(elem) {
				var op = elem.options[elem.selectedIndex];
				return op['did'] || op.getAttribute('did') || '0';
			};
			var pid = changelevel >= 1 && elems[0] && $(elems[0]) ? getdid($(elems[0])) : 0;
			var cid = changelevel >= 2 && elems[1] && $(elems[1]) ? getdid($(elems[1])) : 0;
			var did = changelevel >= 3 && elems[2] && $(elems[2]) ? getdid($(elems[2])) : 0;
			var coid = changelevel >= 4 && elems[3] && $(elems[3]) ? getdid($(elems[3])) : 0;
			var url = "plugin.php?id=sanree_brand&mod=district&container="+container+"&containertype="+containertype
				+"&province="+elems[0]+"&city="+elems[1]+"&district="+elems[2]+"&community="+elems[3]
				+"&pid="+pid + "&cid="+cid+"&did="+did+"&coid="+coid+'&level='+totallevel+'&handlekey='+container+'&inajax=1'+(!changelevel ? '&showdefault=1' : '');
			ajaxget(url, container, '');
		}
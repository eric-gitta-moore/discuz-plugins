<?PHP exit('QQÈº£º550494646');?>
<input type="hidden" name="polls" value="yes" />
<div class="exfm_poll cl">
	<div class="sppoll cl">
		<input type="hidden" name="fid" value="$_G[fid]" />
		<!--{if $_GET[action] == 'newthread'}-->
			<input type="hidden" name="tpolloption" value="1" />
			<div class="polltit cl">
				<h2>
					<font class="grey">{lang post_poll_comment}</font>
					<span class="y">
                    	<span class="ainuo_checkbox cl">
                    	<input id="pollchecked" type="checkbox" class="pc" onclick="switchpollm(1)" />
                        <label for="pollchecked">{lang post_single_frame_mode}</label>
                        </span>
                        </span>
				</h2>
			</div>
			<div id="pollm_c_1" class="poll_xx cl">
				<div id="polloption_new"></div>
                <div class="polloption_add">
                    <ul id="polloption_hidden" style="display:none">
                    	<li id="afirst_lilistid" class="afirst cl">
                            <a href="javascript:;" class="del" onclick="delpolloption(this)"><i class="iconfont icon-close"></i></a>
                            <input type="text" name="polloption[]" class="px vm" placeholder="$alang_xuanxiang" autocomplete="off" tabindex="1" />
                            <a href="javascript:;" class="displaypoll" id="polldis_disid" onclick="pollimg('picid')" style="display:none;"><i class="iconfont icon-pic"></i></a>
                            <a href="javascript:;" class="upidpoll"><i class="iconfont icon-upload"></i></a>
                            <input type="file" class="afile_key" name="Filedata" id="auppic" upindex="pollupid" />
                        </li>
						<div class="newuppic" id="newpoll"></div>
                    </ul>
                    
                </div>
                
				<p class="addone"><a href="javascript:;" onclick="addpolloption()">+{lang post_poll_add}</a></p>
			</div>
            
			<div id="pollm_c_2" style="display:none">
				<textarea name="polloptions" class="px" tabindex="1" rows="6" onchange="switchpollm(0)" /></textarea>
				<p class="cl">{lang post_poll_comment_s}</p>
			</div>
		<!--{else}-->
        <div class="poll_xx cl">
			<!--{loop $poll['polloption'] $key $option}-->
				<!--{eval $ppid = $poll['polloptionid'][$key];}-->
				<ul>
                	<li id="afirst_{$key}" class="afirst cl" {if $poll[imginfo][$ppid][big]}style="padding-right:78px;"{/if}>
                        <input type="hidden" name="polloptionid[{$poll[polloptionid][$key]}]" value="$poll[polloptionid][$key]" />
                        <input type="text" name="displayorder[{$poll[polloptionid][$key]}]" class="px pxs vm" autocomplete="off" tabindex="1" value="$poll[displayorder][$key]" />
                        <input type="text" name="polloption[{$poll[polloptionid][$key]}]" class="px vm" autocomplete="off" tabindex="1" value="$option"{if !$_G['group']['alloweditpoll']} readonly="readonly"{/if} />
                        <!--{if $poll[imginfo][$ppid][big]}-->
    					<a href="javascript:;" class="displaypoll" id="polldis_{$key}" onclick="pollimg('{$key}')"><i class="iconfont icon-pic"></i></a>
                        <!--{/if}-->
                        <a href="javascript:;" class="displaypoll" id="polldis_{$key}" onclick="pollimg('{$key}')" style="display:none;"><i class="iconfont icon-pic"></i></a>
                        <a href="javascript:;" class="upidpoll"><i class="iconfont icon-comiisshangchuan"></i></a>
                        <input type="file" class="afile_key" name="Filedata" id="auppic" upindex="{$key}" />
                    </li>
                    <div class="newuppic" id="newpoll{$key}">
                    	<!--{if $poll[imginfo][$ppid][big]}-->
                        	<img src="$poll[imginfo][$ppid][big]" />
						<!--{/if}-->
                    </div>
				</ul>
			<!--{/loop}-->
            
			<div id="polloption_new"></div>
                <div class="polloption_add">
                    <ul id="polloption_hidden" style="display:none">
                    	<li id="afirst_lilistid" class="afirst cl">
                            <a href="javascript:;" class="del" onclick="delpolloption(this)"><i class="iconfont icon-close"></i></a>
                            <input type="text" name="polloption[]" class="px vm" placeholder="$alang_xuanxiang" autocomplete="off" tabindex="1" />
                            <a href="javascript:;" class="displaypoll" id="polldis_disid" onclick="pollimg('picid')" style="display:none;"><i class="iconfont icon-pic"></i></a>
                            <a href="javascript:;" class="upidpoll"><i class="iconfont icon-comiisshangchuan"></i></a>
                            <input type="file" class="afile_key" name="Filedata" id="auppic" upindex="pollupid" />
                        </li>
						<div class="newuppic" id="newpoll"></div>
                    </ul>
                    
                </div>
			<p class="addone"><a href="javascript:;" onclick="addpolloption()">+{lang post_poll_add}</a></p>
		</div>
		<!--{/if}-->
	</div>
	<div class="sadd cl">
		<p class="cl">
                <label for="maxchoices">{lang post_poll_allowmultiple}</label>
                <input type="text" name="maxchoices" id="maxchoices" class="px pxs" value="{if $_GET[action] == 'edit' && $poll[maxchoices]}$poll[maxchoices]{else}1{/if}" tabindex="1" /> {lang post_option}
		</p>
		<p class="cl">
			<label for="polldatas">{lang post_poll_expiration}</label>
			<input type="text" name="expiration" id="polldatas" class="px pxs" value="{if $_GET[action] == 'edit'}{if !$poll[expiration]}0{elseif $poll[expiration] < 0}{lang poll_close}{elseif $poll[expiration] < TIMESTAMP}{lang poll_finish}{else}{echo (round(($poll[expiration] - TIMESTAMP) / 86400))}{/if}{/if}" tabindex="1" /> {lang days}
		</p>
		<p class="cl">
        	<span class="ainuo_checkbox cl">
			<input type="checkbox" name="visibilitypoll" id="visibilitypoll" class="pc" value="1"{if $_GET[action] == 'edit' && !$poll[visible]} checked{/if} tabindex="1" /><label for="visibilitypoll">{lang poll_after_result}</label></span>
		</p>
		<p class="cl">
        	<span class="ainuo_checkbox cl">
			<input type="checkbox" name="overt" id="overt" class="pc" value="1"{if $_GET[action] == 'edit' && $poll[overt]} checked{/if} tabindex="1" /><label for="overt">{lang post_poll_overt}</label>
            </span>
		</p>
		<!--{hook/post_poll_extra}-->
	</div>
</div>
<div class="grey_line cl"></div>
<script type="text/javascript" reload="1">
var maxoptions = parseInt('$_G[setting][maxpolloptions]');
<!--{if $_GET[action] == 'newthread'}-->
	var curoptions = 0;
	var curnumber = 1;
	addpolloption();
	addpolloption();
	addpolloption();
<!--{else}-->
	var curoptions = <!--{echo count($poll['polloption']) - 1}-->;
	var curnumber = <!--{echo count($poll['polloption'])}-->;
	
<!--{/if}-->
function pollimg(liid) {
	var obj = $('#newpoll' + liid);
	var dis = obj.css("display");
	obj.slideToggle(200);
	if(dis == "none"){ 
		obj.css("display", "block"); 
	}else{ 
		obj.css("display", "none"); 
	} 
}


function addpolloption() {
	if(curoptions < maxoptions) {
		var imgid = 'auppic_'+curnumber;
		var proid = 'newpoll'+curnumber;
		var pollid = curnumber;
		var pollstr = document.getElementById('polloption_hidden').innerHTML.replace('auppic', imgid);
		pollstr = pollstr.replace('newpoll', proid);
		pollstr = pollstr.replace('pollupid', pollid);
		pollstr = pollstr.replace('picid', pollid);
		pollstr = pollstr.replace('disid', pollid);
		pollstr = pollstr.replace('lilistid', pollid);
		document.getElementById('polloption_new').outerHTML = '<ul>' + pollstr + '</ul>' + document.getElementById('polloption_new').outerHTML;
		curoptions++;
		curnumber++;
	} else {
		popup.open('$alang_maxpoll'+maxoptions + '!', 'alert');
	}
}
function delpolloption(obj) {
	obj.parentNode.parentNode.parentNode.removeChild(obj.parentNode.parentNode);
	curoptions--;
}
function switchpollm(swt) {
	t = document.getElementById('pollchecked').checked && swt ? 2 : 1;
	var v = '';
	for(var i = 0; i < document.getElementById('postform').elements.length; i++) {
		var e = document.getElementById('postform').elements[i];
		if(!isUndefined(e.name)) {
			if(e.name.match('^polloption')) {
				if(t == 2 && e.tagName == 'INPUT') {
					v += e.value + '\n';
				} else if(t == 1 && e.tagName == 'TEXTAREA') {
					v += e.value;
				}
			}
		}
	}
	if(t == 1) {
		var a = v.split('\n');
		var pcount = 0;
		for(var i = 0; i < document.getElementById('postform').elements.length; i++) {
			var e = document.getElementById('postform').elements[i];
			if(!isUndefined(e.name)) {
				if(e.name.match('^polloption')) {
					pcount++;
					if(e.tagName == 'INPUT') e.value = '';
				}
			}
		}
		for(var i = 0; i < a.length - pcount + 2; i++) {
			addpolloption();
		}
		var ii = 0;
		for(var i = 0; i < document.getElementById('postform').elements.length; i++) {
			var e = document.getElementById('postform').elements[i];
			if(!isUndefined(e.name)) {
				if(e.name.match('^polloption') && e.tagName == 'INPUT' && a[ii]) {
					e.value = a[ii++];
				}
			}
		}
	} else if(t == 2) {
		document.getElementById('postform').polloptions.value = trim(v);

	}
	document.getElementById('postform').tpolloption.value = t;
	if(swt) {
		display('pollm_c_1');
		display('pollm_c_2');
	}
}

function trim(str) {
	return str.replace(/^\s*(.*?)[\s\n]*$/g, '$1');
}

function display(id) {
	var obj = document.getElementById(id);
	if(obj.style.visibility) {
		obj.style.visibility = obj.style.visibility == 'visible' ? 'hidden' : 'visible';
	} else {
		obj.style.display = obj.style.display == '' ? 'none' : '';
	}
}


$(document).on('change', '.afile_key', function() {
	var upkey_id = $(this).attr('upindex');
	var myinput = $(this).attr('myinput');

	Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');

	uploadsuccess = function(data) {
		if(data == '') {
			popup.open('{lang uploadpicfailed}', 'alert');
		}
		var aredata = eval("("+data+")");
		if(aredata.errorcode == 0 && aredata.aid) {
			var newaid = aredata.aid;
			Zepto('.ainuooverlay').remove();
			$('#newpoll' + upkey_id).html('<img src="' + aredata.bigimg + '" width="100%"><input type="hidden" name="pollimage[' + (myinput == 1 ? upkey_id : '') + ']" value="' + newaid + '">');
			$('#polldis_' + upkey_id).css("display","block");
			$('#afirst_' + upkey_id).addClass("lisdispic");
			
		} else {
			popup.open(STATUSMSG[aredata.errorcode], 'alert');
		}
	};
	if(typeof FileReader != 'undefined' && this.files[0]) {	
		$.buildfileupload({
			uploadurl:'misc.php?mod=swfupload&action=swfupload&operation=poll&fid=$_G[fid]',
			files:this.files,
			uploadformdata:{uid:"$_G[uid]", hash:"$swfconfig[hash]"},
			uploadinputname:'Filedata',
			maxfilesize:"",
			success:uploadsuccess,
			error:function() {
				popup.open('{lang uploadpicfailed}', 'alert');
			}
		});

	} else {

		$.ajaxfileupload({
			url:'misc.php?mod=swfupload&action=swfupload&operation=poll&fid=$_G[fid]',
			data:{uid:"$_G[uid]", hash:"$swfconfig[hash]"},
			dataType:'text',
			fileElementId:'filedata',
			success:uploadsuccess,
			error: function() {
				popup.open('{lang uploadpicfailed}', 'alert');
			}
		});

	}
});
</script>

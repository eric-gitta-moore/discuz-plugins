<?PHP exit('QQÈº£º550494646');?>
<div id="{$editorid}_body_loading"><i class="fa fa-circle-o-notch fa-spin"></i> {lang e_editor_loading}</div>
<div class="edt" id="{$editorid}_body" style="display: none">

    <div class="cl">
		<textarea class="px" tabindex="3" autocomplete="off" id="{$editorid}_textarea" name="$editor[textarea]" cols="80" rows="5"  placeholder="{lang thread_content}" fwin="reply">$editor[value]</textarea>
    </div>
	<!--{subtemplate touch/common/editor}-->
    
	<div id="{$editorid}_controls" class="bar">
    	<div class="y" style="display:none;">
			<div class="z">
				<label id="{$editorid}_switcher" class="bar_swch ptn"><input id="{$editorid}_switchercheck" type="checkbox" class="pc" name="checkbox" value="0" {if !$editor[editormode]}checked="checked"{/if} onclick="switchEditor(this.checked?0:1)" /></label>
			</div>
		</div>
		<!--{if !empty($_G[setting][pluginhooks][post_editorctrl_right])}-->
			<div class="y"><!--{hook/post_editorctrl_right}--></div>
		<!--{/if}-->
		<div id="{$editorid}_button" class="cl">
            <div class="b2r nbr " id="{$editorid}_adv_s2">
                <a id="{$editorid}_bold"><i class="fa fa-bold"></i></a>
                <a id="{$editorid}_forecolor" title="{lang e_forecolor}" style="display:none;"><i class="fa fa-font"></i></a>

            </div>
            <div class="b2r nbr" id="{$editorid}_adv_s1">
                <a id="{$editorid}_sml" title="{lang e_smilies_title}" menuwidth="200" style="display:none"><i class="fa fa-meh-o"></i></a>
                <div id="{$editorid}_imagen" style="display:none">!</div>
                <a id="{$editorid}_image" title="{lang e_image_title}" menupos="00" menuwidth="300"><i class="fa fa-image"></i></a>
                <!--{hook/post_editorctrl_left}-->
            </div>   
		</div>
	</div>

	
</div>

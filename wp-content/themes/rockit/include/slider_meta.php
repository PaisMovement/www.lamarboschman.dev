<?php
	if( !isset($post) ) {
		require_once '../../../../wp-load.php';
		$cs_slider_title_db = '';
		$cs_slider_description_db = '';
		$cs_slider_link_db = '';
		$cs_slider_link_target_db = '';
		$cs_slider_box_align_db = '';
		$cs_slider_use_image_as_db = '';
		$cs_slider_video_code_db = '';
	}
	if ( isset($_POST['counter']) ) $counter = $_POST['counter'];
	if ( isset($_POST['path']) ) $path = $_POST['path'];
?>
<li class="ui-state-default" id="<?php echo $counter?>">
	<div class="thumb-secs">
    	<?php $image_path = wp_get_attachment_image_src( $path, array( get_option("thumbnail_size_w"),get_option("thumbnail_size_h") ) );?>
        <img src="<?php echo $image_path[0]?>">
        <div class="gal-edit-opts">
            <!--<a href="#" class="resize"></a>-->
            <a href="javascript:slidedit(<?php echo $counter?>)" class="edit"></a>
            <a href="javascript:del_this(<?php echo $counter?>)" class="delete"></a>
        </div>
    </div>
    <div class="poped-up" id="edit_<?php echo $counter?>">
        <div class="opt-head">
            <h6>Edit Options</h6>
            <a href="javascript:slideclose(<?php echo $counter?>)" class="closeit">&nbsp;</a>
        </div>
        <div class="opt-conts">
            <ul class="form-elements">
                <li class="to-label">
                    <label>Image Title</label>
                </li>
                <li class="to-field">
                    <input type="text" name="cs_slider_title[]" value="<?php echo htmlspecialchars($cs_slider_title_db)?>" class="txtfield" />
                </li>
            </ul>
            <ul class="form-elements">
                <li class="to-label">
                    <label>Image Description</label>
                </li>
                <li class="to-field">
                    <textarea class="txtarea" name="cs_slider_description[]"><?php echo htmlspecialchars($cs_slider_description_db)?></textarea>
                </li>
            </ul>
            <ul class="form-elements">
                <li class="to-label">
                    <label>Link</label>
                </li>
                <li class="to-field">
                    <input type="text" name="cs_slider_link[]" value="<?php echo htmlspecialchars($cs_slider_link_db)?>" class="txtfield" />
                </li>
            </ul>
            <ul class="form-elements">
                <li class="to-label">
                    <label>Link Target</label>
                </li>
                <li class="to-field">
                    <select name="cs_slider_link_target[]" class="select_dropdown">
                        <option <?php if($cs_slider_link_target_db=="_self")echo "selected";?> >_self</option>
                        <option <?php if($cs_slider_link_target_db=="_blank")echo "selected";?> >_blank</option>
                    </select>
                </li>
                <li class="to-desc">
                    <p>Please select image target _Self it will open in same window _Blank it will open in new window.</p>
                </li>
            </ul>
            <ul class="form-elements">
                <li class="to-label">
                    <label>Box Align</label>
                </li>
                <li class="to-field">
                    <select name="cs_slider_box_align[]" class="select_dropdown">
                        <option <?php if($cs_slider_box_align_db=="Bottom")echo "selected";?> >Bottom</option>
                        <option <?php if($cs_slider_box_align_db=="Top")echo "selected";?> >Top</option>
                    </select>
                </li>
                <li class="to-desc">
                    <p>Please select text box position on slide(image).</p>
                </li>
            </ul>
            
            <ul class="form-elements">
                <li class="to-label">
                    
                </li>
                <li class="to-field">
                	<input type="hidden" name="path[]" value="<?php echo $path?>" />
                    <input type="button" value="Submit" onclick="javascript:slideclose(<?php echo $counter?>)" class="close-submit" />
                </li>
            </ul>
            <div class="clear"></div>
        </div>
    </div>
</li>

<?php
	if( !isset($post) ) {
		require_once '../../../../wp-load.php';
		$title_db = "";
		$description_db = "";
		$use_image_as = "";
		$video_code_db = "";
		$use_image_as_db = "";
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
            <a href="javascript:galedit(<?php echo $counter?>)" class="edit"></a>
            <a href="javascript:del_this(<?php echo $counter?>)" class="delete"></a>
        </div>
    </div>
    <div class="poped-up" id="edit_<?php echo $counter?>">
        <div class="opt-head">
            <h6>Edit Options</h6>
            <a href="javascript:galclose(<?php echo $counter?>)" class="closeit">&nbsp;</a>
        </div>
        <div class="opt-conts">
            <ul class="form-elements">
                <li class="to-label">
                    <label>Image Title</label>
                </li>
                <li class="to-field">
                    <input type="text" name="title[]" value="<?php echo htmlspecialchars($title_db)?>" class="txtfield" />
                </li>
            </ul>
            <ul class="form-elements">
                <li class="to-label">
                    <label>Image Description</label>
                </li>
                <li class="to-field">
                    <textarea class="txtarea" name="description[]"><?php echo htmlspecialchars($description_db)?></textarea>
                </li>
            </ul>
            <ul class="form-elements">
                <li class="to-label">
                    <label>Use Image As</label>
                </li>
                <li class="to-field">
                    <select name="use_image_as[]" class="select_dropdown" onchange="cs_toggle('video_code<?php echo $counter?>')">
                        <option <?php if($use_image_as_db=="0")echo "selected";?> value="0">LightBox to current thumbnail</option>
                        <option <?php if($use_image_as_db=="1")echo "selected";?> value="1">LightBox to Video</option>
                    </select>
                </li>
                <li class="to-desc">
                    <p>Please select Image link where it will go.</p>
                </li>
            </ul>
            <ul class="form-elements" id="video_code<?php echo $counter?>" <?php if($use_image_as_db=="0" or $use_image_as_db=="")echo 'style="display:none"';?> >
                <li class="to-label">
                    <label>Video URL</label>
                </li>
                <li class="to-field">
                    <input type="text" name="video_code[]" value="<?php echo htmlspecialchars($video_code_db)?>" class="txtfield" />
                </li>
                <li class="to-desc">
                    <p>(Enter Specific Video URL Youtube or Vimeo)</p>
                </li>
            </ul>
            <ul class="form-elements">
                <li class="to-label">
                    
                </li>
                <li class="to-field">
                    <input type="hidden" name="path[]" value="<?php echo $path?>" />
                    <input type="button" onclick="javascript:galclose(<?php echo $counter?>)" value="Submit" class="close-submit" />
                </li>
            </ul>
            <div class="clear"></div>
        </div>
    </div>
</li>

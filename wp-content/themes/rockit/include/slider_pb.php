<?php 
foreach ($_POST as $keys=>$values) {
	$$keys = $values;
}
	if ( isset($_POST['name']) ) {
		require_once '../../../../wp-load.php';
		global $wpdb;
			$name = $_POST['name'];
			$counter = $_POST['counter'];
			$cs_slider_type_db = '';
			$cs_slider_db = '';
			$cs_slider_width_db = '';
			$cs_slider_height_db = '';
	}
	else {
		$name = ucfirst($node->getName());
			$count_node++;
			$cs_slider_type_db = $node->slider_type;
			$cs_slider_db = $node->slider;
			$cs_slider_width_db = $node->width;
			$cs_slider_height_db = $node->height;
				$counter = $post->ID.$count_node;
}
?> 
	<li id="<?php echo $name.$counter?>_sort">
		<div class="add_page_builder_item_show temp-tubes" id="<?php echo $name.$counter?>_del">
            <span class="slider">&nbsp;</span>
            <p><?php echo $name?></p>
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="javascript:delete_this('<?php echo $name.$counter?>')" class="delete-it">&nbsp;</a>
            <br class="clear" />
        </div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h6>Edit Slider Options</h6>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label">
                        <label>Choose SliderType</label>
                    </li>
                    <li class="to-field">
                        <select name="cs_slider_type[]" class="dropdown" onchange="cs_toggle_height(this.value,'cs_slider_height<?php echo $name.$counter?>')">
                            <option <?php if($cs_slider_type_db=="Anything Slider"){echo "selected";}?> >Anything Slider</option>
                            <option <?php if($cs_slider_type_db=="Nivo Slider"){echo "selected";}?> >Nivo Slider</option>
                            <option <?php if($cs_slider_type_db=="Sudo Slider"){echo "selected";}?> >Sudo Slider</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label">
                        <label>Choose Slider</label>
                    </li>
                    <li class="to-field">
                        <select name="cs_slider[]" class="dropdown">
                        	<option value="0">-- Select Slider --</option>
                            <?php
                                $query = array( 'post_type' => 'cs_slider', 'orderby'=>'ID', 'post_status' => 'publish' );
                                $wp_query = new WP_Query($query);
                                while ($wp_query->have_posts()) : $wp_query->the_post();
                            ?>
                                <option <?php if($post->post_name==$cs_slider_db)echo "selected";?> value="<?php echo $post->post_name?>"><?php echo $post->post_title?></option>
                            <?php
                                endwhile;
                            ?>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label">
                        <label>Slider Width</label>
                    </li>
                    <li class="to-field">
                        <input type="text" name="cs_slider_width[]" class="txtfield" value="<?php if($cs_slider_width_db=="")echo "500"; else echo $cs_slider_width_db;?>" />
                    </li>
                    <li class="to-desc">
                        <p>
                            Slider width in PX.
                        </p>
                    </li>                                        
                </ul>
                <ul class="form-elements <?php if($cs_slider_type_db=="Nivo Slider")echo 'no-display';?>" id="cs_slider_height<?php echo $name.$counter?>">
                    <li class="to-label">
                        <label>Slider Height</label>
                    </li>
                    <li class="to-field">
                        <input type="text" name="cs_slider_height[]" class="txtfield" value="<?php if($cs_slider_height_db=="") echo "300"; else echo $cs_slider_height_db;?>" />
                    </li>
                    <li class="to-desc">
                        <p>
                            Slider Height in PX.
                        </p>
                    </li>                                                            
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label">
                    </li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="slider" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </li>
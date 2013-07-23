<?php 
foreach ($_POST as $keys=>$values) {
	$$keys = $values;
}
	if ( isset($_POST['name']) ) {
		require_once '../../../../wp-load.php';
		global $wpdb;
			$name = $_POST['name'];
			$counter = $_POST['counter'];
			$cs_album_cat_db = '';
			$cs_album_title = '';
			$cs_album_filterable_db = '';
			$cs_album_cat_show_db = '';
			$cs_album_buynow_db = '';
			$cs_album_pagination_db = '';
			$cs_album_per_page_db = '';
	}
	else {
		$name = ucfirst($node->getName());
			$count_node++;
			$cs_album_title = $node->cs_album_title;
			$cs_album_cat_db = $node->cs_album_cat;
			$cs_album_filterable_db = $node->cs_album_filterable;
			$cs_album_cat_show_db = $node->cs_album_cat_show;
			$cs_album_buynow_db = $node->cs_album_buynow;
			$cs_album_pagination_db = $node->cs_album_pagination;
			$cs_album_per_page_db = $node->cs_album_per_page;
				$counter = $post->ID.$count_node;
	}
?> 
	<li id="<?php echo $name.$counter?>_sort">
    	<div class="add_page_builder_item_show temp-tubes" id="<?php echo $name.$counter?>_del">
            <span class="album">&nbsp;</span>
            <p><?php echo $name?></p>
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="javascript:delete_this('<?php echo $name.$counter?>')" class="delete-it">&nbsp;</a>
            <br class="clear" />
        </div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h6>Edit Album Options</h6>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label">
                        <label>Album Title</label>
                    </li>
                    <li class="to-field">
                        <input type="text" name="cs_album_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_album_title)?>" />
                    </li>
                    <li class="to-desc">
                        <p>
                            Album Page Title
                        </p>
                    </li>                                            
                </ul>
                <ul class="form-elements">
                    <li class="to-label">
                        <label>Choose Category</label>
                    </li>
                    <li class="to-field">
                        <select name="cs_album_cat[]" class="dropdown">
                        	<option value="0">-- Select Category --</option>
                        	<?php show_all_cats('', '', $cs_album_cat_db, "album-category");?>
                        </select>
                    </li>
                    <li class="to-desc">
                        <p>
                            Choose category to show albums list
                        </p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label">
                    	<label>Show Category</label>
                    </li>
                    <li class="to-field">
                        <select name="cs_album_cat_show[]" class="dropdown">
                            <option <?php if($cs_album_cat_show_db=="On")echo "selected";?> >On</option>
                            <option <?php if($cs_album_cat_show_db=="Off")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label">
                    	<label>Buy Now</label>
                    </li>
                    <li class="to-field">
                        <select name="cs_album_buynow[]" class="dropdown">
                            <option <?php if($cs_album_buynow_db=="On")echo "selected";?> >On</option>
                            <option <?php if($cs_album_buynow_db=="Off")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label">
                    	<label>Filterable</label>
                    </li>
                    <li class="to-field">
                        <select name="cs_album_filterable[]" class="dropdown" onchange="cs_toggle_tog('pagination<?php echo $name.$counter?>')">
                            <option <?php if($cs_album_filterable_db=="Off")echo "selected";?> >Off</option>
                            <option <?php if($cs_album_filterable_db=="On")echo "selected";?> >On</option>
                        </select>
                    </li>
                </ul>
                	<div id="pagination<?php echo $name.$counter?>" <?php if($cs_album_filterable_db=="On")echo 'class="no-display"'?> >
                        <ul class="form-elements">
                            <li class="to-label">
                                <label>Pagination</label>
                            </li>
                            <li class="to-field">
                                <select name="cs_album_pagination[]" class="dropdown" onchange="cs_toggle_tog('cs_album_per_page<?php echo $name.$counter?>')" >
                                    <option <?php if($cs_album_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>
                                    <option <?php if($cs_album_pagination_db=="Single Page")echo "selected";?> >Single Page</option>
                                </select>
                            </li>
                        </ul>
                        <ul class="form-elements <?php if($cs_album_pagination_db=="Single Page")echo 'no-display';?>" id="cs_album_per_page<?php echo $name.$counter?>">
                            <li class="to-label">
                                <label>No. of Album Per Page</label>
                            </li>
                            <li class="to-field">
                                <input type="text" name="cs_album_per_page[]" class="txtfield" value="<?php if($cs_album_per_page_db=="")echo "5"; else echo $cs_album_per_page_db;?>" />
                            </li>
                        </ul>
					</div>
                <ul class="form-elements noborder">
                    <li class="to-label">
                    	<label></label>
                    </li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="album" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </li>
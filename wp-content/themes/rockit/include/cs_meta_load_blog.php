<?php 
foreach ($_POST as $keys=>$values) {
	$$keys = $values;
}
	if ( isset($_POST['name']) ) {
		require_once '../../../../wp-load.php';
		global $wpdb;
			$name = $_POST['name'];
			$counter = $_POST['counter'];
			$cs_blog_title_db = '';
			$cs_blog_cat_db = '';
			$cs_blog_excerpt_db = '';
			$cs_blog_num_post_db = '';
			$cs_blog_pagination_db = '';
	}
	else {
		$name = ucfirst($node->getName());
			$count_node++;
			$cs_blog_title_db = $node->cs_blog_title;
			$cs_blog_cat_db = $node->cs_blog_cat;
			$cs_blog_excerpt_db = $node->cs_blog_excerpt;
			$cs_blog_num_post_db = $node->cs_blog_num_post;
			$cs_blog_pagination_db = $node->cs_blog_pagination;
				$counter = $post->ID.$count_node;
}
?> 
	<li id="<?php echo $name.$counter?>_sort">
    	<div class="add_page_builder_item_show temp-tubes" id="<?php echo $name.$counter?>_del">
            <span class="blog">&nbsp;</span>
            <p><?php echo $name?></p>
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="javascript:delete_this('<?php echo $name.$counter?>')" class="delete-it">&nbsp;</a>
            <br class="clear" />
        </div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h6>Edit Blog Options</h6>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label">
                        <label>Blog Header Title</label>
                    </li>
                    <li class="to-field">
                        <input type="text" name="cs_blog_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_blog_title_db)?>" />
                    </li>
                    <li class="to-desc">
                        <p>
                            Please enter Blog header title.
                        </p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label">
                        <label>Choose Category</label>
                    </li>
                    <li class="to-field">
                        <select name="cs_blog_cat[]" class="dropdown">
                        	<option value="0">-- Select Category --</option>
							<?php show_all_cats('', '', $cs_blog_cat_db, "category");?>
                        </select>
                    </li>
                    <li class="to-desc">
                        <p>
                            Please select category to show posts.
                        </p>
                    </li>                                        
                </ul>
                <ul class="form-elements">
                    <li class="to-label">
                        <label>Length of Excerpt</label>
                    </li>
                    <li class="to-field">
                        <input type="text" name="cs_blog_excerpt[]" class="txtfield" value="<?php if($cs_blog_excerpt_db=="")echo "255"; else echo $cs_blog_excerpt_db;?>" />
                    </li>
                    <li class="to-desc">
                        <p>
                            Enter number of character for short description text.
                        </p>
                    </li>                                        
                </ul>
                <ul class="form-elements">
                    <li class="to-label">
                        <label>Pagination</label>
                    </li>
                    <li class="to-field">
                        <select name="cs_blog_pagination[]" class="dropdown" onchange="cs_toggle_tog('cs_blog_num_post<?php echo $name.$counter?>')" >
                            <option <?php if($cs_blog_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($cs_blog_pagination_db=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements <?php if($cs_blog_pagination_db=="Single Page")echo 'no-display';?>" id="cs_blog_num_post<?php echo $name.$counter?>" >
                    <li class="to-label">
                        <label>No. of Post Per Page</label>
                    </li>
                    <li class="to-field">
                        <input type="text" name="cs_blog_num_post[]" class="txtfield" value="<?php if($cs_blog_num_post_db=="")echo "5"; else echo $cs_blog_num_post_db;?>" />
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label">
                    </li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="blog" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </li>
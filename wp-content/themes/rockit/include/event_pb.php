<?php 
foreach ($_POST as $keys=>$values) {
	$$keys = $values;
}
	if ( isset($_POST['name']) ) {
		require_once '../../../../wp-load.php';
		global $wpdb;
			$name = $_POST['name'];
			$counter = $_POST['counter'];
			$cs_event_title_db = '';
			$cs_event_view_db = '';
			$cs_event_type_db = '';
			$cs_event_category_db = '';
			$cs_event_time_db = '';
			$cs_event_map_db = '';
			$cs_event_excerpt_db = '';
			$cs_event_filterables_db = '';
			$cs_event_pagination_db = '';
			$cs_event_per_page_db = '';
	}
	else {
		$name = ucfirst($node->getName());
			$count_node++;
			$cs_event_title_db = $node->cs_event_title;
			$cs_event_view_db = $node->cs_event_view;
			$cs_event_type_db = $node->cs_event_type;
			$cs_event_category_db = $node->cs_event_category;
			$cs_event_time_db = $node->cs_event_time;
			$cs_event_map_db = $node->cs_event_map;
			$cs_event_excerpt_db = $node->cs_event_excerpt;
			$cs_event_filterables_db = $node->cs_event_filterables;
			$cs_event_pagination_db = $node->cs_event_pagination;
			$cs_event_per_page_db = $node->cs_event_per_page;
				$counter = $post->ID.$count_node;
}
?> 
	<li id="<?php echo $name.$counter?>_sort">
    	<div class="add_page_builder_item_show temp-tubes" id="<?php echo $name.$counter?>_del">
            <span class="events">&nbsp;</span>
            <p><?php echo $name?></p>
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="javascript:delete_this('<?php echo $name.$counter?>')" class="delete-it">&nbsp;</a>
            <br class="clear" />
        </div>
        
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
                <div class="opt-head">
                    <h6>Edit Event Options</h6>
                    <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
                </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label">
                        <label>Event Title</label>
                    </li>
                    <li class="to-field">
                        <input type="text" name="cs_event_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_event_title_db)?>" />
                    </li>
                    <li class="to-desc">
                        <p>
                            Event Page Title
                        </p>
                    </li>                                            
                </ul>
                <ul class="form-elements">
                    <li class="to-label">
                        <label>View</label>
                    </li>
                    <li class="to-field">
                        <select name="cs_event_view[]" class="dropdown">
                            <option value="List View" <?php if($cs_event_view_db=="List View")echo "selected";?> >List View</option>
                            <option value="Calender View" <?php if($cs_event_view_db=="Calender View")echo "selected";?> >Calender View</option>
                        </select>
                    </li>
                    <li class="to-desc">
                        <p>
                            Select layout for Listing page, calender view contain all the dates of events in calender format. List view contain all the events with title and description in list.
                        </p>
                    </li>                                                                                
                </ul>
                <ul class="form-elements">
                    <li class="to-label">
                        <label>Event Types</label>
                    </li>
                    <li class="to-field">
                        <select name="cs_event_type[]" class="dropdown">
                            <option <?php if($cs_event_type_db=="All Events")echo "selected";?> >All Events</option>
                            <option <?php if($cs_event_type_db=="Upcoming Events")echo "selected";?> >Upcoming Events</option>
                            <option <?php if($cs_event_type_db=="Past Events")echo "selected";?> >Past Events</option>
                        </select>
                    </li>
                    <li class="to-desc">
                        <p>
                            Select layout for Listing page, calender view contain all the dates of events in calender format. List view contain all the events with title and description in list.
                        </p>
                    </li>                                                                                
                </ul>
                <ul class="form-elements">
                    <li class="to-label">
                        <label>Select Category</label>
                    </li>
                    <li class="to-field">
                        <select name="cs_event_category[]" class="dropdown">
                        	<option value="0">-- Select Category --</option>
                            <?php show_all_cats('', '', $cs_event_category_db, "event-category");?>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label">
                        <label>Show Time</label>
                    </li>
                    <li class="to-field">
                        <select name="cs_event_time[]" class="dropdown">
                            <option value="Yes" <?php if($cs_event_time_db=="Yes")echo "selected";?> >Yes</option>
                            <option value="No" <?php if($cs_event_time_db=="No")echo "selected";?> >No</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label">
                        <label>Show Map</label>
                    </li>
                    <li class="to-field">
                        <select name="cs_event_map[]" class="dropdown">
                            <option value="Yes" <?php if($cs_event_map_db=="Yes")echo "selected";?> >Yes</option>
                            <option value="No" <?php if($cs_event_map_db=="No")echo "selected";?> >No</option>
                        </select>
                    </li>
                    <li class="to-desc">
                        <p>
                            Show only at List View.
                        </p>
                    </li>                                            
                </ul>
                <ul class="form-elements">
                    <li class="to-label">
                        <label>Length of Excerpt</label>
                    </li>
                    <li class="to-field">
                        <input type="text" name="cs_event_excerpt[]" class="txtfield" value="<?php if($cs_event_excerpt_db=="")echo "255"; else echo $cs_event_excerpt_db;?>" />
                    </li>
                    <li class="to-desc">
                        <p>
                            Enter number of character for short description text.
                        </p>
                    </li>                                        
                </ul>
                <ul class="form-elements">
                    <li class="to-label">
                        <label>Filterables</label>
                    </li>
                    <li class="to-field">
                        <select name="cs_event_filterables[]" class="dropdown" >
                            <option value="No" <?php if($cs_event_filterables_db=="No")echo "selected";?> >No</option>
                            <option value="Yes" <?php if($cs_event_filterables_db=="Yes")echo "selected";?> >Yes</option>
                        </select>
                    </li>
                </ul>
                        <ul class="form-elements">
                            <li class="to-label">
                                <label>Pagination</label>
                            </li>
                            <li class="to-field">
                                <select name="cs_event_pagination[]" class="dropdown" onchange="cs_toggle_tog('cs_event_per_page<?php echo $name.$counter?>')" >
                                    <option <?php if($cs_event_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>
                                    <option <?php if($cs_event_pagination_db=="Single Page")echo "selected";?> >Single Page</option>
                                </select>
                            </li>
                            <li class="to-desc">
                                <p>
                                    Show navigation only at List View.
                                </p>
                            </li>                                            
                        </ul>
                        <ul class="form-elements <?php if($cs_event_pagination_db=="Single Page")echo 'no-display';?>" id="cs_event_per_page<?php echo $name.$counter?>">
                            <li class="to-label">
                                <label>No. of Events Per Page</label>
                            </li>
                            <li class="to-field">
                                <input type="text" name="cs_event_per_page[]" class="txtfield" value="<?php if($cs_event_per_page_db=="")echo "5"; else echo $cs_event_per_page_db;?>" />
                            </li>
                            <li class="to-desc">
                                <p>
                                    Show number of events on per page only at List View.
                                </p>
                            </li>                                            
                        </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="event" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </li>
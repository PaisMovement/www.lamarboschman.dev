<?php
// event start
	//adding columns start
    add_filter('manage_events_posts_columns', 'event_columns_add' );
		function event_columns_add($columns) {
			$columns['category'] = 'Categories';
			$columns['author'] = 'Author';
			$columns['tag'] = 'Tags';
			return $columns;
	    }
    add_action('manage_events_posts_custom_column', 'event_columns');
		function event_columns($name) {
			global $post;
			switch ($name) {
				case 'category':
					$categories = get_the_terms( $post->ID, 'event-category' );
						if($categories <> ""){
							$couter_comma = 0;
							foreach ( $categories as $category ) {
								echo $category->name;
								$couter_comma++;
								if ( $couter_comma < count($categories) ) {
									echo ", ";
								}
							}
						}
					break;
				case 'author':
					echo get_the_author();
					break;
				case 'tag':
					$categories = get_the_terms( $post->ID, 'event-tag' );
						if($categories <> ""){
							$couter_comma = 0;
							foreach ( $categories as $category ) {
								echo $category->name;
								$couter_comma++;
								if ( $couter_comma < count($categories) ) {
									echo ", ";
								}
							}
						}
					break;
			}
		}
	//adding columns end
	
	function cs_event_register() {  
		$labels = array(
			'name' => __('Manage Event','mytheme'),
			'add_new_item' => __('Add New Event','mytheme'),
			'edit_item' => __('Edit Event','mytheme'),
			'new_item' => __('New Event Item','mytheme'),
			'add_new' => __('Add New Event','mytheme'),
			'view_item' => __('View Event Item','mytheme'),
			'search_items' => __('Search Event','mytheme'),
			'not_found' =>  __('Nothing found','mytheme'),
			'not_found_in_trash' => __('Nothing found in Trash','mytheme'),
			'parent_item_colon' => ''
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/events-icon.png',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail', 'excerpt')
		); 
        register_post_type( 'events' , $args );  

			// adding Manage Location start
				$labels = array(
					'name' => __('Manage Location', 'mytheme'),
					'add_new_item' => __('Add New Location (Venue Title)', 'mytheme'),
					'edit_item' => __('Edit Location', 'mytheme'),
					'new_item' => __('New Location Item', 'mytheme'),
					'add_new' => __('Add New Location', 'mytheme'),
					'view_item' => __('View Location Item', 'mytheme'),
					'search_items' => __('Search Location', 'mytheme'),
					'not_found' =>  __('Nothing found', 'mytheme'),
					'not_found_in_trash' => __('Nothing found in Trash', 'mytheme'),
					'parent_item_colon' => ''
				);
				$args = array(
					'labels' => $labels,
					'public' => true,
					'publicly_queryable' => true,
					'show_ui' => true,
					'query_var' => true,
					'menu_icon' => get_stylesheet_directory_uri() . '/images/calendar.png',
					'show_in_menu' => 'edit.php?post_type=events',
					'show_in_nav_menus'=>true,
					'rewrite' => true,
					'capability_type' => 'post',
					'hierarchical' => false,
					'menu_position' => null,
					'supports' => array('title')
				); 
				register_post_type( 'event-location' , $args );  
			// adding Manage Location end
				
		
    }
	add_action('init', 'cs_event_register');

	function cs_event_categories() 
	{
		  $labels = array(
			'name' => __( 'Event Categories','mytheme' ),
			'search_items' =>  __( 'Search Event Categories' ,'mytheme'),
			'edit_item' => __( 'Edit Event Category','mytheme' ), 
			'update_item' => __( 'Update Event Category','mytheme' ),
			'add_new_item' => __( 'Add New Category','mytheme' ),
			'menu_name' => __( 'Event Categories' ,'mytheme'),
		  ); 	
		  register_taxonomy('event-category',array('events'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'event-category' ),
		  ));
	}
	add_action( 'init', 'cs_event_categories');

	function cs_event_tag() {
		  $labels = array(
			'name' => __( 'Event Tags','mytheme'),
			'singular_name' => __( 'event-tag','mytheme' ),
			'search_items' =>  __( 'Search Tags' ,'mytheme'),
			'popular_items' => __( 'Popular Tags','mytheme' ),
			'all_items' => __( 'All Tags','mytheme' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit Tag','mytheme' ), 
			'update_item' => __( 'Update Tag','mytheme' ),
			'add_new_item' => __( 'Add New Tag','mytheme' ),
			'new_item_name' => __( 'New Tag Name' ,'mytheme'),
			'separate_items_with_commas' => __( 'Separate writers with commas','mytheme' ),
			'add_or_remove_items' => __( 'Add or remove tags','mytheme' ),
			'choose_from_most_used' => __( 'Choose from the most used tags','mytheme' ),
			'menu_name' => __( 'Event Tags','mytheme' ),
		  ); 
		  register_taxonomy('event-tag','events',array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array( 'slug' => 'event-tag' ),
		  ));
	}
	add_action( 'init', 'cs_event_tag');

	// event-location custom fields start
		add_action( 'add_meta_boxes', 'event_loc_meta' );  
		function event_loc_meta()
		{
			add_meta_box( 'event_loc_meta', 'Add Location With Map', 'event_loc_meta_data', 'event-location', 'normal', 'high' );
		}
		function event_loc_meta_data($post) {
			$event_loc_meta = get_post_meta($post->ID, "cs_event_loc_meta", true);
			if ( $event_loc_meta <> "" ) {
				$xmlObject = new SimpleXMLElement($event_loc_meta);
					$event_loc_lat = $xmlObject->event_loc_lat;
					$event_loc_long = $xmlObject->event_loc_long;
					$event_loc_zoom = $xmlObject->event_loc_zoom;
					$loc_address = $xmlObject->loc_address;
					$loc_city = $xmlObject->loc_city;
					$loc_postcode = $xmlObject->loc_postcode;
					$loc_region = $xmlObject->loc_region;
					$loc_country = $xmlObject->loc_country;
			}
			else {
				$event_loc_lat = '';
				$event_loc_long = '';
				$event_loc_zoom = '';
				$loc_address = '';
				$loc_city = '';
				$loc_postcode = '';
				$loc_region = '';
				$loc_country = '';
			}
			?>
				<fieldset class="gllpLatlonPicker">
            	<table width="100%" cellpadding="10">
                  <tr>
                    <td width="40%" valign="top">
						<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
                        <script src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery-gmaps-latlon-picker.js"></script>
                        	<table width="100%">
                              <tr>
                                <td>Address:</td>
                                <td><input name="loc_address" id="loc_address" type="text" value="<?php echo htmlspecialchars($loc_address)?>" class="gllpSearchButton" onblur="gll_search_map()" /></td>
                              </tr>
                              <tr>
                                <td>City / Town:</td>
                                <td><input name="loc_city" id="loc_city" type="text" value="<?php echo htmlspecialchars($loc_city)?>" class="gllpSearchButton" onblur="gll_search_map()" /></td>
                              </tr>
                              <tr>
                                <td>Post Code:</td>
                                <td><input name="loc_postcode" id="loc_postcode" type="text" value="<?php echo htmlspecialchars($loc_postcode)?>" class="gllpSearchButton" onblur="gll_search_map()" /></td>
                              </tr>
                              <tr>
                                <td>Region:</td>
                                <td><input name="loc_region" id="loc_region" type="text" value="<?php echo htmlspecialchars($loc_region)?>" class="gllpSearchButton" onblur="gll_search_map()" /></td>
                              </tr>
                              <tr>
                                <td>Country:</td>
                                <td>
                                    <select name="loc_country" id="loc_country" class="gllpSearchButton" onblur="gll_search_map()" >
										<?php foreach( get_countries() as $key => $val ):?>
                                        	<option <?php if($loc_country==$val)echo "selected"?> ><?php echo $val;?></option>
										<?php endforeach; ?>  
                                    </select>
                                </td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td><input type="button" class="gllpSearchButton" value="Search This Location on Map" onclick="gll_search_map()"></td>
                              </tr>
                            </table>
                    </td>
                    <td>
                        <input type="hidden" name="add_new_loc" class="gllpSearchField" style="margin-bottom:10px;" >
                        <div class="gllpMap">Google Maps</div>
                        <input type="hidden" name="event_loc_lat" value="<?php echo $event_loc_lat?>" class="gllpLatitude" />
                        <input type="hidden" name="event_loc_long" value="<?php echo $event_loc_long?>" class="gllpLongitude" />
                        <input type="hidden" name="event_loc_zoom" value="<?php echo $event_loc_zoom?>" class="gllpZoom" />
                        <input type="button" class="gllpUpdateButton" value="update map" style="display:none">
                    </td>
                  </tr>
                </table>
				</fieldset>
				<input type="hidden" name="event_loc_meta_form" value="1" />
			<?php
		}
	// event-location custom fields end
	// event-location custom fields save start
		if ( isset($_POST['event_loc_meta_form']) and $_POST['event_loc_meta_form'] == 1 ) {
			add_action( 'save_post', 'event_loc_meta_save' );
			function event_loc_meta_save( $post_id ) {
				$sxe = new SimpleXMLElement("<event_loc></event_loc>");
					$sxe->addChild('event_loc_lat',$_POST['event_loc_lat']);
					$sxe->addChild('event_loc_long',$_POST['event_loc_long']);
					$sxe->addChild('event_loc_zoom',$_POST['event_loc_zoom']);
					$sxe->addChild('loc_address',htmlspecialchars($_POST['loc_address']) );
					$sxe->addChild('loc_city',htmlspecialchars($_POST['loc_city']) );
					$sxe->addChild('loc_postcode',htmlspecialchars($_POST['loc_postcode']) );
					$sxe->addChild('loc_region',htmlspecialchars($_POST['loc_region']) );
					$sxe->addChild('loc_country',$_POST['loc_country']);
						update_post_meta( $post_id, 'cs_event_loc_meta', $sxe->asXML() );
			}
		}
	// event-location custom fields save end

	// event custom fields start
	add_action( 'add_meta_boxes', 'cs_event_meta' );  
    function cs_event_meta()
    {
        add_meta_box( 'event_meta', 'Event Options', 'cs_event_meta_data', 'events', 'normal', 'high' );
    }
	function cs_event_meta_data($post) {
		$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
		if ( $cs_event_meta <> "" ) {
			$xmlObject = new SimpleXMLElement($cs_event_meta);
				$event_social_sharing = $xmlObject->event_social_sharing;
				$event_start_time = $xmlObject->event_start_time;
				$event_end_time = $xmlObject->event_end_time;
				$event_all_day = $xmlObject->event_all_day;
				$event_booking_url = $xmlObject->event_booking_url;
				$event_address = $xmlObject->event_address;
				$event_loc_lat = $xmlObject->event_loc_lat;
				$event_loc_long = $xmlObject->event_loc_long;
				$event_loc_zoom = $xmlObject->event_loc_zoom;
		}
		else {
			$event_social_sharing = '';
			$event_start_time = '';
			$event_end_time = '';
			$event_all_day = '';
			$event_booking_url = '';
			$event_address = '';
			$event_loc_lat = '';
			$event_loc_long = '';
			$event_loc_zoom = '';
		}
		$cs_event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
		$cs_event_to_date = get_post_meta($post->ID, "cs_event_to_date", true);
	?>
		<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.timepicker.js"></script>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/jquery.ui.datepicker.css">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/jquery.ui.datepicker.theme.css">
        <script>
            jQuery(function($) {
                $('#event_start_time').timepicker();
                $('#event_end_time').timepicker();
            });
            jQuery(function($) {
                $( "#from_date" ).datepicker({
                    defaultDate: "+1w",
					dateFormat: "yy-mm-dd",
                    changeMonth: true,
                    numberOfMonths: 1,
                    onSelect: function( selectedDate ) {
                        $( "#to_date" ).datepicker( "option", "minDate", selectedDate );
                    }
                });
                $( "#to_date" ).datepicker({
                    defaultDate: "+1w",
					dateFormat: "yy-mm-dd",
                    changeMonth: true,
                    numberOfMonths: 1,
                    onSelect: function( selectedDate ) {
                        $( "#from_date" ).datepicker( "option", "maxDate", selectedDate );
                    }
                });
            });
        </script>

    	<div class="page-wrap">
            <div class="option-sec" style="margin-bottom:0;">
                <div class="opt-conts">
                    <ul class="form-elements">
                        <li class="to-label">
                            <label>Social Sharing</label>
                        </li>
                        <li class="to-field">
                            <div class="on-off">
                                <input type="checkbox" name="event_social_sharing" value="on" class="styled" <?php if($event_social_sharing=='on')echo "checked"?> />
                            </div>
                        </li>
                        <li class="to-desc">
                            <p>
                                Enable/Disbale social sharing
                            </p>
                        </li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label">
                            <label>Event Start Date</label>
                        </li>
                        <li class="to-field">
                            <input type="text" id="from_date" name="event_from_date" value="<?php if($cs_event_from_date=='') echo gmdate("Y-m-d"); else echo $cs_event_from_date?>" />
                        </li>
                        <li class="to-desc">
                            <p>
                                Put event start date
                            </p>
                        </li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label">
                            <label>Event End Date</label>
                        </li>
                        <li class="to-field">
                            <input type="text" id="to_date" name="event_to_date" value="<?php if($cs_event_to_date=='') echo gmdate("Y-m-d"); else echo $cs_event_to_date?>" />
                        </li>
                        <li class="to-desc">
                            <p>
                                Put event end date
                            </p>
                        </li>
                    </ul>
                    <?php if ( empty( $_GET['post']) ) {?>
                        <ul class="form-elements">
                            <li class="to-label">
                                <label>Repeat</label>
                            </li>
                            <li class="to-field">
                                <select name="repeat" class="dropdown" onchange="toggle_with_value('num_repeat', this.value)">
									<option value="0">-- Never Repeat --</option>
									<option value="+1 day">Every Day</option>
									<option value="+1 week">Every Week</option>
									<option value="+1 month">Every Month</option>
                                </select>
                            </li>
                            <li class="to-desc">
                                <p></p>
                            </li>
                        </ul>
                        <ul class="form-elements" id="num_repeat" style="display:none">
                            <li class="to-label">
                                <label>Repeat how many time</label>
                            </li>
                            <li class="to-field">
                                <select name="num_repeat" class="dropdown">
                                    <?php for ( $i = 1; $i <= 25; $i++ ) {?>
                                        <option><?php echo $i?></option>
                                    <?php }?>
                                </select>
                            </li>
                            <li class="to-desc">
                                <p></p>
                            </li>
                        </ul>
                    <?php }?>
                    <ul class="form-elements">
                        <li class="to-label">
                            <label>Events start time from</label>
                        </li>
                        <li class="to-field">
                            <div id="event_time" <?php if($event_all_day=='on')echo 'style="display:none"'?>>
                                <input id="event_start_time" name="event_start_time" value="<?php echo $event_start_time?>" type="text" size="10" readonly="readonly" />
                                <span style="width:100%; display:block; padding:7px 0px; font-weight:bold;">To</span>
                                <input id="event_end_time" name="event_end_time" value="<?php echo $event_end_time?>" type="text" size="10" readonly="readonly"  />
                            </div>
                            <div class="checkbox-list" style="padding-top:15px;">
                                <div class="checkbox-item">
                                    <input type="checkbox" name="event_all_day" value="on" <?php if($event_all_day=='on')echo "checked"?> onclick="cs_toggle('event_time')" />
                                    <span>All Day</span>
                                </div>
                            </div>
                        </li>
						<li class="to-desc">
                            <p>
                                Start and ending time
                            </p>
                        </li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label">
                            <label>Booking URL</label>
                        </li>
                        <li class="to-field">
                            <input type="text" name="event_booking_url" value="<?php echo htmlspecialchars($event_booking_url)?>" />
                        </li>
                        <li class="to-desc">
                            <p>
                                Put booking URL
                            </p>
                        </li>
                    </ul>
                    <ul class="form-elements noborder">
                        <li class="to-label">
                            <label>Location / Address</label>
                        </li>
                        <li class="to-field">
                        	<?php
                            //echo $event_address."<br />";
								query_posts( array('post_type' => 'event-location') );
									while ( have_posts()) : the_post();
										//echo get_the_ID();
									endwhile;
							?>

                        	<select name="event_address" class="dropdown">
                            	<option value="0"></option>
                                <?php
									query_posts( array('posts_per_page' => "-1", 'post_status' => 'publish', 'post_type' => 'event-location') );
										while ( have_posts()) : the_post();
										?>
	                                        <option <?php if($event_address==get_the_ID())echo "selected"?> value="<?php the_ID()?>"><?php the_title()?></option>
                                        <?php
										endwhile;
                                ?>
                            </select>
                            <br /><br />
                        </li>
                        <li class="to-desc">
                            <p>
                                Put the address
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
            <?php include "inc_meta_layout.php";?>
            <input type="hidden" name="event_meta_form" value="1" />
			<div class="clear"></div>
		</div>
    
    <?php
	}
	// event custom fields end

	// event custom fields save start
		if ( isset($_POST['event_meta_form']) and $_POST['event_meta_form'] == 1 ) {
			add_action( 'save_post', 'cs_event_meta_save' );
			function cs_event_meta_save( $post_id ) {
				// repeating events start
				if ( isset($_POST['num_repeat'] ) ) {
					if ( $_POST['num_repeat'] > 1 ) $_SESSION['event_num_repeat'] = $_POST['num_repeat'];
					global $wpdb;
					$post_thumbnail_id = get_post_thumbnail_id( $post_id );
					$post = get_post($post_id);
					$from_date = $_POST["event_from_date"];
					$to_date = $_POST["event_to_date"];
						for ( $i = 1; $i < $_POST['num_repeat']; $i++ ) {
							$wpdb->insert( $wpdb->prefix.'posts',
									array(
										'post_author'		=> $post->post_author,
										'post_date'			=> $post->post_date,
										'post_date_gmt'		=> $post->post_date_gmt,
										'post_content'		=> $post->post_content,
										'post_title'		=> $post->post_title,
										'post_excerpt'		=> $post->post_excerpt,
										'post_status'		=> $post->post_status,
										'comment_status'	=> $post->comment_status,
										'ping_status'		=> $post->ping_status,
										'post_name'			=> $post->post_name."-".$i,
										'post_modified'		=> $post->post_modified,
										'post_modified_gmt'	=> $post->post_modified_gmt,
										'post_type'			=> $post->post_type
									)
							);
							$inserted_id = (int) $wpdb->insert_id;
							// adding categories start
								$terms = wp_get_post_terms($post->ID, "event-category");
								foreach ( $terms as $val ) {
									$wpdb->insert( $wpdb->prefix.'term_relationships',
											array(
												'object_id'	=> $inserted_id,
												'term_taxonomy_id'	=> $val->term_id,
												'term_order'	=> 0
											)
									);
								}
							// adding categories end
							// adding tag start
								$terms = wp_get_post_terms($post->ID, "event-tag");
								foreach ( $terms as $val ) {
									$wpdb->insert( $wpdb->prefix.'term_relationships',
											array(
												'object_id'	=> $inserted_id,
												'term_taxonomy_id'	=> $val->term_id,
												'term_order'	=> 0
											)
									);
								}
							// adding tag end
							// adding feature image start
								if ( $post_thumbnail_id ) update_post_meta( $inserted_id, '_thumbnail_id', $post_thumbnail_id );
							// adding feature image end
							events_meta_save($inserted_id);
							if ( $_POST['repeat'] <> 0 ) {
								$from_date = strtotime(date("Y-m-d", strtotime($from_date)) . $_POST['repeat'] );
									$from_date = date('Y-m-d', $from_date);
								$to_date = strtotime(date("Y-m-d", strtotime($to_date)) . $_POST['repeat'] );
									$to_date = date('Y-m-d', $to_date);

								update_post_meta( $inserted_id, 'cs_event_from_date', $from_date );
								update_post_meta( $inserted_id, 'cs_event_to_date', $to_date );
							}
						}
				}
				// repeating events end
				events_meta_save($post_id);
					update_post_meta( $post_id, 'cs_event_from_date', $_POST["event_from_date"] );
					update_post_meta( $post_id, 'cs_event_to_date', $_POST["event_to_date"] );
			}
		}
	// event custom fields save end
	
// event end
?>
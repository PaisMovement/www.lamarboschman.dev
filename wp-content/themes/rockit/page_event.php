<?php
	global $node,$counter_gal,$cs_transwitch;

?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
<div id="show_next">
<?php
	$row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $node->cs_event_category ."'" );
	$meta_compare = '';
	$filter_category = '';
	
	if ( $node->cs_event_type == "Upcoming Events" ) $meta_compare = ">=";
	else if ( $node->cs_event_type == "Past Events" ) $meta_compare = "<";

	//if ( empty ($row_cat->name) or $row_cat->name == "" ) $row_cat->name = "";
	if ( isset($_GET['filter_category']) ) $filter_category = $_GET['filter_category'];
	else $filter_category = $row_cat->slug;

	if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;

		if ( $node->cs_event_type == "Upcoming Events") {
                            $args = array(
                                'posts_per_page'			=> "-1",
                                'post_type'					=> 'events',
                                'event-category'			=> "$filter_category",
                                'post_status'				=> 'publish',
                                'meta_key'					=> 'cs_event_from_date',
                                'meta_value'				=> date('Y-m-d'),
                                'meta_compare'				=> ">=",
                                'orderby'					=> 'meta_value',
                                'order'						=> 'ASC',
                             );
					}elseif ( $node->cs_event_type == "All Events" ) {
						$args = array(
							'posts_per_page'			=> "-1",
							'paged'						=> $_GET['page_id_all'],
							'post_type'					=> 'events',
							'event-category'			=> "$filter_category",
							'post_status'				=> 'publish',
							'meta_key'					=> 'cs_event_from_date',
							'meta_value'				=> '',
							'orderby'					=> 'meta_value',
							'order'						=> 'DESC',
							);
					}
					else {
						$args = array(
							'posts_per_page'			=> "-1",
							'paged'						=> $_GET['page_id_all'],
							'post_type'					=> 'events',
							'event-category'			=> "$filter_category",
							'post_status'				=> 'publish',
							'meta_key'					=> 'cs_event_from_date',
							'meta_value'				=> date('Y-m-d'),
							'meta_compare'				=> $meta_compare,
							'orderby'					=> 'meta_value',
							'order'						=> 'ASC',
							);
					}
		$custom_query = new WP_Query($args);
		//query_posts($args);
		$count_post = 0;
			while ( $custom_query->have_posts()) : $custom_query->the_post();
				$count_post++;
			endwhile;
			wp_reset_query();
		
		if ( $node->cs_event_pagination == "Single Page" ) $node->cs_event_per_page = -1;
		$event_type = 'event_trans_'.strtolower(str_replace(' ','_',$node->cs_event_type));
?>
    <?php if($node->cs_event_title <> ''){?>
    	<h1 class="heading"><?php echo $node->cs_event_title?></h1>
    <?php } ?>
	<?php if($node->cs_event_filterables == "Yes"){?>
		<div class="cat-select">
			<ul>
				<li><h5><?php if($cs_transwitch =='on'){ _e('Select Events Category',CSDOMAIN); }else{ echo __CS('event_trans_category_filter', 'Select Events Category'); }?></h5></li>
				<li>
					<form action="" method="get">
						<input type="hidden" name="page_id" value="<?php if (isset($_GET['page_id'])) echo $_GET['page_id']?>" />
						<select name="filter_category" onchange="this.form.submit()">
							<option><?php echo $row_cat->name?></option>
							<?php
								$categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'event-category', 'hide_empty' => 0) );
								foreach ($categories as $category) {
							?>
								<option <?php if($filter_category==$category->cat_name) echo "selected";?> ><?php echo $category->cat_name?></option>
							<?php
								}
							?>
						</select>
					</form>
				</li>
			</ul>
		</div>
	<?php }?>
	<?php
    if( $node->cs_event_view == "List View" ) {
	?>
        <div class="in-sec in-sec-nopad">
            <!-- Timeline Start -->
            <div id="tab-timeline">
                <ul class="timeline">
                    <?php
					if ( $node->cs_event_type == "Upcoming Events") {
                            $args = array(
                                'posts_per_page'			=> "$node->cs_event_per_page",
								'paged'						=> $_GET['page_id_all'],
                                'post_type'					=> 'events',
                                'event-category'			=> "$filter_category",
                                'post_status'				=> 'publish',
                                'meta_key'					=> 'cs_event_from_date',
                                'meta_value'				=> date('Y-m-d'),
                                'meta_compare'				=> ">=",
                                'orderby'					=> 'meta_value',
                                'order'						=> 'ASC',
                             );
					}elseif ( $node->cs_event_type == "All Events" ) {
						$args = array(
							'posts_per_page'			=> "$node->cs_event_per_page",
							'paged'						=> $_GET['page_id_all'],
							'post_type'					=> 'events',
							'event-category'			=> "$filter_category",
							'post_status'				=> 'publish',
							'meta_key'					=> 'cs_event_from_date',
							'meta_value'				=> '',
							'orderby'					=> 'meta_value',
							'order'						=> 'DESC',
							);
					}
					else {
						$args = array(
							'posts_per_page'			=> "$node->cs_event_per_page",
							'paged'						=> $_GET['page_id_all'],
							'post_type'					=> 'events',
							'event-category'			=> "$filter_category",
							'post_status'				=> 'publish',
							'meta_key'					=> 'cs_event_from_date',
							'meta_value'				=> date('Y-m-d'),
							'meta_compare'				=> $meta_compare,
							'orderby'					=> 'meta_value',
							'order'						=> 'ASC',
							);
					}
					$custom_query = new WP_Query($args);
                    //query_posts($args);
                    if ( $custom_query->have_posts() <> "" ) {
                        while ( $custom_query->have_posts() ): $custom_query->the_post();
                            $cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
                            if ( $cs_event_meta <> "" ) {
                                $cs_event_meta = new SimpleXMLElement($cs_event_meta);
                            }
                    ?>
                            <li>
                                <div class="date">
                                	<span>&nbsp;</span>
                                    <h6 class="colr">
										<?php
                                            $event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
                                            $event_to_date = get_post_meta($post->ID, "cs_event_to_date", true);
                                            echo date( get_option("date_format"), strtotime($event_from_date) );
                                        ?>
                                    </h6>
                                </div>
                                <div class="desc">
                                    <div class="desc-in">
                                        <span class="pointer">&nbsp;</span>
                                        <div class="thumb">
                                            <a href="<?php echo get_permalink()?>">
                                                <?php
                                                    $image_id = get_post_thumbnail_id ( $post->ID );
                                                    if ( $image_id <> "" ) {
                                                        $image_url = cs_attachment_image_src($image_id, 120, 95);
                                                        echo "<img src='".$image_url."' />";
                                                    }
                                                    else {
                                                        echo "<img width='120' height='95' src='".get_template_directory_uri()."/images/no_image.jpg' />";
                                                    }
                                                ?>	
                                            </a>
                                        </div>
                                        <div class="txt">
                                            <h5>
                                                <a href="<?php echo get_permalink()?>">
                                                    <?php echo substr(get_the_title(), 0, 50);  if ( strlen(get_the_title()) > 50 ) echo "..."; ?>
                                                </a>
                                            </h5>
                                            <p>
                                                <?php
													if (post_password_required()) { 
														echo pixfill_password_form();
													}else{
														$cs_news_excerpt_db = $node->cs_event_excerpt;
														cs_get_the_excerpt($cs_news_excerpt_db);
													}
                                                ?>
                                            </p>
                                        </div>
                                           <?php
													$cs_event_loc = get_post_meta($cs_event_meta->event_address, "cs_event_loc_meta", true);
													if ( $cs_event_loc <> "" ) {
														$xmlObject = new SimpleXMLElement($cs_event_loc);
															$event_loc_lat = $xmlObject->event_loc_lat;
															$event_loc_long = $xmlObject->event_loc_long;
															$event_loc_zoom = $xmlObject->event_loc_zoom;
													}
													else {
														$event_loc_lat = '';
														$event_loc_long = '';
														$event_loc_zoom = '';
													}
													$address_map = '';
													$address_map = get_the_title("$cs_event_meta->event_address");
  												?>
                                            <div class="map-sec active" id="mapctr<?php echo $post->ID.$counter_gal;?>" >
                                                <a onClick="javascript:map_hide_show('mapctr<?php echo $post->ID.$counter_gal;?>')" class="closemap">&nbsp;</a>
                                                <div class="mapdiv<?php echo $post->ID.$counter_gal;?>" id="map_canvas<?php echo $post->ID.$counter_gal;?>" style=" height:200px;">
                                                	<?php  if($node->cs_event_map == "Yes"){ ?>
                                             		<script type='text/javascript'>
														jQuery(document).ready(function(){
                                                        	event_map("<?php echo $address_map ?>",<?php echo $event_loc_lat ?>,<?php echo $event_loc_long ?>,<?php echo $event_loc_zoom ?>,<?php echo $post->ID.$counter_gal ?>);
														});
													</script>
                                                    <?php  } ?>
                                                 </div>
                                            </div>
                                            <div class="gig-opts table_section">
                                            	<div class="table_row">
	                                                <?php 
 	                                                if($node->cs_event_time == 'Yes') {
	                                                    echo "<h6 class='time'>";
	                                                    if ( $cs_event_meta->event_all_day == "" ) {
	                                                        echo $cs_event_meta->event_start_time . " &ndash; " . $cs_event_meta->event_end_time;
	                                                    }
	                                                    else 
														if($cs_transwitch =='on'){ _e('All Day',CSDOMAIN); }else{  echo __CS('event_trans_all_day', 'All Day'); }
	                                                    echo "</h6>";
	                                                }
	                                                ?>
	                                                <a class="location" <?php  if($node->cs_event_map == "Yes"){ ?> href="javascript:map_hide_show('mapctr<?php echo $post->ID.$counter_gal;?>')" <?php } ?>><?php echo get_the_title( "$cs_event_meta->event_address" )?></a>
	                                                <?php if($cs_event_meta->event_booking_url <> ""){ ?>
	                                                    <a class="booking_url" href="<?php echo $cs_event_meta->event_booking_url;?>" target="_blank"><?php if($cs_transwitch =='on'){ _e('BUY TICKETS',CSDOMAIN); }else{ echo __CS('event_trans_booking_url', 'BUY TICKETS'); } ?></a>
	                                                <?php }?>
	                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                    <?php
                        endwhile; wp_reset_query();
                    }
                    ?>
                </ul>
                        <div class="clear"></div>
                            <?php
                            // pagination start
                                if ( $node->cs_event_pagination == "Show Pagination" and $node->cs_event_per_page > 0 ) {
                                    echo "<div class='in-sec'><ul class='pagination'>";
                                        $qrystr = '';
                                        if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                                        if ( isset($_GET['filter_category']) ) $qrystr .= "&filter_category=".$_GET['filter_category'];
                                    echo cs_pagination($count_post, $node->cs_event_per_page, $qrystr);
                                    echo "</ul></div>";
                                }
                            // pagination end
                            ?>
                    </div>
                    <!-- Timeline End -->
            <div class="clear"></div>
        </div>

<?php
	}
	else {
		if ( $node->cs_event_type == "All Events" ) {
			$args = array(
				'posts_per_page'			=> "-1",
				'post_type'					=> 'events',
				'event-category'			=> "$filter_category",
				'post_status'				=> 'publish',
				'orderby'					=> 'meta_value',
				'order'						=> 'ASC',
				);
		}
		else {
			$args = array(
				'posts_per_page'			=> "-1",
				'post_type'					=> 'events',
				'event-category'			=> "$filter_category",
				'post_status'				=> 'publish',
				'meta_key'					=> 'cs_event_from_date',
				'meta_value'				=> date('Y-m-d'),
				'meta_compare'				=> $meta_compare,
				'orderby'					=> 'meta_value',
				'order'						=> 'ASC',
				);
		}
		$custom_query = new WP_Query($args);
		//query_posts($args);
			if ( $custom_query->have_posts() <> "" ) {
				while ( $custom_query->have_posts() ): $custom_query->the_post();
					$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
					$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
					if ( $cs_event_meta <> "" ) {
						$cs_event_meta = new SimpleXMLElement($cs_event_meta);
					}
					$aaa[] = array(
						'title' => substr(get_the_title(), 0, 35).'....',
						'start' => date("Y-m-d", strtotime($event_from_date)),
						'url' => get_permalink()
					);
				endwhile;
				wp_reset_query();
			} // have Post Condition
?>
        <!--Calendar View start-->
           <?php event_enqueue_styles_scripts();?>
            <script type='text/javascript'>
                jQuery(document).ready(function($) {
                    $('#calendar').fullCalendar({
                        editable: false,
                        events: <?php echo json_encode( $aaa );?>,
                        eventDrop: function(event, delta) {
                            alert(event.title + ' was moved ' + delta + ' days\n' +
                                '(should probably update your database)');
                        },
                        loading: function(bool) {
                            if (bool) $('#loading').show();
                            else $('#loading').hide();
                        }
                    });
                });
            </script>
            <div id='loading' style='display:none'>loading...</div>
            <div class="in-sec in-sec-nopad">
                <div id='calendar'></div>
            </div>
        <!--Calendar View end -->
<?php
	}
	
?>
</div>
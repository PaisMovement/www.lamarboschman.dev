<?php
class upcomingevents_count extends WP_Widget
{
  function upcomingevents_count()
  {
    $widget_ops = array('classname' => 'upcomingevents_count small-banners', 'description' => 'Select Event to show its countdown.' );
    $this->WP_Widget('upcomingevents_count', 'ChimpS : Event Countdown', $widget_ops);
  }
 
  function form($instance)
  {
	  
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ,'widget_names_events' =>'new') );
    $title = $instance['title'];
	//$img_url = isset( $instance['img_url'] ) ? esc_attr( $instance['img_url'] ) : '';
	$get_post_slug = isset( $instance['get_post_slug'] ) ? esc_attr( $instance['get_post_slug'] ) : '';
?>
 
  <p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
	  Title: 
	  <br />
	  <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
  </p>
	<!--<p>
		<label for="<?php echo $this->get_field_id('img_url'); ?>">
			  Background Image Url:
			  <br />
			  <input class="upcoming" id="<?php echo $this->get_field_id('img_url'); ?>" size="40" name="<?php echo $this->get_field_name('img_url'); ?>" type="text" value="<?php echo esc_attr($img_url); ?>" />
		</label>
	</p>-->  
  <p>
  <label for="<?php echo $this->get_field_id('get_post_slug'); ?>">
	  Select Event:
	  <select id="<?php echo $this->get_field_id('get_post_slug'); ?>" name="<?php echo $this->get_field_name('get_post_slug'); ?>" style="width:225px;">
		<?php
        global $wpdb,$post;
        $newpost = 'posts_per_page=-1&post_type=events&order=ASC&post_status=publish';
			$newquery = new WP_Query($newpost);
				echo '<option value="">Select Event</option>';
				while ( $newquery->have_posts() ): $newquery->the_post(); ?>
                    <option <?php if(esc_attr($get_post_slug) == $post->post_name){echo 'selected';}?> value="<?php echo $post->post_name;?>" >
	                    <?php echo substr(get_the_title($post->ID), 0, 20);	if ( strlen(get_the_title($post->ID)) > 20 ) echo "...";?>
                    </option>						
			<?php endwhile;?>
      </select>
  </label>
  </p>  
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
	//$instance['img_url'] = $new_instance['img_url'];
	$instance['get_post_slug'] = $new_instance['get_post_slug'];	
    return $instance;
  }
 
	function widget($args, $instance)
	{
		global $cs_transwitch;
		extract($args, EXTR_SKIP);

		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		//$img_url = isset( $instance['img_url'] ) ? esc_attr( $instance['img_url'] ) : '';
		echo $before_widget;	
		$get_post_slug = isset( $instance['get_post_slug'] ) ? esc_attr( $instance['get_post_slug'] ) : '';		
		 
		$args=array(
		  'name' => $get_post_slug,
		  'post_type' => 'events',
		  'post_status' => 'publish',
		  'showposts' => 1,
 		);
		$get_posts = get_posts($args);
		if( $get_posts ) {
			$get_post_id = $get_posts[0]->ID;
		}else{
			$get_post_id = '';
		}
 		if($get_post_id <> ""){ //$get_post_slug = '4';
		
		// WIDGET display CODE Start
			
		if (!empty($title))
			//echo $before_title . $title . $after_title;
			global $wpdb, $post;
				
				$cs_event_from_date = get_post_meta($get_post_id , "cs_event_from_date", true);
				//$event_to_date = get_post_meta($instance['get_post_slug'], "cs_event_to_date", true);
				$year_event = date("Y", strtotime($cs_event_from_date));
				$month_event = date("m", strtotime($cs_event_from_date));
				$month_event_c = date("M", strtotime($cs_event_from_date));							
				$date_event = date("d", strtotime($cs_event_from_date));
				$cs_event_meta = get_post_meta($get_post_id , "cs_event_meta", true);
				if ( $cs_event_meta <> "" ) {
					$cs_event_meta = new SimpleXMLElement($cs_event_meta);
				}
				if($cs_event_meta->event_all_day == ''){
					$time_left = date("H,i,s", strtotime("$cs_event_meta->event_start_time"));
				}else{
					$time_left = date("H,i,s", strtotime(12,00));
				}
				$image_id = get_post_thumbnail_id ($get_post_id );
				if($image_id <> ''){
					$image_url = cs_attachment_image_src($image_id, 438, 288);
				}
				
				$current_gtm = get_option('gmt_offset');
				countdown_enqueue_scripts();
				?>
                <script>
					jQuery(function ($) {
							var austDay = new Date();
							austDay = new Date(<?php echo $year_event;?>, <?php echo $month_event;?>-1, <?php echo $date_event;?>,<?php echo $time_left?>);
							console.log(austDay);
							$('#defaultCountdownn<?php echo $get_post_id?>').countdown({timezone: <?php echo $current_gtm; ?>, until: austDay});
							$('#year').text(austDay.getFullYear());
					});                
                </script>
                        <a href="#" class="thumb"><?php if(isset($image_url)){?><img width="298" height="188" src="<?php echo $image_url?>" alt="" /><?php }else{?><img src="<?php echo get_template_directory_uri(); ?>/images/img1.jpg" width="298" height="188" alt="" /><?php }?></a>
                        <h1 class="title"><?php echo substr($title, 0, 20); if ( strlen($title) > 20 ) echo "...";?></h1>
                        <div class="event-counter">
                            <?php if($get_post_slug <> ''){?>
                            <h3>
                            	<a class="colr" href="<?php echo get_permalink($get_post_id);?>">
									<?php 
										echo substr( get_the_title ($get_post_id), 0, 15 );
										$count_len = strlen( get_the_title ($get_post_id) );
										if ( $count_len > 15 ) echo "...";
									?>
	                            </a>
							</h3>
                            <?php }?>
                            <div id="defaultCountdownn<?php echo $get_post_id; ?>"></div>
						</div>
                <?php
			
		}else{
		?>
			<h1 class="heading"><?php echo substr($title, 0, 20); if ( strlen($title) > 20 ) echo "..." ?></h1>
			<?php 
            	echo '<div class="box-small no-results-found"> <h5>';
					_e("No results found.",CSDOMAIN);
				echo ' </h5></div>';
			}
			echo $after_widget;	// WIDGET display CODE Ends
		}
	}
add_action( 'widgets_init', create_function('', 'return register_widget("upcomingevents_count");') );?>
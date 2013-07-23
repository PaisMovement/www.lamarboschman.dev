<?php
class upcomingevents extends WP_Widget
{
  function upcomingevents()
  {
    $widget_ops = array('classname' => 'upcomingevents', 'description' => 'Select Recent Events to show' );
    $this->WP_Widget('upcomingevents', 'ChimpS : Recent Events', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
	$nop = isset( $instance['nop'] ) ? esc_attr( $instance['nop'] ) : '';
?>
  <p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
	  Title: 
	  <input class="upcoming" size="40" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
  </p> 
  <br />
  <div class="clear"></div>
  <br />
  <div class="clear"></div>
  <p>
  <label for="<?php echo $this->get_field_id('nop'); ?>">
	  Number of Posts To Display:
	  <input class="upcoming" size="2" id="<?php echo $this->get_field_id('nop'); ?>" name="<?php echo $this->get_field_name('nop'); ?>" type="text" value="<?php echo esc_attr($nop); ?>" />
  </label>
  </p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
	$instance['nop'] = $new_instance['nop'];
    return $instance;
  }
 
	function widget($args, $instance)
	{
		global $cs_transwitch;
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		if($instance['nop'] == ""){$instance['nop'] = '-1';}
		echo $before_widget;	
		// WIDGET display CODE Start
		if (!empty($title))
			echo $before_title;
			echo $title;
			echo $after_title;
			global $wpdb, $post;?>
            <div class="list-thumb">
				<ul>
                <?php
				$args = array(
                                'posts_per_page'			=> $instance['nop'],
                                'post_type'					=> 'events',
                                'post_status'				=> 'publish',
                                'meta_key'					=> 'cs_event_from_date',
                                'meta_value'				=> date('Y-m-d'),
                                'meta_compare'				=> '>',
                                'orderby'					=> 'meta_value',
                                'order'						=> 'ASC',
    	                        );
                    query_posts($args);?>
					<?php 
					 if ( have_posts() <> "" ) {
                        while ( have_posts() ): the_post();?>
						<li>
						<?php
							$cs_event_to_date = get_post_meta($post->ID, "cs_event_to_date", true);
							$cs_event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
							//$event_to_date = get_post_meta($instance['get_names_events'], "cs_event_to_date", true);
							$year_event = date("Y", strtotime($cs_event_from_date));
							$month_event = date("m", strtotime($cs_event_from_date));
							$month_event_c = date("M", strtotime($cs_event_from_date));							
							$date_event = date("d", strtotime($cs_event_from_date));
							$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
							if ( $cs_event_meta <> "" ) {
								$cs_event_meta = new SimpleXMLElement($cs_event_meta);
							}		
						$image_id = get_post_thumbnail_id (get_the_ID());	
						if ( $image_id <> "" ) {
							//$image_url = wp_get_attachment_image_src($image_id, array(120,95),true);
							$image_url = cs_attachment_image_src($image_id, 120, 95);
							?>
                                <a href="" class="thumb">
                                    <img width="62" height="58" src="<?php echo $image_url?>" alt="" />
                                </a>                                                      
					<?php	}
						else {
							echo "<a href='' class='thumb'><img width='62' height='58' src='".get_template_directory_uri()."/images/no_image.jpg' /></a>";
						}
						?>
                        <div class="desc">
                            <h5><a href="<?php echo get_permalink()?>"><?php echo substr(get_the_title ( ), 0, 20); if ( strlen(get_the_title ( )) > 20 ) echo "...";?></a></h5>
                            <span>
								<?php 
//									if ( $cs_event_meta->event_all_day == "" ) {
//										echo $cs_event_meta->event_start_time . " &ndash; " . $cs_event_meta->event_end_time;
//									}else{
//										echo 'All Day';
//										}
                                ?>
								<?php echo 'Starting on '.date( get_option("date_format"), strtotime($cs_event_from_date) );?>                                
                            </span>
                            <p>
							<?php
								if ( $post->post_excerpt <> "" ) $get_the_excerpt = $post->post_excerpt;
								else $get_the_excerpt = $post->post_content;
									$get_the_excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU','', $get_the_excerpt ));
									echo substr($get_the_excerpt, 0, "60");
									if ( strlen( $get_the_excerpt ) > "60" ) {
										echo '<a href="'.get_permalink().'"> '. __('More...', CSDOMAIN).'</a>';
									}
                            ?>
                            </p>
                        </div>
					</li>     
                                       
                    <?php endwhile; 
					 }else{
						 echo '<h2>There is no Recent Event to Show.</h2>';
						 }
					 ?>

            </ul>
        </div>
	<!-- Upcoming Widget End -->
	<?php
	echo $after_widget;
		}
		
	}
add_action( 'widgets_init', create_function('', 'return register_widget("upcomingevents");') );?>
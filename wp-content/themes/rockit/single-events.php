<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
get_header();
global $post_id,$cs_transwitch,$counter_gal;
$post_xml = get_post_meta($post->ID, "cs_event_meta", true);
	if ( $post_xml <> "" ) {
		$xmlObject = new SimpleXMLElement($post_xml);
			$cs_layout = $xmlObject->cs_layout;
			$cs_sidebar_left = $xmlObject->cs_sidebar_left;
			$cs_sidebar_right = $xmlObject->cs_sidebar_right;
			if ( $cs_layout == "left" ) {
				$cs_layout = "two-thirds column right";
				$show_sidebar = $cs_sidebar_left;
			}
			else if ( $cs_layout == "right" ) {
				$cs_layout = "two-thirds column left";
				$show_sidebar = $cs_sidebar_right;
			}
			else $cs_layout = "sixteen columns left";
	}

	$cs_event_loc = get_post_meta($xmlObject->event_address, "cs_event_loc_meta", true);
	if ( $cs_event_loc <> "" ) {
		$cs_event_loc = new SimpleXMLElement($cs_event_loc);
			$event_loc_lat = $cs_event_loc->event_loc_lat;
			$event_loc_long = $cs_event_loc->event_loc_long;
			$event_loc_zoom = $cs_event_loc->event_loc_zoom;
			$loc_address = $cs_event_loc->loc_address;
			$loc_city = $cs_event_loc->loc_city;
			$loc_postcode = $cs_event_loc->loc_postcode;
			$loc_region = $cs_event_loc->loc_region;
			$loc_country = $cs_event_loc->loc_country;
	}
	else
	{
		$event_loc_lat = '';
		$event_loc_long = '';
		$event_loc_zoom = '';
		$loc_address = '';
		$loc_city = '';
		$loc_postcode = '';
		$loc_region = '';
		$loc_country = '';
	}
	$address_map = '';
	$address_map = get_the_title("$xmlObject->event_address");
?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script type='text/javascript'>
	jQuery(document).ready(function(){
		event_map("<?php echo $address_map ?>",<?php echo $event_loc_lat ?>,<?php echo $event_loc_long ?>,<?php echo $event_loc_zoom ?>,<?php echo $post->ID; ?>);
	});
</script>

 	<?php
    if($event_loc_lat <> "" && $event_loc_long <>""){
	?>
		<div id="sub-banner" class="row">  
            <div class="top-cont">                
				<div class="map-sec" id="map_canvas<?php echo $post->ID; ?>"></div>
            </div>
		</div>
	<?php }?>
		<div class="container row">
	        <div class="<?php echo $cs_layout;?>">
					<?php
						//Run the loop to output the post.
                        //get_template_part( 'loop', 'single_cs_event' );
                    ?>
					<?php
                    $cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
                    if ( $cs_event_meta <> "" ) $xmlObject = new SimpleXMLElement($cs_event_meta);
                        if ( have_posts() ) while ( have_posts() ) : the_post();
                    ?>
                            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>                
                                <h1 class="heading"><?php the_title(); ?></h1>                    
                                <div class="in-sec">
                                    <div class="blog-detail">
                                    <?php
                                    $image_id = get_post_thumbnail_id ( $post->ID );
                                    if($image_id <> ''){
                                        //$image_url = wp_get_attachment_image_src($image_id, array(580,244),true);
                                        $image_url = cs_attachment_image_src($image_id, 580, 244);
                                        ?>
                                            <a class="thumb" style="width:100%; margin-bottom:20px;">
                                             <?php
                                                // getting featured image start
                                                echo "<img src='".$image_url."' />";
                                                // getting featured image end
                                             ?>
                                            </a>
                                            <?php }?>
                                        <div class="blog-opts">
                                            <div class="date"><h1><?php
                                                    $event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
                                                    $event_to_date = get_post_meta($post->ID, "cs_event_to_date", true);
                                                    echo date( get_option("date_format"), strtotime($event_from_date) );
                                                ?>
                                            </h1>
                                            </div>
                                            <div class="desc">
                                                <h4><?php the_title(); ?>
                                                    <?php $categories = get_the_terms( $post->ID, 'event-category' );
                                                        if($categories != ''){?>
                                                            (<?php 
                                                            $couter_comma = 0;
                                                            foreach ( $categories as $category ) {
                                                                echo $category->name;
                                                                $couter_comma++;
                                                                if ( $couter_comma < count($categories) ) {
                                                                    echo ", ";
                                                                }
                                                            }
                                                            ?>)                        
                                                    <?php }?>
                                                </h4>
                                                <p class="by"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author();?></a></p>
                                                <?php $tag_post = wp_get_post_tags( $post->ID );?>
                                                <p class="tags">
                                                    <?php
                                                    $counterr = 0;
                                                    foreach(get_the_category() as $values){
                                                        if($counterr == 0){ _e('Categories', CSDOMAIN);}
                                                        $counterr++;
                                                        echo '<a href="'.get_category_link($values->term_id).'">'.$values->name.'</a> ';											
                                                        }										
                                                    ?> 
                                                </p>
                                                <p class="time">
													<?php 
														echo date( get_option("date_format"), strtotime($event_from_date) ), " - ";
														echo date( get_option("date_format"), strtotime($event_to_date) );
													?>
                                                </p>
                                                <p>
                                                    <?php
                                                            if ( $xmlObject->event_all_day == "" ) {
                                                                echo $xmlObject->event_start_time . " &ndash; " . $xmlObject->event_end_time;
                                                            }
                                                            else {
                                                               if($cs_transwitch =='on'){ _e('All Day',CSDOMAIN); }else{ echo __CS('event_trans_all_day', "All Day"); }
                                                            }
                                                        ?>
                                                </p>
                                                <p class="by location">
													<?php
														if ( $xmlObject->event_address <> "" ) {
															echo get_the_title( "$xmlObject->event_address" );
																
														}
													?>
                                                </p>
                                                <p>
													<?php
														/* translators: used between list items, there is a space after the comma */
														$before_cat = " ".__( 'Categories',CSDOMAIN ).": ";
														$categories_list = get_the_term_list ( get_the_id(), 'event-category', $before_cat, ', ', '' );
														if ( $categories_list ): printf( __( '%1$s', CSDOMAIN ),$categories_list ); endif; '</p>'; 
													?>
                                                </p>
                                                <p>
													<?php
														$event_tag = get_the_term_list($post->ID, 'event-tag','',', ','');
														if ( !empty($event_tag) ) echo __("Tags: ", CSDOMAIN).$event_tag;
													?>
                                                </p>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                        <div class="blog-desc rich_editor_text">
                                            <?php the_content(); ?>
                                            <div class="clear"></div>
                                            <?php edit_post_link( __( 'Edit', CSDOMAIN ), '<span class="edit-link">', '</span>' ); ?>
                                            <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages', CSDOMAIN ).': ', 'after' => '</div>' ) ); ?>
                                        </div>

                                        <?php if ( $xmlObject->event_social_sharing == "on" ) { ?>
                                            <div class="blog-sharing">
                                            <div class="sharing right">
                                                <?php 
                                                	social_share();
												?>
                                                </div>
                                            </div>
                                        <?php }?>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <?php if ( get_the_author_meta( 'description' ) ) :?>
                                    <div class="in-sec">
                                        <div class="about-author">
                                            <div class="avatars">
                                                <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'PixFill_author_bio_avatar_size', 53 ) ); ?>
                                            </div>
                                            <div class="desc">
                                                <h5><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php _e('About', CSDOMAIN); ?> <?php echo get_the_author(); ?></a></h5>
                                                <p class="txt">
                                                    <?php the_author_meta( 'description' ); ?>
                                                </p>
                                                <div class="clear"></div>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>		
                            <?php comments_template( '', true ); ?>
                        </div>
                    <?php endwhile; // end of the loop. ?>

			</div>
			<?php if( $cs_layout != "sixteen columns left" and isset($show_sidebar) ) { ?>
                <div class="one-third column left">
                    <?php
                    	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($show_sidebar) ) :
						endif;
					?>
                </div>
            <?php }?>
        </div><!-- #container -->
        <div class="clear"></div>
<?php get_footer(); ?>
<div class="clear"></div>
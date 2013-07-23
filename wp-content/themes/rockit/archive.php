<?php
get_header();
global $cs_transwitch;
$cs_default_pages = get_option("cs_default_pages");
 $show_sidebar = '';
if ($cs_default_pages <> "") {
    $xmlObject = new SimpleXMLElement($cs_default_pages);
    $cs_layout = $xmlObject->cs_layout;
    $cs_sidebar_left = $xmlObject->cs_sidebar_left;
    $cs_sidebar_right = $xmlObject->cs_sidebar_right;
    $cs_pagination = $xmlObject->cs_pagination;
    $record_per_page = $xmlObject->record_per_page;
    if ($cs_pagination == 'Single Page') {
        $record_per_page = '-1';
    }
}
        if ( $cs_layout == "left" ) {
            $cs_layout = "two-thirds column right";
            $show_sidebar = $cs_sidebar_left;
        }
        else if ( $cs_layout == "right" ) {
            $cs_layout = "two-thirds column left";
            $show_sidebar = $cs_sidebar_right;
        }
        else $cs_layout = "sixteen columns left";
?>
    <div class="container row">
        <div class="<?php if (isset($cs_layout)) echo $cs_layout; ?>">
            <h1 class="heading">
                <?php if (have_posts()) : the_post(); ?>
                <?php
                if (is_author()) :
                    echo __('Author', CSDOMAIN) . " " . __('Archives', CSDOMAIN) . ": " . get_the_author();
                elseif (is_tag() || is_tax('event-tag') || is_tax('course-tag')) :
                    echo __('Tags', CSDOMAIN) . " " . __('Archives', CSDOMAIN) . ": " . single_cat_title('', false);
                elseif (is_category() || is_tax('album-category') || is_tax('event-category')) :
                    echo __('Categories', CSDOMAIN) . " " . __('Archives', CSDOMAIN) . ": " . single_cat_title('', false);
                elseif (is_day()) :
                    printf(__('Daily Archives: %s', CSDOMAIN), '<span>' . get_the_date() . '</span>');
                elseif (is_month()) :
                    printf(__('Monthly Archives: %s', CSDOMAIN), '<span>' . get_the_date(_x('F Y', 'monthly archives date format', CSDOMAIN)) . '</span>');
                elseif (is_year()) :
                    printf(__('Yearly Archives: %s', CSDOMAIN), '<span>' . get_the_date(_x('Y', 'yearly archives date format', CSDOMAIN)) . '</span>');
                else :
                    _e('Blog Archives', CSDOMAIN);
                endif;
                ?>
            </h1>
            <?php if ( (is_category() || is_tax('album-category') || is_tax('event-category') || is_tag() || is_tax('event-tag') || is_tax('album-tag')) and category_description() ) : // Show an optional category description ?>
            		<div class="blog-desc in-sec">
                    	<p class="txt"><?php echo category_description(); ?></p>
                    </div>
            <?php endif; ?>
           <?php if (is_author() and get_the_author_meta( 'description' ) ) :?>
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
			<?php
				  if (empty($_GET['page_id_all']))
                        $_GET['page_id_all'] = 1;
                    if (!isset($_GET["s"])) {
                        $_GET["s"] = '';
                    }
                rewind_posts();
                while (have_posts()) : the_post();
                $image_id = get_post_thumbnail_id($post->ID);
            ?>
            <div class="in-sec">
                <div class="blog-detail">
                    	
                        <div class="blog-opts">
                        <div class="date">
                            <h1><?php
									$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
									if($event_from_date <> ''){
										echo date( get_option("date_format"), strtotime($event_from_date) );
									}else{
										echo get_the_date();
									} 
									
								?>
                            </h1>
                        </div>
                        <div class="desc">
                            <h4><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></h4>
                            <p class="by"> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author();?></a></p>
                            <p class="coments"><a href="<?php echo get_permalink();?>#comments"><?php echo comments_number(__('No Comments', CSDOMAIN), __('1 Comment', CSDOMAIN), __('% Comments', CSDOMAIN) );?></a></p>
                            <?php $tag_post = wp_get_post_tags( $post->ID );?>
                            <p class="tags">
								<?php 
                                     /* translators: used between list items, there is a space after the comma */
                                    $before_cat = " ".__( 'Categories',CSDOMAIN ).":	";
                                    $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '' );
                                    if ( $categories_list ): printf( __( '%1$s', CSDOMAIN ),$categories_list );  endif; // End if categories 
                                ?>
                             </p>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="blog-desc">
                        <p class="txt">
                            <?php 
							if (post_password_required()) { 
								echo pixfill_password_form();
							}else{
								cs_get_the_excerpt(255);
							}
							?>
                        </p>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <?php endwhile; 
				$qrystr = '';
                // pagination start
				if(cs_pagination($wp_query->found_posts, $record_per_page, $qrystr) <> ''){
                     echo "<div class='in-sec'><ul class='pagination'>";
                        $qrystr = '';
                        if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
						if ( isset($_GET['author']) ) $qrystr .= "&author=".$_GET['author'];
						if ( isset($_GET['m']) ) $qrystr .= "&m=".$_GET['m'];
						if ( isset($_GET['tag']) ) $qrystr .= "&tag=".$_GET['tag'];
						if ( isset($_GET['cat']) ) $qrystr .= "&cat=".$_GET['cat'];
						if ( isset($_GET['event-category']) ) $qrystr .= "&event-category=".$_GET['event-category'];
						if ( isset($_GET['album-category']) ) $qrystr .= "&album-category=".$_GET['album-category'];
                    echo cs_pagination($wp_query->found_posts, $record_per_page,$qrystr);
                    echo "</ul></div>";
                }
                // pagination end
            ?>
             <?php endif; ?>
            </div>
            <?php if ($cs_layout != "sixteen columns left") { ?>
            <!--Sidebar Start-->
            <div class="one-third column left">
                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($show_sidebar)) : ?>
                <?php endif; ?>   
            </div>            
            <!--Sidebar Ends-->  
        <?php } ?>
    </div>
 <?php get_footer(); ?>

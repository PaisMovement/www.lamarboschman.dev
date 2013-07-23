<?php get_header();?>
<div class="inner">
    <div class="top-cont">  
		<?php
            if(!is_front_page() ||! is_home()){
                if($post->post_parent)
                    $children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0");
                else	
                    $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
                if ($children) { ?>
                 <div class="second-nav">
                    <ul>
                        <?php echo $children; ?>
                    </ul>
                </div>
                <!-- Sub Page Banner Start -->
            <?php }   ?>    
            <?php if ( has_post_thumbnail()) {?>
                <div id="sub-banner" class="row">
                    <?php
                    // getting featured image start
                        $image_id = get_post_thumbnail_id ( $post->ID );
                        //$image_url = wp_get_attachment_image_src($image_id, array(980,228),true);
                        $image_url = cs_attachment_image_src($image_id, 980, 228);
                        echo "<img src='".$image_url."' />";
                    // getting featured image end
                    ?>
                </div> 
            <?php }?>
             <!-- Sub Page Banner End -->
            <div class="clear"></div>    
        <?php }?>
    </div>
    <!-- Container Start -->
<?php
	$cs_page_builder = get_post_meta($post->ID, "cs_page_builder", true);
	if($cs_page_builder == ''){ ?>
		<div class="container row">
			<div class="sixteen columns left">
				<?php 
					wp_reset_query();
					if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
 					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if ( is_front_page() ) { ?>
						<h1 class="heading"><?php the_title(); ?></h1>
					<?php } else { ?>
						<h1 class="heading"><?php the_title(); ?></h1>
					<?php } ?>
 					<div class="in-sec in-sec-nopad">
						<div class="pagetxt">
							<?php the_content(); ?>
						</div>
						<?php 
                		if(!is_page()){ 
                        	comments_template( '', true ); 
                    	}
               			 ?>
					</div>
				</div>
			<?php endwhile; wp_reset_query(); // end of the loop. ?>
				</div>
			</div>
			</div>
		<?php
 		// Sample Page End
	}
	else {
	$xmlObject = new SimpleXMLElement($cs_page_builder);
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

	?>
    <div class="container row">
        <div class="<?php echo $cs_layout;?>">
			<?php
			if (post_password_required()) { 
				echo '<h1 class="heading">'.get_the_title().'</h1>';
				echo '<div class="in-sec">'.pixfill_password_form().'</div>';
			}else{
				$counter_gal = 0;
				foreach ( $xmlObject->children() as $node ){
					if ( $node->getName() == "rich_editor" ) {
						wp_reset_query();
						if ( $node->cs_rich_editor_title == "Yes") echo '<h1 class="heading">'.get_the_title().'</h1>';
						if ( $node->cs_rich_editor_desc == "Yes") {
							$content_of_post = get_post($post->ID);
							$content = $content_of_post->post_content;
							$content = apply_filters('the_content', $content);
							echo '<div class="in-sec in-sec-nopad rich_editor_text"><div class="pagetxt">'.$content.'</div></div>';
						}
					}
					if ( $node->getName() == "gallery" ) {
						$counter_gal++;
						if ( $node->album <> "" and $node->album <> "0" ) 
						get_template_part( 'page_gallery', 'page' );
					}
					else if ( $node->getName() == "slider" ) {
						$counter_gal++;
						if ( $node->slider <> "" and $node->slider <> "0" ) 
						get_template_part( 'page_slider', 'page' );
					}
					else if ( $node->getName() == "event" ) {
						$counter_gal++;
						if ( $node->cs_event_category <> "" and $node->cs_event_category <> "0" ) 
						get_template_part( 'page_event', 'page' );
					}
					else if ( $node->getName() == "blog" ) {
						$counter_gal++;
						if ( $node->cs_blog_cat <> "" and $node->cs_blog_cat <> "0" ) 
						get_template_part( 'page_blog', 'page' );
					}
					else if ( $node->getName() == "contact" ) {
						$counter_gal++;
						get_template_part('page_contact','page');
					}
					else if ( $node->getName() == "news" ) {
						$counter_gal++;
						if ( $node->cs_news_cat <> "" and $node->cs_news_cat <> "0" ) 
						get_template_part( 'page_news', 'page' );
					}
					else if ( $node->getName() == "album" ) {
						$counter_gal++;
						if ( $node->cs_album_cat <> "" and $node->cs_album_cat <> "0" ) 
						get_template_part( 'page_album', 'page' );
					}						
				}
			}
  		?>
        <?php wp_reset_query(); comments_template( '', true ); ?>
    </div>
    <!-- two-thirds end -->
    <?php if($cs_layout != "sixteen columns left"){?>
    <!--Sidebar Start-->
        <div class="one-third column left">
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($show_sidebar) ) : ?>
			<?php endif; ?>   
        </div>
	<?php }?>
    <!--Sidebar Ends-->    
	<div class="clear"></div>
</div><!-- Page End -->
<?php
}
get_footer();
?> 
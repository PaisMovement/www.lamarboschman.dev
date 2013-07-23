<?php get_header();

global $post_id,$cs_transwitch;
$cs_layout = '';
$post_xml = get_post_meta($post->ID, "post", true);
	if ( $post_xml <> "" ) {
		$xmlObject = new SimpleXMLElement($post_xml);
			$cs_layout = $xmlObject->cs_layout;
			$cs_sidebar_left = $xmlObject->cs_sidebar_left;
			$cs_sidebar_right = $xmlObject->cs_sidebar_right;
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
 	    
 			<?php if ( have_posts() ): while ( have_posts() ) : the_post(); 
				global $post_id;
			?>
                <div class="<?php if(isset($cs_layout)) echo $cs_layout;?> ">
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                	
					<div class="in-sec row">
                    	<div class="blog-detail detail-page">
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
                            <?php }
							featured();
							?>
                            <div class="blog-opts">
                                <div class="date">
                                    <h1><?php echo get_the_date();?></h1>
                                </div>
                                <div class="desc">
                                    <h4><?php echo get_the_title();?></h4>
                                    <p class="by"> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author();?></a></p>
                                    <p class="coments"><a href="<?php echo get_permalink();?>#comments"><?php echo comments_number(__('No Comments', CSDOMAIN), __('1 Comment', CSDOMAIN), __('% Comments', CSDOMAIN) );?></a></p>
                                    <?php $tag_post = wp_get_post_tags( $post->ID );?>
                                    <p class="tags">
                                        <?php
                                        $counterr = 0;
                                        foreach($tag_post as $values){
                                            if($counterr == 0){ echo 'Tags: ';}
                                            	$counterr++;
	                                            echo '<a href="'.get_term_link($values->slug,$values->taxonomy).'">'.$values->name.'</a>  ';											
                                            }										
                                        ?> 
                                    </p>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            <div class="blog-desc rich_editor_text">
                                <?php the_content();?>
                                <?php
                                	cs_media_attachment($post->ID,120,120);
 								?>
                                <div class="clear"></div>
                                <?php edit_post_link( __( 'Edit', CSDOMAIN ), '<span class="edit-link">', '</span>' ); ?>
                                <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', CSDOMAIN ), 'after' => '</div>' ) ); ?>
                            </div>
                            <div class="blog-sharing">
                                <div class="sharing right">
                                <?php 
                                	if (!empty($xmlObject->post_social_sharing)== "on" ) {
										social_share();	
									}
								?>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                        </div>
					<div class="clear"></div>
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
               	</div><!-- #content -->

           <!-- two-thirds end -->      
			<?php endwhile; endif; // end of the loop. ?>

		
            <?php if($cs_layout != "sixteen columns left"){?>
            <!--Sidebar Start-->
            
                <div class="one-third column left">
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($show_sidebar) ) : ?>
                    <?php endif; ?>   
                </div>
            <?php }?>
        </div><!-- #container -->
        <div class="clear"></div>

<?php get_footer(); ?>
<div class="clear"></div>

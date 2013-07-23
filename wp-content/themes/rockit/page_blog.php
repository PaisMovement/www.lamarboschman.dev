<?php
	global $node,$cs_transwitch,$post_id;
	$cs_blog_title_db = $node->cs_blog_title;
	$cs_blog_cat_db = $node->cs_blog_cat;
	$cs_blog_excerpt_db = $node->cs_blog_excerpt;
	$cs_blog_num_post_db = $node->cs_blog_num_post;
	$cs_blog_pagination_db = $node->cs_blog_pagination;
	if($cs_blog_title_db <> ''){ ?>
		<h1 class="heading">
   	 		<?php echo $cs_blog_title_db; ?>
		</h1>
    <?php } ?>
	<?php
		if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
		$count_post = 0;
		$args = array( 'posts_per_page' => '-1', 'post_type' => 'post', 'category_name' => "$cs_blog_cat_db" );
		$custom_query = new WP_Query($args);
			while ( $custom_query->have_posts()) : $custom_query->the_post();
				$count_post++;
			endwhile;
			wp_reset_query();
			if ( $cs_blog_pagination_db == "Single Page" ) $cs_blog_num_post_db = -1;
			$args = array( 'posts_per_page' => "$cs_blog_num_post_db", 'paged' => $_GET['page_id_all'], 'category_name' => "$cs_blog_cat_db" , 'post_status' => 'publish' ); 
			$custom_query = new WP_Query($args);
			$counter = 0;
			if($custom_query->have_posts()):
			while ( $custom_query->have_posts()) : $custom_query->the_post();
				$image_id = get_post_thumbnail_id ( $post->ID );?>
					<div class="in-sec">
						<div class="blog-detail <?php if($image_id == ''){ echo 'no-image';}?>">
							<?php
							if($image_id <> ''){
								$image_url = cs_attachment_image_src($image_id, 580, 244);
								echo "<a href='".get_permalink()."' class='thumb'><img src='".$image_url."' /></a>";
							}
						    featured();
							?>														   
                            <div class="post-conts">
                                <div class="blog-opts">
                                    <div class="date">
                                        <h1><?php echo get_the_date();?></h1>
                                    </div>
                                    <div class="desc">
                                        <h4><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></h4>
                                        <p class="by"> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author();?></a></p>
                                        <p class="coments"><a href="<?php echo get_permalink();?>#comments"><?php echo comments_number(__('No Comments', CSDOMAIN), __('1 Comment', CSDOMAIN), __('% Comments', CSDOMAIN) );?></a></p>
                                        <?php $tag_post = wp_get_post_tags( $post->ID );?>
                                        <p class="tags">
                                            <?php
											$counterr = 0;
											foreach(get_the_category() as $values){
												if($counterr == 0){ echo __('Categories', CSDOMAIN).':  ';}
												echo '<a href="'.get_category_link($values->term_id).'">'.$values->name.'</a>  ';                                           
												if($counterr == 0){ echo ", ";}
												$counterr++;
											}
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
												
												cs_get_the_excerpt($cs_blog_excerpt_db);
												
											}
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                      </div>             
						<?php
				endwhile; endif; wp_reset_query();

			// pagination start
			if ( $cs_blog_pagination_db == "Show Pagination" and $cs_blog_num_post_db > 0 ) {
				echo "<div class='in-sec'><ul class='pagination'>";
					$qrystr = '';
					if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
					echo cs_pagination($count_post, $cs_blog_num_post_db,$qrystr);
				echo "</ul></div>";
			}
			// pagination end
        ?>


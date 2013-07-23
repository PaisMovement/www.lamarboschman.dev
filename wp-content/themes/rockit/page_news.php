<?php
	global $node,$counter_gal,$cs_transwitch;
	$cs_news_title_db = $node->cs_news_title;
	$cs_news_cat_db = $node->cs_news_cat;
	$cs_news_excerpt_db = $node->cs_news_excerpt;
	$cs_news_num_post_db = $node->cs_news_num_post;
	$cs_news_pagination_db = $node->cs_news_pagination;
	if($cs_news_title_db <> ''){
	?>
		<h1 class="heading"><?php echo $cs_news_title_db ?></h1>
    <?php } ?>
<div class="in-sec">
    <ul class="news-list">
    <?php
		if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
		$count_post = 0;
		$args = array( 'posts_per_page' => '-1', 'post_type' => 'post', 'category_name' => "$cs_news_cat_db" );
		$custom_query = new WP_Query($args);
		$count_post = $custom_query->post_count;
			if ( $cs_news_pagination_db == "Single Page" ) $cs_news_num_post_db = -1;
			$args = array( 'posts_per_page' => "$cs_news_num_post_db", 'paged' => $_GET['page_id_all'], 'category_name' => "$cs_news_cat_db" ); 
			$counter = 0;
			$custom_query = new WP_Query($args);
			if($custom_query-> have_posts()):
			while ( $custom_query->have_posts()) : $custom_query->the_post();
				$counter++;
			?>
				<li>
					<?php
					$image_id = get_post_thumbnail_id ( $post->ID );
                    if ($image_id and $counter == 1 and $_GET['page_id_all'] == 1){
                    ?>
                        <div class="news-thumb">
                            <a href="<?php echo get_permalink();?>" class="thumb">
                                <?php echo "<img src='" . cs_attachment_image_src($image_id, 580, 244) . "' />"; 
								featured();
								?>
                            </a>
                        </div>
                    <?php }?>
                    <div class="news-desc">
                        <div class="date"><h1><?php echo get_the_date();?></h1></div>
                        <div class="desc">
                            <h4><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></h4>
                            <p class="txt">
                                <?php
                                    cs_get_the_excerpt($cs_news_excerpt_db);
									
                                ?>
                            </p>
                        </div>
                    </div>
                </li>
			<?php endwhile; endif;?>
        </ul>
        <!-- News List End -->
</div>
<?php
 	// pagination start
	if ( $cs_news_pagination_db == "Show Pagination" and $cs_news_num_post_db > 0 ) {
		echo "<div class='in-sec'><ul class='pagination'>";
			$qrystr = '';
			if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];		
		echo cs_pagination($count_post, $cs_news_num_post_db,$qrystr);
		echo "</ul></div>";
	}
	// pagination end
?>
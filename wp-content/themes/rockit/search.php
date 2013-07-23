<?php
	$cs_default_pages = get_option("cs_default_pages");
	if ( $cs_default_pages <> "" ) $xmlObject = new SimpleXMLElement($cs_default_pages);
		if ( $xmlObject->cs_layout == "left" ) {
			$xmlObject->cs_layout = "two-thirds column right";
			$show_sidebar = $xmlObject->cs_sidebar_left;
		}
		else if ( $xmlObject->cs_layout == "right" ) {
			$xmlObject->cs_layout = "two-thirds column left";
			$show_sidebar = $xmlObject->cs_sidebar_right;
		}
		else $xmlObject->cs_layout = "sixteen columns left";

get_header();
?>

<div class="container row">
     <div class="<?php echo $xmlObject->cs_layout;?>">
     	<h1 class="heading"><?php printf( __( 'Search Results %1$s %2$s', CSDOMAIN ), ': ','<span>' . get_search_query() . '</span>' ); ?></h1>
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
                <div class="in-sec">
                    <div class="blog-detail">
                        <div class="blog-opts">
                            <div class="date"><h1><?php
									$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
									if($event_from_date <> ''){
										echo date( get_option("date_format"), strtotime($event_from_date) );
									}else{
										echo get_the_date();
									} 
									
								?></h1></div>
                            <div class="desc">
                            	<h4><a href="<?php echo get_permalink();?>"><?php the_title();?></a></h4>
                                <p class="by"> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author();?></a></p>
                                <p class="coments"><a href="<?php echo get_permalink();?>#comments"><?php echo comments_number(__('No Comments', CSDOMAIN), __('1 Comment', CSDOMAIN), __('% Comments', CSDOMAIN) );?></a></p>
                                <p class="tags">
									<?php $counterr = 0;
                                    foreach(get_the_category() as $values){
                                        if($counterr == 0) echo __('Category', CSDOMAIN). ' : ';
                                        $counterr++;
                                        echo '<a href="'.get_category_link($values->term_id).'">'.$values->name.'</a>  ';
                                    }?> 
                                </p>
	                            <div class="clear"></div>
                            </div>
                        </div>
                        <div class="blog-desc"><p class="txt"><?php cs_get_the_excerpt(255);?></p></div>
                        <div class="clear"></div>
                    </div>
                </div>
			<?php endwhile; ?>
			<?php
                // pagination start
                if ( record_per_page_default_pages() < $wp_query->found_posts ) {
                    echo "<div class='in-sec'><ul class='pagination'>";
                        $qrystr = '';
                        if ( isset($_GET['s']) ) $qrystr = "&s=".$_GET['s'];
                    echo cs_pagination($wp_query->found_posts, record_per_page_default_pages(),$qrystr);
                    echo "</ul></div>";
                }
                // pagination end
            ?>
		<?php else : ?>
            <div class="in-sec">
				<h1 class=""><?php _e( 'No results found.', CSDOMAIN ); ?></h1>
                <p style="padding:10px 0;"><?php _e( 'Sorry, no posts matched your criteria.', CSDOMAIN ); _e('Please try again.', CSDOMAIN) ?></p>
                <?php get_search_form(); ?>
            </div>
		<?php endif; ?>
    </div>
    <?php if ( $xmlObject->cs_layout != "sixteen columns left") { ?>
        <div class="one-third column left">
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($show_sidebar) ) : ?>
            <?php endif; ?>   
        </div>            
    <?php }?>
</div>

<?php get_footer(); ?>

<?php
 	global $node,$counter_gal,$cs_transwitch;
	$cs_album_layout_db = $node->cs_album_layout;
	$cs_album_title = $node->cs_album_title;
	$cs_album_cat_db = $node->cs_album_cat;
	$cs_album_cat_show_db = $node->cs_album_cat_show;
	$cs_album_filterable_db = $node->cs_album_filterable;
	$cs_album_title_db = $node->cs_album_title;
	$cs_album_buynow_db = $node->cs_album_buynow;
	$cs_album_pagination_db = $node->cs_album_pagination;
	$cs_album_per_page_db = $node->cs_album_per_page;
 ?>
 <div id='show_next' class="<?php echo $cs_album_layout_db."_width ";?>">
 	<?php if($cs_album_title <> ''){?>
		<h1 class="heading"><?php echo $cs_album_title; ?></h1>
    <?php } ?>
	<?php 
    $row = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $cs_album_cat_db ."'" );
    //if(isset($row->name)){echo $row->name;} 
    ?>
        <?php
        if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
        $count_post = 0;
        if(isset($row->name)){
            $args = array( 'posts_per_page' => '-1', 'post_type' => 'albums', 'album-category' => "$row->name" );
            //query_posts( $args ); 
            $custom_query = new WP_Query($args);
        }
        else{
            $args = array( 'posts_per_page' => '-1', 'post_type' => 'albums' );
            //query_posts( $args ); 
            $custom_query = new WP_Query($args);
        }
            while ( $custom_query->have_posts()) : $custom_query->the_post();
                $count_post++;
            endwhile;
            if ( $cs_album_pagination_db == "Single Page" or $cs_album_filterable_db == "On" ) $cs_album_per_page_db = -1;
            if($cs_album_filterable_db == "On"){
        		filterable_enqueue_scripts();
				
?>	
        
        <script>
		jQuery(document).ready(function(){
        ablum_fliterable('<?php echo $counter_gal;?>');
		});
        </script>
                    <div class="tab_menu_container albumstabs">
                       <h5><?php echo __CS('event_trans_category_filter', 'Filter By'); ?>: </h5>
						<ul id="portfolio-item-filter<?php echo $counter_gal?>">
                            <li><a data-value="all" class="gdl-button active" href="#"><?php _e('All', CSDOMAIN); ?></a></li>
							<?php
								if($row <> ''){
									$categories = get_categories( array('child_of' => $row->term_id, 'taxonomy' => 'album-category', 'hide_empty' => 0) );
								}else{
									$categories = get_categories( array('taxonomy' => 'album-category', 'hide_empty' => 0) );
								}
                                if($categories <> ""){
                                    foreach ( $categories as $category ) {
                                ?>
							<li><a data-value="<?php echo $category->term_id;?>" class="gdl-button" href="#"><?php echo $category->name;?></a></li>                                
								<?php }?>
                            <?php }?>                            
                            <div class="clear"></div>
                        </ul>
                    </div>
				<?php } //End Condition of Filterable ?>                    
                    <!-- Gallery Four Column Start -->
                    <div class="in-sec nopad-bot">
						<ul class="prod-list portfolio-item-holder" id="portfolio-item-holder<?php echo $counter_gal?>">
							<?php
							enqueue_alubmtrack_format_resources();
							if(isset($row->name)){
								$args = array( 'posts_per_page' => "$cs_album_per_page_db", 'paged' => $_GET['page_id_all'], 'post_type' => 'albums', 'album-category' => "$row->name" );
								//query_posts( $args ); 
								$custom_query = new WP_Query($args);
							}
							else{
								$args = array( 'posts_per_page' => "$cs_album_per_page_db", 'paged' => $_GET['page_id_all'], 'post_type' => 'albums',);
								query_posts( $args );
								$custom_query = new WP_Query($args);
							}
								//print_r($wpdb->last_query );
								//print_r($wpdb->num_rows );
								
									$counter_album_db = 0;
									if(have_posts()):
									while ( $custom_query->have_posts()) : $custom_query->the_post();
										$counter_album_db++;
							?>                        
							<li class="all portfolio-item 
							<?php
							$categories = get_the_terms( $post->ID, 'album-category' );
								if($categories <> ''){
									foreach ( $categories as $category ) {
										echo $category->term_id." ";
									}
								}
							?>">
								<a href="<?php echo get_permalink();?>" class="thumb">                                         
									<?php
                                        $image_id = get_post_thumbnail_id ( $post->ID );
										if ( $image_id <> "" ) {
											//$image_url = wp_get_attachment_image_src($image_id, array(208,208),true);
											$image_url = cs_attachment_image_src($image_id, 208, 208);
											echo "<img src='".$image_url."' />";
										}
										else {
											echo "<img width='208' height='208' src='".get_template_directory_uri()."/images/no_image.jpg' />";
										}
                                    ?>	
                                </a>
                                <div class="clear"></div>
                                <h4 class="title">
                                	<a href="<?php echo get_permalink();?>">
                                        <?php 
										echo substr($post->post_title, 0, 20);
                                        if ( strlen($post->post_title) > 20 ) echo "...";
										?>
                                    </a>
                                </h4>
                                <?php
                                if ( $cs_album_cat_show_db == "On" ) {
                                ?>
                                    <p>
                                        <?php
											/* translators: used between list items, there is a space after the comma */
											$before_cat = " ".__( '',CSDOMAIN );
											$categories_list = get_the_term_list ( get_the_id(), 'album-category', $before_cat, ', ', '' );
											if ( $categories_list ): printf( __( '%1$s', CSDOMAIN ),$categories_list ); endif; '</p>'; 
										  ?>
                                    </p>
                                <?php }?>
                                <div class="prod-opts">
                                    <?php
                                        if ( $cs_album_buynow_db == "On" ) {
                                            $cs_album = get_post_meta($post->ID, "cs_album", true);
                                            if ( $cs_album <> "" ) {
                                                $xmlObject = new SimpleXMLElement($cs_album);
                                                    $album_release_date_db = $xmlObject->album_release_date;
                                                    $album_buy_amazon = $xmlObject->album_buy_amazon;
                                                    $album_buy_apple = $xmlObject->album_buy_apple;
                                                    $album_buy_groov = $xmlObject->album_buy_groov;
                                                    $album_buy_cloud = $xmlObject->album_buy_cloud;
											 if($album_buy_amazon != '' or $album_buy_apple != '' or $album_buy_groov != '' or $album_buy_cloud != ''){
                                                echo "<h6>"; if($cs_transwitch =='on'){ _e('BUY NOW',CSDOMAIN); }else{ echo __CS('buy_now', 'BUY NOW'); } echo "</h6>";
                                                 if ( $album_buy_amazon <> "" ) echo ' <a target="_blank" href="'.$album_buy_amazon.'" class="amazon-ind">&nbsp;<span>';if($cs_transwitch =='on'){ _e('Amazon',CSDOMAIN); }else{ echo __CS('amazon', 'Amazon'); }  echo '</span></a> ';
                                                if ( $album_buy_apple <> "") echo ' <a target="_blank" href="'.$album_buy_apple.'" class="apple-ind">&nbsp;<span>'; if($cs_transwitch =='on'){ _e('Apple',CSDOMAIN); }else{ echo __CS('itunes', 'iTunes'); }  echo '</span></a> ';
                                                if ( $album_buy_groov <> "") echo ' <a target="_blank" href="'.$album_buy_groov.'" class="grooveshark-ind">&nbsp;<span>';  if($cs_transwitch =='on'){ _e('GrooveShark',CSDOMAIN); }else{ echo __CS('grooveshark', 'GrooveShark'); }  echo '</span></a> ';
                                                if ( $album_buy_cloud <> "") echo ' <a target="_blank" href="'.$album_buy_cloud.'" class="soundcloud-ind">&nbsp;<span>'; if($cs_transwitch =='on'){ _e('SoundCloud',CSDOMAIN); }else{ echo __CS('soundcloud', 'SoundCloud '); } echo '</span></a> ';
  												}
                                            }
                                        }
                                    ?>
                                </div>										                                
                            </li>
                            <?php endwhile; endif; wp_reset_query(); ?>
						</ul>
						                            
					<div class="clear"></div>
				</div>
                <?php
                            // pagination start
                                if ( $cs_album_pagination_db == "Show Pagination" and $cs_album_per_page_db > 0 and $cs_album_filterable_db == "Off" ) {
                                    echo "<div class='in-sec'><ul class='pagination'>";
										$qrystr = '';
										if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                                    echo cs_pagination($count_post, $cs_album_per_page_db,$qrystr);
                                    echo "</ul></div>";
                                }
                            // pagination end
                        ?>
</div>
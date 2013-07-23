<?php
	// Gallery start
		//adding columns start
		add_filter('manage_cs_gallery_posts_columns', 'gallery_columns_add');
			function gallery_columns_add($columns) {
				//$columns['category'] = 'Category';
				$columns['author'] = 'Author';
				return $columns;
		}
		add_action('manage_cs_gallery_posts_custom_column', 'gallery_columns');
			function gallery_columns($name) {
				global $post;
				switch ($name) {
					case 'author':
						echo get_the_author();
						break;
				}
			}
		//adding columns end
	function cs_gallery_register() {  
		$labels = array(
			'name' => __('Manage Gallery','mytheme'),
			'add_new_item' => __('Add New Gallery','mytheme'),
			'edit_item' => __('Edit Gallery','mytheme'),
			'new_item' => __('New Gallery Item','mytheme'),
			'add_new' => __('Add New Gallery','mytheme'),
			'view_item' => __('View Gallery Item','mytheme'),
			'search_items' => __('Search Gallery','mytheme'),
			'not_found' =>  __('Nothing found','mytheme'),
			'not_found_in_trash' => __('Nothing found in Trash','mytheme'),
			'parent_item_colon' => ''
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/gallery-icon.png',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title' )
		); 
        register_post_type( 'cs_gallery' , $args );
	}
/*		  
$labels = array(
			'name' => __( 'Gallery Categories', 'taxonomy general name' ),
			'search_items' =>  __( 'Search Gallery Categories' ),
			'edit_item' => __( 'Edit Gallery Category' ), 
			'update_item' => __( 'Update Gallery Category' ),
			'add_new_item' => __( 'Add New Category' ),
			'menu_name' => __( 'Gallery Categories' ),
		  ); 	
		  register_taxonomy('cs_gallery_categories_tax',array('cs_gallery'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'cs_gallery_categories_tax' ),
		  ));
*/
	add_action('init', 'cs_gallery_register');

		// adding Gallery meta info start
			add_action( 'add_meta_boxes', 'cs_meta_gallery_add' );
			function cs_meta_gallery_add()
			{  
				add_meta_box( 'cs_meta_gallery', 'Gallery Options', 'cs_meta_gallery', 'cs_gallery', 'normal', 'high' );  
			}
			function cs_meta_gallery( $post ) {
				?>
					<div class="page-wrap">
                    <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.scrollTo-min.js"></script>
					<script>
                        jQuery(document).ready(function($) {
                                $("#gal-sortable").sortable({
									cancel:'li div.poped-up',
									});
                                $(this).append("#gal-sortable").clone() ;
                            });
                            var counter = 0;
                            function clone(path){
                                counter = counter + 1;
                                var dataString = 'path='+path+'&counter='+counter;
                                jQuery("#loading").html("<img src='<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif' />");
                                jQuery.ajax({
                                    type:'POST', 
                                    url: '<?php echo get_template_directory_uri()?>/include/gallery_meta.php',
                                    data: dataString,
                                    success: function(response) {
                                        jQuery("#loading").html("");
                                        jQuery("#gal-sortable").append(response);
                                    }
                                });
                            }
                            function del_this(id){
                                jQuery("#"+id).remove();
                            }
                    </script>
<script type="text/javascript">
	var contheight;
      function galedit(id){
		var $ = jQuery;
		$.scrollTo( '.page-wrap', 800, {easing:'swing'} );
        $("#edit_" + id).css("display", "block");
		var popd = $('.poped-up').height();
		contheight = $('.to-social-network').height();
        $(".poped-up").css("top", popd);
  		$(".poped-up").css("height", popd);
        $(".to-social-network").css("height", popd);
        $('.poped-up').animate({
         top: 0,
        }, 1000, function() {
         // Animation complete.
        });
		popd = 0;
       };
       function galclose(id){
		var $ = jQuery;
        $.scrollTo( '.page-wrap', 800, {easing:'swing'} );
        $('.poped-up').animate({
         top: contheight,
         height: "auto"
        }, 1000, function() {
        // Animation complete.
        });
        $(".to-social-network").css("height", "auto");
        $(".poped-up").hide(800).delay(800);
		contheight = 0;
      };

</script>
                    
					<div class="option-sec">
                            <div class="opt-conts-in">
                                <div class="to-social-network">
                                    <div class="gal-active">
                                        <h5 class="left">Media Added</h5>
                                        <div id="loading" style="float:right; margin-right:10px;"></div>
                                        <div class="clear"></div>
                                        <ul id="gal-sortable">
                        <?php 
							$cs_meta_gallery_options = get_post_meta($post->ID, "cs_meta_gallery_options", true);
							if ( $cs_meta_gallery_options <> "" ) {
								$xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
									$counter_gal = 0;
									foreach ( $xmlObject->children() as $node ){
										$counter_gal++;
										$path = $node->path;
										$title_db = $node->title;
										$description_db = $node->description;
										$use_image_as_db = $node->use_image_as;
										$video_code_db = $node->video_code;
										$counter = $post->ID.$counter_gal;
										include get_template_directory()."/include/gallery_meta.php";
									}
							}
						?>
                    </ul>
                                    </div>
                                    <div class="to-social-list">
                                        <h5>Select Media</h5>
                                        <div class="right">
                                            <input id="cs_log" name="cs_logo" type="button" class="uploadfile button" value="Upload Media" style="margin-right:10px" />
                                            <input type="button" class="button" value="Reload" onclick="refresh_media()" />
                                        </div>
                                        <div class="clear"></div>
                                        <script type="text/javascript">
											function refresh_media(){
												jQuery("#pagination").html("<img src='<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif' />").load('<?php echo get_template_directory_uri()?>/include/pagination.php');
											}
											function show_next(page_id, total_pages){
												jQuery("#pagination").html("<img src='<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif' />").load('<?php echo get_template_directory_uri()?>/include/pagination.php?page_id='+page_id+'&total_pages='+total_pages);
											}
										</script>
										<div id="pagination">
											<?php include get_template_directory()."/include/pagination.php";?>
										</div>
	                                    <input type="hidden" name="gallery_meta_form" value="1" />
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php
			}
			// adding Gallery meta info end
			// saving Gallery meta start
			if ( isset($_POST['gallery_meta_form']) and $_POST['gallery_meta_form'] == 1 ) {
				add_action( 'save_post', 'cs_meta_gallery_options' );
				function cs_meta_gallery_options( $post_id )
				{
					$counter = 0;
					$sxe = new SimpleXMLElement("<gallery_options></gallery_options>");
						if ( isset($_POST['path']) ) {
							foreach ( $_POST['path'] as $count ) {
								$gallery = $sxe->addChild('gallery');
									$gallery->addChild('path', $_POST['path'][$counter] );
									$gallery->addChild('title', htmlspecialchars($_POST['title'][$counter]) );
									$gallery->addChild('description', htmlspecialchars($_POST['description'][$counter]) );
									$gallery->addChild('use_image_as', $_POST['use_image_as'][$counter] );
									$gallery->addChild('video_code', htmlspecialchars($_POST['video_code'][$counter]) );
									$counter++;
							}
						}
					update_post_meta( $post_id, 'cs_meta_gallery_options', $sxe->asXML() );
				}
			}
			// saving Gallery meta end
	// Gallery end
?>
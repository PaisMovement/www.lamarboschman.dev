<?php 
	global $node,$counter_gal,$prettyphoto_flag;
	$cs_gal_layout_db = $node->layout;
	$cs_gal_album_db = $node->album;
	$cs_gal_title_db = $node->title;
	$cs_gal_desc_db = $node->desc;
	$cs_gal_pagination_db = $node->pagination;
	$cs_gal_media_per_page_db = $node->media_per_page;
	$count_post =0;
	$prettyphoto_flag = "true";

		// galery slug to id start
			$args=array(
			  'name' => $cs_gal_album_db,
			  'post_type' => 'cs_gallery',
			  'post_status' => 'publish',
			  'showposts' => 1,
			);
 			$get_posts = get_posts($args);
			if($get_posts){
				$cs_gal_album_db = $get_posts[0]->ID;
			}
		// galery slug to id end
	
	if($cs_gal_title_db <> ''){
	?>
		<h1 class="heading"><?php echo $cs_gal_title_db;?></h1>
    <?php } ?>
	<div class="in-sec nopad-bot">
	<?php
	enqueue_gallery_format_resources();	
    $cs_meta_gallery_options = get_post_meta($cs_gal_album_db, "cs_meta_gallery_options", true);
	  if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
        // pagination start
            if ( $cs_meta_gallery_options <> "" ) {
                $xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
                    if ( $cs_gal_pagination_db == "Show Pagination" and $cs_gal_media_per_page_db > 0 ) {
                            $limit_start = $cs_gal_media_per_page_db * ($_GET['page_id_all']-1);
                            $limit_end = $limit_start + $cs_gal_media_per_page_db;
							$count_post = count($xmlObject);
                                if ( $limit_end > count($xmlObject) ) $limit_end = count($xmlObject);
                    }
                    else {
                        $limit_start = 0;
                        $limit_end = count($xmlObject);
						$count_post = count($xmlObject);
                    }
            }
        // pagination end
    ?>
    <section id="gal-container">
    	<ul class="<?php echo $cs_gal_layout_db?> light-box">
            <?php
		        if ( $cs_meta_gallery_options <> "" ) {
					//foreach ( $xmlObject->children() as $node ) {
					for ( $i = $limit_start; $i < $limit_end; $i++ ) {
						$path = $xmlObject->gallery[$i]->path;
						$title = $xmlObject->gallery[$i]->title;
						$description = $xmlObject->gallery[$i]->description;
						$social_network = $xmlObject->gallery[$i]->social_network;
						$use_image_as = $xmlObject->gallery[$i]->use_image_as;
						$video_code = $xmlObject->gallery[$i]->video_code;
							//$image_url = wp_get_attachment_image_src($path, array(438,288),false);
							$image_url = cs_attachment_image_src($path, 438, 288);
							//$image_url_full = wp_get_attachment_image_src($path, 'full',false);
							$image_url_full = cs_attachment_image_src($path, 0, 0);
            ?>
                            <li>
                                <a href="<?php if($use_image_as==1)echo $video_code; else echo $image_url_full?>" rel="<?php if($use_image_as==1)echo "prettyPhoto"; else echo "prettyPhoto[gallery1]"?>" name="<?php if($cs_gal_desc_db=="On")echo $description;?>" >
                                <?php echo "<img src='".$image_url."' alt='".$title."' />"?>
                                </a>
                                <?php
                                    if ( $cs_gal_title_db == "On" or $cs_gal_desc_db == "On" ) {
                                    ?>
                                        <div class="gal-caption <?php if($use_image_as==1)echo "video"; else echo"image"?>-bg">
                                            <h3 class="colr">
                                                <?php
                                                    if ( $cs_gal_title_db == "On" ) {
                                                        echo substr($title, 0, 30);
                                                        if ( strlen($title) > 30 ) echo " ...";
                                                    }
                                                ?>
                                            </h3>
                                            <p>
                                                <?php
                                                    if ( $cs_gal_desc_db == "On" ) {
                                                        echo substr($description, 0, 70);
                                                        if ( strlen($description) > 70 ) echo " ...";
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                    <?php }?>
                            </li>
            <?php
                        }
                }
            ?>
            </ul>

	</section>
</div>
<?php
					if ( $cs_gal_pagination_db == "Show Pagination" and $cs_gal_media_per_page_db > 0 ) {
						echo "<div class='in-sec'><ul class='pagination'>";
							$qrystr = '';
							if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];						
						echo cs_pagination( $count_post, $cs_gal_media_per_page_db,$qrystr );
						echo "</ul></div>";
					}
                ?>
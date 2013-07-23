<?php
// album download start
//	if ( isset($_GET['download']) ) {
//		header('Content-type: application/mp3');
//		header('Content-Disposition: attachment; filename='.basename($_GET['download']));
//		readfile( $_GET['download'] );
//	}
// album download end

get_header(); 
global $cs_transwitch,$prettyphoto_flag;
$prettyphoto_flag = "true";
	$cs_album = get_post_meta($post->ID, "cs_album", true);
	if ( $cs_album <> "" ) {
		$xmlObject = new SimpleXMLElement($cs_album);
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
		<div id="container" class="container row">
			<div role="main" class="<?php echo $cs_layout;?>" >
				<?php
                    /* Run the loop to output the post.
                     * If you want to overload this in a child theme then include a file
                     * called loop-single.php and that will be used instead.
                     */
                    //get_template_part( 'loop', 'single_cs_album' );
                ?>
						<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>
                        <?php
                            //showing meta start
                            $cs_album = get_post_meta($post->ID, "cs_album", true);
                            if ( $cs_album <> "" ) {
                                $xmlObject = new SimpleXMLElement($cs_album);
                                    $cs_layout = $xmlObject->cs_layout;
                                    $cs_sidebar_left = $xmlObject->cs_sidebar_left;
                                    $cs_sidebar_right = $xmlObject->cs_sidebar_right;
                                    $album_release_date = $xmlObject->album_release_date;
                                    $album_social_share = $xmlObject->album_social_share;
                                    $album_buy_amazon = $xmlObject->album_buy_amazon;
                                    $album_buy_apple = $xmlObject->album_buy_apple;
                                    $album_buy_groov = $xmlObject->album_buy_groov;
                                    $album_buy_cloud = $xmlObject->album_buy_cloud;
                            }
                            //showing meta end
                        ?>
                            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <h1 class="heading"><?php the_title(); ?></h1>
                                <div class="in-sec">
                                    <?php
                                    // getting featured image start
                                        $image_id = get_post_thumbnail_id ( $post->ID );
                                        if ( $image_id <> "" ) {
                                            //$image_url = wp_get_attachment_image_src($image_id, array(208,208),true);
                                            $image_url = cs_attachment_image_src($image_id, 208, 208);
                                                $image_url = $image_url;
                                            //$image_url_full = wp_get_attachment_image_src($image_id, 'full',true);
                                            $image_url_full = cs_attachment_image_src($image_id, 0, 0);
                                                $image_url_full = $image_url_full;
                                        }
                                        else {
                                            $image_url = get_template_directory_uri()."/images/admin/no_image.jpg";
                                            $image_url_full = get_template_directory_uri()."/images/admin/no_image.jpg";
                                        }
                                            //$image_id = get_post_thumbnail_id ( $post->ID );
                                            //$image_url = wp_get_attachment_image_src($image_id, array(208,198),true);
                                            //$image_url_full = wp_get_attachment_image_src($image_id, 'full',true);
                                    // getting featured image end
                                    ?>
                                        <div class="light-box album-tracks album-detail <?php if($image_id == "") echo "no-img-found";?> ">
                                            <a rel="prettyPhoto" name="<?php the_title(); ?>" href="<?php echo $image_url_full?>" class="thumb" >
                                                <?php echo "<img src='".$image_url."' />";?>
                                            </a>
                                            <div class="desc">
                                                <p style="font-size:12px;"><span class="bold" style="text-transform:uppercase; color:#262626;"><?php _e('Categories', CSDOMAIN); ?> :</span> 
                                                  <?php
													/* translators: used between list items, there is a space after the comma */
													$before_cat = " ".__( '',CSDOMAIN );
													$categories_list = get_the_term_list ( get_the_id(), 'album-category', $before_cat, ', ', '' );
													if ( $categories_list ): printf( __( '%1$s', CSDOMAIN ),$categories_list ); endif; '</p>'; 
                                                  ?>
                                                </p>
                                                <p class="released"><?php if($cs_transwitch =='on'){ _e('Released',CSDOMAIN); }else{ echo __CS('release_date', 'Released'); } ?>: 
                                                    <?php
                                                        echo date( get_option("date_format") , strtotime($album_release_date) );
                                                    ?>
                                                </p>
                                                         <h4><?php _e('Description', CSDOMAIN); ?></h4>
                                                        <div class='txt rich_editor_text'>
                                                            <?php 
                                                                the_content();
                                                                
                                                            ?>
                                                        </div>
                                                        <div class="clear"></div>
                                                        <?php edit_post_link( __( 'Edit', CSDOMAIN ), '<span class="edit-link">', '</span>' ); ?>
                                             </div>
                                            <div class="clear"></div>
                                        </div>
                                </div>
                                <div class="in-sec">
                                    <div class="album-opts">
                                        <div class="share-album">
                                        <?php 
                                            $cs_social_share = get_option("cs_social_share");							
                                            if($cs_social_share != ''){
                                              $xmlObject_album = new SimpleXMLElement($cs_social_share);
                                                if($album_social_share == 'Yes'){
                                                	social_share(); 
                                                 }?>                        
                                            <?php }?>   
                                        </div>
                                        <?php if($album_buy_amazon != '' or $album_buy_apple != '' or $album_buy_groov != '' or $album_buy_cloud != ''){?>
                                        <div class="availble">
                                            <h4><?php if($cs_transwitch =='on'){ _e('Buy This',CSDOMAIN); }else{ echo __CS('buy_now', 'Buy This'); }?></h4>
                                            <?php
                                                if ( $album_buy_amazon <> "" ) echo ' <a target="_blank" href="'.$album_buy_amazon.'" class="amazon-ind">&nbsp;<span>';if($cs_transwitch =='on'){ _e('Amazon',CSDOMAIN); }else{ echo __CS('amazon', 'Amazon'); }  echo '</span></a> ';
                                                if ( $album_buy_apple <> "") echo ' <a target="_blank" href="'.$album_buy_apple.'" class="apple-ind">&nbsp;<span>'; if($cs_transwitch =='on'){ _e('Apple',CSDOMAIN); }else{ echo __CS('itunes', 'iTunes'); }  echo '</span></a> ';
                                                if ( $album_buy_groov <> "") echo ' <a target="_blank" href="'.$album_buy_groov.'" class="grooveshark-ind">&nbsp;<span>';  if($cs_transwitch =='on'){ _e('GrooveShark',CSDOMAIN); }else{ echo __CS('grooveshark', 'GrooveShark'); }  echo '</span></a> ';
                                                if ( $album_buy_cloud <> "") echo ' <a target="_blank" href="'.$album_buy_cloud.'" class="soundcloud-ind">&nbsp;<span>'; if($cs_transwitch =='on'){ _e('SoundCloud',CSDOMAIN); }else{ echo __CS('soundcloud', 'SoundCloud '); } echo '</span></a> ';
                                            ?>
                                        </div>
                                        <?php }?>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <?php  
                                foreach ( $xmlObject as $track ){
                                    if ( $track->getName() == "track" ) {
                                ?>
                                <div class="in-sec">
                                    <?php 
									enqueue_alubmtrack_format_resources();
									enqueue_gallery_format_resources();		
									?>
                                        <div class="album-tracks light-box">
                                        <?php 
                                            $counter = 0;
                                            foreach ( $xmlObject as $track ){
                                                $counter++;
                                                if ( $track->getName() == "track" ) {
                                                    echo "<div class='track'>";
                                                    echo "<h5>";
                                                    echo $album_track_title = $track->album_track_title;
                                                    echo "</h5>";
                                                    echo "<ul>";
                                                        if ($track->album_track_playable == "Yes") {
                                                            echo '
                                                                <li>
                                                                    <div class="cp-container cp_container_'.$counter.'">
                                                                        <ul class="cp-controls">
                                                                            <li><a style="display: block;" href="#" class="cp-play" tabindex="1">&nbsp;<span>'; if($cs_transwitch =='on'){ _e('Play',CSDOMAIN); }else{ echo __CS('play', 'Play'); } echo '</span></a></li>
                                                                            <li><a href="#" class="cp-pause" style="display: none;" tabindex="1">&nbsp;<span>'; if($cs_transwitch =='on'){ _e('Pause',CSDOMAIN); }else{ echo __CS('pause', 'Pause'); } echo '</span></a></li>
                                                                        </ul>
                                                                    </div>
                                                                    <div style="width: 0px; height: 0px;" class="cp-jplayer jquery_jplayer_'.$counter.'">
                                                                        <img style="width: 0px; height: 0px; display: none;" id="jp_poster_0">
                                                                        <audio src="'.$track->album_track_mp3_url.'" preload="metadata" ></audio>
                                                                    </div>
                                                                    <script>
                                                                        jQuery(document).ready(function($){
                                                                            var myCirclePlayer = new CirclePlayer(".jquery_jplayer_'.$counter.'",
                                                                                {
                                                                                    mp3: "'.$track->album_track_mp3_url.'"
                                                                                }, {
                                                                                    cssSelectorAncestor: ".cp_container_'.$counter.'",
                                                                                    swfPath: "'.get_template_directory_uri().'/scripts/frontend/Jplayer.swf",
                                                                                    wmode: "window",
                                                                                    supplied: "mp3"
                                                                                });
                                                                        });
                                                                    </script>
                                                                </li>
                                                            ';
                                                        }
                                                        if ($track->album_track_downloadable == "Yes"){ echo '<li><a href="'.$track->album_track_mp3_url.'" class="download">&nbsp;<span>'; if($cs_transwitch =='on'){ _e('Download',CSDOMAIN); }else{ echo __CS('download', 'Download'); } echo '</span></a></li>'; }
                                                        if ($track->album_track_lyrics <> "") { echo '<li><a href="#lyrics'.$counter.'" rel="prettyPhoto[inline]" title="'.$album_track_title.'" class="lyrics">&nbsp;<span>'; if($cs_transwitch =='on'){ _e('Lyrics',CSDOMAIN); }else{ echo __CS('lyrics', 'Lyrics'); } echo '</span></a></li>';}
                                                        if ($track->album_track_buy_mp3 <> ""){ echo '<li><a href="'.$track->album_track_buy_mp3.'" class="buysong">&nbsp;<span>'; if($cs_transwitch =='on'){ _e('Buy&nbsp;Song',CSDOMAIN); }else{  echo __CS('buy_now', 'Buy&nbsp;Song'); } echo '</span></a></li>';}
                										

                                                    echo "</ul>";
                                                    echo '
                                                        <div id="lyrics'.$counter.'" style="display:none;">
                                                            '.str_replace("\n","</br>",$track->album_track_lyrics).'
                                                        </div>
                                                    ';
                                                    echo "</div>";
                                                }
                                            }
                                        ?>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <?php
                                    }
                                } 
                                ?>  
                                <div class="clear"></div>
                                <?php if ( get_the_author_meta( 'description' ) ) :?>
                                <div class="in-sec" style="margin-top:20px;">
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
                            </div>
                        <?php endwhile; endif; // end of the loop. ?>
                        <?php comments_template( '', true ); ?>

			</div>
			<?php if( $cs_layout != "sixteen columns left" and isset($show_sidebar) ) { ?>
            <!--Sidebar Start-->
                <div class="one-third column left">
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($show_sidebar) ) : ?>
                    <?php endif; ?>   
                </div>            
            <!--Sidebar Ends-->  
            <?php }?>
            <div class="clear"></div><!-- #content -->
		</div><!-- #container -->
        <div class="clear"></div>
<?php get_footer(); ?>
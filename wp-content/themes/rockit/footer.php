<?php 
global $cs_transwitch,$prettyphoto_flag;
wp_reset_query();
if(is_front_page() || is_home()){
	$show_album = "";
		$cs_home_page_album = get_option("cs_home_page_album");
			if ( $cs_home_page_album <> "" ) {
				$xmlObject = new SimpleXMLElement($cs_home_page_album);
					$show_album = $xmlObject->show_album;
					$album_title = $xmlObject->album_title;
					$album_cat = $xmlObject->album_cat;
					$show_view_all = $xmlObject->show_view_all;
					$no_of_album_post = $xmlObject->no_of_album_post;
			}
?>
	<?php if($show_album == 'on' and $album_cat <> "" and $album_cat <> "0" ){ ?>
        <!--Album Home Page Area Started -->
			<?php 
 				$row = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '$album_cat'" );
			 
            	if(!empty($row)){
			?>
				<div class="container row hidemobile">
            	<div class="sixteen columns" style="margin-top:0px;">
                	<!-- Albums Start -->
                	<div class="prod-sec">
                    	<div class="prod-head">
                        	<h1><?php echo $album_title;?></h1>
                            	<?php if($show_view_all=="Yes"){?>
		                            <a href="<?php echo get_term_link("$album_cat", "album-category")?>" class="buttonsmall right"><?php _e('More...',CSDOMAIN)?></a>
                            	<?php }?>
                            <div class="clear"></div>
                        </div>
                        <ul class="prod-list">
							<?php
							$args = array( 'posts_per_page' => "$no_of_album_post", 'post_type' => 'albums', 'album-category' => "$row->name"); 
							$custom_query = new WP_Query($args);
							if ( $custom_query->have_posts() ) :
                                while ( $custom_query->have_posts() ) : $custom_query->the_post();
                            ?>
                                <li>
                                    <a href="<?php echo get_permalink();?>" class="thumb">
                                        <?php
                                            $image_id = get_post_thumbnail_id ( $post->ID );
                                            if ( $image_id <> "" ) {
                                                //$image_url = wp_get_attachment_image_src($image_id, array(208,208),true);
                                                $image_url = cs_attachment_image_src($image_id, 208, 208);
                                                echo "<img src='".$image_url."' />";
                                            }
                                            else {
                                                echo "<img width='208' height='198' src='".get_template_directory_uri()."/images/no_image.jpg' />";
                                            }
                                        ?>	
                                    </a>
                                    <h4 class="title"><a href="<?php echo get_permalink();?>">
                                    <?php echo substr($post->post_title, 0, 20); if ( strlen($post->post_title) > 20 ) echo "...";?></a></h4>
                                    <p><?php $row->name = '';
                                    if($row->name == ''){$row->name = 'no title';}?></p>
                                    <div class="prod-opts">
                                        <?php 
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
														if ( $album_buy_amazon <> "" ) echo ' <a target="_blank" href="'.$album_buy_amazon.'" class="amazon">&nbsp;<span>Amazon</span></a> ';
														if ( $album_buy_apple <> "" ) echo ' <a target="_blank" href="'.$album_buy_apple.'" class="apple">&nbsp;<span>ITUNES</span></a> ';
														if ( $album_buy_groov <> "" ) echo ' <a target="_blank" href="'.$album_buy_groov.'" class="grooveshark">&nbsp;<span>GrooveShark</span></a> ';
														if ( $album_buy_cloud <> "" ) echo ' <a target="_blank" href="'.$album_buy_cloud.'" class="soundcloud">&nbsp;<span>SoundCloud</span></a> ';
                                            		}		
											}							
                                        ?>
                                    </div>
                                </li>
                            <?php endwhile;?>
						<?php endif;?>
                        </ul>
                    </div>
                    <!-- Albums End -->
                </div>
            </div>
            
            <?php 
				}else{
					echo '<div class="box-small no-results-found"> <br><h1>'.$album_title.'</h1><h5>';
					         
					
					
					_e("No results found.",CSDOMAIN);
				echo ' </h5></div>';
				}
			}?>
            <div class="clear"></div>	
<?php }?>
   <!--Album Home Page Area Started -->


<?php	
	$cs_gs_footer_settings = get_option( "cs_gs_footer_settings" );
		if ( $cs_gs_footer_settings <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_footer_settings);
				$cs_footer_logo = $sxe->cs_footer_logo;
				$cs_copyright = $sxe->cs_copyright;
				$cs_powered_by = $sxe->cs_powered_by;
				$cs_powered_icon = $sxe->cs_powered_icon;
				$cs_analytics = $sxe->cs_analytics;
		}
?>
<!-- Footer Start -->
            <div id="footer">
            	<div class="foot-top">
                	<!-- Footer Logo Start -->
                    <div class="logo-foot">
                    	<a href="<?php echo home_url( '/' ); ?>"><img src="<?php echo $cs_footer_logo?>" alt="" /></a>
                    </div>
                    <!-- Footer Logo End -->
                    <!-- Footer Navigation Start -->
                    <div class="links-foot">

						<?php 

					// Menu parameters		
						$defaults = array(
						  'theme_location'  => 'footer-menu',
						  'menu'            => '', 
						  'container'       => '', 
						  'container_class' => 'links-foot', 
						  'container_id'    => '',
						  'menu_class'      => '', 
						  'menu_id'         => '',
						  'echo'            => true,
						  'fallback_cb'     => 'wp_page_menu',
						  'before'          => '',
						  'after'           => '',
						  'link_before'     => '',
						  'link_after'      => '',
						  'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						  'depth'           => 1,
						  'walker'          => '');
						  wp_nav_menu( $defaults); 
					 
					//$menu = wp_get_nav_menu_object( $locations[ $args->theme_location ] );					
					//if ( ! $menu && $args->theme_location && ( $locations = get_nav_menu_locations() ) && isset( $locations[ $args->theme_location ] ) );
					?>                    
                    </div>
                    <!-- Footer Navigation End -->
                    <!-- Newsletter Start -->
						<?php if ( get_option("cs_show_newsletter") == "on" ) {?>
					 
                        <div class="newsletter">
                           <?php cs_newsletter(); ?>
                        </div>
					<?php }?>
                    <!-- Newsletter End -->
                </div>
                <div class="foot-bottom">
                	<!-- Copyrights Start -->
                    <div class="copyrights">
                    	<p>
							<?php echo $cs_copyright?>
                        </p>
                        <p class="hidemobile">
                        	<?php if ($cs_powered_by<>"")echo "<span>".$cs_powered_by."</span>"?>
                            <?php if ($cs_powered_icon<>"")echo '<img src="'.$cs_powered_icon.'" />'?>
                        </p>
                    </div>
                    <!-- Copyrights End -->
                    <!-- Follow Us and Top Start -->
                    <div class="followus-top">
                    	<a href="#top" class="top" id="back-top"><?php _e('Top', CSDOMAIN);?></a>
                        <?php
						$cs_social_network = get_option("cs_social_network");
							if ( $cs_social_network <> "" ) {
								$xmlObject = new SimpleXMLElement($cs_social_network);
									$twitter = $xmlObject->twitter;
									$facebook = $xmlObject->facebook;
									$linkedin = $xmlObject->linkedin;
									$digg = $xmlObject->digg;
									$delicious = $xmlObject->delicious;
									$google_plus = $xmlObject->google_plus;
									$google_buzz = $xmlObject->google_buzz;
									$google_bookmark = $xmlObject->google_bookmark;
									$myspace = $xmlObject->myspace;
									$reddit = $xmlObject->reddit;
									$stumbleupon = $xmlObject->stumbleupon;
									$yahoo_buzz = $xmlObject->yahoo_buzz;
									$youtube = $xmlObject->youtube;
									$feedburner = $xmlObject->feedburner;
									$flickr = $xmlObject->flickr;
									$picasa = $xmlObject->picasa;
									$vimeo = $xmlObject->vimeo;
									$tumblr = $xmlObject->tumblr;
							}
						?>
                        <!-- Follow Us Start -->
                    	<ul>
                        	<li><h6 class="white"><?php if($cs_transwitch =='on'){ _e('Follow Us',CSDOMAIN); }else{ echo __CS('follow_us', 'Follow Us'); }?></h6></li>
							<?php if($twitter != ''){?><li><a title="Twitter" href="<?php echo $twitter;?>" class="twitter" target="_blank"></a></li><?php }?>
                            <?php if($facebook != ''){?><li><a  title="Facebook" href="<?php echo $facebook;?>" class="facebook" target="_blank"></a></li><?php }?>
                            <?php if($linkedin != ''){?><li><a  title="Linkedin" href="<?php echo $linkedin;?>" class="linkedin" target="_blank"></a></li><?php }?>
                            <?php if($digg != ''){?><li><a  title="Digg" href="<?php echo $digg;?>" class="digg" target="_blank"></a></li><?php }?>
                            <?php if($delicious != ''){?><li><a  title="Delicious" href="<?php echo $delicious;?>" class="delicious" target="_blank"></a></li><?php }?>
                            <?php if($google_plus != ''){?><li><a  title="Google Plus" href="<?php echo $google_plus;?>" class="google_plus" target="_blank"></a></li><?php }?>
                            <?php if($google_buzz != ''){?><li><a  title="Google Buzz" href="<?php echo $google_buzz;?>" class="google_buzz" target="_blank"></a></li><?php }?>
                            <?php if($google_bookmark != ''){?><li><a  title="Google Bookmark" href="<?php echo $google_bookmark;?>" class="google_bookmark" target="_blank"></a></li><?php }?>                                                                                                                                            
                            <?php if($myspace != ''){?><li><a  title="Myspace" href="<?php echo $myspace;?>" class="myspace" target="_blank"></a></li><?php }?>
                            <?php if($reddit != ''){?><li><a  title="Reddit" href="<?php echo $reddit;?>" class="reddit" target="_blank"></a></li><?php }?>
                            <?php if($stumbleupon != ''){?><li><a  title="Stumbleupon" href="<?php echo $stumbleupon;?>" class="stumbleupon" target="_blank"></a></li><?php }?>
                            <?php if($youtube != ''){?><li><a  title="Youtube" href="<?php echo $youtube;?>" class="youtube" target="_blank"></a></li><?php }?>
                            <?php if($feedburner != ''){?><li><a  title="Feedburner" href="<?php echo $feedburner;?>" class="feedburner" target="_blank"></a></li><?php }?>
                            <?php if($flickr != ''){?><li><a  title="Flickr" href="<?php echo $flickr;?>" class="flickr" target="_blank"></a></li><?php }?>                                                                                                                                
                            <?php if($picasa != ''){?><li><a  title="Picasa" href="<?php echo $picasa;?>" class="picasa" target="_blank"></a></li><?php }?>                                                                                                                                                                
							<?php if($vimeo != ''){?><li><a  title="Vimeo" href="<?php echo $vimeo;?>" class="vimeo" target="_blank"></a></li><?php }?>                                                                                                                                                                
                            <?php if($tumblr != ''){?><li><a title="Tumblr"  href="<?php echo $tumblr;?>" class="tumblr" target="_blank"></a></li><?php }?>                                                                                                                                                                
                            
                        </ul>
                        <!-- Follow Us End -->
                    </div>
                    <!-- Follow Us and Top End -->
                </div>
            </div>
            <div class="clear"></div>
            <!-- Footer End -->
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php echo  stripslashes($cs_analytics);?>
<!-- Outer Wrapper End -->
<?php wp_footer(); ?>
 </body>
</html>
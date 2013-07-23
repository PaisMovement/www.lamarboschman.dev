<?php
class cs_music_player extends WP_Widget
{
  function cs_music_player()
  {
    $widget_ops = array('classname' => 'cs_music_player', 'description' => 'Select Album to Play Your Playlist.' );
    $this->WP_Widget('cs_music_player', 'ChimpS : MusicPlayList', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
	$get_post_slug = isset( $instance['get_post_slug'] ) ? esc_attr( $instance['get_post_slug'] ) : '';
	$numtrack = isset( $instance['numtrack'] ) ? esc_attr( $instance['numtrack'] ) : '';

?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>">
          <span>Title: </span>
          <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
      </label>
    </p>
    <br />
    
    <p>
      <label for="<?php echo $this->get_field_id('get_post_slug'); ?>">
          <span>Album for Playlist:</span>
          <br /><br />

          <select name="<?php echo $this->get_field_name('get_post_slug'); ?>" style="width:225px;">
          <?php
                global $wpdb,$post;
                $args = array( 'post_type' => 'albums', 'posts_per_page' => -1,'post_status'=> 'publish');
                $loop = new WP_Query( $args );
                while ( $loop->have_posts() ) : $loop->the_post();
            ?>	
                    <option <?php if($get_post_slug == $post->post_name){echo 'selected';}?> value="<?php echo $post->post_name;?>">
					<?php echo substr(get_the_title(), 0, 20);	if ( strlen(get_the_title()) > 20 ) echo "...";?>
					</option>
                <?php endwhile;  ?>
          </select>
      </label>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('noot'); ?>">
          <span>No Of Tracks To Play: </span>
          <input class="upcoming" id="<?php echo $this->get_field_id('numtrack'); ?>" size="2" name="<?php echo $this->get_field_name('numtrack'); ?>" type="text" value="<?php echo esc_attr($numtrack); ?>" />
      </label>
    </p>
	<div class="clear"></div>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
	$instance['get_post_slug'] = $new_instance['get_post_slug'];
	$instance['numtrack'] = $new_instance['numtrack'];	
    return $instance;
  }
 
	function widget($args, $instance)
	{
		global $cs_transwitch;
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$get_post_slug = empty($instance['get_post_slug']) ? ' ' : apply_filters('widget_title', $instance['get_post_slug']);		
		 echo $before_widget;
		 $args=array(
		  'name' => $get_post_slug,
		  'post_type' => 'albums',
		  'post_status' => 'publish',
		  'showposts' => 1,
 		);
		$get_posts = get_posts($args);
		if( $get_posts ) {
			$get_post_id = $get_posts[0]->ID;
		}else{
			$get_post_id = '';
		}
 		
		// WIDGET display CODE Start
		if (!empty($title))
			
			echo $before_title . $title . $after_title;
			global $wpdb;
			if($get_post_id <> ""){
			 $album_buy_amazon_db ='';
			 $album_buy_apple_db = '';
			 $album_buy_groov_db ='';
			 $album_buy_cloud_db = '';			 
			 $cs_album = get_post_meta($get_post_id, "cs_album", true);
				 if ( $cs_album <> "" ) {
					 $xmlObject = new SimpleXMLElement($cs_album);
						 $album_release_date_db = $xmlObject->album_release_date;
						 $album_buy_amazon_db = $xmlObject->album_buy_amazon;
						 $album_buy_apple_db = $xmlObject->album_buy_apple;
						 $album_buy_groov_db = $xmlObject->album_buy_groov;
						 $album_buy_cloud_db = $xmlObject->album_buy_cloud;
                       	enqueue_alubmtrack_format_resources('widget');
						?>
                         <script>
                        jQuery(document).ready(function($){
                            new jPlayerPlaylist({
                                jPlayer: "#jquery_jplayer_<?php echo $get_post_id;?>",
                                cssSelectorAncestor: "#jp_container_<?php echo $get_post_id;?>"
                            }, [                                         
                                 <?php	
                                     $my_counter = 0;
                                     foreach ( $xmlObject as $track ){
                                         if ( $track->getName() == "track" ) {
                                             if ( $my_counter < $instance['numtrack'] ) {
                                                 $album_track_title = $track->album_track_title;
                                                 $album_track_mp3_url = $track->album_track_mp3_url;
                                                 echo '{';
                                                 echo 'title:"'.$album_track_title.'",';
                                                 echo 'mp3:"'.$album_track_mp3_url.'"';
                                                 echo '},';
                                             }
                                             $my_counter++;
                                         }
                                     }
                        ?>
                            ], {
                                swfPath: "<?php echo get_template_directory_uri()?>/scripts/frontend/Jplayer.swf",
                                supplied: "mp3",
                                wmode: "window"
                            });
                        });                                                     
                        </script>                                         
                        
                        <!-- Now Playing Start -->
                        <div class="nowplaying">
                        	<?php $cs_by = __('By: %s', CSDOMAIN); ?>
                            <h5><a href="<?php echo get_permalink($get_post_id); ?>"><?php if($get_post_id <> ''){echo get_the_title($get_post_id);}?></a></h5>
                            <p><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php printf($cs_by, get_the_author()); ?></a> - <?php if(isset($album_release_date_db)){ if($cs_transwitch =='on'){ _e('Release Date',CSDOMAIN); }else{ echo __CS('release_date', 'Release Date'). ' : '.$album_release_date_db; }}?></p>
                            <div id="jquery_jplayer_<?php echo $get_post_id;?>" class="jp-jplayer"></div>
                            <div id="jp_container_<?php echo $get_post_id;?>" class="jp-audio">
                                <div class="jp-type-playlist">
                                    <div class="jp-gui jp-interface">
                                        <ul class="jp-controls">
                                            <li><a href="javascript:;" class="jp-previous" tabindex="1">previous</a></li>
                                            <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                                            <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                                            <li><a href="javascript:;" class="jp-next" tabindex="1">next</a></li>
                                            <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
                                            <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                                            <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                                            <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
                                        </ul>
                                        <div class="jp-progress">
                                            <div class="jp-seek-bar">
                                                <div class="jp-play-bar"></div>
                                            </div>
                                        </div>
                                        <div class="jp-volume-bar">
                                            <div class="jp-volume-bar-value"></div>
                                        </div>
                                        <div class="jp-current-time"></div>
                                        <div class="jp-duration"></div>
                                        <ul class="jp-toggles">
                                            <li><a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle">Shuffle</a></li>
                                            <li><a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off">Shuffle off</a></li>
                                            <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">Repeat All</a></li>
                                            <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">Repeat off</a></li>
                                        </ul>
                                    </div>
                                    <div class="jp-playlist">
                                        <ul>
                                            <li></li>
                                        </ul>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
						<?php if($album_buy_amazon_db <> '' or $album_buy_apple_db <> '' or $album_buy_groov_db <> '' or $album_buy_cloud_db <> ''){?>
                        <!-- Buy Now Start -->
                        <div class="buynow">
                            <h5 class="white"><?php if($cs_transwitch =='on'){ _e('BUY NOW',CSDOMAIN); }else{ echo __CS('buy_now', 'BUY NOW'); } ?></h5>
                            <ul>
                                <?php if($xmlObject->album_buy_cloud <> ""){?><li><a href="<?php echo $xmlObject->album_buy_cloud;?>" class="soundcloud">&nbsp;</a></li><?php }?>
                                <?php if($xmlObject->album_buy_amazon <> ""){?><li><a href="<?php echo $xmlObject->album_buy_amazon;?>" class="amazon">&nbsp;</a></li><?php }?>
                                <?php if($xmlObject->album_buy_apple <> ""){?><li><a href="<?php echo $xmlObject->album_buy_apple;?>" class="apple">&nbsp;</a></li><?php }?>
                                <?php if($xmlObject->album_buy_groov <> ""){?><li><a href="<?php echo $xmlObject->album_buy_groov;?>" class="grooveshark">&nbsp;</a></li><?php }?>
                            </ul>
                            <!-- Buy Now End -->
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                        <?php } //Buy now Condition end?>
                      <?php }else{?>
                        <div class="list-thumb">
                            <ul>
                                <li>
                                    <h2><?php _e("No results found.",CSDOMAIN); ?></h2>
                                </li>
                            </ul>
                        </div>
                          <?php
						  } 
		} // if Album is not Selected 
		else{
             echo '<div class="box-small no-results-found"> <h5>';
				_e("No results found.",CSDOMAIN);
			echo ' </h5></div>';
 			
			}
	echo $after_widget;
	}
}
	
add_action( 'widgets_init', create_function('', 'return register_widget("cs_music_player");') );?>
<?php
// album start
	//adding columns start
    add_filter('manage_albums_posts_columns', 'album_columns_add');
		function album_columns_add($columns) {
			$columns['category'] = 'Category';
			$columns['author'] = 'Author';
			return $columns;
    }
    add_action('manage_albums_posts_custom_column', 'album_columns');
		function album_columns($name) {
			global $post;
			switch ($name) {
				case 'category':
					$categories = get_the_terms( $post->ID, 'album-category' );
						if($categories <> ""){
							$couter_comma = 0;
							foreach ( $categories as $category ) {
								echo $category->name;
								$couter_comma++;
								if ( $couter_comma < count($categories) ) {
									echo ", ";
								}
							}
						}
					break;
				case 'author':
					echo get_the_author();
					break;
			}
		}
	//adding columns end

	function cs_album_register() {
		$labels = array(
			'name' => __('Manage Albums','mytheme'),
			'add_new_item' => __('Add New Album','mytheme'),
			'edit_item' => __('Edit Album','mytheme'),
			'new_item' => __('New Album Item','mytheme'),
			'add_new' => __('Add New Album', 'Add Album'),
			'view_item' => __('View Album Item','mytheme'),
			'search_items' => __('Search Album','mytheme'),
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
			'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/album-icon.png',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail', 'comments' )
		); 
        register_post_type( 'albums' , $args );
	}
		  $labels = array(
			'name' => __( 'Album Categories' ,'mytheme' ),
			'search_items' =>  __( 'Search Album Categories' ,'mytheme'),
			'edit_item' => __( 'Edit Album Category' ,'mytheme'), 
			'update_item' => __( 'Update Album Category' ,'mytheme'),
			'add_new_item' => __( 'Add New Category','mytheme' ),
			'menu_name' => __( 'Album Categories' ,'mytheme'),
		  ); 	
		  register_taxonomy('album-category',array('albums'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'album-category' ),
		  ));

	add_action('init', 'cs_album_register');

	// adding album meta info start
		add_action( 'add_meta_boxes', 'cs_meta_album_add' );
		function cs_meta_album_add()
		{  
			add_meta_box( 'cs_meta_album', 'Album Options', 'cs_meta_album', 'albums', 'normal', 'high' );  
		}
		function cs_meta_album( $post ) {
			$cs_album = get_post_meta($post->ID, "cs_album", true);
			if ( $cs_album <> "" ) {
				$xmlObject = new SimpleXMLElement($cs_album);
					$album_release_date_db = $xmlObject->album_release_date;
					$album_social_share_db = $xmlObject->album_social_share;
					$album_buy_amazon_db = $xmlObject->album_buy_amazon;
					$album_buy_apple_db = $xmlObject->album_buy_apple;
					$album_buy_groov_db = $xmlObject->album_buy_groov;
					$album_buy_cloud_db = $xmlObject->album_buy_cloud;
			}
			else {
				$album_release_date_db = '';
				$album_social_share_db = '';
				$album_buy_amazon_db = '';
				$album_buy_apple_db = '';
				$album_buy_groov_db = '';
				$album_buy_cloud_db = '';
			}
?>
            <div class="page-wrap page-opts left" style="overflow:hidden; position:relative;">
            <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.scrollTo-min.js"></script>
                <div class="option-sec" style="margin-bottom:0;">
                    <div class="opt-head">
                        <h6>Release Date and Social Sharing</h6>
                    </div>
                    <div class="opt-conts">
                    	<ul class="form-elements">
                            <li class="to-label">
                                <label>Release Date</label>
                            </li>
                            <li class="to-field">
            
                                    <!--date picker start-->
                                        <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/jquery.ui.datepicker.css">
                                        <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/jquery.ui.datepicker.theme.css">
                                        <script>
                                        jQuery(function($) {
                                            $( "#album_release_date" ).datepicker({
                                                defaultDate: "+1w",
                                                dateFormat: "yy-mm-dd",
												changeMonth: true,
                                                numberOfMonths: 1,
                                                //onSelect: function( selectedDate ) {
                                                    //$( "#cs_event_to_date" ).datepicker( "option", "minDate", selectedDate );
                                                //}
                                            });
                                        });
                                        </script>
                                    <!--date picker end-->
                                <input type="text" id="album_release_date" name="album_release_date" value="<?php if ($album_release_date_db=="") echo gmdate("Y-m-d"); else echo $album_release_date_db?>" />
                            </li>
                            <li class="to-desc">
                                <p>
                                    Put album release date
                                </p>
                            </li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label">
                                <label>Social Sharing</label>
                            </li>
                            <li class="to-field">
                                <select name="album_social_share" id="album_social_share" class="dropdown">
                                    <option <?php if($album_social_share_db=="Yes")echo "selected" ?> >Yes</option>
                                    <option <?php if($album_social_share_db=="No")echo "selected" ?> >No</option>
                                </select>
                            </li>
                            <li class="to-desc">
                                <p>
                                    Make Social Sharing On/Off
                                </p>
                            </li>
                        </ul>
                    </div>
					<div class="clear"></div>
                </div>
                <div class="option-sec row" style="margin-bottom:0;">
                    <div class="opt-head">
                        <h6>Buy Now</h6>
                    </div>
                    <div class="opt-conts">
                        <ul class="form-elements">
                            <li class="to-label">
                                <label>Amazon</label>
                            </li>
                            <li class="to-field">
                                <input type="text" name="album_buy_amazon" value="<?php echo htmlspecialchars($album_buy_amazon_db)?>" />
                            </li>
                            <li class="to-desc">
                                <div class="icon-thumb">
                                    <img src="<?php echo get_template_directory_uri()?>/images/admin/amazon.gif" />
                                </div>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label">
                                <label>Apple ITunes</label>
                            </li>
                            <li class="to-field">
                                <input type="text" name="album_buy_apple" value="<?php echo htmlspecialchars($album_buy_apple_db)?>" />
                            </li>
                            <li class="to-desc">
                                <div class="icon-thumb">
                                    <img src="<?php echo get_template_directory_uri()?>/images/admin/itunes.gif" />
                                </div>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label">
                                <label>Grooveshark</label>
                            </li>
                            <li class="to-field">
                                <input type="text" name="album_buy_groov" value="<?php echo htmlspecialchars($album_buy_groov_db)?>" />
                            </li>
                            <li class="to-desc">
                                <div class="icon-thumb">
                                    <img src="<?php echo get_template_directory_uri()?>/images/admin/grooveshark.gif" />
                                </div>
                            </li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label">
                                <label>Sound Cloud</label>
                            </li>
                            <li class="to-field">
                                <input type="text" name="album_buy_cloud" value="<?php echo htmlspecialchars($album_buy_cloud_db)?>" />
                            </li>
                            <li class="to-desc">
                                <div class="icon-thumb">
                                    <img src="<?php echo get_template_directory_uri()?>/images/admin/soundcloud.gif" />
                                </div>
                            </li>
                        </ul>
                    </div>
					<div class="clear"></div>
                </div>
                <div class="to-tables" style="margin-top: 10px;">
                    <div id="add_track" class="poped-up">
                        <div class="opt-head">
                            <h6>Track Settings</h6>
                            <a href="javascript:closetrack('add_track')" class="closeit">&nbsp;</a>
                        </div>
                        <ul class="form-elements">
                            <li class="to-label"><label>Track Title</label></li>
                            <li class="to-field"><input type="text" id="album_track_title_dummy" name="album_track_title_dummy" value="Track Title" /></li>
                            <li class="to-desc"><p>Put album track title</p></li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Track MP3 URL</label></li>
                            <li class="to-field">
								<input id="album_track_mp3_url" name="album_track_mp3_url" value="" type="text" size="36" />
								<input id="album_track_mp3_url" name="album_track_mp3_url" type="button" class="uploadfile left" value="Browse"/>
                            </li>
                            <li class="to-desc"><p>Put album track mp3 url</p></li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Playable</label></li>
                            <li class="to-field">
                                <select name="album_track_playable" id="album_track_playable" class="dropdown">
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </li>
                            <li class="to-desc"><p>Make Playable on/off</p></li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Downloadable</label></li>
                            <li class="to-field">
                                <select name="album_track_downloadable" id="album_track_downloadable" class="dropdown">
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </li>
                            <li class="to-desc"><p>Make Downloadable on/off</p></li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Lyrics</label></li>
                            <li class="to-field"><textarea name="album_track_lyrics" id="album_track_lyrics" ></textarea></li>
                            <li class="to-desc"><p>Put Lyrics</p></li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Buy MP3 URL</label></li>
                            <li class="to-field"><input type="text" name="album_track_buy_mp3" id="album_track_buy_mp3" value="" /></li>
                            <li class="to-desc"><p>Put mp3 url to buy</p></li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"></li>
                            <li class="to-field"><input type="button" value="Add Track to List" onclick="add_track_to_list()" /></li>
                        </ul>
                    </div>
            
            
            <script>
                var counter_track = 0;
                function add_track_to_list(){
                    counter_track++;
                    var dataString = 'counter_track=' + counter_track + 
                                    '&album_track_title=' + jQuery("#album_track_title_dummy").val() +
                                    '&album_track_mp3_url=' + jQuery("#album_track_mp3_url").val() +
                                    '&album_track_playable=' + jQuery("#album_track_playable").val() + 
                                    '&album_track_downloadable=' + jQuery("#album_track_downloadable").val() +
                                    '&album_track_lyrics=' + jQuery("#album_track_lyrics").val() +
                                    '&album_track_buy_mp3=' + jQuery("#album_track_buy_mp3").val() ;
                    jQuery("#loading").html("<img src='<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif' />");
                        jQuery.ajax({
                            type:'POST',
                            url: '<?php echo get_template_directory_uri()?>/include/album_track.php',
                            data: dataString,
                            success: function(response) {
                                jQuery("#total_tracks").append(response);
                                jQuery("#loading").html("");
                                closetrack('add_track');
                                    jQuery("#album_track_title_dummy").val("Track Title");
                                    jQuery("#album_track_mp3_url").val("");
                                    jQuery("#album_track_playable").val("Yes");
                                    jQuery("#album_track_downloadable").val("Yes");
                                    jQuery("#album_track_lyrics").val("");
                                    jQuery("#album_track_buy_mp3").val("");
                            }
                        });
						
                }
            
				jQuery(document).ready(function($) {
					$("#total_tracks").sortable({
						cancel : 'li div.poped-up',
					});
				});
				</script>
               
                    <h5>
                        <span style="padding-top:5px; float:left;">Album Tracks</span> 
                        <a href="javascript:addtrack('add_track')" class="button right">Add Track</a>
                    </h5>
                    <ul class="to-rows to-head">
                        <li class="album-title">Track Title</li>
                        <li class="actions">Actions</li>
                    </ul>
                        <ul id="total_tracks">
                            <?php
                            $counter_track = $post->ID;
					        if ( $cs_album <> "" ) {
								foreach ( $xmlObject as $track ){
									if ( $track->getName() == "track" ) {
										$album_track_title = $track->album_track_title;
										$album_track_mp3_url = $track->album_track_mp3_url;
										$album_track_playable = $track->album_track_playable;
										$album_track_downloadable = $track->album_track_downloadable;
										$album_track_lyrics = $track->album_track_lyrics;
										$album_track_buy_mp3 = $track->album_track_buy_mp3;
										$counter_track++;
										include "album_track.php";
									}
								}
							}
                            ?>
                        </ul>
                        
	                </div>
				<?php include "inc_meta_layout.php"; ?>
                <input type="hidden" name="album_meta_form" value="1" />
                <div class="clear"></div>
            </div>
            <div class="clear"></div>

<?php
		}

		if ( isset($_POST['album_meta_form']) and $_POST['album_meta_form'] == 1 ) {
			if ( empty($_POST['cs_layout']) ) $_POST['cs_layout'] = 'none';
			add_action( 'save_post', 'cs_meta_album_save' );  
			function cs_meta_album_save( $post_id )
			{  
				$sxe = new SimpleXMLElement("<album></album>");
					if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
					if ( empty($_POST["album_release_date"]) ) $_POST["album_release_date"] = "";
					if ( empty($_POST["album_social_share"]) ) $_POST["album_social_share"] = "";
					if ( empty($_POST["album_buy_amazon"]) ) $_POST["album_buy_amazon"] = "";
					if ( empty($_POST["album_buy_apple"]) ) $_POST["album_buy_apple"] = "";
					if ( empty($_POST["album_buy_groov"]) ) $_POST["album_buy_groov"] = "";
					if ( empty($_POST["album_buy_cloud"]) ) $_POST["album_buy_cloud"] = "";
						$sxe = save_layout_xml($sxe);
								$sxe->addChild('album_release_date', $_POST['album_release_date'] );
								$sxe->addChild('album_social_share', $_POST['album_social_share'] );
								$sxe->addChild('album_buy_amazon', htmlspecialchars($_POST['album_buy_amazon']) );
								$sxe->addChild('album_buy_apple', htmlspecialchars($_POST['album_buy_apple']) );
								$sxe->addChild('album_buy_groov', htmlspecialchars($_POST['album_buy_groov']) );
								$sxe->addChild('album_buy_cloud', htmlspecialchars($_POST['album_buy_cloud']) );
							$counter = 0;
							if ( isset($_POST['album_track_title']) ) {
								foreach ( $_POST['album_track_title'] as $count ){
									$track = $sxe->addChild('track');
										$track->addChild('album_track_title', htmlspecialchars($_POST['album_track_title'][$counter]) );
										$track->addChild('album_track_mp3_url', htmlspecialchars($_POST['album_track_mp3_url'][$counter]) );
										$track->addChild('album_track_playable', $_POST['album_track_playable'][$counter] );
										$track->addChild('album_track_downloadable', $_POST['album_track_downloadable'][$counter] );
										$track->addChild('album_track_lyrics', htmlspecialchars($_POST['album_track_lyrics'][$counter]) );
										$track->addChild('album_track_buy_mp3', htmlspecialchars($_POST['album_track_buy_mp3'][$counter]) );
										$counter++;
								}
							}
				update_post_meta( $post_id, 'cs_album', $sxe->asXML() );
			}
		}
		// adding album meta info end
	
// album end
	
?>
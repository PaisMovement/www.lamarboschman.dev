<?php
function home_page_settings() {
	global $post;
		$show_slider = "";
		$slider_type = "";
		$slider_name = "";
			$cs_home_page_slider = get_option("cs_home_page_slider");
			if ( $cs_home_page_slider <> "" ) {
				$xmlObject = new SimpleXMLElement($cs_home_page_slider);
					$show_slider = $xmlObject->show_slider;
					$slider_type = $xmlObject->slider_type;
					$slider_name = $xmlObject->slider_name;
			}
?>
	<script>
		function frm_submit(){
			$ = jQuery;
			$("#submit_btn").hide();
			$("#loading_div").html('<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />');
			$.ajax({
				type:'POST', 
				url: '<?php echo get_template_directory_uri()?>/include/home_page_slider_save.php',
				data:$('#frm').serialize(), 
				success: function(response) {
					//$('#frm_slide').get(0).reset();
					$(".form-msgs p").html(response);
					$(".form-msgs").show("");
					$("#submit_btn").show('');
					$("#loading_div").html('');
					slideout();
					//$('#frm_slide').find('.form_result').html(response);
				}
			});
		}
		function frm_submit2(){
			$ = jQuery;
			$("#submit_btn2").hide();
			$("#loading_div2").html('<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />');
			$.ajax({
				type:'POST', 
				url: '<?php echo get_template_directory_uri()?>/include/home_page_album_save.php',
				data:$('#frm2').serialize(), 
				success: function(response) {
					//$('#frm_slide').get(0).reset();
					$(".form-msgs p").html(response);
					$(".form-msgs").show("");
					$("#submit_btn2").show('');
					$("#loading_div2").html('');
					slideout();
					//$('#frm_slide').find('.form_result').html(response);
				}
			});
		}
	</script>
<div class="theme-wrap fullwidth">
	<?php include "theme_leftnav.php";?>
    <!-- Right Column Start -->
    <div class="col2 left">
		<!-- Header Start -->
        <div class="wrap-header">
            <h4 class="bold">Home Page Settings</h4>
            
            <div class="clear"></div>
        </div>
        <!-- Header End -->
        <!-- Content Section Start -->
        <div class="tab-section">
            <div class="tab_menu_container">
                <ul id="tab_menu">  
                    <li><a href="#chooselang" class="current" rel="tab-chooselang"><span>Home Page Slider</span></a></li>
                    <li><a href="#uploadlang" class="" rel="tab-uploadlang"><span>Home Page Album</span></a></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="tab_container">
            	<div class='form-msgs' style="display:none"><div class='to-notif success-box'><span class='tick'>&nbsp;</span><p></p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>
                <div class="tab_container_in">
                    <!-- social network Start -->
                    <div id="tab-chooselang" class="tab-list">
                        <div class="option-sec">
                        	<form id="frm" method="post" action="javascript:frm_submit()">
                            <div class="opt-head">
                                <h6>Home Page Slider</h6>
                                <p>Edit home page slider settings</p>
                            </div>
                            <div class="opt-conts">
                                <ul class="form-elements">
                                    <li class="to-label">
                                        <label>Show Slider</label>
                                    </li>
                                    <li class="to-field">
                                        <div class="on-off">
                                            <input type="checkbox" name="show_slider" class="styled" <?php if($show_slider=="on") echo "checked" ?> />
                                        </div>
                                    </li>
                                    <li class="to-desc">
                                        <p>Switch it on if you want to show slider at home page. If you switch it off it will not show slider at home page</p>
                                    </li>
                                </ul>
                                <ul class="form-elements">
                                    <li class="to-label">
                                        <label>Choose SliderType</label>
                                    </li>
                                    <li class="to-field">
                                        <select name="slider_type" class="dropdown">
                                            <option <?php if($slider_type=="Anything Slider"){echo "selected";}?> >Anything Slider</option>
                                            <option <?php if($slider_type=="Nivo Slider"){echo "selected";}?> >Nivo Slider</option>
                                            <option <?php if($slider_type=="Sudo Slider"){echo "selected";}?> >Sudo Slider</option>
                                        </select>
                                    </li>
                                </ul>
                                <ul class="form-elements">
                                    <li class="to-label">
                                        <label>Select Slider</label>
                                    </li>
                                    <li class="to-field">
                                        <select name="slider_name" class="dropdown">
                                        	<option value="">-- Select Slider --</option>
                                            <?php
                                                $query = array( 'post_type' => 'cs_slider', 'orderby'=>'ID' );
                                                $wp_query = new WP_Query($query);
                                                while ($wp_query->have_posts()) : $wp_query->the_post();
                                            ?>
                                                <option <?php if($post->post_name==$slider_name)echo "selected";?> value="<?php echo $post->post_name; ?>"><?php echo $post->post_title?></option>
                                            <?php
                                                endwhile;
                                            ?>
                                        </select>
                                    </li>
                                    <li class="to-desc">
                                        <p>Select Slider from drop down to show at home page. To creat new slider go to Manage Slider</p>
                                    </li>
                                </ul>
                                <ul class="form-elements noborder">
                                    <li class="to-label">
                                    </li>
                                    <li class="to-field">
                                        <input id="submit_btn" type="submit" value="Save Slider" />
                                        <div id="loading_div"></div>
                                    </li>
                                </ul>
                            </div>
                        </form>
                        </div>
                    </div>
                    <!-- social network End -->
<?php
	$cs_home_page_album = get_option("cs_home_page_album");
		$show_album = "";
		$album_title = "";
		$album_cat = "";
		$show_view_all = '';
		$no_of_album_post = '';
			if ( $cs_home_page_album <> "" ) {
				$xmlObject = new SimpleXMLElement($cs_home_page_album);
					$show_album = $xmlObject->show_album;
					$album_title = $xmlObject->album_title;
					$album_cat = $xmlObject->album_cat;
					$show_view_all = $xmlObject->show_view_all;
					$no_of_album_post = $xmlObject->no_of_album_post;
			}
?>
                    <!-- social share Tabs -->
                    <div id="tab-uploadlang" class="tab-list">
                        <div class="option-sec">
                        	<form id="frm2" method="post" action="javascript:frm_submit2()">
                            <div class="opt-head">
                                <h6>Home Page Albums List</h6>
                                <p>Edit home page albums list settings</p>
                            </div>
                            <div class="opt-conts">
                                <ul class="form-elements">
                                    <li class="to-label">
                                        <label>Show Albums</label>
                                    </li>
                                    <li class="to-field">
                                        <div class="on-off">
                                            <input type="checkbox" name="show_album" class="styled" <?php if($show_album=="on") echo "checked" ?> />
                                        </div>
                                    </li>
                                    <li class="to-desc">
                                        <p>
                                            Switch it on if you want to show Albums at home page. If you switch it off it will not show Albums at home page
                                        </p>
                                    </li>
                                </ul>
                                <ul class="form-elements">
                                    <li class="to-label">
                                        <label>Album Title</label>
                                    </li>
                                    <li class="to-field">
                                        <input type="text" name="album_title" value="<?php echo htmlspecialchars($album_title)?>" />
                                    </li>
                                    <li class="to-desc">
                                        <p>
                                            Put heading for albums section
                                        </p>
                                    </li>
                                </ul>
                                <ul class="form-elements">
                                    <li class="to-label">
                                        <label>Select Albums Category</label>
                                    </li>
                                    <li class="to-field">
				                        	<?php 
												//$categories = get_categories( array('child_of' => "$cs_album_cat_db", 'taxonomy' => 'album-category', 'hide_empty' => 0) );
												//print_r($categories);
												//foreach ($categories as $category) {
													//echo "<li><a class='".$category->term_id."' href='#'>".$category->cat_name."</a></li>";
													//echo $category->cat_name;
												//}
											?>
                                        <select name="album_cat">
                                        	<option value="0">---- Select Category ----</option>
				                        	<?php 
												show_all_cats('', '', $album_cat, "album-category");
											?>
                                        </select>
                                    </li>
                                    <li class="to-desc">
                                        <p>
                                            Select Albums from drop down to show at home page. To creat new album go to manage albums
                                        </p>
                                    </li>
                                </ul>
                                <ul class="form-elements" id="view_all_url">
                                    <li class="to-label"><label>No. of post</label></li>
                                    <li class="to-field"><input type="text" name="no_of_album_post" value="<?php echo $no_of_album_post?>" /></li>
                                    <li class="to-desc"><p>No of album post to show </p></li>
                                </ul>
                                <ul class="form-elements">
                                    <li class="to-label">
                                        <label>Show More Button</label>
                                    </li>
                                    <li class="to-field">
                                        <div class="on-off">
                                            <select name="show_view_all">
                                                <option value="Yes" <?php if($show_view_all=="Yes")echo "selected";?> >Yes</option>
                                                <option value="No" <?php if($show_view_all=="No")echo "selected";?> >No</option>
                                            </select>
                                        </div>
                                    </li>
                                    <li class="to-desc">
                                        <p>
                                            Put heading for albums section
                                        </p>
                                    </li>
                                </ul>
                                <ul class="form-elements noborder">
                                    <li class="to-label">
                                    </li>
                                    <li class="to-field">
                                        <input id="submit_btn2" type="submit" value="Save Album" />
                                        <div id="loading_div2"></div>
                                    </li>
                                </ul>
                            </div>
                        </form>
                        </div>
                    </div>
                    <!-- social share End -->
                    <div class="clear"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <!-- Content Section End -->
    </div>
    <div class="clear"></div>
    <!-- Right Column End -->
</div>
<?php } ?>
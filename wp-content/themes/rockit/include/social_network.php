<?php
function social_network() {
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
	<script>
			function frm_submit(){
				$ = jQuery;
				$("#submit_btn").hide();
				$("#loading_div").html('<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />');
				$.ajax({
					type:'POST', 
					url: '<?php echo get_template_directory_uri()?>/include/social_network_save.php',
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
					url: '<?php echo get_template_directory_uri()?>/include/social_sharing_save.php',
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
            <h4 class="bold">Social Networking</h4>
            
            <div class="clear"></div>
        </div>
        <!-- Header End -->
        <!-- Content Section Start -->
        <div class="tab-section">
            <div class="tab_menu_container">
                <ul id="tab_menu">  
                    <li><a href="#chooselang" class="current" rel="tab-chooselang"><span>Social Networking</span></a></li>
                    <li><a href="#uploadlang" class="" rel="tab-uploadlang"><span>Social Sharing</span></a></li>
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
                                    <h6>Social Network Settings</h6>
                                    <p>Social Network Settings.</p>
                                </div>
                                <div class="opt-conts">
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Twitter</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="twitter" value="<?php echo htmlspecialchars($twitter) ?>" />
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/twitter.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Facebook</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="facebook" value="<?php echo htmlspecialchars($facebook) ?>" />
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/facebook.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Linkedin</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="linkedin" value="<?php echo htmlspecialchars($linkedin) ?>" />
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/linkedin.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Digg</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="digg" value="<?php echo htmlspecialchars($digg) ?>" />
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/digg.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Delicious</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="delicious" value="<?php echo htmlspecialchars($delicious) ?>" />
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/delicious.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Google+</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="google_plus" value="<?php echo htmlspecialchars($google_plus) ?>" />
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/google_plus.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Google Buzz</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="google_buzz" value="<?php echo htmlspecialchars($google_buzz) ?>" />
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/google_buzz.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Google Bookmark</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="google_bookmark" value="<?php echo htmlspecialchars($google_bookmark) ?>" />
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/google_bookmark.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Myspace</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="myspace" value="<?php echo htmlspecialchars($myspace) ?>" />
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/myspace.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Reddit</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="reddit" value="<?php echo htmlspecialchars($reddit) ?>" />
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/reddit.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Stumbleupon</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="stumbleupon" value="<?php echo htmlspecialchars($stumbleupon) ?>" />
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/stumbleupon.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Youtube</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="youtube" value="<?php echo htmlspecialchars($youtube) ?>" />
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/youtube.gif" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Feedburner</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="feedburner" value="<?php echo htmlspecialchars($feedburner) ?>" />
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/feedburner.gif" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Flickr</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="flickr" value="<?php echo htmlspecialchars($flickr) ?>" />
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/flikr.gif" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Picasa</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="picasa" value="<?php echo htmlspecialchars($picasa) ?>" />
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/picasa.gif" />
                                            </div>
                                        </li>
                                    </ul>
                                    
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Vimeo</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="vimeo" value="<?php echo htmlspecialchars($vimeo) ?>" />
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/vimeo.gif" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Tumblr</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="tumblr" value="<?php echo htmlspecialchars($tumblr) ?>" />
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/tumbler.gif" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label"></li>
                                        <li class="to-field">
                                            <input id="submit_btn" type="submit" value="Save Network Settings" />
											<div id="loading_div"></div>
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- social network End -->
<?php
$cs_social_share = get_option("cs_social_share");
	if ( $cs_social_share <> "" ) {
		$xmlObject = new SimpleXMLElement($cs_social_share);
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
			$rss = $xmlObject->rss;
	}
?>
                    <!-- social share Tabs -->
                    <div id="tab-uploadlang" class="tab-list">
                        <div class="option-sec">
                        	<form id="frm2" method="post" action="javascript:frm_submit2()">
                            	<div class="opt-head">
                                    <h6>Social Sharing Settings</h6>
                                    <p>Social Sharing Settings..</p>
                                </div>
                                <div class="opt-conts">
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Twitter</label>
                                        </li>
                                        <li class="to-field">
                                            <div class="on-off">
	                                            <input type="checkbox" name="twitter" class="styled" <?php if($twitter=="on") echo "checked" ?> />
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/twitter.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Facebook</label>
                                        </li>
                                        <li class="to-field">
                                            <div class="on-off">
                                            	<input type="checkbox" name="facebook" class="styled" <?php if($facebook=="on") echo "checked" ?> />
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/facebook.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Linkedin</label>
                                        </li>
                                        <li class="to-field">
                                            <div class="on-off">
	                                            <input type="checkbox" name="linkedin" class="styled" <?php if($linkedin=="on") echo "checked" ?> />
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/linkedin.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Digg</label>
                                        </li>
                                        <li class="to-field">
                                        	<div class="on-off">
	                                            <input type="checkbox" name="digg" class="styled" <?php if($digg=="on") echo "checked" ?> />
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/digg.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Delicious</label>
                                        </li>
                                        <li class="to-field">
                                        	<div class="on-off">
	                                            <input type="checkbox" name="delicious" class="styled" <?php if($delicious=="on") echo "checked" ?> />
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/delicious.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Google+</label>
                                        </li>
                                        <li class="to-field">
                                            <div class="on-off">
	                                            <input type="checkbox" name="google_plus" class="styled" <?php if($google_plus=="on") echo "checked" ?> />
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/google_plus.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Google Buzz</label>
                                        </li>
                                        <li class="to-field">
                                        	<div class="on-off">
	                                            <input type="checkbox" name="google_buzz" class="styled" <?php if($google_buzz=="on") echo "checked" ?> />
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/google_buzz.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Google Bookmark</label>
                                        </li>
                                        <li class="to-field">
                                        	<div class="on-off">
	                                            <input type="checkbox" name="google_bookmark" class="styled" <?php if($google_bookmark=="on") echo "checked" ?> />
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/google_bookmark.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Myspace</label>
                                        </li>
                                        <li class="to-field">
                                        	<div class="on-off">
	                                            <input type="checkbox" name="myspace" class="styled" <?php if($myspace=="on") echo "checked" ?> />
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/myspace.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Reddit</label>
                                        </li>
                                        <li class="to-field">
                                        	<div class="on-off">
	                                            <input type="checkbox" name="reddit" class="styled" <?php if($reddit=="on") echo "checked" ?> />
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/reddit.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Stumbleupon </label>
                                        </li>
                                        <li class="to-field">
                                        	<div class="on-off">
	                                            <input type="checkbox" name="stumbleupon" class="styled" <?php if($stumbleupon=="on") echo "checked" ?> />
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/stumbleupon.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>RSS</label>
                                        </li>
                                        <li class="to-field">
                                        	<div class="on-off">
	                                            <input type="checkbox" name="rss" class="styled" <?php if($rss=="on") echo "checked" ?> />
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <div class="icon-thumb">
                                                <img src="<?php echo get_template_directory_uri()?>/images/admin/rss.png" />
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label"></li>
                                        <li class="to-field">
                                            <input id="submit_btn2" type="submit" value="Save Sharing Settings" />
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

<?php
}
?>
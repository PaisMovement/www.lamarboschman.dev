<?php
function translation() {
	$cs_trans_events = get_option( "cs_trans_events" );
		if ( $cs_trans_events <> "" ) {
			$sxe = new SimpleXMLElement($cs_trans_events);
				$event_trans_booking_url = $sxe->event_trans_booking_url;
				$event_trans_all_day = $sxe->event_trans_all_day;
				$event_trans_posted_by = $sxe->event_trans_posted_by;
				$event_trans_category_filter = $sxe->event_trans_category_filter;
		}
		else {
				$event_trans_booking_url = '';
				$event_trans_all_day = '';
				$event_trans_posted_by = '';
				$event_trans_category_filter = '';
		}
	$cs_trans_albums = get_option( "cs_trans_albums" );
		if ( $cs_trans_albums <> "" ) {
			$sxe = new SimpleXMLElement($cs_trans_albums);
				$release_date = $sxe->release_date;
				$buy_now = $sxe->buy_now;
				$lyrics = $sxe->lyrics;
				$download = $sxe->download;
				$play = $sxe->play;
				$pause = $sxe->pause;
				$amazon = $sxe->amazon;
				$itunes = $sxe->itunes;
				$grooveshark = $sxe->grooveshark;
				$soundcloud = $sxe->soundcloud;
		}
		else {
				$release_date = '';
				$buy_now = '';
				$lyrics = '';
				$download = '';
				$play = '';
				$pause = '';
				$amazon = '';
				$itunes = '';
				$grooveshark = '';
				$soundcloud = '';
		}
	$cs_trans_contact = get_option( "cs_trans_contact" );
		if ( $cs_trans_contact <> "" ) {
			$sxe = new SimpleXMLElement($cs_trans_contact);
				$form_title = $sxe->form_title;
				$contact_no = $sxe->contact_no;
				$message = $sxe->message;
				$captcha = $sxe->captcha;
				$refresh_captcha = $sxe->refresh_captcha;
				$name_error = $sxe->name_error;
				$email_error = $sxe->email_error;
				$contact_no_error = $sxe->contact_no_error;
				$message_error = $sxe->message_error;
				$captcha_error = $sxe->captcha_error;
		}
		else {
				$form_title = '';
				$contact_no = '';
				$message = '';
				$captcha = '';
				$refresh_captcha = '';
				$name_error = '';
				$email_error = '';
				$contact_no_error = '';
				$message_error = '';
				$captcha_error = '';
		}
	$cs_trans_others = get_option( "cs_trans_others" );
		if ( $cs_trans_others <> "" ) {
			$sxe = new SimpleXMLElement($cs_trans_others);
				$title_404 = $sxe->title_404;
				$content_404 = $sxe->content_404;
				$share_this_post = $sxe->share_this_post;
				$featured_post = $sxe->featured_post;
				$follow_us = $sxe->follow_us;
				$follow_us_on = $sxe->follow_us_on;
				$need_an_account = $sxe->need_an_account;
				$newsletter = $sxe->newsletter;
				$newsletter_thanks = $sxe->newsletter_thanks;
		}
		else {
				$title_404 = '';
				$content_404 = '';
				$share_this_post = '';
				$featured_post = '';
				$follow_us = '';
				$follow_us_on = '';
				$need_an_account = '';
				$newsletter = '';
				$newsletter_thanks = '';
		}
?>
<div class="theme-wrap fullwidth">
	<?php include "theme_leftnav.php";?>
    <!-- Right Column Start -->
    <div class="col2 left">
		<!-- Header Start -->
        <div class="wrap-header">
            <h4 class="bold">Translation</h4>
            <div class="clear"></div>
        </div>
        <!-- Header End -->
        <script type="text/javascript">
			function gs_tab(id){
				jQuery("#trans_tab_save"+id).hide();
				jQuery("#trans_tab_loading"+id).show('');
				jQuery.ajax({
					type:'POST', 
					url: '<?php echo get_template_directory_uri()?>/include/translation_save.php', 
					data:jQuery('#frm'+id).serialize(), 
					success: function(response) {
						//jQuery('#frm_slide').get(0).reset();
						jQuery(".form-msgs p").html(response);
						jQuery(".form-msgs").show("");
						jQuery("#trans_tab_save"+id).show('');
						jQuery("#trans_tab_loading"+id).hide();
						slideout();
						//jQuery('#frm_slide').find('.form_result').html(response);
					}
				});
			}
		jQuery().ready(function($) {
			var container = $('div.container');
			// validate the form when it is submitted
			var validator = $("#frm1").validate({
				errorContainer: container,
				errorLabelContainer: $(container),
				errorElement:'span',
				errorClass:'ele-error',				
				meta: "validate"
			});
		});
		jQuery().ready(function($) {
			var container = $('div.container');
			// validate the form when it is submitted
			var validator = $("#frm2").validate({
				errorContainer: container,
				errorLabelContainer: $(container),
				errorElement:'span',
				errorClass:'ele-error',				
				meta: "validate"
			});
		});
		jQuery().ready(function($) {
			var container = $('div.container');
			// validate the form when it is submitted
			var validator = $("#frm3").validate({
				errorContainer: container,
				errorLabelContainer: $(container),
				errorElement:'span',
				errorClass:'ele-error',				
				meta: "validate"
			});
		});
			
		</script>
        <div class="tab-section">
            <div class="tab_menu_container">
                <ul id="tab_menu">
                    <li><a href="#" class="" rel="tab-events"><span>Events</span></a></li>
                    <li><a href="#" class="" rel="tab_albums"><span>Albums</span></a></li>
                    <li><a href="#" class="" rel="tab-contact"><span>Contact</span></a></li>
                    <li><a href="#" class="" rel="tab-others"><span>Others</span></a></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="tab_container">
                <div class="tab_container_in">
					<div class='form-msgs' style="display:none"><div class='to-notif success-box'><span class='tick'>&nbsp;</span><p></p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>
                    
                    <div id="tab-events" class="tab-list">
                        <form id="frm1" method="post" action="javascript:gs_tab(1)">
                            <div class="option-sec">
                                <div class="opt-head">
                                    <h6>Events Translation</h6>
                                    <p>Events Translation</p>
                                    <div id="trans_tab_loading1" class="ajax-loaders">
                                    	<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />
                                    </div>
                                </div>
                                <div class="opt-conts">
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Booking URL</label></li>
                                        <li class="to-field"><input type="text" name="event_trans_booking_url" value="<?php echo htmlspecialchars($event_trans_booking_url)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>All Day</label></li>
                                        <li class="to-field"><input type="text" name="event_trans_all_day" value="<?php echo htmlspecialchars($event_trans_all_day)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Posted By</label></li>
                                        <li class="to-field"><input type="text" name="event_trans_posted_by" value="<?php echo htmlspecialchars($event_trans_posted_by)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Category Filter</label></li>
                                        <li class="to-field"><input type="text" name="event_trans_category_filter" value="<?php echo htmlspecialchars($event_trans_category_filter)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label"></li>
                                        <li class="to-field">
                                           	<input type="hidden" name="tab" value="tab_events" />
                                            <input id="trans_tab_save1" class="submit butnthree" type="submit" value="Save"/>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="tab_albums" class="tab-list">
                        <form id="frm2" method="post" action="javascript:gs_tab(2)">
                            <div class="option-sec">
                                <div class="opt-head">
                                    <h6>Albums Translation</h6>
                                    <p>Albums Translation</p>
                                    <div id="trans_tab_loading2" class="ajax-loaders">
                                    	<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />
                                    </div>
                                </div>
                                <div class="opt-conts">
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Release Date</label></li>
                                        <li class="to-field"><input type="text" name="release_date" value="<?php echo htmlspecialchars($release_date)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Buy Now</label></li>
                                        <li class="to-field"><input type="text" name="buy_now" value="<?php echo htmlspecialchars($buy_now)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Lyrics</label></li>
                                        <li class="to-field"><input type="text" name="lyrics" value="<?php echo htmlspecialchars($lyrics)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Download</label></li>
                                        <li class="to-field"><input type="text" name="download" value="<?php echo htmlspecialchars($download)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Play</label></li>
                                        <li class="to-field"><input type="text" name="play" value="<?php echo htmlspecialchars($play)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Pause</label></li>
                                        <li class="to-field"><input type="text" name="pause" value="<?php echo htmlspecialchars($pause)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Amazon</label></li>
                                        <li class="to-field"><input type="text" name="amazon" value="<?php echo htmlspecialchars($amazon)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>ITunes</label></li>
                                        <li class="to-field"><input type="text" name="itunes" value="<?php echo htmlspecialchars($itunes)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>GrooveShark</label></li>
                                        <li class="to-field"><input type="text" name="grooveshark" value="<?php echo htmlspecialchars($grooveshark)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>SoundCloud</label></li>
                                        <li class="to-field"><input type="text" name="soundcloud" value="<?php echo htmlspecialchars($soundcloud)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label"></li>
                                        <li class="to-field">
                                           	<input type="hidden" name="tab" value="tab_albums" />
                                            <input id="trans_tab_save2" class="submit butnthree" type="submit" value="Save"/>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="tab-contact" class="tab-list"> 
                        <form id="frm3" method="post" action="javascript:gs_tab(3)">
                            <div class="option-sec">
                                <div class="opt-head">
                                    <h6>Contact Translation</h6>
                                    <p>Contact Translation</p>
                                    <div id="trans_tab_loading3" class="ajax-loaders">
                                    	<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />
                                    </div>
                                </div>
                                <div class="opt-conts">
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Form Title</label></li>
                                        <li class="to-field"><input type="text" name="form_title" value="<?php echo htmlspecialchars($form_title)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Contact No.</label></li>
                                        <li class="to-field"><input type="text" name="contact_no" value="<?php echo htmlspecialchars($contact_no)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Message</label></li>
                                        <li class="to-field"><input type="text" name="message" value="<?php echo htmlspecialchars($message)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Captcha</label></li>
                                        <li class="to-field"><input type="text" name="captcha" value="<?php echo htmlspecialchars($captcha)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Refresh Captcha</label></li>
                                        <li class="to-field"><input type="text" name="refresh_captcha" value="<?php echo htmlspecialchars($refresh_captcha)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Name (Error)</label></li>
                                        <li class="to-field"><input type="text" name="name_error" value="<?php echo htmlspecialchars($name_error)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Email (Error)</label></li>
                                        <li class="to-field"><input type="text" name="email_error" value="<?php echo htmlspecialchars($email_error)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Contact No. (Error)</label></li>
                                        <li class="to-field"><input type="text" name="contact_no_error" value="<?php echo htmlspecialchars($contact_no_error)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Message (Error)</label></li>
                                        <li class="to-field"><input type="text" name="message_error" value="<?php echo htmlspecialchars($message_error)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Captcha (Error)</label></li>
                                        <li class="to-field"><input type="text" name="captcha_error" value="<?php echo htmlspecialchars($captcha_error)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label"></li>
                                        <li class="to-field">
                                           	<input type="hidden" name="tab" value="tab_contact" />
                                            <input id="gs_tab_save6" class="submit butnthree" type="submit" value="Save"/>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="tab-others" class="tab-list"> 
                        <form id="frm4" method="post" action="javascript:gs_tab(4)">
                            <div class="option-sec">
                                <div class="opt-head">
                                    <h6>Other Translation</h6>
                                    <p>Other Translation</p>
                                    <div id="trans_tab_loading3" class="ajax-loaders">
                                    	<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />
                                    </div>
                                </div>
                                <div class="opt-conts">
                                    <ul class="form-elements">
                                        <li class="to-label"><label>404 Title</label></li>
                                        <li class="to-field"><input type="text" name="title_404" value="<?php echo htmlspecialchars($title_404)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>404 Content</label></li>
                                        <li class="to-field"><textarea name="content_404"><?php echo $content_404?></textarea></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Share This Post</label></li>
                                        <li class="to-field"><input type="text" name="share_this_post" value="<?php echo htmlspecialchars($share_this_post)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                     <ul class="form-elements">
                                        <li class="to-label"><label>Featured Post</label></li>
                                        <li class="to-field"><input type="text" name="featured_post" value="<?php echo htmlspecialchars($featured_post)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Follow Us</label></li>
                                        <li class="to-field"><input type="text" name="follow_us" value="<?php echo htmlspecialchars($follow_us)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Follow Us on</label></li>
                                        <li class="to-field"><input type="text" name="follow_us_on" value="<?php echo htmlspecialchars($follow_us_on)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Need an Account?</label></li>
                                        <li class="to-field"><input type="text" name="need_an_account" value="<?php echo htmlspecialchars($need_an_account)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Newsletter</label></li>
                                        <li class="to-field"><input type="text" name="newsletter" value="<?php echo htmlspecialchars($newsletter)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Newsletter (Success)</label></li>
                                        <li class="to-field"><input type="text" name="newsletter_thanks" value="<?php echo htmlspecialchars($newsletter_thanks)?>" /></li>
                                        <li class="to-desc"><p></p></li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label"></li>
                                        <li class="to-field">
                                           	<input type="hidden" name="tab" value="tab_others" />
                                            <input id="gs_tab_save6" class="submit butnthree" type="submit" value="Save"/>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="clear"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
    <!-- Right Column End -->
</div>



<?php
}
?>
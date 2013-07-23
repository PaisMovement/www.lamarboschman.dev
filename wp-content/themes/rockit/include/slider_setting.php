<?php
//adding short code start 
/*	function cs_slider_fun ( $atts ) {
		foreach ( $atts as $key=>$val ) {
			echo $key . " = " . $val;
		}
	}
	add_shortcode( 'cs_slider', 'cs_slider_fun' );
*/
//adding short code end

function slider_setting() {
	$cs_sliders_setttings = get_option( "cs_sliders_setttings" );
	if ( $cs_sliders_setttings <> "" ) {
		$xmlObject = new SimpleXMLElement($cs_sliders_setttings);
			$cs_anything_effect = $xmlObject->anything->effect;
			$cs_anything_auto_play = $xmlObject->anything->auto_play;
			$cs_anything_animation_speed = $xmlObject->anything->animation_speed;
			$cs_anything_pause_time= $xmlObject->anything->pause_time;
				$cs_nivo_effect = $xmlObject->nivo->effect;
				$cs_nivo_auto_play = $xmlObject->nivo->auto_play;
				$cs_nivo_animation_speed = $xmlObject->nivo->animation_speed;
				$cs_nivo_pause_time= $xmlObject->nivo->pause_time;
			$cs_sudo_effect = $xmlObject->sudo->effect;
			$cs_sudo_auto_play = $xmlObject->sudo->auto_play;
			$cs_sudo_animation_speed = $xmlObject->sudo->animation_speed;
			$cs_sudo_pause_time= $xmlObject->sudo->pause_time;
	}
?>

<div class="theme-wrap fullwidth">


	<?php include "theme_leftnav.php";?>
        <script type="text/javascript">
		jQuery().ready(function($) {
			var container = $('div.container');
			// validate the form when it is submitted
			var validator = $("#frm").validate({
				errorContainer: container,
				errorLabelContainer: $(container),
				errorElement:'span',
				errorClass:'ele-error',				
				meta: "validate"
			});
		});
    </script>
    <form id="frm" method="" action="javascript:sliders_save()">
    <!-- Right Column Start -->
    <div class="col2 left">
		<!-- Header Start -->
        <div class="wrap-header">
            <h4 class="bold">Slider Managment</h4>
            
            <div class="clear"></div>
        </div>
        <!-- Header End -->
            <!-- Content Section Start -->
	<div class='form-msgs' style="display:none"><div class='to-notif success-box'><span class='tick'>&nbsp;</span><p></p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>
    	<div class="elements-in">
            <div class="option-sec">
                <div class="opt-head">
                    <h6>Choose Slider Type</h6>
                    <p>Slider type Nivo-Slider, Anything-Slider, Sudo-Slider settings</p>
                    <span id="loading_div"></span>
                </div>
                <div class="opt-conts">
                    <ul class="form-elements noborder">
                        <li class="to-label">
                            <label>Choose SliderType</label>
                        </li>
                        <li class="to-field">
                            
                            <select class="dropdown" id="slider_types" name="slider_type" onchange="javascript:show_hide_slider(this.value)">
                                <option></option>
                                <option value="anything_slider">Anything Slider</option>
                                <option value="nivo_slider">Nivo Slider</option>
                                <option value="sudo_slider">Sudo Slider</option>
                            </select>
                        </li>
                        <li class="to-desc">
		                    <p>Please select slider type.</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="elements" id="slider_types">
                <div class="option-sec row" id="anything_slider" style="display:none" >
                    <div class="opt-head">
                        <h6>Anything Slider Options</h6>
                        <p>Configure Anything Slider settings</p>
                    </div>
                    <div class="opt-conts">
                        <ul class="form-elements">
                            <li class="to-label">
                                <label>Effects</label>
                            </li>
                            <li class="to-field">
                                <select class="dropdown" name="cs_anything_effect">
                                    <option <?php if($cs_anything_effect=="Fade"){echo "selected";}?> >Fade</option>
                                    <option <?php if($cs_anything_effect=="Horizontal"){echo "selected";}?> >Horizontal</option>
                                    <option <?php if($cs_anything_effect=="Vertical"){echo "selected";}?> >Vertical</option>
                                </select>
                            </li>
                            <li class="to-desc">
                                <p>
                                    Please select Effect to Anything Slider ('Defult:fade').
                                </p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label">
                                <label>Auto Play</label>
                            </li>
                            <li class="to-field">
                                <div class="on-off">
                                    <input type="checkbox" name="cs_anything_auto_play" value="true" <?php if ( $cs_anything_auto_play == "true" ){ echo "checked";}?> class="styled" />					
                                </div>
                            </li>
                            <li class="to-desc">
                                <p>
                                    If true, the slideshow will start running on page load
                                </p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label">
                                <label>Animation Speed</label>
                            </li>
                            <li class="to-field">
                                <input type="text" name="cs_anything_animation_speed" size="5" class="{validate:{required:true}} bar" value="<?php echo $cs_anything_animation_speed?>" />
                            </li>
                            <li class="to-desc">
                                <p>
                                    How long the slideshow transition takes (in milliseconds)
                                </p>
                            </li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label">
                                <label>Pause Time</label>
                            </li>
                            <li class="to-field">
                                <input type="text" name="cs_anything_pause_time" size="5" class="{validate:{required:true}} bar" value="<?php echo $cs_anything_pause_time?>" />
                            </li>
                            <li class="to-desc">
                                <p>
                                    Resume slideshow after user interaction (in milliseconds)
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="option-sec row" id="nivo_slider" style="display:none" >
                    <div class="opt-head">
                        <h6>Nivo Slider Options</h6>
                        <p>Configure Nivo Slider setting</p>
                    </div>
                    <div class="opt-conts">
                        <ul class="form-elements">
                            <li class="to-label">
                                <label>Effects</label>
                            </li>
                            <li class="to-field">
                                <select class="dropdown" name="cs_nivo_effect">
                                    <option <?php if($cs_nivo_effect=="sliceDown"){echo "selected";}?> >sliceDown</option>
                                    <option <?php if($cs_nivo_effect=="sliceDownLeft"){echo "selected";}?> >sliceDownLeft</option>
                                    <option <?php if($cs_nivo_effect=="sliceUp"){echo "selected";}?> >sliceUp</option>
                                    <option <?php if($cs_nivo_effect=="sliceUpLeft"){echo "selected";}?> >sliceUpLeft</option>
                                    <option <?php if($cs_nivo_effect=="sliceUpDown"){echo "selected";}?> >sliceUpDown</option>
                                    <option <?php if($cs_nivo_effect=="sliceUpDownLeft"){echo "selected";}?> >sliceUpDownLeft</option>
                                    <option <?php if($cs_nivo_effect=="fold"){echo "selected";}?> >fold</option>
                                    <option <?php if($cs_nivo_effect=="fade"){echo "selected";}?> >fade</option>
                                    <option <?php if($cs_nivo_effect=="random"){echo "selected";}?> >random</option>
                                    <option <?php if($cs_nivo_effect=="slideInRight"){echo "selected";}?> >slideInRight</option>
                                    <option <?php if($cs_nivo_effect=="slideInLeft"){echo "selected";}?> >slideInLeft</option>
                                    <option <?php if($cs_nivo_effect=="boxRandom"){echo "selected";}?> >boxRandom</option>
                                    <option <?php if($cs_nivo_effect=="boxRain"){echo "selected";}?> >boxRain</option>
                                    <option <?php if($cs_nivo_effect=="boxRainReverse"){echo "selected";}?> >boxRainReverse</option>
                                    <option <?php if($cs_nivo_effect=="boxRainGrow"){echo "selected";}?> >boxRainGrow</option>
                                    <option <?php if($cs_nivo_effect=="boxRainGrowReverse"){echo "selected";}?> >boxRainGrowReverse</option>
                                </select>
                            </li>
                            <li class="to-desc">
                                <p>
                                    Please select Effect to Anything Slider ('Defult:fade').
                                </p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label">
                                <label>Auto Play</label>
                            </li>
                            <li class="to-field">
                                <div class="on-off">
                                    <input type="checkbox" name="cs_nivo_auto_play" value="true" <?php if ( $cs_nivo_auto_play == "true" ){ echo "checked";}?> class="styled" />					
                                </div>
                            </li>
                            <li class="to-desc">
                                <p>
                                    If true, the slideshow will start running on page load
                                </p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label">
                                <label>Animation Speed</label>
                            </li>
                            <li class="to-field">
                                <input type="text" name="cs_nivo_animation_speed" size="5" class="{validate:{required:true}} bar" value="<?php echo $cs_nivo_animation_speed?>" />
                            </li>
                            <li class="to-desc">
                                <p>
                                    How long the slideshow transition takes (in milliseconds)
                                </p>
                            </li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label">
                                <label>Pause Time</label>
                            </li>
                            <li class="to-field">
                                <input type="text" name="cs_nivo_pause_time" size="5" class="{validate:{required:true}} bar" value="<?php echo $cs_nivo_pause_time?>" />
                            </li>
                            <li class="to-desc">
                                <p>
                                    Resume slideshow after user interaction (in milliseconds)
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="option-sec row" id="sudo_slider" style="display:none" >
                    <div class="opt-head">
                        <h6>Sudo Slider Options</h6>
                        <p>Configure Sudo Slider setting</p>
                    </div>
                    <div class="opt-conts">
                        <ul class="form-elements">
                            <li class="to-label">
                                <label>Effects</label>
                            </li>
                            <li class="to-field">
                                <select class="dropdown" name="cs_sudo_effect">
                                    <option <?php if($cs_sudo_effect=="Fade"){echo "selected";}?> >Fade</option>
                                    <option <?php if($cs_sudo_effect=="Vertical"){echo "selected";}?> >Vertical</option>
                                </select>
                            </li>
                            <li class="to-desc">
                                <p>
                                    Please select Effect to Anything Slider ('Defult:fade').
                                </p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label">
                                <label>Auto Play</label>
                            </li>
                            <li class="to-field">
                                <div class="on-off">
                                    <input type="checkbox" name="cs_sudo_auto_play" value="true" <?php if ( $cs_sudo_auto_play == "true" ){ echo "checked";}?> class="styled" />					
                                </div>
                            </li>
                            <li class="to-desc">
                                <p>
                                    If true, the slideshow will start running on page load
                                </p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label">
                                <label>Animation Speed</label>
                            </li>
                            <li class="to-field">
                                <input type="text" name="cs_sudo_animation_speed" size="5" class="{validate:{required:true}} bar" value="<?php echo $cs_sudo_animation_speed?>" />
                            </li>
                            <li class="to-desc">
                                <p>
                                    How long the slideshow transition takes (in milliseconds)
                                </p>
                            </li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label">
                                <label>Pause Time</label>
                            </li>
                            <li class="to-field">
                                <input type="text" name="cs_sudo_pause_time" size="5" class="{validate:{required:true}} bar" value="<?php echo $cs_sudo_pause_time?>" />
                            </li>
                            <li class="to-desc">
                                <p>
                                    Resume slideshow after user interaction (in milliseconds)
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
		</div>
        <div class="clear"></div>
        <div class="wrap-footer" style="display:none;">
        	<input id="btn_save" class="butnthree right" type="submit" name="submit" value="Save All Sliders" />
            <div class="clear"></div>
        </div>
        <!-- Content Section End -->
        </form>
    </div>
    <div class="clear"></div>
    <!-- Right Column End -->

    <script type="text/javascript">
		function show_hide_slider(id){
			if ( id == "" ){
				jQuery("div#all_tabs").hide();
			}
			else {
				jQuery("div#all_tabs").show('');
			}
			jQuery("div#slider_types > div").hide();
			jQuery("#"+id).show('');
			jQuery(".wrap-footer").show('');
		}
		function sliders_save(){
			$ = jQuery;
			$("#btn_save").hide();
			$("#loading_div").html('<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />');
			$.ajax({
				type:'POST', 
				url: '<?php echo get_template_directory_uri() ?>/include/slider_setting_save.php', 
				data:$('#frm').serialize(), 
				success: function(response) {
					$("#loading_div").html('');
					$("#btn_save").show('');
						$(".form-msgs p").html(response);
						$(".form-msgs").show("");
						slideout();
				}
			})
		}
	</script>
<?php
}
?>
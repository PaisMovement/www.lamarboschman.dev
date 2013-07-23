<?php
function general_options() {
	foreach ($_REQUEST as $keys=>$values) {
		$$keys = trim($values);
	}
$cs_color_scheme = "";
$cs_style_sheet = "";
	$cs_gs_color_style = get_option( "cs_gs_color_style" );
		if ( $cs_gs_color_style <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_color_style);
				$cs_bg = $sxe->cs_bg;
				$cs_bg_position = $sxe->cs_bg_position;
				$cs_bg_repeat = $sxe->cs_bg_repeat;
				$cs_bg_attach = $sxe->cs_bg_attach;
				$cs_bg_pattern = $sxe->cs_bg_pattern;
				$custome_pattern = $sxe->custome_pattern;
				$cs_bg_color = $sxe->cs_bg_color;
				$cs_color_scheme = $sxe->cs_color_scheme;
				$cs_style_sheet = $sxe->cs_style_sheet;
		}
		else {
			$custome_pattern = 'none';
		}
	$cs_gs_logo = get_option( "cs_gs_logo" );
		if ( $cs_gs_logo <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_logo);
				$cs_logo = $sxe->cs_logo;
				$cs_width = $sxe->cs_width;
				$cs_height = $sxe->cs_height;
		}
					if ( $cs_width == "" ) $cs_width = 1;
					if ( $cs_height == "" ) $cs_height = 1;
	$cs_gs_header_script = get_option( "cs_gs_header_script" );
		if ( $cs_gs_header_script <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_header_script);
				$cs_header_code = $sxe->cs_header_code;
				$cs_fav_icon = $sxe->cs_fav_icon;
		}
	$cs_gs_footer_settings = get_option( "cs_gs_footer_settings" );
		if ( $cs_gs_footer_settings <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_footer_settings);
				$cs_footer_logo = $sxe->cs_footer_logo;
				$cs_copyright = $sxe->cs_copyright;
				$cs_powered_by = $sxe->cs_powered_by;
				$cs_powered_icon = $sxe->cs_powered_icon;
				$cs_analytics = $sxe->cs_analytics;
		}
	$cs_gs_captcha = get_option( "cs_gs_captcha" );
		$captcha = "";
			if ( $cs_gs_captcha <> "" ) {
				$sxe = new SimpleXMLElement($cs_gs_captcha);
					$captcha = $sxe->captcha;
			}
	$cs_gs_other_setting = get_option( "cs_gs_other_setting" );
			$responsive = "";
			$rtl = "";
			$transwitch = "";
 			
			if ( $cs_gs_other_setting <> "" ) {
				$sxe = new SimpleXMLElement($cs_gs_other_setting);
				$responsive = $sxe->cs_responsive;
				$rtl = $sxe->cs_rtl;
				$transwitch = $sxe->cs_transwitch;
			}
?>

<div class="theme-wrap fullwidth">


	<?php include "theme_leftnav.php";?>
    <!-- Right Column Start -->
    <div class="col2 left">
		<!-- Header Start -->
        <div class="wrap-header">
            <h4 class="bold">General Settings</h4>
            
            <div class="clear"></div>
        </div>

        <!-- Header End -->
        <script type="text/javascript">
			jQuery(function($) {
				$( "#width-slider" ).slider({
					range: "min",
					value: <?php echo $cs_width;?>,
					min: 1,
					max: 400,
					slide: function( event, ui ) {
					$( "#width-value" ).val( ui.value);
					}
				});
				$( "#width-value" ).val($( "#width-slider" ).slider( "value" ));
			});
			
			jQuery(function($) {
				$( "#height-slider" ).slider({
					range: "min",
					value: <?php echo $cs_height;?>,
					min: 1,
					max: 400,
					slide: function( event, ui ) {
					$( "#height-value" ).val( ui.value);
					}
				});
				$( "#height-value" ).val($( "#height-slider" ).slider( "value" ));
			});
				
			function gs_tab(id){
				var $ = jQuery;
				$("#gs_tab_save"+id).hide();
				$("#gs_tab_loading"+id).show('');
				$.ajax({
					type:'POST', 
					url: '<?php echo get_template_directory_uri()?>/include/general_options_save.php', 
					data:$('#frm'+id).serialize(), 
					success: function(response) {
						//$('#frm_slide').get(0).reset();
						$(".form-msgs p").html(response);
						$(".form-msgs").show("");
						$("#gs_tab_save"+id).show('');
						$("#gs_tab_loading"+id).hide();
						slideout();
						//$('#frm_slide').find('.form_result').html(response);
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
		jQuery().ready(function($) {
			var container = $('div.container');
			// validate the form when it is submitted
			var validator = $("#frm4").validate({
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
			var validator = $("#frm5").validate({
				errorContainer: container,
				errorLabelContainer: $(container),
				errorElement:'span',
				errorClass:'ele-error',				
				meta: "validate"
			});
		});
		
        jQuery(document).ready( function($) {
            var consoleTimeout;
            $('.minicolors').each( function() {
                $(this).minicolors({
                    change: function(hex, opacity) {
                        // Generate text to show in console
                        text = hex ? hex : 'transparent';
                        if( opacity ) text += ', ' + opacity;
                        text += ' / ' + $(this).minicolors('rgbaString');
                    }
                });
            });
        });
		</script>

        <div class="tab-section">
            <div class="tab_menu_container">
                <ul id="tab_menu">  
                    <li><a href="#colorstyle" class="current" rel="tab-color"><span>Color and Style</span></a></li>
                    <li><a href="#logo" class="" rel="tab-logo"><span>Logo</span></a></li>
                    <li><a href="#headscript" class="" rel="tab-head-scripts"><span>Header Scripts</span></a></li>
                    <li><a href="#footersetting" class="" rel="tab-foot-setting"><span>Footer Settings</span></a></li>
                    <li><a href="#captcha-settings" class="" rel="tab-captcha"><span>Captcha Settings</span></a></li>
                    <li><a href="#other" class="" rel="tab-other"><span>Other Setting</span></a></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="tab_container">
                <div class="tab_container_in">
					<div class='form-msgs' style="display:none"><div class='to-notif success-box'><span class='tick'>&nbsp;</span><p></p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>
                    <!-- Color And Style Start -->
                    <div id="tab-color" class="tab-list">
                        <div class="elements">
                        	<form id="frm1" method="post" action="javascript:gs_tab(1)">
                                <div class="option-sec">
                                    <div class="opt-head">
                                        <h6>Color And Styles</h6>
                                        <p>Theme color scheme and styling setting.</p>
                                        <div id="gs_tab_loading1" class="ajax-loaders">
                                        	<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />
                                        </div>
                                    </div>
                                    <div class="opt-conts">
                                        <ul class="form-elements">
                                            <li class="to-label">
                                                <label>Select Stylesheet</label>
                                            </li>
                                            <li class="to-field">
                                                <select name="cs_style_sheet" onchange="hide_custom_color_scheme(this.value)">
                                                    <option value="">Default Color Scheme</option>
                                                    <?php 
                                                    foreach (glob(TEMPLATEPATH."/css/custom_styles/*.css") as $filename) {
                                                    //echo "$filename size " . filesize($filename) . "\n";
                                                    $vals = str_replace(TEMPLATEPATH."/css/custom_styles/","",$filename);
                                                    $vals = str_replace(".css","",$vals);
                                                    ?>
                                                    <option value="<?php echo $vals;?>" <?php if ($cs_style_sheet==$vals){echo "selected";}?> ><?php echo ucfirst($vals);?></option>
                                                    <?php } ?>
                                                    <option value="custom" <?php if ($cs_style_sheet=="custom"){echo "selected";}?> > -- Custom Color Scheme -- </option>
                                                </select>
                                            </li>
                                            <li class="to-desc"><p>Please select stylesheet(color scheme) from dropdown.</p></li>
                                            <div class="wpcolor-picker form-elements noborder" id="cs_color_scheme" <?php if($cs_style_sheet<>"custom")echo 'style="display:none"'?> >
                                                <li class="to-label"><label>Color Scheme</label></li>
                                                <li class="to-field"><input type="text" name="cs_color_scheme" value="<?php echo $cs_color_scheme?>" class="minicolors" size="7" /></li>
                                                <li class="to-desc"><p>Pick a custom color for Scheme of the theme e.g. #697e09</p></li>
                                            </div>
                                        </ul>
                                        <ul class="form-elements">
                                            <li class="to-label">
                                                <label>Background Image</label>
                                            </li>
                                            <li class="to-field">
                                                <input id="cs_bg" name="cs_bg" value="<?php echo $cs_bg; ?>" type="text" class="{validate:{accept:'jpg|jpeg|gif|png|bmp'}}" size="36" />
                                                <input id="cs_bg" name="cs_bg" type="button" class="uploadfile left" value="Browse"/>
                                            </li>
                                            <li class="to-desc">
                                            	<div class="logo-thumb">
                                                    <img id="cs_bg_img" width="150" height="150" src="<?php echo $cs_bg?>" />
                                                    <a data-id="cs_bg_img" href="javascript:remove_logo('cs_bg')" class="closethumb">&nbsp;</a>
                                                 </div>
                                            </li>
                                            <div class="wpcolor-picker form-elements noborder">
                                                <li class="to-label"><label>Position</label></li>
                                                <li class="to-field">
                                                	<input type="radio" name="cs_bg_position" value="left" <?php if($cs_bg_position=="left")echo "checked"?> /> Left &nbsp; 
                                                	<input type="radio" name="cs_bg_position" value="center" <?php if($cs_bg_position=="center")echo "checked"?> /> Center &nbsp; 
                                                	<input type="radio" name="cs_bg_position" value="right" <?php if($cs_bg_position=="right")echo "checked"?> /> Right &nbsp; 
                                                </li>
                                                <li class="to-desc"><p></p></li>
                                            </div>
                                            <div class="wpcolor-picker form-elements noborder">
                                                <li class="to-label"><label>Repeat</label></li>
                                                <li class="to-field">
                                                	<input type="radio" name="cs_bg_repeat" value="no-repeat" <?php if($cs_bg_repeat=="no-repeat")echo "checked"?> /> No Repeat
                                                	<input type="radio" name="cs_bg_repeat" value="repeat" <?php if($cs_bg_repeat=="repeat")echo "checked"?> /> Tile
                                                	<input type="radio" name="cs_bg_repeat" value="repeat-x" <?php if($cs_bg_repeat=="repeat-x")echo "checked"?> /> Tile Horizontally
                                                	<input type="radio" name="cs_bg_repeat" value="repeat-y" <?php if($cs_bg_repeat=="repeat-y")echo "checked"?> /> Tile Vertically
                                                </li>
                                                <li class="to-desc"><p></p></li>
                                            </div>
                                            <div class="wpcolor-picker form-elements noborder">
                                                <li class="to-label"><label>Attachment</label></li>
                                                <li class="to-field">
                                                	<input type="radio" name="cs_bg_attach" value="scroll" <?php if($cs_bg_attach=="scroll")echo "checked"?> /> Scroll &nbsp; 
                                                	<input type="radio" name="cs_bg_attach" value="fixed" <?php if($cs_bg_attach=="fixed")echo "checked"?> /> Fixed &nbsp; 
                                                </li>
                                                <li class="to-desc"><p></p></li>
                                            </div>
                                        </ul>
                                        <ul class="form-elements">
                                            <li class="to-label">
                                                <label>Background Pattern</label>
                                            </li>
                                            <li class="to-field">
                                                    <div class="meta-input pattern">
                                                        <div class='radio-image-wrapper'>
                                                            <input <?php if($custome_pattern=="")echo "checked"?> onclick="select_pattern()" type="radio" name="custome_pattern" class="radio" value="" />
                                                            <label for="radio_0">
                                                                <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/pattern/none.png" /></span>
                                                                <span <?php if($custome_pattern=="")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/pattern/tick.png" /></span>
                                                            </label>
                                                        </div>
														<div class='radio-image-wrapper'>
                                                            <input <?php if($custome_pattern=="pattern1")echo "checked"?> onclick="select_pattern()" type="radio" name="custome_pattern" class="radio" value="pattern1" />
                                                            <label for="radio_1">
                                                                <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/pattern/pattern1.png" /></span>
                                                                <span <?php if($custome_pattern=="pattern1")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/pattern/tick.png" /></span>
                                                            </label>
                                                        </div>
                                                        <div class='radio-image-wrapper'>
                                                            <input <?php if($custome_pattern=="pattern2")echo "checked"?> onclick="select_pattern()" type="radio" name="custome_pattern" class="radio" value="pattern2" />
                                                            <label for="radio_2">
                                                                <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/pattern/pattern2.png" /></span>
                                                                <span <?php if($custome_pattern=="pattern2")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/pattern/tick.png" /></span>
                                                            </label>
                                                        </div>
                                                        <div class='radio-image-wrapper'>
                                                            <input <?php if($custome_pattern=="pattern3")echo "checked"?> onclick="select_pattern()" type="radio" name="custome_pattern" class="radio" value="pattern3" />
                                                            <label for="radio_3">
                                                                <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/pattern/pattern3.png" /></span>
                                                                <span <?php if($custome_pattern=="pattern3")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/pattern/tick.png" /></span>
                                                            </label>
                                                        </div>
                                                        <div class='radio-image-wrapper'>
                                                            <input <?php if($custome_pattern=="pattern4")echo "checked"?> onclick="select_pattern()" type="radio" name="custome_pattern" class="radio" value="pattern4" />
                                                            <label for="radio_4">
                                                                <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/pattern/pattern4.png" /></span>
                                                                <span <?php if($custome_pattern=="pattern4")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/pattern/tick.png" /></span>
                                                            </label>
                                                        </div>
                                                        <div class='radio-image-wrapper'>
                                                            <input <?php if($custome_pattern=="pattern5")echo "checked"?> onclick="select_pattern()" type="radio" name="custome_pattern" class="radio" value="pattern5" />
                                                            <label for="radio_5">
                                                                <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/pattern/pattern5.png" /></span>
                                                                <span <?php if($custome_pattern=="pattern5")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/pattern/tick.png" /></span>
                                                            </label>
                                                        </div>
                                                        <div class='radio-image-wrapper'>
                                                            <input <?php if($custome_pattern=="pattern6")echo "checked"?> onclick="select_pattern()" type="radio" name="custome_pattern" class="radio" value="pattern6" />
                                                            <label for="radio_6">
                                                                <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/pattern/pattern6.png" /></span>
                                                                <span <?php if($custome_pattern=="pattern6")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/pattern/tick.png" /></span>
                                                            </label>
                                                        </div>
                                                        <div class='radio-image-wrapper'>
                                                            <input <?php if($custome_pattern=="pattern7")echo "checked"?> onclick="select_pattern()" type="radio" name="custome_pattern" class="radio" value="pattern7" />
                                                            <label for="radio_7">
                                                                <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/pattern/pattern7.png" /></span>
                                                                <span <?php if($custome_pattern=="pattern7")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/pattern/tick.png" /></span>
                                                            </label>
                                                        </div>
                                                        <div class='radio-image-wrapper'>
                                                            <input <?php if($custome_pattern=="pattern8")echo "checked"?> onclick="select_pattern()" type="radio" name="custome_pattern" class="radio" value="pattern8" />
                                                            <label for="radio_8">
                                                                <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/pattern/pattern8.png" /></span>
                                                                <span <?php if($custome_pattern=="pattern8")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/pattern/tick.png" /></span>
                                                            </label>
                                                        </div>
                                                        <div class='radio-image-wrapper'>
                                                            <input <?php if($custome_pattern=="pattern9")echo "checked"?> onclick="select_pattern()" type="radio" name="custome_pattern" class="radio" value="pattern9" />
                                                            <label for="radio_9">
                                                                <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/pattern/pattern9.png" /></span>
                                                                <span <?php if($custome_pattern=="pattern9")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/pattern/tick.png" /></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                <input id="cs_bg_pattern" name="cs_bg_pattern" value="<?php echo $cs_bg_pattern; ?>" type="text" class="{validate:{accept:'jpg|jpeg|gif|png|bmp'}}" size="36" />
                                                <input id="cs_bg_pattern" name="cs_bg_pattern" type="button" class="uploadfile left" value="Browse"/>
                                            </li>
                                            <li class="to-desc">
	                                            <div class="logo-thumb bg_pattern_img">
                                                    <img id="cs_bg_pattern_img" width="150" height="150" src="<?php echo $cs_bg_pattern;?>" />
                                                    <a data-id="cs_bg" href="javascript:remove_logo('cs_bg_pattern')" class="closethumb">&nbsp;</a>
                                                </div>
                                            </li>
                                        </ul>
                                        <ul class="form-elements">
                                            <div class="wpcolor-picker form-elements noborder">
                                                <li class="to-label"><label>Background Color</label></li>
                                                <li class="to-field"><input type="text" name="cs_bg_color" value="<?php echo $cs_bg_color?>" class="minicolors" size="7" /></li>
                                                <li class="to-desc"><p></p></li>
                                            </div>
                                        </ul>
                                        <ul class="form-elements noborder">
                                            <li class="to-label"></li>
                                            <li class="to-field">
                                            	<input type="hidden" name="tab" value="color_style" />
                                                <input id="gs_tab_save1" class="submit butnthree" type="submit" value="Save"/>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Color And Style End -->
                    <!-- Logo Tabs -->
                    <div id="tab-logo" class="tab-list">
                        <form id="frm2" method="post" action="javascript:gs_tab(2)">
                            <div class="option-sec">
                                <div class="opt-head">
                                    <h6>Logo Settings</h6>
                                    <p>Add your company logo adjust image Width, Height.</p>
                                    <div id="gs_tab_loading2" class="ajax-loaders">
                                    	<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />
                                    </div>
                                </div>
                                <div class="opt-conts">
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Upload Logo</label>
                                        </li>
                                        <li class="to-field">
                                    		<input id="cs_logo" name="cs_logo" value="<?php echo $cs_logo?>" type="text" class="{validate:{accept:'jpg|jpeg|gif|png|bmp'}}" size="36" />
                                            <input id="cs_log" name="cs_logo" type="button" class="uploadfile left" value="Browse"/>
                                        </li>
                                        <li class="to-desc">
                                            <div class="logo-thumb">
                                                <img id="cs_logo_img" width="<?php echo $cs_width?>" height="<?php echo $cs_height?>" src="<?php echo $cs_logo?>" />
                                                <a href="javascript:remove_logo('cs_logo')" class="closethumb">&nbsp;</a>
                                            </div>
                                        </li>
                                    </ul>	
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Width</label>
                                        </li>
                                        <li class="to-field">
                                            <div class="slide-range">
                                                <div class="slidebar">
                                                    <div id="width-slider"></div>
                                                </div>
                                            </div>
                                            <div class="valueinput">
                                                <input type="text" name="cs_width" id="width-value" value="<?php echo $cs_width?>" style="border:0; color:#f6931f; font-weight:bold;" />
                                                <span>px</span>
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Please scroll left to right to increase the width of logo, Right to left decrease the logo width.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Height</label>
                                        </li>
                                        <li class="to-field">
                                            <div class="slide-range">
                                                <div class="slidebar">
                                                    <div id="height-slider"></div>
                                                </div>
                                            </div>
                                            <div class="valueinput">
                                                <input type="text" name="cs_height" id="height-value" value="<?php echo $cs_height?>" style="border:0; color:#f6931f; font-weight:bold;" />
                                                <span>px</span>
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <p>
												Please scroll left to right to increase the Height of Logo, Right to left decrease the logo Height.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label">
                                            
                                        </li>
                                        <li class="to-field">
                                           	<input type="hidden" name="tab" value="logo" />
                                            <input id="gs_tab_save2" class="submit butnthree" type="submit" value="Save" onclick="update_logo('cs_logo')" />
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Logo Tabs End -->
                    <!-- Header Script -->
                    <div id="tab-head-scripts" class="tab-list">
                        <form id="frm3" method="post" action="javascript:gs_tab(3)">
                            <div class="option-sec">
                                <div class="opt-head">
                                    <h6>Header Scripts</h6>
                                    <p>Paste your Html or Css Code here.</p>
                                    <div id="gs_tab_loading3" class="ajax-loaders">
                                    	<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />
                                    </div>
                                </div>
                                <div class="opt-conts">
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>FAV Icon</label>
                                        </li>
                                        <li class="to-field">
                                        	<input id="cs_fav_icon" name="cs_fav_icon" value="<?php echo $cs_fav_icon?>" type="text" size="36" class="{validate:{accept:'ico|png'}}" />
                                            <input id="cs_fav_icon" name="cs_fav_icon" type="button" class="uploadfile left" value="Browse" />
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                            	Browse a small fav icon, only .ICO or .PNG format allowed. 
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Header Code</label>
                                        </li>
                                        <li class="to-field">
                                            <textarea rows="" cols="" name="cs_header_code"><?php echo $cs_header_code?></textarea>
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Paste your Html or Css Code here.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label">
                                            
                                        </li>
                                        <li class="to-field">
                                           	<input type="hidden" name="tab" value="header_script" />
                                            <input id="gs_tab_save3" class="submit butnthree" type="submit" value="Save"/>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Header Script End -->
                    <!-- Footer Settings -->
                    <div id="tab-foot-setting" class="tab-list">
                        <form id="frm4" method="post" action="javascript:gs_tab(4)">
                            <div class="option-sec">
                                <div class="opt-head">
                                    <h6>Footer Settings</h6>
                                    <p>Add footer setting detail.</p>
                                    <div id="gs_tab_loading4" class="ajax-loaders">
                                    	<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />
                                    </div>
                                </div>
                                <div class="opt-conts">
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Footer Logo</label>
                                        </li>
                                        <li class="to-field">
                                        	<input id="cs_footer_logo" name="cs_footer_logo" value="<?php echo $cs_footer_logo?>" type="text" size="36" class="{validate:{accept:'jpg|jpeg|gif|png|bmp'}}" />
                                            <input id="cs_footer_log" name="cs_footer_logo" type="button" class="uploadfile left" value="Browse" />
                                        </li>
                                        <li class="to-desc">
                                            <p>Browse a small logo for footer only .JPG, JPEG, PNG, GIF .BMP allowed.</p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Custom Copyright</label>
                                        </li>
                                        <li class="to-field">
                                            <textarea rows="2" cols="4" name="cs_copyright"><?php echo $cs_copyright?></textarea>
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Write Custom Copyright text.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Powered By Text</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="cs_powered_by" value="<?php echo htmlspecialchars($cs_powered_by)?>" />
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Please enter powered by text.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Powered By Icon</label>
                                        </li>
                                        <li class="to-field">
                                            <input id="cs_powered_icon" name="cs_powered_icon" value="<?php echo $cs_powered_icon?>" type="text" size="36" class="{validate:{accept:'jpg|jpeg|gif|png|bmp'}}"/>
                                            <input id="cs_powered_ico" name="cs_powered_icon" type="button" class="uploadfile left" value="Browse"/>
                                        </li>
                                        <li class="to-desc">
                                            <p>
	                                            Please upload or paste link of image to use in powered by Icon only .JPG, JPEG, PNG, GIF .BMP allowed.
                                            </p>
                                        </li>                                                 
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Analytics Code</label>
                                        </li>
                                        <li class="to-field">
                                            <textarea rows="" cols="" name="cs_analytics"><?php echo $cs_analytics?></textarea>
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Paste your Google Analytics (or other) tracking code here.<br /> This will be added into the footer template of your theme.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label">
                                            
                                        </li>
                                        <li class="to-field">
                                           	<input type="hidden" name="tab" value="footer_settings" />
                                            <input id="gs_tab_save4" class="submit butnthree" type="submit" value="Save"/>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Footer Settings End -->
                    <div id="tab-captcha" class="tab-list"> 
                        <form id="frm5" method="post" action="javascript:gs_tab(5)">
                            <div class="option-sec">
                                <div class="opt-head">
                                    <h6>Captcha Setting</h6>
                                    <p>Captcha Setting</p>
                                    <div id="gs_tab_loading5" class="ajax-loaders">
                                    	<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />
                                    </div>
                                </div>
                                <div class="opt-conts">
                                	<ul class="form-elements">
                                        <li class="to-label">
                                            <label>Captcha</label>
                                        </li>
                                        <li class="to-field">
                                            <div class="on-off">
                                            	<input type="checkbox" name="captcha" class="styled" <?php if($captcha=="on") echo "checked" ?> />
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <p>Make the Captcha On/Off</p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label">
                                            
                                        </li>
                                        <li class="to-field">
                                           	<input type="hidden" name="tab" value="captcha" />
                                            <input id="gs_tab_save5" class="submit butnthree" type="submit" value="Save"/>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div id="tab-other" class="tab-list"> 
                        <form id="frm6" method="post" action="javascript:gs_tab(6)">
                            <div class="option-sec">
                                <div class="opt-head">
                                    <h6>Other Setting</h6>
                                     <div id="gs_tab_loading5" class="ajax-loaders">
                                    	<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />
                                    </div>
                                </div>
                                <div class="opt-conts">
                                	<ul class="form-elements">
                                        <li class="to-label">
                                            <label>Responsive On / Off</label>
                                        </li>
                                        <li class="to-field">
                                            <div class="on-off">
                                            	<input type="checkbox" name="responsive" class="styled" <?php if($responsive=="on") echo "checked" ?> />
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <p>Set the responsive On/Off</p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>RTL On / Off</label>
                                        </li>
                                        <li class="to-field">
                                            <div class="on-off">
                                            	<input type="checkbox" name="rtl" class="styled" <?php if($rtl=="on") echo "checked" ?> />
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <p>Set the RTL On/Off</p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Translation Switcher </label>
                                        </li>
                                        <li class="to-field">
                                            <div class="on-off">
                                            	<input type="checkbox" name="transwitch" class="styled" <?php if($transwitch=="on") echo "checked" ?> />
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <p>Set the translation switcher </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label">
                                        </li>
                                        <li class="to-field">
                                           	<input type="hidden" name="tab" value="tab_other" />
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
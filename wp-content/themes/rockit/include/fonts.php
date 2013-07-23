<?php
function fonts() {
	$cs_fonts = get_option('cs_font_settings');
	$g_fonts = get_google_fonts();
?>
	<script type="text/javascript">
        function frm_submit(){
            $ = jQuery;
            $("#submit_btn").hide();
            $("#loading_div").html('<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />');
            $.ajax({
                type:'POST', 
                url: '<?php echo get_template_directory_uri()?>/include/fonts_save.php',
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
    
        jQuery(function($) {
            $( ".h1_size" ).slider({
                range: "min",
                value: <?php echo $cs_fonts['h1_size']?>,
                min: 9,
                max: 72,
                slide: function( event, ui ) {
                $( "#h1_size" ).val( ui.value);
                }
            });
            $( "#h1_size" ).val($( ".h1_size" ).slider( "value" ));
        });
        jQuery(function($) {
            $( ".h2_size" ).slider({
                range: "min",
                value: <?php echo $cs_fonts['h2_size']?>,
                min: 9,
                max: 72,
                slide: function( event, ui ) {
                $( "#h2_size" ).val( ui.value);
                }
            });
            $( "#h2_size" ).val($( ".h2_size" ).slider( "value" ));
        });
        jQuery(function($) {
            $( ".h3_size" ).slider({
                range: "min",
                value: <?php echo $cs_fonts['h3_size']?>,
                min: 9,
                max: 72,
                slide: function( event, ui ) {
                $( "#h3_size" ).val( ui.value);
                }
            });
            $( "#h3_size" ).val($( ".h3_size" ).slider( "value" ));
        });
        jQuery(function($) {
            $( ".h4_size" ).slider({
                range: "min",
                value: <?php echo $cs_fonts['h4_size']?>,
                min: 9,
                max: 72,
                slide: function( event, ui ) {
                $( "#h4_size" ).val( ui.value);
                }
            });
            $( "#h4_size" ).val($( ".h4_size" ).slider( "value" ));
        });
        jQuery(function($) {
            $( ".h5_size" ).slider({
                range: "min",
                value: <?php echo $cs_fonts['h5_size']?>,
                min: 9,
                max: 72,
                slide: function( event, ui ) {
                $( "#h5_size" ).val( ui.value);
                }
            });
            $( "#h5_size" ).val($( ".h5_size" ).slider( "value" ));
        });
        jQuery(function($) {
            $( ".h6_size" ).slider({
                range: "min",
                value: <?php echo $cs_fonts['h6_size']?>,
                min: 9,
                max: 72,
                slide: function( event, ui ) {
                $( "#h6_size" ).val( ui.value);
                }
            });
            $( "#h6_size" ).val($( ".h6_size" ).slider( "value" ));
        });
        jQuery(function($) {
            $( ".content_size" ).slider({
                range: "min",
                value: <?php echo $cs_fonts['content_size']?>,
                min: 9,
                max: 72,
                slide: function( event, ui ) {
                $( "#content_size" ).val( ui.value);
                }
            });
            $( "#content_size" ).val($( ".content_size" ).slider( "value" ));
        });
    
	</script>

<div class="theme-wrap fullwidth">
	<?php include "theme_leftnav.php";?>
    <!-- Right Column Start -->
    <div class="col2 left">
		<!-- Header Start -->
        <div class="wrap-header">
            <h4 class="bold">Fonts Settings</h4>
            <div class="clear"></div>
        </div>
        <!-- Header End -->
        <!-- Content Section Start -->
        <div class="tab-section">
            <div class="tab_menu_container">
                <ul id="tab_menu">  
                    <li><a href="#chooselang" class="current" rel="tab-fonts"><span>Fonts Settings</span></a></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="tab_container">
            	<div class='form-msgs' style="display:none"><div class='to-notif success-box'><span class='tick'>&nbsp;</span><p></p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>
                <div class="tab_container_in">
                    <!-- social network Start -->
                    <div id="tab-fonts" class="tab-list">
                        <div class="option-sec">
                        	<form id="frm" method="post" action="javascript:frm_submit()">
                            <div class="opt-head">
                                <h6>Fonts Settings</h6>
                                <p>Fonts Settings</p>
                            </div>
                            <div class="opt-conts">
                                <ul class="form-elements">
                                    <li class="to-label"><label>H1 Size</label></li>
                                    <li class="to-field">
                                        <div class="slide-range">
                                            <div class="slidebar">
                                                <div class="h1_size"></div>
                                            </div>
                                        </div>
                                        <div class="valueinput">
                                            <input type="text" name="h1_size" id="h1_size" value="<?php echo $cs_fonts['h1_size']?>" readonly="readonly" />
                                            <span>px</span>
                                        </div>
                                        <select name="h1_g_font">  
                                            <option value="">-- Default Font --</option>
                                            <?php foreach( $g_fonts as $key => $font ): ?>
	                                            <option <?php if($cs_fonts['h1_g_font']==$font){echo "selected";}?>><?php echo $font; ?></option>
                                            <?php endforeach; ?>  
                                        </select>
                                    </li>
                                    <li class="to-desc"><p>Please scroll left to right to increase size of the font, Right to left decrease the size.</p></li>
                                </ul>
                                <ul class="form-elements">
                                    <li class="to-label"><label>H2 Size</label></li>
                                    <li class="to-field">
                                        <div class="slide-range">
                                            <div class="slidebar">
                                                <div class="h2_size"></div>
                                            </div>
                                        </div>
                                        <div class="valueinput">
                                            <input type="text" name="h2_size" id="h2_size" value="<?php echo $cs_fonts['h2_size']?>" readonly="readonly" />
                                            <span>px</span>
                                        </div>
                                        <select name="h2_g_font">  
                                            <option value="">-- Default Font --</option>
                                            <?php foreach( $g_fonts as $key => $font ): ?>
	                                            <option <?php if($cs_fonts['h2_g_font']==$font){echo "selected";}?>><?php echo $font; ?></option>
                                            <?php endforeach; ?>  
                                        </select>
                                    </li>
                                    <li class="to-desc"><p>Please scroll left to right to increase size of the font, Right to left decrease the size.</p></li>
                                </ul>
                                <ul class="form-elements">
                                    <li class="to-label"><label>H3 Size</label></li>
                                    <li class="to-field">
                                        <div class="slide-range">
                                            <div class="slidebar">
                                                <div class="h3_size"></div>
                                            </div>
                                        </div>
                                        <div class="valueinput">
                                            <input type="text" name="h3_size" id="h3_size" value="<?php echo $cs_fonts['h3_size']?>" readonly="readonly" />
                                            <span>px</span>
                                        </div>
                                        <select name="h3_g_font">  
                                            <option value="">-- Default Font --</option>
                                            <?php foreach( $g_fonts as $key => $font ): ?>
	                                            <option <?php if($cs_fonts['h3_g_font']==$font){echo "selected";}?>><?php echo $font; ?></option>
                                            <?php endforeach; ?>  
                                        </select>
                                    </li>
                                    <li class="to-desc"><p>Please scroll left to right to increase size of the font, Right to left decrease the size.</p></li>
                                </ul>
                                <ul class="form-elements">
                                    <li class="to-label"><label>H4 Size</label></li>
                                    <li class="to-field">
                                        <div class="slide-range">
                                            <div class="slidebar">
                                                <div class="h4_size"></div>
                                            </div>
                                        </div>
                                        <div class="valueinput">
                                            <input type="text" name="h4_size" id="h4_size" value="<?php echo $cs_fonts['h4_size']?>" readonly="readonly" />
                                            <span>px</span>
                                        </div>
                                        <select name="h4_g_font">  
                                            <option value="">-- Default Font --</option>
                                            <?php foreach( $g_fonts as $key => $font ): ?>
	                                            <option <?php if($cs_fonts['h4_g_font']==$font){echo "selected";}?>><?php echo $font; ?></option>
                                            <?php endforeach; ?>  
                                        </select>
                                    </li>
                                    <li class="to-desc"><p>Please scroll left to right to increase size of the font, Right to left decrease the size.</p></li>
                                </ul>
                                <ul class="form-elements">
                                    <li class="to-label"><label>H5 Size</label></li>
                                    <li class="to-field">
                                        <div class="slide-range">
                                            <div class="slidebar">
                                                <div class="h5_size"></div>
                                            </div>
                                        </div>
                                        <div class="valueinput">
                                            <input type="text" name="h5_size" id="h5_size" value="<?php echo $cs_fonts['h5_size']?>" readonly="readonly" />
                                            <span>px</span>
                                        </div>
                                        <select name="h5_g_font">  
                                            <option value="">-- Default Font --</option>
                                            <?php foreach( $g_fonts as $key => $font ): ?>
	                                            <option <?php if($cs_fonts['h5_g_font']==$font){echo "selected";}?>><?php echo $font; ?></option>
                                            <?php endforeach; ?>  
                                        </select>
                                    </li>
                                    <li class="to-desc"><p>Please scroll left to right to increase size of the font, Right to left decrease the size.</p></li>
                                </ul>
                                <ul class="form-elements">
                                    <li class="to-label"><label>H6 Size</label></li>
                                    <li class="to-field">
                                        <div class="slide-range">
                                            <div class="slidebar">
                                                <div class="h6_size"></div>
                                            </div>
                                        </div>
                                        <div class="valueinput">
                                            <input type="text" name="h6_size" id="h6_size" value="<?php echo $cs_fonts['h6_size']?>" readonly="readonly" />
                                            <span>px</span>
                                        </div>
                                        <select name="h6_g_font">
                                            <option value="">-- Default Font --</option>
                                            <?php foreach( $g_fonts as $key => $font ): ?>
	                                            <option <?php if($cs_fonts['h6_g_font']==$font){echo "selected";}?>><?php echo $font; ?></option>
                                            <?php endforeach; ?>  
                                        </select>
                                    </li>
                                    <li class="to-desc"><p>Please scroll left to right to increase size of the font, Right to left decrease the size.</p></li>
                                </ul>
                                <ul class="form-elements">
                                    <li class="to-label"><label>Content Text Size</label></li>
                                    <li class="to-field">

                                        <div class="slide-range">
                                            <div class="slidebar">
                                                <div class="content_size"></div>
                                            </div>
                                        </div>
                                        <div class="valueinput">
                                            <input type="text" name="content_size" id="content_size" value="<?php echo $cs_fonts['content_size']?>" readonly="readonly" />
                                            <span>px</span>
                                        </div>
                                        <select name="content_size_g_font">  
                                            <option value="">-- Default Font --</option>
                                            <?php foreach( $g_fonts as $key => $font ): ?>
	                                            <option <?php if($cs_fonts['content_size_g_font']==$font){echo "selected";}?>><?php echo $font; ?></option>
                                            <?php endforeach; ?>  
                                        </select>
                                    </li>
                                    <li class="to-desc"><p>Please scroll left to right to increase size of the font, Right to left decrease the size.</p></li>
                                </ul>
                                
                                
                                <ul class="form-elements noborder">
                                    <li class="to-label"></li>
                                    <li class="to-field"><input id="submit_btn" type="submit" value="Save" /><div id="loading_div"></div></li>
                                </ul>
                            </div>
                        </form>
                        </div>
                    </div>
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
	add_action( 'wp_head', 'cs_font_head' );
	function cs_font_head() {
		$cs_fonts = get_option('cs_font_settings');
			if ( isset($cs_fonts['h1_size']) ) echo '<style> h1{ font-size:'.$cs_fonts['h1_size'].'px !important; } </style>';
			if ( isset($cs_fonts['h1_g_font']) and $cs_fonts['h1_g_font'] <> "" ) {
				echo '<style>';
					echo "@import url(http://fonts.googleapis.com/css?family=".$cs_fonts['h1_g_font'].");";
					echo "h1 { font-family: '".$cs_fonts['h1_g_font']."', sans-serif !important; }";
				echo '</style>';
			}

			if ( isset($cs_fonts['h2_size']) ) echo '<style> h2{ font-size:'.$cs_fonts['h2_size'].'px !important; } </style>';
			if ( isset($cs_fonts['h2_g_font']) and $cs_fonts['h2_g_font'] <> "" ) {
				echo '<style>';
					echo "@import url(http://fonts.googleapis.com/css?family=".$cs_fonts['h2_g_font'].");";
					echo "h2 { font-family: '".$cs_fonts['h2_g_font']."', sans-serif !important; }";
				echo '</style>';
			}

			if ( isset($cs_fonts['h3_size']) ) echo '<style> h3{ font-size:'.$cs_fonts['h3_size'].'px !important; } </style>';
			if ( isset($cs_fonts['h3_g_font']) and $cs_fonts['h3_g_font'] <> "" ) {
				echo '<style>';
					echo "@import url(http://fonts.googleapis.com/css?family=".$cs_fonts['h3_g_font'].");";
					echo "h3 { font-family: '".$cs_fonts['h3_g_font']."', sans-serif !important; }";
				echo '</style>';
			}

			if ( isset($cs_fonts['h4_size']) ) echo '<style> h4{ font-size:'.$cs_fonts['h4_size'].'px !important; } </style>';
			if ( isset($cs_fonts['h4_g_font']) and $cs_fonts['h4_g_font'] <> "" ) {
				echo '<style>';
					echo "@import url(http://fonts.googleapis.com/css?family=".$cs_fonts['h4_g_font'].");";
					echo "h4 { font-family: '".$cs_fonts['h4_g_font']."', sans-serif !important; }";
				echo '</style>';
			}

			if ( isset($cs_fonts['h5_size']) ) echo '<style> h5{ font-size:'.$cs_fonts['h5_size'].'px !important; } </style>';
			if ( isset($cs_fonts['h5_g_font']) and $cs_fonts['h5_g_font'] <> "" ) {
				echo '<style>';
					echo "@import url(http://fonts.googleapis.com/css?family=".$cs_fonts['h5_g_font'].");";
					echo "h5 { font-family: '".$cs_fonts['h5_g_font']."', sans-serif !important; }";
				echo '</style>';
			}

			if ( isset($cs_fonts['h6_size']) ) echo '<style> h6{ font-size:'.$cs_fonts['h6_size'].'px !important; } </style>';
			if ( isset($cs_fonts['h6_g_font']) and $cs_fonts['h6_g_font'] <> "" ) {
				echo '<style>';
					echo "@import url(http://fonts.googleapis.com/css?family=".$cs_fonts['h6_g_font'].");";
					echo "h6 { font-family: '".$cs_fonts['h6_g_font']."', sans-serif !important; }";
				echo '</style>';
			}

			if ( isset($cs_fonts['content_size']) ) echo '<style> body{ font-size:'.$cs_fonts['content_size'].'px !important; } </style>';
			if ( isset($cs_fonts['content_size_g_font']) and $cs_fonts['content_size_g_font'] <> "" ) {
				echo '<style>';
					echo "@import url(http://fonts.googleapis.com/css?family=".$cs_fonts['content_size_g_font'].");";
					echo "body { font-family: '".$cs_fonts['content_size_g_font']."', sans-serif !important; }";
				echo '</style>';
			}

	}

?>
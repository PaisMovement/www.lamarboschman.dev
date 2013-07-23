<?php
	global $node,$counter_gal,$get_slider_id;
 	$cs_sliders_setttings = get_option( "cs_sliders_setttings" );
	$xmlObject = new SimpleXMLElement($cs_sliders_setttings);
	
	if(!empty( $node->slider)){
		// slider slug to id start
			$args=array(
			  'name' => $node->slider,
			  'post_type' => 'cs_slider',
			  'post_status' => 'publish',
			  'showposts' => 1,
			);
 			$get_posts = get_posts($args);
			if($get_posts){
				$node->slider = $get_posts[0]->ID;
			}
		// slider slug to id end
		$get_slider_id = $node->slider;
	}
 	if($get_slider_id <> ''){
	
	if ( $node->slider_type == "Nivo Slider" ) {
	// nivo code start
	$width = $node->width;
	$height = $node->height;
	?>
				<?php
				slider_enqueue_style_scripts($node->slider_type);
					if($xmlObject->nivo->auto_play == 'true'){$xmlObject->nivo->auto_play = 'false';}
					else if($xmlObject->nivo->auto_play == ''){$xmlObject->nivo->auto_play = 'true';}?>
				
				<script>	
					jQuery(function() {
						jQuery('#slidernivo<?php echo $counter_gal?>').nivoSlider({
							effect: "<?php echo $xmlObject->nivo->effect?>",
							manualAdvance: <?php echo $xmlObject->nivo->auto_play;?>,			
							animSpeed: <?php echo $xmlObject->nivo->animation_speed?>,
							pauseTime: <?php echo $xmlObject->nivo->pause_time?>,		
						});
					});
				</script>
				<style>
				.slider-wrapper<?php echo $counter_gal?> {
					width:<?php echo $width?>px;
				}*/
				</style>
				<div class="in-sec">
				<!--    <h1 class="in-sec-heading">
						Slider: 
						<?php 
							//echo get_the_title("$node->slider");
							//echo " ( ".$node->slider_type." )";
						?>
					</h1>
				-->
				<?php 
					$cs_meta_slider_options = get_post_meta($get_slider_id, "cs_meta_slider_options", true);
					if ( $cs_meta_slider_options <> "" ) {?>
                        <!--slider html-->
                        <div class="slider-wrapper<?php echo $counter_gal?> theme-default">
                            <div id="slidernivo<?php echo $counter_gal?>" class="nivoSlider">
                                <?php
									$xmlObject = new SimpleXMLElement($cs_meta_slider_options);
										$counter_nivo_slider_start = 0;
										foreach ( $xmlObject->children() as $as_node ){
											$counter_nivo_slider_start++;
											//$image_url = wp_get_attachment_image_src($as_node->path, array(980,418),true);
											$image_url = cs_attachment_image_src($as_node->path, 980, 418);
										?>
											<img src="<?php echo $image_url?>" data-thumb="<?php echo $image_url?>" alt="" title="#id<?php echo $counter_nivo_slider_start;?>" />
										<?php }?>
                            </div>
							<?php 
								$xmlObject = new SimpleXMLElement($cs_meta_slider_options);
									$counter_nivo_slider = 0;
									 foreach ( $xmlObject->children() as $as_node ){
										$link = '';
										if ( trim($as_node->link) <> "" ) $link = "href='".$as_node->link."'";
										$counter_nivo_slider++
							?>
                                            <div id="id<?php echo $counter_nivo_slider?>" class="nivo-html-caption">
                                            	<?php if($as_node->title != ''){?>
                                                    <div class="nivo-caption-in <?php echo $as_node->box_align?>">    
                                                        <div class="capt-in">
                                                            <h4><a target="<?php echo $as_node->link_target;?>" class="white" <?php echo $link?>><?php echo $as_node->title?></a></h4>
                                                            <p><?php echo $as_node->description?></p>
                                                        </div>
                                                    </div>
												<?php }?>
                                            </div>
                                    <?php } // foreach loop end ?>                
                        </div>
					<?php }?>
					<!--slider html-->
					<div class="clear"></div>
				</div>
    <?php
	// nivo code end
}
else if ( $node->slider_type == "Sudo Slider" ) {
	// sudo code start
	$width = $node->width;
	$height = $node->height;
	?>
             <div class="in-sec">
            <!--    <h1 class="in-sec-heading">
                    Slider: 
                    <?php 
                        //echo get_the_title("$node->slider");
                        //echo " ( ".$node->slider_type." )";
                    ?>
                </h1>
            -->
            <?php
			
                $cs_meta_slider_options = get_post_meta($get_slider_id, "cs_meta_slider_options", true);
                if ( $cs_meta_slider_options <> "" ) {
            slider_enqueue_style_scripts($node->slider_type);
			?>
            <style>
            .sudoslider<?php echo $counter_gal?>{
                width:<?php echo $width?>px;
                height:<?php echo $height?>px;
                position:relative !important;
            }
            #sudoslider<?php echo $counter_gal?>{
                width:<?php echo $width?>px;
                height:<?php echo $height?>px;
                position:relative !important;
            }
            #sudoslider<?php echo $counter_gal?> img{
                width:<?php echo $width?>px;
                height:<?php echo $height?>px;
            }
            </style>
            <?php if($xmlObject->sudo->effect == 'Fade'){$xmlObject->sudo->effect = 'true';}?>
            <?php if($xmlObject->sudo->effect == 'Vertical'){$xmlObject->sudo->effect = 'false';}?>
            <?php if($xmlObject->sudo->auto_play == ''){$xmlObject->sudo->auto_play = 'false';}?>
            <script>
                jQuery(function($){	
                    var ajaximages = [
                        <?php
                                        $xmlObject_sudo = new SimpleXMLElement($cs_meta_slider_options);
                                            foreach ( $xmlObject_sudo->children() as $as_node ){
                                            ?>
                                                '<?php 
                                                    $image_url = cs_attachment_image_src($as_node->path, 980, 418);
                                                    echo $image_url
                                                ?>',
                                            <?php
                                            }
                                ?>
                            ];
                            var imagestext = [
                               <?php 
                                            foreach ( $xmlObject_sudo->children() as $as_node ){
												$link = '';
												if ( trim($as_node->link) <> "" ) $link = 'href="'.$as_node->link.'"';	
                                                
                                            ?>
                                                '<?php 
													if ( $as_node->title != '' && $as_node->description != '' ){
                                                    	echo '<a target="'.$as_node->link_target.'" '.$link.' ><h3>'.$as_node->title .'</h3><p>'. $as_node->description.'</p></a>';
													}else{
														echo 'blank';
													}
												?>',
										
                                    <?php } ?>																									
                            ];	
                                            var caption_text = [
                               <?php 
                                            foreach ( $xmlObject_sudo->children() as $as_node ){
                                                $box_align_db = $as_node->box_align;
                                            ?>
                                                '<?php 
                                                    echo $box_align_db;
                                                ?>',
                                    <?php } ?>																									
                            ];	
                            var sudoSlider = $("#sudoslider<?php echo $counter_gal?>").sudoSlider({ 
                                fade:<?php echo $xmlObject->sudo->effect;?>,
                                auto: <?php echo $xmlObject->sudo->auto_play;?>, 
                                speed: <?php echo $xmlObject->sudo->animation_speed?>, 
                                pause: <?php echo $xmlObject->sudo->pause_time?>, 
                                //resumePause: 10000,
                                //prevNext:false,
                                prevNext: true,
                                numeric: false,					
                                continuous:true,
                                crossFade:false,
                                responsive:true,
                                //vertical:true,
                                ajax: ajaximages,
                                ajaxLoadFunction: function(t){
									if (imagestext[t-1] != "blank"){
                                    $(this)
                                        .css("position","relative")
                                        .append('<div class="caption ' + caption_text[t-1] + '"><div class="capt-in">' + imagestext[t-1] + '</div></div>');
									}
                                },
                                beforeAniFunc: function(t){ 
                                    $(this).children('.caption').hide();	
                                },
                                afterAniFunc: function(t){ 
                                    $(this).children('.caption').slideDown(400);
                                }
                            });
                        });	           
            </script>
                <?php }?>
                <div class="sudoslid sudoslider<?php echo $counter_gal?>">
                    <div id="sudoslider<?php echo $counter_gal?>" class="sudo-slider"></div>
                </div>
             
                <div class="clear"></div>
            </div>
            
    <?php
	// sudo code end
}
else if ( $node->slider_type == "Anything Slider" ) {
	// anything code start
	if ( $xmlObject->anything->auto_play <> "true" ) {$xmlObject->anything->auto_play = "false";}
		$width = $node->width;
		$height = $node->height;
		slider_enqueue_style_scripts($node->slider_type);
		?>
				<?php $inc_path_anything = get_template_directory_uri().'/scripts/frontend/';?>
                <style>
                #slider<?php echo $counter_gal?> {
                    width:<?php echo $width?>px;
                    height:<?php echo $height?>px;
                }
                </style>
                    <!-- AnythingSlider -->
                     <script>
                    jQuery(function($){
                        $('#slider<?php echo $counter_gal?>')
                        .anythingSlider({
                            mode          : "<?php echo $xmlObject->anything->effect?>", 
                            autoPlay      : <?php echo $xmlObject->anything->auto_play?>,
                            animationTime : <?php echo $xmlObject->anything->animation_speed?>,
                            delay         : <?php echo $xmlObject->anything->pause_time?>,
                            //buildNavigation     : true,
                            //buildStartStop      : true,
                            //navigationFormatter : function(i, panel){
                                //return ['Top', 'Right', 'Bottom', 'Left'][i - 1];
                            //}
                        })
                        .anythingSliderFx({
                            '.caption-top'    : [ 'caption-Top', '50px', '1000', 'easeOutBounce' ],
                            '.caption-right'  : [ 'caption-Right', '130px', '1000', 'easeOutBounce' ],
                            '.caption-bottom' : [ 'caption-Bottom', '50px', '1000', 'easeOutBounce' ],
                            '.caption-left'   : [ 'caption-Left', '130px', '1000', 'easeOutBounce' ]
                        })
                        // add a close button (x) to the caption
                        .find('div[class*=caption]')
                            .css({ position: 'absolute' })
                            //.prepend('<span class="as_close">Close</span>')
                            .find('.as_close').click(function(){
                                var cap = $(this).parent(),
                                    ani = { bottom : -50 }; // bottom
                                if (cap.is('.caption-top')) { ani = { top: -50 }; }
                                if (cap.is('.caption-left')) { ani = { left: -150 }; }
                                if (cap.is('.caption-right')) { ani = { right: -150 }; }
                                cap.animate(ani, 400);
                            });
                    });
                    </script>
                
                <div class="in-sec">
                <!--    <h1 class="in-sec-heading">
                        Slider: 
                        <?php 
                            //echo get_the_title("$node->slider");
                            //echo " ( ".$node->slider_type." )";
                        ?>
                    </h1>
                -->
                    <?php
                        $cs_meta_slider_options = get_post_meta($get_slider_id, "cs_meta_slider_options", true);
                        if ( $cs_meta_slider_options <> "" ) {
                            $xmlObject = new SimpleXMLElement($cs_meta_slider_options);
                    ?>
                        <ul id="slider<?php echo $counter_gal?>">
                            <?php
                                foreach ( $xmlObject->children() as $as_node ){
									//echo $as_node->link;
                                    $image_url = cs_attachment_image_src($as_node->path, 980, 418);
									$link = '';
									if ( trim($as_node->link) <> "" ) $link = "href='".$as_node->link."'";
							?>
                                <li>
									<a target="<?php echo $as_node->link_target;?>" <?php echo $link?> ><img src="<?php echo $image_url?>" /></a>
                                    <?php
                                        if($as_node->title != '' && $as_node->description != '' || $as_node->title != '' || $as_node->description != ''){?>
                                        <div class="any-caption caption-<?php echo $as_node->box_align?>">
                                            <div class="capt-in">
                                                <h4><a target="<?php echo $as_node->link_target;?>" class="white" <?php echo $link?> ><?php echo $as_node->title?></a></h4>
                                                <p><?php echo $as_node->description?></p>
                                            </div>
                                        </div>
									<?php }?>
                                </li>
                            <?php }?>
                        </ul>
                    <div class="clear"></div>
                <?php }?>
                </div>
		<?php
	// anything code end
}
	}else{
		echo '<div class="box-small no-results-found"> <h5>';
					_e("No results found.",CSDOMAIN);
				echo ' </h5></div>';
	}
?>
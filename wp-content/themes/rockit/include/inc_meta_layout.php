<?php
	if ( empty($xmlObject->cs_layout) ) $xmlObject = new stdClass();

	if ( empty($xmlObject->cs_layout) ) $xmlObject->cs_layout = "";
	if ( empty($xmlObject->cs_sidebar_left) ) $xmlObject->cs_sidebar_left = "";
	if ( empty($xmlObject->cs_sidebar_right) ) $xmlObject->cs_sidebar_right = "";
?>
    <div class="option-sec row">
        <div class="opt-head">
            <h6>Select Layout</h6>
        </div>
        <div class="opt-conts">
            <div class="meta-input">
                <div class='radio-image-wrapper'>
                    <input <?php if($xmlObject->cs_layout=="none")echo "checked"?> onclick="show_sidebar('none')" type="radio" name="cs_layout" class="radio" value="none" id="radio_1" />
                    <label for="radio_1">
                        <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/admin/1.png" /></span>
                        <span <?php if($xmlObject->cs_layout=="none")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/admin/1-hover.png" /></span>
                    </label>
                </div>
                <div class='radio-image-wrapper'>
                    <input <?php if($xmlObject->cs_layout=="right")echo "checked"?> onclick="show_sidebar('right')" type="radio" name="cs_layout" class="radio" value="right" id="radio_2"  />
                    <label for="radio_2">
                        <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/admin/2.png" /></span>
                        <span <?php if($xmlObject->cs_layout=="right")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/admin/2-hover.png" /></span>
                    </label>
                </div>
                <div class='radio-image-wrapper'>
                    <input <?php if($xmlObject->cs_layout=="left")echo "checked"?> onclick="show_sidebar('left')" type="radio" name="cs_layout" class="radio" value="left" id="radio_3" />
                    <label for="radio_3">
                        <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/admin/3.png" /></span>
                        <span <?php if($xmlObject->cs_layout=="left")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/admin/3-hover.png" /></span>
                    </label>
                </div>

            </div>
            <ul class="form-elements meta-body" style="border-top:#C4C4C4 solid 1px; border-bottom:0; <?php if($xmlObject->cs_sidebar_left == ""){echo "display:none";}else echo "display:block";?>" id="sidebar_left" >
                <li class="to-label">
                    <label>Select Left Sidebar</label>
                </li>
                <li class="to-field">
                    <select name="cs_sidebar_left" class="select_dropdown" id="page-option-choose-left-sidebar">
                        <?php
                        $parts = explode( "<name>", get_option("cs_sidebar") );
                        foreach ( $parts as $val ) {
                            if ( $val <> "" ) {
                                $counter++;
                        ?>
                                <option <?php if($xmlObject->cs_sidebar_left==$val){echo "selected";}?> ><?php echo $val;?></option>
                        <?php 
                            }
                        }
                        ?>
                    </select>
                </li>
            </ul>
            <ul class="form-elements meta-body" style="border-top:#C4C4C4 solid 1px; border-bottom:0; <?php if($xmlObject->cs_sidebar_right == ""){echo "display:none";}else echo "display:block";?>" id="sidebar_right" >
                <li class="to-label">
                    <label>Select Right Sidebar</label>
                </li>
                <li class="to-field">
                    <select name="cs_sidebar_right" class="select_dropdown" id="page-option-choose-right-sidebar">
                        <?php
                        $parts = explode( "<name>", get_option("cs_sidebar") );
                        foreach ( $parts as $val ) {
                            if ( $val <> "" ) {
                                $counter++;
                        ?>
                                <option <?php if($xmlObject->cs_sidebar_right==$val){echo "selected";}?> ><?php echo $val;?></option>
                        <?php 
                            }
                        }
                        ?>
                    </select>
                </li>
            </ul>
        </div>
    </div>

<div class="clear"></div>

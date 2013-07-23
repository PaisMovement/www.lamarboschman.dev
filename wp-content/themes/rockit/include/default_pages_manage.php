<?php
function default_pages_manage() {
	global $wpdb;
	foreach ($_REQUEST as $keys=>$values) {
		$$keys = trim($values);
	}
		$cs_default_pages = get_option("cs_default_pages");
		if ( $cs_default_pages <> "" ) {
			$xmlObject = new SimpleXMLElement($cs_default_pages);
				$cs_pagination = $xmlObject->cs_pagination;
				$record_per_page = $xmlObject->record_per_page;
		}
?>

    <div class="theme-wrap fullwidth">
        <?php include "theme_leftnav.php";?>
        <!-- Right Column Start -->
        <div class="col2 left">
            <!-- Header Start -->
            <div class="wrap-header">
                <h4 class="bold">Default Pages</h4>
                
                <div class="clear"></div>
            </div>
            <!-- Header End -->
            <!-- Content Section Start -->
            <div class="elements-in">
                <div class='form-msgs' style="display:none"><div class='to-notif success-box'><span class='tick'>&nbsp;</span><p></p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>
                    <form id="frm" method="post" action="javascript:frm_submit()">
                        <div class="option-sec">
                            <div class="opt-head">
                                <h6>Manage Default Pages (Archive, Search, Categories, Tags and Author Pages)</h6>
                                <p>Set the default pages settings.</p>
                            </div>
                            <div class="opt-conts">
                                    <div class="option-sec" style="border:none">
                                        
                                        <div class="opt-conts">
                                            
                                            <div class="option-sec" style="border:0; position:inherit !important">
                                                
                                                    <ul class="form-elements">
                                                        <li class="to-label">Pagination:</li>
                                                        <li class="to-field">
                                                            <select name="cs_pagination" class="dropdown" onchange="cs_toggle('record_per_page')">
                                                                <option <?php if($cs_pagination=="Show Pagination")echo "selected";?> >Show Pagination</option>
                                                                <option <?php if($cs_pagination=="Single Page")echo "selected";?> >Single Page</option>
                                                            </select>
                                                        </li>
                                                    </ul>
                                                    <ul class="form-elements noborder" id="record_per_page" <?php if($cs_pagination=="Single Page")echo 'style="display:none" '?> >
                                                        <li class="to-label">No. of Record / page:</li>
                                                        <li class="to-field">
                                                            <input type="text" name="record_per_page" value="<?php if($record_per_page=="")echo "5"; else echo $record_per_page?>" />
                                                        </li>
                                                    </ul>
                                                    
                                            </div>
                                        </div>
                                    </div>
            
                            </div>
                            <div class="clear"></div>
                        </div>
							<?php include "inc_meta_layout.php"; ?>
            
                            <ul class="form-elements noborder">
                                <li class="to-label"></li>
                                <li class="to-field">
                                    <input id="submit_btn" class="submit butnthree" type="submit" value="Save"/>
                                    <div id="loading_div"></div>
                                </li>
                            </ul>
                    </form>

                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <!-- Content Section End -->
        </div>
        <div class="clear"></div>
        <!-- Right Column End -->
    </div>

	<script>
        function frm_submit(){
			$ = jQuery;
            $("#submit_btn").hide();
            $("#loading_div").html('<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />');
            $.ajax({
                type:'POST', 
                url: '<?php echo get_template_directory_uri()?>/include/default_pages_save.php',
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
    </script>

<?php }?>
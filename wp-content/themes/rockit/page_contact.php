<?php
	global $node,$counter_gal,$cs_transwitch;
	$cs_contact_email_db = $node->cs_contact_email;
	$cs_contact_succ_msg_db = $node->cs_contact_succ_msg;
	$cs_contact_map_db = $node->cs_contact_map;
	$captcha = "";
	$cs_gs_captcha = get_option( "cs_gs_captcha" );
		if ( $cs_gs_captcha <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_captcha);
				$captcha = $sxe->captcha;
		}
	contact_enqueue_scripts();
?>

<script type="text/javascript">
	jQuery().ready(function($) {
		var container = $('');
		var validator = $("#frm<?php echo $counter_gal?>").validate({
			messages:{
				contact_name: '<?php if($cs_transwitch =='on'){ _e('Name is Required',CSDOMAIN); }else{ echo __CS('name_error', 'Name is Required'); } ?>',
				contact_email:{
					required: '<?php if($cs_transwitch =='on'){ _e('Name is Required',CSDOMAIN); }else{ echo __CS('email_error', 'Email is Required'); } ?>',
					email:'<?php if($cs_transwitch =='on'){ _e('Name is Required',CSDOMAIN); }else{ echo __CS('email_error', 'Invalid Email Provided'); } ?>',
				},
				contact_no: {
					number: '<?php if($cs_transwitch =='on'){ _e('Name is Required',CSDOMAIN); }else{ echo __CS('contact_no_error', 'Please Enter Valid Contact Number'); } ?>',
				},
				contact_msg: '<?php if($cs_transwitch =='on'){ _e('Name is Required',CSDOMAIN); }else{ echo __CS('message_error', 'Message Field is Required'); } ?>',
				key: '<?php if($cs_transwitch =='on'){ _e('Name is Required',CSDOMAIN); }else{ echo __CS('captcha_error', 'Please Enter Security Key'); } ?>',
			},
			errorContainer: container,
			errorLabelContainer: $(container),
			errorElement:'div',
			errorClass:'frm_error',
			meta: "validate"
		});
	});
	function frm_capcha_verify<?php echo $counter_gal?>(){
		var $ = jQuery;
		$("#submit_btn<?php echo $counter_gal?>").hide();
		$("#loading_div<?php echo $counter_gal?>").html('<img src="<?php echo get_template_directory_uri()?>/images/contact_loading.gif" />');
		$.ajax({
			type:'POST', 
			url: '<?php echo get_template_directory_uri()?>/include/captcha_verify.php',
			data:$('#frm<?php echo $counter_gal?>').serialize(), 
			success: function(response) {
				if ( response == "Valid" ) {
					frm_submit<?php echo $counter_gal?>();
				}
				else {
					$("#loading_div<?php echo $counter_gal?>").html('');
					$("#submit_btn<?php echo $counter_gal?>").show('');
					$("#recaptcha_mess<?php echo $counter_gal?>").show('');
					$("#recaptcha_mess<?php echo $counter_gal?>").html(response);
					//alert(response);
					//Recaptcha.reload();
				}
			}
		});
	}
	function frm_submit<?php echo $counter_gal?>(){
		var $ = jQuery;
		$("#submit_btn<?php echo $counter_gal?>").hide();
		$("#loading_div<?php echo $counter_gal?>").html('<img src="<?php echo get_template_directory_uri()?>/images/contact_loading.gif" />');
		$.ajax({
			type:'POST', 
			url: '<?php echo get_template_directory_uri()?>/page_contact_submit.php',
			data:$('#frm<?php echo $counter_gal?>').serialize(), 
			success: function(response) {
				//$('#frm').get(0).reset();
				$("#loading_div<?php echo $counter_gal?>").html('');
				$("#frm_area<?php echo $counter_gal?>").hide();
				$("#succ_mess<?php echo $counter_gal?>").show('');
				$("#succ_mess<?php echo $counter_gal?>").html(response);
				//$('#frm_slide').find('.form_result').html(response);
			}
		});
	}
</script>
<div class="clear"></div>
	<div class="in-sec">
    <h2><?php if($cs_transwitch =='on'){ _e('Quick Inquiry',CSDOMAIN); }else{ echo __CS('form_title', 'Quick Inquiry'); } ?></h2><br />
    <div class="cont-map"><?php echo $cs_contact_map_db?></div>
    <div class="succ_mess" id="succ_mess<?php echo $counter_gal?>"></div>
    <div class="quickinquiry" id="frm_area<?php echo $counter_gal?>">
            <form id="frm<?php echo $counter_gal?>" name="frm<?php echo $counter_gal?>" method="post" action="javascript:<?php if($captcha=="on")echo "frm_capcha_verify".$counter_gal."()";else echo "frm_submit".$counter_gal."()";?>">
                <ul>
                    <li>
                        <label class="txt"><?php _e('Name', CSDOMAIN); ?>:</label>
                        <input type="text" name="contact_name" id="contact_name" value="" class="bar {validate:{required:true}}" />
                    </li>
                    <li>
                        <label class="txt"><?php _e('Email', CSDOMAIN); ?>:</label>
                        <input type="text" name="contact_email" id="contact_email" value="" class="bar {validate:{required:true,email:true}}" />
                    </li>
                    <li>
                        <label class="txt"><?php if($cs_transwitch =='on'){ _e('Contact No',CSDOMAIN); }else{ echo __CS('contact_no', 'Contact No'); }?>:</label>
                        <input type="text" name="contact_no" id="contact_no" value="" class="bar {validate:{number:true}}" />
                    </li>
                    <li>
                        <label class="txt"><?php if($cs_transwitch =='on'){ _e('Message',CSDOMAIN); }else{ echo __CS('message', 'Message'); }?>:</label>
                        <textarea name="contact_msg" id="contact_msg" class="{validate:{required:true}}" /></textarea>
                    </li>
                    <?php if($captcha=="on") {?>
						<li>
							<img src="<?php echo get_template_directory_uri()?>/include/captcha.php?new_sess=sess_cap<?php echo $counter_gal?>" border="0" alt="CAPTCHA" id="captcha<?php echo $counter_gal?>"> <a class="refresh-captcha" onclick="document.getElementById('captcha<?php echo $counter_gal?>').src='<?php echo get_template_directory_uri()?>/include/captcha.php?new_sess=sess_cap<?php echo $counter_gal?>&'+Math.random();" style="cursor:pointer"><?php if($cs_transwitch =='on'){ _e('Refresh Captcha',CSDOMAIN); }else{ echo __CS('refresh_captcha', 'Refresh Captcha'); }?></a>						
                            <div class="clear"></div>
                            <label class="txt"><?php if($cs_transwitch =='on'){ _e('Enter CAPTCHA',CSDOMAIN); }else{ echo __CS('captcha', 'Enter CAPTCHA'); }?></label>
                            <div class="clear"></div>
							<input type="text" id="key" name="key" class="bar" value="" />
							<div class="recaptcha_mess" id="recaptcha_mess<?php echo $counter_gal?>"></div>
						</li>
					<?php }?>
					<li>
                    	<div class="clear"></div>
						<input type="hidden" name="cs_contact_email" value="<?php echo $node->cs_contact_email?>" />
						<input type="hidden" name="bloginfo" value="<?php echo get_bloginfo()?>" />
						<input type="hidden" name="cs_contact_succ_msg" value="<?php echo $node->cs_contact_succ_msg?>" />
						<input type="hidden" name="counter_gal" value="<?php echo $counter_gal?>" />
						<input class="backcolr left btn_submit" id="submit_btn<?php echo $counter_gal?>" type="submit" value="<?php _e('Submit', CSDOMAIN); ?>"/>
						<div id="loading_div<?php echo $counter_gal?>"></div>
					</li>
                </ul>
            </form>
    </div>
</div>
<!-- Quick Inquary End -->
<div class="clear"></div>
<?php 
foreach ($_POST as $keys=>$values) {
	$$keys = $values;
}
	if ( isset($_POST['name']) ) {
		require_once '../../../../wp-load.php';
		global $wpdb;
			$name = $_POST['name'];
			$counter = $_POST['counter'];
			$cs_contact_map_db = '';
			$cs_contact_email_db = '';
			$cs_contact_succ_msg_db = '';
	}
	else {
		$name = ucfirst($node->getName());
			$count_node++;
			$cs_contact_map_db = $node->cs_contact_map;
			$cs_contact_email_db = $node->cs_contact_email;
			$cs_contact_succ_msg_db = $node->cs_contact_succ_msg;
				$counter = $post->ID.$count_node;
}
?> 
	<li id="<?php echo $name.$counter?>_sort">
    	<div class="add_page_builder_item_show temp-tubes" id="<?php echo $name.$counter?>_del">
            <span class="contact">&nbsp;</span>
            <p><?php echo $name?></p>
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="javascript:delete_this('<?php echo $name.$counter?>')" class="delete-it">&nbsp;</a>
            <br class="clear" />
        </div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h6>Edit Contact Form</h6>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label">
                        <label>Google Map IFrame Code</label>
                    </li>
                    <li class="to-field">
                    	<textarea name="cs_contact_map[]"><?php echo $cs_contact_map_db;?></textarea>
                    </li>
                    <li class="to-desc">
                        <p>
                            Please enter Google Map IFrame Code (For Address).
                        </p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label">
                        <label>Contact Email</label>
                    </li>
                    <li class="to-field">
                        <input type="text" name="cs_contact_email[]" class="txtfield" value="<?php if($cs_contact_email_db=="") echo get_option("admin_email"); else echo $cs_contact_email_db;?>" />
                    </li>
                    <li class="to-desc">
                        <p>
                            Please enter Contact email Address.
                        </p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label">
                        <label>Successful Message</label>
                    </li>
                    <li class="to-field">
                    	<textarea name="cs_contact_succ_msg[]"><?php if($cs_contact_succ_msg_db=="")echo "Email Sent Successfully.\nThank you, your message has been submitted to us."; else echo $cs_contact_succ_msg_db;?></textarea>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label">
                    </li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="contact" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </li>
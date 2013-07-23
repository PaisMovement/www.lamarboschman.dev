<?php
	global $cs_transwitch;
	require_once '../../../../wp-load.php';
	global $wpdb;
	$_POST['newsletter_email'] = trim( $_POST['newsletter_email'] );
	$row = $wpdb->get_row("SELECT email from ".$wpdb->prefix."cs_newsletter where email = '" . $_POST['newsletter_email'] . "'" );

		if ( $_POST['newsletter_email'] == "" ) {
			echo "Empty Email Field";
		}
		else if ( !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['newsletter_email'] ) ) {
			if($cs_transwitch =='on'){ _e('Invalid Email Address',CSDOMAIN); }else{ echo __CS('email_error', "Invalid Email Address"); }
		}
		else if ( $wpdb->num_rows > 0 ) {
			if ( $row->email == $_POST['newsletter_email'] ) {
				if($cs_transwitch =='on'){ _e('This Email Already Exist',CSDOMAIN); }else{ echo __CS('email_error', "This Email Already Exist"); }
			}
		}
		else {
			$wpdb->insert( $wpdb->prefix.'cs_newsletter', 
					array( 
						'email' => $_POST['newsletter_email'],
						'ip' => $_SERVER['REMOTE_ADDR'],
						'date_time' => gmdate("Y-m-d H:i:s")
					)
			);
			if($cs_transwitch =='on'){ _e('Thanks for your subscription',CSDOMAIN); }else{ echo __CS('newsletter_thanks', "Thanks for your subscription"); }
		}
?>
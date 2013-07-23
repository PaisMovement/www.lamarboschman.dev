<?php
global $cs_transwitch;
//session_start();
require_once '../../../../wp-load.php';
if ( !session_id() ) add_action( 'init', 'session_start' );

	$counter_gal = $_POST['counter_gal'];
	//echo $_SESSION['aaa'.$counter_gal];
	if ( strlen($_SESSION['sess_cap'.$counter_gal]) && $_POST['key'] == $_SESSION['sess_cap'.$counter_gal] ) {
		echo "Valid";
	} else {
		if($cs_transwitch =='on'){ _e('Wrong Captcha Code',CSDOMAIN); }else{ echo __CS('captcha_error', "Wrong Captcha Code");}
	}
?>
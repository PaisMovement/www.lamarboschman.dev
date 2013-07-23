<?php
	require_once '../../../../wp-load.php';
	foreach ($_REQUEST as $keys=>$values) {
		$$keys = $values;
	}
		if ( empty($show_newsletter) ) $show_newsletter = '';
		update_option( "cs_show_newsletter", $show_newsletter );
	echo "Newsletter Settings Saved";
?>
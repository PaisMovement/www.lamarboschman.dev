<?php
	require_once '../../../../wp-load.php';
	global $wpdb;
	header( 'Content-Description: File Transfer' );
	header( 'Content-Disposition: attachment; filename=cs_newsletter-'.gmdate("Y-m-d").'.csv');
		$rs = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."cs_newsletter ORDER BY date_time ");
			echo '"Email",';
			echo '"IP",';
			echo '"Date Time"';
			echo "\n";
				foreach ( $rs as $row ) {
					echo '"' . $row->email . '",';
					echo '"' . $row->ip . '",';
					echo '"' . $row->date_time . '"';
					echo "\n";
				}
?>
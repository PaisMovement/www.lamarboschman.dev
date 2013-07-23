<?php
	require_once '../../../../wp-load.php';
	foreach ($_REQUEST as $keys=>$values) {
		$$keys = $values;
	}
		$sxe = new SimpleXMLElement("<cs_default_pages></cs_default_pages>");
			$sxe->addChild('cs_pagination', $_POST['cs_pagination'] );
			$sxe->addChild('record_per_page', $_POST['record_per_page'] );
			$sxe = save_layout_xml($sxe);
		update_option( "cs_default_pages", $sxe->asXML() );
	echo "Default Pages Settings Saved";
?>
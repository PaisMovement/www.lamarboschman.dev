<?php
	require_once '../../../../wp-load.php';
	foreach ($_REQUEST as $keys=>$values) {
		$$keys = $values;
	}
		$sxe = new SimpleXMLElement("<cs_home_page_slider></cs_home_page_slider>");
			if ( empty($show_slider) ) $show_slider = '';
				$sxe->addChild('show_slider', $show_slider );
				$sxe->addChild('slider_type', $slider_type );
				$sxe->addChild('slider_name', $slider_name );
			update_option( "cs_home_page_slider", $sxe->asXML() );
	echo "Home Page Slider Settings Saved";
?>
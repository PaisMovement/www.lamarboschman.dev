<?php
	require_once '../../../../wp-load.php';
	foreach ($_REQUEST as $keys=>$values) {
		$$keys = $values;
	}
		$sxe = new SimpleXMLElement("<cs_home_page_album></cs_home_page_album>");
			if ( empty($show_album) ) $show_album = '';
			if ( empty($album_title) ) $album_title = '';
			if ( empty($album_cat) ) $album_cat = '';
			if ( empty($show_view_all) ) $show_view_all = '';
			if ( empty($no_of_album_post) ) $no_of_album_post = '';
				$sxe->addChild('show_album', $show_album );
				$sxe->addChild('album_title', htmlspecialchars(stripslashes($album_title)) );
				$sxe->addChild('album_cat', $album_cat );
				$sxe->addChild('show_view_all', $show_view_all );
				$sxe->addChild('no_of_album_post', $no_of_album_post );
			update_option( "cs_home_page_album", $sxe->asXML() );
	echo "Home Page Album Settings Saved";
?>
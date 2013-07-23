<?php
	require_once '../../../../wp-load.php';
	foreach ($_REQUEST as $keys=>$values) {
		$$keys = $values;
	}
		if ( empty($twitter) ) $twitter = '';
		if ( empty($facebook) ) $facebook = '';
		if ( empty($linkedin) ) $linkedin = '';
		if ( empty($digg) ) $digg = '';
		if ( empty($delicious) ) $delicious = '';
		if ( empty($google_plus) ) $google_plus = '';
		if ( empty($google_buzz) ) $google_buzz = '';
		if ( empty($google_bookmark) ) $google_bookmark = '';
		if ( empty($myspace) ) $myspace = '';
		if ( empty($reddit) ) $reddit = '';
		if ( empty($stumbleupon) ) $stumbleupon = '';
		if ( empty($youtube) ) $youtube = '';
		if ( empty($feedburner) ) $feedburner = '';
		if ( empty($flickr) ) $flickr = '';
		if ( empty($picasa) ) $picasa = '';
		if ( empty($vimeo) ) $vimeo = '';
		if ( empty($tumblr) ) $tumblr = '';
		if ( empty($rss) ) $rss = '';

		$sxe = new SimpleXMLElement("<social_sharing></social_sharing>");
			$sxe->addChild('twitter', $twitter );
			$sxe->addChild('facebook', $facebook );
			$sxe->addChild('linkedin', $linkedin );
			$sxe->addChild('digg', $digg );
			$sxe->addChild('delicious', $delicious );
			$sxe->addChild('google_plus', $google_plus );
			$sxe->addChild('google_buzz', $google_buzz );
			$sxe->addChild('google_bookmark', $google_bookmark );
			$sxe->addChild('myspace', $myspace );
			$sxe->addChild('reddit', $reddit );
			$sxe->addChild('stumbleupon', $stumbleupon );
			$sxe->addChild('rss', $rss );
		update_option( "cs_social_share", $sxe->asXML() );
	echo "Social Sharing Settings Saved";
?>
<?php
	require_once '../../../../wp-load.php';
	foreach ($_REQUEST as $keys=>$values) {
		$$keys = $values;
	}
		$sxe = new SimpleXMLElement("<social_network></social_network>");
			$sxe->addChild('twitter', htmlspecialchars(stripslashes($twitter)) );
			$sxe->addChild('facebook', htmlspecialchars(stripslashes($facebook)) );
			$sxe->addChild('linkedin', htmlspecialchars(stripslashes($linkedin)) );
			$sxe->addChild('digg', htmlspecialchars(stripslashes($digg)) );
			$sxe->addChild('delicious', htmlspecialchars(stripslashes($delicious)) );
			$sxe->addChild('google_plus', htmlspecialchars(stripslashes($google_plus)) );
			$sxe->addChild('google_buzz', htmlspecialchars(stripslashes($google_buzz)) );
			$sxe->addChild('google_bookmark', htmlspecialchars(stripslashes($google_bookmark)) );
			$sxe->addChild('myspace', htmlspecialchars(stripslashes($myspace)) );
			$sxe->addChild('reddit', htmlspecialchars(stripslashes($reddit)) );
			$sxe->addChild('stumbleupon', htmlspecialchars(stripslashes($stumbleupon)) );
			$sxe->addChild('youtube', htmlspecialchars(stripslashes($youtube)) );
			$sxe->addChild('feedburner', htmlspecialchars(stripslashes($feedburner)) );
			$sxe->addChild('flickr', htmlspecialchars(stripslashes($flickr)) );
			$sxe->addChild('picasa', htmlspecialchars(stripslashes($picasa)) );
			$sxe->addChild('vimeo', htmlspecialchars(stripslashes($vimeo)) );
			$sxe->addChild('tumblr', htmlspecialchars(stripslashes($tumblr)) );
		update_option( "cs_social_network", $sxe->asXML() );
	echo "Social Network Settings Saved";
?>
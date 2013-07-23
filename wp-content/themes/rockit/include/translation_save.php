<?php
require_once '../../../../wp-load.php';
foreach ($_REQUEST as $keys=>$values) {
	$$keys = htmlspecialchars(stripslashes($values));
}
	
	if ( $tab == "tab_events" ) {
		$sxe = new SimpleXMLElement("<trans_events></trans_events>");
			$sxe->addChild('event_trans_booking_url', $event_trans_booking_url );
			$sxe->addChild('event_trans_all_day', $event_trans_all_day );
			$sxe->addChild('event_trans_posted_by', $event_trans_posted_by );
			$sxe->addChild('event_trans_category_filter', $event_trans_category_filter );
		update_option( "cs_trans_events", $sxe->asXML() );
		echo "Events Translation Saved";
	}
	else if ( $tab == "tab_albums" ) {
		$sxe = new SimpleXMLElement("<trans_albums></trans_albums>");
			$sxe->addChild('release_date', $release_date );
			$sxe->addChild('buy_now', $buy_now );
			$sxe->addChild('lyrics', $lyrics );
			$sxe->addChild('download', $download );
			$sxe->addChild('play', $play );
			$sxe->addChild('pause', $pause );
			$sxe->addChild('amazon', $amazon );
			$sxe->addChild('itunes', $itunes );
			$sxe->addChild('grooveshark', $grooveshark );
			$sxe->addChild('soundcloud', $soundcloud );
		update_option( "cs_trans_albums", $sxe->asXML() );
		echo "Albums Translation Saved";
	}
	else if ( $tab == "tab_contact" ) {
		$sxe = new SimpleXMLElement("<trans_contact></trans_contact>");
			$sxe->addChild('form_title', $form_title );
			$sxe->addChild('contact_no', $contact_no );
			$sxe->addChild('message', $message );
			$sxe->addChild('captcha', $captcha );
			$sxe->addChild('refresh_captcha', $refresh_captcha );
			$sxe->addChild('name_error', $name_error );
			$sxe->addChild('email_error', $email_error );
			$sxe->addChild('contact_no_error', $contact_no_error );
			$sxe->addChild('message_error', $message_error );
			$sxe->addChild('captcha_error', $captcha_error );
		update_option( "cs_trans_contact", $sxe->asXML() );
		echo "Contact Translation Saved";
	}
	else if ( $tab == "tab_others" ) {
		$sxe = new SimpleXMLElement("<trans_others></trans_others>");
			$sxe->addChild('title_404', $title_404 );
			$sxe->addChild('content_404', $content_404 );
			$sxe->addChild('share_this_post', $share_this_post );
			$sxe->addChild('featured_post', $featured_post);
			$sxe->addChild('follow_us', $follow_us );
			$sxe->addChild('follow_us_on', $follow_us_on );
			$sxe->addChild('need_an_account', $need_an_account );
			$sxe->addChild('newsletter', $newsletter );
			$sxe->addChild('newsletter_thanks', $newsletter_thanks );
		update_option( "cs_trans_others", $sxe->asXML() );
		echo "Others Translation Saved";
	}

?>
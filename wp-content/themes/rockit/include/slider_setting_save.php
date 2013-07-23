<?php
	require_once '../../../../wp-load.php';
	global $wpdb;
	foreach ($_REQUEST as $keys=>$values) {
		$$keys = trim($values);
	}
	$sxe = new SimpleXMLElement("<sliders_setttings></sliders_setttings>");
		$anything = $sxe->addChild('anything');
			$anything->addChild('effect', $cs_anything_effect);
				if ( empty($cs_anything_auto_play) ) $cs_anything_auto_play = '';
					$anything->addChild('auto_play', $cs_anything_auto_play);
					$anything->addChild('animation_speed', $cs_anything_animation_speed);
					$anything->addChild('pause_time', $cs_anything_pause_time);
		$nivo = $sxe->addChild('nivo');
			$nivo->addChild('effect', $cs_nivo_effect);
				if ( empty($cs_nivo_auto_play) ) $cs_nivo_auto_play = '';
					$nivo->addChild('auto_play', $cs_nivo_auto_play);
					$nivo->addChild('animation_speed', $cs_nivo_animation_speed);
					$nivo->addChild('pause_time', $cs_nivo_pause_time);
		$sudo = $sxe->addChild('sudo');
			$sudo->addChild('effect', $cs_sudo_effect);
				if ( empty($cs_sudo_auto_play) ) $cs_sudo_auto_play = '';
					$sudo->addChild('auto_play', $cs_sudo_auto_play);
					$sudo->addChild('animation_speed', $cs_sudo_animation_speed);
					$sudo->addChild('pause_time', $cs_sudo_pause_time);

		update_option( "cs_sliders_setttings", $sxe->asXML() );
	echo "All Sliders Settings Saved";
?>
<?php
	if ( isset($_POST['cs_orderby']) ) {
		$counter = 0;
		$counter_gal = 0;
		$counter_port = 0;
		$counter_event = 0;
		$counter_slider = 0;
		$counter_blog = 0;
		$counter_news = 0;
		$counter_contact = 0;
		$counter_album = 0;
		foreach ( $_POST['cs_orderby'] as $count ){
			if ( $_POST['cs_orderby'][$counter] == "rich_editor" ) {
				$rich_editor = $sxe->addChild('rich_editor');
					$rich_editor->addChild('cs_rich_editor_title', $_POST['cs_rich_editor_title'] );
					$rich_editor->addChild('cs_rich_editor_desc', $_POST['cs_rich_editor_desc'] );
			}
			else if ( $_POST['cs_orderby'][$counter] == "gallery" ) {
				$gallery = $sxe->addChild('gallery');
					$gallery->addChild('layout', $_POST['cs_gal_layout'][$counter_gal] );
					$gallery->addChild('album', $_POST['cs_gal_album'][$counter_gal] );
					$gallery->addChild('title', $_POST['cs_gal_title'][$counter_gal] );
					$gallery->addChild('desc', $_POST['cs_gal_desc'][$counter_gal] );
					$gallery->addChild('pagination', $_POST['cs_gal_pagination'][$counter_gal] );
					$gallery->addChild('media_per_page', $_POST['cs_gal_media_per_page'][$counter_gal] );
				$counter_gal++;
			}
			else if ( $_POST['cs_orderby'][$counter] == "portfolio" ) {
				$portfolio = $sxe->addChild('portfolio');
					$portfolio->addChild('header_title', $_POST['cs_port_header_title'][$counter_port] );
					$portfolio->addChild('layout', $_POST['cs_port_layout'][$counter_port] );
					$portfolio->addChild('cat', $_POST['cs_port_cat'][$counter_port] );
					$portfolio->addChild('thumbnail_height', $_POST['cs_port_thumbnail_height'][$counter_port] );
					$portfolio->addChild('filterable', $_POST['cs_port_filterable'][$counter_port] );
					$portfolio->addChild('title', $_POST['cs_port_title'][$counter_port] );
					$portfolio->addChild('desc', $_POST['cs_port_desc'][$counter_port] );
					$portfolio->addChild('pagination', $_POST['cs_port_pagination'][$counter_port] );
					$portfolio->addChild('media_per_page', $_POST['cs_port_media_per_page'][$counter_port] );
				$counter_port++;
			}
			else if ( $_POST['cs_orderby'][$counter] == "event" ) {
				$event = $sxe->addChild('event');
					$event->addChild('cs_event_title', htmlspecialchars($_POST['cs_event_title'][$counter_event]) );
					$event->addChild('cs_event_view', $_POST['cs_event_view'][$counter_event] );
					$event->addChild('cs_event_type', $_POST['cs_event_type'][$counter_event] );
					$event->addChild('cs_event_category', $_POST['cs_event_category'][$counter_event] );
					$event->addChild('cs_event_time', $_POST['cs_event_time'][$counter_event] );
					$event->addChild('cs_event_map', $_POST['cs_event_map'][$counter_event] );
					$event->addChild('cs_event_excerpt', $_POST['cs_event_excerpt'][$counter_event] );
					$event->addChild('cs_event_filterables', $_POST['cs_event_filterables'][$counter_event] );
					$event->addChild('cs_event_pagination', $_POST['cs_event_pagination'][$counter_event] );
					$event->addChild('cs_event_per_page', $_POST['cs_event_per_page'][$counter_event] );
				$counter_event++;
			}
			else if ( $_POST['cs_orderby'][$counter] == "slider" ) {
				$slider = $sxe->addChild('slider');
					$slider->addChild('slider_type', $_POST['cs_slider_type'][$counter_slider] );
					$slider->addChild('slider', $_POST['cs_slider'][$counter_slider] );
					$slider->addChild('width', $_POST['cs_slider_width'][$counter_slider] );
					$slider->addChild('height', $_POST['cs_slider_height'][$counter_slider] );
				$counter_slider++;
			}
			else if ( $_POST['cs_orderby'][$counter] == "blog" ) {
				$slider = $sxe->addChild('blog');
					$slider->addChild('cs_blog_title', htmlspecialchars($_POST['cs_blog_title'][$counter_blog]) );
					$slider->addChild('cs_blog_cat', $_POST['cs_blog_cat'][$counter_blog] );
					$slider->addChild('cs_blog_excerpt', $_POST['cs_blog_excerpt'][$counter_blog] );
					$slider->addChild('cs_blog_num_post', $_POST['cs_blog_num_post'][$counter_blog] );
					$slider->addChild('cs_blog_pagination', $_POST['cs_blog_pagination'][$counter_blog] );
				$counter_blog++;
			}
			else if ( $_POST['cs_orderby'][$counter] == "news" ) {
				$slider = $sxe->addChild('news');
					$slider->addChild('cs_news_title', htmlspecialchars($_POST['cs_news_title'][$counter_news]) );
					$slider->addChild('cs_news_cat', $_POST['cs_news_cat'][$counter_news] );
					$slider->addChild('cs_news_excerpt', $_POST['cs_news_excerpt'][$counter_news] );
					$slider->addChild('cs_news_num_post', $_POST['cs_news_num_post'][$counter_news] );
					$slider->addChild('cs_news_pagination', $_POST['cs_news_pagination'][$counter_news] );
				$counter_news++;
			}
			else if ( $_POST['cs_orderby'][$counter] == "contact" ) {
				$slider = $sxe->addChild('contact');
					$slider->addChild('cs_contact_map', htmlspecialchars($_POST['cs_contact_map'][$counter_contact]) );
					$slider->addChild('cs_contact_email', $_POST['cs_contact_email'][$counter_contact] );
					$slider->addChild('cs_contact_succ_msg', $_POST['cs_contact_succ_msg'][$counter_contact] );
				$counter_contact++;
			}
			else if ( $_POST['cs_orderby'][$counter] == "album" ) {
				$slider = $sxe->addChild('album');
					$slider->addChild('cs_album_title', htmlspecialchars($_POST['cs_album_title'][$counter_album]) );
					$slider->addChild('cs_album_cat', $_POST['cs_album_cat'][$counter_album] );
					$slider->addChild('cs_album_filterable', $_POST['cs_album_filterable'][$counter_album] );
					$slider->addChild('cs_album_cat_show', $_POST['cs_album_cat_show'][$counter_album] );
					$slider->addChild('cs_album_buynow', $_POST['cs_album_buynow'][$counter_album] );
					$slider->addChild('cs_album_pagination', $_POST['cs_album_pagination'][$counter_album] );
					$slider->addChild('cs_album_per_page', $_POST['cs_album_per_page'][$counter_album] );
				$counter_album++;
			}
			$counter++;
		}
	}
?>
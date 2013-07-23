<?php
// adding mce custom button for short codes start
	class ShortcodesEditorSelector{
		var $buttonName = 'cs_shortcode';
		function addSelector() {
			add_filter('mce_external_plugins', array($this, 'registerTmcePlugin'));
			add_filter('mce_buttons', array($this, 'registerButton'));
		}
		function registerButton($buttons) {
			array_push($buttons, "separator", $this->buttonName);
			return $buttons;
		}
		function registerTmcePlugin($plugin_array) {
			$plugin_array[$this->buttonName] = get_template_directory_uri() . '/include/mce_editor_plugin.js.php';
			//var_dump($plugin_array);
			return $plugin_array;
		}
	}
	if(!isset($shortcodesES)) {
		$shortcodesES = new ShortcodesEditorSelector();
		add_action('admin_head', array($shortcodesES, 'addSelector'));
	}
// adding mce custom button for short codes end

//adding shortcode start 
	// adding toggle start
	function cs_shortcode_pb_toggle($atts, $content="") {
		global $toggle_counter;
		$toggle_counter ++;
		$html = '<a data-toggle="collapse" data-target="#cs_toggle'.$toggle_counter.'" class="btn backcolr">'.$atts["title"].'</a>';
		$html .= '<div class="togglebox in collapse" id="cs_toggle'.$toggle_counter.'">'.$content.'</div>';
		$html = '<div class="toggle-sectn">'.$html.'</div>';
		return do_shortcode($html).'<div class="clear"></div>';
	}
	add_shortcode( 'cs_toggle', 'cs_shortcode_pb_toggle' );
	// adding toggle end
	// adding tabs start
	function cs_shortcode_pb_tabs($atts, $content="") {
		global $tab_counter;
		$tab_counter++;
		$content = str_replace("[cs_tab_item", "<cs_tab_item", $content);
		$content = str_replace("[/cs_tab_item]", "</cs_tab_item>", $content);
		$content = str_replace('tabs="tabs"]', ">", $content);
		$content = str_replace("<br />", "", $content);
		$content = str_replace("<p>", "", $content);
		$content = str_replace("</p>", "", $content);
		$content = "<tab>". $content . "</tab>";
		$html = "";
		$tabs_count = 0;
			$html .= '<ul class="nav nav-tabs">';
				$xmlObject = new SimpleXMLElement($content);
					foreach ( $xmlObject as $node ){
						$tabs_count++;
						if($tabs_count==1) $tab_active=" active"; else $tab_active="";
						$html .= '<li class="'.$tab_active.'"><a data-toggle="tab" href="#'.str_replace(" ","",$node["title"].$tab_counter).'">'.$node["title"].'</a></li>';
					}
			$html .= '</ul>';
			$html .= '<div class="tab-content">';
			$tabs_count = 0;
				foreach ( $xmlObject as $node ){
					$tabs_count++;
					if($tabs_count==1) $tab_active=" active"; else $tab_active="";
					$html .= '<div class="tab-pane '.$tab_active.'" id="'.str_replace(" ","",$node["title"].$tab_counter).'">'.$node.'</div>';
				}
			$html .= '</div>';
			$html = '<div class="tabs-sectn">'.$html.'</div>';
		return do_shortcode($html).'<div class="clear"></div>';
	}
	add_shortcode( 'cs_tab', 'cs_shortcode_pb_tabs' );
	// adding tabs end
	// adding accordion start
	function cs_shortcode_pb_accordion($atts, $content="") {
		global $acc_counter;
		$acc_counter++;
		$content = str_replace("[cs_accordion_item", "<cs_accordion_item", $content);
		$content = str_replace("[/cs_accordion_item]", "</cs_accordion_item>", $content);
		$content = str_replace('accordion="accordion"]', ">", $content);
		$content = str_replace("<br />", "", $content);
		$content = str_replace("<p>", "", $content);
		$content = str_replace("</p>", "", $content);
		$content = "<accordion>". $content . "</accordion>";
		$html = "";
		$accordion_count = 0;
			$html .= '<div class="accordion" id="accordion2">';
				$xmlObject = new SimpleXMLElement($content);
					foreach ( $xmlObject as $node ){
						$accordion_count++;
						if($accordion_count==1) $accordion_active=" in"; else $accordion_active="";
						$html .= '<div class="accordion-group">';
							$html .= '<div class="accordion-heading">';
								$html .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#'.str_replace(" ","",$node["title"].$acc_counter).'">'.$node["title"].'</a>';
							$html .= '</div>';
							$html .= '<div id="'.str_replace(" ","",$node["title"].$acc_counter).'" class="accordion-body collapse '.$accordion_active.'">';
								$html .= '<div class="accordion-inner">'.$node.'</div>';
							$html .= '</div>';
						$html .= '</div>';
					}
			$html .= '</div>';
		return do_shortcode($html).'<div class="clear"></div>';
	}
	add_shortcode( 'cs_accordion', 'cs_shortcode_pb_accordion' );
	// adding accordion end
	// adding divider start
	function cs_shortcode_pb_divider($atts) {
		$html = '<div class="devider"><a id="back-top" class="top" href="#top">'.$atts["title"].'</a></div><hr />';
		return $html.'<div class="clear"></div>';
	}
	add_shortcode( 'cs_divider', 'cs_shortcode_pb_divider' );
	// adding divider end
	// adding quote start
	function cs_shortcode_pb_quote($atts, $content="") {
		$html = '<blockquote class="cs_blockquote" style="color:'.$atts['color'].'">'.$content.'</blockquote>';
		return do_shortcode($html).'<div class="clear"></div>';
	}
	add_shortcode( 'cs_quote', 'cs_shortcode_pb_quote' );
	// adding quote end
	// adding button start
	function cs_shortcode_pb_button($atts, $content="") {
		$html = '<a href="'.$atts['src'].'" class="btn" style=" cursor:pointer; color:'.$atts['color'].' ;background-color:'.$atts['background'].'">'.$content.'</a>';
		return $html.'<div class="clear"></div>';
	}
	add_shortcode( 'cs_button', 'cs_shortcode_pb_button' );
	// adding button end
	// adding column start
	function cs_shortcode_pb_column($atts, $content="") {
		list($top, $bottom) = explode('/', $atts['size']);
		$width = $top / $bottom * 100;
		$html = '<div class="shortgrid" style="width:'.$width.'%">'.$content.'</div>';
		return do_shortcode(htmlspecialchars_decode($html));
	}
	add_shortcode( 'cs_column', 'cs_shortcode_pb_column' );
	// adding column end
	// adding dropcap start
	function cs_shortcode_pb_dropcap($atts, $content="") {
		$html = '<div class="cs_dropcap">'.$content.'</div>';
		return $html;
	}
	add_shortcode( 'cs_dropcap', 'cs_shortcode_pb_dropcap' );
	// adding dropcap end
	// adding message_box start
	function cs_shortcode_pb_message_box($atts, $content="") {
		$html = '<div class="messagebox alert alert-info" style="background:'.$atts["background"].'; color:'.$atts["color"].'; border:1px solid '.$atts["border_color"].'"><button type="button" class="close" data-dismiss="alert">&times;</button><h4>'.$atts["title"].'</h4>'.$content.'</div>';
		return do_shortcode($html).'<div class="clear"></div>';
	}
	add_shortcode( 'cs_message_box', 'cs_shortcode_pb_message_box' );
	// adding message_box end
	// adding frame start
	function cs_shortcode_pb_frame($atts, $content="") {
		$html = '';
		$lightbox = '';
		if ( $atts["lightbox"] == "on" ) {
			$lightbox = 'href="'.$atts["src"].'" rel="prettyPhoto[gallery1]"';
		}
			$html .= '<div class="light-box"><a '.$lightbox.'><img width="'.$atts["width"].'" height="'.$atts["height"].'" src="'.$atts["src"].'" alt="'.$atts["title"].'" /></a></div>';
		return $html.'<div class="clear"></div>';
	}
	add_shortcode( 'cs_frame', 'cs_shortcode_pb_frame' );
	// adding frame end
	// adding list start
	function cs_shortcode_pb_list($atts, $content="") {
		$content = "<ul class='shortcode-list'>". $content . "</ul>";
		$content = str_replace("[cs_list_item]", "<li>", $content);
		$content = str_replace("[/cs_list_item]", "</li>", $content);
		$content = str_replace("<br />", "", $content);
		$html = '<div class="list_'.$atts["type"].'">'.$content.'</div>';
		return do_shortcode($html).'<div class="clear"></div>';
	}
	add_shortcode( 'cs_list', 'cs_shortcode_pb_list' );
	// adding list end
	// adding table start
	function cs_shortcode_pb_table($atts, $content="") {
		$table_class = "table_".str_replace("#","",$atts["color"]);
		$content = "<table class='table table-condensed ".$table_class."'>". $content . "</table>";
		$content = str_replace("[thead]", "<thead>", $content);
		$content = str_replace("[/thead]", "</thead>", $content);
		$content = str_replace("[tr]", "<tr>", $content);
		$content = str_replace("[/tr]", "</tr>", $content);
		$content = str_replace("[th]", "<th>", $content);
		$content = str_replace("[/th]", "</th>", $content);
		$content = str_replace("[tbody]", "<tbody>", $content);
		$content = str_replace("[/tbody]", "</tbody>", $content);
		$content = str_replace("[td]", "<td>", $content);
		$content = str_replace("[/td]", "</td>", $content);
		$content = str_replace("<br />", "", $content);
		//$content = do_shortcode(htmlspecialchars_decode($content));
		$html = '
			<style>
			.'.$table_class.' {border:1px solid '.$atts["color"].';}
			.'.$table_class.' td {border-top: 1px solid '.$atts["color"].';}
			.'.$table_class.' thead {background:'.$atts["color"].';}
			</style>
		';
		$html .= '<div class="tables-code">'.$content.'</div>';
		return do_shortcode(htmlspecialchars_decode($html)).'<div class="clear"></div>';
	}
	add_shortcode( 'cs_table', 'cs_shortcode_pb_table' );
	// adding table end
	
	// adding code start
	function cs_shortcode_pb_code($atts, $content="") {
		$html = '<div class="cs_code">'.$content.'</div>';
		return $html.'<div class="clear"></div>';
	}
	add_shortcode( 'cs_code', 'cs_shortcode_pb_code' );
	// adding code end

//adding short code end

?>
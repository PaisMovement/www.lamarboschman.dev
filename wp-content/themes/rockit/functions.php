<?php
 add_filter('post_updated_messages', 'codex_events_updated_messages');
function codex_events_updated_messages( $messages ) {
	global $post, $post_ID;
	$ev_string = '';
	$ev_value = '';
	if ( isset( $_SESSION['event_num_repeat'] ) ) {
		$ev_string = "and repeated %d times";
		$ev_value = $_SESSION['event_num_repeat'];
		unset( $_SESSION['event_num_repeat'] );
	}
  
  $messages['events'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Event updated. <a href="%s">View events</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.',CSDOMAIN),
    3 => __('Custom field deleted.',CSDOMAIN),
    4 => __('Events updated.',CSDOMAIN),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('events restored to revision from %s',CSDOMAIN), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Event published  and repeated %d times. <a href="%s">View events</a>',CSDOMAIN), $ev_value, esc_url( get_permalink($post_ID) ) ),
    7 => __('Event saved.',CSDOMAIN),
    8 => sprintf( __('events submitted. <a target="_blank" href="%s">Preview events</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('events scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview events</a>',CSDOMAIN),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i',CSDOMAIN), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('events draft updated. <a target="_blank" href="%s">Preview events</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
function cs_get_the_excerpt($limit) {
    $get_the_excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', get_the_excerpt()));
    echo substr($get_the_excerpt, 0, "$limit");
    if (strlen($get_the_excerpt) > "$limit") {
        echo '&nbsp;&nbsp;<a href="' . get_permalink() . '" class="readmore">' . __('More...', CSDOMAIN). '</a>';
    }
}
function custom_excerpt_length( $length ) {
return 255; // Change this to the number of characters you wish to have in your excerpt
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function record_per_page_default_pages(){
	$cs_default_pages = get_option("cs_default_pages");
	if ( $cs_default_pages <> "" ) {
		$xmlObject = simplexml_load_string($cs_default_pages);
			$record_per_page = $xmlObject->record_per_page;
			if ( $xmlObject->cs_pagination == 'Single Page' ) $record_per_page = '-1';
	}
	return $record_per_page;
}
// change the default query variable start

// change the default query variable start
function change_query_vars($query) {
    if (is_search() || is_archive() || is_author() || is_tax() || is_tag() || is_category()) {
        if (empty($_GET['page_id_all']))
            $_GET['page_id_all'] = 1;
        $record_per_page = record_per_page_default_pages();
        $query->query_vars['posts_per_page'] = "$record_per_page"; // Change number of posts you would like to show
        $query->query_vars['paged'] = $_GET['page_id_all'];
        //$query->query_vars['post_type'] = array('post', 'classes-schedule', 'facility');
    }
    return $query; // Return modified query variables
}
add_filter('pre_get_posts', 'change_query_vars'); // Hook our custom function onto the request filter
// change the default query variable end
 
function cs_paginate(){
	global $wp_query;
	$cur_page = ($wp_query->query_vars);
	$total_page = ceil($wp_query->found_posts/record_per_page_default_pages());
		echo "<div class='in-sec'><ul class='pagination'>";
			echo '<li>'; previous_posts_link(__('&lt; Prev', CSDOMAIN)); echo '</li>';
				for ( $i = 1; $i <= $total_page; $i++ ) {
					if ( $cur_page['paged'] == $i ){
						echo '<li><a class="active">'.$i.'</a></li>';
					}
					else {
						echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
					}
				}
			echo "<li>"; next_posts_link(__('Next &gt;',CSDOMAIN)); echo "</li>";
		echo "</ul></div>";
}

// pagination start
function cs_pagination($total_records, $per_page, $qrystr=''){
	$html = '';
	$dot_pre = '';
	$dot_more = '';
	$total_page = ceil($total_records/$per_page);
	$loop_start = $_GET['page_id_all'] - 2;
	$loop_end = $_GET['page_id_all'] + 2;
		if ( $_GET['page_id_all'] < 3 ) {
			$loop_start = 1;
				if ( $total_page < 5 ) $loop_end = $total_page;
				else $loop_end = 5;
		}
		else if ( $_GET['page_id_all'] >= $total_page - 1 ) {
			if ( $total_page < 5 ) $loop_start = 1;
			else $loop_start = $total_page - 4;
			$loop_end = $total_page;
		}
			if ( $_GET['page_id_all'] > 1 ) $html .= "<li><a href='?page_id_all=".($_GET['page_id_all']-1)."$qrystr'>".__('&lt; Prev', CSDOMAIN)."</a></li>";
			if ( $_GET['page_id_all'] > 3 and $total_page > 5 ) $html .= "<li><a href='?page_id_all=1$qrystr'>1</a></li>";
			if ( $_GET['page_id_all'] > 4 and $total_page > 6 ) $html .= "<li> <strong>. . .</strong> </li>";
					if ( $total_page > 1 ) {
						for ( $i = $loop_start; $i <= $loop_end; $i++ ) {
							if ( $i <> $_GET['page_id_all'] ) $html .= "<li><a href='?page_id_all=$i$qrystr'>" . $i . "</a></li>";
						else $html .= "<li><a class='active'>".$i."</a></li>";
					}
			}
			if ( $loop_end <> $total_page and $loop_end <> $total_page-1 ) $html .= "<li> <strong>. . .</strong> </li>";
			if ( $loop_end <> $total_page ) $html .= "<li><a href='?page_id_all=$total_page$qrystr'>$total_page</a></li>";
			if ( $_GET['page_id_all'] < $total_records/$per_page ) $html .= "<li><a href='?page_id_all=".($_GET['page_id_all']+1)."$qrystr'>".__('Next &gt;',CSDOMAIN)."</a><li>";
	return $html;
}
// pagination end

if ( !session_id() ) add_action( 'init', 'session_start' );

if(!function_exists('__CS')){
	function __CS($str, $default = '')
	{
		$locale = get_locale();
		$lang = get_option('lang_theme');
		//$trans = array('cs_trans_events', 'cs_trans_sermons', 'cs_trans_contact', 'cs_trans_others');
		$trans[] = get_option('cs_trans_events');
		$trans[] = get_option('cs_trans_albums');
		$trans[] = get_option('cs_trans_contact');
		$trans[] = get_option('cs_trans_others');
		$value = '';
		foreach($trans as $tr)
		{
			$sxe = new SimpleXMLElement($tr);
			if(isset($sxe->$str) && $sxe->$str != '') $value = $sxe->$str;
			if($value) return $value;
		}
		return $default;
	}
}

function events_meta_save($post_id) {
	global $wpdb;
	if ( empty($_POST["event_social_sharing"]) ) $_POST["event_social_sharing"] = "";
	if ( empty($_POST["event_start_time"]) ) $_POST["event_start_time"] = "";
	if ( empty($_POST["event_end_time"]) ) $_POST["event_end_time"] = "";
	if ( empty($_POST["event_all_day"]) ) $_POST["event_all_day"] = "";
	if ( empty($_POST["event_booking_url"]) ) $_POST["event_booking_url"] = "";
	if ( empty($_POST["event_address"]) ) $_POST["event_address"] = "";
	$sxe = new SimpleXMLElement("<event></event>");
	$sxe->addChild('event_social_sharing', $_POST["event_social_sharing"] );
	$sxe->addChild('event_start_time', $_POST["event_start_time"] );
	$sxe->addChild('event_end_time', $_POST["event_end_time"] );
	$sxe->addChild('event_all_day', $_POST["event_all_day"] );
	$sxe->addChild('event_booking_url', htmlspecialchars($_POST["event_booking_url"]) );
	$sxe->addChild('event_address', $_POST["event_address"] );
	$sxe = save_layout_xml($sxe);
	update_post_meta( $post_id, 'cs_event_meta', $sxe->asXML() );
}
function cs_get_post_img($post_id, $width, $height){
	//if ( has_post_thumbnail()) {}
	$image_id = get_post_thumbnail_id($post_id);
	$image_url = wp_get_attachment_image_src($image_id, array($width,$height),true);
	if ( $image_url[1] == $width and $image_url[2] == $height ) {
		return get_the_post_thumbnail($post_id, array($width, $height));
	}
	else {
		return get_the_post_thumbnail($post_id,"full");
	}
}
function cs_attachment_image_src($attachment_id, $width, $height){
	$image_url = wp_get_attachment_image_src($attachment_id, array($width,$height),true);
	if ( $image_url[1] == $width and $image_url[2] == $height );
	else $image_url = wp_get_attachment_image_src($attachment_id, "full",true);
	return $image_url[0];
}
function cs_media_attachment($post_id,$width, $height){
	$attachment = get_children( array( 'post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
	foreach($attachment as $image){
		echo '<img src="'.$image->guid.'" width="'.$width.'" height="'.$height.'">';
	}
}
function get_google_fonts() {
	$fonts = array("Abel", "Aclonica", "Acme", "Actor", "Advent Pro", "Aldrich", "Allerta", "Allerta Stencil", "Amaranth", "Andika", "Anonymous Pro", "Antic", "Anton", "Arimo", "Armata", "Asap", "Asul", 
		"Basic", "Belleza", "Cabin", "Cabin Condensed", "Cagliostro", "Candal", "Cantarell", "Carme", "Chau Philomene One", "Chivo", "Coda Caption", "Comfortaa", "Convergence", "Cousine", "Cuprum", "Days One", 
		"Didact Gothic", "Doppio One", "Dorsa", "Dosis", "Droid Sans", "Droid Sans Mono", "Duru Sans", "Economica", "Electrolize", "Exo", "Federo", "Francois One", "Fresca", "Galdeano", "Geo", "Gudea", 
		"Hammersmith One", "Homenaje", "Imprima", "Inconsolata", "Inder", "Istok Web", "Jockey One", "Josefin Sans", "Jura", "Karla", "Krona One", "Lato", "Lekton", "Magra", "Mako", "Marmelad", "Marvel", 
		"Maven Pro", "Metrophobic", "Michroma", "Molengo", "Montserrat", "Muli", "News Cycle", "Nobile", "Numans", "Nunito", "Open Sans", "Open Sans Condensed", "Orbitron", "Oswald", "Oxygen", "PT Mono", 
		"PT Sans", "PT Sans Caption", "PT Sans Narrow", "Paytone One", "Philosopher", "Play", "Pontano Sans", "Port Lligat Sans", "Puritan", "Quantico", "Quattrocento Sans", "Questrial", "Quicksand", "Rationale", 
		"Ropa Sans", "Rosario", "Ruda", "Ruluko", "Russo One", "Shanti", "Sigmar One", "Signika", "Signika Negative", "Six Caps", "Snippet", "Spinnaker", "Syncopate", "Telex", "Tenor Sans", "Ubuntu", 
		"Ubuntu Condensed", "Ubuntu Mono", "Varela", "Varela Round", "Viga", "Voltaire", "Wire One", "Yanone Kaffeesatz","Adamina", "Alegreya", "Alegreya SC", "Alice", "Alike", "Alike Angular", "Almendra", 
		"Almendra SC", "Amethysta", "Andada", "Antic Didone", "Antic Slab", "Arapey", "Artifika", "Arvo", "Average", "Balthazar", "Belgrano", "Bentham", "Bevan", "Bitter", "Brawler", "Bree Serif", "Buenard", 
		"Cambo", "Cantata One", "Cardo", "Caudex", "Copse", "Coustard", "Crete Round", "Crimson Text", "Cutive", "Della Respira", "Droid Serif", "EB Garamond", "Enriqueta", "Esteban", "Fanwood Text", "Fjord One", 
		"Gentium Basic", "Gentium Book Basic", "Glegoo", "Goudy Bookletter 1911", "Habibi", "Holtwood One SC", "IM Fell DW Pica", "IM Fell DW Pica SC", "IM Fell Double Pica", "IM Fell Double Pica SC", 
		"IM Fell English", "IM Fell English SC", "IM Fell French Canon", "IM Fell French Canon SC", "IM Fell Great Primer", "IM Fell Great Primer SC", "Inika", "Italiana", "Josefin Slab", "Judson", "Junge", 
		"Kameron", "Kotta One", "Kreon", "Ledger", "Linden Hill", "Lora", "Lusitana", "Lustria", "Marko One", "Mate", "Mate SC", "Merriweather", "Montaga", "Neuton", "Noticia Text", "Old Standard TT", "Ovo", 
		"PT Serif", "PT Serif Caption", "Petrona", "Playfair Display", "Podkova", "Poly", "Port Lligat Slab", "Prata", "Prociono", "Quattrocento", "Radley", "Rokkitt", "Rosarivo", "Simonetta", "Sorts Mill Goudy", 
		"Stoke", "Tienne", "Tinos", "Trocchi", "Trykker", "Ultra", "Unna", "Vidaloka", "Volkhov", "Vollkorn","Abril Fatface", "Aguafina Script", "Aladin", "Alex Brush", "Alfa Slab One", "Allan", "Allura", 
		"Amatic SC", "Annie Use Your Telescope", "Arbutus", "Architects Daughter", "Arizonia", "Asset", "Astloch", "Atomic Age", "Aubrey", "Audiowide", "Averia Gruesa Libre", "Averia Libre", "Averia Sans Libre", 
		"Averia Serif Libre", "Bad Script", "Bangers", "Baumans", "Berkshire Swash", "Bigshot One", "Bilbo", "Bilbo Swash Caps", "Black Ops One", "Bonbon", "Boogaloo", "Bowlby One", "Bowlby One SC", 
		"Bubblegum Sans", "Buda", "Butcherman", "Butterfly Kids", "Cabin Sketch", "Caesar Dressing", "Calligraffitti", "Carter One", "Cedarville Cursive", "Ceviche One", "Changa One", "Chango", "Chelsea Market", 
		"Cherry Cream Soda", "Chewy", "Chicle", "Coda", "Codystar", "Coming Soon", "Concert One", "Condiment", "Contrail One", "Cookie", "Corben", "Covered By Your Grace", "Crafty Girls", "Creepster", "Crushed", 
		"Damion", "Dancing Script", "Dawning of a New Day", "Delius", "Delius Swash Caps", "Delius Unicase", "Devonshire", "Diplomata", "Diplomata SC", "Dr Sugiyama", "Dynalight", "Eater", "Emblema One", 
		"Emilys Candy", "Engagement", "Erica One", "Euphoria Script", "Ewert", "Expletus Sans", "Fascinate", "Fascinate Inline", "Federant", "Felipa", "Flamenco", "Flavors", "Fondamento", "Fontdiner Swanky", 
		"Forum", "Fredericka the Great", "Fredoka One", "Frijole", "Fugaz One", "Geostar", "Geostar Fill", "Germania One", "Give You Glory", "Glass Antiqua", "Gloria Hallelujah", "Goblin One", "Gochi Hand", 
		"Gorditas", "Graduate", "Gravitas One", "Great Vibes", "Gruppo", "Handlee", "Happy Monkey", "Henny Penny", "Herr Von Muellerhoff", "Homemade Apple", "Iceberg", "Iceland", "Indie Flower", "Irish Grover", 
		"Italianno", "Jim Nightshade", "Jolly Lodger", "Julee", "Just Another Hand", "Just Me Again Down Here", "Kaushan Script", "Kelly Slab", "Kenia", "Knewave", "Kranky", "Kristi", "La Belle Aurore", 
		"Lancelot", "League Script", "Leckerli One", "Lemon", "Lilita One", "Limelight", "Lobster", "Lobster Two", "Londrina Outline", "Londrina Shadow", "Londrina Sketch", "Londrina Solid", 
		"Love Ya Like A Sister", "Loved by the King", "Lovers Quarrel", "Luckiest Guy", "Macondo", "Macondo Swash Caps", "Maiden Orange", "Marck Script", "Meddon", "MedievalSharp", "Medula One", "Megrim", 
		"Merienda One", "Metamorphous", "Miltonian", "Miltonian Tattoo", "Miniver", "Miss Fajardose", "Modern Antiqua", "Monofett", "Monoton", "Monsieur La Doulaise", "Montez", "Mountains of Christmas", 
		"Mr Bedfort", "Mr Dafoe", "Mr De Haviland", "Mrs Saint Delafield", "Mrs Sheppards", "Mystery Quest", "Neucha", "Niconne", "Nixie One", "Norican", "Nosifer", "Nothing You Could Do", "Nova Cut", 
		"Nova Flat", "Nova Mono", "Nova Oval", "Nova Round", "Nova Script", "Nova Slim", "Nova Square", "Oldenburg", "Oleo Script", "Original Surfer", "Over the Rainbow", "Overlock", "Overlock SC", "Pacifico", 
		"Parisienne", "Passero One", "Passion One", "Patrick Hand", "Patua One", "Permanent Marker", "Piedra", "Pinyon Script", "Plaster", "Playball", "Poiret One", "Poller One", "Pompiere", "Press Start 2P", 
		"Princess Sofia", "Prosto One", "Qwigley", "Raleway", "Rammetto One", "Rancho", "Redressed", "Reenie Beanie", "Revalia", "Ribeye", "Ribeye Marrow", "Righteous", "Rochester", "Rock Salt", "Rouge Script", 
		"Ruge Boogie", "Ruslan Display", "Ruthie", "Sail", "Salsa", "Sancreek", "Sansita One", "Sarina", "Satisfy", "Schoolbell", "Seaweed Script", "Sevillana", "Shadows Into Light", "Shadows Into Light Two", 
		"Share", "Shojumaru", "Short Stack", "Sirin Stencil", "Slackey", "Smokum", "Smythe", "Sniglet", "Sofia", "Sonsie One", "Special Elite", "Spicy Rice", "Spirax", "Squada One", "Stardos Stencil", 
		"Stint Ultra Condensed", "Stint Ultra Expanded", "Sue Ellen Francisco", "Sunshiney", "Supermercado One", "Swanky and Moo Moo", "Tangerine", "The Girl Next Door", "Titan One", "Trade Winds", "Trochut", 
		"Tulpen One", "Uncial Antiqua", "UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "Unlock", "VT323", "Vast Shadow", "Vibur", "Voces", "Waiting for the Sunrise", "Wallpoet", "Walter Turncoat", 
		"Wellfleet", "Yellowtail", "Yeseva One", "Yesteryear", "Zeyada");
	return $fonts;
} 
function get_countries() {
	$get_countries = array("Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan",
		"Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil","British Virgin Islands",
		"Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China",
		"Colombia","Comoros","Costa Rica","Croatia","Cuba","Cyprus","Czech Republic","Democratic People's Republic of Korea","Democratic Republic of the Congo","Denmark","Djibouti",
		"Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","England","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Fiji","Finland","France","French Polynesia",
		"Gabon","Gambia","Georgia","Germany","Ghana","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong",
		"Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan",
		"Laos","Latvia","Lebanon","Lesotho","Liberia","Libyan Arab Jamahiriya","Liechtenstein","Lithuania","Luxembourg","Macao","Macedonia","Madagascar","Malawi","Malaysia",
		"Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Morocco","Mozambique",
		"Myanmar(Burma)","Namibia","Nauru","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Northern Ireland",
		"Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico",
		"Qatar","Republic of the Congo","Romania","Russia","Rwanda","Saint Kitts and Nevis","Saint Lucia","Saint Vincent and the Grenadines","Samoa",
		"San Marino","Saudi Arabia","Scotland","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa",
		"South Korea","Spain","Sri Lanka","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor-Leste","Togo","Tonga",
		"Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Tuvalu","US Virgin Islands","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay",
		"Uzbekistan","Vanuatu","Vatican","Venezuela","Vietnam","Wales","Yemen","Zambia","Zimbabwe");
	return $get_countries;
}
function save_layout_xml($sxe) {
	if ( empty($_POST['cs_layout']) ) $_POST['cs_layout'] = "";
	if ( empty($_POST['cs_sidebar_left']) ) $_POST['cs_sidebar_left'] = "";
	if ( empty($_POST['cs_sidebar_right']) ) $_POST['cs_sidebar_right'] = "";
		$sxe->addChild('cs_layout', $_POST["cs_layout"] );
			if ( $_POST["cs_layout"] == "left" ) {
				$sxe->addChild('cs_sidebar_left', $_POST['cs_sidebar_left'] );
			}
			else if ( $_POST["cs_layout"] == "right" ) {
				$sxe->addChild('cs_sidebar_right', $_POST['cs_sidebar_right'] );
			}
			else if ( $_POST["cs_layout"] == "both_right" or $_POST["cs_layout"] == "both_left" or $_POST["cs_layout"] == "both" ) {
				$sxe->addChild('cs_sidebar_left', $_POST['cs_sidebar_left'] );
				$sxe->addChild('cs_sidebar_right', $_POST['cs_sidebar_right'] );
			}
	return $sxe;
}

// installing tables on theme activating start
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) { 

    add_action('admin_head', 'activate_widget');
	function activate_widget(){
		$sidebars_widgets = get_option('sidebars_widgets');  //collect widget informations
 		// ---- calendar widget setting---
		$calendar = array();
		$calendar[1] = array(
		"title"		=>	'Calendar'
		);
 		$calendar['_multiwidget'] = '1';
		update_option('widget_calendar',$calendar);
		$calendar = get_option('widget_calendar');
		krsort($calendar);
		foreach($calendar as $key1=>$val1)
		{
			$calendar_key = $key1;
			if(is_int($calendar_key))
			{
				break;
			}
		}
 		// ---- archive widget setting---
		$archives = array();
		$archives[1] = array(
			"count" => "checked",
			"dropdown" => ""
		);						
		$archives['_multiwidget'] = '1';
		update_option('widget_chimp_archives',$archives);
		$archives = get_option('widget_chimp_archives');
		krsort($archives);
		foreach($archives as $key1=>$val1)
		{
			$archives_key = $key1;
			if(is_int($archives_key))
			{
				break;
			}
		}
		// ---- categories widget setting---
		$categories = array();
		$categories[1] = array();						
		$categories['_multiwidget'] = '1';
		update_option('widget_categories',$categories);
		$categories = get_option('widget_categories');
		krsort($categories);
		foreach($categories as $key1=>$val1)
		{
			$categories_key = $key1;
			if(is_int($categories_key))
			{
				break;
			}
		}
		// --- text widget setting ---
		
		$text = array();
		$text[1] = array(
			'title' => '',
			'text' => '<a href="'.site_url().'/?events=lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-1"><img src="'.get_template_directory_uri().'/images/advert1.jpg"></a>',
		);						
		$text['_multiwidget'] = '1';
		update_option('widget_text',$text);
		$text = get_option('widget_text');
		krsort($text);
		foreach($text as $key1=>$val1)
		{
			$text_key = $key1;
			if(is_int($text_key))
			{
				break;
			}
		}
		// ---- tags widget setting---
		$tag_cloud = array();
		$tag_cloud[1] = array(
			"title" => 'Tags',
			"taxonomy" => 'Tags',
		);						
		$tag_cloud['_multiwidget'] = '1';
		update_option('widget_tag_cloud',$tag_cloud);
		$tag_cloud = get_option('widget_tag_cloud');
		krsort($tag_cloud);
		foreach($tag_cloud as $key1=>$val1)
		{
			$tag_cloud_key = $key1;
			if(is_int($tag_cloud_key))
			{
				break;
			}
		}
		 // --- music player widget setting-----
		$cs_music_player = array();
		$cs_music_player[1] = array(
		"title"		=>	'Now Playing',
		"get_post_slug" 	=>	"the-right-voice",
 		"numtrack" => "2"
		);						
		$cs_music_player['_multiwidget'] = '1';
		update_option('widget_cs_music_player',$cs_music_player);
		$cs_music_player = get_option('widget_cs_music_player');
		krsort($cs_music_player);
		foreach($cs_music_player as $key1=>$val1)
		{
			$cs_music_player_key = $key1;
			if(is_int($cs_music_player_key))
			{
				break;
			}
		}
		// --- music player 2 widget setting-----
		$cs_music_player2 = array();
		$cs_music_player2 = get_option('widget_cs_music_player');
		$cs_music_player2[2] = array(
		"title"		=>	"What's New ?",
		"get_post_slug" 	=>	"the-right-voice",
 		"numtrack" => "4"
		);						
		$cs_music_player2['_multiwidget'] = '1';
		update_option('widget_cs_music_player',$cs_music_player2);
		$cs_music_player2 = get_option('widget_cs_music_player');
		krsort($cs_music_player2);
		foreach($cs_music_player2 as $key1=>$val1)
		{
			$cs_music_player_key2 = $key1;
			if(is_int($cs_music_player_key2))
			{
				break;
			}
		} 
		// --- facebook widget setting-----
		$facebook_module = array();
		$facebook_module[1] = array(
		"title"		=>	'Follow Us at Facebook',
		"pageurl" 	=>	"https://www.facebook.com/envato",
		"showfaces" => "on",
		"likebox_height" => "270",
		"fb_bg_color" => "#fff"
		);						
		$facebook_module['_multiwidget'] = '1';
		update_option('widget_facebook_module',$facebook_module);
		$facebook_module = get_option('widget_facebook_module');
		krsort($facebook_module);
		foreach($facebook_module as $key1=>$val1)
		{
			$facebook_module_key = $key1;
			if(is_int($facebook_module_key))
			{
				break;
			}
		}
		// --- text widget  setting ---
		$text2 = array();
		$text2 = get_option('widget_text');
		$text2[2] = array(
			'title' => 'Contact Info',
			'text' => '<div class="contact-widget">
                             <p>
                                 1234 Saint-Ambroise, Suite 000<br>
                                    Montreal, Otawa, Canada<br>
                                    ABC 123<br>
                                </p>
                                <p>
                                 Call: 1.123.456.7891<br>
         Email: <a href="mailto:hello@theband.com">hello@theband.com</a><br>
                                </p>
                                <h4>Aditional info</h4>
                                <p>
                                 Sales: 1.866.924.1420<br>
         Concerts: <a href="mailto:hello@theband.com">hello@theband.com</a><br>
                                </p>
                            </div>',
		);						
		$text2['_multiwidget'] = '1';
		update_option('widget_text',$text2);
		$text2 = get_option('widget_text');
		krsort($text2);
		foreach($text2 as $key1=>$val1)
		{
			$text_key2 = $key1;
			if(is_int($text_key2))
			{
				break;
			}
		}
		// --- text widget  setting ---
		$text3 = array();
		$text3 = get_option('widget_text');
		$text3[3] = array(
			'title' => '',
			'text' => '<a href="'.site_url().'/?events=lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-1"><img src="'.get_template_directory_uri().'/images/arrived.jpg" /></a>',
		);						
		$text3['_multiwidget'] = '1';
		update_option('widget_text',$text3);
		$text3 = get_option('widget_text');
		krsort($text3);
		foreach($text3 as $key1=>$val1)
		{
			$text_key3 = $key1;
			if(is_int($text_key3))
			{
				break;
			}
		}
		// --- Upcoming Event widget  setting ---
		$upcomingevents_count = array();
		$upcomingevents_count[1] = array(
			'title' => 'Upcoming Events',
			'get_post_slug' => 'lorem-ipsum-dolor-sit-amet-8',
		);						
		$upcomingevents_count['_multiwidget'] = '1';
		update_option('widget_upcomingevents_count',$upcomingevents_count);
		$upcomingevents_count = get_option('widget_upcomingevents_count');
		krsort($upcomingevents_count);
		foreach($upcomingevents_count as $key1=>$val1)
		{
			$upcomingevents_count_key = $key1;
			if(is_int($upcomingevents_count_key))
			{
				break;
			}
		}
		$cs_twitter_widget = array();
		$cs_twitter_widget[1] = array(
			'title' => 'evanto',
			't_img_url' => get_template_directory_uri().'/images/twitter-img.jpg',
			'numoftweets' => '3',
		);						
		$cs_twitter_widget['_multiwidget'] = '1';
		update_option('widget_cs_twitter_widget',$cs_twitter_widget);
		$cs_twitter_widget = get_option('widget_cs_twitter_widget');
		krsort($cs_twitter_widget);
		foreach($cs_twitter_widget as $key1=>$val1)
		{
			$cs_twitter_widget_key = $key1;
			if(is_int($cs_twitter_widget_key))
			{
				break;
			}
		}
		
  		$sidebars_widgets['Sidebar'] = array("chimp_archives-$archives_key","calendar-$calendar_key","text-$text_key","tag_cloud-$tag_cloud_key");
		$sidebars_widgets['Home Sidebar'] = array("cs_music_player-$cs_music_player_key","facebook_module-$facebook_module_key");
		$sidebars_widgets['Contact us'] = array("text-$text_key2","facebook_module-$facebook_module_key","calendar-$calendar_key");
		$sidebars_widgets['Album'] = array("cs_music_player-$cs_music_player_key","facebook_module-$facebook_module_key","tag_cloud-$tag_cloud_key");
		$sidebars_widgets['Album Detail'] = array("cs_music_player-$cs_music_player_key","facebook_module-$facebook_module_key","calendar-$calendar_key");
		$sidebars_widgets['Event Details'] = array("facebook_module-$facebook_module_key","calendar-$calendar_key","categories-$categories_key","tag_cloud-$tag_cloud_key");
		$sidebars_widgets['homepage-sidebar'] = array("upcomingevents_count-$upcomingevents_count_key","text-$text_key3","cs_twitter_widget-$cs_twitter_widget_key");
 		update_option('sidebars_widgets',$sidebars_widgets);  //save widget iformations
 	}
	add_action('init', 'install_tables');
	function install_tables() {
	global $wpdb;
 	$wpdb->query("
		CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."cs_newsletter` (
		  `email` varchar(100) NOT NULL,
		  `ip` varchar(16) NOT NULL,
		  `date_time` datetime NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
	
	$theme_mod_val = array();
		$term_exists = term_exists('top-menu', 'nav_menu');
 		if ( !$term_exists ) {
			$wpdb->query(" INSERT INTO `" . $wpdb->prefix . "terms` VALUES ('', 'Top Menu' , 'top-menu', '0'); ");
			$insert_id = mysql_insert_id();
			$theme_mod_val['top-menu'] = $insert_id;
			$wpdb->query(" INSERT INTO `" . $wpdb->prefix . "term_taxonomy` VALUES ('', '".$insert_id."' , 'nav_menu', '', '0', '0'); ");
		}
		else $theme_mod_val['top-menu'] = $term_exists['term_id'];
 		$term_exists = term_exists('bottom-menu', 'nav_menu');
		if ( !$term_exists ) {
			$wpdb->query(" INSERT INTO `" . $wpdb->prefix . "terms` VALUES ('', 'Bottom Menu' , 'bottom-menu', '0'); ");
			$insert_id = mysql_insert_id();
			$theme_mod_val['footer-menu'] = $insert_id;
			$wpdb->query(" INSERT INTO `" . $wpdb->prefix . "term_taxonomy` VALUES ('', '".$insert_id."' , 'nav_menu', '', '0', '0'); ");
		}
		else $theme_mod_val['footer-menu'] = $term_exists['term_id'];
 		set_theme_mod( 'nav_menu_locations', $theme_mod_val );

	//$gfonts = json_decode(@file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAmnx95iAIwGwfUBnX6D645dQPyMyRGGpc'));
	//if($gfonts)	update_option('cs_google_fonts', $gfonts);
	
	// adding general settings start
		update_option( "cs_gs_color_style", '<?xml version="1.0"?><cs_gs_color_style><cs_style_sheet></cs_style_sheet><cs_color_scheme></cs_color_scheme><cs_bg>'.get_template_directory_uri().'/images/bg-body.png</cs_bg><cs_bg_position>center</cs_bg_position><cs_bg_repeat>no-repeat</cs_bg_repeat><cs_bg_attach>scroll</cs_bg_attach><cs_bg_pattern></cs_bg_pattern><custome_pattern>pattern1</custome_pattern><cs_bg_color></cs_bg_color></cs_gs_color_style>' );
		update_option( "cs_gs_logo", '<?xml version="1.0"?><cs_gs_logo><cs_logo>'.get_template_directory_uri().'/images/logo.png</cs_logo><cs_width>159</cs_width><cs_height>69</cs_height></cs_gs_logo>' );
		update_option( "cs_gs_header_script", '<?xml version="1.0"?><cs_gs_header_script><cs_header_code></cs_header_code><cs_fav_icon>'.get_template_directory_uri().'/images/favicon.ico</cs_fav_icon></cs_gs_header_script>' );
		update_option( "cs_home_page_slider", '<?xml version="1.0"?><cs_home_page_slider><show_slider>on</show_slider><slider_type>Nivo Slider</slider_type><slider_name>slider</slider_name></cs_home_page_slider>' );
		update_option( "cs_home_page_album", '<?xml version="1.0"?><cs_home_page_album><show_album>on</show_album><album_title>Latest Album</album_title><album_cat>music</album_cat><show_view_all>Yes</show_view_all><no_of_album_post>4</no_of_album_post></cs_home_page_album>' );
  		update_option( "cs_gs_footer_settings", '<?xml version="1.0"?><cs_gs_footer_settings><cs_footer_logo>'.get_template_directory_uri().'/images/logo-footer.png</cs_footer_logo><cs_copyright>Copyright '.get_option("blogname")." ".gmdate("Y").'</cs_copyright><cs_powered_by></cs_powered_by><cs_powered_icon></cs_powered_icon><cs_analytics></cs_analytics></cs_gs_footer_settings>' );
		update_option( "cs_font_settings", array('h1_size' => '24', 'h2_size' => '20', 'h3_size' => '18', 'h4_size' => '16', 'h5_size' => '14', 'h6_size' => '12', 'content_size' => '11', 'h1_g_font' =>'', 'h2_g_font' =>'', 'h3_g_font' =>'', 'h4_g_font' =>'', 'h5_g_font' =>'', 'h6_g_font' =>'', 'content_size_g_font' =>'' ) );
		update_option( "cs_sidebar", 'Sidebar<name>Home Sidebar<name>Contact us<name>Album<name>Album Detail<name>Event Details<name>' );
		update_option( "cs_sliders_setttings", '<?xml version="1.0"?><sliders_setttings><anything><effect>Fade</effect><auto_play>true</auto_play><animation_speed>500</animation_speed><pause_time>3000</pause_time></anything><nivo><effect>random</effect><auto_play>true</auto_play><animation_speed>500</animation_speed><pause_time>3000</pause_time></nivo><sudo><effect>Fade</effect><auto_play>true</auto_play><animation_speed>500</animation_speed><pause_time>3000</pause_time></sudo></sliders_setttings>' );
		update_option( "cs_social_network", '<?xml version="1.0"?><social_network><twitter>YOUR_PROFILE_LINK</twitter><facebook>YOUR_PROFILE_LINK</facebook><linkedin>YOUR_PROFILE_LINK</linkedin><digg></digg><delicious></delicious><google_plus>YOUR_PROFILE_LINK</google_plus><google_buzz></google_buzz><google_bookmark></google_bookmark><myspace></myspace><reddit></reddit><stumbleupon></stumbleupon><youtube></youtube><feedburner></feedburner><flickr></flickr><picasa></picasa><vimeo></vimeo><tumblr></tumblr></social_network>' );
		update_option( "cs_social_share", '<?xml version="1.0"?><social_sharing><twitter>on</twitter><facebook>on</facebook><linkedin>on</linkedin><digg/><delicious/><google_plus>on</google_plus><google_buzz/><google_bookmark/><myspace/><reddit/><stumbleupon/><rss/></social_sharing>' );
		// adding translation start
		update_option( "cs_trans_events", '<?xml version="1.0"?><trans_events><event_trans_list_view>List View</event_trans_list_view><event_trans_calendar_view>Calendar View</event_trans_calendar_view><event_trans_all_events>All Events</event_trans_all_events><event_trans_upcoming_events>Upcoming Events</event_trans_upcoming_events><event_trans_past_events>Past Events</event_trans_past_events><event_trans_booking_url>Booking URL</event_trans_booking_url><event_trans_all_day>All Day</event_trans_all_day><event_trans_posted_by>Posted By</event_trans_posted_by><event_trans_category_filter>Category Filter</event_trans_category_filter></trans_events>' );
		update_option( "cs_trans_albums", '<?xml version="1.0"?><trans_albums><release_date>Release Date</release_date><buy_now>Buy Now</buy_now><lyrics>Lyrics</lyrics><download>Download</download><play>Play</play><pause>Pause</pause><amazon>Amazon</amazon><itunes>ITunes</itunes><grooveshark>GrooveShark</grooveshark><soundcloud>SoundCloud</soundcloud></trans_albums>' );
		update_option( "cs_trans_contact", '<?xml version="1.0"?><trans_contact><form_title>Quick Inquiry</form_title><contact_no>Contact No</contact_no><message>Message</message><captcha>Enter Captcha</captcha><refresh_captcha>Refresh Captcha</refresh_captcha><name_error>Name field is invalid or empty</name_error><email_error>Email field is invalid or empty</email_error><contact_no_error>Contact no. field is invalid or empty</contact_no_error><message_error>Message field is invalid or empty</message_error><captcha_error>Captcha field is invalid or empty</captcha_error></trans_contact>' );
		update_option( "cs_trans_others", '<?xml version="1.0"?><trans_others><title_404>Page Not Found</title_404><content_404>It seems we can&#x2019;t find what you&#x2019;re looking for.</content_404><share_this_post>Share This Post</share_this_post><featured_post>Featured</featured_post><follow_us>Follow Us</follow_us><follow_us_on>Follow Us on</follow_us_on><need_an_account>Need an Account?</need_an_account><newsletter>Newsletter</newsletter><newsletter_thanks>Thanks for subscribing</newsletter_thanks></trans_others>' );
		update_option( "cs_gs_other_setting", '<?xml version="1.0"?><cs_gs_other_settings><cs_responsive>on</cs_responsive><cs_rtl></cs_rtl><cs_transwitch></cs_transwitch></cs_gs_other_settings>' );
		// adding translation end
		update_option( "cs_default_pages", '<?xml version="1.0"?><cs_default_pages><cs_pagination>Show Pagination</cs_pagination><record_per_page>5</record_per_page><cs_layout>right</cs_layout><cs_sidebar_right>Sidebar</cs_sidebar_right></cs_default_pages>' );
		update_option( 'TWITTER_SCREEN_NAME', 'evanto' );
		update_option( 'TWITTER_CONSUMER_KEY', 'BUVzW5ThLW8Nbmk9rSFag' );
		update_option( 'TWITTER_CONSUMER_SECRET', 'J8LDM3SOSNuP2JrESm8ZE82dv9NtZzer091ZjlWI' );
		update_option( 'TWITTER_BEARER_TOKEN', 'AAAAAAAAAAAAAAAAAAAAAGt%2FSAAAAAAAc7UCkKRfPuPoB6HE1TAQWmd%2FNmQ%3DNqMKXtYlXw7ELrLszYipiree7idpL4zDP53fSFxzYg');

	// adding general settings end
}
// installing tables on theme activating end
}
// custom sidebar start
$counter = 0;
 $parts = explode( "<name>", get_option("cs_sidebar") );
 foreach ( $parts as $val ) {
  if ( $val <> "" ) {
   $counter++;
    register_sidebar(array(
      'name' => $val,
      'id' => $val,
      'description' => 'This widget will be displayed on right side of the page.',
      'before_widget' => '<div class="box-small %2$s">',
      'after_widget' => '</div><div class="clear"></div>',
      'before_title' => '<h1 class="heading">',
      'after_title' => '</h1>'
    ));
  }
 }
// custom sidebar end

function admin_scripts_enqueue() 
{
	$template_path = get_template_directory_uri().'/scripts/admin/media_upload.js';
	wp_enqueue_script('my-upload', $template_path, array('jquery','media-upload','thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider','wp-color-picker'));
	wp_enqueue_script('custom_wp_admin_script', get_template_directory_uri().'/scripts/admin/cs_functions.js');
	wp_enqueue_style('custom_wp_admin_style', get_template_directory_uri().'/css/admin/style-page.css', array('thickbox'));
	wp_enqueue_style('wp-color-picker');
}

function front_scripts_enqueue()
{
	if(!is_admin())
	{	
		
		global $cs_responsive,$cs_rtl,$prettyphoto_flag;	
 		wp_enqueue_style('base_css', get_template_directory_uri() . '/css/base.css');
 		wp_enqueue_style('style_css', get_template_directory_uri() . '/style.css');
		wp_enqueue_style('bootstrap_css', get_template_directory_uri() . '/css/bootstrap.css');
   		if($cs_responsive == "on"){
 			wp_enqueue_style('skeleton_css', get_template_directory_uri() . '/css/skeleton.css');
		}
		if($cs_rtl == "on"){
 			wp_enqueue_style('rtl_css', get_template_directory_uri() . '/css/rtl.css');
		}
  		wp_enqueue_script('jquery');
		
 		wp_enqueue_script('easing_js', get_template_directory_uri() . '/scripts/frontend/jquery.easing.1.3.js', '', '', true);
		wp_enqueue_script('bootstrap_js', get_template_directory_uri() . '/scripts/frontend/bootstrap.min.js', '', '', true);
		wp_enqueue_script('functions_js', get_template_directory_uri() . '/scripts/frontend/functions.js', '', '', true);
 	}
}

// Enqueue album track files
function enqueue_alubmtrack_format_resources($format='') {
    
        if($format=='widget'){
			wp_enqueue_style('player_css', get_template_directory_uri() . '/css/player.css');
            wp_enqueue_script('jplayer_js', get_template_directory_uri() . '/scripts/frontend/jquery.jplayer.min.js', '', '', true);
            wp_enqueue_script('playlist_js', get_template_directory_uri() . '/scripts/frontend/jplayer.playlist.min.js', '', '', true);
        } else {
            wp_enqueue_script('jplayer_js', get_template_directory_uri() . '/scripts/frontend/jquery.jplayer.min.js', '', '', true);
            wp_enqueue_script('mod_js', get_template_directory_uri() . '/scripts/frontend/mod.js', '', '', true);
        }
 }
 
// Enqueue Gallery files
function enqueue_gallery_format_resources() {
     wp_enqueue_style('prettyPhoto_css', get_template_directory_uri() . '/css/prettyPhoto.css');
	 wp_enqueue_script('prettyPhoto_js', get_template_directory_uri() . '/scripts/frontend/jquery.prettyPhoto.js', '', '', true);
 } 
 
 // Enqueue events files
function event_enqueue_styles_scripts() {
    wp_enqueue_style('fullcalendar_css', get_template_directory_uri() . '/css/fullcalendar.css');
    wp_enqueue_script('fullcalendar.min_js', get_template_directory_uri() . '/scripts/frontend/fullcalendar.min.js', '', '', true);
    wp_enqueue_script('jquery-ui-1.8.23.min_js', get_template_directory_uri() . '/scripts/frontend/jquery-ui-1.8.23.min.js', '', '', true);
}
// Enqueue contact files
function contact_enqueue_scripts() {
	wp_enqueue_script('validate.metadata_js', get_template_directory_uri() . '/scripts/admin/jquery.validate.metadata.js', '', '', true);
    wp_enqueue_script('validate_js', get_template_directory_uri() . '/scripts/admin/jquery.validate.js', '', '', true);
    
}
// Enqueue countdown  files
function countdown_enqueue_scripts() {
    
        wp_enqueue_script('countdown_js', get_template_directory_uri() . '/scripts/frontend/jquery.countdown.js', '', '', TRUE);
}
//end function

// Enqueue countdown  files
function filterable_enqueue_scripts() {
         wp_enqueue_script('filterable_js', get_template_directory_uri() . '/scripts/frontend/jquery-filterable.js', '', '', TRUE);
}
//end function
// Enqueue Slider files
function slider_enqueue_style_scripts($format) {
    if($format=='Nivo Slider')
        wp_enqueue_script('nivo.slider_js', get_template_directory_uri() . '/scripts/frontend/jquery.nivo.slider.js', '', '', TRUE);
    else if($format=='Sudo Slider')
        wp_enqueue_script('sudoslider.min_js', get_template_directory_uri() . '/scripts/frontend/jquery.sudoslider.min.js', '', '', TRUE);
    else {
        wp_enqueue_script('anythingslider_js', get_template_directory_uri() . '/scripts/frontend/jquery.anythingslider.js', '', '', TRUE);
        wp_enqueue_script('anythingslider.fx_js', get_template_directory_uri() . '/scripts/frontend/jquery.anythingslider.fx.js', '', '', TRUE);
        wp_enqueue_script('anythingslider.video_js', get_template_directory_uri() . '/scripts/frontend/jquery.anythingslider.video.js', '', '', TRUE);
    }
}

//end function
// Enqueue Twitter Files
function twitter_enqueue_scripts() {
          wp_enqueue_script('jquery.jcarousel.min_js', get_template_directory_uri() . '/scripts/frontend/jquery.jcarousel.min.js', '', '', TRUE);
 }
add_action( 'admin_enqueue_scripts', 'admin_scripts_enqueue' ); 
add_action( 'wp_enqueue_scripts', 'front_scripts_enqueue' ); 

$inc_path = (TEMPLATEPATH.'/include/');
require_once ($inc_path.'default_pages_manage.php');
require_once ($inc_path.'album.php');
require_once ($inc_path.'event.php');
require_once ($inc_path.'newsletter_manage.php');
require_once ($inc_path.'home_page_settings.php');
require_once ($inc_path.'general_options.php');
require_once ($inc_path.'social_network.php');
require_once ($inc_path.'manage_languages.php');
require_once ($inc_path.'translation.php');
require_once ($inc_path.'manage_sidebars.php');
require_once ($inc_path.'fonts.php');
require_once ($inc_path.'cs_meta_box.php');
require_once ($inc_path.'cs_meta_post.php');
require_once ($inc_path.'slider.php');
require_once ($inc_path.'slider_setting.php');
require_once ($inc_path.'gallery.php');
require_once ($inc_path.'short_code.php');
require_once ($inc_path.'twitter_settings.php');
 
add_action('admin_menu','my_new_theme');
function my_new_theme(){
	
	add_theme_page( 'Chimp Theme Option', 'Chimp Theme Option', 'manage_options', basename(__FILE__), 'general_options', get_template_directory_uri()."/images/admin/cs-icon.png" );
 	add_theme_page( '', '', 'read', 'general_options', 'general_options' );
	add_theme_page( '', '', 'read','home_page_settings', 'home_page_settings' );
	add_theme_page( '', '', 'read','fonts', 'fonts' );
	add_theme_page( '', '', 'read','manage_sidebars', 'manage_sidebars' );
	add_theme_page( '', '', 'read','slider_setting', 'slider_setting' );
	add_theme_page( '', '', 'read','social_network', 'social_network' );
	add_theme_page( '', '', 'read','manage_languages', 'manage_languages' );
	add_theme_page( '', '', 'read','translation', 'translation' );
	add_theme_page( '', '', 'read','default_pages_manage', 'default_pages_manage' );
	add_theme_page( '', '', 'read','newsletter_manage', 'newsletter_manage');
	add_theme_page( '', '', 'read','twitter_settings', 'twitter_settings');
}

//Content Width
if ( ! isset( $content_width ) ) $content_width = 640;
$args = array(
	'default-color' => '',
	'default-image' => '',
);
add_theme_support( 'custom-background', $args );
add_theme_support( 'custom-header', $args );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	define('CSDOMAIN', 'rockit');
	load_theme_textdomain( CSDOMAIN, get_template_directory() . '/languages' );

//	$locale = get_locale();
//	$locale_file = get_template_directory() . "/languages/$locale.php";
//	if ( is_readable( $locale_file ) )
//		require_once( $locale_file );

//Home Page Sidebar
register_sidebar( array(
	'name' => __( 'Front-Page Widget Area',CSDOMAIN),
	'id' => 'homepage-sidebar',
	'description' => 'This Widget Show the Content of Home Sidebar.',
	'before_widget' => '<div class="one-third column small-banners box-small %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h1 class="heading">',
	'after_title' => '</h1>'
) );

function register_my_menus() {
  register_nav_menus(
	array(
	  'top-menu'  => __('Main Menu',CSDOMAIN),
	  'footer-menu' => __( 'Footer Menu',CSDOMAIN )
	)
  );
}
add_action( 'init', 'register_my_menus' ); 

	$inc_path = (TEMPLATEPATH.'/include/widgets/');
	require_once ($inc_path.'cs_event_countdown_widget.php');
 	require_once ($inc_path.'cs_music_playlist_widget.php');
	require_once ($inc_path.'cs_recent_event_widget.php');
	require_once ($inc_path.'cs_facebook_widget.php');
	require_once ($inc_path.'cs_twitter_widget.php');
	require_once ($inc_path.'cs_archive_widgets.php');

	

class New_Wolker_Menu extends Walker_Nav_Menu {
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ){
	    $GLOBALS['menu_children'] = ( isset($children_elements[$element->ID]) )? 1:0;
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}
add_filter('nav_menu_css_class','add_parent_css',10,2);
function  add_parent_css($classes, $item){
     global  $menu_children;
     if($menu_children)
         $classes[] = 'parent';
    return $classes;
}	


// adding custom images while uploading media start
	 add_image_size('cs_media_1', 980, 418, true);
	 add_image_size('cs_media_2', 980, 228, true);
	 add_image_size('cs_media_3', 580, 244, true);
	 add_image_size('cs_media_4', 438, 288, true);
	 add_image_size('cs_media_5', 208, 208, true);
	 add_image_size('cs_media_6', 120, 95, true);
	 add_image_size('cs_media_7', 62, 58, true);
// adding custom images while uploading media end

if ( ! function_exists( 'PixFill_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own PixFill_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function PixFill_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$args['reply_text'] = __('Reply', CSDOMAIN);
	switch ( $comment->comment_type ) :
		case '' :
	?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div id="comment-<?php comment_ID(); ?>">
		<div class="avatars">
			<?php echo get_avatar( $comment, 40 ); ?>
        </div>
		<div class="desc">
            <div class="desc-in">
                <span class="pointer">&nbsp;</span>
                <div class="text-desc">
                    <h5><?php printf( __( '%s', CSDOMAIN ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?></h5>
                    <p class="ago">
                        <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                            <?php
                                /* translators: 1: date, 2: time */
                                printf( __( '%1$s at %2$s', CSDOMAIN ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', CSDOMAIN ), ' ' );
                            ?>
                    </p>
                    <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                    <?php if ( $comment->comment_approved == '0' ) : ?>
                        <div class="comment-awaiting-moderation backcolr"><?php _e( 'Your comment is awaiting moderation.', CSDOMAIN ); ?></div>
                    <?php endif; ?>
                    <div class="txt">
                        <?php comment_text(); ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
		</div>
	</div>
</li>
	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', CSDOMAIN ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', CSDOMAIN ), ' ' ); ?></p>
    </li>
	<?php
			break;
	endswitch;
?>
<?php
	
}
endif;

if ( ! function_exists( 'posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', CSDOMAIN );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', CSDOMAIN );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', CSDOMAIN );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;
function social_share(){
	global $cs_transwitch;
	$cs_social_share = get_option("cs_social_share");
	$xmlObject_album = new SimpleXMLElement($cs_social_share);
	$twitter = $xmlObject_album->twitter;
	$facebook = $xmlObject_album->facebook;
	$linkedin = $xmlObject_album->linkedin;
	$digg = $xmlObject_album->digg;
	$delicious = $xmlObject_album->delicious;
	$google_plus = $xmlObject_album->google_plus;
	$google_buzz = $xmlObject_album->google_buzz;
	$google_bookmark = $xmlObject_album->google_bookmark;
	$myspace = $xmlObject_album->myspace;
	$reddit = $xmlObject_album->reddit;
	$stumbleupon = $xmlObject_album->stumbleupon;
	$yahoo_buzz = $xmlObject_album->yahoo_buzz;
	$rss = $xmlObject_album->rss;
	if($twitter == 'on' or $facebook == 'on' or $linkedin == 'on' or $digg == 'on' or $delicious == 'on' or $google_plus == 'on' or $google_buzz == 'on' or $google_bookmark == 'on' or $myspace == 'on' or $reddit == 'on' or $stumbleupon == 'on' or $yahoo_buzz == 'on' or $rss == 'on'){
	$pageurl = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?>
	<h6><?php  if($cs_transwitch =='on'){ _e('Share This Post',CSDOMAIN); }else{ echo __CS('share_this_post', 'Share This Post'); } ?></h6>
	<?php if($twitter == 'on'){?><a href="http://twitter.com/home?status=<?php the_title();?> - <?php echo $pageurl;?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/twitter.png" alt="" /></a><?php }?>
	<?php if($facebook == 'on'){?><a href="http://www.facebook.com/share.php?u=<?php echo $pageurl."&t="?><?php the_title()?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/facebook.png" alt="" /></a><?php }?>
	<?php if($linkedin == 'on'){?><a href="http://www.linkedin.com/shareArticle?mini=true&#038;url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/linkedin.png" alt="" /></a><?php }?>
	<?php if($digg == 'on'){?><a href="http://digg.com/submit?url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/digg.png" alt="" /></a><?php }?>												
	<?php if($delicious == 'on'){?><a href="http://delicious.com/post?url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/delicious.png" alt="" /></a><?php }?>
	<?php if($google_bookmark == 'on'){?><a href="http://www.google.com/bookmarks/mark?op=edit&#038;bkmk=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/google_bookmark.png" alt="" /></a><?php }?>
	<?php if($google_buzz == 'on'){?><a href="http://www.google.com/reader/link?title=<?php the_title();?>&url=<?php the_permalink();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/google_buzz.png" alt="" /></a><?php }?>												
	<?php if($google_plus == 'on'){?><a href="https://plus.google.com/share?url=<?php the_permalink();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/google_plus.png" alt="" /></a><?php }?>																																																
	<?php if($myspace == 'on'){?><a href="http://www.myspace.com/Modules/PostTo/Pages/?u=<?php echo $pageurl;?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/myspace.png" alt="" /></a><?php }?>
	<?php if($reddit == 'on'){?><a href="http://reddit.com/submit?url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/reddit.png" alt="" /></a><?php }?>
	<?php if($stumbleupon == 'on'){?><a href="http://www.stumbleupon.com/submit?url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/stumbleupon.png" alt="" /></a><?php }?>
	<?php if($yahoo_buzz == 'on'){?><a href="#" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/yahoo_buzz.png" alt="" /></a><?php }?>                                                                                                                                
	<?php if($rss == 'on'){?><a href="<?php bloginfo('rss_url'); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/rss.png" alt="" /></a><?php }?>												
	<?php }?>
<?php 	

}
// Use a static front page
$home = get_page_by_title( 'Home' );
if($home <> '' && get_option( 'page_on_front' ) == "0"){
update_option( 'page_on_front', $home->ID );
update_option( 'show_on_front', 'page' );
}
// password protect post/page
function pixfill_password_form() {
	

    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = '<div class="password_protector">
 			<h5>' . __( "This post is password protected. To view it please enter your password below:",CSDOMAIN ) . '</h5>';
	$o .= '<div class="req_password">
				<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post"><input class="webkit" name="post_password" id="' . $label . '" type="password" size="20" /><input class="backcolr" type="submit" name="Submit" value="' . esc_attr__( "Submit" ) . '" />
    			</form>
	 		</div>
       	</div>';
    return $o;
}
add_filter( 'the_password_form', 'pixfill_password_form' );
function featured(){
	global $cs_transwitch;
if ( is_sticky() ): ?>
<span class="featured"><strong><?php  if($cs_transwitch =='on'){ _e('Featured',CSDOMAIN); }else{ echo __CS('featured_post', 'Featured'); } ?></strong></span>
 <?php endif;  
}
 // add custom post type in author start
function custom_post_author_archive($query) {
    if ($query->is_author or $query->is_month())
        $query->set( 'post_type', array('post', 'albums', 'events' ) );
    remove_action( 'pre_get_posts', 'custom_post_author_archive' );
}
add_action('pre_get_posts', 'custom_post_author_archive');
// add custom post type in author end
function cs_newsletter(){ 
	global $cs_transwitch;	
?>
 <form id="frm_newsletter" action="javascript:frm_newsletter('<?php echo get_template_directory_uri()?>')">
    <div id="newsletter_mess"></div>
    <h5 class="white"><?php if($cs_transwitch =='on'){ _e('NEWSLETTER',CSDOMAIN); }else{ echo __CS('newsletter', 'NEWSLETTER'); }?></h5>
    <ul>
        <li class="left">
            <input type="text" class="bar" name="newsletter_email" value="<?php _e('Email address', CSDOMAIN);?>" onfocus="if(this.value=='<?php _e('Email address', CSDOMAIN);?>') {this.value='';}" onblur="if(this.value=='') {this.value='<?php _e('Email address', CSDOMAIN);?>';}" />
        </li>
        <li class="right">
            <button id="btn_newsletter" class="backcolr"><?php _e('Submit', CSDOMAIN);?></button>
            <div id="process_newsletter"></div>
        </li>
    </ul>
 </form>	
<?php 
}
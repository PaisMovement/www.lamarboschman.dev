<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]--><head>
<?php
// genereal setting start
global $cs_responsive,$prettyphoto_flag,$cs_transwitch,$cs_rtl,$cs_color_scheme;
$cs_style_sheet = '';
$cs_responsive  = '';
$cs_transwitch = '';
$cs_color_scheme = '';
$prettyphoto_flag = "false";
$cs_rtl = '';
	$cs_gs_color_style = get_option( "cs_gs_color_style" );
		if ( $cs_gs_color_style <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_color_style);
				$cs_bg = $sxe->cs_bg;
				$cs_bg_position = $sxe->cs_bg_position;
				$cs_bg_repeat = $sxe->cs_bg_repeat;
				$cs_bg_attach = $sxe->cs_bg_attach;
				$cs_bg_pattern = $sxe->cs_bg_pattern;
				$custome_pattern = $sxe->custome_pattern;
				$cs_bg_color = $sxe->cs_bg_color;
				$cs_color_scheme = $sxe->cs_color_scheme;
				$cs_style_sheet = $sxe->cs_style_sheet;
				if ( $custome_pattern <> "" ) $pattern = get_template_directory_uri()."/images/pattern/".$custome_pattern."-bg.png";
				else $pattern = $cs_bg_pattern;
		}
	$cs_gs_logo = get_option( "cs_gs_logo" );
		if ( $cs_gs_logo <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_logo);
				$cs_logo = $sxe->cs_logo;
				$cs_width = $sxe->cs_width;
				$cs_height = $sxe->cs_height;
		}
	$cs_gs_header_script = get_option( "cs_gs_header_script" );
		if ( $cs_gs_header_script <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_header_script);
				echo $sxe->cs_header_code;
				$cs_fav_icon = $sxe->cs_fav_icon;
		}
	$cs_gs_other_settings = get_option( "cs_gs_other_setting" );
 		if ( $cs_gs_other_settings <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_other_settings);
				$cs_responsive = $sxe->cs_responsive;
				$cs_rtl = $sxe->cs_rtl;
				$cs_transwitch = $sxe->cs_transwitch;
  		}
	// genereal setting end
	$color_picker_enable = 0;
	if ( isset($_POST['color_picker']) ) {
		$_SESSION['color_picker_sess'] = $_POST['color_picker'];
		$cs_color_scheme = $_SESSION['color_picker_sess'];
		$color_picker_enable = 1;
	}
	else if ( isset($_SESSION['color_picker_sess']) ) {
		$cs_color_scheme = $_SESSION['color_picker_sess'];
		$color_picker_enable = 1;
	}
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Mobile Specific Metas
================================================== -->
<title>
<?php
	global $page, $paged;
	wp_title( '|', true, 'right' );

	bloginfo( 'name' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'rockit' ), max( $paged, $page ) );

?>
    </title>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
 
<?php 
 if ( $cs_responsive == "on" ) { ?>
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<?php }?>
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--// Javascript //-->

<?php 
 if ( is_single() && get_option( 'thread_comments' ) ) {	
	wp_enqueue_script( 'comment-reply' );
}
wp_head();

?>
<!--// Favicons //-->
<link rel="shortcut icon" href="<?php echo $cs_fav_icon?>" />



<?php if ( file_exists(TEMPLATEPATH."/color_picker/inc_color_picker.php") ) include_once "color_picker/inc_color_picker.php";?>

<?php
if ( $cs_style_sheet == "custom" or $color_picker_enable == 1 ) {
?>
	<style>
		.colr, 
		.navigation a:focus, 
		.navigation li:hover > a,
		.navigation ul ul :hover > a,
		.navigation .current-menu-item > a,
		.navigation .current_page_item > a,
		.links-foot ul li a:hover,
		.fc-event-inner:hover span,
		.top-links li a:hover
		{color:<?php echo $cs_color_scheme?> !important;}
		
		#login-box, 
		.navigation a:focus, 
		.navigation li:hover > a,
		.navigation ul ul :hover > a,
		.navigation .current-menu-item > a,
		.navigation .current_page_item > a,
		.gal-caption,
		.tab-section .tab-head ul li a:hover, 
		.tab-section .tab-head ul li a.current
		 {border-color:<?php echo $cs_color_scheme?> !important;}
		
		.backcolr, 
		.nivo-prevNav:hover, 
		.nivo-nextNav:hover,
		.anythingSlider-default .arrow:hover,
		#controls a:hover,
		.second-nav ul li.current_page_item a,
		.second-nav ul li a:hover,
		#wp-calendar caption,
		.fourofuor,
		#wp-calendar tbody td a:hover
		{background-color:<?php echo $cs_color_scheme?> !important;}
	</style>
<?php
}
else if ( $cs_style_sheet <> "" && $cs_style_sheet <> "custom" ) {
?>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/custom_styles/<?php echo $cs_style_sheet?>.css" />
<?php
}
?>
  
</head>
<body <?php body_class(); echo ($pattern) ? ' style="background:url('.$pattern.') '.$cs_bg_color.';"' : '' ?>>
<div id="outer-wrapper" <?php echo ($cs_bg) ? ' style="background:url('.$cs_bg.') '.$cs_bg_repeat.' top '.$cs_bg_position.' '.$cs_bg_attach.';"' : '' ?>>
	<div class="inner shadow">
    	<!-- Header Start -->
    	<div id="header">
        	<span class="topbar">&nbsp;</span>
        	<!-- Container Start -->
            <div class="container">
            	<!-- Logo Start -->
            	<a href="<?php echo home_url() ; ?>" class="logo">
                	<img src="<?php echo $cs_logo?>" alt="<?php echo bloginfo( 'name' )?>" width="<?php echo $cs_width?>px" height="<?php echo $cs_height?>px"/>
                </a>
                <!-- Logo End -->
                <div class="sixteen columns right">
                	<!-- Top Links Start -->
                    <ul class="top-links">
                        	<?php  if ( is_user_logged_in() ) { ?>
                                <li><a href="<?php echo wp_logout_url("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>"><?php _e('Log out', CSDOMAIN); ?></a></li>
                                <li>
                                	<a href="<?php echo home_url() ; ?>/wp-admin/">
										<?php 
                                            global $current_user;
                                            echo $current_user->display_name;
                                        ?>
                                	</a>
                                </li>
                            <?php } else { ?>
                                  <li><a href="javascript:cs_amimate('login-box')"><?php _e('Log In', CSDOMAIN); ?></a></li>
                                <div id="login-box">
                                    <ul>
                                        <form action="<?php echo home_url(); ?>/wp-login.php" method="post">
                                            <li><h4 class="white"><?php _e('Log In', CSDOMAIN); ?></h4></li>
                                            <li>
                                                <input name="log" onfocus="if(this.value=='yourname@email.com') {this.value='';}"
                                                onblur="if(this.value=='') {this.value='yourname@email.com';}" id="user_login" type="text" class="bar" />
                                            </li>
                                            <li>
                                                <input name="pwd" value="password"
                                                onfocus="if(this.value=='password') {this.value='';}"
                                                onblur="if(this.value=='') {this.value='password';}" type="password" class="bar" />
                                            </li>
                                            <li>
                                                <input type="hidden" name="redirect_to" value="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" />                                        
                                                <input name="rememberme" value="forever" id="rememberme" type="checkbox" class="left" />
                                                <p><?php _e('Remember Me', CSDOMAIN); ?></p>
                                            </li>
                                            <li>
                                                <button name="submit" class="backcolr"><?php _e('Log In', CSDOMAIN); ?></button>
                                            </li>
                                        </form>
                                    </ul>
                                    <div class="forgot">
                                        <a href="<?php echo home_url() ; ?>/wp-login.php?action=lostpassword"><?php _e('Lost your password?', CSDOMAIN); ?></a>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            <?php }?>
                            
                       
							<?php
                            if ( get_option("users_can_register") == 1 and !is_user_logged_in() ) {
                            ?>
		                        <li><a href="<?php echo home_url() ; ?>/wp-login.php?action=register"><?php _e('Signup', CSDOMAIN); ?></a></li>
							<?php
							}
                            ?>
                        <li>
                        	<a href="javascript:cs_amimate('search-box')"><?php _e('Search', CSDOMAIN); ?></a>
                            <div id="search-box"><?php get_search_form(); ?></div>
                        </li>
                    </ul>
                    <div class="clear"></div>
                    <!-- Top Links End -->
                    <!-- Navigation Start -->
                    <div class="navigation">
					<script>
							// DOM ready
						 
                        </script>
					<nav class="ddsmoothmenu">
							<?php 
								// Menu parameters		
								$defaults = array(
								  'theme_location'  => 'top-menu',
								  'menu'            => '', 
								  'container'       => '', 
								  'container_class' => 'menu-{menu slug}-container', 
								  'container_id'    => '',
								  'menu_class'      => 'main-navi', 
								  'menu_id'         => '',
								  'echo'            => true,
								  'fallback_cb'     => 'wp_page_menu',
								  'before'          => '',
								  'after'           => '',
								  'link_before'     => '',
								  'link_after'      => '',
								  'items_wrap'      => '<ul>%3$s</ul>',
								  'depth'           => 0,
								  'walker'          => '',);				
								wp_nav_menu( $defaults); 
							?>
                        	<div class="clear"></div>
                        </nav>
                    </div>
                    <!-- Navigation End -->
                    <div class="clear"></div>
                </div>
            </div>
            <!-- Container End -->
        </div>
        <!-- Header End -->
        <div class="clear"></div>
<?php 
if(is_front_page() or is_home()){
	global $node,$get_slider_id;
	$show_slider = "";
	$slider_name = "";
	$get_slider_id = "";
	$cs_home_page_slider = get_option("cs_home_page_slider");
 	if ( $cs_home_page_slider <> "" ) {
		$xmlObject = new SimpleXMLElement($cs_home_page_slider);
 			$node = new stdClass();
			$show_slider = $xmlObject->show_slider;
 			$node->slider_type = $xmlObject->slider_type;
			$slider_name = $xmlObject->slider_name;
			
	}
?>
<div class="inner shadow">
  	<!-- Banner Start -->
        <?php
        if ($show_slider == 'on' and $slider_name <> '') {
			$args=array(
			  'name' => $slider_name,
			  'post_type' => 'cs_slider',
			  'post_status' => 'publish',
			  'showposts' => 1,
			);
 			$get_posts = get_posts($args);
			if($get_posts){
				$get_slider_id = $get_posts[0]->ID;
			}
			$counter_gal = 1;
			$node->width = 980;
			$node->height = 418;
		?>               	
		    <div class="banner row">
                <?php get_template_part('page_slider','page');?>
			</div>
		<?php }else{
			echo '<div class="box-small no-results-found"> <h5>';
				_e("No results found.",CSDOMAIN);
			echo ' </h5></div>';
			
			}
		?>
        <div class="container">
			<?php
                // Home Page Sidebar
                if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('homepage-sidebar') ) : endif;
            ?>
        </div>
        <div class="clear"></div>
<?php } ?>
<?php
class facebook_module extends WP_Widget
{
  function facebook_module()
  {
    $widget_ops = array('classname' => 'facebook_module', 'description' => 'Facebook widget like box total customized with theme.' );
    $this->WP_Widget('facebook_module', 'ChimpS : Facebook', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
	$pageurl = isset( $instance['pageurl'] ) ? esc_attr( $instance['pageurl'] ) : '';
	$showfaces = isset( $instance['showfaces'] ) ? esc_attr( $instance['showfaces'] ) : '';
	$showstream = isset( $instance['showstream'] ) ? esc_attr( $instance['showstream'] ) : '';
	$showheader = isset( $instance['showheader'] ) ? esc_attr( $instance['showheader'] ) : '';
	$fb_bg_color = isset( $instance['fb_bg_color'] ) ? esc_attr( $instance['fb_bg_color'] ) : '';
	$likebox_height = isset( $instance['likebox_height'] ) ? esc_attr( $instance['likebox_height'] ) : '';						
?>
 
  <p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
	  Title: 
	  <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size='40' name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
  </p> 
  <p>
  <label for="<?php echo $this->get_field_id('pageurl'); ?>">
	  Page URL: 
	  <input class="upcoming" id="<?php echo $this->get_field_id('pageurl'); ?>" size='40' name="<?php echo $this->get_field_name('pageurl'); ?>" type="text" value="<?php echo esc_attr($pageurl); ?>" />
	<br />
      <small>Please enter your page or User profile url example: http://www.facebook.com/profilename OR <br />
      https://www.facebook.com/pages/wxyz/123456789101112
	</small><br />
    <!--<strong>Only People Will Be Shown Please Use Height to Manage Your View.</strong>-->
  </label>
  </p> 
  <p>
  <label for="<?php echo $this->get_field_id('showfaces'); ?>">
	  Show Faces: 
	  <input class="upcoming" id="<?php echo $this->get_field_id('showfaces'); ?>" name="<?php echo $this->get_field_name('showfaces'); ?>" type="checkbox" <?php if(esc_attr($showfaces) != '' ){echo 'checked';}?> />
  </label>
  </p> 
  <p>
  <label for="<?php echo $this->get_field_id('showstream'); ?>">
	  Show Stream: 
	  <input class="upcoming" id="<?php echo $this->get_field_id('showstream'); ?>" name="<?php echo $this->get_field_name('showstream'); ?>" type="checkbox" <?php if(esc_attr($showstream) != '' ){echo 'checked';}?> />
  </label>
  </p> 
  <!--<p>
  <label for="<?php echo $this->get_field_id('likebox_width'); ?>">
	  Like Box Width:
	  <input class="upcoming" id="<?php echo $this->get_field_id('likebox_width'); ?>" size='5' name="<?php echo $this->get_field_name('likebox_width'); ?>" type="text" value="<?php echo esc_attr($likebox_width); ?>" />
  </label>
  </p>-->
  <p>
  <label for="<?php echo $this->get_field_id('likebox_height'); ?>">
	  Like Box Height:
	  <input class="upcoming" id="<?php echo $this->get_field_id('likebox_height'); ?>" size='2' name="<?php echo $this->get_field_name('likebox_height'); ?>" type="text" value="<?php echo esc_attr($likebox_height); ?>" />
  </label>
  </p>
	<p>		
     <label for="<?php echo $this->get_field_id('fb_bg_color'); ?>">
     	Background Color:
  		<input type="text" name="<?php echo $this->get_field_name('fb_bg_color'); ?>" size='2' id="<?php echo $this->get_field_id('fb_bg_color'); ?>"  value="<?php echo $fb_bg_color; ?>" class="fb_bg_color upcoming"  />
    </label>
    </p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
	$instance['pageurl'] = $new_instance['pageurl'];
	$instance['showfaces'] = $new_instance['showfaces'];	
	$instance['showstream'] = $new_instance['showstream'];
	$instance['showheader'] = $new_instance['showheader'];	
	$instance['fb_bg_color'] = $new_instance['fb_bg_color'];
	$instance['likebox_height'] = $new_instance['likebox_height'];			
    return $instance;
  }

	function widget($args, $instance)
	{
		global $cs_transwitch;
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$pageurl = empty($instance['pageurl']) ? ' ' : apply_filters('widget_title', $instance['pageurl']);
		$showfaces = empty($instance['showfaces']) ? ' ' : apply_filters('widget_title', $instance['showfaces']);
		$showstream = empty($instance['showstream']) ? ' ' : apply_filters('widget_title', $instance['showstream']);
		$showheader = empty($instance['showheader']) ? ' ' : apply_filters('widget_title', $instance['showheader']);
		$fb_bg_color = empty($instance['fb_bg_color']) ? ' ' : apply_filters('widget_title', $instance['fb_bg_color']);								
		$likebox_height = empty($instance['likebox_height']) ? ' ' : apply_filters('widget_title', $instance['likebox_height']);													
		if(isset($showfaces) AND $showfaces == 'on'){$showfaces ='true';}else{$showfaces = 'false';}
		if(isset($showstream) AND $showstream == 'on'){$showstream ='true';}else{$showstream ='false';}
		
		echo $before_widget;	
		// WIDGET display CODE Start
		if (!empty($title))
			echo $before_title;
			echo $title;
			echo $after_title;
			global $wpdb, $post;?>
			<style type="text/css">
			 .facebookOuter {
				background-color:<?php echo $fb_bg_color ?>; 
				width:100%; 
				padding:10px 0 10px 10px;
				height:<?php echo $likebox_height;?>px;
 			  }
			 .facebookInner {
				height:<?php echo $likebox_height;?>px;
				width: 100%;
				
			  }
			 
			</style>
			<div class="facebookOuter">
			 <div class="facebookInner">
			  <div class="fb-like-box" 
				  colorscheme ="light" data-width="300" data-height="<?php echo $likebox_height;?>" 
				  data-href="<?php echo $pageurl;?>" 
				  data-border-color="<?php echo $fb_bg_color; ?>" data-show-faces="<?php echo $showfaces;?>" 
				  data-show-border="false" data-stream="<?php echo $showstream;?>" data-header="false">
			  </div>          
			 </div>
			</div>
					   
			<div id="fb-root"></div>

			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
			</script>
             
	<?php echo $after_widget;
		}
		
	}
add_action( 'widgets_init', create_function('', 'return register_widget("facebook_module");') );?>
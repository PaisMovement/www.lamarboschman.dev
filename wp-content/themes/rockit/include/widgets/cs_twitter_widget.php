<?php
class cs_twitter_widget extends WP_Widget
{
  function cs_twitter_widget()
  {
    $widget_ops = array('classname' => 'cs_twitter_widget', 'description' => 'Twitter Widget feeds' );
    $this->WP_Widget('cs_twitter_widget', 'ChimpS : Twitter Widget', $widget_ops);
  }
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
	$t_img_url = isset( $instance['t_img_url'] ) ? esc_attr( $instance['t_img_url'] ) : '';
	$numoftweets = isset( $instance['numoftweets'] ) ? esc_attr( $instance['numoftweets'] ) : '';	

?>

<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"> <span>Twitter Username </span><br />
    <span>http://www.twitter.com/your-username  - Only {your-username}</span>
    <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('t_img_url'); ?>"> <span>Background Url: </span>
    <input class="upcoming" id="<?php echo $this->get_field_id('t_img_url'); ?>" size="40" name="<?php echo $this->get_field_name('t_img_url'); ?>" type="text" value="<?php echo esc_attr($t_img_url); ?>" />
  </label>
</p>
<p>
<label for="<?php echo $this->get_field_id('numoftweets'); ?>"> <span>Num of Tweets: </span>
  <input class="upcoming" id="<?php echo $this->get_field_id('numoftweets'); ?>" size="2" name="<?php echo $this->get_field_name('numoftweets'); ?>" type="text" value="<?php echo esc_attr($numoftweets); ?>" />
  <div class="clear">
  </div>
</label>
</p>
<?php
  }
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['t_img_url'] = $new_instance['t_img_url'];	
	$instance['numoftweets'] = $new_instance['numoftweets'];	
		

    return $instance;
  }

  function widget($args, $instance)
  {
 	
	global $cs_transwitch,$username;
	extract($args, EXTR_SKIP);
	$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$numoftweets = empty($instance['numoftweets']) ? ' ' : apply_filters('widget_title', $instance['numoftweets']);


	// WIDGET display CODE Start
	if (!empty($title))
	echo $before_widget;
	//echo $before_title .$title. $after_title;
	//	echo '<div class="tweet-banners"><a href="#" class="thumb"><img src="'.$instance['t_img_url'].'" alt="" /><span>&nbsp;</span></a>';
	//	echo "<div class='scroll-sec'>";
	$username = $instance['title'];
	if(strlen($username) > 1){?>
<a class="thumb"><img src="<?php echo $instance['t_img_url'];?>" alt="" width="300" height="188"/></a> 
<!-- Twitter Scroll Start -->
<div class="scroll-sec">
  <div id="tweet-links">
    <?php 
		global $username;
		$return = '';
		$exclude_replies = '0';
		$include_rts = '0';
		$token = get_option( 'TWITTER_BEARER_TOKEN' );
		$screen_name = $title;
		 if($token && $screen_name) {
		$args = array(
			'httpversion' => '1.1',
			'blocking' => true,
			'headers' => array( 
				'Authorization' => "Bearer $token"
			)
		);
		add_filter('https_ssl_verify', '__return_false');
		$api_url = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=$screen_name&count=$numoftweets&exclude_replies=$exclude_replies&include_rts=$include_rts";
		
		$response = wp_remote_get( $api_url, $args );
		if(!is_wp_error($response)){
		$tweets = json_decode($response['body']);
		
		$return .= "<div class='scroll-sec main_carousel'><div id='mycarouselcontent' class='scroller' ><ul>";
		foreach($tweets as $i => $tweet) {
			$text = $tweet->{'text'}; 
			foreach($tweet->{'entities'} as $type => $entity) {
				if($type == 'urls') {						
					foreach($entity as $j => $url) {
						$update_with = '<a href="' . $url->{'url'} . '" target="_blank" title="' . $url->{'expanded_url'} . '">' . $url->{'display_url'} . '</a>';
						$text = str_replace($url->{'url'}, $update_with, $text);
					}
				} else if($type == 'hashtags') {
					foreach($entity as $j => $hashtag) {
						$update_with = '<a href="https://twitter.com/search?q=%23' . $hashtag->{'text'} . '&src=hash" target="_blank" title="' . $hashtag->{'text'} . '">#' . $hashtag->{'text'} . '</a>';
						$text = str_replace('#'.$hashtag->{'text'}, $update_with, $text);
					}
				} else if($type == 'user_mentions') {
					foreach($entity as $j => $user) {
						$update_with = '<a href="https://twitter.com/' . $user->{'screen_name'} . '" target="_blank" title="' . $user->{'name'} . '">@' . $user->{'screen_name'} . '</a>';
						$text = str_replace('@'.$user->{'screen_name'}, $update_with, $text);
					}
				}					
			}
			 $large_ts = time();
			  $n = $large_ts - strtotime($tweet->{'created_at'});
			  if($n < (60)){ $posted = sprintf(__('%d seconds ago','rotatingtweets'),$n); }
			  elseif($n < (60*60)) { $minutes = round($n/60); $posted = sprintf(_n('About a Minute Ago','%d Minutes Ago',$minutes,'rotatingtweets'),$minutes); }
			  elseif($n < (60*60*16)) { $hours = round($n/(60*60)); $posted = sprintf(_n('About an Hour Ago','%d Hours Ago',$hours,'rotatingtweets'),$hours); }
			  elseif($n < (60*60*24)) { $hours = round($n/(60*60)); $posted = sprintf(_n('About an Hour Ago','%d Hours Ago',$hours,'rotatingtweets'),$hours); }
			  elseif($n < (60*60*24*6.5)) { $days = round($n/(60*60*24)); $posted = sprintf(_n('About a Day Ago','%d Days Ago',$days,'rotatingtweets'),$days); }
			  elseif($n < (60*60*24*7*3.5)) { $weeks = round($n/(60*60*24*7)); $posted = sprintf(_n('About a Week Ago','%d Weeks Ago',$weeks,'rotatingtweets'),$weeks); } 
			  elseif($n < (60*60*24*7*4*11.5)) { $months = round($n/(60*60*24*7*4)) ; $posted = sprintf(_n('About a Month Ago','%d Months Ago',$months,'rotatingtweets'),$months);}
			  elseif($n >= (60*60*24*7*4*12)){$years=round($n/(60*60*24*7*52)) ; $posted = sprintf(_n('About a year Ago','%d years Ago',$years,'rotatingtweets'),$years);} 
			$user = $tweet->user->name;
			
			$return .= "<li><div class='twitter-sec'>";
			$return .="<h4 class='white'>".$user."</h4>";
			$return .= "<p class='date'>" . $posted . "</p>";
			$return .= "<p class='txt'>" . $text . "</p>";
			$return .="<span class='pointer'>&nbsp;</span>";
		   
			$return .= "</div></li>";
	}
	$return .= "</ul></div></div>";
	echo $return; 
	}else{
		echo $response->errors['http_failure'][0];
	}
	twitter_enqueue_scripts();
} ?>
    <div class="jcarousel-scroll"> <a  class="jcarousel-prev">Previous</a> <a class="jcarousel-next">Next</a> </div>
  </div>
  <a href="http://www.twitter.com/<?php echo $username;?>" target="_blank" class="follow">
  <?php if($cs_transwitch =='on'){ _e('Follow Us on',CSDOMAIN); }else{ echo __CS('follow_us_on', 'Follow Us on'); } ?>
  Twitter</a> </div>
				
                
<!-- Twitter Scroll End --> 
<!-- Twitter End -->
<?php }else{ ?>
<h1 class="heading">Twitter Widget</h1>
<div class="list-thumb">
  <ul>
    <li>
      <h2>No User information given.</h2>
    </li>
  </ul>
</div>
<?php
	}
	echo $after_widget;
	// WIDGET display CODE End
	}
}
add_action( 'widgets_init', create_function('', 'return register_widget("cs_twitter_widget");') );?>

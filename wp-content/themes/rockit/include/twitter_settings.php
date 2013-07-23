<?php
global $message;
$message = '';
function twitter_authenticate($force = false) {
		$api_key = get_option( 'TWITTER_CONSUMER_KEY' );
		$api_secret = get_option( 'TWITTER_CONSUMER_SECRET' );
		$token = get_option( 'TWITTER_BEARER_TOKEN' );
		
		if($api_key && $api_secret && ( !$token || $force )) {
			$bearer_token_credential = $api_key . ':' . $api_secret;
			$credentials = base64_encode($bearer_token_credential);
			
			$args = array(
				'method' => 'POST',
				'httpversion' => '1.1',
				'blocking' => true,
				'headers' => array( 
					'Authorization' => 'Basic ' . $credentials,
					'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
				),
				'body' => array( 'grant_type' => 'client_credentials' )
			);
			$keys = new stdClass();
			add_filter('https_ssl_verify', '__return_false');
			$response = wp_remote_post( 'https://api.twitter.com/oauth2/token', $args );
			if(!is_wp_error($response)){
				$keys = array();
				$keys = json_decode($response['body']);
				if($keys) {
					global $message;
					if(!empty($keys->access_token)){
						update_option( 'TWITTER_BEARER_TOKEN', $keys->{'access_token'} );
						echo $message = "<div class='form-msgs'><div class='to-notif success-box'><span class='tick'>&nbsp;</span><p>Twitter API Settings Successfully Saved</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
					}else{
						echo $message = "<div class='form-msgs'><div class='to-notif error-box'><span class='error'>&nbsp;</span><p>".$keys->errors[0]->message."</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
					}
					echo $message = "<script>slideout();</script>";
				}
			}else{
				echo $message = "<div class='form-msgs'><div class='to-notif error-box'><span class='error'>&nbsp;</span><p>".$response->errors['http_failure'][0]."</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
				echo $message = "<script>slideout();</script>";
			}
		}
	}

function twitter_settings() {
?>
 <script type="text/javascript">
	jQuery().ready(function($) {
			var container = $('div.container');
			// validate the form when it is submitted
			var validator = $("#frm1").validate({
				errorContainer: container,
				errorLabelContainer: $(container),
				errorElement:'span',
				errorClass:'ele-error',				
				meta: "validate"
			});
		});
	</script>
<div class="theme-wrap fullwidth">
  <?php include "theme_leftnav.php";?>
  <!-- Right Column Start -->
  <div class="col2 left"> 
    <!-- Header Start -->
    <div class="wrap-header">
      <h4 class="bold">Twitter API Settings</h4>
      <div class="clear"></div>
    </div>
    <!-- Header End --> 
    <!-- Content Section Start -->
    <div class="tab-section">
      <div class="tab_menu_container">
        <ul id="tab_menu">
          <li><a href="#uploadlang" class="" rel="tab-uploadlang"><span>Twitter Widget Settings</span></a></li>
        </ul>
        <div class="clear"></div>
      </div>
      <div class="tab_container">
        <div class="tab_container_in">
          <div id="tab-uploadlang" class="tab-list">
            <div class="option-sec">
              <div class="opt-conts">
              <?php 
			  if ( $_SERVER["REQUEST_METHOD"] == "POST" ){			
					update_option( 'TWITTER_CONSUMER_KEY', $_POST['consumer_key'] );
					update_option( 'TWITTER_CONSUMER_SECRET', $_POST['consumer_secret'] );
					update_option( 'TWITTER_SCREEN_NAME', $_POST['screen_name'] );
					twitter_authenticate(true);
				}
				 
			  ?>
                <form name="options" id="frm1" method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                
                  <ul class="form-elements">
                    <li class="to-label">
                      <label for="screen_name">Twitter Username : </label>
                    </li>
                    <li class="to-field">
                      <input type="text" name="screen_name" value="<?php echo get_option( 'TWITTER_SCREEN_NAME', '' ); ?>"  class="{validate:{required:true}}">
                    </li>
                    <li class="to-desc">
                      <p>Please type your twitter username here.</p>
                    </li>
                  </ul>
                  <ul class="form-elements">
                    <li class="to-label">
                      <label for="consumer_key">Consumer Key : </label>
                    </li>
                    <li class="to-field">
                      <input type="text" name="consumer_key" value="<?php echo get_option( 'TWITTER_CONSUMER_KEY', '' ); ?>"  class="{validate:{required:true}}">
                    </li>
                    <li class="to-desc">
                      <p>Please type your twitter Consumer Key here.</p>
                    </li>
                  </ul>
                  <ul class="form-elements">
                    <li class="to-label">
                      <label for="consumer_secret">Consumer Secret : </label>
                    </li>
                    <li class="to-field">
                      <input type="text" name="consumer_secret" value="<?php echo get_option( 'TWITTER_CONSUMER_SECRET', '' ); ?>" class="{validate:{required:true}}">
                    </li>
                     <li class="to-desc">
                      <p>Please type your twitter Consumer Secret here.</p>
                    </li>
                  </ul>
                  <ul class="form-elements">
                    <li class="to-label">
                      <label for="bearer_token">Bearer Token: </label>
                    </li>
                    <li class="to-field">
                      <input type="text" disabled value="<?php echo get_option( 'TWITTER_BEARER_TOKEN', '' ); ?>" >
                    </li>
                    <li class="to-desc">
                      <p>Bearer Token will automatically generated leave it blank.</p>
                    </li>
                  </ul>
                  <ul class="form-elements">
                    <li class="to-label"> </li>
                    <li class="to-field">
                      <input class="button-primary" id="gs_tab_save1"  type="submit" name="save" value="get token and save" />
                    </li>
                    <li class="to-desc">
                    <p>You can sign up for a API.</p>
                    </li>
                  </ul>
                </form>
                </ul>
              </div>
            </div>
          </div>
          <!-- Upload Cufon End -->
          <div class="clear"></div>
        </div>
      </div>
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <!-- Content Section End --> 
  </div>
  <div class="clear"></div>
  <!-- Right Column End --> 
</div>
<?php } ?>

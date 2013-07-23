<?php
function manage_languages() {
	foreach ($_REQUEST as $keys=>$values) {
		$$keys = trim($values);
	}
	
	$message_upload = '';
	if ( empty($mess) ) $mess = '';
	$lang_theme_db = '';
	$lang_theme_db = get_option("lang_theme");
	$lang_style_db = get_option("lang_style");
	if ( isset($submit_upload) ) {
		//$file_name = $_FILES['uploadedfile']['name'];
		$target_path_mo = get_template_directory()."/languages/".$_FILES['uploadedfileMO']['name'];
		if ( file_exists($target_path_mo) ) {
			$message_upload = "<div class='form-msgs'><div class='to-notif error-box'><span class='error'>&nbsp;</span><p>This Language Already Exist</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
		}
		else {
			if ( move_uploaded_file($_FILES['uploadedfileMO']['tmp_name'], $target_path_mo) ) {
				//echo "Allah Is The Greatest <br />";
				chmod($target_path_mo,0777);
				$message_upload = "<div class='form-msgs'><div class='to-notif success-box'><span class='tick'>&nbsp;</span><p>New Language Uploaded</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
			}
			else $message_upload = "<div class='form-msgs'><div class='to-notif error-box'><span class='error'>&nbsp;</span><p>Language Not Uploaded</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
		}
		$message_upload .= "<script>slideout();</script>";
	}
?>

<div class="theme-wrap fullwidth">
  <?php include "theme_leftnav.php";?>
  <!-- Right Column Start -->
  <div class="col2 left"> 
    <!-- Header Start -->
    <div class="wrap-header">
      <h4 class="bold">Manage Languages</h4>
      <div class="clear"></div>
    </div>
    <!-- Header End --> 
    <!-- Content Section Start -->
    <div class="tab-section">
      <div class="tab_menu_container">
        <ul id="tab_menu">
          <li><a href="#uploadlang" class="" rel="tab-uploadlang"><span>Upload New Languages</span></a></li>
        </ul>
        <div class="clear"></div>
      </div>
      <div class="tab_container">
        <div class="tab_container_in">
          <?php 
			echo $message_upload;
			if ( $mess == 1 ) {
				echo "<div class='form-msgs'><div class='to-notif success-box'><span class='tick'>&nbsp;</span><p>Selected Language loaded</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
				echo "<script>slideout();</script>";
			}
			?>
          
          <!-- Upload Cufon Tabs -->
          <div id="tab-uploadlang" class="tab-list">
            <div class="option-sec">
              <form id="frm2" enctype="multipart/form-data" action="admin.php?page=<?php echo $page?>" method="POST">
                <div class="opt-head">
                  <h6>Upload Languages</h6>
                  <p>Upload new language.</p>
                </div>
                <div class="opt-conts">
                  <ul class="form-elements">
                    <li class="to-label">
                      <label>Upload Language (MO File)</label>
                    </li>
                    <li class="to-field">
                      <input id="uploadedfileMO" name="uploadedfileMO" type="file" style="display: none;" onchange="document.getElementById('uploadedfileMO_text').value = this.value;">
                      <div class="fakefile">
                        <input class="{validate:{required:true,accept:'mo'}}" id="uploadedfileMO_text" name="uploadedfileMO_text" type="text" readonly>
                        <input class="left" type="button" onclick="document.getElementById('uploadedfileMO').click();" value="Browse">
                      </div>
                    </li>
                    <li class="to-desc">
                      <p>Please upload new language file (MO format only). It will be uploaded in your theme's languages folder.  
                        Download MO files from <a target="_blank" href="http://translate.wordpress.org/projects/wp/">http://translate.wordpress.org/projects/wp/</a> </p>
                    </li>
                  </ul>
                  <ul class="form-elements">
                    <li class="to-label"></li>
                    <li class="to-field">
                      <input type="submit" name="submit_upload" value="Upload Language" />
                    </li>
                  </ul>
                  <ul class="form-elements noborder">
                    <li class="to-label">
                      <label>Already Uploaded Languages</label>
                    </li>
                    <li class="to-field">
                      <?php
						  $counter = 0;
						  foreach (glob(get_template_directory()."/languages/*.mo") as $filename) {
							  $counter++;
							  $val = str_replace(get_template_directory()."/languages/","",$filename);
							  echo "<p>".$counter . ". " . str_replace(".mo","",$val)."</p>";
						  }
					  ?>
                    </li>
                    <li class="to-desc">
                      <p> Please copy the language name, open config.php file, find WPLANG constant and set its value by replacing the language name. </p>
                    </li>
                  </ul>
                </div>
              </form>
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
<script type="text/javascript">
			jQuery().ready(function($) {
			var container = $('div.container');
			// validate the form when it is submitted
			var validator = $("#frm2").validate({
				errorContainer: container,
				errorLabelContainer: $(container),
				errorElement:'span',
				errorClass:'ele-error',				
				meta: "validate"
			});
		});
</script>
<?php
}
?>

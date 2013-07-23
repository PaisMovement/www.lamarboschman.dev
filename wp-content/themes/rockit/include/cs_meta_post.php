<?php
add_action( 'add_meta_boxes', 'cs_meta_post_add' );
function cs_meta_post_add()
{  
	add_meta_box( 'cs_meta_post', 'Select Layout', 'cs_meta_post', 'post', 'normal', 'high' );  
}
function cs_meta_post( $post ) {
	$post_xml = get_post_meta($post->ID, "post", true);
	if ( $post_xml <> "" ) {
		$xmlObject = new SimpleXMLElement($post_xml);
			$post_social_sharing = $xmlObject->post_social_sharing;
	}
	else {
		$post_social_sharing = '';
	}
?>
	<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script>
	<div class="page-wrap">
        <div class="option-sec row">
            <div class="opt-head">
                <h6>Post Option</h6>
            </div>
            <div class="opt-conts">
				<ul class="form-elements">
                    <li class="to-label">
                        <label>Social Sharing</label>
                    </li>
                    <li class="to-field">
                        <div class="on-off">
                            <input type="checkbox" name="post_social_sharing" value="on" class="styled" <?php if($post_social_sharing=='on')echo "checked"?> />
                        </div>
                    </li>
                    <li class="to-desc">
                        <p>
                            Make Social Sharing On/Off
                        </p>
                    </li>
                </ul>
			</div>
		</div>
		<div class="clear"></div>
		<?php include "inc_meta_layout.php";?>
        <input type="hidden" name="post_meta_form" value="1" />
    </div>
<?php
}
		if ( isset($_POST['post_meta_form']) and $_POST['post_meta_form'] == 1 ) {
			add_action( 'save_post', 'cs_meta_post_save' );
			function cs_meta_post_save( $post_id ) {
				if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
					if ( empty($_POST['post_social_sharing']) ) $_POST['post_social_sharing'] = "";
						$sxe = new SimpleXMLElement("<cs_meta_post></cs_meta_post>");
							$sxe->addChild('post_social_sharing', $_POST['post_social_sharing'] );
							$sxe = save_layout_xml($sxe);
				update_post_meta( $post_id, 'post', $sxe->asXML() );
			}
		}

?>
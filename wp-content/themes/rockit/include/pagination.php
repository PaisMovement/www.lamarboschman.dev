<?php
if ( !isset($post) ) {
	require_once '../../../../wp-load.php';
	global $wpdb;
}
	foreach ( $_REQUEST as $keys=>$values) {
		$$keys = $values;
	}

$records_per_page = 9;
if ( empty($page_id) ) $page_id = 1;
$offset = $records_per_page * ($page_id-1);
?>
	  	<ul class="gal-list">
            <?php
                $query_images_args = array('post_type' => 'attachment', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => -1,);
                $query_images = new WP_Query( $query_images_args );
					if ( empty($total_pages) ) $total_pages = count( $query_images->posts );

                $query_images_args = array('post_type' => 'attachment', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => $records_per_page, 'offset' => $offset,);
                $query_images = new WP_Query( $query_images_args );
                $images = array();
                foreach ( $query_images->posts as $image) {
					$image_path = wp_get_attachment_image_src( $image->ID, array( get_option("thumbnail_size_w"),get_option("thumbnail_size_h") ) );
	            ?>
                    <li style="cursor:pointer"><img src="<?php echo $image_path[0]?>" onclick="javascript:clone('<?php echo $image->ID?>')" /></li>
				<?php
                    }
                ?>
			</ul>
      
        <br />
        <div class="pagination-cus">
        	<ul>
<?php
if ( $page_id > 1 ) echo "<li><a href='javascript:show_next(".($page_id-1).",$total_pages)'>Prev</a></li>";
	for ( $i = 1; $i <= ceil($total_pages/$records_per_page); $i++ ) {
		if ( $i <> $page_id ) echo "<li><a href='javascript:show_next($i,$total_pages)'>" . $i . "</a></li> ";
		else echo "<li class='active'><a>" . $i . "</a></li>";
	}
if ( $page_id < $total_pages/$records_per_page ) echo "<li><a href='javascript:show_next(".($page_id+1).",$total_pages)'>Next</a></li>";
?>
			</ul>
        </div>
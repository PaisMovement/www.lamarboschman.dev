<?php
function manage_sidebars() {
	foreach ($_REQUEST as $keys=>$values) {
		$$keys = trim($values);
	}
	
	$message = '';
	
	$pre_data = get_option("cs_sidebar");
	if ( isset($sidebar) ) {
		$parts = explode( "<name>", $pre_data );
			if ( in_array($sidebar, $parts) ){
				$message = "<div class='form-msgs'><div class='to-notif error-box'><span class='error'>&nbsp;</span><p>This Sidebar Already Exist</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
				$message .= "<script>slideout();</script>";
			}
			else {
				update_option( "cs_sidebar", $pre_data.$sidebar."<name>" );
				$message = "<div class='form-msgs'><div class='to-notif success-box'><span class='tick'>&nbsp;</span><p>Sidebar Added</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
				$message .= "<script>slideout();</script>";
			}
	}
	
	// delete sidebar start
	if ( isset($sidebar_del) ){
		update_option( "cs_sidebar", str_replace ( $sidebar_del."<name>", "", $pre_data ) );
		$message = "<div class='form-msgs'><div class='to-notif error-box'><span class='error'>&nbsp;</span><p>Sidebar Deleted</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
		$message .= "<script>slideout();</script>";
	}
	// delete sidebar end

?>

    
<form id="frm" name="frm" enctype="multipart/form-data" action="admin.php?page=manage_sidebars" method="POST">
<div class="theme-wrap fullwidth">


	<?php include "theme_leftnav.php";?>
    <!-- Right Column Start -->
    <div class="col2 left">
		<!-- Header Start -->
        <div class="wrap-header">
            <h4 class="bold">Manage Sidebars</h4>
            
            <div class="clear"></div>
        </div>
        <!-- Header End -->
        <!-- Content Section Start -->
    	<div class="elements-in">
			<?php echo $message;?>
            <div class="option-sec">
                <div class="opt-head">
                    <h6>Add New Sidebar</h6>
                    <p>Add new sidebar here.</p>
                </div>
                <div class="opt-conts">
                    <ul class="form-elements noborder">
                        <li class="to-label">
                            <label>Sidebar Name</label>
                        </li>
                        <li class="to-field">
                            <input class="{validate:{required:true}}" type="text" name="sidebar" size="40" />
                            <input type="submit" value="Add Sidebar" />
                        </li>
                        <li class="to-desc">
                            <p>
                                Please enter the desired title of sidebar.
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="to-tables" style="margin-bottom:15px;">
                <h5>Side Bars</h5>
                <ul class="to-rows to-head">
                    <li class="id">#</li>
                    <li class="big-title"><a href="#">Sider Bar Name</a></li>
                    <li class="close noborder"></li>
                </ul>
                <?php
					$counter = 0;
                	$parts = explode( "<name>", get_option("cs_sidebar") );
                    foreach ( $parts as $val ) {
                    	if ( $val <> "" ) {
                        	$counter++;
                ?>
                <ul class="to-rows to-cont">
                    <li class="id"><?php echo $counter;?></li>
                    <li class="big-title"><?php echo $val;?></li>
                    <li class="close noborder"><a href="admin.php?page=manage_sidebars&sidebar_del=<?php echo $val;?>" onclick="javascript: return confirm('Are you sure you want to delete this record?')" class="ac-close">&nbsp;</a></li>
                </ul>
                <?php
                    	}
                	}
                ?>
            </div>
        </div>
        <div class="clear"></div>
        <!-- Content Section End -->
    </div>
    <div class="clear"></div>
    <!-- Right Column End -->
</div>
</form>
<script type="text/javascript">
		jQuery().ready(function($) {
			var container = $('div.container');
			// validate the form when it is submitted
			var validator = $("#frm").validate({
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
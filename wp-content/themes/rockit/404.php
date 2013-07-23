<?php
global $cs_transwitch;
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>
<div class="clear"></div>
<div class="inner">
	<!-- Container Start -->
    <div class="container row">
        <div class="sixteen columns left">
            <div class="in-sec nopad-bot">
                <div id="post-0" class="post error404 not-found" style="min-height:300px;">
                    <h1 class="entry-title"><?php if($cs_transwitch =='on'){ _e('Not Found',CSDOMAIN); }else{ echo __CS( 'title_404', 'Not Found' ); } ?></h1>
                    <div class="entry-content">
                        <p style="margin-bottom:30px;"><?php if($cs_transwitch =='on'){ _e('Apologies, but the page you requested could not be found. Perhaps searching will help.',CSDOMAIN); }else{ echo __CS( 'content_404', 'Apologies, but the page you requested could not be found. Perhaps searching will help.'); } ?></p>
                        <?php get_search_form(); ?>
                    </div><!-- .entry-content -->
                </div>
                <!--<div class="page-not-found">
                    <div class="fourofuor"><img src="<?php echo get_template_directory_uri(); ?>/images/404.png" alt="404" /></div>
                </div>-->
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>

    
    <!-- #post-0 -->
	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

<?php get_footer(); ?>
</div>
<div id="comments">
	<?php if ( post_password_required() ) : ?>
        <p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', CSDOMAIN ); ?></p>
    	</div><!-- #comments -->
     <?php return; endif;?>
    <?php if ( have_comments() ) : ?>
        <h1 class="heading"><?php echo comments_number(__('No Comments', CSDOMAIN), __('1 Comment', CSDOMAIN), __('% Comments', CSDOMAIN) );?></h1>
            <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
                <div class="navigation">
                    <div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', CSDOMAIN ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', CSDOMAIN ) ); ?></div>
                </div> <!-- .navigation -->
            <?php endif; // check for comment navigation ?>
        
            <ul>
                <?php wp_list_comments( array( 'callback' => 'PixFill_comment' ) );	?>
            </ul>
        
        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
            <div class="navigation">
                <div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', CSDOMAIN ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', CSDOMAIN ) ); ?></div>
            </div><!-- .navigation -->
        <?php endif; 
        else : 
            if ( ! comments_open() ) :?>
        <?php endif; // end ! comments_open() ?>
    <?php endif;  // end have_comments() ?>
</div>
<?php 
global $post_id;
$you_may_use = __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', CSDOMAIN );
$must_login = __( 'You must be <a href="%s">logged in</a> to post a comment.', CSDOMAIN );
$logged_in_as = __('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', CSDOMAIN);
$required_fields_mark = ' ' . __('Required fields are marked %s', CSDOMAIN);
$required_text = sprintf($required_fields_mark , '<span class="required">*</span>' );

$defaults = array( 'fields' => apply_filters( 'comment_form_default_fields', 
	array(
		'author' => '<p class="comment-form-author">' .
		'<label for="author">' . __( 'Name', CSDOMAIN ) . '</label> ' .
		( $req ? '<span class="required">*</span>' : '' ) .
		
		'<input id="author" name="author" type="text" value="' .
		esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1"  />' .
		'</p><!-- #form-section-author .form-section -->',
		
		'email'  => '<p class="comment-form-email">' .
		'<label for="email">' . __( 'Email', CSDOMAIN ) . '</label> ' .
		( $req ? '<span class="required">*</span>' : '' ) .
		'<input id="email" name="email" type="text" value="' . 
		esc_attr(  $commenter['comment_author_email'] ) . '" size="30" tabindex="2"/>' .
		'</p><!-- #form-section-email .form-section -->',
		
		'url'    => '<p class="comment-form-url">' .
		'<label for="url">' . __( 'Website', CSDOMAIN ) . '</label>' .
		'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="3" />' .
		'<!-- #<span class="hiddenSpellError" pre="">form-section-url</span> .form-section -->' ) ),
		
		'comment_field' => '<p class="comment-form-comment">' .
		'<label for="comment">' . __( 'Comment: ', CSDOMAIN ) . '</label>' .
		'<textarea id="comment" name="comment" cols="45" rows="8" tabindex="4" aria-required="true"></textarea>' .
		'</p><!-- #form-section-comment .form-section -->',
		
		'must_log_in' => '<p class="must-log-in">' .  sprintf( $must_login,	wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'logged_in_as' => '<p class="logged-in-as">' . sprintf( $logged_in_as, admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ),
		'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email is <em>never</em> published nor shared.', CSDOMAIN ) . 
		( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after' =>  sprintf('<dl class="form-allowed-tags"><dt>' .$you_may_use , '</dt> <dd><code>' . allowed_tags() . '</code></dd>'),
		'id_form' => 'commentform',
		'id_submit' => 'submit',
		'title_reply' => __( 'Leave a Reply', CSDOMAIN ),
		'title_reply_to' => __( 'Leave a Reply to %s', CSDOMAIN ),
		'cancel_reply_link' => __( 'Cancel reply', CSDOMAIN ),
		'label_submit' => __( 'Post Comment', CSDOMAIN ),); ?>
<?php comment_form($defaults, $post_id); ?>
<?php
  if (post_password_required()) {
    return;
  }

 if (have_comments()) : ?>
  <section id="comments">
    <h3 class="comments-title"><?php printf(_n('One Comment', '%1$s Comments', get_comments_number(), 'uplands'), number_format_i18n(get_comments_number()), get_the_title()); ?></h3>

    <ol class="media-list">
      <?php wp_list_comments(array('walker' => new Roots_Walker_Comment)); ?>
    </ol>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
    <nav>
      <ul class="pager">
        <?php if (get_previous_comments_link()) : ?>
          <li class="previous"><?php previous_comments_link(esc_html__('&larr; Older comments', 'uplands')); ?></li>
        <?php endif; ?>
        <?php if (get_next_comments_link()) : ?>
          <li class="next"><?php next_comments_link(esc_html__('Newer comments &rarr;', 'uplands')); ?></li>
        <?php endif; ?>
      </ul>
    </nav>
    <?php endif; ?>

    <?php if (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
    <div class="comments-closed">
      <?php esc_html_e('Comments are closed.', 'uplands'); ?>
    </div>
    <?php endif; ?>
  </section><!-- /#comments -->
<?php endif; ?>

<?php if (!have_comments() && !comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
  <section id="comments">
	  <div class="comments-closed">
		  <?php esc_html_e('Comments are closed.', 'uplands'); ?>
	  </div>
  </section><!-- /#comments -->
<?php endif; ?>

<?php
if (comments_open()) :

    $required_text = esc_html__( 'Required fields are marked *','uplands');
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );

	$args = array(
		'id_form'           => 'commentform',
		'id_submit'         => 'submit',
		'title_reply'       => esc_html__( 'Leave a Reply','uplands' ),
		'title_reply_to'    => esc_html__( 'Leave a Reply to %s','uplands' ),
		'cancel_reply_link' => esc_html__( 'Cancel Reply','uplands' ),
		'label_submit'      => esc_html__( 'Submit Comment','uplands' ),

	
		'comment_field' =>  '<div class="form-group"><label for="comment">' . esc_html__( 'Comment','uplands' ) .
		'</label><textarea name="comment" id="comment" class="form-control" rows="8" aria-required="true">' .
		'</textarea></div>',
	
			'must_log_in' => '<p class="comment-info">' .
			sprintf(
				wp_kses_post(__( 'You must be <a href="%s">logged in</a> to post a comment.','uplands' )),
			  wp_login_url( apply_filters( 'the_permalink', esc_url(get_permalink()) ) )
			) . '</p>',
	
			'logged_in_as' => '<p class="comment-info">' .
			sprintf(
				wp_kses_post(__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','uplands' )),
			  admin_url( 'profile.php' ),
			  $user_identity,
			  wp_logout_url( apply_filters( 'the_permalink', esc_url(get_permalink( )) ) )
			) . '</p>',
	
			'comment_notes_before' => '<p class="comment-info">' .
			esc_html__( 'Your email address will not be published. ','uplands' ) . ( $req ? $required_text : '' ) .
			'</p>',
	
			'comment_notes_after' => '<p class="form-allowed-tags">' .
			sprintf(
				wp_kses_post(__( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s','uplands' )),
			  ' <code>' . allowed_tags() . '</code>'
			) . '</p>',
	
			'fields' => apply_filters( 'comment_form_default_fields', array(
	
				'author' =>
				  '<div class="form-group">' .
				  '<label for="author">' . esc_html__( 'Name', 'uplands' ) . ( $req ? ' *' : '' ) . '</label> ' .
				  '<input type="text" class="form-control" name="author"  id="author" value="' . esc_attr( $commenter['comment_author'] ) .
				  '" size="22"' . $aria_req . ' /></div>',
		
				'email' =>
				   '<div class="form-group">' .
				  '<label for="email">' . esc_html__( 'Email', 'uplands' ) . ( $req ? ' *' : '' ) . '</label> ' .
				  '<input type="text" class="form-control" name="email" id="email" value="' . esc_attr(  $commenter['comment_author_email'] ) .
				  '" size="22"' . $aria_req . ' /></div>',
		
				'url' =>
				  '<div class="form-group">'.
				  '<label for="url">' . esc_html__( 'Website', 'uplands' ) . '</label>' .
				  '<input type="text"  class="form-control" name="url" id="url"  value="' . esc_attr( $commenter['comment_author_url'] ) .
				  '" size="22" /></div>',
				)
			),
);
?>


    
<?php comment_form($args); ?>
  
<?php endif; ?>

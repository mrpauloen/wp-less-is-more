<?php

/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @since 1.0
 */



/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if ( post_password_required() ) {
	return;
}
$comments_number = get_comments_number();
$commenter       = wp_get_current_commenter();
$req             = get_option( 'require_name_email' );
$aria_req        = ( $req ? ' aria-required="true"' : '' );
$user            = wp_get_current_user();

	$comments_args = array(
		'id_form'              => 'commentform',
		'class_form'           => '',
		'title_reply'          => '',
		/* translators: %s: Author of the comment being replied to. */
		'title_reply_to'       => __( 'You reply to: %s', 'wp-less-is-more' ) . '&emsp;',
		'title_reply_before'   => '<h4 id="reply-title" class="comment-reply-title">',
		'title_reply_after'    => '</h4>',
		'cancel_reply_before'  => ' ',
		'cancel_reply_after'   => '',
		'cancel_reply_link'    => __( 'Cancel', 'wp-less-is-more' ),
		'id_submit'            => 'submit',
		'class_submit'         => 'btn btn-primary btn-sm',
		'label_submit'         => __( 'Send', 'wp-less-is-more' ),
		'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
		'submit_field'         => ( $user->exists() ) ? '<p class="mt-3">%1$s %2$s</p>' : '%1$s %2$s </div></div><br>',
		'must_log_in'          => sprintf(
			'<p class="p-3 bg-dark text-white must-log-in">%s</p>',
			sprintf(
				/* translators: %1$s: login url; %2$s: glyphicon-log-in */
				__( 'You must be <a href="%1$s">%2$s logged in</a> to post a comment.', 'wp-less-is-more' ),
				wp_login_url( apply_filters( 'the_permalink', get_permalink() . '#comments' ) ),
				'<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>'
			)
		),
		'logged_in_as'         => '',
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
		'comment_field'        => '<textarea id="commenttext" name="comment" class="form-control" rows="1" placeholder="' . __( '**) Add comment content...', 'wp-less-is-more' ) . '"  ' . $aria_req . ' ' . ( $req ? 'required="true"' : '' ) . '></textarea>',
	);

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( have_comments() && ! comments_open() && $comments_number && ! is_page() ) {
		?>
<div class="alert alert-danger" role="alert">
		<?php
		printf(
			/* translators: %s: number of comments (if comments are closed and there are comments) */
			esc_html( _nx( 'There is %s comment, but discussion is disabled.', 'There are %s comments, but discussion is disabled.', $comments_number, 'comments status alert', 'wp-less-is-more' ) ),
			number_format_i18n( $comments_number ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
		?>
</div>
<?php } elseif ( comments_open() ) { ?>
<div class="container row">
	<h2>
		<?php
		printf(
			/* translators: %s: Number of comments. `Comments` word stay always in plural eg: Comments |1| */
			esc_html__( 'Comments |%s|', 'wp-less-is-more' ),
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$comments_number
		);
		?>
	</h2>
</div>

<?php } elseif ( ! is_page() ) { ?>

<div class="well well-sm" role="alert"><?php esc_html_e( 'Discussion disabled.', 'wp-less-is-more' ); ?></div>
		<?php
} 

comment_form( $comments_args );

if ( have_comments() ) {
	echo '<hr style="margin-top:0">';
}

	wp_list_comments(
		array(
			'avatar_size' => get_theme_mod( 'avatar_size', 45 ),
			'type'        => 'all',
			'reply_text'  => __( '&rarr; Reply', 'wp-less-is-more' ),
			'walker'      => new WP_Less_is_More_Comments_Walker(),
		)
	);

	/**
	 * Are there comments to navigate through?
	 * Check for comment navigation
	 */
	if ( have_comments() && get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
		?>
<nav role="navigation" aria-label="<?php esc_attr_e( 'Comments navigation', 'wp-less-is-more' ); ?>">

<h4 class="screen-reader-text"><?php esc_html_e( 'Comments navigation', 'wp-less-is-more' ); ?></h4>

<ul class="pager">

<li><?php previous_comments_link( __( 'Older', 'wp-less-is-more' ) ); ?></li>

<li><?php next_comments_link( __( 'Newer', 'wp-less-is-more' ) ); ?></li>

</ul>

</nav>
		<?php
	} wp_less_is_more__comment_legend();

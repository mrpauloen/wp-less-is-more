<?php

// Exit if accessed directly

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WP_Less_Is_More_Comments_Walker ' ) ) :

	/**
	* Main WP_Less_Is_More_Comments_Walker Class
	*
	* @since WP Less is More 1.1.6
	*/
	class WP_Less_Is_More_Comments_Walker  extends Walker_Comment {

		/**
		 * What the class handles.
		 *
		 * @since 2.7.0
		 * @var string
		 *
		 * @see Walker::$tree_type
		 */
		public $tree_type = 'comment';



		/**
		 * Database fields to use.
		 *
		 * @since 2.7.0
		 * @var array
		 *
		 * @see Walker::$db_fields
		 * @todo Decouple this
		 */
		public $db_fields = array(

			'parent' => 'comment_parent',
			'id'     => 'comment_ID',
		);


		/** CONSTRUCTOR
		 * You'll have to use this if you plan to get to the top of the comments list, as
		 * start_lvl() only goes as high as 1 deep nested comments
		 */
		function __construct() {
			if ( have_comments() ) {
				?>
		<div id="comments" class="comments-area"><ul id="comment-list" class="list-unstyled">
				<?php
			}
		}

		/**
		 * DESTRUCTOR
		 * I just using this since we needed to use the constructor to reach the top
		 * of the comments list, just seems to balance out :)
		 */
		function __destruct() {

			if ( have_comments() ) {
				?>
				</ul></div>
				<?php
			}
		}

		/**
		 * Outputs a comment in the HTML5 format.
		 *
		 * @since 3.6.0
		 *
		 * @see wp_list_comments()
		 *
		 * @param WP_Comment $comment Comment to display.
		 * @param int        $depth   Depth of the current comment.
		 * @param array      $args    An array of arguments.
		 */
		protected function html5_comment( $comment, $depth, $args ) {

			$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

			$commenter          = wp_get_current_commenter();
			$show_pending_links = ! empty( $commenter['comment_author'] );

			?>

			<<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>

				<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

				<footer class="comment-meta">

						<div class="comment-author vcard">

						<?php
						$comment_author_url = get_comment_author_url( $comment );
						$comment_author     = get_comment_author( $comment );
						$avatar             = get_avatar(
							$comment,
							$args['avatar_size'],
							'',
							esc_attr( $comment_author ),
							$_args          = array(
								'class' => array(
									'img-circle',
									'img-thumbnail',
									'pull-right',
								),
							)
						);
						if ( 0 !== $args['avatar_size'] ) {
							if ( empty( $comment_author_url ) ) {
								echo wp_kses_post( $avatar );
							} else {
								printf( '<a href="%s" rel="external nofollow" class="url">', $comment_author_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped --Escaped in https://developer.wordpress.org/reference/functions/get_comment_author_url/
								echo wp_kses_post( $avatar );
							}
						}

						printf(
							'<strong><span class="fn">%1$s</span></strong> <span class="says text-muted">%2$s</span>',
							esc_html( $comment_author ),
							esc_html__( 'says:', 'wp-less-is-more' )
						);

						if ( ! empty( $comment_author_url ) ) {
							echo '</a>';
						}
						?>

						</div><!-- .comment-author -->

						<div class="comment-metadata">

						<?php 
							
						/* translators: 1: Comment date, 2: Comment time. */
						$comment_timestamp = sprintf( __( '%1$s at %2$s', 'wp-less-is-more' ), get_comment_date( '', $comment ), get_comment_time() );

						printf(
							'<a  class="text-muted small" href="%s"><span class="glyphicon glyphicon-link" aria-hidden="true"></span> <time datetime="%s" title="%s">%s</time></a>',
							esc_url( get_comment_link( $comment, $args ) ),
							esc_attr( get_comment_time( 'c' ) ),
							esc_attr( $comment_timestamp ),
							esc_html( $comment_timestamp )
						);
						
						
						if ( get_edit_comment_link() ) {
									printf(
										' <span aria-hidden="true">&bull;</span> <a class="comment-edit-link small" href="%s">(%s <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>)</a>',
										esc_url( get_edit_comment_link() ),
										esc_html__( 'Edit', 'wp-less-is-more' )
									);
						}

						?>

						</div><!-- .comment-metadata -->

					</footer><!-- .comment-meta -->

					<div class="comment-content">

						<?php 
			
						if ( '0' === $comment->comment_approved ) :
							?>
						<em class="text-primary comment-awaiting-moderation"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>&nbsp;<?php esc_html_e( 'Your comment is awaiting moderation.', 'wp-less-is-more' ); ?></em>

						<div class="progress" style="width:35%;height:8px">

							<div class="progress-bar active progress-bar-striped" style="width: 100%">

								<span class="sr-only"><?php esc_html_e( 'Animated progress bar indicator', 'wp-less-is-more' ); ?></span>

							</div>

						</div>


						<?php endif; ?>

						<?php comment_text(); ?>

					</div><!-- .comment-content -->

				</article><!-- .comment-body -->
				<?php

				if ( '1' === $comment->comment_approved || $show_pending_links ) {

					comment_reply_link(
						array_merge(
							$args,
							array(
								'add_below'     => 'div-comment',
								'depth'         => $depth,
								'max_depth'     => $args['max_depth'],
								'before'        => '<p class="comment-reply">',
								'after'         => '</p>',
								'login_text'    => '<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>&nbsp;' . __( 'Log in to Reply', 'wp-less-is-more' ),
								/* translators: Comment reply text. %s: Comment author name. */
								'reply_to_text' => __( 'You reply to: %s', 'wp-less-is-more' ) . '&emsp;',
							)
						)
					);
				}
				?>
			<?php
		}
	}
endif;

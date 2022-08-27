<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WP_Less_is_More_Comments_Walker' ) ) :

/**
 * Main WP Bootstrap Comments Walker Class
 *
 * @since WP Less is More 1.1.6
 */

 /** COMMENTS WALKER */

class WP_Less_is_More_Comments_Walker extends Walker_Comment {

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
	 * start_lvl() only goes as high as 1 deep nested comments */
	function __construct() {
		if ( have_comments() ):
	?>
	<div id="comments" class="comments-area"><ul id="comment-list" class="list-unstyled"><?php endif;
	}

	/** DESTRUCTOR
	 * I just using this since we needed to use the constructor to reach the top
	 * of the comments list, just seems to balance out :) */
	function __destruct() {
	 if ( have_comments() ):	?></ul></div><?php endif;
	}

	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::start_lvl()
	 * @global int $comment_depth
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param int    $depth  Optional. Depth of the current comment. Default 0.
	 * @param array  $args   Optional. Uses 'style' argument for type of HTML list. Default empty array.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;

		switch ( $args['style'] ) {
			case 'div':
				break;
			case 'ol':
				$output .= '<ol class="children">' . "\n";
				break;
			case 'ul':
			default:
				$output .= '<ul class="children">' . "\n";
				break;
		}
	}

	/**
	 * Ends the list of items after the elements are added.
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::end_lvl()
	 * @global int $comment_depth
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param int    $depth  Optional. Depth of the current comment. Default 0.
	 * @param array  $args   Optional. Will only append content if style argument value is 'ol' or 'ul'.
	 *                       Default empty array.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;

		switch ( $args['style'] ) {
			case 'div':
				break;
			case 'ol':
				$output .= "</ol><!-- .children -->\n";
				break;
			case 'ul':
			default:
				$output .= "</ul><!-- .children -->\n";
				break;
		}
	}

	/**
	 * Traverses elements to create list from elements.
	 *
	 * This function is designed to enhance Walker::display_element() to
	 * display children of higher nesting levels than selected inline on
	 * the highest depth level displayed. This prevents them being orphaned
	 * at the end of the comment list.
	 *
	 * Example: max_depth = 2, with 5 levels of nested content.
	 *     1
	 *      1.1
	 *        1.1.1
	 *        1.1.1.1
	 *        1.1.1.1.1
	 *        1.1.2
	 *        1.1.2.1
	 *     2
	 *      2.2
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::display_element()
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $element           Comment data object.
	 * @param array      $children_elements List of elements to continue traversing. Passed by reference.
	 * @param int        $max_depth         Max depth to traverse.
	 * @param int        $depth             Depth of the current element.
	 * @param array      $args              An array of arguments.
	 * @param string     $output            Used to append additional content. Passed by reference.
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( ! $element ) {
			return;
		}

		$id_field = $this->db_fields['id'];
		$id       = $element->$id_field;

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

		/*
		 * If at the max depth, and the current element still has children, loop over those
		 * and display them at this level. This is to prevent them being orphaned to the end
		 * of the list.
		 */
		if ( $max_depth <= $depth + 1 && isset( $children_elements[ $id ] ) ) {
			foreach ( $children_elements[ $id ] as $child ) {
				$this->display_element( $child, $children_elements, $max_depth, $depth, $args, $output );
			}

			unset( $children_elements[ $id ] );
		}

	}

	/**
	 * Starts the element output.
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::start_el()
	 * @see wp_list_comments()
	 * @global int        $comment_depth
	 * @global WP_Comment $comment       Global comment object.
	 *
	 * @param string     $output  Used to append additional content. Passed by reference.
	 * @param WP_Comment $comment Comment data object.
	 * @param int        $depth   Optional. Depth of the current comment in reference to parents. Default 0.
	 * @param array      $args    Optional. An array of arguments. Default empty array.
	 * @param int        $id      Optional. ID of the current comment. Default 0 (unused).
	 */
	public function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
		$depth++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment']       = $comment;

		if ( ! empty( $args['callback'] ) ) {
			ob_start();
			call_user_func( $args['callback'], $comment, $args, $depth );
			$output .= ob_get_clean();
			return;
		}

		if ( 'comment' === $comment->comment_type ) {
			add_filter( 'comment_text', array( $this, 'filter_comment_text' ), 40, 2 );
		}

		if ( ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) && $args['short_ping'] ) {
			ob_start();
			$this->ping( $comment, $depth, $args );
			$output .= ob_get_clean();
		} elseif ( 'html5' === $args['format'] ) {
			ob_start();
			$this->html5_comment( $comment, $depth, $args );
			$output .= ob_get_clean();
		} else {
			ob_start();
			$this->comment( $comment, $depth, $args );
			$output .= ob_get_clean();
		}

		if ( 'comment' === $comment->comment_type ) {
			remove_filter( 'comment_text', array( $this, 'filter_comment_text' ), 40, 2 );
		}
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::end_el()
	 * @see wp_list_comments()
	 *
	 * @param string     $output  Used to append additional content. Passed by reference.
	 * @param WP_Comment $comment The current comment object. Default current comment.
	 * @param int        $depth   Optional. Depth of the current comment. Default 0.
	 * @param array      $args    Optional. An array of arguments. Default empty array.
	 */
	public function end_el( &$output, $comment, $depth = 0, $args = array() ) {
		if ( ! empty( $args['end-callback'] ) ) {
			ob_start();
			call_user_func( $args['end-callback'], $comment, $args, $depth );
			$output .= ob_get_clean();
			return;
		}
		if ( 'div' == $args['style'] ) {
			$output .= "</div><!-- #comment-## -->\n";
		} else {
			$output .= "</li><!-- #comment-## -->\n";
		}
	}

	/**
	 * Outputs a pingback comment.
	 *
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment The comment object.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function ping( $comment, $depth, $args ) {
		$tag = ( 'div' == $args['style'] ) ? 'div' : 'li';
		?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( '', $comment ); ?>>
			<div class="comment-body">
				<?php _e( 'Pingback:', 'wp-less-is-more' ); ?> <?php comment_author_link( $comment ); ?> <?php edit_comment_link( sprintf (
					/* translators: %s: glyphicon glyphicon-edit @see: bootstrap 3.4 dosc. */
					__( '(Edit %s)', 'wp-less-is-more' ), '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>') , '<span class="edit-link small">', '</span>' ); ?>
			</div>
		<?php
	}

	/**
	 * Filters the comment text.
	 *
	 * Removes links from the pending comment's text if the commenter did not consent
	 * to the comment cookies.
	 *
	 * @since 5.4.2
	 *
	 * @param string          $comment_text Text of the current comment.
	 * @param WP_Comment|null $comment      The comment object. Null if not found.
	 * @return string Filtered text of the current comment.
	 */
	public function filter_comment_text( $comment_text, $comment ) {
		$commenter          = wp_get_current_commenter();
		$show_pending_links = ! empty( $commenter['comment_author'] );

		if ( $comment && '0' == $comment->comment_approved && ! $show_pending_links ) {
			$comment_text = wp_kses( $comment_text, array() );
		}

		return $comment_text;
	}

	/**
	 * Outputs a single comment.
	 *
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function comment( $comment, $depth, $args ) {
		if ( 'div' == $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}

		$commenter          = wp_get_current_commenter();
		$show_pending_links = isset( $commenter['comment_author'] ) && $commenter['comment_author'];

		if ( $commenter['comment_author_email'] ) {
			$moderation_note = __( 'Your comment is awaiting moderation.', 'wp-less-is-more' );
		} else {
			$moderation_note = __( ' Your comment is awaiting moderation and will be visible soon. Preview shown below.', 'wp-less-is-more' );
		}
		?>
		<<?php echo $tag; ?> <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?> id="comment-<?php comment_ID(); ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<?php endif; ?>
		<div class="comment-author vcard">
			<?php
			if ( 0 != $args['avatar_size'] ) {
				echo get_avatar( $comment, $args['avatar_size'], '', '', $_args = array( 'class' => array(
					'img-circle', 'img-thumbnail',  'pull-right' ) ) );
			}
			?>
			<?php
			$comment_author = get_comment_author_link( $comment );

			if ( '0' == $comment->comment_approved && ! $show_pending_links ) {
				$comment_author = get_comment_author( $comment );
			}

			printf(
				/* translators: %s: Comment author link. */
				__( '%s <span class="says">says:</span>', 'wp-less-is-more' ),
				sprintf( '<cite class="fn">%s</cite>', $comment_author )
			);
			?>
		</div>

		<div class="comment-meta commentmetadata"><a class="text-muted small" href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
			<span class="glyphicon glyphicon-link" aria-hidden="true"></span>
			<?php
				/* translators: 1: Comment date, 2: Comment time. */
				printf( __( '%1$s at %2$s', 'wp-less-is-more' ), get_comment_date( '', $comment ), get_comment_time() );
			?>
				</a>
				<?php edit_comment_link( sprintf (
					/* translators: %s: glyphicon-edit. */
					__( '(Edit %s)', 'wp-less-is-more' ), '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>') , '<span class="edit-link small">', '</span>' ); ?>
		</div>
		<?php if ( '0' == $comment->comment_approved ) : ?>
		<em class="comment-awaiting-moderation"> &nbsp;<?php echo $moderation_note; ?></em>
		<div class="progress" style="width:35%;height:8px">
			<div class="progress-bar active progress-bar-striped" style="width: 100%">
				<span class="sr-only"><?php _e( 'Animated progress bar indicator', 'wp-less-is-more' ); ?></span>
			</div>
		</div>

		<?php endif;

		comment_text(
			$comment,
			array_merge(
				$args,
				array(
					'add_below' => $add_below,
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
				)
			)
		);
		?>

		<?php
		comment_reply_link(
			array_merge(
				$args,
				array(
					'add_below' => $add_below,
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<p class="comment-reply">',
					'after'     => '</p>',
        	'login_text'    => '<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>&nbsp;' . __( 'Log in to Reply', 'wp-less-is-more' ),
					/* translators: Comment reply text. %s: Comment author name. */
					'reply_to_text' => __( 'You reply to: %s', "wp-less-is-more" )  . '&emsp;',
				)
			)
		);
		?>

		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
		<?php
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

		if ( $commenter['comment_author_email'] ) {
			$moderation_note = __( 'Your comment is awaiting moderation.', 'wp-less-is-more' );
		} else {
			$moderation_note = __( ' Your comment is awaiting moderation and will be visible soon. Preview shown below.', 'wp-less-is-more' );
		}
		?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

			<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php
						$comment_author = get_comment_author_link( $comment ); ?>

						<?php
						if ( 0 != $args['avatar_size'] ) {
							echo get_avatar( $comment, $args['avatar_size'], '', '', $_args = array( 'class' => array(
		            'img-circle', 'img-thumbnail',  'pull-right' ) ) );
						}

						if ( '0' == $comment->comment_approved && ! $show_pending_links ) {
							$comment_author = get_comment_author( $comment );
						}

						printf(
							/* translators: %s: Comment author link. */
							__( '%s <span class="says">says:</span>', 'wp-less-is-more' ),
							sprintf( '<b class="fn">%s</b>', $comment_author )
						);
						?>
					</div><!-- .comment-author -->

					<div class="comment-metadata">
						<a class="text-muted small" href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
							<span class="glyphicon glyphicon-link" aria-hidden="true"></span>
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php
									/* translators: 1: Comment date, 2: Comment time. */
									printf( __( '%1$s at %2$s', 'wp-less-is-more' ), get_comment_date( '', $comment ), get_comment_time() );
								?>
							</time>
						</a>
						<?php edit_comment_link( sprintf (
							/* translators: %s: glyphicon-edit. */
							__( '(Edit %s)', 'wp-less-is-more' ), '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>') , '<span class="edit-link small">', '</span>' ); ?>
					</div><!-- .comment-metadata -->




				</footer><!-- .comment-meta -->

				<div class="comment-content">

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<em class="text-primary comment-awaiting-moderation"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>&nbsp;<?php echo $moderation_note; ?></em>
					<div class="progress" style="width:35%;height:8px">
						<div class="progress-bar active progress-bar-striped" style="width: 100%">
							<span class="sr-only"><?php _e( 'Animated progress bar indicator', 'wp-less-is-more' ); ?></span>
						</div>
					</div>

					<?php endif; ?>


					<?php comment_text(); ?>
				</div><!-- .comment-content -->

			</article><!-- .comment-body -->

			<?php
			if ( '1' == $comment->comment_approved || $show_pending_links ) {
				comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<p class="comment-reply">',
							'after'     => '</p>',
							'login_text'    => '<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>&nbsp;' . __( 'Log in to Reply', 'wp-less-is-more'),
							/* translators: Comment reply text. %s: Comment author name. */
        			'reply_to_text' => __( 'You reply to: %s', "wp-less-is-more" )  . '&emsp;',
						)
					)
				);
			}
			?>

		<?php
	}
}

endif;
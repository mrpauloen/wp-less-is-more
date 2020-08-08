<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

 if ( post_password_required() )
     return;

     $comments_number = get_comments_number();
     $commenter		= wp_get_current_commenter();
     $req			= get_option( 'require_name_email' );
     $aria_req		= ( $req ? " aria-required='true'" : '' );
     $user			= wp_get_current_user();
     $user_identity	= $user->exists() ? $user->display_name : '';


     $fields =  array(

     'author' => '<div id="form-input" class="collapse row"><br><div class="col-xs-8 col-sm-4">
         <div class="form-group">

         <div class="input-group">
         <span class="input-group-addon" data-toggle="tooltip" data-placement="top" title="' . __( 'Nick name required', 'wp-less-is-more' ) . '"><span class="glyphicon glyphicon-user text-muted" aria-hidden="true"></span> *</span>
         <span class="sr-only">' . __( 'nick name (required):', 'wp-less-is-more' ) . '</span>
         <input type="text" class="form-control input-sm" name="author" value="' . esc_attr( $commenter['comment_author'] ) . '" id="author" placeholder="' . __( 'nick name (req)', 'wp-less-is-more' ) . '" '. ( $req ? 'required="required"' : '' ) .'>
         </div>

         </div>
       </div>',

     'email' => '<div class="col-xs-8 col-sm-4">
         <div class="form-group">

         <div class="input-group">
         <span class="input-group-addon" data-toggle="tooltip" data-placement="bottom" title="' . __( 'Email required', 'wp-less-is-more' ) . '">@ *</span>
         <span class="sr-only">' . __( 'email (required):', 'wp-less-is-more' ) . '</span>
         <input type="email" class="form-control input-sm" name="email" id="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '"  placeholder="' . __( 'email (req)', 'wp-less-is-more' ) . '"  ' . $aria_req . ' '. ( $req ? 'required="required"' : '' ) .'>
         </div>

         </div>
       </div>

     ',

     'url' => '',
     'cookies' => '<div class="col-xs-8 col-sm-4">
      <div class="checkbox" style="margin-top:0">
           <label for="wp-comment-cookies-consent">
             <input  id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"> ' . __( 'Remember me', 'wp-less-is-more' ) . '
           </label> <span data-toggle="tooltip" data-placement="top" title="' . __( 'Your data will be stored in this browser and added automaticly so next time you don\'t need to put it again.', 'wp-less-is-more' ) . '" class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
      </div>
       ',

     );


     $comments_args = array(
     'id_form'				=> 'commentform',
     'class_form'			=> '',
     'title_reply'      		=> '',
     'title_reply_to'    	=> __( 'You reply to: %s', "wp-less-is-more" )  . '&emsp;',
     'title_reply_before'	=> '<h4>',
     'title_reply_after'		=> '',
     'cancel_reply_before'	=> '',
     'cancel_reply_after'	=> '</h4>',
     'cancel_reply_link'		=> __( 'Cancel', 'wp-less-is-more' ),
     'id_submit'				=> 'submit',
     'class_submit'			=> 'btn btn-primary btn-sm',
     'label_submit'			=> __( 'Send', 'wp-less-is-more' ),
     'submit_button'			=> '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
     'submit_field'			=> ( $user->exists() ) ? '<p class="mt-3">%1$s %2$s</p>' : '%1$s
     %2$s
      </div></div><br>',
     'must_log_in'			=> '<p class="p-3 bg-dark text-white must-log-in">' .
     sprintf(
       __( 'You must be <a href="%s">%s logged in</a> to post a comment.', 'wp-less-is-more' ), wp_login_url( apply_filters( 'the_permalink', get_permalink() . '#comments' )), '<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>&nbsp;'
     ) . '</p>',

     'logged_in_as' 			=> '',

     'comment_notes_before' 	=> '',
     'comment_notes_after' 	=> '',
     'fields'				=>  $fields ,
     'comment_field'			=> '<textarea id="commenttext" name="comment" class="form-control" rows="1" placeholder="' . __( '**) Add comment content...', 'wp-less-is-more' ) . '"  ' . $aria_req . ' '. ( $req ? 'required="required"' : '' ) .'></textarea>',


     );
     ?>
<script>
jQuery.noConflict();
jQuery( document ).ready( function( $ ){
    $('[data-toggle="tooltip"]').tooltip();
    $('.triggerpopover').popover({
        container: 'div.popoverContainer',
        html: true,
        content: function () {
        return '<code><?php echo allowed_tags(); ?></code>';
      },
    });
    $('#commenttext').each(function () {
      this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
    }).on('input', function () {
      this.style.height = 'auto';
      this.style.height = (this.scrollHeight) + 'px';
    });
    $('#commenttext').css('height', '35');
    $('#commenttext').focus(function(){
       $('#form-input').collapse();
    });
    <?php if ( isset( $_GET['replytocom'] ) ) { ?>
    $('#commenttext').focus();
      <?php } ?>
});
</script>

<?php // If comments are closed and there are comments, let's leave a little note, shall we?
if ( have_comments() && ! comments_open() && $comments_number && ! is_page() ){
?>
<div class="alert alert-danger" role="alert"><?php printf(
  /* translators: %s: number of comments */
   _nx( 'There is %s comment, but discussion is disabled.',
        'There are %s comments, but discussion is disabled.',
    $comments_number, 'comments status alert', 'wp-less-is-more' ), number_format_i18n( $comments_number ) ); ?></div>
<?php } elseif ( comments_open() ){ ?>

	<div class="container row">
  <h2><?php printf(
    /* translators: %s: Number of comments.
    * translators: `Comments` word stay always in plural eg: Comments |1|
    */
    __( 'Comments |%s|', 'wp-less-is-more' ),
     $comments_number ); ?></h2>
	</div>

<?php } elseif ( ! is_page() ) { ?>
<div class="well well-sm" role="alert"><?php _e( 'Discussion disabled.', 'wp-less-is-more' ); ?></div>
<?php } ?>

<?php  comment_form( $comments_args );

if ( have_comments() )
echo '<hr style="margin-top:0">';

  				wp_list_comments( array(
  					'avatar_size' => get_theme_mod( 'avatar_size', 45 ),
  					'type'  => 'all',
  					'reply_text'  => __( '&rarr; Reply', 'wp-less-is-more' ),
  					'walker' 		=> new WP_Less_is_More_Comments_Walker(),
  				) );


/**
 * Are there comments to navigate through?
 * Check for comment navigation
 */
if ( have_comments() && get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
?>
<nav role="navigation" aria-label="<?php esc_attr_e( 'Comments navigation', 'wp-less-is-more' ); ?>">
  <h4 class="screen-reader-text"><?php _e( 'Comments navigation', 'wp-less-is-more' ); ?></h4>
  <ul class="pager">
    <li><?php previous_comments_link( __( 'Older', 'wp-less-is-more'  ) ); ?></li>
    <li><?php next_comments_link( __( 'Newer', 'wp-less-is-more' ) ); ?></li>
  </ul>
</nav>
<?php }

if ( comments_open() ){ ?>
	<hr style="margin-top:0">
<div class="popoverContainer" style="position:relative">
  <p class="small"><?php _e( '*) Required fields are marked with star', 'wp-less-is-more' ); ?><br/>
  <?php echo _x( '**) You can use some', 'comment legend', 'wp-less-is-more' ); ?><button title="<?php esc_attr_e( 'Alowed HTML tags and attributes', 'wp-less-is-more' ); ?>" type="button" class="triggerpopover btn btn-xs btn-link" data-toggle="popover" data-placement="top" role="button"><?php echo _x( 'HTML markup', 'comment legend (button text)', 'wp-less-is-more' ); ?> <span class="caret"></span></button></p>
</div>
<?php }

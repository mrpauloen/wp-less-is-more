<?php

/**
 * WP Less is More functions and definitions
 *
 * @since WP Less is More 1.0
 */

 /**
 * Customizer additions.
 *
 * @since WP Less is More 1.1.1
 */

require trailingslashit( get_template_directory() ) . 'inc/customizer/customizer.php';

 /*
 * Define Dropdowns Bootstrap Menu **
 *
 * ** If you want to have dropdowns, bootstrtap menu, you have to:
 * 	1) Register Custom Navigation Walker
 * 	2) Replaces "current-menu-item" with "active"
 * 	3) Deletes all CSS classes and id's, except for those listed in the @array
 * 	4) Deletes empty classes and removes the sub menu class
 *
 * @since WP Less is More 1.0
 */

require trailingslashit( get_template_directory() ) . 'classes/wp-less-is-more-bootstrap-navwalker.php';

/**
 * Define Custom Comments Walker
 *
 * @since WP Less is More 1.1.6
 */

require trailingslashit( get_template_directory() ) . 'classes/wp-less-is-more-comments-walker.php';

/**
 * Sets up theme defaults and registers the various WordPress features that
 * WP Less is More supports.
 *
 * @uses load_theme_textdomain() for translation/localization support.
 * @uses add_editor_style() to add Visual Editor stylesheets.
 * @uses add_theme_support() to add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() to add support for a navigation menu.
 * @uses set_post_thumbnail_size() to set a custom post thumbnail size.
 *
 * @since WP Less is More 1.0
 */
function wp_less_is_more__theme_setup() {

	/*
	 * Set the content width based on the theme's design and stylesheet.
	 */
		global $content_width;

		if ( ! isset( $content_width ) ) {
		$content_width = 692;
	}

	/*
	 * Makes WP Less is More available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on WP Less is More, use a find and
	 * replace to change 'wp-less-is-more' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'wp-less-is-more' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
	  'caption'
	) );

	// This theme uses wp_nav_menu() in six locations.

		register_nav_menus( array (
		'top'	 => __( 'Top Menu', 	'wp-less-is-more'),
		'bottom' => __( 'Bottom Menu', 	'wp-less-is-more'),
		));

	/**
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/*
	 * Enable support for custom logo.
	 *
	 */

	 $defaults = array(
		'header-text'           => false,
		'random-default'		=> false,
		'width'					=> 700,
		'height'				=> 150,
		'flex-height'			=> true,
		'flex-width'			=> true,
		'uploads'				=> true,

	);
	add_theme_support( 'custom-header', $defaults );
	add_theme_support( 'custom-background', $args = array());

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( 'bootstrap/css/editor-style.css' );

	/**
	 * Add theme support for selective refresh for widgets.
	 * @since 1.1.8
	 */
	add_theme_support( 'customize-selective-refresh-widgets' );


	/**
	 *  Adds starter content to highlight the theme on fresh sites.
	 * 	 * This is done conditionally to avoid loading the starter content on every
	 * 	 * page load, as it is a one-off operation only needed once in the customizer.
	 */
		if ( is_customize_preview() ) {
			require get_template_directory() . '/inc/starter-content.php';
			add_theme_support( 'starter-content', wp_less_is_more__get_starter_content() );
		}
}
add_action( 'after_setup_theme', 'wp_less_is_more__theme_setup' );

/**
 * Filters
 */

/**
 * Filters the CSS classes applied to a menu item’s list item element.
 * @param string|array Array of the CSS classes that are applied to the menu item's li element.
 * @return @array
 * @since WP Less is More 1.0
 */
function wp_less_is_more__filter__custom_nav_menu( $classes ) {
		return is_array( $classes ) ? array_intersect( $classes, array(
				//List of allowed menu classes
				'current-menu-item',
				'current_page_item',
				'current_page_parent',
				'current_page_ancestor',
				'first',
				'last',
				'vertical',
				'horizontal'
				)
		) : '';
}
add_filter ( 'nav_menu_css_class',  'wp_less_is_more__filter__custom_nav_menu' );
add_filter ( 'nav_menu_item_id'	 ,	'wp_less_is_more__filter__custom_nav_menu' );
add_filter ( 'page_css_class'	 , 	'wp_less_is_more__filter__custom_nav_menu' );

/**
 * Replaces "current-menu-item" with "active" - for bootstrap menu
 *
 * @since WP Less is More 1.0
 */
function wp_less_is_more__filter__current_to_active( $classes ){
		$replace = array(
			//List of menu item classes that should be changed to "active"
			'current-menu-item' 	=> 'active',
			'current_page_item' 	=> 'item',
			'current_page_parent' 	=> 'parent',
			'current_page_ancestor' => 'ancestor',
		);
		$classes = str_replace( array_keys( $replace ), $replace, $classes );
			return $classes;
		}
add_filter ( 'wp_nav_menu'		 ,	'wp_less_is_more__filter__current_to_active'	 );

/**
 * Deletes empty classes and removes the sub menu class
 *
 * @since WP Less is More 1.0
 */
function wp_less_is_more__filter__strip_empty_classes( $menu ) {
    $menu = preg_replace( '/ class=""| class="sub-menu"/',' class="dropdown-menu"', $menu );
    return $menu;
}
add_filter ( 'wp_nav_menu'		 ,	'wp_less_is_more__filter__strip_empty_classes');

/**
 * Add img-responsive class within the_content included post_thumbnails.
 * If you want to have responsive images outside the_content you have to add this class manually.
 *
 * @param string $content Content of the current post.
 *
 *  Responsive images:
 * 	1) add img-responsive class
 * 	2) remove dimensions
 *
 * @since WP Less is More 1.0
 */
function wp_less_is_more__filter__bootstrap_responsive_images( $content ){
  $classes = 'img-responsive'; // separated by spaces, e.g. 'img image-link'

  // check if there are already classes assigned to the anchor
  if ( preg_match( '/<img.*? class="/', $content ) ) {

    $content = preg_replace( '/(<img.*? class=".*?)(".*?\/>)/', '$1 ' . $classes . ' $2', $content );

  } else {

    $content = preg_replace( '/(<img.*?)(\/>)/', '$1 class="' . $classes . '" $2', $content );
  }

  // remove dimensions from images,, does not need it!
  $content = preg_replace( '/(width|height)=\"\d*\"\s/', "", $content );

  return $content;
}
add_filter( 'the_content', 'wp_less_is_more__filter__bootstrap_responsive_images', 10 );

/**
 * Removes dimensions from post_thumbnails for better responsive
 *
 * @param string $html    The post thumbnail HTML.
 *
 * @since WP Less is More 1.1.2
 */

function wp_less_is_more__filter__remove_width_and_height( $html )
{
    $html = preg_replace( '/ (width|height)="[^"]+"/', '', $html );
    return $html;
}
add_filter( 'post_thumbnail_html',	'wp_less_is_more__filter__remove_width_and_height', 10 );

/**
 * Hides post thumbnail if post password required
 *
 * @return void|string Void on flase, HTML on true
 *
 * @since WP Less is More 1.1.6
 */
function wp_less_is_more__filter__hide_thumb_if_post_protected( $html ){
	if ( ! post_password_required() ) return $html;
}
add_filter( 'post_thumbnail_html',	'wp_less_is_more__filter__hide_thumb_if_post_protected', 10 );

/**
 * Excerpt lenght
 *
 * @param integer @lenght    The maximum number of words. Default 55.
 *
 * @return integer excerpt_length
 *
 * @since WP Less is More 1.1.1
 */
function wp_less_is_more__filter__excerpt_length( $length ) {

	$_excerpt_length = wp_less_is_more__default_excerpt_length();
	$excerpt_length = get_theme_mod( 'excerpt_length', $_excerpt_length );

	if ( $excerpt_length == $_excerpt_length )
		return $_excerpt_length;
	else return $excerpt_length;
}
add_filter( 'excerpt_length', 'wp_less_is_more__filter__excerpt_length', 999 );

/**
 * Filters the HTML output of single page number links.
 * This filter makes page number $link disable to click
 * by adding `disabled` class
 *
 * @param string $link The page number HTML output.
 * @param int    $i    Page number for paginated posts' page links.
 *
 * @since WP Less is More 1.1.1
*/

function wp_less_is_more__filter__wp_link_pages_link( $link, $i ){
	global $page;

	if ( !is_archive() AND $i === $page AND is_single() ) {
    $link = '<button class="btn btn-default btn-xs disabled">' . $i . '</button>';
	}

	return $link;
}
add_filter( 'wp_link_pages_link', 'wp_less_is_more__filter__wp_link_pages_link', 10, 2 );

/** Navigation Markup Template **
 *
 * Add extra class to navigation
 *
 * @since WP Less is More 1.1.6
 */
function wp_less_is_more__filter__navigation_markup_template( $template, $class ) {
    $template = '<nav class="navigation text-center center-block %1$s" role="navigation" aria-label="%4$s">
    <h2 class="screen-reader-text">%2$s</h2>
    <div class="nav-links">%3$s</div>
</nav>';
    return $template;
};
add_filter( 'navigation_markup_template', 'wp_less_is_more__filter__navigation_markup_template', 10, 2 );

/**
 * Filters the cancel comment reply link HTML.
 * Added extra glyphicon-remove and btn class
 *
 * @since WP Less is More 1.1.6
 *
 * @param string $formatted_link The HTML-formatted cancel comment reply link.
 * @param string $link           Cancel comment reply link URL.
 * @param string $text           Cancel comment reply link text.
 */

function wp_less_is_more__filter__cancel_comment_reply_link( $formatted_link, $link, $text ) {

	$style = isset( $_GET['replytocom'] ) ? '' : ' style="display:none;"';
    $formatted_link = '<a class="btn btn-sm btn-default" rel="nofollow" id="cancel-comment-reply-link" href="' . $link . '"' . $style . '><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;' . $text . '</a>';
    return $formatted_link;
}
add_filter( 'cancel_comment_reply_link', 'wp_less_is_more__filter__cancel_comment_reply_link', 10, 3 );


/**
 * Filters the arguments for the Custom Menu widget.
 * @argument @menu_class added for non left padding
 *
 * @return @nav_menu_args
 *
 * @since WP Less is More 1.1.6
 */

function wp_less_is_more__filter__widget_nav_menu_args( $nav_menu_args, $nav_menu, $args, $instance ) {
    $nav_menu_args = array(
	'menu_class' => 'list-unstyled',
    'walker'			=> new Wp_Less_Is_More_Bootstrap_Navwalker(),
);
    return $nav_menu_args;
}
add_filter( 'widget_nav_menu_args', 'wp_less_is_more__filter__widget_nav_menu_args', 10, 4 );

/**
 * Filters the arguments for the Categories widget drop-down.
 *
 * @since WP Less is More 1.1.6
 *
 * @see wp_dropdown_categories()
 *
 * @param array $cat_args An array of Categories widget drop-down arguments.
 */

function wp_less_is_more__filter__widget_categories_dropdown_args( $cat_args ) {

	$cat_args['class'] = 'form-control';
    return $cat_args;
}
add_filter( 'widget_categories_dropdown_args', 'wp_less_is_more__filter__widget_categories_dropdown_args', 10, 1 );

/**
 * Actions HOOK
 *
 */

if ( ! function_exists( 'wp_body_open' ) ) {
    /**
     * Fire the wp_body_open action.
     *
     * Added for backwards compatibility to support WordPress versions prior to 5.2.0.
     */
    function wp_body_open() {
        /**
         * Triggered after the opening <body> tag.
         */
        do_action( 'wp_body_open' );
    }
}

/**
 * Include a skip to content link at the top of the page so that users can bypass the menu.
 */
function wp_less_is_more__action__skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#site-content">' . __( 'Skip to the content', 'wp-less-is-more' ) . '</a>';
}

add_action( 'wp_body_open', 'wp_less_is_more__action__skip_link', 5 );

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 *
 * 	You've got four widgets area
 * 	1) on the left bottom side of the site
 * 	2) in the left middle - bottom
 * 	3) in the right bottom side
 *   4) on the right bottom side
 *
 * @since WP Less is More 1.0
 *
 */

function wp_less_is_more__action__widgets_init() {
	register_sidebar( array(
		'name'			=> __( 'Left Bottom Widget Area', 'wp-less-is-more' ),
		'id'			=> 'sidebar-left',
		'description'	=> __( 'Appears on the left-bottom side of the page.', 'wp-less-is-more' ),
		'before_widget'	=> '<div class="widget-content">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h3 class="widget-title subheading heading-size-3">',
		'after_title'	=> '</h3>',
	) );
	register_sidebar( array(
		'name'			=> __( 'Middle Left  Bottom Widget Area', 'wp-less-is-more' ),
		'id'			=> 'sidebar-middle-left',
		'description'	=> __( 'Appears on the middle-bottom side of the page.', 'wp-less-is-more' ),
		'before_widget'	=> '<div class="widget-content">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h3>',
		'after_title'	=> '</h3>',
	) );
	register_sidebar( array(
		'name'			=> __( 'Middle Right Bottom Widget Area', 'wp-less-is-more' ),
		'id'			=> 'sidebar-middle-right',
		'description'	=> __( 'Appears on the right-bottom side of the page.', 'wp-less-is-more' ),
		'before_widget'	=> '<div class="widget-content">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h3>',
		'after_title'	=> '</h3>',
	) );
	register_sidebar( array(
		'name'			=> __( 'Right Bottom Widget Area', 'wp-less-is-more' ),
		'id'			=> 'sidebar-right',
		'description'	=> __( 'Appears on the right-bottom side of the page.', 'wp-less-is-more' ),
		'before_widget'	=> '<div class="widget-content">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h3>',
		'after_title'	=> '</h3>',
	) );

}
add_action( 'widgets_init', 'wp_less_is_more__action__widgets_init' );



/**
 *  Enqueue scripts and styles.
 *
 * @since WP Less is More 1.0
 */

function wp_less_is_more__action__enqueue_js_and_css() {

	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_script( 'bootstrap', get_stylesheet_directory_uri() . '/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '3.4.1', false );

	wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/bootstrap/css/bootstrap.min.css', false, '3.4.1', 'all' );


	wp_enqueue_style( 'bootstrap-joombotron-narrow', get_stylesheet_directory_uri() . '/bootstrap/css/jumbotron-narrow.min.css', false, '3.4.1', 'all' );

	wp_enqueue_style( 'wp-less-is-more-style',	get_stylesheet_directory_uri() . '/style.css', false, $theme_version, 'all' );

	/*
	* HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
	*
	*/

	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/bootstrap/js/html5shiv.min.js',   false, null, true );
	wp_enqueue_script( 'respond',	 get_template_directory_uri() . '/bootstrap/js/respond.min.js',	false, null, true );

	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
	wp_script_add_data( 'respond',   'conditional', 'lt IE 9' );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' )  ){
	wp_enqueue_script( 'comment-reply' );
	/*
	 * Allowed_tags popover, tooltip and autoheight comment textarea trigger handler
	 * @since WP Less is More 1.1.7
	 */
		wp_enqueue_script ( 'wp-less-is-more-popover',	 get_template_directory_uri() . '/js/wp-less-is-more-popover.min.js', array('jquery'), null, true );
		// Add allowet tags to localize_script
		wp_localize_script( 'wp-less-is-more-popover', 'wp_less_is_more_popover', array(
			'allowed_tags' => htmlspecialchars( allowed_tags() ),
			'commenttextfocus' => ( isset( $_GET['replytocom'] ) ) ? true:false,
		));
	}
}
add_action( 'wp_enqueue_scripts', 'wp_less_is_more__action__enqueue_js_and_css' );

/**
 * Enqueue script for custom customize control.
 *
 * @since WP Less is More 1.1.1
 */

function wp_less_is_more__action__customize_enqueue_js() {
	wp_enqueue_script( 'wp-less-is-more-custom-customize', get_template_directory_uri() . '/inc/customizer/js/wp_less_is_more_show_if_checked.js', array( 'jquery', 'customize-controls' ), false, true );
}
add_action( 'customize_controls_enqueue_scripts', 'wp_less_is_more__action__customize_enqueue_js' );

/**
 * Custom Site Title
 *
 * This function changes the way you see (in header section)
 * your site tile (or blog name), depends on different pages
 * See line: 27 in header.php file
 *
 * @echo string $site_title
 *
 * @since WP Less is More 1.1.0.8
 */

function wp_less_is_more__site_title(){

	// if there is attachment page display: Attachment
	if ( is_attachment() ) {

		$site_title =  __( 'Attachment', 'wp-less-is-more');
	}
		// if there is author page display: Author + author name
		elseif ( is_author()   ) {

			$site_title =  __( 'Author:', 'wp-less-is-more') . ' ' . get_the_author();
		}
			// if there is archive display: Archive
			elseif ( is_archive()  ) {

				$site_title =  __( 'Archive', 'wp-less-is-more');
			}

				// if there is custom page templete used display page title
				elseif( is_page_template( 'templates/page_list-child-pages.php' ) ) {

					$site_title =  the_title();
				}
					// in other any cases display hyperlinked blog name
					else {

						$site_title =  get_bloginfo( 'name' );
					}
	echo $site_title;
}

/**
 * Taxonomy Title
 *
 * This function shows the single taxonomy title - styled as breadcrumb - on archive page
 *
 * @echo @html $output
 *
 * @since WP Less is More 1.1.4
 */

function wp_less_is_more__taxonomy_title(){
	global $wp_query;

	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

	if ( is_tag() || is_category() ) {

	$output = '<ol class="breadcrumb">';
	$output .= '<li class="active">';

		if ( is_tag() ) {

		 $output .= __( 'Posts tagged with' , 'wp-less-is-more' );
		}

		if ( is_category() ) {

		$output .= __( 'Posts in category', 'wp-less-is-more' );
		}

	$output .= '</li>';
	$output .= '<li><a href="#">' . single_tag_title( '', false ) . '</a> </li>';

/*
 * Page number text
 * @since 1.1.6
 */
	if ( $wp_query->max_num_pages > 1 )
	$output .= '<li><span class="badge">' . sprintf( __( 'page %s', 'wp-less-is-more' ), $paged ) . '</span></li>';
	$output .= '</ol>';

	echo $output;

	}
}

/**
 ** Cutom Footer Text
 *
 * @echo string $text
 *
 * @since WP Less is More 1.1.1
 */

function wp_less_is_more__custom_footer_text(){

	$custom_footer_text = get_theme_mod( 'custom_footer_text', wp_less_is_more__default_footer_text() );

	$text = wp_less_is_more__sanitize_text( $custom_footer_text );

		if ( get_theme_mod( 'display_footer_text', 1 ) )
	 echo $text;
}

/**
 * This is a post summary info appears at the bottom of the post but
 * over comments section
 * You can choose betwen text and icons
 * (see in customizer)
 *
 * @return @html
 *
 * @since: WP Less is More 1.1.4
 */

function wp_less_is_more__entry_meta(){

	if( get_theme_mod( 'entry_meta', 1 ) ){

	if( has_tag() ) { ?>
<p title="<?php esc_attr_e( 'hashtags - tags - keywords', 'wp-less-is-more' ); ?>"><span class="glyphicon glyphicon-tags" aria-hidden="true"></span><span class="sr-only"><?php _e( 'Tagged with:', 'wp-less-is-more' ); ?></span>&ensp;<?php the_tags( '', ', ', '' ); ?></p><?php } ?>

<p class="post_author vcard author post_date post_modified_dat">
<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
<span class="sr-only"><?php _e( 'Written by', 'wp-less-is-more' ); ?></span>
<span class="fn" title="<?php esc_attr_e( 'Written by', 'wp-less-is-more' ); ?>"><?php the_author_link() ?></span>&emsp;

<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
<span class="sr-only"><?php _e( 'Published', 'wp-less-is-more' ); ?></span>
<time class="entry-date updated" title="<?php esc_attr_e( 'Published', 'wp-less-is-more' ); ?>"><?php the_date(); ?></time>&emsp;
<?php  /* Check if post has update */
if( get_the_modified_date() != get_the_date() ) : ?>
<span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
<span class="sr-only"><?php _e( 'Last update', 'wp-less-is-more' ); ?></span>
<time class="entry-date updated" title="<?php esc_attr_e( 'Last update', 'wp-less-is-more' ); ?>"><?php the_modified_date(); ?></time>&emsp;
<?php endif; ?>

<span class="text-right glyphicon glyphicon-folder-open" aria-hidden="true" title=" <?php esc_attr_e( 'Category', 'wp-less-is-more' ); ?>"></span><span class="sr-only"><?php _e( 'Category', 'wp-less-is-more' ); ?></span>&ensp;<span class="category"  title=" <?php esc_attr_e( 'Category', 'wp-less-is-more' ); ?>"><?php the_category( '&ensp;&bullet;&ensp;' ); ?></span></p>

	<?php } else {

?><p><?php the_tags( __( 'Tagged with:&nbsp;', 'wp-less-is-more' ), ', ', '<br />' ); ?></p>
<p><?php _e( 'Category:&nbsp;', 'wp-less-is-more' ); the_category( ' | ' ); ?></p>
<p class="post_author vcard author post_date post_modified_date"><?php _e( 'Written by:&nbsp;', 'wp-less-is-more' ); ?><span class="fn"><?php the_author_link(); ?></span> &diams; <?php _e( 'Published:', 'wp-less-is-more' ); ?> <time class="entry-date updated"><?php the_date(); ?></time>
<?php  /* Check if post has update */
if( get_the_modified_date() != get_the_date() ) : ?> &diams; <?php _e( 'Last update:', 'wp-less-is-more' ); ?> <time class="entry-date updated"><?php the_modified_date(); ?></time><?php endif; ?></p>
<?php }

}

/**
 * Sticky Post handle
 *
 * Adds `svg` pin to the sticky post title
 *
 * @return @html
 *
 * @since WP Less is More 1.1.5
 **/

function wp_less_is_more__sticky_pin(){

	if ( is_sticky() ) :

	$url =  get_template_directory_uri() . '/img/pin.svg';

?><img class="pull-right" style="position:relative;top:-0.5rem" width="28" src="<?php echo esc_url( $url ); ?>" alt="<?php esc_attr_e( 'Sticky pin', 'wp-less-is-more' );?>">
<?php endif;
}
/**
 * Post Password Protected handle
 *
 * Adds `svg` padlock to the protected post title
 *
 * @return @html
 *
 * @since WP Less is More 1.1.6
 */

function wp_less_is_more__password_protcted(){

	if ( post_password_required() ) :

?><span style="font-size:80%" class="glyphicon glyphicon-lock <?php ( is_singular() ) ? esc_attr('text-primary') : ''; ?>" aria-hidden="true"></span>&thinsp;<?php endif;
}

/**
 * Custom header
 * Show header image above the top menu
 *
 * @return @html
 *
 * @since WP Less is More 1.1.6
 **/

function wp_less_is_more__custom_header(){

	if ( get_custom_header()->url ) { ?>

<header id="masthead" class="site-header" role="banner"><img alt="<?php echo bloginfo( 'name' ); ?>" title="<?php echo bloginfo( 'description' ); ?>" src="<?php header_image(); ?>" class="img-responsive center-block" height="<?php
echo get_custom_header()->height;
?>" width="<?php echo get_custom_header()->width; ?>"/></header>

<?php  }
}

/**
 * Current page number indicator
 * Show current page number under the top menu on home.php template
 * if there is nth(n) page in pagination but not on archive page
 *
 * @var @paged 	Current Pagination Number
 * @return @html
 *
 * @since WP Less is More 1.1.6
 */

function wp_less_is_more__current_page_number(){

	$paged = get_query_var('paged');

	if ( $paged AND ! is_archive() ) { ?>

<p style="cursor:help" class="badge bg-red" title="<?php _e( 'Current page number', 'wp-less-is-more') ;?>"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>&nbsp;<?php

$paged = ( $paged ) ? $paged : 1;

printf(
	/* translators: %s: page number in pagination */
	__( 'Page №%s', 'wp-less-is-more' ), $paged ); ?>
</p>
<?php }
}

/**
 * Comment Legend
 *
 * @return void|string $output      HTML comment legend text
 *
 * @since WP Less is More 1.1.7
 */

function wp_less_is_more__comment_legend(){
	//Show comment legenf text if omments_open()
	if ( comments_open() ){

 // Don't show comment legenf text if comment_registration option is on and user is not logged in
		if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ){
			return;
		}

	$output = '<hr style="margin-top:0">';
	$output .= '<div class="popoverContainer" style="position:relative">';
	$output .=  '<p class="small">';
	$output .= __( '*) Required fields are marked with star', 'wp-less-is-more' ) . '<br>';
	$output .=  _x( '**) You can use some', 'comment legend part1', 'wp-less-is-more' );
	$output .= '<button title="' . esc_attr__( 'Alowed HTML tags and attributes', 'wp-less-is-more' ) . '" type="button" class="triggerpopover btn btn-xs btn-link" data-toggle="popover" data-placement="top" role="button">';
	$output .= _x( 'HTML markup', 'comment legend part2 (button text)', 'wp-less-is-more' );
	$output .= '<span class="caret"></span></button></p>';
	$output .= '</div>';

	return $output;
	}
}
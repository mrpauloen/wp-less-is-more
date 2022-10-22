<?php

/**
 * Template Name: List Child Pages
 * Description: This template lists all the sub-pages in a bulleted list. Choose one of your page as parent and list all of its child pages in a nice and clear list of pages.
 *
 *
 ** Use @wp_list_pages() function
 *  Doc: https://developer.wordpress.org/reference/functions/wp_list_pages/
 *
 * @package WordPress
 * @subpackage WP Less is More
 * @since WP Less is More 1.1.0.7
 */

 get_header();

	if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article>

<?php

global $post;

if ( is_page() && $post->post_parent )

	$childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0' );

else

	$childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0' );

if ( $childpages ) {

	echo '<ul>' . $childpages . '</ul>';

}

?>

<!--
<?php trackback_rdf(); ?>
-->

</article>

<?php endwhile; else: ?>

<p><?php _e( 'Sorry, no posts matched your criteria.', 'wp-less-is-more' ); ?></p>

<?php endif;

get_footer(); ?>


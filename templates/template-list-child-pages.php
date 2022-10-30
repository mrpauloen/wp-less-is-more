<?php

/**
 * Template Name: List Child Pages
 * Description: This template lists all the sub-pages in a bulleted list. Choose one of your page as parent and list all of its child pages in a nice and clear list of pages.
 *
 *
 ** Use @wp_list_pages() function
 *  Doc: https://developer.wordpress.org/reference/functions/wp_list_pages/
 *
 * @since WP Less is More 1.1.0.7
 */

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
<article>
		<?php 
		wp_list_pages(
			array(
				'title_li'    => '',
				'child_of'    => get_the_ID(),
				'sort_column' => 'menu_order',
			)
		);
		?>

<!--
		<?php trackback_rdf(); ?>
-->

</article>

<?php endwhile; else : ?>

<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'wp-less-is-more' ); ?></p>

	<?php
endif;

get_footer();

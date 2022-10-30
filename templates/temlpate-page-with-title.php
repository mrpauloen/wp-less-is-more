<?php

/**
 * Template Name: Page with title
 * Description: This template show page with title above thumbnail. It has been created because standart (default) page template hasn't it.
 *
 * @since WP Less is More 1.1.1
 */

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
<article>
<h3 class="container single-entry-title entry-title"><?php the_title(); ?></h3>
<hr/>
		<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-responsive' ) ); ?>

<div class="clearfix top"></div>

		<?php
		the_content();

		wp_link_pages(
			array(
				'link_before' => '<button type="button" class="btn btn-xs btn-danger">',
				'link_after'  => '</button>',
				'separator'   => '&nbsp;&nbsp;',
				'pagelink'    => _x( 'part: %', 'category & tag page', 'wp-less-is-more' ),
			)
		);
		?>

<div class="clearfix"></div>

<!--
		<?php trackback_rdf(); ?>
-->

</article>

<?php endwhile; else : ?>

<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'wp-less-is-more' ); ?></p>

	<?php
endif;

get_footer();


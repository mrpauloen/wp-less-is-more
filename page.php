<?php get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>

<article id="site-content" class="text-break">

		<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-responsive' ) ); ?>

<div class="clearfix"></div>

		<?php

		the_content();

		wp_link_pages(
			array(
				'before'      => '<p class="post-nav-links clear">' . __( 'Pages:', 'wp-less-is-more' ),
				'after'       => '</p>',
				'link_before' => '<button type="button" class="btn btn-xs btn-danger">',
				'link_after'  => '</button>',
				'separator'   => '&nbsp;&nbsp;',
				'pagelink'    => _x( 'part: %', 'category & tag page', 'wp-less-is-more' ),
			)
		);
		?>

<!--
		<?php trackback_rdf(); ?>
-->

		<?php comments_template(); ?>

</article>

<?php endwhile; else : ?>

<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'wp-less-is-more' ); ?></p>

	<?php
endif;

get_footer();

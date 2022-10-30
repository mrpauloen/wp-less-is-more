<?php get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>

<article id="site-content" class="text-break">
<h3 class="container single-entry-title entry-title"><?php wp_less_is_more__password_protcted(); ?> <?php the_title(); ?></h3>
<hr/>

		<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-responsive' ) ); ?>

<div class="clearfix top"></div>

		<?php
		the_content();

		wp_link_pages(
			array(
				'before'      => '<p class="pager clear">' . __( 'Go to:', 'wp-less-is-more' ),
				'after'       => '</p>',
				'link_before' => '<span class="btn btn-xs btn-danger">',
				'link_after'  => '</span>',
				'separator'   => '&nbsp;&nbsp;',
				'pagelink'    => _x( 'part: %', 'single post & page', 'wp-less-is-more' ),
			)
		);
		?>

<!--
		<?php trackback_rdf(); ?>
-->

<nav>
<ul class="pager">
<li class="previous"><?php previous_post_link( '%link', '<span aria-hidden="true">&larr;</span> ' . __( 'Previous post', 'wp-less-is-more' ) ); ?></li>
<li class="next"><?php next_post_link( '%link', __( 'Next post', 'wp-less-is-more' ) . ' <span aria-hidden="true">&rarr;</span>' ); ?></li>
</ul>
</nav>
<hr/>
<div class="entry-meta"><?php wp_less_is_more__entry_meta(); ?></div>

		<?php comments_template(); ?>

</article>

<?php endwhile; else : ?>

<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'wp-less-is-more' ); ?></p>

	<?php
endif;

get_footer();

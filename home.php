<?php get_header(); ?>

<div id="site-content"></div>

<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
<article <?php post_class( 'text-break' ); ?>>

		<?php
		the_post_thumbnail(
			'post-thumbnail',
			array(
				'class' => 'img-responsive',
			)
		);
		?>
<h3><a href="<?php the_permalink(); ?>" rel="<?php esc_attr_e( 'bookmark', 'wp-less-is-more' ); ?>" title="<?php esc_attr_e( 'Permanent Link to:', 'wp-less-is-more' ); ?>&nbsp;<?php the_title_attribute(); ?>"><?php wp_less_is_more__password_protcted(); ?><?php the_title(); ?></a><?php wp_less_is_more__sticky_pin(); ?></h3>

		<?php the_excerpt(); ?>

		<?php
		wp_link_pages(
			array(
				'before'      => '<p class="post-nav-links clear">' . __( 'Pages:', 'wp-less-is-more' ),
				'after'       => '</p>',
				'link_before' => '<span type="button" class="btn btn-xs btn-danger">',
				'link_after'  => '</span>',
				'separator'   => '&nbsp;&nbsp;',
				'pagelink'    => '%',
			)
		);
		?>
<p class="text-right">
<a href="<?php the_permalink(); ?>" rel="<?php esc_attr_e( 'bookmark', 'wp-less-is-more' ); ?>" title="<?php esc_attr_e( 'Permanent Link to:', 'wp-less-is-more' ); ?>&nbsp;<?php the_title_attribute(); ?>" class="btn btn-default" role="button"> <?php esc_html_e( 'Read more...', 'wp-less-is-more' ); ?></a>
</p>

<!--
		<?php trackback_rdf(); ?>
-->

</article>

<?php endwhile; else : ?>

<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'wp-less-is-more' ); ?></p>

	<?php
endif;

$curent_page_number = max( 1, get_query_var( 'paged', 1 ) );
$args               = array(
	'prev_next'          => true,
	'prev_text'          => '<span title="' . __( '&larr; Click to: Previous Page', 'wp-less-is-more' ) . '" class="badge bg-red">' . __( '&loarr; Previous', 'wp-less-is-more' ) . '</span>',
	'next_text'          => '<span title="' . __( 'Click to: Next Page &rarr;', 'wp-less-is-more' ) . '" class="badge bg-red">' . __( 'Next &roarr;', 'wp-less-is-more' ) . '</span>',
	'before_page_number' => '<span title="' . __( 'Another page number in pagination', 'wp-less-is-more' ) . '" class="badge bg-red">',
	'after_page_number'  => '</span>',
	'current'            => $curent_page_number,
);
the_posts_pagination( $args );
get_footer();

<?php get_header();

	if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article class="text-break">
<h4><a href="<?php the_permalink(); ?>"><span class="glyphicon glyphicon-link" aria-hidden="true"></span> <?php the_title(); ?> </a></h4>

<?php wp_link_pages(

	$args = array	(

		'link_before'	=> '<span title="Another page part in paging" class="btn btn-xs btn-danger">',
		'link_after'	=> '</span>',
		'separator'		=> '&nbsp;&nbsp;',
		'pagelink'		=> _x( 'part: %', 'category & tag page', 'wp-less-is-more' )

	));
?>

<!--

<?php trackback_rdf(); ?>

-->

</article>

<?php endwhile; else: ?>
<p><?php _e( 'Sorry, no posts matched your criteria.', 'wp-less-is-more' ); ?></p>
<?php endif;

$args = array(
		'prev_next'          => true,
		'prev_text'          => '<span title="' . __( '&larr; Click to: Previous Page', 'wp-less-is-more' ) . '" class="badge bg-red">' . __( '&loarr; Previous', 'wp-less-is-more' ) . '</span>',
		'next_text'          => '<span title="' . __( 'Click to: Next Page &rarr;', 'wp-less-is-more' ) . '" class="badge bg-red">' . __( 'Next &roarr;', 'wp-less-is-more' ) . '</span>',
		'before_page_number' => '<span title="' . __( 'Another page number in pagination', 'wp-less-is-more' ) . '" class="badge bg-red">',
		'after_page_number'  => '</span>',
);
the_posts_pagination( $args );
get_footer();

<?php get_header();

	if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article id="site-content" class="text-break">

<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-responsive')) ?>

<div class="clearfix"></div>

<?php the_content();

 	wp_link_pages(

	$args = array	(

		'link_before'	=> '<button type="button" class="btn btn-xs btn-danger">',
		'link_after'	=> '</button>',
		'separator'		=> '&nbsp;&nbsp;',
		'pagelink'		=> _x( 'part: %', 'category & tag page', 'wp-less-is-more' )

	));

?>

<div class="clearfix"></div>

<!--
<?php trackback_rdf(); ?>
-->

<?php comments_template(); ?>

</article>

<?php endwhile; else: ?>

<p><?php _e( 'Sorry, no posts matched your criteria.', 'wp-less-is-more' ); ?></p>

<?php endif;

get_footer();
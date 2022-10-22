<?php get_header();

	if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article>

<h3 class="text-center"><?php the_title(); ?></h3>

<div class="thumbnail"><?php echo wp_get_attachment_image( get_the_ID(), '', '', array( "class" => "img-responsive" ) );  ?></div>

</article>

<?php endwhile; else: ?>

<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'wp-less-is-more' ); ?></p>

<?php endif;

get_footer();
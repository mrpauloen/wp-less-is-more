<?php
/**
 * Template Name: ** Page with title **
 * Description: This template show page with title above thumbnail. It has been created because standart (default) page template hasn't it.
 *
 ** Use @wp_list_pages() function **
 *  Doc: https://developer.wordpress.org/reference/functions/wp_list_pages/
 *
 * @package WordPress
 * @subpackage WP Less is More
 * @since WP Less is More 1.1.1
 */

 get_header();

	if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article>

<h3 class=" text-center container single-entry-title entry-title"><?php the_title(); ?></h3><hr/>

<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-responsive')) ?>

<div class="clearfix top"></div>

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

</article>

<?php endwhile; else: ?>
<p><?php _e( 'Sorry, no posts matched your criteria.', 'wp-less-is-more' ); ?></p>
<?php endif;
get_footer();?>
<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>">

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1">



<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php endif; ?>

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div class="container">

<?php wp_less_is_more__custom_header(); ?>

<div class="header clearfix">

<nav class="navbar-default" role="navigation">

	   <div class="navbar-header">

		<h3 class="site-title">

		<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">

		<?php wp_less_is_more__site_title(); ?></a>

		</h3>

		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">

		  <span class="sr-only"><?php _e( 'Toggle navigation', 'wp-less-is-more' ); ?></span>

		  <span class="icon-bar"></span>

		  <span class="icon-bar"></span>

		  <span class="icon-bar"></span>

	   </button>

	  </div>

<?php

		wp_nav_menu( array(

			'theme_location'	=> 'top',
			'depth'				=> 2,
			'container'			=> 'div',
			'container_class'	=> 'navbar-collapse collapse',
			'container_id'		=> 'navbar',
			'menu_class'		=> 'nav navbar-nav navbar-right main-navigation',
			'fallback_cb'		=> 'Wp_Less_Is_More_Bootstrap_Navwalker::fallback',
			'walker'			=> New Wp_Less_Is_More_Bootstrap_Navwalker()

			)
		);

?>

</nav>

</div>

<?php

wp_less_is_more__current_page_number();
wp_less_is_more__taxonomy_title();
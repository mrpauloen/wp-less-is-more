<footer class="footer text-center clear">

<?php get_sidebar();

	wp_nav_menu(
		array(
			'theme_location' => 'bottom',
			'container'      => false,
			'menu_class'     => 'list-inline dropup',
			'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
			'depth'          => 2,
			'fallback_cb'    => 'Wp_Less_Is_More_Bootstrap_Navwalker::fallback',
			'walker'         => new Wp_Less_Is_More_Bootstrap_Navwalker(),
		)
	);
	?>

<p class="copyright"><?php wp_less_is_more__custom_footer_text(); ?></p>

</footer>

</div>

<!-- End of main container -->

<?php wp_footer(); ?>

</body>
</html>

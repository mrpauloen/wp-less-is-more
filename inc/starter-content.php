<?php
/**
 * WP Less is More Starter Content
 *
 * @link https://make.wordpress.org/core/2016/11/30/starter-content-for-themes-in-4-7/
 *
 * Function to return the array of starter content for the theme.
 *
 * Passes it through the `wp_less_is_more_starter_content` filter before returning.
 *
 * @return array A filtered array of args for the starter_content.
 *
 * @since WP Less is More 1.1.8
 */
function wp_less_is_more__get_starter_content() {

	$starter_content = array(
		'options'   => array(
			'blogdescription' => _x( 'This is the Tagline... a short description of your website.', 'Theme starter content', 'wp-less-is-more' ),
		),
		'widgets'   => array(
			'sidebar-left'         => array(
				'text_about',
			),
			'sidebar-middle-left'  => array(
				'calendar',
			),
			'sidebar-middle-right' => array(
				'text_business_info',
			),
			'sidebar-right'        => array(
				'meta',
			),
		),
		'posts'     => array(
			'home'    => array(
				'post_type' => 'page',
			),
			'about'   => array(
				'post_type' => 'page',
			),
			'contact' => array(
				'post_type' => 'page',
			),
			'blog'    => array(
				'post_type' => 'page',
			),
			'news'    => array(
				'post_type'    => 'page',
				'post_title'   => _x( 'News', 'Theme starter content', 'wp-less-is-more' ),
				'post_content' => _x( 'News content.', 'Theme starter content', 'wp-less-is-more' ),
			),
		),
		'nav_menus' => array(
			'top'    => array(
				'name'  => _x( 'Top Menu', 'Theme starter content', 'wp-less-is-more' ),
				'items' => array(
					'link_home',
					'page_about',
					'page_contact',
				),
			),
			'bottom' => array(
				'name'  => _x( 'Bottom Menu', 'Theme starter content', 'wp-less-is-more' ),
				'items' => array(
					'link_facebook',
					'link_twitter',
					'link_instagram',
					'link_github'  => array(
						'url' => 'https://github.com',
					),
					'link_youtube' => array(
						'url' => 'https://youtube.com',
					),
					'link_other'   => array(
						'title'       => _x( 'Other', 'Theme starter content', 'wp-less-is-more' ),
						'url'         => '#',
						'description' => _x( 'Short description', 'Theme starter content', 'wp-less-is-more' ),
					),
				),
			),
		),
	);

	/**
	 * Filters WP Less is More array of starter content.
	 *
	 * @since WP Less is More 1.1.8
	 *
	 * @param array $starter_content Array of starter content.
	 */
	return apply_filters( 'wp_less_is_more_filter_starter_content', $starter_content );
}

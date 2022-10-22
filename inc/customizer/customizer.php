<?php

/**
 * WP Less is More Theme Customizer functionality
 *
 * @since WP Less is More 1.1.1
 */

## firt let's define some custom sanitize functions
function wp_less_is_more__sanitize_text( $text ){

	$allowed_html = array(

		'a' => array(
			'href' => array(),
		),
		'br' => array(),
		'del' => array (
			'datetime' => array(),
		),
		'em' => array(),
		'i' => array(),
		'q' => array(
			'cite' => array(),
		),
		's' => array(),
		'strike' => array(),
		'strong' => array(),
	);

	$text = wp_kses( $text, $allowed_html );
	return  $text;

}


function wp_less_is_more__sanitize_checkbox( $checked ) {
	// Boolean check.
	return isset( $checked ) && true == $checked;
}

function wp_less_is_more__sanitize_numbers( $number ) {
	// number check.
	return absint( $number );
}

/** Default footer text **/
function wp_less_is_more__default_footer_text(){

	$default_footer_text = sprintf( esc_html__( 'Copyright &copy; by %s', 'wp-less-is-more' ), get_bloginfo( 'name' ) );

	return $default_footer_text;

}

/** Default excerpt length **/
function wp_less_is_more__default_excerpt_length(){
	return 55;
}



/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */

function wp_less_is_more__customize_partial_blogname() {
	bloginfo( 'name' );
}

## Then register theme customizer
add_action( 'customize_register', 'wp_less_is_more__theme_customize', 11 );
function wp_less_is_more__theme_customize( $wp_customize ) {

	/*
	 * Failsafe is safe
	 */
	if ( ! isset( $wp_customize ) ) {
		return;
	}


	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';


	if ( isset( $wp_customize->selective_refresh ) ) {

		$wp_customize->selective_refresh->add_partial(

			'blogname',

			array(

				'selector'        => '.site-title a',
				'render_callback' => 'wp_less_is_more__customize_partial_blogname',

			)

		);

		$wp_customize->selective_refresh->add_partial(

			'custom_footer_text',

			array(

				'selector'        => '.copyright',
				'render_callback' => 'wp_less_is_more__default_footer_text',

			)

		);

		$wp_customize->selective_refresh->add_partial(

			'header_image',

			array(

				'selector'        => '.site-header',
				'render_callback' => 'wp_less_is_more__custom_header',

			)

		);

		$wp_customize->selective_refresh->add_partial(

			'entry_meta',

			array(

				'selector'        => '.entry-meta',
				'render_callback' => 'wp_less_is_more__entry_meta',

			)

		);

	}


		/** Read Me Section
		 *
		 * @since: WP Less is More 1.1.4
		 */
		class WP_Less_is_More_Read_Me extends WP_Customize_Control {

			public function render_content() {
				?>	
				<div class="wp-less-is-more-read-me">	
					<h3><?php

						printf(	
							wp_kses(	
								/* translators: %s: Theme URI */	
								__( 'Thank you for using the <a href="%s" target="_blank">WP Less is More</a> theme.', 'wp-less-is-more' ),	
								array(	
									'a' => array(	
										'href' => array(),	
										'target' => array(),	
									),	
								)	
							),	
							 esc_url( 'https://wordpress.org/themes/wp-less-is-more/' )	
						);	
						
						?></h3>	

					<hr/>	

					<h3><?php esc_html_e( 'Support', 'wp-less-is-more' ); ?></h3>	
					<p><?php esc_html_e( 'If there is something you don\'t understand, please use the support forum.', 'wp-less-is-more' ); ?></p>	
					<p><?php

						printf(	
							wp_kses(	
								/* translators: %s: Theme Support Forum URLs*/	
								__( '<a href="%s" target="_blank">Support Forum</a>', 'wp-less-is-more' ),	
								array(	
									'a' => array(	
										'href' => array(),	
										'target' => array(),	
									),	
								)	
							),	
							esc_url( 'https://wordpress.org/support/theme/wp-less-is-more' ) );	
					 
					?></p>
	
					<hr/>	
	
					<h3><?php esc_html_e( 'Contribute', 'wp-less-is-more' ); ?></h3>	
					<p><?php esc_html_e( 'Are you familiar with github? Great! Use it as an extended support for reporting any bugs, keep track of tasks, propose enhancements or contributing to project.', 'wp-less-is-more' ); ?></a></p>	
					<p><?php
	
						printf(	
							wp_kses(	
								/* translators: %s: Theme github URL */	
								__( '<a href="%s" target="_blank">Contribute</a>', 'wp-less-is-more' ),	
								array(	
									'a' => array(	
										'href' => array(),	
										'target' => array(),	
									),	
								)	
							),	
							 esc_url( 'https://github.com/mrpauloen/wp-less-is-more' ) );	
					
					?></p>
	
					<hr/>	
	
					<h3><?php esc_html_e( 'Review', 'wp-less-is-more' ); ?></h3>
	
					<p><?php esc_html_e( 'If you are satisfied with the theme, we would greatly appreciate if you would review it.', 'wp-less-is-more' ); ?></p>	
					<p><?php	
	
						printf(
	
							wp_kses(	
							/* translators: %s: Theme Reviewing URL */	
							__( '<a href="%s" target="_blank">Review This Theme</a>', 'wp-less-is-more' ),	
								array(	
									'a' => array(	
										'href' => array(),	
										'target' => array(),	
									),	
								)	
						),	
						 esc_url( 'https://wordpress.org/support/view/theme-reviews/wp-less-is-more?filter=5' ) );	
					 ?></p>
	
					<hr/>
	
					<h3><?php esc_html_e( 'Upgrade', 'wp-less-is-more' ); ?></h3>	
					<p><?php

						printf(	
							wp_kses(	
								/* translators: %s: Theme Author Funpage URL */	
								__( 'If you are interested in making major changes or looking for paid help, write me a message on <a href="%s" target="_blank">this fanpage</a>, or just simple create a new (separate) thread on the support forum. .', 'wp-less-is-more' ),
								array(	
									'a' => array(	
										'href' => array(),	
										'target' => array(),	
									),	
									)	
							),	
								esc_url( 'https://www.facebook.com/WPSolucje/' ) );	
						?></a></p>
	
					<hr/>	
	
					<h3><?php esc_html_e( 'Components', 'wp-less-is-more' ); ?></h3>	
					<p><?php	
	
						printf(	
							wp_kses(	
								/* translators: %s: official Bootstrap 3 Documentation URL */	
								__( 'If you want to beautify your theme using the ready-made CSS, HTML and JS components, go to the official <a href="%s" target=_blank">Bootstrap 3 Documentation</a> site.', 'wp-less-is-more' ),
								array(	
									'a' => array(	
										'href' => array(),	
										'target' => array(),	
									),	
								)	
							),	
							 esc_url( 'https://getbootstrap.com/docs/3.4/components/' ) );	
						?>
	
					<hr/>
	
					<h3><?php esc_html_e( 'Some improvements comming soon! :)', 'wp-less-is-more' ); ?></h3>		
				</div>
	
				<?php
	
			}	
	}


	/******************************************

	 *                                        *

	 *      READ ME FIRST - whole section     *

	 *                                        *

	 ******************************************

	 */

	$wp_customize->add_section( 'read_me_section', array(

		'title'    => __( 'Read Me First', 'wp-less-is-more' ),
		'priority' => 1,

	) );

	$wp_customize->add_setting( 'read_me_text', array(

		'default'           => '',
		'sanitize_callback' => 'wp_less_is_more__sanitize_text',

	) );

	$wp_customize->add_control( new WP_Less_is_More_Read_Me( $wp_customize, 'read_me_text', array(

		'section'  => 'read_me_section',
		'priority' => 1,

	) ) );


	/******************************************

	 *                                        *

	 *      Option One - Custom Footer        *

	 *                                        *

	 ******************************************

	 */

	$wp_customize->add_section(

		'custom_footer_section',

		array(

			'title'      => __( 'Custom footer', 'wp-less-is-more' ),
			'description'	=> sprintf( __( 'Use this option to be able to control the footer text. It is enabled by default and looks like this: <strong><i>%s</i></strong>',  'wp-less-is-more' ), wp_less_is_more__default_footer_text() ),

	) );



	/**
	 * Display Footer Text
	 *
	 * Return Values:
	 * (boolean)
	 * True on success, false on failure.
	 *
	 **/
	$wp_customize->add_setting(

		// $id

		'display_footer_text',

		// $args

		array(

			'default'			=> true,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'wp_less_is_more__sanitize_checkbox'

		)

	);

	/**
	 * Custom Footer Text
	 *
	 * Return Values:
	 * (string)
	 * Value set for the option
	 *
	 */
	$wp_customize->add_setting(

		'custom_footer_text',

		array(

			'default'        => wp_less_is_more__default_footer_text(),
			'capability'     => 'edit_theme_options',
			'type'           => 'theme_mod',
			'sanitize_callback' => 'wp_less_is_more__sanitize_text'

		)

	);



	$wp_customize->add_control(

		// $id
		'display_footer_text_control',

		// $args
		array(

			'label'			=> __( 'Display footer text', 'wp-less-is-more' ),
			'settings'		=> 'display_footer_text',
			'section'		=> 'custom_footer_section',
			'type'			=> 'checkbox'

		)
	);

	$wp_customize->add_control(

		'custom_footer_control',

		array(

			'label'    => __( 'Text in footer:', 'wp-less-is-more' ),
			'description' => sprintf( __( 'Use this field to override the default footer text. If nothing specified, default text will be used instead. You may use these HTML tags and attributes: <code>%s</code>.', 'wp-less-is-more' ), esc_html( '<a href="" title=""> <b> <del datetime=""> <em> <i> <q cite=""> <s> <strike> <strong> ' ) ),
			'section'  => 'custom_footer_section',
			'settings' => 'custom_footer_text',
			'type'     => 'text'

		)
	);


	/******************************************

	 *                                        *

	 *      Option Two - Excerpt Lenght       *

	 *                                        *

	 ******************************************/

	$wp_customize->add_section(

		'excerpt_length_section',

		array(

			'title'      => __( 'Excerpt lenght','wp-less-is-more' ),
			'description'	=> sprintf( 

			/* translators: %1$s: the_excerpt (word); %2$s !--more-- (tag); %3$s: url to codex; %4$s: url to codex */

			__( 'Use this option to control the excerpt lenght on the home page. The default excerpt length is 55 words. This setting works only when a post themplate use <code>%1$s</code> template tag and the excerpt is created automatically (excerpt meta box on the post editor screen is empty) but no longer than the <code>%2$s</code> tag (if it\'s used). See: <a href="%3$s" target="_blank">Excerpt</a> or <a href="%4$s" target="_blank">Customizing_the_Read_More</a> in codex.', 'wp-less-is-more'),
			esc_html__( 'the_excerpt', 'wp-less-is-more' ),
			esc_html__( '&lt;!--more--&gt;', 'wp-less-is-more'  ),
			esc_url('https://codex.wordpress.org/Excerpt' ),
			esc_url('https://codex.wordpress.org/Customizing_the_Read_More' )
			)
		) 
	);

	/**
	 * Excerpt lenght
	 *
	 * Return Values:
	 * (int)
	 * A non-negative integer.
	 *
	 */
	$wp_customize->add_setting(

		'excerpt_length',

		array(

			'default' => wp_less_is_more__default_excerpt_length(),
			'capability'     => 'edit_theme_options',
			'type'           => 'theme_mod',
			'sanitize_callback' => 'wp_less_is_more__sanitize_numbers',
		)

	);

	$wp_customize->add_control(

    'excerpt_length_control',

		array(

			'label' => __( 'Use the slider or enter a number:', 'wp-less-is-more' ),
			'settings' => 'excerpt_length',
			'section' => 'excerpt_length_section',
			'type' => 'range',
			'input_attrs' => array(
				'min' => 1,
				'max' => 200,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_control(

    '_excerpt_length_control',

		array(

			'description' => __( 'Available slider range: 1 to 200', 'wp-less-is-more' ),
			'settings' => 'excerpt_length',
			'section' => 'excerpt_length_section',
			'type' => 'number',
			'input_attrs' => array(
				'min' => 1,
				'max' => 200,
				'step' => 1,
			),
		)
	);


	/******************************************

	 *                                        *

	 *      Option Three - Entry Meta         *

	 *                                        *

	 ******************************************/
	$wp_customize->add_section(

		'entry_meta_section',

		array(

			'title'      => __( 'Entry Meta', 'wp-less-is-more' ),
			'description'	=> __( 'Change the way you see the post meta data section.', 'wp-less-is-more' ),
		)
 	);


	/**
	 * Entry Meta
	 *
	 * Return Values:
	 * (boolean)
	 * True on success, false on failure.
	 */
	$wp_customize->add_setting(

		'entry_meta',

		array(

			'default'        => true,
			'capability'     => 'edit_theme_options',
			'type'           => 'theme_mod',
			'sanitize_callback' => 'wp_less_is_more__sanitize_checkbox',
		)
	);

	$wp_customize->add_control(

	    'entry_meta_control',

			array(

				'label' =>	__( 'Use icons instead of text', 'wp-less-is-more' ),
				'description' => __( 'Go to the post meta data & comments section to see the effects <hr/>', 'wp-less-is-more' ),
				'settings' => 'entry_meta',
				'section' => 'entry_meta_section',
				'type' => 'checkbox',
			)

	);
}
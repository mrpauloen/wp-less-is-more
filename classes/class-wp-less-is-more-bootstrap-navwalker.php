<?php

/**
 * Class Name: Wp_Bootstrap_Navwalker
 * GitHub URI: https://github.com/twittem/
 * Description: A custom WordPress nav walker class to implement the Bootstrap 3 navigation style in a custom theme using the WordPress built in menu manager.
 * Version: 2.0.4
 * Author: Edward McIntyre - @twittem
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
class Wp_Less_Is_More_Bootstrap_Navwalker extends Walker_Nav_Menu {

	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {

		$indent = str_repeat( "\t", $depth );

		$output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";

	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		/**
		 * Dividers, Headers or Disabled
		 * =============================
		 * Determine whether the item is a Divider, Header, Disabled or regular
		 * menu item. To prevent errors we use the strcasecmp() function to so a
		 * comparison that is not case sensitive. The strcasecmp() function returns
		 * a 0 if the strings are equal.
		 */
		if ( 0 === strcasecmp( $item->attr_title, 'divider' ) && 1 === $depth ) {

			$output .= $indent . '<li role="presentation" class="divider">';

		} elseif ( 0 === strcasecmp( $item->title, 'divider' ) && 1 === $depth ) {

			$output .= $indent . '<li role="presentation" class="divider">';

		} elseif ( 0 === strcasecmp( $item->attr_title, 'dropdown-header' ) && 1 === $depth ) {

			$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );

		} elseif ( 0 === strcasecmp( $item->attr_title, 'disabled' ) ) {

			$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';

		} else {

			$class_names = '';
			$value       = '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;

			$classes[] = 'menu-item-' . $item->ID;

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

			if ( $args->has_children ) {

				$class_names .= ' dropdown';
			}

			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );

			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $value . $class_names . '>';

			$atts = array();

			$atts['title'] = ! empty( $item->title ) ? $item->title : '';

			$atts['target'] = ! empty( $item->target ) ? $item->target : '';

			$atts['rel'] = ! empty( $item->xfn ) ? $item->xfn : '';


			// If item has_children add atts to a.
			if ( 0 === $depth && $args->has_children ) {

				$atts['href'] = '#';

				$atts['data-toggle'] = 'dropdown';

				$atts['class'] = 'dropdown-toggle';

				$atts['aria-haspopup'] = 'true';

				$atts['aria-expanded'] = 'false';

				$atts['role'] = 'button';

			} else {

				$atts['href'] = ! empty( $item->url ) ? $item->url : '';

			}

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

			$attributes = '';

			foreach ( $atts as $attr => $value ) {

				if ( ! empty( $value ) ) {

					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );

					$attributes .= ' ' . $attr . '="' . $value . '"';

				}
			}

			$item_output = $args->before;

			/*
			 * Glyphicons
			 * ===========
			 * Since the the menu item is NOT a Divider or Header we check the see
			 * if there is a value in the attr_title property. If the attr_title
			 * property is NOT null we apply it as the class name for the glyphicon.
			 */
			if ( ! empty( $item->attr_title ) ) {

				$item_output .= '<a' . $attributes . '><span class="glyphicon ' . esc_attr( $item->attr_title ) . '"></span>&nbsp;';

			} else {
				$item_output .= '<a' . $attributes . '>';
			}

			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

			$item_output .= ( $args->has_children && 0 === $depth ) ? ' <span class="caret"></span></a>' : '</a>';

			$item_output .= $args->after;


			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

		}

	}

	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth.
	 *
	 * This method shouldn't be called directly, use the walk() method instead.
	 *
	 * @see Walker::start_el()
	 * @since 2.5.0
	 *
	 * @param object $element Data object
	 * @param array $children_elements List of elements to continue traversing.
	 * @param int $max_depth Max depth to traverse.
	 * @param int $depth Depth of current element.
	 * @param array $args
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return null Null on failure with no changes to parameters.
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

		if ( ! $element ) {
			return;
		}
		$id_field = $this->db_fields['id'];


		// Display this element.
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
		}

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

	}

	/**
	 * Menu Fallback
	 * =============
	 * If this function is assigned to the wp_nav_menu's fallback_cb variable
	 * and a manu has not been assigned to the theme location in the WordPress
	 * menu manager the function with display nothing to a non-logged in user,
	 * and will add a link to the WordPress menu manager if logged in as an admin.
	 *
	 * @param array $args passed from the wp_nav_menu function.
	 */
	public static function fallback( $args ) {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}

		// Initialize var to store fallback html.
		$fallback_output = '';

		// Menu container opening tag.
		$show_container = false;
		if ( $args['container'] ) {
			/**
			 * Filters the list of HTML tags that are valid for use as menu containers.
			 *
			 * @since WP 3.0.0
			 *
			 * @param array $tags The acceptable HTML tags for use as menu containers.
			 *                    Default is array containing 'div' and 'nav'.
			 */
			$allowed_tags = apply_filters( 'wp_nav_menu_container_allowedtags', array( 'div', 'nav' ) );
			if ( is_string( $args['container'] ) && in_array( $args['container'], $allowed_tags, true ) ) {
				$show_container   = true;
				$class            = $args['container_class'] ? ' class="menu-fallback-container ' . esc_attr( $args['container_class'] ) . '"' : ' class="menu-fallback-container"';
				$id               = $args['container_id'] ? ' id="' . esc_attr( $args['container_id'] ) . '"' : '';
				$fallback_output .= '<' . $args['container'] . $id . $class . '>';
			}
		}

			// The fallback menu.
			$class            = $args['menu_class'] ? ' class="menu-fallback-menu ' . esc_attr( $args['menu_class'] ) . '"' : ' class="menu-fallback-menu"';
			$id               = $args['menu_id'] ? ' id="' . esc_attr( $args['menu_id'] ) . '"' : '';
			$fallback_output .= '<ul' . $id . $class . '>';
			$fallback_output .= '<li class="nav-item"><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" class="nav-link" title="' . esc_attr__( 'Add a menu', 'wp-less-is-more' ) . '">' . esc_html__( 'Add a menu', 'wp-less-is-more' ) . '</a></li>';
			$fallback_output .= '</ul>';

			// Menu container closing tag.
		if ( $show_container ) {
			$fallback_output .= '</' . $args['container'] . '>';
		}

			// if $args has 'echo' key and it's true echo, otherwise return.
		if ( array_key_exists( 'echo', $args ) && $args['echo'] ) {
			echo $fallback_output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $fallback_output;
		}
	}
}

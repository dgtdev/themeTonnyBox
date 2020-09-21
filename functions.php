<?php

// Menus de navegacion, agregar mas utilizando el arreglo
function tonnybox_menus(){
	register_nav_menus(array(
		'menu-principal' => __( 'Menu Principal'),
		'menu-extra' => __('Menu Extra')
	));
}

add_action('init', 'tonnybox_menus');

// Scripts y Styles
function tonnybox_scripts_styles(){
	
	// Hoja de estilos principal
	wp_enqueue_style('tonnybox', get_template_directory_uri() . '/assets/css/tonnybox.css', array('googleFont'), '1.0.0');

	wp_enqueue_style( 'googleFont', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;1,700&display=swap', array(), '1.0.0' );

	// Hoja de estilos de WP
	wp_enqueue_style('style', get_stylesheet_uri(), array(), '1.0.0');
}

add_action('wp_enqueue_scripts', 'tonnybox_scripts_styles');

/* Enable support for title-tag */
add_theme_support( 'title-tag' );

	/* Enable support for custom logo */
function tonnybox_custom_logo_setup() {
	$defaults = array(
	 'height'      => 100,
	 'width'       => 400,
	 'flex-height' => true,
	 'flex-width'  => true,
	 'unlink-homepage-logo' => true,
 	);
 add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'tonnybox_custom_logo_setup' );

/** Sub-Menu **/

class CSS_Menu_Walker extends Walker {

	var $db_fields = array('parent' => 'menu_item_parent', 'id' => 'db_id');
	
	function start_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul>\n";
	}
	
	function end_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}
	
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
	
		global $wp_query;
		$indent = ($depth) ? str_repeat("\t", $depth) : '';
		$class_names = $value = '';
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		
		/* Add active class */
		if (in_array('current-menu-item', $classes)) {
			$classes[] = 'active';
			unset($classes['current-menu-item']);
		}
		
		/* Check for children */
		$children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
		if (!empty($children)) {
			$classes[] = 'has-sub';
		}
		
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
		
		$id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
		$id = $id ? ' id="' . esc_attr($id) . '"' : '';
		
		$output .= $indent . '<li' . $id . $value . $class_names .'>';
		
		$attributes  = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
		$attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target    ) .'"' : '';
		$attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn       ) .'"' : '';
		$attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url       ) .'"' : '';
		
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'><span>';
		$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
		$item_output .= '</span></a>';
		$item_output .= $args->after;
		
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
	
	function end_el(&$output, $item, $depth = 0, $args = array()) {
		$output .= "</li>\n";
	}
}


/* Soporte Woocommerce */

function tonnybox_add_woocommerce_support()
 {
add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'tonnybox_add_woocommerce_support' );


/* Check */
require_once'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/dgtdev/themeTonnyBox',
	__FILE__,
	'unique-plugin-or-theme-slug'
);

//Optional: If you're using a private repository, specify the access token like this:
$myUpdateChecker->setAuthentication('d8c1c797b76e7a2eb91fa0a1a7d4eb9aae3494da');

//Optional: Set the branch that contains the stable release.
$myUpdateChecker->setBranch('master');

?>
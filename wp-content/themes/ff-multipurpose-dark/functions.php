<?php
/**
 * Child Theme functions and definitions.
 * This theme is a child theme for FF Multipurpose.
 *
 * @package FF_Multipurpose_Dark
 * @author  FireflyThemes https://fireflythemes.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU Public License
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 */

/**
 * Theme functions and definitions.
 */
function ff_multipurpose_dark_enqueue_styles() {
	// Parent Theme stylesheet.
	wp_enqueue_style( 'ff-multipurpose-style', get_template_directory_uri() . '/style.css', null, ff_multipurpose_get_file_mod_date( get_template_directory() . '/style.css' ) );

	wp_enqueue_style( 'ff-multipurpose-dark-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'ff-multipurpose-style' ),
        ff_multipurpose_get_file_mod_date( get_stylesheet_directory() . '/style.css' )
    );
}
add_action(  'wp_enqueue_scripts', 'ff_multipurpose_dark_enqueue_styles' );

/**
 * Loads the child theme textdomain.
 */
function ff_multipurpose_dark_setup() {
    load_child_theme_textdomain( 'ff-multipurpose-dark', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'ff_multipurpose_dark_setup', 11 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ff_multipurpose_dark_widgets_init() {
    $args = array(
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    );

    register_sidebar( array(
        'name'        => esc_html__( 'Footer 4', 'ff-multipurpose-dark' ),
        'id'          => 'sidebar-5',
        'description' => esc_html__( 'Add widgets here to appear in your footer.', 'ff-multipurpose-dark' ),
        ) + $args
    );
}
add_action( 'widgets_init', 'ff_multipurpose_dark_widgets_init', 100 );

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 *
 * @since 1.0
 */
function ff_multipurpose_dark_footer_sidebar_class() {
    $count = 0;

    if ( is_active_sidebar( 'sidebar-2' ) ) {
        $count++;
    }

    if ( is_active_sidebar( 'sidebar-3' ) ) {
        $count++;
    }

    if ( is_active_sidebar( 'sidebar-4' ) ) {
        $count++;
    }

    if ( is_active_sidebar( 'sidebar-5' ) ) {
        $count++;
    }

    $class = '';

    switch ( $count ) {
        case '1':
            $class = 'one';
            break;
        case '2':
            $class = 'two';
            break;
        case '3':
            $class = 'three';
            break;
        case '4':
            $class = 'four';
            break;
    }

    if ( $class ) {
        echo 'class="widget-area footer-widget-area ' . $class . '"'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}

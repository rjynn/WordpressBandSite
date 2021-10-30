<?php
/**
 * Theme Palace options
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

/**
 * List of pages for page choices.
 * @return Array Array of page ids and name.
 */
function corpo_digital_page_choices() {
    $pages = get_pages();
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'corpo-digital' );
    foreach ( $pages as $page ) {
        $choices[ $page->ID ] = $page->post_title;
    }
    return  $choices;
}

/**
 * List of posts for post choices.
 * @return Array Array of post ids and name.
 */
function corpo_digital_post_choices() {
    $posts = get_posts( array( 'numberposts' => -1 ) );
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'corpo-digital' );
    foreach ( $posts as $post ) {
        $choices[ $post->ID ] = $post->post_title;
    }
    wp_reset_postdata();
    return  $choices;
}


/**
 * List of category for category choices.
 * @return Array Array of post ids and name.
 */
function corpo_digital_category_choices() {
    $tax_args = array(
        'hierarchical' => 0,
        'taxonomy'     => 'category',
    );
    $taxonomies = get_categories( $tax_args );
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'corpo-digital' );
    foreach ( $taxonomies as $tax ) {
        $choices[ $tax->term_id ] = $tax->name;
    }
    return  $choices;
}


if ( ! function_exists( 'corpo_digital_site_layout' ) ) :
    /**
     * Site Layout
     * @return array site layout options
     */
    function corpo_digital_site_layout() {
        $corpo_digital_site_layout = array(
            'wide'          => esc_url( get_template_directory_uri() . '/assets/images/full.png' ),
            'boxed-layout'  => esc_url( get_template_directory_uri() . '/assets/images/boxed.png' ),
        );

        $output = apply_filters( 'corpo_digital_site_layout', $corpo_digital_site_layout );
        return $output;
    }
endif;

if ( ! function_exists( 'corpo_digital_selected_sidebar' ) ) :
    /**
     * Sidebars options
     * @return array Sidbar positions
     */
    function corpo_digital_selected_sidebar() {
        $corpo_digital_selected_sidebar = array(
            'sidebar-1'             => esc_html__( 'Default Sidebar', 'corpo-digital' ),
            'optional-sidebar'      => esc_html__( 'Optional Sidebar 1', 'corpo-digital' ),
            'optional-sidebar-2'    => esc_html__( 'Optional Sidebar 2', 'corpo-digital' ),
        );

        $output = apply_filters( 'corpo_digital_selected_sidebar', $corpo_digital_selected_sidebar );

        return $output;
    }
endif;


if ( ! function_exists( 'corpo_digital_global_sidebar_position' ) ) :
    /**
     * Global Sidebar position
     * @return array Global Sidebar positions
     */
    function corpo_digital_global_sidebar_position() {
        $corpo_digital_global_sidebar_position = array(
            'right-sidebar' => esc_url( get_template_directory_uri() . '/assets/images/right.png' ),
            'no-sidebar'    => esc_url( get_template_directory_uri() . '/assets/images/full.png' ),
        );

        $output = apply_filters( 'corpo_digital_global_sidebar_position', $corpo_digital_global_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'corpo_digital_sidebar_position' ) ) :
    /**
     * Sidebar position
     * @return array Sidbar positions
     */
    function corpo_digital_sidebar_position() {
        $corpo_digital_sidebar_position = array(
            'right-sidebar'         => esc_url( get_template_directory_uri() . '/assets/images/right.png' ),
            'no-sidebar'            => esc_url( get_template_directory_uri() . '/assets/images/full.png' ),
        );

        $output = apply_filters( 'corpo_digital_sidebar_position', $corpo_digital_sidebar_position );

        return $output;
    }
endif;

if ( ! function_exists( 'corpo_digital_pagination_options' ) ) :
    /**
     * Pagination
     * @return array site pagination options
     */
    function corpo_digital_pagination_options() {
        $corpo_digital_pagination_options = array(
            'numeric'   => esc_html__( 'Numeric', 'corpo-digital' ),
            'default'   => esc_html__( 'Default(Older/Newer)', 'corpo-digital' ),
        );

        $output = apply_filters( 'corpo_digital_pagination_options', $corpo_digital_pagination_options );

        return $output;
    }
endif;

if ( ! function_exists( 'corpo_digital_switch_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function corpo_digital_switch_options() {
        $arr = array(
            'on'        => esc_html__( 'Enable', 'corpo-digital' ),
            'off'       => esc_html__( 'Disable', 'corpo-digital' )
        );
        return apply_filters( 'corpo_digital_switch_options', $arr );
    }
endif;

if ( ! function_exists( 'corpo_digital_hide_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function corpo_digital_hide_options() {
        $arr = array(
            'on'        => esc_html__( 'Yes', 'corpo-digital' ),
            'off'       => esc_html__( 'No', 'corpo-digital' )
        );
        return apply_filters( 'corpo_digital_hide_options', $arr );
    }
endif;

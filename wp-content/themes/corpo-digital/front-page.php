<?php
/**
 * The template for displaying al pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

get_header(); 
		// Call home if Homepage setting is set to latest posts.

	if ( corpo_digital_is_latest_posts() ) {
		get_template_part( 'template-parts/content', 'home' );

	} elseif ( corpo_digital_is_frontpage() ) {
		
		$options = corpo_digital_get_theme_options();
		$sorted = array();
		if ( ! empty( $options['sortable'] ) ) {
			$sorted = explode( ',' , $options['sortable'] );
		}

		foreach ( $sorted as $section ) {
			add_action( 'corpo_digital_primary_content', 'corpo_digital_add_'. $section .'_section' );
		}
		do_action( 'corpo_digital_primary_content' );

		if (true === apply_filters( 'corpo_digital_filter_frontpage_content_enable', true ) ) {
			get_template_part( 'page' );
		}
	}
get_footer();
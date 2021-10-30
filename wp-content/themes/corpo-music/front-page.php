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

		$sorted = array(  'slider','about','playlist','team','faq','event','promotion','gallery','testimonial','contact','blog');
	
		foreach ( $sorted as $section ) {

			if ( $section == 'playlist' || $section == 'team' || $section == 'event' ) {
				add_action( 'corpo_digital_primary_content', 'corpo_music_add_'. $section .'_section' );
			}else{
				add_action( 'corpo_digital_primary_content', 'corpo_digital_add_'. $section .'_section' );
			}
			
		}
		do_action( 'corpo_digital_primary_content' );

		if (true === apply_filters( 'corpo_digital_filter_frontpage_content_enable', true ) ) {
			get_template_part( 'page' );
		}
	}
get_footer();
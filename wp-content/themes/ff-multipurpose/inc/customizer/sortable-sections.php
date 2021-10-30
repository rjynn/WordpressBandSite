<?php
/**
 * FF Multipurpose Theme Customizer
 *
 * @package FF_Multipurpose
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ff_multipurpose_sections( $wp_customize ) {
	$wp_customize->add_panel( 'ff_multipurpose_sections', array(
		'title'       => esc_html__( 'Sections', 'ff-multipurpose' ),
		'priority'    => 150,
	) );

	$sections = array (
		'slider'               => esc_html__( 'Slider', 'ff-multipurpose' ),
		'wwd'                  => esc_html__( 'What We Do', 'ff-multipurpose' ),
		'hero_content'         => esc_html__( 'Hero Content', 'ff-multipurpose' ),
		'portfolio'            => esc_html__( 'Portfolio', 'ff-multipurpose' ),
		'promotional_headline' => esc_html__( 'Promotion Headline', 'ff-multipurpose' ),
		'team'                 => esc_html__( 'Team', 'ff-multipurpose' ),
		'testimonial'          => esc_html__( 'Testimonials', 'ff-multipurpose' ),
		'featured_content'     => esc_html__( 'Featured Content', 'ff-multipurpose' ),
		'associate_logo'       => esc_html__( 'Associate Logo', 'ff-multipurpose' ),
	);

	foreach( $sections as $key => $value ){
		// Add sections.
		$wp_customize->add_section( 'ff_multipurpose_ss_' . $key,
			array(
				'title' => $value,
				'panel' => 'ff_multipurpose_sections'
			)
		);
	}
}
add_action( 'customize_register', 'ff_multipurpose_sections', 1 );

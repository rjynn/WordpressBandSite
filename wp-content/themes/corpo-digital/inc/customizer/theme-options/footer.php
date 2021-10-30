<?php
/**
 * Footer options
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

// Footer Section
$wp_customize->add_section( 'corpo_digital_section_footer',
	array(
		'title'      			=> esc_html__( 'Footer Options', 'corpo-digital' ),
		'priority'   			=> 900,
		'panel'      			=> 'corpo_digital_theme_options_panel',
	)
);

// footer text
$wp_customize->add_setting( 'corpo_digital_theme_options[copyright_text]',
	array(
		'default'       		=> $options['copyright_text'],
		'sanitize_callback'		=> 'corpo_digital_santize_allow_tag',
		'transport'				=> 'postMessage',
	)
);

$wp_customize->add_control( 'corpo_digital_theme_options[copyright_text]',
    array(
		'label'      			=> esc_html__( 'Copyright Text', 'corpo-digital' ),
		'section'    			=> 'corpo_digital_section_footer',
		'type'		 			=> 'textarea',
    )
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpo_digital_theme_options[copyright_text]', array(
		'selector'            => '.site-info .wrapper',
		'settings'            => 'corpo_digital_theme_options[copyright_text]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'corpo_digital_copyright_text_partial',
    ) );
}
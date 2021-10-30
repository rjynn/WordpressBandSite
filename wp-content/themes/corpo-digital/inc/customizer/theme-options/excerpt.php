<?php
/**
 * Excerpt options
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

// Add excerpt section
$wp_customize->add_section( 'corpo_digital_excerpt_section', array(
	'title'             => esc_html__( 'Excerpt','corpo-digital' ),
	'description'       => esc_html__( 'Excerpt section options.', 'corpo-digital' ),
	'panel'             => 'corpo_digital_theme_options_panel',
) );


// long Excerpt length setting and control.
$wp_customize->add_setting( 'corpo_digital_theme_options[long_excerpt_length]', array(
	'sanitize_callback' => 'corpo_digital_sanitize_number_range',
	'validate_callback' => 'corpo_digital_validate_long_excerpt',
	'default'			=> $options['long_excerpt_length'],
) );

$wp_customize->add_control( 'corpo_digital_theme_options[long_excerpt_length]', array(
	'label'       		=> esc_html__( 'Blog Page Excerpt Length', 'corpo-digital' ),
	'description' 		=> esc_html__( 'Total words to be displayed in archive page/search page.', 'corpo-digital' ),
	'section'     		=> 'corpo_digital_excerpt_section',
	'type'        		=> 'number',
	'input_attrs' 		=> array(
		'style'       => 'width: 80px;',
		'max'         => 100,
		'min'         => 5,
	),
) );

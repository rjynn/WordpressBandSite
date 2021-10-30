<?php
/**
 * Breadcrumb options
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

$wp_customize->add_section( 'corpo_digital_breadcrumb', array(
	'title'             => esc_html__( 'Breadcrumb','corpo-digital' ),
	'description'       => esc_html__( 'Breadcrumb section options.', 'corpo-digital' ),
	'panel'             => 'corpo_digital_theme_options_panel',
) );

// Breadcrumb enable setting and control.
$wp_customize->add_setting( 'corpo_digital_theme_options[breadcrumb_enable]', array(
	'sanitize_callback' => 'corpo_digital_sanitize_switch_control',
	'default'          	=> $options['breadcrumb_enable'],
) );

$wp_customize->add_control( new  Corpo_Digital_Switch_Control( $wp_customize, 'corpo_digital_theme_options[breadcrumb_enable]', array(
	'label'            	=> esc_html__( 'Enable Breadcrumb', 'corpo-digital' ),
	'section'          	=> 'corpo_digital_breadcrumb',
	'on_off_label' 		=> corpo_digital_switch_options(),
) ) );

// Breadcrumb separator setting and control.
$wp_customize->add_setting( 'corpo_digital_theme_options[breadcrumb_separator]', array(
	'sanitize_callback'	=> 'sanitize_text_field',
	'default'          	=> $options['breadcrumb_separator'],
) );

$wp_customize->add_control( 'corpo_digital_theme_options[breadcrumb_separator]', array(
	'label'            	=> esc_html__( 'Separator', 'corpo-digital' ),
	'active_callback' 	=> 'corpo_digital_is_breadcrumb_enable',
	'section'          	=> 'corpo_digital_breadcrumb',
) );

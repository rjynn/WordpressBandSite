<?php
/**
 * pagination options
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'corpo_digital_pagination', array(
	'title'               	=> esc_html__('Pagination','corpo-digital'),
	'description'         	=> esc_html__( 'Pagination section options.', 'corpo-digital' ),
	'panel'               	=> 'corpo_digital_theme_options_panel',
) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'corpo_digital_theme_options[pagination_enable]', array(
	'sanitize_callback' 	=> 'corpo_digital_sanitize_switch_control',
	'default'             	=> $options['pagination_enable'],
) );

$wp_customize->add_control( new  Corpo_Digital_Switch_Control( $wp_customize, 'corpo_digital_theme_options[pagination_enable]', array(
	'label'               	=> esc_html__( 'Pagination Enable', 'corpo-digital' ),
	'section'             	=> 'corpo_digital_pagination',
	'on_off_label' 			=> corpo_digital_switch_options(),
) ) );

// Site layout setting and control.
$wp_customize->add_setting( 'corpo_digital_theme_options[pagination_type]', array(
	'sanitize_callback'   	=> 'corpo_digital_sanitize_select',
	'default'             	=> $options['pagination_type'],
) );

$wp_customize->add_control( 'corpo_digital_theme_options[pagination_type]', array(
	'label'               	=> esc_html__( 'Pagination Type', 'corpo-digital' ),
	'section'             	=> 'corpo_digital_pagination',
	'type'                	=> 'select',
	'choices'			  	=> corpo_digital_pagination_options(),
	'active_callback'	  	=> 'corpo_digital_is_pagination_enable',
) );

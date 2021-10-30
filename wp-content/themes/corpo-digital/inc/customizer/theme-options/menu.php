<?php
/**
 * Menu options
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'corpo_digital_menu', array(
	'title'             => esc_html__('Header Menu','corpo-digital'),
	'description'       => esc_html__( 'Header Menu options.', 'corpo-digital' ),
	'panel'             => 'nav_menus',
) );


$wp_customize->add_setting( 'corpo_digital_theme_options[search_icon_in_primary_menu_enable]', array(
	'sanitize_callback' => 'corpo_digital_sanitize_switch_control',
	'default'           => $options['search_icon_in_primary_menu_enable'],
) );

$wp_customize->add_control( new  Corpo_Digital_Switch_Control( $wp_customize, 'corpo_digital_theme_options[search_icon_in_primary_menu_enable]', array(
	'label'             => esc_html__( 'Show Search Icon in Primary menu', 'corpo-digital' ),
	'section'           => 'corpo_digital_menu',
	'on_off_label' 		=> corpo_digital_switch_options(),
) ) );

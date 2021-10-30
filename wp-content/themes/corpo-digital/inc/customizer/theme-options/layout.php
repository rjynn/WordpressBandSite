<?php
/**
 * Layout options
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'corpo_digital_layout', array(
	'title'               => esc_html__('Layout','corpo-digital'),
	'description'         => esc_html__( 'Layout section options.', 'corpo-digital' ),
	'panel'               => 'corpo_digital_theme_options_panel',
) );

// Site layout setting and control.
$wp_customize->add_setting( 'corpo_digital_theme_options[site_layout]', array(
	'sanitize_callback'   => 'corpo_digital_sanitize_select',
	'default'             => $options['site_layout'],
) );

$wp_customize->add_control(  new  Corpo_Digital_Custom_Radio_Image_Control ( $wp_customize, 'corpo_digital_theme_options[site_layout]', array(
	'label'               => esc_html__( 'Site Layout', 'corpo-digital' ),
	'section'             => 'corpo_digital_layout',
	'choices'			  => corpo_digital_site_layout(),
) ) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'corpo_digital_theme_options[sidebar_position]', array(
	'sanitize_callback'   => 'corpo_digital_sanitize_select',
	'default'             => $options['sidebar_position'],
) );

$wp_customize->add_control(  new  Corpo_Digital_Custom_Radio_Image_Control ( $wp_customize, 'corpo_digital_theme_options[sidebar_position]', array(
	'label'               => esc_html__( 'Global Sidebar Position', 'corpo-digital' ),
	'section'             => 'corpo_digital_layout',
	'choices'			  => corpo_digital_global_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'corpo_digital_theme_options[post_sidebar_position]', array(
	'sanitize_callback'   => 'corpo_digital_sanitize_select',
	'default'             => $options['post_sidebar_position'],
) );

$wp_customize->add_control(  new  Corpo_Digital_Custom_Radio_Image_Control ( $wp_customize, 'corpo_digital_theme_options[post_sidebar_position]', array(
	'label'               => esc_html__( 'Posts Sidebar Position', 'corpo-digital' ),
	'section'             => 'corpo_digital_layout',
	'choices'			  => corpo_digital_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'corpo_digital_theme_options[page_sidebar_position]', array(
	'sanitize_callback'   => 'corpo_digital_sanitize_select',
	'default'             => $options['page_sidebar_position'],
) );

$wp_customize->add_control( new  Corpo_Digital_Custom_Radio_Image_Control( $wp_customize, 'corpo_digital_theme_options[page_sidebar_position]', array(
	'label'               => esc_html__( 'Pages Sidebar Position', 'corpo-digital' ),
	'section'             => 'corpo_digital_layout',
	'choices'			  => corpo_digital_sidebar_position(),
) ) );
<?php
/**
 * Excerpt options
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

// Add excerpt section
$wp_customize->add_section( 'corpo_digital_single_post_section', array(
	'title'             => esc_html__( 'Single Post','corpo-digital' ),
	'description'       => esc_html__( 'Options to change the single posts globally.', 'corpo-digital' ),
	'panel'             => 'corpo_digital_theme_options_panel',
) );

// Archive date meta setting and control.
$wp_customize->add_setting( 'corpo_digital_theme_options[single_post_hide_date]', array(
	'default'           => $options['single_post_hide_date'],
	'sanitize_callback' => 'corpo_digital_sanitize_switch_control',
) );

$wp_customize->add_control( new  Corpo_Digital_Switch_Control( $wp_customize, 'corpo_digital_theme_options[single_post_hide_date]', array(
	'label'             => esc_html__( 'Hide Date', 'corpo-digital' ),
	'section'           => 'corpo_digital_single_post_section',
	'on_off_label' 		=> corpo_digital_hide_options(),
) ) );

// Archive author meta setting and control.
$wp_customize->add_setting( 'corpo_digital_theme_options[single_post_hide_author]', array(
	'default'           => $options['single_post_hide_author'],
	'sanitize_callback' => 'corpo_digital_sanitize_switch_control',
) );

$wp_customize->add_control( new  Corpo_Digital_Switch_Control( $wp_customize, 'corpo_digital_theme_options[single_post_hide_author]', array(
	'label'             => esc_html__( 'Hide Author', 'corpo-digital' ),
	'section'           => 'corpo_digital_single_post_section',
	'on_off_label' 		=> corpo_digital_hide_options(),
) ) );

// Archive author category setting and control.
$wp_customize->add_setting( 'corpo_digital_theme_options[single_post_hide_category]', array(
	'default'           => $options['single_post_hide_category'],
	'sanitize_callback' => 'corpo_digital_sanitize_switch_control',
) );

$wp_customize->add_control( new  Corpo_Digital_Switch_Control( $wp_customize, 'corpo_digital_theme_options[single_post_hide_category]', array(
	'label'             => esc_html__( 'Hide Category', 'corpo-digital' ),
	'section'           => 'corpo_digital_single_post_section',
	'on_off_label' 		=> corpo_digital_hide_options(),
) ) );

// Archive tag category setting and control.
$wp_customize->add_setting( 'corpo_digital_theme_options[single_post_hide_tags]', array(
	'default'           => $options['single_post_hide_tags'],
	'sanitize_callback' => 'corpo_digital_sanitize_switch_control',
) );

$wp_customize->add_control( new  Corpo_Digital_Switch_Control( $wp_customize, 'corpo_digital_theme_options[single_post_hide_tags]', array(
	'label'             => esc_html__( 'Hide Tag', 'corpo-digital' ),
	'section'           => 'corpo_digital_single_post_section',
	'on_off_label' 		=> corpo_digital_hide_options(),
) ) );

<?php
/**
* Homepage (Static ) options
*
* @package Theme Palace
* @subpackage Corpo Digital
* @since Corpo Digital 1.0.0
*/

// Homepage (Static ) setting and control.
$wp_customize->add_setting( 'corpo_digital_theme_options[enable_frontpage_content]', array(
	'sanitize_callback'   => 'corpo_digital_sanitize_checkbox',
	'default'             => $options['enable_frontpage_content'],
) );

$wp_customize->add_control( 'corpo_digital_theme_options[enable_frontpage_content]', array(
	'label'       	=> esc_html__( 'Enable Content', 'corpo-digital' ),
	'description' 	=> esc_html__( 'Check to enable content on static front page only.', 'corpo-digital' ),
	'section'     	=> 'static_front_page',
	'type'        	=> 'checkbox',
	'active_callback' => 'corpo_digital_is_static_homepage_enable',
) );
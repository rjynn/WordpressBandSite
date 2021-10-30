<?php
/**
 * Archive options
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

// Add archive section
$wp_customize->add_section( 'corpo_digital_archive_section', array(
	'title'             => esc_html__( 'Blog/Archive','corpo-digital' ),
	'description'       => esc_html__( 'Archive section options.', 'corpo-digital' ),
	'panel'             => 'corpo_digital_theme_options_panel',
) );

// Your latest posts title setting and control.
$wp_customize->add_setting( 'corpo_digital_theme_options[your_latest_posts_title]', array(
	'default'           => $options['your_latest_posts_title'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'corpo_digital_theme_options[your_latest_posts_title]', array(
	'label'             => esc_html__( 'Your Latest Posts Title', 'corpo-digital' ),
	'description'       => esc_html__( 'This option only works if Static Front Page is set to "Your latest posts."', 'corpo-digital' ),
	'section'           => 'corpo_digital_archive_section',
	'type'				=> 'text',
	'active_callback'   => 'corpo_digital_is_latest_posts'
) );

// features content type control and setting
$wp_customize->add_setting( 'corpo_digital_theme_options[blog_column]', array(
	'default'          	=> $options['blog_column'],
	'sanitize_callback' => 'corpo_digital_sanitize_select',
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'corpo_digital_theme_options[blog_column]', array(
	'label'             => esc_html__( 'Column Layout', 'corpo-digital' ),
	'section'           => 'corpo_digital_archive_section',
	'type'				=> 'select',
	'choices'			=> array( 
		'col-1'		=> esc_html__( 'One Column', 'corpo-digital' ),
		'col-2'		=> esc_html__( 'Two Column', 'corpo-digital' ),
		'col-3'		=> esc_html__( 'Three Column', 'corpo-digital' ),
	),
) );

// read more text setting and control
$wp_customize->add_setting( 'corpo_digital_theme_options[read_more_text]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['read_more_text'],
) );

$wp_customize->add_control( 'corpo_digital_theme_options[read_more_text]', array(
	'label'           	=> esc_html__( 'Read More Text Label', 'corpo-digital' ),
	'section'        	=> 'corpo_digital_archive_section',
	'type'				=> 'text',
) );


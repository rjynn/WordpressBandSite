<?php
/**
 * FAQ Section options
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

// Add FAQ section
$wp_customize->add_section( 'corpo_digital_faq_section', array(
	'title'             => esc_html__( 'FAQ','corpo-digital' ),
	'description'       => esc_html__( 'FAQ Section options.', 'corpo-digital' ),
	'panel'             => 'corpo_digital_front_page_panel',
) );

// FAQ content enable control and setting
$wp_customize->add_setting( 'corpo_digital_theme_options[faq_section_enable]', array(
	'default'			=> 	$options['faq_section_enable'],
	'sanitize_callback' => 'corpo_digital_sanitize_switch_control',
) );

$wp_customize->add_control( new  Corpo_Digital_Switch_Control( $wp_customize, 'corpo_digital_theme_options[faq_section_enable]', array(
	'label'             => esc_html__( 'FAQ Section Enable', 'corpo-digital' ),
	'section'           => 'corpo_digital_faq_section',
	'on_off_label' 		=> corpo_digital_switch_options(),
) ) );

// faq title setting and control
$wp_customize->add_setting( 'corpo_digital_theme_options[faq_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['faq_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'corpo_digital_theme_options[faq_title]', array(
	'label'           	=> esc_html__( 'Section Title', 'corpo-digital' ),
	'section'        	=> 'corpo_digital_faq_section',
	'active_callback' 	=> 'corpo_digital_is_faq_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpo_digital_theme_options[faq_title]', array(
		'selector'            => '#faq-section .section-header h2',
		'settings'            => 'corpo_digital_theme_options[faq_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'corpo_digital_faq_title_partial',
    ) );
}

// faq description setting and control
$wp_customize->add_setting( 'corpo_digital_theme_options[faq_sub_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['faq_sub_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'corpo_digital_theme_options[faq_sub_title]', array(
	'label'           	=> esc_html__( 'Section Sub Title', 'corpo-digital' ),
	'section'        	=> 'corpo_digital_faq_section',
	'active_callback' 	=> 'corpo_digital_is_faq_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpo_digital_theme_options[faq_sub_title]', array(
		'selector'            => '#faq-section .section-header p',
		'settings'            => 'corpo_digital_theme_options[faq_sub_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'corpo_digital_faq_sub_title_partial',
    ) );
}

for ( $i = 1; $i <= $options['faq_count']; $i++ ) :
	// faq pages drop down chooser control and setting
	$wp_customize->add_setting( 'corpo_digital_theme_options[faq_content_page_' . $i . ']', array(
		'sanitize_callback' => 'corpo_digital_sanitize_page',
	) );

	$wp_customize->add_control( new  Corpo_Digital_Dropdown_Chooser( $wp_customize, 'corpo_digital_theme_options[faq_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'corpo-digital' ), $i ),
		'section'           => 'corpo_digital_faq_section',
		'choices'			=> corpo_digital_page_choices(),
		'active_callback'	=> 'corpo_digital_is_faq_section_enable',
	) ) );

	// faq hr setting and control
	$wp_customize->add_setting( 'corpo_digital_theme_options[faq_hr_'. $i .']', array(
		'sanitize_callback' => 'corpo_digital_sanitize_html'
	) );

	$wp_customize->add_control( new  Corpo_Digital_Customize_Horizontal_Line( $wp_customize, 'corpo_digital_theme_options[faq_hr_'. $i .']',
		array(
			'section'         => 'corpo_digital_faq_section',
			'active_callback' => 'corpo_digital_is_faq_section_enable',
			'type'			  => 'hr'
	) ) );

endfor;


// About image setting
$wp_customize->add_setting('corpo_digital_theme_options[faq_image]', array(
	'sanitize_callback' => 'corpo_digital_sanitize_image',
));

$wp_customize->add_control(new WP_Customize_Image_Control( $wp_customize, 'corpo_digital_theme_options[faq_image]', array(
	'section'			=> 'corpo_digital_faq_section',
	'label'				=> esc_html__( 'Image:', 'corpo-digital' ),
	'active_callback' 	=> 'corpo_digital_is_faq_section_enable',
)));

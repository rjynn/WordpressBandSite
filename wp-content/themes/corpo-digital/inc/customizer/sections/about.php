<?php
/**
 * About Section options
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

// Add About section
$wp_customize->add_section( 'corpo_digital_about_section', 
    array(
        'title'             => esc_html__( 'About us','corpo-digital' ),
        'description'       => esc_html__( 'About us  Section options.', 'corpo-digital' ),
        'panel'             => 'corpo_digital_front_page_panel',
    ) 
);

// About content enable control and setting
$wp_customize->add_setting( 'corpo_digital_theme_options[about_section_enable]', 
    array(
        'default'			=> 	$options['about_section_enable'],
        'sanitize_callback' => 'corpo_digital_sanitize_switch_control',
    ) 
);

$wp_customize->add_control( new  Corpo_Digital_Switch_Control( $wp_customize, 'corpo_digital_theme_options[about_section_enable]',
    array(
        'label'             => esc_html__( 'About Section Enable', 'corpo-digital' ),
        'section'           => 'corpo_digital_about_section',
        'on_off_label' 		=> corpo_digital_switch_options(),
    ) 
) );

// about section title control and setting
$wp_customize->add_setting( 'corpo_digital_theme_options[about_section_title]',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'			=> 	$options['about_section_title'],
        'transport'			=>'postMessage'
    ) 
);

$wp_customize->add_control('corpo_digital_theme_options[about_section_title]',
    array(
        'label'             => esc_html__( 'Section Sub Title', 'corpo-digital' ),
        'section'           => 'corpo_digital_about_section',
        'type'              =>'text',
        'active_callback'	=> 'corpo_digital_is_about_section_enable',
    )
);


// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpo_digital_theme_options[about_section_title]',
		array(
			'selector'            => '#about-section .section-header p',
			'settings'            => 'corpo_digital_theme_options[about_section_title]',
			'fallback_refresh'    => true,
			'container_inclusive' => false,
			'render_callback'     => 'corpo_digital_about_section_title_partial',
		) 
	);
}


// about pages drop down chooser control and setting
$wp_customize->add_setting( 'corpo_digital_theme_options[about_content_page]', 
    array(
        'sanitize_callback' => 'corpo_digital_sanitize_page',
    ) 
);

$wp_customize->add_control( new Corpo_Digital_Dropdown_Chooser( $wp_customize, 'corpo_digital_theme_options[about_content_page]',
    array(
        'label'             => esc_html__( 'Select Page', 'corpo-digital' ),
        'section'           => 'corpo_digital_about_section',
        'choices'			=> corpo_digital_page_choices(),
        'active_callback'	=> 'corpo_digital_is_about_section_enable',
    ) 
) );

// About content setting
$wp_customize->add_setting('corpo_digital_theme_options[about_btn_label]',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'transport'			=> 'postMessage',
        'default'           => $options['about_btn_label']

    )
);

$wp_customize->add_control('corpo_digital_theme_options[about_btn_label]',
    array(
        'section'			=> 'corpo_digital_about_section',
        'label'				=> esc_html__( 'Button Label:', 'corpo-digital' ),
        'type'          	=>'text',
        'active_callback'	=> 'corpo_digital_is_about_section_enable'
    )
);


// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpo_digital_theme_options[about_btn_label]',
		array(
			'selector'            => '#about-section div.read-more .btn',
			'settings'            => 'corpo_digital_theme_options[about_btn_label]',
			'fallback_refresh'    => true,
			'container_inclusive' => false,
			'render_callback'     => 'corpo_digital_about_btn_label_partial',
		) 
	);
}

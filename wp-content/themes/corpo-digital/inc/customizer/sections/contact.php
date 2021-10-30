<?php
/**
 * Contact Section options
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

// Add Contact section
$wp_customize->add_section( 'corpo_digital_contact_section', 
    array(
        'title'             => esc_html__( 'Contact us','corpo-digital' ),
        'description'       => esc_html__( 'Contact us  Section options.', 'corpo-digital' ),
        'panel'             => 'corpo_digital_front_page_panel',
    ) 
);

// Contact content enable control and setting
$wp_customize->add_setting( 'corpo_digital_theme_options[contact_section_enable]', 
    array(
        'default'			=> 	$options['contact_section_enable'],
        'sanitize_callback' => 'corpo_digital_sanitize_switch_control',
    ) 
);

$wp_customize->add_control( new  Corpo_Digital_Switch_Control( $wp_customize, 'corpo_digital_theme_options[contact_section_enable]',
    array(
        'label'             => esc_html__( 'Contact Section Enable', 'corpo-digital' ),
        'section'           => 'corpo_digital_contact_section',
        'on_off_label' 		=> corpo_digital_switch_options(),
    ) 
) );

// contact section title control and setting
$wp_customize->add_setting( 'corpo_digital_theme_options[contact_section_subtitle]',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'			=> 	$options['contact_section_subtitle'],
        'transport'			=>'postMessage'
    ) 
);

$wp_customize->add_control('corpo_digital_theme_options[contact_section_subtitle]',
    array(
        'label'             => esc_html__( 'Section Sub Title', 'corpo-digital' ),
        'section'           => 'corpo_digital_contact_section',
        'type'              => 'text',
        'active_callback'	=> 'corpo_digital_is_contact_section_enable',
    )
);
$wp_customize->selective_refresh->add_partial(
    'corpo_digital_theme_options[contact_section_subtitle]',
    array(
        'selector'            => '#contact-section .section-subtitle',
        'render_callback'     => 'corpo_digital_contact_section_partial_title',
    )
);

// contact section title control and setting
$wp_customize->add_setting( 'corpo_digital_theme_options[contact_section_title]',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'			=> 	$options['contact_section_title'],
        'transport'			=>'postMessage'
    ) 
);

$wp_customize->add_control('corpo_digital_theme_options[contact_section_title]',
    array(
        'label'             => esc_html__( 'Section Title', 'corpo-digital' ),
        'section'           => 'corpo_digital_contact_section',
        'type'              => 'text',
        'active_callback'	=> 'corpo_digital_is_contact_section_enable',
    )
);
$wp_customize->selective_refresh->add_partial(
    'corpo_digital_theme_options[contact_section_title]',
    array(
        'selector'            => '#contact-section .section-title',
        'render_callback'     => 'corpo_digital_contact_section_partial_title',
    )
);

// contact section title control and setting
$wp_customize->add_setting( 'corpo_digital_theme_options[contact_section_shortcode]',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'transport'			=>'refresh'
    ) 
);

$wp_customize->add_control('corpo_digital_theme_options[contact_section_shortcode]',
    array(
        'label'             => esc_html__( 'Contact Shortcode', 'corpo-digital' ),
        'section'           => 'corpo_digital_contact_section',
        'type'              => 'text',
        'active_callback'	=> 'corpo_digital_is_contact_section_enable',
    )
);

//contact_section_phoneNumber
$wp_customize->add_setting('corpo_digital_theme_options[contact_section_phoneNumber]',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'transport'			=> 'postMessage',
        'default'           => $options['contact_section_phoneNumber'],
    )
);

$wp_customize->add_control('corpo_digital_theme_options[contact_section_phoneNumber]',
    array(
        'section'			=> 'corpo_digital_contact_section',
        'label'				=> esc_html__( 'Contact Number:', 'corpo-digital' ),
        'type'          	=>'text',
        'active_callback' 	=> 'corpo_digital_is_contact_section_enable'
    )
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpo_digital_theme_options[contact_section_phoneNumber]',
		array(
			'selector'            => '#contact-section div.contact-information ul li:nth-child(2) span',
			'settings'            => 'corpo_digital_theme_options[contact_section_phoneNumber]',
			'fallback_refresh'    => true,
			'container_inclusive' => false,
			'render_callback'     => 'corpo_digital_contact_section_phoneNumber_partial',
		) 
	);
}

//contact_section_address
$wp_customize->add_setting('corpo_digital_theme_options[contact_section_address]',
array(
        'sanitize_callback' => 'sanitize_text_field',
        'transport'			=> 'postMessage',
        'default'           => $options['contact_section_address'],
    )
);

$wp_customize->add_control('corpo_digital_theme_options[contact_section_address]',
    array(
        'section'			=> 'corpo_digital_contact_section',
        'label'				=> esc_html__( 'Address:', 'corpo-digital' ),
        'type'          	=>'text',
        'active_callback' 	=> 'corpo_digital_is_contact_section_enable'
    )
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpo_digital_theme_options[contact_section_address]',
		array(
            'selector'            => '#contact-section div.contact-information ul li:nth-child(1) span',
			'settings'            => 'corpo_digital_theme_options[contact_section_address]',
			'fallback_refresh'    => true,
			'container_inclusive' => false,
			'render_callback'     => 'corpo_digital_contact_section_address_partial',
            ) 
        );
    }

//contact_section_email
$wp_customize->add_setting('corpo_digital_theme_options[contact_section_email]',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'transport'			=> 'postMessage',
        'default'           => $options['contact_section_email'],
    )
);

$wp_customize->add_control('corpo_digital_theme_options[contact_section_email]',
    array(
        'section'			=> 'corpo_digital_contact_section',
        'label'				=> esc_html__( 'E-mail:', 'corpo-digital' ),
        'type'          	=>'text',
        'active_callback' 	=> 'corpo_digital_is_contact_section_enable'
    )
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpo_digital_theme_options[contact_section_email]',
        array(
            'selector'            => '#contact-section div.contact-information ul li:nth-child(3) span',
            'settings'            => 'corpo_digital_theme_options[contact_section_email]',
            'fallback_refresh'    => true,
            'container_inclusive' => false,
            'render_callback'     => 'corpo_digital_contact_section_email_partial',
        ) 
    );
}
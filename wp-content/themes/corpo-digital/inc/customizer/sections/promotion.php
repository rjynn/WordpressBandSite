<?php
/**
 * Call To Action Section options
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

// Add Promotion section
$wp_customize->add_section( 'corpo_digital_promotion_section',
    array(
        'title'             => esc_html__( 'Promotion','corpo-digital' ),
        'description'       => esc_html__( 'Promotion Section options.', 'corpo-digital' ),
        'panel'             => 'corpo_digital_front_page_panel',

    )
);

// Promotion content enable control and setting
$wp_customize->add_setting( 'corpo_digital_theme_options[promotion_section_enable]',
    array(
        'default'			=> 	$options['promotion_section_enable'],
        'sanitize_callback' => 'corpo_digital_sanitize_switch_control',
    )
);

$wp_customize->add_control( new  Corpo_Digital_Switch_Control( $wp_customize, 'corpo_digital_theme_options[promotion_section_enable]',
    array(
        'label'             => esc_html__( 'Promotion Section Enable', 'corpo-digital' ),
        'section'           => 'corpo_digital_promotion_section',
        'on_off_label' 		=> corpo_digital_switch_options(),
    )
) );


$wp_customize->add_setting( 'corpo_digital_theme_options[promotion_content_page]',
    array(
        'sanitize_callback' => 'corpo_digital_sanitize_page',
    )
);

$wp_customize->add_control( new  Corpo_Digital_Dropdown_Chooser( $wp_customize, 'corpo_digital_theme_options[promotion_content_page]',
    array(
        'label'             => esc_html__( 'Select Page', 'corpo-digital' ),
        'section'           => 'corpo_digital_promotion_section',
        'choices'			=> corpo_digital_page_choices(),
        'active_callback'	=> 'corpo_digital_is_promotion_section_enable',
    )
));


// Promotion read more setting and control
$wp_customize->add_setting( 'corpo_digital_theme_options[promotion_read_more]',
    array(
        'default'			=> $options['promotion_read_more'],
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         =>'postMessage',
    )
);

$wp_customize->add_control( 'corpo_digital_theme_options[promotion_read_more]',
    array(
        'label'           	=> esc_html__( 'Read More Text', 'corpo-digital' ),
        'section'        	=> 'corpo_digital_promotion_section',
        'active_callback' 	=> 'corpo_digital_is_promotion_section_enable',
        'type'				=> 'text',
    )
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpo_digital_theme_options[promotion_read_more]',
    array(
		'selector'            => '#promotion-section .wrapper .read-more a.btn',
		'settings'            => 'corpo_digital_theme_options[promotion_read_more]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'corpo_digital_promotion_read_more_partial',
    ) );
}

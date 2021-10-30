<?php
/**
 * gallery Section options
 *
 * @package Theme Palace
 * @subpackage Corpo Digital
 * @since Corpo Digital 1.0.0
 */

// Add gallery section
$wp_customize->add_section( 'corpo_digital_gallery_section', array(
    'title'             => esc_html__( 'Gallery','corpo-digital' ),
    'description'       => esc_html__( 'Gallery Section options.', 'corpo-digital' ),
    'panel'             => 'corpo_digital_front_page_panel',
) );

// gallery content enable control and setting
$wp_customize->add_setting( 'corpo_digital_theme_options[gallery_section_enable]', array(
    'default'           =>  $options['gallery_section_enable'],
    'sanitize_callback' => 'corpo_digital_sanitize_switch_control',
) );

$wp_customize->add_control( new Corpo_Digital_Switch_Control( $wp_customize, 'corpo_digital_theme_options[gallery_section_enable]', array(
    'label'             => esc_html__( 'Gallery Section Enable', 'corpo-digital' ),
    'section'           => 'corpo_digital_gallery_section',
    'on_off_label'      => corpo_digital_switch_options(),
) ) );

// gallery section sub title control and setting
$wp_customize->add_setting('corpo_digital_theme_options[gallery_section_sub_title]', array(
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage',
    'default'  => $options['gallery_section_sub_title'],
));

$wp_customize->add_control('corpo_digital_theme_options[gallery_section_sub_title]', array(
    'label' => esc_html__('Section Sub Title', 'corpo-digital'),
    'section' => 'corpo_digital_gallery_section',
    'type' => 'text',
    'active_callback' => 'corpo_digital_is_gallery_section_enable',
));
$wp_customize->selective_refresh->add_partial(
    'corpo_digital_theme_options[gallery_section_sub_title]',
    array(
        'selector' => '#gallery-section .section-subtitle',
        'render_callback' => 'corpo_digital_gallery_section_partial_sub_title',
    )
);

// gallery title setting and control
$wp_customize->add_setting( 'corpo_digital_theme_options[gallery_title]', array(
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => $options['gallery_title'],
    'transport'         => 'postMessage',
) );

$wp_customize->add_control( 'corpo_digital_theme_options[gallery_title]', array(
    'label'             => esc_html__( 'Title', 'corpo-digital' ),
    'section'           => 'corpo_digital_gallery_section',
    'active_callback'   => 'corpo_digital_is_gallery_section_enable',
    'type'              => 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpo_digital_theme_options[gallery_title]', array(
        'selector'            => '#gallery-section .section-header h2',
        'settings'            => 'corpo_digital_theme_options[gallery_title]',
        'container_inclusive' => false,
        'fallback_refresh'    => true,
        'render_callback'     => 'corpo_digital_gallery_title_partial',
    ) );
}


// Add dropdown categories setting and control.
$wp_customize->add_setting( 'corpo_digital_theme_options[gallery_category_exclude]', array(
    'sanitize_callback' => 'corpo_digital_sanitize_category_list',
) ) ;

$wp_customize->add_control( new Corpo_Digital_Dropdown_Multiple_Chooser( $wp_customize,'corpo_digital_theme_options[gallery_category_exclude]', array(
    'label'             => esc_html__( 'Select Excluding Categories', 'corpo-digital' ),
    'section'           => 'corpo_digital_gallery_section',
    'type'              => 'dropdown_multiple_chooser',
    'choices'           =>  corpo_digital_category_choices(),
    'active_callback'   => 'corpo_digital_is_gallery_section_enable'
) ) );

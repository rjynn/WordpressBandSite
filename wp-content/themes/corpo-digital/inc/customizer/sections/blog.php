<?php
/**
 * Blog Section options
 *
 * @package Theme Palace
 * @subpackage Corpo Digital
 * @since Corpo Digital 1.0.0
 */

// Add Blog section
$wp_customize->add_section( 'corpo_digital_blog_section',
    array(
        'title'             => esc_html__( 'Blog','corpo-digital' ),
        'description'       => esc_html__( 'Blog Section options.', 'corpo-digital' ),
        'panel'             => 'corpo_digital_front_page_panel',
    )
);

// Blog content enable control and setting
$wp_customize->add_setting( 'corpo_digital_theme_options[blog_section_enable]',
    array(
        'default'           =>  $options['blog_section_enable'],
        'sanitize_callback' => 'corpo_digital_sanitize_switch_control',
    )
);

$wp_customize->add_control( new Corpo_Digital_Switch_Control( $wp_customize, 'corpo_digital_theme_options[blog_section_enable]',
    array(
        'label'             => esc_html__( 'Blog Section Enable', 'corpo-digital' ),
        'section'           => 'corpo_digital_blog_section',
        'on_off_label'      => corpo_digital_switch_options(),
    ) 
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpo_digital_theme_options[blog_section_enable]',
        array(
            'selector'            => '#latest-posts-section .tooltiptext',
            'settings'            => 'corpo_digital_theme_options[blog_section_enable]',
        )
    );
}

// Blog section sub title control and setting
$wp_customize->add_setting('corpo_digital_theme_options[blog_sub_title]',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
        'default'  => $options['blog_sub_title'],
    )
);

$wp_customize->add_control('corpo_digital_theme_options[blog_sub_title]',
    array(
        'label' => esc_html__('Section Sub Title', 'corpo-digital'),
        'section' => 'corpo_digital_blog_section',
        'type' => 'text',
        'active_callback' => 'corpo_digital_is_blog_section_enable',
    )
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpo_digital_theme_options[blog_sub_title]',
        array(
            'selector'            => '#latest-posts-section .section-header p.section-subtitle',
            'settings'            => 'corpo_digital_theme_options[blog_sub_title]',
            'container_inclusive' => false,
            'fallback_refresh'    => true,
            'render_callback'     => 'corpo_digital_blog_sub_title_partial',
        )
    );
}

// blog title setting and control
$wp_customize->add_setting( 'corpo_digital_theme_options[blog_title]',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => $options['blog_title'],
        'transport'         => 'postMessage',
    )
);

$wp_customize->add_control( 'corpo_digital_theme_options[blog_title]',
    array(
        'label'             => esc_html__( 'Section Title', 'corpo-digital' ),
        'section'           => 'corpo_digital_blog_section',
        'active_callback'   => 'corpo_digital_is_blog_section_enable',
        'type'              => 'text',
    ) 
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpo_digital_theme_options[blog_title]',
        array(
            'selector'            => '#latest-posts-section .section-header h2.section-title',
            'settings'            => 'corpo_digital_theme_options[blog_title]',
            'container_inclusive' => false,
            'fallback_refresh'    => true,
            'render_callback'     => 'corpo_digital_blog_title_partial',
        )
    );
}

// Add dropdown category setting and control.
$wp_customize->add_setting(  'corpo_digital_theme_options[blog_content_category]',
    array(
        'sanitize_callback' => 'corpo_digital_sanitize_single_category',
    )
) ;

$wp_customize->add_control( new Corpo_Digital_Dropdown_Taxonomies_Control( $wp_customize,'corpo_digital_theme_options[blog_content_category]',
    array(
        'label'             => esc_html__( 'Select Category', 'corpo-digital' ),
        'description'       => esc_html__( 'Note: Latest selected no of posts will be shown from selected category', 'corpo-digital' ),
        'section'           => 'corpo_digital_blog_section',
        'type'              => 'dropdown-taxonomies',
        'active_callback'   => 'corpo_digital_is_blog_section_enable'
    ) 
) );

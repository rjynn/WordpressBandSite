<?php

/**
 * Testimonial Section options
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

// Add Testimonial section
$wp_customize->add_section('corpo_digital_testimonial_section',
    array(
        'title'         => esc_html__('Testimonials', 'corpo-digital'),
        'description'   => esc_html__('Testimonials Section options.', 'corpo-digital'),
        'panel'         => 'corpo_digital_front_page_panel',
    )
);

// Testimonial content enable control and setting
$wp_customize->add_setting('corpo_digital_theme_options[testimonial_section_enable]',
    array(
        'default'           => $options['testimonial_section_enable'],
        'sanitize_callback' => 'corpo_digital_sanitize_switch_control',
    )
);

$wp_customize->add_control(new  Corpo_Digital_Switch_Control($wp_customize, 'corpo_digital_theme_options[testimonial_section_enable]',
    array(
        'label'         => esc_html__('Testimonial Section Enable', 'corpo-digital'),
        'section'       => 'corpo_digital_testimonial_section',
        'on_off_label'  => corpo_digital_switch_options(),
    )
));

// Testimonial section sub title control and setting
$wp_customize->add_setting('corpo_digital_theme_options[testimonial_section_sub_title]',
    array(
        'sanitize_callback'     => 'sanitize_text_field',
        'transport'             => 'postMessage',
        'default'               => $options['testimonial_section_sub_title'],
    )
);

$wp_customize->add_control('corpo_digital_theme_options[testimonial_section_sub_title]',
    array(
        'label'             => esc_html__('Section Sub Title', 'corpo-digital'),
        'section'           => 'corpo_digital_testimonial_section',
        'type'              => 'text',
        'active_callback'   => 'corpo_digital_is_testimonial_section_enable',
    )
);

$wp_customize->selective_refresh->add_partial('corpo_digital_theme_options[testimonial_section_sub_title]',
    array(
        'selector'          => '#testimonial-section .section-subtitle',
        'render_callback'   => 'corpo_digital_testimonial_section_partial_sub_title',
    )
);

// Testimonial section title control and setting
$wp_customize->add_setting('corpo_digital_theme_options[testimonial_section_title]',
    array(
        'default'               => $options['testimonial_section_title'],
        'sanitize_callback'     => 'sanitize_text_field',
        'transport'             => 'postMessage'
    )
);

$wp_customize->add_control('corpo_digital_theme_options[testimonial_section_title]',
    array(
        'label'                 => esc_html__('Section Title', 'corpo-digital'),
        'section'               => 'corpo_digital_testimonial_section',
        'type'                  => 'text',
        'active_callback'       => 'corpo_digital_is_testimonial_section_enable',
    )
);

$wp_customize->selective_refresh->add_partial('corpo_digital_theme_options[testimonial_section_title]',
    array(
        'selector'          => '#testimonial-section .section-title',
        'render_callback'   => 'corpo_digital_testimonial_section_partial_title',
    )
);


for ($i = 1; $i <= $options['testimonial_posts_count']; $i++):

    // Testimonial pages drop down chooser control and setting
    $wp_customize->add_setting('corpo_digital_theme_options[testimonial_content_page_' . $i . ']',
        array(
            'sanitize_callback' => 'corpo_digital_sanitize_page',
        )
    );

    $wp_customize->add_control(new  Corpo_Digital_Dropdown_Chooser($wp_customize, 'corpo_digital_theme_options[testimonial_content_page_' . $i . ']',
        array(
            'label'             => sprintf(esc_html__('Select Page : %d', 'corpo-digital'), $i),
            'section'           => 'corpo_digital_testimonial_section',
            'choices'           => corpo_digital_page_choices(),
            'active_callback'   => 'corpo_digital_is_testimonial_section_enable',
        )
    ));

    // Testimonial posts sub title control and setting
    $wp_customize->add_setting('corpo_digital_theme_options[testimonial_post_designation_' . $i . ']',
        array(
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(new  Corpo_Digital_Dropdown_Chooser($wp_customize, 'corpo_digital_theme_options[testimonial_post_designation_' . $i . ']',
        array(
            'label'             => sprintf(esc_html__('Select Designation : %d', 'corpo-digital'), $i),
            'section'           => 'corpo_digital_testimonial_section',
            'active_callback'   => 'corpo_digital_is_testimonial_section_enable',
            'type'              => 'text',
        )
    ));

    //testimonial separator
    $wp_customize->add_setting('corpo_digital_theme_options[testimonial_separator'. $i .']',
        array(
            'sanitize_callback'      => 'corpo_digital_sanitize_html',
        )
    );

    $wp_customize->add_control(new  Corpo_Digital_Customize_Horizontal_Line($wp_customize,'corpo_digital_theme_options[testimonial_separator'. $i .']',
        array(
            'active_callback'       => 'corpo_digital_is_testimonial_section_enable',
            'type'                  =>'hr',
            'section'               =>'corpo_digital_testimonial_section',
        )
    ));

endfor;

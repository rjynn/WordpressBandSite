<?php
/**
 * Slider Section options
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

// Add Slider section
$wp_customize->add_section( 'corpo_digital_slider_section', array(
	'title'             => esc_html__( 'Slider','corpo-digital' ),
	'description'       => esc_html__( 'Slider Section options.', 'corpo-digital' ),
	'panel'             => 'corpo_digital_front_page_panel',
) );

// Slider content enable control and setting
$wp_customize->add_setting( 'corpo_digital_theme_options[slider_section_enable]', 
	array(
		'default'			=> 	$options['slider_section_enable'],
		'sanitize_callback' => 'corpo_digital_sanitize_switch_control',
	) 
);

$wp_customize->add_control( new  Corpo_Digital_Switch_Control( $wp_customize, 'corpo_digital_theme_options[slider_section_enable]',
	array(
		'label'             => esc_html__( 'Slider Section Enable', 'corpo-digital' ),
		'section'           => 'corpo_digital_slider_section',
		'on_off_label' 		=> corpo_digital_switch_options(),
	)
) );

// Slider autoplay enable control and setting
$wp_customize->add_setting( 'corpo_digital_theme_options[slider_autoplay_enable]',
	array(
		'default'			=> 	$options['slider_autoplay_enable'],
		'sanitize_callback' => 'corpo_digital_sanitize_switch_control',
	)
);

$wp_customize->add_control( new  Corpo_Digital_Switch_Control( $wp_customize, 'corpo_digital_theme_options[slider_autoplay_enable]',
	array(
		'label'             => esc_html__( 'Slider Autoplay Enable', 'corpo-digital' ),
		'section'           => 'corpo_digital_slider_section',
		'active_callback'   => 'corpo_digital_is_slider_section_enable',
		'on_off_label' 		=> corpo_digital_switch_options(),
	)
) );


for ( $i = 1; $i <= 3; $i++ ) :

	// slider pages drop down chooser control and setting
	$wp_customize->add_setting( 'corpo_digital_theme_options[slider_content_page_'. $i .']', 
		array(
			'sanitize_callback' => 'corpo_digital_sanitize_page',
		)
	);

	$wp_customize->add_control( new  Corpo_Digital_Dropdown_Chooser( $wp_customize, 'corpo_digital_theme_options[slider_content_page_'. $i .']', 
	array(
		'label'             => sprintf(esc_html__( 'Select Page: %d', 'corpo-digital'), $i ),
		'section'           => 'corpo_digital_slider_section',
		'choices'			=> corpo_digital_page_choices(),
		'active_callback'	=> 'corpo_digital_is_slider_section_enable',
	)
	) );

	// Corpo_Digital_Customize_Horizontal_Line
    $wp_customize->add_setting('corpo_digital_theme_options[slider_separator'. $i .']',
		array(
			'sanitize_callback'      => 'corpo_digital_sanitize_html',
		)
	);

    $wp_customize->add_control(new Corpo_Digital_Customize_Horizontal_Line($wp_customize,'corpo_digital_theme_options[slider_separator'. $i .']',
	array(
			'active_callback'       => 'corpo_digital_is_slider_section_enable',
			'type'                  =>'hr',
			'section'               =>'corpo_digital_slider_section',
		)
	));

endfor;

//slider_btn_txt
$wp_customize->add_setting('corpo_digital_theme_options[slider_btn_txt]',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'transport'			=> 'postMessage',
        'default'           => $options['slider_btn_txt'],
    )
);

$wp_customize->add_control('corpo_digital_theme_options[slider_btn_txt]',
    array(
        'section'			=> 'corpo_digital_slider_section',
        'label'				=> esc_html__( 'Button Text:', 'corpo-digital' ),
        'type'          	=>'text',
        'active_callback' 	=> 'corpo_digital_is_slider_section_enable'
    )
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpo_digital_theme_options[slider_btn_txt]',
		array(
			'selector'            => '#featured-slider-section article div.read-more a:nth-child(1)',
			'settings'            => 'corpo_digital_theme_options[slider_btn_txt]',
			'fallback_refresh'    => true,
			'container_inclusive' => false,
			'render_callback'     => 'corpo_digital_slider_btn_txt_partial',
		) 
	);
}

//slider_btn_alt_txt
$wp_customize->add_setting('corpo_digital_theme_options[slider_btn_alt_txt]',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'transport'			=> 'postMessage',
        'default'           => $options['slider_btn_alt_txt'],
    )
);

$wp_customize->add_control('corpo_digital_theme_options[slider_btn_alt_txt]',
    array(
        'section'			=> 'corpo_digital_slider_section',
        'label'				=> esc_html__( 'Button Text:', 'corpo-digital' ),
        'type'          	=>'text',
        'active_callback' 	=> 'corpo_digital_is_slider_section_enable'
    )
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpo_digital_theme_options[slider_btn_alt_txt]',
		array(
			'selector'            => '#featured-slider-section div.read-more a:nth-child(2)',
			'settings'            => 'corpo_digital_theme_options[slider_btn_alt_txt]',
			'fallback_refresh'    => true,
			'container_inclusive' => false,
			'render_callback'     => 'corpo_digital_slider_btn_alt_txt_partial',
		) 
	);
}

$wp_customize->add_setting( 'corpo_digital_theme_options[slider_btn_alt_url]',
    array(
        'sanitize_callback' => 'esc_url_raw',
    )
);

$wp_customize->add_control( 'corpo_digital_theme_options[slider_btn_alt_url]',
    array(
        'label'           	=> esc_html__( 'Button Alt URL', 'corpo-digital' ),
        'section'        	=> 'corpo_digital_slider_section',
        'active_callback' 	=> 'corpo_digital_is_slider_section_enable',
        'type'				=> 'url',
    ) 
);

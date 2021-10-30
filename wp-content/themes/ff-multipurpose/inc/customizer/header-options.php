<?php
/**
 * Adds the header options sections, settings, and controls to the theme customizer
 *
 * @package FF_Multipurpose
 */

class FF_Multipurpose_Header_Options {
	public function __construct() {
		// Register Header Options.
		add_action( 'customize_register', array( $this, 'register_header_options' ) );

		// Add default options.
		add_filter( 'ff_multipurpose_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'ff_multipurpose_header_style' => 'header-one',
		);

		$updated_defaults = wp_parse_args( $defaults, $default_options );

		return $updated_defaults;
	}

	/**
	 * Add header options section and its controls
	 */
	public function register_header_options( $wp_customize ) {
		// Add header options section.
		$wp_customize->add_section( 'ff_multipurpose_header_options',
			array(
				'title' => esc_html__( 'Header Options', 'ff-multipurpose' ),
				'panel' => 'ff_multipurpose_theme_options'
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Multipurpose_Image_Radio_Button_Custom_Control',
				'settings'          => 'ff_multipurpose_header_style',
				'sanitize_callback' => 'ff_multipurpose_radio_sanitization',
				'label'             => esc_html__( 'Header Style', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_header_options',
				'choices'           => array(
					'header-one'   => array(
						'image' => trailingslashit( get_template_directory_uri() ) . 'images/header-1.png',
						'name'  => esc_html__( 'Header Style One', 'ff-multipurpose' ),
					),
					'header-two'   => array(
						'image' => trailingslashit( get_template_directory_uri() ) . 'images/header-2.png',
						'name'  => esc_html__( 'Header Style Two', 'ff-multipurpose' ),
					),
				),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'ff_multipurpose_header_email',
				'sanitize_callback' => 'sanitize_email',
				'label'             => esc_html__( 'Email', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_header_options',
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'ff_multipurpose_header_phone',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'label'             => esc_html__( 'Phone', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_header_options',
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'ff_multipurpose_header_address',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'label'             => esc_html__( 'Address', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_header_options',
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'ff_multipurpose_header_open_hours',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'label'             => esc_html__( 'Open Hours', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_header_options',
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'ff_multipurpose_header_button_text',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'label'             => esc_html__( 'Button Text', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_header_options',
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'type'              => 'url',
				'settings'          => 'ff_multipurpose_header_button_link',
				'sanitize_callback' => 'esc_url_raw',
				'label'             => esc_html__( 'Button Link', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_header_options',
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Multipurpose_Toggle_Switch_Custom_control',
				'settings'          => 'ff_multipurpose_header_button_target',
				'sanitize_callback' => 'ff_multipurpose_switch_sanitization',
				'label'             => esc_html__( 'Open link in new tab?', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_header_options',
			)
		);
	}
}

/**
 * Initialize class
 */
$ff_multipurpose_theme_options = new FF_Multipurpose_Header_Options();

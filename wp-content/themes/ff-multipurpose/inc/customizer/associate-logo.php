<?php
/**
 * Portfolio Options
 *
 * @package FF_Multipurpose
 */

class FF_Multipurpose_Associate_Logo_Options {
	public function __construct() {
		// Add options to default options.
		add_filter( 'ff_multipurpose_customizer_defaults', array( $this, 'add_defaults' ) );

		// Register Portfolio Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 99 );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'ff_multipurpose_associate_logo_visibility' => 'disabled',
			'ff_multipurpose_associate_logo_number'     => 10,
		);

		$updated_defaults = wp_parse_args( $defaults, $default_options );

		return $updated_defaults;
	}

	/**
	 * Add default color options to main color options
	 * @param [type] $default_options [description]
	 */
	public function add_colors_to_defaults( $default_options ) {


		return $updated_options;
	}

	/**
	 * Add layouts section and its controls
	 */
	public function register_options( $wp_customize ) {
		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_associate_logo_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'ff_multipurpose_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_associate_logo',
				'choices'           => FF_Multipurpose_Customizer_Utilities::section_visibility(),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'settings'          => 'ff_multipurpose_associate_logo_section_top_subtitle',
				'label'             => esc_html__( 'Section Top Sub-title', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_associate_logo',
				'active_callback'   => array( $this, 'is_associate_logo_visible' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_associate_logo_section_title',
				'type'              => 'text',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'label'             => esc_html__( 'Section Title', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_associate_logo',
				'active_callback'   => array( $this, 'is_associate_logo_visible' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_associate_logo_section_subtitle',
				'type'              => 'text',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'label'             => esc_html__( 'Section Subtitle', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_associate_logo',
				'active_callback'   => array( $this, 'is_associate_logo_visible' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_associate_logo_number',
				'type'              => 'number',
				'label'             => esc_html__( 'Number', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_associate_logo',
				'sanitize_callback' => 'absint',
				'input_attrs'       => array(
					'min'   => 1,
					'max'   => 80,
					'step'  => 1,
					'style' => 'width:100px;',
				),
				'active_callback'   => array( $this, 'is_associate_logo_visible' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_associate_logo_category',
				'custom_control'    => 'FF_Multipurpose_Dropdown_Select2_Custom_Control',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'label'             => esc_html__( 'Pick Categories', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_associate_logo',
				'choices'           => array( esc_html__( '--Select--', 'ff-multipurpose' ) => FF_Multipurpose_Customizer_Utilities::get_terms( 'category' ) ),
				'active_callback'   => array( $this, 'is_associate_logo_visible' ),
			)
		);
	}

	/**
	 * Portfolio visibility active callback.
	 */
	public function is_associate_logo_visible( $control ) {
		return ( ff_multipurpose_display_section( $control->manager->get_setting( 'ff_multipurpose_associate_logo_visibility' )->value() ) );
	}
}

/**
 * Initialize class
 */
$ff_multipurpose_ss_associate_logo = new FF_Multipurpose_Associate_Logo_Options();

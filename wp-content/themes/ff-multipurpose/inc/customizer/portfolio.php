<?php
/**
 * Portfolio Options
 *
 * @package FF_Multipurpose
 */

class FF_Multipurpose_Portfolio_Options {
	public function __construct() {
		// Register Portfolio Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 99 );

		// Add default options.
		add_filter( 'ff_multipurpose_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'ff_multipurpose_portfolio_visibility' => 'disabled',
			'ff_multipurpose_portfolio_number'     => 6,
		);

		$updated_defaults = wp_parse_args( $defaults, $default_options );

		return $updated_defaults;
	}

	/**
	 * Add layouts section and its controls
	 */
	public function register_options( $wp_customize ) {
		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_portfolio_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'ff_multipurpose_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_portfolio',
				'choices'           => FF_Multipurpose_Customizer_Utilities::section_visibility(),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'settings'          => 'ff_multipurpose_portfolio_section_top_subtitle',
				'label'             => esc_html__( 'Section Top Sub-title', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_portfolio',
				'active_callback'   => array( $this, 'is_portfolio_visible' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_portfolio_section_title',
				'type'              => 'text',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'label'             => esc_html__( 'Section Title', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_portfolio',
				'active_callback'   => array( $this, 'is_portfolio_visible' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_portfolio_section_subtitle',
				'type'              => 'text',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'label'             => esc_html__( 'Section Subtitle', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_portfolio',
				'active_callback'   => array( $this, 'is_portfolio_visible' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_portfolio_number',
				'type'              => 'number',
				'label'             => esc_html__( 'Number', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_portfolio',
				'sanitize_callback' => 'absint',
				'input_attrs'       => array(
					'min'   => 1,
					'max'   => 80,
					'step'  => 1,
					'style' => 'width:100px;',
				),
				'active_callback'   => array( $this, 'is_portfolio_visible' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_portfolio_category',
				'custom_control'    => 'FF_Multipurpose_Dropdown_Select2_Custom_Control',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'label'             => esc_html__( 'Pick Categories', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_portfolio',
				'choices'           => array( esc_html__( '--Select--', 'ff-multipurpose' ) => FF_Multipurpose_Customizer_Utilities::get_terms( 'category' ) ),
				'active_callback'   => array( $this, 'is_portfolio_visible' ),
			)
		);
	}

	/**
	 * Portfolio visibility active callback.
	 */
	public function is_portfolio_visible( $control ) {
		return ( ff_multipurpose_display_section( $control->manager->get_setting( 'ff_multipurpose_portfolio_visibility' )->value() ) );
	}
}

/**
 * Initialize class
 */
$ff_multipurpose_ss_portfolio = new FF_Multipurpose_Portfolio_Options();

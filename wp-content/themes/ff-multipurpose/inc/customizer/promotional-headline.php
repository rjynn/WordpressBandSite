<?php
/**
 * Promotional Headline Options
 *
 * @package FF_Multipurpose
 */

class FF_Multipurpose_Promotional_Headline_Options {
	public function __construct() {
		// Register Promotion Headline Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 99 );

		// Add default options.
		add_filter( 'ff_multipurpose_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'ff_multipurpose_promotional_headline_visibility' => 'disabled',
			'ff_multipurpose_promotional_headline_overlay'    => 1,
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
				'settings'          => 'ff_multipurpose_promotional_headline_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'ff_multipurpose_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_promotional_headline',
				'choices'           => FF_Multipurpose_Customizer_Utilities::section_visibility(),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Multipurpose_Dropdown_Posts_Custom_Control',
				'sanitize_callback' => 'absint',
				'settings'          => 'ff_multipurpose_promotional_headline_page',
				'label'             => esc_html__( 'Select Page', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_promotional_headline',
				'active_callback'   => array( $this, 'is_promotional_headline_visible' ),
				'input_attrs' => array(
					'post_type'      => 'page',
					'posts_per_page' => -1,
					'orderby'        => 'name',
					'order'          => 'ASC',
				),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Multipurpose_Toggle_Switch_Custom_control',
				'settings'          => 'ff_multipurpose_promotional_headline_overlay',
				'sanitize_callback' => 'ff_multipurpose_switch_sanitization',
				'label'             => esc_html__( 'Overlay on image?', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_promotional_headline',
				'active_callback'   => array( $this, 'is_promotional_headline_visible' ),
			)
		);
	}

	/**
	 * Promotion Headline visibility active callback.
	 */
	public function is_promotional_headline_visible( $control ) {
		return ( ff_multipurpose_display_section( $control->manager->get_setting( 'ff_multipurpose_promotional_headline_visibility' )->value() ) );
	}
}

/**
 * Initialize class
 */
$ff_multipurpose_ss_promotional_headline = new FF_Multipurpose_Promotional_Headline_Options();

<?php
/**
 * WWD Options
 *
 * @package FF_Multipurpose
 */

class FF_Multipurpose_WWD_Options {
	public function __construct() {
		// Register WWD Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 99 );

		// Add default options.
		add_filter( 'ff_multipurpose_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'ff_multipurpose_wwd_visibility' => 'disabled',
			'ff_multipurpose_wwd_number'     => 6,
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
				'settings'          => 'ff_multipurpose_wwd_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'ff_multipurpose_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_wwd',
				'choices'           => FF_Multipurpose_Customizer_Utilities::section_visibility(),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'settings'          => 'ff_multipurpose_wwd_section_top_subtitle',
				'label'             => esc_html__( 'Section Top Sub-title', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_wwd',
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_wwd_section_title',
				'type'              => 'text',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'label'             => esc_html__( 'Section Title', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_wwd',
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_wwd_section_subtitle',
				'type'              => 'text',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'label'             => esc_html__( 'Section Subtitle', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_wwd',
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_wwd_number',
				'type'              => 'number',
				'label'             => esc_html__( 'Number', 'ff-multipurpose' ),
				'description'       => esc_html__( 'Please refresh the customizer page once the number is changed.', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_wwd',
				'sanitize_callback' => 'absint',
				'input_attrs'       => array(
					'min'   => 1,
					'max'   => 80,
					'step'  => 1,
					'style' => 'width:100px;',
				),
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		$numbers = ff_multipurpose_gtm( 'ff_multipurpose_wwd_number' );

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_wwd_category',
				'custom_control'    => 'FF_Multipurpose_Dropdown_Select2_Custom_Control',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'label'             => esc_html__( 'Pick Categories', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_wwd',
				'choices'           => array( esc_html__( '--Select--', 'ff-multipurpose' ) => FF_Multipurpose_Customizer_Utilities::get_terms( 'category' ) ),
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Multipurpose_Simple_Notice_Custom_Control',
				'sanitize_callback' => 'sanitize_text_field',
				'settings'          => 'ff_multipurpose_wwd_icon_note',
				'label'             =>  esc_html__( 'Info', 'ff-multipurpose' ),
				/* translators: 1: Link Start html, 2: Link end html. */
				'description'       =>  sprintf( esc_html__( 'If you want camera icon, save "fas fa-camera". For more classes, check %1$sthis%2$s', 'ff-multipurpose' ), '<a href="' . esc_url( 'https://fontawesome.com/icons?d=gallery&m=free' ) . '" target="_blank">', '</a>' ),
				'section'           => 'ff_multipurpose_ss_wwd',
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		for( $i = 0; $i < $numbers; $i++ ) {
			FF_Multipurpose_Customizer_Utilities::register_option(
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'settings'          => 'ff_multipurpose_wwd_custom_icon_' . $i,
					'label'             => esc_html__( 'Icon Class', 'ff-multipurpose' ),
					'section'           => 'ff_multipurpose_ss_wwd',
					'active_callback'   => array( $this, 'is_wwd_visible' ),
				)
			);
		}
	}

	/**
	 * WWD visibility active callback.
	 */
	public function is_wwd_visible( $control ) {
		return ( ff_multipurpose_display_section( $control->manager->get_setting( 'ff_multipurpose_wwd_visibility' )->value() ) );
	}
}

/**
 * Initialize class
 */
$ff_multipurpose_ss_wwd = new FF_Multipurpose_WWD_Options();

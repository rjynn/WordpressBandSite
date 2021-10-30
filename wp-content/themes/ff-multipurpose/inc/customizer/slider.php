<?php
/**
 * Slider Options
 *
 * @package FF_Multipurpose
 */

class FF_Multipurpose_Slider_Options {
	public function __construct() {
		// Register Slider Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 98 );

		// Register Slider Advance Options.
		add_action( 'customize_register', array( $this, 'register_advanced_options' ), 99 );

		// Add default options.
		add_filter( 'ff_multipurpose_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'ff_multipurpose_slider_visibility'        => 'disabled',
			'ff_multipurpose_slider_transition_speed'  => 300,
			'ff_multipurpose_slider_transition_effect' => 'slide',
			'ff_multipurpose_slider_loop'              => 1,
			'ff_multipurpose_slider_autoplay_delay'    => 5000,
			'ff_multipurpose_slider_pause_on_hover'    => 1,
			'ff_multipurpose_slider_overlay'           => 1,
			'ff_multipurpose_slider_number'            => 2,
		);

		$updated_defaults = wp_parse_args( $defaults, $default_options );

		return $updated_defaults;
	}

	/**
	 * Add slider section and its controls
	 */
	public function register_options( $wp_customize ) {
		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_slider_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'ff_multipurpose_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_slider',
				'choices'           => FF_Multipurpose_Customizer_Utilities::section_visibility(),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'type'              => 'number',
				'settings'          => 'ff_multipurpose_slider_number',
				'label'             => esc_html__( 'Number', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_slider',
				'sanitize_callback' => 'absint',
				'input_attrs'       => array(
					'min'   => 1,
					'max'   => 80,
					'step'  => 1,
					'style' => 'width:100px;',
				),
				'active_callback'   => array( $this, 'is_slider_visible' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_slider_category',
				'custom_control'    => 'FF_Multipurpose_Dropdown_Select2_Custom_Control',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'label'             => esc_html__( 'Pick Categories', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_slider',
				'choices'           => array( esc_html__( '--Select--', 'ff-multipurpose' ) => FF_Multipurpose_Customizer_Utilities::get_terms( 'category' ) ),
				'active_callback'   => array( $this, 'is_slider_visible' ),
			)
		);
	}

	/**
	 * Add slider advance options
	 */
	public function register_advanced_options( $wp_customize ) {
		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Multipurpose_Note_Control',
				'settings'          => 'ff_multipurpose_slider_advance_options_notice',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'label'             => esc_html__( 'Slider Advance Options', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_slider',
				'active_callback'   => array( $this, 'is_slider_visible' ),
				'transport'         => 'postMessage',
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_slider_transition_speed',
				'type'              => 'number',
				'sanitize_callback' => 'absint',
				'label'             => esc_html__( 'Transition Speed', 'ff-multipurpose' ),
				'description'       => esc_html__( 'Duration of transition between slides (in ms)', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_slider',
				'input_attrs'           => array(
					'width' => '10px',
				),
				'active_callback'   => array( $this, 'is_slider_visible' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_slider_transition_effect',
				'type'              => 'select',
				'sanitize_callback' => 'ff_multipurpose_sanitize_select',
				'label'             => esc_html__( 'Transition Effect', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_slider',
				'choices'           => array(
					'slide'     => esc_html__( 'Slide', 'ff-multipurpose' ),
					'fade'      => esc_html__( 'Fade', 'ff-multipurpose' ),
					'cube'      => esc_html__( 'Cube', 'ff-multipurpose' ),
					'coverflow' => esc_html__( 'Coverflow', 'ff-multipurpose' ),
					'flip'      => esc_html__( 'Flip', 'ff-multipurpose' ),
				),
				'active_callback'   => array( $this, 'is_slider_visible' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Multipurpose_Toggle_Switch_Custom_control',
				'settings'          => 'ff_multipurpose_slider_loop',
				'description'       => esc_html__( 'Enable continuous loop mode', 'ff-multipurpose' ),
				'sanitize_callback' => 'ff_multipurpose_switch_sanitization',
				'label'             => esc_html__( 'Loop', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_slider',
				'active_callback'   => array( $this, 'is_slider_visible' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Multipurpose_Toggle_Switch_Custom_control',
				'settings'          => 'ff_multipurpose_slider_zoom',
				'description'       => esc_html__( 'Enable zoom effect on images', 'ff-multipurpose' ),
				'sanitize_callback' => 'ff_multipurpose_switch_sanitization',
				'label'             => esc_html__( 'Zoom Effect', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_slider',
				'active_callback'   => array( $this, 'is_slider_visible' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Multipurpose_Toggle_Switch_Custom_control',
				'settings'          => 'ff_multipurpose_slider_autoplay',
				'sanitize_callback' => 'ff_multipurpose_switch_sanitization',
				'label'             => esc_html__( 'Autoplay', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_slider',
				'active_callback'   => array( $this, 'is_slider_visible' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_slider_autoplay_delay',
				'type'              => 'number',
				'sanitize_callback' => 'absint',
				'label'             => esc_html__( 'Autoplay Delay', 'ff-multipurpose' ),
				'description'       => esc_html__( '(in ms)', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_slider',
				'input_attrs'           => array(
					'width' => '10px',
				),
				'active_callback'   => array( $this, 'is_slider_autoplay_on' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Multipurpose_Toggle_Switch_Custom_control',
				'settings'          => 'ff_multipurpose_slider_pause_on_hover',
				'sanitize_callback' => 'ff_multipurpose_switch_sanitization',
				'label'             => esc_html__( 'Pause On Hover', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_slider',
				'active_callback'   => array( $this, 'is_slider_autoplay_on' ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Multipurpose_Toggle_Switch_Custom_control',
				'settings'          => 'ff_multipurpose_slider_overlay',
				'sanitize_callback' => 'ff_multipurpose_switch_sanitization',
				'label'             => esc_html__( 'Image Overlay', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_ss_slider',
				'active_callback'   => array( $this, 'is_slider_visible' ),
			)
		);
	}

	/**
	 * Slider visibility active callback.
	 */
	public function is_slider_visible( $control ) {
		return ( ff_multipurpose_display_section( $control->manager->get_setting( 'ff_multipurpose_slider_visibility' )->value() ) );
	}

	/**
	 * Slider autoplay check.
	 */
	public function is_slider_autoplay_on( $control ) {
		return ( $this->is_slider_visible( $control ) && $control->manager->get_setting( 'ff_multipurpose_slider_autoplay' )->value() );
	}
}

/**
 * Initialize class
 */
$ff_multipurpose_ss_slider = new FF_Multipurpose_Slider_Options();

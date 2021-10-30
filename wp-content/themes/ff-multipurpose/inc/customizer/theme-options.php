<?php
/**
 * Adds the theme options sections, settings, and controls to the theme customizer
 *
 * @package FF_Multipurpose
 */

class FF_Multipurpose_Theme_Options {
	public function __construct() {
		// Register our Panel.
		add_action( 'customize_register', array( $this, 'add_panel' ) );

		// Register Breadcrumb Options.
		add_action( 'customize_register', array( $this, 'register_breadcrumb_options' ) );

		// Register Excerpt Options.
		add_action( 'customize_register', array( $this, 'register_excerpt_options' ) );

		// Register Homepage Options.
		add_action( 'customize_register', array( $this, 'register_homepage_options' ) );

		// Register Layout Options.
		add_action( 'customize_register', array( $this, 'register_layout_options' ) );

		// Register Search Options.
		add_action( 'customize_register', array( $this, 'register_search_options' ) );

		// Add default options.
		add_filter( 'ff_multipurpose_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			// Header Media.
			'ff_multipurpose_header_image_visibility' => 'entire-site',

			// Breadcrumb
			'ff_multipurpose_breadcrumb_show' => 1,

			// Layout Options.
			'ff_multipurpose_layout_type'             => 'fluid',
			'ff_multipurpose_default_layout'          => 'right-sidebar',
			'ff_multipurpose_homepage_archive_layout' => 'no-sidebar-full-width',
			
			// Excerpt Options
			'ff_multipurpose_excerpt_length'    => 30,
			'ff_multipurpose_excerpt_more_text' => esc_html__( 'Continue reading', 'ff-multipurpose' ),

			// Homepage/Frontpage Options.
			'ff_multipurpose_front_page_category'   => '',
			'ff_multipurpose_show_homepage_content' => 1,
			
			// Search Options.
			'ff_multipurpose_search_text'         => esc_html__( 'Search...', 'ff-multipurpose' ),
		);


		$updated_defaults = wp_parse_args( $defaults, $default_options );

		return $updated_defaults;
	}

	/**
	 * Register the Customizer panels
	 */
	public function add_panel( $wp_customize ) {
		/**
		 * Add our Header & Navigation Panel
		 */
		 $wp_customize->add_panel( 'ff_multipurpose_theme_options',
		 	array(
				'title' => esc_html__( 'Theme Options', 'ff-multipurpose' ),
			)
		);
	}

	/**
	 * Add breadcrumb section and its controls
	 */
	public function register_breadcrumb_options( $wp_customize ) {
		// Add Excerpt Options section.
		$wp_customize->add_section( 'ff_multipurpose_breadcrumb_options',
			array(
				'title' => esc_html__( 'Breadcrumb', 'ff-multipurpose' ),
				'panel' => 'ff_multipurpose_theme_options',
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Multipurpose_Toggle_Switch_Custom_control',
				'settings'          => 'ff_multipurpose_breadcrumb_show',
				'sanitize_callback' => 'ff_multipurpose_switch_sanitization',
				'label'             => esc_html__( 'Display Breadcrumb?', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_breadcrumb_options',
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Multipurpose_Toggle_Switch_Custom_control',
				'settings'          => 'ff_multipurpose_breadcrumb_show_home',
				'sanitize_callback' => 'ff_multipurpose_switch_sanitization',
				'label'             => esc_html__( 'Show on homepage?', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_breadcrumb_options',
			)
		);
	}

	/**
	 * Add layouts section and its controls
	 */
	public function register_layout_options( $wp_customize ) {
		// Add layouts section.
		$wp_customize->add_section( 'ff_multipurpose_layouts',
			array(
				'title' => esc_html__( 'Layouts', 'ff-multipurpose' ),
				'panel' => 'ff_multipurpose_theme_options'
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'type'              => 'select',
				'settings'          => 'ff_multipurpose_layout_type',
				'sanitize_callback' => 'ff_multipurpose_sanitize_select',
				'label'             => esc_html__( 'Site Layout', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_layouts',
				'choices'           => array(
					'fluid' => esc_html__( 'Fluid', 'ff-multipurpose' ),
					'boxed' => esc_html__( 'Boxed', 'ff-multipurpose' ),
				),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'type'              => 'select',
				'settings'          => 'ff_multipurpose_default_layout',
				'sanitize_callback' => 'ff_multipurpose_sanitize_select',
				'label'             => esc_html__( 'Default Layout', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_layouts',
				'choices'           => array(
					'right-sidebar'         => esc_html__( 'Right Sidebar', 'ff-multipurpose' ),
					'no-sidebar-full-width' => esc_html__( 'No Sidebar: Full Width', 'ff-multipurpose' ),
				),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'type'              => 'select',
				'settings'          => 'ff_multipurpose_homepage_archive_layout',
				'sanitize_callback' => 'ff_multipurpose_sanitize_select',
				'label'             => esc_html__( 'Homepage/Archive Layout', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_layouts',
				'choices'           => array(
					'right-sidebar'         => esc_html__( 'Right Sidebar', 'ff-multipurpose' ),
					'no-sidebar-full-width' => esc_html__( 'No Sidebar: Full Width', 'ff-multipurpose' ),
				),
			)
		);
	}

	/**
	 * Add excerpt section and its controls
	 */
	public function register_excerpt_options( $wp_customize ) {
		// Add Excerpt Options section.
		$wp_customize->add_section( 'ff_multipurpose_excerpt_options',
			array(
				'title' => esc_html__( 'Excerpt Options', 'ff-multipurpose' ),
				'panel' => 'ff_multipurpose_theme_options',
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'type'              => 'number',
				'settings'          => 'ff_multipurpose_excerpt_length',
				'sanitize_callback' => 'absint',
				'label'             => esc_html__( 'Excerpt Length (Words)', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_excerpt_options',
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'ff_multipurpose_excerpt_more_text',
				'sanitize_callback' => 'sanitize_text_field',
				'label'             => esc_html__( 'Excerpt More Text', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_excerpt_options',
			)
		);
	}

	/**
	 * Add Homepage/Frontpage section and its controls
	 */
	public function register_homepage_options( $wp_customize ) {
		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Multipurpose_Dropdown_Select2_Custom_Control',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'settings'          => 'ff_multipurpose_front_page_category',
				'description'       => esc_html__( 'Filter Homepage/Blog page posts by following categories', 'ff-multipurpose' ),
				'label'             => esc_html__( 'Categories', 'ff-multipurpose' ),
				'section'           => 'static_front_page',
				'choices'           => array( esc_html__( '--Select--', 'ff-multipurpose' ) => FF_Multipurpose_Customizer_Utilities::get_terms( 'category' ) ),
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Multipurpose_Toggle_Switch_Custom_control',
				'settings'          => 'ff_multipurpose_show_homepage_content',
				'sanitize_callback' => 'ff_multipurpose_switch_sanitization',
				'label'             => esc_html__( 'Show Home Content/Blog', 'ff-multipurpose' ),
				'section'           => 'static_front_page',
			)
		);
	}

	/**
	 * Add Homepage/Frontpage section and its controls
	 */
	public function register_search_options( $wp_customize ) {
		// Add Homepage/Frontpage Section.
		$wp_customize->add_section( 'ff_multipurpose_search',
			array(
				'title' => esc_html__( 'Search', 'ff-multipurpose' ),
				'panel' => 'ff_multipurpose_theme_options',
			)
		);

		FF_Multipurpose_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_multipurpose_search_text',
				'sanitize_callback' => 'ff_multipurpose_text_sanitization',
				'label'             => esc_html__( 'Search Text', 'ff-multipurpose' ),
				'section'           => 'ff_multipurpose_search',
				'type'              => 'text',
			)
		);
	}

	/**
	 * Array for fonts.
	 */
	public static function get_font_options() {
		$fonts = array(
			'ff_multipurpose_body_font' => array(
				'label'    => esc_html__( 'Body(Default)', 'ff-multipurpose' ),
				'selector' => 'body',
			),
			'ff_multipurpose_title_font' => array(
				'label'    => esc_html__( 'Site Title', 'ff-multipurpose' ),
				'selector' => '.site-title',
			),
			'ff_multipurpose_tagline_font' => array(
				'label'    => esc_html__( 'Tagline', 'ff-multipurpose' ),
				'selector' => '.site-description',
			),
			'ff_multipurpose_content_font' => array(
				'label'    => esc_html__( 'Content', 'ff-multipurpose' ),
				'selector' => '#content, #content p',
			),
			'ff_multipurpose_headings_font' => array(
				'label'    => esc_html__( 'Headings (h1 to h6)', 'ff-multipurpose' ),
				'selector' => 'h1, h2, h3, h4, h5, h6',
			),
			'ff_multipurpose_content_font' => array(
				'label'    => esc_html__( 'Section Title', 'ff-multipurpose' ),
				'selector' => '#hero-content .section-title',
			),
		);

		return $fonts;
	}
}

/**
 * Initialize class
 */
$ff_multipurpose_theme_options = new FF_Multipurpose_Theme_Options();

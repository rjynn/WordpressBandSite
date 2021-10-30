<?php
/**
 * FF Multipurpose functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package FF_Multipurpose
 */

/**
 * Returns theme mod value saved for option merging with default option if available.
 * @since 1.0
 */
function ff_multipurpose_gtm( $option ) {
	// Get our Customizer defaults
	$defaults = apply_filters( 'ff_multipurpose_customizer_defaults', true );

	return isset( $defaults[ $option ] ) ? get_theme_mod( $option, $defaults[ $option ] ) : get_theme_mod( $option );
}

if ( ! function_exists( 'ff_multipurpose_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ff_multipurpose_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on FF Multipurpose, use a find and replace
		 * to change 'ff-multipurpose' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ff-multipurpose', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Used in archive content, featured content.
		set_post_thumbnail_size( 825, 620, false );

		// Used in slider.
		add_image_size( 'ff-multipurpose-slider', 1920, 1000, false );

		// Used in hero content.
		add_image_size( 'ff-multipurpose-hero', 600, 650, false );

		// Used in portfolio, team.
		add_image_size( 'ff-multipurpose-portfolio', 400, 450, false );

		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary Menu', 'ff-multipurpose' ),
			'social' => esc_html__( 'Social Menu', 'ff-multipurpose' ),
		) );


		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'ff_multipurpose_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		// Add theme editor style
		add_editor_style( array( 'css/editor-style.css' ) );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );
	}
endif;
add_action( 'after_setup_theme', 'ff_multipurpose_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 */
function ff_multipurpose_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'ff_multipurpose_content_width', 1230 );
}
add_action( 'after_setup_theme', 'ff_multipurpose_content_width', 0 );

if ( ! function_exists( 'ff_multipurpose_custom_content_width' ) ) :
	/**
	 * Custom content width.
	 *
	 * @since 1.0
	 */
	function ff_multipurpose_custom_content_width() {
		$layout  = ff_multipurpose_get_theme_layout();

		if ( 'no-sidebar-full-width' !== $layout ) {
			$GLOBALS['content_width'] = apply_filters( 'ff_multipurpose_content_width', 890 );
		}
	}
endif;
add_filter( 'template_redirect', 'ff_multipurpose_custom_content_width' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ff_multipurpose_widgets_init() {
	$args = array(
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	);

	register_sidebar( array(
		'name'        => esc_html__( 'Sidebar', 'ff-multipurpose' ),
		'id'          => 'sidebar-1',
		'description' => esc_html__( 'Add widgets here.', 'ff-multipurpose' ),
		) + $args
	);

	register_sidebar( array(
		'name'        => esc_html__( 'Footer 1', 'ff-multipurpose' ),
		'id'          => 'sidebar-2',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'ff-multipurpose' ),
		) + $args
	);

	register_sidebar( array(
		'name'        => esc_html__( 'Footer 2', 'ff-multipurpose' ),
		'id'          => 'sidebar-3',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'ff-multipurpose' ),
		) + $args
	);

	register_sidebar( array(
		'name'        => esc_html__( 'Footer 3', 'ff-multipurpose' ),
		'id'          => 'sidebar-4',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'ff-multipurpose' ),
		) + $args
	);
}
add_action( 'widgets_init', 'ff_multipurpose_widgets_init' );

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 *
 * @since 1.0
 */
function ff_multipurpose_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-2' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-4' ) ) {
		$count++;
	}

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
		case '4':
			$class = 'four';
			break;
	}

	if ( $class ) {
		echo 'class="widget-area footer-widget-area ' . $class . '"'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'ff_multipurpose_fonts_url' ) ) :
	/**
	 * Register Google fonts for FF Multipurpose
	 *
	 * Create your own ff_multipurpose_fonts_url() function to override in a child theme.
	 *
	 * @return string Google fonts URL for the theme.
	 *
	 * @since 0.1
	 */
	function ff_multipurpose_fonts_url() {
		$fonts_url = '';

		/* Translators: If there are characters in your language that are not
		* supported by Heebo, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$roboto = _x( 'on', 'Roboto font: on or off', 'ff-multipurpose' );
		$poppins = _x( 'on', 'Poppins font: on or off', 'ff-multipurpose' );

		if ( 'off' !== $roboto && 'off' !== $poppins ) {
			$font_families = array();

			if ( 'off' !== $roboto ) {
				$font_families[] = 'Roboto:300,400,500,600,700,900';
			}

			if ( 'off' !== $poppins ) {
				$font_families[] = 'Poppins:300,400,500,600,700,900';
			}

			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}
endif;

/**
 * Enqueue scripts and styles.
 */
function ff_multipurpose_scripts() {
	$min  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	// FontAwesome.
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome/css/all' . $min . '.css', array(), '5.15.3', 'all' );

	// Theme stylesheet.
	wp_enqueue_style( 'ff-multipurpose-style', get_stylesheet_uri(), array(), ff_multipurpose_get_file_mod_date( get_template_directory() . '/style.css' ) );

	// Add google fonts.
	wp_enqueue_style( 'ff-multipurpose-fonts', ff_multipurpose_fonts_url(), array(), null );

	// Theme block stylesheet.
	wp_enqueue_style( 'ff-multipurpose-block-style', get_template_directory_uri() . '/css/blocks' . $min . '.css', array( 'ff-multipurpose-style' ), ff_multipurpose_get_file_mod_date( get_template_directory() . '/css/blocks' . $min . '.css' ) );

	wp_enqueue_script( 'ff-multipurpose-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix' . $min . '.js', array(), ff_multipurpose_get_file_mod_date( get_template_directory() . '/js/skip-link-focus-fix' . $min . '.js' ), true );

	wp_enqueue_script( 'ff-multipurpose-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation' . $min . '.js', array(), ff_multipurpose_get_file_mod_date( get_template_directory() . '/js/keyboard-image-navigation' . $min . '.js' ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'ff-multipurpose-script', get_template_directory_uri() . '/js/functions' . $min . '.js', array( 'jquery', 'masonry'  ), ff_multipurpose_get_file_mod_date( get_template_directory() . '/js/functions' . $min . '.js' ), true );

	wp_localize_script( 'ff-multipurpose-script', 'ffMultipurposeScreenReaderText', array(
		'expand'   => esc_html__( 'expand child menu', 'ff-multipurpose' ),
		'collapse' => esc_html__( 'collapse child menu', 'ff-multipurpose' ),
	) );

	// Slider Scripts.
	$enable_slider      = ff_multipurpose_gtm( 'ff_multipurpose_slider_visibility' );
	$enable_testimonial = ff_multipurpose_gtm( 'ff_multipurpose_testimonial_visibility' );
	if ( ff_multipurpose_display_section( $enable_slider ) || ff_multipurpose_display_section( $enable_testimonial ) ) {
		wp_enqueue_style( 'swiper-css', get_template_directory_uri() . '/css/swiper' . $min . '.css', array(), ff_multipurpose_get_file_mod_date( get_template_directory() . '/css/swiper' . $min . '.css' ), false );

		wp_enqueue_script( 'swiper', get_template_directory_uri() . '/js/swiper' . $min . '.js', array(), ff_multipurpose_get_file_mod_date( get_template_directory() . '/js/swiper' . $min . '.js' ), true );

		wp_enqueue_script( 'swiper-custom', get_template_directory_uri() . '/js/swiper-custom' . $min . '.js', array( 'swiper' ), ff_multipurpose_get_file_mod_date( get_template_directory() . '/js/swiper-custom' . $min . '.js' ), true );

		// Localize the script with new data.
		$slider_options = array(
			'slider'      => array(
				'speed'         => esc_js( ff_multipurpose_gtm( 'ff_multipurpose_slider_transition_speed' ) ),
				'effect'        => esc_js( ff_multipurpose_gtm( 'ff_multipurpose_slider_transition_effect' ) ),
				'loop'          => esc_js( ff_multipurpose_gtm( 'ff_multipurpose_slider_loop' ) ),
				'autoplay'      => esc_js( ff_multipurpose_gtm( 'ff_multipurpose_slider_autoplay' ) ),
				'autoplayDelay' => esc_js( ff_multipurpose_gtm( 'ff_multipurpose_slider_autoplay_delay' ) ),
				'pauseOnHover'  => esc_js( ff_multipurpose_gtm( 'ff_multipurpose_slider_pause_on_hover' ) ),
			)
		);

		wp_localize_script( 'swiper-custom', 'ffMultipurposeSliderOptions', $slider_options );
	}
}
add_action( 'wp_enqueue_scripts', 'ff_multipurpose_scripts' );

/**
 * Get file modified date
 */
function ff_multipurpose_get_file_mod_date( $file ) {
	return date( 'Ymd-Gis', filemtime( $file ) );
}

/**
 * Enqueue editor styles for Gutenberg
 */
function ff_multipurpose_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'ff-multipurpose-block-editor-style', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'css/editor-blocks.css' );

	// Add custom fonts.
	wp_enqueue_style( 'ff-multipurpose-fonts', ff_multipurpose_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'ff_multipurpose_block_editor_styles' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Breadcrumb.
 */
require get_template_directory() . '/inc/breadcrumb.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Metabox additions.
 */
require get_template_directory() . '/inc/metabox.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load Theme About Page
 */
require get_parent_theme_file_path( '/inc/theme-about.php' );

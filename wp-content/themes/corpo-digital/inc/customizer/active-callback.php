<?php
/**
 * Customizer active callbacks
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

if ( ! function_exists( 'corpo_digital_is_static_homepage_enable' ) ) :
	/**
	 * Check if static homepage is enabled.
	 *
	 * @since Corpo Digital 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function corpo_digital_is_static_homepage_enable( $control ) {
		return ( 'page' == $control->manager->get_setting( 'show_on_front' )->value() );
	}
endif;

if ( ! function_exists( 'corpo_digital_is_breadcrumb_enable' ) ) :
	/**
	 * Check if breadcrumb is enabled.
	 *
	 * @since  Corpo Digital 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function corpo_digital_is_breadcrumb_enable( $control ) {
		return $control->manager->get_setting( 'corpo_digital_theme_options[breadcrumb_enable]' )->value();
	}
endif;

if ( ! function_exists( 'corpo_digital_is_pagination_enable' ) ) :
	/**
	 * Check if pagination is enabled.
	 *
	 * @since  Corpo Digital 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function corpo_digital_is_pagination_enable( $control ) {
		return $control->manager->get_setting( 'corpo_digital_theme_options[pagination_enable]' )->value();
	}
endif;

/**
 * Check if slider section is enabled.
 *
 * @since  Corpo Digital 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpo_digital_is_slider_section_enable( $control ) {
	return ( $control->manager->get_setting( 'corpo_digital_theme_options[slider_section_enable]' )->value() );
}

/**
 * Check if about section is enabled.
 *
 * @since  Corpo Digital 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpo_digital_is_about_section_enable( $control ) {
	return ( $control->manager->get_setting( 'corpo_digital_theme_options[about_section_enable]' )->value() );
}

/**
 * Check if contact section is enabled.
 *
 * @since  Corpo Digital 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpo_digital_is_contact_section_enable( $control ) {
	return ( $control->manager->get_setting( 'corpo_digital_theme_options[contact_section_enable]' )->value() );
}

/**
 * Check if testimonial section is enabled.
 *
 * @since  Corpo Digital 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpo_digital_is_testimonial_section_enable( $control ) {
    return ( $control->manager->get_setting( 'corpo_digital_theme_options[testimonial_section_enable]' )->value() );
}

/**
 * Check if blog section is enabled.
 *
 * @since  Corpo Digital 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpo_digital_is_blog_section_enable( $control ) {
	return ( $control->manager->get_setting( 'corpo_digital_theme_options[blog_section_enable]' )->value() );
}

/**
 * Check if promotion section is enabled.
 *
 * @since  Corpo Digital 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpo_digital_is_promotion_section_enable( $control ) {
	return ( $control->manager->get_setting( 'corpo_digital_theme_options[promotion_section_enable]' )->value() );
}

/**
 * Check if gallery section is enabled.
 *
 * @since  Corpo Digital 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpo_digital_is_gallery_section_enable( $control ) {
	return ( $control->manager->get_setting( 'corpo_digital_theme_options[gallery_section_enable]' )->value() );
}

/**
 * Check if gallery separator section is enabled.
 *
 * @since  Corpo Digital 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpo_digital_is_gallery_section_separator_enable( $control ) {
    $content_type = $control->manager->get_setting( 'corpo_digital_theme_options[gallery_content_type]' )->value();
    return corpo_digital_is_gallery_section_enable( $control ) && !( 'recent' == $content_type || 'category' == $content_type ) ;
}

/**
 * Check if faq section is enabled.
 *
 * @since  Corpo Digital 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpo_digital_is_faq_section_enable( $control ) {
	return ( $control->manager->get_setting( 'corpo_digital_theme_options[faq_section_enable]' )->value() );
}

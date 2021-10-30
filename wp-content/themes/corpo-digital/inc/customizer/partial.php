<?php
/**
* Partial functions
*
* @package Theme Palace
* @subpackage  Corpo Digital
* @since  Corpo Digital 1.0.0
*/

// blog btn title
if ( ! function_exists( 'corpo_digital_copyright_text_partial' ) ) :
    function corpo_digital_copyright_text_partial() {
        $options = corpo_digital_get_theme_options();
        return esc_html( $options['copyright_text'] );
    }
endif;

// slider_btn_txt
if ( ! function_exists( 'corpo_digital_slider_btn_txt_partial' ) ) :
    function corpo_digital_slider_btn_txt_partial() {
        $options = corpo_digital_get_theme_options();
        return esc_html( $options['slider_btn_txt'] );
    }
endif;

// slider_btn_alt_txt
if ( ! function_exists( 'corpo_digital_slider_btn_alt_txt_partial' ) ) :
    function corpo_digital_slider_btn_alt_txt_partial() {
        $options = corpo_digital_get_theme_options();
        return esc_html( $options['slider_btn_alt_txt'] );
    }
endif;

// slider section  btn txt
if ( ! function_exists( 'corpo_digital_about_btn_label_partial' ) ) :
    function corpo_digital_about_btn_label_partial() {
        $options = corpo_digital_get_theme_options();
        return esc_html( $options['about_btn_label'] );
    }
endif;


// about_section_title selective refresh
if ( ! function_exists( 'corpo_digital_about_section_title_partial' ) ) :
    function corpo_digital_about_section_title_partial() {
        $options = corpo_digital_get_theme_options();
        return esc_html( $options['about_section_title'] );
    }
endif;

//Testimonial section sub title selective refresh
if ( ! function_exists( 'corpo_digital_testimonial_section_partial_sub_title' ) ) :
    function corpo_digital_testimonial_section_partial_sub_title() {
        $options = corpo_digital_get_theme_options();
        return esc_html( $options['testimonial_section_sub_title'] );
    }
endif;

//Testimonial section title selective refresh
if ( ! function_exists( 'corpo_digital_testimonial_section_partial_title' ) ) :
    function corpo_digital_testimonial_section_partial_title() {
        $options = corpo_digital_get_theme_options();
        return esc_html( $options['testimonial_section_title'] );
    }
endif;

//Blog section sub title selective refresh
if ( ! function_exists( 'corpo_digital_blog_section_partial_sub_title' ) ) :
    function corpo_digital_blog_section_partial_sub_title() {
        $options = corpo_digital_get_theme_options();
        return esc_html( $options['blog_sub_title'] );
    }
endif;

// Testimonial section  sub title
if ( ! function_exists( 'corpo_digital_team_title_partial' ) ) :
    function corpo_digital_team_title_partial() {
        $options = corpo_digital_get_theme_options();
        return esc_html( $options['team_title'] );
    }
endif;

// Testimonial section  sub title
if ( ! function_exists( 'corpo_digital_team_sub_title_partial' ) ) :
    function corpo_digital_team_sub_title_partial() {
        $options = corpo_digital_get_theme_options();
        return esc_html( $options['team_sub_title'] );
    }
endif;

// Testimonial section  sub title
if ( ! function_exists( 'corpo_digital_team_description_partial' ) ) :
    function corpo_digital_team_description_partial() {
        $options = corpo_digital_get_theme_options();
        return esc_html( $options['team_description'] );
    }
endif;

// blog_sub_title selective refresh
if ( ! function_exists( 'corpo_digital_blog_sub_title_partial' ) ) :
    function corpo_digital_blog_sub_title_partial() {
        $options = corpo_digital_get_theme_options();
        return esc_html( $options['blog_sub_title'] );
    }
endif;

// blog_title selective refresh
if ( ! function_exists( 'corpo_digital_blog_title_partial' ) ) :
    function corpo_digital_blog_title_partial() {
        $options = corpo_digital_get_theme_options();
        return esc_html( $options['blog_title'] );
    }
endif;

// contact_section_phoneNumber selective refresh
if ( ! function_exists( 'corpo_digital_contact_section_phoneNumber_partial' ) ) :
    function corpo_digital_contact_section_phoneNumber_partial() {
        $options = corpo_digital_get_theme_options();
        return esc_html( $options['contact_section_phoneNumber'] );
    }
endif;

// contact_section_email selective refresh
if ( ! function_exists( 'corpo_digital_contact_section_email_partial' ) ) :
    function corpo_digital_contact_section_email_partial() {
        $options = corpo_digital_get_theme_options();
        return esc_html( $options['contact_section_email'] );
    }
endif;

// contact_section_address selective refresh
if ( ! function_exists( 'corpo_digital_contact_section_address_partial' ) ) :
    function corpo_digital_contact_section_address_partial() {
        $options = corpo_digital_get_theme_options();
        return esc_html( $options['contact_section_address'] );
    }
endif;

// contact_description selective refresh
if ( ! function_exists( 'corpo_digital_contact_description_partial' ) ) :
    function corpo_digital_contact_description_partial() {
        $options = corpo_digital_get_theme_options();
        return esc_html( $options['contact_description'] );
    }
endif;
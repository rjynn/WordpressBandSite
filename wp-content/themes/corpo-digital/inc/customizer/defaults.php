<?php
/**
 * Customizer default options
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 * @return array An array of default values
 */

function corpo_digital_get_default_theme_options() {
	$theme_data = wp_get_theme();
	$corpo_digital_default_options = array(
		// Color Options
		'header_title_color'			    => '#fff',
		'header_tagline_color'			    => '#fff',
		'header_txt_logo_extra'			    => 'show-all',

		
		// breadcrumb
		'breadcrumb_enable'				    => (bool) true,
		'breadcrumb_separator'			    => '/',
				
		// homepage options
		'enable_frontpage_content' 			=> false,

		// layout 
		'site_layout'         			    => 'wide',
		'sidebar_position'         		    => 'right-sidebar',
		'post_sidebar_position' 		    => 'right-sidebar',
		'page_sidebar_position' 		    => 'right-sidebar',
		'search_icon_in_primary_menu_enable'=> (bool) true,

		// excerpt options
		'long_excerpt_length'               => 25,
		'read_more_text'           		    => esc_html__( 'Read More', 'corpo-digital' ),

		// pagination options
		'pagination_enable'         	    => (bool) true,
		'pagination_type'         		    => 'default',

		// footer options
		'copyright_text'           		    => sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s. ', '1: Year, 2: Site Title with home URL', 'corpo-digital' ), '[the-year]', '[site-link]' ) . esc_html__( 'All Rights Reserved | ', 'corpo-digital' ) . esc_html( $theme_data->get( 'Name') ) . '&nbsp;' . esc_html__( 'by', 'corpo-digital' ). '&nbsp;<a target="_blank" href="'. esc_url( $theme_data->get( 'AuthorURI' ) ) .'">'. esc_html( ucwords( $theme_data->get( 'Author' ) ) ) .'</a>',

		// reset options
		'reset_options'      			    => (bool) false,
		
		// homepage sections sortable
		'sortable' 						    => 'slider,about,promotion,faq,gallery,testimonial,contact,blog',

		// blog/archive options
		'your_latest_posts_title' 		    => esc_html__( 'Blogs', 'corpo-digital' ),
		'blog_column'						=> 'col-2',


		// single post theme options
		'single_post_hide_date' 		    => (bool) false,
		'single_post_hide_author'		    => (bool) false,
		'single_post_hide_category'		    => (bool) false,
		'single_post_hide_tags'			    => (bool) false,

		/* Front Page */

		// Slider
		'slider_section_enable'				=> (bool) false,
		'slider_autoplay_enable'			=> (bool) false,
		'slider_btn_txt'                    => esc_html__('Learn More','corpo-digital'),
		'slider_btn_alt_txt'                => esc_html__('Get Started','corpo-digital'),

		//about 
		'about_section_enable'			    => (bool) false,
		'about_custom_title'				=> esc_html__('We Develop & Create Digital Future','corpo-digital'),
		'about_section_title'				=> esc_html__('Creative Vision','corpo-digital'),
		'about_btn_label'					=> esc_html__('Explore More','corpo-digital'),
		'about_custom_content'				=> esc_html__('When I first started training for marathons a little over ten years ago, my coach told me something I’ve never forgotten: that I would need to learn how to be comfortable with being uncomfortable.','corpo-digital'),
		
		//testimonial
        'testimonial_section_enable'        => (bool) false,
		'testimonial_section_sub_title'     => esc_html__('Testimonial','corpo-digital'),
		'testimonial_section_title'	        => esc_html__('What They Say About Our Company?','corpo-digital'),
		'testimonial_posts_count'           =>4,

		// contact
		'contact_section_enable'			=> (bool) false,
		'contact_section_subtitle'          => esc_html__('Contact','corpo-digital'),
		'contact_section_title'			    => esc_html__( 'Join Us, Be Healthy', 'corpo-digital' ),
		'contact_section_phoneNumber'	    => '+15 000 000 000',
		'contact_section_address'			=> esc_html__( 'Little Rock, United', 'corpo-digital' ),
		'contact_section_email'			    => 'info@corpoblog.com',

		// blog
		'blog_section_enable'			    => (bool) false,
		'blog_title'					    => esc_html__( 'From Our Blogs', 'corpo-digital' ),
		'blog_sub_title'          			=> esc_html__('Recent Articles','corpo-digital'),
		'blog_count'					    => 3,

		// Popular Post
		'gallery_section_enable'		=> (bool) false,
		'gallery_section_sub_title'   	=> esc_html__('Creative Portfolio','corpo-digital'),
		'gallery_count'					=> 6,
		'gallery_title'					=> esc_html__( 'Branding & Digital Experiences Crafted with Love', 'corpo-digital' ),
		'gallery_btn_title'				=> esc_html__( 'Show All', 'corpo-digital' ),
		
		// faq
		'faq_section_enable'			=> false,
		'faq_count'						=> 3,
		'faq_title'						=> esc_html__( 'Most Popular Frequent Questions', 'corpo-digital' ),
		'faq_sub_title'					=> esc_html__( 'FAQ', 'corpo-digital' ),

		//promotion
		'promotion_section_enable' 		=> false,
		'promotion_read_more'			=>	esc_html__('Contact Us', 'corpo-digital'),

	);

	$output = apply_filters( 'corpo_digital_default_theme_options', $corpo_digital_default_options );

	// Sort array in ascending order, according to the key:
	if ( ! empty( $output ) ) {
		ksort( $output );
	}

	return $output;
}
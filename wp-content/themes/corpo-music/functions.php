<?php

if ( ! function_exists( 'corpo_music_enqueue_styles' ) ) :

	function corpo_music_enqueue_styles() {
		wp_enqueue_style( 'corpo-music-style-parent', get_template_directory_uri() . '/style.css' );

		wp_enqueue_style( 'corpo-music-style', get_stylesheet_directory_uri() . '/style.css', array( 'corpo-music-style-parent' ), '1.0.0' );

		wp_enqueue_style( 'corpo-music-fonts', corpo_music_fonts_url(), array(), null );
	}
endif;
add_action( 'wp_enqueue_scripts', 'corpo_music_enqueue_styles', 99 );


if ( !function_exists( 'corpo_music_block_editor_styles' ) ):

	function corpo_music_block_editor_styles() {
		wp_enqueue_style( 'corpo-music-fonts', corpo_music_fonts_url(), array(), null );
	}

endif;

add_action( 'enqueue_block_editor_assets', 'corpo_music_block_editor_styles' );


if ( ! function_exists( 'corpo_music_fonts_url' ) ) :

function corpo_music_fonts_url() {
	
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';


	if ( 'off' !== _x( 'on', 'Allison font: on or off', 'corpo-music' ) ) {
		$fonts[] = 'Allison';
	}

	if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'corpo-music' ) ) {
		$fonts[] = 'Roboto:400,500,700';
	}


	$query_args = array(
		'family' => urlencode( implode( '|', $fonts ) ),
		'subset' => urlencode( $subsets ),
	);

	if ( $fonts ) {
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

endif;


if ( ! function_exists( 'corpo_music_body_classes' ) ) :

	function corpo_music_audio_choices() {
	    $posts = get_posts( array( 'numberposts' => -1, 'post_type' => 'attachment', 'post_mime_type' => 'audio' ) );
	    $choices = array();
	    $choices[0] = esc_html__( '--None--', 'corpo-music' );
	    foreach ( $posts as $post ) {
	        $choices[ $post->ID ] = $post->post_title;
	    }
	    return  $choices;
	}

endif;


if ( ! function_exists( 'corpo_music_body_classes' ) ) :

	function corpo_music_body_classes( $classes ) {

		$body_class[] = 'dark-version';

		return $body_class;

	}

endif;


add_filter( 'body_class', 'corpo_music_body_classes' );


require get_theme_file_path() . '/inc/customizer.php';

require get_theme_file_path() . '/inc/front-sections/playlist.php';

require get_theme_file_path() . '/inc/front-sections/team.php';

require get_theme_file_path() . '/inc/front-sections/event.php';

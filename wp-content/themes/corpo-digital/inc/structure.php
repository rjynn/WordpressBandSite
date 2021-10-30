<?php
/**
 * Theme Palace basic theme structure hooks
 *
 * This file contains structural hooks.
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

$options = corpo_digital_get_theme_options();  


if ( ! function_exists( 'corpo_digital_doctype' ) ) :
	/**
	 * Doctype Declaration.
	 *
	 * @since  Corpo Digital 1.0.0
	 */
	function corpo_digital_doctype() {
	?>
		<!DOCTYPE html>
			<html <?php language_attributes(); ?>>
	<?php
	}
endif;
add_action( 'corpo_digital_doctype', 'corpo_digital_doctype', 10 );


if ( ! function_exists( 'corpo_digital_head' ) ) :
	/**
	 * Header Codes
	 *
	 * @since  Corpo Digital 1.0.0
	 *
	 */
	function corpo_digital_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
			<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif;
	}
endif;
add_action( 'corpo_digital_before_wp_head', 'corpo_digital_head', 10 );

if ( ! function_exists( 'corpo_digital_page_start' ) ) :
	/**
	 * Page starts html codes
	 *
	 * @since  Corpo Digital 1.0.0
	 *
	 */
	function corpo_digital_page_start() {
		?>
		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'corpo-digital' ); ?></a>
		<?php
	}
endif;
add_action( 'corpo_digital_page_start_action', 'corpo_digital_page_start', 10 );

if ( ! function_exists( 'corpo_digital_page_end' ) ) :
	/**
	 * Page end html codes
	 *
	 * @since  Corpo Digital 1.0.0
	 *
	 */
	function corpo_digital_page_end() {
		?>
		</div><!-- #page -->
		<?php
	}
endif;
add_action( 'corpo_digital_page_end_action', 'corpo_digital_page_end', 10 );

if ( ! function_exists( 'corpo_digital_site_branding' ) ) :
	/**
	 * Site branding codes
	 *
	 * @since  Corpo Digital 1.0.0
	 *
	 */
	function corpo_digital_site_branding() {
		$options  = corpo_digital_get_theme_options();
		$header_txt_logo_extra = $options['header_txt_logo_extra'];	?>

		<div class="menu-overlay"></div>
			<header id="masthead" class="site-header" role="banner">
				<div class="wrapper">
					<div class="site-branding">
						<?php if ( in_array( $header_txt_logo_extra, array( 'show-all', 'logo-title', 'logo-tagline' ) ) && has_custom_logo()  ) : ?>
							<div class="site-logo">
								<?php the_custom_logo(); ?>
							</div>
						<?php endif; 

						if ( in_array( $header_txt_logo_extra, array( 'show-all', 'title-only', 'logo-title', 'show-all', 'tagline-only', 'logo-tagline' ) ) ) : ?>
							<div id="site-identity">
								<?php
								if( in_array( $header_txt_logo_extra, array( 'show-all', 'title-only', 'logo-title' ) )  ) {
									if ( corpo_digital_is_latest_posts() ) : ?>
										<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
									<?php else : ?>
										<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
									<?php
									endif;
								} 
								if ( in_array( $header_txt_logo_extra, array( 'show-all', 'tagline-only', 'logo-tagline' ) ) ) {
									$description = get_bloginfo( 'description', 'display' );
									if ( $description || is_customize_preview() ) : ?>
										<p class="site-description"><?php echo esc_html( $description ); /* WPCS: xss ok. */ ?></p>
									<?php
									endif; 
								}?>
							</div>
						<?php endif; ?>
					</div><!-- .site-branding -->

					<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="Primary Menu">
						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" title="Primary Menu">
						<?php
						echo corpo_digital_get_svg( array( 'icon' => 'menu', 'class' => 'icon-menu' ) );
						echo corpo_digital_get_svg( array( 'icon' => 'close', 'class' => 'icon-menu' ) );
						?>	
						<span class="menu-label"><?php esc_html_e('Menu', 'corpo-digital')?></span>		
						</button>
						<?php  
							$search_html= null;
							if($options['search_icon_in_primary_menu_enable']){
								$search_html = sprintf(
												'<li class="search-menu"><a href="#" title="%1$s">%2$s%3$s</a><div id="search">%4$s</div>',
												esc_attr__('Search','corpo-digital'),
												corpo_digital_get_svg( array( 'icon' => 'search' ) ), 
												corpo_digital_get_svg( array( 'icon' => 'close' ) ), 
												get_search_form( $echo = false )
											);
								
							}else{
								$search_html = '';
							}
							
							wp_nav_menu( array(
								'theme_location' => 'primary',
								'container' => 'div',
								'menu_class' => 'menu nav-menu',
								'menu_id' => 'primary-menu',
								'echo' => true,
								'fallback_cb' => 'corpo_digital_menu_fallback_cb',
								'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s'.$search_html.'</ul>',

							) );
						?>
					</nav><!-- #site-navigation -->
				</div><!-- .wrapper -->
			</header><!-- .header-->
		</div><!-- .header-menu -->
<?php 
	}
endif;
add_action( 'corpo_digital_header_action', 'corpo_digital_site_branding', 10 );

if ( ! function_exists( 'corpo_digital_content_start' ) ) :
	/**
	 * Site content codes
	 *
	 * @since  Corpo Digital 1.0.0
	 *
	 */
	function corpo_digital_content_start() {
		?>
		<div id="content" class="site-content">
		<?php
	}
endif;
add_action( 'corpo_digital_content_start_action', 'corpo_digital_content_start', 10 );

if ( ! function_exists( 'corpo_digital_header_image' ) ) :
    /**
     * Header Image codes
     *
     * @since  Corpo Digital 1.0.0
     *
     */
    function corpo_digital_header_image() {
        if ( corpo_digital_is_frontpage() )
            return;
        $header_image = get_header_image();
        if ( is_singular() ) :
            $header_image = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'full' ) : $header_image;
        endif;
        ?>

        <div id="page-site-header" class="relative" style="background-image: url('<?php echo esc_url( $header_image ); ?>');">
            <div class="overlay"></div>
            <div class="wrapper">
                <header class="page-header">
                    <?php corpo_digital_custom_header_banner_title(); ?>
                </header>
                <?php corpo_digital_add_breadcrumb(); ?>
            </div>
        </div><!-- #page-site-header -->

        <?php
    }
endif;
add_action( 'corpo_digital_header_image_action', 'corpo_digital_header_image', 10 );

if ( ! function_exists( 'corpo_digital_add_breadcrumb' ) ) :
	/**
	 * Add breadcrumb.
	 *
	 * @since  Corpo Digital 1.0.0
	 */
	function corpo_digital_add_breadcrumb() {
		$options = corpo_digital_get_theme_options();

		// Bail if Breadcrumb disabled.
		$breadcrumb = $options['breadcrumb_enable'];
		if ( false === $breadcrumb ) {
			return;
		}
		
		// Bail if Home Page.
		if ( corpo_digital_is_frontpage() ) {
			return;
		}

		echo '<div id="breadcrumb-list" >';
				/**
				 * corpo_digital_simple_breadcrumb hook
				 *
				 * @hooked corpo_digital_simple_breadcrumb -  10
				 *
				 */
				do_action( 'corpo_digital_simple_breadcrumb' );
		echo '</div><!-- #breadcrumb-list -->';
	}
endif;

if ( ! function_exists( 'corpo_digital_content_end' ) ) :
	/**
	 * Site content codes
	 *
	 * @since  Corpo Digital 1.0.0
	 *
	 */
	function corpo_digital_content_end() {
		?>
        </div><!-- #content -->
		<?php
	}
endif;
add_action( 'corpo_digital_content_end_action', 'corpo_digital_content_end', 10 );

if ( ! function_exists( 'corpo_digital_footer_start' ) ) :
	/**
	 * Footer starts
	 *
	 * @since  Corpo Digital 1.0.0
	 *
	 */
	function corpo_digital_footer_start() {
		?>
		<footer id="colophon" class="site-footer" role="contentinfo">
		<?php
	}
endif;
add_action( 'corpo_digital_footer', 'corpo_digital_footer_start', 10 );

if ( ! function_exists( 'corpo_digital_footer_site_info' ) ) :
	/**
	 * Footer starts
	 *
	 * @since  Corpo Digital 1.0.0
	 *
	 */
	function corpo_digital_footer_site_info() {
		$options = corpo_digital_get_theme_options();
		$theme_data = wp_get_theme();
		$search = array( '[the-year]', '[site-link]' );

        $replace = array( date( 'Y' ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>' );

        $options['copyright_text'] = str_replace( $search, $replace, $options['copyright_text'] );

		$copyright_text = $options['copyright_text'];
		?>
		<div class="site-info">
                <div class="wrapper">
                    <span>
					<?php echo corpo_digital_santize_allow_tag( $copyright_text ); ?>
				
					<?php echo esc_html( $theme_data->get( 'Name') ) . '&nbsp;' . esc_html__( 'by', 'corpo-digital' ). '&nbsp;<a target="_blank" href="'. esc_url( $theme_data->get( 'AuthorURI' ) ) .'">'. esc_html( ucwords( $theme_data->get( 'Author' ) ) ) .'</a>' ?>
                </span>
                </div><!-- .wrapper -->    
            </div><!-- .site-info -->

		<?php
	}
endif;
add_action( 'corpo_digital_footer', 'corpo_digital_footer_site_info', 40 );

if ( ! function_exists( 'corpo_digital_footer_scroll_to_top' ) ) :
	/**
	 * Footer starts
	 *
	 * @since  Corpo Digital 1.0.0
	 *
	 */
	function corpo_digital_footer_scroll_to_top() { ?>
			<div class="backtotop"><?php echo corpo_digital_get_svg( array( 'icon' => 'up' ) ); ?></div>
		<?php
	}
endif;
add_action( 'corpo_digital_footer', 'corpo_digital_footer_scroll_to_top', 40 );


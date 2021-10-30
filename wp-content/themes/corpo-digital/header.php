<?php
	/**
	 * The header for our theme.
	 *
	 * This is the template that displays all of the <head> section and everything up until <div id="content">
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	 *
	 * @package Theme Palace
	 * @subpackage  Corpo Digital
	 * @since  Corpo Digital 1.0.0
	 */

	/**
	 * corpo_digital_doctype hook
	 *
	 * @hooked corpo_digital_doctype -  10
	 *
	 */
	do_action( 'corpo_digital_doctype' );

?>
<head>
<?php
	/**
	 * corpo_digital_before_wp_head hook
	 *
	 * @hooked corpo_digital_head -  10
	 *
	 */
	do_action( 'corpo_digital_before_wp_head' );

	wp_head(); 
?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'wp_body_open' ); ?>
<?php
	/**
	 * corpo_digital_page_start_action hook
	 *
	 * @hooked corpo_digital_page_start -  10
	 *
	 */
	do_action( 'corpo_digital_page_start_action' ); 

	/**
	 * corpo_digital_loader_action hook
	 *
	 * @hooked corpo_digital_loader -  10
	 *
	 */
	do_action( 'corpo_digital_before_header' );

	/**
	 * corpo_digital_header_action hook
	 *
	 * @hooked corpo_digital_site_branding -  10
	 * @hooked corpo_digital_header_start -  20
	 * @hooked corpo_digital_site_navigation -  30
	 * @hooked corpo_digital_header_end -  50
	 *
	 */
	do_action( 'corpo_digital_header_action' );

	/**
	 * corpo_digital_content_start_action hook
	 *
	 * @hooked corpo_digital_content_start -  10
	 *
	 */
	do_action( 'corpo_digital_content_start_action' );

    /**
     * corpo_digital_header_image_action hook
     *
     * @hooked corpo_digital_header_image -  10
     *
     */
    do_action( 'corpo_digital_header_image_action' );
	

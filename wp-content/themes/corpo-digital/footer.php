<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

/**
 * corpo_digital_footer_primary_content hook
 *
 * @hooked corpo_digital_add_subscribe_section -  10
 *
 */
do_action( 'corpo_digital_footer_primary_content' );

/**
 * corpo_digital_content_end_action hook
 *
 * @hooked corpo_digital_content_end -  10
 *
 */
do_action( 'corpo_digital_content_end_action' );

/**
 * corpo_digital_content_end_action hook
 *
 * @hooked corpo_digital_footer_start -  10
 * @hooked  Corpo_Digital_Footer_Widgets->add_footer_widgets -  20
 * @hooked corpo_digital_footer_site_info -  40
 * @hooked corpo_digital_footer_end -  100
 *
 */
do_action( 'corpo_digital_footer' );

/**
 * corpo_digital_page_end_action hook
 *
 * @hooked corpo_digital_page_end -  10
 *
 */
do_action( 'corpo_digital_page_end_action' ); 

?>

<?php wp_footer(); ?>

</body>
</html>
